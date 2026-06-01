<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "root";
$database = "finalfood";

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create orders table
$sql_orders = "CREATE TABLE IF NOT EXISTS orders (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    customer_id INT(11) NOT NULL,
    address VARCHAR(300) NOT NULL,
    description VARCHAR(300) NOT NULL,
    date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    payment_type VARCHAR(16) NOT NULL DEFAULT 'Wallet',
    total INT(11) NOT NULL,
    status VARCHAR(25) NOT NULL DEFAULT 'Yet to be delivered',
    deleted TINYINT(4) NOT NULL DEFAULT '0',
    FOREIGN KEY (customer_id) REFERENCES users(id)
)";

// SQL to create order_details table
$sql_order_details = "CREATE TABLE IF NOT EXISTS order_details (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    order_id INT(11) NOT NULL,
    item_id INT(11) NOT NULL,
    quantity INT(11) NOT NULL,
    price INT(11) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (item_id) REFERENCES items(id)
)";

// Execute orders table creation
if ($conn->query($sql_orders) === TRUE) {
    echo "Table orders created successfully<br>";
} else {
    echo "Error creating orders table: " . $conn->error . "<br>";
}

// Execute order_details table creation
if ($conn->query($sql_order_details) === TRUE) {
    echo "Table order_details created successfully<br>";
} else {
    echo "Error creating order_details table: " . $conn->error . "<br>";
}

$conn->close();
?> 