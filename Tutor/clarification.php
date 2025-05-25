<?php 
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

// Handle GET request: return all orders for this tutor from clarification and progressa.
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $orders = [];
    
    // Fetch orders from clarification table.
    $queryClarification = "SELECT *, 'clarification' as source FROM clarification WHERE tutor_id = ?";
    $stmtClarification = $conn->prepare($queryClarification);
    if(!$stmtClarification){
        echo json_encode(["error" => "Failed to prepare statement for clarification: " . $conn->error]);
        exit();
    }
    $stmtClarification->bind_param("i", $tutor_id);
    $stmtClarification->execute();
    $resultClarification = $stmtClarification->get_result();
    while($row = $resultClarification->fetch_assoc()){
        $orders[] = $row;
    }
    $stmtClarification->close();
    
    // Fetch orders from progressa table.
    $queryProgressa = "SELECT *, 'progressa' as source FROM progressa WHERE tutor_id = ?";
    $stmtProgressa = $conn->prepare($queryProgressa);
    if(!$stmtProgressa){
        echo json_encode(["error" => "Failed to prepare statement for progressa: " . $conn->error]);
        exit();
    }
    $stmtProgressa->bind_param("i", $tutor_id);
    $stmtProgressa->execute();
    $resultProgressa = $stmtProgressa->get_result();
    while($row = $resultProgressa->fetch_assoc()){
        $orders[] = $row;
    }
    $stmtProgressa->close();
    
    echo json_encode($orders);
    $conn->close();
    exit();
} 
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if(!$data || !isset($data['order_id']) || !isset($data['action'])){
        echo json_encode(["error" => "Invalid payload"]);
        exit();
    }
    $order_id = intval($data['order_id']);
    $action = $data['action'];
    
    if ($action === "redo") {
        // Try to fetch order from clarification table.
        $query = "SELECT * FROM clarification WHERE order_id = ? AND tutor_id = ?";
        $stmt = $conn->prepare($query);
        if(!$stmt){
            echo json_encode(["error" => "Failed to prepare select statement: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("ii", $order_id, $tutor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            // Order not found in clarification table; check in progressa.
            $queryProgressaCheck = "SELECT * FROM progressa WHERE order_id = ? AND tutor_id = ?";
            $stmtProgressaCheck = $conn->prepare($queryProgressaCheck);
            if(!$stmtProgressaCheck){
                echo json_encode(["error" => "Failed to prepare progressa check statement: " . $conn->error]);
                exit();
            }
            $stmtProgressaCheck->bind_param("ii", $order_id, $tutor_id);
            $stmtProgressaCheck->execute();
            $resultProgressaCheck = $stmtProgressaCheck->get_result();
            if($resultProgressaCheck->num_rows > 0) {
                $stmtProgressaCheck->close();
                echo json_encode(["success" => true, "message" => "Order already exists in progressa. Please open it."]);
                $conn->close();
                exit();
            }
            $stmtProgressaCheck->close();
            echo json_encode(["error" => "Order not found in clarification table"]);
            $conn->close();
            exit();
        }
        $order = $result->fetch_assoc();
        $stmt->close();
        
        // Insert into progressa table including the clarification message.
        $insertQuery = "INSERT INTO progressa 
            (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments, clarification)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'beinread', NOW(), NOW(), ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        if(!$stmtInsert){
            echo json_encode(["error" => "Failed to prepare insert statement: " . $conn->error]);
            exit();
        }
        $bindStr = "iiissssssssdissssss";
        $stmtInsert->bind_param($bindStr,
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
            $order['answer_files'],
            $order['answer_comments'],
            $order['explanation_files'],
            $order['explanation_comments'],
            $order['clarification']
        );
        if(!$stmtInsert->execute()){
            echo json_encode(["error" => "Failed to insert order into progressa table: " . $stmtInsert->error]);
            $stmtInsert->close();
            $conn->close();
            exit();
        }
        $stmtInsert->close();
        
        // Delete the order from clarification table.
        $deleteQuery = "DELETE FROM clarification WHERE order_id = ? AND tutor_id = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        if(!$stmtDelete){
            echo json_encode(["error" => "Failed to prepare delete statement: " . $conn->error]);
            exit();
        }
        $stmtDelete->bind_param("ii", $order_id, $tutor_id);
        if(!$stmtDelete->execute()){
            echo json_encode(["error" => "Failed to delete order from clarification table: " . $stmtDelete->error]);
            $stmtDelete->close();
            $conn->close();
            exit();
        }
        $stmtDelete->close();
        echo json_encode(["success" => true]);
        $conn->close();
        exit();
    }
    elseif ($action === "clarify") {
        // Process clarification: insert order into progress table without the clarification field.
        $answerClarification = isset($data['answerClarification']) ? $data['answerClarification'] : "";
        $explanationClarification = isset($data['explanationClarification']) ? $data['explanationClarification'] : "";
        
        // Fetch order from clarification table first.
        $query = "SELECT * FROM clarification WHERE order_id = ? AND tutor_id = ?";
        $stmt = $conn->prepare($query);
        if(!$stmt){
            echo json_encode(["error" => "Failed to prepare select statement: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("ii", $order_id, $tutor_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 0){
            // Order not found in clarification; you may add logic for progressa if needed.
            echo json_encode(["error" => "Order not found in clarification table"]);
            $stmt->close();
            $conn->close();
            exit();
        }
        $order = $result->fetch_assoc();
        $stmt->close();
        
        // Set the clarification messages into the appropriate fields.
        $answer_comments = !empty($answerClarification) ? $answerClarification : $order['answer_comments'];
        $explanation_comments = !empty($explanationClarification) ? $explanationClarification : $order['explanation_comments'];
        
        // Insert into progress table (do NOT include the clarification field).
        $insertQuery = "INSERT INTO progress 
            (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'donework', NOW(), NOW(), ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertQuery);
        if(!$stmtInsert){
            echo json_encode(["error" => "Failed to prepare insert statement into progress: " . $conn->error]);
            exit();
        }
        $bindStr = "iiissssssssdisssss";
        $stmtInsert->bind_param($bindStr,
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
            $order['answer_files'],
            $answer_comments,
            $order['explanation_files'],
            $explanation_comments
        );
        if(!$stmtInsert->execute()){
            echo json_encode(["error" => "Failed to insert order into progress table: " . $stmtInsert->error]);
            $stmtInsert->close();
            $conn->close();
            exit();
        }
        $stmtInsert->close();
        
        // Delete the order from clarification table.
        $deleteQuery = "DELETE FROM clarification WHERE order_id = ? AND tutor_id = ?";
        $stmtDelete = $conn->prepare($deleteQuery);
        if(!$stmtDelete){
            echo json_encode(["error" => "Failed to prepare delete statement: " . $conn->error]);
            exit();
        }
        $stmtDelete->bind_param("ii", $order_id, $tutor_id);
        if(!$stmtDelete->execute()){
            echo json_encode(["error" => "Failed to delete order from clarification table: " . $stmtDelete->error]);
            $stmtDelete->close();
            $conn->close();
            exit();
        }
        $stmtDelete->close();
        echo json_encode(["success" => true]);
        $conn->close();
        exit();
    }
    else {
        echo json_encode(["error" => "Invalid action"]);
        $conn->close();
        exit();
    }
}
else {
    echo json_encode(["error" => "Unsupported request method"]);
    $conn->close();
    exit();
}
?>
