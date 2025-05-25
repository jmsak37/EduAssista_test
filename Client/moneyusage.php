<?php
session_start();

// Check if the user is logged in; if not, redirect to login.
if (!isset($_SESSION['userID'])) {
    header("Location: ../login.html");
    exit;
}

$userID = $_SESSION['userID'];

// Database connection settings
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "eduassistadb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Check if the user exists in the users table and if their RoleID is 1.
$stmt = $conn->prepare("SELECT UserID, RoleID FROM users WHERE UserID = ?");
if (!$stmt) {
    die(json_encode(["error" => "Prepare failed: " . $conn->error]));
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    // No such user exists
    header("Location: ../login.html");
    exit;
}

$user = $result->fetch_assoc();
$stmt->close();

if ($user['RoleID'] != 1) {
    // The user does not have the required role.
    header("Location: ../login.html");
    exit;
}

// Now that we've confirmed the user exists and has RoleID 1,
// fetch orders from the completed table where client_id matches the user.
$stmt2 = $conn->prepare("SELECT order_id, tutor_id, subject, name, deadline, price FROM completed WHERE client_id = ?");
if (!$stmt2) {
    die(json_encode(["error" => "Prepare failed: " . $conn->error]));
}
$stmt2->bind_param("i", $userID);
$stmt2->execute();
$result2 = $stmt2->get_result();
$orders = [];

while ($row = $result2->fetch_assoc()) {
    $orders[] = $row;
}

$stmt2->close();
$conn->close();

echo json_encode(["orders" => $orders]);
?>
