<?php
// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => '.crystalenaps.com',
    'secure'   => true,
    'httponly' => true,
    'samesite' => 'None'
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your frontend domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit;
}

session_start();
header('Content-Type: application/json');

// Only allow GET requests (or POST if you prefer)
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit;
}

// Database connection settings – adjust these with your credentials
$servername = "localhost";
$dbUser     = getenv('DB_USER');
$dbPass     = getenv('DB_PASS');
$dbname     = "my_database";

try {
    $dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $e->getMessage()]);
    exit;
}

// Check if the visitor has already been counted via a cookie
if (!isset($_COOKIE['visitor_counted'])) {
    try {
        // Begin a transaction
        $pdo->beginTransaction();
        // Increment the visitor count (assuming a row with id = 1 exists)
        $stmt = $pdo->prepare("UPDATE visitor_stats SET count = count + 1 WHERE id = 1");
        $stmt->execute();
        $pdo->commit();

        // Set a cookie to mark this visitor as counted for 30 days
        setcookie('visitor_counted', '1', time() + (30 * 24 * 60 * 60), '/', '.crystalenaps.com', true, true);
    } catch (PDOException $e) {
        $pdo->rollBack();
        http_response_code(500);
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
        exit;
    }
}

// Retrieve the updated visitor count
$stmt = $pdo->prepare("SELECT count FROM visitor_stats WHERE id = 1");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$count = $row ? $row['count'] : 0;

echo json_encode(["success" => true, "count" => $count]);
?>
