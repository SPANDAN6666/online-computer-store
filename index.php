<?php
include 'config.php';
session_start();

$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Online Computer Store</title>
</head>
<body>
    <h1>Welcome to Our Computer Store</h1>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Hello, you are logged in. <a href="logout.php">Logout</a></p>
    <?php else: ?>
        <p><a href="login.php">Login</a> | <a href="register.php">Register</a></p>
    <?php endif; ?>

    <h2>Products:</h2>
    <div style="display: flex; flex-wrap: wrap;">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div style="border: 1px solid #ccc; margin: 10px; padding: 10px;">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <p>Price: $<?php echo $row['price']; ?></p>
                <form method="post" action="cart.php">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
</html>
