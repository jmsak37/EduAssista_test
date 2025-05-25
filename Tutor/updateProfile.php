<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userID = $_SESSION['userID'];

// Get the JSON payload.
$data = json_decode(file_get_contents("php://input"), true);
if (!isset($data['expertise_area'])) {
    echo json_encode(["error" => "Expertise area not provided"]);
    exit();
}
$expertise_area = $data['expertise_area'];

// Database connection parameters.
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Update the tutors table's ExpertiseArea for this user.
$query = "UPDATE tutors SET ExpertiseArea = ? WHERE UserID = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("si", $expertise_area, $userID);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Update failed"]);
}
$stmt->close();
$conn->close();
?>
