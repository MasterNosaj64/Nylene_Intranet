<?php
/*
 * FileName: editCompany.php
 * Version Number: 1.0
 * Author: Jason Waid
 * Date Modified: 11/29/2020
 * Purpose:
 * Edit companies in the database.
 */
session_start();

// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';

include '../Database/Company.php';

if (isset($_POST['company_id_edit'])) {

    $conn_editCompany = getDBConnection();
    // Handler for if the database connection fails
    if ($conn_editCompany->connect_error) {
        die("Connection failed: " . $conn_editCompany->connect_error);
    }

    // Stores Company_id for future use in the session
    $_SESSION['company_id'] = $_POST['company_id_edit'];

    $companyToEdit = new Company($conn_editCompany);

    // attempt to get company data for editing
    if (! $companyToEdit = $companyToEdit->searchId($_SESSION['company_id'])) {

        die("Company data corrupt, OPPERATION ABORTED");
    }

    $conn_editCompany->close();
} else {

    /*
     * The following code handles editing a company in the company table
     * Below is an explaination of some of the variables
     * submit: set to 1 when the submit button is pressed
     * shippingsameasbilling: set to 1 when the user checks off the Shipping Same As Billing Box
     *
     */

    if (isset($_POST['submit'])) {

        if (isset($_POST['shippingSameAsBilling'])) {

            $_POST['shippingStreet'] = $_POST['billingStreet'];
            $_POST['shippingCity'] = $_POST['billingCity'];
            $_POST['shippingState'] = $_POST['billingState'];
            $_POST['shippingPostalCode'] = $_POST['billingPostalCode'];
            $_POST['shippingCountry'] = $_POST['billingCountry'];
        }

        $conn_editCompany = getDBConnection();
        // Handler for if the database connection fails
        if ($conn_editCompany->connect_error) {
            die("Connection failed: " . $conn_editCompany->connect_error);
        }

        $company_name = $_POST['name'];
        $website = $_POST['website'];
        $billing_address_street = $_POST['billingStreet'];
        $billing_address_city = $_POST['billingCity'];
        $billing_address_state = $_POST['billingState'];
        $billing_address_postalcode = $_POST['billingPostalCode'];
        $billing_address_country = $_POST['billingCountry'];
        $shipping_address_street = $_POST['shippingStreet'];
        $shipping_address_city = $_POST['shippingCity'];
        $shipping_address_state = $_POST['shippingState'];
        $shipping_address_postalcode = $_POST['shippingPostalCode'];
        $shipping_address_country = $_POST['shippingCountry'];
        $description = $_POST['description'];
        $type = $_POST['type'];
        $industry = $_POST['industry'];
        $company_email = $_POST['email'];
        $company_id = $_SESSION['company_id'];

        // Check if all entered values already exist for a company
        $companyToEdit = new Company($conn_editCompany);
        $companyToEdit = $companyToEdit->searchExact($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email);
        
        // attempt to find company with same values
        if ($companyToEdit == NULL) {
            $conn_editCompany = getDBConnection();

            if ($conn_editCompany->connect_error) {
                die("Connection failed: " . $conn_editCompany->connect_error);
            }

            // create object
            $companyToEdit = new Company($conn_editCompany);

            // attempt edit
            if (! $companyToEdit = $companyToEdit->update($company_id, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, date("Y-m-d", time()))) {
                die("Company data corrupt or connection failed, OPPERATION ABORTED");
            }


            // send user to viewCompany page
            echo "<meta http-equiv = \"refresh\" content = \"0 url = ./viewCompany.php?sort=1\" />;";
            exit();
        } else {
            echo "<p style=\"color:red\"><b>ERROR - Data entered for \"" . $company_name . "\" already exists, OPERATION ABORTED</b></p>";

            $companyToEdit = new Company($conn_editCompany);

            // attempt to get company data for editing
            if (! $companyToEdit = $companyToEdit->searchId($_SESSION['company_id'])) {

                die("Company data corrupt, OPPERATION ABORTED");
            }
        }
    } else {
        // send back to home page since user should not be here yet
        echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/homePage.php\" />;";
        exit();
    }
    $conn_editCompany->close();
}
?>


<!-- Edit Company Page -->
<!-- The following is the edit company interface -->
<html>
<head>
<title>Edit Company</title>
<link rel="stylesheet" href="../CSS/company.customer.interaction.css">
</head>
<body>
	<form method="post" action=editCompany.php name="edit_company" autocomplete="off">
		<input type="reset" value="Clear"> <input type="text" hidden="true"
			name="company_id"
			value="<?php echo $companyToEdit->getCompanyId();?>" />
		<table class="form-table" border='1'>
			<thead>
				<tr>
					<th colspan=2><h2>Company</h2></th>
					<th colspan=2><h2>Description</h2></th>
				</tr>
			</thead>
			<tr>
				<td>*Name:</td>
				<td><input type="text" required name="name"
					value="<?php echo $companyToEdit->getName();?>"></td>
				<td>Note:</td>
				<td><textarea name="description" rows=3><?php echo $companyToEdit->getDescription();?></textarea></td>
			</tr>
			<tr>
				<td>*Website:</td>
				<td><input type="url" required
					value="<?php echo $companyToEdit->getWebsite();?>" name="website"></td>
				<td>Industry:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getIndustry();?>" name="industry"></td>
			</tr>
			<tr>
				<td>Company Email:</td>
				<td><input type="email"
					value="<?php echo $companyToEdit->getEmail();?>" name="email"></td>
				<td>Type:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getType();?>" name="type"></td>
			</tr>
			<thead>
				<tr>
					<th colspan=2><h2>Billing Address</h2></th>
					<th colspan=2><h2>Shipping Address</h2>Same as billing address<input
						type="checkbox" id="shippingSameAsBilling"
						name="shippingSameAsBilling"></th>
				</tr>
			</thead>
			<tr>
				<td>*Street:</td>
				<td><input type="text" required
					value="<?php echo $companyToEdit->getBillingAddressStreet();?>"
					name="billingStreet"></td>
				<td>Street:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getShippingAddressStreet();?>"
					name="shippingStreet"></td>
			</tr>
			<tr>
				<td>*City:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getBillingAddressCity();?>"
					required name="billingCity"></td>
				<td>City:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getShippingAddressCity();?>"
					name="shippingCity"></td>
			</tr>
			<tr>
				<td>*State:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getBillingAddressState();?>"
					required name="billingState"></td>
				<td>State:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getShippingAddressState();?>"
					name="shippingState"></td>
			</tr>
			<tr>
				<td>*Postal Code:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getBillingAddressPostalCode();?>"
					required name="billingPostalCode"></td>
				<td>Postal Code:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getShippingAddressPostalCode();?>"
					name="shippingPostalCode"></td>
			</tr>
			<tr>
				<td>*Country:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getBillingAddressCountry();?>"
					required name="billingCountry"></td>
				<td>Country:</td>
				<td><input type="text"
					value="<?php echo $companyToEdit->getShippingAddressCountry();?>"
					name="shippingCountry"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>
