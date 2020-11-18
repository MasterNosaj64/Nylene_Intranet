<?php
    /* Name: newDistributorQuote.php
     * Author: Kaitlyn Breker
     * Last Modified: November 17th, 2020
     * Purpose: File called when user clicks submit on the input distributor form. Inserts form information into
     *          the distributor_quote_form table of the database.
     */

    session_start();
	include '../Database/connect.php';
	
	$conn = getDBConnection();
	
	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {

		$interaction_id = $_SESSION['interaction_id'];
		
		/*Prepare insert statement into the distributor_quote_form table*/
		$stmt = $conn->prepare("INSERT INTO distributor_quote_form (
					quote_date, 
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
		
		/*Assign values to variables and execute*/
		$quoteDate = htmlspecialchars(strip_tags($_POST["quote_date"]));
		$quoteNum = htmlspecialchars(strip_tags($_POST["quote_num"]));
		$productName = htmlspecialchars(strip_tags($_POST["product_name"]));
		$payment_terms = htmlspecialchars(strip_tags($_POST["payment_terms"]));
		$productDesc = htmlspecialchars(strip_tags($_POST["product_desc"]));
		$ltlQuantities = htmlspecialchars(strip_tags($_POST["ltl_quantities"]));
		$annualVol = htmlspecialchars(strip_tags($_POST["annual_vol"]));
		$specialTerms = htmlspecialchars(strip_tags($_POST["special_terms"]));
		$OEM = htmlspecialchars(strip_tags($_POST["OEM"]));
		$application = htmlspecialchars(strip_tags($_POST["application"]));
		$truckLoad = htmlspecialchars(strip_tags($_POST["truck_load"]));
		$range40up = htmlspecialchars(strip_tags($_POST["range40up"]));
		$range2240 = htmlspecialchars(strip_tags($_POST["range2240"]));
		$range1122 = htmlspecialchars(strip_tags($_POST["range1122"]));
		$range610 = htmlspecialchars(strip_tags($_POST["range610"]));
		$range24 = htmlspecialchars(strip_tags($_POST["range24"]));
		
		/*Bind statement parameters to statement*/
		$stmt->bind_param("ssssssisssisssss", $quoteDate, $quoteNum, $productName, $payment_terms, $productDesc,
		  $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		  $truckLoad, $range40up, $range2240, $range1122, $range610, $range24); 
		
		$stmt->execute();
				
		/*Prepare insert statement into the interaction_relational_form table*/
		$stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id,
                    form_id,
                    form_type)
                    VALUES (?, ?, ?)");	
			
		/*Assign values to variables*/
		$interactionNum = $interaction_id;
		$formID = $conn->insert_id; //retrieve id of last query under $conn
		$formType = 4;
		
		/*Bind statement parameters to statement*/
		$stmt2->bind_param("iii", $interactionNum, $formID, $formType);
		
		/*Execute statement*/
		$stmt2->execute();
		
		/*Close statements*/
		$stmt->close();
		$stmt2->close();
		
		 /*Search follow up info using interaction id posted from session value*/
		$interactionQuery = "SELECT status, follow_up_type FROM interaction
								WHERE interaction_id = ". $interactionNum;
		$interactionResult = $conn->query($interactionQuery);
		$interactionRow = mysqli_fetch_array($interactionResult);
		

		/*Code for updating date in interaction table if form selected*/
		if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
		    /*Prepare Update statement into the interaction table to update notification date*/
		    $stmt3 = $conn->prepare("UPDATE interaction SET follow_up_date = ?
                                        WHERE interaction_id = ?");
		    
		    /*Assign follow up modified - must convert to date, modify, than convert back to string*/
		    $fDate = strtotime($quoteDate);
		    $followDate = date("Y/m/d", $fDate);
		    $followUpDate = date_create($followDate);
		    date_modify($followUpDate, "+30 days");
		    $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
		    
		    /*Bind statement parameters to statement*/
		    $stmt3->bind_param("si", $followUpDateFormatted, $interactionNum);
		    
		    /*Execute statement*/
		    $stmt3->execute();
		    $stmt3->close();
		    
		} else {
		   //do nothing
		}
		
		/*Close connection*/
		$conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
	}

?>
