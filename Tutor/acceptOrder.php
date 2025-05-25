<?php
session_start();
header('Content-Type: application/json');
ob_start();

ini_set('display_errors', 0);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create database connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Ensure order_id is provided via GET.
if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID not provided"]);
    exit();
}
$order_id = $_GET['order_id'];

// Ensure tutor is logged in.
if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

// Update orders table: set tutor_id and status to "beingdone"
$query = "UPDATE orders SET tutor_id = ?, status = 'beingdone' WHERE order_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare update statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("ii", $tutor_id, $order_id);
if (!$stmt->execute()) {
    echo json_encode(["error" => "Failed to update order status to beingdone: " . $stmt->error]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();
$conn->close();

ob_end_clean();
echo json_encode(["success" => true, "redirect" => "beingdone.html?order_id=" . $order_id]);
?>
