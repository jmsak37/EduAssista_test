<?php
header('Content-Type: application/json');
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "eduassistadb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if($conn->connect_error){
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

$action = $_GET['action'] ?? '';

if($action === "list"){
    // Retrieve all users with RoleID = 3 from the users table.
    $sql = "SELECT UserID, UserName, Email FROM users WHERE RoleID = 3";
    $result = $conn->query($sql);
    $users = [];
    if($result){
        while($row = $result->fetch_assoc()){
            $users[] = $row;
        }
        echo json_encode(["success" => true, "users" => $users]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve users"]);
    }
    $conn->close();
    exit;
} elseif($action === "assign"){
    // Read JSON input.
    $input = json_decode(file_get_contents('php://input'), true);
    $userID = $input['userID'] ?? null;
    $adminRule = $input['adminRule'] ?? null;
    
    if(!$userID || !$adminRule){
        echo json_encode(["success" => false, "message" => "Missing parameters"]);
        $conn->close();
        exit;
    }
    
    // Insert or update the adminrule table.
    $sql = "INSERT INTO adminrule (UserID, AdminRuleID) VALUES (?, ?)
            ON DUPLICATE KEY UPDATE AdminRuleID = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt){
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("iss", $userID, $adminRule, $adminRule);
    if($stmt->execute()){
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Execution failed: " . $stmt->error]);
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
