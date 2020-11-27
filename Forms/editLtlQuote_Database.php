<?php
    /* Name: editLtlQuote_Database.php
     * Author: Karandeep Singh, modified by Kaitlyn Breker
     * Last Modified: November 27th, 2020
     * Purpose: File called when user clicks submit on the edit light truckload form. Updates form information into 
     *          the ltl_quote table of the database.
     */

    session_start();
	include '../Database/connect.php';

	$conn = getDBConnection();

	
	/*Check the connection*/
	if ($conn-> connect_error) {
		
	    die("Connection failed: " . $conn-> connect_error);
	
	} else {
	    $interactionNum = $_SESSION['interaction_id'];

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
        
        $stmt->bind_param("ssssssisssissssssi", $quoteDate, $quoteNum, $productName, $payment_terms, $productDesc,
		    $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
		    $truckLoad, $range1522, $range1121, $range510, $range25, $range12, $range5, $ltl_quote_id);
		
		$stmt->execute();
        $stmt->close();
        
        /*Search follow up info using interaction id posted from session value*/
        $interactionQuery = "SELECT status, follow_up_type FROM interaction
								WHERE interaction_id = ". $interactionNum;
        $interactionResult = $conn->query($interactionQuery);
        $interactionRow = mysqli_fetch_array($interactionResult);
        
        
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
        
        
        $conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
					
	}

?>

	