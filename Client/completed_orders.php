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

// Handle actions
$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'getUserData') {
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

    // Fetch completed orders from the completed table
    $sql = "SELECT order_id, name, deadline, tutor_id 
            FROM completed WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $orders = [];
    while ($row = $result->fetch_assoc()){
        $orders[] = $row;
    }

    echo json_encode(['orders' => $orders]);
    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>
