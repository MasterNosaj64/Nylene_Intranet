<?php
/*
 * FileName: viewInteraction.php
 * Version Number: 0.8
 * Author: Jason Waid
 * Purpose:
 *  View interaction data in the database.
 */
session_start();

if (isset($_POST['interaction_id'])) {

    //the following variables are used in navigation.php
    //View navigation.php for more information
    $_SESSION['interaction_id'] = $_POST['interaction_id'];
    //The navigation bar for the website
    include '../navigation.php';
    //connection to the database
    include '../Database/connect.php';

    //Handler for if the database connection fails
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Get Interaction data
        $query_view_interaction = "SELECT * FROM nylene.interaction WHERE interaction_id = " . $_SESSION['interaction_id'];
        $viewInteractionData = mysqli_fetch_array($conn->query($query_view_interaction));

        $query_view_company = "SELECT * FROM nylene.company WHERE company_id = " . $viewInteractionData['company_id'];
        $viewCompanyData = mysqli_fetch_array($conn->query($query_view_company));

        $companyAddress = $viewCompanyData["billing_address_street"] . ", " . $viewCompanyData["billing_address_city"] . ", " . $viewCompanyData["billing_address_state"] . ", " . $viewCompanyData["billing_address_country"] . ", " . $viewCompanyData["billing_address_postalcode"];

        $query_view_customer = "SELECT * FROM nylene.customer WHERE customer_id = " . $viewInteractionData['customer_id'];
        $viewCustomerData = mysqli_fetch_array($conn->query($query_view_customer));

        $query_view_form = "SELECT * FROM nylene.interaction_relational_form WHERE interaction_id = " . $_SESSION['interaction_id'];
        $viewInteractionForm = mysqli_fetch_array($conn->query($query_view_form));
        
        $conn->close();
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
			<td><?php echo $viewCompanyData['company_name'];?></td>
			<td>Address:</td>
			<td><?php echo $companyAddress;?></td>
			<td>Company Email:</td>
			<td><a href="mailto:<?php echo $viewCompanyData['company_email'];?>"><?php echo $viewCompanyData['company_email'];?></a></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?php echo $viewCustomerData['customer_name'];?></td>
			<td>Email:</td>
			<td><a
				href="mailto: <?php echo $viewCustomerData['customer_email'];?>"><?php echo $viewCustomerData['customer_email'];?></a></td>
			<td>Phone:</td>
			<td><?php echo $viewCustomerData['customer_phone'];?></td>
		</tr>
		<tr>
			<td>Reason:</td>
			<td><?php echo $viewInteractionData['reason'];?></td>
			<td>Date Created:</td>
			<td><?php echo $viewInteractionData['date_created'];?></td>
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
			<td colspan=6><textarea readonly rows="20" cols="100"><?php echo $viewInteractionData['comments']; ?> </textarea></td>
		</tr>
	</table>
</body>
</html>
