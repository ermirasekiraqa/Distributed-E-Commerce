<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "distributed-e-commerce-db";

// Check if the product ID and quantity are provided
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the user is logged in or a guest
    if (isset($_SESSION['email'])) {
        // User is authenticated
        if ($_SESSION['role'] === 'admin') {
            header("Location: admin_dashboard.html");
        } else {
            $email = $_SESSION['email'];
            // If the user is logged in, add the product to their cart in the database
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Prepare and execute the query to retrieve the user ID
            $sql = "SELECT id FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($userId);

            // Fetch the result
            if ($stmt->fetch()) {
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                // Prepare and execute the query to insert the cart item
                $sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("iii", $userId, $productId, $quantity);

                if ($stmt->execute()) {
                    // Cart item added successfully
                    echo json_encode(array("success" => true));
                } else {
                    // Failed to add cart item, handle the error
                    echo json_encode(array("success" => false, "message" => "Failed to add item to cart."));
                }
                // Close the database connection
                $stmt->close();
                $conn->close();
            } else {
                // User not found, handle the error
                echo json_encode(array("success" => false, "message" => "User not found."));
            }
            echo json_encode(array("success" => true));
        }
    } else {
        // If the user is a guest, store the product information in a temporary session variable
        $cartItem = array("product_id" => $productId, "quantity" => $quantity);

        // Retrieve the existing cart items from the session (if any)
        $cartItems = $_SESSION['cart_items'] ?? array();

        // Check if the product is already in the cart
        $existingCartItem = null;
        foreach ($cartItems as $item) {
            if ($item['product_id'] == $productId) {
                $existingCartItem = $item;
                break;
            }
        }

        if ($existingCartItem) {
            // If the product is already in the cart, update the quantity
            $existingCartItem['quantity'] += $quantity;

            // Update the cart item in the session
            $_SESSION['cart_items'][$existingCartItem['product_id']] = $existingCartItem;
            echo json_encode($cartItems);
        } else {
            // If the product is not in the cart, add it as a new item
            $cartItems[$productId] = array(
                "product_id" => $productId,
                "quantity" => $quantity
            );

            // Store the updated cart items in the session
            $_SESSION['cart_items'] = $cartItems;
            echo json_encode($cartItems);
        }

        // Return a response to indicate the success of the operation
        echo json_encode(array("success" => true));
    }
} else {
    // Return a response to indicate the failure of the operation
    echo json_encode(array("success" => false, "message" => "Product ID or quantity not provided."));
}
