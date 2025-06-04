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
require_once "include/navbar.php"; // Include the navigation bar


?>
