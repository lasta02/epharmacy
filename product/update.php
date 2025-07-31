<?php

include(__DIR__ . '/../dbconnect.php');

include(__DIR__ . '/../middleware.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the product data from the database
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $product = $stmt->fetch();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get updated values
        $name = $_POST['name'];
        $price = $_POST['price'];
        $old_price = $_POST['old_price'];
        $image = $_POST['image'];
        $discount = $_POST['discount'];

        // Update product
        $update_sql = "UPDATE products SET name = :name, price = :price, old_price = :old_price, image = :image, discount = :discount WHERE id = :id";
        $update_stmt = $pdo->prepare($update_sql);
        
        $update_stmt->bindParam(':name', $name);
        $update_stmt->bindParam(':price', $price);
        $update_stmt->bindParam(':old_price', $old_price);
        $update_stmt->bindParam(':image', $image);
        $update_stmt->bindParam(':discount', $discount);
        $update_stmt->bindParam(':id', $id);

        if ($update_stmt->execute()) {
            echo "Product updated successfully.";
        } else {
            echo "Failed to update product.";
        }
    }
}
?>

<form method="POST">
    <input type="text" name="name" value="<?php echo $product['name']; ?>" required><br>
    <input type="text" name="price" value="<?php echo $product['price']; ?>" required><br>
    <input type="text" name="old_price" value="<?php echo $product['old_price']; ?>"><br>
    <input type="text" name="image" value="<?php echo $product['image']; ?>" required><br>
    <input type="text" name="discount" value="<?php echo $product['discount']; ?>"><br>
    <button type="submit">Update Product</button>
</form>
