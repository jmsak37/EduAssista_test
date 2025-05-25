<?php
// Start session to ensure the user is logged in as an admin
session_start();
require_once 'database_connection.php';

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Function to get all tutors from the database
function getAllTutors($conn) {
    $sql = "SELECT Tutors.TutorID, Users.UserName, Users.Email, Tutors.ExpertiseArea, Tutors.Availability, Tutors.Rating, Users.CreatedAt
            FROM Tutors
            JOIN Users ON Tutors.UserID = Users.UserID
            ORDER BY Users.CreatedAt DESC";

    $result = $conn->query($sql);
    return $result;
}

// Handle Delete Request if any
if (isset($_POST['delete_tutor_id'])) {
    $tutorID = intval($_POST['delete_tutor_id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM Tutors WHERE TutorID = ?");
    $stmt->bind_param("i", $tutorID);
    if ($stmt->execute()) {
        echo "<script>alert('Tutor deleted successfully.');</script>";
    } else {
        echo "<script>alert('Failed to delete tutor.');</script>";
    }
    $stmt->close();
}

// Get all tutors from the database
$tutors = getAllTutors($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Tutors - Admin Dashboard</title>
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

        .tutor-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .tutor-table th, .tutor-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .tutor-table th {
            background-color: #00796b;
            color: white;
        }

        .tutor-table tr:hover {
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

        .no-tutors {
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
    <h1>Manage Tutors</h1>

    <table class="tutor-table">
        <thead>
            <tr>
                <th>Tutor ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Expertise Area</th>
                <th>Availability</th>
                <th>Rating</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($tutors->num_rows > 0): ?>
                <?php while ($row = $tutors->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['TutorID']); ?></td>
                        <td><?php echo htmlspecialchars($row['UserName']); ?></td>
                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                        <td><?php echo htmlspecialchars($row['ExpertiseArea']); ?></td>
                        <td><?php echo htmlspecialchars($row['Availability']); ?></td>
                        <td><?php echo htmlspecialchars($row['Rating']); ?></td>
                        <td><?php echo htmlspecialchars($row['CreatedAt']); ?></td>
                        <td>
                            <a href="edit_tutor_form.php?tutorID=<?php echo $row['TutorID']; ?>" class="action-btn edit-btn">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="delete_tutor_id" value="<?php echo $row['TutorID']; ?>">
                                <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this tutor?');">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="no-tutors">No tutors found.</td>
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
