<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password is empty
$database = "eduassistadb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Get expertise level from request
if (!isset($_GET['level']) || empty($_GET['level'])) {
    die(json_encode(["error" => "No expertise level provided"]));
}

$selectedLevel = trim($_GET['level']);

// Fetch subjects where ExpertiseArea matches (also checking partial matches for multi-name expertise)
$sql = "SELECT Subject FROM subjects WHERE FIND_IN_SET('$selectedLevel', REPLACE(ExpertiseArea, ' / ', ','))";
$result = $conn->query($sql);

$subjects = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subjects[] = $row["Subject"];
    }
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($subjects);
?>
