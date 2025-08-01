<?php
session_start();
include(__DIR__ . '/middleware.php');
include(__DIR__ . '/dbconnect.php');

$sql = "SELECT * FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();

$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Medicines</title>
    <link rel="stylesheet" href="medicine.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
   
    <style>
        nav {
            background-color: #2e7d32;
            display: flex;
            color: White;
            gap: 8rem;
            padding: 25px;
        }

        nav input {
            width: 300px;
            padding: 0.5rem;
            border-radius: 5px;
            border: none;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-right: 1rem;
            padding: 0.5rem;
            transition: background 0.3s, color 0.3s;
        }

        nav a:hover {
            background-color: white;
            color: #2e7d32;
            border-radius: 5px;
        }


        :root {
            --pink: #b09dc4;
        }

        .products .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .products .box-container .box {
            flex: 1 1 30rem;
            box-shadow: 0.5rem 1.5rem rgba(0, 0, 0, .1);
            border-radius: .5rem;
            border: 1rem solid rgba(0, 0, 0, .1);
            position: relative;
            background: #fff;
            margin-bottom: 2rem;
        }

        .products .box-container .box .discount {
            position: absolute;
            top: 1rem;
            left: 1rem;
            padding: 0.5rem 1rem;
            font-size: 2rem;
            color: var(--pink);
            background: rgba(255, 51, 153, .05);
            z-index: 1;
            border-radius: .5rem;
        }

        .products .box-container .box .image {
            position: relative;
            text-align: center;
            padding-top: 2rem;
            overflow: hidden;
        }

        .products .box-container .box .image img {
            height: 25rem;
            transition: transform 0.3s;
        }

        .products .box-container .box:hover .image img {
            transform: scale(1.1);
        }

        .products .box-container .box .image .icons {
            position: absolute;
            bottom: 7rem;
            left: 0;
            right: 0;
            display: flex;
            transition: bottom 0.3s;
        }

        .products .box-container .box:hover .image .icons {
            bottom: 0;
        }

        .products .box-container .box .image .icons a {
            height: 5rem;
            line-height: 5rem;
            font-size: 2rem;
            width: 50%;
            background: var(--pink);
            color: #fff;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s;
        }

        .products .box-container .box .image .icons .cart-btn {
            border-left: .1rem solid #fff7;
            border-right: .1rem solid #fff7;
            width: 100%;
        }

        .products .box-container .box .image .icons a:hover {
            background: #333;
        }

        .products .box-container .box .content {
            padding: 2rem;
            text-align: center;
        }

        .products .box-container .box .content .price {
            font-size: 2.5rem;
            color: var(--pink);
            font-weight: bolder;
            padding-top: 1rem;
        }

        .products .box-container .box .content .price span {
            font-size: 1.5rem;
            color: #999;
            font-weight: lighter;
            text-decoration: line-through;
            margin-left: 1rem;
        }

        .products .box-container .box .content .med-name {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .heading {
            text-align: center;
            font-size: 3rem;
            margin: 2rem 0;
        }

        .heading span {
            color: var(--pink);
        }

        body {
            background: #f9f9f9;
            font-family: Arial, sans-serif;
        }

        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            transition: right 0.3s ease;
            z-index: 1500;
            display: flex;
            flex-direction: column;
        }

        .cart-sidebar.active {
            right: 0;
        }

        .cart-header {
            padding: 25px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #666;
        }

        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
        }

        .cart-item {
            display: flex;
            gap: 1rem;
            padding: 1rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .cart-item-price {
            color: #2563eb;
            font-weight: 600;
        }

        .cart-item-quantity {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .quantity-btn {
            background: #f3f4f6;
            border: none;
            width: 25px;
            height: 25px;
            border-radius: 3px;
            cursor: pointer;
            font-weight: 600;
        }

        .cart-footer {
            padding: 1.5rem;
            border-top: 1px solid #e5e7eb;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .checkout-btn:hover {
            background: #1d4ed8;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 40px;
            background-color: beige;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        #cart-count {
            position: absolute;
            top: -10px;
            right: -10px;
            background: red;
            color: white;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        .cart-icon {
            position: relative;
            margin-left: 20px;
            font-size: 24px;
        }

        .cart-icon a {
            color: #2e7d32;
            text-decoration: none;
            position: relative;
        }
    </style>
</head>

<body>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h3>Shopping Cart</h3>
            <button class="cart-close" id="cartClose"><i class="fas fa-times"></i></button>
        </div>
        <div class="cart-items" id="cartItems"></div>
        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">Rs 0.00</span>
            </div>
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="logo">
            <img src="https://img.icons8.com/color/48/000000/pills.png" alt="Logo" />
            <span>Care<span class="highlight">Basket</span></span>
        </div>
        <div class="cart-icon">
            <a href="#" id="cartIcon">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-count">0</span>
            </a>
        </div>
    </header>
    <nav>
        <a href="#General">General</a>
        <a href="#Antibiotics & Antiallergy">Antibiotics & Antiallegery</a>
        <a href="#Pressure">Pressure</a>
        <a href="#Cholesterol">Cholesterol</a>
        <a href="#Anticongulants">Anticongulants</a>
        <a href="#Thyroid">Thyroid</a>
        <a href="#Drops">Drops</a>
        <a href="#Ointments">Ointments</a>
        <input type="text" name="" id="" placeholder="Search medicines">
    </nav>
    <section class="products" id="products">


        <!-- General Part -->
        <h1 class="heading">Available <span>Medicines</span></h1>
        <div class="general" id="General">
            <div class="box-container">
                 <?php foreach ($products as $product): ?>
            <div class="box" data-id="<?php echo $product['id']; ?>" 
                 data-price="<?php echo $product['price']; ?>" 
                 data-name="<?php echo $product['name']; ?>" 
                 data-image="<?php echo $product['image']; ?>">
                <span class="discount">-<?php echo $product['discount']; ?>%</span>
                <div class="image">
                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    <div class="icons">
                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                        <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                    </div>
                </div>
                <div class="content">
                    <div class="med-name"><?php echo $product['name']; ?></div>
                    <div class="price">Rs <?php echo $product['price']; ?> <span>Rs <?php echo $product['old_price']; ?></span></div>
                </div>
            </div>
        <?php endforeach; ?>
                <div class="box" data-id="16" data-price="27" data-name="Sinex"
                    data-image="https://nepmed-uat.s3.ap-southeast-1.amazonaws.com/products/600x600/90576/sinex_tablet_10_s_BTNxNA%241.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://nepmed-uat.s3.ap-southeast-1.amazonaws.com/products/600x600/90576/sinex_tablet_10_s_BTNxNA%241.jpg"
                            alt="sinex">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Sinex</div>
                        <div class="price">Rs 27 <span>Rs 30</span></div>
                    </div>
                </div>
                <div class="box" data-id="17" data-price="27" data-name="Flexon"
                    data-image="https://www.nepmeds.com.np/public/files/flexon-2-20200123084207-fmMXeu.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.nepmeds.com.np/public/files/flexon-2-20200123084207-fmMXeu.jpg"
                            alt="Flexon">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Flexon</div>
                        <div class="price">Rs 27 <span>Rs 30</span></div>
                    </div>
                </div>

                <div class="box" data-id="18" data-price="27" data-name="Niko"
                    data-image="https://www.nepmeds.com.np/public/files/niko-suspension-1-20200123085359-nBNIO9.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.nepmeds.com.np/public/files/niko-suspension-1-20200123085359-nBNIO9.jpg"
                            alt="Niko ">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Niko</div>
                        <div class="price">Rs 27<span>Rs 30 </span></div>
                    </div>
                </div>

                <div class="box" data-id="19" data-price="9" data-name="Niko Tablet"
                    data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRFNI4X1hla6y-f4LKXPgIVvgs3N0VVDoPptA&s">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRFNI4X1hla6y-f4LKXPgIVvgs3N0VVDoPptA&s"
                            alt="Niko tablet">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Niko Tablet</div>
                        <div class="price">Rs 9 <span>Rs 10</span></div>
                    </div>
                </div>

                <div class="box" data-id="20" data-price="9" data-name="ORS"
                    data-image="https://crs.org.np/uploads/products/XlVPBN6ub0YoT65m3njP4ELru.png">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://crs.org.np/uploads/products/XlVPBN6ub0YoT65m3njP4ELru.png" alt="ORS">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">ORS</div>
                        <div class="price">Rs 9<span>Rs 10</span></div>
                    </div>
                </div>

                <div class="box" data-id="21" data-price="7.2" data-name="Pantoprazole"
                    data-image="https://www.nepmeds.com.np/public/840-840/files/pantop-2-20200213180649-v7sDEm.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.nepmeds.com.np/public/840-840/files/pantop-2-20200213180649-v7sDEm.jpg"
                            alt="Pantop">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Pantoprazole </div>
                        <div class="price">Rs 7.2 <span>Rs 8</span></div>
                    </div>
                </div>

                <div class="box" data-id="22" data-price="107.1" data-name="Pantafast DSR"
                    data-image="https://5.imimg.com/data5/SELLER/Default/2022/6/OY/UD/MU/78005781/mankind-pantafast-dsr-capsules.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://5.imimg.com/data5/SELLER/Default/2022/6/OY/UD/MU/78005781/mankind-pantafast-dsr-capsules.jpg"
                            alt="Pantafast Dsr">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to
                                cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Pantafast DSR </div>
                        <div class="price">Rs 107.1 <span>Rs 119</span></div>
                    </div>
                </div>
            </div>

            <!-- Antibiotics & Antiallegery -->
            <section class="products" id="products">
                <h1 class="heading">Available <span>Medicines</span></h1>
                <div class="antibiotics & antiallergy" id="Antibiotics & Antiallergy"></div>
                <div class="box-container">
                      
                    <div class="box" data-id="23" data-price="121.5" data-name="Fexomed 180"
                        data-image="https://5.imimg.com/data5/SELLER/Default/2022/8/OG/PW/BK/83563136/fexomed-180-fexofenadine-hcl-tablets-500x500.jpg">
                        <span class="discount">-10%</span>
                        <div class="image">
                            <img src="https://5.imimg.com/data5/SELLER/Default/2022/8/OG/PW/BK/83563136/fexomed-180-fexofenadine-hcl-tablets-500x500.jpg"
                                alt="Fexomed">
                            <div class="icons">
                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i>
                                    Add to cart</a>
                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="med-name">Fexomed 180</div>
                            <div class="price">Rs 121.5 <span>Rs 135</span></div>
                        </div>
                    </div>

                    <div class="box" data-id="24" data-price="251.85" data-name="Allerga"
                        data-image="https://www.nepmeds.com.np/public/840-840/files/allegra-20200120093528-dwtEsm.jpg">
                        <span class="discount">-10%</span>
                        <div class="image">
                            <img src="https://www.nepmeds.com.np/public/840-840/files/allegra-20200120093528-dwtEsm.jpg"
                                alt="Allerga">
                            <div class="icons">
                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i>
                                    Add to cart</a>
                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="med-name">Allerga</div>
                            <div class="price">Rs 251.85 <span>Rs 279.83</span></div>
                        </div>
                    </div>

                    <div class="box" data-id="25" data-price="81" data-name="Curemox"
                        data-image="https://5.imimg.com/data5/SELLER/Default/2023/8/334720023/HU/RH/SH/110822645/imresizer-1691832380466-500x500.jpg">
                        <span class="discount">-10%</span>
                        <div class="image">
                            <img src="https://5.imimg.com/data5/SELLER/Default/2023/8/334720023/HU/RH/SH/110822645/imresizer-1691832380466-500x500.jpg"
                                alt="Curemox">
                            <div class="icons">
                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i>
                                    Add to cart</a>
                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="med-name">Curemox</div>
                            <div class="price">Rs 81<span>Rs 90</span></div>
                        </div>
                    </div>

                    <div class="box" data-id="26" data-price="135" data-name="Azithral"
                        data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNCJiLOy40qUBn8_ywBV13fjM84yDHTyFvow&s">
                        <span class="discount">-10%</span>
                        <div class="image">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSNCJiLOy40qUBn8_ywBV13fjM84yDHTyFvow&s"
                                alt="Azithral">
                            <div class="icons">
                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i>
                                    Add to cart</a>
                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="med-name">Azithral</div>
                            <div class="price">Rs 135 <span>Rs 150 </span></div>
                        </div>
                    </div>

                    <div class="box" data-id="27" data-price="25.2" data-name="Metrogyl"
                        data-image="https://zeelabpharmacy.com/uploads/other_brand_image/Zee6732f88d5bab2.webp">
                        <span class="discount">-10%</span>
                        <div class="image">
                            <img src="https://zeelabpharmacy.com/uploads/other_brand_image/Zee6732f88d5bab2.webp"
                                alt="Metrogyl">
                            <div class="icons">
                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i>
                                    Add to cart</a>
                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="med-name">Metrogyl</div>
                            <div class="price">Rs 25.2 <span>Rs 28</span></div>
                        </div>
                    </div>

                    <!-- Pressure -->
                    <section class="products" id="products">
                        <h1 class="heading">Available <span>Medicines</span></h1>
                        <div class="pressure" id="Pressure"></div>
                        <div class="box-container">
                            <div class="box" data-id="28" data-price="67.5" data-name="Mylod 5"
                                data-image="https://nepmed.s3.ap-southeast-1.amazonaws.com/products/600x600/89723/mylod_5mg_tablet_15_s_1.jpg">
                                <span class="discount">-10%</span>
                                <div class="image">
                                    <img src="https://nepmed.s3.ap-southeast-1.amazonaws.com/products/600x600/89723/mylod_5mg_tablet_15_s_1.jpg"
                                        alt="Mylod">
                                    <div class="icons">
                                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="med-name">Mylod 5</div>
                                    <div class="price">Rs 67.5 <span>Rs 75</span></div>
                                </div>
                            </div>

                            <div class="box" data-id="29" data-price="67.5" data-name="Amlod5"
                                data-image="https://lh3.googleusercontent.com/proxy/QjFpQP9rHlGI3AfL_p6nRps0nEM2rpEBk3Oi_xf70_3Dfvyee_QbDpXaRM3ACkkLzWCs9zjtebhKex8XvMlLKrOYHk4ngQcer4cgLL_8frGmFdzfo-R7nkMCsALUjqV7pa2z5EWcCntzETjf-4-ANZTAG-nzzlVZagcs2nKbFEOx">
                                <span class="discount">-10%</span>
                                <div class="image">
                                    <img src="https://lh3.googleusercontent.com/proxy/QjFpQP9rHlGI3AfL_p6nRps0nEM2rpEBk3Oi_xf70_3Dfvyee_QbDpXaRM3ACkkLzWCs9zjtebhKex8XvMlLKrOYHk4ngQcer4cgLL_8frGmFdzfo-R7nkMCsALUjqV7pa2z5EWcCntzETjf-4-ANZTAG-nzzlVZagcs2nKbFEOx"
                                        alt="Amlod">
                                    <div class="icons">
                                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="med-name">Amlod5</div>
                                    <div class="price">Rs 67.5 <span>Rs 75 </span></div>
                                </div>
                            </div>

                            <div class="box" data-id="30" data-price="118.50" data-name="Amtas 5"
                                data-image="https://lh4.googleusercontent.com/proxy/rTbq5etvTo7PnNZf4evsOyBQT8i0wRHn7YKEnDj6lpCE5oMH7OozDvj9pUjJO4C76al7DNzbutDHp3So00xI9Hovi7Ao1Tf38jAHGFUXfanX3eLzfLl2oF0bir5wCKMXkCNeRF7M6yg1obQ4ckM94bmBhC_n4dBfrcrlFewgxxt_">
                                <span class="discount">-10%</span>
                                <div class="image">
                                    <img src="https://lh4.googleusercontent.com/proxy/rTbq5etvTo7PnNZf4evsOyBQT8i0wRHn7YKEnDj6lpCE5oMH7OozDvj9pUjJO4C76al7DNzbutDHp3So00xI9Hovi7Ao1Tf38jAHGFUXfanX3eLzfLl2oF0bir5wCKMXkCNeRF7M6yg1obQ4ckM94bmBhC_n4dBfrcrlFewgxxt_"
                                        alt="Amtas">
                                    <div class="icons">
                                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="med-name">Amtas 5</div>
                                    <div class="price">Rs 118.50<span>Rs 127.42</span></div>
                                </div>
                            </div>

                            <div class="box" data-id="31" data-price="95.4" data-name="Losartan"
                                data-image="https://fastcdn.pro/FileGallery/zagrosdarou.com/%D8%AF%D8%A7%D8%B1%D9%88%D9%87%D8%A7%DB%8C-%DA%A9%D8%A7%D9%87%D9%86%D8%AF%D9%87-%D9%81%D8%B4%D8%A7%D8%B1-%D8%AE%D9%88%D9%86/%D9%84%D9%88%D8%B2%D8%A7%D8%B1%D8%AA%D8%A7%D9%86_50_%D9%85%DB%8C%D9%84%DB%8C_%DA%AF%D8%B1%D9%85/3D-Box-Losartan.png">
                                <span class="discount">-10%</span>
                                <div class="image">
                                    <img src="https://fastcdn.pro/FileGallery/zagrosdarou.com/%D8%AF%D8%A7%D8%B1%D9%88%D9%87%D8%A7%DB%8C-%DA%A9%D8%A7%D9%87%D9%86%D8%AF%D9%87-%D9%81%D8%B4%D8%A7%D8%B1-%D8%AE%D9%88%D9%86/%D9%84%D9%88%D8%B2%D8%A7%D8%B1%D8%AA%D8%A7%D9%86_50_%D9%85%DB%8C%D9%84%DB%8C_%DA%AF%D8%B1%D9%85/3D-Box-Losartan.png"
                                        alt="Losartan">
                                    <div class="icons">
                                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="med-name">Losartan</div>
                                    <div class="price">Rs 95.4 <span>Rs 106 </span></div>
                                </div>
                            </div>

                            <div class="box" data-id="32" data-price="85.05" data-name="Metloc"
                                data-image="https://5.imimg.com/data5/SELLER/Default/2024/5/420622038/AO/JM/PW/217401229/metroprolol-25-mg-tablets-500x500.jpg">
                                <span class="discount">-10%</span>
                                <div class="image">
                                    <img src="https://5.imimg.com/data5/SELLER/Default/2024/5/420622038/AO/JM/PW/217401229/metroprolol-25-mg-tablets-500x500.jpg"
                                        alt="Metloc">
                                    <div class="icons">
                                        <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="med-name">Metloc</div>
                                    <div class="price">Rs 85.05 <span>Rs 94.5</span></div>
                                </div>
                            </div>

                            <!-- Cholesterol -->
                            <section class="products" id="products">
                                <h1 class="heading">Available <span>Medicines</span></h1>
                                <div class="cholesterol" id="Cholesterol"></div>
                                <div class="box-container">
                                    <div class="box" data-id="33" data-price="214.20" data-name="Rovas"
                                        data-image="https://www.nepmeds.com.np/public/files/5DED4D2319379FD-rovas_5mg_tablet_14_s_1.jpg">
                                        <span class="discount">-10%</span>
                                        <div class="image">
                                            <img src="https://www.nepmeds.com.np/public/files/5DED4D2319379FD-rovas_5mg_tablet_14_s_1.jpg"
                                                alt="Rovas">
                                            <div class="icons">
                                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                        class="fas fa-shopping-cart"></i> Add to cart</a>
                                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="med-name">Rovas</div>
                                            <div class="price">Rs 214.20 <span>Rs 238 </span></div>
                                        </div>
                                    </div>

                                    <div class="box" data-id="34" data-price="235.8" data-name="Rosufit"
                                        data-image="https://www.netmeds.com/images/product-v1/600x600/406593/rosufit_10mg_tablet_15_s_0.jpg">
                                        <span class="discount">-10%</span>
                                        <div class="image">
                                            <img src="https://www.netmeds.com/images/product-v1/600x600/406593/rosufit_10mg_tablet_15_s_0.jpg"
                                                alt="Rosufit">
                                            <div class="icons">
                                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                        class="fas fa-shopping-cart"></i> Add to cart</a>
                                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="med-name">Rosufit</div>
                                            <div class="price">Rs 235.8 <span>Rs 262 </span></div>
                                        </div>
                                    </div>

                                    <div class="box" data-id="35" data-price="97.20" data-name="Astat"
                                        data-image="https://test.jiwantahealth.com/wp-content/uploads/2020/10/jiwanta-astat-10-1-480x480.jpg">
                                        <span class="discount">-10%</span>
                                        <div class="image">
                                            <img src="https://test.jiwantahealth.com/wp-content/uploads/2020/10/jiwanta-astat-10-1-480x480.jpg"
                                                alt="Astat">
                                            <div class="icons">
                                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                        class="fas fa-shopping-cart"></i> Add to cart</a>
                                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="med-name">Astat</div>
                                            <div class="price">Rs 97.20 <span>Rs 108 </span></div>
                                        </div>
                                    </div>

                                    <div class="box" data-id="36" data-price="250.20" data-name="Arvast"
                                        data-image="https://www.practostatic.com/practopedia-images/v3/res-750/arvast-10mg-tablet-15-s_c0774461-3dca-408c-a14a-a464125c8f32.JPG">
                                        <span class="discount">-10%</span>
                                        <div class="image">
                                            <img src="https://www.practostatic.com/practopedia-images/v3/res-750/arvast-10mg-tablet-15-s_c0774461-3dca-408c-a14a-a464125c8f32.JPG"
                                                alt="Arvast">
                                            <div class="icons">
                                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                        class="fas fa-shopping-cart"></i> Add to cart</a>
                                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="med-name">Arvast</div>
                                            <div class="price">Rs 250.20 <span>Rs 278 </span></div>
                                        </div>
                                    </div>

                                    <div class="box" data-id="37" data-price="126.78" data-name="Sartel"
                                        data-image="https://www.nepmeds.com.np/public/files/121453E2C6D5A58-SAR0011_1_1.webp">
                                        <span class="discount">-10%</span>
                                        <div class="image">
                                            <img src="https://www.nepmeds.com.np/public/files/121453E2C6D5A58-SAR0011_1_1.webp"
                                                alt="Sartel">
                                            <div class="icons">
                                                <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                        class="fas fa-shopping-cart"></i> Add to cart</a>
                                                <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <div class="med-name">Sartel</div>
                                            <div class="price">Rs 126.78 <span>Rs 140.87 </span></div>
                                        </div>
                                    </div>

                                    <!-- Anticongulants -->
                                    <section class="products" id="products">
                                        <h1 class="heading">Available <span>Medicines</span></h1>
                                        <div class="anticongulants" id="Anticongulants"></div>
                                        <div class="box-container">
                                            <div class="box" data-id="38" data-price="126" data-name="Levonex"
                                                data-image="https://pronexpharma.co.uk/Basharweb/Product/908d89ff-dc70-4fe7-8019-c0c3447dd961.jpg">
                                                <span class="discount">-10%</span>
                                                <div class="image">
                                                    <img src="https://pronexpharma.co.uk/Basharweb/Product/908d89ff-dc70-4fe7-8019-c0c3447dd961.jpg"
                                                        alt="Levonex">
                                                    <div class="icons">
                                                        <a href="#" title="Add to Wishlist"><i
                                                                class="fas fa-heart"></i></a>
                                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="med-name">Levonex</div>
                                                    <div class="price">Rs 126 <span>Rs 140</span></div>
                                                </div>
                                            </div>

                                            <div class="box" data-id="39" data-price="88" data-name="Ecosprin"
                                                data-image="https://livinghealthy24.com/manager/uploads/510002890_ECOSPRIN_AV_75_40_MG_CAP_(10_CAP).jpg">
                                                <span class="discount">-10%</span>
                                                <div class="image">
                                                    <img src="https://livinghealthy24.com/manager/uploads/510002890_ECOSPRIN_AV_75_40_MG_CAP_(10_CAP).jpg"
                                                        alt="Ecosprin">
                                                    <div class="icons">
                                                        <a href="#" title="Add to Wishlist"><i
                                                                class="fas fa-heart"></i></a>
                                                        <a href="#" class="cart-btn" title="Add to Cart"><i
                                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="med-name">Ecosprin</div>
                                                    <div class="price">Rs 88<span>Rs 98</span></div>
                                                </div>
                                            </div>

                                            <div class="box" data-id="40" data-price="810" data-name="Rivarox"
                                                data-image="https://modernpharmaye.com/upload/products/packs/original/6fed58d36719d73941cee1bd0d21cad6.jpeg">
                                                <span class="discount">-10%</span>
                                                <div class="image">
                                                    <img src="https://modernpharmaye.com/upload/products/packs/original/6fed58d36719d73941cee1bd0d21cad6.jpeg"
                                                        alt="Rivarox">
                                                    <div class="icons">
                                                        <a href="#" title="Add to Wishlist"><i
                                                                class="fas fa-heart"></i></a>
                                                        <a href="cart.js" class="cart-btn" title="Add to Cart"><i
                                                                class="fas fa-shopping-cart"></i> Add to cart</a>
                                                        <a href="#" title="Share"><i class="fas fa-share"></i></a>
                                                    </div>
                                                </div>
                                                <div class="content">
                                                    <div class="med-name">Rivarox</div>
                                                    <div class="price">Rs 810 <span>Rs 900</span></div>
                                                </div>
                                            </div>


                                            <!-- Thyroid -->
                                            <section class="products" id="products">
                                                <h1 class="heading">Available <span>Medicines</span></h1>
                                                <div class="thyroid" id="Thyroid"></div>
                                                <div class="box-container">
                                                    <div class="box" data-id="41" data-price="225" data-name="Thyronorm"
                                                        data-image="https://m.media-amazon.com/images/I/41L8-Kx6mrL.jpg_BO30,255,255,255_UF900,850_SR1910,1000,0,C_QL100_.jpg">
                                                        <span class="discount">-10%</span>
                                                        <div class="image">
                                                            <img src="https://m.media-amazon.com/images/I/41L8-Kx6mrL.jpg_BO30,255,255,255_UF900,850_SR1910,1000,0,C_QL100_.jpg"
                                                                alt="Thyronorm">
                                                            <div class="icons">
                                                                <a href="#" title="Add to Wishlist"><i
                                                                        class="fas fa-heart"></i></a>
                                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                                        class="fas fa-shopping-cart"></i> Add to
                                                                    cart</a>
                                                                <a href="#" title="Share"><i
                                                                        class="fas fa-share"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <div class="med-name">Thyronorm</div>
                                                            <div class="price">Rs 225 <span>Rs 250 </span></div>
                                                        </div>
                                                    </div>

                                                    <div class="box" data-id="42" data-price="27" data-name="Thyrolar"
                                                        data-image="https://www.nepmeds.com.np/public/files/thyrolar-25-1-20200213182222-Kd1yc0.jpg">
                                                        <span class="discount">-10%</span>
                                                        <div class="image">
                                                            <img src="https://www.nepmeds.com.np/public/files/thyrolar-25-1-20200213182222-Kd1yc0.jpg"
                                                                alt="Thyrolar">
                                                            <div class="icons">
                                                                <a href="#" title="Add to Wishlist"><i
                                                                        class="fas fa-heart"></i></a>
                                                                <a href="#" class="cart-btn" title="Add to Cart"><i
                                                                        class="fas fa-shopping-cart"></i> Add to
                                                                    cart</a>
                                                                <a href="#" title="Share"><i
                                                                        class="fas fa-share"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <div class="med-name">Thyrolar</div>
                                                            <div class="price">Rs 27<span>Rs 30 </span></div>
                                                        </div>
                                                    </div>

                                                    <!-- Drops -->
                                                    <section class="products" id="products">
                                                        <h1 class="heading">Available <span>Medicines</span></h1>
                                                        <div class="drops" id="Drops"></div>
                                                        <div class="box-container">
                                                            <div class="box" data-id="43" data-price="180"
                                                                data-name="Eva Tears"
                                                                data-image="https://www.nepmeds.com.np/public/840-840/files/8AB66FC09E27794-eva-tears.jpg">
                                                                <span class="discount">-10%</span>
                                                                <div class="image">
                                                                    <img src="https://www.nepmeds.com.np/public/840-840/files/8AB66FC09E27794-eva-tears.jpg"
                                                                        alt="Eva Tears">
                                                                    <div class="icons">
                                                                        <a href="#" title="Add to Wishlist"><i
                                                                                class="fas fa-heart"></i></a>
                                                                        <a href="#" class="cart-btn"
                                                                            title="Add to Cart"><i
                                                                                class="fas fa-shopping-cart"></i> Add to
                                                                            cart</a>
                                                                        <a href="#" title="Share"><i
                                                                                class="fas fa-share"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="med-name">Eva Tears</div>
                                                                    <div class="price">Rs 180 <span>Rs 200</span></div>
                                                                </div>
                                                            </div>

                                                            <div class="box" data-id="44" data-price="180"
                                                                data-name="Refresh Tears"
                                                                data-image="https://static-01.daraz.com.np/p/4c24a13ed46d950c1dc5f4201fd85cef.jpg">
                                                                <span class="discount">-10%</span>
                                                                <div class="image">
                                                                    <img src="https://static-01.daraz.com.np/p/4c24a13ed46d950c1dc5f4201fd85cef.jpg"
                                                                        alt="Refresh Tears">
                                                                    <div class="icons">
                                                                        <a href="#" title="Add to Wishlist"><i
                                                                                class="fas fa-heart"></i></a>
                                                                        <a href="#" class="cart-btn"
                                                                            title="Add to Cart"><i
                                                                                class="fas fa-shopping-cart"></i> Add to
                                                                            cart</a>
                                                                        <a href="#" title="Share"><i
                                                                                class="fas fa-share"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="med-name">Refresh Tears</div>
                                                                    <div class="price">Rs 180 <span>Rs200 </span></div>
                                                                </div>
                                                            </div>

                                                            <div class="box" data-id="45" data-price="180"
                                                                data-name="Tobrex"
                                                                data-image="https://www.supermart.ng/cdn/shop/files/spls4073_40cf9eb2-e797-4332-8f1a-3946ce22b04a.jpg?v=1712667804">
                                                                <span class="discount">-10%</span>
                                                                <div class="image">
                                                                    <img src="https://www.supermart.ng/cdn/shop/files/spls4073_40cf9eb2-e797-4332-8f1a-3946ce22b04a.jpg?v=1712667804"
                                                                        alt="Tobrex">
                                                                    <div class="icons">
                                                                        <a href="#" title="Add to Wishlist"><i
                                                                                class="fas fa-heart"></i></a>
                                                                        <a href="#" class="cart-btn"
                                                                            title="Add to Cart"><i
                                                                                class="fas fa-shopping-cart"></i> Add to
                                                                            cart</a>
                                                                        <a href="#" title="Share"><i
                                                                                class="fas fa-share"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="med-name">Tobrex</div>
                                                                    <div class="price">Rs 180 <span>Rs 200</span></div>
                                                                </div>
                                                            </div>

                                                            <div class="box" data-id="46" data-price="108"
                                                                data-name="Oflox"
                                                                data-image="https://www.practostatic.com/practopedia-images/v3/res-750/oflox-e-e-drops-5ml_efd13d40-23ab-4d57-9ad3-9c47b8849bc2.JPG">
                                                                <span class="discount">-10%</span>
                                                                <div class="image">
                                                                    <img src="https://www.practostatic.com/practopedia-images/v3/res-750/oflox-e-e-drops-5ml_efd13d40-23ab-4d57-9ad3-9c47b8849bc2.JPG"
                                                                        alt="Oflox">
                                                                    <div class="icons">
                                                                        <a href="#" title="Add to Wishlist"><i
                                                                                class="fas fa-heart"></i></a>
                                                                        <a href="#" class="cart-btn"
                                                                            title="Add to Cart"><i
                                                                                class="fas fa-shopping-cart"></i> Add to
                                                                            cart</a>
                                                                        <a href="#" title="Share"><i
                                                                                class="fas fa-share"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="med-name">Oflox</div>
                                                                    <div class="price">Rs 108 <span>Rs 120 </span></div>
                                                                </div>
                                                            </div>

                                                            <div class="box" data-id="47" data-price="149.4"
                                                                data-name="Waxolve"
                                                                data-image="https://m.media-amazon.com/images/I/61V4gcjb4rL.jpg">
                                                                <span class="discount">-10%</span>
                                                                <div class="image">
                                                                    <img src="https://m.media-amazon.com/images/I/61V4gcjb4rL.jpg"
                                                                        alt="Waxolve">
                                                                    <div class="icons">
                                                                        <a href="#" title="Add to Wishlist"><i
                                                                                class="fas fa-heart"></i></a>
                                                                        <a href="#" class="cart-btn"
                                                                            title="Add to Cart"><i
                                                                                class="fas fa-shopping-cart"></i> Add to
                                                                            cart</a>
                                                                        <a href="#" title="Share"><i
                                                                                class="fas fa-share"></i></a>
                                                                    </div>
                                                                </div>
                                                                <div class="content">
                                                                    <div class="med-name">Waxolve</div>
                                                                    <div class="price">Rs 149.4 <span>Rs 166</span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Ointments -->
                                                            <section class="products" id="products">
                                                                <h1 class="heading">Available <span>Medicines</span>
                                                                </h1>
                                                                <div class="ointments" id="Ointments"></div>
                                                                <div class="box-container">
                                                                    <div class="box" data-id="48" data-price="229.5"
                                                                        data-name="Candid-B"
                                                                        data-image="https://www.mobimeds.com.np/uploads/product/candid-b-cream-20g.jpg">
                                                                        <span class="discount">-10%</span>
                                                                        <div class="image">
                                                                            <img src="https://www.mobimeds.com.np/uploads/product/candid-b-cream-20g.jpg"
                                                                                alt="Candid-B">
                                                                            <div class="icons">
                                                                                <a href="#" title="Add to Wishlist"><i
                                                                                        class="fas fa-heart"></i></a>
                                                                                <a href="#" class="cart-btn"
                                                                                    title="Add to Cart"><i
                                                                                        class="fas fa-shopping-cart"></i>
                                                                                    Add to cart</a>
                                                                                <a href="#" title="Share"><i
                                                                                        class="fas fa-share"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="med-name">Candid-B</div>
                                                                            <div class="price">Rs 229.5 <span>Rs
                                                                                    255</span></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="box" data-id="49" data-price="144"
                                                                        data-name="Moov Ointment"
                                                                        data-image="https://m.media-amazon.com/images/I/41LAuliu1QL._UF1000,1000_QL80_.jpg">
                                                                        <span class="discount">-10%</span>
                                                                        <div class="image">
                                                                            <img src="https://m.media-amazon.com/images/I/41LAuliu1QL._UF1000,1000_QL80_.jpg"
                                                                                alt="Moov Ointment">
                                                                            <div class="icons">
                                                                                <a href="#" title="Add to Wishlist"><i
                                                                                        class="fas fa-heart"></i></a>
                                                                                <a href="#" class="cart-btn"
                                                                                    title="Add to Cart"><i
                                                                                        class="fas fa-shopping-cart"></i>
                                                                                    Add to cart</a>
                                                                                <a href="#" title="Share"><i
                                                                                        class="fas fa-share"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="med-name">Moov Ointment</div>
                                                                            <div class="price">Rs 144 <span>Rs 160
                                                                                </span></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="box" data-id="50" data-price="450"
                                                                        data-name="Moov Spray"
                                                                        data-image="https://m.media-amazon.com/images/I/51skvseP2NL.jpg">
                                                                        <span class="discount">-10%</span>
                                                                        <div class="image">
                                                                            <img src="https://m.media-amazon.com/images/I/51skvseP2NL.jpg"
                                                                                alt="Moov Spray">
                                                                            <div class="icons">
                                                                                <a href="#" title="Add to Wishlist"><i
                                                                                        class="fas fa-heart"></i></a>
                                                                                <a href="#" class="cart-btn"
                                                                                    title="Add to Cart"><i
                                                                                        class="fas fa-shopping-cart"></i>
                                                                                    Add to cart</a>
                                                                                <a href="#" title="Share"><i
                                                                                        class="fas fa-share"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="med-name">Moov Spray</div>
                                                                            <div class="price">Rs 450 <span>Rs 500
                                                                                </span></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="box" data-id="51" data-price="144"
                                                                        data-name="Diaper Rash Cream"
                                                                        data-image="https://www.epharmacy.com.np/content/images/thumbs/5e09d820a47b590001f1a624_himalaya-diaper-rash-cream-50gm.jpeg">
                                                                        <span class="discount">-10%</span>
                                                                        <div class="image">
                                                                            <img src="https://www.epharmacy.com.np/content/images/thumbs/5e09d820a47b590001f1a624_himalaya-diaper-rash-cream-50gm.jpeg"
                                                                                alt="Diaper Rash Cream">
                                                                            <div class="icons">
                                                                                <a href="#" title="Add to Wishlist"><i
                                                                                        class="fas fa-heart"></i></a>
                                                                                <a href="#" class="cart-btn"
                                                                                    title="Add to Cart"><i
                                                                                        class="fas fa-shopping-cart"></i>
                                                                                    Add to cart</a>
                                                                                <a href="#" title="Share"><i
                                                                                        class="fas fa-share"></i></a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="content">
                                                                            <div class="med-name">Diaper Rash Cream
                                                                            </div>
                                                                            <div class="price">Rs 144 <span>Rs 160
                                                                                </span></div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </section>
                                                            <script
                                                                src="https://khalti.com/static/khalti-checkout.js"></script>

                                                            <script src="cart.js"></script>
</body>

</html>