<?php
/*
 * FileName: addCompany.php
 * Version Number: 1.00
 * Author: Jason Waid
 * Date Modified: 11/29/2020
 * Purpose:
 * Add companies in the database.
 */
session_start();

// the following variables are used in navigation.php
// View navigation.php for more information
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';

// Company object
include '../Database/Company.php';

// Handler for if the database connection fails

/*
 * The following code handles adding a company to the company table
 * Below is an explaination of some of the variables
 * submit: set to 1 when the submit button is pressed
 * shippingsameasbilling: set to 1 when the user checks off the Shipping Same As Billing Box
 *
 */
if (isset($_POST['submit'])) {

    $conn_verification = getDBConnection();

    if ($conn_verification->connect_error)
        die("Connection failed: " . $conn_verification->connect_error);

    if (isset($_POST['shippingSameAsBilling'])) {

        $_POST['shippingStreet'] = $_POST['billingStreet'];
        $_POST['shippingCity'] = $_POST['billingCity'];
        $_POST['shippingState'] = $_POST['billingState'];
        $_POST['shippingPostalCode'] = $_POST['billingPostalCode'];
        $_POST['shippingCountry'] = $_POST['billingCountry'];
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

    $validateCompany = new Company($conn_verification);
    $validateCompany = $validateCompany->searchExact($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email); // found an entry with this company name
    $conn_verification->close();
    if ($validateCompany != NULL) {
        echo "<p style=\"color:red\"><b>ERROR - Data entered for \"" . $_POST['name'] . "\" already exists, OPERATION ABORTED</b></p>";
    } else {

        $conn_newCompany = getDBConnection();
        $newCompany = new Company($conn_newCompany);

        $newCompanyResult = $newCompany->create($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $_SESSION["userid"], date("Y-m-d", time()), $_SESSION["userid"]);

        if (! $newCompanyResult) {
            die("OPPERATION FAILED");
        }

        // store company_id in session for further use then redirect user to next page
        $_SESSION["company_id"] = $conn_newCompany->insert_id;
        $conn_newCompany->close();
        echo "<meta http-equiv = \"refresh\" content = \"0 url = ./viewCompany.php?sort=1\" />;";
        exit();
    }
}
else{
    $company_name = "";
    $website = "http://";
    $billing_address_street = "";
    $billing_address_city = "";
    $billing_address_state = "";
    $billing_address_postalcode = "";
    $billing_address_country = "";
    $shipping_address_street = "";
    $shipping_address_city = "";
    $shipping_address_state = "";
    $shipping_address_postalcode = "";
    $shipping_address_country = "";
    $description = "";
    $type = "";
    $industry = "";
    $company_email = "";
}
?>




<!-- Add Company Page -->
<!-- The following is the Add company interface -->
<html>
<head>
<title>Add Company</title>
<link rel="stylesheet" href="../CSS/form.css">
</head>
<body>
	<form method="post" action=addCompany.php name="add_company">
		<input type="reset" value="Clear">
		<table class="form-table" border=1>
			<thead>
				<tr>
					<td colspan=2><h2>Company</h2></td>
					<td colspan=2><h2>Description</h2></td>
				</tr>
			</thead>
			<tr>
				<td>*Name:</td>
				<td><input type="text" value="<?php echo $company_name;?>" required name="name"></td>
				<td>Note:</td>
				<td><textarea name="description" rows=3><?php echo $description;?></textarea></td>
			</tr>
			<tr>
				<td>*Website:</td>
				<td><input type="url" required value="<?php echo $website;?>" name="website"></td>
				<td>Industry:</td>
				<td><input type="text" value="<?php echo $industry;?>" name="industry"></td>
			</tr>
			<tr>
				<td>Company Email:</td>
				<td><input type="email" value="<?php echo $company_email;?>" name="email"></td>
				<td>Type:</td>
				<td><input type="text" value="<?php echo $type;?>" name="type"></td>
			</tr>
			<thead>
				<tr>
					<td colspan=2><h2>Billing Address</h2></td>
					<td colspan=2><h2>Shipping Address</h2>Same as billing address<input
						type="checkbox" id="shippingSameAsBilling"
						name="shippingSameAsBilling"></td>
				</tr>
			</thead>
			<tr>
				<td>*Street:</td>
				<td><input type="text" required value="<?php echo $billing_address_street;?>" name="billingStreet"></td>
				<td>Street:</td>
				<td><input type="text" value="<?php echo $shipping_address_street;?>" name="shippingStreet"></td>
			</tr>
			<tr>
				<td>*City:</td>
				<td><input type="text" required value="<?php echo $billing_address_city;?>" name="billingCity"></td>
				<td>City:</td>
				<td><input type="text" value="<?php echo $shipping_address_city;?>" name="shippingCity"></td>
			</tr>
			<tr>
				<td>*State:</td>
				<td><input type="text" required value="<?php echo $billing_address_state;?>" name="billingState"></td>
				<td>State:</td>
				<td><input type="text" value="<?php echo $shipping_address_state;?>" name="shippingState"></td>
			</tr>
			<tr>
				<td>*Postal Code:</td>
				<td><input type="text" required value="<?php echo $billing_address_postalcode;?>" name="billingPostalCode"></td>
				<td>Postal Code:</td>
				<td><input type="text" value="<?php echo $shipping_address_postalcode;?>" name="shippingPostalCode"></td>
			</tr>
			<tr>
				<td>*Country:</td>
				<td><input type="text" required value="<?php echo $billing_address_country;?>" name="billingCountry"></td>
				<td>Country:</td>
				<td><input type="text"  value="<?php echo $shipping_address_country;?>" name="shippingCountry"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>