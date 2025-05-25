<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID is missing"]);
    exit();
}
$order_id = (int)$_GET['order_id'];

// Database connection parameters (adjust as needed)
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Query the orders table for the given order_id.
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();

if (!$order) {
    echo json_encode(["error" => "Order not found"]);
    exit();
}

// --- Database check ---
// Only flag a change if the tutor assigned to the order is different
$db_changed = false;
if ($order['tutor_id'] != $tutor_id) {
    $db_changed = true;
}

// --- CSV check ---
// Check if the CSV record for this order lists a tutor different from the current one.
$csv_changed = false;
$csvFile = "skipped_orders.csv";
if (file_exists($csvFile)) {
    if (($handle = fopen($csvFile, "r")) !== false) {
        // Read header.
        $header = fgetcsv($handle);
        while (($data = fgetcsv($handle)) !== false) {
            if (isset($data[1]) && (int)$data[1] === $order_id) {
                // The tutorid column may contain one or more IDs (comma-separated).
                $csv_tutor_ids = array_map('trim', explode(",", $data[0]));
                // Convert tutor ids to integers.
                $csv_tutor_ids_int = array_map('intval', $csv_tutor_ids);
                if (!in_array($tutor_id, $csv_tutor_ids_int)) {
                    $csv_changed = true;
                }
                break;
            }
        }
        fclose($handle);
    }
}

if ($db_changed || $csv_changed) {
    echo json_encode([
        "changed" => true,
        "message" => "ORDER HAS BEEN TAKEN. ANOTHER TUTOR IS WORKING ON IT"
    ]);
} else {
    echo json_encode(["changed" => false]);
}

$conn->close();
?>
