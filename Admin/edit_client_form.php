<?php
// edit_client_form.php

session_start();
require 'session_check.php';
require 'database_connection.php';

if (isset($_GET['clientID'])) {
    $clientID = $_GET['clientID'];

    $sql = "SELECT Users.UserName, Users.Email, Clients.EducationalLevel, Clients.PreferredSubject FROM Users JOIN Clients ON Users.UserID = Clients.UserID WHERE Clients.ClientID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $clientID);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if (!$client) {
        echo "Client not found.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Client</h2>
        <form method="POST" action="update_client.php">
            <input type="hidden" name="clientID" value="<?php echo $clientID; ?>">

            <label for="educational-level">Educational Level:</label>
            <input type="text" id="educational-level" name="educational-level" value="<?php echo $client['EducationalLevel']; ?>" required>

            <label for="preferred-subject">Preferred Subject:</label>
            <input type="text" id="preferred-subject" name="preferred-subject" value="<?php echo $client['PreferredSubject']; ?>" required>

            <button type="submit">Update Client</button>
        </form>
    </div>
</body>
</html>
