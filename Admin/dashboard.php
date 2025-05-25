<?php
session_start();

// This block handles the AJAX request for dynamic data.
if (isset($_GET['action']) && $_GET['action'] === 'data') {
    // Ensure the user is logged in and has RoleID 3 (admin).
    if (!isset($_SESSION['userID'])) {
        echo json_encode(['error' => 'Not authorized: userID not set in session.']);
        exit();
    }
    if (!isset($_SESSION['roleID'])) {
        echo json_encode(['error' => 'Not authorized: roleID not set in session.']);
        exit();
    }
    // Cast roleID to integer for strict comparison.
    if ((int)$_SESSION['roleID'] !== 3) {
        echo json_encode(['error' => 'Not authorized: your role is not admin.']);
        exit();
    }
    
    $sessionUserID = $_SESSION['userID'];
    $error = ""; // For collecting error messages

    // Database connection details
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "EduAssistaDB";

    // Create connection
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
    if ($conn->connect_error) {
        $error = "Database connection failed: " . $conn->connect_error;
    } else {
        // 1. Get the username from the "users" table
        $sqlUser = "SELECT UserName FROM users WHERE UserID = ?";
        if ($stmtUser = $conn->prepare($sqlUser)) {
            $stmtUser->bind_param("i", $sessionUserID);
            if (!$stmtUser->execute()) {
                $error .= " Error executing user query: " . $stmtUser->error;
            } else {
                $stmtUser->bind_result($userName);
                if (!$stmtUser->fetch()) {
                    $error .= " User not found.";
                    $userName = "Admin";
                }
            }
            $stmtUser->close();
        } else {
            $error .= " Error preparing user query: " . $conn->error;
        }

        // 2. Check if an AdminRuleID is assigned to this user
        $adminRule = "";
        $sqlRule = "SELECT AdminRuleID FROM adminrule WHERE UserID = ?";
        if ($stmtRule = $conn->prepare($sqlRule)) {
            $stmtRule->bind_param("i", $sessionUserID);
            if (!$stmtRule->execute()) {
                $error .= " Error executing rule query: " . $stmtRule->error;
            } else {
                $stmtRule->bind_result($fetchedRule);
                if ($stmtRule->fetch()) {
                    $adminRule = $fetchedRule;
                }
            }
            $stmtRule->close();
        } else {
            $error .= " Error preparing rule query: " . $conn->error;
        }
        $conn->close();
    }

    // 3. Build the admin notification message based on the AdminRuleID.
    $adminNotification = "";
    if (empty($error)) {
        if (!empty($adminRule)) {
            switch ($adminRule) {
                case '37a':
                    $dashboardLink = "admin001a/index.html?userID=" . $sessionUserID;
                    $adminNotification = "Welcome, you have been assigned as Manager 1. Click the button below to start administering: <a href='" . $dashboardLink . "' class='button'>Start Administering</a>";
                    break;
                case '48b':
                    $dashboardLink = "admin002b/index.html?userID=" . $sessionUserID;
                    $adminNotification = "Welcome, you have been assigned as Manager 2. Click the button below to start administering: <a href='" . $dashboardLink . "' class='button'>Start Administering</a>";
                    break;
                case '51c':
                    $dashboardLink = "admin003c/index.html?userID=" . $sessionUserID;
                    $adminNotification = "Welcome, you have been assigned as Manager 3. Click the button below to start administering: <a href='" . $dashboardLink . "' class='button'>Start Administering</a>";
                    break;
                default:
                    $adminNotification = "Unknown admin rule.";
            }
        } else {
            $adminNotification = "You are not assigned a rule; please wait while support assigns you one.";
        }
    }

    $data = array(
        "userName"          => $userName,
        "adminNotification" => $adminNotification,
        "error"             => $error
    );
    header('Content-Type: application/json');
    echo json_encode($data);
    exit();
} else {
    header("Location: dashboard.html");
    exit();
}
?>
