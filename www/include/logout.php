<?php 
//delete session, and cookie and redirect to login page
session_start();
session_destroy();
setcookie(session_name(), '', time() - 3600, '/'); // Delete the session cookie
header('Location: ../login.php');
exit();
?>