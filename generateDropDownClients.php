<?php
	include "connect.php";

	$q = intval($_GET['q']);

	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
	   $clients = "SELECT * FROM customer
					INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
						INNER JOIN company ON company.company_id = company_relational_customer.company_id WHERE company.company_id=" . $q;

	   $result = $conn->query($clients); 

	   echo "<select id=\"customer_id\" name=\"customer_id\" style=\"width:100%\" onchange=\"populateInfo(this.value)\">";
	   echo "<option value=\"-1\"> Select a Customer... </option>";
			while($row = mysqli_fetch_array($result))
			{
				echo "<option value=" . $row['customer_id'] . " > " . $row['customer_name'] . " </option>";
			}
	   echo	"</select>";
	}
?>