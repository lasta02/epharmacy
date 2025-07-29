<?php include('db/config.php'); ?>
<!DOCTYPE html>
<html>
<head>
    <title>CareBasket - Medicines</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Available Medicines</h1>
    <div class="medicine-container">
        <?php
        $result = $conn->query("SELECT * FROM medicines");
        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="medicine-card">
                <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <h2><?php echo $row['name']; ?></h2>
                <p><?php echo $row['description']; ?></p>
                <p>Rs. <?php echo $row['price']; ?></p>
                <form action="add_to_cart.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Add to Cart</button>
                </form>
            </div>
        <?php } ?>
    </div>
</body>
</html>