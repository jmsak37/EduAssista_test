<?php
// admin_edit_tutor.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$tutorID = $_POST['tutorID'];
$expertiseArea = $_POST['expertiseArea'];
$availability = $_POST['availability'];
$rating = $_POST['rating'];

// Update tutor information
$sql = "UPDATE Tutors SET ExpertiseArea = ?, Availability = ?, Rating = ? WHERE TutorID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdi", $expertiseArea, $availability, $rating, $tutorID);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Tutor updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating tutor: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
