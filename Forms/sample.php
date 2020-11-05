<?php
    /* Name: sample.php
     * Author: Emmett Janssens, Modified by Kaitlyn Breker
     * Last Modified: November 5th, 2020
     * Purpose: Input for Sample form. User information, company and customer information is 
     *          automatically displayed from database.
     */

    session_start();
    include '../NavPanel/navigation.php';
	include '../Database/connect.php';

	
	$conn = getDBConnection();
	
	/*Check the connection*/
	if (mysqli_connect_error())
	{
		die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error);
	}
	else
	{
	    /*Selection statement for current employee*/
		$username = "SELECT first_name, last_name FROM employee WHERE employee_id = " . $_SESSION['userid'];

		/*Selection statement for customer passed from interaction*/
		$customer = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['customer_id'];
		$customer_info = $conn->query($customer);
		$customer_info_row = mysqli_fetch_array($customer_info);

		/*Selection statement for company passed from interaction*/
		$company = "SELECT * FROM company WHERE company_id = " . $_SESSION['company_id'];
		$company_info = $conn->query($company);
		$company_info_row = mysqli_fetch_array($company_info);

		$result = $conn->query($username);
		$row = mysqli_fetch_array($result);
	}

	  /*Assign variables*/
      $todaysDateStr = date("Y/m/d");
      $todaysDateDate = date_create($todaysDateStr);
      date_modify($todaysDateDate, "-1 days");
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../CSS/form.css">
		<script>
		/*Function to validateForm*/
      		function validateForm ()
			{
				var reply_date = document.forms["sample_form"]["response_date"].value;
				var supply_by = document.forms["sample_form"]["sample_req_date"].value;
        		var today = new Date();
				var dateToday = today.toJSON().slice(0, 10);

				if (reply_date < dateToday)
				{
					     alert("Choose a future date for when the request is needed!");
					     return false;
				}

				if (supply_by != "" && supply_by < dateToday)
				{
                      alert("Choose a future date for when the sample is needed!");
                      return false;
				}
				return true;
			}
		</script>
	</head>

	<body height="100%" width="100%">
        <div>
    	<form name="sample_form" action="newSampleForm.php" method="POST" onsubmit="return validateForm()">
            <table class= "form-table" border=1 cellspacing="0" cellpadding="3" align="center">
                 <thead>
                 <tr>
                    <th colspan="7" align="center">
                        Business Contact Information
                    </th>
                </tr></thead>
                <tr>
                    <td  id="info"> Submitted By: </td>
    
                    <td colspan="2">  <input name="submittedBy" type="text" readonly value="<?php echo $row['first_name'] . " " . $row['last_name']; ?>"> </td>
    
                    <td id="info"> Date Created: </td>
                    <td> <input name="dateSubmitted" type="text" readonly value="<?php echo date_format($todaysDateDate, "Y/m/d"); ?>"> </td>
                    <td>
                        Market Code:
                        <select id="mCode" name="mCode">
                            <option value="A-Auto">        A  - Auto          </option>
                            <option value="EE-Electrical"> EE - Electrical    </option>
                            <option value="WC-Wire&Cable"> WC - Wire & Cable  </option>
                            <option value="C-Consumer">    C  - Consumer      </option>
                            <option value="P-Packaging">   P  - Packaging     </option>
                            <option value="I-Industrial">  I  - Industrial    </option>
                            <option value="O-Other">       O  - Other         </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td id="info"> Company: </td>
    
                    <td colspan="6">
    					<input type="hidden" id="comapny_id" value="<?php echo $company_info_row['company_id']; ?>"> <?php echo $company_info_row['company_name']; ?> </p>
    				</td>
                </tr>
                <tr>
                    <td id="info"> Company Address: </td>
                    <td colspan="3">  <?php echo $company_info_row['billing_address_street'] . ", " . $company_info_row['billing_address_city'] . ", " .  $company_info_row['billing_address_state'] . ", " . $company_info_row['billing_address_postalcode'] ?> </p> </div> </td>
                    <td id="info"> Primary Contact: </td>
                    <td colspan="1"> <input type="hidden" value="<?php echo $company_info_row['company_id'];?>">  <?php echo $customer_info_row['customer_name']; ?> </p> </td>
                </tr>
                <tr>
                    <td id="info"> Phone Number:
                    <td colspan="3"> <?php echo $customer_info_row['customer_phone']; ?> </p> </td>
                    <td id="info"> Email Address: </td>
                    <td colspan="1">  <?php echo $customer_info_row['customer_email']; ?> </p> </td>
                </tr>
                <tr>
                    <td id="info"> Fax Number: </td>
                    <td colspan="3"> <?php echo $customer_info_row['customer_fax']; ?> </p> </td>
                    <td id="info"> Credit Application Submitted: </td>
                    <td colspan="1"> <input type="checkbox" name="credit_app_submitted" value="1"> </td>
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
                    <td colspan="4" rowspan="3" style="height:80px;"> <input type="text" name="business_case"> </td>
                    <td colspan="2"> <input type="checkbox" name="match_sample_sub" value=1> Sample Submission  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_data_sheet" value=1> Data Sheet  </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="match_descr" value=1> Description  </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Material Description, Special Handling or Label Request - </th>
                </tr></thead>
                <tr>
                    <td colspan="6"> <input type="text" name="material_descr"> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Additional Information - </th>
                </tr>
                </thead>
                <tr>
                    <td id="info"> Customer Process </td>
                    <td colspan="2"> <input type="text" name="customer_proc"> </td>
                    <td id="info"> Current Supplier </td>
                    <td colspan="2"> <input type="text" name="curr_supplier"> </td>
                </tr>
                <tr>
                    <td id="info"> Finished Good Application </td>
                    <td colspan="2"> <input type="text" name="finised_good_app"> </td>
                    <td id="info"> Est. Annual Volume </td>
                    <td colspan="2"> <input type="text" name="annual_vol"> </td>
                </tr>
                <tr>
                    <td id="info"> Current Base Resin System </td>
                    <td colspan="2"> <input type="text" name="curr_resin_system"> </td>
                    <td id="info"> Target Price </td>
                    <td colspan="2"> <input type="text" name="target_price"> </td>
                </tr>
                <tr>
                    <td id="info"> Melt Requirements </td>
                    <td colspan="5"> <input type="text" name="melt_reqs"> </td>
                </tr>
                <tr>
                    <td id="info"> Current Filler System </td>
                    <td colspan="5"> <input type="text" name="curr_filler_sys"> </td>
                </tr>
                <tr>
                    <td id="info"> Color(s) </td>
                    <td colspan="5"> <input type="text" name="colors"> </td>
                </tr>
                <tr>
                    <td id="info"> Known Additive Packages </td>
                    <td colspan="5"> <input type="text" name="known_additives"> </td>
                </tr>
                <tr>
                    <td id="info"> UV Requirements </td>
                    <td colspan="5"><input type="text" name="uv_reqs">  </td>
                </tr>
                <tr>
                    <td id="info"> UL Requirements </td>
                    <td colspan="5"> <input type="text" name="ul_reqs"> </td>
                </tr>
                <tr>
                    <td id="info"> Automotive Specifications </td>
                    <td colspan="5"> <input type="text" name="auto_reqs"> </td>
                </tr>
                <tr>
                    <td id="info"> FDA Requirements </td>
                    <td colspan="5"> <input type="text" name="fda_reqs"> </td>
                </tr>
                <tr>
                    <td id="info"> Color Specifications </td>
                    <td colspan="5"> <input type="text" name="color_specs"> </td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Type Of Response Needed By - <input type="date" name="response_date"> </th>
                </tr>
                </thead>
                <tr>
                    <td> <input type="checkbox" name="prod_rec" value=1> Product Recommendation  </td>
                    <td> <input type="checkbox" name="stock_prod_qty", value=1>Stock Product QTY  </td>
                    <td colspan="2" id="info"> Other Documentation (Specify) </td>
                    <td colspan="2"> <input type="text" name="other_doc">  </td>
                </tr>
                <tr>
                    <td> <input type="checkbox" name="sds" value=1> SDS  </td>
                    <td> <input type="checkbox" name="coa" value=1 > COA  </td>
                    <td colspan="2" id="info"> Sample Quantity </td>
                    <td> QTY: <input type="text" style="width:100%;" name="sample_qty"> </td>
                    <td> Date REQ: <input type="date" name="sample_req_date"> </td>
                </tr>
                <tr>
                    <td colspan="2"> <input type="checkbox" name="data_sheet" value=1> Data Sheet  </td>
                    <td colspan="2" id="info"> Charge/No Charge </td>
                    <td> Price: <input type="text" style="width:100%" name="sample_price"> </td>
                    <td> Frt PDD/Add: <input type="text" style="width:100%" name="sample_frt"> </td>
                </tr>
                <tr>
                    <td colspan="6" id="info" align="center"> ---Note: SDS Sent With All Samples---</td>
                </tr>
                <thead>
                <tr>
                    <th colspan="6" align="center"> - Distribution List - </th>
                </tr>
                </thead>
                <tr>
    				<td colspan="2" id="info"> Other Contact 1: </td>
                    <td colspan="4"><input type="text" name="other_contact1"> </td>
                </tr>
                <tr>
    				<td colspan="2" id="info"> Other Contact 2: </td>
                    <td colspan="4"><input type="text" name="other_contact2"> </td>
                </tr>
    			<tr>
    				<td colspan="2" id="info"> Other Contact 3: </td>
                    <td colspan="4"><input type="text" name="other_contact3"> </td>
                </tr>
    			<tr>
    				<td colspan="2" id="info"> Other Contact 4: </td>
                    <td colspan="4"><input type="text" name="other_contact4"> </td>
                </tr>
                <tr>
                    <td colspan="5"> <input type="submit" style="width:100%"> </td>
                    <td colspan="3"> <input type="reset" style="width:100%"> </td>
                </tr>
            </table>
    	</form>
        </div>
    </body>
</html>
