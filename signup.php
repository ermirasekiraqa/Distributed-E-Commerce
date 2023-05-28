<?php
// Database connection details
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'distributed-e-commerce-db';

// Establish database connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

// Check if the connection was successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Process registration form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get user input from the registration form
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $role = 'customer';

    // Insert user data into the Users table
    try {
        $sql = "INSERT INTO Users (name, last_name, email, password, phone_number, address, city, country, role) 
                VALUES ('$name', '$last_name', '$email', '$password', '$phone_number', '$address', '$city', '$country', '$role')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // User registration successful, redirect to a success page or perform other actions
            // ...
            echo '<!DOCTYPE html>
            <html lang="en">
            
            <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="css\normalize.css" />
            <link rel="stylesheet" href="css\signup.css" />
            
            <title>Sign up</title>
            
            <link rel="icon" type="image/x-icon" href="images\favicon.png">
            </head>
            
            <body>
            <main>
                <div class="registration-successful">
                    <p>Registration successful!</p>
                    <p id="login-link">Click <a href="login.html">here</a> to login.</p>
                    <p id="login-link">Click <a href="index.html">here</a> to go back to the main page.</p>
                </div>
            </main>
            </body>
            
            </html>';
        }
    } catch (mysqli_sql_exception $e) {
        // Check if the error is due to a duplicate email entry
        $error = $e->getMessage();
        if (strpos($error, "Duplicate entry") !== false && strpos($error, "email") !== false) {
            // Duplicate entry error (unique constraint violation)
            // Display an error message to the user
            echo '<!DOCTYPE html>
            <html lang="en">
            
            <head>
            <meta charset="UTF-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link rel="stylesheet" href="css\normalize.css" />
            <link rel="stylesheet" href="css\signup.css" />
            
            <title>Sign up</title>
            
            <link rel="icon" type="image/x-icon" href="images\favicon.png">
            </head>
            
            <body>
            <main>
                <div class="registration-successful">
                    <p>The email is already in use. Please choose another email.</p>
                    <p id="login-link">Click <a href="signup.html">here</a> to try again.</p>
                </div>
            </main>
            </body>
            
            </html>';
        } else {
            // Other error occurred
            echo "Error: " . $error;
        }
    }
}
?>

