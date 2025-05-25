<?php
require_once '../database_connection.php';

// Parse and validate the token
if (isset($_GET['token'])) {
    $token = base64_decode($_GET['token']);
    list($resourceID, $resourceName, $expiry) = explode('|', $token);

    // Check if the token has expired
    if (time() > $expiry) {
        die("The download link has expired.");
    }

    // Fetch the resource from the database to get the file path
    $stmt = $conn->prepare("SELECT ResourceURL FROM Resources WHERE ResourceID = ? AND ResourceName = ?");
    $stmt->bind_param("is", $resourceID, $resourceName);
    $stmt->execute();
    $stmt->bind_result($resourcePath);
    $stmt->fetch();
    $stmt->close();

    // Check if the file exists
    if (file_exists($resourcePath)) {
        // Serve the file for download
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($resourcePath) . '"');
        header('Content-Length: ' . filesize($resourcePath));
        readfile($resourcePath);
        exit;
    } else {
        die("File not found.");
    }
} else {
    die("Invalid download request.");
}
?>
