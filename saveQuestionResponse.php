<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);
    $question = $data['question'];
    $response = $data['response'];

    // Save the response
    file_put_contents('responses.txt', "$question: $response" . PHP_EOL, FILE_APPEND);

    // Remove the question from unknown.txt
    if (file_exists('unknown.txt')) {
        $questions = file('unknown.txt', FILE_IGNORE_NEW_LINES);
        $updatedQuestions = array_filter($questions, function($q) use ($question) {
            return trim($q) !== trim($question);
        });
        file_put_contents('unknown.txt', implode(PHP_EOL, $updatedQuestions) . PHP_EOL);
    }

    echo "Question response saved and question removed from unknown.txt.";
}
?>
