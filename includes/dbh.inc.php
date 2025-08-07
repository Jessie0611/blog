<?php
// Enable error reporting for debugging during development
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Database credentials
$host = 'localhost';       // or your DB host
$db   = 'thetea';          // your database name
$user = 'root';    // your MySQL username
$pass = '';    // your MySQL password

try { //PDO php data objects - flexible for using various types of db
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection Failed: " . $e->getMessage());
}
