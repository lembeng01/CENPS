<?php
// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your actual frontend domain if different
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

session_start();

// Check if the user session exists and return session data if available
if (isset($_SESSION['user'])) {
    echo json_encode([
        "logged_in" => true,
        "user"      => $_SESSION['user']
    ]);
} else {
    echo json_encode([
        "logged_in" => false
    ]);
}
?>
