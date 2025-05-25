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
$educational_level = $_POST['educational_level'];
$preferred_subject = $_POST['preferred_subject'];

// Validate email and password confirmation
if ($email !== $email_confirm) {
    header("Location: register_client.html?status=email_mismatch");
    exit;
}

if ($password !== $password_confirm) {
    header("Location: register_client.html?status=password_mismatch");
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT); // Hash the password

// Check if email or username already exists
$sql = "SELECT * FROM Users WHERE Email = ? OR UserName = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $email, $user_name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Display existing details
    $existing_user = $result->fetch_assoc();
    $existing_email = $existing_user['Email'];
    $existing_username = $existing_user['UserName'];

    // Redirect with existing details
    header("Location: register_client.html?status=exists&email=" . urlencode($existing_email) . "&username=" . urlencode($existing_username));
} else {
    // Add new client
    $sql = "INSERT INTO Users (RoleID, UserName, Email, PasswordHash) VALUES ((SELECT RoleID FROM Roles WHERE RoleName = 'client'), ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $user_name, $email, $password_hash);

    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        $sql = "INSERT INTO Clients (UserID, EducationalLevel, PreferredSubject) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $user_id, $educational_level, $preferred_subject);

        if ($stmt->execute()) {
            // Redirect to the success page (success2.html)
            header("Location: success2.html");
        } else {
            header("Location: register_client.html?status=error");
        }
    } else {
        header("Location: register_client.html?status=error");
    }
}

$stmt->close();
$conn->close();
?>
