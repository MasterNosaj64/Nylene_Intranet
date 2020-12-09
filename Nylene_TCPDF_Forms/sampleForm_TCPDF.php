<?php
/*
 * FileName: sampleForm_TCPDF.php
 * Version Number: 1.0
 * Date Modified: 11/28/2020
 * Author: Jason Waid
 * Purpose:
 * Creates PDF file for sample quote
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

    /* Selection statement for employee that created the form */
    $userInformation = "SELECT * FROM employee
                        INNER JOIN interaction ON interaction.employee_id = employee.employee_id
                            INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
                                INNER JOIN sample_form ON sample_form.sample_form_id = interaction_relational_form.form_id
                                    WHERE sample_form_id = " . $form_id;

    $userResult = $conn->query($userInformation);
    $userRow = mysqli_fetch_array($userResult);

    /* Selection statement for form */
    $sampleQuery = "SELECT * FROM sample_form WHERE sample_form_id = " . $form_id;

    $sampleResults = $conn->query($sampleQuery);
    $sampleRow = mysqli_fetch_array($sampleResults);

    /* Selection statement for customer passed from interaction */
    $customerInformation = "SELECT * FROM customer
								INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
									INNER JOIN company ON company.company_id = company_relational_customer.company_id
										INNER JOIN interaction ON interaction.company_id = company.company_id
											INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
												INNER JOIN sample_form ON sample_form.sample_form_id = interaction_relational_form.form_id
													WHERE interaction_relational_form.form_type = 1 AND interaction_relational_form.form_id =" . $form_id;

    $customerResult = $conn->query($customerInformation);
    $customerRow = mysqli_fetch_array($customerResult);

    $companyInformation = "SELECT * FROM company
								INNER JOIN interaction ON interaction.company_id = company.company_id
									INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
										INNER JOIN sample_form ON sample_form.sample_form_id = interaction_relational_form.form_id
											WHERE interaction_relational_form.form_type = 1 AND interaction_relational_form.form_id =" . $form_id;

    $companyResult = $conn->query($companyInformation);
    $companyRow = mysqli_fetch_array($companyResult);

    $conn->close();
}

// create new PDF document obj
$pdf_obj = new TCPDF_NYLENE('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf_obj->SetCreator(PDF_CREATOR);
$pdf_obj->SetAuthor($userRow['first_name'] . " " . $userRow['last_name']);
$pdf_obj->SetTitle($companyRow['company_name']." - Sample Request");
$pdf_obj->SetSubject("Sample Request");

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

$pdf_obj->Write(0, 'Sample Request', '', 0, 'L', true, 0, false, false, 0);

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

if ($sampleRow['credit_app_submitted'] == 1) {
    $creditAppSubmited = "Yes";
} else {
    $creditAppSubmited = "No";
}

// Business Contanct Info
$content .= '<table border="1">
            <tr>
                <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>Business Contact Information</strong></th>
            </tr>
            <tr>
                <td> Submitted By:</td>
                <td> ' . $userRow['first_name'] . " " . $userRow['last_name'] . ' </td>
            </tr>
            <tr>
                <td> Date Created: </td>
                <td> ' . $sampleRow['date_submitted'] . '</td>
            </tr>
            <tr>
                <td> Market Code:</td>
                <td> ' . $sampleRow['m_code'] . '</td>
            </tr>
            <tr>
                <td> Company: </td>
                <td> ' . $companyRow['company_name'] . '</td>
            </tr>
            <tr>
                <td> Company Address: </td>
                <td> ' . $companyRow['billing_address_street'] . ", " . $companyRow['billing_address_city'] . ", " . $companyRow['billing_address_state'] . ", " . $companyRow['billing_address_postalcode'] . ' </td>
            </tr>
            <tr>
                <td> Primary Contact: </td>
                <td> ' . $customerRow['customer_name'] . '</td>
            </tr>
            <tr>
                <td> Phone Number: </td>
                <td> ' . $customerRow['customer_phone'] . ' </td>
            </tr>
            <tr>
                <td> Email Address: </td>
                <td> ' . $customerRow['customer_email'] . '</td>
            </tr>
            <tr>
                <td> Fax Number: </td>
                <td> ' . $customerRow['customer_fax'] . '</td>
            </tr>
            <tr>
                <td> Credit Application Submitted: </td>
                <td> ' . $creditAppSubmited . ' </td>
            </tr>
        </table>';

// Business Case for Sample
$content .= '
            <table border="1">
                <tr>                
                    <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Business Case for Sample -</strong></th>    
                </tr>
                <tr>
                    <td colspan="2"> ' . $sampleRow['business_case'] . ' </td>
                </tr>
            </table>';

// Assign Values of Sample Submission, Data Sheet and Description
if ($sampleRow['match_sample_sub'] == 1) {
    $sampleSubmission = "Yes";
} else {
    $sampleSubmission = "No";
}

if ($sampleRow['match_data_sheet'] == 1) {
    $dataSheet = "Yes";
} else {
    $dataSheet = "No";
}

if ($sampleRow['match_description'] == 1) {
    $description = "Yes";
} else {
    $description = "No";
}

// Match To
$content .= '
            <table border="1">
                <tr>
                    <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong>- Match To -</strong></th>
                </tr>
                <tr>
                    <td> Sample Submission  </td>
                    <td> ' . $sampleSubmission . '</td>
                </tr>
                <tr>
                    <td> Data Sheet  </td>
                    <td> ' . $dataSheet . '</td>
                </tr>
                <tr>
                    <td> Description  </td>
                    <td> ' . $description . '</td>
                </tr>
            </table>';

// Material Description, Special Handling or Label Request
$content .= '
            <table border="1">
                <tr>
                    <th style="text-align: center; background-color: rgb(168, 216, 255)"><strong> - Material Description, Special Handling or Label Request - </strong></th>
                </tr>
                <tr>
                    <td colspan="2"> ' . $sampleRow['material_description'] . '</td>
                </tr>
            </table>';

// Additional information
$content .= '
            <table border="1">
                <tr>
                    <td colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong> - Additional Information - </strong></td>
                </tr>
                <tr>
                    <td> Customer Process </td>
                    <td> ' . $sampleRow['customer_proc'] . '</td>
                </tr>
                <tr>
                    <td> Current Supplier </td>
                    <td> ' . $sampleRow['customer_supplier'] . '</td>
                </tr>
                <tr>
                    <td> Finished Good Application </td>
                    <td> ' . $sampleRow['finished_good_app'] . '</td>
                </tr>
                <tr>
                    <td> Est. Annual Volume </td>
                    <td> ' . $sampleRow['annual_vol'] . '</td>
                </tr>
                <tr>
                    <td> Current Base Resin System </td>
                    <td> ' . $sampleRow['current_resin_system'] . '</td>
                </tr>
                <tr>
                    <td> Target Price </td>
                    <td> ' . $sampleRow['target_price'] . '</td>
                </tr>
                <tr>
                    <td> Melt Requirements </td>
                    <td> ' . $sampleRow['melt_reqs'] . '</td>
                </tr>
                <tr>
                    <td> Current Filler System </td>
                    <td> ' . $sampleRow['current_filler_sys'] . '</td>
                </tr>
                <tr>
                    <td> Color(s) </td>
                    <td> ' . $sampleRow['colors'] . '</td>
                </tr>
                <tr>
                    <td> Known Additive Packages </td>
                    <td> ' . $sampleRow['known_additives'] . '</td>
                </tr>
                <tr>
                    <td> UV Requirements </td>
                    <td> ' . $sampleRow['uv_reqs'] . '</td>
                </tr>
                <tr>
                    <td> UL Requirements </td>
                    <td> ' . $sampleRow['ul_reqs'] . '</td>
                </tr>
                <tr>
                    <td> Automotive Specifications </td>
                    <td> ' . $sampleRow['auto_reqs'] . '</td>
                </tr>
                <tr>
                    <td> FDA Requirements </td>
                    <td> ' . $sampleRow['fda_reqs'] . '</td>
                </tr>
                <tr>
                    <td> Color Specifications </td>
                    <td> ' . $sampleRow['color_specs'] . '</td>
                </tr>
            </table>';

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($content, true, false, true, false, '');

// add a page
$pdf_obj->AddPage('P', PDF_PAGE_FORMAT, false, false);

// Assign values for check boxes
if ($sampleRow['prod_rec'] == 1) {
    $prodRecommendation = "Yes";
} else {
    $prodRecommendation = "No";
}

if ($sampleRow['stock_prod_qty'] == 1) {
    $stockProdQty = "Yes";
} else {
    $stockProdQty = "No";
}

if ($sampleRow['sds'] == 1) {
    $sds = "Yes";
} else {
    $sds = "No";
}

if ($sampleRow['coa'] == 1) {
    $coa = "Yes";
} else {
    $coa = "No";
}

if ($sampleRow['data_sheet'] == 1) {
    $datasheet = "Yes";
} else {
    $datasheet = "No";
}

// Type of responce needed
$page2 .= '
    
            <table border="1">
                <tr>
                    <th colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong> - Type Of Response Needed By - ' . $sampleRow['response_date'] . '</strong></th>
                </tr>
                <tr>
                    <td> Product Recommendation</td>
                    <td> ' . $prodRecommendation . '</td>
                </tr>
                <tr>
                    <td> Stock Product QTY</td>
                    <td> ' . $stockProdQty . '</td>
                </tr>
                <tr>
                    <td> SDS</td>
                    <td> ' . $sds . '</td>
                </tr>
                <tr>
                    <td> COA</td>
                    <td> ' . $coa . '</td>
                </tr>
                <tr>
                    <td> Data Sheet  </td>
                    <td> ' . $datasheet . ' </td>
                </tr>
                <tr>
                    <td> Other Documentation (Specify) </td>
                    <td> ' . $sampleRow['other_doc'] . '</td>
                </tr>
                <tr>
                    <td> Sample Quantity </td>
                    <td> ' . $sampleRow['sample_qty'] . ' </td>
                </tr>
                <tr>
                    <td> Date Required: </td>
                    <td> ' . $sampleRow['sample_req_date'] . '</td>
                </tr>
                <tr>
                    <td> Price:</td>
                    <td> ' . $sampleRow['sample_price'] . '</td>
                </tr>
                <tr>
                    <td> Frt PDD/Add:</td>
                    <td> ' . $sampleRow['sample_frt'] . '</td>
                </tr>
                <tr>
                    <td colspan="2" align="center"> ---Note: SDS Sent With All Samples---</td>
                </tr>
            </table>';

$page2 .= '
            <table border="1">
                <tr>
                    <td colspan="2" colspan="2" style="text-align: center; background-color: rgb(168, 216, 255)"><strong> - Distribution List - </strong></td>
                </tr>
                <tr>
                    <td style="width:50%"> ' . $sampleRow['other_contact_1'] . ' </td>
    				<td style="width:50%"> ' . $sampleRow['other_contact_2'] . ' </td>
    			</tr>
    			<tr>
                    <td style="width:50%"> ' . $sampleRow['other_contact_3'] . ' </td>
    				<td style="width:50%"> ' . $sampleRow['other_contact_4'] . '</td>
    			</tr>
            </table>';

// set font
$pdf_obj->SetFont('helvetica', '', 12);

// output the HTML content
$pdf_obj->writeHTML($page2, true, false, true, false, '');

// reset pointer to the last page
$pdf_obj->lastPage();

ob_end_clean();

$pdf_obj->Output($companyRow['company_name']."-Sample Request.pdf", "I");

?>