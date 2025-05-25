<?php
// edit_tutor_form.php

session_start();
require 'session_check.php';
require 'database_connection.php';

if (isset($_GET['tutorID'])) {
    $tutorID = $_GET['tutorID'];

    $sql = "SELECT Users.UserName, Users.Email, Tutors.ExpertiseArea, Tutors.Availability FROM Users JOIN Tutors ON Users.UserID = Tutors.UserID WHERE Tutors.TutorID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $tutorID);
    $stmt->execute();
    $result = $stmt->get_result();
    $tutor = $result->fetch_assoc();

    if (!$tutor) {
        echo "Tutor not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tutor</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Tutor</h2>
        <form method="POST" action="update_tutor.php">
            <input type="hidden" name="tutorID" value="<?php echo $tutorID; ?>">

            <label for="expertise-area">Expertise Area:</label>
            <input type="text" id="expertise-area" name="expertise-area" value="<?php echo $tutor['ExpertiseArea']; ?>" required>

            <label for="availability">Availability:</label>
            <input type="text" id="availability" name="availability" value="<?php echo $tutor['Availability']; ?>" required>

            <button type="submit">Update Tutor</button>
        </form>
    </div>
</body>
</html>
