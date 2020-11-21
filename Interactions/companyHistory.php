<?php
/*
 * FileName: companyHistory.php
 * Version Number: 1.6
 * Author: Jason Waid
 * Purpose:
 * View a list of interactions for the company
 * Date Modified: 11/20/2020
 */
session_start();

// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';
// listBuffer logic
include '../Database/listBuffer.php';
// Interaction object
include '../Database/Interaction.php';
// Customer Object
include '../Database/Customer.php';
// Company Object
include '../Database/Company.php';
// Employee Object
include '../Database/Employee.php';

// The following is used in sessionController.php
$_SESSION['companyHistoryVisited'] = basename($_SERVER['PHP_SELF']);

$interaction_Conn = getDBConnection();

$company_Conn = getDBConnection();

// Handler for if the database connection fails
if ($interaction_Conn->connect_error || $company_Conn->connect_error) {
    die("Connection failed: {$interaction_Conn->connect_error} || {$company_Conn->connect_error}");
} else {

    if (isset($_POST['company_id']) && ! isset($_SESSION['company_id'])) {

        $_SESSION['company_id'] = $_POST['company_id'];
    }

    if (isset($_SESSION['company_id'])) {

        /*
         * The following code handles the offset for the list of companies
         * Below is an explaination of the variables
         * next10: the next 10 button
         * previous10: the previous 10 button
         * offset: the current offset value for the following query
         *
         */

        $_SESSION['companyHistoryPage'] = $_SESSION['company_id'];

        // Company info table

        $company = new Company($company_Conn);

        $company->searchId($_SESSION["company_id"]);
        // $companyInfoResult->fetch();

        // Get company info
        $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCounty()}, {$company->getBillingAddressPostalCode()}";

        $companyShippingAddress = "{$company->getShippingAddressStreet()} {$company->getShippingAddressCity()} {$company->getShippingAddressState()} {$company->getShippingAddressCounty()} {$company->getShippingAddressPostalCode()}";

        // The following is the table for displaying the company information

        echo "<link rel=\"stylesheet\" href=\"../CSS/table.css\">";
        echo "<table class =\"form-table\"  border=5>";
        echo "<tr><td>Company:</td><td>{$company->getName()}</td><td>Address:</td><td>{$companyAddress}</td></tr>";
        echo "<tr><td>Website:</td><td><a href=\"{$company->getWebsite()}\">{$company->getWebsite()}</a></td><td>Email:</td><td><a href=\"mailto: {$company->getEmail()}\">{$company->getEmail()}</a></td></tr>";
        echo "</table>";
    } else {
        // If the above results in error redirect the user to homepage
        echo "<meta http-equiv = \"refresh\" content = \"5; url = ../Home/Homepage.php\" />;";
        exit();
    }
}
?>

<!-- Company History -->
<!-- Below is the interface for all interactions assigned to the company -->

<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>
<!-- Button to add an interaction -->
<form method="post" action="AddInteraction.php">
	<input hidden name="company_id"
		value="<?php echo $_SESSION['company_id'];?>" /> <input type="submit"
		id="create_interaction" name="create_interaction"
		value="Create Interaction" />
</form>

<?php
// Get interactions
// Change this variable to modify the page size
$maxGridSize = 5;

// check if a buffer has already been created
if (isset($_SESSION['buffer'])) {

    // check if user wants next 10 or previous 10

    $interactionBuffer = $_SESSION['buffer'];

    if (isset($_POST['next'])) {
        $_SESSION['offset'] += $maxGridSize;
        if ($_SESSION['offset'] > $interactionBuffer->count()) {
            $_SESSION['offset'] -= $maxGridSize;
        }

        $interactionBuffer = nextBufferPage($interactionBuffer);
    } else if (isset($_POST['previous'])) {
        $_SESSION['offset'] -= $maxGridSize;

        if ($_SESSION['offset'] < 0) {
            $_SESSION['offset'] = 0;
        }

        $interactionBuffer = previousBufferPage($interactionBuffer);
    } else {
        $interactionBuffer = getSortingInteraction($interactionBuffer);
    }
} else {
    // attempt of creating a buffer for a list of companies
    $interactions = new Interaction($interaction_Conn);
    $interactionResult = $interactions->search("", $_SESSION['company_id'], "", "", "", "", "", "", "" ,"");
    $interactionBuffer = create_Buffer($interactionResult, $interactions);

    if (isset($_GET['sort'])) {
        $interactionBuffer = getSortingInteraction($interactionBuffer);
    }
}

echo "{$interactionBuffer->count()} record(s) found";

if (isset($_GET['sort'])) {
    $sortType = $_GET['sort'];
} else {
    $sortType = 0;
}

?>

<table class="form-table" border=5>
	<thead>
		<tr>
<?php printHeadersInteraction($sortType)?>	
</tr>
	</thead>

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
		window.location.href = "./companyHistory.php?sort=" + col;
	
}

	</script>


<?php
for ($offset = $_SESSION['offset']; $interactionBuffer->valid(); $interactionBuffer->next()) {

    // Unserialize the object stored in the companyBuffer
    $currentInteractionNode = unserialize($interactionBuffer->current());

    // temp var for storing current company data members
    $interactionID = $currentInteractionNode->getInteractionId();
    $customerID = $currentInteractionNode->getCustomerId();
    $employeeID = $currentInteractionNode->getCreatedBy();
    $reason = $currentInteractionNode->getReason();
    $comments = $currentInteractionNode->getComments();
    $interactionDateCreated = $currentInteractionNode->getDateCreated();
    $status = $currentInteractionNode->getStatus();

    $customer_Conn = getDBConnection();
    $employee_Conn = getDBConnection();

    if ($customer_Conn->connect_error || $employee_Conn->connect_error) {
        die("Connection failed: {$customer_Conn->connect_error} || {$employee_Conn->connect_error}");
    }

    // obtain customer data
    $customer = new Customer($customer_Conn);
    $customer->searchById($customerID);
    // $customerData->fetch();
    $customerName = $customer->getName();
    $customer_Conn->close();

    $employee = new Employee($employee_Conn);
    $employee->searchById($employeeID);
    $employeeName = $employee->getName();
    $employee_Conn->close();

    echo "<tr><td>{$interactionDateCreated}</td>";
    echo "<td>{$customerName}</td>";
    echo "<td>{$reason}</td>";
    echo "<td>" . substr($comments, 0, 50) . "</td>";
    echo "<td>{$status}</td>";
    echo "<td>{$employeeName}</td>";
    echo "<td><form method=\"post\" action=\"viewInteraction.php\">";
    echo "<input hidden type=\"text\" name=\"interaction_id\" value=\"{$interactionID}\">";
    echo "<input type=\"submit\" value=\"view\"/>";
    echo "</form></td></tr>";

    $offset ++;
    if ($offset == ($_SESSION['offset'] + $maxGridSize)) {
        break;
    }
}

$interaction_Conn->close();
$company_Conn->close();
?>

<!-- Next & Previous Buttons -->
	<!-- The following code presents the user with buttons to navigate the list of customers
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
	
	<?php

if (isset($_GET['sort'])) {

    echo "<table class='form-table'align:center;>";
    echo "<td><form method='post' action='companyHistory.php?sort={$_GET['sort']}'>";
    if ($_SESSION['offset'] == 0) {
        echo "<fieldset disabled ='disabled'>";
    }
    echo "<input hidden name='previous'";
    echo "value={$_SESSION["offset"]} /> <input type='submit'";
    echo "value='&#x21DA; Previous' />";
    if ($_SESSION['offset'] == 0) {
        echo "</fieldset>";
    }

    echo "</form></td>";
    echo "<td><form method='post' action='companyHistory.php?sort={$_GET['sort']}'>";
    if ($offset == $interactionBuffer->count()) {
        echo "<fieldset disabled ='disabled'>";
    }

    echo "<input hidden name='next'";
    echo "value='{$_SESSION["offset"]}' /> <input type='submit'";
    echo "value='Next &#x21DB;' />";
    if ($offset == $interactionBuffer->count()) {
        echo "</fieldset>";
    }
    echo "</form></td>";
    echo "</table>";
} else {

    echo "<table class='form-table'align:center;>";
    echo "<td><form method='post' action='companyHistory.php'>";
    if ($_SESSION['offset'] == 0) {
        echo "<fieldset disabled ='disabled'>";
    }
    echo "<input hidden name='previous'";
    echo "value='{$_SESSION["offset"]}' /> <input type='submit'";
    echo "value='&#x21DA; Previous' />";
    if ($_SESSION['offset'] == 0) {
        echo "</fieldset>";
    }

    echo "</form></td>";
    echo "<td><form method='post' action='companyHistory.php'>";
    if ($offset == $interactionBuffer->count()) {
        echo "<fieldset disabled ='disabled'>";
    }

    echo "<input hidden name='next'";
    echo "value='{$_SESSION["offset"]}' /> <input type='submit'";
    echo "value='Next &#x21DB;' />";
    if ($offset == $interactionBuffer->count()) {
        echo "</fieldset>";
    }
    echo "</form></td>";
    echo "</table>";
}
?>




</html>