<?php
// Start output buffering to capture any accidental output.
ob_start();

// Report all errors but disable direct output.
error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// Assume tutor is logged in (session)
session_start();
if (!isset($_SESSION['userID'])) {
    ob_clean();
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

// Get order_id from POST field
if (!isset($_POST['order_id'])) {
    ob_clean();
    echo json_encode(["error" => "Order ID not provided"]);
    exit();
}
$order_id = intval($_POST['order_id']);

// Check if this order has already been submitted by querying the progress table.
$queryCheck = "SELECT order_id FROM progress WHERE order_id = ?";
$stmtCheck = $conn->prepare($queryCheck);
if ($stmtCheck) {
    $stmtCheck->bind_param("i", $order_id);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    if ($resultCheck->num_rows > 0) {
        $stmtCheck->close();
        $conn->rollback();
        ob_clean();
        echo json_encode(["error" => "This order has already been submitted."]);
        exit();
    }
    $stmtCheck->close();
} else {
    ob_clean();
    echo json_encode(["error" => "Failed to prepare duplicate check statement: " . $conn->error]);
    exit();
}

// Get orderData JSON (contains order details from orders table)
$orderData = [];
if (isset($_POST['orderData'])) {
    $orderData = json_decode($_POST['orderData'], true);
}

// Determine client id either from orderData or by querying the orders table.
$client_id = isset($orderData['client_id']) ? intval($orderData['client_id']) : 0;
if ($client_id == 0) {
    // If the client_id is missing or zero, query the orders table.
    $queryClient = "SELECT client_id FROM orders WHERE order_id = ?";
    $stmtClient = $conn->prepare($queryClient);
    if ($stmtClient) {
        $stmtClient->bind_param("i", $order_id);
        $stmtClient->execute();
        $resultClient = $stmtClient->get_result();
        if ($resultClient->num_rows > 0) {
            $row = $resultClient->fetch_assoc();
            $client_id = intval($row['client_id']);
        }
        $stmtClient->close();
    }
}

// Other order details.
$subject = isset($orderData['subject']) ? $conn->real_escape_string($orderData['subject']) : "";
$name = isset($orderData['name']) ? $conn->real_escape_string($orderData['name']) : "";
$description = isset($orderData['description']) ? $conn->real_escape_string($orderData['description']) : "";
$instructions = isset($orderData['instructions']) ? $conn->real_escape_string($orderData['instructions']) : "";
$deadline = isset($orderData['deadline']) ? $conn->real_escape_string($orderData['deadline']) : "";
$document_upload_link = isset($orderData['document_upload_link']) ? $conn->real_escape_string($orderData['document_upload_link']) : "";
$price = isset($orderData['price']) ? floatval($orderData['price']) : 0.0;
$number_of_pages = isset($orderData['number_of_pages']) ? intval($orderData['number_of_pages']) : 0;

// For document_name, extract basename if document_upload_link exists.
$document_name = "";
if (!empty($document_upload_link)) {
    $document_name = basename($document_upload_link);
}

// Completed work fields (initially empty).
$completed_work_name = "";
$completed_work_link = "";

/**
 * Process file uploads.
 * For each file, check if a file with the same name already exists in the destination folder.
 * If so, append a numeric suffix to the filename (e.g., julius1.pdf, julius2.pdf, etc.)
 * before moving the uploaded file.
 */
function uploadFiles($filesArray, $destinationFolder) {
    $uploadedFiles = [];
    if (!is_dir($destinationFolder)) {
        mkdir($destinationFolder, 0777, true);
    }
    foreach ($filesArray['name'] as $key => $name) {
        if ($filesArray['error'][$key] === UPLOAD_ERR_OK) {
            $tmpName = $filesArray['tmp_name'][$key];
            $safeName = basename($name);
            $destination = rtrim($destinationFolder, '/') . '/' . $safeName;
            $i = 1;
            // Check if file with the same name exists, and if so, append a number.
            while (file_exists($destination)) {
                $info = pathinfo($safeName);
                $base = $info['filename'];
                $extension = isset($info['extension']) ? $info['extension'] : '';
                $safeName = $base . $i . ($extension ? '.' . $extension : '');
                $destination = rtrim($destinationFolder, '/') . '/' . $safeName;
                $i++;
            }
            if (move_uploaded_file($tmpName, $destination)) {
                $uploadedFiles[] = $destination;
            }
        }
    }
    return $uploadedFiles;
}

$answerFilesUploaded = [];
if (isset($_FILES['answerFiles'])) {
    $answerFilesUploaded = uploadFiles($_FILES['answerFiles'], "doneorders");
}
$explanationFilesUploaded = [];
if (isset($_FILES['explanationFiles'])) {
    $explanationFilesUploaded = uploadFiles($_FILES['explanationFiles'], "doneorders");
}

$answerFilesJson = json_encode($answerFilesUploaded);
$explanationFilesJson = json_encode($explanationFilesUploaded);

$answerComments = isset($_POST['answerComments']) ? $conn->real_escape_string($_POST['answerComments']) : "";
$explanationComments = isset($_POST['explanationComments']) ? $conn->real_escape_string($_POST['explanationComments']) : "";

// Begin transaction.
$conn->begin_transaction();

// Insert into progress table.
$query = "INSERT INTO progress 
    (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'donework', NOW(), NOW(), ?, ?, ?, ?)";
$stmt = $conn->prepare($query);
if (!$stmt) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Failed to prepare insert statement: " . $conn->error]);
    exit();
}

// Bind parameters. The bindTypes string "iiisssssssssdissss" corresponds to 18 parameters.
$bindTypes = "iiisssssssssdissss";
$stmt->bind_param(
    $bindTypes,
    $order_id,                // i
    $client_id,               // i
    $tutor_id,                // i
    $subject,                 // s
    $name,                    // s
    $description,             // s
    $instructions,            // s
    $deadline,                // s
    $document_name,           // s
    $document_upload_link,    // s
    $completed_work_name,     // s
    $completed_work_link,     // s
    $price,                   // d
    $number_of_pages,         // i
    $answerFilesJson,         // s
    $answerComments,          // s
    $explanationFilesJson,    // s
    $explanationComments      // s
);

if (!$stmt->execute()) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Error inserting into progress record: " . $stmt->error]);
    exit();
}

// Delete the order from the orders table.
$deleteQuery = "DELETE FROM orders WHERE order_id = ? AND tutor_id = ?";
$deleteStmt = $conn->prepare($deleteQuery);
if (!$deleteStmt) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Failed to prepare delete statement: " . $conn->error]);
    exit();
}
$deleteStmt->bind_param("ii", $order_id, $tutor_id);
if (!$deleteStmt->execute()) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Error deleting order record: " . $deleteStmt->error]);
    exit();
}
$deleteStmt->close();

// *** New Code: Also delete the order from the request table if it exists.
$deleteQueryRequest = "DELETE FROM request WHERE order_id = ? AND tutor_id = ?";
$deleteStmtRequest = $conn->prepare($deleteQueryRequest);
if (!$deleteStmtRequest) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Failed to prepare delete request statement: " . $conn->error]);
    exit();
}
$deleteStmtRequest->bind_param("ii", $order_id, $tutor_id);
if (!$deleteStmtRequest->execute()) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Error deleting order record from request table: " . $deleteStmtRequest->error]);
    exit();
}
$deleteStmtRequest->close();

// *** Additional Code: Check if a similar notification already exists.
// If it exists, update its status from 'read' to 'unread' and commit the transaction.
$queryCheckNotification = "SELECT order_id FROM notifications WHERE order_id = ? AND tutor_id = ?";
$stmtCheckNotification = $conn->prepare($queryCheckNotification);
if ($stmtCheckNotification) {
    $stmtCheckNotification->bind_param("ii", $order_id, $tutor_id);
    $stmtCheckNotification->execute();
    $resultCheckNotification = $stmtCheckNotification->get_result();
    if ($resultCheckNotification->num_rows > 0) {
        // Notification exists; update its status to unread.
        $updateNotification = "UPDATE notifications SET status = ?, updated_at = NOW() WHERE order_id = ? AND tutor_id = ?";
        $stmtUpdateNotification = $conn->prepare($updateNotification);
        if (!$stmtUpdateNotification) {
            $conn->rollback();
            ob_clean();
            echo json_encode(["error" => "Failed to prepare notification update statement: " . $conn->error]);
            exit();
        }
        $newStatus = "unread";
        $stmtUpdateNotification->bind_param("sii", $newStatus, $order_id, $tutor_id);
        if (!$stmtUpdateNotification->execute()) {
            $conn->rollback();
            ob_clean();
            echo json_encode(["error" => "Error updating notification record: " . $stmtUpdateNotification->error]);
            exit();
        }
        $stmtUpdateNotification->close();
        $stmtCheckNotification->close();
        $conn->commit();
        ob_clean();
        echo json_encode(["success" => true, "message" => "Notification status updated to unread"]);
        exit();
    }
    $stmtCheckNotification->close();
} else {
    // If the check fails, proceed with notification insertion.
}

// *** New Code: Insert into notifications table.
$queryNotification = "INSERT INTO notifications 
    (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, created_at, updated_at, document_name, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?)";
$stmtNotification = $conn->prepare($queryNotification);
if (!$stmtNotification) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Failed to prepare notification insert statement: " . $conn->error]);
    exit();
}
$status = "unread"; // default status for a new notification.
$stmtNotification->bind_param(
    "iiissssssssdiss", // Corrected binding string for 15 parameters
    $order_id,                // i
    $client_id,               // i
    $tutor_id,                // i
    $subject,                 // s
    $name,                    // s
    $description,             // s
    $instructions,            // s
    $deadline,                // s
    $document_upload_link,    // s
    $completed_work_name,     // s
    $completed_work_link,     // s
    $price,                   // d
    $number_of_pages,         // i
    $document_name,           // s
    $status                   // s
);
if (!$stmtNotification->execute()) {
    $conn->rollback();
    ob_clean();
    echo json_encode(["error" => "Error inserting notification record: " . $stmtNotification->error]);
    exit();
}
$stmtNotification->close();

$conn->commit();
ob_clean();
echo json_encode(["success" => true]);

$stmt->close();
$conn->close();
ob_end_flush();
?>
