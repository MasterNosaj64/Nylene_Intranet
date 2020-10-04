<?php
/*
 * FileName: editCompany.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 *  Edit companies in the database.
 */
session_start();

//The navigation bar for the website
include '../navigation.php';
//connection to the database
include '../Database/connect.php';

//Handler for if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if (isset($_POST['company_id_edit'])) {
        $_SESSION['company_id'] = $_POST['company_id_edit'];

        // get company data for editing
        $getCompanyDataSQL = "SELECT * FROM nylene.company WHERE company_id = '" . $_SESSION['company_id'] . "'";
        $companyData = $conn->query($getCompanyDataSQL);
        $data = mysqli_fetch_array($companyData);
    } else {
            
        /*
         * The following code handles editing a company in the company table
         * Below is an explaination of some of the variables
         *      submit: set to 1 when the submit button is pressed
         *      shippingsameasbilling: set to 1 when the user checks off the Shipping Same As Billing Box
         *
         */
        
        if (isset($_POST['name'])) {

            if (isset($_POST['shippingSameAsBilling'])) {

                $_POST['shippingStreet'] = $_POST['billingStreet'];
                $_POST['shippingCity'] = $_POST['billingCity'];
                $_POST['shippingState'] = $_POST['billingState'];
                $_POST['shippingPostalCode'] = $_POST['billingPostalCode'];
                $_POST['shippingCountry'] = $_POST['billingCountry'];
            }

            // check if company was already added
            $validateCompanyQuery = "SELECT * FROM nylene.company WHERE company_name = '" . $_POST['name'] . "'";
            $validationResult = $conn->query($validateCompanyQuery);

            // if it doesn't exist, add it to the database
            if (mysqli_fetch_array($validationResult) == NULL) {

                /*
                 * // Unprepared SQL
                 * /*
                 * $sqlQuery = "UPDATE nylene.company
                 *
                 * SET
                 * company_name = '" . $_POST['name'] . "',
                 * website = '" . $_POST['website'] . "',
                 * billing_address_street = '" . $_POST['billingStreet'] . "',
                 * billing_address_city = '" . $_POST['billingCity'] . "',
                 * billing_address_state = '" . $_POST['billingState'] . "',
                 * billing_address_postalcode = '" . $_POST['billingPostalCode'] . "',
                 * billing_address_country = '" . $_POST['billingCountry'] . "',
                 * shipping_address_street = '" . $_POST['shippingStreet'] . "',
                 * shipping_address_city = '" . $_POST['shippingCity'] . "',
                 * shipping_address_state = '" . $_POST['shippingState'] . "',
                 * shipping_address_postalcode = '" . $_POST['shippingPostalCode'] . "',
                 * shipping_address_country = '" . $_POST['shippingCountry'] . "',
                 * description = '" . $_POST['description'] . "',
                 * type = '" . $_POST['type'] . "',
                 * industry = '" . $_POST['industry'] . "',
                 * company_email = '" . $_POST['email'] . "'
                 * WHERE company_id = " . $_SESSION['company_id'];
                 *
                 * $result = $conn->query($sqlQuery);
                 */

                // Prepared SQL
                $sqlQuery = $conn->prepare("UPDATE nylene.company
                    
                    SET
                    company_name = ?,
                    website = ?,
                    billing_address_street = ?,
                    billing_address_city = ?,
                    billing_address_state = ?,
                    billing_address_postalcode = ?,
                    billing_address_country = ?,
                    shipping_address_street = ?,
                    shipping_address_city = ?,
                    shipping_address_state = ?,
                    shipping_address_postalcode = ?,
                    shipping_address_country = ?,
                    description = ?,
                    type = ?,
                    industry = ?,
                    company_email = ?
                    WHERE company_id = ?");

                
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
                
                $sqlQuery->bind_param("ssssssssssssssssi", $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $company_id);
                
                $sqlQuery->execute();

                $conn->close();
                $sqlQuery->close();

                $_SESSION['company_id'] == "";
                echo "<meta http-equiv = \"refresh\" content = \"0 url = ./searchCompany.php\" />;";
                exit();
            } else {
                // set boolean to trigger error message
                echo "<p style=\"color:red\">ERROR - Company name \"" . $_POST['name'] . "\" ALREADY EXISTS</p>";
                $getCompanyDataSQL = "SELECT * FROM nylene.company WHERE company_id = '" . $_SESSION['company_id'] . "'";

                $companyData = $conn->query($getCompanyDataSQL);
                $data = mysqli_fetch_array($companyData);
                $conn->close();
            }
        } else {
            echo "<meta http-equiv = \"refresh\" content = \"0 url = ./searchCompany.php\" />;";
            exit();
        }
    }
}
?>


<!-- Edit Company Page -->
<!-- The following is the edit company interface -->
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<body>
	<form method="post" action=editCompany.php name="edit_company">
		<input type="reset" value="Clear"> <input type="text" hidden
			name="company_id" value="<?php echo $data['company_id'];?>" />
		<table class="form-table" border=5>
			<tr>
				<td colspan=2><h2>Company</h2></td>
				<td colspan=2><h2>Description</h2></td>
			</tr>
			<tr>
				<td>*Name:</td>
				<td><input type="text" required name="name"
					value="<?php echo $data['company_name'];?>"></td>
				<td>Note:</td>
				<td><textarea name="description" rows=3
						value="<?php echo $data['description'];?>"></textarea></td>
			</tr>
			<tr>
				<td>*Website:</td>
				<td><input type="url" required
					value="<?php echo $data['website'];?>" name="website"></td>
				<td>Industry:</td>
				<td><input type="text" value="<?php echo $data['industry'];?>"
					name="industry"></td>
			</tr>
			<tr>
				<td>Company Email:</td>
				<td><input type="email" value="<?php echo $data['company_email'];?>"
					name="email"></td>
				<td>Type:</td>
				<td><input type="text" value="<?php echo $data['type'];?>"
					name="type"></td>
			</tr>
			<tr>
				<td colspan=2><h2>Billing Address</h2></td>
				<td colspan=2><h2>Shipping Address</h2>Same as billing address<input
					type="checkbox" id="shippingSameAsBilling"
					name="shippingSameAsBilling"></td>
			</tr>
			<tr>
				<td>*Street:</td>
				<td><input type="text" required
					value="<?php echo $data['billing_address_street'];?>"
					name="billingStreet"></td>
				<td>Street:</td>
				<td><input type="text"
					value="<?php echo $data['shipping_address_street'];?>"
					name="shippingStreet"></td>
			</tr>
			<tr>
				<td>*City:</td>
				<td><input type="text"
					value="<?php echo $data['billing_address_city'];?>" required
					name="billingCity"></td>
				<td>City:</td>
				<td><input type="text"
					value="<?php echo $data['shipping_address_city'];?>"
					name="shippingCity"></td>
			</tr>
			<tr>
				<td>*State:</td>
				<td><input type="text"
					value="<?php echo $data['billing_address_state'];?>" required
					name="billingState"></td>
				<td>State:</td>
				<td><input type="text"
					value="<?php echo $data['shipping_address_state'];?>"
					name="shippingState"></td>
			</tr>
			<tr>
				<td>*Postal Code:</td>
				<td><input type="text"
					value="<?php echo $data['billing_address_postalcode'];?>" required
					name="billingPostalCode"></td>
				<td>Postal Code:</td>
				<td><input type="text"
					value="<?php echo $data['shipping_address_postalcode'];?>"
					name="shippingPostalCode"></td>
			</tr>
			<tr>
				<td>*Country:</td>
				<td><input type="text"
					value="<?php echo $data['billing_address_country'];?>" required
					name="billingCountry"></td>
				<td>Country:</td>
				<td><input type="text"
					value="<?php echo $data['shipping_address_country'];?>"
					name="shippingCountry"></td>
			</tr>
		</table>
		<input type="submit" value="Submit">
	</form>
</body>
</html>
