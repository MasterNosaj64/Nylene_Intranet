<?php
/*
 * Name: newSampleForm.php
 * Author: Emmett Janssens, Modified by Kaitlyn Breker
 * Last Modified: November 15th, 2020
 * Purpose: File called when user clicks submit on the input sample form. Inserts form information into
 * the sample_form table of the database.
 */
if (! session_id()) {
    session_start();
}
//include '../Database/databaseConnection.php';
include '../Database/connect.php';
$conn = getDBConnection();

$field = $_SESSION['field'];

$query_samples = "SELECT * FROM sample_form WHERE sample_form_id = " . $field;
$query_samples_results = $conn->query($query_samples);
$qsr = mysqli_fetch_array($query_samples_results);

// echo $qsr['m_code'];
/* $getCustomer = "SELECT * FROM company
						INNER JOIN company_relational_customer ON company_relational_customer.company_id = company.company_id
						INNER JOIN customer ON customer.customer_id = company_relational_customer.customer_id WHERE customer.customer_id = " . $qsr['customer_code'];

$getCustomerResult = $conn->query($getCustomer);
$gcr = mysqli_fetch_array($getCustomerResult); */

// $_SESSION['field']=$qsr[sample_form_id];
/* Check required variables for value, if none input 0 */
$m_code = $qsr['m_code'];
$credit_app_submitted = $qsr['credit_app_submitted'];
$business_case = $qsr['business_case'];
$match_sample_sub = $_POST['match_sample_sub'];
$match_data_sheet = $_POST['match_data_sheet'];
$match_description = $_POST['match_description'];
$material_description = $qsr['material_description'];
$customer_proc = $qsr['customer_proc'];
$customer_supplier = $qsr['customer_supplier'];
$finished_good_app = $qsr['finished_good_app'];
$annual_vol = $qsr['annual_vol'];
$current_resin_system = $qsr['current_resin_system'];
$target_price = $qsr['target_price'];
$melt_reqs = $qsr['melt_reqs'];
$current_filler_sys = $qsr['current_filler_sys'];
$colors = $qsr['colors'];
$known_additives = $qsr['known_additives'];
$uv_reqs = $qsr['uv_reqs'];
$ul_reqs = $qsr['ul_reqs'];
$auto_reqs = $qsr['auto_reqs'];
$fda_reqs = $qsr['fda_reqs'];
$color_specs = $qsr['color_specs'];
$response_date = $qsr['response_date'];
$prod_rec = $_POST['prod_rec'];
$stock_prod_qty = $_POST['stock_prod_qty'];
$other_doc = $qsr['other_doc'];
$sds = $_POST['sds'];
$coa = $_POST['coa'];
$sample_qty = $qsr['sample_qty'];
$sample_req_date = $qsr['sample_req_date'];
$data_sheet = $_POST['data_sheet'];
$sample_price = $qsr['sample_price'];
$sample_frt = $qsr['sample_frt'];
$other_contact_1 = $qsr['other_contact_1'];
$other_contact_2 = $qsr['other_contact_2'];
$other_contact_3 = $qsr['other_contact_3'];
$other_contact_4 = $qsr['other_contact_4'];

/* if (isset($_POST['m_code'])) {
    $m_code = $_POST['m_code'];
    // $m_code = htmlspecialchars(strip_tags($_POST['m_code']));
}

if (isset($_POST['company_name'])) {
    $company_name = htmlspecialchars(strip_tags($_POST['company_name']));
} else {
    $company_name = $gcr['company_name'];
}

if (isset($_POST['billing_address_street'])) {
    $billing_address_street = htmlspecialchars(strip_tags($_POST['billing_address_street']));
} else {
    $billing_address_street = $gcr['billing_address_street'];
}

if (isset($_POST['billing_address_city'])) {
    $billing_address_city = htmlspecialchars(strip_tags($_POST['billing_address_city']));
} else {
    $billing_address_city = $gcr['billing_address_city'];
}

if (isset($_POST['billing_address_state'])) {
    $billing_address_state = htmlspecialchars(strip_tags($_POST['billing_address_state']));
} else {
    $billing_address_state = $gcr['billing_address_state'];
}

if (isset($_POST['billing_address_postalcode'])) {
    $billing_address_postalcode = htmlspecialchars(strip_tags($_POST['billing_address_postalcode']));
} else {
    $billing_address_postalcode = $gcr['billing_address_postalcode'];
}

if (isset($_POST['customer_name'])) {
    $customer_name = htmlspecialchars(strip_tags($_POST['customer_name']));
} else {
    $customer_name = $gcr['customer_name'];
}

if (isset($_POST['customer_phone'])) {
    $customer_phone = htmlspecialchars(strip_tags($_POST['customer_phone']));
} else {
    $customer_phone = $gcr['customer_phone'];
}

if (isset($_POST['customer_email'])) {
    $customer_email = htmlspecialchars(strip_tags($_POST['customer_email']));
} else {
    $customer_email = $gcr['customer_email'];
}

if (isset($_POST['customer_fax'])) {
    $customer_fax = htmlspecialchars(strip_tags($_POST['customer_fax']));
} else {
    $customer_fax = $gcr['customer_fax'];
} */

if (isset($_POST['credit_app_submitted'])) {
 // $credit_app_submitted =$_POST['credit_app_submitted'];

   $credit_app_submitted = htmlspecialchars(strip_tags($_POST['credit_app_submitted']));
}


if (isset($_POST['business_case'])) {
    $business_case = htmlspecialchars(strip_tags($_POST['business_case']));
}


if (isset($_POST['match_sample_sub'])) {
    $match_sample_sub = htmlspecialchars(strip_tags($_POST['match_sample_sub']));
}

if (isset($_POST['match_data_sheet'])) {
    $match_data_sheet = htmlspecialchars(strip_tags($_POST['match_data_sheet']));
}


if (isset($_POST['match_description'])) {
    $match_description = htmlspecialchars(strip_tags($_POST['match_description']));
}


if (isset($_POST['material_description'])) {
    $material_description = htmlspecialchars(strip_tags($_POST['material_description']));
}


if (isset($_POST['customer_proc'])) {
    $customer_proc = htmlspecialchars(strip_tags($_POST['customer_proc']));
}

if (isset($_POST['customer_supplier'])) {
    $customer_supplier = htmlspecialchars(strip_tags($_POST['customer_supplier']));
}

if (isset($_POST['finished_good_app'])) {
    $finished_good_app = htmlspecialchars(strip_tags($_POST['finished_good_app']));
}


if (isset($_POST['annual_vol'])) {
    $annual_vol = htmlspecialchars(strip_tags($_POST['annual_vol']));
}

if (isset($_POST['current_resin_system'])) {
    $current_resin_system = htmlspecialchars(strip_tags($_POST['current_resin_system']));
}

if (isset($_POST['target_price'])) {
    $target_price = htmlspecialchars(strip_tags($_POST['target_price']));
}

if (isset($_POST['melt_reqs'])) {
    $melt_reqs = htmlspecialchars(strip_tags($_POST['melt_reqs']));
}

if (isset($_POST['current_filler_sys'])) {
    $current_filler_sys = htmlspecialchars(strip_tags($_POST['current_filler_sys']));
}

if (isset($_POST['colors'])) {
    $colors = htmlspecialchars(strip_tags($_POST['colors']));
}

if (isset($_POST['known_additives'])) {
    $known_additives = htmlspecialchars(strip_tags($_POST['known_additives']));
}

if (isset($_POST['uv_reqs'])) {
    $uv_reqs = htmlspecialchars(strip_tags($_POST['uv_reqs']));
}

if (isset($_POST['ul_reqs'])) {
    $ul_reqs = htmlspecialchars(strip_tags($_POST['ul_reqs']));
}

if (isset($_POST['auto_reqs'])) {
    $auto_reqs = htmlspecialchars(strip_tags($_POST['auto_reqs']));
}

if (isset($_POST['fda_reqs'])) {
    $fda_reqs = htmlspecialchars(strip_tags($_POST['fda_reqs']));
}

if (isset($_POST['color_specs'])) {
    $color_specs = htmlspecialchars(strip_tags($_POST['color_specs']));
}

if (isset($_POST['response_date'])) {
    $response_date = date(htmlspecialchars(strip_tags($_POST['response_date'])));
}

if (isset($_POST['prod_rec'])) {
    $prod_rec = htmlspecialchars(strip_tags($_POST['prod_rec']));
}

if (isset($_POST['stock_prod_qty'])) {
    $stock_prod_qty = htmlspecialchars(strip_tags($_POST['stock_prod_qty']));
}

if (isset($_POST['other_doc'])) {
    $other_doc = htmlspecialchars(strip_tags($_POST['other_doc']));
}

if (isset($_POST['sds'])) {
    $sds = htmlspecialchars(strip_tags($_POST['sds']));
}

if (isset($_POST['coa'])) {
    $coa = htmlspecialchars(strip_tags($_POST['coa']));
}

if (isset($_POST['sample_qty'])) {
    $sample_qty = htmlspecialchars(strip_tags($_POST['sample_qty']));
}

if (isset($_POST['sample_req_date'])) {
    $sample_req_date = htmlspecialchars(strip_tags($_POST['sample_req_date']));
}

if (isset($_POST['data_sheet'])) {
    $data_sheet = htmlspecialchars(strip_tags($_POST['data_sheet']));
}

if (isset($_POST['sample_price'])) {
    $sample_price = htmlspecialchars(strip_tags($_POST['sample_price']));
}

if (isset($_POST['sample_frt'])) {
    $sample_frt = htmlspecialchars(strip_tags($_POST['sample_frt']));
}

if (isset($_POST['other_contact_1'])) {
    $other_contact_1 = htmlspecialchars(strip_tags($_POST['other_contact_1']));
}

if (isset($_POST['other_contact_2'])) {
    $other_contact_2 = htmlspecialchars(strip_tags($_POST['other_contact_2']));
}

if (isset($_POST['other_contact_3'])) {
    $other_contact_3 = htmlspecialchars(strip_tags($_POST['other_contact_3']));
}

if (isset($_POST['other_contact_4'])) {
    $other_contact_4 = htmlspecialchars(strip_tags($_POST['other_contact_4']));
}

/* Check submittedBy field, if blank, display error */
if (empty($_POST['submittedBy'])) {
    echo "There were some errors with your form:";
    $referer = filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL);

    if (! empty($referer)) {
        echo '<p><a href="' . $referer . '" title="Return to the previous page">&laquo; Go back</a></p>';
    } else {
        echo '<p><a href="javascript:history.go(-1)" title="Return to the previous page">&laquo; Go back</a></p>';
    }
}

/* Assign values to variables */
/*
 * $dateSubmitted = htmlspecialchars(strip_tags($_POST['dateSubmitted']));
 * $marketCode = htmlspecialchars(strip_tags($_POST['mCode']));
 * $customer_id = htmlspecialchars(strip_tags($_SESSION['customer_id']));
 * $company_id = htmlspecialchars(strip_tags($_SESSION['company_id']));
 * $business_case = htmlspecialchars(strip_tags($_POST['business_case']));
 * $material_descr = htmlspecialchars(strip_tags($_POST['material_descr']));
 * $customer_proc = htmlspecialchars(strip_tags($_POST['customer_proc']));
 * $curr_supplier = htmlspecialchars(strip_tags($_POST['curr_supplier']));
 * $finished_good_app = htmlspecialchars(strip_tags($_POST['finised_good_app']));
 * $annual_vol = htmlspecialchars(strip_tags($_POST['annual_vol']));
 * $curr_resin_system = htmlspecialchars(strip_tags($_POST['curr_resin_system']));
 * $target_price = htmlspecialchars(strip_tags($_POST['target_price']));
 * $melt_reqs = htmlspecialchars(strip_tags($_POST['melt_reqs']));
 * $colors = htmlspecialchars(strip_tags($_POST['colors']));
 * $known_additives = htmlspecialchars(strip_tags($_POST['known_additives']));
 * $uv_reqs = htmlspecialchars(strip_tags($_POST['uv_reqs']));
 * $ul_reqs = htmlspecialchars(strip_tags($_POST['ul_reqs']));
 * $auto_reqs = htmlspecialchars(strip_tags($_POST['auto_reqs']));
 * $fda_reqs = htmlspecialchars(strip_tags($_POST['fda_reqs']));
 * $color_specs = htmlspecialchars(strip_tags($_POST['color_specs']));
 * $response_date = htmlspecialchars(strip_tags($_POST['response_date']));
 * $other_doc = htmlspecialchars(strip_tags($_POST['other_doc']));
 * $sample_qty = htmlspecialchars(strip_tags($_POST['sample_qty']));
 * $sample_req_date = htmlspecialchars(strip_tags($_POST['sample_req_date']));
 * $sample_price = htmlspecialchars(strip_tags($_POST['sample_price']));
 * $sample_frt = htmlspecialchars(strip_tags($_POST['sample_frt']));
 * $other_contact1 = htmlspecialchars(strip_tags($_POST['other_contact1']));
 * $other_contact2 = htmlspecialchars(strip_tags($_POST['other_contact2']));
 * $other_contact3 = htmlspecialchars(strip_tags($_POST['other_contact3']));
 * $other_contact4 = htmlspecialchars(strip_tags($_POST['other_contact4']));
 */
// include "../Database/connect.php";

// $conn = getDBConnection();

/* Check the connection */
if (mysqli_connect_error()) {
    die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error);
} else {
    /* Prepare insert statement into the sample_form table */
    $stmt = $conn->prepare("UPDATE sample_form SET
					m_code=?,
                    credit_app_submitted=?,
                    business_case=?,
                    match_sample_sub=?,
				    match_data_sheet=?,
                    match_description=?,
                    material_description=?,
                    customer_proc=?,
                    customer_supplier=?,
                    finished_good_app=?,
				    annual_vol=?,
                    current_resin_system=?,
                    target_price=?,
                    melt_reqs=?,
                    current_filler_sys=?,
                    colors=?,
                    known_additives=?,
				    uv_reqs=?,
                    ul_reqs=?,
                    auto_reqs=?,
                    fda_reqs=?,
                    color_specs=?,
                    response_date=?,
                    prod_rec=?,
                    stock_prod_qty=?,
				    sds=?,
                    coa=?,
                    data_sheet=?,
                    other_doc=?,
                    sample_qty=?,
                    sample_req_date=?,
                    sample_price=?,
                    sample_frt=?,
				    other_contact_1=?,
                    other_contact_2=?,
                    other_contact_3=?,
                    other_contact_4=? WHERE sample_form_id = " . $field);

    /* Bind statement parameters to statement and execute */
    $stmt->bind_param("sisiiisssssssssssssssssiisiississssss",
	$m_code, 
	$credit_app_submitted,
	$business_case, 
	$match_sample_sub, 
	$match_data_sheet, 
	$match_description, 
	$material_description, 
	$customer_proc, 
	$customer_supplier,
	$finished_good_app,
	$annual_vol,
	$current_resin_system,
	$target_price,
	$melt_reqs,
	$current_filler_sys,
	$colors,
	$known_additives,
	$uv_reqs,
	$ul_reqs,
	$auto_reqs, 
	$fda_reqs, 
	$color_specs,
	$response_date, 
	$prod_rec,
	$stock_prod_qty, 
	$sds, 
	$coa,
	$data_sheet,
	$other_doc,
	$sample_qty,
	$sample_req_date,
	$sample_price,
	$sample_frt, 
	$other_contact_1, 
	$other_contact_2,
	$other_contact_3, 
	$other_contact_4);

    $stmt->execute();

    /* Modified by Jason, to take Interaction_id generated previously */
    $id = $_SESSION['interaction_id'];

    /* Prepare insert statement into the interaction_relational_form table */
    $stmt2 = $conn->prepare("INSERT INTO interaction_relational_form (
					interaction_id,
                    form_id,
                    form_type)
                    VALUES (?, ?, ?)");

    /* Assign values to variables */
    $interactionNum = $id;
    $formID = $conn->insert_id; // retrieve id of last query under $conn
    $formType = 1;

    /* Bind statement parameters to statement */
    $stmt2->bind_param("iii", $interactionNum, $formID, $formType);

    /* Execute statement */
    $stmt2->execute();

    /* Close statements and connection */
    $stmt->close();
    $stmt2->close();
    // $conn->close();

    echo "<meta http-equiv = \"refresh\" content = \"0; url = ../Interactions/companyHistory.php\" />;";
    exit();
}
?>

