<?php
// Database connection settings
function getDatabaseConnection() {
    // to use, set a variable to the return value of this function.
    try{
	$file_path = __DIR__ . "/../../msql.json";
	$json = file_get_contents($file_path);
	if ($json === false) {
	    throw new Exception("Failed to read msql.json." . $file_path);
	}
	// Required keys
	$data = json_decode($json, associative: true);
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
