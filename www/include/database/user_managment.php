<?php
include_once 'database_connector.php';
include_once 'password_hashing.php';

// Function to register a new user
function register_user($username, $password, $email){
    $conn = getDatabaseConnection();    // Get the database connection from the database_connector.php file
    // Check if the username already exists
    $sql = 'SELECT * FROM users WHERE username = ? OR email = ?';
    $result = $conn->execute_query($sql, [$username, $email]);

    if($result->num_rows > 0){  // User already exists
        return false;
    }
    // Hash the password
    $password_hash = password_hashing($password);

    // Insert the new user into the database
    $sql = 'INSERT INTO users (username, passwordhash, email) VALUES (?, ?, ?)';
    if($conn->execute_query($sql, [$username, $password_hash, $email]) === TRUE){
        $conn->close(); // Close the database connection
        return true; // User registered successfully
    } else {
        $conn->close(); // Close the database connection
        return false; // Error in registration
    }

}
// Function to login a user
function login_user($username, $password){
    $conn = getDatabaseConnection();  // connect to the database
    // validate the inputs
    $password_hash = password_hashing($password);
    $sql = 'SELECT ID FROM users WHERE username = ? AND passwordhash = ?';
    $result = $conn->execute_query($sql, [$username, $password_hash]); // Execute the query
    if($result->num_rows > 0){ // User exists
        $conn->close(); // Close the database connection
        return true; // User logged in successfully
    } else {
        $conn->close(); // Close the database connection
        return false; // Invalid username or password
    }

}

function get_user_data($username){
    $conn = getDatabaseConnection();  // connect to the database
    // validate the inputs
    $sql = 'SELECT * FROM users WHERE username = ?';
    $result = $conn->execute_query($sql, [$username]); // Execute the query
    if($result->num_rows > 0){ // User exists
        $user_data = $result->fetch_assoc(); // Fetch user data
        $conn->close(); // Close the database connection
        return $user_data; // Return user data
    } else {
        $conn->close(); // Close the database connection
        return false; // User not found
    }

}

?>
