<?php
    
    /* Name: editDistributorQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: November 24th, 2020
     * Purpose: Edit a specific distributor form
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
        
        if ($distRow['range40up'] != null) {
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
    													INNER JOIN distributor_quote_form ON distributor_quote_form.distributor_quote_id = interaction_relational_form.form_id
    														WHERE interaction_relational_form.form_type = 4 AND interaction_relational_form.form_id = ". $_POST['id'];
        $customerResult = $conn->query($customerInformation);
        $customerRow = mysqli_fetch_array($customerResult);
        
        $conn->close();
    }
?>
    <html>
    	<head>
    		<title> Edit Distributor Quote Form</title>
    			<link rel="stylesheet" href="../CSS/form.css">
    			<script>
        		/* This function will update the readonly quote values at the base of the form based on the 
        		 * base value (truck_load) if the generateQuote checkbox is checked, otherwise it will keep 
        		 * the fields blank */
        			function updateQuoteConversion(){
            			 
        				if (document.getElementById('generateQuote').checked) { 
        				    document.getElementById('range40up').value=
        				    	document.getElementById('truck_load').value + '.00/lb'; 
        				    document.getElementById('range2240').value=
        				    	parseInt(document.getElementById('truck_load').value) + 0.02 + '/lb';
        				    document.getElementById('range1122').value=
        				    	parseInt(document.getElementById('truck_load').value) + 0.04 + '/lb';
        				    document.getElementById('range610').value=
        				    	parseInt(document.getElementById('truck_load').value) + 0.06 + '/lb';
        				    document.getElementById('range24').value=
        				    	parseInt(document.getElementById('truck_load').value) + 0.11 + '/lb'; 
        				  } else { 
        					  document.getElementById('range40up').value=""; 
        					  document.getElementById('range2240').value=""; 
        					  document.getElementById('range1122').value="";
        					  document.getElementById('range610').value="";
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
        	<form name="editDistributorQuote" action="editDistributorQuoteDatabase.php" method="post" >
            	<table class= "form-table" border="1" cellspacing="0" cellpadding="1" align="center">
            		<thead><tr>
            			<th colspan="4">Distributor Quote Form</th>
            		</tr></thead>
            		<tr>
            			 <!--Quote Date -->
            			<td ><label for="quote_date"> Date </label></td>
            			<td ><input type="text" name="quote_date"  value="<?php echo $distRow['quote_date'];?>"></td>
            		</tr>
            		<tr>
            			<!--Quote Name/Number -->
            			<td ><label for="quote_num"> Quote Name/Number </label></td>
            			<td ><input type="text" name="quote_num" value="<?php echo $distRow['quote_num'];?>"></td>
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
            			<td><input type="text" name="product_name" value="<?php echo $distRow['product_name'];?>"></td>
            		</tr>
            		<tr>
            			<!--Product Description-->
            			<td><label for="product_desc"> Description </label></td>
            			<td><input type="text" name="product_desc" value="<?php echo $distRow['product_desc'];?>"></td>
            		</tr>
            		<tr>
            			<!--Annual Volume-->
            			<td><label for="annual_vol"> Est. Annual Volume </label></td>
            			<td><input type="text" name="annual vol" value="<?php echo $distRow['annual_vol'];?>"></td>
            		</tr>
            		<tr>
            			<!--OEM-->
            			<td><label for="OEM"> OEM </label></td>
            			<td><input type="text" name="OEM" value="<?php echo $distRow['OEM'];?>"></td>
            		</tr>
            		<tr>
            			<!--Application-->
            			<td><label for="application"> Application </label></td>
            			<td><input type="text" name="application" value="<?php echo $distRow['application'];?>"></td>
            		</tr>
            <?php if ($quoteProduced == 1){ ?>
            		<tr>
            			<!--Truck_load - Base Value-->
            			<td><label for="truck_load"> Truckload, 40,000lb </label></td>
            			<td><input type="number" id=truck_load name="truck_load" onkeyup="valuePresent('generateQuote', this)" value="<?php echo $distRow['truck_load'];?>"></td>
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
            			<td><input type="number" id=truck_load name="truck_load" onkeyup="valuePresent('generateQuote', this)" value="<?php echo $distRow['truck_load'];?>"></td>
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
            			<td> Payment terms are USD $ Funds, Net </td>
            			<td>
                	  		<label for="payment_terms">Select/enter payment terms:</label>
             				<input type="text" id="payment_terms" name="payment_terms" list="payment_options" value=<?php echo $distRow['payment_terms'];?>/>
             				<datalist id="payment_options">
             					<option selected value="30 days">
             					<option value="45 days">
                				<option value="60 days">
                				<option value="90 days">
                				<option value="1%/10, Net 30 days">
             				</datalist>
            			</td>
              		</tr>
            		<tr>
            			<!--LTL Quantities-->	
            			<td> LTL quantities are </td>
                    	<td>
            				<label for="ltl_quantities">Select/enter quantities:</label>
             				<input type="text" id="ltl_quantities" name="ltl_quantities" list="ltl_options" value="<?php echo $distRow['ltl_quantities'];?>"></input>
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
            			<td><input type="text" name="special_terms" value="<?php echo $distRow['special_terms'];?>"></td>
            		</tr>
            		<tr>
            			<!--Quote -  40,000+ lb.-->
            			<td> 40,000 lb. + </td>
            			<td><input type="text" id="range40up" name="range40up" readonly value="<?php echo $distRow['range40up'];?>"></td>
            		</tr>
            		<tr>
            		 <!--Quote - 22,000 - 39,999 lb-->	
            			<td> 22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box </td>
            			<td><input type="text" id="range2240" name="range2240" readonly value="<?php echo $distRow['range2240'];?>"></td>
            		</tr>
            		<tr>
            			 <!--Quote - 11,000 - 21,999 lb-->
            			<td> 11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box </td>
            			<td><input type="text" id="range1122" name="range1122" readonly value="<?php echo $distRow['range1122'];?>"></td>
            		</tr>
            		<tr>
            			<!--Quote - 6,600 - 10,999 lb-->
            			<td> 6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box </td>
            			<td><input type="text" id="range610" name="range610"  readonly value="<?php echo $distRow['range610'];?>"></td>
            		</tr>
            		<tr>
            			 <!--Quote - 2,200 - 4,399 lb.-->
            			<td> 2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box </td>
            			<td><input type="text" id="range24" name="range24" readonly value="<?php echo $distRow['range24'];?>"></td>
            		</tr>
            
            		<tr>
            			<td colspan="1"> <input type="submit" value="submit" style="width:100%"> </td>
            			<td colspan="1"> <input type="reset" value= "reset" style="width:100%">
							<input hidden type="number" id="distributor_id" name="distributor_id" value="<?php echo $distRow['distributor_quote_id'];?>"/>
						</td>
            		</tr>
        		</table>
        	</form>
    	</body>
    </html>