<?php
/*
 * Name: newCreditBusinessApplication.php
 * Author: Isha Isha, Modified by Kaitlyn Breker
 * Purpose: Action happening when user clicks submit on the form.
 */
session_start();
include '../Database/connect.php';
//defined('key') ? null : define('key', '84h84hjbgjrh848693');

$myFile = "C:\Users\isham\key.txt";
$file = fopen($myFile, "r");

if($file){
while(!feof($file)){
    //$key = fgets($file);
   defined ('key') ? null : define('key', 'fgets($file)');
}

fclose($file);
}
// getDBConnection to get connection
$conn = getDBConnection();

// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    $interaction_id = $_SESSION['interaction_id'];

    /* Prepare insert statement into the credit_application_business_form table */
    $stmt = $conn->prepare("INSERT INTO credit_application_business_form (company_name,
							company_address,
							contact_name,
							time_current_address,
							title,
							date_business_commenced,
							phone,
							nylene_representative,
							fax,
							order_pending,
							order_amount,
							business_email,
							bank_name,
							account_number,
							bank_address,
							bank_email,
							bank_contact_name,
							bank_fax,
							bank_phone,
							ref1_company_name,
							ref1_company_phone,
							ref1_company_contact_name,
							ref1_company_fax,
							ref1_company_address,
							ref1_company_email,
							ref2_company_name,
							ref2_company_phone,
							ref2_company_contact_name,
							ref2_company_fax,
							ref2_company_address,
							ref2_company_email,
							ref3_company_name,
							ref3_company_phone,
							ref3_company_contact_name,
							ref3_company_fax,
							ref3_company_address,
							ref3_company_email,
                            credit_date)
						 values (?,?,?,?,?,?,?,?,?,?,?,?,?,AES_ENCRYPT(?,?),?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

    $key = key;
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

    $stmt->bind_param("sssssssssisssssssssssssssssssssssssssss", $company_name, $company_address, $contact_name, $time_current_address, $title, $date_business_commenced,
        $phone, $nylene_representative, $fax, $order_pending, $order_amount, $business_email, $bank_name, $account_number, $key, $bank_address, $bank_email, 
        $bank_contact_name, $bank_fax, $bank_phone, $ref1_company_name, $ref1_company_phone, $ref1_company_contact_name, $ref1_company_fax, $ref1_company_address,
        $ref1_company_email, $ref2_company_name, $ref2_company_phone, $ref2_company_contact_name, $ref2_company_fax, $ref2_company_address, $ref2_company_email, 
        $ref3_company_name, $ref3_company_phone, $ref3_company_contact_name, $ref3_company_fax, $ref3_company_address, $ref3_company_email, $credit_date);

    $stmt->execute();

    $stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
                                     interaction_id,
                                     form_id, form_type)
                                      VALUES (?,?,?)");

    $interactionNum = $interaction_id;
    $formId = $conn -> insert_id;
    $formType = 6;
    $stmt2->bind_param("iii", $interactionNum, $formId, $formType);

    $stmt2->execute();

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
        $fDate = strtotime($credit_date);
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
    
    
    $conn->close();

    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
}

?>
