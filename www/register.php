<?php
require "include/database/user_managment.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Call the function to handle registration
    $result = register_user($username, $password, $email);
    

    if ($result) {
        echo "Registration successful!";
        sleep(2);
        // Redirect to login page or another page
        header('Location: login.php');
        exit();
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register.php" method="post">
        <label for="username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="username" required>
        <br>
        <label for="email"><b>Email</b></label>
        <input type="email" placeholder="Enter Email" name="email" required>
        <br>
        <label for="password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <br>
         already habe an account?
  <a href="login.php" class="loginbtn" >login</a>
        <br>
        <button type="submit">Register</button>
    </form>
   
</body>
</html>