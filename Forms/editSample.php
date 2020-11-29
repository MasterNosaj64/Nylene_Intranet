<?php
    /* Name: sample_form_view.php
     * Author: Emmett Janssens, Modified by Kaitlyn Breker
     * Last Modified: November 12th, 2020
     * Purpose: Displays the information from the Sample form
     */

    session_start();
    include '../NavPanel/navigation.php';
    include "../Database/connect.php";

    $conn = getDBConnection();
    
    /*Check the connection*/
    if (mysqli_connect_error())
    {
		die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error);
    }
    else
    {
        /*Selection statement for employee that created the form*/
		$username = "SELECT first_name, last_name FROM employee
                        INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                            INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                INNER JOIN sample_form ON sample_form.sample_form_id = interaction_relational_form.form_id
                                    WHERE sample_form_id = " . $_POST['id'];
		$result = $conn->query($username);
		$row = mysqli_fetch_array($result);

    }

    /*Selection statement for form*/
	$query_samples	= "SELECT * FROM sample_form WHERE sample_form_id = " . $_POST['id'];
	$query_samples_results = $conn->query($query_samples);
	$qsr = mysqli_fetch_array($query_samples_results);
	
	$_SESSION['field']=$qsr['sample_form_id'];

	/*Selection statement for customer*/
	$getCustomer = "SELECT * FROM company
						INNER JOIN company_relational_customer ON company_relational_customer.company_id = company.company_id
						INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id WHERE customer.customer_id = " . $qsr['customer_code'];

	$getCustomerResult = $conn->query($getCustomer);
	$gcr = mysqli_fetch_array($getCustomerResult);
?>

<html>
    <head>
      <link rel="stylesheet" type="text/css" href="../CSS/form.css">
      <title>Edit Sample Form</title>
	</head>
	<body height="100%" width="100%">
        	<form name="sample_form" action="editSampleDatabase.php" method="POST" onsubmit="return validateForm()">

            <table class= "form-table" border=1 cellspacing="0" cellpadding="3" align="center">
            <thead>
                 <tr>
                    <th colspan="7" align="center">
                        Business Contact Information
                    </th>
                </tr></thead>
                <tr>
                    <td id="info"> Submitted By: </td>
    
                    <td colspan="2">  <input name="submittedBy" type="text" readonly value="<?php echo $row['first_name'] . " " . $row['last_name']; ?>"> </td>
    
                    <td id="info"> Date Created: </td>
                    <td> <input name="dateSubmitted" type="text" readonly value="<?php echo $qsr['date_submitted']; ?>"> </td>
                    <td><label for="m_code">
                        Market Code:</label><br /> <select
					name="m_code" ><?php

echo '<option disabled selected hidden style="width: 260px" >' . $qsr['m_code'] .'</option>'; 
    echo '<option style="width: 260px" value="A-Auto">' . "A  - Auto"	.'</option>';
    echo '<option style="width: 260px" value="EE-Electrical">' . "EE-Electrical" . '</option>';
    echo '<option style="width: 260px" value="WC-Wire&Cable">' . "WC-Wire&Cable"  . '</option>';
    echo '<option style="width: 260px" value="C-Consumer">' . "C-Consumer" . '</option>';
    echo '<option style="width: 260px" value="P-Packaging">' ."P-Packaging" . '</option>';
    echo '<option style="width: 260px" value="I-Industrial">' . "I-Industrial" . '</option>';
    echo '<option style="width: 260px" value="O-Other">' . "O-Other" . '</option>';


?></select></td>
							
    
                 
                </tr>
                <tr>
                    <td id="info"> Company: </td>
    
                    <td colspan="6"><label for="company_name">
                   </label>
    				 <input
					name="company_name" placeholder="<?php echo $gcr['company_name']; ?>"/>
    					
    				</td>
                </tr>
                <tr>
                    <td id="info"> Company Address: </td>
                    <td colspan="3"><label for="company_address">
                   </label>
    				 <input
					name="company_address" placeholder=" <?php echo $gcr['billing_address_street'] . ", " . $gcr['billing_address_city'] . ", " .  $gcr['billing_address_state'] . ", " . $gcr['billing_address_postalcode'] ?>"> </td>
                    <td id="info"> Primary Contact: </td>
                    <td colspan="1"> <label for="customer_name">
                   </label>
    				 <input
					name="customer_name" placeholder="<?php echo $gcr['customer_name'] ?> "> </div> </td>
                </tr>
                <tr>
                    <td id="info"> Phone Number:
                    <td colspan="3"> <label for="customer_phone">
                   </label>
    				 <input
					name="customer_phone" placeholder="<?php echo $gcr['customer_phone'] ?>"> </td>
                    <td id="info"> Email Address: </td>
                    <td colspan="1"><label for="customer_email">
                   </label>
    				 <input
					name="customer_email" placeholder=" <?php echo $gcr['customer_email'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Fax Number: </td>
                    <td colspan="3"><label for="customer_fax">
                   </label>
    				 <input
					name="customer_fax" placeholder=" <?php echo $gcr['customer_fax'] ?>"> </td>
                    <td id="info"> Credit Application Submitted: </td>
                    <td colspan="1"> <label for="credit_app_submitted">
                   </label>
    				 <input type="checkbox" name="credit_app_submitted" value="1" <?php if($qsr['credit_app_submitted'] == 1) {echo "checked";} ?>> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="4" align="center">
                        - Business Case for Sample -
                    </th>
                    <th colspan="2" align="center">
                        - Match To -
                    </th>
                </tr></thead>
                <tr>
                    <td colspan="4" rowspan="3" style="height:80px;"> 
    				 <input
					name="business_case" placeholder="<?php echo $qsr['business_case'] ?> "></td>
                    <td colspan="2"> <input type="checkbox" name="match_sample_sub" value=1 <?php if($qsr['match_sample_sub'] == 1) {echo "checked";} ?>> Sample Submission  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_data_sheet" value=1 <?php if($qsr['match_data_sheet'] == 1) {echo "checked";} ?>> Data Sheet  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_descr" value=1 <?php if($qsr['match_description'] == 1) {echo "checked";} ?>> Description  </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Material Description, Special Handling or Label Request - </th>
                </tr></thead>
                <tr>
                    <td colspan="6"> 
    				 <input
					name="company_name" placeholder="<?php echo $qsr['material_description']; if ($qsr['material_description'] == "") {echo "<br/>";}?>"> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Additional Information - </th>
                </tr></thead>
                <tr>
                    <td id="info"> Customer Process </td>
                    <td colspan="2"><label for="customer_proc">
                   </label>
    				 <input
					name="customer_proc" placeholder=" <?php echo $qsr['customer_proc'] ?>"> </td>
                    <td id="info"> Current Supplier </td>
                    <td colspan="2"> <label for="customer_supplier">
                   </label>
    				 <input
					name="customer_supplier" placeholder="<?php echo $qsr['customer_supplier'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Finished Good Application </td>
                    <td colspan="2"> <label for="finished_good_app">
                   </label>
    				 <input
					name="finished_good_app" placeholder="<?php echo $qsr['finished_good_app'] ?>"> </td>
                    <td id="info"> Est. Annual Volume </td>
                    <td colspan="2"> <label for="annual_vol">
                   </label>
    				 <input
					name="annual_vol" placeholder="<?php echo $qsr['annual_vol'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Current Base Resin System </td>
                    <td colspan="2"><label for="current_resin_system">
                   </label>
    				 <input
					name="current_resin_system" placeholder=" <?php echo $qsr['current_resin_system'] ?>"> </td>
                    <td id="info"> Target Price </td>
                    <td colspan="2"> <label for="target_price">
                   </label>
    				 <input
					name="target_price" placeholder="<?php echo $qsr['target_price'] ?> "></td>
                </tr>
                <tr>
                    <td id="info"> Melt Requirements </td>
                    <td colspan="5"><label for="melt_reqs">
                   </label>
    				 <input
					name="melt_reqs" placeholder=" <?php echo $qsr['melt_reqs'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Current Filler System </td>
                    <td colspan="5"><label for="current_filler_sys">
                   </label>
    				 <input
					name="current_filler_sys" placeholder=" <?php echo $qsr['current_filler_sys'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Color(s) </td>
                    <td colspan="5"><label for="colors">
                   </label>
    				 <input
					name="colors" placeholder=" <?php echo $qsr['colors'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Known Additive Packages </td>
                    <td colspan="5"><label for="known_additives">
                   </label>
    				 <input
					name="known_additives" placeholder=" <?php echo $qsr['known_additives'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> UV Requirements </td>
                    <td colspan="5"> <label for="uv_reqs">
                   </label>
    				 <input
					name="uv_reqs" placeholder="<?php echo $qsr['uv_reqs'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> UL Requirements </td>
                    <td colspan="5"><label for="ul_reqs">
                   </label>
    				 <input
					name="ul_reqs" placeholder=" <?php echo $qsr['ul_reqs'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Automotive Specifications </td>
                    <td colspan="5"><label for="auto_reqs">
                   </label>
    				 <input
					name="auto_reqs" placeholder=" <?php echo $qsr['auto_reqs'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> FDA Requirements </td>
                    <td colspan="5"> <label for="fda_reqs">
                   </label>
    				 <input
					name="fda_reqs" placeholder="<?php echo $qsr['fda_reqs'] ?>"> </td>
                </tr>
                <tr>
                    <td id="info"> Color Specifications </td>
                    <td colspan="5"><label for="color_specs">
                   </label>
    				 <input
					name="color_specs" placeholder=" <?php echo $qsr['color_specs'] ?>"> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Type Of Response Needed By - <?php echo $qsr['response_date'] ?> </th>
                </tr></thead>
                <tr>
                    <td> <input type="checkbox" name="prod_rec" value=1 <?php if($qsr['prod_rec'] == 1) {echo "checked";} ?>> Product Recommendation  </td>
                    <td> <input type="checkbox" name="stock_prod_qty", value=1 <?php if($qsr['stock_prod_qty'] == 1) {echo "checked";} ?>>Stock Product QTY  </td>
                    <td colspan="2" id="info" > Other Documentation (Specify) </td>
                    <td colspan="2"><label for="other_doc">
                   </label>
    				 <input
					name="other_doc" placeholder=" <?php echo $qsr['other_doc'] ?>">  </td>
                </tr>
                <tr>
                    <td> <input type="checkbox" name="sds" value=1 <?php if($qsr['sds'] == 1) {echo "checked";} ?>> SDS  </td>
                    <td> <input type="checkbox" name="coa" value=1 <?php if($qsr['coa'] == 1) {echo "checked";} ?>> COA  </td>
                    <td colspan="2" id="info"> Sample Quantity </td>
                    <td> QTY:<label for="sample_qty">
                   </label>
    				 <input
					name="sample_qty" placeholder=" <?php echo $qsr['sample_qty'] ?>"> </td>
                    <td> Date REQ:<label for="sample_req_date">
                   </label>
    				 <input
					name="sample_req_date" placeholder=" <?php echo $qsr['sample_req_date'] ?>"> </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="data_sheet" value=1 <?php if($qsr['data_sheet'] == 1) {echo "checked";} ?>> Data Sheet  </td>
                    <td colspan="2" id="info"> Charge/No Charge </td>
                    <td> Price:<label for="sample_price">
                   </label>
    				 <input
					name="sample_price" placeholder=" <?php echo $qsr['sample_price'] ?>"> </td>
                    <td> Frt PDD/Add:<label for="sample_frt">
                   </label>
    				 <input
					name="sample_frt" placeholder=" <?php echo $qsr['sample_frt'] ?>"> </td>
                </tr>
                <tr>
                    <td colspan="6" id="info" align="center"> ---Note: SDS Sent With All Samples---</td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Distribution List - </th>
                </tr></thead>
                <tr>
                    <td colspan="3" style="width:50%">Other Contact 1: <label for="other_contact_1">
                   </label>
    				 <input
					name="other_contact_1" placeholder="<?php echo $qsr['other_contact_1'];  ?>"> </td>
    				<td colspan="3" style="width:50%"> Other Contact 2: <label for="other_contact_2">
                   </label>
    				 <input
					name="other_contact_2" placeholder="<?php echo $qsr['other_contact_2'] ?>"> </td>
    			</tr>
    			<tr>
                    <td colspan="3" style="width:50%">Other Contact 3:  <label for="other_contact_3">
                   </label>
    				 <input
					name="other_contact_3" placeholder="<?php echo $qsr['other_contact_3']; ?> "></td>
    				<td colspan="3" style="width:50%">Other Contact 4: <label for="other_contact_4">
                   </label>
    				 <input
					name="other_contact_4" placeholder=" <?php echo $qsr['other_contact_4'] ?> "></td>
    			</tr>
				<tr>
                    <td colspan="3"> <input type="submit" style="width:100%"> </td>
                    <td colspan="3"> <input type="reset" style="width:100%"> </td>
                </tr>
            </table>
    	</form>
         
	</body>
</html>
