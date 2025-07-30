<?php

include(__DIR__ . '/../dbconnect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Product deleted successfully.";
    } else {
        echo "Failed to delete product.";
    }
}
?>
