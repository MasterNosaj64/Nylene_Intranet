<?php
session_start();
include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();


if ($_SESSION['company_id'] != "" && isset($_POST['submit'])) {

$t = time();
    //, assigned_to, date_created, created_by)
    $sqlQuery = "INSERT INTO nylene.customer (customer_name, customer_email, date_created, customer_phone, customer_fax)
VALUES ('". $_POST['firstName'] . " " . $_POST['lastName']. "','". $_POST['email'] . "','" . date("Y-m-d",$t) . "','" . $_POST['phone']."','" . $_POST['fax']."')"; //16
    
    $result = $dbConnection->query($sqlQuery);

    $customer_id = $dbConnection->lastInsertId();

     $sqlRelationQuery = "INSERT INTO nylene.company_relational_customer (company_id, customer_id)
 VALUES ('".$_SESSION['company_id']."','". $customer_id. "')";

     $result = $dbConnection->query($sqlRelationQuery);

     echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php\" />;";
     exit();
}
?>


<html><head>
<link rel="stylesheet" href="table.css">
</head>

<body>
<form method="post" action=addCustomer.php name="add_customer">
<input type="reset" value="Clear">
	<table class ="form-table" border=5>
		<tr>
		<td colspan=4><h2>Customer</h2></td>
		</tr>
		<tr>
			<td>*First Name:</td>
			<td><input type="text" required name="firstName"></td>
			<td>*Last Name:</td>
			<td><input type="text" required name="lastName" ></td>
		</tr>
		<tr>
			<td>*Email:</td>
			<td><input type="email" required  name="email"></td>
			<td>Phone:</td>
			<td><input type="tel" name="phone"></td>
		</tr>
		<tr>
			<td>Fax:</td>
			<td><input type="tel" name="fax"></td>
		</tr>
		
	</table>
	<input type="submit" name="submit" value="Submit" >
</form>
</body>
</html>
