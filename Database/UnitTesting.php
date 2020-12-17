<?php
include './connect.php';
include './Company.php';
include './Customer.php';
include './Employee.php';
include './Interaction.php';

// test object code
function testInsert($id, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by)
{
    $test_Conn = getDBConnection();
    $companyTest = new Company($test_Conn);
    $companyTest = $companyTest->searchId($id);

    if ($companyTest == false) {
        echo "Company Search Action Failed";
        return false;
    } else {

        
        $company_name = htmlspecialchars(strip_tags($company_name));
        $website = htmlspecialchars(strip_tags($website));
        $billing_address_street = htmlspecialchars(strip_tags($billing_address_street));
        $billing_address_city = htmlspecialchars(strip_tags($billing_address_city));
        $billing_address_state = htmlspecialchars(strip_tags($billing_address_state));
        $billing_address_postalcode = htmlspecialchars(strip_tags($billing_address_postalcode));
        $billing_address_country = htmlspecialchars(strip_tags($billing_address_country));
        $shipping_address_street = htmlspecialchars(strip_tags($shipping_address_street));
        $shipping_address_city = htmlspecialchars(strip_tags($shipping_address_city));
        $shipping_address_state = htmlspecialchars(strip_tags($shipping_address_state));
        $shipping_address_postalcode = htmlspecialchars(strip_tags($shipping_address_postalcode));
        $shipping_address_country = htmlspecialchars(strip_tags($shipping_address_country));
        $description = htmlspecialchars(strip_tags($description));
        $type = htmlspecialchars(strip_tags($type));
        $industry = htmlspecialchars(strip_tags($industry));
        $company_email = htmlspecialchars(strip_tags($company_email));
        $assigned_to = htmlspecialchars(strip_tags($assigned_to));
        $date_created = htmlspecialchars(strip_tags($date_created));
        $created_by = htmlspecialchars(strip_tags($created_by));
        
        $failedParams = array();

        // check if all params match what was entered
        if (strcmp($companyTest->getName(), $company_name) != 0) {
            array_push($failedParams, $company_name . " != " . $companyTest->getName());
        }
        if (strcmp($companyTest->getWebsite(), $website) != 0) {
            array_push($failedParams, $website . " != " . $companyTest->getWebsite());
        }
        if (strcmp($companyTest->getBillingAddressStreet(), $billing_address_street) != 0) {
            array_push($failedParams, $billing_address_street . " != " . $companyTest->getBillingAddressStreet());
        }
        if (strcmp($companyTest->getBillingAddressCity(), $billing_address_city) != 0) {
            array_push($failedParams, $billing_address_city . " != " . $companyTest->getBillingAddressCity());
        }
        if (strcmp($companyTest->getBillingAddressState(), $billing_address_state) != 0) {
            array_push($failedParams, $billing_address_state . " != " . $companyTest->getBillingAddressState());
        }
        if (strcmp($companyTest->getBillingAddressPostalCode(), $billing_address_postalcode) != 0) {
            array_push($failedParams, $billing_address_postalcode . " != " . $companyTest->getBillingAddressPostalCode());
        }
        if (strcmp($companyTest->getBillingAddressCountry(), $billing_address_country) != 0) {
            array_push($failedParams, $billing_address_country . " != " . $companyTest->getBillingAddressCountry());
        }
        if (strcmp($companyTest->getShippingAddressStreet(), $shipping_address_street) != 0) {
            array_push($failedParams, $shipping_address_street . " != " . $companyTest->getShippingAddressStreet());
        }
        if (strcmp($companyTest->getShippingAddressCity(), $shipping_address_city) != 0) {
            array_push($failedParams, $shipping_address_city . " != " . $companyTest->getShippingAddressCity());
        }
        if (strcmp($companyTest->getShippingAddressState(), $shipping_address_state) != 0) {
            array_push($failedParams, $shipping_address_state . " != " . $companyTest->getShippingAddressState());
        }
        if (strcmp($companyTest->getShippingAddressPostalCode(), $shipping_address_postalcode) != 0) {
            array_push($failedParams, $shipping_address_postalcode . " != " . $companyTest->getShippingAddressPostalCode());
        }
        if (strcmp($companyTest->getShippingAddressCountry(), $shipping_address_country) != 0) {
            array_push($failedParams, $shipping_address_country . " != " . $companyTest->getShippingAddressCountry());
        }
        if (strcmp($companyTest->getDescription(), $description) != 0) {
            array_push($failedParams, $description . " != " . $companyTest->getDescription());
        }
        if (strcmp($companyTest->getType(), $type) != 0) {
            array_push($failedParams, $type . " != " . $companyTest->getType());
        }
        if (strcmp($companyTest->getIndustry(), $industry) != 0) {
            array_push($failedParams, $industry . " != " . $companyTest->getIndustry());
        }
        if (strcmp($companyTest->getEmail(), $company_email) != 0) {
            array_push($failedParams, $company_email . " != " . $companyTest->getEmail());
        }
        if ($companyTest->getAssignedTo() != $assigned_to) {
            array_push($failedParams, $assigned_to . " != " . $companyTest->getAssignedTo());
        }
        if (strcmp($companyTest->getDateCreated(), $date_created) != 0) {
            array_push($failedParams, $date_created . " != " . $companyTest->getDateCreated());
        }
        if ($companyTest->getCreatedBy() != $created_by) {
            array_push($failedParams, $created_by . " != " . $companyTest->getCreatedBy());
        }
    }
    return $failedParams;
}

$test_Conn = getDBConnection();

$companyTest = new Company($test_Conn);
$companyTestDescription = "";
$companyTest;
// Test Criteria
$company_name = "test_company_name";
$website = "test_website";
$billing_address_street = "test_billing_street";
$billing_address_city = "test_billing_city";
$billing_address_state = "test_billing_state";
$billing_address_postalcode = "test_billing_postal";
$billing_address_country = "test_billing_country";
$shipping_address_street = "test_shipping_street";
$shipping_address_city = "test_shipping_city";
$shipping_address_state = "test_shipping_state";
$shipping_address_postalcode = "test_shipping_postal";
$shipping_address_country = "test_shipping_country";
$description = "test_description";
$type = "test_type";
$industry = "test_industry";
$company_email = "test_company_email";
$assigned_to = 9;
$date_created = date("Y-m-d", time());
$created_by = 9;

$companyTest = $companyTest->create($company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by);

if ($companyTest == false) {
    echo "Company Create Action Failed";
} else {

    $insertTest = $test_Conn->insert_id;

    $insertTest = testInsert($insertTest, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by);

    if ($insertTest == false) {} else {

        if (count($insertTest) > 0) {

            echo "<h1>Company Search Mismatches</h1>";

            for ($i = 0; $i < count($insertTest); $i ++) {

                echo $insertTest[$i] . "<br>";
            }
        } else {
            echo "<h1>Company Search Pass</h1>";
        }
    }
}

if ($companyTest == false) {
    echo "<h1>Company Insert/Search Fail</h1>";
    echo $companyTestDescription;
}

?>


