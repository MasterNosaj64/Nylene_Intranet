<?php
if (isset($_POST['submit'])) {

    switch ($_POST['formType']) {

        // Sample Request
        case 1:

            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/sampleForm_TCPDF.php?id={$_POST['formID']}\" />";
            exit();
            break;
        // Light Truckload Quote
        case 2:

            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/ltlQuoteForm_TCPDF.php?id={$_POST['formID']}\" />";
            exit();
            break;
        // tlquote
        case 3:

            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/tlQuoteForm_TCPDF.php?id={$_POST['formID']}\" />";
            exit();
            break;
        // Distributor Quote
        case 4:

            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/distributorQuoteForm_TCPDF.php?id={$_POST['formID']}\" />";
            exit();
            break;
        // Marketing Request
        // case 5:

        // echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/marketingRequestForm_TCPDF.php?id={$_POST['formID']}\" />";
        // exit();
        // break;
        // Credit Business Application
        case 6:

            echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/creditBusinessApp_TCPDF.php?id={$_POST['formID']}\" />";
            exit();
            break;
        // none
        default:
            echo "Select a form type to convert to pdf";

            break;
    }
}
?>

<link rel="stylesheet" href="../CSS/form.css">

<form method="post" action=jasonTestFile.php name="convertToPdf">
	<table>

		<tr>
			<td>Form Type</td>
			<td><select id="selection" required name="formType">
					<option value="0"></option>
					<option value="6">Credit Business Application</option>
					<option value="4">Distributor Quote</option>
					<option value="2">Light Truckload Quote</option>
					<!--  <option value="5">Marketing Request</option> -->
					<option value="1">Sample Request</option>
					<option value="3">Truckload Quote</option>
			</select></td>
		</tr>
		<tr>
			<td>Form ID:</td>
			<td><input type="text" required name="formID" /></td>
		</tr>
		<tr>
			<td><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
</form>