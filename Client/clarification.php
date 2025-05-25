<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

session_start();

// Database connection settings
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Determine action (we expect action=getClarifications)
$action = "";
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else {
    ob_clean();
    echo json_encode(['error' => 'No action provided']);
    exit;
}

if ($action === "getClarifications") {
    // Ensure the user is logged in
    if (!isset($_SESSION['userID'])) {
        ob_clean();
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }
    $client_id = intval($_SESSION['userID']);
    // Query the clarification table for records for this client.
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, clarification, created_at 
            FROM clarification 
            WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_clean();
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $clarifications = [];
    while ($row = $result->fetch_assoc()) {
        $clarifications[] = $row;
    }
    $stmt->close();
    ob_clean();
    echo json_encode(['clarifications' => $clarifications]);
    exit;
} else {
    ob_clean();
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

$conn->close();
ob_end_flush();
?>
