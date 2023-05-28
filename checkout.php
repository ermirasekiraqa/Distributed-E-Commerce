<?php
    session_start();

    echo '<!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin" />
      <link rel="stylesheet" href="css\normalize.css" />
      <link rel="stylesheet" href="css\common.css" />
      <link rel="stylesheet" href="css\checkout.css" />
    
      <script defer src="js\header-functions.js"></script>
      <!-- <script defer src="js\shopping-cart.js"></script> -->
    
      <title>Cart</title>
    
      <link rel="icon" type="image/x-icon" href="images\favicon.png">
    </head>
    
    <body>
      <header>
        <nav id="header-menu">
          <img src="images\logo.png" alt="Black and light red sunglasses">
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="shop.html">Shop</a></li>
            <li><a href="about-us.html">About us</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><i class="fa fa-shopping-cart" id="active"></i></li>
          </ul>
        </nav>
      </header>
      <main>
        <div class="container">';
    if (isset($_SESSION['email'])) {
      // User is logged in
      // Display a simplified form with only the payment method
      echo '<form action="process-order.php" method="post">
        <!-- Payment method input field -->
        <h4>Choose payment method</h4>
        <p>We only offer cash at the moment</p>
        <label for="cashPayment"><input type="radio" name="paymentMethod" id="cashPayment" value="Cash"> Cash</label>
        <input type="submit" value="Place Order" id="place-order-button">
      </form>';
    // echo 'User is logged in';
    } else {
      // User is a guest
      // Display a form with additional input fields for guest information
      echo '<form action="process-order.php" method="post">
        <!-- Guest information input fields -->
        <h1>Fill out checkout form</h1>
        <input type="text" name="firstName" id="firstName" placeholder="First Name" required><br>
        <input type="text" name="lastName" id="lastName" placeholder="Last Name" required><br>
        <input type="text" name="address" id="address" placeholder="Address" required><br>
        <input type="text" name="city" id="city" placeholder="City" required><br>
        <input type="text" name="country" id="country" placeholder="Country" required><br>

        <!-- Payment method input field -->
        <h4>Choose payment method</h4>
        <p>We only offer cash at the moment</p>
        <label for="cashPayment"><input type="radio" name="paymentMethod" id="cashPayment" value="Cash"> Cash</label>
        <input type="submit" value="Place Order" id="place-order-button">
      </form>';
    }    

    echo '</div>
        </main>
        <footer class="footer-with-gray-background">
        <section class="useful-info">
            <div class="get-in-touch">
                <h3>Head Office</h3>
                <div class="get-in-touch-info">
                    <li>
                        <i class="fa fa-map-o"></i>
                        <p>See map for our location!</p>
                    </li>
                    <li>
                        <i class="fa fa-envelope-o"></i>
                        <p>eye-wear@gmail.com</p>
                    </li>
                    <li>
                        <i class="fa fa-phone"></i>
                        <p>+12 345 6789</p>
                    </li>
                    <li>
                        <i class="fa fa-clock-o"></i>
                        <p>Monday to Saturday, 9:00AM to 16.PM</p>
                    </li>
                </div>
            </div>
            <div class="quick-links">
                <h3>Quick Links</h3>
                <li><a href="index.html">Home</a></li>
                <li><a href="about-us.html">About Us</a></li>
                <li><a href="shop.html">Shop Now</a></li>
                <li><a href="contact.html">Contact Us</a></li>
                <li><a href="login.html">Log in</a></li>
                <li><a href="signup.html">Sign up</a></li>
            </div>
            <div class="logo-in-footer">
                <img src="images/logo.png" alt="Logo">
            </div>
        </section>
        <section class="copyright-social-media">
            <p>
                Copyright © 2023 Universiteti i Prishtines "Hasan Prishtina", FSHMN, Shkenca Kompjuterike
            </p>
            <div id="social-media-icons">
                <i class="fa fa-twitter"></i>
                <i class="fa fa-google-plus"></i>
                <i class="fa fa-linkedin"></i>
            </div>
        </section>
        </footer>
        </body>
    </html>';
?>