<?php 
    /* Name: tlQuoteForm.php
     * Author: Kaitlyn Breker
     * Last Modified: December 1st, 2020
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
		
		/*Selection statement for customer passed from interaction*/
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
		<title>TL Quote Form</title>
		<link rel="stylesheet" href="../CSS/form.css">
		
		<script>
		/* This function will update the readonly quote values at the base of the form based on the 
		 * base value (truck_load) if the generateQuote checkbox is checked, otherwise it will keep 
		 * the fields blank */
			function updateQuoteConversion(){

			 var val40p = parseInt(document.getElementById('truck_load').value); 
			 var val2240 = parseInt(document.getElementById('truck_load').value) + 0.02;
			 var val1022 = parseInt(document.getElementById('truck_load').value) + 0.04;
			 var val610 = parseInt(document.getElementById('truck_load').value) + 0.06;
			 var val46  = parseInt(document.getElementById('truck_load').value) + 0.08;
			 var val24 = parseInt(document.getElementById('truck_load').value) + 0.16;
			 
				if (document.getElementById('generateQuote').checked) { 
					document.getElementById('range40plus').value = val40p.toFixed(2).toString() + "/lb"; 
				    document.getElementById('range2240').value = val2240.toFixed(2).toString() + "/lb"; 
				    document.getElementById('range1022').value = val1022.toFixed(2).toString() + "/lb";
				    document.getElementById('range610').value = val610.toFixed(2).toString() + "/lb";
				    document.getElementById('range46').value = val46.toFixed(2).toString() + "/lb"; 
				    document.getElementById('range24').value = val24.toFixed(2).toString() + "/lb";
				  } else { 
					  document.getElementById('range40plus').value=""; 
					  document.getElementById('range2240').value=""; 
					  document.getElementById('range1022').value="";
					  document.getElementById('range610').value="";
					  document.getElementById('range46').value="";
					  document.getElementById('range24').value="";
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
	<form name="TlQuoteForm" action="newTlQuote.php" method="post" autocomplete="off">
		<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center" >
    		<thead><tr>
    			<th colspan="4">TL Quote Form</th>
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
    		
    		<thead><tr>
    			<th colspan="2">- Customer Information -</th>
    		</tr></thead>
    		<tr>
    			<!--Customer's Company-->
    			<td><label for="compnay_name"> Customer Company </label></td>
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
    		</tr></thead>
    		<tr>
    			<!--Product Name - Mandatory-->
    			<td><label for="product_name"> Product Name* </label></td>
    			<td><input type="text" id="product_name" name="product_name" required></td>
    		</tr>
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
    			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
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
    			<td>Payment terms are USD $ Funds, Net </td>
    			<td>
     				<label for="payment_terms">Select/enter payment terms:</label>
     				<input type="text" id="payment_terms" name="payment_terms" list="payment_options"/>
     				<datalist id="payment_options">
     					<option value="30 days">
     					<option value="45 days">
        				<option value="60 days">
        				<option value="90 days">
        				<option value="1%/10, Net 30 days">
     				</datalist>
    			</td>
    		</tr>
    
    		<tr>	
    			<!--LTL Quantities-->
    			<td>LTL quantities are </td>
    			<td>
    				<label for="ltl_quantities">Select/enter quantities:</label>
     				<input type="text" id="ltl_quantities" name="ltl_quantities" list="ltl_options"></input>
     				<datalist id="ltl_options">
     					<option value="FOB Shipping Point, freight prepaid">
     					<option value="FOB Shipping Point, customer pick-up">
        				<option value="Ex-Works">
     				</datalist>
    			</td>
    		</tr>
    		<tr>
    			<!--Special Terms-->
    			<td><label for="special_terms"> Special terms and conditions </label></td>
    			<td><input type="text" id="special_terms" name="special_terms" value=" N/A"></td>
    		</tr>
    
    		<tr>
    			<!--Quote -  40,000+ lb.-->
    			<td>40,000 lb.+</td>
    			<td><input type="text" id="range40plus" name="range40plus" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 22,000 - 39,999 lb-->
    			<td>22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box</td>
    			<td><input type="text" id="range2240" name="range2240" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 11,000 - 21,999 lb-->
    			<td>11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box</td>
    			<td><input type="text" id="range1022" name="range1022" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 6,600 - 10,999 lb-->
    			<td>6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box</td>
    			<td><input type="text" id="range610" name="range610" readonly></td>
    		</tr>
    		<tr>
    		    <!--Quote - 4,400 - 6,599 lb.-->
    			<td>4,400 - 6,599 lb. bags, 3,000 - 5,999 lb. box</td>
    			<td><input type="text" id="range46" name="range46" readonly></td>
    		</tr>
    		<tr>
    			<!--Quote - 2,200 - 4,399 lb.-->
    			<td>2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box</td>
    			<td><input type="text" id="range24" name="range24" readonly></td>
    		</tr>
    		<tr>
    			<td colspan="1"> <input type="submit" value="submit" style="width:100%"> </td>
    			<td colspan="1"> <input type="reset" value= "reset" style="width:100%"> </td>
    		</tr>
		</table>
		
	</form>
	</body>
</html>

