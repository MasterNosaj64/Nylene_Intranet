<?php
session_start();

unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

include 'navigation.php';
include 'databaseConnection.php';
$dbConnection = setConnectionInfo();



if (isset($_POST['submit'])) {

    if (isset($_POST['shippingSameAsBilling'])) {

        $_POST['shippingStreet'] = $_POST['billingStreet'];
        $_POST['shippingCity'] = $_POST['billingCity'];
        $_POST['shippingState'] = $_POST['billingState'];
        $_POST['shippingPostalCode'] = $_POST['billingPostalCode'];
        $_POST['shippingCountry'] = $_POST['billingCountry'];
    }

    // check if company was already added
    $validateCompanyQuery = "SELECT count(*) FROM nylene.company WHERE company_name = '".$_POST['name']."'";
    $validationResult = $dbConnection->query($validateCompanyQuery)->fetchColumn();

    //if it doesn't exist, add it to the database
    if ($validationResult == 0) {

        $t = time();
        // , assigned_to, date_created, created_by)
        $sqlQuery = "INSERT INTO nylene.company (company_name, website, billing_address_street, billing_address_city, billing_address_state, billing_address_postalcode, billing_address_country, shipping_address_street, shipping_address_city, shipping_address_state, shipping_address_postalcode, shipping_address_country, description, type, industry, company_email, date_created, created_by)
        VALUES ('" . $_POST['name'] . "','" . $_POST['website'] . "','" . $_POST['billingStreet'] . "','" . $_POST['billingCity'] . "','" . $_POST['billingState'] . "','" . $_POST['billingPostalCode'] . "','" . $_POST['billingCountry'] . "','" . $_POST['shippingStreet'] . "','" . $_POST['shippingCity'] . "','" . $_POST['shippingState'] . "','" . $_POST['shippingPostalCode'] . "','" . $_POST['shippingCountry'] . "','" . $_POST['description'] . "','" . $_POST['type'] . "','" . $_POST['industry'] . "','" . $_POST['email'] . "','" . date("Y-m-d", $t) . "','".$_SESSION['userid']."')"; // 16

        $result = $dbConnection->query($sqlQuery);
        $company_id = $dbConnection->lastInsertId();

        //store company_id in session for further use then redirect user to next page
        $_SESSION["company_id"] = $company_id;
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ./addCustomer.php\" />;";
        exit();

    } else {
        //set boolean to trigger error message
        //$validationBOOL = false;
        echo "<p style=\"color:red\">ERROR - \"" . $_POST['name'] . "\" ALREADY EXISTS</p>";
    }
//     if ($validationBOOL == false) {

//     }
}

?>


<html><head>
  <link rel="stylesheet" href="table.css">
</head>
<body>
	<form method="post" action=addCompany.php name="add_company">
		<input type="reset" value="Clear">
		<table class ="form-table" border=5>
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
