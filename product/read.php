<?php

include(__DIR__ . '/../dbconnect.php');

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll();

foreach ($products as $product) {
    echo "<div class='product'>
            <img src='{$product['image']}' alt='{$product['name']}'>
            <h4>{$product['name']}</h4>
            <p>Price: Rs {$product['price']}</p>
            <p>Old Price: Rs {$product['old_price']}</p>
            <p>Discount: {$product['discount']}</p>
            <a href='update.php?id={$product['id']}'>Edit</a> |
            <a href='delete.php?id={$product['id']}'>Delete</a>
          </div>";
}
?>
