<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0);
header('Content-Type: application/json');
session_start();

// Database configuration
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

$action = "";
if (isset($_GET['action']) && !empty($_GET['action'])) {
    $action = $_GET['action'];
} elseif (isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
} else {
    ob_clean();
    echo json_encode(['error' => 'Action parameter not provided.']);
    exit;
}

// Action: Get Pricing for Professional Writer
if ($action === 'getPricing') {
    $sqlPricing = "SELECT price_per_page FROM pricing WHERE writer_type='Professional Writer' LIMIT 1";
    $result = $conn->query($sqlPricing);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $price = $row['price_per_page'];
        ob_clean();
        echo json_encode(['success' => true, 'price_per_page' => $price]);
        exit;
    } else {
        ob_clean();
        echo json_encode(['success' => false, 'error' => 'Pricing information not found.']);
        exit;
    }
}

// Action: Validate tutor ID
if ($action === 'validate') {
    $tutor_id = isset($_POST['tutor_id']) ? trim($_POST['tutor_id']) : "";
    if (empty($tutor_id)) {
        ob_clean();
        echo json_encode(['error' => 'Tutor ID is required.']);
        exit;
    }
    // Check if tutor exists (RoleID = 2)
    $sql = "SELECT UserID FROM users WHERE UserID = ? AND RoleID = 2";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_clean();
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        ob_clean();
        echo json_encode(['success' => true, 'message' => 'Tutor validated.']);
        exit;
    } else {
        ob_clean();
        echo json_encode(['error' => 'Tutor does not exist. Please enter a valid Tutor ID.']);
        exit;
    }
    $stmt->close();
}

// Action: Submit order (tutor request)
elseif ($action === 'submit') {
    // Retrieve and validate fields
    $tutor_id          = isset($_POST['tutor_id']) ? trim($_POST['tutor_id']) : "";
    $subject           = isset($_POST['subject']) ? trim($_POST['subject']) : "";
    $order_name        = isset($_POST['order_name']) ? trim($_POST['order_name']) : "";
    $order_description = isset($_POST['order_description']) ? trim($_POST['order_description']) : "";
    $upload_instructions = isset($_POST['upload_instructions']) ? trim($_POST['upload_instructions']) : "";
    $order_deadline    = isset($_POST['order_deadline']) ? trim($_POST['order_deadline']) : "";
    $number_of_pages   = isset($_POST['number_of_pages']) ? intval($_POST['number_of_pages']) : 0;
    $total_price       = isset($_POST['total_price']) ? floatval($_POST['total_price']) : 0;
    
    if (empty($tutor_id) || empty($subject) || empty($order_name) || empty($order_description) || empty($order_deadline) || $number_of_pages <= 0 || $total_price <= 0) {
        ob_clean();
        echo json_encode(['error' => 'Missing or invalid required fields.']);
        exit;
    }
    
    // Validate deadline: must be at least one hour from now.
    $deadline_timestamp = strtotime($order_deadline);
    if ($deadline_timestamp === false || $deadline_timestamp < (time() + 3600)) {
        ob_clean();
        echo json_encode(['error' => 'Deadline must be at least one hour from now.']);
        exit;
    }
    
    // Get client id from session
    $client_id = $_SESSION['userID'] ?? null;
    if (!$client_id) {
        ob_clean();
        echo json_encode(['error' => 'Client not logged in.']);
        exit;
    }
    
    // *** New Code: Check user's balance and subtract the order amount ***
    $stmtBalance = $conn->prepare("SELECT balance FROM balance WHERE user_id = ?");
    if (!$stmtBalance) {
        ob_clean();
        echo json_encode(['error' => 'Prepare balance failed: ' . $conn->error]);
        exit;
    }
    $stmtBalance->bind_param("i", $client_id);
    $stmtBalance->execute();
    $stmtBalance->bind_result($balance);
    $stmtBalance->fetch();
    $stmtBalance->close();
    $balance = is_null($balance) ? 0 : (float)$balance;
    if ($balance < $total_price) {
        ob_clean();
        echo json_encode(['error' => 'Insufficient balance.']);
        exit;
    }
    $stmtUpdate = $conn->prepare("UPDATE balance SET balance = balance - ? WHERE user_id = ?");
    if (!$stmtUpdate) {
        ob_clean();
        echo json_encode(['error' => 'Prepare update failed: ' . $conn->error]);
        exit;
    }
    $stmtUpdate->bind_param("di", $total_price, $client_id);
    if (!$stmtUpdate->execute()) {
        ob_clean();
        echo json_encode(['error' => 'Failed to update balance: ' . $stmtUpdate->error]);
        exit;
    }
    $stmtUpdate->close();
    // *** End New Code ***

    // Process file uploads from "order_document[]"
    $uploadedFiles = [];
    if (isset($_FILES['order_document'])) {
        $files = $_FILES['order_document'];
        $uploadDir = "request/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $originalName = basename($files['name'][$i]);
                $pathInfo = pathinfo($originalName);
                $newFileName = $originalName;
                $counter = 1;
                // Check if file already exists; if so, append counter
                while(file_exists($uploadDir . $newFileName)) {
                    $newFileName = $pathInfo['filename'] . $counter . '.' . $pathInfo['extension'];
                    $counter++;
                }
                $destination = $uploadDir . $newFileName;
                if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                    $uploadedFiles[] = $newFileName;
                }
            }
        }
    }
    $document_names = !empty($uploadedFiles) ? implode(",", $uploadedFiles) : "";
    
    // Insert into the "request" table.
    // Table columns: order_id, client_id, tutor_id, subject, name, description, instructions,
    // deadline, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages,
    // created_at, updated_at, document_name, status.
    $created_at = date("Y-m-d H:i:s");
    $status = "beingdone";
    $sqlInsert = "INSERT INTO request (client_id, tutor_id, subject, name, description, instructions, deadline, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, created_at, updated_at, document_name, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, '', '', ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        ob_clean();
        echo json_encode(['error' => 'Prepare insert failed: ' . $conn->error]);
        exit;
    }
    // Bind parameters using the correct types:
    // "iissssssdissss" corresponds to: client_id, tutor_id, subject, order_name, order_description,
    // upload_instructions, order_deadline, document_names, total_price, number_of_pages,
    // created_at, updated_at, document_names, status.
    $stmtInsert->bind_param("iissssssdissss", $client_id, $tutor_id, $subject, $order_name, $order_description, $upload_instructions, $order_deadline, $document_names, $total_price, $number_of_pages, $created_at, $created_at, $document_names, $status);
    
    if ($stmtInsert->execute()) {
        $order_number = $conn->insert_id;
        ob_clean();
        echo json_encode(['success' => true, 'message' => 'Order submitted successfully.', 'order_number' => $order_number]);
        exit;
    } else {
        ob_clean();
        echo json_encode(['error' => 'Error submitting order: ' . $stmtInsert->error]);
        exit;
    }
    $stmtInsert->close();
} else {
    ob_clean();
    echo json_encode(['error' => 'Invalid action']);
    exit;
}

$conn->close();
ob_end_flush();
?>
