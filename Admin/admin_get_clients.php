<?php
session_start();
require_once 'database_connection.php';

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Function to get all clients from the database
function getAllClients($conn) {
    $sql = "SELECT Clients.ClientID, Users.UserName, Users.Email, Clients.EducationalLevel, Clients.PreferredSubject, Users.CreatedAt
            FROM Clients
            JOIN Users ON Clients.UserID = Users.UserID
            ORDER BY Users.CreatedAt DESC";
    $result = $conn->query($sql);
    $clients = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $clients[] = $row;
        }
    }
    return $clients;
}

$clients = getAllClients($conn);
$conn->close();

header('Content-Type: application/json');
echo json_encode($clients);
?>
