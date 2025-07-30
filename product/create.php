<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include(__DIR__ . '/../dbconnect.php');


if (isset($_POST['create'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $old_price = $_POST['old_price'];
    $image = $_POST['image'];
    $discount = $_POST['discount'];

    $sql = "INSERT INTO products (name, price, old_price, image, discount) VALUES (:name, :price, :old_price, :image, :discount)";
    $stmt = $pdo->prepare($sql);
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':old_price', $old_price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam(':discount', $discount);

    if ($stmt->execute()) {
        echo "Product created successfully.";
    } else {
        echo "Failed to create product.";
    }
}
?>

<form method="POST">
    <input type="text" name="name" placeholder="Product Name" required><br>
    <input type="text" name="price" placeholder="Price" required><br>
    <input type="text" name="old_price" placeholder="Old Price"><br>
    <input type="text" name="image" placeholder="Image URL" required><br>
    <input type="text" name="discount" placeholder="Discount (optional)"><br>
    <button type="submit" name="create">Create Product</button>
</form>
