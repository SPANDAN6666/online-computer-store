<?php
session_start();
include 'config.php';

// Handle add to cart
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If product already in cart, update quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    header("Location: cart.php");
    exit();
}

// Display cart items
$cart_items = $_SESSION['cart'] ?? [];

?>

<h2>Your Shopping Cart</h2>

<?php if (empty($cart_items)): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>Product</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
        <?php
        $total = 0;
        foreach ($cart_items as $product_id => $qty):
            $stmt = $conn->prepare("SELECT name, price FROM products WHERE id = ?");
            $stmt->bind_param("i", $product_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $product = $result->fetch_assoc();

            $subtotal = $product['price'] * $qty;
            $total += $subtotal;
        ?>
            <tr>
                <td><?= $product['name'] ?></td>
                <td><?= $qty ?></td>
                <td>$<?= $product['price'] ?></td>
                <td>$<?= $subtotal ?></td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3"><strong>Total</strong></td>
            <td><strong>$<?= $total ?></strong></td>
        </tr>
    </table>

    <br>
    <a href="checkout.php">Proceed to Checkout</a>
<?php endif; ?>
