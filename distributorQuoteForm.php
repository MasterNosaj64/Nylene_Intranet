<?php 
session_start();

// 	$_SESSION['customer_id'] = '1';
// 	$_SESSION['company_id'] = '1';

	include 'db_config.php';

	//Check the connection
	if ($dbConnection-> connect_error) {
	
		die("Connection failed: " . $dbConnection-> connect_error);
	
	} else {
		
		//Selection statement for current employee
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee 
								WHERE employee_id = " . $_SESSION['userid'];
		$result = $dbConnection->query($userInformation); 
		$row = mysqli_fetch_array($result);
		
		$customerSelect = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['customer_id'];
		$customerInfo = $dbConnection->query($customerSelect);
		$customerRow = mysqli_fetch_array($customerInfo);

		$companySelect = "SELECT * FROM company WHERE company_id = " . $_SESSION['company_id'];
		$companyInfo = $dbConnection->query($companySelect);
		$companyRow = mysqli_fetch_array($companyInfo);
		
		$dbConnection->close();
	}
?>
<html>
	<head>
		<title>Distributor Quote Form</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	
	<body>
	
	<form name="distributorQuoteForm" action="newDistributorQuote.php" method="post" >
		<table border="1" cellspacing="0" cellpadding="1" align="center">
		<tr>
			<th colspan="4">Distributor Quote Form</th>
		</tr>
		<tr>
			<td ><label for="date_created"> Date </label></td>
			<td ><input type="date" id="date_created" name="date_created" required></td>
		</tr>
		<tr>
			<td ><label for="quote_num"> Quote Name/Number </label></td>
			<td ><input type="text" id="quote_num" name="quote_num" required></td>
		</tr>
		
		
		<tr>
			<th colspan="2">- Employee Information -</th>
		</tr>
		<tr>		
			<!--Employee first name-->
			<td><label for="first_name"> First Name </label></td>
			<td><input type="text" id="first_name" name="first_name" readonly value="<?php echo $row['first_name'];?>"></td>
		</tr>
		<tr>
			<!--Employee last name-->		
			<td><label for="last_name"> Last Name </label></td>
			<td><input type="text" id="last_name" name="last_name" readonly value="<?php echo $row['last_name'];?>"></td>
		</tr>
		<tr>
			<!--Employee at Nylene-->
			<td><label for="nyleneCompany"> Nylene Company </label></td>
			<td><input type="text" id="nyleneCompany" readonly value="Nylene"></td>
		</tr>
		<tr>
			<!--Employee work phone number-->
			<td><label for="work_phone"> Nylene Phone </label></td>
			<td><input type="number" id="work_phone" readonly value="<?php echo $row['work_phone'];?>"></td>
		</tr>
		<tr>
			<!--Employee Email-->
			<td><label for="employee_email"> Your Email </label></td>
			<td><input type="email" id="employee_email" readonly value="<?php echo $row['employee_email'];?>"></td>			
		</tr>
		<tr>
			<!--Employee Title-->
			<td><label for="title"> Your Title </label></td>
			<td><input type="text" id="title" readonly value="<?php echo $row['title'];?>"></td>
		</tr>
		
		<tr>
			<th colspan="2" id="info">- Customer Information -</th>
		</tr>
		<tr>
			<!--Customer's Company-->
			<td><label> Customer Company </label></td>
			<td ><input type="text" readonly value="<?php echo $companyRow['company_name'];?>"></td> 
		</tr>
		<tr>
			<!--Customer Name-->
			<td ><label> Customer Name </label></td>
			<td ><input type="text" readonly value="<?php echo $customerRow['customer_name'];?>"></td>
		</tr>
		
		<tr>
			<!--Customer Phone-->
			<td ><label> Customer Phone </label></td>
			<td ><input type="text" readonly value="<?php echo $customerRow['customer_phone'];?>"></td>
		</tr>
		<tr>	
			<!--Customer Email-->
			<td id="info"><label> Customer Email </label></td>
			<td ><input type="text" readonly value="<?php echo $customerRow['customer_email'];?>"></td>
		</tr>
		<tr>
			<th colspan="2">- Product Information -</th>
		</tr>
		<tr>
			<td><label for="product_name"> Product Name </label></td>
			<td><input type="text" id="product_name" name="product_name" required></td>
		</tr>
		<tr>
			<td><label for="product_desc"> Description </label></td>
			<td><input type="text" id="product_desc" name="product_desc"></td>
		</tr>
		<tr>
			<td><label for="annual_vol"> Est. Annual Volume </label></td>
			<td><input type="number" id="annual_vol" name="annual_vol"></td>
		</tr>
		<tr>
			<td><label for="OEM"> OEM </label></td>
			<td><input type="text" id="OEM" name="OEM"></td>
		</tr>
		<tr>
			<td><label for="application"> Application </label></td>
			<td><input type="text" id="application" name="application"></td>
		</tr>
		<tr>
			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
			<td><input type="text" id="truck_load" name="truck_load"></td>
		</tr>
		
		
		<tr>
			<th colspan="2">- Terms -</th>
		</tr>
		<tr>
			<td> Payment terms are USD $ Funds, Net </td>
			<td><select id="payment_terms" name="payment_terms">
					<option></option>
					<option value="30 days">30 days</option>
					<option value="45 days">45 days</option>
					<option value="60 days">60 days</option>
					<option value="90 days">90 days</option>
					<option value="1%/10, Net 30 days">1%/10, Net 30 days</option>
					<option value="Other">Other</option>
				</select>
			</td>
		</tr>
		<tr>	
			<td> LTL quantities are </td>
			<td><select id="ltl_quantities" name="ltl_quantities">
					<option></option>
					<option value="FOB Shipping Point, freight prepaid">FOB Shipping Point, freight prepaid</option>
					<option value="FOB Shipping Point, customer pick-up">FOB Shipping Point, customer pick-up</option>
					<option value="Ex-Works">Ex-Works</option>
					<option value="Other">Other</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label for="special_terms"> Special terms and conditions </label></td>
			<td><input type="text" id="special_terms" name="special_terms" value=" N/A"></td>
		</tr>

		<tr>
			<td> 22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box </td>
			<td><input type="text" id="range2240" name="range2240"></td>
		</tr>
		<tr>
			<td> 11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box </td>
			<td><input type="text" id="range1122" name="range1122"></td>
		</tr>
		<tr>
			<td> 6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box </td>
			<td><input type="text" id="range610" name="range610"></td>
		</tr>
		<tr>
			<td> 2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box </td>
			<td><input type="text" id="range24" name="range24"></td>
		</tr>

		<tr>
			<td colspan="2"> <input type="submit" value="submit" style="width:100%"> </td>
		</tr>
		</table>
		
	</form>
	</body>
</html>