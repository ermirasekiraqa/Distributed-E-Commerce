<?php
session_start();

echo '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" href="css\normalize.css">
    <link rel="stylesheet" href="css\common.css">
    <link rel="stylesheet" href="css\contact-style.css">
    <link rel="stylesheet" href="css/chat-style.css">


    <script defer src="js\header-functions.js"></script>
    <script defer src="js\contact.js"></script>
    <script src="http://localhost:4000/socket.io/socket.io.js"></script>

    <title>Contact</title>

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
                <li id="active">Contact</li>
                <li><a href="shopping-cart.php"><i class="fa fa-shopping-cart"></i></a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section class="entry">
            <h2>#letstalk</h2>
            <p>LEAVE A MESSAGE, We Love to hear from you!</p>
        </section>

        <section id="contact-details" class="section-p1">
            <div class="details">
                <span>GET IN TOUCH</span>
                <h2>Visit our headquarters or contact us today</h2>
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
            <address class="map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3001156.4288297426!2d-78.01371936852176!3d42.72876761954724!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4ccc4bf0f123a5a9%3A0xddcfc6c1de189567!2sNew%20York%2C%20USA!5e0!3m2!1sen!2sbd!4v1603794290143!5m2!1sen!2sbd" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </address>
        </section>

        <section id="form-details">
            <form action="" onsubmit="sendEmail(); reset(); return false;">
                <span>LEAVE A MESSAGE</span>
                <h2>We love to hear from you</h2>
                <input type="text" name="" id="full_name" placeholder="Your Name">
                <input type="email" name="" id="email_id" placeholder="E-mail">
                <input type="text" name="" id="subject" placeholder="Subject">
                <textarea name="" id="message" cols="30" rows="10" placeholder="Your message"></textarea>
                <button>Submit</button>
            </form>

            <div class="people">
                <div>
                    <img src="images\photo-fashion-stylish-girl-in-sunglasses.jpg" alt="">
                    <p><span>Emily Dason</span>
                        Founder/CEO <br>
                        Phone: +000 447 531 914 <br>
                        Email: EmilyDason@gmail.com
                    </p>
                </div>
                <div><img src="images\person2.jpg" alt="">
                    <p><span>Emma Watson</span>
                        Product Specialist
                        <br>Phone: +000 132 531 100
                        <br>Email: EmmaWatson@gmail.com
                    </p>
                </div>
                <div>
                    <img src="images\person3.jpg" alt="">
                    <p><span>Adam Smith</span>
                        Customer Support Representative
                        <br>Phone: +000 981 501 954
                        <br>Email: AdamSmith@gmail.com
                    </p>
                </div>

            </div>
        </section>';


if (isset($_SESSION['email']) && isset($_SESSION['role']) && $_SESSION['role'] === 'customer') {
    echo '<section class="chat-box-container">
            <div class="chatbox" id="chatbox">
                <div class="chatbox-button">
                    <button id="chatbox-button"><img src="images/chatbox-icon.svg" /></button>
                </div>
            </div>
        </section>';

        echo '<script>
          echo "window.addEventListener(\'scroll\', function() {
            const floatingButton = document.getElementById(\'chatbox-button\');
            const desiredPosition = window.scrollY + window.innerHeight - floatingButton.offsetHeight - 20;
            floatingButton.style.top = desiredPosition + \'px\';
        });";
    </script>';
       
        
    echo '<script>
    
    let socket = io("http://localhost:4000");
    let chatboxButton = document.getElementById("chatbox-button");
    const messages = []
    chatboxButton.addEventListener("click", function () {
        window.location = "chat.html";
    })
    
    </script>';
}



echo '</main>
    <footer>
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
                <li><a href="contact.php">Contact Us</a></li>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script type="text/javascript">
        (function() {
            emailjs.init("DHPr1WNY7fh4Bumzr");
        })();
    </script>
    
</body>

</html>';
