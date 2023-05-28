<?php
// echo 'Process order!!!';
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "distributed-e-commerce-db";

$cartItems = [];
$user_id;
$firstName;
$lastName;
$address;
$city;
$country;
$paymentMethod;
$status = 'Processed';
$totalPrice = 0;

// Check if the user is logged in
if (isset($_SESSION['email'])) {
    // User is logged in
    $email = $_SESSION['email'];

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user information from the database
    $stmt = $conn->prepare('SELECT id, name, last_name, address, city, country FROM users WHERE email = ?');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($user_id, $firstName, $lastName, $address, $city, $country);
    $stmt->fetch();
    $stmt->close();

    // Insert order details into the database
    $paymentMethod = $_POST['paymentMethod'];

    // Fetch all rows from the cart table for the specific user_id
    $sql = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the fetched rows in an array
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    // Close the statement
    $stmt->close();
    // Close the database connection
    $conn->close();
} else {
    // User is Guest
    // Retrieve cart items from the session storage
    // Access the session storage data and assign it to $cartItems
    if (isset($_SESSION['cart_items'])) {
        $cartItems = $_SESSION['cart_items'];
    }
    // Insert order details into the database
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $paymentMethod = $_POST['paymentMethod'];
}

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Get the price for each product
foreach ($cartItems as &$item) {
    // Prepare the SQL statement to fetch product details
    $sql = "SELECT price FROM product WHERE product_id = ?";

    // Prepare and bind the parameter
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $item['product_id']);

    // Execute the query
    $stmt->execute();

    // Bind the result variables
    $stmt->bind_result($price);

    // Fetch the result
    $stmt->fetch();

    // Assign the fetched values to the cart item
    $item['price'] = $price;
    $totalPrice += ($price * $item['quantity']);
    
    $stmt->close();
}

// Insert data in Orders table
$sql = "INSERT INTO orders (first_name, last_name, total_price, address, city, country, payment_method, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssd', $firstName, $lastName, $totalPrice, $address, $city, $country, $paymentMethod, $status);

if ($stmt->execute()) {
    // Get the order ID
    $order_id = $stmt->insert_id;
    foreach ($cartItems as &$item) { 
        $productId = intval($item['product_id']);
        $quantity = intval($item['quantity']);
        // Insert the product_id and order_id into the order_products table
        $sql = "INSERT INTO order_products (order_id, product_id, quantity) VALUES (?, ?, ?)";
        $insertStmt  = $conn->prepare($sql);
        $insertStmt ->bind_param('iii', $order_id, $productId, $quantity);
        $insertStmt ->execute();
        $insertStmt ->close();
    }
    // Clear user's cart after order
    if (isset($_SESSION['email'])) {
        $sql = "DELETE FROM cart WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        session_destroy();
        $stmt->close();
    }

    // Redirect the user to a success page or perform other actions
    echo '<!DOCTYPE html>
    <html lang="en">
    
    <head>
      <meta charset="UTF-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <link rel="stylesheet" type="text/css"
        href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin" />
      <link rel="stylesheet" href="css\normalize.css" />
      <link rel="stylesheet" href="css\common.css" />
      <link rel="stylesheet" href="css\shopping-cart-style.css" />
    
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
        <div class="shopping-cart-and-button">
          <p id="cart-is-empty-message">Your order was made!</p>
        </div>
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
} else {
    echo "Error: " . $stmt->error;
}

// Close the database connection
$conn->close();
