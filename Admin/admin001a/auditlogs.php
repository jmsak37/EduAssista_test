<?php
header('Content-Type: application/json');

$servername  = "localhost";
$dbUsername  = "root";
$dbPassword  = "";
$dbname      = "eduassistadb";

// Create connection
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection error"]);
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === "list") {
    // Retrieve audit logs joined with user details.
    $sql = "SELECT a.LogID, a.UserID, a.Action, a.ActionDetails, a.Timestamp,
                   u.UserName, u.Email, u.RoleID 
            FROM auditlogs a 
            LEFT JOIN users u ON a.UserID = u.UserID 
            ORDER BY a.Timestamp DESC";
    $result = $conn->query($sql);
    $logs = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Map RoleID to a rule string.
            $rule = "";
            if (isset($row['RoleID'])) {
                if ($row['RoleID'] == 1) {
                    $rule = "client";
                } elseif ($row['RoleID'] == 2) {
                    $rule = "tutor";
                } elseif ($row['RoleID'] == 3) {
                    $rule = "admin";
                } else {
                    $rule = "unknown";
                }
            }
            $row['rule'] = $rule;
            $logs[] = $row;
        }
        echo json_encode(["success" => true, "auditlogs" => $logs]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to retrieve audit logs"]);
    }
    $conn->close();
    exit;
} elseif ($action === "getUser") {
    // Return user details.
    $userID = intval($_GET['userID'] ?? 0);
    if (!$userID) {
        echo json_encode(["success" => false, "message" => "Missing userID"]);
        $conn->close();
        exit;
    }
    $sql = "SELECT UserID, RoleID, UserName, Email, CreatedAt, UpdatedAt FROM users WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($user = $result->fetch_assoc()) {
            $rule = "";
            if ($user['RoleID'] == 1) {
                $rule = "client";
            } elseif ($user['RoleID'] == 2) {
                $rule = "tutor";
            } elseif ($user['RoleID'] == 3) {
                $rule = "admin";
            } else {
                $rule = "unknown";
            }
            $user['rule'] = $rule;
            echo json_encode(["success" => true, "user" => $user]);
        } else {
            echo json_encode(["success" => false, "message" => "User not found"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Query execution error"]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "forceLogout") {
    // Delete all audit log records for the given user.
    $userID = intval($_GET['userID'] ?? 0);
    if (!$userID) {
        echo json_encode(["success" => false, "message" => "Missing userID"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM auditlogs WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Audit logs for user deleted (force logout)."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete audit logs for user."]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "restrict") {
    // Insert into `restrict` table.
    $input = json_decode(file_get_contents('php://input'), true);
    $userID = intval($input['userID'] ?? 0);
    if (!$userID) {
        echo json_encode(["success" => false, "message" => "Missing userID"]);
        $conn->close();
        exit;
    }
    $sql = "INSERT INTO `restrict` (UserID, RestrictDate) VALUES (?, NOW())";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo json_encode(["success" => false, "message" => "Prepare failed: " . $conn->error]);
        $conn->close();
        exit;
    }
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User has been restricted."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to restrict user: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "unrestrict") {
    // Remove from `restrict` table.
    $input = json_decode(file_get_contents('php://input'), true);
    $userID = intval($input['userID'] ?? 0);
    if (!$userID) {
        echo json_encode(["success" => false, "message" => "Missing userID"]);
        $conn->close();
        exit;
    }
    $sql = "DELETE FROM `restrict` WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userID);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User restriction has been removed."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to remove restriction: " . $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit;
} elseif ($action === "delete") {
    // Bulk delete: expects a JSON array of LogIDs.
    $input = json_decode(file_get_contents('php://input'), true);
    $logIDs = $input['logIDs'] ?? [];
    if (empty($logIDs)) {
        echo json_encode(["success" => false, "message" => "No log IDs provided"]);
        $conn->close();
        exit;
    }
    $placeholders = implode(',', array_fill(0, count($logIDs), '?'));
    $sql = "DELETE FROM auditlogs WHERE LogID IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $types = str_repeat('i', count($logIDs));
    $stmt->bind_param($types, ...$logIDs);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Selected audit logs deleted."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete audit logs."]);
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
