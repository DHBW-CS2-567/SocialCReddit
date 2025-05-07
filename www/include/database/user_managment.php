<?php 
include_once 'mysql_input_valid.php';
include_once 'database_connector.php';
// Function to register a new user
function register_user($username, $password, $email){
    $conn = getDatabaseConnection();
    // Check if the username already exists
    $sql = 'SELECT * FROM users WHERE username = "'.$username.'"';
    $result = $conn->query($sql);
    echo $result;

}

register_user('testuser', 'password123', 'test@mail.com');
?>