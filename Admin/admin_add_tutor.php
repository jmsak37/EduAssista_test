<?php
// admin_add_tutor.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$userID = $_POST['userID']; // Assumes user has been added in Users table
$expertiseArea = $_POST['expertiseArea'];
$availability = $_POST['availability'];
$rating = 0.0; // Default rating for new tutor

// Add tutor-specific information to Tutors table
$sql = "INSERT INTO Tutors (UserID, ExpertiseArea, Availability, Rating) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("issd", $userID, $expertiseArea, $availability, $rating);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Tutor added successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error adding tutor: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
