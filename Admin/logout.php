<?php
session_start();

// If no user is logged in, redirect to login.
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$userID = $_SESSION['user_id'];
$roleID = $_SESSION['role_id']; // 1=client, 2=tutor, 3=admin

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

// Remove user from usersession table based on role
if ($roleID == 1) {
    $sql = "DELETE FROM usersession WHERE client_id = ?";
} elseif ($roleID == 2) {
    $sql = "DELETE FROM usersession WHERE tutor_id = ?";
} else {
    $sql = "DELETE FROM usersession WHERE admin_id = ?";
}
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();

// Insert audit log record
$sqlAudit = "INSERT INTO auditlogs (UserID, Action, ActionDetails, Timestamp) VALUES (?, 'Logout', 'Successful Logout', NOW())";
$stmtAudit = $conn->prepare($sqlAudit);
$stmtAudit->bind_param("i", $userID);
$stmtAudit->execute();
$stmtAudit->close();

// Update user's status in users table to "out of session"
$sqlUpdate = "UPDATE users SET status = 'out of session' WHERE UserID = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("i", $userID);
$stmtUpdate->execute();
$stmtUpdate->close();

$conn->close();

// Destroy session and redirect to login.
session_unset();
session_destroy();
header("Location: login.html");
exit();
?>
