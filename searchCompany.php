<?php
session_start();

unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();


if(isset($_POST['search_By_Name'])){

    $sqlquery = "SELECT * FROM nylene.company WHERE company_name = '".$_POST['search_By_Name']."' ORDER BY company_name ASC";
    $result = $dbConnection->query($sqlquery);


}else if(isset($_POST['search_By_Website'])){

    $sqlquery = "SELECT * FROM nylene.company WHERE website = '".$_POST['search_By_Website']."' ORDER BY company_name ASC";
    $result = $dbConnection->query($sqlquery);
    $test = $dbConnection->query($sqlquery);

}else{

    $sqlquery = "SELECT * FROM nylene.company ORDER BY company_name ASC";
    $result = $dbConnection->query($sqlquery);
    $test = $dbConnection->query($sqlquery);

if(!$test->fetch()){
    echo "The company database is empty";
  exit;
}
}
?>
<html>
<head>
  <link rel="stylesheet" href="table.css">
</head>

<!-- Company Search -->

<table class ="form-table" border=5>
	<tr>
	<form method="post" action=searchCompany.php name="search_companyName">
		<td>Name: </td>
		<td><input type="text" required name="search_By_Name"/></td>
		<td><input type="submit" value="Search"/></td>
	</form>
	<form method="post" action=searchCompany.php name="search_companyWebsite">
		<td>Website: </td>
		<td><input type="url" required value="http://" name="search_By_Website"/></td>
		<td><input type="submit" value="Search"/></td>
	</form>
	<form method="post" action=searchCompany.php name=reset>
		<td><input type="submit" value="Reset"/></td>
	</form>
	</tr>
</table>



<table class= "form-table" border=5>
  <thead>
	<tr>
		<td>Name</td>
		<td>Website</td>
		<td>Email</td>
		<td>Billing Street</td>
		<td>Billing City</td>
		<td>Billing State</td>
		<td>Menu</td>
	</tr>
</thead>
<!-- </head> </html> -->
	<?php
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
	    echo "<tr><td>" . $row["company_name"] . "</td><td><a href=\"". $row["website"] ."\">"  . $row["website"] . "</a></td><td><a href =\"mailto: ".$row["company_email"]."\">" . $row["company_email"] . "</a></td><td>" . $row["billing_address_street"] . "</td><td>" . $row["billing_address_city"] . "</td><td>". $row["billing_address_state"] . "</td>
<td><form action=\"./editCompany.php\" method=\"post\">
		<input hidden name =\"company_id_edit\" value=\"".$row['company_id']."\"/>
		<input type=\"submit\" value=\"edit\"/>
	</form>
    <form action=\"./viewCompany.php\" method=\"post\">
		<input hidden name =\"company_id_view\" value=\"".$row['company_id']."\"/>
		<input type=\"submit\" value=\"view\"/>
	</form>




   </td></tr>";
	}
	?>

</table>
</html>
