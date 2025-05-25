<?php
ob_start();
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
    exit;
}

// Start session and check tutor login
session_start();
if (!isset($_SESSION['userID'])) {
    ob_clean();
    echo json_encode(["error" => "Tutor not logged in"]);
    exit;
}
$tutor_id = $_SESSION['userID'];

// Handle GET request: fetch order details from progressa table, including document details.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['order_id'])) {
        echo json_encode(["error" => "Order ID not provided"]);
        exit();
    }
    $order_id = intval($_GET['order_id']);
    $query = "SELECT * FROM progressa WHERE order_id = ? AND tutor_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("ii", $order_id, $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo json_encode(["error" => "Order not found in progressa table"]);
        $stmt->close();
        exit();
    }
    $order = $result->fetch_assoc();
    $stmt->close();

    // Decode the JSON fields for answer_files and explanation_files (if present)
    $order['answer_files'] = (isset($order['answer_files']) && !empty($order['answer_files'])) 
        ? json_decode($order['answer_files'], true) : [];
    $order['explanation_files'] = (isset($order['explanation_files']) && !empty($order['explanation_files'])) 
        ? json_decode($order['explanation_files'], true) : [];
    // The answer_comments and explanation_comments are returned as-is.
    echo json_encode($order);
    $conn->close();
    exit();
}
// Handle POST request
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // If this is an "accept" action, update order status to "accepted"
    if (isset($_POST['action']) && $_POST['action'] === 'accept') {
        if (!isset($_POST['order_id'])) {
            ob_clean();
            echo json_encode(["error" => "Order ID not provided"]);
            exit();
        }
        $order_id = intval($_POST['order_id']);
        $queryAccept = "UPDATE progressa SET status = 'accepted', updated_at = NOW() WHERE order_id = ? AND tutor_id = ?";
        $stmtAccept = $conn->prepare($queryAccept);
        if (!$stmtAccept) {
            ob_clean();
            echo json_encode(["error" => "Failed to prepare accept statement: " . $conn->error]);
            exit();
        }
        $stmtAccept->bind_param("ii", $order_id, $tutor_id);
        if(!$stmtAccept->execute()){
            ob_clean();
            echo json_encode(["error" => "Failed to accept order: " . $stmtAccept->error]);
            exit();
        }
        $stmtAccept->close();
        ob_clean();
        echo json_encode(["success" => true, "message" => "Order accepted successfully"]);
        exit();
    }

    // Process work submission
    // Check duplicate submission in progress table.
    if (!isset($_POST['order_id'])) {
        ob_clean();
        echo json_encode(["error" => "Order ID not provided"]);
        exit();
    }
    $order_id = intval($_POST['order_id']);
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
    // Get orderData from POST (JSON string)
    $orderData = [];
    if (isset($_POST['orderData'])) {
        $orderData = json_decode($_POST['orderData'], true);
    }
    // Determine client_id
    $client_id = isset($orderData['client_id']) ? intval($orderData['client_id']) : 0;
    if ($client_id == 0) {
        $queryClient = "SELECT client_id FROM progressa WHERE order_id = ?";
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
    // Get other order details.
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

    // Function to upload files.
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

    // 1. Insert order details into the progress table.
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
    // Binding string for 18 parameters.
    $bindTypes = "iiisssssssssdissss";
    $stmt->bind_param(
      $bindTypes,
      $order_id,
      $client_id,
      $tutor_id,
      $subject,
      $name,
      $description,
      $instructions,
      $deadline,
      $document_name,
      $document_upload_link,
      $completed_work_name,
      $completed_work_link,
      $price,
      $number_of_pages,
      $answerFilesJson,
      $answerComments,
      $explanationFilesJson,
      $explanationComments
    );
    if (!$stmt->execute()) {
        $conn->rollback();
        ob_clean();
        echo json_encode(["error" => "Error inserting into progress record: " . $stmt->error]);
        exit();
    }
    $stmt->close();

    // 2. Delete the order from progressa table.
    $deleteQuery = "DELETE FROM progressa WHERE order_id = ? AND tutor_id = ?";
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

    // 3. Insert/update the order in the notifications table.
    // First check if the order is already present.
    $queryCheckNotif = "SELECT * FROM notifications WHERE order_id = ? AND tutor_id = ?";
    $stmtCheckNotif = $conn->prepare($queryCheckNotif);
    if (!$stmtCheckNotif) {
        $conn->rollback();
        ob_clean();
        echo json_encode(["error" => "Failed to prepare notifications check: " . $conn->error]);
        exit();
    }
    $stmtCheckNotif->bind_param("ii", $order_id, $tutor_id);
    $stmtCheckNotif->execute();
    $resultNotif = $stmtCheckNotif->get_result();
    if ($resultNotif->num_rows > 0) {
        // Order already exists in notifications: update its status to unread and updated_at to NOW()
        $queryUpdateNotif = "UPDATE notifications SET status = ?, updated_at = NOW() WHERE order_id = ? AND tutor_id = ?";
        $stmtUpdateNotif = $conn->prepare($queryUpdateNotif);
        if (!$stmtUpdateNotif) {
            $conn->rollback();
            ob_clean();
            echo json_encode(["error" => "Failed to prepare notifications update: " . $conn->error]);
            exit();
        }
        $status = "unread";
        $stmtUpdateNotif->bind_param("sii", $status, $order_id, $tutor_id);
        if (!$stmtUpdateNotif->execute()) {
            $conn->rollback();
            ob_clean();
            echo json_encode(["error" => "Failed to update notification: " . $stmtUpdateNotif->error]);
            exit();
        }
        $stmtUpdateNotif->close();
    } else {
        // Insert a new notification record.
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
        // Binding string for 15 parameters: i, i, i, s, s, s, s, s, s, s, s, d, i, s, s.
        $stmtNotification->bind_param(
            "iiissssssssdiss",
            $order_id,
            $client_id,
            $tutor_id,
            $subject,
            $name,
            $description,
            $instructions,
            $deadline,
            $document_upload_link,
            $completed_work_name,
            $completed_work_link,
            $price,
            $number_of_pages,
            $document_name,
            $status
        );
        if (!$stmtNotification->execute()) {
            $conn->rollback();
            ob_clean();
            echo json_encode(["error" => "Error inserting notification record: " . $stmtNotification->error]);
            exit();
        }
        $stmtNotification->close();
    }
    $stmtCheckNotif->close();

    // 4. Update tutor's balance (add bonus = number_of_pages * 2).
    $bonus = $number_of_pages * 2;
    $sqlTutor = "UPDATE balance SET balance = balance + ? WHERE user_id = ?";
    $stmtTutor = $conn->prepare($sqlTutor);
    if (!$stmtTutor) {
        throw new Exception("Prepare update tutor balance failed: " . $conn->error);
    }
    $stmtTutor->bind_param("di", $bonus, $tutor_id);
    if (!$stmtTutor->execute()) {
        throw new Exception("Failed to update tutor balance: " . $stmtTutor->error);
    }
    $stmtTutor->close();

    $conn->commit();
    ob_clean();
    echo json_encode(["success" => true, "message" => "Order accepted successfully", "redirect" => "tutor_index.html"]);
    $conn->close();
    exit();
} else {
    echo json_encode(["error" => "Unsupported request method"]);
    $conn->close();
    exit();
}
?>
