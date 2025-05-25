<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error));
    exit();
}

if (!isset($_SESSION['userID'])) {
    echo json_encode(array("status" => "error", "message" => "User not logged in"));
    exit();
}

$userID = $_SESSION['userID'];

// Enclose the table name in backticks because "restrict" is reserved.
$sql = "SELECT RestrictID FROM `restrict` WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $response = array("status" => "restricted");
} else {
    $response = array("status" => "not_restricted");
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
