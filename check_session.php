<?php
session_start();
header('Content-Type: application/json');

// Check if the user session exists
if (isset($_SESSION['user'])) {
    // You can return additional user information if needed
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
