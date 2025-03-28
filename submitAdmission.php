<?php
// Optional: Start session if needed
// session_set_cookie_params(0, '/', '.crystalenaps.com', true, true);
// session_start();

// Dynamic CORS header example (adjust as necessary)
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $allowed_origins = ['https://crystalenaps.com', 'https://www.crystalenaps.com'];
    if (in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
    }
} else {
    header("Access-Control-Allow-Origin: https://crystalenaps.com");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Handle preflight OPTIONS request.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Only allow POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Get the raw POST data.
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data.']);
    exit;
}

// Validate required fields.
$requiredFields = ['fullName', 'email', 'phone', 'grade', 'message', 'submittedAt'];
foreach ($requiredFields as $field) {
    if (!isset($data[$field]) || empty(trim($data[$field]))) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "Missing or empty field: $field."]);
        exit;
    }
}

// Additional validation for email (if applicable)
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid email address.']);
    exit;
}

// Database configuration – ideally retrieve these from a secure config or environment variables.
$host    = 'localhost';
$db      = 'my_database';      // Change to your database name.
// Load database credentials from external configuration file
$configFile = 'C:/wamp64/config/db_config.ini';
$config = parse_ini_file($configFile, true);
if ($config === false) {
    echo json_encode(["success" => false, "message" => "Failed to load configuration file"]);
    exit();
}
$dbUser = $config['database']['user'];
$dbPass = $config['database']['pass'];
$charset = 'utf8mb4';

// Set up the DSN and options for PDO.
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    http_response_code(500);
    error_log('Database connection failed: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

// Prepare the SQL statement to insert the admission data.
$sql = "INSERT INTO admissions (fullName, email, phone, grade, message, submittedAt)
        VALUES (:fullName, :email, :phone, :grade, :message, :submittedAt)";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':fullName'    => $data['fullName'],
        ':email'       => $data['email'],
        ':phone'       => $data['phone'],
        ':grade'       => $data['grade'],
        ':message'     => $data['message'],
        ':submittedAt' => $data['submittedAt']
    ]);
    echo json_encode(['success' => true, 'message' => 'Admission submitted successfully.']);
} catch (PDOException $e) {
    http_response_code(500);
    error_log('Database error: ' . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'A database error occurred.']);
    exit;
}
?>
