<!-- <?php
session_start();
require 'db.php';
require 'functions.php';

if (!isLoggedIn()) {
    header("Location: auth/login.php");
    exit();
}

$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;

if ($product_id <= 0) {
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id]++;
} else {
    $_SESSION['cart'][$product_id] = 1;
}

header("Location: cart.php");
exit(); -->

<?php
session_start();
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$productId = isset($data['productId']) ? intval($data['productId']) : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false]);
    exit;
}

// Initialize cart session if not exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add product to cart or increase quantity
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]++;
} else {
    $_SESSION['cart'][$productId] = 1;
}

$cartItemCount = array_sum($_SESSION['cart']);

echo json_encode(['success' => true, 'cartItemCount' => $cartItemCount]);
?>
