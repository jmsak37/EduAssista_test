<?php
// progressa.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, price, number_of_pages, status, created_at, updated_at,
                   document_upload_link, completed_work_link, answer_files, explanation_files
            FROM progressa";
    $result = $conn->query($sql);
    $progressa = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $progressa[] = $row;
        }
        echo json_encode(["success" => true, "progressa" => $progressa]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching records: " . $conn->error]);
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
    
    $sql = "UPDATE progressa SET tutor_id = ?, deadline = ?, price = ?, number_of_pages = ?, status = ?, updated_at = NOW() WHERE order_id = ?";
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
} elseif ($action === "delete" && isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
    $sql = "DELETE FROM progressa WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $success = $stmt->execute();
    echo json_encode(["success" => $success]);
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "reassign") {
    // Reassign: move the order from progressa to clarification table.
    $order_id = $_GET['order_id'] ?? '';
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Order ID is required"]);
        $conn->close();
        exit;
    }
    
    // Fetch order details from progressa.
    $sql = "SELECT order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments, clarification
            FROM progressa WHERE order_id = ?";
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
    
    // Insert into clarification table.
    $sqlInsert = "INSERT INTO clarification (order_id, client_id, tutor_id, subject, name, description, instructions, deadline, document_name, document_upload_link, completed_work_name, completed_work_link, price, number_of_pages, status, created_at, updated_at, answer_files, answer_comments, explanation_files, explanation_comments, clarification)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW(), ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    if (!$stmtInsert) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtInsert->bind_param("siisssssssdiisssssss",
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
        $order['status'],
        $order['answer_files'],
        $order['answer_comments'],
        $order['explanation_files'],
        $order['explanation_comments'],
        $order['clarification']
    );
    if (!$stmtInsert->execute()) {
        echo json_encode(["success" => false, "message" => "Insert into clarification failed: " . $stmtInsert->error]);
        $stmtInsert->close();
        $conn->close();
        exit;
    }
    $stmtInsert->close();
    
    // Delete from progressa table.
    $sqlDelete = "DELETE FROM progressa WHERE order_id = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if (!$stmtDelete) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtDelete->bind_param("s", $order_id);
    if ($stmtDelete->execute()) {
        echo json_encode(["success" => true, "message" => "Order moved to clarification successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Delete from progressa failed: " . $stmtDelete->error]);
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
