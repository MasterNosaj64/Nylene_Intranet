<?php
	/*This is the database connection file for our project*/
	
	//$_SESSION["userid"] = 2;

	//$userid   = $_SESSION["userid"];
	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene";
	$conn     = new mysqli($host, $username, $password, $dbname);
	?>