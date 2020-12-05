<?php
/*
 * FileName: creditBusiness_TCPDF.php
 * Version Number: 1.0
 * Date Modified: 11/29/2020
 * Author: Jason Waid
 * Purpose:
 * Creates PDF file for credit Business Application
 */

// Include the Extended TCPDF library
include '../Nylene_TCPDF_Forms/TCPDF_Modified.php';
include '../Nylene_TCPDF_Forms/TCPDF_getHTML.php';

$conn = getDBConnection();

// test variables

$form_id = $_GET['id'];

/* Check the connection */
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    $myFile = "../key.txt";
    $file = fopen($myFile, "r");

    if ($file) {
        while (! feof($file)) {
            $key = fgets($file);
        }

        fclose($file);
    }

    /* Selection statement for employee that created the form */
    $userInformation = "SELECT * FROM employee
                        INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                            INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                INNER JOIN credit_application_business_form ON credit_application_business_form.credit_application_business_id = interaction_relational_form.form_id
                                    WHERE credit_application_business_id = " . $form_id;

    $userResult = $conn->query($userInformation);
    $userRow = mysqli_fetch_array($userResult);

    /* Selection statement for credit business form */
    $creditBusinessQuery = "SELECT * FROM credit_application_business_form WHERE credit_application_business_id = " . $form_id;
    $creditBusinessResults = $conn->query($creditBusinessQuery);
    $creditBusinessRow = mysqli_fetch_array($creditBusinessResults);

    /* Selection statement for customer passed from interaction */
    $customerInformation = "SELECT * FROM customer
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN credit_application_business_form ON credit_application_business_form.credit_application_business_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 6 AND interaction_relational_form.form_id = " . $form_id;

    $customerResult = $conn->query($customerInformation);
    $customerRow = mysqli_fetch_array($customerResult);

    $companyInformation = "SELECT * FROM company
								INNER JOIN interaction ON interaction.company_id = company.company_id
									INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
										INNER JOIN credit_application_business_form ON credit_application_business_form.credit_application_business_id = interaction_relational_form.form_id
											WHERE interaction_relational_form.form_type = 6 AND interaction_relational_form.form_id =" . $form_id;

    $companyResult = $conn->query($companyInformation);
    $companyRow = mysqli_fetch_array($companyResult);

    
    $account_number_Query = "SELECT AES_DECRYPT(account_number,'$key') as decrypted FROM credit_application_business_form WHERE credit_application_business_id = " . $form_id;
    $account_number_result = $conn->query($account_number_Query);
    $accountNumberRow = mysqli_fetch_array($account_number_result);
    
    
    $conn->close();
}

// create new PDF document obj
$pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf_obj->SetCreator(PDF_CREATOR);
$pdf_obj->SetAuthor($userRow['first_name'] . " " . $userRow['last_name']);
$pdf_obj->SetTitle($companyRow['company_name'] . " - Credit Application For Business Account");
$pdf_obj->SetSubject("Credit Application For Business Account");

// Header and Footer Fonts
$pdf_obj->setHeaderFont(Array(
    PDF_FONT_NAME_MAIN,
    '',
    PDF_FONT_SIZE_MAIN
));
$pdf_obj->setFooterFont(array(
    PDF_FONT_NAME_DATA,
    '',
    PDF_FONT_SIZE_DATA
));

// set default monospaced font
$pdf_obj->SetDefaultMonospacedFont('helvetica');

// set margins
$pdf_obj->SetMargins(PDF_MARGIN_LEFT, '35', PDF_MARGIN_RIGHT);
$pdf_obj->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf_obj->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf_obj->setPrintHeader(true);
$pdf_obj->setPrintFooter(true);

// set image scale factor
$pdf_obj->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set auto page breaks
$pdf_obj->SetAutoPageBreak(True, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf_obj->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// set font
$pdf_obj->SetFont('helvetica', 'B', 18);

$pdf_obj->Write(0, 'Credit Application For Business Account', '', 0, 'L', true, 0, false, false, 0);

if ($creditBusinessRow['order_pending'] == '1') {
    $orderPending = "Yes";
} else {
    $orderPending = "No";
}


// Business Contact Info
$content .= '

<table border="1">
	<thead>
	<tr>
		<th colspan="4" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>BUSINESS CONTACT INFORMATION</strong></th>
	</tr>
	</thead>            
	<tr>
    	<td> Company Name:</td>              
		<td> '.$customerRow['company_name'].'</td>
        <td> Company Address:</td>
        <td> '.$creditBusinessRow['company_address'].'</td> 
	</tr>
    <tr>
        <td> Contact Name:</td>
        <td> '.$creditBusinessRow['contact_name'].'</td>
        <td> How long at current address?</td>
        <td> '.$creditBusinessRow['time_current_address'].'</td>
    </tr>
     <tr>
        <td> Title:</td>
        <td> '. $creditBusinessRow['title'].'</td>
        <td> Date business commenced:</td>
        <td> '.$creditBusinessRow['date_business_commenced'].'</td>

    </tr>
   <tr>
        <td> Phone:</td>
        <td> '.$creditBusinessRow['phone'].'</td>
        <td> Nylene Representative:</td>
        <td> '.$creditBusinessRow['nylene_representative'].'</td>
    </tr>
    <tr>
        <td> Fax:</td>
        <td> '.$creditBusinessRow['fax'].'</td>
        <td> Order Pending: '.$orderPending.'</td>
        <td> Order Amount: $'.$creditBusinessRow['order_amount'].'/lbs.</td>
    </tr>
    <tr>
        <td> E-mail:</td>
        <td> '.$creditBusinessRow['business_email'].'</td>
        <td> Application Date:</td>
        <td> '.$creditBusinessRow['credit_date'].'</td>
    </tr>
        </table>';


// BANK INFORMATION
$content .= '
            <table border="1">
                <thead>
				<tr>
					<th colspan="4" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>BANK INFORMATION</strong></th>
				</tr>
			    </thead>
                 <tr>
                    <td> Bank Name:</td>
                    <td> '.$creditBusinessRow['bank_name'].'</td>
                    <td> Account Number:</td>
                    <td> '.$accountNumberRow['decrypted'].'</td>
                </tr>
                <tr>
                    <td> Bank Address:</td>
                    <td> '.$creditBusinessRow['bank_address'].'</td>
                    <td> E-mail:</td>
                    <td> '.$creditBusinessRow['bank_email'].'</td>
                </tr>
                <tr>
                    <td> Bank Contact Name:</td>
                    <td> '.$creditBusinessRow['bank_contact_name'].'</td>
                    <td> Fax:</td>
                    <td> '.$creditBusinessRow['bank_fax'].'</td>
                </tr> 
                <tr>
                    <td> Phone:</td>
                    <td> '.$creditBusinessRow['bank_phone'].'</td>
                    <td></td>
                    <td></td>
                </tr>                
            </table>';

//BUSINESS/TRADE REFERENCES
$content .= '
            <table border="1">
                <thead>
				<tr>
					<th colspan="4" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>BUSINESS/TRADE REFERENCES</strong></th>
				</tr>
			    </thead>
                    <tr>
                        <td colspan="4"><p> Reference #1</p></td>
                    </tr>
                 <tr>
                    <td> Company Name:</td>
                    <td> '.$creditBusinessRow['ref1_company_name'].'</td>
                    <td> Phone:</td>
                    <td> '.$creditBusinessRow['ref1_company_phone'].'</td>
                </tr>
                <tr>
                    <td> Contact Name:</td>
                    <td> '.$creditBusinessRow['ref1_company_contact_name'].'</td>
                    <td> Fax:</td>
                    <td> '.$creditBusinessRow['ref1_company_fax'].'</td>
                </tr>
                <tr>
                    <td> Address:</td>
                    <td> '.$creditBusinessRow['ref1_company_address'].'</td>
                    <td> E-mail:</td>
                    <td> '.$creditBusinessRow['ref1_company_email'].'</td>
                </tr>
 
                <tr>
                        <td colspan="4"><p> Reference #2</p></td>
                    </tr>
                 <tr>
                    <td> Company Name:</td>
                    <td> '.$creditBusinessRow['ref2_company_name'].'</td>
                    <td> Phone:</td>
                    <td> '.$creditBusinessRow['ref2_company_phone'].'</td>
                </tr>
                <tr>
                    <td> Contact Name:</td>
                    <td> '.$creditBusinessRow['ref2_company_contact_name'].'</td>
                    <td> Fax:</td>
                    <td> '.$creditBusinessRow['ref2_company_fax'].'</td>
                </tr>
                <tr>
                    <td> Address:</td>
                    <td> '.$creditBusinessRow['ref2_company_address'].'</td>
                    <td> E-mail:</td>
                    <td> '.$creditBusinessRow['ref2_company_email'].'</td>
                </tr>

                <tr>
                        <td colspan="4"><p> Reference #3</p></td>
                    </tr>
                 <tr>
                    <td> Company Name:</td>
                    <td> '.$creditBusinessRow['ref3_company_name'].'</td>
                    <td> Phone:</td>
                    <td> '.$creditBusinessRow['ref3_company_phone'].'</td>
                </tr>
                <tr>
                    <td> Contact Name:</td>
                    <td> '.$creditBusinessRow['ref3_company_contact_name'].'</td>
                    <td> Fax:</td>
                    <td> '.$creditBusinessRow['ref3_company_fax'].'</td>
                </tr>
                <tr>
                    <td> Address:</td>
                    <td> '.$creditBusinessRow['ref3_company_address'].'</td>
                    <td> E-mail:</td>
                    <td> '.$creditBusinessRow['ref3_company_email'].'</td>
                </tr>              
            </table>';

// Agreement
$content .= '
            <table border="1">
                <thead>
				<tr>
					<th colspan="4" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>AGREEMENT</strong></th>
				</tr>
			</thead>
                <tr>
				<td colspan="4"><p>Upon approval, standard terms are net 30 days.
						Alternate terms must be separately requested and agreed in
						writing. Claims arising from invoices must be made in writing
						within seven working days. By submitting this application, you
						authorize Nylene to make inquiries into the banking and
						business/trade references that you have supplied.</p></td>
			</tr>
            </table>';

// SIGNATURES
$content .= '
            <table border="1">
                <thead>
				<tr>
					<th colspan="4" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>SIGNATURES</strong></th>
				</tr>
			</thead>
			<tr>
				<td> Signature</td>
				<td></td>
				<td> Signature</td>
				<td></td>
			</tr>
			<tr>
				<td> Name and Title</td>
				<td></td>
				<td> Name and Title</td>
				<td></td>
			</tr>
			<tr>
				<td> Date</td>
				
				<td></td>
				<td> Date</td>
				<td></td>
			</tr>
			<tr>
				<td colspan="4"><p>Upon completion please scan and return by email
						to tgreenstein@nylene.com or fax to: Toby Greenstein at
						973-694-3549</p></td>
			</tr>
            </table>';

// set font
$pdf_obj->SetFont('helvetica', '', 10);

// output the HTML content
$pdf_obj->writeHTML($content, true, false, true, false, '');

// reset pointer to the last page
$pdf_obj->lastPage();

ob_end_clean();

$pdf_obj->Output($companyRow['company_name'] . "-Credit Application For Business Account", "I");

?>