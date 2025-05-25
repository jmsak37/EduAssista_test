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
    // Fetch user data from users table
    $sql = "SELECT UserID, UserName FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        // Fetch rating data
        $sql_rating = "SELECT rating_status FROM ratings WHERE user_id = ?";
        $stmt_rating = $conn->prepare($sql_rating);
        $stmt_rating->bind_param("i", $userID);
        $stmt_rating->execute();
        $rating_result = $stmt_rating->get_result();
        $rating_count = ['helpful' => 0, 'unhelpful' => 0];
        while ($rating_row = $rating_result->fetch_assoc()) {
            if ($rating_row['rating_status'] === 'helpful') {
                $rating_count['helpful']++;
            } else {
                $rating_count['unhelpful']++;
            }
        }
        $total_ratings = $rating_count['helpful'] + $rating_count['unhelpful'];
        $rating_percentage = $total_ratings > 0 ? ($rating_count['helpful'] / $total_ratings) * 100 : 100;
        echo json_encode([
            'userID' => $userData['UserID'],
            'username' => $userData['UserName'],
            'rating' => round($rating_percentage, 2)
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
    
    // Fetch from orders table
    $sql = "SELECT order_id, name, subject, status, deadline, tutor_id FROM orders WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $row['source'] = "orders";
        $orders[] = $row;
    }
    $stmt->close();
    
    // Fetch from progress table
    $sql = "SELECT order_id, name, subject, status, deadline, tutor_id FROM progress WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $row['source'] = "progress";
        $orders[] = $row;
    }
    $stmt->close();
    
    // Fetch from completed table
    $sql = "SELECT order_id, name, subject, status, deadline, tutor_id FROM completed WHERE client_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()){
        $row['source'] = "completed";
        $orders[] = $row;
    }
    $stmt->close();
    
    if(count($orders) > 0){
        echo json_encode(['orders' => $orders]);
    } else {
        echo json_encode(['error' => 'No active orders found']);
    }
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>
