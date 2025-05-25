<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in.
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

// If RoleID is not 2, return an error.
if ($roleID != 2) {
    echo json_encode(["error" => "Not a tutor"]);
    exit();
}

echo json_encode(["status" => "ok"]);
?>
