<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    $sql = "SELECT QuestionID, QuestionText, Reply, UserID, Date, Email FROM questions ORDER BY Date ASC";
    $result = $conn->query($sql);
    $questions = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $questions[] = $row;
        }
        echo json_encode(["success" => true, "questions" => $questions]);
    } else {
        echo json_encode(["success" => false, "message" => "Error fetching questions: " . $conn->error]);
    }
    $conn->close();
    exit;
} elseif ($action === "update") {
    $QuestionID = $_POST['QuestionID'] ?? '';
    $Reply = $_POST['Reply'] ?? '';
    if (empty($QuestionID)) {
        echo json_encode(["success" => false, "message" => "QuestionID is required"]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE questions SET Reply = ? WHERE QuestionID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("si", $Reply, $QuestionID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reply updated successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Update failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "delete") {
    $QuestionID = $_GET['QuestionID'] ?? '';
    if (empty($QuestionID)) {
        echo json_encode(["success" => false, "message" => "QuestionID is required"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM questions WHERE QuestionID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $QuestionID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Question deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Delete failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "getUser") {
    $UserID = $_GET['UserID'] ?? '';
    if (empty($UserID)) {
        echo json_encode(["success" => false, "message" => "UserID is required"]);
        $conn->close();
        exit;
    }
    $sql = "SELECT UserID, UserName, RoleID FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $UserID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        $role = "unknown";
        if ($user['RoleID'] == 1) { $role = "client"; }
        elseif ($user['RoleID'] == 2) { $role = "tutor"; }
        elseif ($user['RoleID'] == 3) { $role = "admin"; }
        $user['role'] = $role;
        echo json_encode(["success" => true, "user" => $user]);
    } else {
        echo json_encode(["success" => false, "message" => "User not found"]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "getConversation") {
    // Given a QuestionID, fetch the sender's email and then all questions for that email.
    $QuestionID = $_GET['QuestionID'] ?? '';
    if (empty($QuestionID)) {
        echo json_encode(["success" => false, "message" => "QuestionID is required"]);
        $conn->close();
        exit;
    }
    // Get email for the given QuestionID.
    $sql = "SELECT Email FROM questions WHERE QuestionID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $QuestionID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $email = $row['Email'];
    } else {
        echo json_encode(["success" => false, "message" => "Question not found"]);
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();
    // Fetch all questions for this email.
    $sql = "SELECT QuestionID, QuestionText, Reply, UserID, Date, Email FROM questions WHERE Email = ? ORDER BY Date ASC";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $conversation = [];
    while ($row = $result->fetch_assoc()) {
        $conversation[] = $row;
    }
    echo json_encode(["success" => true, "conversation" => $conversation]);
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "deleteConversation") {
    // Delete all questions for a given email.
    $Email = $_GET['Email'] ?? '';
    if (empty($Email)) {
        echo json_encode(["success" => false, "message" => "Email is required"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM questions WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $Email);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Conversation deleted successfully"]);
    } else {
        echo json_encode(["success" => false, "message" => "Delete failed: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
