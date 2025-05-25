<?php
// Start session to ensure the user is logged in as an admin
session_start();
require_once 'database_connection.php';

// Check if the user is an admin and logged in
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Retrieve user data based on userID
$userID = isset($_GET['userID']) ? intval($_GET['userID']) : 0;
$userData = null;

if ($userID > 0) {
    $stmt = $conn->prepare("SELECT UserID, UserName, Email, RoleID FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $userData = $result->fetch_assoc();
    } else {
        echo "<script>alert('User not found.'); window.location.href = 'admin_get_users.php';</script>";
        exit();
    }
    $stmt->close();
}

// Handle form submission for updating user details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = intval($_POST['userID']);
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $roleID = intval($_POST['role']);

    // Check if all fields are filled
    if (empty($username) || empty($email) || empty($roleID)) {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Check if email is already taken by another user
        $stmtCheckEmail = $conn->prepare("SELECT UserID FROM Users WHERE Email = ? AND UserID != ?");
        $stmtCheckEmail->bind_param("si", $email, $userID);
        $stmtCheckEmail->execute();
        $emailResult = $stmtCheckEmail->get_result();

        if ($emailResult->num_rows > 0) {
            echo "<script>alert('Email is already associated with another user.');</script>";
        } else {
            // Prepare SQL to update user details
            $sql = "UPDATE Users SET UserName = ?, Email = ?, RoleID = ? WHERE UserID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $username, $email, $roleID, $userID);

            if ($stmt->execute()) {
                echo "<script>alert('User updated successfully.'); window.location.href = 'admin_get_users.php';</script>";
                exit();
            } else {
                echo "<script>alert('Error updating user: " . $stmt->error . "');</script>";
            }
            $stmt->close();
        }
        $stmtCheckEmail->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Dashboard</title>
    <style>
        /* General body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        /* Container styles */
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #00796b;
        }

        label {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            border-color: #00796b;
            outline: none;
            box-shadow: 0px 0px 5px rgba(0, 121, 107, 0.5);
        }

        button {
            background-color: #00796b;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-transform: uppercase;
            transition: background-color 0.3s, transform 0.2s;
            width: 100%;
        }

        button:hover {
            background-color: #004d40;
        }

        button:active {
            transform: scale(0.98);
        }

        .back-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #00796b;
            font-weight: bold;
            transition: color 0.3s;
        }

        .back-link:hover {
            color: #004d40;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Edit User</h2>
        <?php if ($userData): ?>
        <form method="POST" action="edit_user_form.php">
            <input type="hidden" name="userID" value="<?php echo $userData['UserID']; ?>">
            
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($userData['UserName']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($userData['Email']); ?>" required>

            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="1" <?php echo ($userData['RoleID'] == 1) ? 'selected' : ''; ?>>Client</option>
                <option value="2" <?php echo ($userData['RoleID'] == 2) ? 'selected' : ''; ?>>Tutor</option>
                <option value="3" <?php echo ($userData['RoleID'] == 3) ? 'selected' : ''; ?>>Admin</option>
            </select>

            <button type="submit">Update User</button>
        </form>
        <a href="admin_get_users.php" class="back-link">Back to User List</a>
        <?php else: ?>
        <p>User data could not be retrieved. <a href="admin_get_users.php">Go back to User List</a></p>
        <?php endif; ?>
    </div>
</body>

</html>
