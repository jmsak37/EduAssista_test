<?php
// admin_add_client.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$userID = $_POST['userID']; // Assumes user has been added in Users table
$educationalLevel = $_POST['educationalLevel'];
$preferredSubject = $_POST['preferredSubject'];

// Add client-specific information to Clients table
$sql = "INSERT INTO Clients (UserID, EducationalLevel, PreferredSubject) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $userID, $educationalLevel, $preferredSubject);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Client added successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error adding client: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
