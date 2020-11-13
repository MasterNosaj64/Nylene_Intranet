<?php 
    /* Name: ltlQuoteForm.php
     * Author: Kaitlyn Breker
     * Last Modified: November 5th, 2020
     * Purpose: Input for distributor quote. User information, company and customer information is
     *          automatically displayed from database. Contains two functions to help automate the
     *          quote calculation and display in the form.
     */
    session_start();
    include '../NavPanel/navigation.php';	
	include '../Database/connect.php';

	$conn = getDBConnection();
	
	/*Check the connection*/
	if ($conn-> connect_error) {
	
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
		
	    /*Selection statement for current employee*/
		$userInformation = "SELECT first_name, last_name, title, work_phone, employee_email FROM employee 
								WHERE employee_id = " . $_SESSION['userid'];
		$result = $conn->query($userInformation); 
		$row = mysqli_fetch_array($result);
		
		/*Selection statement for custemor passed from interaction*/
		$customerSelect = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['customer_id'];
		$customerInfo = $conn->query($customerSelect);
		$customerRow = mysqli_fetch_array($customerInfo);

		/*Selection statement for company passed from interaction*/
		$companySelect = "SELECT * FROM company WHERE company_id = " . $_SESSION['company_id'];
		$companyInfo = $conn->query($companySelect);
		$companyRow = mysqli_fetch_array($companyInfo);
		
		$conn->close();
	}
?>
<html>
	<head>
		<title>LTL Quote Form</title>
		<link rel="stylesheet" type="text/css" href="../CSS/form.css">
		
		<script>
		/* This function will update the readonly quote values at the base of the form based on the 
		 * base value (truck_load) if the generateQuote checkbox is checked, otherwise it will keep 
		 * the fields blank */
			function updateQuoteConversion(){

				if (document.getElementById('generateQuote').checked) { 
				    document.getElementById('range1522').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.16 + '/lb'; 
				    document.getElementById('range1121').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.31 + '/lb'; 
				    document.getElementById('range510').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.62 + '/lb';
				    document.getElementById('range25').value=
					    parseInt(document.getElementById('truck_load').value) + 1.31 + '/lb';
				    document.getElementById('range12').value=
				    	parseInt(document.getElementById('truck_load').value) + 2.22 + '/lb'; 
				    document.getElementById('range5').value=
				    	parseInt(document.getElementById('truck_load').value) + 3.66 + '/lb';
				  } else { 
					  document.getElementById('range1522').value=""; 
					  document.getElementById('range1121').value=""; 
					  document.getElementById('range510').value="";
					  document.getElementById('range25').value="";
					  document.getElementById('range12').value="";
					  document.getElementById('range5').value="";
				  } 
			}

			/* This function will enable or disable the generateQuote checkbox depending on if a number has 
			 * been typed in the truck_load field*/
			function valuePresent(generate, exists){
			    if (exists.value.length > 0){
			        document.getElementById(generate).disabled=false;
			    } else {
			        document.getElementById(generate).disabled=true;
			    }
			}
		</script>
	</head>
	
	<body>
	<form name="ltlQuoteForm" action="newLtlQuote.php" method="post" >
		<table class = "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
    		<thead><tr>
    			<th colspan="4">LTL Quote Form</th>
    		</tr></thead>
    		<tr>
    			 <!--Quote Date - Mandatory-->
    			<td ><label for="quote_date"> Date* </label></td>
    			<td ><input type="date" id="quote_date" name="quote_date" required></td>
    		</tr>
    		<tr>
    			<!--Quote Name/Number - Mandatory-->
    			<td ><label for="quote_num"> Quote Name/Number* </label></td>
    			<td ><input type="text" id="quote_num" name="quote_num" required></td>
    		</tr>
    		
    		<thead><tr>
    			<th colspan="2">- Employee Information -</th>
    		</tr></thead>
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
    			<td><input type="number" id="work_phone" name="work_phone" readonly value="<?php echo $row['work_phone'];?>"></td>
    		</tr>
    		<tr>
    			<!--Employee Email-->
    			<td><label for="employee_email"> Your Email </label></td>
    			<td><input type="email" id="employee_email" name="employee_email" readonly value="<?php echo $row['employee_email'];?>"></td>			
    		</tr>
    		<tr>
    			<!--Employee Title-->
    			<td><label for="title"> Your Title </label></td>
    			<td><input type="text" id="title" name="title" readonly value="<?php echo $row['title'];?>"></td>
    		</tr>
    		
    		<thead><tr>
    			<th colspan="2">- Customer Information -</th>
    		<tr></thead>
    			<!--Customer's Company-->
    			<td><label for="company_name"> Customer Company </label></td>
    			<td><input type="text" readonly value="<?php echo $companyRow['company_name'];?>"></td>
    		</tr>
    		<tr>
    			<!--Customer Name-->
    			<td><label for="customer_name"> Customer Name </label></td>
    			<td><input type="text" readonly value="<?php echo $customerRow['customer_name'];?>"></td>
    		</tr>
    		<tr>
    			<!--Customer Phone-->
    			<td><label for="customer_phone"> Customer Phone </label></td>
    			<td><input type="text" readonly value="<?php echo $customerRow['customer_phone'];?>"></td>
    		</tr>
    		<tr>	
    			<!--Customer Email-->
    			<td><label for="customer_email"> Customer Email </label></td>
    			<td><input type="text" readonly value="<?php echo $customerRow['customer_email'];?>"></td>
    		</tr>
    		
    		<thead><tr>
    			<th colspan="2">- Product Information -</th>
    		</tr>
    		</thead>
    		<tr>
    			<!--Product Name - Mandatory-->
    			<td><label for="product_name"> Product Name* </label></td>
    			<td><input type="text" id="product_name" name="product_name" required></td>
    		</tr></thead>
    		<tr>
    			<!--Product Description-->
    			<td><label for="product_desc"> Description </label></td>
    			<td><input type="text" id="product_desc" name="product_desc"></td>
    		</tr>
    		<tr>
    			<!--Annual Volume-->
    			<td><label for="annual_vol"> Est. Annual Volume </label></td>
    			<td><input type="number" id="annual_vol" name="annual_vol"></td>
    		</tr>
    		<tr>
    			<!--OEM-->
    			<td><label for="OEM"> OEM </label></td>
    			<td><input type="text" id="OEM" name="OEM"></td>
    		</tr>
    		<tr>
    			<!--Application-->
    			<td><label for="application"> Application </label></td>
    			<td><input type="text" id="application" name="application"></td>
    		</tr>
    		<tr>
    			<!--Truck_load - Base Value-->
    			<td><label for="truck_load"> TL Price </label></td>
    			<td><input type="number" id="truck_load" name="truck_load" onkeyup="valuePresent('generateQuote', this)"></td>
    		</tr>
    		<tr>
    			<!--Checkbox to Generate Quote -->
    			<td><input type="checkbox" id="generateQuote" name="generateQuote" value="N" onchange="updateQuoteConversion()" disabled/>
    			<label for = "generateQuote">Check box to generate quote below</label></td>
    		</tr>
    		
    		<thead><tr>
    			<th colspan="2">- Terms -</th>
    		</tr></thead>
    		<tr>
    			<!--Payment Terms-->
    			<td>Payment terms are USD $ Funds, Net:</td>
    			<td><select id="payment_terms" name="payment_terms">
    					<option></option>
    					<option value="30 days">30 days</option>
    					<option value="40 days">45 days</option>
    					<option value="60 days">60 days</option>
    					<option value="90 days">90 days</option>
    					<option value="1%/10, Net 30 days">1%/10, Net 30 days</option>
    					<option value="Other">Other</option>
    				</select>
    			</td>
    		</tr>
    		<tr>
    			<!--LTL Quantities-->
    			<td>LTL quantities are </td>
    			<td><select id="ltl_quantities" name="ltl_quantities">
    					<option></option>
    					<option value="FOB Shipping Point, customer pick-up">FOB Shipping Point, customer pick-up</option>
    					<option value="Ex-Works">Ex-Works</option>
    					<option value="Other">Other</option>
    				</select>
    			</td>
    		</tr>
    		<tr>
    			<!--Special Terms-->
    			<td><label for="special_terms"> Special terms and conditions </label></td>
    			<td><input type="text" id="special_terms" name="special_terms" value=" N/A"></td>
    		</tr>
    		<tr>
    			<!--Quote - 1,500 lb. Bx, 2,200 lb. Bags-->
    			<td>1,500 lb. Bx, 2,200 lb. Bags</td>
    			<td><input type="text" id="range1522" name="range1522" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 1,100 - 2,199 lb. bags-->
    			<td>1,100 - 2,199 lb. bags</td>
    			<td><input type="text" id="range1121" name="range1121" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 550 - 1099 lb. bags-->
    			<td>550 - 1099 lb. bags</td>
    			<td><input type="text" id="range510" name="range510" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 275 - 549 lb. bags-->
    			<td>275 - 549 lb. bags</td>
    			<td><input type="text" id="range25" name="range25" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 110 - 274 lb. bags-->
    			<td>110 - 274 lb. bags</td>
    			<td><input type="text" id="range12" name="range12" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 55 lb. bags-->
    			<td>55 lb. bags</td>
    			<td><input type="text" id="range5" name="range5" readonly></td>
    		</tr>
    		<tr>
    			<td colspan="1"> <input type="Submit" style="width:100%" value="submit"> </td>
    			<td colspan="1"> <input type="reset" value= "reset" style="width:100%"> </td>
    		</tr>
		</table>
		
	</form>
	</body>
</html>