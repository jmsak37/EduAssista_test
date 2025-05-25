<?php 
// Enable full error reporting for debugging.
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

// For testing purposes only: ensure a user is logged in.
if (!isset($_SESSION['userID'])) {
    $_SESSION['userID'] = 1; // Remove or adjust for production.
}

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "EduAssistaDB";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error: " . $conn->connect_error]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    // Retrieve blogs and join with users table to get author name.
    $sql = "SELECT b.BlogID, b.BlogTitle, b.BlogContent, b.AuthorID, b.CreatedAt, b.date, b.attarchement, u.UserName AS AuthorName
            FROM blogs b
            LEFT JOIN users u ON b.AuthorID = u.UserID
            ORDER BY b.CreatedAt DESC";
    $result = $conn->query($sql);
    if(!$result) {
        echo json_encode(["success" => false, "message" => "SQL error: " . $conn->error]);
        $conn->close();
        exit;
    }
    $blogs = [];
    while ($row = $result->fetch_assoc()) {
        $blogs[] = $row;
    }
    echo json_encode(["success" => true, "blogs" => $blogs]);
    $conn->close();
    exit;
} elseif ($action === "add") {
    // Process blog addition.
    if (!isset($_SESSION['userID'])) {
        echo json_encode(["success" => false, "message" => "Not logged in"]);
        $conn->close();
        exit;
    }
    $authorID = $_SESSION['userID'];
    $blogTitle = trim($_POST['blogTitle'] ?? '');
    $blogContent = trim($_POST['blogContent'] ?? '');
    
    $docAttached = false;
    $attachment = "";
    $originalDocName = "";
    
    // Check if attachment(s) were uploaded.
    if (isset($_FILES['attachment'])) {
        if (is_array($_FILES['attachment']['name'])) {
            $attachmentFiles = [];
            $attachmentCount = count($_FILES['attachment']['name']);
            // If more than one attachment and no title, require a title.
            if (empty($blogTitle) && $attachmentCount > 1) {
                echo json_encode(["success" => false, "message" => "Please provide a blog title if multiple attachments are uploaded."]);
                $conn->close();
                exit;
            }
            $targetDir = "blogs/";
            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0755, true)) {
                    echo json_encode(["success" => false, "message" => "Failed to create blogs folder"]);
                    $conn->close();
                    exit;
                }
            }
            for ($i = 0; $i < $attachmentCount; $i++) {
                if ($_FILES['attachment']['error'][$i] === UPLOAD_ERR_OK) {
                    $docAttached = true;
                    $originalDocName = basename($_FILES['attachment']['name'][$i]);
                    $ext = pathinfo($originalDocName, PATHINFO_EXTENSION);
                    $baseName = pathinfo($originalDocName, PATHINFO_FILENAME);
                    $newName = $originalDocName;
                    $counter = 1;
                    while(file_exists($targetDir . $newName)) {
                        $newName = $baseName . $counter . "." . $ext;
                        $counter++;
                    }
                    $targetFile = $targetDir . $newName;
                    if (move_uploaded_file($_FILES['attachment']['tmp_name'][$i], $targetFile)) {
                        $attachmentFiles[] = $newName;
                    } else {
                        echo json_encode(["success" => false, "message" => "File upload failed: " . $_FILES['attachment']['error'][$i]]);
                        $conn->close();
                        exit;
                    }
                }
            }
            if (!empty($attachmentFiles)) {
                $attachment = implode(",", $attachmentFiles);
            }
            // If exactly one attachment and no title provided, use its filename (without .pdf) as title.
            if (empty($blogTitle) && count($attachmentFiles) == 1) {
                $blogTitle = preg_replace('/\.pdf$/i', '', $attachmentFiles[0]);
            }
        } else {
            // Single attachment.
            if ($_FILES['attachment']['error'] === UPLOAD_ERR_OK) {
                $docAttached = true;
                $targetDir = "blogs/";
                if (!is_dir($targetDir)) {
                    if(!mkdir($targetDir, 0755, true)) {
                        echo json_encode(["success" => false, "message" => "Failed to create blogs folder"]);
                        $conn->close();
                        exit;
                    }
                }
                $originalDocName = basename($_FILES['attachment']['name']);
                $ext = pathinfo($originalDocName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalDocName, PATHINFO_FILENAME);
                $newName = $originalDocName;
                $counter = 1;
                while(file_exists($targetDir . $newName)) {
                    $newName = $baseName . $counter . "." . $ext;
                    $counter++;
                }
                $targetFile = $targetDir . $newName;
                if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                    $attachment = $newName;
                } else {
                    echo json_encode(["success" => false, "message" => "File upload failed: " . $_FILES['attachment']['error']]);
                    $conn->close();
                    exit;
                }
                if (empty($blogTitle)) {
                    $blogTitle = preg_replace('/\.pdf$/i', '', $newName);
                }
            }
        }
    }
    
    // If no title, no content, and no attachment, return error.
    if (empty($blogTitle) && empty($blogContent) && !$docAttached) {
        echo json_encode(["success" => false, "message" => "Please provide a title, content, or attach a document."]);
        $conn->close();
        exit;
    }
    
    // Insert new blog record.
    $sql = "INSERT INTO blogs (BlogTitle, BlogContent, AuthorID, CreatedAt, date, attarchement) VALUES (?, ?, ?, NOW(), NOW(), ?)";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("ssis", $blogTitle, $blogContent, $authorID, $attachment);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Blog added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add blog: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "delete") {
    // Delete a blog given its BlogID.
    $blogID = intval($_GET['blogID'] ?? 0);
    if (!$blogID) {
        echo json_encode(["success" => false, "message" => "Missing blogID"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM blogs WHERE BlogID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $blogID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Blog deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete blog: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
}
// -------------------- New Actions for Comments -----------------------
elseif ($action === "listComments") {
    $blogID = intval($_GET['blogID'] ?? 0);
    if (!$blogID) {
        echo json_encode(["success" => false, "message" => "Missing blogID"]);
        $conn->close();
        exit;
    }
    $sql = "SELECT CommentID, BlogID, BlogTitle, UserID, CommentMessage, ReplyMessage, CreatedAt FROM Comments WHERE BlogID = ? ORDER BY CreatedAt ASC";
    $stmt = $conn->prepare($sql);
    if(!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $blogID);
    $stmt->execute();
    $result = $stmt->get_result();
    $comments = [];
    while ($row = $result->fetch_assoc()) {
        $comments[] = $row;
    }
    echo json_encode(["success" => true, "comments" => $comments]);
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "addComment") {
    if (!isset($_SESSION['userID'])) {
        echo json_encode(["success" => false, "message" => "Not logged in"]);
        $conn->close();
        exit;
    }
    $userID = $_SESSION['userID'];
    $blogID = intval($_POST['blogID'] ?? 0);
    $commentMessage = trim($_POST['commentMessage'] ?? '');
    if (!$blogID || empty($commentMessage)) {
        echo json_encode(["success" => false, "message" => "BlogID and comment message are required."]);
        $conn->close();
        exit;
    }
    // Get BlogTitle from blogs table.
    $sql = "SELECT BlogTitle FROM blogs WHERE BlogID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $blogID);
    $stmt->execute();
    $stmt->bind_result($blogTitle);
    $stmt->fetch();
    $stmt->close();
    
    // Insert comment. Use ON DUPLICATE KEY UPDATE to allow updating if the user already commented.
    // Alternatively, you can change your table schema to have an auto-increment CommentID.
    $replyMessage = "";
    $sql = "INSERT INTO Comments (BlogID, BlogTitle, UserID, CommentMessage, ReplyMessage) 
            VALUES (?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE CommentMessage = VALUES(CommentMessage), CreatedAt = CURRENT_TIMESTAMP";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("isiss", $blogID, $blogTitle, $userID, $commentMessage, $replyMessage);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comment added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add comment: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "addReply") {
    if (!isset($_SESSION['userID'])) {
        echo json_encode(["success" => false, "message" => "Not logged in"]);
        $conn->close();
        exit;
    }
    $commentID = intval($_POST['commentID'] ?? 0);
    $replyMessage = trim($_POST['replyMessage'] ?? '');
    if (!$commentID || empty($replyMessage)) {
        echo json_encode(["success" => false, "message" => "CommentID and reply message are required."]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE Comments SET ReplyMessage = ? WHERE CommentID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("si", $replyMessage, $commentID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reply added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add reply: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "deleteComment") {
    $commentID = intval($_GET['commentID'] ?? 0);
    if (!$commentID) {
        echo json_encode(["success" => false, "message" => "Missing commentID"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM Comments WHERE CommentID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $commentID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Comment deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete comment: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "deleteReply") {
    $commentID = intval($_GET['commentID'] ?? 0);
    if (!$commentID) {
        echo json_encode(["success" => false, "message" => "Missing commentID"]);
        $conn->close();
        exit;
    }
    $sql = "UPDATE Comments SET ReplyMessage = '' WHERE CommentID = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $commentID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Reply deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete reply: " . $stmt->error]);
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
