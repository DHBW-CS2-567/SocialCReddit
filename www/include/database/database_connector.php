<?php
// Database connection settings
function getDatabaseConnection() {
    // to use, set a variable to the return value of this function.
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "socialcreddit";
    
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}
?>