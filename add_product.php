<?php
session_start();
include '../config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $cat = $_POST['category'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, category, stock) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsi", $name, $desc, $price, $cat, $stock);
    $stmt->execute();

    echo "Product added! <a href='dashboard.php'>Back to Dashboard</a>";
}
?>

<h2>Add Product</h2>
<form method="post">
    Name: <input type="text" name="name"><br><br>
    Description: <textarea name="description"></textarea><br><br>
    Price: <input type="number" step="0.01" name="price"><br><br>
    Category: <input type="text" name="category"><br><br>
    Stock: <input type="number" name="stock"><br><br>
    <button type="submit">Add Product</button>
</form>
