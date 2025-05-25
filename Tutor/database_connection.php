<?php
$host = 'localhost'; // Use '127.0.0.1' if localhost doesn't work
$username = 'root';
$password = ''; // Default XAMPP password is empty
$database = 'eduassistadb';

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
