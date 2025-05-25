<?php
session_start();
header('Content-Type: application/json');

// Ensure the tutor is logged in.
if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}

$tutor_id = $_SESSION['userID'];

// Validate the order_id parameter.
if (!isset($_GET['order_id'])) {
    echo json_encode(["error" => "Order ID missing"]);
    exit();
}

$order_id = (int)$_GET['order_id'];
$csvFile = "skipped_orders.csv";

// Check if the CSV file exists.
if (!file_exists($csvFile)) {
    echo json_encode(["error" => "CSV file not found"]);
    exit();
}

$rows = [];
$header = [];

// Open the CSV file for reading.
if (($handle = fopen($csvFile, "r")) !== false) {
    // Get the header row.
    $header = fgetcsv($handle);
    
    // Process each row.
    while (($data = fgetcsv($handle)) !== false) {
        // Expecting CSV columns: tutorid, order_id, status.
        if (count($data) < 3) {
            continue; // Skip malformed rows.
        }
        
        $currentTutor = (int)$data[0];
        $currentOrder = (int)$data[1];
        
        // Skip the row if tutorid and order_id match.
        if ($currentTutor === $tutor_id && $currentOrder === $order_id) {
            continue;
        }
        
        // Otherwise, keep the row.
        $rows[] = $data;
    }
    fclose($handle);
} else {
    echo json_encode(["error" => "Failed to open CSV file for reading"]);
    exit();
}

// Open the CSV file for writing and save the updated rows.
if (($handle = fopen($csvFile, "w")) !== false) {
    // Write the header.
    if (!empty($header)) {
        fputcsv($handle, $header);
    }
    // Write all remaining rows.
    foreach ($rows as $row) {
        fputcsv($handle, $row);
    }
    fclose($handle);
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Failed to open CSV file for writing"]);
}
?>
