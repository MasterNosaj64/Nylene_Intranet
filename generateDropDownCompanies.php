<?php
	include "connect.php";

	if (mysqli_connect_error())
	{
		die('Connect Error ('. mysqli_connect_errno() . ') '.mysqli_connect_error);
	}
	else 
	{
	   $companies = "SELECT * FROM company";
	   $result = $conn->query($companies); 

	   echo "<select id=\"company_id\" name=\"company_id\" onchange=\"generateDropDownContacts(this.value)\" style=\"width:100%\">";
	   echo "<option value=\"-1\"> Select a Company... </option>";
			while($row = mysqli_fetch_array($result))
			{
				echo "<option value=" . $row['company_id'] . " > " . $row['company_name'] . " </option>";
			}
	   echo	"</select>";
	}
?>