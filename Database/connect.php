<?php
// 	$host     = "localhost";
// 	$username = "root";
// 	$password = "";
// 	$dbname   = "nylene";
// 	$conn    = mysqli_connect($host, $username, $password, $dbname);
// 	$db = mysqli_select_db($conn, "nylene");
	
	function getDBConnection(){
	    $host     = "localhost";
	    $username = "root";
	    $password = "";
	    $dbname   = "nylene";
	    $conn    = mysqli_connect($host, $username, $password, $dbname);
	    date_default_timezone_set('America/Toronto');
	    return $conn;
	}
	
	?>