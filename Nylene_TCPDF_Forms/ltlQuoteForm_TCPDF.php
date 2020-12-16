<?php
/*
 * FileName: ltlQuoteForm_TCPDF.php
 * Version Number: 1.0
 * Date Modified: 12/15/2020
 * Author: Jason Waid
 * Purpose:
 * Creates PDF file for ltlquote
 */

// Include the Extended TCPDF library
include '../Nylene_TCPDF_Forms/TCPDF_Modified.php';
include '../Nylene_TCPDF_Forms/TCPDF_getHTML.php';

$conn = getDBConnection();

//Gets the form_id from html string: ?id=x
$form_id = $_GET['id'];

/* Check the connection */
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    /* Selection statement for employee that created the form */
    $userInformation = "SELECT * FROM employee
                            INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                                INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                    INNER JOIN ltl_quote ON ltl_quote.ltl_quote_id = interaction_relational_form.form_id
                                        WHERE ltl_quote_id = " . $form_id;

    $userResult = $conn->query($userInformation);
    $userRow = mysqli_fetch_array($userResult);

    /* Selection statement for form */
    $ltlQuery = "SELECT * FROM ltl_quote
								WHERE ltl_quote_id = " . $form_id;

    $ltlResults = $conn->query($ltlQuery);
    $ltlRow = mysqli_fetch_array($ltlResults);

    /* Selection statement for customer passed from interaction */
    $customerInformation = "SELECT * FROM customer
								INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
									INNER JOIN company ON company.company_id = company_relational_customer.company_id
										INNER JOIN interaction ON interaction.company_id = company.company_id
											INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
												INNER JOIN ltl_quote ON ltl_quote.ltl_quote_id = interaction_relational_form.form_id
													WHERE interaction_relational_form.form_type = 2 AND interaction_relational_form.form_id =" . $form_id;

    $customerResult = $conn->query($customerInformation);
    $customerRow = mysqli_fetch_array($customerResult);

    $companyInformation = "SELECT * FROM company
								INNER JOIN interaction ON interaction.company_id = company.company_id
									INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
										INNER JOIN ltl_quote ON ltl_quote.ltl_quote_id = interaction_relational_form.form_id
											WHERE interaction_relational_form.form_type = 2 AND interaction_relational_form.form_id =" . $form_id;

    $companyResult = $conn->query($companyInformation);
    $companyRow = mysqli_fetch_array($companyResult);

    $conn->close();
}

// create new PDF document obj
$pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
//Creator is default
$pdf_obj->SetCreator(PDF_CREATOR);
//Author will use created_by from database
$pdf_obj->SetAuthor($userRow['first_name'] . " " . $userRow['last_name']);
//the title of the page (the name of the window / tab)
$pdf_obj->SetTitle($companyRow['company_name']." - Light Truckload Quote");
//the subject
$pdf_obj->SetSubject("Light Truck Load Quote");

//Footer Fonts
//defaults are used in this case
$pdf_obj->setFooterFont(array(
    PDF_FONT_NAME_DATA,
    '',
    PDF_FONT_SIZE_DATA
));

// set margins
//margin of 35 is used instead of the default because of our custom header.
$pdf_obj->SetMargins(PDF_MARGIN_LEFT, '35', PDF_MARGIN_RIGHT);
//Default
$pdf_obj->SetFooterMargin(PDF_MARGIN_FOOTER);

//enabled the header and the footer
$pdf_obj->setPrintHeader(true);
$pdf_obj->setPrintFooter(true);

// set auto page breaks
//in this case we use defaults
$pdf_obj->SetAutoPageBreak(True, PDF_MARGIN_BOTTOM);

// adds a page ready for use
// P for portrait
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);


//the html markup for page 1
$page1 = '';

$page1 .= create_EmployeeHTML($userRow['employee_id']);

$page1 .= create_CustomerHTML($customerRow['customer_id']);

$page1 .= create_CompanyHTML($companyRow['company_id']);

$page1 .= create_QuoteIntroHTML($customerRow['customer_id']);

// set font, style and size
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($page1, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

//html markup for the next page
$content .= '
    		<table border="1">
    			<thead>
    				<tr>
    					<th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Light Truckload Quote -</strong></th>
    				</tr>
    			</thead>
    			<tr>
    				<td> Date </td>
    				<td> ' . $ltlRow['quote_date'] . ' </td>
    			</tr>
    			<tr>
    				<td> Quote Name/Number </td>
    				<td> ' . $ltlRow['quote_num'] . '</td>
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
    				<td> ' . $ltlRow['product_name'] . '</td>
    			</tr>
    			<tr>
    				<td> Description </td>
    				<td> ' . $ltlRow['product_desc'] . '</td>
    			</tr>
    			<tr>
    				<td> Est. Annual Volume </td>
    				<td> ' . $ltlRow['annual_vol'] . '</td>
    			</tr>
    			<tr>
    				<td> OEM </td>
    				<td> ' . $ltlRow['OEM'] . '</td>
    			</tr>
    			<tr>
    				<td> Application </td>
    				<td> ' . $ltlRow['application'] . '</td>
    			</tr>
    			<tr>
    				<td> TL Price </td>
    				<td> ' . $ltlRow['truck_load'] . '</td>
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
    				<td> ' . $ltlRow['payment_terms'] . '</td>
    			</tr>
    			<tr>
    				<td> LTL quantities are</td>
    				<td> ' . $ltlRow['ltl_quantities'] . '</td>
    			</tr>
    			<tr>
    				<td> Special terms and conditions</td>
    				<td> ' . $ltlRow['special_terms'] . '</td>
    			</tr>
    			<tr>
    				<td> 1,500 lb. Bx, 2,200 lb. Bags</td>
    				<td> ' . $ltlRow['range1522'] . '</td>
    			</tr>
    			<tr>
    				<td> 1,100 - 2,199 lb. bags</td>
    				<td> ' . $ltlRow['range1121'] . '</td>
    			</tr>
    			<tr>
    				<td> 550 - 1099 lb. bags</td>
    				<td> ' . $ltlRow['range510'] . '</td>
    			</tr>
    			<tr>
    				<td> 275 - 549 lb. bags</td>
    				<td> ' . $ltlRow['range25'] . '</td>
    			</tr>
    			<tr>
    				<td> 110 - 274 lb. bags</td>
    				<td> ' . $ltlRow['range12'] . '</td>
    			</tr>
    			<tr>
    				<td> 55 lb. bags</td>
    				<td> ' . $ltlRow['range5'] . '</td>
    			</tr>
    		</table>';

//see function comment for more details
$content .= create_QuoteOutroHTML($userRow['employee_id']);

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($content, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// Terms and conditions html mark up
$terms .= "";

$terms .= create_QuoteTermsAndConditionsHTML();

// set font
$pdf_obj->SetFont('helvetica', '', 8);

// output the HTML content
$pdf_obj->writeHTML($terms, true, false, true, false, '');

// reset pointer to the last page
$pdf_obj->lastPage();

//this must be done in order to view the PDF file in browser right away before downloading
ob_end_clean();

//outputs the file,
$pdf_obj->Output($companyRow['company_name']."-Light Truckload Quote.pdf", "I");

?>