<?php
include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();

if($_SESSION['company_id'] != ""){

//Get Interactions for Company by customer_id
    $sqlquery = "SELECT * FROM nylene.interaction WHERE company_id = " .$_SESSION['company_id']. " ORDER BY date_created ASC";
$result = $dbConnection->query($sqlquery);
//$test = $dbConnection->query($sqlquery);
echo "<h1>Company History</h1>";

//Get company info
$sqlGetCompany = "SELECT * FROM nylene.company WHERE company_id = ".$_SESSION['company_id'];
$getCompanyInfo = $dbConnection->query($sqlGetCompany);
$companyInfo = $getCompanyInfo->fetch(PDO::FETCH_ASSOC);

$companyAddress = $companyInfo["billing_address_street"].", ".$companyInfo["billing_address_city"].", "
    .$companyInfo["billing_address_state"].", ".$companyInfo["billing_address_country"].", ".$companyInfo["billing_address_postalcode"];
    
    echo "<table border=5>";
    echo "<tr><td>Company:</td><td>".$companyInfo["company_name"]."</td><td>Address:</td><td>$companyAddress</td></tr>";
    echo "<tr><td>Website:</td><td><a href=\"".$companyInfo["website"]."\">".$companyInfo["website"]."</a></td><td>Email:</td><td><a href=\"mailto: ".$companyInfo["company_email"]."\">".$companyInfo["company_email"]."</a></td></tr>";
    echo "</table>";

// if(!$test->fetch()){
//     echo "This company has no interaction history";
//   exit;  
//}
}
else{
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./Homepage.php\" />;";
    exit();
}
?>

<form method="post" action="AddInteraction.php">
<input hidden name="company_id" value="<?php echo $_SESSION['company_id'];?>"/>
<input type="submit" value="Create Interaction"/>
</form>

<table border=5>
	<tr>
		<td><h2>Date</h2></td>
		<td><h2>Customer</h2></td>
		<td><h2>Reason</h2></td>
		<td><h2>Notes</h2></td>
		<td><h2>Manage</h2></td>
	</tr>
	
	<?php 
	
	while($row = $result->fetch(PDO::FETCH_ASSOC)){
	    
	    $sqlGetCustomerID = "SELECT * FROM nylene.customer WHERE customer_id =".$row["customer_id"];
	    $getCustomerName = $dbConnection->query($sqlGetCustomerID);
	    $customerName = $getCustomerName->fetch(PDO::FETCH_ASSOC);
	    
	    echo "<tr><td>".$row["date_created"]."</td><td>".$customerName["customer_name"]."</td><td>".$row["reason"]."</td><td>". substr($row["comments"],0,50) . "</td><td>

<form method=\"post\" action=\"viewInteraction.php\">
<input hidden type=\"text\" name=\"interaction_id\" value=\"".$row["interaction_id"]."\">
<input type=\"submit\" value=\"view\"/>
</form>
</td></tr>";
	}
	?>

</table>