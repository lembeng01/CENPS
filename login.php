<?php
// Set session cookie parameters so that the session cookie is available across subdomains
session_set_cookie_params([
    'lifetime' => 0,               // Session cookie expires when the browser closes
    'path'     => '/',             // Available across the entire domain
    'domain'   => '.crystalenaps.com', // Note the leading dot
    'secure'   => true,            // Ensure the cookie is only sent over HTTPS
    'httponly' => true,            // Prevent JavaScript access for security
    'samesite' => 'Lax'            // Adjust as needed (None, Lax, or Strict)
]);

// Set CORS headers for cross-origin requests with credentials
header("Access-Control-Allow-Origin: https://crystalenaps.com"); // Your frontend domain
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Start session after setting cookie parameters
session_start();

// Set Content-Type header for JSON response
header('Content-Type: application/json');

$dsn = "mysql:host=localhost;dbname=my_database;charset=utf8mb4";
$dbUser = "admin";
$dbPass = "test"; // Ensure this is your actual DB password

try {
    $pdo = new PDO($dsn, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve credentials from POST data
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Use prepared statements to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Successful login: regenerate session and store user data
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
