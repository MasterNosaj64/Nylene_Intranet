<?php
/*
 * Name: newCreditBusinessApplication.php
 * Author: Isha Isha
 * Purpose: Action happening when user clicks submit on the form.
 */
session_start();
include '../Database/connect.php';

// Check connection
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    $interaction_id = $_SESSION['interaction_id'];

    //TODO: ISHA implement security to protect against SQL injection
            //View ../Database/Company.php for code that can help
            
    //TODO: ISHA implement some sort of hashing for sensitive data
    $sql = "INSERT INTO credit_application_business_form (company_name, 
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
						'" . $_POST["account_number"] . "', 
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
						'" . $_POST["ref3_company_email"] . "')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully<br/>";

        $getFormId = "SELECT credit_application_business_id FROM credit_application_business_form ORDER BY credit_application_business_id DESC";
        $formId = $conn->query($getFormId);
        $id_form = mysqli_fetch_array($formId);

        $insert_into_interaction_relational_manager_table = "INSERT INTO interaction_relational_form (
					interaction_id, form_id, form_type) values ('$interaction_id', " . $id_form['credit_application_business_id'] . ", '6')";

        if ($conn->query($insert_into_interaction_relational_manager_table) === TRUE) {
            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
