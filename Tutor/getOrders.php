<?php
session_start();
header('Content-Type: application/json');

// Disable error display to prevent HTML error pages from being output
ini_set('display_errors', 0);
error_reporting(0);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

// Create connection.
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

/**
 * Returns an array of order_ids from the CSV that have status "beinread"
 */
function getBeenReadOrders() {
    $beenReadOrders = array();
    $csvFile = "skipped_orders.csv";
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, "r")) !== false) {
            // Skip header.
            fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                if (isset($data[1], $data[2]) && strtolower(trim($data[2])) === "beinread") {
                    $beenReadOrders[] = (int)$data[1];
                }
            }
            fclose($handle);
        }
    }
    return $beenReadOrders;
}

/**
 * Returns an array of order_ids from the CSV that were skipped by the current tutor.
 * (These orders will be excluded from assignment when includeSkipped is false.)
 */
function getCurrentTutorSkippedOrders() {
    $skippedOrders = array();
    $csvFile = "skipped_orders.csv";
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, "r")) !== false) {
            fgetcsv($handle); // Skip header.
            while (($data = fgetcsv($handle)) !== false) {
                if (isset($data[0], $data[1])) {
                    $csvStatus = isset($data[2]) ? trim($data[2]) : "";
                    if ((int)$data[0] === (int)$GLOBALS['tutor_id'] && $csvStatus === "") {
                        $skippedOrders[] = (int)$data[1];
                    }
                }
            }
            fclose($handle);
        }
    }
    return $skippedOrders;
}

/**
 * Sets (or overrides) the CSV row for the given tutor and order with the provided status.
 * This function forces the CSV record to match the current tutor—even if another tutor
 * previously skipped the order.
 */
function setCSVStatus($tutor_id, $order_id, $newStatus) {
    $csvFile = "skipped_orders.csv";
    $header = ['tutorid', 'order_id', 'status'];
    $rows = [];
    $found = false;
    
    if (file_exists($csvFile)) {
        if (($handle = fopen($csvFile, "r")) !== false) {
            $csvHeader = fgetcsv($handle);
            while (($data = fgetcsv($handle)) !== false) {
                while(count($data) < 3) {
                    $data[] = "";
                }
                if ((int)$data[1] === (int)$order_id) {
                    // Override any previous tutor assignment.
                    $data[0] = $tutor_id;
                    $data[2] = $newStatus;
                    $found = true;
                }
                $rows[] = $data;
            }
            fclose($handle);
        }
    }
    if (!$found) {
        $rows[] = array($tutor_id, $order_id, $newStatus);
    }
    if (($handle = fopen($csvFile, "w")) !== false) {
        fputcsv($handle, $header);
        foreach ($rows as $row) {
            while(count($row) < 3) {
                $row[] = "";
            }
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

$includeSkipped = (isset($_GET['includeSkipped']) && $_GET['includeSkipped'] == "1");
$beenReadOrders = getBeenReadOrders();
$beenReadList = "";
if (!empty($beenReadOrders)) {
    $beenReadList = implode(",", $beenReadOrders);
}

if ($includeSkipped) {
    // When includeSkipped is true, fetch orders that are either 'undone' or 'skipped'
    // without excluding orders skipped by other tutors.
    $query = "SELECT * FROM orders WHERE ( (status = 'undone' AND (tutor_id IS NULL OR tutor_id = 0 OR tutor_id = ?)) OR (status = 'skipped') )";
    if ($beenReadList !== "") {
        $query .= " AND order_id NOT IN ($beenReadList)";
    }
    $query .= " LIMIT 1";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("i", $tutor_id);
    
} else {
    // When includeSkipped is false, still fetch orders that are either 'undone' or 'skipped'
    // but exclude orders that were skipped by the current tutor.
    $skippedOrders = getCurrentTutorSkippedOrders();
    $query = "SELECT * FROM orders WHERE ( (status = 'undone' AND (tutor_id IS NULL OR tutor_id = 0 OR tutor_id = ?)) OR (status = 'skipped') )";
    if ($beenReadList !== "") {
        $query .= " AND order_id NOT IN ($beenReadList)";
    }
    if (!empty($skippedOrders)) {
        $skippedList = implode(",", $skippedOrders);
        $query .= " AND order_id NOT IN ($skippedList)";
    }
    $query .= " LIMIT 1";
    
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn->error]);
        exit();
    }
    $stmt->bind_param("i", $tutor_id);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $order = $result->fetch_assoc();
    // If the order is unassigned or its tutor_id is not the current tutor,
    // then reassign it to the current tutor (even if it was skipped by another tutor).
    if (!isset($order['tutor_id']) || $order['tutor_id'] == 0 || $order['tutor_id'] != $tutor_id) {
        $updateQuery = "UPDATE orders SET tutor_id = ?, status = 'beinread' WHERE order_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt) {
            $updateStmt->bind_param("ii", $tutor_id, $order['order_id']);
            $updateStmt->execute();
            $updateStmt->close();
            $order['tutor_id'] = $tutor_id;
            $order['status'] = "beinread";
        }
    }
    // Always update the CSV record so that it reflects the current tutor assignment.
    setCSVStatus($tutor_id, $order['order_id'], "beinread");
    echo json_encode($order);
} else {
    echo json_encode(null);
}
$stmt->close();

/* --- Additional Functionalities --- */

/**
 * Fetch an order with status "skipped" from the database where the tutor_id is different
 * from the current tutor. This function ignores CSV data entirely.
 */
function fetchSkippedOrderForDifferentTutor($tutor_id) {
    global $conn;
    $query = "SELECT * FROM orders WHERE status = 'skipped' AND tutor_id != ? LIMIT 1";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param("i", $tutor_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    return $order;
}

/**
 * Fetch an order with no status (status IS NULL or empty) and update its status
 * to "beinread" in the database irrespective of its current tutor_id.
 */
function fetchNoStatusOrderAndUpdate() {
    global $conn;
    $query = "SELECT * FROM orders WHERE (status IS NULL OR status = '') LIMIT 1";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        return null;
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
    if ($order) {
        $updateQuery = "UPDATE orders SET status = 'beinread' WHERE order_id = ?";
        $updateStmt = $conn->prepare($updateQuery);
        if ($updateStmt) {
            $updateStmt->bind_param("i", $order['order_id']);
            $updateStmt->execute();
            $updateStmt->close();
            $order['status'] = 'beinread';
        }
    }
    return $order;
}

/* --- New Functionality --- 
   When this file is called with ?action=fetchSkippedAll, it will return all orders 
   from the orders table with status "skipped" and where tutor_id is different from 
   the current session tutor.
*/
if (isset($_GET['action']) && $_GET['action'] == 'fetchSkippedAll') {
    // Open a new connection for this functionality.
    $conn2 = new mysqli($servername, $username, $password, $dbname);
    if ($conn2->connect_error) {
        die(json_encode(["error" => "Database connection failed: " . $conn2->connect_error]));
    }
    if (!isset($_SESSION['userID'])) {
        echo json_encode(["error" => "Tutor not logged in"]);
        exit();
    }
    $tutor_id = $_SESSION['userID'];
    $query = "SELECT * FROM orders WHERE status = 'skipped' AND tutor_id != ?";
    $stmt2 = $conn2->prepare($query);
    if (!$stmt2) {
        echo json_encode(["error" => "Failed to prepare statement: " . $conn2->error]);
        exit();
    }
    $stmt2->bind_param("i", $tutor_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();
    $skippedOrdersAll = array();
    while ($row = $result2->fetch_assoc()) {
        $skippedOrdersAll[] = $row;
    }
    $stmt2->close();
    $conn2->close();
    echo json_encode($skippedOrdersAll);
    exit();
}

$conn->close();
?>
