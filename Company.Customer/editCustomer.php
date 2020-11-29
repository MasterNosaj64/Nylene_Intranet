<?php
/*
 * FileName: editCustomer.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Date Modified: 11/29/2020
 * Purpose:
 * Edit customers in the database.
 */
session_start();

// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';
// customer object
include '../Database/Customer.php';

// Check the following, if these are not set redirect user to viewCompany
if ($_SESSION['company_id'] = ! "" && ! isset($_POST['customer_id'])) {

    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/viewCompany.php\" />;";
    exit();
}

$conn_Customer = getDBConnection();

// Handler for if the database connection fails
if ($conn_Customer->connect_error) {
    die("Connection failed: " . $conn_Customer->connect_error);
}

$_SESSION['customer_created'] = $_SESSION['company_id'];

$customer_id = $_POST['customer_id'];

$customerToEdit = new Customer($conn_Customer);

$customerToEdit = $customerToEdit->searchById($customer_id);

if (!$customerToEdit) {
    die("Company data corrupt or connection failed, OPPERATION ABORTED");
} // else didn't find something

/*
 * The following code handles editing a customer in the customer table
 * Below is an explaination of some of the variables
 * submit: set to 1 when the submit button is pressed
 *
 */

if (isset($_POST['submit'])) {

    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['firstName'] . " " . $_POST['lastName'];
    $customer_email = $_POST['customer_email'];
    $customer_phone = $_POST['customer_phone'];
    $customer_fax = $_POST['customer_fax'];

    $conn_Customer = getDBConnection();
    
    // Handler for if the database connection fails
    if ($conn_Customer->connect_error) {
        die("Connection failed: " . $conn_Customer->connect_error);
    }
    
    
    // Get object
    $customerToEdit = new Customer($conn_Customer);

    $findCustomerToEdit = $customerToEdit->searchExact($customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax);

    // if found something
    if ($findCustomerToEdit->fetch()) {
        echo "<p style=\"color:red\"><b>ERROR - Data entered for \"" . $customerToEdit->getName() . "\" already exists, OPERATION ABORTED</b></p>";

        // close connection and statement
        $conn_Customer->close();
        $findCustomerToEdit->close();
    } else {
        // else didn't find something
        $conn_Customer->close();
        $findCustomerToEdit->close();

        $conn_Customer = getDBConnection();

        if ($conn_Customer->connect_error) {
            die("Connection failed: " . $conn_Customer->connect_error);
        }

        $customerToEdit = new Customer($conn_Customer);

        
        if (! $findCustomerToEdit = $customerToEdit->update($customer_id, $customer_name, $customer_email, $customer_phone, $customer_fax)) {
            die("Company data corrupt or connection failed, OPPERATION ABORTED");
        }

        echo "<meta http-equiv = \"refresh\" content = \"0; url = ./viewCompany.php?sort=1\" />;";
        exit();
    }
    
    
}

$customer_name = explode(" ",$customerToEdit->getName());

?>

<html>
<head>
<title>Edit Customer</title>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<!-- Edit Customer Page -->
<!-- The following is the edit customer interface -->

<body>
	<form method="post" action=editCustomer.php name="edit_customer">
		<input type="reset" value="Clear"> <input hidden name="customer_id"
			value="<?php echo $customerToEdit->getCustomerId();?>" />
		<table class="form-table" border=5>
			<tr>
				<td colspan=4><h2>Customer</h2></td>
			</tr>
			<tr>
				<td>*First Name:</td>
				<td><input type="text" value="<?php echo $customer_name[0];?>" required
					name="firstName"></td>
				<td>*Last Name:</td>
				<td><input type="text" value="<?php echo $customer_name[1];?>" required
					name="lastName"></td>
			</tr>
			<tr>
				<td>*Email:</td>
				<td><input type="email"
					value="<?php echo $customerToEdit->getEmail();?>" required
					name="customer_email"></td>
				<td>Phone:</td>
				<td><input type="tel"
					value="<?php echo $customerToEdit->getPhone();?>" name="customer_phone"></td>
			</tr>
			<tr>
				<td>Fax:</td>
				<td colspan=3><input type="tel"
					value="<?php echo $customerToEdit->getFax();?>" name="customer_fax"></td>

			</tr>

		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>
