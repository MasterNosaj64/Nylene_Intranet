<?php

/*
 Sets up the PDO database connection
 */
function setConnectionInfo() {
    
    
    $connString = "mysql:host=localhost;dbname=nylene";
    $user = "root";
    $password = "";
    
    $pdo = new PDO($connString,$user,$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene";
	$conn    = mysqli_connect($host, $username, $password, $dbname);
	$db = mysqli_select_db($conn, "nylene");

?>