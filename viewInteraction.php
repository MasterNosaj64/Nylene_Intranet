<?php
include 'navigation.php';
include 'databaseConnection.php';

if($_SESSION['interaction_id']==""){
    $_SESSION['interaction_id'] = $_POST["interaction_id"];
}

$dbConnection = setConnectionInfo();

  
  $query_view_interaction = "SELECT * FROM nylene.interaction WHERE interaction_id = ".$_SESSION['interaction_id'];
  $viewInteractionData = $dbConnection->query($query_view_interaction)->fetch(PDO::FETCH_ASSOC);

  $query_view_company ="SELECT * FROM nylene.company WHERE company_id = ".$viewInteractionData['company_id'];
  $viewCompanyData = $dbConnection->query($query_view_company)->fetch(PDO::FETCH_ASSOC);
  
  $companyAddress = $viewCompanyData["billing_address_street"].", ".$viewCompanyData["billing_address_city"].", "
      .$viewCompanyData["billing_address_state"].", ".$viewCompanyData["billing_address_country"].", ".$viewCompanyData["billing_address_postalcode"];
  
  $query_view_customer ="SELECT * FROM nylene.customer WHERE customer_id = ".$viewInteractionData['customer_id'];
  $viewCustomerData = $dbConnection->query($query_view_customer)->fetch(PDO::FETCH_ASSOC);

?>
<html>
<body>
<h1>Interaction</h1>
<table border = 5>
  <tr>
  		<td><h2>Company:</h2></td><td><?php echo $viewCompanyData['company_name'];?></td>
  		<td><h2>Address:</h2></td><td><?php echo $companyAddress;?></td>
  		<td><h2>Company Email:</h2></td><td><?php echo $viewCompanyData['company_email'];?></td>
  </tr>
  <tr>
		<td><h2>Name:</h2></td><td><?php echo $viewCustomerData['customer_name'];?></td>
		<td><h2>Email:</h2></td><td><a href="mailto: <?php echo $viewCustomerData['customer_email'];?>"><?php echo $viewCustomerData['customer_email'];?></a></td>
		<td><h2>Phone:</h2></td><td><?php echo $viewCustomerData['customer_phone'];?></td>
 </tr>
 <tr>
		<td><h2>Reason:</h2></td><td><?php echo $viewInteractionData['reason'];?></td>
		<td><h2>Date Created:</h2></td><td><?php echo $viewInteractionData['date_created'];?></td>
		<td><h2>Form: </h2></td><td>check if forms exist and give link</td>
</tr>		
<tr>
	<td colspan=6><textarea readonly rows="20" cols="100"><?php echo $viewInteractionData['comments']; ?> </textarea></td>
</tr>
</table>
</body>
</html>
