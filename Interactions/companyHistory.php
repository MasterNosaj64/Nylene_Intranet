<?php
/*
 * FileName: companyHistory.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 * View a list of interactions for the company
 * Date Modified: 11/01/2020
 */
session_start();



// The navigation bar for the website
include '../NavPanel/navigation.php';
// connection to the database
include '../Database/connect.php';
//listBuffer logic
include '../Database/listBuffer.php';
// Interaction object
include '../Database/Interaction.php';
// Customer Object
include '../Database/Customer.php';
// Company Object
include '../Database/Company.php';
//Employee Object
include '../Database/Employee.php';

// The following is used in sessionController.php
$_SESSION['companyHistoryVisited'] = basename($_SERVER['PHP_SELF']);

$interaction_Conn = getDBConnection();

$company_Conn = getDBConnection();

// Handler for if the database connection fails
if ($interaction_Conn->connect_error || $company_Conn->connect_error) {
    die("Connection failed: {$interaction_Conn->connect_error} || {$company_Conn->connect_error}");
} else {

    if (isset($_POST['company_id']) && !isset($_SESSION['company_id'])) {

        $_SESSION['company_id'] = $_POST['company_id'];
    }
    
    
    if(isset($_SESSION['company_id'])){
        
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

        $companyInfo = new Company($company_Conn);

        $companyInfoResult = $companyInfo->searchId($_SESSION["company_id"]);
        $companyInfoResult->fetch();

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

<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Date</td>
			<td>Customer</td>
			<td>Reason</td>
			<td>Notes</td>
			<td>Author</td>
			<td>Manage</td>
		</tr>
	</thead>
<?php
// Get interactions
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
        
        $interactionBuffer = next10($sessionBuffer);
    } else if (isset($_POST['previous10'])) {
        $_SESSION['offset'] -= $maxGridSize;
        
        if ($_SESSION['offset'] < 0) {
            $_SESSION['offset'] = 0;
        }
        
        $interactionBuffer = previous10($sessionBuffer);
    }
    
    
    //page refresh
    /* $interactionBuffer = $_SESSION['buffer'];
    $interactionBuffer->rewind(); */
} else {
    // attempt of creating a buffer for a list of companies
    $interactions = new Interaction($interaction_Conn);
    $interactionResult = $interactions->search("", $_SESSION['company_id'], "", "", "", "", "");
    $interactionBuffer = create_Buffer($interactionResult, $interactions);
}

echo "{$interactionBuffer->count()} record(s) found";


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

    $customer_Conn = getDBConnection();
    $employee_Conn = getDBConnection();
    
    
    if($customer_Conn->connect_error || $employee_Conn->connect_error){
        die("Connection failed: {$customer_Conn->connect_error} || {$employee_Conn->connect_error}");
    }
    
    //obtain customer data
    $customer = new Customer($customer_Conn);
    $customerData = $customer->searchById($customerID);
    $customerData->fetch();
    $customerName = $customer->getName();
    $customer_Conn->close();
    
    //TODO: JASON add created by column
    //obtain employee data
    $employee = new Employee($employee_Conn);
    $employeeData = $employee->searchById($employeeID);
    $employeeData->fetch();
    $employeeName = $employee->getName();
    $employee_Conn->close();
    
    
    
    echo "<tr><td>{$interactionDateCreated}</td>";
    echo "<td>{$customerName}</td>";
    echo "<td>{$reason}</td>";
    echo "<td>".substr($comments, 0, 50)."</td>";
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

<!-- Next 10 Previous 10 Buttons -->
	<!-- The following code presents the user with buttons to navigate the list of companies
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
	<table class="form-table"align:center;>
		<td><form method="post" action="companyHistory.php">
		<?php if($_SESSION['offset'] == 0){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="previous10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					value="Previous 10" />
		<?php if($_SESSION['offset'] == 0){ echo "</fieldset>";}?>
			</form></td>
		<td><form method="post" action="companyHistory.php">
		<?php if($offset == $interactionBuffer->count()){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="next10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					value="Next 10" />
					<?php if($offset == $interactionBuffer->count()){ echo "</fieldset>";}?>
			</form></td>
	</table>
	</html>