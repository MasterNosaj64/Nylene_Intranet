<?php
	$host     = "localhost";
	$username = "root";
	$password = "";
	$dbname   = "nylene";
	$conn    = mysqli_connect($host, $username, $password, $dbname);
	$db = mysqli_select_db($conn, "nylene");
	?>