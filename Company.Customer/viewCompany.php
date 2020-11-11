<?php
/*
 * FileName: viewCompany.php
 * Version Number: 1.2
 * Author: Jason Waid
 * Purpose:
 * View company data in the database.
 * This includes the customers registered to the company
 * Date Modified: 11/01/2020
 */
Session_start();

// The following is used in sessionController.php
$_SESSION['viewCompanyVisited'] = basename($_SERVER['PHP_SELF']);

// The navigation bar for the website
include '../NavPanel/navigation.php';

// connection to the database
include '../Database/connect.php';

// Company Objects
include '../Database/Company.php';

// Customer Objects
include '../Database/Customer.php';

// list buffer
include '../Database/listBuffer.php';

// Attempt connection to DB for Companies
$conn_Company = getDBConnection();

// Attempt connection to DB for Customers
$conn_CustomerIDs = getDBConnection();

// Attempt connection to DB for Customers
$conn_Customers = getDBConnection();

// Handler for if the database connection fails
if ($conn_Company->connect_error || $conn_CustomerIDs->connect_error || $conn_Customers->connect_error) {
    die("A connection failed: Company: " . $conn_Company->connect_error . "|| Customer: " . $conn_Customers->connect_error . " || CustomerIDs: " . $conn_CustomerIDs->connect_error);
} else {

    if (! isset($_SESSION['company_id']) && isset($_POST['company_id_view'])) {

        $_SESSION['company_id'] = $_POST['company_id_view'];
    }

    if (! isset($_SESSION['company_id']) && isset($_POST['customer_created'])) {

        $_SESSION['company_id'] = $_POST['company_id_view'];
    }

    /*
     * // The below is used only for when the user is redirected from the addCustomer page
     * if (isset($_SESSION['customer_created'])) {
     * $_POST['company_id_view'] = $_SESSION['customer_created'];
     * unset($_SESSION['customer_created']);
     * }
     */

    // TODO: JASON add the below to sessionController.php
    // The below is used to reassign session vars used for navigation menu
    // if (isset($_POST['company_id_view']) || isset($_SESSION['company_id'])) {
    if (isset($_SESSION['company_id'])) {

        // Get Company data
        $companyInfo = new Company($conn_Company);

        $companyInfoResult = $companyInfo->searchId($_SESSION["company_id"]);
        $companyInfoResult->fetch();

        // Get customer_id's for company
        $customersqlquery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = " . $_SESSION['company_id'];
        $customerIDs = $conn_CustomerIDs->query($customersqlquery);

        // Get company info
        $companyAddress = "{$companyInfo->getBillingAddressStreet()} {$companyInfo->getBillingAddressCity()} {$companyInfo->getBillingAddressState()} {$companyInfo->getBillingAddressCounty()} {$companyInfo->getBillingAddressPostalCode()}";

        $companyShippingAddress = "{$companyInfo->getShippingAddressStreet()} {$companyInfo->getShippingAddressCity()} {$companyInfo->getShippingAddressState()} {$companyInfo->getShippingAddressCounty()} {$companyInfo->getShippingAddressPostalCode()}";

        // The following is the table for displaying the company information

        echo "<link rel=\"stylesheet\" href=\"../CSS/table.css\">";
        echo "<table class =\"form-table\"  border=5>";
        echo "<tr><td>Company:</td><td>{$companyInfo->getName()}</td><td>Address:</td><td>{$companyAddress}</td></tr>";
        echo "<tr><td>Website:</td><td><a href=\"{$companyInfo->getWebsite()}\">{$companyInfo->getWebsite()}</a></td><td>Email:</td><td><a href=\"mailto: {$companyInfo->getEmail()}\">{$companyInfo->getEmail()}</a></td></tr>";
        echo "</table>";
    } else {
        // If the above results in error redirect the user to homepage
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
        exit();
    }

    // Change this variable to modify the page size
    $maxGridSize = 10;

    // check if a buffer has already been created
    if (isset($_SESSION['buffer'])) {

        // check if user wants next 10 or previous 10
        $sessionBuffer = $_SESSION['buffer'];

        if (isset($_POST['next10'])) {
            $_SESSION['offset'] += $maxGridSize;
            if ($_SESSION['offset'] > $sessionBuffer->count()) {
                $_SESSION['offset'] -= $maxGridSize;
            }

            $customerBuffer = next10($sessionBuffer);
        } else if (isset($_POST['previous10'])) {
            $_SESSION['offset'] -= $maxGridSize;

            if ($_SESSION['offset'] < 0) {
                $_SESSION['offset'] = 0;
            }

            $customerBuffer = previous10($sessionBuffer);
        }
        
        /* $customerBuffer = $_SESSION['buffer'];
        $customerBuffer->rewind(); */
        
    } else {
        // attempt of creating a buffer for a list of companies
        $customerBuffer = create_Customer_Buffer($customerIDs);
    }
}
?>


<!-- View Company -->
<!-- Below is the interface for all customers assigned to the company -->


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
	<tr>
		<td>

<?php echo "{$customerBuffer->count()} record(s) found";?>



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
// Customers List
for ($offset = $_SESSION['offset']; $customerBuffer->valid(); $customerBuffer->next()) {

    // Unserialize the object stored in the companyBuffer
    $currentCustomerNode = unserialize($customerBuffer->current());

    // temp var for storing current company data members
    $customerID = $currentCustomerNode->getCustomerId();
    $customerName = $currentCustomerNode->getName();
    $customerEmail = $currentCustomerNode->getEmail();
    $customerPhone = $currentCustomerNode->getPhone();
    $customerFax = $currentCustomerNode->getFax();
    $customerDateCreated = $currentCustomerNode->getDateCreated();

    echo "<tr><td>{$customerName}</td><td><a href=\"mailto: {$customerEmail}\">{$customerEmail}</td><td>{$customerPhone}</td><td>{$customerFax}</td><td>" . date("d-m-Y", strtotime($customerDateCreated)) . "</td><td>
<form method=\"post\" action=\"editCustomer.php\">
<input hidden type=\"text\" name=\"customer_id\" value=\"{$customerID}\">
<input type=\"submit\" value=\"edit\"/>
</form>
</td></tr>";

    $offset ++;
    if ($offset == ($_SESSION['offset'] + $maxGridSize)) {
        break;
    }
}
$conn_Customers->close();
?>

<!-- Next 10 Previous 10 Buttons -->
	<!-- The following code presents the user with buttons to navigate the list of companies
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
	<table class="form-table"align:center;>
		<td><form method="post" action="viewCompany.php">
		<?php if($_SESSION['offset'] == 0){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="previous10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					value="Previous 10" />
		<?php if($_SESSION['offset'] == 0){ echo "</fieldset>";}?>
			</form></td>
		<td><form method="post" action="viewCompany.php">
		<?php if($offset == $customerBuffer->count()){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="next10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					value="Next 10" />
					<?php if($offset == $customerBuffer->count()){ echo "</fieldset>";}?>
			</form></td>
	</table>
	</html>