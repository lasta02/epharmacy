<?php
session_start();
require 'db.php';
require 'functions.php';

redirectIfNotLoggedIn();

$cart = $_SESSION['cart'] ?? [];

if (!$cart) {
    header("Location: cart.php");
    exit();
}

$total = 0;
$products_in_cart = [];

$ids = implode(',', array_keys($cart));
$sql = "SELECT * FROM products WHERE id IN ($ids)";
$result = $conn->query($sql);

while ($product = $result->fetch_assoc()) {
    $product['quantity'] = $cart[$product['id']];
    $product['subtotal'] = $product['discount_price'] * $product['quantity'];
    $total += $product['subtotal'];
    $products_in_cart[] = $product;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Here you would normally process payment and store order details
    // For demo, just clear cart and show success
    $_SESSION['cart'] = [];
    $message = "Order placed successfully! Thank you for shopping with CareBasket.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout - CareBasket</title>
    <link rel="stylesheet" href="assets/medicine.css">
</head>
<body>
    <h2 style="text-align:center; margin-top:2rem;">Checkout</h2>

    <?php if (!empty($message)): ?>
        <p style="text-align:center; color:green;"><?php echo $message; ?></p>
        <p style="text-align:center;"><a href="index.php">Continue Shopping</a></p>
    <?php else: ?>
        <table style="width:80%; margin: 1rem auto; border-collapse: collapse;" border="1">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Subtotal (Rs)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products_in_cart as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['name']); ?></td>
                        <td><?php echo $p['quantity']; ?></td>
                        <td><?php echo number_format($p['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align:right; font-weight:bold;">Total:</td>
                    <td>Rs <?php echo number_format($total, 2); ?></td>
                </tr>
            </tfoot>
        </table>

        <form method="POST" action="" style="width:80%; margin: 1rem auto; text-align:center;">
            <button type="submit" style="padding: 10px 20px; font-size: 1.2rem;">Place Order</button>
        </form>
    <?php endif; ?>
</body>
</html>
