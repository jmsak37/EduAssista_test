<?php
session_start();
header('Content-Type: application/json');

// Database connection settings
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "eduassistadb";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action === 'getUser') {
    // Retrieve the email from query parameters
    $email = isset($_GET['email']) ? trim($_GET['email']) : '';
    if (empty($email)) {
        echo json_encode(['error' => 'Email is required']);
        exit;
    }
    // Look up the user in the users table
    $sql = "SELECT UserID, RoleID, UserName, Email FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode($user);
    } else {
        echo json_encode(['error' => 'No user found with that email']);
    }
    $stmt->close();
} elseif ($action === 'updateBalance') {
    // Get the JSON payload from POST
    $data = json_decode(file_get_contents("php://input"), true);
    if (!$data) {
        echo json_encode(['error' => 'Invalid input']);
        exit;
    }
    
    $userID = isset($data['userID']) ? intval($data['userID']) : 0;
    $transactionType = isset($data['transactionType']) ? $data['transactionType'] : '';
    $amount = isset($data['amount']) ? floatval($data['amount']) : 0;
    
    if ($userID <= 0 || $amount <= 0 || !in_array($transactionType, ['add', 'remove'])) {
        echo json_encode(['error' => 'Invalid parameters']);
        exit;
    }
    
    // Check if user exists in the balance table
    $sql = "SELECT balance FROM balance WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($currentBalance);
    $exists = $stmt->fetch();
    $stmt->close();
    
    if ($transactionType === 'add') {
        if ($exists) {
            $newBalance = $currentBalance + $amount;
            $sql = "UPDATE balance SET balance = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("di", $newBalance, $userID);
            if ($stmt->execute()) {
                echo json_encode(['message' => "Balance updated. New balance: $$newBalance"]);
            } else {
                echo json_encode(['error' => 'Error updating balance']);
            }
            $stmt->close();
        } else {
            $sql = "INSERT INTO balance (user_id, balance) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("id", $userID, $amount);
            if ($stmt->execute()) {
                echo json_encode(['message' => "Balance updated. New balance: $$amount"]);
            } else {
                echo json_encode(['error' => 'Error inserting balance record']);
            }
            $stmt->close();
        }
    } elseif ($transactionType === 'remove') {
        if (!$exists) {
            echo json_encode(['error' => 'User has no deposited balance']);
            exit;
        } else {
            if ($currentBalance < $amount) {
                echo json_encode(['error' => "Insufficient balance. Current balance: $$currentBalance"]);
                exit;
            } else {
                $newBalance = $currentBalance - $amount;
                $sql = "UPDATE balance SET balance = ? WHERE user_id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("di", $newBalance, $userID);
                if ($stmt->execute()) {
                    echo json_encode(['message' => "Balance updated. New balance: $$newBalance"]);
                } else {
                    echo json_encode(['error' => 'Error updating balance']);
                }
                $stmt->close();
            }
        }
    }
} else {
    echo json_encode(['error' => 'Invalid action']);
}

$conn->close();
?>
