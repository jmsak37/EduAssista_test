<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Prepare query to fetch orders with status 'beingdone' and tutor_id equal to current tutor.
$query = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, created_at, updated_at, document_name, status 
          FROM request 
          WHERE status = 'beingdone' AND tutor_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("i", $tutor_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);

$stmt->close();
$conn->close();
?>
