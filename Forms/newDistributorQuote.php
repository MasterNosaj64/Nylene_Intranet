<?php
    /* Name: newLtlQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: October 11th, 2020
     * Purpose: File called when user clicks submit on the input distributor form. Inserts form information into
     *          the distributor_quote_form table of the database.
     */

    session_start();
	include '../Database/connect.php';
	
	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {

		$interaction_id = $_SESSION['interaction_id'];
		
		/*Prepare insert statement into the distributor_quote_form table*/
		$stmt = $conn->prepare("INSERT INTO distributor_quote_form (
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
                    range40up, 
					range2240, 
					range1122, 
					range610, 
					range24)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		

		/*Bind statement parameters to statement*/
		$stmt->bind_param("ssssssisssisssss", $dateCreated, $quoteNum, $productName, $payment_terms, $productDesc, 
		                  $ltlQuantities, $annualVol, $specialTerms, $OEM, $application, 
		                  $truckLoad, $range40up, $range2240, $range1122, $range610, $range24); 
		
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
		$range40up = $_POST["range40up"];
		$range2240 = $_POST["range2240"];
		$range1122 = $_POST["range1122"];
		$range610 = $_POST["range610"];
		$range24 = $_POST["range24"];
		
		$stmt->execute();
			
		/*Select the form Id from the database*/
		$getFormId = "SELECT distributor_quote_id FROM distributor_quote_form ORDER BY distributor_quote_id DESC";
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
		$formID = $id_form['distributor_quote_id'];
		$formType = 4;
		
		$stmt2->execute();
		
		/*Close statements and connection*/
		$stmt->close();
		$stmt2->close();
		$conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
	}

?>
