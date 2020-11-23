<?php
if (isset($_POST['submit'])) {

    if ($_POST['formType'] == 3) {

        echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Nylene_TCPDF_Forms/tlQuoteForm_TCPDF.php?id=3\" />";
        exit();
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
			<td><input type="submit" name="submit" value="Submit" /></td>
		</tr>
	</table>
</form>