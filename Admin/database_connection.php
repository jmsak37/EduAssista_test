<?php
// database_connection.php

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

// Define a function to close the connection if needed
function closeConnection($conn) {
    if ($conn) {
        $conn->close();
    }
}
?>
