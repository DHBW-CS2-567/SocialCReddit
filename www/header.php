<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SocialCReddit</title>
        <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <link rel="stylesheet" href="assets/css/styles.css">

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- jQuery UI JS -->
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

        <script>
            function toggleMenu() {
                const topicsList = document.querySelector('.popular-topics-bar .topics-list');
                topicsList.classList.toggle('show'); // Toggle the "show" class
            }
        </script>
    </head>
</html>
<?php
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
            exit();
        }
// Include the database connection file
require_once "include/database/content_managment.php";
include "include/navbar.php"; // Include the navigation bar

// Read timeout from msql.json configuration file
$file_path = __DIR__ . "/msql.json";
$json = file_get_contents($file_path);
$config_data = json_decode($json, true);
$session_timeout = isset($config_data['timeout']) ? $config_data['timeout'] : 30; // Default to 30 if not found

// Check for session timeout using the configured timeout value
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_timeout)) {
    // Destroy the session
    session_unset();
    session_destroy();
    
    // Redirect to login with logout message
    echo "<script>
        alert('You have been logged out for inactivity');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

?>
