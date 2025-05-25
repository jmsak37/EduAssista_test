<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$user_name = $_POST['username'];
$email = $_POST['email'];
$email_confirm = $_POST['email_confirm'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

// Validate email and password confirmation
if ($email !== $email_confirm) {
    header("Location: register.html?status=email_mismatch");
    exit;
}

if ($password !== $password_confirm) {
    header("Location: register.html?status=password_mismatch");
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password

// Check if admin already exists
$sql = "SELECT * FROM Users WHERE Email = ? AND RoleID = (SELECT RoleID FROM Roles WHERE RoleName = 'admin')";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Admin already exists
    header("Location: register.html?status=admin_exists");
} else {
    // Add new admin
    $sql = "INSERT INTO Users (RoleID, UserName, Email, PasswordHash) VALUES ((SELECT RoleID FROM Roles WHERE RoleName = 'admin'), ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $user_name, $email, $password_hash);

    if ($stmt->execute()) {
        header("Location: register.html?status=success");
    } else {
        header("Location: register.html?status=error");
    }
}

$stmt->close();
$conn->close();
?>
