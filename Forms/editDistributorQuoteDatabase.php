<?php
    /* Name: editDistributorQuoteDatabase.php
     * Author: Kaitlyn Breker
     * Last Modified: November 28th, 2020
     * Purpose: Update file for edit distributor form
     */
session_start();
include '../Database/connect.php';

$conn = getDBConnection();

/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {

    /*Assign values to variables for update query*/
    $interactionNum = $_SESSION['interaction_id'];
    $distributorID = htmlspecialchars(strip_tags($_POST["distributor_id"]));
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
    
    /*AUTO UPDATE INTERACTION COMMENTS*/
    /*Select current database fields*/
    $distributorQuery = "SELECT * FROM distributor_quote_form
								WHERE distributor_quote_id = ". $distributorID;
    $distributorResults = $conn->query($distributorQuery);
    $distRow = mysqli_fetch_array($distributorResults);
    
 
    /*Retrieve original values from db*/
    $old_quoteDate = $distRow['quote_date'];
    $old_quoteNum = $distRow['quote_num'];
    $old_productName = $distRow['product_name'];
    $old_payment_terms = $distRow['payment_terms'];
    $old_productDesc = $distRow['product_desc'];
    $old_ltlQuantities = $distRow['ltl_quantities'];
    $old_annualVol = $distRow['annual_vol'];
    $old_specialTerms = $distRow['special_terms'];
    $old_OEM = $distRow['OEM'];
    $old_application = $distRow['application'];
    $old_truckLoad = $distRow['truck_load'];
    $old_range40up = $distRow['range40up'];
    $old_range2240 = $distRow['range2240'];
    $old_range1122 = $distRow['range1122'];
    $old_range610 = $distRow['range610'];
    $old_range24 = $distRow['range24'];
    $commentString = "";
    $dateModified = "thisisthedatefornow";
    $autoUpdate = 0;
    
    /*CREATE STRING OF EDITS*/
    $commentString = "Date Modified: {$dateModified}, Fields: ";
    
    /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
    /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
  //  if ($old_quoteDate != $quoteDate){
 //       $autoUpdate = 1;
  //      $commentString .= "{$old_quoteDate} -> {$quoteDate}, ";
    //}
    if(strcmp($old_quoteNum, $quoteNum) !== 0){
        $autoUpdate = 1;
        $commentString .= "{$old_quoteNum} -> {$quoteNum}, ";
        
    }
    if (strcmp($old_productName, $productName) !== 0){
        $autoUpdate = 1;
        $commentString .= "{$old_productName} -> {$productName}, ";
        
    }
    if (strcmp($old_payment_terms, $payment_terms) !== 0){
        $autoUpdate = 1;
        $commentString .= "{$old_payment_terms} -> {$payment_terms}, ";
    }
    if (strcmp($old_productDesc, $old_productDesc) !== 0){
        $autoUpdate = 1;
    }
    if (strcmp($old_ltlQuantities, $ltlQuantities) !== 0){
        $autoUpdate = 1;
    }
    if ($old_annualVol != $old_annualVol){
        $autoUpdate = 1;
    }
    if (strcmp($old_specialTerms, $specialTerms) !==0) {
        $autoUpdate = 1;
    }
    if (strcmp($old_OEM, $OEM) !== 0){
        $autoUpdate = 1;
    }
    if (strcmp($old_application, $application) !== 0){
        $autoUpdate = 1;
    }
    if ($old_truckLoad != $truckLoad){
        $autoUpdate = 1;
    }
    if ($old_range40up != $range40up){
        $autoUpdate = 1;
        $commentString .= "Old Quote: {$old_range40up}, {$old_range2240}, {$old_range1122}, {$old_range610}, {$old_range24}, ";
    }
/*     if ($old_range2240 != $range2240){
        $autoUpdate = 1;
    }
    if ($old_range1122 != $range1122){
        $autoUpdate = 1;
    }
    if ($old_range610 != $range610){
        $autoUpdate = 1;
    }
    if ($old_range24 != $range24){
        $autoUpdate = 1;
    } */
    $commentString .= "END Modified.";
    
   
    /*Search follow up info using interaction id posted from session value*/
    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
    $interactionResult = $conn->query($interactionQuery);
    $interactionRow = mysqli_fetch_array($interactionResult);
    
    /*Get length(comments)*/
    /*Ensure length(comments) does not reach max length of field*/
    
    
    /*UPDATING THE FORM IN THE DATABASE*/
    /*Prepare update statement into the distributor_quote_form table*/
    $stmt = $conn->prepare("UPDATE distributor_quote_form SET
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
                                range40up = ?,
            					range2240 = ?,
            					range1122 = ?,
            					range610 = ?,
            					range24 = ?
                                WHERE distributor_quote_id = ?"); 
    
    /*Bind statement parameters to statement*/
    $stmt->bind_param("ssssssisssisssssi", $quoteDate, $quoteNum, $productName, $payment_terms, $productDesc,
        $ltlQuantities, $annualVol, $specialTerms, $OEM, $application,
        $truckLoad, $range40up, $range2240, $range1122, $range610, $range24, $distributorID);
    
    /*Execute and close statements*/
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

    /*Close connection*/
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
}

?>
