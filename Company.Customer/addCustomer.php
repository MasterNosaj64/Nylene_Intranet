<?php
/*
 * FileName: addCustomer.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 * Add customers in the database.
 */
session_start();
// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';

include '../Database/Customer.php';

/*
 * The following code handles adding a customer in the customer table
 * Below is an explaination of some of the variables
 * submit: set to 1 when the submit button is pressed
 *
 */

if (isset($_SESSION['company_id'])) {
    $_SESSION['customer_created'] = $_SESSION['company_id'];

    
    if ($_SESSION['company_id'] != "" && isset($_POST['submit'])) {

        $conn_Customer = getDBConnection();
        
        // Handler for if the database connection fails
        if ($conn_Customer->connect_error) {
            die("Connection failed: " . $conn_Customer->connect_error);
        }
        
        
        $newCustomer = new Customer($conn_Customer);
        
        $newCustomerResult = $newCustomer->create($_POST['firstName'] . " " . $_POST['lastName'], $_POST['email'], date("Y-m-d", time()), $_POST['phone'], $_POST['fax']);
        
        if(!$newCustomerResult){
            die("Adding Customer failed, OPPERATION ABORTED");
        }
        
        $customer_id = $conn_Customer->insert_id;

        $conn_Relational = getDBConnection();
        
        $sqlRelationQuery = $conn_Relational->prepare("INSERT INTO nylene.company_relational_customer 
            (company_id, 
            customer_id)

            VALUES (?,?)");

        $company_id = $_SESSION['company_id'];
        

        $sqlRelationQuery->bind_param("ii", $company_id, $customer_id);

        $sqlRelationQuery->execute();

        $sqlRelationQuery->close();
        $conn_Customer->close();
        $conn_Relational->close();

        echo "<meta http-equiv = \"refresh\" content = \"0 url = ./viewCompany.php\" />;";
        exit();
    }
} else {
    echo "<meta http-equiv = \"refresh\" content = \"0 url = ./Homepage.php\" />;";
    exit();
}
?>

<!-- Add Customer Page -->
<!-- The following is the add customer interface -->

<html>
<head>
<title>Add Customer</title>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<body>
	<form method="post" action=addCustomer.php name="add_customer">
		<input type="reset" value="Clear">
		<table class="form-table" border=5>
			<tr>
				<td colspan=4><h2>Customer</h2></td>
			</tr>
			<tr>
				<td>*First Name:</td>
				<td><input type="text" required name="firstName"></td>
				<td>*Last Name:</td>
				<td><input type="text" required name="lastName"></td>
			</tr>
			<tr>
				<td>*Email:</td>
				<td><input type="email" required name="email"></td>
				<td>Phone:</td>
				<td><input type="tel" name="phone"></td>
			</tr>
			<tr>
				<td>Fax:</td>
				<td colspan=3><input type="tel" name="fax"></td>
			</tr>

		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>
