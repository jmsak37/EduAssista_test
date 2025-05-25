<?php
// clarification.php
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
    // Fetch all records from the clarification table.
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, price, number_of_pages, status, created_at, updated_at, clarification,
                   document_upload_link, completed_work_name, completed_work_link, document_name, answer_files, explanation_files
            FROM clarification";
    $result = $conn->query($sql);
    $clarifications = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $clarifications[] = $row;
        }
        echo json_encode(["success" => true, "clarifications" => $clarifications]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching clarifications: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif ($action === "listTutors") {
    // List tutors from users table where RoleID = 2.
    $sql = "SELECT UserID, UserName FROM users WHERE RoleID = 2";
    $result = $conn->query($sql);
    $tutors = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tutors[] = $row;
        }
        echo json_encode(["success" => true, "tutors" => $tutors]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching tutors: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif ($action === "update") {
    // Update clarification record with new tutor, deadline, price, pages, and status.
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
    
    $sql = "UPDATE clarification SET tutor_id = ?, deadline = ?, price = ?, number_of_pages = ?, status = ?, updated_at = NOW() WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("isdisi", $tutor_id, $deadline, $price, $number_of_pages, $status, $order_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Order updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "reassign") {
    // Reassign: move the order from clarification to orders table.
    // Only insert: order_id, client_id, tutor_id (set to NULL), subject, name, description, instructions, deadline, price, number_of_pages, created_at, updated_at, status.
    // Set tutor_id to NULL and status to 'undone'.
    $order_id = $_GET['order_id'] ?? '';
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    
    // Fetch the order details from clarification.
    $sql = "SELECT order_id, client_id, subject, name, description, instructions, deadline, price, number_of_pages, created_at, updated_at
            FROM clarification WHERE order_id = ?";
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
    
    // Insert into orders table.
    // Note: Adjust the field order and types as per your orders table.
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
    
    // Delete from clarification table.
    $sqlDelete = "DELETE FROM clarification WHERE order_id = ?";
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
