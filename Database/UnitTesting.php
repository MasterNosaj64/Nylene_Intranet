<?php
include './connect.php';
include './Company.php';
include './Customer.php';
include './Employee.php';
include './Interaction.php';

function updateRelationTable($company_id, $customer_id)
{
    $conn_Relational = getDBConnection();

    $sqlRelationQuery = $conn_Relational->prepare("INSERT INTO nylene.company_relational_customer
            (company_id,
            customer_id)
        
            VALUES (?,?)");

    $sqlRelationQuery->bind_param("ii", $company_id, $customer_id);

    if ($sqlRelationQuery->execute()) {
        $sqlRelationQuery->close();
        $conn_Relational->close();
        return true;
    }

    $sqlRelationQuery->close();
    $conn_Relational->close();

    return false;
}

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

// test object code
function testEdit($id)
{
    $company_name = "edit_company_name";
    $website = "edit_website";
    $billing_address_street = "edit_billing_street";
    $billing_address_city = "edit_billing_city";
    $billing_address_state = "edit_billing_state";
    $billing_address_postalcode = "edit_billing_postal";
    $billing_address_country = "edit_billing_country";
    $shipping_address_street = "edit_shipping_street";
    $shipping_address_city = "edit_shipping_city";
    $shipping_address_state = "edit_shipping_state";
    $shipping_address_postalcode = "edit_shipping_postal";
    $shipping_address_country = "edit_shipping_country";
    $description = "edit_description";
    $type = "edit_type";
    $industry = "edit_industry";
    $company_email = "edit_company_email";
    $assigned_to = 9;
    $date_modified = date("Y-m-d", time());
    $created_by = 9;

    $test_Conn = getDBConnection();
    $companyTest = new Company($test_Conn);
    $companyTest = $companyTest->update($id, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $date_modified);

    if ($companyTest == false) {
        echo "Company Edit Action Failed";
        return false;
    } else {

        $test_Conn = getDBConnection();
        $companyTest = new Company($test_Conn);
        $companyTest = $companyTest->searchId($id);

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
        if (strcmp($companyTest->getDateCreated(), $date_modified) != 0) {
            array_push($failedParams, $date_modified . " != " . $companyTest->getDateModified());
        }
        if ($companyTest->getCreatedBy() != $created_by) {
            array_push($failedParams, $created_by . " != " . $companyTest->getCreatedBy());
        }
    }

    if (count($failedParams) > 0) {

        echo "<h1>Company Search Mismatches</h1>";

        for ($i = 0; $i < count($failedParams); $i ++) {

            echo $failedParams[$i] . "<br>";
        }
    } else {
        echo "<h1>Company Edit Passed</h1>";
        return 1;
    }

    return - 1;
}

// test object code
function test_cx_Insert($id, $customer_name, $customer_email, $date_created, $customer_phone, $customer_fax)
{
    $test_Conn = getDBConnection();
    $customerTest = new Customer($test_Conn);
    $customerTest = $customerTest->searchById($id);

    if ($customerTest == false) {
        echo "Customer Search Action Failed";
        return false;
    } else {

        echo "<h1>Customer Search Passed</h1>";

        $failedParams = array();

        // check if all params match what was entered
        if (strcmp($customerTest->getName(), $customer_name) != 0) {
            array_push($failedParams, $customer_name . " != " . $customerTest->getName());
        }
        if (strcmp($customerTest->getEmail(), $customer_email) != 0) {
            array_push($failedParams, $customer_email . " != " . $customerTest->getEmail());
        }
        if (strcmp($customerTest->getPhone(), $customer_phone) != 0) {
            array_push($failedParams, $customer_phone . " != " . $customerTest->getPhone());
        }
        if (strcmp($customerTest->getFax(), $customer_fax) != 0) {
            array_push($failedParams, $customer_fax . " != " . $customerTest->getFax());
        }
    }
    return $failedParams;
}

function test_interaction_Insert($interaction_id, $company_id, $customer_id, $created_by, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date)
{
    $test_Conn = getDBConnection();
    $interactionTest = new Interaction($test_Conn);
    $interactionTest = $interactionTest->searchId($interaction_id);

    if ($interactionTest == false) {
        echo "Interaction Search Action Failed";
        return false;
    } else {

        echo "<h1>Interaction Search Passed</h1>";

        $failedParams = array();

        // check if all params match what was entered
        if ($company_id != $interactionTest->getCompanyId()) {
            array_push($failedParams, $company_id . " != " . $interactionTest->getCompanyId());
        }
        if ($interactionTest->getCustomerId() != $customer_id) {
            array_push($failedParams, $customer_id . " != " . $interactionTest->getCustomerId());
        }
        if ($interactionTest->getCreatedBy() != $created_by) {
            array_push($failedParams, $created_by . " != " . $interactionTest->getCreatedBy());
        }
        if (strcmp($interactionTest->getReason(), $reason) != 0) {
            array_push($failedParams, $reason . " != " . $interactionTest->getReason());
        }
        if (strcmp($interactionTest->getReason(), $reason) != 0) {
            array_push($failedParams, $reason . " != " . $interactionTest->getReason());
        }
        if (strcmp($interactionTest->getComments(), $comments) != 0) {
            array_push($failedParams, $comments . " != " . $interactionTest->getComments());
        }
        if (strcmp($interactionTest->getStatus(), $status) != 0) {
            array_push($failedParams, $status . " != " . $interactionTest->getStatus());
        }
        if (strcmp($interactionTest->getFollowUpType(), $follow_up_type) != 0) {
            array_push($failedParams, $follow_up_type . " != " . $interactionTest->getFollowUpType());
        }

        if (count($failedParams) > 0) {

            echo "<h1>Interaction Search Mismatches</h1>";

            for ($i = 0; $i < count($failedParams); $i ++) {
                echo $failedParams[$i] . "<br>";
            }
            return - 1;
        }
    }
    return 1;
    ;
}

// test object code
function test_cx_Edit($id)
{
    $customer_name = "edit_name";
    $customer_email = "edit_email";
    $customer_phone = "edit_phone";
    $customer_fax = "edit_fax";

    $test_Conn = getDBConnection();
    $customerTest = new Customer($test_Conn);
    $customerTest = $customerTest->update($id, $customer_name, $customer_email, $customer_phone, $customer_fax);

    if ($customerTest == false) {
        echo "Customer Edit Action Failed";
        return - 1;
    } else {

        $test_Conn = getDBConnection();
        $customerTest = new Customer($test_Conn);
        $customerTest = $customerTest->searchById($id);

        $failedParams = array();

        // check if all params match what was entered
        if (strcmp($customerTest->getName(), $customer_name) != 0) {
            array_push($failedParams, $customer_name . " != " . $customerTest->getName());
        }
        if (strcmp($customerTest->getEmail(), $customer_email) != 0) {
            array_push($failedParams, $customer_email . " != " . $customerTest->getEmail());
        }
        if (strcmp($customerTest->getPhone(), $customer_phone) != 0) {
            array_push($failedParams, $customer_phone . " != " . $customerTest->getPhone());
        }
        if (strcmp($customerTest->getFax(), $customer_fax) != 0) {
            array_push($failedParams, $customer_fax . " != " . $customerTest->getFax());
        }
    }

    if (count($failedParams) > 0) {

        echo "<h1>Customer Edit Mismatches</h1>";

        for ($i = 0; $i < count($failedParams); $i ++) {
            echo $failedParams[$i] . "<br>";
        }
        return - 1;
    } else {
        echo "<h1>Customer Edit Passed</h1>";
    }

    return 1;
}

function createCompany()
{
    $test_Conn = getDBConnection();

    $companyTest = new Company($test_Conn);

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
        return - 1;
    } else {

        echo "<h1>Company Create Passed</h1>";

        $company_id = $test_Conn->insert_id;
    }

    $insertTest = testInsert($company_id, $company_name, $website, $billing_address_street, $billing_address_city, $billing_address_state, $billing_address_postalcode, $billing_address_country, $shipping_address_street, $shipping_address_city, $shipping_address_state, $shipping_address_postalcode, $shipping_address_country, $description, $type, $industry, $company_email, $assigned_to, $date_created, $created_by);

    if (count($insertTest) > 0) {

        echo "<h1>Company Search Mismatches</h1>";

        for ($i = 0; $i < count($insertTest); $i ++) {

            echo $insertTest[$i] . "<br>";
        }
        return - 1;
    } else {
        echo "<h1>Company Search Passed</h1>";
    }

    return $company_id;
}

function create_Customer($company_id)
{

    // begin testing customer
    $test_Conn = getDBConnection();
    $customer_Test = new Customer($test_Conn);

    $customer_name = "test_name";
    $customer_email = "test_email";
    $date_created = $date_created = date("Y-m-d", time());
    $customer_phone = "test_phone";
    $customer_fax = "test_fax";

    $customer_Test = $customer_Test->create($customer_name, $customer_email, $date_created, $customer_phone, $customer_fax);

    if ($customer_Test == false) {
        echo "Create Customer Failed<br>";
        return - 1;
    } else {
        echo "<h1>Customer Create Passed</h1>";
        $customer_id = $test_Conn->insert_id;

        $insert_test = test_cx_Insert($customer_id, $customer_name, $customer_email, $date_created, $customer_phone, $customer_fax);

        if (count($insert_test) > 0) {

            echo "<h1>Customer Search Mismatches</h1>";

            for ($i = 0; $i < count($insert_test); $i ++) {
                echo $insert_test[$i] . "<br>";
            }
            return - 1;
        } else {

            if (updateRelationTable($company_id, $customer_id) == false) {
                echo "Relation Table Failed To Update<br>";

                // delete Customer
                $test_Conn = getDBConnection();
                $deleteQuery = "DELETE FROM nylene.customer WHERE customer_id = ?";

                $stmt = $test_Conn->prepare($deleteQuery);
                $stmt->bind_param("i", $customer_id);
                $stmt->execute();
                $test_Conn->close();

                if ($stmt->affected_rows > 0) {
                    echo "<h1>Customer Delete Passed</h1>";
                }
                $stmt->close();
                return - 1;
            }
        }
    }
    return $customer_id;
}

function create_Interaction($company_id, $customer_id)
{

    // begin testing customer
    $test_Conn = getDBConnection();
    $interaction_Test = new Interaction($test_Conn);

    // test inputs
    $company_id = $company_id;
    $customer_id = $customer_id;
    $created_by = 9;
    $reason = "General";
    $comments = "Test_Comment";
    $date_created = date("Y-m-d", time());
    $status = "open";
    $follow_up_type = "none";
    $follow_up_date = "";

    $interaction_Test = $interaction_Test->create($company_id, $customer_id, $created_by, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date);

    if ($interaction_Test == false) {
        echo "Create Interaction Failed<br>";
        return - 1;
    } else {
        echo "<h1>Interaction Create Passed</h1>";
        $interaction_id = $test_Conn->insert_id;

        $insert_test = test_interaction_Insert($interaction_id, $company_id, $customer_id, $created_by, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date);

        if ($insert_test == - 1) {
            return - 1;
        }
    }
    return $interaction_id;
}

// test object code
function test_Interaction_Edit($interaction_id)
{
    $comments = "Edit_Comment";
    $status = "closed";
    $follow_up_type = "interaction";
    $follow_up_date = "";

    $test_Conn = getDBConnection();
    $interactionTest = new Interaction($test_Conn);
    $interactionTest = $interactionTest->modify($interaction_id, $comments, $status, $follow_up_type, $follow_up_date);

    if ($interactionTest == false) {
        echo "Interaction Edit Action Failed";
        return - 1;
    } else {

        $test_Conn = getDBConnection();
        $interactionTest = new Interaction($test_Conn);
        $interactionTest = $interactionTest->searchId($interaction_id);

        $failedParams = array();

        // check if all params match what was entered
        if (strcmp($interactionTest->getComments(), $comments) != 0) {
            array_push($failedParams, $comments . " != " . $interactionTest->getComments());
        }
        if (strcmp($interactionTest->getStatus(), $status) != 0) {
            array_push($failedParams, $status . " != " . $interactionTest->getStatus());
        }
        if (strcmp($interactionTest->getFollowUpType(), $follow_up_type) != 0) {
            array_push($failedParams, $follow_up_type . " != " . $interactionTest->getFollowUpType());
        }
    }

    if (count($failedParams) > 0) {

        echo "<h1>Interaction Edit Mismatches</h1>";

        for ($i = 0; $i < count($failedParams); $i ++) {
            echo $failedParams[$i] . "<br>";
        }
        return - 1;
    } else {
        echo "<h1>Interaction Edit Passed</h1>";
    }

    return 1;
}

function delete_Company($company_id)
{
    // delete company
    $test_Conn = getDBConnection();
    $deleteQuery = "DELETE FROM nylene.company WHERE company_id = ?";

    $stmt = $test_Conn->prepare($deleteQuery);
    $stmt->bind_param("i", $company_id);
    $stmt->execute();
    $test_Conn->close();

    if ($stmt->affected_rows > 0) {
        echo "<h1>Company Delete Passed</h1>";
    } else {
        echo "<h1>Company Delete FAIL</h1>";
    }
    $stmt->close();
}

function delete_Customer($customer_id)
{
    // delete Customer
    $test_Conn = getDBConnection();
    $deleteQuery = "DELETE FROM nylene.customer WHERE customer_id = ?";

    $stmt = $test_Conn->prepare($deleteQuery);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $test_Conn->close();

    if ($stmt->affected_rows > 0) {
        echo "<h1>Customer Delete Passed</h1>";
    } else {
        echo "<h1>Customer Delete FAIL</h1>";
    }
    $stmt->close();
}

function delete_Interaction($interaction_id)
{
    // delete Customer
    $test_Conn = getDBConnection();
    $deleteQuery = "DELETE FROM nylene.interaction WHERE interaction_id = ?";

    $stmt = $test_Conn->prepare($deleteQuery);
    $stmt->bind_param("i", $interaction_id);
    $stmt->execute();
    $test_Conn->close();

    if ($stmt->affected_rows > 0) {
        echo "<h1>Interaction Delete Passed</h1>";
    } else {
        echo "<h1>Interaction Delete FAIL</h1>";
    }
    $stmt->close();
}



function unitTesting(){
    /*
     * Testing begins here
     */
    
    $company_id = createCompany();
    
    // if company creation Passed
    if ($company_id != - 1) {
        
        // if edit test Passed
        if (testEdit($company_id) != - 1) {
            
            $customer_id = create_Customer($company_id);
            
            // if create customer Passed
            if ($customer_id != - 1) {
                
                // if edit customer Passed
                if (test_cx_Edit($customer_id) != - 1) {
                    
                    $interaction_id = create_Interaction($company_id, $customer_id);
                    
                    // if create interaction Passed
                    if ($interaction_id != - 1) {
                        
                        // if edit interaction Passed
                        if (test_Interaction_Edit($interaction_id) != - 1) {}
                        
                        delete_Interaction($interaction_id);
                    }
                }
                
                delete_Customer($customer_id);
            }
        }
        
        delete_Company($company_id);
    }
    
}


?>