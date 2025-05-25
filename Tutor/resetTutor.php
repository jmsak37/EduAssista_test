<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID not provided"]);
    exit();
}
$order_id = $_GET['order_id'];

$query = "UPDATE orders SET tutor_id = NULL, status = 'undone' WHERE order_id = ?";
$stmt = $conn->prepare($query);
if (!$stmt) {
    echo json_encode(["error" => "Failed to prepare update statement: " . $conn->error]);
    exit();
}
$stmt->bind_param("i", $order_id);
if ($stmt->execute()) {
    // Update the CSV file: For the given order_id, clear its status while leaving others unchanged.
    $csvFile = "skipped_orders.csv";
    if (file_exists($csvFile)) {
        $rows = [];
        // Open the CSV for reading.
        if (($handle = fopen($csvFile, "r")) !== false) {
            // Read header.
            $header = fgetcsv($handle);
            // Read each row.
            while (($data = fgetcsv($handle)) !== false) {
                // Check if this row's order_id (assumed to be in column index 1) matches.
                if (isset($data[1]) && (int)$data[1] === (int)$order_id) {
                    // Set status (column index 2) to an empty string.
                    $data[2] = "";
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
        // Write back the header and updated rows.
        if (($handle = fopen($csvFile, "w")) !== false) {
            fputcsv($handle, $header);
            foreach ($rows as $row) {
                // Ensure the row has at least three columns.
                while (count($row) < 3) {
                    $row[] = "";
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        }
    }
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to reset tutor id: " . $stmt->error]);
}
$stmt->close();
$conn->close();
?>
