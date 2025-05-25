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

// Fetch distinct Expertise Areas
$sql = "SELECT DISTINCT ExpertiseArea FROM subjects ORDER BY ExpertiseArea ASC";
$result = $conn->query($sql);

$expertiseAreas = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Ensure expertise areas are trimmed and formatted correctly
        $areas = explode("/", $row["ExpertiseArea"]);
        foreach ($areas as $area) {
            $trimmedArea = trim($area);
            if (!in_array($trimmedArea, $expertiseAreas)) {
                $expertiseAreas[] = $trimmedArea;
            }
        }
    }
}

// Close connection
$conn->close();

// Return JSON response
echo json_encode($expertiseAreas);
?>
