<?php
session_start();
require 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get all orders for this user
$order_query = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$order_query->bind_param("i", $user_id);
$order_query->execute();
$orders_result = $order_query->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Or Bootstrap -->
</head>
<body>
    <h2>My Orders</h2>

    <?php if ($orders_result->num_rows === 0): ?>
        <p>You haven't placed any orders yet.</p>
    <?php else: ?>
        <?php while ($order = $orders_result->fetch_assoc()): ?>
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                <h3>Order #<?= $order['id'] ?></h3>
                <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
                <p><strong>Total:</strong> $<?= number_format($order['total_price'], 2) ?></p>

                <!-- Fetch order items -->
                <?php
                $order_id = $order['id'];
                $item_query = $conn->prepare("
                    SELECT oi.quantity, oi.price, p.name 
                    FROM order_items oi
                    JOIN products p ON oi.product_id = p.id
                    WHERE oi.order_id = ?
                ");
                $item_query->bind_param("i", $order_id);
                $item_query->execute();
                $items = $item_query->get_result();
                ?>
                <table border="1" cellpadding="8" style="width: 100%; margin-top: 10px;">
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php while ($item = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        <?php endwhile; ?>
    <?php endif; ?>
</body>
</html>
