<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.php");
    exit();
}

// Database connection
include(__DIR__ . '/connect_food.php');

// Get user's orders
$user_id = $_SESSION['user_id'];
$sql = "SELECT o.*, GROUP_CONCAT(CONCAT(od.quantity, 'x ', i.name, ' (₹', od.price, ')') SEPARATOR ', ') as items
        FROM orders o
        LEFT JOIN order_details od ON o.id = od.order_id
        LEFT JOIN items i ON od.item_id = i.id
        WHERE o.customer_id = ? AND o.deleted = 0
        GROUP BY o.id
        ORDER BY o.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Orders - Food Delivery</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        .order-id {
            font-weight: bold;
            color: #333;
        }
        .order-date {
            color: #666;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-weight: bold;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .order-details {
            margin-top: 10px;
        }
        .order-items {
            margin: 10px 0;
            color: #666;
        }
        .order-total {
            font-weight: bold;
            margin-top: 10px;
            text-align: right;
        }
        .no-orders {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="homepage.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Back to Home
        </a>
        
        <h1>Your Past Orders</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($order = $result->fetch_assoc()): ?>
                <div class="order-card">
                    <div class="order-header">
                        <div>
                            <span class="order-id">Order #<?php echo $order['id']; ?></span>
                            <span class="order-date"><?php echo date('d M Y, h:i A', strtotime($order['date'])); ?></span>
                        </div>
                        <span class="order-status <?php echo strtolower($order['status']) == 'delivered' ? 'status-delivered' : 'status-pending'; ?>">
                            <?php echo $order['status']; ?>
                        </span>
                    </div>
                    
                    <div class="order-details">
                        <div class="order-items">
                            <?php echo $order['items']; ?>
                        </div>
                        <div class="order-total">
                            Total: ₹<?php echo $order['total']; ?>
                        </div>
                        <div>
                            <strong>Delivery Address:</strong> <?php echo $order['address']; ?>
                        </div>
                        <div>
                            <strong>Payment Method:</strong> <?php echo $order['payment_type']; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-orders">
                <i class="fas fa-shopping-bag" style="font-size: 48px; color: #ccc;"></i>
                <h2>No Orders Yet</h2>
                <p>You haven't placed any orders yet. Start ordering now!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
$stmt->close();
$conn->close();
?> 