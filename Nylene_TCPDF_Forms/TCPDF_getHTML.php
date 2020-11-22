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
    $employeeEmail = $employeeObj->getWork_Email();

    // Quoted by
    $content = "";

    $content .= '<div>
        <h2>Quoted by:</h2>
        <div>' . $employeeName . '</div>
        <div>' . $employeePhone . '</div>
        <div><a href="mailto:' . $employeeEmail . '">' . $employeeEmail . '</a></div>
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
    $companyAddress = $companyObj->getAddress();
    $companyEmail = $companyObj->getEmail();
    
    $content = "";
    
    $content .='
    <div>'.$companyName.'<br>
    '.$companyAddress.'</div>
    <div><a href="'.$companyEmail.'">'.$companyEmail.'</a></div>
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
    
    $content .='
    
    <div>
    <div>QUOTED TO:</div>
    <h2>'.$customerName.'</h2>
    '.$customerPhone.'
    <div><a href="mailto:'.$customerEmail.'">'.$customerEmail.'</a></div>
    </div>';
        
    return $content;
}

/*
 * Function: create_QuoteIntroHTML
 * Purpose:
 * Creates intro HTML elements
 * returns a string containing the HTML mark up
 */
function create_QuoteIntroHTML()
{
    $content = "";

    // Quoted by
}