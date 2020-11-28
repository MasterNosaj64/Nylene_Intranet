<?php
/*
 * FileName: TCPDF_getHTML.php
 * Version Number: 0.5
 * Date Modified: 11/22/2020
 * Author: Jason Waid
 * Purpose:
 * All function for handling and creating html data for TCPDF Forms
 */
include '../Database/Customer.php';
include '../Database/Company.php';
include '../Database/Employee.php';
include '../Database/connect.php';

/*
 * Function: create_EmployeeHTML
 * Purpose:
 * Creates Employee HTML elements
 * returns a string containing the HTML mark up
 */
function create_EmployeeHTML($employee_id)
{

    // database connection
    $db_conn = getDBConnection();
    $employeeObj = new Employee($db_conn);
    $employeeObj = $employeeObj->searchById($employee_id);
    $db_conn->close();

    $employeeName = $employeeObj->getName();
    $employeePhone = $employeeObj->getWork_Phone();
    $employeeEmail = $employeeObj->getEmployee_Email();

    // Quoted by
    $content = "";

    $content .= '<div>
        <h2>Quoted by:</h2>
        ' . $employeeName . '<br>' . $employeePhone . '<br><a href="mailto:' . $employeeEmail . '">' . $employeeEmail . '</a>
    </div>';

    return $content;
}

/*
 * Function: create_CompanyHTML
 * Purpose:
 * Creates Company HTML elements
 * returns a string containing the HTML mark up
 */
function create_CompanyHTML($company_id)
{
    $db_conn = getDBConnection();
    $companyObj = new Company($db_conn);
    $companyObj = $companyObj->searchId($company_id);
    $db_conn->close();

    $companyName = $companyObj->getName();
    // $companyAddress = $companyObj->getBillingAddress();
    $companyAddressStreet = $companyObj->getBillingAddressStreet();
    $companyAddressCity = $companyObj->getBillingAddressCity();
    $companyAddressState = $companyObj->getBillingAddressState();
    $companyAddressCountry = $companyObj->getBillingAddressCountry();
    $companyAddressPostalCode = $companyObj->getBillingAddressPostalCode();
    $companyEmail = $companyObj->getEmail();

    $content = "";

    $content .= '
    <div>' . $companyName . '<br>' . $companyAddressStreet . '<br>' . $companyAddressCity . ', ' . $companyAddressState . '<br>' . $companyAddressPostalCode . '<br>' . $companyAddressCountry . '<br><a href="' . $companyEmail . '">' . $companyEmail . '</a>
    </div>';

    return $content;
}

/*
 * Function: create_CustomerHTML
 * Purpose:
 * Creates Customer HTML elements
 * returns a string containing the HTML mark up
 */
function create_CustomerHTML($customer_id)
{
    $db_conn = getDBConnection();
    $customerObj = new Customer($db_conn);
    $customerObj = $customerObj->searchById($customer_id);
    $db_conn->close();

    $customerName = $customerObj->getName();
    $customerPhone = $customerObj->getPhone();
    $customerEmail = $customerObj->getEmail();

    $content = "";

    $content .= '
    
    <div><h2>Quoted to:</h2>' . $customerName . '<br>' . $customerPhone . '<br><a href="mailto:' . $customerEmail . '">' . $customerEmail . '</a></div>
    </div>';

    return $content;
}

/*
 * Function: create_QuoteIntroHTML
 * Purpose:
 * Creates intro HTML elements
 * returns a string containing the HTML mark up
 */
function create_QuoteIntroHTML($customer_id)
{
    $db_conn = getDBConnection();
    $customerObj = new Customer($db_conn);
    $customerObj = $customerObj->searchById($customer_id);

    $customerName = $customerObj->getName();
    $db_conn->close();

    $content = "";

    $content .= '
    
    <p>Dear ' . $customerName . ',</p>
    <p>On behalf of Nylene, I am pleased to provide the following pricing confirmation:</p>';

    return $content;
}

/*
 * Function: create_EmployeeHTML
 * Purpose:
 * Creates Employee HTML elements
 * returns a string containing the HTML mark up
 */
function create_QuoteOutroHTML($employee_id)
{

    // database connection
    $db_conn = getDBConnection();
    $employeeObj = new Employee($db_conn);
    $employeeObj = $employeeObj->searchById($employee_id);
    $db_conn->close();

    $employeeName = $employeeObj->getName();
    // $employeePhone = $employeeObj->getWork_Phone();
    // $employeeEmail = $employeeObj->getEmployee_Email();
    $employeeTitle = $employeeObj->getTitle();

    // Quoted by
    $content = "";

    $content .= '
    <div>
        <div>Prices quoted price is based on the current economic conditions and supplier reserves the right to evaluate the pricing in the case of any significant changes in the cost of the components of the product.
        </div>
        <div>Lead time of this product is 4 to 6 weeks. Customer is to supply an accurate 90 day rolling forecast.
        </div>
        <div>Purchase orders should include: Nylene product number, packaging type and release quantity, credit terms, required ship date, 
        specifications and approvals required, customer part number if required, and any other special instructions.
        </div>
        <p>Please review this information and let me know if there are any questions.</p>
        <p>We thank you for your business.</p>
        <p><span>' . $employeeName . '</span></p>
        <p><br>' . $employeeTitle . '</p>
</div>
';

    return $content;
}

