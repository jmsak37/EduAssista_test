<?php
header('Content-Type: application/json');
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if($conn->connect_error){
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if($action === "list"){
    // Retrieve all orders from orders table.
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, price, number_of_pages, status, created_at, updated_at, document_name FROM orders";
    $result = $conn->query($sql);
    $orders = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $orders[] = $row;
        }
        echo json_encode(["success" => true, "orders" => $orders]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve orders: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif($action === "delete"){
    // Delete an order.
    $input = json_decode(file_get_contents('php://input'), true);
    $order_id = $input['order_id'] ?? null;
    if(!$order_id){
        echo json_encode(["success" => false, "message" => "Missing order_id"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $order_id);
    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Order deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete order: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif($action === "assign"){
    // Update the order: set tutor_id and change status to "beingdone"
    $input = json_decode(file_get_contents('php://input'), true);
    $order_id = $input['order_id'] ?? null;
    $tutor_id = $input['tutor_id'] ?? null;
    if(!$order_id || !$tutor_id){
        echo json_encode(["success" => false, "message" => "Missing parameters"]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE orders SET tutor_id = ?, status = 'beingdone' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $tutor_id, $order_id);
    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Order assigned successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to assign order: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif($action === "listTutors"){
    // List tutors from users table (RoleID = 2)
    $sql = "SELECT UserID, UserName FROM users WHERE RoleID = 2";
    $result = $conn->query($sql);
    $tutors = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $tutors[] = $row;
        }
        echo json_encode(["success" => true, "tutors" => $tutors]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve tutors: " . $conn->error]);
    }
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
