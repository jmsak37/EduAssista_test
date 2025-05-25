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

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    ob_clean();
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

/* ---------------------------------------------------------------------
   If the rating form is submitted via POST (standard form submission),
   process the rating.
--------------------------------------------------------------------- */
if (isset($_POST['rating_submitted'])) {
    $order_id      = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
    $tutor_id      = isset($_POST['tutor_id']) ? intval($_POST['tutor_id']) : 0;
    $client_id     = isset($_POST['client_id']) ? intval($_POST['client_id']) : 0;
    $rating_status = isset($_POST['rating_status']) ? $_POST['rating_status'] : '';
    $rating_reason = isset($_POST['rating_reason']) ? trim($_POST['rating_reason']) : '';

    // For "helpful": if empty, default to "non". For "unhelpful": require a nonempty reason.
    if ($rating_status === 'helpful') {
        if (empty($rating_reason)) {
            $rating_reason = "non";
        }
    } elseif ($rating_status === 'unhelpful') {
        if (empty($rating_reason)) {
            echo json_encode(['success' => false, 'message' => 'Please provide details for unhelpful rating']);
            exit;
        }
    } elseif ($rating_status === 'ignore') {
        // For "ignore", no rating is inserted.
        echo json_encode(['success' => true, 'message' => 'Rating submitted successfully']);
        exit;
    }

    $sqlRating = "INSERT INTO ratings (user_id, rating_status, reason, order_id) VALUES (?, ?, ?, ?)";
    $stmtRating = $conn->prepare($sqlRating);
    if (!$stmtRating) {
        echo json_encode(['success' => false, 'message' => 'Prepare rating failed: ' . $conn->error]);
        exit;
    }
    $stmtRating->bind_param("issi", $tutor_id, $rating_status, $rating_reason, $order_id);
    if ($stmtRating->execute()) {
        echo json_encode(['success' => true, 'message' => 'Rating submitted successfully']);
        exit;
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to submit rating: ' . $stmtRating->error]);
        exit;
    }
    $stmtRating->close();
}

/* ---------------------------------------------------------------------
   Otherwise, process order acceptance via JSON input.
--------------------------------------------------------------------- */
$rawInput = file_get_contents("php://input");
$inputData = json_decode($rawInput, true);

if (!$inputData || !isset($inputData['action']) || $inputData['action'] !== 'acceptOrder') {
    ob_clean();
    echo json_encode(['error' => 'Invalid action for AcceptOrder.php']);
    exit;
}

if (!isset($inputData['orderData'])) {
    ob_clean();
    echo json_encode(['error' => 'Order data not provided']);
    exit;
}

$order = $inputData['orderData'];

// Ensure every expected field is present (set missing/empty ones to null)
$expectedFields = [
    "order_id", "client_id", "tutor_id", "subject", "name", "description",
    "instructions", "deadline", "document_name", "document_upload_link",
    "completed_work_name", "completed_work_link", "price", "number_of_pages",
    "status", "created_at", "updated_at", "answer_files", "answer_comments",
    "explanation_files", "explanation_comments"
];
foreach ($expectedFields as $field) {
    if (!isset($order[$field]) || $order[$field] === "") {
        $order[$field] = null;
    }
}

// Verify that session user id matches order's client_id.
if (!isset($_SESSION['userID']) || $_SESSION['userID'] != $order['client_id']) {
    echo json_encode(['error' => 'Session user id does not match order client id']);
    exit;
}

$order_id_val  = intval($order['order_id'] ?? 0);
$client_id_val = intval($order['client_id'] ?? 0);
$tutor_id_val  = intval($order['tutor_id'] ?? 0);
$price_val     = floatval($order['price'] ?? 0);
$num_pages_val = intval($order['number_of_pages'] ?? 0);
$status        = "completed";

$subject              = $order['subject'];
$name                 = $order['name'];
$description          = $order['description'];
$instructions         = $order['instructions'];
$deadline             = $order['deadline'];
$document_name        = $order['document_name'];
$document_upload_link = $order['document_upload_link'];
$completed_work_name  = $order['completed_work_name'];
$completed_work_link  = $order['completed_work_link'];
$created_at           = $order['created_at'];
// We no longer bind $updated_at as we update it to NOW() in SQL.
$answer_files         = $order['answer_files'];
$answer_comments      = $order['answer_comments'];
$explanation_files    = $order['explanation_files'];
$explanation_comments = $order['explanation_comments'];

$conn->begin_transaction();
try {
    // 1. Insert order details into the completed table.
    // Notice: updated_at is set to NOW() automatically.
    $sqlInsert = "INSERT INTO completed
        (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, 
         document_name, document_upload_link, completed_work_name, completed_work_link, price, 
         number_of_pages, status, created_at, updated_at, answer_files, answer_comments, 
         explanation_files, explanation_comments)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        throw new Exception("Prepare insert failed: " . $conn->error);
    }
    // Binding string now has 20 placeholders (updated_at is not bound).
    $bindTypes = "iiisssssssssdissssss";
    $stmtInsert->bind_param(
        $bindTypes,
        $order_id_val,
        $client_id_val,
        $tutor_id_val,
        $subject,
        $name,
        $description,
        $instructions,
        $deadline,
        $document_name,
        $document_upload_link,
        $completed_work_name,
        $completed_work_link,
        $price_val,
        $num_pages_val,
        $status,
        $created_at,
        $answer_files,
        $answer_comments,
        $explanation_files,
        $explanation_comments
    );
    if (!$stmtInsert->execute()) {
        throw new Exception("Insert into completed failed: " . $stmtInsert->error);
    }
    $stmtInsert->close();

    // 2. Delete order from progress table.
    $sqlDelete = "DELETE FROM progress WHERE order_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if (!$stmtDelete) {
        throw new Exception("Prepare delete failed: " . $conn->error);
    }
    $stmtDelete->bind_param("i", $order_id_val);
    if (!$stmtDelete->execute()) {
        throw new Exception("Failed to delete order from progress: " . $stmtDelete->error);
    }
    $stmtDelete->close();

    // 3. Update tutor's balance (add bonus = number_of_pages * 2).
    $bonus = $num_pages_val * 2;
    $sqlTutor = "UPDATE balance SET balance = balance + ? WHERE user_id = ?";
    $stmtTutor = $conn->prepare($sqlTutor);
    if (!$stmtTutor) {
        throw new Exception("Prepare update tutor balance failed: " . $conn->error);
    }
    $stmtTutor->bind_param("di", $bonus, $tutor_id_val);
    if (!$stmtTutor->execute()) {
        throw new Exception("Failed to update tutor balance: " . $stmtTutor->error);
    }
    $stmtTutor->close();

    $conn->commit();
    echo json_encode(['success' => true, 'message' => 'Order accepted successfully']);
    exit;
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    exit;
}

$conn->close();
ob_end_flush();
?>
