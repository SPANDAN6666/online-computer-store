<?php
session_start();
include '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$products = $conn->query("SELECT * FROM products");
?>

<h2>Admin Dashboard</h2>
<p><a href="add_product.php">Add New Product</a> | <a href="view_orders.php">View Orders</a></p>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Name</th><th>Price</th><th>Stock</th><th>Actions</th>
    </tr>
    <?php while ($row = $products->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td>$<?= $row['price'] ?></td>
            <td><?= $row['stock'] ?></td>
            <td>
                <a href="edit_product.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this product?');">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>
