<?php
// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'distributed-e-commerce-db';

session_start();

// Check is the user is admin
if (isset($_SESSION['email'])) {
    // User is authenticated
    if ($_SESSION['role'] === 'admin') {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Order Products</title>
            <link rel="stylesheet" href="css/product-table.css" />
        </head>
        <body>
            <table>
                <caption>Order Products</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>';

        // Check if the order_id parameter is set
        if (isset($_GET['order_id'])) {
            $order_id = $_GET['order_id'];

            try {
                // Create a new PDO instance
                $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

                // Set PDO error mode to exception
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Retrieve order products based on the order_id
                $query = "SELECT * FROM order_products WHERE order_id = :order_id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td>{$row['product_id']}</td>";
                    echo "<td>{$row['quantity']}</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "Error retrieving order products: " . $e->getMessage();
            }
        } else {
            echo "Invalid order ID.";
        }
        echo '</tbody>
        </table>
    </body>
    </html>';
    } else {
        header("Location: index.html");
    }
}
