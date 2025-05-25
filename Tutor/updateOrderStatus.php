<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if (!isset($_POST['order_id']) || !isset($_POST['new_status'])) {
    echo json_encode(["error" => "Invalid parameters"]);
    exit();
}

$order_id = $_POST['order_id'];
$new_status = $_POST['new_status'];

$query = "UPDATE orders SET status = ? WHERE order_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("si", $new_status, $order_id);
if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to update order status: " . $stmt->error]);
}
$stmt->close();
$conn->close();
?>
