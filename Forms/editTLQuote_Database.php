<?php
    /* Name: newTLQuote.php
     * Author: Karandeep Singh, modified by Kaitlyn Breker
     * Last Modified: November 29th, 2020
     * Purpose: File called when user clicks submit on the edit truckload form. Inserts form information into the 
     *          tl_quote table of the database. Inserts into interaction autoupdated fields, and followup date information.
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
	    $range40plus = htmlspecialchars(strip_tags($_POST["range40plus"]));
	    $range2240 = htmlspecialchars(strip_tags($_POST["range2240"]));
	    $range1022 = htmlspecialchars(strip_tags($_POST["range1022"]));
	    $range610 = htmlspecialchars(strip_tags($_POST["range610"]));
	    $range46 = htmlspecialchars(strip_tags($_POST["range46"]));
	    $range24 = htmlspecialchars(strip_tags($_POST["range24"]));
	    $tl_quote_id = htmlspecialchars(strip_tags($_POST["tl_quote_id"]));
	    $interactionNum = $_SESSION['interaction_id'];
	    
	    /*AUTO UPDATE INTERACTION COMMENTS*/
	    /*Select current database fields*/
	    $truckLoadQuery = "SELECT * FROM tl_quote WHERE tl_quote_id = ". $tl_quote_id;
	    $truckLoadResults = $conn->query($truckLoadQuery);
	    $truckLoadRow = mysqli_fetch_array($truckLoadResults);
	    
	    /*Retrieve original values from db*/
	    $old_quoteDate = $truckLoadRow['quote_date'];
	    $old_quoteNum = $truckLoadRow['quote_num'];
	    $old_productName = $truckLoadRow['product_name'];
	    $old_payment_terms = $truckLoadRow['payment_terms'];
	    $old_productDesc = $truckLoadRow['product_desc'];
	    $old_ltlQuantities = $truckLoadRow['ltl_quantities'];
	    $old_annualVol = $truckLoadRow['annual_vol'];
	    $old_specialTerms = $truckLoadRow['special_terms'];
	    $old_OEM = $truckLoadRow['OEM'];
	    $old_application = $truckLoadRow['application'];
	    $old_truckLoad = $truckLoadRow['truck_load'];
	    $old_range40plus = $truckLoadRow['range40plus'];
	    $old_range2240 = $truckLoadRow['range2240'];
	    $old_range1022 = $truckLoadRow['range1022'];
	    $old_range610 = $truckLoadRow['range610'];
	    $old_range46 = $truckLoadRow['range46'];
	    $old_range24 = $truckLoadRow['range24'];
	    
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
	    if ($old_range40plus != $range40plus){
	        $autoUpdate = 1;
	        if ($old_range40plus == null){
	            $commentString .= "New quote created, ";
	        } else {
	            $commentString .= "Old Quote: {$old_range40plus}, {$old_range2240}, {$old_range1022}, {$old_range610}, {$old_range46}, {$old_range24}, ";
	        }
	    }
	    
	    $commentString .= "END Modified.";
	    
	    
	    /*Search follow up info using interaction id posted from session value*/
	    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
	    $interactionResult = $conn->query($interactionQuery);
	    $interactionRow = mysqli_fetch_array($interactionResult);
	    
	    
	    /*UPDATING THE FORM IN THE DATABASE*/
		/*Prepare insert statement into the tl_quote table*/
		$stmt = $conn->prepare("UPDATE tl_quote SET
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
                    range40plus = ?,
					range2240 = ?,
					range1022 = ?,
					range610 = ?,
                    range46 = ?,
					range24 = ? 
                    WHERE tl_quote_id=?");
		
        /*Bind statement parameters to statement*/
		$stmt->bind_param("ssssssisssissssssi", $quoteDate, $quoteNum, $productName, $payment_terms, $productDesc,
		  $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		  $truckLoad, $range40plus, $range2240, $range1022, $range610, $range46, $range24, $tl_quote_id);
		
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
		     
		     $comments = $interactionRow['comments'];
		     
		     /*Only update the comments in the interaction if the max length is not reached*/
		     $old_commentLength = strlen($comments);
		     
		     if($old_commentLength >= 1024){
		         //echo "Cannot append modified changes to comments, exceeding max length for comments in database";
		     } else {
		         
    		     /*Check new comments for length*/
    		     $comments .= "\n\n{$commentString}";
    		     $newCommentLength = strlen($comments);
    		     
    		     if($newCommentLength < 1024){
    		         
    		         /*Update comments in the interaction with the modified fields*/
        		     $stmt3 = $conn->prepare("UPDATE interaction SET comments = ?
                                                WHERE interaction_id = ?");
        		     $stmt3->bind_param("si", $comments, $interactionNum);
        		     $stmt3->execute();
        		     $stmt3->close();
    		     } else {
    		         //echo "Cannot append modified changes to comments, exceeding max length for comments in database";
    		     }
		     }
		 } else {
		     //do nothing
		 }
		 
        $conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php?sort=1\" />;";
		exit();
		
	}

?>