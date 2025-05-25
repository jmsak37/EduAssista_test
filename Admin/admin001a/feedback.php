<?php
session_start();
header('Content-Type: application/json');
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if($conn->connect_error){
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

$action = $_GET['action'] ?? '';

if($action === "list"){
    // List all feedback records.
    $sql = "SELECT UserID, FeedbackID, FeedbackMessage, order_id FROM feedback";
    $result = $conn->query($sql);
    $feedback = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $feedback[] = $row;
        }
        echo json_encode(["success" => true, "feedback" => $feedback]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve feedback"]);
    }
    $conn->close();
    exit;
} elseif($action === "viewUser"){
    // Return user details from the users table.
    $user_id = $_GET['user_id'] ?? '';
    if(!$user_id){
        echo json_encode(["success" => false, "message" => "Missing user_id"]);
        $conn->close();
        exit;
    }
    $sql = "SELECT UserID, RoleID, UserName, Email, CreatedAt, UpdatedAt FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    if($stmt->execute()){
        $result = $stmt->get_result();
        if($user = $result->fetch_assoc()){
            $role = "";
            if($user['RoleID'] == 1){
                $role = "client";
            } elseif($user['RoleID'] == 2){
                $role = "tutor";
            } elseif($user['RoleID'] == 3){
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
} elseif($action === "update"){
    // Update a feedback record (FeedbackMessage).
    // Expecting POST data: feedback_id, feedback_message.
    $feedback_id = $_POST['feedback_id'] ?? null;
    $feedback_message = $_POST['feedback_message'] ?? "";
    if($feedback_id === null){
        echo json_encode(["success" => false, "message" => "Missing feedback_id"]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE feedback SET FeedbackMessage = ? WHERE FeedbackID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $feedback_message, $feedback_id);
    if($stmt->execute()){
        echo json_encode(["success" => true, "message" => "Feedback updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update feedback"]);
    }
    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
