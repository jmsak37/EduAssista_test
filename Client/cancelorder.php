<?php
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 0); // Suppress PHP errors so JSON output remains clean
header('Content-Type: application/json');
session_start();

// Database connection settings
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

// Define folder for supportreview uploads
$uploadFolder = "supportreview_uploads/";
if (!is_dir($uploadFolder)) {
    mkdir($uploadFolder, 0777, true);
}

// Function to generate a unique form ID (for renaming files)
function generateUniqueFormId() {
    return uniqid("form_");
}

// Retrieve and validate POST fields
$order_id = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
$issues = isset($_POST['issues']) ? $_POST['issues'] : [];
$issues_other_detail = isset($_POST['issues_other_detail']) ? trim($_POST['issues_other_detail']) : '';
$additional_details = isset($_POST['additional_details']) ? trim($_POST['additional_details']) : "";
$resolution = isset($_POST['resolution']) ? $_POST['resolution'] : [];
$resolution_other_detail = isset($_POST['resolution_other_detail']) ? trim($_POST['resolution_other_detail']) : '';

if (!$order_id) {
    ob_end_clean();
    echo json_encode(['error' => 'Missing required order id.']);
    exit;
}

// Build the issues text for the supportreview table.
$issuesText = implode(", ", $issues);
if (in_array("Other", $issues) && !empty($issues_other_detail)) {
    $issuesText .= " (Other: " . $issues_other_detail . ")";
}

// Build the resolution text for the supportreview table.
$resolutionText = implode(", ", $resolution);
if (in_array("Other", $resolution) && !empty($resolution_other_detail)) {
    $resolutionText .= " (Other: " . $resolution_other_detail . ")";
}

// Retrieve the order record from the progress table.
$sqlProgress = "SELECT * FROM progress WHERE order_id = ?";
$stmtProgress = $conn->prepare($sqlProgress);
if (!$stmtProgress) {
    ob_end_clean();
    echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
    exit;
}
$stmtProgress->bind_param("i", $order_id);
$stmtProgress->execute();
$resultProgress = $stmtProgress->get_result();
if ($resultProgress->num_rows == 0) {
    $stmtProgress->close();
    ob_end_clean();
    echo json_encode(['error' => 'Order not found in progress table.']);
    exit;
}
$progressData = $resultProgress->fetch_assoc();
$stmtProgress->close();

// Generate a unique form ID (for renaming uploaded files)
$form_id = generateUniqueFormId();

// Process any supporting file uploads using the form_id for renaming.
$supportFiles = [];
if (isset($_FILES['support_files'])) {
    $files = $_FILES['support_files'];
    for ($i = 0; $i < count($files['name']); $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $originalName = basename($files['name'][$i]);
            $newFileName = $form_id . "_" . $originalName;
            $destination = $uploadFolder . $newFileName;
            if (move_uploaded_file($files['tmp_name'][$i], $destination)) {
                $supportFiles[] = $newFileName;
            }
        }
    }
}
$supporting_files = !empty($supportFiles) ? implode(", ", $supportFiles) : "None";

// Use the additional details exactly as entered (if empty, store "None")
if ($additional_details === "") {
    $additional_details = "None";
}

// Begin transaction.
$conn->begin_transaction();
try {
    // Insert into supportreview table (26 columns).
    $sqlInsert = "INSERT INTO supportreview 
        (progress_id, order_id, client_id, tutor_id, subject, name, description, instructions, deadline,
         document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages,
         status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments,
         issues_identified, additional_details, preferred_resolution, supporting_files)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        throw new Exception("Prepare insert failed: " . $conn->error);
    }
    // Build the types string:
    // - 4 ints: progress_id, order_id, client_id, tutor_id
    // - 9 strings: subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link
    // - 1 double: price
    // - 1 int: number_of_pages
    // - 7 strings: status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments
    // - 4 strings: issues_identified, additional_details, preferred_resolution, supporting_files
    $types = "iiii" . "sssssssss" . "d" . "i" . "sssssss" . "ssss";
    $stmtInsert->bind_param($types,
         $progressData['progress_id'],
         $progressData['order_id'],
         $progressData['client_id'],
         $progressData['tutor_id'],
         $progressData['subject'],
         $progressData['name'],
         $progressData['description'],
         $progressData['instructions'],
         $progressData['deadline'],
         $progressData['document_name'],
         $progressData['document_upload_link'],
         $progressData['completed_work_name'],
         $progressData['completed_work_link'],
         $progressData['price'],
         $progressData['number_of_pages'],
         $progressData['status'],
         $progressData['created_at'],
         $progressData['updated_at'],
         $progressData['answer_files'],
         $progressData['answer_comments'],
         $progressData['explanation_files'],
         $progressData['explanation_comments'],
         $issuesText,
         $additional_details,
         $resolutionText,
         $supporting_files
    );
    if (!$stmtInsert->execute()) {
        throw new Exception("Insert into supportreview failed: " . $stmtInsert->error);
    }
    $stmtInsert->close();

    // Delete the record from the progress table.
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

    $conn->commit();
    ob_end_clean();
    echo json_encode(['success' => true, 'message' => 'Review submitted successfully', 'client_id' => $progressData['client_id']]);
    exit;
} catch (Exception $e) {
    $conn->rollback();
    ob_end_clean();
    echo json_encode(['error' => $e->getMessage()]);
    exit;
}
$conn->close();
?>
