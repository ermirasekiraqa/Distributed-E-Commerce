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
        // Create a new PDO instance
$pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

// Function to add a user
function addUser($name, $last_name, $email, $password, $phone_number, $address, $city, $country)
{
    global $pdo;
    $role = 'customer';
    $query = "INSERT INTO users (name, last_name, email, password, phone_number, address, city, country, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $last_name, $email, $password, $phone_number, $address, $city, $country, $role]);
    echo '<script>alert("User added successfully.");</script>';
}

// Function to delete a user
function deleteUser($user_id)
{
    global $pdo;

    // Check if the user with the given ID exists in the database
    $checkQuery = "SELECT role FROM users WHERE id = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$user_id]);
    $user = $checkStmt->fetch();

    if ($user['role'] === 'admin') {
        echo '<script>alert("Cannot delete admin.");</script>';
    } else {
        if ($user) {
            // Delete the user
            $deleteQuery = "DELETE FROM users WHERE id = ?";
            $deleteStmt = $pdo->prepare($deleteQuery);
            $deleteStmt->execute([$user_id]);
            echo '<script>alert("User deleted successfully.");</script>';
        } else {
            echo '<script>alert("User with ID $user_id does not exist.");</script>';
        }
    }
}

// Function to update a user
function updateUser($user_id, $name, $last_name, $email, $password, $phone_number, $address, $city, $country)
{
    global $pdo;

    // Check if the user with the given ID exists in the database
    $checkQuery = "SELECT role FROM users WHERE id = ?";
    $checkStmt = $pdo->prepare($checkQuery);
    $checkStmt->execute([$user_id]);
    $user = $checkStmt->fetch();

    if ($user['role'] === 'admin') {
        echo '<script>alert("Cannot edit admin.");</script>';
    } else {
        if ($user) {
            // Build the update query
            $updateFields = [];
            $values = [];

            // Add the fields and values to update only if they are provided
            if (!empty($name)) {
                $updateFields[] = "name = ?";
                $values[] = $name;
            }
            if (!empty($last_name)) {
                $updateFields[] = "last_name = ?";
                $values[] = $last_name;
            }
            if (!empty($email)) {
                $updateFields[] = "email = ?";
                $values[] = $email;
            }
            if (!empty($password)) {
                $updateFields[] = "password = ?";
                $values[] = $password;
            }
            if (!empty($phone_number)) {
                $updateFields[] = "phone_number = ?";
                $values[] = $phone_number;
            }
            if (!empty($address)) {
                $updateFields[] = "address = ?";
                $values[] = $address;
            }
            if (!empty($city)) {
                $updateFields[] = "city = ?";
                $values[] = $city;
            }
            if (!empty($country)) {
                $updateFields[] = "country = ?";
                $values[] = $country;
            }

            if (!empty($updateFields)) {
                // Update the user
                $query = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE id = ?";
                $values[] = $user_id;
                $stmt = $pdo->prepare($query);
                $stmt->execute($values);
                echo '<script>alert("User updated successfully.");</script>';
            } else {
                echo "No fields provided for update.";
            }
        } else {
            echo '<script>alert("User with ID ' . $user_id . ' does not exist.");</script>';
        }
    }
}


// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check the action and perform the appropriate operation
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $name = $_POST['name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $phone_number = $_POST['phone_number'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                addUser($name, $last_name, $email, $password, $phone_number, $address, $city, $country);
                break;
            case 'delete':
                $user_id = $_POST['user_id'];
                deleteUser($user_id);
                break;
            case 'update':
                $user_id = $_POST['user_id'];
                $name = $_POST['name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
                $phone_number = $_POST['phone_number'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                updateUser($user_id, $name, $last_name, $email, $password, $phone_number, $address, $city, $country);
                break;
        }
    }
}

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
    <link rel="stylesheet" href="css\add-delete-edit_product.css" />

    <script defer src="js\header-functions.js"></script>

    <title>Admin Panel</title>
</head>

<body>
    <header>
    
    </header>

    <main id="main-container">
    <div class="container">
    <div class="form user-form">
        <h1>Add User</h1>
        <!-- Add User Form -->
        <form method="post" action="">
            <input type="hidden" name="action" value="add">
            <input type="text" placeholder="Name" name="name" required><br>
            <input type="text" placeholder="Last name" name="last_name" required><br>
            <input type="email" placeholder="Email" name="email" required><br>
            <input type="password" placeholder="Password" name="password" required><br>
            <input type="text" placeholder="Phone number" name="phone_number" required><br>
            <input type="text" placeholder="Address" name="address" required><br>
            <input type="text" placeholder="City" name="city" required><br>
            <input type="text" placeholder="Country" name="country" required><br>
            <button class="form-button" type="submit" value="Add User">Add User</button>
        </form>
    </div>

    <div class="form user-form">
        <!-- Delete User Form -->
        <h1>Delete User</h1>
        <form method="post" action="">
            <input type="hidden" name="action" value="delete">
            <input type="number" placeholder="User ID" name="user_id" required><br>
            <button class="form-button" type="submit" value="Delete User">Delete User</button>
        </form>
        <a href="user-table.php" target="_blank">
            <button class="form-button user-list-button">User List</button>
        </a>
    </div>


    <div class="form user-form">
        <!-- Update User Form -->
        <h1>Update User</h1>
        <form method="post" action="">
            <input type="hidden" name="action" value="update">
            <input type="number" placeholder="User Id" name="user_id" required><br>
            <input type="text" placeholder="Name" name="name"><br>
            <input type="text" placeholder="Last name" name="last_name"><br>
            <input type="email" placeholder="Email" name="email"><br>
            <input type="password" placeholder="Password" name="password"><br>
            <input type="text" placeholder="Phone number" name="phone_number"><br>
            <input type="text" placeholder="Address" name="address"><br>
            <input type="text" placeholder="City" name="city"><br>
            <input type="text" placeholder="Country" name="country"><br>
            <button class="form-button " type="submit" value="Update User">Update User</button>
        </form>
        <a href="user-table.php" target="_blank">
            <button class="form-button user-list-button-update">User List</button>
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
