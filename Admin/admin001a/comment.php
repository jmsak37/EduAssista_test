<?php
// Enable full error reporting for debugging.
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
header('Content-Type: application/json');

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

if ($action === "listComments") {
    $blogID = intval($_GET['blogID'] ?? 0);
    if (!$blogID) {
        echo json_encode(["success" => false, "message" => "Missing blogID"]);
        $conn->close();
        exit;
    }
    
    $comments = [];
    
    // Fetch registered comments from 'comments' table.
    $sql = "SELECT c.CommentID, c.BlogID, c.BlogTitle, c.UserID, c.CommentMessage, c.CreatedAt,
                   (SELECT UserName FROM users WHERE users.UserID = c.UserID) AS UserName
            FROM comments c
            WHERE c.BlogID = ?";
    $stmt = $conn->prepare($sql);
    if(!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $blogID);
    $stmt->execute();
    $result = $stmt->get_result();
    while($row = $result->fetch_assoc()){
        $row['replies'] = [];
        $comments[] = $row;
    }
    $stmt->close();
    
    // Fetch guest comments from 'gustcomment' table.
    $sqlGuest = "SELECT CommentID, BlogID, BlogTitle, CommentMessage, FirstName, MiddleName, LastName, Email, Timestamp AS CreatedAt
                 FROM gustcomment
                 WHERE BlogID = ?";
    $stmtGuest = $conn->prepare($sqlGuest);
    if(!$stmtGuest) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtGuest->bind_param("i", $blogID);
    $stmtGuest->execute();
    $resultGuest = $stmtGuest->get_result();
    while($row = $resultGuest->fetch_assoc()){
        // For guest, set UserID = 0 and create a UserName from FirstName and LastName.
        $row['UserID'] = 0;
        $row['UserName'] = trim($row['FirstName'] . " " . $row['LastName']);
        $row['replies'] = [];
        $comments[] = $row;
    }
    $stmtGuest->close();
    
    // Sort comments by CreatedAt ascending.
    usort($comments, function($a, $b) {
        return strtotime($a['CreatedAt']) - strtotime($b['CreatedAt']);
    });
    
    // Fetch registered replies from 'comment_replies'
    $sqlReplies = "SELECT r.ReplyID, r.ParentCommentID, r.BlogID_replied, r.BlogTitle_replied, r.UserID_replied, r.ReplyMessage, r.CreatedAt,
                           (SELECT UserName FROM users WHERE users.UserID = r.UserID_replied) AS UserName_replied
                    FROM comment_replies r
                    WHERE r.BlogID_replied = ?";
    $stmtReplies = $conn->prepare($sqlReplies);
    if(!$stmtReplies) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtReplies->bind_param("i", $blogID);
    $stmtReplies->execute();
    $resultReplies = $stmtReplies->get_result();
    $registeredReplies = [];
    while($row = $resultReplies->fetch_assoc()){
        $registeredReplies[] = $row;
    }
    $stmtReplies->close();
    
    // Fetch guest replies from 'guestreply'
    $sqlGuestReplies = "SELECT ReplyID, ParentCommentID, BlogID_replied, BlogTitle_replied, ReplyMessage, FirstName, MiddleName, LastName, Email, Timestamp AS CreatedAt
                        FROM guestreply
                        WHERE BlogID_replied = ?";
    $stmtGuestReplies = $conn->prepare($sqlGuestReplies);
    if(!$stmtGuestReplies) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtGuestReplies->bind_param("i", $blogID);
    $stmtGuestReplies->execute();
    $resultGuestReplies = $stmtGuestReplies->get_result();
    $guestReplies = [];
    while($row = $resultGuestReplies->fetch_assoc()){
        // For guest reply, set UserID_replied to 0 and create UserName_replied from FirstName and LastName.
        $row['UserID_replied'] = 0;
        $row['UserName_replied'] = trim($row['FirstName'] . " " . $row['LastName']);
        $guestReplies[] = $row;
    }
    $stmtGuestReplies->close();
    
    // Merge replies into corresponding comments.
    foreach ($registeredReplies as $reply) {
        foreach ($comments as &$comment) {
            if ($comment['CommentID'] == $reply['ParentCommentID']) {
                $comment['replies'][] = $reply;
                break;
            }
        }
    }
    foreach ($guestReplies as $reply) {
        foreach ($comments as &$comment) {
            if ($comment['CommentID'] == $reply['ParentCommentID']) {
                $comment['replies'][] = $reply;
                break;
            }
        }
    }
    
    // Optionally, sort each comment's replies by CreatedAt ascending.
    foreach ($comments as &$comment) {
        if (!empty($comment['replies'])) {
            usort($comment['replies'], function($a, $b) {
                return strtotime($a['CreatedAt']) - strtotime($b['CreatedAt']);
            });
        }
    }
    
    $conn->close();
    echo json_encode(["success" => true, "comments" => $comments]);
    exit;
    
} elseif ($action === "addComment") {
    $blogID = intval($_POST['blogID'] ?? 0);
    $commentMessage = trim($_POST['commentMessage'] ?? '');
    
    // Get BlogTitle from blogs table.
    $sqlBlog = "SELECT BlogTitle FROM blogs WHERE BlogID = ?";
    $stmtBlog = $conn->prepare($sqlBlog);
    if (!$stmtBlog) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtBlog->bind_param("i", $blogID);
    $stmtBlog->execute();
    $stmtBlog->bind_result($blogTitle);
    if (!$stmtBlog->fetch()) {
        echo json_encode(["success" => false, "message" => "Blog not found."]);
        $stmtBlog->close();
        $conn->close();
        exit;
    }
    $stmtBlog->close();
    
    // Check if user is logged in.
    $userID = $_SESSION['userID'] ?? 0;
    if ($userID > 0) {
        // Registered user, insert into comments table.
        $sqlCheck = "SELECT UserID, UserName FROM users WHERE UserID = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $userID);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        if ($stmtCheck->num_rows == 0) {
            $userID = 0;
        }
        $stmtCheck->close();
    }
    if ($userID > 0) {
        if (!$blogID || empty($commentMessage)) {
            echo json_encode(["success" => false, "message" => "BlogID and comment message are required."]);
            $conn->close();
            exit;
        }
        $sqlInsert = "INSERT INTO comments (BlogID, BlogTitle, UserID, CommentMessage, CreatedAt) VALUES (?, ?, ?, ?, NOW())";
        $stmtInsert = $conn->prepare($sqlInsert);
        if (!$stmtInsert) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            $conn->close();
            exit;
        }
        $stmtInsert->bind_param("isis", $blogID, $blogTitle, $userID, $commentMessage);
        if ($stmtInsert->execute()) {
            echo json_encode(["success" => true, "message" => "Comment added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add comment: " . $stmtInsert->error]);
        }
        $stmtInsert->close();
        $conn->close();
        exit;
    } else {
        // Guest comment: require guest details.
        if (empty($_POST['guestFirst']) || empty($_POST['guestLast']) || empty($_POST['guestEmail'])) {
            echo json_encode(["success" => false, "message" => "Guest details required. Please enter first name, last name and a valid email."]);
            $conn->close();
            exit;
        }
        $guestFirst = trim($_POST['guestFirst']);
        $guestMiddle = trim($_POST['guestMiddle'] ?? '');
        $guestLast = trim($_POST['guestLast']);
        $guestEmail = trim($_POST['guestEmail']);
        
        // Generate custom CommentID for guest comment.
        $blogPart = str_pad($blogID, 4, '0', STR_PAD_LEFT);
        $sqlCount = "SELECT COUNT(*) FROM gustcomment WHERE BlogID = ?";
        $stmtCount = $conn->prepare($sqlCount);
        $stmtCount->bind_param("i", $blogID);
        $stmtCount->execute();
        $stmtCount->bind_result($count);
        $stmtCount->fetch();
        $stmtCount->close();
        $seq = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        $customCommentID = $blogPart . "-" . $seq;
        
        $sqlInsertGuest = "INSERT INTO gustcomment (CommentID, BlogID, BlogTitle, CommentMessage, FirstName, MiddleName, LastName, Email, Timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmtInsertGuest = $conn->prepare($sqlInsertGuest);
        if (!$stmtInsertGuest) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            $conn->close();
            exit;
        }
        $stmtInsertGuest->bind_param("sissssss", $customCommentID, $blogID, $blogTitle, $commentMessage, $guestFirst, $guestMiddle, $guestLast, $guestEmail);
        if ($stmtInsertGuest->execute()) {
            echo json_encode(["success" => true, "message" => "Guest comment added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add guest comment: " . $stmtInsertGuest->error]);
        }
        $stmtInsertGuest->close();
        $conn->close();
        exit;
    }
    
} elseif ($action === "addReply") {
    $parentCommentID = $_POST['commentID'] ?? '';
    $replyMessage = trim($_POST['replyMessage'] ?? '');
    
    if (empty($parentCommentID) || empty($replyMessage)) {
        echo json_encode(["success" => false, "message" => "CommentID and reply message are required."]);
        $conn->close();
        exit;
    }
    
    // Get BlogID and BlogTitle from parent comment.
    // First check in registered comments.
    $sqlParent = "SELECT BlogID, BlogTitle FROM comments WHERE CommentID = ?";
    $stmtParent = $conn->prepare($sqlParent);
    $isGuestComment = false;
    if ($stmtParent) {
        $stmtParent->bind_param("s", $parentCommentID);
        $stmtParent->execute();
        $stmtParent->bind_result($blogID_replied, $blogTitle_replied);
        if (!$stmtParent->fetch()) {
            $stmtParent->close();
            // Not found in comments, check gustcomment.
            $sqlParentGuest = "SELECT BlogID, BlogTitle FROM gustcomment WHERE CommentID = ?";
            $stmtParentGuest = $conn->prepare($sqlParentGuest);
            if (!$stmtParentGuest) {
                echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
                $conn->close();
                exit;
            }
            $stmtParentGuest->bind_param("s", $parentCommentID);
            $stmtParentGuest->execute();
            $stmtParentGuest->bind_result($blogID_replied, $blogTitle_replied);
            if (!$stmtParentGuest->fetch()) {
                echo json_encode(["success" => false, "message" => "Parent comment not found."]);
                $stmtParentGuest->close();
                $conn->close();
                exit;
            }
            $stmtParentGuest->close();
            $isGuestComment = true;
        } else {
            $stmtParent->close();
        }
    } else {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    
    // Check if user is logged in.
    $userID = $_SESSION['userID'] ?? 0;
    if ($userID > 0) {
        $sqlCheck = "SELECT UserID, UserName FROM users WHERE UserID = ?";
        $stmtCheck = $conn->prepare($sqlCheck);
        $stmtCheck->bind_param("i", $userID);
        $stmtCheck->execute();
        $stmtCheck->store_result();
        if ($stmtCheck->num_rows == 0) {
            $userID = 0;
        }
        $stmtCheck->close();
    }
    if ($userID > 0) {
        // Registered reply.
        $sqlInsertReply = "INSERT INTO comment_replies (ParentCommentID, BlogID_replied, BlogTitle_replied, UserID_replied, ReplyMessage, CreatedAt) VALUES (?, ?, ?, ?, ?, NOW())";
        $stmtInsertReply = $conn->prepare($sqlInsertReply);
        if (!$stmtInsertReply) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            $conn->close();
            exit;
        }
        $stmtInsertReply->bind_param("sisis", $parentCommentID, $blogID_replied, $blogTitle_replied, $userID, $replyMessage);
        if ($stmtInsertReply->execute()) {
            echo json_encode(["success" => true, "message" => "Reply added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add reply: " . $stmtInsertReply->error]);
        }
        $stmtInsertReply->close();
        $conn->close();
        exit;
    } else {
        // Guest reply.
        if (empty($_POST['guestFirst']) || empty($_POST['guestLast']) || empty($_POST['guestEmail'])) {
            echo json_encode(["success" => false, "message" => "Guest details required for reply."]);
            $conn->close();
            exit;
        }
        $guestFirst = trim($_POST['guestFirst']);
        $guestMiddle = trim($_POST['guestMiddle'] ?? '');
        $guestLast = trim($_POST['guestLast']);
        $guestEmail = trim($_POST['guestEmail']);
        
        // Generate custom ReplyID for guest reply (format similar to guest comment).
        $blogPart = str_pad($blogID_replied, 4, '0', STR_PAD_LEFT);
        $sqlCountReply = "SELECT COUNT(*) FROM guestreply WHERE BlogID_replied = ?";
        $stmtCountReply = $conn->prepare($sqlCountReply);
        $stmtCountReply->bind_param("i", $blogID_replied);
        $stmtCountReply->execute();
        $stmtCountReply->bind_result($replyCount);
        $stmtCountReply->fetch();
        $stmtCountReply->close();
        $seqReply = str_pad($replyCount + 1, 4, '0', STR_PAD_LEFT);
        $customReplyID = $blogPart . "-" . $seqReply;
        
        $sqlInsertGuestReply = "INSERT INTO guestreply (ReplyID, ParentCommentID, BlogID_replied, BlogTitle_replied, ReplyMessage, FirstName, MiddleName, LastName, Email, Timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmtInsertGuestReply = $conn->prepare($sqlInsertGuestReply);
        if (!$stmtInsertGuestReply) {
            echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
            $conn->close();
            exit;
        }
        $stmtInsertGuestReply->bind_param("sisisssss", $customReplyID, $parentCommentID, $blogID_replied, $blogTitle_replied, $replyMessage, $guestFirst, $guestMiddle, $guestLast, $guestEmail);
        if ($stmtInsertGuestReply->execute()) {
            echo json_encode(["success" => true, "message" => "Guest reply added successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to add guest reply: " . $stmtInsertGuestReply->error]);
        }
        $stmtInsertGuestReply->close();
        $conn->close();
        exit;
    }
    
} elseif ($action === "deleteComment") {
    $commentID = $_GET['commentID'] ?? '';
    if (empty($commentID)) {
        echo json_encode(["success" => false, "message" => "Missing commentID"]);
        $conn->close();
        exit;
    }
    // First try deleting from registered comments.
    $sqlDelete = "DELETE FROM comments WHERE CommentID = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    if ($stmtDelete) {
        $stmtDelete->bind_param("s", $commentID);
        $stmtDelete->execute();
        if ($stmtDelete->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Comment deleted successfully."]);
            $stmtDelete->close();
            $conn->close();
            exit;
        }
        $stmtDelete->close();
    }
    // Otherwise, try deleting from gustcomment.
    $sqlDeleteGuest = "DELETE FROM gustcomment WHERE CommentID = ?";
    $stmtDeleteGuest = $conn->prepare($sqlDeleteGuest);
    if (!$stmtDeleteGuest) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtDeleteGuest->bind_param("s", $commentID);
    if ($stmtDeleteGuest->execute()) {
        echo json_encode(["success" => true, "message" => "Guest comment deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete comment: " . $stmtDeleteGuest->error]);
    }
    $stmtDeleteGuest->close();
    $conn->close();
    exit;
} elseif ($action === "deleteReply") {
    $replyID = $_GET['replyID'] ?? '';
    if (empty($replyID)) {
        echo json_encode(["success" => false, "message" => "Missing replyID"]);
        $conn->close();
        exit;
    }
    // Try deleting from registered replies.
    $sqlDeleteReply = "DELETE FROM comment_replies WHERE ReplyID = ?";
    $stmtDeleteReply = $conn->prepare($sqlDeleteReply);
    if ($stmtDeleteReply) {
        $stmtDeleteReply->bind_param("s", $replyID);
        $stmtDeleteReply->execute();
        if ($stmtDeleteReply->affected_rows > 0) {
            echo json_encode(["success" => true, "message" => "Reply deleted successfully."]);
            $stmtDeleteReply->close();
            $conn->close();
            exit;
        }
        $stmtDeleteReply->close();
    }
    // Otherwise, try deleting from guest replies.
    $sqlDeleteGuestReply = "DELETE FROM guestreply WHERE ReplyID = ?";
    $stmtDeleteGuestReply = $conn->prepare($sqlDeleteGuestReply);
    if (!$stmtDeleteGuestReply) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtDeleteGuestReply->bind_param("s", $replyID);
    if ($stmtDeleteGuestReply->execute()) {
        echo json_encode(["success" => true, "message" => "Guest reply deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete reply: " . $stmtDeleteGuestReply->error]);
    }
    $stmtDeleteGuestReply->close();
    $conn->close();
    exit;
} else {
    echo json_encode(["success" => false, "message" => "Invalid action"]);
    $conn->close();
    exit;
}
?>
