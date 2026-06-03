<?php
// Database connection
include(__DIR__ . '/connect_food.php');

// SQL to create delivery_details table
$sql = "CREATE TABLE IF NOT EXISTS delivery_details (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(20) NOT NULL,
    instructions TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table delivery_details created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 