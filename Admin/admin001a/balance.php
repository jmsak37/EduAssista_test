<?php
session_start(); // Start session to get current user info

header('Content-Type: application/json');
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

$action = $_GET['action'] ?? '';

// Get current user id and role from session
$currentUser = $_SESSION['user_id'] ?? null;     // e.g., for a client or tutor
$currentRole = $_SESSION['role_id'] ?? null;       // 1 = client, 2 = tutor, 3 = admin

if ($action === "list") {
    // Retrieve all records from the balance table joined with users table.
    $sql = "SELECT b.user_id, b.balance, u.UserName, u.Email, u.RoleID 
            FROM balance b 
            LEFT JOIN users u ON b.user_id = u.UserID";
    $result = $conn->query($sql);
    $balances = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $role = "";
            if (isset($row['RoleID'])) {
                if ($row['RoleID'] == 1) {
                    $role = "client";
                } elseif ($row['RoleID'] == 2) {
                    $role = "tutor";
                } elseif ($row['RoleID'] == 3) {
                    $role = "admin";
                } else {
                    $role = "unknown";
                }
            }
            $row['rule'] = $role;
            $balances[] = $row;
        }
        echo json_encode(["success" => true, "balances" => $balances]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve balances"]);
    }
    $conn->close();
    exit;
} elseif ($action === "viewUser") {
    // Return user details from the users table.
    $user_id = $_GET['user_id'] ?? '';
    if (!$user_id) {
        echo json_encode(["success" => false, "message" => "Missing user_id"]);
        $conn->close();
        exit;
    }
    $sql = "SELECT UserID, RoleID, UserName, Email, CreatedAt, UpdatedAt FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            $role = "";
            if ($user['RoleID'] == 1) {
                $role = "client";
            } elseif ($user['RoleID'] == 2) {
                $role = "tutor";
            } elseif ($user['RoleID'] == 3) {
                $role = "admin";
            } else {
                $role = "unknown";
            }
            $user['rule'] = $role;
            echo json_encode(["success" => true, "user" => $user]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Query execution error"]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "searchOrder") {
    // New action: search the entire database for the order_id
    // Only fetch the order if it belongs to the logged-in user (based on role)
    $order_id = $_GET['order_id'] ?? '';
    if (empty($order_id)) {
        echo json_encode(["success" => false, "message" => "Missing order_id"]);
        $conn->close();
        exit;
    }
    
    // Prepare base query according to user's role:
    // If admin (role 3), no additional condition.
    // If client (role 1), order must have client_id = current user.
    // If tutor (role 2), order must have tutor_id = current user.
    $found = false;
    $tables = ["orders", "completed", "clarification"];
    foreach ($tables as $tbl) {
        if ($currentRole == 1) {
            $sql = "SELECT order_id FROM $tbl WHERE order_id = ? AND client_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $order_id, $currentUser);
        } elseif ($currentRole == 2) {
            $sql = "SELECT order_id FROM $tbl WHERE order_id = ? AND tutor_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $order_id, $currentUser);
        } else { // admin or if role not set
            $sql = "SELECT order_id FROM $tbl WHERE order_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $order_id);
        }
        if(!$stmt) continue;
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $found = true;
            $stmt->close();
            break;
        }
        $stmt->close();
    }
    if ($found) {
        echo json_encode(["success" => true, "message" => "Order found: " . $order_id]);
    } else {
        echo json_encode(["success" => false, "message" => "Order not found or does not belong to you"]);
    }
    $conn->close();
    exit;
} elseif ($action === "update") {
    // Update the user's balance and insert a feedback record including order_id.
    $input = json_decode(file_get_contents('php://input'), true);
    $user_id = $input['user_id'] ?? null;
    $update_amount = $input['update_amount'] ?? null;
    $reason = $input['reason'] ?? "";
    $order_id_feedback = $input['order_id'] ?? "";
    if ($user_id === null || $update_amount === null) {
        echo json_encode(["success" => false, "message" => "Missing parameters"]);
        $conn->close();
        exit;
    }
    // Get current balance (if exists).
    $sql = "SELECT balance FROM balance WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($current_balance);
    if (!$stmt->fetch()) {
        $current_balance = 0;
        $stmt->close();
        $sqlInsert = "INSERT INTO balance (user_id, balance) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param("id", $user_id, $current_balance);
        $stmtInsert->execute();
        $stmtInsert->close();
    } else {
        $stmt->close();
    }
    $new_balance = $current_balance + $update_amount;
    $sqlUpdate = "UPDATE balance SET balance = ? WHERE user_id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("di", $new_balance, $user_id);
    if ($stmtUpdate->execute()) {
        $feedbackMessage = "Balance updated by " . $update_amount . ". Reason: " . $reason;
        $sqlFeedback = "INSERT INTO feedback (UserID, FeedbackMessage, order_id) VALUES (?, ?, ?)";
        $stmtFeedback = $conn->prepare($sqlFeedback);
        $stmtFeedback->bind_param("iss", $user_id, $feedbackMessage, $order_id_feedback);
        $stmtFeedback->execute();
        $stmtFeedback->close();
        echo json_encode(["success" => true, "message" => "Balance updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update balance."]);
    }
    $stmtUpdate->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
