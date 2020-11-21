<link rel="stylesheet" href="../CSS/table.css">

<form method="post" action=testFile.php name="convertToPdf">
	<table>

		<tr>
			<td>Form Type</td>
			<td><select id="selection" required name="formType">
					<option value="0"></option>
					<option value="6">Credit Business Application</option>
					<option value="4">Distributor Quote</option>
					<option value="2">Light Truckload Quote</option>
					<option value="5">Marketing Request</option>
					<option value="1">Sample Request</option>
					<option value="3">Truckload Quote</option>
			</select></td>
		</tr>
		<tr>
			<td>Form ID:</td>
			<td><input type="text" name="formID" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="submit" /></td>
		</tr>


	</table>
</form>

<?php
if (isset($_POST['submit'])) {

    // Include the main TCPDF library (search for installation path).
    require_once ('../TCPDF/tcpdf.php');

    // create new PDF document obj
    $pdf_obj = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set document information
    $pdf_obj->SetCreator(PDF_CREATOR);
    $pdf_obj->SetAuthor("Jason Waid");
    $pdf_obj->SetTitle("Export to PDF TEST");
    $pdf_obj->SetSubject("Testing");

    // set default header data
    $pdf_obj->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);

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
    $pdf_obj->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);
    $pdf_obj->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf_obj->SetFooterMargin(PDF_MARGIN_FOOTER);

    /* $pdf_obj->setPrintHeader(false);
    $pdf_obj->setPrintFooter(false); */
    
    // set auto page breaks
    $pdf_obj->SetAutoPageBreak(True, PDF_MARGIN_BOTTOM);
    
    // set image scale factor
    $pdf_obj->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    // add a page
    $pdf_obj->AddPage('P',PDF_PAGE_FORMAT,false,false);
    
    // set font
    $pdf_obj->SetFont('helvetica', 'B', 20);
    
    $pdf_obj->Write(0, 'Test Conv to PDF', '', 0, 'L', true, 0, false, false, 0);
    
    $content = '';
    $content .= "<table class='form-table' border=5><tr><td>col1</td><td>col2</td><td>col3</td></tr>";
    $content .= "<tr><td>data1</td><td>data2</td><td>data3</td></tr></table>";

    
    // set font
    $pdf_obj->SetFont('helvetica', '', 12);
    
    // output the HTML content
    $pdf_obj->writeHTML($content,true, 0, true, true);
    
    // reset pointer to the last page
    $pdf_obj->lastPage();
    
    ob_end_clean();
    
    $pdf_obj->Output("test.pdf", "I");
}


/* // Include the main TCPDF library (search for installation path).
require_once('../TCPDF/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 039');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 039', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('helvetica', 'B', 20);

$pdf->Write(0, 'Example of HTML Justification', '', 0, 'L', true, 0, false, false, 0);

// create some HTML content
$html = '<span style="text-align:justify;">a <u>abc</u> abcdefghijkl (abcdef) abcdefg <b>abcdefghi</b> a ((abc)) abcd <img src="../TCPDF/examples/images/logo_example.png" border="0" height="41" width="41" /> <img src="../TCPDF/examples/images/tcpdf_box.svg" alt="test alt attribute" width="80" height="60" border="0" /> abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a <u>abc</u> abcd abcdef abcdefg <b>abcdefghi</b> a abc \(abcd\) abcdef abcdefg <b>abcdefghi</b> a abc \\\(abcd\\\) abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg <b>abcdefghi</b> a abc abcd abcdef abcdefg abcdefghi a abc abcd <a href="http://tcpdf.org">abcdef abcdefg</a> start a abc before <span style="background-color:yellow">yellow color</span> after a abc abcd abcdef abcdefg abcdefghi a abc abcd end abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi a abc abcd abcdef abcdefg abcdefghi<br />abcd abcdef abcdefg abcdefghi<br />abcd abcde abcdef</span>';

// set core font
$pdf->SetFont('helvetica', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);

$pdf->Ln();

// set UTF-8 Unicode font
$pdf->SetFont('dejavusans', '', 10);

// output the HTML content
$pdf->writeHTML($html, true, 0, true, true);

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------



//Close and output PDF document
$pdf->Output('example_039.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

 */

?>





