<?php
session_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 0);

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
    echo json_encode(["error" => "Database connection failed: " . $conn->connect_error]);
    exit();
}

if(!isset($_SESSION['userID'])){
    echo json_encode(["error" => "Tutor not logged in"]);
    exit();
}
$tutor_id = $_SESSION['userID'];

// Fetch orders from progress table (work in progress)
$progress = [];
$queryProgress = "SELECT * FROM progress WHERE tutor_id = ?";
$stmtProgress = $conn->prepare($queryProgress);
$stmtProgress->bind_param("i", $tutor_id);
$stmtProgress->execute();
$resultProgress = $stmtProgress->get_result();
while($row = $resultProgress->fetch_assoc()){
    $progress[] = $row;
}
$stmtProgress->close();

// Fetch orders from completed table
$completed = [];
$queryCompleted = "SELECT * FROM completed WHERE tutor_id = ?";
$stmtCompleted = $conn->prepare($queryCompleted);
$stmtCompleted->bind_param("i", $tutor_id);
$stmtCompleted->execute();
$resultCompleted = $stmtCompleted->get_result();
while($row = $resultCompleted->fetch_assoc()){
    $completed[] = $row;
}
$stmtCompleted->close();

$conn->close();

echo json_encode([
    "progress" => $progress,
    "completed" => $completed
]);
?>
