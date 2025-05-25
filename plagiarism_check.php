<?php
header('Content-Type: application/json');

// Replace this with actual plagiarism checking logic
function checkPlagiarism($text) {
    // Simulate a plagiarism check with a percentage
    // In reality, integrate with a plagiarism detection service here
    $percentage = rand(0, 100); // Randomly generate a percentage for simulation
    return $percentage . '%';
}

$response = ['success' => false, 'message' => 'No data provided.'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['textContent'])) {
        // Check plagiarism for text content
        $textContent = $_POST['textContent'];
        $result = checkPlagiarism($textContent);
        $response = ['success' => true, 'message' => $result];
    } elseif (!empty($_FILES['fileUpload']['tmp_name'])) {
        // Handle file upload
        $fileTmpName = $_FILES['fileUpload']['tmp_name'];
        $fileContent = file_get_contents($fileTmpName);
        if ($fileContent === false) {
            $response['message'] = 'Error reading the file.';
        } else {
            $result = checkPlagiarism($fileContent);
            $response = ['success' => true, 'message' => $result];
        }
    } else {
        $response['message'] = 'No text or file uploaded.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
