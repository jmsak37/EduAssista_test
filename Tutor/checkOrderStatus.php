<?php
session_start();
header('Content-Type: application/json');

// Ensure the tutor is logged in.
if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}

// Validate order_id parameter.
if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID is missing"]);
    exit();
}

$order_id = (int)$_GET['order_id'];

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create database connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Retrieve tutor_id and status for the order.
$query = "SELECT tutor_id, status FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    echo json_encode($order);
} else {
    echo json_encode(["error" => "Order not found"]);
}

$stmt->close();
$conn->close();
?>
