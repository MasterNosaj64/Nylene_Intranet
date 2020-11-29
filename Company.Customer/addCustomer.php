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

    if (isset($_POST['submit'])) {

        $customer_FirstName = $_POST['firstName'];
        $customer_LastName = $_POST['lastName'];
        $customer_email = $_POST['email'];
        $customer_phone = $_POST['phone'];
        $customer_fax = $_POST['fax'];

        $conn_Customer = getDBConnection();

        // Handler for if the database connection fails
        if ($conn_Customer->connect_error) {
            die("Connection failed: " . $conn_Customer->connect_error);
        }

        // check if customer data already exists
        $customerToAdd = new Customer($conn_Customer);
        $customerToAdd = $customerToAdd->searchExact($customer_FirstName." ".$customer_LastName, $customer_email, $customer_phone, $customer_fax);
        $conn_Customer->close();

        // if found something
        if ($customerToAdd != NULL) {

            echo "<p style=\"color:red\"><b>ERROR - Data entered for \"" . $customer_FirstName." ".$customer_LastName . "\" already exists, OPERATION ABORTED</b></p>";
        } else {

            $conn_Customer = getDBConnection();
            
            $newCustomer = new Customer($conn_Customer);

            $newCustomerResult = $newCustomer->create($customer_FirstName." ".$customer_LastName, $customer_email, date("Y-m-d", time()), $customer_phone, $customer_fax);

            if (! $newCustomerResult) {
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

            echo "<meta http-equiv = \"refresh\" content = \"0 url = ./viewCompany.php?sort=1\" />;";
            exit();
        }
    }else {
        
        $customer_FirstName = "";
        $customer_LastName = "";
        $customer_email = "";
        $customer_phone = "";
        $customer_fax = "";
        
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
<link rel="stylesheet" href="../CSS/form.css">
</head>

<body>
	<form method="post" action=addCustomer.php name="add_customer">
		<input type="reset" value="Clear">
		<table class="form-table" border=1>
			<thead>
				<tr>
					<td colspan=4><h2>Customer</h2></td>
				</tr>
			</thead>
			<tr>
				<td>*First Name:</td>
				<td><input type="text" value="<?php echo $customer_FirstName;?>" required name="firstName"></td>
				<td>*Last Name:</td>
				<td><input type="text" value="<?php echo $customer_LastName;?>" required name="lastName"></td>
			</tr>
			<tr>
				<td>*Email:</td>
				<td><input type="email" value="<?php echo $customer_email;?>" required name="email"></td>
				<td>Phone:</td>
				<td><input type="number" value="<?php echo $customer_phone;?>" name="phone"></td>
			</tr>
			<tr>
				<td>Fax:</td>
				<td colspan=3><input type="number" value="<?php echo $customer_fax;?>" name="fax"></td>
			</tr>

		</table>
		<input type="submit" name="submit" value="Submit">
	</form>
</body>
</html>
