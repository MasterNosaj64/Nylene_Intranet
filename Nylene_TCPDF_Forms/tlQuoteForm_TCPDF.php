<?php
/*
 * FileName: tlQuoteForm_TCPDF.php
 * Version Number: 1.0
 * Date Modified: 11/28/2020
 * Author: Jason Waid
 * Purpose:
 * Creates PDF file for tlquote
 */

// Include the Extended TCPDF library
include '../Nylene_TCPDF_Forms/TCPDF_Modified.php';
include '../Nylene_TCPDF_Forms/TCPDF_getHTML.php';

$conn = getDBConnection();

$form_id = $_GET['id'];

/* Check the connection */
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    /* Selection statement for employee that created the form */
    $userInformation = "SELECT * FROM employee
                            INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                                INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                    INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
                                        WHERE tl_quote_id = " . $form_id;

    $userResult = $conn->query($userInformation);
    $userRow = mysqli_fetch_array($userResult);

    /* Selection statement for form */
    $tlQuery = "SELECT * FROM tl_quote
								WHERE tl_quote_id = " . $form_id;

    $tlResults = $conn->query($tlQuery);
    $tlRow = mysqli_fetch_array($tlResults);

    /* Selection statement for customer passed from interaction */
    $customerInformation = "SELECT * FROM customer
								INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
									INNER JOIN company ON company.company_id = company_relational_customer.company_id
										INNER JOIN interaction ON interaction.company_id = company.company_id
											INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
												INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
													WHERE interaction_relational_form.form_type = 3 AND interaction_relational_form.form_id =" . $form_id;

    $customerResult = $conn->query($customerInformation);
    $customerRow = mysqli_fetch_array($customerResult);

    $companyInformation = "SELECT * FROM company
								INNER JOIN interaction ON interaction.company_id = company.company_id
									INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
										INNER JOIN tl_quote ON tl_quote.tl_quote_id = interaction_relational_form.form_id
											WHERE interaction_relational_form.form_type = 3 AND interaction_relational_form.form_id =" . $form_id;

    $companyResult = $conn->query($companyInformation);
    $companyRow = mysqli_fetch_array($companyResult);

    $conn->close();
}

// create new PDF document obj
$pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf_obj->SetCreator(PDF_CREATOR);
$pdf_obj->SetAuthor($userRow['first_name'] . " " . $userRow['last_name']);
$pdf_obj->SetTitle($companyRow['company_name']." - tl Quote");
$pdf_obj->SetSubject("Truck Load Quote");

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

$page1 = '';

$page1 .= create_EmployeeHTML($userRow['employee_id']);

$page1 .= create_CustomerHTML($customerRow['customer_id']);

$page1 .= create_CompanyHTML($companyRow['company_id']);

$page1 .= create_QuoteIntroHTML($customerRow['customer_id']);

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($page1, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

$content .= '
    		<table border="1">
    			<thead>
    				<tr>
    					<th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Truckload Quote -</strong></th>
    				</tr>
    			</thead>
    			<tr>
    				<td> Date </td>
    				<td> ' . $tlRow['quote_date'] . ' </td>
    			</tr>
    			<tr>
    				<td> Quote Name/Number </td>
    				<td> ' . $tlRow['quote_num'] . '</td>
    			</tr>
            </table>
                <table  border="1">
    			<thead>
    				<tr>
                        <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Product Information -</strong></th>
    				</tr>
    			</thead>
    			<tr>
    				<td> Product Name </td>
    				<td> ' . $tlRow['product_name'] . '</td>
    			</tr>
    			<tr>
    				<td> Description </td>
    				<td> ' . $tlRow['product_desc'] . '</td>
    			</tr>
    			<tr>
    				<td> Est. Annual Volume </td>
    				<td> ' . $tlRow['annual_vol'] . '</td>
    			</tr>
    			<tr>
    				<td> OEM </td>
    				<td> ' . $tlRow['OEM'] . '</td>
    			</tr>
    			<tr>
    				<td> Application </td>
    				<td> ' . $tlRow['application'] . '</td>
    			</tr>
    			<tr>
    				<td> TL Price </td>
    				<td> ' . $tlRow['truck_load'] . '</td>
    			</tr>
                </table>
                <table  border="1">
    			<thead>
    				<tr>
                        <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Terms -</strong></th>
    				</tr>
    			</thead>
    			<tr>
    				<td> Payment terms are USD $ Funds, Net</td>
    				<td> ' . $tlRow['payment_terms'] . '</td>
    			</tr>
    			<tr>
    				<td> LTL quantities are</td>
    				<td> ' . $tlRow['ltl_quantities'] . '</td>
    			</tr>
    			<tr>
    				<td> Special terms and conditions</td>
    				<td> ' . $tlRow['special_terms'] . '</td>
    			</tr>
    			<tr>
    				<td> 40,000 lb.+</td>
    				<td> ' . $tlRow['range40plus'] . '</td>
    			</tr>
    			<tr>
    				<td> 22,000 - 39,999 lb. bags, 21,000 - 39,999 lb. box</td>
    				<td> ' . $tlRow['range2240'] . '</td>
    			</tr>
    			<tr>
    				<td> 11,000 - 21,999 lb. bags, 10,500 - 20,999 lb. box</td>
    				<td> ' . $tlRow['range1022'] . '</td>
    			</tr>
    			<tr>
    				<td> 6,600 - 10,999 lb. bags, 6,000 - 10,499 lb. box</td>
    				<td> ' . $tlRow['range610'] . '</td>
    			</tr>
    			<tr>
    				<td> 4,400 - 6,599 lb. bags, 3,000 - 5,999 lb. box</td>
    				<td> ' . $tlRow['range46'] . '</td>
    			</tr>
    			<tr>
    				<td> 2,200 - 4,399 lb. bags, 1,500 - 2,999 lb. box</td>
    				<td> ' . $tlRow['range24'] . '</td>
    			</tr>
    		</table>';

$content .= create_QuoteOutroHTML($userRow['employee_id']);

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($content, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// Terms and conditions
$terms .= "";
    
$terms .= create_QuoteTermsAndConditionsHTML();

// set font
$pdf_obj->SetFont('helvetica', '', 8);

// output the HTML content
$pdf_obj->writeHTML($terms, true, false, true, false, '');

// reset pointer to the last page
$pdf_obj->lastPage();

ob_end_clean();

$pdf_obj->Output("test.pdf", "I");

?>