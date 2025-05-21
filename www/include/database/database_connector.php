<?php
// Database connection settings
function getDatabaseConnection() {
    // to use, set a variable to the return value of this function.
    try{
	$json = file_get_contents("../../msql.json");
	if ($json === false) {
	    throw new Exception("Failed to read msql.json.");
	}
	// Required keys
	$data = json_decode($json);
	if ($data === null) {
	    throw new Exception("Failed to parse JSON file.");
	}

	/* foreach ($requiredKeys as $key) { */
	/*     if (!array_key_exists($key, $data)) { */
	/* 	throw new Exception("Missing required config key: '$key'"); */
	/*     } */
	/* } */
	$servername = $data["servername"];
	$username = $data["username"];
	$password = $data["password"];
	$dbname = $data["dbname"];
	// Create connection
	return new mysqli($servername, $username, $password, $dbname);
    }
    catch(Throwable $e){
        echo "ERROR WITH MSQL CONF FILE! Contact your Server Administrator<br>";
        echo "Details: " . $e->getMessage();
        exit;
    }
}


?>
