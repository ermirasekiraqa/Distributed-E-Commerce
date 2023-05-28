<?php
// Start the session
session_start();

// Check if the user is authenticated
$authenticated = false;
$email = '';
$role = '';
// if (isset($_SESSION['email'])) {
//   // User is authenticated
//   $authenticated = true;
//   $email = $_SESSION['email'];
// }

if (isset($_SESSION['email'])) {
  // User is authenticated
  $authenticated = true;
  $email = $_SESSION['email'];

  // Database connection parameters
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'distributed-e-commerce-db';

  // Create a new PDO instance
  $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

  // Retrieve the user's role based on email
  $query = "SELECT role FROM users WHERE email = ?";
  $stmt = $pdo->prepare($query);
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user) {
      $role = $user['role'];
  } else {
      echo "User not found.";
  }
}


// Create an associative array with the authentication status and email
$response = array(
  'authenticated' => $authenticated,
  'email' => $email,
  'role' => $role
);

// Send the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
