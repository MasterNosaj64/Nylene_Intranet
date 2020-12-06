<?php
/*
 * FileName: viewCompany.php
 * Version Number: 2.0
 * Author: Jason Waid
 * Purpose:
 * View company data in the database.
 * This includes the customers registered to the company
 * Date Modified: 11/29/2020
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

    if (isset($_SESSION['company_id'])) {

        // Get Company data
        $company = new Company($conn_Company);

        $company->searchId($_SESSION["company_id"]);

        // Get customer_id's for company
        $customersqlquery = "SELECT * FROM nylene.company_relational_customer WHERE company_id = " . $_SESSION['company_id'];
        $customerIDs = $conn_CustomerIDs->query($customersqlquery);

        // Get company info
        $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCountry()}, {$company->getBillingAddressPostalCode()}";

        // $companyShippingAddress = "{$company->getShippingAddressStreet()} {$company->getShippingAddressCity()} {$company->getShippingAddressState()} {$company->getShippingAddressCounty()} {$company->getShippingAddressPostalCode()}";

        // The following is the table for displaying the company information

        echo "<link rel=\"stylesheet\" href=\"../CSS/table.css\">";
        echo "<table class =\"form-table\"  border=5>";
        echo "<tr><td>Company:</td><td>{$company->getName()}</td><td>Address:</td><td>{$companyAddress}</td></tr>";
        echo "<tr><td>Website:</td><td><a href=\"{$company->getWebsite()}\">{$company->getWebsite()}</a></td><td>Email:</td><td><a href=\"mailto: {$company->getEmail()}\">{$company->getEmail()}</a></td></tr>";
        echo "</table>";
    } else {
        // If the above results in error redirect the user to homepage
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Home/Homepage.php\" />;";
        exit();
    }

    // Change this variable to modify the page size
    $maxGridSize = 4;

    // check if a buffer has already been created
    if (isset($_SESSION['buffer'])) {

        // check if user wants next 10 or previous 10
        $customerBuffer = $_SESSION['buffer'];

        if (isset($_POST['next'])) {
            $_SESSION['offset'] += $maxGridSize;
            if ($_SESSION['offset'] > $customerBuffer->count()) {
                $_SESSION['offset'] -= $maxGridSize;
            }

            $customerBuffer = nextBufferPage($customerBuffer);
        } else if (isset($_POST['previous'])) {
            $_SESSION['offset'] -= $maxGridSize;

            if ($_SESSION['offset'] < 0) {
                $_SESSION['offset'] = 0;
            }

            $customerBuffer = previousBufferPage($customerBuffer);
        } else {

            $customerBuffer = getSortingCustomer($customerBuffer);
        }
    } else {
        // attempt of creating a buffer for a list of companies
        $customerBuffer = create_Customer_Buffer($customerIDs);

        if (isset($_GET['sort'])) {
            $customerBuffer = getSortingCustomer($customerBuffer);
        }
    }
}
?>


<!-- View Company -->
<!-- Below is the interface for all customers assigned to the company -->


<html>
<head>
<link rel="stylesheet" href="../CSS/form.css">
<title>View Company</title>
</head>
<!-- Buttons for adding customer or viewing Comapny History -->
<table>
	<tr>
		<td>
			<form method="post" action="addCustomer.php">
				<input hidden="true" name="company_id"
					value="<?php echo $_SESSION['company_id'];?>" /> <input
					type="submit" value="Add Customer" />
			</form>
		</td>
		<td>
			<form method="post"
				action="../Interactions/companyHistory.php?sort=1">
				<input hidden="true" name="company_id"
					value="<?php echo $_SESSION['company_id'];?>" /> <input
					type="submit" value="View History" />
			</form>
		</td>
	</tr>
</table>

<?php

echo "{$customerBuffer->count()} record(s) found";

if (isset($_GET['sort'])) {
    $sortType = $_GET['sort'];
} else {
    $sortType = 0;
}

?>


<table class="form-table" border=1>
	<thead>
		<tr>
		<?php printHeadersCustomer($sortType)?>	
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
$conn_Company->close();
$conn_Customers->close();
?>
</table>
<!-- Next 10 Previous 10 Buttons -->
<!-- The following code presents the user with buttons to navigate the list of customers
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
<table>
	<tr>
		<td>
			<form method='post'
				action='viewCompany.php?sort=<?php echo $_GET['sort'];?>'>
	<?php
if ($_SESSION['offset'] == 0) {
    echo "<fieldset style='border-style:none' disabled ='disabled'>";
}
?>
    <input hidden='true' name='previous'
					value='<?php echo $_SESSION["offset"];?>' /> <input type='submit'
					value='&#x21DA; Previous' />
    <?php
    if ($_SESSION['offset'] == 0) {
        echo "</fieldset>";
    }
    ?>
	</form>
		</td>
		<td>
			<form method='post'
				action='viewCompany.php?sort=<?php echo $_GET['sort'];?>'>
	<?php
if ($offset == $customerBuffer->count()) {
    echo "<fieldset style='border-style:none' disabled ='disabled'>";
}
?>
    <input hidden='true' name='next'
					value='<?php echo $_SESSION["offset"];?>' /> <input type='submit'
					value='Next &#x21DB;' />
	<?php
if ($offset == $customerBuffer->count()) {
    echo "</fieldset>";
}
?>
    
	</form>
		</td>
	</tr>
</table>


<!-- Script for Sorting columns -->
<script>
	
	var td = document.getElementsByClassName("ColSort");
	var i;

	for (i = 0; i < td.length; i++) {
		td[i].addEventListener("click", colSort);
		td[i].addEventListener("mouseover", function(event){
		
			event.target.style = "font-size: 20px; background-color: rgb(211, 211, 211); color: #000000; text-align: left; font-weight: bold; text-align: center;";
			}, false);

		td[i].addEventListener("mouseout", function(event){
		
			event.target.style = "";
			}, false);
	}

function colSort(){
	
		var col = this.getAttribute("data-colnum");
		window.location.href = "./viewCompany.php?sort=" + col;
	
}

</script>
</html>