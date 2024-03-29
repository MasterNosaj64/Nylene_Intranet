<?php
/*
 * FileName: searchCompany.php
 * Version Number: 2.5
 * Date Modified: 12/07/2020
 * Author: Jason Waid (later modified by Madhav Sachdeva)
 * Purpose:
 * Search for companies in the database.
 */
session_start();

// The following is used in sessionController.php
$_SESSION['searchCompanyVisited'] = basename($_SERVER['PHP_SELF']);

// The navigation bar for the website
include '../NavPanel/navigation.php';

// connection to the database
include '../Database/connect.php';
// input handling functions

// Company Object
include '../Database/Company.php';

// Employee Object
include '../Database/Employee.php';

// list buffer
include '../Database/listBuffer.php';

// Attempt connection to DB for Companies
$conn_Company = getDBConnection();

// Attempt connection to DB for Employees
$conn_Employee = getDBConnection();

// Handler for if the database connection fails
if ($conn_Company->connect_error || $conn_Employee->connect_error) {
    die("A connection failed: Company: " . $conn_Company->connect_error . "|| Employee: " . $conn_Employee->connect_error);
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
    $employeeTitle = array(); // array of role of employees
    $employeeTeam = array(); // array of employee Reports_to column
    $numEmployees = 0;

    // Store all employee names and id's in array
    // This is later used to the creation of the drop down menus
    while ($employeeListResult->fetch()) {

        array_push($employeeTitle, $employeeList->getTitle());
        array_push($employeeIds, $employeeList->getId());
        array_push($employeeNames, $employeeList->getName());
        array_push($employeeTeam, $employeeList->getReports_To());

        $numEmployees ++;
    }
    $employeeListResult->close();

    $name = "";
    $website = "http://";
    $address = "";
    $city = "";
    $state = "";
    $country = "";
    $assigned_To = "";
    $created_By = "";

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

        if (isset($_POST["search_By_Created_By"])) {

            $created_By = $_POST["search_By_Created_By"];
        }

        if (strcmp($website, "") == 0) {
            $website = "http://";
        }

        $companies = new Company($conn_Company);
        $companyResult = $companies->searchInclude($name, $website, $address, $city, $state, $country, $assigned_To, $created_By);
    } else {

        if (! isset($_GET['sort']) || (isset($_GET['sort']) && ! isset($_SESSION['buffer']))) {
            $companies = new Company($conn_Company);
            $companyResult = $companies->read();
        }
        // The default option, grabs all companies when initialy loading the page or when not search criteria is entered when clicking search
    }
}

if (isset($_GET['sort'])) {
    $sortType = $_GET['sort'];
} else {
    $sortType = 1;
}

?>
<html>
<head>
<title>Search Company</title>
<link rel="stylesheet" href="../CSS/company.customer.interaction.css">
</head>
<body style="overflow: scroll">
	<!-- Company Search -->
	<!-- Below is the search company functionality -->
	<button type="button"
		style="background-color: rgb(65, 95, 142); color: #ffffff; font-weight: bold;"
		id="searchButton" value="0" class="collapsible">Expand Search</button>
	<div hidden="true" class="content">

		<form method="post"
			action="searchCompany.php?sort=
		<?php echo $_GET['sort'];?>"
			name="search_company_data" autocomplete="off">
			<table class="form-table">
				<tr>
					<td>Name:</td>
					<td><input type="text" value="<?php echo $name;?>"
						name="search_By_Name" class="search-bar-item" /></td>
					<td>Website:</td>
					<td><input type="text" value="<?php echo $website;?>"
						name="search_By_Website" id="search-bar-item" /></td>
					<td>Assigned To:</td>
					<td><select id="payment_terms" name="search_By_Assigned_To">
							<option></option>
				<?php

    // Drop down menu for assign to list
    for ($i = 0; $i < $numEmployees; $i ++) {

        if ($_SESSION['role'] == 'admin') {
            ?>
            <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
        <?php
        } else if ($_SESSION['role'] == 'supervisor') {
            if (($employeeIds[$i] == $_SESSION['userid']) || (($employeeTitle[$i] == 'ind_rep') && ($employeeTeam[$i] == $_SESSION['userid'])) || (($employeeTitle[$i] == 'sales_rep') && ($employeeTeam[$i] == $_SESSION['userid']))) {
                ?>
               <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
            <?php
            }
        } else if ($_SESSION['role'] == 'ind_rep') {
            if ($employeeIds[$i] == $_SESSION['userid']) {
                ?>
                  <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
          <?php
            }
        } else {
            if (($employeeIds[$i] == $_SESSION['userid']) || ((($employeeTitle[$i] == 'sales_rep') || ($employeeTitle[$i] == 'ind_rep')) && ($employeeTeam[$i] == $_SESSION['reports_to']))) {
                ?>
                
                 <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
                 <?php
            }
        }
    }
    ?>
				</select></td>
				
<?php

if ($_SESSION["role"] == "admin" || $_SESSION["role"] == "supervisor") { // only show created by list if signed in as admin and supervisor

    ?>
    <td>Created By:</td>
					<td><select name="search_By_Created_By" id="payment_terms">
							<option></option>
<?php
    for ($i = 0; $i < $numEmployees; $i ++) {

        if ($_SESSION['role'] == 'admin') {
            ?>
            <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
        <?php
        } else if ($_SESSION['role'] == 'supervisor') {
            if (($employeeIds[$i] == $_SESSION['userid']) || (($employeeTitle[$i] == 'ind_rep') && ($employeeTeam[$i] == $_SESSION['userid'])) || (($employeeTitle[$i] == 'sales_rep') && ($employeeTeam[$i] == $_SESSION['userid']))) {
                ?>
               <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
            <?php
            }
        } else if ($_SESSION['role'] == 'ind_rep') {
            if ($employeeIds[$i] == $_SESSION['userid']) {
                ?>
                  <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
          <?php
            }
        } else {
            if (($employeeIds[$i] == $_SESSION['userid']) || ((($employeeTitle[$i] == 'sales_rep') || ($employeeTitle[$i] == 'ind_rep')) && ($employeeTeam[$i] == $_SESSION['reports_to']))) {
                ?>
                
                 <option value="<?php echo $employeeIds[$i];?>"><?php echo $employeeNames[$i];?></option>
                 <?php
            }
        }
    }
    ?>
</select></td>
<?php
}
?>
				</tr>
				<tr>
					<td>Address:</td>
					<td><input type="text" value="<?php echo $address;?>"
						name="search_By_Address" class="search-bar-item" /></td>
					<td>City:</td>
					<td><input type="text" value="<?php echo $city;?>"
						name="search_By_City" class="search-bar-item" /></td>
					<td>State:</td>
					<td><input type="text" value="<?php echo $state;?>"
						name="search_By_State" class="search-bar-item" /></td>
					<td>Country:</td>
					<td><input type="text" value="<?php echo $country;?>"
						name="search_By_Country" class="search-bar-item" /></td>

				</tr>
			</table>
			<input type="submit" value="Search" name="Search"
				style="width: 100%; margin: 15 5 1 5; text-align: center box-sizing border-box; border: 2px solid #000; border-radius: 4px; font-size: 20px; background-color: rgb(167, 197, 244); padding: 5px 12px 5px 12px; font-weight: bold;" />
		</form>
		<button onclick="clearSearchBar()"
			style="background-color: rgb(255, 0, 0); color: #ffffff; font-weight: bold;">Clear
			Search</button>
	</div>
<?php
// Change this variable to modify the page size
$maxGridSize = 4;

if (isset($_SESSION['buffer'])) {

    $companyBuffer = $_SESSION['buffer'];

    // checks page request (next or previous)
    // offset used to contrill the current index in the linked list structure
    if (isset($_POST['next'])) {
        $_SESSION['offset'] += $maxGridSize;
        if ($_SESSION['offset'] > $companyBuffer->count()) {
            $_SESSION['offset'] -= $maxGridSize;
        }

        $companyBuffer = nextBufferPage($companyBuffer);
    } else if (isset($_POST['previous'])) {
        $_SESSION['offset'] -= $maxGridSize;

        if ($_SESSION['offset'] < 0) {
            $_SESSION['offset'] = 0;
        }
        $companyBuffer = previousBufferPage($companyBuffer);
    } else {

        $companyBuffer = getSortingCompany($companyBuffer);
    }
} else {

    // attempt of creating a buffer for a list of companies
    $companyBuffer = create_Company_Buffer($companyResult, $companies);

    if (isset($_GET['sort'])) {
        $companyBuffer = getSortingCompany($companyBuffer);
    }
}

echo "{$companyBuffer->count()} record(s) found";

?>
	<!-- Company Search -->
	<!-- Below is the table that is presented to the user for the query results on the Company table -->
	<table class="form-table">
		<thead>
			<tr> 
		<?php printHeadersCompany($sortType)?>	
		</tr>
		</thead>

<?php
for ($offset = $_SESSION['offset']; $companyBuffer->valid(); $companyBuffer->next()) { // Unserialize the object stored in the companyBuffer

    $currentCompanyNode = unserialize($companyBuffer->current()); // temp var for storing current company data members
    $companyId = $currentCompanyNode->getCompanyId();
    $companyName = $currentCompanyNode->getName();
    $companyWebsite = $currentCompanyNode->getWebsite();
    $companyEmail = $currentCompanyNode->getEmail();
    $companyStreet = $currentCompanyNode->getBillingAddressStreet();
    $companyCity = $currentCompanyNode->getBillingAddressCity();
    $companyState = $currentCompanyNode->getBillingAddressState(); // Get created by if admin is logged in

    // Get created by
    $createdByEmployee = new Employee(getDBConnection());
    $createdByEmployee = $createdByEmployee->searchById($currentCompanyNode->getCreatedBy());

    // Get assigned to
    $assignedToEmployee = new Employee(getDBConnection());
    $assignedToEmployee = $assignedToEmployee->searchById($currentCompanyNode->getAssignedTo());

    echo "
			<tr>
			";
    echo "
			<td>{$companyName}</td>";
    echo "
			<td><a href=\"{$companyWebsite}\">{$companyWebsite}</a></td>";
    echo "
			<td><a href=\"mailto: {$companyEmail}\">{$companyEmail}</a></td>";
    echo "
			<td>{$companyStreet}</td>";
    echo "
			<td>{$companyCity}</td>";
    echo "
			<td>{$companyState}</td>";
    echo "
			<td>{$assignedToEmployee->getName()}</td>";

    // Creates createdByColumn if supervisor or admin is logged in
    if (($_SESSION["role"] == "admin") || ($_SESSION["role"] == "supervisor")) {
        echo "
			<td>{$createdByEmployee->getName()}</td>";
    }
    echo "<td><form action='./editCompany.php' method='post'>
				<input hidden name='company_id_edit' value='{$companyId}'/> <input
					type='submit' value='edit'/>
			</form>
			<form action='./viewCompany.php?sort=1' method='post'>
				<input hidden name='company_id_view' value='{$companyId}'/> <input
					type='submit' value='view' style ='width: 100%;
	text-align: center box-sizing border-box;
	border: 2px solid #000;
	border-radius: 4px;
	font-size: 20px;
	background-color: rgb(167, 197, 244);'/>
			</form></td>";
    echo "
		</tr>
		";

    $offset ++;
    if ($offset == ($_SESSION['offset'] + $maxGridSize)) {
        break;
    }
}
$conn_Company->close();
?>
</table>
	<!-- Next 10 Previous 10 Buttons -->
	<!-- The following code presents the user with buttons to navigate the list of customers
	       If the list has reached its end, next10 will be disabled, same if the user is already at the begining of the list -->
	<table>
		<tr>
			<td>
				<form method='post'
					action='searchCompany.php?sort=<?php echo $_GET['sort'];?>'>

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
					action='searchCompany.php?sort=<?php echo $_GET['sort'];?>'>

					<fieldset style='border-style: none'
						<?php if ($offset == $companyBuffer->count()) { echo "disabled ='disabled'";}?>>
						<input hidden='true' name='next'
							value='<?php echo $_SESSION["offset"];?>' /> <input type='submit'
							value='Next &#x21DB;' />
					</fieldset>
				</form>
			</td>
		</tr>
	</table>


	<!-- Script for collapsible search menu -->
	<!-- https://www.w3schools.com/howto/howto_js_collapsible.asp -->
	<script>
document.getElementById("searchButton").addEventListener("click", function() {

if(this.value == 0){
	this.innerHTML = "Hide Search";
	this.value = 1;
	event.target.style = "background-color: rgb(211, 211, 211); color: #000000; font-weight: bold;";
}
else if(this.value == 1){
	this.innerHTML = "Expand Search";
	this.value = 0;
	event.target.style = "background-color: rgb(65, 95, 142); color: #ffffff; font-weight: bold;";
}	
});



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
		window.location.href = "./searchCompany.php?sort=" + col;
}
	</script>

	<!-- Script for reseting search menu vals when clicking clear -->
	<script>

function clearSearchBar(){

	var searchBarBox = document.getElementsByClassName("search-bar-item");

	for (i = 0; i < searchBarBox.length; i++) {

		searchBarBox[i].value = "";

	}
//box for search by website
	var searchBarBox = document.getElementById("search-bar-item");

	searchBarBox.value = "http://";	
}
	</script>
</body>
</html>
