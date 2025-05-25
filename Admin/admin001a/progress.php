<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    // Fetch all records from the progress table.
    $sql = "SELECT progress_id, order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments FROM progress";
    $result = $conn->query($sql);
    $progress = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $progress[] = $row;
        }
        echo json_encode(["success" => true, "progress" => $progress]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching progress records: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif ($action === "update") {
    // Update progress record.
    $order_id = $_POST['order_id'] ?? '';
    $tutor_id = $_POST['tutor_id'] ?? null;
    $deadline = $_POST['deadline'] ?? '';
    $price = $_POST['price'] ?? '';
    $number_of_pages = $_POST['number_of_pages'] ?? '';
    $status = $_POST['status'] ?? '';
    
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    
    $sql = "UPDATE progress SET tutor_id = ?, deadline = ?, price = ?, number_of_pages = ?, status = ?, updated_at = NOW() WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("isdisi", $tutor_id, $deadline, $price, $number_of_pages, $status, $order_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Progress updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "delete") {
    // Delete a progress record.
    $input = json_decode(file_get_contents('php://input'), true);
    $order_id = $input['order_id'] ?? '';
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM progress WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $order_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Progress record deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete progress record: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "reassign") {
    // Reassign: move the record from progress back to orders table.
    $order_id = $_GET['order_id'] ?? '';
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    
    // Fetch the record from progress.
    $sql = "SELECT order_id, client_id, subject, name, description, instructions, deadline, price, number_of_pages, created_at, updated_at FROM progress WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("s", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    
    if (!$order) {
        echo json_encode(["success" => false, "message" => "Order not found"]);
        $conn->close();
        exit;
    }
    
    // Insert the record into orders table.
    $sqlInsert = "INSERT INTO orders (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, price, number_of_pages, created_at, updated_at, status)
                  VALUES (?, ?, NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'undone')";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtInsert->bind_param("sisssssdids", 
        $order['order_id'],
        $order['client_id'],
        $order['subject'],
        $order['name'],
        $order['description'],
        $order['instructions'],
        $order['deadline'],
        $order['price'],
        $order['number_of_pages'],
        $order['created_at'],
        $order['updated_at']
    );
    if (!$stmtInsert->execute()) {
        echo json_encode(["success" => false, "message" => "Insert into orders failed: " . $stmtInsert->error]);
        $stmtInsert->close();
        $conn->close();
        exit;
    }
    $stmtInsert->close();
    
    // Delete from progress table.
    $sqlDelete = "DELETE FROM progress WHERE order_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if (!$stmtDelete) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtDelete->bind_param("s", $order_id);
    if ($stmtDelete->execute()) {
        echo json_encode(["success" => true, "message" => "Order reassigned successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Delete failed: " . $stmtDelete->error]);
    }
    $stmtDelete->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
