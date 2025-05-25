<?php
header('Content-Type: application/json');
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    // List all pricing records
    $sql = "SELECT writer_type, price_per_page FROM pricing";
    $result = $conn->query($sql);
    $pricing = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $pricing[] = $row;
        }
        echo json_encode(["success" => true, "pricing" => $pricing]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve pricing records: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif ($action === "add") {
    // Add a new pricing record.
    $writer_type = $_POST['writer_type'] ?? '';
    $price_per_page = $_POST['price_per_page'] ?? '';
    if (empty($writer_type) || $price_per_page === '') {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        $conn->close();
        exit;
    }
    $sql = "INSERT INTO pricing (writer_type, price_per_page, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sd", $writer_type, $price_per_page);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pricing record added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add pricing record: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "update") {
    // Update an existing pricing record.
    $writer_type = $_POST['writer_type'] ?? '';
    $price_per_page = $_POST['price_per_page'] ?? '';
    if (empty($writer_type) || $price_per_page === '') {
        echo json_encode(["success" => false, "message" => "Missing required fields."]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE pricing SET price_per_page = ?, updated_at = NOW() WHERE writer_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ds", $price_per_page, $writer_type);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pricing record updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update pricing record: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "delete") {
    // Delete a pricing record.
    // Using JSON POST data.
    $input = json_decode(file_get_contents('php://input'), true);
    $writer_type = $input['writer_type'] ?? '';
    if (empty($writer_type)) {
        echo json_encode(["success" => false, "message" => "Missing writer type."]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM pricing WHERE writer_type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $writer_type);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pricing record deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete pricing record: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action."]);
    $conn->close();
    exit;
}
?>
s