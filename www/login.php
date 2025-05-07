<?php
require 'include\database\user_managment.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['psw'];
    $username = $_POST['uname'];
    $output = register_password($username, $password); // Call the function to handle login
    if ($output) {
        echo "Login successful!";
        sleep(2);
        $url = "index.php";
        session_start(); # Neue Session oder vorhandene fortsetzen
        $_SESSION['name'] = $_POST['uname']; # Session-Variable setzen";
        $SessionTimeOut = 5; # Timeout in Sekunden -> ggf. aus Config-Datei
        header('Location: '.$url);
        die();
        // Redirect to index.php or another page
    } else {
        echo "Login failed. Please try again.";
        sleep(2);
        $url = "login.php";
        header('Location: '.$url);
        die();
    }

    
} else {
    ?>
    <form action="login.php" method="post">
  <div class="imgcontainer">
    <img src="img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
    <br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
    
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <a href="register.php" class="registerbtn" >Register</a>
  </div>
</form> 
<?php    
}
?>