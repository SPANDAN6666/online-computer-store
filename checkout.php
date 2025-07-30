<?php
session_start();
include 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must <a href='login.php'>login</a> to place an order.";
    exit();
}

// Check if cart exists
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty. <a href='index.php'>Shop now</a>";
    exit();
}

// Calculate total
$cart = $_SESSION['cart'];
$total = 0;

foreach ($cart as $product_id => $qty) {
    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $subtotal = $product['price'] * $qty;
    $total += $subtotal;
}

// Insert into orders table
$stmt = $conn->prepare("INSERT INTO orders (user_id, total_price) VALUES (?, ?)");
$stmt->bind_param("id", $_SESSION['user_id'], $total);
$stmt->execute();
$order_id = $stmt->insert_id;

// Optional: You can also create an order_items table to store each product per order

// Clear the cart
unset($_SESSION['cart']);
?>

<h2>Order Placed Successfully!</h2>
<p>Your order has been submitted. Order ID: <?= $order_id ?></p>
<p><a href="index.php">Return to Store</a></p>
