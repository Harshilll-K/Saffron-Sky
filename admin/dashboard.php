<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit();
}
// Connect to DB
$conn = new mysqli('localhost', 'root', 'root', 'finalfood');
if ($conn->connect_error) {
    die('DB connection failed: ' . $conn->connect_error);
}
// Get today's orders
$today = date('Y-m-d');
$orders = [];
$total_orders = 0;
$today_orders = 0;
$revenue = 0;
$sql = "SELECT * FROM delivery_details WHERE DATE(created_at) = '$today' ORDER BY created_at DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
        $revenue += 0; // You can add price if you have it
    }
    $today_orders = count($orders);
}
// Total orders
$res2 = $conn->query("SELECT COUNT(*) as cnt FROM delivery_details");
if ($res2) {
    $total_orders = $res2->fetch_assoc()['cnt'];
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/admin.css">
    <style>
        .dashboard-container { max-width: 1100px; margin: 40px auto; background: #fff; border-radius: 16px; box-shadow: 0 8px 32px 0 rgba(31,38,135,0.12); padding: 40px; animation: fadeIn 1s; }
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .dashboard-header h1 { color: #ff5858; font-size: 2.2rem; }
        .nav-links a { margin-left: 20px; color: #f09819; font-weight: 600; text-decoration: none; transition: color 0.2s; }
        .nav-links a:hover { color: #ff5858; }
        .summary-cards { display: flex; gap: 30px; margin-bottom: 30px; }
        .summary-card { flex: 1; background: linear-gradient(90deg, #ff5858 0%, #f09819 100%); color: #fff; border-radius: 12px; padding: 30px 20px; box-shadow: 0 2px 8px #ff585822; text-align: center; animation: fadeInUp 0.7s; }
        .summary-card h2 { font-size: 2.2rem; margin: 0; }
        .summary-card p { margin: 8px 0 0 0; font-size: 1.1rem; letter-spacing: 1px; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        .orders-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .orders-table th, .orders-table td { padding: 14px 10px; border-bottom: 1px solid #eee; text-align: left; }
        .orders-table th { background: #f09819; color: #fff; }
        .orders-table tr:hover { background: #fff3e0; transition: background 0.2s; }
        .order-items { color: #ff5858; font-weight: 500; }
        .no-orders { text-align: center; color: #888; margin-top: 40px; font-size: 1.2rem; }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="nav-links">
                <a href="dashboard.php">Dashboard</a>
                <a href="orders.php">All Orders</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
        <div class="summary-cards">
            <div class="summary-card">
                <h2><?php echo $today_orders; ?></h2>
                <p>Today's Orders</p>
            </div>
            <div class="summary-card">
                <h2><?php echo $total_orders; ?></h2>
                <p>Total Orders</p>
            </div>
        </div>
        <h2 style="color:#ff5858; margin-bottom:10px;">Today's Orders</h2>
        <?php if (count($orders) > 0): ?>
        <table class="orders-table">
            <tr>
                <th>Order ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Items</th>
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
                <td><?php echo date('h:i A', strtotime($order['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <div class="no-orders">No orders placed today.</div>
        <?php endif; ?>
    </div>
</body>
</html> 