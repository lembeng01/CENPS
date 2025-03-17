<?php
// Set session cookie parameters to share the session cookie across subdomains.
session_set_cookie_params([
    'lifetime' => 0,                   // Expires when the browser closes.
    'path'     => '/',                 // Available throughout the domain.
    'domain'   => '.crystalenaps.com', // Leading dot makes it valid for all subdomains.
    'secure'   => true,                // Only send cookie over HTTPS.
    'httponly' => true,                // Prevent JavaScript access.
    'samesite' => 'None'               // Allow cross-site requests.
]);

// Prevent caching of this page.
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Set CORS headers if needed (adjust if admin.php is called via AJAX)
// header("Access-Control-Allow-Origin: https://crystalenaps.com");
// header("Access-Control-Allow-Credentials: true");

session_start();

// Check if the user is logged in.
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not authenticated.
    header("Location: login.html");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Custom PHP Integration</title>
  <!-- Prevent browser caching -->
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />
  <link rel="stylesheet" href="styles.css">
  <!-- Include your script.js which handles UI functions -->
  <script src="script.js" defer></script>
</head>
<body>
  <div class="admin-sidebar">
    <h2 style="cursor:pointer;" onclick="window.location.reload();">Admin Dashboard</h2>
    <ul>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropdown-toggle" onclick="toggleDropdown()">Student List <span class="arrow">&#9662;</span></a>
        <ul class="dropdown-menu">
          <li><a href="#" onclick="setStudentGrade('Nursery')">Nursery</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 1')">Primary 1</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 2')">Primary 2</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 3')">Primary 3</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 4')">Primary 4</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 5')">Primary 5</a></li>
          <li><a href="#" onclick="setStudentGrade('Primary 6')">Primary 6</a></li>
        </ul>
      </li>
      <li><a href="#" data-target="admissions-management">Admissions</a></li>
      <li><a href="#" data-target="content-management">Content</a></li>
      <li><a href="#" data-target="payments-management">Payments</a></li>
      <li><a href="#" data-target="analytics">Analytics</a></li>
      <li><a href="#" data-target="user-management">User Management</a></li>
    </ul>
  </div>

  <div class="admin-main">
    <header class="admin-header">
      <h1>Administration Panel</h1>
      <button class="logoff-btn" onclick="logout()" title="Click to log off">Log Off</button>
    </header>

    <!-- Student List Panel -->
    <section id="student-list" class="admin-section active">
      <h2>Student List</h2>
      <p id="selected-grade-label">Selected Grade: <span id="current-grade-display">None</span></p>
      <div id="student-tables-container">
        <!-- Dynamic student tables will be inserted here via script.js -->
      </div>
      <button class="btn add-row-btn" onclick="addStudentRowForCurrentGrade()" title="Add a new row">Add Row</button>
      <button class="btn save-btn" onclick="downloadStudentTableDataForCurrentGrade()" title="Download CSV for current grade">Download CSV</button>
      <button class="btn save-btn" onclick="updateStudentTableForCurrentGrade()" title="Save changes">Save</button>
      <button class="btn save-btn" onclick="downloadAllStudentData()" title="Download all student data">Download All Student Data</button>
    </section>

    <!-- Admissions Management Panel -->
    <section id="admissions-management" class="admin-section">
      <h2>Admissions Management</h2>
      <p>Review and process admission applications here.</p>
      <table id="admissions-table">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Grade</th>
            <th>Message</th>
            <th>Submitted At</th>
          </tr>
        </thead>
        <tbody id="admissions-table-body">
          <!-- Admissions data will be inserted here via script.js -->
        </tbody>
      </table>
    </section>

    <!-- Additional panels for Content, Payments, Analytics, and User Management can be added similarly -->
  </div>
</body>
</html>
