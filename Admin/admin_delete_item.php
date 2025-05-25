<?php
// admin_delete_item.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from request
$table = $_POST['table']; // Table name to delete from (e.g., Users, Clients, Tutors)
$idColumn = $_POST['idColumn']; // ID column name (e.g., UserID, ClientID, TutorID)
$id = $_POST['id']; // Actual ID to delete

// Prepare SQL statement
$sql = "DELETE FROM $table WHERE $idColumn = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Item deleted successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error deleting item: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
