<?php
session_start();
header('Content-Type: application/json');

// Ensure the user is logged in.
if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userID = $_SESSION['userID'];

// Database connection settings.
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Query the user's RoleID.
$sql = "SELECT RoleID FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($roleID);
$stmt->fetch();
$stmt->close();
$conn->close();

// Check if the RoleID equals 1.
if ($roleID != 3) {
    echo json_encode(["error" => "Access denied: insufficient privileges"]);
    exit();
}

echo json_encode(["status" => "ok"]);
?>
