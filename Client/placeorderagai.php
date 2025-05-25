<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0); // Suppress PHP errors so JSON output remains clean
header('Content-Type: application/json');

session_start();

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create DB connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_end_clean();
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Ensure the uploads folder exists
$uploadDir = "uploads/";
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Define path for our "Excel" file (using CSV here)
$csvFile = "document_ids.csv";

/**
 * Get the next document ID for a given base filename.
 * Reads the CSV file (if exists) and returns the next available ID.
 */
function getNextDocumentId($baseName, $csvFile = "document_ids.csv") {
    $data = [];
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            while (($row = fgetcsv($handle)) !== FALSE) {
                if (count($row) >= 2) {
                    $data[$row[0]] = (int)$row[1];
                }
            }
            fclose($handle);
        }
    }
    if (isset($data[$baseName])) {
        $data[$baseName]++;
        $nextId = $data[$baseName];
    } else {
        $nextId = 1;
        $data[$baseName] = $nextId;
    }
    // Write the updated data back to the CSV file
    if (($handle = fopen($csvFile, "w")) !== FALSE) {
        foreach ($data as $key => $value) {
            fputcsv($handle, [$key, $value]);
        }
        fclose($handle);
    }
    return $nextId;
}

/**
 * Generate a unique file name for an uploaded document using the CSV file to track last used IDs.
 */
function generateDocumentFileName($originalName, $uploadDir = "uploads/", $csvFile = "document_ids.csv") {
    $pathInfo = pathinfo($originalName);
    $base = $pathInfo['filename'];
    $ext = isset($pathInfo['extension']) ? $pathInfo['extension'] : '';
    $docId = getNextDocumentId($base, $csvFile);
    $newFileName = $base . $docId . ($ext ? '.' . $ext : '');
    return $newFileName;
}

// ----------- GET branch: Return order details from the progress table -----------
if (isset($_GET['action']) && $_GET['action'] === 'getOrder') {
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    if (!$order_id) {
        ob_end_clean();
        echo json_encode(['error' => 'Order ID is missing']);
        exit;
    }
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, 
                   document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, 
                   created_at, updated_at, document_name, status
            FROM progress WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        ob_end_clean();
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        ob_end_clean();
        echo json_encode($order);
        exit;
    } else {
        ob_end_clean();
        echo json_encode(['error' => 'Order not found']);
        exit;
    }
    $stmt->close();
}
// ----------- POST branch: Process order submission -----------
else {
    // Get required POST fields
    $order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $additional_details = isset($_POST['additional_details']) ? trim($_POST['additional_details']) : '';
    $new_deadline = isset($_POST['new_deadline']) ? trim($_POST['new_deadline']) : '';
    
    if (!$order_id || empty($additional_details) || empty($new_deadline)) {
        ob_end_clean();
        echo json_encode(['error' => 'Missing required fields']);
        exit;
    }
    
    // Validate new deadline: must be at least 1 hour from now.
    $current_time = time();
    $deadline_time = strtotime($new_deadline);
    if ($deadline_time === false || ($deadline_time - $current_time) < 3600) {
        ob_end_clean();
        echo json_encode(['error' => 'Deadline must be at least 1 hour from now']);
        exit;
    }
    
    // Process file uploads using our CSV "Excel" mechanism.
    $uploadedFiles = [];
    if (isset($_FILES['documents'])) {
        $files = $_FILES['documents'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $originalName = basename($files['name'][$i]);
                $newFileName = generateDocumentFileName($originalName, $uploadDir, $csvFile);
                $destination = $uploadDir . $newFileName;
                if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                    $uploadedFiles[] = $newFileName;
                }
            }
        }
    }
    $newDocumentLinks = !empty($uploadedFiles) ? implode(",", $uploadedFiles) : "";
    
    // Get the order details sent from the HTML (fetched earlier from progress)
    if (isset($_POST['order_details']) && !empty($_POST['order_details'])) {
        $order = json_decode($_POST['order_details'], true);
        if (!$order) {
            ob_end_clean();
            echo json_encode(['error' => 'Failed to decode order details']);
            exit;
        }
    } else {
        ob_end_clean();
        echo json_encode(['error' => 'Order details missing']);
        exit;
    }
    
    // Prepare new values:
    // Append the new additional details to the existing instructions.
    $newInstructions = $order['instructions'] . " Additional Details: " . $additional_details;
    // Use the new deadline as the updated deadline.
    $updatedDeadline = $new_deadline;
    
    // For document fields, if new files are uploaded, append them to the existing ones.
    $newDocumentUploadLink = $order['document_upload_link'];
    $newDocumentName = $order['document_name'];
    if (!empty($newDocumentLinks)) {
        // Prepend "uploads/" to each new document file name for the upload link.
        $newDocArray = explode(",", $newDocumentLinks);
        $prefixedNewDocs = array_map(function($doc){ return "uploads/" . $doc; }, $newDocArray);
        $prefixedNewDocumentLinks = implode(",", $prefixedNewDocs);
        
        $newDocumentUploadLink = empty($order['document_upload_link']) 
            ? $prefixedNewDocumentLinks 
            : $order['document_upload_link'] . "," . $prefixedNewDocumentLinks;
        $newDocumentName = empty($order['document_name']) 
            ? $newDocumentLinks 
            : $order['document_name'] . "," . $newDocumentLinks;
    }
    
    // Begin transaction
    $conn->begin_transaction();
    try {
        // Check if an order with this order_id already exists in the orders table
        $sqlCheck = "SELECT * FROM orders WHERE order_id = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        if (!$stmtCheck) {
            throw new Exception("Prepare check failed: " . $conn->error);
        }
        $stmtCheck->bind_param("i", $order_id);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();
        
        if ($resultCheck->num_rows > 0) {
            // Record exists – update instructions, deadline, document fields and updated_at.
            $sqlUpdate = "UPDATE orders 
                SET instructions = CONCAT(instructions, ' ', ?), deadline = ?, 
                    document_upload_link = ?, document_name = ?, updated_at = NOW()
                WHERE order_id = ?";
            $stmtUpdate = $conn->prepare($sqlUpdate);
            if (!$stmtUpdate) {
                throw new Exception("Prepare update failed: " . $conn->error);
            }
            $stmtUpdate->bind_param("ssssi", $newInstructions, $updatedDeadline, $newDocumentUploadLink, $newDocumentName, $order_id);
            if (!$stmtUpdate->execute()) {
                throw new Exception("Update orders failed: " . $stmtUpdate->error);
            }
            $stmtUpdate->close();
        } else {
            // No record exists – insert new order using values from progress (with modifications)
            // Set tutor_id as NULL and updated_at to NOW()
            $sqlInsert = "INSERT INTO orders 
                (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, 
                 document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, 
                 created_at, updated_at, document_name, status)
                VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?)";
            $stmtInsert = $conn->prepare($sqlInsert);
            if (!$stmtInsert) {
                throw new Exception("Prepare insert failed: " . $conn->error);
            }
            $status = "undone";
            // Note: tutor_id is not bound (NULL inserted) and updated_at is NOW()
            $bindTypes = "iissssssssdisss";
            $stmtInsert->bind_param(
                $bindTypes,
                $order['order_id'],
                $order['client_id'],
                $order['subject'],
                $order['name'],
                $order['description'],
                $newInstructions,
                $updatedDeadline,
                $newDocumentUploadLink,
                $order['completed_work_name'],
                $order['completed_work_link'],
                $order['price'],
                $order['number_of_pages'],
                $order['created_at'],
                $newDocumentName,
                $status
            );
            if (!$stmtInsert->execute()) {
                throw new Exception("Insert into orders failed: " . $stmtInsert->error);
            }
            $stmtInsert->close();
        }
        $stmtCheck->close();
        
        // After updating/inserting into orders, delete the record from progress
        $sqlDelete = "DELETE FROM progress WHERE order_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        if (!$stmtDelete) {
            throw new Exception("Prepare delete failed: " . $conn->error);
        }
        $stmtDelete->bind_param("i", $order_id);
        if (!$stmtDelete->execute()) {
            throw new Exception("Delete from progress failed: " . $stmtDelete->error);
        }
        $stmtDelete->close();
        
        // --- New Code: Check if the order exists in ../tutor/skipped_orders.csv using order_id only ---
        $skippedFile = "../tutor/skipped_orders.csv";
        if (file_exists($skippedFile)) {
            $rows = [];
            if (($handle = fopen($skippedFile, "r")) !== false) {
                while (($data = fgetcsv($handle)) !== false) {
                    // Assume CSV columns: tutor_id, order_id, status
                    if (count($data) >= 3) {
                        if ($data[1] == $order_id) { // check using order_id only
                            // Skip this row (delete it)
                            continue;
                        }
                    }
                    $rows[] = $data;
                }
                fclose($handle);
            }
            if (($handle = fopen($skippedFile, "w")) !== false) {
                foreach ($rows as $row) {
                    fputcsv($handle, $row);
                }
                fclose($handle);
            }
        }
        
        $conn->commit();
        ob_end_clean();
        echo json_encode(['success' => true, 'message' => 'Order placed successfully', 'client_id' => $order['client_id']]);
        $conn->close();
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        ob_end_clean();
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
}
$conn->close();
?>
