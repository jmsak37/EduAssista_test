<?php
// Start session to check if the admin is logged in
session_start();
require_once 'database_connection.php'; // Include the database connection

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) { // Assuming roleID 3 is for Admin
    header("Location: admin_login.php");
    exit();
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Initialize error message
$errorMsg = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $roleID = intval($_POST['role']);

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($password) || empty($roleID)) {
        header("Location: add_user_form.html?status=error&message=All%20fields%20are%20required.");
        exit();
    }

    // Check if the email already exists in the database
    $checkEmailQuery = "SELECT * FROM Users WHERE Email = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, show error message
        header("Location: add_user_form.html?status=exists");
        exit();
    }

    // Hash the password for security
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Prepare SQL to insert new user
    $sql = "INSERT INTO Users (RoleID, UserName, Email, PasswordHash) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $roleID, $username, $email, $passwordHash);

    if ($stmt->execute()) {
        // Redirect to add user form with a success status
        header("Location: add_user_form.html?status=success");
        exit();
    } else {
        // Show error message if there's an issue inserting the user
        header("Location: add_user_form.html?status=error&message=" . urlencode("Error adding user: " . $stmt->error));
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
