<?php
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "distributed-e-commerce-db";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  // Check if the user is logged in or guest
  if (isset($_SESSION['email']) && isset($_POST['product_id'])) {
    // User is logged in and product_id is provided
  
    // Connect to the database
    $conn = new mysqli($servername, $username, $password, $dbname);
  
    // Check if the connection was successful
    if ($conn->connect_error) {
      die('Database connection failed: ' . $conn->connect_error);
    }
  
    // Retrieve the user_id based on the email
    $email = $_SESSION['email'];
    $sql = "SELECT id FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
  
    $product_id = $_POST['product_id'];
  
    // Remove the product from the cart table
    $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
  
    // Close the database connection
    $conn->close();  
  } else {
    // User is a guest
    $product_id = $_POST['product_id'];

    // Retrieve cart items from the session storage
    if (isset($_SESSION['cart_items'])) {
      $cartItems = $_SESSION['cart_items'];

      // Find the index of the product in the cartItems array
      $index = -1;
      foreach ($cartItems as $key => $item) {
        if ($item['product_id'] == $product_id) {
          $index = $key;
          break;
        }
      }

      // Remove the product from the cartItems array
      if ($index !== -1) {
        unset($cartItems[$index]);
        $_SESSION['cart_items'] = $cartItems;
      }
    }
  }

  // Redirect back to the cart page after removing the product
  header('Location: shopping-cart.php');
  exit();
}
