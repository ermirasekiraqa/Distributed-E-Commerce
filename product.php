<?php
session_start();

// Retrieve the product ID from the URL parameter
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "distributed-e-commerce-db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    echo '<!DOCTYPE html>
    <html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css"
            href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
        <link rel="stylesheet" href="css\shop-style.css">
        <link rel="stylesheet" href="css\normalize.css">
        <link rel="stylesheet" href="css\common.css">
    
        <!-- <script src="js\shop-data.js"></script> -->
        <!-- <script defer src="js\single-product-functions.js"></script> -->
        <script defer src="js\header-functions.js"></script>
        
        <title>Shop</title>
    
        <link rel="icon" type="image/x-icon" href="images\favicon.png">
    </head>
    
    <body>
        <header>
            <nav id="header-menu">
                <img src="images\logo.png" alt="Black and light red sunglasses">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li id="active">Shop</li>
                    <li><a href="about-us.html">About us</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="shopping-cart.php"><i class="fa fa-shopping-cart"></i></a></li>
                </ul>
            </nav>
        </header>
        <main>
            <section class="single-product-container">
                <div id="product-card" class="single-product">
                    <div id="main-img">
                        <img id="main" src="" alt="">
                    </div>
                    <div class="prod-description">
                        <div class="prod-info">
                            <div id="quantity-add-button">
                                <input type="number" value="1" min="1" id="product-quantity">
                                <button id="add-to-cart-button" class="entry-and-about-us-button">Add to cart</button>
                            </div>
                        </div>
                        <div class="prod-specifics">
                            <table>
                                <tr>
                                    <th>Specifics</th>
                                    <th>Details about product</th>
                                </tr>
                                <tr>
                                    <td><b>Name</b></td>
                                    <td><i id="product-name"></i></td>
                                </tr>
                                <tr>
                                    <td><b>Brand</b></td>
                                    <td><i id="product-brand"></i></td>
                                </tr>
                                <tr>
                                    <td><b>Price</b></td>
                                    <td><i id="product-price"></i></td>
                                </tr>
                                <tr>
                                    <td><b>Description</b></td>
                                    <td><i id="product-description"></i></td>
                                </tr>
                                <tr>
                                    <td><b>Category</b></td>
                                    <td><i id="product-category"></i></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
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

    // Retrieve product information from the database
    $sql = "SELECT * FROM product WHERE product_id = ?"; // Assuming your products table has an 'id' column
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId); // Assuming you're passing the product ID as a query parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product exists
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        // Display the product information in the HTML elements
        echo "<script>
            document.getElementById('main').src = 'images'.concat('/', '{$product['image_url']}');
            document.getElementById('product-name').innerText = '{$product['name']}';
            document.getElementById('product-brand').innerText = '{$product['brand']}';
            document.getElementById('product-price').innerText = '$' + '{$product['price']}';
            document.getElementById('product-description').innerText = '{$product['description']}';
            document.getElementById('product-category').innerText = '{$product['category']}';
          </script>";
        if (isset($_SESSION['email'])) {
            // User is authenticated
            if ($_SESSION['role'] === 'admin') {
                echo "<script>
                // Add to Cart button click event handler
                document.getElementById('add-to-cart-button').addEventListener('click', function() {
                    window.location = 'admin_dashboard.php';
                });</script>";
            } 
        } else {
            echo "<script>
            // Add to Cart button click event handler
            document.getElementById('add-to-cart-button').addEventListener('click', function() {
            var quantity = parseInt(document.getElementById('product-quantity').value);
            
            // AJAX request to addToCart.php
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'addToCart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Handle the response from addToCart.php
                var response = xhr.responseText;
                console.log(response);
                // You can perform additional actions based on the response, such as displaying a success message
            }
        };
        
        // Prepare the data to send in the request body
        var data = 'product_id=' + {$product['product_id']} + '&quantity=' + quantity;
        
        // Send the AJAX request
        xhr.send(data);

        // Deactivate button
        let deactivatedButton = document.getElementById('add-to-cart-button');
        deactivatedButton.innerText = 'Added to Cart';
        deactivatedButton.disabled = 'disabled';
    });</script>";
        }
    } else {
        echo "Product not found.";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    // If the product ID is not provided, display an error message or redirect the user
    echo "Product ID not provided.";
}
