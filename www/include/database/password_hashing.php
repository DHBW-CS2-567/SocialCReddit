<?php
// function existsts that we can easely change the hashing algorithm, without changing the rest of the code
function password_hashing($password){
    // options that the hashfunction do not use salt for now
   
    
    // Hash the password using bcrypt
    return hash('sha512', $password);
}
?>