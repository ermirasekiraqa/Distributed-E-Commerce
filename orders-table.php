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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
        href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin" />
    <link rel="stylesheet" href="css\normalize.css">
    <link rel="stylesheet" href="css\common.css">
    <link rel="stylesheet" href="css/product-table.css" />

    <script defer src="js\header-functions.js"></script>

    <title>Order Table</title>
</head>
<body>
    <header>
    
    </header>
    <table>
        <caption>Orders List</caption>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Total Price</th>
                <th>Address</th>
                <th>City</th>
                <th>Country</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Order Products</th> <!-- New column for the button -->
            </tr>
        </thead>
        <tbody>';

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Retrieve orders from the database
        $query = "SELECT * FROM `orders`";
        $stmt = $pdo->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['order_id']}</td>";
            echo "<td>{$row['first_name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['total_price']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['country']}</td>";
            echo "<td>{$row['payment_method']}</td>";
            echo "<td>{$row['status']}</td>";
            echo "<td>{$row['created_at']}</td>";
            echo "<td id='view-order-products-anchor'><a href=\"order-products-table.php?order_id={$row['order_id']}\">View Order Products</a></td>"; // Button with link
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
