<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$mysqli = new mysqli('localhost','root','','EduAssistaDB');
if ($mysqli->connect_error) {
    echo json_encode(['success'=>false,'message'=>'DB connection error']);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action==='hasGuests') {
    $res = $mysqli->query(
      "SELECT 1 FROM messages 
       WHERE GuestName IS NOT NULL AND GuestName<>'' 
       LIMIT 1"
    );
    echo json_encode(['hasGuests'=> (bool)$res->fetch_assoc()]);
    exit;
}

if ($action==='getUsers') {
    $role = $_GET['role'] ?? '';
    if (in_array($role,['client','tutor'])) {
        $roleID = $role==='client'?1:2;
        $stmt = $mysqli->prepare(
          "SELECT UserID, UserName 
           FROM users 
           WHERE RoleID=? 
           ORDER BY UserName ASC"
        );
        $stmt->bind_param('i',$roleID);
        $stmt->execute();
        $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success'=>true,'users'=>$users]);
        exit;
    }
    if ($role==='guest') {
        $res = $mysqli->query(
          "SELECT DISTINCT GuestName, GuestEmail
           FROM messages
           WHERE GuestName IS NOT NULL AND GuestName<>''
           ORDER BY GuestName ASC"
        );
        $guests = [];
        while ($r=$res->fetch_assoc()) {
            $guests[]=[
              'UserID'   => $r['GuestEmail'],
              'UserName' => $r['GuestName']
            ];
        }
        echo json_encode(['success'=>true,'users'=>$guests]);
        exit;
    }
    echo json_encode(['success'=>false,'message'=>'Invalid role']);
    exit;
}

if ($action==='searchUser') {
    $role  = $_GET['role']  ?? '';
    $q     = trim($_GET['query'] ?? '');
    if (!in_array($role,['client','tutor','guest']) || $q==='') {
        echo json_encode(['success'=>false,'message'=>'Invalid search']);
        exit;
    }
    if ($role==='guest') {
        $like = "%{$mysqli->real_escape_string($q)}%";
        $res = $mysqli->query(
          "SELECT DISTINCT GuestName AS UserName, GuestEmail AS UserID
           FROM messages
           WHERE GuestName LIKE '$like'
           LIMIT 20"
        );
        $guests = $res->fetch_all(MYSQLI_ASSOC);
        echo json_encode(['success'=>true,'users'=>$guests]);
        exit;
    }
    $roleID = $role==='client'?1:2;
    if (ctype_digit($q)) {
        $stmt = $mysqli->prepare(
          "SELECT UserID, UserName, Email, CreatedAt, UpdatedAt, status
           FROM users
           WHERE RoleID=? AND status='active' AND UserID=?"
        );
        $stmt->bind_param('ii',$roleID,$q);
    } else {
        $like = "%{$mysqli->real_escape_string($q)}%";
        $stmt = $mysqli->prepare(
          "SELECT UserID, UserName, Email, CreatedAt, UpdatedAt, status
           FROM users
           WHERE RoleID=? AND status='active'
             AND (UserName LIKE ? OR Email LIKE ?)
           LIMIT 20"
        );
        $stmt->bind_param('iss',$roleID,$like,$like);
    }
    $stmt->execute();
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['success'=>true,'users'=>$users]);
    exit;
}

if (in_array($action,['startChat','reply'])) {
    $st    = $_POST['sender_type']   ?? 'support';
    $sid   = 0;
    $rid   = intval($_POST['receiver_id'] ?? 0);
    $gname = $_POST['guest_name']    ?? null;
    $gemail= $_POST['guest_email']   ?? null;
    $pid   = $action==='reply'? intval($_POST['thread_id'] ?? 0): null;
    $txt   = trim($_POST['message_text'] ?? '');
    if ($txt==='') {
        echo json_encode(['success'=>false,'message'=>'Empty message']);
        exit;
    }
    $stmt = $mysqli->prepare(
      "INSERT INTO messages
         (SenderType,SenderID,GuestName,GuestEmail,ReceiverID,ParentID,MessageText)
       VALUES (?,?,?,?,?,?,?)"
    );
    $stmt->bind_param('sisssis',$st,$sid,$gname,$gemail,$rid,$pid,$txt);
    echo json_encode([
      'success'=>$stmt->execute(),
      'message'=>$stmt->execute()?'Message saved':'Save failed'
    ]);
    exit;
}

if ($action==='list') {
    $threads = [];
    $res = $mysqli->query(
      "SELECT m.MessageID AS threadID,
              COALESCE(m.GuestName,u.UserName) AS withName,
              m.SenderType AS withType,
              m.MessageText AS latest,
              (SELECT COUNT(*) FROM messages r
                 WHERE r.ParentID=m.MessageID
                   AND r.SenderType<>'support') AS unread
       FROM messages m
       LEFT JOIN users u ON u.UserID=m.ReceiverID
       WHERE m.ParentID IS NULL
       ORDER BY m.CreatedAt DESC"
    );
    while($r=$res->fetch_assoc()) $threads[]=$r;
    echo json_encode(['success'=>true,'threads'=>$threads]);
    exit;
}

if ($action==='getThread') {
    $tid = intval($_GET['thread_id'] ?? 0);
    if (!$tid) { echo json_encode(['success'=>false,'message'=>'No thread_id']); exit; }
    $stmt=$mysqli->prepare(
      "SELECT MessageID,SenderType,MessageText,CreatedAt
       FROM messages
       WHERE MessageID=? OR ParentID=?
       ORDER BY CreatedAt ASC"
    );
    $stmt->bind_param('ii',$tid,$tid);
    $stmt->execute();
    $msgs=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['success'=>true,'messages'=>$msgs]);
    exit;
}

if ($action==='update') {
    $mid = intval($_POST['message_id']   ?? 0);
    $txt = trim($_POST['message_text']   ?? '');
    if (!$mid||$txt==='') { echo json_encode(['success'=>false,'message'=>'Invalid input']); exit; }
    $row = $mysqli->query("SELECT SenderType FROM messages WHERE MessageID=$mid")->fetch_assoc();
    if (!$row||$row['SenderType']!=='support') {
        echo json_encode(['success'=>false,'message'=>'Cannot edit']); exit;
    }
    $stmt=$mysqli->prepare(
      "UPDATE messages SET MessageText=?,UpdatedAt=NOW() WHERE MessageID=?"
    );
    $stmt->bind_param('si',$txt,$mid);
    echo json_encode([
      'success'=>$stmt->execute(),
      'message'=>$stmt->execute()?'Updated':'Update failed'
    ]);
    exit;
}

if ($action==='delete') {
    parse_str(file_get_contents('php://input'),$p);
    $mid = intval($p['message_id'] ?? 0);
    if (!$mid) { echo json_encode(['success'=>false,'message'=>'No message_id']); exit; }
    $stmt=$mysqli->prepare("DELETE FROM messages WHERE MessageID=?");
    $stmt->bind_param('i',$mid);
    echo json_encode([
      'success'=>$stmt->execute(),
      'message'=>$stmt->execute()?'Deleted':'Delete failed'
    ]);
    exit;
}

echo json_encode(['success'=>false,'message'=>'Invalid action']);
exit;
?>
