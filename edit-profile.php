<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page or display an error message
    header("Location: login.html");
    exit();
}

// Database connection parameters
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'distributed-e-commerce-db';

// Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

// Function to update the user profile
function updateUserProfile($user_email, $name, $last_name, $phone_number, $address, $city, $country)
{
    global $pdo;
    // Prepare the update query
    $query = "UPDATE users SET name = ?, last_name = ?, phone_number = ?, address = ?, city = ?, country = ? WHERE email = ?";
    $stmt = $pdo->prepare($query);

    // Bind the parameters
    $stmt->execute([$name, $last_name, $phone_number, $address, $city, $country, $user_email]);
}

// Get the user email from the session
$user_email = $_SESSION['email'];

// Retrieve the user profile
$query = "SELECT name, last_name, phone_number, address, city, country FROM users WHERE email = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_email]);
$userProfile = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form inputs
    $name = $_POST["name"];
    $last_name = $_POST["last_name"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $country = $_POST["country"];

    // Update the user profile
    updateUserProfile($user_email, $name, $last_name, $phone_number, $address, $city, $country);

    // Redirect back to the user profile page
    header("Location: view-profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="css\edit-profile.css">
    <style>
        /* CSS styles for the edit profile form */
        /* ... Your CSS styles for the form ... */
    </style>
</head>
<body>
    <div class="edit-profile-container">
        <h1>Edit Profile</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $userProfile['name']; ?>">
            
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo $userProfile['last_name']; ?>">
            
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo $userProfile['phone_number']; ?>">
            
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $userProfile['address']; ?>">
            
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo $userProfile['city']; ?>">
            
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo $userProfile['country']; ?>">
            
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
