<?php
//Session_start();
//include 'menu.php';
include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();


if(isset($_POST['company_id_view']) || $_SESSION['company_id'] != ""){


    if(isset($_POST['company_id_view'])){
        $_SESSION['company_id'] = $_POST['company_id_view'];
    }

//Get Company data
    $companysqlquery = "SELECT * FROM nylene.company WHERE company_id = " .$_SESSION["company_id"];
$companyInfo = $dbConnection->query($companysqlquery)->fetch(PDO::FETCH_ASSOC);

//Get customer_id's for company
$customersqlquery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = ".$_SESSION['company_id'];
$customers = $dbConnection->query($customersqlquery);


echo "<h1>Company View</h1>";

//Get company info



$companyAddress = $companyInfo["billing_address_street"].", ".$companyInfo["billing_address_city"].", "
    .$companyInfo["billing_address_state"].", ".$companyInfo["billing_address_country"].", ".$companyInfo["billing_address_postalcode"];

$companyShippingAddress = $companyInfo["shipping_address_street"].", ".$companyInfo["shipping_address_city"].", "
    .$companyInfo["shipping_address_state"].", ".$companyInfo["shipping_address_country"].", ".$companyInfo["shipping_address_postalcode"];

    echo "<link rel=\"stylesheet\" href=\"table.css\">";
    echo "<table class =\"form-table\"  border=5>";
    echo "<tr><td>Company:</td><td>".$companyInfo["company_name"]."</td><td>Address:</td><td>$companyAddress</td></tr>";
    echo "<tr><td>Website:</td><td><a href=\"".$companyInfo["website"]."\">".$companyInfo["website"]."</a></td><td>Email:</td><td><a href=\"mailto: ".$companyInfo["company_email"]."\">".$companyInfo["company_email"]."</a></td></tr>";
    echo "</table>";
}
else{
echo "<meta http-equiv = \"refresh\" content = \"0; url = ./searchCompany.php\" />;";
exit();
}

?>
<html><head>
  <!--
  <link rel="stylesheet" href="table.css">
</head>

-->
<form method="post" action="addCustomer.php">
<input hidden name="company_id" value="<?php echo $_SESSION['company_id'];?>"/>
<input type="submit" value="Add Customer"/>
</form>
<form method="post" action="companyHistory.php">
<input hidden name="company_id" value="<?php echo $_SESSION['company_id'];?>"/>
<input type="submit" value="View History"/>
</form>


<!-- Customers List -->
<table class = "form-table" border=5>
	<tr>
		<td><h2>Name</h2></td>
		<td><h2>Email</h2></td>
		<td><h2>Phone</h2></td>
		<td><h2>Date Created</h2></td>
		<td><h2>Manage</h2></td>
	</tr>

	<?php

	while($cx = $customers->fetch(PDO::FETCH_ASSOC)){
	    $sqlGetCustomerDataQuery = "SELECT * FROM nylene.customer WHERE customer_id = ".$cx["customer_id"];
	    $customerData = $dbConnection->query($sqlGetCustomerDataQuery)->fetch(PDO::FETCH_ASSOC);
        echo "<tr><td>".$customerData["customer_name"]."</td><td><a href=\"mailto: ".$customerData["customer_email"]."\">".$customerData["customer_email"]."</td><td>".$customerData["customer_phone"]."</td><td>".$customerData['date_created']."</td><td>
<form method=\"post\" action=\"editCustomer.php\">
<input hidden type=\"text\" name=\"customer_id\" value=\"".$cx["customer_id"]."\">
<input type=\"submit\" value=\"edit\"/>
</form>
</td></tr>";
	}
	?>
</table>
</html>
