<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$result = $conn->query("SELECT o.id, u.name AS customer, o.total_price, o.order_date FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.order_date DESC");
?>

<h2>All Orders</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Date</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['customer'] ?></td>
            <td>$<?= $row['total_price'] ?></td>
            <td><?= $row['order_date'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>
