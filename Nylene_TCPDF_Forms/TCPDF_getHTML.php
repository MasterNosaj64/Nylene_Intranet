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
function create_EmployeeHTML($employee_id){
    
    //database connection
    $db_conn = getDBConnection();
    $employeeObj = new Employee($db_conn);
    $employeeObj = $employeeObj->searchById($employee_id);
    $db_conn->close();
    
    
    $employeeName = $employeeObj->getName();
    
    //Quoted by
    $content = "";
    
    $content = <<<EOF
    <div>
        <h2>Quoted by:</h2>
        <div>{Name (First):85.3} {Name (Last):85.6}{created_by:display_name}</div>
        <div>{Your Phone Number:97}</div>
        <div><a href="mailto:{created_by:user_email}">{created_by:user_email}</a></div>
    </div>
EOF;
    
}

/*
 * Function: create_CompanyHTML
 * Purpose:
 * Creates Company HTML elements
 * returns a string containing the HTML mark up
 */
function create_CompanyHTML(){
    
    $content = "";
    
}

/*
 * Function: create_CustomerHTML
 * Purpose:
 * Creates Customer HTML elements
 * returns a string containing the HTML mark up
 */
function create_CustomerHTML(){
    
    $content = "";
    
}

/*
 * Function: create_QuoteIntroHTML
  * Purpose:
 * Creates intro HTML elements
 * returns a string containing the HTML mark up
 */
function create_QuoteIntroHTML(){
    
    $content = "";
    
    //Quoted by
    
    
    
}