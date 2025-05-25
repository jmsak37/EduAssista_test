<?php
// Start session and check for admin (tutor) authentication
session_start();
require_once 'database_connection.php';

// Check if the user is logged in and has the tutor role (roleID == 3)
if (!isset($_SESSION['userID']) || $_SESSION['roleID'] != 3) {
    header("Location: admin_login.php");
    exit();
}

// Function to get all tutors from the database
function getAllTutors($conn) {
    // Adjust the query to return only tutors (assuming RoleID of 3 indicates a tutor)
    $sql = "SELECT Users.UserID, Users.UserName, Users.Email, Roles.RoleName, Users.CreatedAt
            FROM Users
            JOIN Roles ON Users.RoleID = Roles.RoleID
            WHERE Users.RoleID = 3
            ORDER BY Users.CreatedAt DESC";
    $result = $conn->query($sql);
    return $result;
}

// Handle Delete Request if any
if (isset($_POST['delete_tutor_id'])) {
    $userID = intval($_POST['delete_tutor_id']);

    // Prepare and execute delete query
    $stmt = $conn->prepare("DELETE FROM Users WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
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

<table class="user-table">
  <thead>
    <tr>
      <th>Tutor ID</th>
      <th>Username</th>
      <th>Email</th>
      <th>Role</th>
      <th>Created At</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($tutors && $tutors->num_rows > 0): ?>
      <?php while ($row = $tutors->fetch_assoc()): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['UserID']); ?></td>
          <td><?php echo htmlspecialchars($row['UserName']); ?></td>
          <td><?php echo htmlspecialchars($row['Email']); ?></td>
          <td><?php echo htmlspecialchars($row['RoleName']); ?></td>
          <td><?php echo htmlspecialchars($row['CreatedAt']); ?></td>
          <td>
            <a href="edit_tutor_form.php?tutorID=<?php echo $row['UserID']; ?>" class="action-btn edit-btn">Edit</a>
            <form method="POST" style="display:inline;">
              <input type="hidden" name="delete_tutor_id" value="<?php echo $row['UserID']; ?>">
              <button type="submit" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this tutor?');">Delete</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" class="no-users">No tutors found.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php
$conn->close();
?>
