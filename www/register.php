<?php
require "include/database/user_managment.php";

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = register_user($username, $password, $email);
    
    if ($result) {
        $success_message = "Registration successful! Redirecting to login...";
        echo "<script>
            setTimeout(function() {
                window.location.href = 'login.php';
            }, 2000);
        </script>";
    } else {
        $error_message = "Registration failed. Username or email may already exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SocialCReddit</title>
    <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="logo">Social<span>CReddit</span></div>
        <div class="tagline">DAS FORUM FÜR ALLE OHNE SCHLECHTE HINTERGEDANKEN</div>
        
        <h2>Register</h2>
        
        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <?php if ($success_message): ?>
            <div class="success-message"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>

        <form action="register.php" method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" placeholder="Enter Username" name="username" id="username" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" placeholder="Enter Password" name="password" id="password" required>
            </div>

            <button type="submit" class="auth-button">Register</button>
            <button type="button" class="cancel-button" onclick="window.location.href='login.php'">Cancel</button>
        </form>

        <div class="auth-link">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>