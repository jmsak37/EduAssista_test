<?php
session_start();
// Optionally, enforce that only admin users may access this page.

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if($conn->connect_error){
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if($action === "list"){
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, price, number_of_pages, status, created_at, updated_at, answer_comments, explanation_comments, document_name, document_upload_link, completed_work_name, completed_work_link, answer_files, explanation_files
            FROM completed
            ORDER BY updated_at DESC";
    $result = $conn->query($sql);
    $orders = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        echo json_encode(["success" => true, "orders" => $orders]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching completed orders: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif($action === "listTutors"){
    $sql = "SELECT UserID, UserName FROM users WHERE RoleID = 2";
    $result = $conn->query($sql);
    $tutors = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $tutors[] = $row;
        }
        echo json_encode(["success" => true, "tutors" => $tutors]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching tutors: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif($action === "update"){
    // Expected POST fields: order_id, tutor_id, deadline, price, number_of_pages, status, answer_comments, explanation_comments.
    $order_id = $_POST['order_id'] ?? '';
    if(empty($order_id)){
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    $tutor_id = $_POST['tutor_id'] ?? null;
    $deadline = $_POST['deadline'] ?? '';
    $price = $_POST['price'] ?? '';
    $number_of_pages = $_POST['number_of_pages'] ?? '';
    $status = $_POST['status'] ?? '';
    $answer_comments = $_POST['answer_comments'] ?? '';
    $explanation_comments = $_POST['explanation_comments'] ?? '';
    
    $sql = "UPDATE completed SET tutor_id = ?, deadline = ?, price = ?, number_of_pages = ?, status = ?, answer_comments = ?, explanation_comments = ?, updated_at = NOW() WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("isdisssi", $tutor_id, $deadline, $price, $number_of_pages, $status, $answer_comments, $explanation_comments, $order_id);
    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Order updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif($action === "delete"){
    $order_id = $_POST['order_id'] ?? '';
    if(empty($order_id)){
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM completed WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("s", $order_id);
    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Order deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Delete failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
