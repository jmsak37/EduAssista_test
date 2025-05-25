<?php
session_start();
header('Content-Type: application/json');

// Check if an action is provided
$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

// Response array to be sent back as JSON
$response = ['loggedIn' => isset($_SESSION['userID']) && $_SESSION['roleID'] == 3];

if ($action === 'check_session') {
    // Check if the admin is logged in
    $response['loggedIn'] = isset($_SESSION['userID']) && $_SESSION['roleID'] == 3;

} elseif ($action === 'keep_alive' && $response['loggedIn']) {
    // Extend the session lifetime if the user is still logged in
    $_SESSION['last_activity'] = time();
    $response['loggedIn'] = true;

} elseif ($action === 'logout_due_to_inactivity') {
    // Log out due to inactivity
    session_unset();
    session_destroy();
    $response['loggedIn'] = false;
    $response['message'] = 'Logged out due to inactivity';

} else {
    // Invalid action or no valid session
    $response['loggedIn'] = false;
    $response['message'] = 'Invalid session or action';
}

// Send JSON response
echo json_encode($response);
