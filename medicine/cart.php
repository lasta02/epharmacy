<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items with product details
$query = $conn->prepare("
    SELECT cart.cart_id, products.name, products.price, cart.quantity 
    FROM cart 
    JOIN products ON cart.product_id = products.product_id 
    WHERE cart.user_id = ?
");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$total = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
</head>
<body>
<h2>Your Cart</h2>
<table border="1" cellpadding="10">
<tr>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Total</th>
<th>Action</th>
</tr>
<?php while($row = $result->fetch_assoc()) { 
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['price']; ?></td>
<td>
<form method="post" action="update_cart.php">
    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
    <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1">
    <button type="submit" name="update">Update</button>
</form>
</td>
<td><?php echo $subtotal; ?></td>
<td>
<form method="post" action="remove_cart.php">
    <input type="hidden" name="cart_id" value="<?php echo $row['cart_id']; ?>">
    <button type="submit" name="remove">Remove</button>
</form>
</td>
</tr>
<?php } ?>
</table>

<h3>Grand Total: <?php echo $total; ?></h3>
<a href="checkout.php">Proceed to Checkout</a>
</body>
</html>
