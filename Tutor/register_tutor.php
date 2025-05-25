<?php
require_once 'database_connection.php';

function showError($error) {
    echo "<!DOCTYPE html>
    <html>
    <head>
        <title>Error</title>
        <style>
            body { font-family: Arial, sans-serif; }
            .modal { display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); justify-content: center; align-items: center; }
            .modal-content { background-color: #fefefe; padding: 20px; border-radius: 5px; width: 300px; max-height: 80%; overflow-y: auto; text-align: center; }
            .error { color: red; font-size: 16px; margin-bottom: 10px; }
            .close-btn { padding: 8px 16px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        </style>
    </head>
    <body>
        <div class='modal'>
            <div class='modal-content'>
                <p class='error'>$error</p>
                <button class='close-btn' onclick='window.history.back();'>Close</button>
            </div>
        </div>
    </body>
    </html>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize array to store missing fields
    $missingFields = [];

    // Check for all required fields and assign values
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $emailConfirm = $_POST['email_confirm'] ?? '';
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $expertise_area = $_POST['expertise'] ?? '';
    $availability = $_POST['availability'] ?? '';
    $subjects = isset($_POST['subjects']) ? explode(',', $_POST['subjects']) : []; // Parse subjects as an array

    // Add missing fields to array
    if (empty($username)) $missingFields[] = "Username";
    if (empty($email)) $missingFields[] = "Email";
    if (empty($emailConfirm)) $missingFields[] = "Confirm Email";
    if (empty($password)) $missingFields[] = "Password";
    if (empty($passwordConfirm)) $missingFields[] = "Confirm Password";
    if (empty($expertise_area)) $missingFields[] = "Expertise Area";
    if (empty($availability)) $missingFields[] = "Availability";
    if (empty($subjects)) $missingFields[] = "Subjects";

    // Show error if there are missing fields
    if (count($missingFields) > 0) {
        showError("Please fill in the following fields: " . implode(", ", $missingFields));
    }

    // Validate email and password matches
    if ($email !== $emailConfirm) {
        showError("Emails do not match.");
    }
    if ($password !== $passwordConfirm) {
        showError("Passwords do not match.");
    }

    // Sanitize inputs for database
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $expertise_area = $conn->real_escape_string($expertise_area);
    $availability = (int) $availability;
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    // Check if the username or email already exists
    $userCheckQuery = "SELECT * FROM users WHERE UserName = '$username' OR Email = '$email'";
    $userCheckResult = $conn->query($userCheckQuery);
    if ($userCheckResult->num_rows > 0) {
        showError("Username or email already exists.");
    }

    // Insert new user
    $query = "INSERT INTO users (UserName, Email, PasswordHash, RoleID) VALUES ('$username', '$email', '$passwordHash', 2)";
    if ($conn->query($query) === TRUE) {
        $userID = $conn->insert_id;

        // Insert tutor profile
        $query = "INSERT INTO tutors (UserID, ExpertiseArea, Availability) VALUES ($userID, '$expertise_area', $availability)";
        if ($conn->query($query) === TRUE) {
            $tutorID = $conn->insert_id;

            // Insert into tutorid table
            $tutorIdQuery = "INSERT INTO tutorid (tutor_id, user_id) VALUES ($tutorID, $userID)";
            if (!$conn->query($tutorIdQuery)) {
                showError("Failed to add data to tutorid table. Error: " . $conn->error);
            }

            // Insert into tutoraccount table
            $tutorAccountQuery = "INSERT INTO tutoraccount (Tutor_id, tutorrating, tutorpendingmoney, tutoravailablemoney, tutorrevision, tutorrequest, tutorclarification) 
                                  VALUES ($tutorID, 100, 0.00, 0.00, 0, 0, 0)";
            if (!$conn->query($tutorAccountQuery)) {
                showError("Failed to add data to tutoraccount table. Error: " . $conn->error);
            }

            // Insert subjects for tutor
            $subject_insert_success = true;
            foreach ($subjects as $subjectName) {
                $subjectName = trim($subjectName); // Remove extra whitespace

                // Check if the subject already exists
                $subjectCheckQuery = "SELECT SubjectID FROM subjects WHERE Subject = '$subjectName'";
                $subjectCheckResult = $conn->query($subjectCheckQuery);

                if ($subjectCheckResult->num_rows > 0) {
                    // Subject exists, retrieve the SubjectID
                    $subjectRow = $subjectCheckResult->fetch_assoc();
                    $subjectID = $subjectRow['SubjectID'];
                } else {
                    // Subject does not exist, insert it
                    $insertSubjectQuery = "INSERT INTO subjects (Subject) VALUES ('$subject')";
                    if ($conn->query($insertSubjectQuery) === TRUE) {
                        $subjectID = $conn->insert_id;
                    } else {
                        $subject_insert_success = false;
                        break;
                    }
                }

                // Insert into tutor_subjects with the retrieved or newly created SubjectID
                $subject_query = "INSERT INTO tutor_subjects (TutorID, SubjectID, Level) VALUES ($tutorID, $subjectID, '$expertise_area')";
                if (!$conn->query($subject_query)) {
                    $subject_insert_success = false;
                    break;
                }
            }

            if ($subject_insert_success) {
                echo "<!DOCTYPE html>
                <html>
                <head>
                    <title>Success</title>
                    <style>
                        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
                        .success-content { max-width: 600px; margin: 0 auto; }
                        .success-content h1 { color: #4CAF50; }
                        .success-content p { font-size: 18px; }
                        .success-content a { color: #4CAF50; text-decoration: none; font-weight: bold; }
                        .success-content a:hover { text-decoration: underline; }
                    </style>
                    <script>
                        setTimeout(function() { window.location.href = '../login.html'; }, 3000);
                    </script>
                </head>
                <body>
                    <div class='success-content'>
                        <h1>Registration Successful</h1>
                        <p>Your registration as a tutor was successful. You will be redirected to the login page shortly.</p>
                        <p>If you are not redirected, <a href='../login.html'>click here</a>.</p>
                    </div>
                </body>
                </html>";
            } else {
                // Rollback tutor entry if subjects failed
                $conn->query("DELETE FROM tutors WHERE TutorID = $tutorID");
                $conn->query("DELETE FROM users WHERE UserID = $userID");
                showError("Failed to assign subjects. Please try again.");
            }
        } else {
            // Rollback user entry if tutor insertion failed
            $conn->query("DELETE FROM users WHERE UserID = $userID");
            showError("Failed to create tutor profile. Please try again.");
        }
    } else {
        showError("Failed to create user. Please try again.");
    }
} else {
    showError("Please fill in all required fields.");
}
?>
