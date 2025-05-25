<?php
// admin_edit_client.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$clientID = $_POST['clientID'];
$educationalLevel = $_POST['educationalLevel'];
$preferredSubject = $_POST['preferredSubject'];

// Update client information
$sql = "UPDATE Clients SET EducationalLevel = ?, PreferredSubject = ? WHERE ClientID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $educationalLevel, $preferredSubject, $clientID);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Client updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating client: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
