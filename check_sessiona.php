<?php
session_start();
header('Content-Type: application/json');

// If the user is not logged in, return false.
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["inSession" => false, "reason" => "No active session."]);
    exit;
}

$userID = $_SESSION['user_id'];

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["inSession" => false, "reason" => "Database connection error."]);
    exit;
}

// Retrieve the RoleID and status from the users table.
$sql = "SELECT RoleID, status FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($roleID, $status);
if (!$stmt->fetch()) {
    echo json_encode(["inSession" => false, "reason" => "User not found in users table."]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Normalize status: remove spaces and parentheses, then convert to lowercase.
$statusNormalized = strtolower(trim($status));
$statusNormalized = str_replace([" ", "(", ")"], "", $statusNormalized);

// Check if the user's status is "insession".
if ($statusNormalized !== "insession") {
    echo json_encode(["inSession" => false, "reason" => "User status is not insession."]);
    $conn->close();
    exit;
}

// Check if the user exists in the usersession table in any of the columns.
$sql = "SELECT * FROM usersession WHERE client_id = ? OR tutor_id = ? OR admin_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $userID, $userID, $userID);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    echo json_encode(["inSession" => true]);
} else {
    echo json_encode(["inSession" => false, "reason" => "User not found in usersession."]);
}
$stmt->close();
$conn->close();
?>
