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
            <title>Product Table</title>
            <link rel="stylesheet" href="css/product-table.css" />
        </head>
        <body>
            <table>
                <caption>Product List</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image URL</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>';

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Retrieve products from the database
        $query = "SELECT * FROM product";
        $stmt = $pdo->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['product_id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['price']}</td>";
            echo "<td>{$row['description']}</td>";
            echo '<td><img src="images/' . $row['image_url'] . '" alt="Product Image"></td>';
            echo "<td>{$row['brand']}</td>";
            echo "<td>{$row['category']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "</tr>";
        }
        echo '</tbody>
        </table>
    </body>
    </html>';
    } else {
        header("Location: index.html");
    }
}
