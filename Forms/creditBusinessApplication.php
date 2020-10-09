<?php
/*
 * Name: creditBusinessApplication.php
 * Author: Isha Isha
 * Purpose: Input for Credit business application form. The information that is already known is auto filled.
 */
session_start();
include '../navigation.php';
include '../Database/connect.php';

// check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {

    /* Selection statement for company passed from interaction */
    $companySelect = "SELECT * FROM company WHERE company_id = " . $_SESSION['company_id'];
    $companyInfo = $conn->query($companySelect);
    $companyRow = mysqli_fetch_array($companyInfo);

    /* Selection statement for customor passed from interaction */
    $customerSelect = "SELECT * FROM customer WHERE customer_id = " . $_SESSION['customer_id'];
    $customerInfo = $conn->query($customerSelect);
    $customerRow = mysqli_fetch_array($customerInfo);

    /* Selection statement for current employee */
    $userInformation = "SELECT concat(first_name,' ',last_name) as name, title, work_phone, employee_email FROM employee
								WHERE employee_id = " . $_SESSION['userid'];
    $result = $conn->query($userInformation);
    $row = mysqli_fetch_array($result);
    $conn->close();
}

?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../CSS/form.css">
</head>
<body>
	<form name="creditBusinessApplication"
		action="newCreditBusinessApplication.php" method="POST">
		<table class="form-table" border=1 cellspacing="0" cellpadding="1">
			<thead>
				<tr>
					<th colspan="7" align="center">Credit Application For Business
						Account</th>
				</tr>
			</thead>
			<thead>
				<tr>
					<th colspan="7" align="center">BUSINESS CONTACT INFORMATION</th>
				</tr>
			</thead>
			<td id="company_name">Company Name</td>
			<td colspan="2"><input type="text" name="company_name" readonly
				value="<?php echo $companyRow['company_name'];?>"></td>
			<td id="company_address">Company Address(City, State, ZIP Code)</td>
			<td><input type="text" name="company_address" readonly
				value="<?php echo $companyRow['billing_address_city'] . "," . $companyRow['billing_address_state'] . ", " . $companyRow['billing_address_postalcode']?>"></td>
			<tr>
				<td id="contact_name">Contact Name</td>
				<td colspan="2"><input type="text" name="contact_name" readonly
					value="<?php echo $customerRow['customer_name'];?>"></td>
				<td id="time_current_address">How long at current address?</td>
				<td colspan="2"><input type="text" name="time_current_address"
					required></td>
			</tr>
			<tr>
				<td id="title">Title</td>
				<td colspan="2"><input type="text" name="title" required></td>
				<td id="date_business_commenced">Date business commenced</td>
				<td colspan="2"><input type="text" name="date_business_commenced"
					required></td>
			</tr>
			<tr>
				<td id="phone">Phone
				
				<td colspan="2"><input type="text" name="phone" required></td>
				<td id="nylene_representative">Nylene Representative</td>
				<td colspan="2"><input type="text" name="nylene_representative"
					readonly value="<?php echo $row['name'];?>"></td>
			</tr>

			<tr>
				<td id="fax">Fax</td>
				<td colspan="2"><input type="text" name="fax" required></td>
				<td id="order_pending">Order Pending?<input type="checkbox">Yes<input
					type="checkbox">No
				</td>
				<td colspan="2" id="order_amount">Order Amount $<input type="text"
					name="order_amount" required> /lbs.
				</td>
			</tr>
			<tr>
				<td id="business_email">E-mail</td>
				<td colspan="2"><input type="text" name="business_email" required></td>
			</tr>

			<thead>
				<tr>
					<th colspan="6" align="center">BANK INFORMATION</th>
				</tr>
			</thead>
			<tr>
				<td id="bank_name">Bank Name
				
				<td colspan="2"><input type="text" name="bank_name" required></td>
				<td id="account_number">Account Number</td>
				<td colspan="2"><input type="text" name="account_number" required></td>
			</tr>
			<tr>
				<td id="bank_address">Bank: City, State ZIP Code
				
				<td colspan="2"><input type="text" name="bank_address" required></td>
				<td id="bank_email">E-mail</td>
				<td colspan="2"><input type="text" name="bank_email" required></td>
			</tr>
			<tr>
				<td id="bank_contact_name">Bank Contact Name
				
				<td colspan="2"><input type="text" name="bank_contact_name" required>
				</td>
				<td id="bank_fax">Fax</td>
				<td colspan="2"><input type="text" name="bank_fax" required></td>
			</tr>
			<tr>
				<td id="bank_phone">Phone</td>
				<td colspan="2"><input type="text" name="bank_phone" required></td>
			</tr>

			<thead>
				<tr>
					<th colspan="6" align="center">BUSINESS/TRADE REFERENCES</th>
				</tr>
			</thead>
			<tr>
				<td colspan="6"><p>Reference #1</p></td>
			</tr>
			<tr>
				<td id="ref1_company_name">Company Name
				
				<td colspan="2"><input type="text" name="ref1_company_name" required>
				</td>
				<td id="ref1_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref1_company_phone"
					required></td>
			</tr>

			<tr>
				<td id="ref1_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref1_company_contact_name"
					required></td>
				<td id="ref1_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref1_company_fax" required>
				</td>
			</tr>

			<tr>
				<td id="ref1_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref1_company_address"
					required></td>
				<td id="ref1_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref1_company_email"
					required></td>
			</tr>
			<tr>
				<td colspan="6"><p>Reference #2</p></td>
			</tr>
			<tr>
				<td id="ref2_company_name">Company Name
				
				<td colspan="2"><input type="text" name="ref2_company_name" required>
				</td>
				<td id="ref2_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref2_company_phone"
					required></td>
			</tr>

			<tr>
				<td id="ref2_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref2_company_contact_name"
					required></td>
				<td id="ref2_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref2_company_fax" required>
				</td>
			</tr>

			<tr>
				<td id="ref2_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref2_company_address"
					required></td>
				<td id="ref2_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref2_company_email"
					required></td>
			</tr>
			<tr>
				<td colspan="6"><p>Reference #3</p></td>
			</tr>
			<tr>
				<td id="ref3_company_name">Company Name
				
				<td colspan="2"><input type="text" name="ref3_company_name" required>
				</td>
				<td id="ref3_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref3_company_phone"
					required></td>
			</tr>

			<tr>
				<td id="ref3_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref3_company_contact_name"
					required></td>
				<td id="ref3_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref3_company_fax" required>
				</td>
			</tr>

			<tr>
				<td id="ref3_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref3_company_address"
					required></td>
				<td id="ref3_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref3_company_email"
					required></td>
			</tr>
			<thead>
				<tr>
					<th colspan="6" align="center">AGREEMENT</th>
				</tr>
			</thead>

			<tr>
				<td colspan="6"><p>Upon approval, standard terms are net 30 days.
						Alternate terms must be separately requested and agreed in
						writing. Claims arising from invoices must be made in writing
						within seven working days. By submitting this application, you
						authorize Nylene to make inquiries into the banking and
						business/trade references that you have supplied.</p></td>
			</tr>

			<thead>
				<tr>
					<th colspan="6" align="center">SIGNATURES</th>
				</tr>
			</thead>
			<tr>
				<td id="info">Signature
				
				<td colspan="2"><input type="text"></td>
				<td id="info">Signature</td>
				<td colspan="2"><input type="text"></td>
			</tr>

			<tr>
				<td id="info">Name and Title
				
				<td colspan="2"><input type="text"></td>
				<td id="info">Name and Title</td>
				<td colspan="2"><input type="text"></td>
			</tr>

			<tr>
				<td id="info">Date
				
				<td colspan="2"><input type="text"></td>
				<td id="info">Date</td>
				<td colspan="2"><input type="text"></td>
			</tr>

			<tr>
				<td colspan="6"><p>Upon completion please scan and return by email
						to tgreenstein@nylene.com or fax to: Toby Greenstein at
						973-694-3549</p></td>
			</tr>

			<tr>
				<td colspan="4" align="center"><input type="submit" value="submit"
					style="width: 100%"></td>
				<td colspan="4" align="center"><input type="reset" value="reset"
					style="width: 100%"></td>
			</tr>
		</table>

	</form>
</body>
</html>
