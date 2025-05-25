<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    echo json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error));
    exit();
}

// If this is a POST request, update the user’s session status.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['action']) && $_POST['action'] === 'markOut' && isset($_POST['UserID'])){
        $UserID = intval($_POST['UserID']);
        $stmt = $conn->prepare("UPDATE Users SET status = 'out of session' WHERE UserID = ? AND RoleID = 1");
        $stmt->bind_param("i", $UserID);
        if($stmt->execute()){
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to update status."));
        }
        $stmt->close();
        exit();
    } else {
        echo json_encode(array("status" => "error", "message" => "Invalid request."));
        exit();
    }
}

// If this is a GET request, fetch all users with RoleID = 1.
$sql = "SELECT UserID, UserName, status FROM Users WHERE RoleID = 1";
$result = $conn->query($sql);
$users = array();
if($result){
    while($row = $result->fetch_assoc()){
        $users[] = $row;
    }
    echo json_encode(array("status" => "success", "users" => $users));
} else {
    echo json_encode(array("status" => "error", "message" => "Error retrieving records."));
}
$conn->close();
?>
