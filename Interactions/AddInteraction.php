<?php
    /*
     * FileName: addInteraction.php
     * Version Number: 1.1
     * Author: Jason Waid, Modified by Kaitlyn Breker
     * Date Modified: Nov 27, 2020
     * Purpose: Add companies in the database.
     */

    session_start();
    
    // the following variables are used in navigation.php
    // View navigation.php for more information
    $_SESSION["navToAddInteractionPage"] = true;
    
    // The navigation bar for the website
    include '../NavPanel/navigation.php';
    // connection to the database
    include '../Database/connect.php';
    
    // Customer object
    include '../Database/Customer.php';
    
    // Company object
    include '../Database/Company.php';
    
    // Interaction object
    include '../Database/Interaction.php';
    
    $conn_Customer = getDBConnection();
    
    $conn_Company = getDBConnection();
    
    $conn_Interaction = getDBConnection();
    
    // Handler for if the database connection fails
    if ($conn_Customer->connect_error || $conn_Company->connect_error) {
        die("Connection failed: " . $conn_Customer->connect_error . " || " . $conn_Company->connect_error);
    } else {
        $todaysDate = date("Y-m-d");
        $followDate = date_create($todaysDate);
        date_modify($followDate, "+30 days");
        
        /*
         * The following code handles adding a interaction to the interaction table
         * Below is an explaination of some of the variables
         * submit: set to 1 when the submit button is pressed
         * companyid: The id of the company the interaction will be files under
         */
    
        if (isset($_SESSION['company_id'])) {
    
            if (isset($_POST['submit'])) {
    
                $company_id = $_POST['company_id'];
                $customer_id = $_POST['customer_id'];
                $employee_id = $_SESSION['userid'];
                $reason = $_POST['reason'];
                $comments = $_POST['comments'];
                $status = $_POST['status'];
                $follow_up_type = $_POST['follow_up_type'];
                $follow_up_date = $_POST['follow_up_date'];
    
                $t = time();
                $date_created = date("Y-m-d", $t);
    
                $newInteraction = new Interaction($conn_Interaction);
    
                // Create method returns the insert id if it was successful
                $addInteraction = $newInteraction->create($company_id, $customer_id, $employee_id, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date);
    
                if ($addInteraction == false) {
                    echo "Opperation failed, please try again. If this happens again, inform management";
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Interactions/companyHistory.php\" />";
                }
    
                // store customer id into session for use in forms
                $_SESSION['customer_id'] = $_POST['customer_id'];
                // store interaction_id into session for use in forms
                $_SESSION['interaction_id'] = $addInteraction;
    
                // if form selected, redirect to the appropriate form creation page
                // Sample Form
                if ($_POST['form'] == 1) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/sample.php\" />";
                    exit();
                } // Light Truckload Quote Form
                else if ($_POST['form'] == 2) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/ltlQuoteForm.php\" />";
                    exit();
                } // Truckload Quote Form
                else if ($_POST['form'] == 3) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/tlQuoteForm.php\" />";
                    exit();
                } // Distributor Quote Form
                else if ($_POST['form'] == 4) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/distributorQuoteForm.php\" />";
                    exit();
                } // Marketing Request Form
                else if ($_POST['form'] == 5) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/MMform.php\" />";
                    exit();
                } // Credit Business Application Forn
                else if ($_POST['form'] == 6) {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/creditBusinessApplication.php\" />";
                    exit();
                } else {
    
                    echo "<meta http-equiv = \"refresh\" content = \"0 url = ./companyHistory.php\" />";
                    exit();
                }
            } else {
    
                // Get customers ID's ready for form
                $customerQuery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = " . $_POST['company_id'];
                $customerIds = $conn_Customer->query($customerQuery);
                // Get companyData ready for form
    
                $company = new Company($conn_Company);
                $company->searchId($_POST['company_id']);
                $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCountry()}, {$company->getBillingAddressPostalCode()}";
            }
        } else {
            // If the above throws an error, kick the user back to the homepage
            echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/Homepage.php\" />";
            exit();
        }
    }
?>

<!-- Add interaction Page -->
<!-- The following is the Add interaction interface -->
<html>
<head>
    <title>Add Interaction</title>
    <link rel="stylesheet" href="../CSS/table.css">
    <script>
		/* This function will disable follow_up_type and follow_up_date if the status is closed */
		function disableFollowUp(){
			document.getElementById('follow_up_type').disabled = true;
			document.getElementById('follow_up_type').readOnly = true;
			document.getElementById('follow_up_type').value = "none";
			document.getElementById('follow_up_date').readOnly = true; 
			document.getElementById('follow_up_date').value = "";
			document.getElementById('selector_disabled').disabled = false;
			document.getElementById('selector_disabled').value = "none";
		}
		/* This function will disable follow_up_type and follow_up_date if the status is open */
		function enableFollowUp(){
			document.getElementById('follow_up_type').disabled = false;
			document.getElementById('follow_up_type').readOnly = false; 
			document.getElementById('follow_up_date').readOnly = false;
			document.getElementById('selector_disabled').disabled = true;
		}
		/*Function determines what the input for the follow up date will be if there is a date based on the follow_up_type
			Follow up for quote forms is the set quote date, follow up for sample forms is the request date, 
			credit app date is credit_date and market material date is date_needed */
		function followDate(){
			var x = document.getElementById('set_date');
			var followDate = x.defaultValue;
			
			if ((document.getElementById('follow_up_type').value == "none") || (document.getElementById('follow_up_type').value == "form")){
				document.getElementById('follow_up_date').readOnly = true;
				document.getElementById('follow_up_date').value = "";
				document.getElementById('selector_disabled').disabled = true;
			} else if (document.getElementById('follow_up_type').value == "interaction") {
				document.getElementById('follow_up_date').readOnly = true;
				document.getElementById('follow_up_date').value = followDate;
				document.getElementById('selector_disabled').disabled = true;
			} else if (document.getElementById('follow_up_type').value == "manual"){
				document.getElementById('follow_up_date').readOnly = false;
				document.getElementById('follow_up_date').value = followDate;
				document.getElementById('selector_disabled').disabled = true;
			}
		}

		/*Function disables selection for form if the reason is not a form*/
		function formSelect(){
			if ((document.getElementById('reason').value == "Credit Business Application") 
				|| (document.getElementById('reason').value == "Distributor Quote")
				|| (document.getElementById('reason').value == "Light Truckload Quote")
				|| (document.getElementById('reason').value == "Marketing Request")
				|| (document.getElementById('reason').value == "Sample")
				|| (document.getElementById('reason').value == "Truckload Quote")) {

					document.getElementById('form').disabled = false;
    				document.getElementById('form').readOnly = false;
    				document.getElementById('form_disabled').disabled = true;

				} else {
					document.getElementById('form').disabled = true;
					document.getElementById('form_disabled').disabled = false;
    				document.getElementById('form').value = "0";
    				
				}
		}
		</script>
    </head>
    <body>
    	<!-- <h1>Interaction</h1> -->
    	<form method="post" action=AddInteraction.php name="add_interaction" autocomplete="off">
    		<input type="reset" value="Clear">
    		<table class="form-table" border=5>
    			<tr>
    				<td>Company:</td>
    				<td><?php echo $company->getName();?></td>
    				<td>Address:</td>
    				<td><?php echo $companyAddress;?></td>
    				<td>Company Email:</td>
    				<td><a href="mailto:<?php echo $company->getEmail();?>"><?php echo $company->getEmail();?></a></td>
    			</tr>
    			<tr>
    				<td>Customer:</td>
    				<td><select id="selection" required name="customer_id">
    						<option></option>
                    	<?php
                            while ($id = mysqli_fetch_array($customerIds)) {
                            
                                $customer = new Customer($conn_Customer);
                                $customer->searchById($id["customer_id"]);
                            
                                // $getCustomerData = "SELECT * FROM nylene.customer WHERE customer_id = " . $id["customer_id"];
                                // $customerData = mysqli_fetch_array($conn->query($getCustomerData));
                                echo "<option value='{$customer->getCustomerId()}'>{$customer->getName()}</option>";
                            }
                            $conn_Customer->close();
                            $conn_Company->close();
                        ?>
            		</select></td>
    				<td>Reason:</td>
    				<td><select id="reason" name="reason" onclick="formSelect()" required>
    						<option></option>
    						<option value="Added Customer">Added Customer</option>
    						<option value="Credit Business Application">Credit Business Application</option>
    						<option value="Distributor Quote">Distributor Quote</option>
    						<option value="General">General</option>
    						<option value="Light Truckload Quote">Light Truckload Quote</option>
    						<option value="Marketing Request">Marketing Request</option>
    						<option value="Meeting">Meeting</option>
    						<option value="Phone Call">Phone Call</option>
    						<option value="Sample">Sample Request</option>
    						<option value="Schedule">Schedule</option>
    						<option value="Status">Status</option>
    						<option value="Truckload Quote">Truckload Quote</option>
    						<option value="Update">Update</option>
    				</select></td>
    				<td>Form (if applicable):</td>
    				<td><select id="form" name="form" disabled>
    						<option value="0"></option>
    						<option value="6">Credit Business Application</option>
    						<option value="4">Distributor Quote</option>
    						<option value="2">Light Truckload Quote</option>
    						<option value="5">Marketing Request</option>
    						<option value="1">Sample Request</option>
    						<option value="3">Truckload Quote</option>
    					</select>
    					<input hidden id="form_disabled" name="form" value="0" disabled/>
    				</td>
    			<tr>
    				<td>Interaction Status: </td>
    				<td>
    					<input type="radio" id="enable" name="status" value="open" onclick="enableFollowUp()" checked>
        				<label for="open"> Open </label>
        				<input type="radio" id="disable" name="status" value="closed" onclick="disableFollowUp()">
        				<label for="closed"> Closed </label>
        			</td>

        		<td><label for="follow_up_type"> Follow Up Type: </label></td>
        			<td><select id="follow_up_type" name="follow_up_type" onclick="followDate()" required >
        					<option> </option>
        					<option value="interaction">Based on the interaction date (+30days)</option>
    						<option value="form">Based on the set form date (+30days)</option>
    						<option value="none">No follow up date</option>
    						<option value="manual">Manual (update follow-up date)</option>
    					</select>
    					<input hidden id="selector_disabled" name="follow_up_type" value="none" disabled/>
    				</td>
    				

        			<td><label for="follow_up_date"> Follow Up Date: </label></td>
        			<td><input type="date" id="follow_up_date" name="follow_up_date" value="" readonly >
        				<input hidden type="date" id="set_date" value="<?php echo date_format($followDate, "Y-m-d"); ?>" disabled></td>
    			</tr>
    			<tr>
    				<td colspan=6><textarea maxlength="1024" required name="comments"
    						rows="20" cols="100"></textarea></td>
    			</tr>
    		</table>
    		<input hidden="true" name="company_id" value="<?php echo $company->getCompanyId();?>" />
    		<input type="submit" name="submit" value="Submit">
    	</form>
    </body>
</html>