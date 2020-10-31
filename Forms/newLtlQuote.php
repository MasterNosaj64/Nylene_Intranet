<?php
    /* Name: newLtlQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: October 11th, 2020
     * Purpose: File called when user clicks submit on the input light truckload form. Inserts form information into 
     *          the ltl_quote table of the database.
     */

    session_start();
	include '../Database/connect.php';

	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {

		$interaction_id = $_SESSION['interaction_id'];

		/*Prepare insert statement into the ltl_quote table*/
		$stmt = $conn->prepare("INSERT INTO ltl_quote (
					date_created,
					quote_num,
					product_name,
					payment_terms,
					product_desc,
					ltl_quantities,
					annual_vol,
					special_terms,
					OEM,
					application,
					truck_load,
					range1522,
					range1121,
					range510,
					range25,
                    range12, 
					range5)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		
		/*Bind statement parameters to statement*/
		$stmt->bind_param("ssssssisssissssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range1522, $range1121, $range510, $range25, $range12, $range5);
		
		//TODO: KAITLYN implement more security to protect against SQL injection
		//View ../Database/Company.php for code that can help
		
		/*Assign values to variables and execute*/
		$dateCreated = $_POST["date_created"];
		$quoteNum = $_POST["quote_num"];
		$productName = $_POST["product_name"];
		$payment_terms = $_POST["payment_terms"];
		$productDesc = $_POST["product_desc"];
		$ltlQuantities = $_POST["ltl_quantities"]; 
		$annualVol = $_POST["annual_vol"];
		$specialTerms = $_POST["special_terms"];
		$OEM = $_POST["OEM"];
		$application = $_POST["application"];
		$truckLoad = $_POST["truck_load"];
		$range1522 = $_POST["range1522"];
		$range1121 = $_POST["range1121"];
		$range510 = $_POST["range510"];
		$range25 = $_POST["range25"];
		$range12 = $_POST["range12"];
		$range5 = $_POST["range5"];
		
		$stmt->execute();
	
		/*Select the form Id from the database*/
		$getFormId = "SELECT ltl_quote_id FROM ltl_quote ORDER BY ltl_quote_id DESC";
		$formId = $conn->query($getFormId);
		$id_form = mysqli_fetch_array($formId);

		/*Prepare insert statement into the interaction_relational_form table*/
		$stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id,
                    form_id,
                    form_type)
                    VALUES (?, ?, ?)");
		
		/*Bind statement parameters to statement*/
		$stmt2->bind_param("iii", $interactionNum, $formID, $formType);
		
		/*Assign values to variables and execute*/
		$interactionNum = $interaction_id;
		$formID = $id_form['ltl_quote_id'];
		$formType = 2;
		
		$stmt2->execute();
		
		/*Close statements and connection*/
		$stmt->close();
		$stmt2->close();
		$conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
					
	}

?>

