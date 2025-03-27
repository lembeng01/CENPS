<?php
// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,                   // Session cookie expires when the browser closes
    'path'     => '/',                 // Cookie available throughout the domain
    'domain'   => '.crystalenaps.com', // Leading dot makes it valid for all subdomains
    'secure'   => true,                // Send cookie only over HTTPS
    'httponly' => true,                // Prevent JavaScript access to the cookie
    'samesite' => 'None'                // Adjust this if needed (None, Lax, or Strict)
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Use your frontend's domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

// Start the session after setting cookie parameters
session_start();

// ----- Session Timeout Logic Start -----
// Set the timeout duration to 5 minutes (300 seconds)
$timeout_duration = 300;

// Check if the last activity timestamp exists and if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    // Session has timed out: clear session data and destroy the session
    session_unset();
    session_destroy();
    // Redirect to your login page (choose login.html or login.php based on your flow)
    header("Location: login.html");
    exit();
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();
// ----- Session Timeout Logic End -----

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
