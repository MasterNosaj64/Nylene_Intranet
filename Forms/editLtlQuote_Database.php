<?php
    /* Name: editLtlQuote_Database.php
     * Author: Karandeep Singh
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
        $conn->close();

		echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
		exit();
					
	}

?>

	