<?php
/*
 * FileName: Interaction.php
 * Author: Jason Waid, Modified by Kaitlyn Breker
 * Version: 1.00
 * Date Modified: 12/07/2020
 * Purpose:
 *  Object oriented representation of a interaction
 *  all database manipulation happens here
 */
class Interaction
{

    // database connection and table name
    private $conn;

    private $table_name = "interaction";

    // object properties
    public $interaction_id;

    public $company_id;

    public $customer_id;

    public $created_by;

    public $reason;

    public $comments;

    public $date_created;
    
    public $status;
    
    public $follow_up_type;
    
    public $follow_up_date;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    /*
     * FileName: read
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose:
     * grabs all interactions from the connected db
     * returns the objects
     */
    public function read()
    {
        $query = "SELECT * FROM interaction";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->interaction_id, $this->company_id, $this->customer_id, $this->created_by, $this->reason, $this->comments, $this->date_created, $this->status, $this->follow_up_type, $this->follow_up_date);
        
        return $stmt;
    }

    /*
     * FileName: create
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose:
     * creates a interaction with the supplied parameters
     * returns bool on failure or last insert id
     */
    function create($company_id, $customer_id, $created_by, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date)
    {
        
        // query to insert record
        $query = "INSERT INTO
                nylene.interaction (company_id, customer_id, employee_id, reason, comments, date_created, status, follow_up_type, follow_up_date)
            VALUES(
              ?,?,?,?,?,?,?,?,?)";
        
        $stmt = $this->conn->prepare($query);
        
        $company_id = htmlspecialchars(strip_tags($company_id));
        $customer_id = htmlspecialchars(strip_tags($customer_id));
        $created_by = htmlspecialchars(strip_tags($created_by));
        $reason = htmlspecialchars(strip_tags($reason));
        $comments = htmlspecialchars(strip_tags($comments));
        $date_created = htmlspecialchars(strip_tags($date_created));
        $status = htmlspecialchars(strip_tags($status));
        $follow_up_type = htmlspecialchars(strip_tags($follow_up_type));
        $follow_up_date = htmlspecialchars(strip_tags($follow_up_date));
      
        $stmt->bind_param("iiissssss", $company_id, $customer_id, $created_by, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date);
        
        if (! $stmt->execute()) {
            return false;
        }
        
        $insert_id = $stmt->insert_id;
        $stmt->close();
        
        return $insert_id;
    }
    
    /*
     * FileName: modify
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose:
     * modify a interaction with the parameters
     * Return: bool on success or failure
     */
    function modify($interaction_id, $comments, $status, $follow_up_type, $follow_up_date){

        $query = "UPDATE interaction SET
                        comments = ?, 
                        status = ?, 
                        follow_up_type = ?, 
                        follow_up_date = ?
                    WHERE interaction_id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $comments = htmlspecialchars(strip_tags($comments));
        $status = htmlspecialchars(strip_tags($status));
        $follow_up_type = htmlspecialchars(strip_tags($follow_up_type));
        $follow_up_date = htmlspecialchars(strip_tags($follow_up_date));
        
        $stmt->bind_param("ssssi", $comments, $status, $follow_up_type, $follow_up_date, $interaction_id);
        
        if (! $stmt->execute()) {
            return false;
        }
        return true;
    }

    /*
     * FileName: getCreatedBy
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose:
     * Function returns the created_by
     */
    function getCreatedBy(){
        return $this->created_by;
    }
    
    /*
     * FileName: getComments
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose:
     * Function returns the ccomments
     */
    function getComments(){
        return $this->comments;
    }
    
    
    /*
     * FileName: getCompanyId
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the company_id
     */
    function getCompanyId(){
        return $this->company_id;
    }
    
    /*
     * FileName: getDateCreated
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the date_created
     */
    function getDateCreated(){
        return $this->date_created;
    }
    
    /*
     * FileName: getCustomerId
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the customer_id
     */
    function getCustomerId(){
        return $this->customer_id;
    }
    
    /*
     * FileName: getInteractionId
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the interaction_id
     */
    function getInteractionId(){
        return $this->interaction_id;
    }
    
    /*
     * FileName: getReason
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the reason
     */
    function getReason(){
        return $this->reason;
    }
    /*
     * FileName: getStatus
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the status
     */
    function getStatus(){
        return $this->status;
    }
    
    /*
     * FileName: getFollowUpType
     * Author: Kaitlyn Breker
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the follow_up_type
     */
    function getFollowUpType(){
        return $this->follow_up_type;
    }
    
    /*
     * FileName: getFollowUpDate
     * Author: Kaitlyn Breker
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the follow_up_date
     */
    function getFollowUpDate(){
        return $this->follow_up_date;
    }
    
    /*
     * FileName: get
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function returns the object
     */
    function get(){
        return $this;
    }
    
    /*
     * FileName: searchId
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: A simpler version of search that only searches using the interaction_id
     */
    function searchId($interaction_id)
    {
        $query = "SELECT
                *
            FROM
			  nylene.interaction WHERE interaction_id = ?";
        
        $stmt = $this->conn->prepare($query);
        
        $interaction_id = htmlspecialchars(strip_tags($interaction_id));
        
        $stmt->bind_param("i", $interaction_id);
        
        // execute query
        if (! $stmt->execute()) {
            return false;
        }
        
        // bind the results
        $stmt->bind_result($this->interaction_id, $this->company_id, $this->customer_id, $this->created_by, $this->reason, $this->comments, $this->date_created, $this->status, $this->follow_up_type, $this->follow_up_date);
        
        
        $stmt->fetch();
        $stmt->close();
        // return objects
        return $this;
    }
    
    /*
     * FileName: search
     * Author: Jason Waid
     * Version: 1.00
     * Date Modified: 12/07/2020
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     */
    function search($interaction_id, $company_id, $customer_id, $employee_id, $reason, $comments, $date_created, $status, $follow_up_type, $follow_up_date)
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
        
        if ($status != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "" && $reason == "" && $comments == "" && $date_created == "") {
                $query .= " WHERE status LIKE ?";
            } else {
                $query .= " AND status LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $status = htmlspecialchars(strip_tags($status));
            $status .= "%";
            array_push($params, $status);
        }
        
        if ($follow_up_type != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "" && $reason == "" && $comments == "" && $date_created == "" && $status == "") {
                $query .= " WHERE follow_up_type LIKE ?";
            } else {
                $query .= " AND follow_up_type LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $follow_up_type = htmlspecialchars(strip_tags($follow_up_type));
            $follow_up_type .= "%";
            array_push($params, $follow_up_type);
        }
        
        if ($follow_up_date != "") {
            if ($interaction_id == "" && $company_id == "" && $customer_id == "" && $employee_id == "" && $reason == "" && $comments == "" && $date_created == "" && $status == ""  && $follow_up_type == "") {
                $query .= " WHERE follow_up_date LIKE ?";
            } else {
                $query .= " AND follow_up_date LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $follow_up_date = htmlspecialchars(strip_tags($follow_up_date));
            array_push($params, $follow_up_date);
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
           
            case 8:
                
                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7]);
                break;
                
            case 9:
                
                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7], $params[8]);
                break;
                
            case 10:
                
                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7], $params[8], $params[9]);
                break;
           /*  default: */
                //no params
                
        }
        
        // execute query
        $stmt->execute();

        
        // bind the results
        $stmt->bind_result($this->interaction_id, $this->company_id, $this->customer_id, $this->created_by, $this->reason, $this->comments, $this->date_created, $this->status, $this->follow_up_type, $this->follow_up_date);
        // return objects
        return $stmt;
    }

}
?>