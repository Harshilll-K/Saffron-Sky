<?php
session_start();
require_once 'connect_food.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get order data from POST request
    $user_id = $_SESSION['user_id'];
    $delivery_address = $_POST['delivery_address'];
    $payment_method = $_POST['payment_method'];
    $cart_items = json_decode($_POST['cart_items'], true);
    
    // Calculate total price
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }
    
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Insert into orders table
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_price, delivery_address, payment_method) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("idss", $user_id, $total_price, $delivery_address, $payment_method);
        $stmt->execute();
        
        // Get the last inserted order ID
        $order_id = $conn->insert_id;
        
        // Insert into order_details table
        $stmt = $conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        
        foreach ($cart_items as $item) {
            $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }
        
        // Commit transaction
        $conn->commit();
        
        // Clear cart
        unset($_SESSION['cart']);
        
        // Return success response
        echo json_encode([
            'success' => true,
            'message' => 'Order placed successfully',
            'order_id' => $order_id
        ]);
        
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        
        // Return error response
        echo json_encode([
            'success' => false,
            'message' => 'Error processing order: ' . $e->getMessage()
        ]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    // Return error for non-POST requests
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}
?> 