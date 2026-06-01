<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Database connection
$host = "localhost";
$username = "root";
$password = "root";
$database = "finalfood"; // Updated to your actual database name
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    echo json_encode(["status" => "error", "message" => "Database connection failed. Please try again later."]);
    exit;
}

// Get JSON data from request
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$required = ['firstName', 'lastName', 'email', 'phone', 'address', 'city', 'state', 'zipCode', 'items'];
foreach ($required as $field) {
    if (empty($data[$field])) {
        echo json_encode(["success" => false, "message" => "Missing field: $field"]);
        exit;
    }
}

// Escape input values
$firstName = $conn->real_escape_string($data['firstName']);
$lastName = $conn->real_escape_string($data['lastName']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$address = $conn->real_escape_string($data['address']);
$city = $conn->real_escape_string($data['city']);
$state = $conn->real_escape_string($data['state']);
$zipCode = $conn->real_escape_string($data['zipCode']);
$instructions = isset($data['instructions']) ? $conn->real_escape_string($data['instructions']) : null;
$items = $conn->real_escape_string($data['items']);

// Insert data into `delivery_details` table
$sql = "INSERT INTO delivery_details (first_name, last_name, email, phone, address, city, state, zip_code, instructions, items) 
        VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$city', '$state', '$zipCode', '$instructions', '$items')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => "Insert failed: " . $conn->error]);
}

$conn->close();
?>
