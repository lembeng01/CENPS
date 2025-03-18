<?php
// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,               // Session cookie expires when the browser closes
    'path'     => '/',             // Available across the entire domain
    'domain'   => '.crystalenaps.com', // Note the leading dot
    'secure'   => true,            // Ensure the cookie is only sent over HTTPS
    'httponly' => true,            // Prevent JavaScript access for security
    'samesite' => 'None'           // Adjust as needed (None, Lax, or Strict)
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Replace with your frontend domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle preflight OPTIONS request
    header("HTTP/1.1 200 OK");
    exit;
}

session_start();
header('Content-Type: application/json');

// Only allow POST requests.
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
$grade = $input['grade']; // Top-level grade value

$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";
$dbUser = "admin";
$dbPass = "test";

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Begin a transaction
    $pdo->beginTransaction();

    // Loop through each student record in the input array
    foreach ($students as $student) {
        // Optional: enforce that all student records use the top-level grade
        $student['grade'] = $grade;

        try {
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
        } catch (PDOException $e) {
            // Check if the error is due to a duplicate entry (SQLSTATE 23000)
            if ($e->getCode() == 23000) {
                $pdo->rollBack();
                http_response_code(400);
                echo json_encode([
                    "success" => false, 
                    "message" => "Duplicate student name for grade {$student['grade']} detected. Record not saved."
                ]);
                exit;
            } else {
                $pdo->rollBack();
                http_response_code(500);
                echo json_encode(["success" => false, "message" => $e->getMessage()]);
                exit;
            }
        }
    }
    
    // If all operations succeed, commit the transaction.
    $pdo->commit();
    
    // Fetch the updated list of students for the given grade
    $stmt = $pdo->prepare("SELECT * FROM students WHERE grade = :grade");
    $stmt->execute([':grade' => $grade]);
    $updatedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the updated list along with a success message
    echo json_encode([
        "success" => true, 
        "message" => "Student data updated successfully",
        "students" => $updatedStudents
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
