<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');

session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Connect to the database.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Retrieve order_id and clarification message from POST.
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$clarification = isset($_POST['clarification']) ? trim($_POST['clarification']) : '';
$client_id = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;

if (!$order_id || empty($clarification)) {
    ob_clean();
    echo json_encode(['error' => 'Order ID or clarification message missing.']);
    exit;
}

// Fetch order details from the progress table.
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
if ($result->num_rows == 0) {
    ob_clean();
    echo json_encode(['error' => 'Order not found.']);
    exit;
}
$order = $result->fetch_assoc();
$stmt->close();

// Begin transaction: Insert into clarification table and then delete from progress table.
$conn->begin_transaction();
try {
    // Insert into clarification table.
    $sqlInsert = "INSERT INTO clarification 
        (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, 
         document_name, document_upload_link, completed_work_name, completed_work_link, price, 
         number_of_pages, status, created_at, updated_at, answer_files, answer_comments, 
         explanation_files, explanation_comments, clarification)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        throw new Exception("Prepare insert failed: " . $conn->error);
    }
    // Bind parameters: 
    // "iiissssssssdisssssssss"
    $stmtInsert->bind_param("iiissssssssdisssssssss",
        $order['order_id'],
        $order['client_id'],
        $order['tutor_id'],
        $order['subject'],
        $order['name'],
        $order['description'],
        $order['instructions'],
        $order['deadline'],
        $order['document_name'],
        $order['document_upload_link'],
        $order['completed_work_name'],
        $order['completed_work_link'],
        $order['price'],
        $order['number_of_pages'],
        $order['status'],
        $order['created_at'],
        $order['updated_at'],
        $order['answer_files'],
        $order['answer_comments'],
        $order['explanation_files'],
        $order['explanation_comments'],
        $clarification
    );
    if (!$stmtInsert->execute()) {
        throw new Exception("Insert into clarification failed: " . $stmtInsert->error);
    }
    $stmtInsert->close();

    // Delete the order from the progress table.
    $sqlDelete = "DELETE FROM progress WHERE order_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if (!$stmtDelete) {
        throw new Exception("Prepare delete failed: " . $conn->error);
    }
    $stmtDelete->bind_param("i", $order_id);
    if (!$stmtDelete->execute()) {
        throw new Exception("Failed to delete order from progress: " . $stmtDelete->error);
    }
    $stmtDelete->close();

    $conn->commit();
    ob_clean();
    echo json_encode(['success' => true, 'message' => 'Clarification submitted successfully', 'client_id' => $order['client_id']]);
    exit;
} catch (Exception $e) {
    $conn->rollback();
    ob_clean();
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}

$conn->close();
ob_end_flush();
?>
