<?php 
    /* Name: viewTLQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: October 11th, 2020
     * Purpose: Displays the information from the Truckload form. 
     */
    
    session_start();

	include '../NavPanel/navigation.php';
	include '../Database/connect.php';

	//TODO: KAITLYN call getDBConnection to get connection
	//$conn = getDBConnection();
	
	/*Check the connection*/
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
	    /*Selection statement for current employee*/
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee 
								WHERE employee_id = " . $_SESSION['userid'];
		$userResult = $conn->query($userInformation); 
		$userRow = mysqli_fetch_array($userResult);
		
		/*Selection statement for form*/
		$tlQuery = "SELECT * FROM tl_quote 
								WHERE tl_quote_id = ". $_POST['id'];
		$tlResults = $conn->query($tlQuery);								
		$tlRow = mysqli_fetch_array($tlResults);
		
		/*Selection statement for customer passed from interaction*/
		$customerInformation	= "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 3 AND interaction_relational_form.form_id =". $_POST['id'];
		
		$customerResult = $conn->query($customerInformation); 
		$customerRow = mysqli_fetch_array($customerResult);
		
		$conn->close();
	}
?>
<html>
	<head>
		<title>View TL Quote Form</title>
			<link rel="stylesheet" href="../CSS/form.css">
	</head>
	<body>
    	<form>
    		<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">TL Quote Form</th>
        		</tr></thead>
        		<tr>
        			 <!--Date Created -->
        			<td ><label for="date_created"> Date </label></td>
        			<td ><input type="date" name="date_created" readonly value="<?php echo $tlRow['date_created'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote Name/Number -->
        			<td ><label for="quote_num"> Quote Name/Number </label></td>
        			<td ><input type="text" name="quote_num" readonly value="<?php echo $tlRow['quote_num'];?>"></td>
        		</tr>
        		
        		<thead><tr>
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
        		
        		<thead><tr>
        			<th colspan="2">- Customer Information -</th>
        		<tr></thead>
        			<!--Customer's Company-->
        			<td><label for="company_name"> Customer Company </label></td>
        			<td ><input type="text" name="company_name" readonly value="<?php echo $customerRow['company_name'];?>"></td> 
        		</tr>
        		<tr>
        			<!--Customer Name-->
        			<td><label for="customer_name"> Customer Name </label></td>
        			<td ><input type="text" name="customer_name" readonly value="<?php echo $customerRow['customer_name'];?>"></td>
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
        		
        		<thead><tr>
        			<th colspan="2">- Product Information -</th>
        		</tr></thead>
        		<tr>
        			<!--Product Name-->
        			<td><label for="product_name"> Product Name </label></td>
        			<td><input type="text" name="product_name" readonly value="<?php echo $tlRow['product_name'];?>"></td>
        		</tr>
        		<tr>
        			<!--Product Description-->
        			<td><label for="product_desc"> Description </label></td>
        			<td><input type="text" name="product_desc" readonly value="<?php echo $tlRow['product_desc'];?>"></td>
        		</tr>
        		<tr>
        			<!--Annual Volume-->
        			<td><label for="annual_vol"> Est. Annual Volume </label></td>
        			<td><input type="text" name="annual vol" readonly value="<?php echo $tlRow['annual_vol'];?>"></td>
        		</tr>
        		<tr>
        			<!--OEM-->
        			<td><label for="OEM"> OEM </label></td>
        			<td><input type="text" name="OEM" readonly value="<?php echo $tlRow['OEM'];?>"></td>
        		</tr>
        		<tr>
        			<!--Application-->
        			<td><label for="application"> Application </label></td>
        			<td><input type="text" name="application" readonly value="<?php echo $tlRow['application'];?>"></td>
        		</tr>
        		<tr>
        			<!--Truck_load - Base Value-->
        			<td><label for="truck_load"> TL Price </label></td>
        			<td><input type="number" name="truck_load" readonly value="<?php echo $tlRow['truck_load'];?>"></td>
        		</tr>
        		
        		<thead><tr>
        			<th colspan="2">- Terms -</th>
        		</tr></thead>
        		<tr>
        			<!--Payment Terms-->
        			<td>Payment terms are USD $ Funds, Net </td>
        			<td><input type="text" name="payment_terms" readonly value="<?php echo $tlRow['payment_terms'];?>"></td>
        		</tr>
        		<tr>
        			<!--LTL Quantities-->	
        			<td>LTL quantities are </td>
        			<td><input type="text" name="ltl_quantities" readonly value="<?php echo $tlRow['ltl_quantities'];?>"></td>
        		</tr>
        		<tr>
        			<!--Special Terms-->
        			<td><label for="special_terms"> Special terms and conditions </label></td>
        			<td><input type="text" name="special_terms" readonly value="<?php echo $tlRow['special_terms'];?>"></td>
        		</tr>
        		
        		<tr>
        			<!--Quote -  40,000+ lb.-->
        			<td>40,000 lb.+</td>
        			<td><input type="text" name="range40plus" readonly value="<?php echo $tlRow['range40plus'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 22,000 - 39,999 lb-->	
        			<td>22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box</td>
        			<td><input type="text" name="range2240" readonly value="<?php echo $tlRow['range2240'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 11,000 - 21,999 lb-->
        			<td>11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box</td>
        			<td><input type="text" name="range1022" readonly value="<?php echo $tlRow['range1022'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote - 6,600 - 10,999 lb-->
        			<td>6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box</td>
        			<td><input type="text" name="range610" readonly value="<?php echo $tlRow['range610'];?>"></td>
        		</tr>
        		<tr>
        		    <!--Quote - 4,400 - 6,599 lb.-->
        			<td>4,400 - 6,599 lb. bags, 3,000 - 5,999 lb. box</td>
        			<td><input type="text" name="range46" readonly value="<?php echo $tlRow['range46'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 2,200 - 4,399 lb.-->
        			<td>2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box</td>
        			<td><input type="text" name="range24" readonly value="<?php echo $tlRow['range24'];?>"></td>
        		</tr>
    		</table>
    	</form>
	</body>
</html>