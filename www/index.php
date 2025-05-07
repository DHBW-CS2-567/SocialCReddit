<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hello</title>
	<link href="" rel="stylesheet">
    </head>
    <body>
        <?php
        // if user not logged in, redirect to login page check via session from login.php
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
            exit();
        }
        // if user is logged in, show the welcome message
        echo "<h1>Welcome " . htmlspecialchars($_SESSION['user']) . "</h1>";
       
        // show the user data
     
        ?>
    </body>
</html>

