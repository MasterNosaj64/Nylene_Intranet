<?php
    /*
     * FileName: editInteraction.php
     * Version Number: 1.1
     * Author: Kaitlyn Breker modified from AddInteraction.php
     * Date Modified: Nov 22, 2020
     * Purpose: Edit interaction information from database by autofilling fields from db.
     */
    
    date_default_timezone_set('America/Toronto');
    session_start();
    
    $_SESSION["navToAddInteractionPage"] = true;
    
    include '../NavPanel/navigation.php';
    include '../Database/connect.php';
    include '../Database/Customer.php';
    include '../Database/Company.php';
    include '../Database/Interaction.php';
    
    $conn_Customer = getDBConnection();
    $conn_Company = getDBConnection();
    $conn_Interaction = getDBConnection();
    $conn_Forms = getDBConnection();
    
    
    if (isset($_POST['interaction_id'])) {
        
        $_SESSION['interaction_id'] = $_POST['interaction_id'];
        
        //Handler for if the database connection fails
        if ($conn_Interaction->connect_error || $conn_Company->connect_error || $conn_Customer->connect_error || $conn_Forms->connect_error) {
            
            die("Connection failed: " . $conn_Interaction->connect_error ." || ".$conn_Company->connect_error." || ". $conn_Customer->connect_error ." || ". $conn_Forms->connect_error);
        
        } else {
            

            $interaction = new Interaction($conn_Interaction);
            $interaction = $interaction->searchId($_SESSION['interaction_id']);
            
            $_SESSION['company_id'] = $interaction->getCompanyId();
            
            $company = new Company($conn_Company);
            $company = $company->searchId($interaction->getCompanyId());
            $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCountry()}, {$company->getBillingAddressPostalCode()}";
            
            $customer = new Customer($conn_Customer);
            $customer = $customer->searchById($interaction->getCustomerId());
            
            $query_view_form = "SELECT * FROM nylene.interaction_relational_form WHERE interaction_id = " . $_SESSION['interaction_id'];
            $viewInteractionForm = mysqli_fetch_array($conn_Forms->query($query_view_form));
            
            /*create follow_up date based on interaction date*/
           /*  $intDate = strtotime($interaction->getDateCreated());
            $interDate = date("Y-m-d", $intDate);
            $interactionDate = date_create($interDate);
            date_modify($interactionDate, "+30 days"); */
            
            /**/
            $followDate = date_create($interaction->getDateCreated());
            date_modify($followDate, "+30 days");
            
            
            $conn_Interaction->close();
            $conn_Company->close();
            $conn_Customer->close();
            $conn_Forms->close();
        }
    } else {

        echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/Homepage.php\" />;";
        exit();
    }
?>

<html>
    <head>
        <title>Edit Interaction</title>
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
    			credit app date is date form and market material date is the date form (request_date in db) */
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
    	</script>
    </head>
    <body>
    	<form method="post" action=updateInteractionDB.php name="edit_interaction">
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
                	<td>Name:</td>
                	<td><?php echo $customer->getName();?></td>
                	<td>Email:</td>
                	<td><a href="mailto: <?php echo $customer->getEmail();?>"><?php echo $customer->getEmail();?></a></td>
                	<td>Phone:</td>
                	<td><?php echo $customer->getPhone();?></td>
                </tr>
                <tr>
    				<td>Date Created</td>
                	<td><?php echo $interaction->getDateCreated();?></td>
                	<td>*Reason:</td>
    				<td><?php echo $interaction->getReason();?></td>
    				<td>*Form Type, if present:</td>
    				<td>
    				<?php 
    				if ($viewInteractionForm != null) {
                        if ($viewInteractionForm['form_type'] == 1) {
                        ?> Sample Form 
                        <?php } else if ($viewInteractionForm['form_type'] == 2) {
                        ?> Light Truck Form
                        <?php } else if ($viewInteractionForm['form_type'] == 3) {
                        ?> Truckload Form
                        <?php } else if ($viewInteractionForm['form_type'] == 4) {
                        ?> Distributor Quote Form
                        <?php } else if ($viewInteractionForm['form_type'] == 5) {
                        ?> Marketing Request Form
                        <?php } else if ($viewInteractionForm['form_type'] == 6) {
                        ?> Business Credit Application Form 
                        <?php } 
    				} else { ?>
					 	-- <?php 
                    } ?>
    				</td>
    			</tr>
    			<tr>
    				<td colspan=2></td>
    				<td colspan=4>*Note: To update reason or change the form type, please close this interaction and create a new one</td>
    			</tr>
    			<tr>
    				<td>Interaction Status: </td>
    				<td><?php
        			     /*status of the interaction open/closed*/
                           if ($interaction->getStatus() == 'open'){ ?>
                               <input type="radio" id="enable" name="status" value="open" onclick="enableFollowUp()" checked/>
                               <label for="open"> Open </label>
                               <input type="radio" id="disable" name="status" value="closed" onclick="disableFollowUp()"/>
                               <label for="closed"> Closed </label>
                           <?php } else if ($interaction->getStatus() == 'closed') { ?>
                		       <input type="radio" id="enable" name="status" value="open" onclick="enableFollowUp()"/>
                               <label for="open"> Open </label>
                               <input type="radio" id="disable" name="status" value="closed" onclick="disableFollowUp()" checked/>
                               <label for="closed"> Closed </label>
                           <?php } ?>
        			</td>
            		<td><label for="follow_up_type"> Follow Up Type: </label></td>
            		<td>
            			<select id="follow_up_type" name="follow_up_type" onclick="followDate()" required >
                					<option> </option>
            			 	<?php if ($interaction->getFollowUpType() == 'interaction'){ ?>
                					<option value="interaction" selected>Based on the interaction date (+30days)</option>
            						<option value="form">Based on the set form date (+30days)</option>
            						<option value="none">No follow up date</option>
            						<option value="manual">Manual (update follow-up date)</option>
                            <?php } else if ($interaction->getFollowUpType() == 'form') { ?>
    								<option value="interaction">Based on the interaction date (+30days)</option>
            						<option value="form" selected>Based on the set form date (+30days)</option>
            						<option value="none">No follow up date</option>
            						<option value="manual">Manual (update follow-up date)</option>
                             <?php } else if ($interaction->getFollowUpType() == 'none') { ?>
                                	<option value="interaction">Based on the interaction date (+30days)</option>
            						<option value="form">Based on the set form date (+30days)</option>
            						<option value="none" selected>No follow up date</option>
            						<option value="manual">Manual (update follow-up date)</option>
                             <?php } else if ($interaction->getFollowUpType() == 'manual') { ?>
                               		<option value="interaction">Based on the interaction date (+30days)</option>
            						<option value="form">Based on the set form date (+30days)</option>
            						<option value="none">No follow up date</option>
            						<option value="manual" selected>Manual (update follow-up date)</option>
                             <?php } ?>
        				</select>
        				<input hidden id="selector_disabled" name="follow_up_type" value="none" disabled/>
        			</td>
            		<td><label for="follow_up_date"> Follow Up Date: </label></td>
            		<td>
						<?php if ($interaction->getFollowUpDate() == 0){ ?>
						   	<input type="date" id="follow_up_date" name="follow_up_date" value="" readonly />
            				<input hidden type="date" id="set_date" value="<?php echo date_format($followDate,"Y-m-d"); ?>" disabled>
						<?php } else { ?>
						    <input type="date" id="follow_up_date" name="follow_up_date" value="<?php echo $interaction->getFollowUpDate(); ?>" readonly />
            				<input hidden type="date" id="set_date" value="<?php echo date_format($followDate,"Y-m-d"); ?>" disabled>
						<?php }?>
					</td>
    			</tr>
    			<tr>
    				<td colspan=6><textarea maxlength="1024" name="comments" rows="20" cols="100" required><?php echo $interaction->getComments(); ?></textarea></td>
    			</tr>
    		</table>
    		<input hidden name="interaction_id" value="<?php echo $interaction->getInteractionId();?>" />
    		<input type="submit" name="submit" value="Submit">
    	</form>
    </body>
</html>