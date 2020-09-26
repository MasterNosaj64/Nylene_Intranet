<?php 
session_start();

	include '../navigation.php';
	include '../Database/connect.php';

	//Check the connection
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
		//Selection statement for current employee
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee 
								WHERE employee_id = " . $_SESSION['userid'];
		$userResult = $conn->query($userInformation); 
		$userRow = mysqli_fetch_array($userResult);
		
		//Selection statement for distributor quote form
		$ltlQuery = "SELECT * FROM ltl_quote 
								WHERE tl_quote_id = ". $_POST['id'];
		$ltlResults = $conn->query($ltlQuery);								
		$ltlRow = mysqli_fetch_array($ltlResults);
		
		//Selection statement for customer information
		//tl = ltl_quote_id
		$customerInformation	= "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN ltl_quote ON ltl_quote.tl_quote_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 2 AND interaction_relational_form.form_id = ". $_POST['id'];
		$customerResult = $conn->query($customerInformation); 
		$customerRow = mysqli_fetch_array($customerResult);
		
		$conn->close();
		
		//echo var_dump($customerRow);
	}
?>
<html>
	<head>
		<title>View LTL Quote Form</title>
		<link rel="stylesheet" href="../CSS/form.css">
	</head>
	
	<body>
	<form>
		<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
		<thead>
		<tr>
			<th colspan="4">LTL Quote Form</th>
		</tr></thead>
		<tr>
			<td ><label for="date_created"> Date </label></td>
			<td ><input type="date" name="date_created" readonly value="<?php echo $ltlRow['date_created'];?>"></td>
		</tr>
		<tr>
			<td ><label for="quote_num"> Quote Name/Number </label></td>
			<td ><input type="text" name="quote_num" readonly value="<?php echo $ltlRow['quote_num'];?>"></td>
		</tr>
		<thead>
		<tr>
			<th colspan="2">- Employee Information -</th>
		</tr></thead>
		<tr>		
			<!--Employee first name-->
			<td><label for="first_name"> First Name </label></td>
			<td><input type="text" name="first_name" readonly value="<?php echo $userRow['first_name'];?>"></td>
		</tr>
		<tr>
			<!--Employee last name-->		
			<td><label for="last_name"> Last Name </label></td>
			<td><input type="text" name="last_name" readonly value="<?php echo $userRow['last_name'];?>"></td>
		</tr>
		<tr>
			<!--Employee at Nylene-->
			<td><label for="nyleneCompany"> Nylene Company </label></td>
			<td><input type="text" id="nyleneCompany" readonly value="Nylene"></td>
		</tr>
		<tr>
			<!--Employee work phone number-->
			<td><label for="work_phone"> Nylene Phone </label></td>
			<td><input type="number" name="work_phone" readonly value="<?php echo $userRow['work_phone'];?>"></td>
		</tr>
		<tr>
			<!--Employee Email-->
			<td><label for="employee_email"> Your Email </label></td>
			<td><input type="email" name="employee_email" readonly value="<?php echo $userRow['employee_email'];?>"></td>			
		</tr>
		<tr>
			<!--Employee Title-->
			<td><label for="title"> Your Title </label></td>
			<td><input type="text" name="title" readonly value="<?php echo $userRow['title'];?>"></td>
		</tr>
		<thead>
		<tr>
			<th colspan="2">- Customer Information -</th>
		<tr></thead>
			<!--Customer's Company-->
			<td><label for="company_name"> Customer Company </label></td>
			<td><input type="text" name="company_name" readonly value="<?php echo $customerRow['company_name'];?>"></td>
		</tr>
		<tr>
			<!--Customer Name-->
			<td><label for="customer_name"> Customer Name </label></td>
			<td><input type="text" name="customer_name" readonly value="<?php echo $customerRow['customer_name'];?>"></td>
		</tr>
		<tr>
			<!--Customer Phone-->
			<td><label for="customer_phone"> Customer Phone </label></td>
			<td><input type="text" name="customer_phone" readonly value="<?php echo $customerRow['customer_phone'];?>"></td>
		</tr>
		<tr>	
			<!--Customer Email-->
			<td><label for="customer_email"> Customer Email </label></td>
			<td><input type="email" name="customer_email" readonly value="<?php echo $customerRow['customer_email'];?>"></td>
		</tr>
		<thead>
		<tr>
			<th colspan="2">- Product Information -</th>
		</tr></thead>
		<tr>
			<td><label for="product_name"> Product Name </label></td>
			<td><input type="text" name="product_name" readonly value="<?php echo $ltlRow['product_name'];?>"></td>
		</tr>
		<tr>
			<td><label for="product_desc"> Description </label></td>
			<td><input type="text" name="product_desc" readonly value="<?php echo $ltlRow['product_desc'];?>"></td>
		</tr>
		<tr>
			<td><label for="annual_vol"> Est. Annual Volume </label></td>
			<td><input type="text" name="annual vol" readonly value="<?php echo $ltlRow['annual_vol'];?>"></td>
		</tr>
		<tr>
			<td><label for="OEM"> OEM </label></td>
			<td><input type="text" name="OEM" readonly value="<?php echo $ltlRow['OEM'];?>"></td>
		</tr>
		<tr>
			<td><label for="application"> Application </label></td>
			<td><input type="text" name="application" readonly value="<?php echo $ltlRow['application'];?>"></td>
		</tr>
		<tr>
			<td><label for="truck_load"> TL Price </label></td>
			<td><input type="text" name="truck_load" readonly value="<?php echo $ltlRow['truck_load'];?>"></td>
		</tr>
		<thead>
		<tr>
			<th colspan="2">- Terms -</th>
		</tr></thead>
		<tr>
			<td>Payment terms are USD $ Funds, Net </td>
			<td><input type="text" name="payment_terms" readonly value="<?php echo $ltlRow['payment_terms'];?>"></td>
		</tr>
		<tr>	
			<td>LTL quantities are </td>
			<td><input type="text" name="ltl_quantities" readonly value="<?php echo $ltlRow['ltl_quantities'];?>"></td>
		</tr>
		<tr>
			<td><label for="special_terms"> Special terms and conditions </label></td>
			<td><input type="text" name="special_terms" readonly value="<?php echo $ltlRow['special_terms'];?>"></td>
		</tr>
		<tr>
			<td>1,500 lb. Bx - 2,200 lb. Bags</td>
			<td><input type="text" id="range1522" name="range1522" readonly value="<?php echo $ltlRow['range1522'];?>"></td>
		</tr>
		<tr>
			<td>1,100 - 2,199 lb. bags</td>
			<td><input type="text" id="range1121" name="range1121" readonly value="<?php echo $ltlRow['range1121'];?>"></td>
		</tr>
		<tr>
			<td>550 - 1099 lb. bags</td>
			<td><input type="text" id="range510" name="range510" readonly value="<?php echo $ltlRow['range510'];?>"></td>
		</tr>
		<tr>
			<td>275 - 549 lb. bags</td>
			<td><input type="text" id="range25" name="range25" readonly value="<?php echo $ltlRow['range25'];?>"></td>
		</tr>
		<tr>
			<td>110 - 274 lb. bags</td>
			<td><input type="text" id="range12" name="range12" readonly value="<?php echo $ltlRow['range12'];?>"></td>
		</tr>
		<tr>
			<td>55 lb. bags</td>
			<td><input type="text" id="range5" name="range5" readonly value="<?php echo $ltlRow['range5'];?>"></td>
		</tr>

		</table>
		
	</form>
	</body>
</html>