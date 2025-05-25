<?php
header('Content-Type: application/json');

// Database credentials
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

// Query to get blogs
$sql = "SELECT BlogID, BlogTitle, BlogContent, CreatedAt FROM Blogs ORDER BY CreatedAt DESC";
$result = $conn->query($sql);

$blogs = array();

if ($result->num_rows > 0) {
    // Fetch data
    while($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
}

// Output data in JSON format
echo json_encode($blogs);

$conn->close();
?>
