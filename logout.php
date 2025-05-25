<?php 
session_start();

// Check if user is logged in
if (!isset($_SESSION['userID'])) {
    header("Location: login.html");
    exit();
}

$userID = $_SESSION['userID'];
$roleID = $_SESSION['roleID'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection error: " . $conn->connect_error);
}

// Remove the user from the usersession table using UserID only.
$sql = "DELETE FROM usersession WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->close();

// Insert audit log entry for logout.
$sqlAudit = "INSERT INTO auditlogs (UserID, Action, ActionDetails, Timestamp) VALUES (?, 'Logout', 'Successful Logout', NOW())";
$stmtAudit = $conn->prepare($sqlAudit);
$stmtAudit->bind_param("i", $userID);
$stmtAudit->execute();
$stmtAudit->close();

// Update the user's status in the users table to "out of session".
$sqlUpdate = "UPDATE users SET status = 'out of session' WHERE UserID = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("i", $userID);
$stmtUpdate->execute();
$stmtUpdate->close();

$conn->close();

// Destroy session
session_unset();
session_destroy();

// Redirect to login page
header("Location: index.html");
exit();
?>
