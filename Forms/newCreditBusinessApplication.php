<?php
/*
 * Name: newCreditBusinessApplication.php
 * Author: Isha Isha
 * Purpose: Action happening when user clicks submit on the form.
 */
session_start();
include '../Database/connect.php';
defined('key') ? null : define('key', '84h84hjbgjrh848693');


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
							ref3_company_email)
						 values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

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

 //  $account_number = $_POST["account_number"];

  /*    $sql = "INSERT INTO credit_application_business_form (company_name,
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
      ref3_company_email
      )
     VALUES ('" . $_POST["company_name"] . "',
      '" . $_POST["company_address"] . "',
      '" . $_POST["contact_name"] . "',
      '" . $_POST["time_current_address"] . "',
      '" . $_POST["title"] . "',
      '" . $_POST["date_business_commenced"] . "',
      '" . $_POST["phone"] . "',
      '" . $_POST["nylene_representative"] . "',
      '" . $_POST["fax"] . "',
      '" . $_POST["order_pending"] . "',
      '" . $_POST["order_amount"] . "',
      '" . $_POST["business_email"] . "',
      '" . $_POST["bank_name"] . "',
      AES_ENCRYPT('$account_number', 'key'),
      '" . $_POST["bank_address"] . "',
      '" . $_POST["bank_email"] . "',
     '" . $_POST["bank_contact_name"] . "',
      '" . $_POST["bank_fax"] . "',
      '" . $_POST["bank_phone"] . "',
      '" . $_POST["ref1_company_name"] . "',
      '" . $_POST["ref1_company_phone"] . "',
      '" . $_POST["ref1_company_contact_name"] . "',
      '" . $_POST["ref1_company_fax"] . "',
      '" . $_POST["ref1_company_address"] . "',
      '" . $_POST["ref1_company_email"] . "',
      '" . $_POST["ref2_company_name"] . "',
      '" . $_POST["ref2_company_phone"] . "',
      '" . $_POST["ref2_company_contact_name"] . "',
      '" . $_POST["ref2_company_fax"] . "',
      '" . $_POST["ref2_company_address"] . "',
      '" . $_POST["ref2_company_email"] . "',
      '" . $_POST["ref3_company_name"] . "',
      '" . $_POST["ref3_company_phone"] . "',
      '" . $_POST["ref3_company_contact_name"] . "',
      '" . $_POST["ref3_company_fax"] . "',
      '" . $_POST["ref3_company_address"] . "',
      '" . $_POST["ref3_company_email"] . "')"; */
  

    $stmt->bind_param("sssssssssisssssssssssssssssssssssssss", $company_name, $company_address, $contact_name, $time_current_address, $title, 
        $date_business_commenced, $phone, $nylene_representative, 
        $fax, $order_pending, $order_amount, $business_email, $bank_name,AES_ENCRYPT('$account_number', 'key'), $bank_address,
        $bank_email, $bank_contact_name, $bank_fax, $bank_phone, $ref1_company_name, $ref1_company_phone, 
        $ref1_company_contact_name, $ref1_company_fax, $ref1_company_address, $ref1_company_email,
        $ref2_company_name, $ref2_company_phone, $ref2_company_contact_name, $ref2_company_fax, 
        $ref2_company_address, $ref2_company_email, $ref3_company_name, $ref3_company_phone,
        $ref3_company_contact_name, $ref3_company_fax, $ref3_company_address, $ref3_company_email);
    
    $stmt -> execute();
   /*if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br/>";*/

        $getFormId = "SELECT credit_application_business_id FROM credit_application_business_form ORDER BY credit_application_business_id DESC";
        $formId = $conn->query($getFormId);
        $id_form = mysqli_fetch_array($formId);

   //    $insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
	//				interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['credit_application_business_id'] . ", '6')";
        
        $stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
                                     interaction_id,
                                     form_id, form_type)
                                      VALUES (?,?,?)");

        $stmt2 -> bind_param("iii", $interactionNum, $formId, $formType);
        
        
        $interactionNum = $interaction_id;
        $formId = $id_form['credit_application_business_id'];
        $formType = 6;
        
        $stmt2 -> execute();
        
     /*   if ($conn->query($insert_into_interaction_relational_manager_table) === TRUE) {
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    } */
    
        $stmt->close();
        $stmt2->close();
        $conn->close();
        
        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
        exit();
   }

?>
