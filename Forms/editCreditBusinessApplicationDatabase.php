<?php 
session_start();
include '../Database/connect.php';

$conn = getDBConnection();
defined('key') ? null : define('key', '84h84hjbgjrh848693');
/*Check the connection*/
if ($conn-> connect_error) {
    
    die("Connection failed: " . $conn-> connect_error);
    
} else {

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
							account_number = ?,
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
                            WHERE credit_business_application_id = ?");
    
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
    $stmt->close();
    $conn->close();
    
    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
}
    
?>