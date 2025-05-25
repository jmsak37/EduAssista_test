<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

// Ensure the user is logged in
if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userID = $_SESSION['userID'];

// NEW CODE: Check if the tutor has 5 or more undone orders from the progress table (status = "beingdone")
$sqlUndone = "SELECT COUNT(*) AS undoneCount FROM orders WHERE tutor_id = ? AND status = 'beingdone'";
$stmtUndone = $conn->prepare($sqlUndone);
$stmtUndone->bind_param("i", $userID);
$stmtUndone->execute();
$resultUndone = $stmtUndone->get_result();
$rowUndone = $resultUndone->fetch_assoc();
$undoneCount = $rowUndone['undoneCount'];
$stmtUndone->close();

if ($undoneCount >= 5) {
    echo json_encode([
        "error" => "You have more than 5 undone orders. Please handle your pending orders first.",
        "redirect" => "undone.html"
    ]);
    $conn->close();
    exit();
}

// Fetch subjects and the tutor’s expertise area using a join
$sql = "SELECT s.SubjectID, s.Subject, t.ExpertiseArea 
        FROM tutor_subjects ts
        JOIN subjects s ON ts.SubjectID = s.SubjectID
        JOIN tutors t ON ts.TutorID = t.TutorID
        WHERE t.UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode($subjects);
?>
