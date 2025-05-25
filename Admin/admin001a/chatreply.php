<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$QuestionID = $_GET['QuestionID'] ?? '';
if (empty($QuestionID)) {
    echo json_encode(["success" => false, "message" => "QuestionID is required"]);
    $conn->close();
    exit;
}

// Get the sender's email for the given QuestionID.
$sql = "SELECT Email FROM questions WHERE QuestionID = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}
$stmt->bind_param("i", $QuestionID);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $email = $row['Email'];
} else {
    echo json_encode(["success" => false, "message" => "Question not found"]);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Fetch all questions for that email.
$sql = "SELECT QuestionID, QuestionText, Reply, UserID, Date, Email FROM questions WHERE Email = ? ORDER BY Date ASC";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
    $conn->close();
    exit;
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$conversation = [];
while ($row = $result->fetch_assoc()) {
    $conversation[] = $row;
}
echo json_encode(["success" => true, "conversation" => $conversation]);
$stmt->close();
$conn->close();
?>
