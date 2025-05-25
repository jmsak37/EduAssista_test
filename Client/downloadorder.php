<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

// Custom error handler to output JSON errors.
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    ob_clean();
    echo json_encode(['error' => "PHP Error [$errno] in $errfile at line $errline: $errstr"]);
    exit;
});

session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Read raw input and decode JSON (if any)
$rawInput = file_get_contents("php://input");
$inputData = json_decode($rawInput, true);

// Determine the action: check GET first, then POST data.
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} else if ($inputData && isset($inputData['action']) && !empty($inputData['action'])) {
    $action = $inputData['action'];
} else {
    ob_clean();
    echo json_encode(['error' => 'Invalid action: Action parameter not provided.']);
    exit;
}

if ($action === 'getOrder') {
    // Fetch order details from progress table.
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    if (!$order_id) {
        ob_clean();
        echo json_encode(['error' => 'Order ID is missing']);
        exit;
    }
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, 
                    document_name, document_upload_link, completed_work_name, completed_work_link, price, 
                    number_of_pages, status, created_at, updated_at, answer_files, answer_comments, 
                    explanation_files, explanation_comments 
            FROM progress WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_clean();
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        // Verify that session user id matches the order's client_id.
        if (!isset($_SESSION['userID']) || $_SESSION['userID'] != $order['client_id']) {
            ob_clean();
            echo json_encode(['error' => 'Session user id does not match order client id.']);
            exit;
        }
        ob_clean();
        echo json_encode($order);
        exit;
    } else {
        ob_clean();
        echo json_encode(['error' => 'Order not found']);
        exit;
    }
    $stmt->close();
} else {
    ob_clean();
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

$conn->close();
ob_end_flush();
?>
