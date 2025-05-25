<?php
require 'db_connect.php'; // Ensure the database connection file is included

if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "No order ID provided"]);
    exit;
}

$orderID = intval($_GET['order_id']);

// First, try to fetch order details from the orders table.
$query = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($query);

$order = null;
if ($stmt) {
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
} else {
    echo json_encode(["error" => "Query preparation failed: " . $conn->error]);
    exit;
}

// If no order was found in the orders table, try the request table.
if (!$order) {
    $query2 = "SELECT * FROM request WHERE order_id = ?";
    $stmt2 = $conn->prepare($query2);
    if ($stmt2) {
        $stmt2->bind_param("i", $orderID);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        $order = $result2->fetch_assoc();
        $stmt2->close();
    } else {
        echo json_encode(["error" => "Query preparation failed: " . $conn->error]);
        exit;
    }
}

echo json_encode($order);
$conn->close();
?>
