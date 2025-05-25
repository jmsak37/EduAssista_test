<?php
// Start session to ensure the user is logged in as an admin
session_start();
require_once 'database_connection.php';

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Function to get all requests from the database
function getAllRequests($conn) {
    $sql = "SELECT Requests.RequestID, Clients.ClientID, Users.UserName AS ClientName, 
                   Tutors.TutorID, Tutors.UserID AS TutorUserID, TU.UserName AS TutorName, 
                   Requests.RequestTitle, Requests.RequestDetails, Requests.Status, Requests.CreatedAt
            FROM Requests
            LEFT JOIN Clients ON Requests.ClientID = Clients.ClientID
            LEFT JOIN Users ON Clients.UserID = Users.UserID
            LEFT JOIN Tutors ON Requests.TutorID = Tutors.TutorID
            LEFT JOIN Users AS TU ON Tutors.UserID = TU.UserID
            ORDER BY Requests.CreatedAt DESC";

    $result = $conn->query($sql);
    return $result;
}

// Handle Delete Request if any
if (isset($_POST['delete_request_id'])) {
    $requestID = intval($_POST['delete_request_id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM Requests WHERE RequestID = ?");
    $stmt->bind_param("i", $requestID);
    if ($stmt->execute()) {
        echo "<script>alert('Request deleted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to delete request.');</script>";
    }
    $stmt->close();
}

// Get all requests from the database
$requests = getAllRequests($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests - Admin Dashboard</title>
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

        .request-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .request-table th, .request-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .request-table th {
            background-color: #00796b;
            color: white;
        }

        .request-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-btn {
            padding: 8px 15px;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #1dbab4;
        }

        .edit-btn:hover {
            background-color: #148b80;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        .no-requests {
            text-align: center;
            color: #333;
        }

        .footer {
            background-color: #00796b;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h1>Manage Requests</h1>

    <table class="request-table">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Client Name</th>
                <th>Tutor Name</th>
                <th>Title</th>
                <th>Details</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($requests->num_rows > 0): ?>
                <?php while ($row = $requests->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['RequestID']); ?></td>
                        <td><?php echo htmlspecialchars($row['ClientName']); ?></td>
                        <td><?php echo htmlspecialchars($row['TutorName']); ?></td>
                        <td><?php echo htmlspecialchars($row['RequestTitle']); ?></td>
                        <td><?php echo htmlspecialchars($row['RequestDetails']); ?></td>
                        <td><?php echo htmlspecialchars($row['Status']); ?></td>
                        <td><?php echo htmlspecialchars($row['CreatedAt']); ?></td>
                        <td>
                            <a href="edit_request_form.php?requestID=<?php echo $row['RequestID']; ?>" class="action-btn edit-btn">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_request_id" value="<?php echo $row['RequestID']; ?>">
                                <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this request?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="no-requests">No requests found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>2024 © EduAssista. All rights reserved. Contact us at <a href="mailto:jmsak37@gmail.com">jmsak37@gmail.com</a> or call +25469089734.</p>
    </div>
</body>

</html>

<?php
$conn->close();
?>
