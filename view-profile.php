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

// Function to get user profile
function getUserProfile($user_email)
{
    global $pdo;
    $query = "SELECT name, last_name, email, phone_number, address, city, country FROM users WHERE email = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Get the user email from the session
$user_email = $_SESSION['email'];

// Retrieve the user profile
$userProfile = getUserProfile($user_email);

// Display the user profile information
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Profile</title>
    <style>
        :root {
  --light-pink: #dc5774;
  --background-grey: #eeeeee;
  --light-grey: #7c7a7a;
}
        body {
            background-image: url('..images/entry-background.jpg');
            font-family: 'Ubuntu', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            color: #333;
            text-align: center;
            color: white;
        }

        .profile-container {
    background-color:var(--light-pink) ;
    border-radius: 5px;
    padding: 50px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
    box-shadow: -5px -10px 10px 2px #d9d9d9, 5px 10px 15px 2px #d9d9d9,
    -5px 10px 10px 2px #d9d9d9, 5px -10px 15px 2px #d9d9d9;
}


        .profile-container p {
            margin: 10px 0;
            text-align: center;
            color: white;
        }

        .profile-container strong {
            font-weight: bold;
        }

        .edit-link {
            position: relative;
            text-align: center;
            margin-top: 10px;
           
        }

        .edit-link a {
           
            
            color: #333;
            text-decoration: none;
            border-bottom: 1px solid #333;
        }

        .edit-link a:hover {
            border-bottom-color: #999;
        }
    </style>
</head>
<body>
<div class="profile-container">
    <h1>User Profile</h1>
    <p><strong>Name:</strong> <?php echo $userProfile['name']; ?></p>
    <p><strong>Last Name:</strong> <?php echo $userProfile['last_name']; ?></p>
    <p><strong>Email:</strong> <?php echo $userProfile['email']; ?></p>
    <p><strong>Phone Number:</strong> <?php echo $userProfile['phone_number']; ?></p>
    <p><strong>Address:</strong> <?php echo $userProfile['address']; ?></p>
    <p><strong>City:</strong> <?php echo $userProfile['city']; ?></p>
    <p><strong>Country:</strong> <?php echo $userProfile['country']; ?></p>
    <!-- Display other profile information as needed -->
    
    <div class="edit-link"><a href="edit-profile.php">Edit Profile</a></div>
    <!-- Link to the page where users can edit their profiles -->
</div>
</body>
</html>
