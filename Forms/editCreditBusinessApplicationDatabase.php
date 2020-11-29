<?php 
    /* Name: editCreditBusinessApplicationDatabase.php
     * Author: Isha Isha, modified by Kaitlyn Breker
     * Last Modified: November 28th, 2020
     * Purpose: Update file for edit credit form form. Inserts into interaction 
     * autoupdated fields, and followup date information.
     */
session_start();
include '../Database/connect.php';

$conn = getDBConnection();
//defined('key') ? null : define('key', '84h84hjbgjrh848693');

$myFile = "../key.txt";
$file = fopen($myFile, "r");

if($file){
    while(!feof($file)){
        $key = fgets($file);
    }
    
    fclose($file);
}
/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {

    /*Assign values to variables for update query*/
    $interactionNum = $_SESSION['interaction_id'];
   // $key = key;
    $company_name = htmlspecialchars(strip_tags($_POST['company_name']));
    $company_address = htmlspecialchars(strip_tags($_POST['company_address']));
    $contact_name = htmlspecialchars(strip_tags($_POST['contact_name']));
    $time_current_address = htmlspecialchars(strip_tags($_POST['time_current_address']));
    $title = htmlspecialchars(strip_tags($_POST['title']));
    $date_business_commenced = htmlspecialchars(strip_tags($_POST['date_business_commenced']));
    $phone = htmlspecialchars(strip_tags($_POST['phone']));
    $nylene_representative = htmlspecialchars(strip_tags($_POST['nylene_representative']));
    $fax = htmlspecialchars(strip_tags($_POST['fax']));
    $order_pending = htmlspecialchars(strip_tags($_POST['order_pending']));
    $order_amount = htmlspecialchars(strip_tags($_POST['order_amount']));
    $business_email = htmlspecialchars(strip_tags($_POST['business_email']));
    $bank_name = htmlspecialchars(strip_tags($_POST['bank_name']));
    $account_number = htmlspecialchars(strip_tags($_POST['account_number']));
    $bank_address = htmlspecialchars(strip_tags($_POST['bank_address']));
    $bank_email = htmlspecialchars(strip_tags($_POST['bank_email']));
    $bank_contact_name = htmlspecialchars(strip_tags($_POST['bank_contact_name']));
    $bank_fax = htmlspecialchars(strip_tags($_POST['bank_fax']));
    $bank_phone = htmlspecialchars(strip_tags($_POST['bank_phone']));
    $ref1_company_name = htmlspecialchars(strip_tags($_POST['ref1_company_name']));
    $ref1_company_phone = htmlspecialchars(strip_tags($_POST['ref1_company_phone']));
    $ref1_company_contact_name = htmlspecialchars(strip_tags($_POST['ref1_company_contact_name']));
    $ref1_company_fax = htmlspecialchars(strip_tags($_POST['ref1_company_fax']));
    $ref1_company_address = htmlspecialchars(strip_tags($_POST['ref1_company_address']));
    $ref1_company_email = htmlspecialchars(strip_tags($_POST['ref1_company_email']));
    $ref2_company_name = htmlspecialchars(strip_tags($_POST['ref2_company_name']));
    $ref2_company_phone = htmlspecialchars(strip_tags($_POST['ref2_company_phone']));
    $ref2_company_contact_name = htmlspecialchars(strip_tags($_POST['ref2_company_contact_name']));
    $ref2_company_fax = htmlspecialchars(strip_tags($_POST['ref2_company_fax']));
    $ref2_company_address = htmlspecialchars(strip_tags($_POST['ref2_company_address']));
    $ref2_company_email = htmlspecialchars(strip_tags($_POST['ref2_company_email']));
    $ref3_company_name = htmlspecialchars(strip_tags($_POST['ref3_company_name']));
    $ref3_company_phone = htmlspecialchars(strip_tags($_POST['ref3_company_phone']));
    $ref3_company_contact_name = htmlspecialchars(strip_tags($_POST['ref3_company_contact_name']));
    $ref3_company_fax = htmlspecialchars(strip_tags($_POST['ref3_company_fax']));
    $ref3_company_address = htmlspecialchars(strip_tags($_POST['ref3_company_address']));
    $ref3_company_email = htmlspecialchars(strip_tags($_POST['ref3_company_email']));
    $credit_date = htmlspecialchars(strip_tags($_POST['credit_date']));
    $credit_application_business_id = htmlspecialchars(strip_tags($_POST['credit_application_business_id']));
    
    /*AUTO UPDATE INTERACTION COMMENTS*/
    /* Selection statement for credit business form */
    $creditBusinessQuery = "SELECT * FROM credit_application_business_form 
                                WHERE credit_application_business_id = " . $credit_application_business_id;
    $creditBusinessResults = $conn->query($creditBusinessQuery);
    $creditBusinessRow = mysqli_fetch_array($creditBusinessResults);
    
    $accountQuery = "SELECT AES_DECRYPT(account_number,'$key') as decrypted 
                        FROM credit_application_business_form 
                            WHERE credit_application_business_id = " . $credit_application_business_id;
    $accountResult = $conn->query($accountQuery);
    $accountNumRow = mysqli_fetch_array($accountResult);
    
    
    /*Retrieve original values from db*/
    $old_account_number = $accountNumRow['decrypted'];
    $old_company_name = $creditBusinessRow['company_name'];
    $old_company_address = $creditBusinessRow['company_address'];
    $old_contact_name = $creditBusinessRow['contact_name'];
    $old_time_current_address = $creditBusinessRow['time_current_address'];
    $old_title = $creditBusinessRow['title'];
    $old_date_business_commenced = $creditBusinessRow['date_business_commenced'];
    $old_phone = $creditBusinessRow['phone'];
    $old_nylene_representative = $creditBusinessRow['nylene_representative'];
    $old_fax = $creditBusinessRow['fax'];
    $old_order_pending = $creditBusinessRow['order_pending'];
    $old_order_amount = $creditBusinessRow['order_amount'];
    $old_business_email = $creditBusinessRow['business_email'];
    $old_bank_name = $creditBusinessRow['bank_name'];
    $old_bank_address = $creditBusinessRow['bank_address'];
    $old_bank_email = $creditBusinessRow['bank_email'];
    $old_bank_contact_name = $creditBusinessRow['bank_contact_name'];
    $old_bank_fax = $creditBusinessRow['bank_fax'];
    $old_bank_phone = $creditBusinessRow['bank_phone'];
    $old_credit_date = $creditBusinessRow['credit_date'];
    
    $old_ref1_company_name = $creditBusinessRow['ref1_company_name'];
    $old_ref1_company_phone = $creditBusinessRow['ref1_company_phone'];
    $old_ref1_company_contact_name = $creditBusinessRow['ref1_company_contact_name'];
    $old_ref1_company_fax = $creditBusinessRow['ref1_company_fax'];
    $old_ref1_company_address = $creditBusinessRow['ref1_company_address'];
    $old_ref1_company_email = $creditBusinessRow['ref1_company_email'];
    
    $old_ref2_company_name = $creditBusinessRow['ref2_company_name'];
    $old_ref2_company_phone = $creditBusinessRow['ref2_company_phone'];
    $old_ref2_company_contact_name = $creditBusinessRow['ref2_company_contact_name'];
    $old_ref2_company_fax = $creditBusinessRow['ref2_company_fax'];
    $old_ref2_company_address = $creditBusinessRow['ref2_company_address'];
    $old_ref2_company_email = $creditBusinessRow['ref2_company_email'];
    
    $old_ref3_company_name = $creditBusinessRow['ref3_company_name'];
    $old_ref3_company_phone = $creditBusinessRow['ref3_company_phone'];
    $old_ref3_company_contact_name = $creditBusinessRow['ref3_company_contact_name'];
    $old_ref3_company_fax = $creditBusinessRow['ref3_company_fax'];
    $old_ref3_company_address = $creditBusinessRow['ref3_company_address'];
    $old_ref3_company_email = $creditBusinessRow['ref3_company_email'];
    
    $commentString = "";
    $autoUpdate = 0;
    $dateModified = date("Y-m-d");
    
    
    
    /*CREATE STRING OF EDITS*/
    $commentString = "Form Modified on {$dateModified}. Old form value(s): ";
    
    /*Compare with fields passed from edit forms, set autoUpdate to 1 if changes, 0 if no changes*/
    /*If any fields changes, Create string by apending changes "Date Modified: Todays Date, Fields: ... -> ..., ... -> ..."*/
    if (strcmp($old_company_name, $company_name) !== 0){ //this one
        $autoUpdate = 1;
        $commentString .= "Comapny Name: {$old_company_name}, ";
    }
    if(strcmp($old_company_address, $company_address) !== 0){
        $autoUpdate = 1;
        $commentString .= "Company Address: {$old_company_address}, ";
    }
    if (strcmp($old_contact_name, $contact_name) !== 0){
        $autoUpdate = 1;
        $commentString .= "Old Contact Name: {$old_contact_name}, ";
    }
    if (strcmp($old_time_current_address, $time_current_address) !== 0){
        $autoUpdate = 1;
        $commentString .= "Time Current Address: {$old_time_current_address}, ";
    }
    if (strcmp($old_title, $title) !== 0){
        $autoUpdate = 1;
        $commentString .= "Title: {$old_title}, ";
    }
    if (strcmp($old_date_business_commenced, $date_business_commenced) !== 0){
        $autoUpdate = 1;
        $commentString .= "Date Business Commenced: {$old_date_business_commenced}, ";
    }
    if (strcmp($old_phone, $phone) !== 0){
        $autoUpdate = 1;
        $commentString .= "Phone: {$old_phone}, ";
    }
    if (strcmp($old_nylene_representative, $nylene_representative) !==0) {
        $autoUpdate = 1;
        $commentString .= "Nylene Rep: {$old_nylene_representative}, ";
    }
    if (strcmp($old_fax, $fax) !== 0){
        $autoUpdate = 1;
        $commentString .= "Fax: {$old_fax}, ";
    }
    if ($old_order_pending != $order_pending){
        $autoUpdate = 1;
        $commentString .= "Order Pending: {$old_order_pending}, ";
    }
    if (strcmp($old_order_amount, $order_amount) !== 0){
        $autoUpdate = 1;
        $commentString .= "Order Amount: {$old_order_amount}, ";
    } 
    if (strcmp($old_business_email, $business_email) !== 0){ //this one
        $autoUpdate = 1;
        $commentString .= "Business Email: {$old_business_email}, ";
    }
    if(strcmp($old_bank_name, $bank_name) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Name: {$old_bank_name}, ";
    }
    if (strcmp($old_account_number, $account_number) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Account Number Updated, ";
    }
    if (strcmp($old_bank_address, $bank_address) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Address: {$old_bank_address}, ";
    }
    if (strcmp($old_bank_email, $bank_email) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Email: {$old_bank_email}, ";
    }
    if (strcmp($old_bank_contact_name, $bank_contact_name) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Contact: {$old_bank_contact_name}, ";
    }
    if (strcmp($old_bank_fax, $bank_fax) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Fax: {$old_bank_fax}, ";
    }
    if (strcmp($old_bank_phone, $bank_phone) !== 0){
        $autoUpdate = 1;
        $commentString .= "Bank Phone: {$old_bank_phone}, ";
    }
    if (strcmp($old_credit_date, $credit_date) !== 0){
        $autoUpdate = 1;
        $commentString .= "Credit Date: {$old_credit_date}, ";
    }
    
    
    if ((strcmp($old_ref1_company_name, $ref1_company_name) !==0 ) ||
        (strcmp($old_ref1_company_phone, $ref1_company_phone) !==0 ) ||
        (strcmp($old_ref1_company_contact_name, $ref1_company_contact_name) !==0 ) ||
        (strcmp($old_ref1_company_fax, $ref1_company_fax) !==0 ) ||
        (strcmp($old_ref1_company_address, $ref1_company_address) !==0 ) ||
        (strcmp($old_ref1_company_email, $ref1_company_email) !==0 ))
    {
        $autoUpdate = 1;
        $commentString .= "Reference 1 Updated, ";
    }
    
    if ((strcmp($old_ref2_company_name, $ref2_company_name) !==0 ) ||
        (strcmp($old_ref2_company_phone, $ref2_company_phone) !==0 ) ||
        (strcmp($old_ref2_company_contact_name, $ref2_company_contact_name) !==0 ) ||
        (strcmp($old_ref2_company_fax, $ref2_company_fax) !==0 ) ||
        (strcmp($old_ref2_company_address, $ref2_company_address) !==0 ) ||
        (strcmp($old_ref2_company_email, $ref2_company_email) !==0 ))
    {
        $autoUpdate = 1;
        $commentString .= "Reference 2 Updated, ";
    }
    
    if ((strcmp($old_ref3_company_name, $ref3_company_name) !==0 ) ||
        (strcmp($old_ref3_company_phone, $ref3_company_phone) !==0 ) ||
        (strcmp($old_ref3_company_contact_name, $ref3_company_contact_name) !==0 ) ||
        (strcmp($old_ref3_company_fax, $ref3_company_fax) !==0 ) ||
        (strcmp($old_ref3_company_address, $ref3_company_address) !==0 ) ||
        (strcmp($old_ref3_company_email, $ref3_company_email) !==0 ))
    {
        $autoUpdate = 1;
        $commentString .= "Reference 3 Updated, ";
    }
    
    $commentString .= "END Modified.";

    
    /*Search follow up info using interaction id posted from session value*/
    $interactionQuery = "SELECT status, follow_up_type, comments FROM interaction
								WHERE interaction_id = ". $interactionNum;
    $interactionResult = $conn->query($interactionQuery);
    $interactionRow = mysqli_fetch_array($interactionResult);
    
    
    
    /*UPDATING THE FORM IN THE DATABASE*/
    $stmt = $conn->prepare("UPDATE credit_application_business_form SET
                            company_name = ?,
							company_address = ?,
							contact_name = ?,
							time_current_address = ?,
							title = ?,
							date_business_commenced = ?,
							phone = ?,
							nylene_representative = ?,
							fax = ?,
							order_pending = ?,
							order_amount = ?,
							business_email = ?,
							bank_name = ?,
							account_number = AES_ENCRYPT(?,?),
							bank_address = ?,
							bank_email = ?,
							bank_contact_name = ?,
							bank_fax = ?,
							bank_phone = ?,
							ref1_company_name = ?,
							ref1_company_phone = ?,
							ref1_company_contact_name = ?,
							ref1_company_fax = ?,
							ref1_company_address = ?,
							ref1_company_email = ?,
							ref2_company_name = ?,
							ref2_company_phone = ?, 
							ref2_company_contact_name = ?,
							ref2_company_fax = ?,
							ref2_company_address = ?,
							ref2_company_email = ?,
							ref3_company_name = ?,
							ref3_company_phone = ?,
							ref3_company_contact_name = ?,
							ref3_company_fax = ?,
							ref3_company_address = ?,
							ref3_company_email = ?,
                            credit_date = ? 
                            WHERE credit_application_business_id = ?");
    

    $stmt->bind_param("sssssssssisssssssssssssssssssssssssssssi", $company_name, $company_address, $contact_name, $time_current_address, $title, $date_business_commenced,
        $phone, $nylene_representative, $fax, $order_pending, $order_amount, $business_email, $bank_name, $account_number, $key, $bank_address, $bank_email,
        $bank_contact_name, $bank_fax, $bank_phone, $ref1_company_name, $ref1_company_phone, $ref1_company_contact_name, $ref1_company_fax, $ref1_company_address,
        $ref1_company_email, $ref2_company_name, $ref2_company_phone, $ref2_company_contact_name, $ref2_company_fax, $ref2_company_address, $ref2_company_email,
        $ref3_company_name, $ref3_company_phone, $ref3_company_contact_name, $ref3_company_fax, $ref3_company_address, $ref3_company_email, $credit_date, $credit_application_business_id);
   
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
        $fDate = strtotime($credit_date);
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