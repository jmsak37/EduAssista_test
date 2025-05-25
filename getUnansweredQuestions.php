<?php
$questions = [];

if (file_exists('unknown.txt')) {
    $file = fopen('unknown.txt', 'r');
    while (($line = fgets($file)) !== false) {
        $questions[] = trim($line);
    }
    fclose($file);
}

header('Content-Type: application/json');
echo json_encode(['questions' => $questions]);
?>
