<?php
session_start();
header('Content-Type: application/json');

// (Optional) Check if user is logged in
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
