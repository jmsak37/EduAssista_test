<?php
session_start();

// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// Prepare and execute SQL statement to retrieve user info
$sql = "SELECT UserID, RoleID, PasswordHash FROM Users WHERE Email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($userID, $roleID, $passwordHash);

$response = [
    "status" => "",
    "role"   => "",
    "userID" => ""
];

if ($stmt->num_rows > 0) {
    $stmt->fetch();

    // Verify password
    if (password_verify($password, $passwordHash)) {
        // Set session variables
        $_SESSION['userID'] = $userID;
        $_SESSION['roleID'] = $roleID;

        // -------------------------------
        // Update auditlogs table for successful login
        $auditSql = "
            INSERT INTO auditlogs (UserID, Action, ActionDetails, Timestamp) 
            VALUES (?, 'Login', 'Successful Login', NOW())
            ON DUPLICATE KEY UPDATE 
                Action = 'Login', 
                ActionDetails = 'Successful Login', 
                Timestamp = NOW()
        ";
        $auditStmt = $conn->prepare($auditSql);
        $auditStmt->bind_param("i", $userID);
        $auditStmt->execute();
        $auditStmt->close();
        // -------------------------------

        // Update Users table to set status = 'insession'
        $updateStatusSql = "UPDATE Users SET status = 'insession' WHERE UserID = ?";
        $updateStmt = $conn->prepare($updateStatusSql);
        $updateStmt->bind_param("i", $userID);
        if (!$updateStmt->execute()) {
            $response["status"]  = "error";
            $response["message"] = "Failed to update user status.";
            echo json_encode($response);
            exit();
        }
        $updateStmt->close();

        // Check if user is restricted
        $restrictSql  = "SELECT RestrictID FROM `restrict` WHERE UserID = ?";
        $restrictStmt = $conn->prepare($restrictSql);
        $restrictStmt->bind_param("i", $userID);
        $restrictStmt->execute();
        $restrictStmt->store_result();
        if ($restrictStmt->num_rows > 0) {
            $response["status"] = "redirect_restricted";
            echo json_encode($response);
            $restrictStmt->close();
            exit();
        }
        $restrictStmt->close();

        // Determine role for redirection
        switch ($roleID) {
            case 1:
                $response["role"] = "client";
                break;
            case 2:
                $response["role"] = "tutor";
                break;
            case 3:
                $response["role"] = "admin";
                break;
            default:
                $response["status"]  = "error";
                $response["message"] = "Invalid role.";
                echo json_encode($response);
                exit();
        }

        // --- Begin usersession logic ---
        // Generate a secure session token
        $sessionToken = bin2hex(random_bytes(32));
        $ipAddress    = $_SERVER['REMOTE_ADDR'] ?? '';
        $userAgent    = $_SERVER['HTTP_USER_AGENT'] ?? '';

        // Check for existing session row
        $checkSQL = "SELECT SessionID FROM usersession WHERE UserID = ?";
        $checkStmt = $conn->prepare($checkSQL);
        $checkStmt->bind_param("i", $userID);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Update existing session
            $updateSQL = "
                UPDATE usersession
                   SET SessionToken   = ?,
                       IPAddress      = ?,
                       UserAgent      = ?,
                       LastActiveTime = NOW(),
                       IsActive       = TRUE
                 WHERE UserID = ?
            ";
            $updStmt = $conn->prepare($updateSQL);
            $updStmt->bind_param("sssi",
                $sessionToken,
                $ipAddress,
                $userAgent,
                $userID
            );
            $updStmt->execute();
            $updStmt->close();
        } else {
            // Insert new session row
            $insertSQL = "
                INSERT INTO usersession
                    (UserID, SessionToken, IPAddress, UserAgent)
                VALUES (?, ?, ?, ?)
            ";
            $insStmt = $conn->prepare($insertSQL);
            $insStmt->bind_param("isss",
                $userID,
                $sessionToken,
                $ipAddress,
                $userAgent
            );
            $insStmt->execute();
            $insStmt->close();
        }
        $checkStmt->close();

        // Store the session token in PHP session
        $_SESSION['sessionToken'] = $sessionToken;
        // --- End usersession logic ---

        // Finally, indicate successful login + redirect
        $response["status"] = "redirect";
        $response["userID"] = $userID;

    } else {
        $response["status"]  = "error";
        $response["message"] = "Invalid email or password.";
    }
} else {
    $response["status"] = "not_found";
}

// Close connections
$stmt->close();
$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
