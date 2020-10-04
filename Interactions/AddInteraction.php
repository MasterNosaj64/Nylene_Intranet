<?php
session_start();
$_SESSION["navToAddInteractionPage"] = true;
include '../navigation.php';
/*
 * include '../Database/databaseConnection.php';
 * $dbConnection = setConnectionInfo();
 */
include '../Database/connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if ($_POST['company_id'] != "") {

        $_SESSION['company_id'] = $_POST['company_id'];

        if (isset($_POST['submit'])) {
            /*
             * NO SQL INJECTION PROTECTION
             *
             * $insertInteractionQuery = "INSERT INTO nylene.interaction
             * (company_id,
             * customer_id,
             * employee_id,
             * reason,
             * comments,
             * date_created)
             *
             * VALUES ('" . $_POST['company_id'] . "',
             * '" . $_POST['customer_id'] . "',
             * '" . $_SESSION['userid'] . "',
             * '" . $_POST['reason'] . "',
             * '" . $_POST['comments'] . "',
             * '" . date("Y-m-d", $t) . "') ";
             * /* $dbConnection->query($insertInteractionQuery);
             * $conn->query($insertInteractionQuery);
             */

            // SQL INJECTION PROTECTION
            $insertInteractionQuery = $conn->prepare("INSERT INTO nylene.interaction 
            (company_id, 
            customer_id, 
            employee_id, 
            reason, 
            comments, 
            date_created) 

            VALUES (?,?,?,?,?,?)");
    
            $company_id = $_POST['company_id'];
            $customer_id = $_POST['customer_id'];
            $employee_id = $_SESSION['userid'];
            $reason = $_POST['reason'];
            $comments = $_POST['comments'];
            
            $t = time();
            $date_created = date("Y-m-d", $t);
            
            $insertInteractionQuery->bind_param("iiisss", $company_id, $customer_id, $employee_id, $reason, $comments, $date_created);

            $insertInteractionQuery->execute();

            // store customer id into session for use in forms
            $_SESSION['customer_id'] = $_POST['customer_id'];
            // store interaction_id into session for use in forms
            $_SESSION['interaction_id'] = $conn->insert_id;

            // if form selected, redirect to the appropriate form creation page
            // Sample Form
            if ($_POST['form'] == 1) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/sample.php\" />;";
                exit();
            } // Light Truckload Quote Form
            else if ($_POST['form'] == 2) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/ltlQuoteForm.php\" />;";
                exit();
            } // Truckload Quote Form
            else if ($_POST['form'] == 3) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/tlQuoteForm.php\" />;";
                exit();
            } // Distributor Quote Form
            else if ($_POST['form'] == 4) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/distributorQuoteForm.php\" />;";
                exit();
            } // Marketing Request Form
            else if ($_POST['form'] == 5) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/newMarketRequest.php\" />;";
                exit();
            } // Business Credit Application Forn
            else if ($_POST['form'] == 6) {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Forms/newCreditBusinessApplication.php\" />;";
                exit();
            } else {

                echo "<meta http-equiv = \"refresh\" content = \"0 url = ./companyHistory.php\" />;";
                exit();
            }
        } else {

            // Get customers ID's ready for form
            $customerQuery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = " . $_POST['company_id'];
            /* $customerIds = $dbConnection->query($customerQuery); */
            $customerIds = $conn->query($customerQuery);
            // Get companyData ready for form
            $getCompanyDataQuery = "SELECT * FROM nylene.company WHERE company_id = " . $_POST['company_id'];
            /* $viewCompanyData = $dbConnection->query($getCompanyDataQuery)->fetch(PDO::FETCH_ASSOC); */
            $viewCompanyData = mysqli_fetch_array($conn->query($getCompanyDataQuery));
            // Build company address into string
            $companyAddress = $viewCompanyData["billing_address_street"] . ", " . $viewCompanyData["billing_address_city"] . ", " . $viewCompanyData["billing_address_state"] . ", " . $viewCompanyData["billing_address_country"] . ", " . $viewCompanyData["billing_address_postalcode"];
        }
    } else {
        echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/Homepage.php\" />;";
        exit();
    }
}
?>

<html>
<link rel="stylesheet" href="../CSS/table.css">
<body>
	<!-- <h1>Interaction</h1> -->

	<form method="post" action=AddInteraction.php name="add_interaction">
		<input type="reset" value="Clear">
		<table class="form-table" border=5>
			<tr>
				<td>Company:</td>
				<td><?php echo $viewCompanyData['company_name'];?></td>
				<td>Address:</td>
				<td><?php echo $companyAddress;?></td>
				<td>Company Email:</td>
				<td><a href="mailto:<?php echo $viewCompanyData['company_email'];?>"><?php echo $viewCompanyData['company_email'];?></a></td>
			</tr>
			<tr>
				<td>Customer:</td>
				<td><select id="selection" required name="customer_id">
						<option></option>
		<?php

while ($id = mysqli_fetch_array($customerIds)) {
    $getCustomerData = "SELECT * FROM nylene.customer WHERE customer_id = " . $id["customer_id"];
    /* $customerData = $dbConnection->query($getCustomerData)->fetch(PDO::FETCH_ASSOC); */
    $customerData = mysqli_fetch_array($conn->query($getCustomerData));
    echo "<option value=\"" . $customerData['customer_id'] . "\">" . $customerData['customer_name'] . "</option>";
}
$conn->close();
?>
		</select></td>
				<td>Reason:</td>
				<td><select id="selection" required name="reason">
						<option></option>
						<option value="Update">Update</option>
						<option value="General">General</option>
						<option value="Added Customer">Added Customer</option>
						<option value="Status">Status</option>
						<option value="Marketing Request">Marketing Request</option>
						<option value="Distributor Quote">Distributor Quote</option>
						<option value="Truckload Quote">Truckload Quote</option>
						<option value="Light Truckload Quote">Light Truckload Quote</option>
						<option value="Sample">Sample Request</option>
						<option value="Credit Business Application">Business Credit Application</option>
				</select></td>
				<td>Form (if applicable):</td>
				<td><select id="selection" required name="form">
						<option value="0"></option>
						<option value="6">Credit Business Application</option>
						<option value="5">Marketing Request</option>
						<option value="4">Distributor Quote</option>
						<option value="3">Truckload Quote</option>
						<option value="2">Light Truckload Quote</option>
						<option value="1">Sample Request</option>
				</select></td>
			
			
			<tr>
				<td colspan=6><textarea maxlength="1024" required name="comments"
						rows="20" cols="100"></textarea></td>
			</tr>
		</table>
		<input hidden name="company_id"
			value="<?php echo $viewCompanyData['company_id'];?>" /> <input
			type="submit" name="submit" value="Submit">
	</form>
</body>
</html>