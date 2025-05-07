<?php
// function existsts that we can easely change the hashing algorithm, without changing the rest of the code
function password_hashing($password){
    // Hash the password using bcrypt
    return password_hash($password, PASSWORD_BCRYPT);
}
?>