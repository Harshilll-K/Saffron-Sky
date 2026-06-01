<?php
session_start();

// Set header to return JSON
header('Content-Type: application/json');

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);

// Return JSON response
echo json_encode([
    'isLoggedIn' => $isLoggedIn
]);
?> 