<?php
session_start();
include '../config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, category=?, stock=? WHERE id=?");
    $stmt->bind_param("ssdssi", $name, $desc, $price, $cat, $stock, $id);
    $stmt->execute();

    echo "Updated! <a href='dashboard.php'>Back</a>";
}
?>

<h2>Edit Product</h2>
<form method="post">
    Name: <input type="text" name="name" value="<?= $product['name'] ?>"><br><br>
    Description: <textarea name="description"><?= $product['description'] ?></textarea><br><br>
    Price: <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>"><br><br>
    Category: <input type="text" name="category" value="<?= $product['category'] ?>"><br><br>
    Stock: <input type="number" name="stock" value="<?= $product['stock'] ?>"><br><br>
    <button type="submit">Update Product</button>
</form>
