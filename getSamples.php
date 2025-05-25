<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['error' => 'Connection failed: ' . $conn->connect_error]);
    exit();
}

// Fetch the latest samples
$sql = "SELECT SampleName, SampleDescription, CreatedAt FROM Samples ORDER BY CreatedAt DESC";
$result = $conn->query($sql);

if ($result === false) {
    echo json_encode(['error' => 'Query error: ' . $conn->error]);
    $conn->close();
    exit();
}

$samples = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $samples[] = $row;
    }
}

echo json_encode($samples);

$conn->close();
?>
