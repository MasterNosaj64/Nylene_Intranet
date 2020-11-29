<?php
    /* Name: editLtlQuote_Database.php
     * Author: Karandeep Singh, modified by Kaitlyn Breker
     * Last Modified: November 29th, 2020
     * Purpose: File called when user clicks submit on the edit light truckload form. Updates form information into 
     *          the ltl_quote table of the database. Inserts into interaction autoupdated fields, and followup date 
     *          information.
     */

    session_start();
	include '../Database/connect.php';
	
	$conn = getDBConnection();

	
	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
	    
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
	    $range1522 = htmlspecialchars(strip_tags($_POST["range1522"]));
	    $range1121 = htmlspecialchars(strip_tags($_POST["range1121"]));
	    $range510 = htmlspecialchars(strip_tags($_POST["range510"]));
	    $range25 = htmlspecialchars(strip_tags($_POST["range25"]));
	    $range12 = htmlspecialchars(strip_tags($_POST["range12"]));
	    $range5 = htmlspecialchars(strip_tags($_POST["range5"]));
	    $ltl_quote_id = htmlspecialchars(strip_tags($_POST["ltl_quote_id"]));
	    $interactionNum = $_SESSION['interaction_id'];

	    /*AUTO UPDATE INTERACTION COMMENTS*/
	    /*Selection statement for form*/
	    $ltlQuery = "SELECT * FROM ltl_quote WHERE ltl_quote_id = ". $ltl_quote_id;
	    $ltlResults = $conn->query($ltlQuery);
	    $ltlRow = mysqli_fetch_array($ltlResults);
	    
	    /*Retrieve original values from db*/
	    $old_quoteDate = $ltlRow['quote_date'];
	    $old_quoteNum = $ltlRow['quote_num'];
	    $old_productName = $ltlRow['product_name'];
	    $old_payment_terms = $ltlRow['payment_terms'];
	    $old_productDesc = $ltlRow['product_desc'];
	    $old_ltlQuantities = $ltlRow['ltl_quantities'];
	    $old_annualVol = $ltlRow['annual_vol'];
	    $old_specialTerms = $ltlRow['special_terms'];
	    $old_OEM = $ltlRow['OEM'];
	    $old_application = $ltlRow['application'];
	    $old_truckLoad = $ltlRow['truck_load'];
	    $old_range1522 = $ltlRow['range1522'];
	    $old_range1121 = $ltlRow['range1121'];
	    $old_range510 = $ltlRow['range510'];
	    $old_range25 = $ltlRow['range25'];
	    $old_range12 = $ltlRow['range12'];
	    $old_range5 = $ltlRow['range5'];
	    
	    $commentString = "";
	    $autoUpdate = 0;
	    $dateModified = date("Y-m-d");
	    
	    /*CREATE STRING OF EDITS*/
	    $commentString = "Form Modified on {$dateModified}. Old form value(s): ";
	    
	    /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
	    /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
	    if (strcmp($old_quoteDate,$quoteDate) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Quote Date: {$old_quoteDate}, ";
	    }
	    if(strcmp($old_quoteNum, $quoteNum) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Quote Num: {$old_quoteNum}, ";
	    }
	    if (strcmp($old_productName, $productName) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Product Name: {$old_productName}, ";
	    }
	    if (strcmp($old_payment_terms, $payment_terms) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Payment Terms: {$old_payment_terms}, ";
	    }
	    if (strcmp($old_productDesc, $productDesc) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Product Desc: {$old_productDesc}, ";
	    }
	    if (strcmp($old_ltlQuantities, $ltlQuantities) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "LTL Quant: {$old_ltlQuantities}, ";
	    }
	    if ($old_annualVol != $old_annualVol){
	        $autoUpdate = 1;
	        $commentString .= "Annual Volume: {$old_annualVol}, ";
	    }
	    if (strcmp($old_specialTerms, $specialTerms) !==0) {
	        $autoUpdate = 1;
	        $commentString .= "Special Terms: {$old_specialTerms}, ";
	    }
	    if (strcmp($old_OEM, $OEM) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "OEM: {$old_OEM}, ";
	    }
	    if (strcmp($old_application, $application) !== 0){
	        $autoUpdate = 1;
	        $commentString .= "Application value: {$old_application}, ";
	    }
	    if ($old_truckLoad != $truckLoad){ //this one
	        $autoUpdate = 1;
	        $commentString .= "TruckLoad: {$old_truckLoad}, ";
	    }
	    if ($old_range1522 != $range1522){
	        $autoUpdate = 1;
	        if ($old_range1522 == null){
	            $commentString .= "New quote created, ";
	        } else {
	            $commentString .= "Old Quote: {$old_range1522}, {$old_range1121}, {$old_range510}, {$old_range25}, {$old_range12}, {$old_range5}, ";
	        }
	    }
	    
	    $commentString .= "END Modified.";
	    
	    /*Search follow up info using interaction id posted from session value*/
	    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
	    $interactionResult = $conn->query($interactionQuery);
	    $interactionRow = mysqli_fetch_array($interactionResult);
	    
	    
	    /*UPDATING THE FORM IN THE DATABASE*/
		/*Prepare insert statement into the ltl_quote table*/
		$stmt = $conn->prepare("UPDATE ltl_quote SET
					quote_date = ?,
					quote_num = ?,
					product_name = ?,
					payment_terms = ?,
					product_desc = ?,
					ltl_quantities = ?,
					annual_vol = ?,
					special_terms = ?,
					OEM = ?,
					application = ?,
					truck_load = ?,
					range1522 = ?,
					range1121= ?,
					range510 = ?,
					range25 = ?,
                    range12 = ?, 
					range5 = ?
                    WHERE ltl_quote_id = ?");

        $stmt->bind_param("ssssssisssissssssi", $quoteDate, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range1522, $range1121, $range510, $range25, $range12, $range5, $ltl_quote_id);
		
		$stmt->execute();
        $stmt->close();

        
        /*UPDATING THE STATUS AND FOLLOWUP IN THE INTERACTION TABLE*/
        /*Code for updating date in interaction table if form selected*/
        if (($interactionRow['status'] == 'open') && ($interactionRow['follow_up_type'] == 'form')){
            /*Prepare Update statement into the interaction table to update notification date*/
            $stmt2 = $conn->prepare("UPDATE interaction SET
                                    follow_up_date = ?
                                    WHERE interaction_id = ?");
            
            /*Assign follow up modified - must convert to date, modify, than convert back to string*/
            $fDate = strtotime($quoteDate);
            $followDate = date("Y/m/d", $fDate);
            $followUpDate = date_create($followDate);
            date_modify($followUpDate, "+30 days");
            $followUpDateFormatted = date_format($followUpDate,"Y/m/d");
            
            /*Bind statement parameters to statement*/
            $stmt2->bind_param("si", $followUpDateFormatted, $interactionNum);
            
            /*Execute statement*/
            $stmt2->execute();
            $stmt2->close();
            
        } else {
            //do nothing
        }
        
        /*UPDATING THE COMMENTS IN THE INTERACTION TABLE*/
        /*If autoUpdate == 1, do changes*/
        if ($autoUpdate == 1){
            
            //Implement This
            /*Ensure strlen(comments) does not reach max length of field*/
            
            
            $comments = $interactionRow['comments'];
            $comments .= "\n{$commentString}";
            $stmt3 = $conn->prepare("UPDATE interaction SET
                                        comments = ?
                                        WHERE interaction_id = ?");
            $stmt3->bind_param("si", $comments, $interactionNum);
            $stmt3->execute();
            $stmt3->close();
        } else {
            //do nothing
        }
        
        $conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
					
	}

?>

	