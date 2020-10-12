<?php
/*
 * FileName: addCompany.php
 * Version Number: 0.81
 * Author: Jason Waid
 * Date Modified: 10/09/2020
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

    $validateCompany = new Company($conn_verification);
    $validationResult = $validateCompany->search($_POST['name'], $_POST['website'], $_POST['billingStreet'], $_POST['billingCity'], $_POST['billingState'], $_POST['billingCountry'], "", "");
    // found an entry with this company name
    if ($validationResult->fetch()) {
        /* echo "<script>alert(\"This company data already exists\");</script>"; */
        echo "<p style=\"color:red\"><b>ERROR - Data entered for \"" . $_POST['name'] . "\" already exists, OPERATION ABORTED</b></p>";
       
    } else {

        $conn_verification->close();
        $validationResult->close();
       
        $conn_newCompany = getDBConnection();
        $newCompany = new Company($conn_newCompany);
        
        $newCompanyResult = $newCompany->create($_POST['name'], $_POST['website'], $_POST['billingStreet'], $_POST['billingCity'], $_POST['billingState'], $_POST['billingPostalCode'], $_POST['billingCountry'],$_POST['billingStreet'], $_POST['shippingCity'], $_POST['shippingState'], $_POST['shippingPostalCode'], $_POST['shippingCountry'], $_POST['description'], $_POST['type'], $_POST['industry'], $_POST['email'], $_SESSION["userid"], date("Y-m-d", time()), $_SESSION["userid"]);
        
        if(!$newCompanyResult){
            die("OPPERATION FAILED");
        }
   
        
        // store company_id in session for further use then redirect user to next page
        $_SESSION["company_id"] = $conn_newCompany->insert_id;
        $conn_newCompany->close();
        echo "<meta http-equiv = \"refresh\" content = \"5 url = ./addCustomer.php\" />;";
        exit();
    }
    $conn_verification->close();
    $validationResult->close();
}

?>




<!-- Add Company Page -->
<!-- The following is the Add company interface -->
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<body>
	<form method="post" action=addCompany.php name="add_company">
		<input type="reset" value="Clear">
		<table class="form-table" border=5>
			<tr>
				<td colspan=2><h2>Company</h2></td>
				<td colspan=2><h2>Description</h2></td>
			</tr>
			<tr>
				<td>*Name:</td>
				<td><input type="text" required name="name"></td>
				<td>Note:</td>
				<td><textarea name="description" rows=3></textarea></td>
			</tr>
			<tr>
				<td>*Website:</td>
				<td><input type="url" required value="http://" name="website"></td>
				<td>Industry:</td>
				<td><input type="text" name="industry"></td>
			</tr>
			<tr>
				<td>Company Email:</td>
				<td><input type="email" name="email"></td>
				<td>Type:</td>
				<td><input type="text" name="type"></td>
			</tr>
			<tr>
				<td colspan=2><h2>Billing Address</h2></td>
				<td colspan=2><h2>Shipping Address</h2>Same as billing address<input
					type="checkbox" id="shippingSameAsBilling"
					name="shippingSameAsBilling"></td>
			</tr>
			<tr>
				<td>*Street:</td>
				<td><input type="text" required name="billingStreet"></td>
				<td>Street:</td>
				<td><input type="text" name="shippingStreet"></td>
			</tr>
			<tr>
				<td>*City:</td>
				<td><input type="text" required name="billingCity"></td>
				<td>City:</td>
				<td><input type="text" name="shippingCity"></td>
			</tr>
			<tr>
				<td>*State:</td>
				<td><input type="text" required name="billingState"></td>
				<td>State:</td>
				<td><input type="text" name="shippingState"></td>
			</tr>
			<tr>
				<td>*Postal Code:</td>
				<td><input type="text" required name="billingPostalCode"></td>
				<td>Postal Code:</td>
				<td><input type="text" name="shippingPostalCode"></td>
			</tr>
			<tr>
				<td>*Country:</td>
				<td><input type="text" required name="billingCountry"></td>
				<td>Country:</td>
				<td><input type="text" name="shippingCountry"></td>
			</tr>
		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>