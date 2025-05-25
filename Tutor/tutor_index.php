<?php
session_start();
header('Content-Type: application/json');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "EduAssistaDB";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

if (!isset($_SESSION['userID'])) {
    echo json_encode(["error" => "User not logged in"]);
    exit();
}

$userID = $_SESSION['userID'];

// 1. Fetch username from Users table
$sql = "SELECT UserName FROM Users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

// 2. Fetch rating from ratings table
$sql = "SELECT SUM(CASE WHEN rating_status = 'helpful' THEN 1 ELSE 0 END) AS helpful,
               SUM(CASE WHEN rating_status IN ('helpful', 'unhelpful') THEN 1 ELSE 0 END) AS total
        FROM ratings WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->bind_result($helpful, $total);
$stmt->fetch();
$stmt->close();
$rating = ($total > 0) ? ($helpful / $total) * 100 : 100;
$ratingMessage = ($rating < 85) ? "Your rating is below average. Your account may be terminated." 
                : (($rating == 85) ? "You are at the average level." 
                : "You are above average! Keep up the good work.");

// 3. Fetch balance from balance table. If not exists, insert with balance 0.00.
$sql = "SELECT balance FROM balance WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userID);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->bind_result($balance);
    $stmt->fetch();
    $stmt->close();
} else {
    $stmt->close();
    $insertSql = "INSERT INTO balance (user_id, balance) VALUES (?, 0.00)";
    $insertStmt = $conn->prepare($insertSql);
    $insertStmt->bind_param("i", $userID);
    $insertStmt->execute();
    $insertStmt->close();
    $balance = 0.00;
}

// 4. NEW CODE: Compute Available Balance from the completed table.
//   (Orders with tutor_id = $userID, status = 'completed', and updated_at at least 14 days old)
$sqlAvail = "SELECT SUM(number_of_pages) AS totalPages 
             FROM completed 
             WHERE tutor_id = ? AND status = 'completed' AND updated_at <= DATE_SUB(NOW(), INTERVAL 14 DAY)";
$stmtAvail = $conn->prepare($sqlAvail);
$stmtAvail->bind_param("i", $userID);
$stmtAvail->execute();
$stmtAvail->bind_result($totalPages);
$stmtAvail->fetch();
$stmtAvail->close();
if ($totalPages === null) {
    $totalPages = 0;
}
$availableBalance = $totalPages * 2; // Multiply sum of pages by 2
$pendingBalance = $balance - $availableBalance;
if ($pendingBalance < 0) { 
    $pendingBalance = 0; 
}

// --- NEW CODE: Fetch Clarification orders count ---
$sqlClar = "SELECT 
    (SELECT COUNT(*) FROM clarification WHERE tutor_id = ?) + 
    (SELECT COUNT(*) FROM progressa WHERE tutor_id = ?) AS clarificationCount";
$stmtClar = $conn->prepare($sqlClar);
if ($stmtClar) {
    $stmtClar->bind_param("ii", $userID, $userID);
    $stmtClar->execute();
    $stmtClar->bind_result($clarificationCount);
    $stmtClar->fetch();
    $stmtClar->close();
} else {
    $clarificationCount = 0;
}

// --- NEW CODE: Fetch Request orders count from request table ---
$sqlReq = "SELECT COUNT(*) FROM request WHERE tutor_id = ?";
$stmtReq = $conn->prepare($sqlReq);
if ($stmtReq) {
    $stmtReq->bind_param("i", $userID);
    $stmtReq->execute();
    $stmtReq->bind_result($requestCount);
    $stmtReq->fetch();
    $stmtReq->close();
} else {
    $requestCount = 0;
}

$conn->close();

echo json_encode([
    "username" => $username,
    "rating" => round($rating, 2),
    "ratingMessage" => $ratingMessage,
    "balance" => round($balance, 2),
    "availableBalance" => round($availableBalance, 2),
    "pendingBalance" => round($pendingBalance, 2),
    "clarificationCount" => $clarificationCount,
    "requestCount" => $requestCount,
    "userID" => $userID  // so the HTML can use it for links
]);
?>
