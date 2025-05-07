<?php 
include_once 'mysql_input_valid.php';
include_once 'database_connector.php';
include_once 'password_hashing.php';

// Function to register a new user
function register_user($username, $password, $email){
    $conn = getDatabaseConnection();    // Get the database connection from the database_connector.php file
    // validate the inputs
    if(!sqlinjection_test($username) || !sqlinjection_test($password) || !sqlinjection_test($email)){
        return false; // Invalid input
    }
    // Check if the username already exists
    $sql = 'SELECT * FROM users WHERE username = "'.$username.'" OR email = "'.$email.'"';
    $result = $conn->query($sql); 

    if($result->num_rows > 0){  // User already exists
        return false;
    }
    // Hash the password
    $password_hash = password_hashing($password);
   
    // Insert the new user into the database
    $sql = 'INSERT INTO users (username, passwordhash, email) VALUES ("'.$username.'", "'.$password_hash.'", "'.$email.'")';
    if($conn->query($sql) === TRUE){
        $conn->close(); // Close the database connection
        return true; // User registered successfully
    } else {
        $conn->close(); // Close the database connection
        return false; // Error in registration
    }

}
// Function to login a user
function register_password($username, $password){
    $conn = getDatabaseConnection();  // connect to the database
    // validate the inputs
    if(!sqlinjection_test($username) || !sqlinjection_test($password)){
        return false; // Invalid input
    }
    $password_hash = password_hashing($password);
    $sql = 'SELECT ID FROM users WHERE username = "'.$username.'" AND passwordhash = "'.$password_hash.'"';
    $result = $conn->query($sql); // Execute the query
    if($result->num_rows > 0){ // User exists
        $conn->close(); // Close the database connection
        return true; // User logged in successfully
    } else {
        $conn->close(); // Close the database connection
        return false; // Invalid username or password
    }

}
?>