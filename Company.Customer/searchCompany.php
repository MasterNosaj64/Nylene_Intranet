<?php
/*
 * FileName: searchCompany.php
 * Version Number: 0.85
 * Date Modified: 10/10/2020
 * Author: Jason Waid
 * Purpose:
 * Search for companies in the database.
 */
session_start();

// the following variables are used in navigation.php
// View navigation.php for more information
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);

// The navigation bar for the website
include '../NavPanel/navigation.php';

// connection to the database
include '../Database/connect.php';
// input handling functions

// Company Object
include '../Database/Company.php';

// Employee Object
include '../Database/Employee.php';

// Test file for list buffer
include '../Database/listBuffer.php';

// Attempt connection to DB for Companies
$conn_Company = getDBConnection();

// Attempt connection to DB for Employees
$conn_Employee = getDBConnection();

// Handler for if the database connection fails
if ($conn_Company->connect_error || $conn_Employee->connect_error) {
    die("A connection failed: Company: " . $conn_Company->connect_error . "|| Employee: " . $conn_employee->connect_error);
} else {

    /*
     * The following code handles the search functionality
     * Below is an explaination of the variables
     * employeeList = all the employee names used for assigned_to and created_by
     */

    // Querys for getting all employee names
    $employeeList = new Employee($conn_Employee);
    $employeeListResult = $employeeList->read();

    $employeeNames = array();
    $employeeIds = array();
    $numEmployees = 0;

    // Store all employee names and id's in array
    // THis is later used to the creation of the drop down menus
    while ($employeeListResult->fetch()) {
        array_push($employeeIds, $employeeList->getId());
        array_push($employeeNames, $employeeList->getName());
        $numEmployees ++;
    }
    $employeeListResult->close();

    // The bulk of the searching logic
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['Search'])) {

            // unset buffer since new search opperation makes current buffer obsolete
            unset($_SESSION['buffer']);

            // Below is the criteria available to the user for searchings the database
            // Any combination of the below can be used
            $name = $_POST["search_By_Name"];
            $website = $_POST["search_By_Website"];
            $address = $_POST["search_By_Address"];
            $city = $_POST["search_By_City"];
            $state = $_POST["search_By_State"];
            $country = $_POST["search_By_Country"];
            $assigned_To = $_POST["search_By_Assigned_To"];
            $created_By = $_POST["search_By_Created_By"];

            $companies = new Company($conn_Company);

            $companyResult = $companies->searchInclude($name, $website, $address, $city, $state, $country, $assigned_To, $created_By);
        }
    } else {
        // The default option, grabs all companies when initialy loading the page or when not search criteria is entered when clicking search
        $companies = new Company($conn_Company);
        $companyResult = $companies->read();
    }
}
?>
<html>
<head>
<link rel="stylesheet" href="../CSS/table.css">
</head>

<!-- NEW Company Search -->
<!-- Below is the NEW search company functionality -->
<button type="button" class="collapsible">Toggle Search</button>
<div class="content">

	<form method="post" action=searchCompany.php name="search_company_data">
		<table class="form-table" border=5>
			<tr>
				<td>Name:</td>
				<td><input type="text" name="search_By_Name" /></td>
				<td>Website:</td>
				<td><input type="text" value="http://" name="search_By_Website" /></td>
				<td>Assigned To:</td>
				<td><select name="search_By_Assigned_To">
						<option></option>
				<?php
    for ($i = 0; $i < $numEmployees; $i ++) {
        echo "<option value=\"{$employeeIds[$i]}\">";
        echo "{$employeeNames[$i]}</option>";
    }
    ?>
				</select></td>
				<td>Created By:</td>
				<td><select name="search_By_Created_By">
						<option></option>
				<?php
    for ($i = 0; $i < $numEmployees; $i ++) {
        echo "<option value=\"{$employeeIds[$i]}\">";
        echo "{$employeeNames[$i]}</option>";
    }
    ?>
				</select></td>
			</tr>
			<tr>
				<td>Address:</td>
				<td><input type="text" name="search_By_Address" /></td>
				<td>City</td>
				<td><input type="text" name="search_By_City" /></td>
				<td>State</td>
				<td><input type="text" name="search_By_State" /></td>
				<td>Country</td>
				<td><input type="text" name="search_By_Country" /></td>

			</tr>
		</table>
		<input type="submit" value="Search" name="Search" /> <input
			type="reset" value="Clear" />
	</form>

</div>

<!-- Script for collapsible search menu -->
<!-- https://www.w3schools.com/howto/howto_js_collapsible.asp -->
<script>
var coll = document.getElementsByClassName("collapsible");
var i;

for (i = 0; i < coll.length; i++) {
  coll[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var content = this.nextElementSibling;
    if (content.style.display === "block") {
      content.style.display = "none";
    } else {
      content.style.display = "block";
    }
  });
}
</script>

<?php
/*
 * if ($_SERVER["REQUEST_METHOD"] != "POST"){
 * die();
 * }
 */
?>

<!-- Company Search -->
<!-- Below is the table that is presented to the user for the query results on the Company table -->

<table class="form-table" border=5>
	<thead>
		<tr>
			<td>Name</td>
			<td>Website</td>
			<td>Email</td>
			<td>Street</td>
			<td>City</td>
			<td>State</td>
			<td>Assigned To</td>
			<?php
if ($_SESSION["role"] == "admin") {
    echo "<td>Created By</td>";
}
?>
			<td>Menu</td>
		</tr>
	</thead>

	<!-- </head> </html> -->
	<?php

	//Change this variable to modify the page size
	$maxGridSize = 10;
	
// check if a buffer has already been created
if (isset($_SESSION['buffer'])) {

    // check if user wants next 10 or previous 10

    $sessionBuffer = $_SESSION['buffer'];

    if (isset($_POST['next10'])) {
        $_SESSION['offset'] += $maxGridSize;
        if($_SESSION['offset'] > $sessionBuffer->count()){
            $_SESSION['offset'] -= $maxGridSize ;
        }

        $companyBuffer = next10($sessionBuffer);
    } else if (isset($_POST['previous10'])) {
        $_SESSION['offset'] -= $maxGridSize;

        if ($_SESSION['offset'] < 0) {
            $_SESSION['offset'] = 0;
        }

        $companyBuffer = previous10($sessionBuffer);
    }
    
} else {
    // attempt of creating a buffer for a list of companies
    $companyBuffer = create_Buffer($companyResult, $companies);
}

echo "{$companyBuffer->count()} record(s) found";



// TODO: Implement maximum buffer size of 10
for ($offset = $_SESSION['offset']; $companyBuffer->valid(); $companyBuffer->next()) {

    // Unserialize the object stored in the companyBuffer
    $currentCompanyNode = unserialize($companyBuffer->current());

    // temp var for storing current company data members
    $companyId = $currentCompanyNode->getCompanyId();
    $companyName = $currentCompanyNode->getName();
    $companyWebsite = $currentCompanyNode->getWebsite();
    $companyEmail = $currentCompanyNode->getEmail();

    $companyStreet = $currentCompanyNode->getBillingAddressStreet();
    $companyCity = $currentCompanyNode->getBillingAddressCity();
    $companyState = $currentCompanyNode->getBillingAddressState();

    // Get created by if admin is logged in
    if ($_SESSION["role"] == "admin") {

        $createdByEmployee = new Employee(getDBConnection());
        $getCreated_By = $createdByEmployee->search($currentCompanyNode->getCreatedBy(), "", "", "", "", "", "", "", "", "", "", "");
        $getCreated_By->fetch();
    }

    // Get assigned to
    $assignedToEmployee = new Employee(getDBConnection());
    $getAssigned_To = $assignedToEmployee->search($currentCompanyNode->getAssignedTo(), "", "", "", "", "", "", "", "", "", "", "");
    $getAssigned_To->fetch();

    echo "<tr>";
    echo "<td>{$companyName}</td>";
    echo "<td><a href=\"{$companyWebsite}\">{$companyWebsite}</a></td>";
    echo "<td><a href =\"mailto: {$companyEmail}\">{$companyEmail}</a></td>";
    echo "<td>{$companyStreet}</td>";
    echo "<td>{$companyCity}</td>";
    echo "<td>{$companyState}</td>";
    echo "<td>{$assignedToEmployee->getName()}</td>";

    // Show Created by field if Admin is logged in
    if ($_SESSION["role"] == "admin") {
        echo "<td>{$createdByEmployee->getName()}</td>";
    }
    echo "<td><form action=\"./editCompany.php\" method=\"post\">
     <input hidden name =\"company_id_edit\" value=\"{$companyId}\"/>
     <input type=\"submit\" value=\"edit\"/>
     </form>
     <form action=\"./viewCompany.php\" method=\"post\">
     <input hidden name =\"company_id_view\" value=\"{$companyId}\"/>
     <input type=\"submit\" value=\"view\"/>
     </form>
     </td>";
    echo "</tr>";
    $getAssigned_To->close();
    $getCreated_By->close();

    $offset ++;
    if ($offset == ($_SESSION['offset'] + $maxGridSize)) {
        break;
    }
}
$conn_Company->close();
?>

<!-- Next 10 Previous 10 Buttons -->
	<!-- The following code presents the user with buttons to navigate the query -->
	<table class="form-table" align:center;>
		<td><form method="post" action="searchCompany.php">
		<?php if($_SESSION['offset'] == 0){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="previous10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					 value="Previous 10" />
		<?php if($_SESSION['offset'] == 0){ echo "</fieldset>";}?>
			</form></td>
		<td><form method="post" action="searchCompany.php">
		<?php if($offset == $companyBuffer->count()){ echo "<fieldset disabled =\"disabled\">";}?>
				<input hidden name="next10"
					value="<?php echo $_SESSION['offset'];?>" /> <input type="submit"
					value="Next 10" />
					<?php if($offset == $companyBuffer->count()){ echo "</fieldset>";}?>
			</form></td>
	</table>
	</html>