<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit();
}
include(__DIR__ . '/../finalfoody/connect_food.php');
$orders = [];
$sql = "SELECT * FROM delivery_details ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Admin</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .orders-container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.12); padding: 40px; animation: fadeIn 1s; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-header h1 { color: #ff5858; font-size: 2.2rem; }
        .nav-links a { margin-left: 20px; color: #f09819; font-weight: 600; text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover { color: #ff5858; }
        .orders-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .orders-table th, .orders-table td { padding: 14px 10px; border-bottom: 1px solid #eee; text-align: left; }
        .orders-table th { background: #f09819; color: #fff; }
        .orders-table tr:hover { background: #fff3e0; transition: background 0.2s; }
        .order-items { color: #ff5858; font-weight: 500; }
        .no-orders { text-align: center; color: #888; margin-top: 40px; font-size: 1.2rem; }
    </style>
</head>
<body>
    <div class="orders-container">
        <div class="dashboard-header">
            <h1>All Orders</h1>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="orders.php">All Orders</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <?php if (count($orders) > 0): ?>
        <table class="orders-table">
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Items</th>
                <th>Date</th>
                <th>Time</th>
            </tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['first_name'] . ' ' . $order['last_name']; ?></td>
                <td><?php echo $order['email']; ?></td>
                <td><?php echo $order['phone']; ?></td>
                <td><?php echo $order['address'] . ', ' . $order['city'] . ', ' . $order['state'] . ' - ' . $order['zip_code']; ?></td>
                <td class="order-items"><?php echo $order['items']; ?></td>
                <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                <td><?php echo date('h:i A', strtotime($order['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <div class="no-orders">No orders found.</div>
        <?php endif; ?>
    </div>
</body>
</html> 