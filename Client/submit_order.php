<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    // Collect data from the form
    $subject = isset($_POST['subject']) ? $conn->real_escape_string($_POST['subject']) : null;
    $orderName = isset($_POST['order_name']) ? $conn->real_escape_string($_POST['order_name']) : null;
    $orderDescription = isset($_POST['order_description']) ? $conn->real_escape_string($_POST['order_description']) : null;
    $orderInstructions = isset($_POST['upload_instructions']) ? $conn->real_escape_string($_POST['upload_instructions']) : null;
    $orderDeadline = isset($_POST['order_deadline']) ? $conn->real_escape_string($_POST['order_deadline']) : null;
    $clientID = isset($_POST['client_id']) ? (int)$_POST['client_id'] : null;
    $numberOfPages = isset($_POST['number_of_pages']) ? (int)$_POST['number_of_pages'] : null;
    $totalPrice = isset($_POST['total_price']) ? (float)$_POST['total_price'] : 0.0;

    if (empty($subject) || empty($orderName) || empty($orderDescription) || empty($orderDeadline) || empty($clientID)) {
        throw new Exception("Some required fields are missing.");
    }

    // Check if the order deadline is at least 1 hour from now.
    $currentDateTime = new DateTime();
    $deadlineDateTime = new DateTime($orderDeadline);
    $interval = $currentDateTime->diff($deadlineDateTime);
    if ($interval->days == 0 && $interval->h < 1) {
        throw new Exception("Order deadline must be at least 1 hour from the current time.");
    }

    // Check user's current balance.
    $stmtBalance = $conn->prepare("SELECT balance FROM balance WHERE user_id = ?");
    if (!$stmtBalance) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    $stmtBalance->bind_param("i", $clientID);
    $stmtBalance->execute();
    $stmtBalance->bind_result($balance);
    $stmtBalance->fetch();
    $stmtBalance->close();
    $balance = is_null($balance) ? 0 : (float)$balance;
    if ($balance < $totalPrice) {
        $conn->rollback();
        echo json_encode([
            'success' => false,
            'message' => "Insufficient balance. You need $" . number_format($totalPrice - $balance, 2) . " more.",
            'required' => $totalPrice - $balance
        ]);
        exit;
    }

    // Deduct the order amount from the user's balance.
    $stmtUpdate = $conn->prepare("UPDATE balance SET balance = balance - ? WHERE user_id = ?");
    if (!$stmtUpdate) {
        throw new Exception("Prepare update failed: " . $conn->error);
    }
    $stmtUpdate->bind_param("di", $totalPrice, $clientID);
    if (!$stmtUpdate->execute()) {
        $conn->rollback();
        throw new Exception("Failed to update balance: " . $stmtUpdate->error);
    }
    $stmtUpdate->close();

    // File upload handling: allow multiple files.
    $uploadDir = 'uploads/';  // Ensure this folder is writable and accessible via URL
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $documentNames = [];
    $documentUploadLinks = [];

    if (isset($_FILES['order_document'])) {
        $files = $_FILES['order_document'];
        $fileCount = count($files['name']);

        for ($i = 0; $i < $fileCount; $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $tmp_name = $files['tmp_name'][$i];
                $orig_name = basename($files['name'][$i]);
                
                // Extract file extension
                $pathInfo = pathinfo($orig_name);
                $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
                
                // Generate a unique file name
                $newName = uniqid('doc_', true) . $extension;
                while (file_exists($uploadDir . $newName)) {
                    $newName = uniqid('doc_', true) . $extension;
                }
                
                $targetFile = $uploadDir . $newName;
                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $documentNames[] = $newName;
                    $documentUploadLinks[] = $uploadDir . $newName;
                } else {
                    throw new Exception("Error uploading file: " . $orig_name);
                }
            }
        }
    }
    // If no file is uploaded, use empty strings
    $documentName = empty($documentNames) ? "" : implode(",", $documentNames);
    $documentUploadLink = empty($documentUploadLinks) ? "" : implode(",", $documentUploadLinks);

    // Set order status to "undone"
    $status = "undone";

    // Prepare and execute insert query
    $stmt = $conn->prepare("INSERT INTO orders (client_id, subject, name, description, instructions, deadline, number_of_pages, price, document_name, document_upload_link, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        throw new Exception("Prepare statement failed: " . $conn->error);
    }
    $stmt->bind_param("isssssidsss", $clientID, $subject, $orderName, $orderDescription, $orderInstructions, $orderDeadline, $numberOfPages, $totalPrice, $documentName, $documentUploadLink, $status);

    if ($stmt->execute()) {
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
    } else {
        $conn->rollback();
        throw new Exception("Error placing the order.");
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
