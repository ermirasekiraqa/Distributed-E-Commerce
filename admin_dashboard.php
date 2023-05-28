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
            <title>Admin Dashboard</title>
            <link rel="stylesheet" href="css\admin-dashboard-style.css">
        </head>
        <body>
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
        </body>
        </html>';
    } else {
        header("Location: index.html");
    }
}
