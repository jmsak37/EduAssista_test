<?php
$servername = "localhost";
$username = "root";
$password = ""; // Replace with your database password
$dbname = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to handle file upload
function handleFileUpload($file, $uploadDir, $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    $fileName = basename($file['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    if (!in_array($fileExt, $allowedTypes)) {
        return false;
    }

    $targetFile = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        return $fileName;
    }

    return false;
}

// Process form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uploadDir = 'uploads/'; // Directory where files will be uploaded
    $blogFileName = '';
    $sampleFileName = '';

    // Check if form is for submitting a blog
    if (isset($_POST['submitBlog'])) {
        $blogTitle = $conn->real_escape_string($_POST['blogTitle']);
        $blogContent = $conn->real_escape_string($_POST['blogContent']);
        $authorID = intval($_POST['authorID']);

        // Handle file upload if a file was uploaded
        if (isset($_FILES['blogFile']) && $_FILES['blogFile']['error'] == UPLOAD_ERR_OK) {
            $blogFileName = handleFileUpload($_FILES['blogFile'], $uploadDir);
        }

        // Check if AuthorID exists in Users table
        $stmt = $conn->prepare("SELECT UserID FROM Users WHERE UserID = ?");
        $stmt->bind_param("i", $authorID);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            echo "Error: Author ID does not exist in Users table.<br>";
        } else {
            $stmt = $conn->prepare("INSERT INTO Blogs (BlogTitle, BlogContent, AuthorID, CreatedAt) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("ssi", $blogTitle, $blogContent, $authorID);
            if ($stmt->execute()) {
                echo "New blog record created successfully.<br>";
            } else {
                echo "Error: " . $stmt->error . "<br>";
            }
        }
        $stmt->close();
    }

    // Check if form is for submitting a sample
    if (isset($_POST['submitSample'])) {
        $sampleName = $conn->real_escape_string($_POST['sampleName']);
        $sampleDescription = $conn->real_escape_string($_POST['sampleDescription']);

        // Handle file upload if a file was uploaded
        if (isset($_FILES['sampleFile']) && $_FILES['sampleFile']['error'] == UPLOAD_ERR_OK) {
            $sampleFileName = handleFileUpload($_FILES['sampleFile'], $uploadDir);
        }

        $stmt = $conn->prepare("INSERT INTO Samples (SampleName, SampleDescription, CreatedAt) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $sampleName, $sampleDescription);
        if ($stmt->execute()) {
            echo "New sample record created successfully.<br>";
        } else {
            echo "Error: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }
}

$conn->close();
?>
