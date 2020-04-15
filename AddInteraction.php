<?php
session_start();
$_SESSION["navToAddInteractionPage"] = true;
include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();

if ($_POST['company_id'] != "") {

    $_SESSION['company_id'] = $_POST['company_id'];
    
    if (isset($_POST['submit'])) {        
        $t = time();
        $insertInteractionQuery = "INSERT INTO nylene.interaction (company_id, customer_id, employee_id, reason, comments, date_created) VALUES ('" . $_POST['company_id'] . "','" . $_POST['customer_id'] . "','" . $_SESSION['userid'] . "','" . $_POST['reason'] . "','" . $_POST['comments'] . "','" . date("Y-m-d", $t) . "') ";
        $dbConnection->query($insertInteractionQuery);
        
        
        
        //store customer id into session for use in forms
        $_SESSION['customer_id'] = $_POST['customer_id'];
        //store interaction_id into session for use in forms
        $_SESSION['interaction_id'] = $dbConnection->lastInsertId();
        
        //if form selected, redirect to the appropriate form creation page
        
        //Sample Form
        if($_POST['form'] == 1){
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./sample.php\" />;";
            exit();
        }
        //Light Truckload Quote Form
        else if($_POST['form'] == 2){
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./ltlQuoteForm.php\" />;";
            exit();
        }
        //Truckload Quote Form
        else if($_POST['form'] == 3){
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./tlQuoteForm.php\" />;";
            exit();
        }
        //Distributor Quote Form
        else if($_POST['form'] == 4){
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./distributorQuoteForm.php\" />;";
            exit();
        }
        //Marketing Request Form
        else if($_POST['form'] == 5){
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./newMarketRequest.php\" />;";
            exit();
        }
        else{
            
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ./companyHistory.php\" />;";
            exit();
        }
        
       

    } else {
        
        //Get customers ID's ready for form
        $customerQuery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = ".$_POST['company_id'];
        $customerIds = $dbConnection->query($customerQuery);
        
        //Get companyData ready for form
        $getCompanyDataQuery = "SELECT * FROM nylene.company WHERE company_id = ".$_POST['company_id'];
        $viewCompanyData = $dbConnection->query($getCompanyDataQuery)->fetch(PDO::FETCH_ASSOC);
        
        //Build company address into string
        $companyAddress = $viewCompanyData["billing_address_street"].", ".$viewCompanyData["billing_address_city"].", "
            .$viewCompanyData["billing_address_state"].", ".$viewCompanyData["billing_address_country"].", ".$viewCompanyData["billing_address_postalcode"];
            
    }
} else {
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./Homepage.php\" />;";
    exit();
}
?>

<html>
  <link rel="stylesheet" href="table.css">
<body>
<!-- <h1>Interaction</h1> -->

<form method="post" action=AddInteraction.php name="add_interaction">
<input type="reset" value="Clear">
<table class= "form-table" border = 5>
  <tr>
  		<td>Company:</td><td><?php echo $viewCompanyData['company_name'];?></td>
  		<td>Address:</td><td><?php echo $companyAddress;?></td>
  		<td>Company Email:</td><td><a href="mailto:<?php echo $viewCompanyData['company_email'];?>"><?php echo $viewCompanyData['company_email'];?></a></td>
  </tr>
  <tr>
		<td>Customer:</td><td>
		<select id="selection" required name="customer_id">
		<option></option>
		<?php 
		
		while($id = $customerIds->fetch(PDO::FETCH_ASSOC)){
  $getCustomerData = "SELECT * FROM nylene.customer WHERE customer_id = ".$id["customer_id"];
  $customerData = $dbConnection->query($getCustomerData)->fetch(PDO::FETCH_ASSOC);
  echo "<option value=\"".$customerData['customer_id']."\">" . $customerData['customer_name'] ."</option>";
}
?>
		</select>
		</td>
		<td>Reason:</td>
		<td><select id="selection" required name="reason">
		<option></option>
		<option value="Update">Update</option>
		<option value="General">General</option>
		<option value="Added Customer">Added Customer</option>
		<option value="Status">Status</option>
<!-- 		<option value="Marketing Request">Marketing Request</option> -->
		<option value="Distributor Quote">Distributor Quote</option>
		<option value="Truckload Quote">Truckload Quote</option>
		<option value="Light Truckload Quote">Light Truckload Quote</option>
		<option value="Sample">Sample</option>
		</select>
		</td>
		<td>Form (if applicable):</td>
		<td>
		<select id="selection" required name="form">
		<option value="0"></option>
<!-- 		<option value="5">Marketing Request</option> -->
		<option value="4">Distributor Quote</option>
		<option value="3">Truckload Quote</option>
		<option value="2">Light Truckload Quote</option>
		<option value="1">Sample</option>
		</select>
		</td>		
<tr>
	<td colspan=6><textarea  maxlength="1024" required name="comments" rows="20" cols="100"></textarea></td>
</tr>
</table>
<input hidden name="company_id" value="<?php echo $viewCompanyData['company_id'];?>"/>
<input type="submit" name="submit" value="Submit" >
  </form>
</body>
</html>