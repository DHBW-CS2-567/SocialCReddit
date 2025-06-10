<?php
require "include/database/user_managment.php";

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['psw'];
    $username = $_POST['uname'];
    $output = login_user($username, $password);
    
    if ($output) {
        session_start();
        $user_temp_data = get_user_data($username);
        
        $_SESSION['username'] = $user_temp_data['username'];
        $_SESSION['userID'] = $user_temp_data['ID'];
        $_SESSION['email'] = $user_temp_data['email'];
        $_SESSION['socialcredit'] = $user_temp_data['SocialCredit'];
        $_SESSION['isadmin'] = $user_temp_data['isadmin'];

        header('Location: index.php');
        exit();
    } else {
        $error_message = "Login failed. Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SocialCReddit</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="logo">Social<span>CReddit</span></div>
        <div class="tagline">DAS FORUM FÜR ALLE OHNE SCHLECHTE HINTERGEDANKEN</div>
        
        <h2>Login</h2>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="uname">Username</label>
                <input type="text" placeholder="Enter Username" name="uname" id="uname" required>
            </div>
            
            <div class="form-group">
                <label for="psw">Password</label>
                <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
            </div>

            <button type="submit" class="auth-button">Login</button>
            <button type="button" class="cancel-button" onclick="window.location.href='index.php'">Cancel</button>
        </form>

        <div class="auth-link">
            Don't have an account? <a href="register.php">Register here</a>
        </div>
    </div>
</body>
</html>