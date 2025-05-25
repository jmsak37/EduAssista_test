<?php
session_start();

// Database connection settings
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "eduassistadb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    http_response_code(403);
    echo json_encode(["error" => "Access denied"]);
    exit();
}

header('Content-Type: application/json');

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userID = intval($_POST['delete_user_id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        echo json_encode(["success" => "User deleted successfully"]);
    } else {
        echo json_encode(["error" => "Failed to delete user"]);
    }
    $stmt->close();
    $conn->close();
    exit();
}

// For GET requests, return the list of users in JSON format
function getAllUsers($conn) {
    $sql = "SELECT Users.UserID, Users.UserName, Users.Email, Roles.RoleName, Users.CreatedAt
            FROM Users
            JOIN Roles ON Users.RoleID = Roles.RoleID
            ORDER BY Users.CreatedAt DESC";
    $result = $conn->query($sql);
    $users = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

$users = getAllUsers($conn);
echo json_encode($users);
$conn->close();
?>
