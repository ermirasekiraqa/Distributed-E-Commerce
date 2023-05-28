<?php
// Connect to the database (replace host, username, password, and dbname with your actual database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'distributed-e-commerce-db';
$conn = mysqli_connect($host, $username, $password, $dbname);

// Check the connection
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// Fetch all products from the "Product" table
$query = "SELECT * FROM Product";
$result = mysqli_query($conn, $query);

// Prepare the array to store the product data
$products = array();

// Fetch the product data and add it to the array
while ($row = mysqli_fetch_assoc($result)) {
    $product = array(
        'id' => $row['product_id'],
        'productname' => $row['name'],
        'price' => $row['price'],
        'description' => $row['description'],
        'image' => $row['image_url'],
        'brand' => $row['brand'],
        'category' => $row['category'],
        'created_at' => $row['created_at']
    );
    $products[] = $product;
}

// Close the database connection
mysqli_close($conn);

// Return the product data as JSON response
header('Content-Type: application/json');
echo json_encode($products);
?>
