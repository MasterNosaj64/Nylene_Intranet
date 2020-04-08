<?php
	include "connect.php";

	$q = intval($_GET['q']);

	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
	   $clients = "SELECT customer_phone FROM customer
					 WHERE customer_id=" . $q;

	   $result = $conn->query($clients); 
	   $row = mysqli_fetch_array($result);

	   echo "<p style=\"background-color:lightblue\"> " . $row['customer_phone'] . " </p>";
	}
?>