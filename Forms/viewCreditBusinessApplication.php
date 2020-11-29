<?php
/*
 * Name: viewCreditBusinessApplication.php
 * Author: Isha Isha
 * Purpose: View credit business application form. Displays all the information filled in the form.
 */
session_start();

include '../NavPanel/navigation.php';
include '../Database/connect.php';

// getDBConnection to get connection
$conn = getDBConnection();

//defined('key') ? null : define('key', '84h84hjbgjrh848693');


$myFile = "../key.txt";
$file = fopen($myFile, "r");

if($file){
    while(!feof($file)){
        $key = fgets($file);
    }
    
    fclose($file);
}

/* Check the connection */
if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);
} else {

    /* Selection statement for credit business form */
    $creditBusinessQuery = "SELECT * FROM credit_application_business_form WHERE credit_application_business_id = " . $_POST['id'];
    $creditBusinessResults = $conn->query($creditBusinessQuery);
    $creditBusinessRow = mysqli_fetch_array($creditBusinessResults);

    if ($creditBusinessRow['order_pending'] == '1') {
        $checked = 1;
    } else {
        $checked = 0;
    }

   // $key = key; 
    $account_number_Query = "SELECT AES_DECRYPT(account_number,'$key') as decrypted FROM credit_application_business_form WHERE credit_application_business_id = " . $_POST['id'];
    $account_number_result = $conn->query($account_number_Query);
    $accountNumberRow = mysqli_fetch_array($account_number_result);

    /* Selection statement for customer information */
    $customerInformation = "SELECT * FROM customer 
									INNER JOIN company_relational_customer ON company_relational_customer.customer_id = customer.customer_id
										INNER JOIN company ON company.company_id = company_relational_customer.company_id
											INNER JOIN interaction ON interaction.company_id = company.company_id
												INNER JOIN interaction_relational_form ON interaction_relational_form.interaction_id = interaction.interaction_id
													INNER JOIN credit_application_business_form ON credit_application_business_form.credit_application_business_id = interaction_relational_form.form_id
														WHERE interaction_relational_form.form_type = 6 AND interaction_relational_form.form_id = " . $_POST['id'];
    $customerResult = $conn->query($customerInformation);
    $customerRow = mysqli_fetch_array($customerResult);

    $conn->close();
}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../CSS/form.css">
<title>View Credit Business Application</title>
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
				value="<?php echo $customerRow['company_name'];?>"></td>
			<td id="company_address">Company Address(City, State, ZIP Code)</td>
			<td><input type="text" name="company_address" readonly
				value="<?php echo $creditBusinessRow['company_address'];?>"></td>
			<tr>
				<td id="contact_name">Contact Name</td>
				<td colspan="2"><input type="text" name="contact_name" readonly
					value="<?php echo $creditBusinessRow['contact_name'];?>"></td>
				<td id="time_current_address">How long at current address?</td>
				<td colspan="2"><input type="text" name="time_current_address"
					readonly
					value="<?php echo $creditBusinessRow['time_current_address'];?>"></td>
			</tr>
			<tr>
				<td id="title">Title</td>
				<td colspan="2"><input type="text" name="title" readonly
					value="<?php echo $creditBusinessRow['title'];?>"></td>
				<td id="date_business_commenced">Date business commenced</td>
				<td colspan="2"><input type="text" name="date_business_commenced"
					readonly
					value="<?php echo $creditBusinessRow['date_business_commenced'];?>"></td>
			</tr>
			<tr>
				<td id="phone">Phone
				
				<td colspan="2"><input type="text" name="phone" readonly
					value="<?php echo $creditBusinessRow['phone'];?>"></td>
				<td id="nylene_representative">Nylene Representative</td>
				<td colspan="2"><input type="text" name="nylene_representative"
					readonly
					value="<?php echo $creditBusinessRow['nylene_representative'];?>"></td>
			</tr>

			<tr>
				<td id="fax">Fax</td>
				<td colspan="2"><input type="text" name="fax" readonly
					value="<?php echo $creditBusinessRow['fax'];?>"></td>
				<td id="order_pending">Order Pending?
        			<?php if ($checked){ ?>
        			<input type="radio" name="order_pending" value="1"
					checked> <label for="1"> Yes </label> <input type="radio"
					name="order_pending" value="0"> <label for="0"> No </label>
        			<?php } else { ?>
        			<input type="radio" name="order_pending" value="Yes">
					<label for="Yes"> Yes </label> <input type="radio"
					name="order_pending" value="No" checked> <label for="No"> No
				</label>
        			<?php } ?> </td>
        			
				<td colspan="2" id="order_amount">Order Amount $<input type="text"
					name="order_amount" readonly
					value="<?php echo $creditBusinessRow['order_amount'];?>"> /lbs.
				</td>
			</tr>
			<tr>
				<td id="business_email">E-mail</td>
				<td colspan="2"><input type="text" name="business_email" readonly
					value="<?php echo $creditBusinessRow['business_email'];?>"></td>
				<td ><label for="credit_date"> Credit Businees Application Date </label></td>
    			<td ><input type="date" id="credit_date" name="credit_date" value="<?php echo $creditBusinessRow['credit_date'];?>" readonly></td>
			</tr>

			<thead>
				<tr>
					<th colspan="6" align="center">BANK INFORMATION</th>
				</tr>
			</thead>
			<tr>
				<td id="bank_name">Bank Name
				
				<td colspan="2"><input type="text" name="bank_name" readonly
					value="<?php echo $creditBusinessRow['bank_name'];?>"></td>
				<td id="account_number">Account Number</td>
				<td colspan="2"><input type="text" name="account_number" readonly
					value="<?php echo $accountNumberRow['decrypted'];?>"></td>
			</tr>
			<tr>
				<td id="bank_address">Bank: City, State ZIP Code
				
				<td colspan="2"><input type="text" name="bank_address" readonly
					value="<?php echo $creditBusinessRow['bank_address'];?>"></td>
				<td id="bank_email">E-mail</td>
				<td colspan="2"><input type="text" name="bank_email" readonly
					value="<?php echo $creditBusinessRow['bank_email'];?>"></td>
			</tr>
			<tr>
				<td id="bank_contact_name">Bank Contact Name
				
				<td colspan="2"><input type="text" name="bank_contact_name" readonly
					value="<?php echo $creditBusinessRow['bank_contact_name'];?>"></td>
				<td id="bank_fax">Fax</td>
				<td colspan="2"><input type="text" name="bank_fax" readonly
					value="<?php echo $creditBusinessRow['bank_fax'];?>"></td>
			</tr>
			<tr>
				<td id="bank_phone">Phone</td>
				<td colspan="2"><input type="text" name="bank_phone" readonly
					value="<?php echo $creditBusinessRow['bank_phone'];?>"></td>
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
				
				<td colspan="2"><input type="text" name="ref1_company_name" readonly
					value="<?php echo $creditBusinessRow['ref1_company_name'];?>"></td>
				<td id="ref1_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref1_company_phone"
					readonly
					value="<?php echo $creditBusinessRow['ref1_company_phone'];?>"></td>
			</tr>

			<tr>
				<td id="ref1_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref1_company_contact_name"
					readonly
					value="<?php echo $creditBusinessRow['ref1_company_contact_name'];?>">
				</td>
				<td id="ref1_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref1_company_fax" readonly
					value="<?php echo $creditBusinessRow['ref1_company_fax'];?>"></td>
			</tr>

			<tr>
				<td id="ref1_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref1_company_address"
					readonly
					value="<?php echo $creditBusinessRow['ref1_company_address'];?>"></td>
				<td id="ref1_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref1_company_email"
					readonly
					value="<?php echo $creditBusinessRow['ref1_company_email'];?>"></td>
			</tr>
			<tr>
				<td colspan="6"><p>Reference #2</p></td>
			</tr>
			<tr>
				<td id="ref2_company_name">Company Name
				
				<td colspan="2"><input type="text" name="ref2_company_name" readonly
					value="<?php echo $creditBusinessRow['ref2_company_name'];?>"></td>
				<td id="ref2_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref2_company_phone"
					readonly
					value="<?php echo $creditBusinessRow['ref2_company_phone'];?>"></td>
			</tr>

			<tr>
				<td id="ref2_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref2_company_contact_name"
					readonly
					value="<?php echo $creditBusinessRow['ref2_company_contact_name'];?>">
				</td>
				<td id="ref2_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref2_company_fax" readonly
					value="<?php echo $creditBusinessRow['ref2_company_fax'];?>"></td>
			</tr>

			<tr>
				<td id="ref2_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref2_company_address"
					readonly
					value="<?php echo $creditBusinessRow['ref2_company_address'];?>"></td>
				<td id="ref2_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref2_company_email"
					readonly
					value="<?php echo $creditBusinessRow['ref2_company_email'];?>"></td>
			</tr>
			<tr>
				<td colspan="6"><p>Reference #3</p></td>
			</tr>
			<tr>
				<td id="ref3_company_name">Company Name
				
				<td colspan="2"><input type="text" name="ref3_company_name" readonly
					value="<?php echo $creditBusinessRow['ref3_company_name'];?>"></td>
				<td id="ref3_company_phone">Phone</td>
				<td colspan="2"><input type="text" name="ref3_company_phone"
					readonly
					value="<?php echo $creditBusinessRow['ref3_company_phone'];?>"></td>
			</tr>

			<tr>
				<td id="ref3_company_contact_name">Contact Name
				
				<td colspan="2"><input type="text" name="ref3_company_contact_name"
					readonly
					value="<?php echo $creditBusinessRow['ref3_company_contact_name'];?>">
				</td>
				<td id="ref3_company_fax">Fax</td>
				<td colspan="2"><input type="text" name="ref3_company_fax" readonly
					value="<?php echo $creditBusinessRow['ref3_company_fax'];?>"></td>
			</tr>

			<tr>
				<td id="ref3_company_address">Full Address
				
				<td colspan="2"><input type="text" name="ref3_company_address"
					readonly
					value="<?php echo $creditBusinessRow['ref3_company_address'];?>"></td>
				<td id="ref3_company_email">E-mail</td>
				<td colspan="2"><input type="text" name="ref3_company_email"
					readonly
					value="<?php echo $creditBusinessRow['ref3_company_email'];?>"></td>
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
		</table>

	</form>
</body>
</html>
