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
	</head>
	<body height="100%" width="100%">
    	<form>
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
                    <td>
                        Market Code:
    
    					<?php echo $qsr['m_code'] ?>
    
                    </td>
                </tr>
                <tr>
                    <td id="info"> Company: </td>
    
                    <td colspan="6">
    				<div id="companies">
    					<?php echo $gcr['company_name'] ?>
    				</div>
    				</td>
                </tr>
                <tr>
                    <td id="info"> Company Address: </td>
                    <td colspan="3"> <?php echo $gcr['billing_address_street'] . ", " . $gcr['billing_address_city'] . ", " .  $gcr['billing_address_state'] . ", " . $gcr['billing_address_postalcode'] ?> </td>
                    <td id="info"> Primary Contact: </td>
                    <td colspan="1"> <?php echo $gcr['customer_name'] ?>  </div> </td>
                </tr>
                <tr>
                    <td id="info"> Phone Number:
                    <td colspan="3"> <?php echo $gcr['customer_phone'] ?> </td>
                    <td id="info"> Email Address: </td>
                    <td colspan="1"> <?php echo $gcr['customer_email'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Fax Number: </td>
                    <td colspan="3"> <?php echo $gcr['customer_fax'] ?> </td>
                    <td id="info"> Credit Application Submitted: </td>
                    <td colspan="1"> <input type="checkbox" name="credit_app_submitted" value="1" <?php if($qsr['credit_app_submitted'] == 1) {echo "checked";} ?>> </td>
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
                    <td colspan="4" rowspan="3" style="height:80px;"> <?php echo $qsr['business_case'] ?> </td>
                    <td colspan="2"> <input type="checkbox" name="match_sample_sub" value=1 <?php if($qsr['match_sample_sub'] == 1) {echo "checked";} ?>> Sample Submission  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_data_sheet" value=1<?php if($qsr['match_data_sheet'] == 1) {echo "checked";} ?>> Data Sheet  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_descr" value=1 <?php if($qsr['match_description'] == 1) {echo "checked";} ?>> Description  </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Material Description, Special Handling or Label Request - </th>
                </tr></thead>
                <tr>
                    <td colspan="6"> <?php echo $qsr['material_description']; if ($qsr['material_description'] == "") {echo "<br/>";}?> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Additional Information - </th>
                </tr></thead>
                <tr>
                    <td id="info"> Customer Process </td>
                    <td colspan="2"> <?php echo $qsr['customer_proc'] ?> </td>
                    <td id="info"> Current Supplier </td>
                    <td colspan="2"> <?php echo $qsr['customer_supplier'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Finished Good Application </td>
                    <td colspan="2"> <?php echo $qsr['finished_good_app'] ?> </td>
                    <td id="info"> Est. Annual Volume </td>
                    <td colspan="2"> <?php echo $qsr['annual_vol'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Current Base Resin System </td>
                    <td colspan="2"> <?php echo $qsr['current_resin_system'] ?> </td>
                    <td id="info"> Target Price </td>
                    <td colspan="2"> <?php echo $qsr['target_price'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Melt Requirements </td>
                    <td colspan="5"> <?php echo $qsr['melt_reqs'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Current Filler System </td>
                    <td colspan="5"> <?php echo $qsr['current_filler_sys'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Color(s) </td>
                    <td colspan="5"> <?php echo $qsr['colors'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Known Additive Packages </td>
                    <td colspan="5"> <?php echo $qsr['known_additives'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> UV Requirements </td>
                    <td colspan="5"> <?php echo $qsr['uv_reqs'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> UL Requirements </td>
                    <td colspan="5"> <?php echo $qsr['ul_reqs'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Automotive Specifications </td>
                    <td colspan="5"> <?php echo $qsr['auto_reqs'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> FDA Requirements </td>
                    <td colspan="5"> <?php echo $qsr['fda_reqs'] ?> </td>
                </tr>
                <tr>
                    <td id="info"> Color Specifications </td>
                    <td colspan="5"> <?php echo $qsr['color_specs'] ?> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Type Of Response Needed By - <?php echo $qsr['response_date'] ?> </th>
                </tr></thead>
                <tr>
                    <td> <input type="checkbox" name="prod_rec" value=1 <?php if($qsr['prod_rec'] == 1) {echo "checked";} ?>> Product Recommendation  </td>
                    <td> <input type="checkbox" name="stock_prod_qty", value=1 <?php if($qsr['stock_prod_qty'] == 1) {echo "checked";} ?>>Stock Product QTY  </td>
                    <td colspan="2" id="info" > Other Documentation (Specify) </td>
                    <td colspan="2"> <?php echo $qsr['other_doc'] ?>  </td>
                </tr>
                <tr>
                    <td> <input type="checkbox" name="sds" value=1 <?php if($qsr['sds'] == 1) {echo "checked";} ?>> SDS  </td>
                    <td> <input type="checkbox" name="coa" value=1 <?php if($qsr['coa'] == 1) {echo "checked";} ?>> COA  </td>
                    <td colspan="2" id="info"> Sample Quantity </td>
                    <td> QTY: <?php echo $qsr['sample_qty'] ?> </td>
                    <td> Date REQ: <?php echo $qsr['sample_req_date'] ?> </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="data_sheet" value=1 <?php if($qsr['data_sheet'] == 1) {echo "checked";} ?>> Data Sheet  </td>
                    <td colspan="2" id="info"> Charge/No Charge </td>
                    <td> Price: <?php echo $qsr['sample_price'] ?> </td>
                    <td> Frt PDD/Add: <?php echo $qsr['sample_frt'] ?> </td>
                </tr>
                <tr>
                    <td colspan="6" id="info" align="center"> ---Note: SDS Sent With All Samples---</td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Distribution List - </th>
                </tr></thead>
                <tr>
                    <td colspan="3" style="width:50%"> <?php echo $qsr['other_contact_1']; if ($qsr['other_contact_1'] == "") {echo "<br/>";} ?> </td>
    				<td colspan="3" style="width:50%"> <?php echo $qsr['other_contact_2'] ?> </td>
    			</tr>
    			<tr>
                    <td colspan="3" style="width:50%"> <?php echo $qsr['other_contact_3']; if ($qsr['other_contact_3'] == "") {echo "<br/>";} ?> </td>
    				<td colspan="3" style="width:50%"> <?php echo $qsr['other_contact_4'] ?> </td>
    			</tr>
            </table>
    	</form>
	</body>
</html>
