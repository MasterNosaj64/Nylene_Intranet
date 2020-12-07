<?php
/*
 * FileName: companyHistory.php
 * Version Number: 2.0
 * Author: Jason Waid
 * Purpose:
 * View a list of interactions for the company
 * Date Modified: 12/7/2020
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

        $_SESSION['companyHistoryPage'] = $_SESSION['company_id'];

        // Company info table
        $company = new Company($company_Conn);

        $company->searchId($_SESSION["company_id"]);
    } else {

        ?>
<!-- If the above results in error redirect the user to homepage  -->
<meta http-equiv="refresh" content="0; url = ../Home/Homepage.php" />
<?php
        exit();
    }
}
?>

<!-- Company History -->
<!-- Below is the interface for all interactions assigned to the company -->

<html>
<head>
<title>Company History</title>
<link rel="stylesheet" href="../CSS/company.customer.interaction.css">
</head>

<!-- The following is the table for displaying the company information -->
<?php
echo $company->printCompanyInfoTable();
?>
<!-- Button to add an interaction -->
<form method="post" action="AddInteraction.php">
	<input hidden="true" name="company_id"
		value="<?php echo $_SESSION['company_id'];?>" /> <input type="submit"
		id="create_interaction" name="create_interaction"
		value="Create Interaction"
		style="width: 100%; margin: 15 5 1 5; text-align: center box-sizing border-box; border: 2px solid #000; border-radius: 4px; font-size: 20px; background-color: rgb(167, 197, 244); padding: 5px 12px 5px 12px; cursor: pointer;" />
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
    $interactionResult = $interactions->search("", $_SESSION['company_id'], "", "", "", "", "", "", "", "");
    $interactionBuffer = create_Interaction_Buffer($interactionResult, $interactions);

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

<table class="form-table" border="1">
	<thead>
		<tr>
<?php printHeadersInteraction($sortType)?>	
</tr>
	</thead>
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
    $customerName = $customer->getName();
    $customer_Conn->close();

    $employee = new Employee($employee_Conn);
    $employee->searchById($employeeID);
    $employeeName = $employee->getName();
    $employee_Conn->close();
    ?>
 <tr>
		<td><?php echo $interactionDateCreated;?></td>
		<td><?php echo $customerName;?></td>
		<td><?php echo $reason;?></td> 
		<?php if (strlen($comments) > 50) { ?>
		<td><?php echo substr($comments, 0, 50);?> ...</td>
		<?php } else {?>
		<td><?php echo substr($comments, 0, 50);?></td>
		<?php }?>
		<td><?php echo $status; ?></td>
		<td><?php echo $employeeName; ?></td>
		<td><form method="post" action="viewInteraction.php">
				<input hidden="true" type="text" name="interaction_id"
					value="<?php echo $interactionID;?>"> <input type="submit"
					value="view" />
			</form></td>
	</tr>
	
<?php
    $offset ++;
    if ($offset == ($_SESSION['offset'] + $maxGridSize)) {
        break;
    }
}
$interaction_Conn->close();
$company_Conn->close();
?>
</table>
<!-- Next 10 Previous 10 Buttons -->
<!-- The following code presents the user with buttons to navigate the list of customers
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
<table>
	<tr>
		<td>
			<form method='post'
				action='companyHistory.php?sort=<?php echo $_GET['sort'];?>'>
				<fieldset style='border-style: none'
					<?php if ($_SESSION['offset'] == 0) { echo "disabled ='disabled'";}?>>
					<input hidden='true' name='previous'
						value='<?php echo $_SESSION["offset"];?>' /> <input type='submit'
						value='&#x21DA; Previous' />
				</fieldset>
			</form>
		</td>
		<td>
			<form method='post'
				action='companyHistory.php?sort=<?php echo $_GET['sort'];?>'>
				<fieldset style='border-style: none'
					<?php if ($offset == $interactionBuffer->count()) { echo "disabled ='disabled'";}?>>
					<input hidden='true' name='next'
						value='<?php echo $_SESSION["offset"];?>' /> <input type='submit'
						value='Next &#x21DB;' />
				</fieldset>
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
		window.location.href = "./companyHistory.php?sort=" + col;	
	}
</script>
</html>