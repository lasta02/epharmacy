<?php
session_start();

// Check if the cart exists
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Update quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['quantities'] as $id => $qty) {
        $qty = intval($qty);
        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['quantity'] = $qty;
        }
    }
    $_SESSION['cart'] = $cart;
    header("Location: cart.php");
    exit;
}

// Calculate total
$total = 0;
foreach ($cart as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - CareBasket</title>
    <link rel="stylesheet" href="style.css"> <!-- Add your CSS file -->
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; background-color: #f8f9fa; }
        .cart-container { max-width: 800px; margin: auto; background: #fff; padding: 20px; box-shadow: 0 0 10px #ccc; }
        h2 { text-align: center; margin-bottom: 30px; }
        .cart-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ccc; }
        .cart-item input { width: 50px; text-align: center; }
        .total { text-align: right; font-size: 1.2em; margin-top: 20px; }
        .btn { padding: 10px 15px; background: #28a745; color: white; border: none; cursor: pointer; }
        .btn:hover { background: #218838; }
        .remove-btn { background: #dc3545; }
        .remove-btn:hover { background: #c82333; }
        .back-link { display: inline-block; margin-top: 20px; color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Your Shopping Cart</h2>

        <?php if (empty($cart)): ?>
            <p>Your cart is empty. <a href="project.html">Continue Shopping</a></p>
        <?php else: ?>
            <form method="POST" action="cart.php">
                <?php foreach ($cart as $id => $item): ?>
                    <div class="cart-item">
                        <div>
                            <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                            $<?= number_format($item['price'], 2) ?>
                        </div>
                        <div>
                            Qty:
                            <input type="number" name="quantities[<?= $id ?>]" value="<?= $item['quantity'] ?>" min="0">
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="total">Total: $<?= number_format($total, 2) ?></div>

                <br>
                <button type="submit" class="btn">Update Cart</button>
                <a href="checkout.php" class="btn">Proceed to Checkout</a>
            </form>
        <?php endif; ?>

        <a href="project.html" class="back-link">← Back to Home</a>
    </div>
</body>
</html>
