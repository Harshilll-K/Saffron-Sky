<?php
$host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: "localhost";  // Server name
$user = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: "root";       // Default username
$pass = getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : "root");           // Default password
$db = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: "login17";      // Your database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?>
