<?php
$host = "localhost";  // Server name
$user = "root";       // Default username
$pass = "root";           // Default password
$db = "finalfood";    // Food ordering database name

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
?> 