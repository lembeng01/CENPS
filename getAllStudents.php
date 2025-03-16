<?php
// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your frontend domain if different
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();
header('Content-Type: application/json');

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Not authenticated"]);
    exit;
}

$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";
$dbUser = "admin";
$dbPass = "test";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "students" => $students]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
