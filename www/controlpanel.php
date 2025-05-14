<!DOCTYPE html>
<html lang="en">

<head>
    <title>SocialCReddit - Admin Panel</title>
    <meta charset="UTF-8">
    <?php include "header.php"; ?>
    <link rel="stylesheet" href="assets/css/create.css">
</head>

<body>
    <?php
    // Include the database connection and user management functions
    require "include/database/user_managment.php";
    require "include/database/post_managment.php";

    // Check if the user is logged in and is an admin
    if (!isset($_SESSION['isadmin']) || $_SESSION['isadmin'] != 1) {
        header('Location: index.php');
        exit();
    }

    
    ?>