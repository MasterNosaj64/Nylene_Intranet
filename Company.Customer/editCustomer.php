<?php
/*
 * FileName: editCustomer.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 *  Edit customers in the database.
 */

session_start();

//The navigation bar for the website
include '../NavPanel/navigation.php';
//connection to the database
include '../Database/connect.php';

//Handler for if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    /*
     * The following code handles editing a customer in the customer table
     * Below is an explaination of some of the variables
     *      submit: set to 1 when the submit button is pressed
     *      
     */
    $_SESSION['customer_created'] = $_SESSION['company_id'];

    if (isset($_POST['submit'])) {

        // No SQL INJECTION PROTECTION
        /*
         * $sqlQuery = "UPDATE nylene.customer
         * SET
         * customer_name = '" . $_POST['firstName'] . " " . $_POST['lastName'] . "',
         * customer_email = '" . $_POST['email'] . "',
         * customer_phone = '" . $_POST['phone'] . "',
         * customer_fax = '" . $_POST['fax'] . "'
         * WHERE customer_id =" . $_POST['customer_id'];
         *
         * /* $result = $dbConnection->query($sqlQuery);
         * $result = $conn->query($sqlQuery);
         * $conn->close();
         */

        // SQL INJECTION PROTECTION
        $sqlQuery = $conn->prepare("UPDATE nylene.customer
            SET
            customer_name = ?,
            customer_email = ?,
            customer_phone = ?,
            customer_fax = ?
            WHERE customer_id = ?");

        $customer_name = $_POST['firstName'] . " " . $_POST['lastName'];
        $customer_email = $_POST['email'];
        $customer_phone = $_POST['phone'];
        $customer_fax = $_POST['fax'];
        $customer_id = $_POST['customer_id'];
        
        
        $sqlQuery->bind_param("ssssi", $customer_name, $customer_email, $customer_phone, $customer_fax, $customer_id);
        $sqlQuery->execute();
        $conn->close();
        $sqlQuery->close();

        echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php\" />;";
        exit();
    }

    if ($_SESSION['company_id'] != "" && isset($_POST['customer_id'])) {

        $sqlGetCustomerInfo = "SELECT * FROM nylene.customer WHERE customer_id = " . $_POST['customer_id'];
        $customerInfo = mysqli_fetch_array($conn->query($sqlGetCustomerInfo));
        $name = explode(" ", $customerInfo['customer_name']);
        $conn->close();
    } else {
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php\" />;";
        exit();
    }
}
?>

<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<!-- Edit Customer Page -->
<!-- The following is the edit customer interface -->

<body>
	<form method="post" action=editCustomer.php name="edit_customer">
		<input type="reset" value="Clear"> <input hidden name="customer_id"
			value="<?php echo $customerInfo['customer_id'];?>" />
		<table class="form-table" border=5>
			<tr>
				<td colspan=4><h2>Customer</h2></td>
			</tr>
			<tr>
				<td>*First Name:</td>
				<td><input type="text" value="<?php echo $name[0];?>" required
					name="firstName"></td>
				<td>*Last Name:</td>
				<td><input type="text" value="<?php echo $name[1];?>" required
					name="lastName"></td>
			</tr>
			<tr>
				<td>*Email:</td>
				<td><input type="email"
					value="<?php echo $customerInfo['customer_email'];?>" required
					name="email"></td>
				<td>Phone:</td>
				<td><input type="tel"
					value="<?php echo $customerInfo['customer_phone'];?>" name="phone"></td>
			</tr>
			<tr>
				<td>Fax:</td>
				<td colspan=3><input type="tel"
					value="<?php echo $customerInfo['customer_fax'];?>" name="fax"></td>

			</tr>

		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>
