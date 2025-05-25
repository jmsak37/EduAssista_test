<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // When the Skip button is clicked via GET: update order status to "waiting" and assign tutor_id.
    if (!isset($_GET['order_id'])) {
        echo json_encode(["error" => "Order ID not provided"]);
        exit();
    }
    $order_id = $_GET['order_id'];
    $query = "UPDATE orders SET status = 'waiting', tutor_id = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("ii", $tutor_id, $order_id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["error" => "Failed to update order status to waiting: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // When the tutor submits the skip form (via POST): update order status to "skipped" and assign tutor_id.
    // This branch is triggered when the "Submit Reason" button is clicked.
    $payload = json_decode(file_get_contents("php://input"), true);
    if (!$payload || !isset($payload['order'])) {
        echo json_encode(["error" => "Invalid payload"]);
        exit();
    }
    $order = $payload['order'];
    if (!isset($order['order_id'])) {
        echo json_encode(["error" => "Order ID not provided in payload"]);
        exit();
    }
    $order_id = $order['order_id'];
    $query = "UPDATE orders SET status = 'skipped', tutor_id = ? WHERE order_id = ?";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Failed to prepare update statement: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("ii", $tutor_id, $order_id);
    if ($stmt->execute()) {
        if ($stmt->affected_rows === 0) {
            $stmt->close();
            $selectQuery = "SELECT status FROM orders WHERE order_id = ?";
            $stmtSelect = $conn->prepare($selectQuery);
            if (!$stmtSelect) {
                echo json_encode(["error" => "Failed to prepare select statement: " . $conn->error]);
                exit();
            }
            $stmtSelect->bind_param("i", $order_id);
            $stmtSelect->execute();
            $result = $stmtSelect->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['status'] === 'skipped') {
                    // Already skipped: update only the CSV record for this tutor.
                    logSkippedOrder($tutor_id, $order_id);
                    echo json_encode(["success" => true, "redirect" => "successful.html"]);
                } else {
                    echo json_encode(["error" => "No rows updated when attempting to set status to 'skipped'. Current status: " . $row['status']]);
                }
            } else {
                echo json_encode(["error" => "Order not found when verifying status."]);
            }
            $stmtSelect->close();
        } else {
            // Successfully updated – now log the skip for this tutor.
            logSkippedOrder($tutor_id, $order_id);
            echo json_encode(["success" => true, "redirect" => "successful.html"]);
        }
    } else {
        echo json_encode(["error" => "Failed to update order status to skipped: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
} else {
    echo json_encode(["error" => "Unsupported request method"]);
    exit();
}

/**
 * Logs the skipped order to the CSV file.
 *
 * If a row for the current tutor and order exists, clear its status (set it to an empty string)
 * without affecting rows for other tutors or orders.
 * If no row exists for the current tutor/order combination, append a new row.
 */
function logSkippedOrder($tutor_id, $order_id) {
    $csvFile = "skipped_orders.csv";
    // Define header with three columns.
    $header = ['tutorid', 'order_id', 'status'];
    $rows = [];
    $found = false;
    
    // Read existing rows if CSV exists.
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, "r")) !== false) {
            $csvHeader = fgetcsv($handle); // read header
            while (($data = fgetcsv($handle)) !== false) {
                // Ensure we have three columns; if not, pad with empty string.
                while(count($data) < 3) {
                    $data[] = "";
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
    }
    
    // Process rows: only update the row matching current tutor and order.
    for ($i = 0; $i < count($rows); $i++) {
        if ((int)$rows[$i][0] === (int)$tutor_id && (int)$rows[$i][1] === (int)$order_id) {
            // Found matching record: clear only its status.
            $rows[$i][2] = "";
            $found = true;
            // Do not break: if there are duplicate rows for this tutor/order, update them all.
        }
    }
    
    // If no matching row was found, append a new row with empty status.
    if (!$found) {
        $rows[] = array($tutor_id, $order_id, "");
    }
    
    // Write the header and all rows back to the CSV, preserving three columns.
    if (($handle = fopen($csvFile, "w")) !== false) {
        fputcsv($handle, $header);
        foreach ($rows as $row) {
            // Ensure row has exactly three columns.
            while(count($row) < 3) {
                $row[] = "";
            }
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}
?>
