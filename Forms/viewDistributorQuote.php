<?php 
    /* Name: viewDistributorQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: November 12th, 2020
     * Purpose: Displays the information from the Distributor Quote form
     */

    session_start();
    include '../NavPanel/navigation.php';
	include '../Database/connect.php';

	$conn = getDBConnection();
	
	/*Check the connection*/
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
	    /*Selection statement for employee that created the form*/
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee
                                INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                                    INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                        INNER JOIN distributor_quote_form ON distributor_quote_form.distributor_quote_id = interaction_relational_form.form_id
                                            WHERE distributor_quote_id = " . $_POST['id'];
		$userResult = $conn->query($userInformation); 
		$userRow = mysqli_fetch_array($userResult);
		
		/*Selection statement for form*/
		$distributorQuery = "SELECT * FROM distributor_quote_form 
								WHERE distributor_quote_id = ". $_POST['id'];
		$distributorResults = $conn->query($distributorQuery);								
		$distRow = mysqli_fetch_array($distributorResults);
		
		/*Selection statement for customer passed from interaction*/
		$customerInformation	= "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN distributor_quote_form ON distributor_quote_form.distributor_quote_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 4 AND interaction_relational_form.form_id = ". $_POST['id'];
		$customerResult = $conn->query($customerInformation); 
		$customerRow = mysqli_fetch_array($customerResult);
		
		$conn->close();
	}
?>
<html>
	<head>
		<title> View Distributor Quote Form</title>
			<link rel="stylesheet" href="../CSS/form.css">
	</head>
	
	<body>
    	<form>
        	<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">Distributor Quote Form</th>
        		</tr></thead>
        		<tr>
        			 <!--Date Created -->
        			<td ><label for="date_created"> Date </label></td>
        			<td ><input type="text" name="date_created" readonly value="<?php echo $distRow['date_created'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote Name/Number -->
        			<td ><label for="quote_num"> Quote Name/Number </label></td>
        			<td ><input type="text" name="quote_num" readonly value="<?php echo $distRow['quote_num'];?>"></td>
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
        			<th colspan="2" id="info">- Customer Information -</th>
        		</tr></thead>
        		<tr>
        			<!--Customer's Company-->
        			<td id="info"><label> Customer Company </label></td>
        			<td ><input type="text" name="company_name" readonly value="<?php echo $customerRow['company_name'];?>"></td> 
        		</tr>
        		<tr>
        			<!--Customer Name-->
        			<td id="info"><label> Customer Name </label></td>
        			<td ><input type="text" name="customer_name" readonly value="<?php echo $customerRow['customer_name'];?>"></td>
        		</tr>
        		<tr>
        			<!--Customer Phone-->
        			<td id="info"><label> Customer Phone </label></td>
        			<td><input type="text" name="customer_phone" readonly value="<?php echo $customerRow['customer_phone'];?>"></td>
        		</tr>
        		<tr>	
        			<!--Customer Email-->
        			<td id="info"><label> Customer Email </label></td>
        			<td><input type="email" name="customer_email" readonly value="<?php echo $customerRow['customer_email'];?>"></td>
        		</tr>
        		
        		<thead><tr>
        			<th colspan="2">- Product Information -</th>
        		</tr></thead>
        		<tr>
        			<!--Product Name-->
        			<td><label for="product_name"> Product Name </label></td>
        			<td><input type="text" name="product_name" readonly value="<?php echo $distRow['product_name'];?>"></td>
        		</tr>
        		<tr>
        			<!--Product Description-->
        			<td><label for="product_desc"> Description </label></td>
        			<td><input type="text" name="product_desc" readonly value="<?php echo $distRow['product_desc'];?>"></td>
        		</tr>
        		<tr>
        			<!--Annual Volume-->
        			<td><label for="annual_vol"> Est. Annual Volume </label></td>
        			<td><input type="text" name="annual vol" readonly value="<?php echo $distRow['annual_vol'];?>"></td>
        		</tr>
        		<tr>
        			<!--OEM-->
        			<td><label for="OEM"> OEM </label></td>
        			<td><input type="text" name="OEM" readonly value="<?php echo $distRow['OEM'];?>"></td>
        		</tr>
        		<tr>
        			<!--Application-->
        			<td><label for="application"> Application </label></td>
        			<td><input type="text" name="application" readonly value="<?php echo $distRow['application'];?>"></td>
        		</tr>
        		<tr>
        			<!--Truck_load - Base Value-->
        			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
        			<td><input type="number" name="truck_load" readonly value="<?php echo $distRow['truck_load'];?>"></td>
        		</tr>
        		
        		<thead><tr>
        			<th colspan="2">- Terms -</th>
        		</tr></thead>
        		<tr>
        			<!--Payment Terms-->
        			<td> Payment terms are USD $ Funds, Net </td>
        			<td><input type="text" name="payment_terms" readonly value="<?php echo $distRow['payment_terms'];?>"></td>
        		</tr>
        		<tr>
        			<!--LTL Quantities-->	
        			<td> LTL quantities are </td>
        			<td><input type="text" name="ltl_quantities" readonly value="<?php echo $distRow['ltl_quantities'];?>"></td>
        		</tr>
        		<tr>
        			<!--Special Terms-->
        			<td><label for="special_terms"> Special terms and conditions </label></td>
        			<td><input type="text" name="special_terms" readonly value="<?php echo $distRow['special_terms'];?>"></td>
        		</tr>
        
        		<tr>
        			<!--Quote -  40,000+ lb.-->
        			<td> 40,000 lb. + </td>
        			<td><input type="text" name="range40up" readonly value="<?php echo $distRow['range40up'];?>"></td>
        		</tr>
        		<tr>
        		 <!--Quote - 22,000 - 39,999 lb-->	
        			<td> 22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box </td>
        			<td><input type="text" name="range2240" readonly value="<?php echo $distRow['range2240'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 11,000 - 21,999 lb-->
        			<td> 11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box </td>
        			<td><input type="text" name="range1122" readonly value="<?php echo $distRow['range1122'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote - 6,600 - 10,999 lb-->
        			<td> 6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box </td>
        			<td><input type="text" name="range610"  readonly value="<?php echo $distRow['range610'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 2,200 - 4,399 lb.-->
        			<td> 2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box </td>
        			<td><input type="text" name="range24" readonly value="<?php echo $distRow['range24'];?>"></td>
        		</tr>
    		</table>
    	</form>
	</body>
</html>