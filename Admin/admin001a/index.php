<?php
session_start();

// When called with ?action=getUsername, return the username as JSON.
if(isset($_GET['action']) && $_GET['action'] === 'getUsername') {
    header('Content-Type: application/json');
    
    // Check if user is logged in and is an admin (RoleID 3)
    if(!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
        echo json_encode(["error" => "Not authorized"]);
        exit;
    }
    
    // Database connection details
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "eduassistadb";
    
    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
    if($conn->connect_error) {
        echo json_encode(["error" => "Database connection error"]);
        exit;
    }
    
    $userID = $_SESSION['userID'];
    
    // Check if the user has an AdminRuleID in the adminrule table.
    $sql = "SELECT AdminRuleID FROM adminrule WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($adminRuleID);
    $hasAdminRule = $stmt->fetch();
    $stmt->close();
    
    if(!$hasAdminRule) {
        // If no admin rule is assigned, instruct client to redirect to dashboard.html.
        echo json_encode(["redirect" => "../dashboard.html"]);
        $conn->close();
        exit;
    }
    
    // Retrieve the username from the users table.
    $sql = "SELECT UserName FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($userName);
    $stmt->fetch();
    $stmt->close();
    $conn->close();
    
    echo json_encode(["userName" => $userName]);
    exit;
}

// Handle other session-check actions (if needed)
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

$response = ['loggedIn' => isset($_SESSION['userID']) && $_SESSION['roleID'] == 3];

if ($action === 'check_session') {
    $response['loggedIn'] = isset($_SESSION['userID']) && $_SESSION['roleID'] == 3;
} elseif ($action === 'keep_alive' && $response['loggedIn']) {
    $_SESSION['last_activity'] = time();
    $response['loggedIn'] = true;
} elseif ($action === 'logout_due_to_inactivity') {
    session_unset();
    session_destroy();
    $response['loggedIn'] = false;
    $response['message'] = 'Logged out due to inactivity';
} else {
    $response['loggedIn'] = false;
    $response['message'] = 'Invalid session or action';
}

echo json_encode($response);
?>
