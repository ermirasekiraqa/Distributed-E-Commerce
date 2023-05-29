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
        
            <title>User Table</title>
        </head>
        <body>
            <header>
            
            </header>
            <table>
                <caption>User List</caption>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Last name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Phone number</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>Country</th>
                    </tr>
                </thead>
                <tbody>';

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Retrieve products from the database
        $query = "SELECT * FROM users";
        $stmt = $pdo->query($query);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "<td>{$row['last_name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['password']}'</td>";
            echo "<td>{$row['phone_number']}</td>";
            echo "<td>{$row['address']}</td>";
            echo "<td>{$row['city']}</td>";
            echo "<td>{$row['country']}</td>";
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
