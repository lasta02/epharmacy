<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Beauty Products</title>
    <link rel="stylesheet" href="medicine.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
         * {
         margin: 0;
         padding: 0;
        box-sizing: border-box;
        }

         body {
         font-family: 'Segoe UI', sans-serif;
         background-color: #f4f4f4;
           }
        header {
         display: flex;
          justify-content: space-between;
         align-items: center;
          padding: 15px 40px;
          background-color: beige;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
         }
        .logo {
          display: flex;
          align-items: center;
          font-size: 50px;
          font-weight: bold;
          color: #2e7d32;
        }

        .logo img {
          margin-right: 10px;
        }

        .logo .highlight {
          color: #43a047;
        }
        
        nav {
            background-color: #2e7d32;
            display: flex;
            align-items: center;
            color: white;
            gap: 2rem;
            padding: 20px 40px;
            font-size: 1.2rem;
        }
        nav input {
            width: 300px;
            padding: 0.5rem;
            border-radius: 5px;
            border: none;
            font-size: 1rem;
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
            color: #2e7d32;
            background-color: white;
            border-radius: 5px;
        }
        :root { --pink: #ff3399; }
        h2
        {
            color: #ff3399;
        }
        .products {
            padding: 2rem 0;
        }
        .heading {
            text-align: center;
            font-size: 2.5rem;
            margin: 1.5rem 0 0.5rem 0;
        }
        .heading span { color: var(--pink); }
        .subheading {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 2rem;
        }
        .subheading span{ color: var(--pink);}
        .box-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: center;
        }
        .box {
            flex: 1 1 300px;
            max-width: 320px;
            box-shadow: 0.5rem 1.5rem rgba(0,0,0,.1);
            border-radius: .5rem;
            border: 0.1rem solid rgba(0,0,0,.1);
            position: relative;
            background: #fff;
            margin-bottom: 2rem;
        }
        .discount {
            position: absolute;
            top: 1rem; left: 1rem;
            padding: 0.5rem 1rem;
            font-size: 1.2rem;
            color: var(--pink);
            background: rgba(255,51,153,.05);
            z-index:1;
            border-radius: .5rem;
        }
        .image {
            position: relative;
            text-align: center;
            padding-top: 2rem;
            overflow: hidden;
        }
        .image img {
            height: 180px;
            transition: transform 0.3s;
        }
        .box:hover .image img {
            transform: scale(1.1);
        }
        .icons {
            position: absolute;
            bottom: 7rem; left: 0; right: 0;
            display: flex;
            transition: bottom 0.3s;
        }
        .box:hover .icons {
            bottom: 0;
        }
        .icons a {
            height: 3rem;
            line-height: 3rem;
            font-size: 1.2rem;
            width: 50%;
            background: var(--pink);
            color: #fff;
            text-align: center;
            text-decoration: none;
            transition: background 0.3s;
        }
        .cart-btn {
            border-left:  .1rem solid #fff7;
            border-right:  .1rem solid #fff7;
            width: 100%;
        }
        .icons a:hover {
            background: #333;
        }
        .content {
            padding: 1rem;
            text-align: center;
        }
        .price {
            font-size: 1.5rem;
            color: var(--pink);
            font-weight: bolder;
            padding-top:1rem;
        }
        .price span {
            font-size: 1rem;
            color: #999;
            font-weight: lighter;
            text-decoration: line-through;
            margin-left: 1rem;
        }
        .med-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        @media (max-width: 900px) {
            .box-container { flex-direction: column; align-items: center; }
            nav { flex-direction: column; gap: 1rem; }
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
      padding: 1.5rem;
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
    </style>
</head>
<body>
     <!-- Cart Sidebar -->
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
        <a href="#Skin">Skin Products</a>
        <a href="#Baby">Baby Products</a>
        <input type="text" id="searchBar" placeholder="Search medicines">
    </nav>
    <section class="products" id="products">
        <h1 class="heading">Available <span>Beauty Products</span></h1>
        <div class="subheading">Get 10% Discount on <span>Every Purchase</span></div>
        <!-- Skin Products Part -->
        <div class="skin" id="Skin">
            <h2><b>Skin Products</b></h2>
            <div class="box-container">
                <div class="box" data-id="52" data-name="Cetaphil Products" data-price="5850" data-image="https://www.cetaphil.in/dw/image/v2/BGGN_PRD/on/demandware.static/-/Sites-Galderma-IN-Library/default/dw32aff090/plp/Category_GLOBAL-All-CATEGORIES%201.jpg?sw=500">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.cetaphil.in/dw/image/v2/BGGN_PRD/on/demandware.static/-/Sites-Galderma-IN-Library/default/dw32aff090/plp/Category_GLOBAL-All-CATEGORIES%201.jpg?sw=500" alt="Cetaphil Products">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Cetaphil Products(3 product)</div>
                        <div class="price">Rs 5850 <span>Rs 6500</span></div>
                    </div>
                </div>
                <div class="box" data-id="53" data-name="Fix Derma Sunscreen" data-price="900" data-image="https://www.epharmacy.com.np/content/images/thumbs/628f149b3e1d66b6e7619cb6_fixderma-shadow-spf-50-gel-75gm.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.epharmacy.com.np/content/images/thumbs/628f149b3e1d66b6e7619cb6_fixderma-shadow-spf-50-gel-75gm.jpeg" alt="Fix Derma Sunscreen">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Fix Derma Sunscreen</div>
                        <div class="price">Rs 900 <span>Rs 1000</span></div>
                    </div>
                </div>
                <div class="box" data-id="53" data-name="Alic Facewash" data-price="432 " data-image="https://static-01.daraz.com.np/p/736294c294e810f26089e0d6a6fa3909.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://static-01.daraz.com.np/p/736294c294e810f26089e0d6a6fa3909.jpg" alt="Alic Facewash">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Alic Facewash</div>
                        <div class="price">Rs 432 <span>Rs 480</span></div>
                    </div>
                </div>
                <div class="box" data-id="54" data-name="UVCOZ Sunscreen" data-price="1080" data-image="https://www.nepmeds.com.np/public/840-840/files/A463C08AA647428-Screenshot%202025-05-04%20at%2012.31.18.png">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.nepmeds.com.np/public/840-840/files/A463C08AA647428-Screenshot%202025-05-04%20at%2012.31.18.png" alt="UVCOZ Sunscreen">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">UVCOZ Sunscreen</div>
                        <div class="price">Rs 1080 <span>Rs 1200</span></div>
                    </div>
                </div>
                <div class="box" data-id="55" data-name="Curatio foam facewash" data-price="612" data-image="https://www.epharmacy.com.np/content/images/thumbs/636a2558fd557e2ea054f608_curatio-fash-foam-foaming-face-wash-100ml.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.epharmacy.com.np/content/images/thumbs/636a2558fd557e2ea054f608_curatio-fash-foam-foaming-face-wash-100ml.jpeg" alt="Curatio foam facewash">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Curatio foam facewash</div>
                        <div class="price">Rs 612 <span>Rs 680</span></div>
                    </div>
                </div>
                <div class="box" data-id="56" data-name="Derma-co Nicanamide" data-price="862" data-image="https://www.epharmacy.com.np/content/images/thumbs/6311c0d36e78441b741bb049_the-derma-co-10-niacinamide-serum-30ml.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.epharmacy.com.np/content/images/thumbs/6311c0d36e78441b741bb049_the-derma-co-10-niacinamide-serum-30ml.jpeg" alt="Derma-co Nicanamide">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Derma-co Nicanamide</div>
                        <div class="price">Rs 862 <span>Rs 958.40</span></div>
                    </div>
                </div>
                <div class="box" data-id="57" data-name="Cuticare(Dark spot Removable)" data-price="225" data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRyEXAMyFN96jdafBSuklX_kCuGcwC4GgQogw&s">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRyEXAMyFN96jdafBSuklX_kCuGcwC4GgQogw&s" alt="Cuticare">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Cuticare(Dark spot Removable)</div>
                        <div class="price">Rs 225 <span>Rs 250</span></div>
                    </div>
                </div>
                <div class="box" data-id="58" data-name="Extra Virgin Coconut oil" data-price="1125" data-image="https://img.drz.lazcdn.com/g/kf/Sa79f962a4bc84a99b30d59922b9ba3fac.jpg_720x720q80.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://img.drz.lazcdn.com/g/kf/Sa79f962a4bc84a99b30d59922b9ba3fac.jpg_720x720q80.jpg" alt="Extra Virgin Coconut Oil">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Extra Virgin Coconut oil</div>
                        <div class="price">Rs 1125 <span>Rs 1250</span></div>
                    </div>
                </div>
                <div class="box" data-id="59" data-name="Ketanol Shampoo" data-price="202" data-image="https://static-01.daraz.com.np/p/b706f9571c6cc0971ea4d86e82ec1f4a.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://static-01.daraz.com.np/p/b706f9571c6cc0971ea4d86e82ec1f4a.jpg" alt="Ketanol Shampoo">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Ketanol Shampoo</div>
                        <div class="price">Rs 202 <span>Rs 225</span></div>
                    </div>
                </div>
                <div class="box" data-id="60" data-name="Thermoseal Toothpaste" data-price="202" data-image="https://images.apollo247.in/pub/media/catalog/product/T/H/THE0014_1-AUG23_1.jpg?tr=q-80,f-webp,w-400,dpr-3,c-at_max%201200w">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://images.apollo247.in/pub/media/catalog/product/T/H/THE0014_1-AUG23_1.jpg?tr=q-80,f-webp,w-400,dpr-3,c-at_max%201200w" alt="Thermoseal Toothpaste">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Thermoseal Toothpaste</div>
                        <div class="price">Rs 202 <span>Rs 225</span></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Baby Products Part -->
        <div class="baby" id="Baby">
             <h2><b>Baby Products</b></h2>
            <div class="box-container">
                <div class="box" data-id="61" data-name="Aiwibi New Born Diaper(Upto 5kg)" data-price="486" data-image="https://static-01.daraz.com.np/p/bb36e69bacb3abd60cb2006417df7a3b.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://static-01.daraz.com.np/p/bb36e69bacb3abd60cb2006417df7a3b.jpg" alt="Aiwibi New Born">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Aiwibi New Born Diaper(Upto 5kg)</div>
                        <div class="price">Rs 486 <span>Rs 540</span></div>
                    </div>
                </div>
        
                <div class="box" data-id="62" data-name="Aiwibi Medium Diaper" data-price="900" data-image="https://static-01.daraz.com.np/p/08603ac356b2553365f776eac96d9097.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://static-01.daraz.com.np/p/08603ac356b2553365f776eac96d9097.jpg" alt="Aiwibi Medium Diaper">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Aiwibi Medium Diaper</div>
                        <div class="price">Rs 900 <span>Rs 1000</span></div>
                    </div>
                </div>
                
                <div class="box" data-id="63" data-name="Aiwibi XL pack of 3" data-price="3397" data-image="https://admin.sutkeri.com/product-cache/XL_36_pack_of_3_with_wipes-1691652104.jpeg?p=main&s=9c118240bbbf3030e9e5f68bb716d71b">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://admin.sutkeri.com/product-cache/XL_36_pack_of_3_with_wipes-1691652104.jpeg?p=main&s=9c118240bbbf3030e9e5f68bb716d71b" alt="Aiwibi XL pack of 3">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Aiwibi XL pack of 3</div>
                        <div class="price">Rs 3397 <span>Rs 3775</span></div>
                    </div>
                </div>
                <div class="box" data-id="64" data-name="Johnson's Baby Oil" data-price="450" data-image="https://i5.walmartimages.com/seo/Johnson-s-Baby-Body-Moisturizing-Oil-Liquid-Mineral-Oil-for-Baby-Massage-Original-14-fl-oz_a13438de-c358-42d5-932d-6a25c9386a16.9eba87404d05dfd11b2badcedb59fbd1.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://i5.walmartimages.com/seo/Johnson-s-Baby-Body-Moisturizing-Oil-Liquid-Mineral-Oil-for-Baby-Massage-Original-14-fl-oz_a13438de-c358-42d5-932d-6a25c9386a16.9eba87404d05dfd11b2badcedb59fbd1.jpeg" alt="Johnson's Baby Oil">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Johnson's Baby Oil</div>
                        <div class="price">Rs 450 <span>Rs 500</span></div>
                    </div>
                </div>
              
                <div class="box" data-id="65" data-name="Himalaya Diaper Rashes Cream" data-price="216" data-image="https://www.epharmacy.com.np/content/images/thumbs/5e09d820a47b590001f1a624_himalaya-diaper-rash-cream-50gm.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://www.epharmacy.com.np/content/images/thumbs/5e09d820a47b590001f1a624_himalaya-diaper-rash-cream-50gm.jpeg" alt="Himalaya Diaper Rashes Cream">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Himalaya Diaper Rashes Cream</div>
                        <div class="price">Rs 216 <span>Rs 240</span></div>
                    </div>
                </div>
                <div class="box" data-id="66" data-name="Baby Feeding Bottle" data-price="189" data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnwrx2Mil1gUmrqOCfycPJsvOVirwLHk0pH7ET_4zL65SpP031EWl8OfYJTj2ujw3bqxc&usqp=CAU">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRnwrx2Mil1gUmrqOCfycPJsvOVirwLHk0pH7ET_4zL65SpP031EWl8OfYJTj2ujw3bqxc&usqp=CAU" alt="Baby Feeding Bottle">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Baby Feeding Bottle</div>
                        <div class="price">Rs 189 <span>Rs 210</span></div>
                    </div>
                </div>
                
                <div class="box" data-id="67" data-name="Lactogen(Formula Milk)" data-price="787.5" data-image="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHkz3PjDq6JBrAOheDxrn6b-QVlDseN4KPug&s">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSHkz3PjDq6JBrAOheDxrn6b-QVlDseN4KPug&s" alt="Lactogen">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Lactogen(Formula Milk)</div>
                        <div class="price">Rs 787.5 <span>Rs 875</span></div>
                    </div>
                </div>
                
                <div class="box" data-id="68" data-name="Zerolac" data-price="993" data-image="https://np-live-21.slatic.net/kf/S5ff5552672904d5cb4b5267d045d12bdN.jpg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://np-live-21.slatic.net/kf/S5ff5552672904d5cb4b5267d045d12bdN.jpg" alt="Zerolac">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Zerolac</div>
                        <div class="price">Rs 993 <span>Rs 1104</span></div>
                    </div>
                </div>
                <div class="box" data-id="69" data-name="Similac" data-price="3615" data-image="https://i5.walmartimages.com/seo/Similac-Advance-Baby-Formula-with-Iron-Powder-12-4-oz-Can_fbdffcbe-5924-45a6-b18a-55abe226c1e7.4a64fa4b53b72c653b957ba2b4eebb87.jpeg">
                    <span class="discount">-10%</span>
                    <div class="image">
                        <img src="https://i5.walmartimages.com/seo/Similac-Advance-Baby-Formula-with-Iron-Powder-12-4-oz-Can_fbdffcbe-5924-45a6-b18a-55abe226c1e7.4a64fa4b53b72c653b957ba2b4eebb87.jpeg" alt="Similac">
                        <div class="icons">
                            <a href="#" title="Add to Wishlist"><i class="fas fa-heart"></i></a>
                            <a href="#" class="cart-btn" title="Add to Cart"><i class="fas fa-shopping-cart"></i> Add to cart</a>
                            <a href="#" title="Share"><i class="fas fa-share"></i></a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="med-name">Similac</div>
                        <div class="price">Rs 3615 <span>Rs 4017</span></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     <script src="cart.js"></script>
     <script src="search.js"></script>
</body>
</html>
