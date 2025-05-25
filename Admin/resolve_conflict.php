<?php
// Start session to check if the user is an admin
session_start();
require_once '../database_connection.php'; // Update the path to your database connection

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Handle form submission for conflict resolution
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $conflictID = filter_input(INPUT_POST, 'conflictID', FILTER_SANITIZE_NUMBER_INT);
    $resolution = filter_input(INPUT_POST, 'resolution', FILTER_SANITIZE_STRING);
    $adminID = $_SESSION['userID'];
    
    // Check if the conflict exists in the database
    $conflictCheck = $conn->prepare("SELECT * FROM conflicts WHERE ConflictID = ?");
    $conflictCheck->bind_param("i", $conflictID);
    $conflictCheck->execute();
    $result = $conflictCheck->get_result();

    if ($result->num_rows === 0) {
        echo "<p>Conflict not found. Please check the Conflict ID and try again.</p>";
    } else {
        // Update the conflict record with resolution details
        $stmt = $conn->prepare("UPDATE conflicts SET Resolution = ?, ResolvedBy = ?, ResolutionDate = NOW(), Status = 'resolved' WHERE ConflictID = ?");
        $stmt->bind_param("sii", $resolution, $adminID, $conflictID);

        if ($stmt->execute()) {
            echo "<p>Conflict resolved successfully!</p>";
        } else {
            echo "<p>Error resolving conflict. Please try again later.</p>";
        }
    }
}

// Retrieve unresolved conflicts to show on the page
$unresolvedConflicts = $conn->query("SELECT ConflictID, ClientID, TutorID, ConflictDetails, CreatedAt FROM conflicts WHERE Status = 'unresolved'");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resolve Conflict - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #00796b;
        }
        .conflict-table, .resolve-form {
            width: 80%;
            margin: 20px auto;
            background-color: white;
            padding: 15px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .conflict-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .conflict-table th, .conflict-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .conflict-table th {
            background-color: #00796b;
            color: white;
        }
        .action-btn {
            padding: 8px 15px;
            color: white;
            background-color: #1dbab4;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }
        .action-btn:hover {
            background-color: #148b80;
        }
    </style>
</head>
<body>
    <h1>Resolve Conflicts</h1>

    <div class="conflict-table">
        <h2>Unresolved Conflicts</h2>
        <table>
            <thead>
                <tr>
                    <th>Conflict ID</th>
                    <th>Client ID</th>
                    <th>Tutor ID</th>
                    <th>Conflict Details</th>
                    <th>Reported At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($conflict = $unresolvedConflicts->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($conflict['ConflictID']); ?></td>
                        <td><?php echo htmlspecialchars($conflict['ClientID']); ?></td>
                        <td><?php echo htmlspecialchars($conflict['TutorID']); ?></td>
                        <td><?php echo htmlspecialchars($conflict['ConflictDetails']); ?></td>
                        <td><?php echo htmlspecialchars($conflict['CreatedAt']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="resolve-form">
        <h2>Resolve Conflict</h2>
        <form method="post" action="">
            <label for="conflictID">Conflict ID:</label>
            <input type="number" id="conflictID" name="conflictID" required><br><br>
            
            <label for="resolution">Resolution Details:</label><br>
            <textarea id="resolution" name="resolution" rows="5" required></textarea><br><br>
            
            <button type="submit" class="action-btn">Resolve Conflict</button>
        </form>
    </div>
</body>
</html>
