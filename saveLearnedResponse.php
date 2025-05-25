<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $question = trim($data['question']);
    $reply = trim($data['reply']);
    // Append the learned Q/A pair to responses.txt.
    file_put_contents('responses.txt', $question . ": " . $reply . PHP_EOL, FILE_APPEND);
    echo "Learned response saved.";
}
?>
