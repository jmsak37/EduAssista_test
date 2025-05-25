<?php
session_start();
// Optionally enforce that only admin users may access this page.
// if(!isset($_SESSION['roleID']) || $_SESSION['roleID'] != 3){
//     echo json_encode(array("status" => "error", "message" => "Access denied."));
//     exit();
// }

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Connection failed: " . $conn->connect_error)));
}

// Handle POST actions: restrict, unrestrict, update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST['action']) && isset($_POST['UserID'])) {
        $action = $_POST['action'];
        $UserID = intval($_POST['UserID']);
        if($action === 'restrict') {
            $stmt = $conn->prepare("INSERT INTO `restrict` (UserID, RestrictDate) VALUES (?, NOW())");
            $stmt->bind_param("i", $UserID);
            if($stmt->execute()){
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to restrict user."));
            }
            $stmt->close();
            exit();
        }
        if($action === 'unrestrict') {
            $stmt = $conn->prepare("DELETE FROM `restrict` WHERE UserID = ?");
            $stmt->bind_param("i", $UserID);
            if($stmt->execute()){
                echo json_encode(array("status" => "success"));
            } else {
                echo json_encode(array("status" => "error", "message" => "Failed to unrestrict user."));
            }
            $stmt->close();
            exit();
        }
        if($action === 'update') {
            if(isset($_POST['EducationalLevel']) && isset($_POST['PreferredSubject'])) {
                $EducationalLevel = $_POST['EducationalLevel'];
                $PreferredSubject = $_POST['PreferredSubject'];
                $stmt = $conn->prepare("UPDATE clients SET EducationalLevel = ?, PreferredSubject = ?, updated_at = NOW() WHERE UserID = ?");
                $stmt->bind_param("ssi", $EducationalLevel, $PreferredSubject, $UserID);
                if($stmt->execute()){
                    echo json_encode(array("status" => "success"));
                } else {
                    echo json_encode(array("status" => "error", "message" => "Failed to update client info."));
                }
                $stmt->close();
                exit();
            } else {
                echo json_encode(array("status" => "error", "message" => "Missing data for update."));
                exit();
            }
        }
    }
    exit();
}

// For GET, fetch all clients joined with details from the users table.
$sql = "SELECT c.UserID, c.EducationalLevel, c.PreferredSubject, c.created_at, c.updated_at, 
        u.UserName, u.Email, u.RoleID, u.CreatedAt as userCreated, u.UpdatedAt as userUpdated 
        FROM clients c 
        JOIN users u ON c.UserID = u.UserID";
$result = $conn->query($sql);
$clients = array();
if($result) {
    while($row = $result->fetch_assoc()) {
        // Check if the user is restricted
        $stmt = $conn->prepare("SELECT RestrictID FROM `restrict` WHERE UserID = ?");
        $stmt->bind_param("i", $row['UserID']);
        $stmt->execute();
        $stmt->store_result();
        $row['restricted'] = ($stmt->num_rows > 0) ? true : false;
        $stmt->close();
        $clients[] = $row;
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Error retrieving client records."));
    exit();
}
echo json_encode(array("status" => "success", "clients" => $clients));
$conn->close();
?>
