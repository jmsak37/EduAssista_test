<?php
session_start();
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

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

if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID is missing"]);
    exit();
}
$order_id = intval($_GET['order_id']);

/**
 * Helper function to fetch an order from a given table.
 * It ensures that key fields for documents are defined (defaulting to empty string if missing).
 */
function fetchOrder($conn, $order_id, $table) {
    $query = "SELECT * FROM $table WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            $order = $result->fetch_assoc();
            // Ensure the following fields exist for consistency:
            if (!isset($order['answer_files'])) { 
                $order['answer_files'] = ""; 
            }
            if (!isset($order['answer_comments'])) { 
                $order['answer_comments'] = ""; 
            }
            if (!isset($order['explanation_files'])) { 
                $order['explanation_files'] = ""; 
            }
            if (!isset($order['explanation_comments'])) { 
                $order['explanation_comments'] = ""; 
            }
            // Optional: Also define main document fields if needed.
            if (!isset($order['document_upload_link'])) { 
                $order['document_upload_link'] = ""; 
            }
            if (!isset($order['document_name'])) { 
                $order['document_name'] = ""; 
            }
            $stmt->close();
            return $order;
        }
        $stmt->close();
    }
    return null;
}

// Try to fetch the order from the orders table.
$order = fetchOrder($conn, $order_id, "orders");
if ($order) {
    echo json_encode($order);
    $conn->close();
    exit();
}

// If not found, try the progress table.
$order = fetchOrder($conn, $order_id, "progress");
if ($order) {
    echo json_encode($order);
    $conn->close();
    exit();
}

// If still not found, try the completed table.
$order = fetchOrder($conn, $order_id, "completed");
if ($order) {
    echo json_encode($order);
    $conn->close();
    exit();
}

echo json_encode(["error" => "Order not found"]);
$conn->close();
?>
