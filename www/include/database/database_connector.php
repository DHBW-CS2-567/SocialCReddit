<?php
// Database connection settings
function getDatabaseConnection() {
    // to use, set a variable to the return value of this function.
    $servername = "";
    $username = "";
    $password = "";
    $dbname = "";
    try{
	$data = yaml_parse_file("../../msql.yaml");
	if ($data === false) {
	    throw new Exception("Failed to parse YAML file.");
	}
	// Required keys
	$requiredKeys = ["servername", "username", "password", "dbname"];

	/* foreach ($requiredKeys as $key) { */
	/*     if (!array_key_exists($key, $data)) { */
	/* 	throw new Exception("Missing required config key: '$key'"); */
	/*     } */
	/* } */
    }
    catch(Throwable $e){
	echo "ERROR WITH MSQL CONF FILE! Contact your Server Administrator";
	echo "Details: " . $e->getMessage();
    }

    $servername = $data["servername"];
    $username = $data["username"];
    $password = $data["password"];
    $dbname = $data["dbname"];
    // Create connection
    return new mysqli($servername, $username, $password, $dbname);
}


?>
