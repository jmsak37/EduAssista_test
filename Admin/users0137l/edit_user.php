<?php
session_start();

// Database connection settings
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "eduassistadb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    http_response_code(403);
    echo json_encode(["error" => "Access denied"]);
    exit();
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Handle GET request: return user data as JSON
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['userID']) && intval($_GET['userID']) > 0) {
        $userID = intval($_GET['userID']);
        $stmt = $conn->prepare("SELECT UserID, UserName, Email, RoleID FROM Users WHERE UserID = ?");
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows === 1) {
            $userData = $result->fetch_assoc();
            echo json_encode(["success" => true, "data" => $userData]);
        } else {
            echo json_encode(["error" => "User not found"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["error" => "Invalid user ID"]);
    }
    $conn->close();
    exit();
}

// Handle POST request: update user details
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userID = intval($_POST['userID']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $roleID = intval($_POST['role']);

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($roleID)) {
        echo json_encode(["error" => "All fields are required."]);
        exit();
    }

    // Check if email is already taken by another user
    $stmtCheckEmail = $conn->prepare("SELECT UserID FROM Users WHERE Email = ? AND UserID != ?");
    $stmtCheckEmail->bind_param("si", $email, $userID);
    $stmtCheckEmail->execute();
    $emailResult = $stmtCheckEmail->get_result();
    if ($emailResult->num_rows > 0) {
        echo json_encode(["error" => "Email is already associated with another user."]);
        $stmtCheckEmail->close();
        $conn->close();
        exit();
    }
    $stmtCheckEmail->close();

    // Update user details
    $stmt = $conn->prepare("UPDATE Users SET UserName = ?, Email = ?, RoleID = ? WHERE UserID = ?");
    $stmt->bind_param("ssii", $username, $email, $roleID, $userID);
    if ($stmt->execute()) {
        echo json_encode(["success" => "User updated successfully."]);
    } else {
        echo json_encode(["error" => "Error updating user: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
}
?>
