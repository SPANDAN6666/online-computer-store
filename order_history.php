<?php
session_start();
include 'config.php';

// Only show to logged-in users
if (!isset($_SESSION['user_id'])) {
    echo "You must <a href='login.php'>login</a> to view order history.";
    exit();
}

// Get orders for the current user
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Your Order History</h2>

<?php if ($result->num_rows === 0): ?>
    <p>You haven't placed any orders yet.</p>
<?php else: ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Order ID</th>
            <th>Total Price</th>
            <th>Order Date</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td>$<?= $row['total_price'] ?></td>
                <td><?= $row['order_date'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php endif; ?>
