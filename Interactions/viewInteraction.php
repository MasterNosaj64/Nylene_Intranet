<?php
/*
 * FileName: viewInteraction.php
 * Version Number: 1.0
 * Date Modified: 11/15/2020
 * Author: Jason Waid
 * Purpose:
 *  View interaction data in the database.
 */
session_start();

//interaction object
include '../Database/Interaction.php';

//customer object
include '../Database/Customer.php';

//company object
include '../Database/Company.php';

//nav bar
include '../NavPanel/navigation.php';

//connection to the database
include '../Database/connect.php';

$conn_Interaction = getDBConnection();

$conn_Company = getDBConnection();

$conn_Customer = getDBConnection();

$conn_Forms = getDBConnection();

if (isset($_POST['interaction_id'])) {

    //the following variables are used in navigation.php
    //View navigation.php for more information
    $_SESSION['interaction_id'] = $_POST['interaction_id'];
    //The navigation bar for the website


    //Handler for if the database connection fails
    if ($conn_Interaction->connect_error || $conn_Company->connect_error || $conn_Customer->connect_error || $conn_Forms->connect_error) {
        die("Connection failed: " . $conn_Interaction->connect_error ." || ".$conn_Company->connect_error." || ". $conn_Customer->connect_error ." || ". $conn_Forms->connect_error);
    } else {
        
        $interaction = new Interaction($conn_Interaction);
        $interaction = $interaction->searchId($_SESSION['interaction_id']);
      
        
        $_SESSION['company_id'] = $interaction->getCompanyId();
        
        $company = new Company($conn_Company);
        $company = $company->searchId($interaction->getCompanyId());
        $companyAddress = "{$company->getBillingAddressStreet()}, {$company->getBillingAddressCity()}, {$company->getBillingAddressState()}, {$company->getBillingAddressCounty()}, {$company->getBillingAddressPostalCode()}";

        
        $customer = new Customer($conn_Customer);
        $customer = $customer->searchById($interaction->getCustomerId());
        
        $query_view_form = "SELECT * FROM nylene.interaction_relational_form WHERE interaction_id = " . $_SESSION['interaction_id'];
        $viewInteractionForm = mysqli_fetch_array($conn_Forms->query($query_view_form));
        
        $conn_Interaction->close();
        $conn_Company->close();
        $conn_Customer->close();
        $conn_Forms->close();
    }
} else {
    //If the above results in error redirect the user to homepage
    
    echo "<meta http-equiv = \"refresh\" content = \"0 url = ../Home/Homepage.php\" />;";
    exit();
}
?>
<!-- Table containing the company/customer information -->
<html>
<link rel="stylesheet" href="../CSS/table.css">
<body>
	<!-- <h1>Interaction</h1> -->
	<table class="form-table" border=5>
		<tr>
			<td>Company:</td>
			<td><?php echo $company->getName();?></td>
			<td>Address:</td>
			<td><?php echo $companyAddress;?></td>
			<td>Company Email:</td>
			<td><a href="mailto:<?php echo $company->getEmail();?>"><?php echo $company->getEmail();?></a></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?php echo $customer->getName();?></td>
			<td>Email:</td>
			<td><a
				href="mailto: <?php echo $customer->getEmail();?>"><?php echo $customer->getEmail();?></a></td>
			<td>Phone:</td>
			<td><?php echo $customer->getPhone();?></td>
		</tr>
		<tr>
			<td>Reason:</td>
			<td><?php echo $interaction->getReason();?></td>
			<td>Date Created:</td>
			<td><?php echo $interaction->getDateCreated();?></td>
			<td>Form:</td>
			<td>
		<?php
//The following code checks which form (if any) is assigned to this interaction
//Then it adds a button to link to the corresponding form.
if ($viewInteractionForm != null) {
    // Sample Form
    if ($viewInteractionForm['form_type'] == 1) {

        echo "<form method=\"post\" action=\"../Forms/sample_form_view.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Sample Request Form\"/>
                    </form>";
    } // Light Truck Load Quote Form
    else if ($viewInteractionForm['form_type'] == 2) {

        echo "<form method=\"post\" action=\"../Forms/viewLtlQuote.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Light Truckload Form\"/>
                    </form>";
    } // Truck Load Quote Form
    else if ($viewInteractionForm['form_type'] == 3) {

        echo "<form method=\"post\" action=\"../Forms/viewTlQuote.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Truckload Quote Form\"/>
                    </form>";
    } // Distributor Quote Form
    else if ($viewInteractionForm['form_type'] == 4) {

        echo "<form method=\"post\" action=\"../Forms/viewDistributorQuote.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Distributor Quote Form\"/>
                    </form>";
    } // Marketing Request Form
    else if ($viewInteractionForm['form_type'] == 5) {

        echo "<form method=\"post\" action=\"../Forms/viewMarketRequest.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Market Request Form\"/>
                    </form>";
    } // Business Credit Application Form
    else if ($viewInteractionForm['form_type'] == 6) {

        echo "<form method=\"post\" action=\"../Forms/viewCreditBusinessApplication.php\">
                   <input hidden type=\"text\" name=\"id\" value=\"" . $viewInteractionForm['form_id'] . "\">
                        <input type=\"submit\" value=\"View Business Credit App. Form\"/>
                    </form>";
    }
} else {
    //No Form
    echo "--";
}
?>
		</td>
		</tr>
		<tr>
			<td colspan=6><textarea readonly rows="20" cols="100"><?php echo $interaction->getComments(); ?> </textarea></td>
		</tr>
	</table>
</body>
</html>
