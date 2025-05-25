<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $userInput = $data['userInput'];
    // Get email if provided (for support chat), otherwise set to empty.
    $email = isset($data['email']) ? $data['email'] : '';

    // Save the unknown question to the file.
    file_put_contents('unknown.txt', $userInput . PHP_EOL, FILE_APPEND);

    // Determine the user ID. If a session user exists, use it; otherwise generate a guest ID.
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        if (isset($_SESSION['guest_id'])) {
            $user_id = $_SESSION['guest_id'];
        } else {
            $user_id = 'guest' . bin2hex(random_bytes(4));
            $_SESSION['guest_id'] = $user_id;
        }
    }

    // Insert the unknown question into the "questions" table.
    $mysqli = new mysqli("localhost", "root", "", "EduAssistaDB");
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    $stmt = $mysqli->prepare("INSERT INTO questions (QuestionText, Reply, UserID, Email, Date) VALUES (?, '', ?, ?, NOW())");
    $stmt->bind_param("sss", $userInput, $user_id, $email);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

    echo "Unknown response saved successfully.";
}
?>
