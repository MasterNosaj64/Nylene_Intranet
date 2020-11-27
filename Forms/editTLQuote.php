<?php 
    /* Name: editTLQuote.php
     * Author: Karandeep Singh
     * Last Modified: November 26th, 2020
     * Purpose: Edits the information from the Truckload form. 
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
                                        INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
                                            WHERE tl_quote_id = " . $_POST['id'];
		$userResult = $conn->query($userInformation); 
		$userRow = mysqli_fetch_array($userResult);
		
		/*Selection statement for form*/
		$tlQuery = "SELECT * FROM tl_quote 
								WHERE tl_quote_id = ". $_POST['id'];
		$tlResults = $conn->query($tlQuery);								
		$tlRow = mysqli_fetch_array($tlResults);
        
          if ($tlRow['range40plus'] != null) {
            $quoteProduced = 1;
        } else {
            $quoteProduced = 0;
        }
		
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
		<title>Edit TL Quote Form</title>
			<link rel="stylesheet" href="../CSS/form.css">
        <script>
		/* This function will update the readonly quote values at the base of the form based on the 
		 * base value (truck_load) if the generateQuote checkbox is checked, otherwise it will keep 
		 * the fields blank */
			function updateQuoteConversion(){

				if (document.getElementById('generateQuote').checked) { 
				    document.getElementById('range40plus').value=
				    	document.getElementById('truck_load').value + '.00/lb'; 
				    document.getElementById('range2240').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.02 + '/lb';
				    document.getElementById('range1022').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.04 + '/lb';
				    document.getElementById('range610').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.06 + '/lb';
				    document.getElementById('range46').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.08 + '/lb';
				    document.getElementById('range24').value=
				    	parseInt(document.getElementById('truck_load').value) + 0.16 + '/lb'; 
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
    	<form method="post" action="editTLQuote_Database.php"   name="editTLQuote">
    		<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
        		<thead><tr>
        			<th colspan="4">TL Quote Form</th>
        		</tr></thead>
        		<tr>
        			 <!--Quote Date -->
        			<td ><label for="quote_date"> Date </label></td>
        			<td ><input type="date" name="quote_date" value="<?php echo $tlRow['quote_date'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote Name/Number -->
        			<td ><label for="quote_num"> Quote Name/Number </label></td>
        			<td ><input type="text" name="quote_num" value="<?php echo $tlRow['quote_num'];?>"></td>
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
        		
        		<thead>
                    <tr>
        			<th colspan="2">- Product Information -</th>
        		</tr></thead>
        		<tr>
        			<!--Product Name-->
        			<td><label for="product_name"> Product Name </label></td>
        			<td><input type="text" name="product_name" value="<?php echo $tlRow['product_name'];?>"></td>
        		</tr>
        		<tr>
        			<!--Product Description-->
        			<td><label for="product_desc"> Description </label></td>
        			<td><input type="text" name="product_desc" value="<?php echo $tlRow['product_desc'];?>"></td>
        		</tr>
        		<tr>
        			<!--Annual Volume-->
        			<td><label for="annual_vol"> Est. Annual Volume </label></td>
        			<td><input type="text" name="annual vol" value="<?php echo $tlRow['annual_vol'];?>"></td>
        		</tr>
        		<tr>
        			<!--OEM-->
        			<td><label for="OEM"> OEM </label></td>
        			<td><input type="text" name="OEM"  value="<?php echo $tlRow['OEM'];?>"></td>
        		</tr>
        		<tr>
                    <!--Application-->
        			<td><label for="application"> Application </label></td>
        			<td><input type="text" name="application" value="<?php echo $tlRow['application'];?>"></td>
        		</tr>
           
    			<?php if ($quoteProduced == 1){ ?>
            		<tr>
            			<!--Truck_load - Base Value-->
            			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
            			<td><input type="number" id=truck_load name="truck_load" onkeyup="valuePresent('generateQuote', this)" value="<?php echo $tlRow['truck_load'];?>"></td>
            		</tr>
            		<tr>
            			<!--Checkbox to Generate Quote -->
            			<td><input type="checkbox" id="generateQuote" name="generateQuote" value="N" onchange="updateQuoteConversion()" checked/>
            			<label for = "generateQuote">Check box to generate quote below</label></td>
            		</tr>
    		<?php } else { ?>
    				<tr>
            			<!--Truck_load - Base Value-->
            			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
            			<td><input type="number" id=truck_load name="truck_load" onkeyup="valuePresent('generateQuote', this)" value="<?php echo $tlRow['truck_load'];?>"></td>
            		</tr>
            		<tr>
            			<!--Checkbox to Generate Quote -->
            			<td><input type="checkbox" id="generateQuote" name="generateQuote" value="N" onchange="updateQuoteConversion()" disabled/>
            			<label for = "generateQuote">Check box to generate quote below</label></td>
            		</tr>
            <?php } ?>
        
        		<thead><tr>
        			<th colspan="2">- Terms -</th>
        		</tr></thead>
        		<tr>
        			<!--Payment Terms-->
        			<td>Payment terms are USD $ Funds, Net </td>
    			<td>
     				<label for="payment_terms">Select/enter payment terms:</label>
     				<input type="text" id="payment_terms" name="payment_terms" list="payment_options" value="<?php echo $tlRow['payment_terms'];?>">
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
        			<td><label for="ltl_quantities">Select/enter quantities:</label>
     				<input type="text" id="ltl_quantities" name="ltl_quantities" list="ltl_options" value="<?php echo $tlRow['ltl_quantities'];?>">
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
        			<td><input type="text" name="special_terms" value="<?php echo $tlRow['special_terms'];?>"></td>
        		</tr>
            <tr>
        			<!--Quote -  40,000+ lb.-->
        			<td>40,000 lb.+</td>
        			<td><input type="text" id ="range40plus" name="range40plus" readonly value="<?php echo $tlRow['range40plus'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 22,000 - 39,999 lb-->	
        			<td>22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box</td>
        			<td><input type="text" id ="range2240" name="range2240" readonly value="<?php echo $tlRow['range2240'];?>" ></td>
        		</tr>
        		<tr>
        			 <!--Quote - 11,000 - 21,999 lb-->
        			<td>11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box</td>
        			<td><input type="text" id ="range1022" name="range1022" readonly value="<?php echo $tlRow['range1022'];?>"></td>
        		</tr>
        		<tr>
        			<!--Quote - 6,600 - 10,999 lb-->
        			<td>6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box</td>
        			<td><input type="text" id ="range610" name="range610" readonly value="<?php echo $tlRow['range610'];?>"></td>
        		</tr>
        		<tr>
        		    <!--Quote - 4,400 - 6,599 lb.-->
        			<td>4,400 - 6,599 lb. bags, 3,000 - 5,999 lb. box</td>
        			<td><input type="text" id ="range46" name="range46" readonly value="<?php echo $tlRow['range46'];?>"></td>
        		</tr>
        		<tr>
        			 <!--Quote - 2,200 - 4,399 lb.-->
        			<td>2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box</td>
        			<td><input type="text" id ="range24" name="range24" readonly value="<?php echo $tlRow['range24'];?>"></td>
        		</tr>
            <tr>
    			<td colspan="1"> <input type="submit" value="submit" style="width:100%"> </td>
    			<td colspan="1"> <input type="reset" value= "reset" style="width:100%"><input hidden type="number" id="tl_quote_id" name="tl_quote_id" value="<?php echo $tlRow['tl_quote_id'];?>"/> </td>
    		</tr>
            </table>
        </form>
    </body>
</html>

        		