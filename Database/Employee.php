<?php

/*
 * FileName: Employee.php
 * Author: Jason Waid (later modified by Madhav Sachdeva)
 * Version: 1.0
 * Date Modified: 12/07/2020
 * Purpose:
 * Object oriented representation of a Employee
 * all database manipulation happens here
 *
 *
 */
class Employee
{

    // database connection and table name
    private $conn;

    private $table_name = "employee";

    // object properties
    public $employee_id;

    public $first_name;

    public $last_name;

    public $title;

    public $department;

    public $work_phone;

    public $reports_to;

    public $date_entered;

    public $date_modified;

    public $modified_by;

    public $username;

    public $STATUS;

    public $employee_email;

    public $password;

    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    /*
     * Function Name: getId
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the id
     */
    function getId()
    {
        return $this->employee_id;
    }

    /*
     * Function Name: getFirst_Name
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the first name
     */
    function getFirst_Name()
    {
        return $this->first_name;
    }

    /*
     * Function Name: getLast_Name
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the last name
     */
    function getLast_Name()
    {
        return $this->last_name;
    }

    /*
     * Function Name: getName
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the full name
     */
    function getName()
    {
        return $this->first_name . " " . $this->last_name;
    }

    /*
     * Function Name: getTitle
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the title
     */
    function getTitle()
    {
        return $this->title;
    }

    /*
     * Function Name: getDepartment
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the department
     */
    function getDepartment()
    {
        return $this->department;
    }

    /*
     * Function Name: getWork_Phone
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the Work_Phone
     */
    function getWork_Phone()
    {
        return $this->work_phone;
    }

    /*
     * Function Name: getReports_To
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the reports_to
     */
    function getReports_To()
    {
        return $this->reports_to;
    }

    /*
     * Function Name: getDate_Entered
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the date_entered
     */
    function getDate_Entered()
    {
        return $this->date_entered;
    }

    /*
     * Function Name: getDate_Modified
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the date_modified
     */
    function getDate_Modified()
    {
        return $this->date_modified;
    }

    /*
     * Function Name: getModified_By
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the modified_by
     */
    function getModified_By()
    {
        return $this->modified_by;
    }

    /*
     * Function Name: getUsername
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the username
     */
    function getUsername()
    {
        return $this->username;
    }

    /*
     * Function Name: getSTATUS
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the STATUS
     */
    function getSTATUS()
    {
        return $this->STATUS;
    }

    /*
     * Function Name: getEmployee_Email
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the employee_email
     */
    function getEmployee_Email()
    {
        return $this->employee_email;
    }

    /*
     * Function Name: getPassword
     * Version: 1.0
     * Date Modified: 11/22/2020
     * Author: Jason Waid
     * Purpose: Function returns the password
     */
    function getPassword()
    {

        //return $this->password;
        return "";
    }

    /*
     * Function: read
     * Purpose:
     * grabs all Employees from the connected db
     * returns the objects
     */
    public function read()
    {
        $query = "SELECT * FROM nylene.employee";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->employee_id, $this->first_name, $this->last_name, $this->title, $this->department, $this->work_phone, $this->reports_to, $this->date_entered, $this->date_modified, $this->modified_by, $this->username, $this->STATUS, $this->employee_email, $this->password);

        return $stmt;
    }

    /*
     * Function Name: create
     * Version: 1.0
     * Date Modified: 12/17/2020
     * Author: Jason Waid (later modified by Madhav Sachdeva)
     * Function: creates a employee with the supplied parameters
     * Return: bool on failure or success
     */
    function create($first_name, $last_name, $title, $department, $work_phone, $reports_to, $modified_by, $username, $STATUS, $employee_email, $password)
    {
        $query = "INSERT INTO
                nylene.employee (first_name,
				last_name,
				title,
				department, 
				work_phone,
				reports_to,
				date_entered,
				modified_by,
				username, 
				STATUS,
				employee_email,
				password)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        
        $stmt = $this->conn->prepare($query);
        
        $first_name = htmlspecialchars(strip_tags($first_name));
        $last_name = htmlspecialchars(strip_tags($last_name));
        $title = htmlspecialchars(strip_tags($title));
        $department = htmlspecialchars(strip_tags($department));
        $work_phone = htmlspecialchars(strip_tags($work_phone));
        $reports_to = htmlspecialchars(strip_tags($reports_to));
        $date_created = date("Y-m-d", time());
        $modified_by = htmlspecialchars(strip_tags($modified_by));
        $username = htmlspecialchars(strip_tags($username));
        $STATUS = htmlspecialchars(strip_tags($STATUS));
        $employee_email = htmlspecialchars(strip_tags($employee_email));
        $password = password_hash($password,PASSWORD_BCRYPT);
        
        $stmt->bind_param("sssssisissss", $first_name, $last_name, $title, $department, $work_phone, $reports_to, $date_created, $modified_by, $username, $STATUS, $employee_email, $password);
        
        if (!$stmt->execute()) {
            return false;
        }else{
			return true;
		}
    }
    
    
    /*
     * Function Name: searchById
     * Version: 1.0
     * Date Modified: 12/07/2020
     * Author: Jason Waid
     * Purpose: Function searches for an employee obj by id
     */
    function searchById($employee_id)
    {
        $query = "SELECT
                *
            FROM
			  nylene.employee WHERE employee_id = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $employee_id = htmlspecialchars(strip_tags($employee_id));

        $stmt->bind_param("i", $employee_id);

        // execute query
        $stmt->execute();

        // bind the results
        $stmt->bind_result($this->employee_id, $this->first_name, $this->last_name, $this->title, $this->department, $this->work_phone, $this->reports_to, $this->date_entered, $this->date_modified, $this->modified_by, $this->username, $this->STATUS, $this->employee_email, $this->password);

        $stmt->fetch();
        $stmt->close();
        // return objects
        return $this;
    }


    /*
     * Function Name: search
     * Purpose: Function dynamically creates a select query depending on the parameters used and returns found objects
     *
     */
    function search($employee_id, $first_name, $last_name, $title, $department, $work_phone, $reports_to, $modified_by, $username, $STATUS, $employee_email)
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

        $query = "SELECT * FROM nylene.employee";

        if ($employee_id != "") {
            $query .= "  WHERE employee_id LIKE ? ";
            $intCount ++;
            $paramTypes .= "i";
            $employee_id = htmlspecialchars(strip_tags($employee_id));
            /* $employee_id .= "%"; */
            array_push($params, $employee_id);
        }

        if ($first_name != "") {
            if ($employee_id == "") {
                $query .= "  WHERE first_name LIKE ?";
            } else {
                $query .= " AND first_name LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $first_name = htmlspecialchars(strip_tags($first_name));
            $first_name .= "%";
            array_push($params, $first_name);
        }

        if ($last_name != "") {
            if ($employee_id == "" && $first_name == "") {
                $query .= "  WHERE last_name LIKE ?";
            } else {
                $query .= " AND last_name LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $last_name = htmlspecialchars(strip_tags($last_name));
            $last_name .= "%";
            array_push($params, $last_name);
        }

        if ($title != "") {

            if ($employee_id == "" && $first_name == "" && $last_name == "") {
                $query .= "  WHERE title LIKE ?";
            } else {
                $query .= " AND title LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $title = htmlspecialchars(strip_tags($title));
            $title .= "%";
            array_push($params, $title);
        }

        if ($department != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "") {
                $query .= "  WHERE department LIKE ?";
            } else {
                $query .= " AND department LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $department = htmlspecialchars(strip_tags($department));
            $department .= "%";
            array_push($params, $department);
        }

        if ($work_phone != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "") {
                $query .= "  WHERE work_phone LIKE ?";
            } else {
                $query .= " AND work_phone LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $work_phone = htmlspecialchars(strip_tags($work_phone));
            $work_phone .= "%";
            array_push($params, $work_phone);
        }

        if ($reports_to != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "" && $work_phone == "") {
                $query .= "  WHERE reports_to LIKE ?";
            } else {
                $query .= " AND reports_to LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $reports_to = htmlspecialchars(strip_tags($reports_to));
            array_push($params, $reports_to);
        }

        if ($modified_by != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "" && $work_phone == "" && $reports_to == "") {
                $query .= "  WHERE modified_by LIKE ?";
            } else {
                $query .= " AND modified_by LIKE ?";
            }
            $intCount ++;
            $paramTypes .= "i";
            $modified_by = htmlspecialchars(strip_tags($modified_by));
            array_push($params, $modified_by);
        }

        if ($username != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "" && $work_phone == "" && $reports_to == "" && $modified_by == "") {
                $query .= "  WHERE username LIKE ?";
            } else {
                $query .= " AND username LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $username = htmlspecialchars(strip_tags($username));
            array_push($params, $username);
        }

        if ($STATUS != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "" && $work_phone == "" && $reports_to == "" && $modified_by == "" && $username == "") {
                $query .= "  WHERE STATUS LIKE ?";
            } else {
                $query .= " AND STATUS LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $STATUS = htmlspecialchars(strip_tags($STATUS));
            array_push($params, $STATUS);
        }

        if ($employee_email != "") {
            if ($employee_id == "" && $first_name == "" && $last_name == "" && $title == "" && $department == "" && $work_phone == "" && $reports_to == "" && $modified_by == "" && $username == "" && $STATUS == "") {
                $query .= "  WHERE employee_email LIKE ?";
            } else {
                $query .= " AND employee_email LIKE ?";
            }
            $stringCount ++;
            $paramTypes .= "s";
            $employee_email = htmlspecialchars(strip_tags($employee_email));
            array_push($params, $employee_email);
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
            case 11:

                $stmt->bind_param($paramTypes, $params[0], $params[1], $params[2], $params[3], $params[4], $params[5], $params[6], $params[7], $params[8], $params[9], $params[10]);
                break;

            /* default: */
            // no params
        }

        // execute query
        $stmt->execute();
        // bind the results
        $stmt->bind_result($this->employee_id, $this->first_name, $this->last_name, $this->title, $this->department, $this->work_phone, $this->reports_to, $this->date_entered, $this->date_modified, $this->modified_by, $this->username, $this->STATUS, $this->employee_email, $this->password);

        // return objects
        return $stmt;
    }

}
?>
