<?php
	include "connect.php";

	$q = intval($_GET['q']);

	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
	  $clients = "SELECT billing_address_street, billing_address_city, billing_address_state, billing_address_postalcode FROM company
					WHERE company_id=" . $q;

	   $result = $conn->query($clients); 
	   $row = mysqli_fetch_array($result);

	   $address = $row['billing_address_street'] . ", " . $row['billing_address_city'] . ", " .  $row['billing_address_state'] . ", " . $row['billing_address_postalcode'];

	   echo "<input type=\"hidden\">";
	   echo "<p style=\"background-color:lightblue\"> " . $address . " </p>";
	}
?>