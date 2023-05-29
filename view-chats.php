<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['email'])) {
    // Redirect to the login page or display an error message
    header("Location: login.html");
    exit();
} else {
    if ($_SESSION['role'] === 'admin') {
        echo '<!DOCTYPE html>
        <html lang="en">
        
        <head>
          <meta charset="UTF-8" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
          <link rel="stylesheet" type="text/css"
            href="http://fonts.googleapis.com/css?family=Ubuntu:regular,bold&subset=Latin" />
          <link rel="stylesheet" href="css\normalize.css" />
          <link rel="stylesheet" href="css\common.css" />
          <link rel="stylesheet" href="css\view-chats.css" />
        
          <script defer src="js\header-functions.js"></script>
          <script src="http://localhost:4000/socket.io/socket.io.js"></script>        
        
          <title>Chats</title>
        
          <link rel="icon" type="image/x-icon" href="images\favicon.png">
        </head>
        
        <body>
        <header>
        
        </header>
        <main id="chats-main-container">
        <div class="users-container">';
        // Database connection parameters
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'distributed-e-commerce-db';

        // Create a new PDO instance
        $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);

        // Perform the SQL query
        $query = "SELECT cr.participant_1_id, cr.participant_2_id
                  FROM chatrooms AS cr
                  INNER JOIN users AS u1 ON cr.participant_1_id = u1.id
                  INNER JOIN users AS u2 ON cr.participant_2_id = u2.id
                  WHERE u1.role != 'admin' OR u2.role != 'admin'";

        $statement = $pdo->query($query);
        
        // Check if there are any rows returned
        if ($statement->rowCount() > 0) {
            // Display the participant IDs
            echo "<h2 id='header'>Participant IDs</h2>";
            echo "<ul>";
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                $adminID = $_SESSION['admin_id'];
                $idToShow = $row['participant_1_id'];
                $participantFirstName = '';
                $participantLastName = '';
                if ($row['participant_1_id'] === (int)$adminID) {
                    $idToShow = $row['participant_2_id'];
                }
                $secondQuery = "SELECT * FROM users WHERE id = $idToShow";
                    $secondStatement = $pdo->query($secondQuery);
                    if ($secondStatement->rowCount() > 0) {
                        $secondRow = $secondStatement->fetch(PDO::FETCH_ASSOC);
                        $participantFirstName = $secondRow['name'];
                        $participantLastName = $secondRow['last_name'];
                    }
                echo "<li id='". $idToShow ."' class='participant'>User: " . $participantFirstName . " " . $participantLastName ."</li>";
                echo "<br>";
            }
            echo "</ul>
            </div>";

            echo 
                '<script>
                    let socket = io("http://localhost:4000");
                    const listItems = document.getElementsByClassName("participant");
                    // let participant = document.getElementById("participant");
                    // Iterate over the list items and assign an event listener
                    for (let i = 0; i < listItems.length; i++) {
                    listItems[i].addEventListener("click", function() {
                        sessionStorage.setItem("participant_id", listItems[i].id);
                        window.location = "chat.html";
                    });
                    }
                    // console.log("participant ", participant)
                    // participant.addEventListener("click", function() {
                    //     sessionStorage.setItem("participant_id", participant.className);
                    //     window.location = "chat.html";
                    // });
                </script>';

            echo "</main>
            </body>

</html>";
        } else {
            echo "No participants found.";
        }
    }
}
?>
