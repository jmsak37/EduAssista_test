<?php
session_start();
header('Content-Type: application/json');
error_reporting(0);

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userID = $_SESSION['userID'];

// Database connection parameters.
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

// --- Fetch User Details from Users Table ---
$queryUser = "SELECT UserID, RoleID, UserName, Email, CreatedAt, UpdatedAt FROM Users WHERE UserID = ?";
$stmtUser = $conn->prepare($queryUser);
if (!$stmtUser) {
    echo json_encode(["error" => "Failed to prepare user statement: " . $conn->error]);
    exit();
}
$stmtUser->bind_param("i", $userID);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();
if ($resultUser->num_rows == 0) {
    echo json_encode(["error" => "User not found"]);
    exit();
}
$userData = $resultUser->fetch_assoc();
$stmtUser->close();

// --- Fetch Tutor Details from tutors Table ---
$queryTutor = "SELECT TutorID, ExpertiseArea, Availability, Rating, updated_at as TutorUpdatedAt FROM tutors WHERE UserID = ? LIMIT 1";
$stmtTutor = $conn->prepare($queryTutor);
if (!$stmtTutor) {
    echo json_encode(["error" => "Failed to prepare tutor statement: " . $conn->error]);
    exit();
}
$stmtTutor->bind_param("i", $userID);
$stmtTutor->execute();
$resultTutor = $stmtTutor->get_result();
$tutorData = $resultTutor->fetch_assoc();
if (!$tutorData) {
    echo json_encode(["error" => "Tutor data not found"]);
    exit();
}
$tutorID = $tutorData['TutorID'];
$stmtTutor->close();

// --- Fetch Subject Expertise from tutor_subjects & subjects Tables ---
$querySubjects = "SELECT s.SubjectID, s.Subject, ts.SubjectName 
                  FROM tutor_subjects ts 
                  JOIN subjects s ON ts.SubjectID = s.SubjectID 
                  WHERE ts.TutorID = ?";
$stmtSubjects = $conn->prepare($querySubjects);
if (!$stmtSubjects) {
    echo json_encode(["error" => "Failed to prepare subjects statement: " . $conn->error]);
    exit();
}
$stmtSubjects->bind_param("i", $tutorID);
$stmtSubjects->execute();
$resultSubjects = $stmtSubjects->get_result();
$subjects = [];
while ($row = $resultSubjects->fetch_assoc()) {
    $subjects[] = $row;
}
$stmtSubjects->close();

// --- Fetch Ratings from ratings Table ---
$queryRatings = "SELECT rating_status FROM ratings WHERE user_id = ?";
$stmtRatings = $conn->prepare($queryRatings);
if (!$stmtRatings) {
    echo json_encode(["error" => "Failed to prepare ratings statement: " . $conn->error]);
    exit();
}
$stmtRatings->bind_param("i", $userID);
$stmtRatings->execute();
$resultRatings = $stmtRatings->get_result();
$ratings = [];
while ($row = $resultRatings->fetch_assoc()) {
    $ratings[] = $row;
}
$stmtRatings->close();

$conn->close();

// --- Combine All Data ---
$data = array_merge($userData, $tutorData);
$data['subjects'] = $subjects;
$data['ratings'] = $ratings;

// Output JSON
$json = json_encode($data);
if ($json === false) {
    $error = json_last_error_msg();
    echo json_encode(["error" => "JSON encode error: " . $error]);
    exit();
}
echo $json;
exit();
