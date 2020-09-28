<?php
	//$_SESSION["userid"] = 2;

	//$userid   = $_SESSION["userid"];
	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene";
	$conn    = mysqli_connect($host, $username, $password, $dbname);
	$db = mysqli_select_db($conn, "nylene");

	?>