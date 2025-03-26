<?php
// incrementVisitor.php

// Database connection settings – adjust these with your credentials
$servername = "api.crystalenaps.com";
$username   = "admin";
$password   = "test";
$dbname     = "my_database";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die(json_encode(["success" => false, "error" => "Connection failed: " . $conn->connect_error]));
}

// Increment the visitor count
$sql = "UPDATE visitor_stats SET count = count + 1 WHERE id = 1";
if ($conn->query($sql) === TRUE) {
  // Retrieve the new count
  $result = $conn->query("SELECT count FROM visitor_stats WHERE id = 1");
  $row = $result->fetch_assoc();
  $count = $row['count'];
  echo json_encode(["success" => true, "count" => $count]);
} else {
  echo json_encode(["success" => false, "error" => $conn->error]);
}

$conn->close();
?>
