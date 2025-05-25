<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if(!isset($_SESSION['userID'])){
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

// Query the completed table for orders belonging to the current tutor.
$completed = [];
$query = "SELECT order_id, client_id, subject, name, deadline, number_of_pages 
          FROM completed WHERE tutor_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()){
    $completed[] = $row;
}
$stmt->close();
$conn->close();

echo json_encode($completed);
?>
