<?php
// log_action.php
require 'database_connection.php';

/**
 * Log an action performed by a user or the system
 * @param int $userId - The ID of the user performing the action
 * @param string $action - A brief description of the action
 * @param string $actionDetails - Detailed information about the action
 */
function logAction($userId, $action, $actionDetails) {
    global $conn;
    
    $sql = "INSERT INTO AuditLogs (UserID, Action, ActionDetails) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $userId, $action, $actionDetails);
    
    if (!$stmt->execute()) {
        error_log("Error logging action: " . $conn->error);
    }
    
    $stmt->close();
}

// Example usage of logAction
// logAction(1, "Admin Login", "Admin with ID 1 logged into the system.");
?>
