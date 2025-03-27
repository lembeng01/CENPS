<?php
// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,               
    'path'     => '/',             
    'domain'   => '.crystalenaps.com', // Note the leading dot for subdomain access
    'secure'   => true,            
    'httponly' => true,            
    'samesite' => 'None'           
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Your frontend domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Start session after setting cookie parameters
session_start();

// ----- Session Timeout Logic Start -----
// Set the timeout duration to 5 minutes (300 seconds)
$timeout_duration = 300;

// Check if the last activity timestamp exists and if the session has expired
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout_duration)) {
    // Session has timed out: clear session data and destroy the session
    session_unset();
    session_destroy();
    // Redirect to your login page
    header("Location: login.html");
    exit();
}

// Update the last activity timestamp
$_SESSION['last_activity'] = time();
// ----- Session Timeout Logic End -----

// Set Content-Type header for JSON response
header('Content-Type: application/json');

// Load database credentials from external configuration file
$configFile = 'C:/wamp64/config/db_config.ini';
$config = parse_ini_file($configFile, true);
if ($config === false) {
    echo json_encode(["success" => false, "message" => "Failed to load configuration file"]);
    exit();
}
$dbUser = $config['database']['user'];
$dbPass = $config['database']['pass'];

// Build DSN for PDO
$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve credentials from POST data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Use a prepared statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login: regenerate the session ID and store user data
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'       => $user['id'],
            'username' => $user['username']
        ];
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password"]);
    }

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
