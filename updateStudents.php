<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Method not allowed"]);
    exit;
}

// (Optional) Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Not authenticated"]);
    exit;
}

// Read and decode JSON input
$data = file_get_contents("php://input");
$input = json_decode($data, true);
if (!$input || !isset($input['students']) || !isset($input['grade'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Invalid input"]);
    exit;
}

$students = $input['students'];
$grade = $input['grade'];

$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";
$dbUser = "admin";
$dbPass = "test";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Loop through each student record in the input array
    foreach ($students as $student) {
        // If the record has an ID, update the record; otherwise, insert a new one
        if (isset($student['id']) && !empty($student['id'])) {
            $stmt = $pdo->prepare(
                "UPDATE students 
                 SET student_name = :student_name, grade = :grade, email = :email, phone = :phone 
                 WHERE id = :id"
            );
            $stmt->execute([
                ":student_name" => $student['student_name'],
                ":grade"        => $student['grade'],
                ":email"        => $student['email'],
                ":phone"        => $student['phone'],
                ":id"           => $student['id']
            ]);
        } else {
            $stmt = $pdo->prepare(
                "INSERT INTO students (student_name, grade, email, phone) 
                 VALUES (:student_name, :grade, :email, :phone)"
            );
            $stmt->execute([
                ":student_name" => $student['student_name'],
                ":grade"        => $student['grade'],
                ":email"        => $student['email'],
                ":phone"        => $student['phone']
            ]);
        }
    }
    echo json_encode(["success" => true, "message" => "Student data updated successfully"]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
