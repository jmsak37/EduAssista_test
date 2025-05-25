<?php
session_start();
header('Content-Type: application/json');

// Ensure the user is logged in.
$client_id = $_SESSION['userID'] ?? null;
if (!$client_id) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

// Get action parameter.
$action = "";
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
} else {
    echo json_encode(['error' => 'Action parameter not provided.']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduassistadb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

if ($action === "getNotifications") {
    // Query the notifications table for unread notifications for this client.
    $stmt = $conn->prepare("SELECT order_id, name FROM notifications WHERE client_id = ? AND status = 'unread' ORDER BY created_at ASC");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = [];
    while ($row = $result->fetch_assoc()){
        $notifications[] = $row;
    }
    $stmt->close();
    echo json_encode(['notifications' => $notifications, 'new_count' => count($notifications)]);
    exit;
} elseif ($action === "markAsRead") {
    // Mark a notification as read in the notifications table.
    if (!isset($_GET['order_id'])) {
        echo json_encode(['error' => 'Order ID not provided for marking as read.']);
        exit;
    }
    $order_id = intval($_GET['order_id']);
    $stmt = $conn->prepare("UPDATE notifications SET status = 'read' WHERE order_id = ? AND client_id = ?");
    $stmt->bind_param("ii", $order_id, $client_id);
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => 'Error marking notification as read: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
} else {
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

$conn->close();
?>
