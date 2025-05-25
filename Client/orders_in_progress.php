<?php
session_start();

// Database connection
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
    // Use userID from session
    $userID = $_SESSION['userID'] ?? null;
    if (!$userID) {
        echo json_encode(['error' => 'User not logged in']);
        exit;
    }
    // Fetch user data from users table
    $sql = "SELECT UserID as client_id, UserName as username FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Save the username in session for later use
        $_SESSION['username'] = $userData['username'];
        echo json_encode($userData);
    } else {
        echo json_encode(['error' => 'User data not found']);
    }
    $stmt->close();
} elseif ($action === 'getOrders') {
    $client_id = isset($_GET['client_id']) ? intval($_GET['client_id']) : 0;
    if (!$client_id) {
        echo json_encode(['error' => 'Invalid client ID']);
        exit;
    }

    $orders = [];

    // Get orders from "orders" table
    $sql_orders = "SELECT order_id AS id, name, tutor_id, deadline, status, 'orders' AS source FROM orders WHERE client_id = ?";
    $stmt = $conn->prepare($sql_orders);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    $stmt->close();

    // Get orders from "progress" table
    $sql_progress = "SELECT order_id AS id, name, tutor_id, deadline, status, 'progress' AS source FROM progress WHERE client_id = ?";
    $stmt = $conn->prepare($sql_progress);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    $stmt->close();

    // Get orders from "completed" table
    $sql_completed = "SELECT order_id AS id, name, tutor_id, deadline, status, 'completed' AS source FROM completed WHERE client_id = ?";
    $stmt = $conn->prepare($sql_completed);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }
    $stmt->close();

    if(count($orders) > 0){
        echo json_encode(['orders' => $orders]);
    } else {
        echo json_encode(['error' => 'No orders in progress']);
    }
} elseif ($action === 'setUserAndRedirect') {
    // New branch: Get the username from session and use it to look up the user in the users table.
    // Then, save the UserID in session and redirect to downloadorder.html with the order_id.
    $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    if (!$order_id) {
        echo json_encode(['error' => 'Order ID is missing']);
        exit;
    }
    // Use the username from session (it was set in getUserData)
    if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
        echo json_encode(['error' => 'Username not found in session']);
        exit;
    }
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT UserID FROM users WHERE UserName = ?");
    if (!$stmt) {
        echo json_encode(['error' => 'Prepare failed: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['userID'] = $row['UserID'];
    } else {
        echo json_encode(['error' => 'User not found in database']);
        exit;
    }
    $stmt->close();
    // Redirect to downloadorder.html with the order_id in GET; the userID is now saved in session (but not displayed)
    header("Location: downloadorder.html?order_id=" . $order_id);
    exit;
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>
