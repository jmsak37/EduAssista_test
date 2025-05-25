<?php
$mysqli = new mysqli("localhost", "root", "", "EduAssistaDB");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$email = isset($_GET['email']) ? $_GET['email'] : '';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 10;
$offset = ($page - 1) * $limit;
$chats = [];

if ($email !== '') {
    $stmt = $mysqli->prepare("SELECT QuestionText, Reply, Date FROM questions WHERE Email = ? ORDER BY Date DESC LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $email, $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $chats[] = $row;
    }
    $stmt->close();
}
$mysqli->close();

header('Content-Type: application/json');
echo json_encode($chats);
?>
