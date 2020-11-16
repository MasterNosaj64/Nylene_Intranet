<?php
/*
 * FileName: addInteraction.php
 * Version Number: 0.81
 * Author: Jason Waid
 * Purpose:
 * Add companies in the database.
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
            
            //placeholder for now
            $status = "";
            $follow_up_type = "";
            $follow_up_date = "";

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
            $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCounty()}, {$company->getBillingAddressPostalCode()}";
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
<link rel="stylesheet" href="../CSS/table.css">
<body>
	<!-- <h1>Interaction</h1> -->

	<form method="post" action=AddInteraction.php name="add_interaction">
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
				<td><select id="selection" required name="reason">
						<option></option>
						<option value="Added Customer">Added Customer</option>
						<option value="Credit Business Application">Credit Business
							Application</option>
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
				<td><select id="selection" required name="form">
						<option value="0"></option>
						<option value="6">Credit Business Application</option>
						<option value="4">Distributor Quote</option>
						<option value="2">Light Truckload Quote</option>
						<option value="5">Marketing Request</option>
						<option value="1">Sample Request</option>
						<option value="3">Truckload Quote</option>
				</select></td>
			
			
			<tr>
				<td colspan=6><textarea maxlength="1024" required name="comments"
						rows="20" cols="100"></textarea></td>
			</tr>
		</table>
		<input hidden name="company_id"
			value="<?php echo $company->getCompanyId();?>" /> <input
			type="submit" name="submit" value="Submit">
	</form>
</body>
</html>