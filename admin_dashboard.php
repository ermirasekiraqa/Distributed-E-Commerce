<?php
// Database connection details
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'distributed-e-commerce-db';

session_start();

// Check if the user is logged in or a guest
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
            <link rel="stylesheet" href="css\normalize.css">
            <link rel="stylesheet" href="css\common.css">
            <link rel="stylesheet" href="css\admin-dashboard-style.css">
            
            <script defer src="js\header-functions.js"></script>

            <title>Admin Dashboard</title>
        </head>
        <body>
            <header>
            
            </header>
            <main id="main-container">
                <div class="admin-dashboard-container">
                    <h1>ADMIN SITE</h1>
                    <div class="container">
                        <a href="add-delete-edit_product.php" class="square">
                            <p>Manage Products</p>
                        </a>
                        <a href="add-delete-edit_users.php" class="square">
                            <p>Manage Users</p>
                        </a>
                        <a href="orders-table.php" class="square">
                            <p>View Orders</p>
                        </a>
                        <a href="view-chats.php" class="square">
                        <p>View Chats</p>
                        </a>
                    </div>
                </div>
            </main>
        </body>
        </html>';
    } else {
        header("Location: index.html");
    }
}
