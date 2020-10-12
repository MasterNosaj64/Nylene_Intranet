<?php

class Interaction
{

    // database connection and table name
    private $conn;

    private $table_name = "interaction";

    // object properties
    public $interaction_id;

    public $company_id;

    public $customer_id;

    public $employee_id;

    public $reason;

    public $comments;

    public $date_created;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function read()
    {
        $query = "SELECT * FROM interaction";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->interaction_id, $this->company_id, $this->customer_id, $this->employee_id, $this->reason, $this->comments, $this->date_created);
        
        return $stmt;
    }

    function create()
    {

    }

    // delete
    function delete()
    {
    }

    
    /*
     * Function Name: getname
     * Version: 0.6
     * Date Modified: 10/11/2020
     * Author: Jason Waid
     * Purpose: Function returns the company_name of the object
     *
     */
    function getComments(){
        return $this->comments;
    }
    
    function getCompanyId(){
        return $this->company_id;
    }
    
    function getCustomerId(){
        return $this->customer_id;
    }
    
    function getInteractionId(){
        return $this->interaction_id;
    }
    
    function get(){
        return $this;
    }
    
    /*
     * Function Name: search
     * Version: 0.6
     * Date Modified: 10/11/2020
     * Author: Jason Waid
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     *
     */
    function search($interaction_id, $company_id, $customer_id, $employee_id, $reason, $comments, $date_created)
    {

        // number of string parameters
        $stringCount = 0;
        // number of integer parameters
        $intCount = 0;
        // String for keeping track of the parameter types
        $paramTypes = "";
        // The paramters to be added to the prepared SQL statement
        $params = array();

        // append query string, sanitize then apply % wildcard character to end of entered parmeter
        
        $query = "SELECT
                *
            FROM
			  nylene.interaction";

        if ($interaction_id != "") {
            $query .= " WHERE interaction_id LIKE ? ";
            $intCount ++;
            $paramTypes .= "i";
            $interaction_id = htmlspecialchars(strip_tags($interaction_id));
            array_push($params, $interaction_id);
        }

        if ($company_id != "") {
            if ($interaction_id == "") {
                $query .= " WHERE company_id LIKE ?";
            } else {
                $query .= " AND company_id LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $company_id = htmlspecialchars(strip_tags($company_id));
            array_push($params, $company_id);
        }

        if ($customer_id != "") {
            if ($interaction_id == "" && $company_id == "") {
                $query .= " WHERE customer_id LIKE ?";
            } else {
                $query .= " AND customer_id LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $customer_id = htmlspecialchars(strip_tags($customer_id));
            array_push($params, $customer_id);
        }

        if ($employee_id != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "") {
                $query .= " WHERE employee_id LIKE ?";
            } else {
                $query .= " AND employee_id LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $employee_id = htmlspecialchars(strip_tags($employee_id));
            array_push($params, $employee_id);
        }

        if ($reason != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "") {
                $query .= " WHERE reason LIKE ?";
            } else {
                $query .= " AND reason LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $reason = htmlspecialchars(strip_tags($reason));
            $reason .= "%";
            array_push($params, $reason);
        }

        if ($comments != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "" && $reason == "") {
                $query .= " WHERE comments LIKE ?";
            } else {
                $query .= " AND comments LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $comments = htmlspecialchars(strip_tags($comments));
            $comments .= "%";
            array_push($params, $comments);
        }

        if ($date_created != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "" && $reason == "" && $comments == "") {
                $query .= " WHERE date_created LIKE ?";
            } else {
                $query .= " AND date_created LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $date_created = htmlspecialchars(strip_tags($date_created));
            array_push($params, $date_created);
        }

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // determine number of parameters
        // seperate counters were used for debugging
        $paramCount = $stringCount + $intCount;

        switch ($paramCount) {

            case 1:

                $stmt->bind_param($paramTypes, $params[0]);
                break;
            case 2:

                $stmt->bind_param($paramTypes, $params[0], $params[1]);
                break;
            case 3:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2]);
                break;
            case 4:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3]);
                break;
            case 5:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4]);
                break;
            case 6:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5]);
                break;
            case 7:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6]);
                break;
                
           /*  default: */
                //no params
                
        }
        
        // execute query
        $stmt->execute();

        
        // bind the results
        $stmt->bind_result($this->interaction_id, $this->company_id, $this->customer_id, $this->employee_id, $this->reason, $this->comments, $this->date_created);
        // return objects
        return $stmt;
    }

    // update the product
    function update()
    {

    }
}
?>