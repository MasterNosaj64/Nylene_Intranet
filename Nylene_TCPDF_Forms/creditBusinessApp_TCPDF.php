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
    $creditBusinessQuery = "SELECT * FROM credit_application_business_form WHERE credit_application_business_id = " . $_POST['id'];
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

    $conn->close();
}

// create new PDF document obj
$pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf_obj->SetCreator(PDF_CREATOR);
$pdf_obj->SetAuthor($userRow['first_name'] . " " . $userRow['last_name']);
$pdf_obj->SetTitle($companyRow['company_name'] . " - Credit Business Application");
$pdf_obj->SetSubject("Credit Business Application");

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
$pdf_obj->SetFont('helvetica', 'B', 20);

$pdf_obj->Write(0, 'Credit Application For Business Account', '', 0, 'L', true, 0, false, false, 0);

// $page1 = '';

// $page1 .= create_EmployeeHTML($userRow['employee_id']);

// $page1 .= create_CustomerHTML($customerRow['customer_id']);

// $page1 .= create_CompanyHTML($companyRow['company_id']);

// $page1 .= create_QuoteIntroHTML($customerRow['customer_id']);

// set font
// $pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
// $pdf_obj->writeHTML($page1, true, false, true, false, '');

// add a page
// $pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// Business Contanct Info
$content .= '

<table border="1">
	<thead>
	<tr>
		<th colspan="2" align="center">BUSINESS CONTACT INFORMATION</th>
	</tr>
	</thead>            
	<tr>
    	<td> Company Name</td>              
		<td> '.$customerRow["company_name"].'</td> 
	</tr>
    <tr>
        <td> Company Address(City, State, ZIP Code)</td>
        <td> '.$creditBusinessRow["company_address"].'</td>
    </tr>
    <tr>
        <td> How long at current address?</td>
        <td> '.$creditBusinessRow["time_current_address"].'</td>
    </tr>
    
     <tr>
        <td> Contact Name</td>
        <td> '.$creditBusinessRow["contact_name"].'</td>
    </tr>
   

        </table>';

// Business Case for Sample
$content .= '
            <table border="1">
               

            </table>';

// Assign Values of Sample Submission, Data Sheet and Description

// Match To
$content .= '
            <table border="1">
                
            </table>';

// Material Description, Special Handling or Label Request
$content .= '
            <table border="1">
                
            </table>';

// Additional information
$content .= '
            <table border="1">
                
            </table>';

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($content, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// Assign values for check boxes

// Type of responce needed
$page2 .= '
    
            <table border="1">
                olspan="2" align="center"> ---Note: SDS Sent With All Samples---</td>
                </tr>
            </table>';

$page2 .= '
            <table border="1">
              
            </table>';

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($page2, true, false, true, false, '');

// reset pointer to the last page
$pdf_obj->lastPage();

ob_end_clean();

$pdf_obj->Output("test.pdf", "I");

?>