<?php
//session_start();
//include 'menu.php';
include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();
   

if(isset($_POST['submit'])){
    
    $sqlQuery = "UPDATE nylene.customer 
                SET 
                customer_name = '". $_POST['firstName'] ." ". $_POST['lastName'] . "',
                customer_email = '". $_POST['email'] ."', 
                customer_phone = '". $_POST['phone'] ."'
                WHERE customer_id =".$_POST['customer_id'];
   
    $result = $dbConnection->query($sqlQuery);
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php\" />;";
    exit();	
}

if ($_SESSION['company_id'] != "" && isset($_POST['customer_id'])) {
    
  
    $sqlGetCustomerInfo = "SELECT * FROM nylene.customer WHERE customer_id = ".$_POST['customer_id'];
    $customerInfo = $dbConnection->query($sqlGetCustomerInfo)->fetch(PDO::FETCH_ASSOC);
    
    $name = explode(" ", $customerInfo['customer_name']);
}
else {
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php\" />;";
    exit();
}
?>



<body>
<form method="post" action=editCustomer.php name="edit_customer">
<input type="reset" value="Clear">
<input hidden name="customer_id" value="<?php echo $customerInfo['customer_id'];?>"/>
	<table border=5>
		<tr>
		<td colspan=4><h2>Customer</h2></td>
		</tr>
		<tr>
			<td>*First Name:</td>
			<td><input type="text" value="<?php echo $name[0];?>" required name="firstName"></td>
			<td>*Last Name:</td>
			<td><input type="text" value="<?php echo $name[1];?>" required name="lastName" ></td>
		</tr>
		<tr>
			<td>*Email:</td>
			<td><input type="email" value="<?php echo $customerInfo['customer_email'];?>" required  name="email"></td>
			<td>Phone:</td>
			<td><input type="tel" value="<?php echo $customerInfo['customer_phone'];?>" name="phone"></td>
		</tr>
		
	</table>
	<input type="submit" name="submit" value="Submit" >
</form>
</body>