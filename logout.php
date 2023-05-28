<?php
// Start the session
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

echo '<script>
        localStorage.clear();
        window.location = "login.html";
    </script>';

// Redirect to the login page or any other page you desire
// header("Location: login.html");
exit();
?>
