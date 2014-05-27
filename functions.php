<?php

require '/Applications/XAMPP/xamppfiles/htdocs/config/config.php'; # development path

// require($_SERVER[DOCUMENT_ROOT]."/../config.php"); # production path - store config.php above document root




/* ---------- DATABASE FUNCTIONS ---------- */

/* Connect to database */
function connect($config) {
	try {
		$conn = new PDO("mysql:host=localhost;dbname={$config['DB_NAME']}",
						$config['DB_USERNAME'],
						$config['DB_PASSWORD']);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} 
	catch(Exception $e) {
		return false;
	}
}


/* 
Returns all rows from $tableName and checks that table is not empty. 
If $tableName does not exist or is empty, returns false.
*/
function getAllRows($tableName, $conn) {
	try {
		$result = $conn->query("SELECT * FROM $tableName");
		return $result->rowCount() > 0 ? $result : false;
	}
	catch(Exception $e) {
		return false;
	}
}


/*
Dynamically query database. 
$query: MySQL query
$bindings: values to bind to query
*/
function queryDB($query, $bindings, $conn) {
	$stmt = $conn->prepare($query);
	$stmt->setFetchMode(PDO::FETCH_OBJ);
	$stmt->execute($bindings);
	$results = $stmt->fetchAll();
	return $results ? $results : false;
}


/*
Insert values into database. 
$query: MySQL query
$bindings: values to bind to query
*/
function insertUpdateDeleteDB($query, $bindings, $conn) {
	$stmt = $conn->prepare($query);
	$stmt->setFetchMode(PDO::FETCH_OBJ);
	$stmt->execute($bindings);
}

/* ---------- END OF DATABASE FUNCTIONS ---------- */



/* 
Delete file from directory
$path parameter eg "../images/frontpage/{$orientation}/{$filename}" 
*/
function deleteImage($path, $conn) {
	if (file_exists($path)) {
		unlink( $path );
	} else {
		echo "File does not exist";
	}
}

?>