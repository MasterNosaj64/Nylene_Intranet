<?php
/*
 * FileName: viewCompany.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 *  View company data in the database.
 *  This includes the customers registered to the company
 */

Session_start();

//the following variables are used in navigation.php
//View navigation.php for more information
unset($_SESSION['interaction_id']);
unset($_SESSION['company_id']);

//The navigation bar for the website
include '../navigation.php';
//connection to the database
include '../Database/connect.php';

//Handler for if the database connection fails
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

//The below is used only for when the user is redirected from the addCustomer page
    if (isset($_SESSION['customer_created'])) {
        $_POST['company_id_view'] = $_SESSION['customer_created'];
        unset($_SESSION['customer_created']);
    }

    //The blow is used to reassign session vars used for navigation menu
    if (isset($_POST['company_id_view']) || isset($_SESSION['companyHistoryPage'])) {

        if (isset($_POST['company_id_view'])) {
            $_SESSION['company_id'] = $_POST['company_id_view'];
        } else {
            $_SESSION['company_id'] = $_SESSION['companyHistoryPage'];
            $_POST['company_id_view'] = $_SESSION['companyHistoryPage'];
            unset($_SESSION['companyHistoryPage']);
        }

        /*
         * The following code handles the offset for the list of companies
         * Below is an explaination of the variables
         *      next10: the next 10 button
         *      previous10: the previous 10 button
         *      offset: the current offset value for the following query
         *
         */
        
        
        if (! isset($_POST['offset'])) {
            $_POST['offset'] = 0;
        }

        if (isset($_POST['next10'])) {
            $_POST['offset'] += 10;
        }

        if (isset($_POST['previous10'])) {
            $_POST['offset'] -= 10;

            if ($_POST['offset'] < 0) {
                $_POST['offset'] = 0;
            }
        }

        // Get Company data
        $companysqlquery = "SELECT * FROM nylene.company WHERE company_id = " . $_SESSION["company_id"];
        /* $companyInfo = $dbConnection->query($companysqlquery)->fetch(PDO::FETCH_ASSOC); */
        $company_result = $conn->query($companysqlquery);
        $companyInfo = mysqli_fetch_array($company_result);

        // Get customer_id's for company
        $customersqlquery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = " . $_SESSION['company_id'] . " LIMIT 10 OFFSET " . $_POST['offset'];
        /* $customers = $dbConnection->query($customersqlquery); */
        $customers = $conn->query($customersqlquery);
        // echo "<h1>Company View</h1>";

        // Get company info
        $companyAddress = $companyInfo["billing_address_street"] . ", " . $companyInfo["billing_address_city"] . ", " . $companyInfo["billing_address_state"] . ", " . $companyInfo["billing_address_country"] . ", " . $companyInfo["billing_address_postalcode"];

        $companyShippingAddress = $companyInfo["shipping_address_street"] . ", " . $companyInfo["shipping_address_city"] . ", " . $companyInfo["shipping_address_state"] . ", " . $companyInfo["shipping_address_country"] . ", " . $companyInfo["shipping_address_postalcode"];

        //The following is the table for displaying the company information
        
        echo "<link rel=\"stylesheet\" href=\"../CSS/table.css\">";
        echo "<table class =\"form-table\"  border=5>";
        echo "<tr><td>Company:</td><td>" . $companyInfo["company_name"] . "</td><td>Address:</td><td>$companyAddress</td></tr>";
        echo "<tr><td>Website:</td><td><a href=\"" . $companyInfo["website"] . "\">" . $companyInfo["website"] . "</a></td><td>Email:</td><td><a href=\"mailto: " . $companyInfo["company_email"] . "\">" . $companyInfo["company_email"] . "</a></td></tr>";
        echo "</table>";
    } else {
        //If the above results in error redirect the user to homepage
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
        exit();
    }
}

?>


<!-- View Company -->
<!-- Below is the interface for all customers assign to the company -->


<html>
<head>
<!--
  <link rel="stylesheet" href="../CSS/table.css">
</head>

-->

<!-- Buttons for adding customer or viewing Comapny History -->
<table>
	<tr>
		<td>
			<form method="post" action="addCustomer.php">
				<input hidden name="company_id"
					value="<?php echo $_SESSION['company_id'];?>" /> <input
					type="submit" value="Add Customer" />
			</form>
		</td>
		<td>
			<form method="post" action="../Interactions/companyHistory.php">
				<input hidden name="company_id"
					value="<?php echo $_SESSION['company_id'];?>" /> <input
					type="submit" value="View History" />
			</form>
		</td>
	</tr>

	<!-- 
<tr><td>

<!-- Next 10 Previous 10 Buttons -->
<!-- The following code presents the user with buttons to navigate the query -->
<form method="post" action="viewCompany.php">
<input hidden name="previous10" value="<?php echo $_POST['offset'];?>"/>
<input hidden name="company_id_view" value="<?php echo $_POST['company_id_view'];?>"/>
<input type="submit" value="Previous 10"/>
</form>
</td>
<td>
<form method="post" action="viewCompany.php">
<input hidden name="next10" value="<?php echo $_POST['offset'];?>"/>
<input hidden name="company_id_view" value="<?php echo $_POST['company_id_view'];?>"/>
<input type="submit" value="Next 10"/>
</form>
</td>
</tr>

 -->

</table>
<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Name</td>
			<td>Email</td>
			<td>Phone</td>
			<td>Fax</td>
			<td>Date Created</td>
			<td>Manage</td>
		</tr>
	</thead>

	<?php

while ($cx = mysqli_fetch_array($customers)) {
    $sqlGetCustomerDataQuery = "SELECT * FROM nylene.customer WHERE customer_id = " . $cx["customer_id"];

    /* $customerData = $dbConnection->query($sqlGetCustomerDataQuery)->fetch(PDO::FETCH_ASSOC); */
    $customer_result = $conn->query($sqlGetCustomerDataQuery);
    $customerData = mysqli_fetch_array($customer_result);
    echo "<tr><td>" . $customerData["customer_name"] . "</td><td><a href=\"mailto: " . $customerData["customer_email"] . "\">" . $customerData["customer_email"] . "</td><td>" . $customerData["customer_phone"] . "</td><td>" . $customerData['customer_fax'] . "</td><td>" . date("d-m-Y", strtotime($customerData['date_created'])) . "</td><td> 
<form method=\"post\" action=\"editCustomer.php\">
<input hidden type=\"text\" name=\"customer_id\" value=\"" . $cx["customer_id"] . "\">
<input type=\"submit\" value=\"edit\"/>
</form>
</td></tr>";
}
$conn->close();
?>
	
	
<!-- Customers List -->
	<table class="form-table" border=0align:center;>
		<td><form method="post" action="viewCompany.php">
				<input hidden name="previous10"
					value="<?php echo $_POST['offset'];?>" /> <input hidden
					name="company_id_view"
					value="<?php echo $_POST['company_id_view'];?>" /> <input
					type="submit" value="Previous 10" />
			</form></td>
		<td>
			<form method="post" action="viewCompany.php">
				<input hidden name="next10" value="<?php echo $_POST['offset'];?>" />
				<input hidden name="company_id_view"
					value="<?php echo $_POST['company_id_view'];?>" /> <input
					type="submit" value="Next 10" />
			</form>
		</td>

	</table>
	</html>