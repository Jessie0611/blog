<?php
// Enable error reporting for debugging during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database credentials
$host = 'localhost';       // or your DB host
$db   = 'thetea';          // your database name
$user = 'yourUsername';    // your MySQL username
$pass = 'yourPassword';    // your MySQL password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Set character set to UTF-8
$conn->set_charset("utf8mb4");

// Optional: Check connection (for development)
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
