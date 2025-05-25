<?php
session_start();

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "eduassistadb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'getUserData') {
    $userID = $_SESSION['userID'] ?? null;
    if (!$userID) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }
    // Fetch user data from the users table
    $sql = "SELECT UserID, UserName FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Now fetch the balance from the balance table
        $sql2 = "SELECT balance FROM balance WHERE user_id = ?";
        $stmt2 = $conn->prepare($sql2);
        if (!$stmt2) {
            echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
            exit;
        }
        $stmt2->bind_param("i", $userID);
        $stmt2->execute();
        $stmt2->bind_result($balance);
        $stmt2->fetch();
        $stmt2->close();
        $balance = is_null($balance) ? 0 : floatval($balance);
        echo json_encode([
            'userID' => $userData['UserID'],
            'username' => $userData['UserName'],
            'balance' => $balance
        ]);
    } else {
        echo json_encode(['error' => 'User data not found']);
    }
    $stmt->close();
} elseif ($action === 'getActiveOrders') {
    $clientID = $_GET['clientID'] ?? null;
    if (!$clientID) {
        echo json_encode(['error' => 'Client ID is missing']);
        exit;
    }
    $orders = [];
    // Fetch active orders from the orders table for the given client
    $sql = "SELECT order_id, name, subject, status FROM orders WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    $stmt->close();
    if (count($orders) > 0) {
        echo json_encode(['orders' => $orders]);
    } else {
        echo json_encode(['error' => 'No active orders found']);
    }
} elseif ($action === 'getRequestOrders') {
    // Fetch request orders from the request table for the logged-in client.
    $clientID = $_GET['clientID'] ?? null;
    if (!$clientID) {
        echo json_encode(['error' => 'Client ID is missing']);
        exit;
    }
    $orders = [];
    // We now use the "request" table. Adjust the SELECT fields as needed.
    $sql = "SELECT order_id, tutor_id, subject, description, deadline FROM request WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    $stmt->close();
    if (count($orders) > 0) {
        echo json_encode(['orders' => $orders]);
    } else {
        echo json_encode(['error' => 'No request orders found']);
    }
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>
