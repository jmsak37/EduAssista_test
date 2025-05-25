<?php
// admin_edit_user.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$userID = $_POST['userID'];
$username = $_POST['username'];
$email = $_POST['email'];
$roleID = $_POST['roleID'];

// Check if the email already exists for a different user
$sql_check = "SELECT UserID FROM Users WHERE Email = ? AND UserID != ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("si", $email, $userID);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email already exists."]);
    exit();
}

// Update user information
$sql = "UPDATE Users SET UserName = ?, Email = ?, RoleID = ? WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssii", $username, $email, $roleID, $userID);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "User updated successfully."]);
} else {
    echo json_encode(["success" => false, "message" => "Error updating user: " . $conn->error]);
}

$stmt->close();
$conn->close();
?>
