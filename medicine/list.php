<?php
require 'db.php';
require 'functions.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Available Healthcares</title>
    <link rel="stylesheet" href="assets/medicine.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<header>
    <div class="logo">
        <img src="https://img.icons8.com/color/48/000000/pills.png" alt="Logo" />
        <span>Care<span class="highlight">Basket</span></span>
    </div>
</header>

<section class="equiments" id="Equiments">
    <h1 class="heading">Available <span>Healthcares Devices</span></h1>
    <div class="box-container">
        <?php while ($product = $result->fetch_assoc()): ?>
            <div class="box">
                <span class="discount">-<?php echo htmlspecialchars($product['discount_percent']); ?>%</span>
                <div class="image">
                    <img src="uploads/<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="icons">
                        <a href="add_to_wishlist.php?product_id=<?php echo $product['id']; ?>" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                        <a href="add_to_cart.php?product_id=<?php echo $product['id']; ?>" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                    </div>
                </div>
                <div class="content">
                    <div class="med-name"><?php echo htmlspecialchars($product['name']); ?></div>
                    <div class="price">Rs <?php echo number_format($product['discount_price'], 2); ?> <span>Rs <?php echo number_format($product['price'], 2); ?></span></div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>
</body>
</html>
