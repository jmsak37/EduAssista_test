<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the user is a tutor
    $tutor_query = $conn->prepare("SELECT tutor_id FROM tutors WHERE user_id = ?");
    $tutor_query->bind_param("i", $user_id);
    $tutor_query->execute();
    $result = $tutor_query->get_result();

    if ($row = $result->fetch_assoc()) {
        $tutor_id = $row['tutor_id'];

        // Fetch subjects for the tutor
        $subject_query = $conn->prepare("SELECT subject_name FROM tutor_subjects WHERE tutor_id = ?");
        $subject_query->bind_param("i", $tutor_id);
        $subject_query->execute();
        $subject_result = $subject_query->get_result();

        while ($subject = $subject_result->fetch_assoc()) {
            echo "<option value='" . htmlspecialchars($subject['subject_name']) . "'>" . htmlspecialchars($subject['subject_name']) . "</option>";
        }
    } else {
        echo "<option>No subjects available</option>";
    }
}
?>
