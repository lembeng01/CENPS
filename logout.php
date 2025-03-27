<?php

// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,               // Session cookie expires when the browser closes
    'path'     => '/',             // Available across the entire domain
    'domain'   => '.crystalenaps.com', // Note the leading dot
    'secure'   => true,            // Ensure the cookie is only sent over HTTPS
    'httponly' => true,            // Prevent JavaScript access for security
    'samesite' => 'None'            // Adjust as needed (None, Lax, or Strict)
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your actual frontend domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

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

header('Content-Type: application/json');

// Unset all session variables
$_SESSION = array();

// Delete the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

echo json_encode(["success" => true, "message" => "Logged out successfully"]);
?>
