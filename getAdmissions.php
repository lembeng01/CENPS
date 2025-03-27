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
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your frontend domain
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

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Not authenticated"]);
    exit;
}

$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";
$dbUser = getenv('DB_USER');
$dbPass = getenv('DB_PASS');

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM admissions ORDER BY submittedAt DESC");
    $admissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "admissions" => $admissions]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
