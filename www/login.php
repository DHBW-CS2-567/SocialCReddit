
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['uname']== "abc" && $_POST['psw'] == "123") {
    $url = "index.php";
    session_start(); # Neue Session oder vorhandene fortsetzen
    $_SESSION['name'] = $_POST['uname']; # Session-Variable setzen";
    $SessionTimeOut = 5; # Timeout in Sekunden -> ggf. aus Config-Datei
    header('Location: '.$url);
    die();
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
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
</form> 
<?php    
}
?>