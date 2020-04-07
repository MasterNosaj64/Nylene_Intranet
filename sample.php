<?php
    //session_start();
    
    include 'navigation.php';
	include 'connect.php';

	$_SESSION['company_id'] = 1;
	$_SESSION['customer_id'] = 1;

	if (mysqli_connect_error())
	{
		die ('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error);
	}
	else
	{
		$username = "SELECT first_name, last_name FROM employee WHERE employee_id =" .$_SESSION['user_id'] ;

		$result = $conn->query($username); 
		$row = mysqli_fetch_array($result);

		$company = "SELECT company_name, billing_address_street, billing_address_city, billing_address_state, billing_address_postalcode FROM company
					WHERE company_id=" . $_SESSION['company_id'];

		$result2 = $conn->query($company);
		$company_row = mysqli_fetch_array($result2);

		 $address = $company_row['billing_address_street'] . ", " . $company_row['billing_address_city'] . ", " .  $company_row['billing_address_state'] . ", " . $company_row['billing_address_postalcode'];

		 $customer = "SELECT customer_name, customer_phone, customer_fax, customer_email FROM customer
					WHERE customer_id=" . $_SESSION['customer_id'];

		$result3 = $conn->query($customer);
		$customer_row = mysqli_fetch_array($result3);
	}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="form.css">

		<script>
			
			//Create The Dropdown Menu for Companies
			getCompanies();

			/*
				Uses PHP to query the database for all of the companies and creates
				a dropdown menu of the existing companies, javascript then modifies the
				appropriate html div accordingly
			*/
			function getCompanies ()
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("companies").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "generateDropDownCompanies.php", true);
				xhttp.send();
			}

			/*
				Uses PHP to query the database for all of the customers based on the
				currently selected company and creates a dropdown menu of the those customers,
				javascript then modifies the appropriate html div accordingly
			*/
			function generateDropDownContacts (str)
			{
				//Clear info when the user switches companies
				document.getElementById("dropdown_popup_clients").innerHTML;
				document.getElementById("fax").innerHTML = "<p> </p>";
				document.getElementById("phone_num").innerHTML = "<p> </p>";
				document.getElementById("email").innerHTML = "<p> </p>";
				
				//Clear everything if the user went back to selecting just the select company
				if (str == "-1")
				{
					document.getElementById("dropdown_popup_clients").innerHTML = "<p> </p>";
					document.getElementById("address").innerHTML = "<p> </p>";
					return;
				}

				//Get the address of the new company (Billing)
				getAddress(str);

				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("dropdown_popup_clients").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "generateDropDownClients.php?q=" + str, true);
				xhttp.send();
			}

			/*
				Uses PHP to query the database for the contact information of the
				currently selected customer javascript then modifies the appropriate 
				html divs accordingly
			*/
			function populateInfo (str)
			{
				//Clear info if 
				if (str == "-1")
				{
					document.getElementById("fax").innerHTML = "<p> </p>";
					document.getElementById("phone_num").innerHTML = "<p> </p>";
					document.getElementById("email").innerHTML = "<p> </p>";
					return;
				}

				getPhoneNum(str);
				getEmail(str);
				getFax(str);
			}

			/*
				Uses PHP to get the address of the currently selected company
			*/
			function getAddress (str)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("address").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "getAddress.php?q=" + str, true);
				xhttp.send();
			}

			/*
				Uses PHP to get the email of the currently selected customer
			*/
			function getEmail (str)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("email").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "getEmail.php?q=" + str, true);
				xhttp.send();
			}

			/*
				Uses PHP to get the phone number of the currently selected customer
			*/
			function getPhoneNum (str)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("phone_num").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "getPhoneNum.php?q=" + str, true);
				xhttp.send();
			}

			/*
				Uses PHP to get the fax of the currently selected customer
			*/
			function getFax (str)
			{
				var xhttp = new XMLHttpRequest();
				xhttp.onreadystatechange = function ()
				{
					if (this.readyState == 4 && this.status == 200)
					{
						document.getElementById("fax").innerHTML = this.responseText;
					}
				};

				xhttp.open("GET", "getFax.php?q=" + str, true);
				xhttp.send();
			}

			function validateForm ()
			{
				var company = document.forms["sample_form"]["company"].value;
				var customer = document.forms["sample_form"]["customer_id"].value;
				var reply_date = document.forms["sample_form"]["response_date"].value;
				var supply_by = document.forms["sample_form"]["sample_req_date"].value;
				var today = new Date().toJSON().slice(0, 10);

				if (company == "-1")
				{
					alert("You have to select a company!");
					return false;
				}
				
				if (customer == "-1")
				{
					alert("You have to select a customer!");
					return false;
				}

				if (reply_date < today)
				{
					alert("Choose a future date for when the request is needed!");
					return false;
				}

				const customer_id = document.createElement("input");
				customer_id.type  = "hidden";
				customer_id.id    = "customer_id";
				customer_id.value = document.forms["sample_form"]["customer_id"].value;

				document.getElementById("sample_form").Add(customer_id);

				const company_id = document.createElement("input");
				company_id.type  = "hidden";
				company_id.id    = "company_id";
				company_id.value = document.forms["sample_form"]["company"].value;

				document.getElementById("sample_form").Add(company_id);
			}
		</script>
	</head>

	<body height="100%" width="100%">
    <div>
	<form name="sample_form" action="insert.php" method="POST" onsubmit="return validateForm()">
        <table border=1 cellspacing="0" cellpadding="3" align="center">
             <tr>
                <th colspan="7" align="left">
                    Business Contact Information
                </th>
            </tr>
            <tr>
                <td id="info"> Submitted By: </td>

                <td colspan="2">  <input name="submittedBy" type="text" readonly value="<?php echo $row['first_name'] . " " . $row['last_name']; ?>"> </td>
   
                <td id="info"> Date Created: </td>
                <td> <input name="dateSubmitted" type="text" readonly value="<?php echo date("Y/m/d"); ?>"> </td>
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
					<p style="background-color:lightblue"> <?php echo $company_row['company_name']; ?> </p>
				</td>
            </tr>
            <tr>
                <td id="info"> Company Address: </td>
                <td colspan="3"> <p style="background-color:lightblue"> <?php echo $address; ?> </p> </td>
                <td id="info"> Primary Contact: </td>
                <td colspan="1"> <p style="background-color:lightblue"> <?php echo $customer_row['customer_name']; ?> </p> </td>
            </tr>
            <tr>
                <td id="info"> Phone Number:
                <td colspan="3"> <p style="background-color:lightblue"> <?php echo $customer_row['customer_phone']; ?> </p> </td>
                <td id="info"> Email Address: </td>
                <td colspan="1"> <p style="background-color:lightblue"> <?php echo $customer_row['customer_email']; ?> </p> </td>
            </tr>
            <tr>
                <td id="info"> Fax Number: </td>
                <td colspan="3"> <p style="background-color:lightblue"> <?php echo $customer_row['customer_fax']; ?> </p> </td>
                <td id="info"> Credit Application Submitted: </td>
                <td colspan="1"> <input type="checkbox" name="credit_app_submitted" value="1"> </td>
            </tr>
            <tr>
                <th colspan="4" align="left">
                    Business Case for Sample
                </th>
                <th colspan="2" align="left">
                    Match To
                </th>
            </tr>
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
            <tr>
                <th colspan="6" align="left"> Material Description, Special Handling or Label Request </th>
            </tr>
            <tr>
                <td colspan="6"> <input type="text" name="material_descr"> </td>
            </tr>
            <tr>
                <th colspan="6" align="left"> Additional Information </th>
            </tr>
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
            <tr>
                <th colspan="6" align="left"> Type Of Response Needed By: <input type="date" name="response_date"> </th>
            </tr>
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
            <tr>
                <th colspan="6" align="left"> Distribution List (Other Contacts) </th>
            </tr>
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