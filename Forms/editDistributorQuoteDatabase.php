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
    $autoUpdate = 0;
    $dateModified = date("Y-m-d");

    
    /*CREATE STRING OF EDITS*/
    $commentString = "Form Modified on {$dateModified}. Old form value(s): ";
    
    /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
    /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
    if ($old_quoteDate != $quoteDate){ //this one
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
    if ($old_range40up != $range40up){
        $autoUpdate = 1;
        if ($old_range40up == null){
            $commentString .= "New quote created, ";
        } else {
            $commentString .= "Old Quote: {$old_range40up}, {$old_range2240}, {$old_range1122}, {$old_range610}, {$old_range24}, ";
        }
    }

    $commentString .= "END Modified.";
    
   
    /*Search follow up info using interaction id posted from session value*/
    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
    $interactionResult = $conn->query($interactionQuery);
    $interactionRow = mysqli_fetch_array($interactionResult);
    
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

    /*Close connection*/
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
}

?>
