<?php
// admin_add_user.php
session_start();
require 'session_check.php'; // Ensures the admin is logged in
require 'database_connection.php';

// Collect data from form
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$roleID = $_POST['roleID']; // Role ID: 1 = client, 2 = tutor, 3 = admin

// Hash the password
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Check if email already exists
$sql_check = "SELECT * FROM Users WHERE Email = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add User - Admin Panel</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
            }
            .message-container {
                background-color: #ffcccc;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                text-align: center;
            }
            h2 {
                color: #ff0000;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #00796b;
                color: white;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                cursor: pointer;
            }
            .button:hover {
                background-color: #004d40;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <h2>Email already exists. Please try again.</h2>
            <a href="add_user_form.html" class="button">Back to Add User Form</a>
        </div>
    </body>
    </html>';
    exit();
}

// Add user to Users table
$sql = "INSERT INTO Users (RoleID, UserName, Email, PasswordHash) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $roleID, $username, $email, $passwordHash);

if ($stmt->execute()) {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Added Successfully - Admin Panel</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
            }
            .message-container {
                background-color: #ccffcc;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                text-align: center;
            }
            h2 {
                color: #00796b;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #00796b;
                color: white;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                cursor: pointer;
            }
            .button:hover {
                background-color: #004d40;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <h2>User added successfully!</h2>
            <a href="index.html" class="button">Back to Dashboard</a>
        </div>
    </body>
    </html>';
} else {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error Adding User - Admin Panel</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #f5f5f5;
                font-family: Arial, sans-serif;
            }
            .message-container {
                background-color: #ffcccc;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
                text-align: center;
            }
            h2 {
                color: #ff0000;
            }
            .button {
                display: inline-block;
                padding: 10px 20px;
                background-color: #00796b;
                color: white;
                border: none;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                cursor: pointer;
            }
            .button:hover {
                background-color: #004d40;
            }
        </style>
    </head>
    <body>
        <div class="message-container">
            <h2>Error adding user. Please try again.</h2>
            <p>Error: ' . $conn->error . '</p>
            <a href="add_user_form.html" class="button">Back to Add User Form</a>
        </div>
    </body>
    </html>';
}

$stmt->close();
$conn->close();
?>
