<?php
// Database connection details
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'distributed-e-commerce-db';

// Establish database connection
$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);

session_start(); // Start the session

// Retrieve user information from the database
// Assuming you have retrieved the user's ID and name

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the form inputs
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Check if the user exists

  // Perform the query to fetch user data based on email
  $sql = "SELECT * FROM Users WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) == 0) {
    // User does not exist, display message and registration link
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
                    <p>User with this email does not exist.</p>
                    <p id="login-link">Please <a href="signup.html">register</a> to create an account.</p>
                </div>
            </main>
            </body>
            
            </html>';
  } else {
    // User exists, verify the password
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {
      // Password is correct, set session variables and redirect to home page
     
      $_SESSION['email'] = $email;
      $_SESSION['role'] = $row['role']; // Store the role value in session
      if ($row['role'] == 'admin') {
        echo '<script>
                localStorage.setItem("user_id", ' . $row['id'] . ');
                window.location = "admin_dashboard.php";
              </script>';
      } else {
        // header("Location: index.html");
        echo '<script>
                localStorage.setItem("user_id", ' . $row['id'] . ');
                window.location = "index.html";
              </script>';
      }
      exit();
    } else {
      // Password is incorrect, display message and options
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
                    <p>Incorrect password.</p>
                    <p id="login-link">Please <a href="login.html">try again</a>.</p>
                </div>
            </main>
            </body>
            
            </html>';
    }
  }
}
