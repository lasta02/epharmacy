<?php

session_start();
// session_destroy(); 

echo '<pre>';
print_r($_SESSION);
echo '</pre>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CareBasket</title>
  <link rel="stylesheet" href="service.css" />

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
html
{
  scroll-behavior: smooth;
}
header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  background-color: white;
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
  display: flex;
  align-items: center;
  gap: 20px;
  font-size: 35px;
}

nav a {
  text-decoration: none;
  color: #222;
  font-weight: 500px;
}
.heads{
  display: flex;
  align-items: center;
  gap: 50px;

}
.btn{
background-color:#ebdab6;
align-items: center;
padding: 10px ;
justify-content: right;
display: flex;
gap: 25px;
  
}

.cart-icon {
  position: relative;
  font-size: 20px;
  color: black;
  cursor: pointer;
}
header .cart-count {
  position: absolute;
  top: -8px;
  right: -10px;
  background: red;
  color: white;
  font-size: 12px;
  padding: 2px 6px;
  border-radius: 50%;
  display: block;
}

.texts {
  background-color: #3b5a48;
  text-align: center;
  padding: 80px 20px;
}

.texts h1 {
  font-size: 40px;
  color: white;
  margin-bottom: 10px;
}

.texts p {
  font-size: 18px;
  color: #a29898;
}

marquee{
  font-size: 40px;
  color: #ebdab6;
}
.row{
  display: flex;
  align-items: center;
  flex-wrap: wrap;
  justify-content: space-around;
  background-color: rgb(226, 204, 208);
}
.col-2{
  flex-basis: 50%;
  min-width: 300px;
}
.col-2 img{
  max-width: 100%;
  padding: 50px 0px;
}
.col-2 h1{
  font-size: 100px;
  line-height: 60px;
  margin: 25px 0;
}
.col-2 p{
  font-size: 45px;
  font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
}
.btns{
  display: inline-block;
  background-color: darkolivegreen;
  color: white;
  padding: 8px 30px;
  margin: 30px 0;
  border-radius: 30px;
  font-size: 40px;
  transition: background 0.5s;
}
.btns:hover{
  background-color: #563434;
}

.heading{
  text-align: center;
  font-size: 4rem;
  color: #333;
  padding: 1rem;
  margin: 2rem 0;
  background-color:#3b5a48;
}
.heading span{
  color:bisque ;
}
.about .row{
  display: flex;
  align-items: center;
  gap: 2rem;
  flex-wrap: wrap;
  padding: 2rem 0;
  padding-bottom: 3rem;
}
.about .row .video-container{
  flex: 1 1 40rem;
  position: relative;
}
.about .row .video-container video{
  width: 100%;
  border: 1.5rem solid #fff;
  border-radius: 0.5rem;
  box-shadow: 0.5rem 1rem rgba(0,0,0,.1);
  height: 100%;
  object-fit: cover;
}
.about .row .video-container h3
{
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  font-size: 3 rem;
  background: #fff;
  width: 100%;
  padding: 1 rem 2rem;
  text-align: center;
  mix-blend-mode: screen;
}
.about .row .content
{
  flex: 1 1 40rem;
}
.about .row .content h3{
  font-size: 10rem;
  color: #999;
  padding: 5rem 0;
  padding-top: 1rem;
  line-height: 1.5;
}
.categories{
  margin: 70px 0;
}
.categories img{
  padding: 9rem 3.5rem;
}
.categories h1{
  font-size: 50px;
  text-align: center;
}
.col-3{
  flex-basis: 30%;
  min-width: 250px;
  margin-bottom: 30px;
}
.col-3 img{
 max-width: 1080px;
  margin: 100px;
  padding: 30px;

}
footer {
    background-color:#102542;
    color:white;
    padding: 50px;
    min-height: 500px;
  }
  .footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    min-height: 400px;
    margin: 0 auto;
    font-size: 25px;
  }
  .footer-section {
    flex: 1;
    min-width: 250px;
    margin-bottom: 20px;
  }
  .footer-section h3 {
    color:#F87060;
    margin-bottom: 15px;
  }
  .footer-section p, .footer-section a {
    color: #ccc;
    text-decoration: none;
    display: block;
    margin: 5px 0;
  }
  .footer-bottom {
    text-align: center;
    margin-top: 20px;
    border-top: 1px solid #334;
    padding-top: 20px;
    color:#aaa;
}

.cartTab{
  width: 400px;
  background-color: #102542;
  color: white;
  position: fixed;
  inset: 0 -400px 0 auto;
  display: grid;
  grid-template-rows: 70px 1fr 70px;
  transition:transform .5s;
}
.cartTab h1{
  padding: 20px;
  margin: 0;
  font-weight: 300;
}
.cartTab .btn{
  display: grid;
  grid-template-columns:repeat(2,1fr) ;
}
.cartTab .btn button{
  background-color: #563434;
  border: none;
  font-family: Poppins;
  font-weight: 500;
  cursor: pointer;
}
.cartTab .btn .close{
  background-color: #Eeee;
}
.cartTab .ListCart .item img{
  width: 100%;
}
.cartTab .ListCart .item {
  display: grid;
  grid-template-columns: 70px 150px 50px 1fr;
  text-align: center;
  align-items: center;
  gap: 10px;
}
.ListCart .quantity span{
display: inline-block;
width: 25px;
height: 25px;
background-color: white;
color: #555;
border-radius: 50%;
cursor: pointer;
}
.ListCart .quantity span:nth-child(2){
  background-color: transparent;
  color: #eee;
}
.ListCart .item:nth-child(even){
  background-color: #eee1;
}
.ListCart{
  overflow: auto;
}
.ListCart::-webkit-scrollbar{
  width: 0;
}
body .showcart .cartTab{
  inset: 0 0 0 auto;
}
body .showcart .container{
  transform: translateX(-250px);
}
  </style>
</head>
<body class="showcart">
  <header>
    <div class="logo">
      <img src="https://img.icons8.com/color/48/000000/pills.png" alt="Logo" />
      <span>Care<span class="highlight">Basket</span></span>
    </div>
    <nav class="heads">
      <a href="http://localhost:8000/login.php" target=""><i class="fa-regular fa-circle-user fa-xl"></i></a>
      <div class="cart-icon">
        <i class="fa-solid fa-cart-shopping fa-2xl"></i>
        <span class="cart-count">0</span>
      </div>
    </nav>
  </header>

  <div class="cartTab">
    <h1>Shopping Cart</h1>
    <div class="ListCart">
       <div class="item">
        <div class="image">
          <img src="https://nepmed-uat.s3.ap-southeast-1.amazonaws.com/products/600x600/90576/sinex_tablet_10_s_BTNxNA%241.jpg" alt="">
        </div>
        <div class="name"> Name</div>
         <div class="price">Price</div>
        <div class="quantity">
          <span class="minus"></span>
          <span>1</span>
          <span class="plus"></span>
        </div>
       </div>
    </div>
    <div class="btn">
      <button class="close">CLOSE</button>
      <button class="checkout">CHECKOUT</button>
    </div>
  </div>

  <nav class="btn">
      <a href="medicine.php">Medicines</a>
      <a href="health.html">Healthcare</a>
      <a href="beauty.html">Beauty</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
  </nav>

  <section class="texts">
    <h1>Your Health, Our Priority</h1>
    <p>Discover premium healthcare</p>
    <br><br>
    <marquee behavior="" direction="left" scrollamount="15">Bringing wellness to your doorstep. Open 7am to 10pm&#x1F4C5— Because Health Can’t Wait!<i class='fas fa-heartbeat' style='font-size:48px;color:red'></i></marquee>
  </section>
  
     <div class="row">
      <div class="col-2">
        <h1><b>Care You Can Count On!</b></h1>
        <br><br>
        <p><b>“At the heart of every healthy life is trust—and we deliver it daily.”</b> <br>
        We believe that healthcare should be safe, accessible, and compassionate. <br>
        That’s why we combine expert knowledge, genuine medicines, and fast, <br> reliable service to support your wellness journey.
         Whether it’s a routine prescription or a sudden need,  <br>we’re here to care, guide, and deliver—because your health is our promise.</p>
         <a href="" class=" btns">Explore Now &#8594;</a>
      </div>
      <div class="col-2">
        <img src="https://c4.wallpaperflare.com/wallpaper/581/885/202/medicine-pharmacy-pills-fake-law-wallpaper-preview.jpg" alt="" width="100%" height="100%">
      </div>
     </div>
<!-- Featured categories -->
    <div class="categories">
      <h1>Our featured Categories</h1>
        <div class="col-3">
        <img src="https://c8.alamy.com/comp/KBPBJ7/vitamins-vector-icon-illustration-KBPBJ7.jpg" alt="" height="750px" width="750px" title="Vitamins">
        <img src="https://blog.caretobeauty.com/wp-content/uploads/2021/03/dermatologist-approved-skincare-brands-1110x740.png" alt=""  height="750px" width="750px" title="Skin cares">
        <img src="https://th.bing.com/th/id/R.e5e6cc82520d43e21d95fff532baa440?rik=ULUYyU1I5y5sbA&riu=http%3a%2f%2faiwibimalaysia.com%2fcdn%2fshop%2farticles%2f20230420173703.jpg%3fv%3d1686640889&ehk=5oIfLIqBRldPtEPFOZx9xSrRGVys15q3av4uANWcc1w%3d&risl=&pid=ImgRaw&r=0" alt="" height="750px" width="750px" title="Baby products">
      </div>
      </div>

<!-- About section -->
      <section class="about" id="about">
        <h1 class="heading"><span>About</span> Us</h1>
        <div class="row">
          <div class="video-container">
            <video src="pharm.mp4" loop autoplay muted></video>
            <h3>Fast Medicine supply</h3>
          </div>
          <div class="content">
            <h3>Why choose us?</h3>
            <p>At CareBasket Pharmacy, your health is our priority. We offer a wide range of genuine medicines, wellness products, and healthcare essentials at affordable prices—all delivered right to your doorstep. With a user-friendly platform, secure payment options, and timely delivery, we ensure a smooth and trustworthy shopping experience. Our licensed pharmacists are available for guidance, and every product is carefully sourced from verified manufacturers. Choose us for reliability, convenience, and care—because you deserve nothing less.</p>
            <a href="#" class="btn">Learn more</a>
          </div>
        </div>
      </section>

      <!-- Service section -->
      <section class="services-section">
    <h1>Our Services</h1>
    <div class="services-container">
      
      <div class="service-card">
        <div class="icon">🚚</div>
        <h3>Fast Delivery</h3>
        <p>Get your medications delivered to your doorstep within hours</p>
      </div>

      <div class="service-card">
        <div class="icon">👨‍⚕</div>
        <h3>Expert Advice</h3>
        <p>Consult with our licensed pharmacists for any questions</p>
      </div>

      <div class="service-card">
        <div class="icon">💊</div>
        <h3>Generic Options</h3>
        <p>Quality generic medications at affordable prices</p>
      </div>

      <div class="service-card">
        <div class="icon">❤</div>
        <h3>Health Monitoring</h3>
        <p>Regular check-ups and health screenings available</p></div>
</div>
<br><br>
<!-- Footer -->
    <footer id="contact">
    <div class="footer-container">
      <div class="footer-section">
        <h3>CareBasket</h3>
        <p>Your trusted online pharmacy for quality medications and healthcare products.</p>
      </div>
      <div class="footer-section">
        <h3>Contact Info</h3>
        <p>📞 9863123450</p>
        <p>📧 info@carebasket.com</p>
        <p>📍 Lubhoo,Lalitpur</p>
      </div>
    </div>
    <div class="footer-bottom">
      © 2024 CareBasket. All rights reserved.
    </div>
</footer> 
<script src="cart.js"></script>
</body>
</html>
