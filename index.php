<?php
include 'config.php';
session_start();

// Fetch all products
$result = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Online Computer Store</title>
  <!-- Bootstrap CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container py-4">
  <h1 class="text-center mb-4">💻 Online Computer Store</h1>

  <div class="d-flex justify-content-between mb-3">
    <?php if (isset($_SESSION['user_id'])): ?>
      <div>Welcome! <a href="order_history.php">Order History</a> | <a href="logout.php">Logout</a></div>
    <?php else: ?>
      <div><a href="login.php">Login</a> | <a href="register.php">Register</a></div>
    <?php endif; ?>
    <div><a href="cart.php" class="btn btn-primary">🛒 View Cart</a></div>
  </div>

  <div class="row">
    <?php while ($row = $result->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img 
            src="<?php echo !empty($row['image_url']) ? $row['image_url'] : 'https://via.placeholder.com/300x200?text=No+Image'; ?>" 
            class="card-img-top" 
            alt="<?= htmlspecialchars($row['name']) ?>"
            style="object-fit: cover; height: 200px;">
          
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
            <p class="card-text"><?= htmlspecialchars($row['description']) ?></p>
            <p class="card-text"><strong>$<?= number_format($row['price'], 2) ?></strong></p>
            
            <form method="POST" action="cart.php" class="mt-auto">
              <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
              <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
              <button type="submit" class="btn btn-success w-100">Add to Cart</button>
            </form>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- Optional JS -->
<script src="js/script.js"></script>
</body>
</html>
