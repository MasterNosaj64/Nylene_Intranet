



<?php 


/*
 * FileName: EmployeeTest.php
 * Author: Madhav Sachdeva
 * Version: 1.0
 * Date Modified: 12/07/2020
 * Purpose:
 * Object oriented unit testing of a Employee.php
 * 
 *
 *
 */
require 'connect.php';
require 'Employee.php';






/*
 * ClassName: EmployeeTest.php
 * Author: Madhav Sachdeva
 * Version: 1.0
 * Date Modified: 12/07/2020
 * Extends: \PHPUnit\Framework\TestCase
 * Purpose:
 * Object oriented unit testing of a Employee.php
 * 
 *
 *
 */
class EmployeeTest extends \PHPUnit\Framework\TestCase
{
	// database connection and employee object name
	private $employee; 
	private $conn;
	
	
	
	 /*
     * Function Name: setUp
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: Sets up the database connection and creates an object of employee( method generally used in unit testing as a set up constructor)
     */
    protected function setUp():void 
    {
		$this->conn = getDBConnection();
		$this->employee = new Employee($this->conn);
    }
 
	/*
     * Function Name: tearDown
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: Nullify the employee object created( method generally used in unit testing as a destructor)
     */
    protected function tearDown():void
    {
        $this->employee = NULL;
    }
	
	
	/*
     * Function Name: testRead
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: tests the read() method of class Employee 
	 *			[Reads full employee table with manual select statement and through read() method 
	 *			and then compare both results to pass/fail] 
	 * 
     */
	public function testRead(){
		$sql = "SELECT * FROM employee"; //array to test with
		$query = mysqli_query($this->conn,$sql);
		$myArray =[[]];
		$i=0;
		$rows=mysqli_num_rows($query);
		if($query  = mysqli_query($this->conn, $sql)){
		   if( $rows > 0){ 
				while($row = mysqli_fetch_array($query)){//getting values for each row of the employee table
					
					$myArray[$i][0]=$row['employee_id'];
					$myArray[$i][1]=$row['first_name'];
					$myArray[$i][2]=$row['last_name'];
					$myArray[$i][3]=$row['title'];
					$myArray[$i][4]=$row['department'];
					$myArray[$i][5]=$row['work_phone'];
					$myArray[$i][6]=$row['reports_to'];
					$myArray[$i][7]=$row['date_entered'];
					$myArray[$i][8]=$row['date_modified'];
					$myArray[$i][9]=$row['modified_by'];
					$myArray[$i][10]=$row['username'];
					$myArray[$i][11]=$row['STATUS'];
					$myArray[$i][12]=$row['employee_email'];
					$myArray[$i][13]=$row['password'];
					$i++;
				}
		   }	
		}
		
		$employeeTest=[[]];
		$employeeListResult = $this->employee->read();
		$i=0;
		while ($employeeListResult->fetch()) {
			$employeeTest[$i][0]=$this->employee->employee_id;
			$employeeTest[$i][1]=$this->employee->first_name;
			$employeeTest[$i][2]=$this->employee->last_name;
			$employeeTest[$i][3]=$this->employee->title;
			$employeeTest[$i][4]=$this->employee->department;
			$employeeTest[$i][5]=$this->employee->work_phone;
			$employeeTest[$i][6]=$this->employee->reports_to;
			$employeeTest[$i][7]=$this->employee->date_entered;
			$employeeTest[$i][8]=$this->employee->date_modified;
			$employeeTest[$i][9]=$this->employee->modified_by;
			$employeeTest[$i][10]=$this->employee->username;
			$employeeTest[$i][11]=$this->employee->STATUS;
			$employeeTest[$i][12]=$this->employee->employee_email;
			$employeeTest[$i][13]=$this->employee->password;
			$i++;
		}
		
		$this->assertEquals($myArray, $employeeTest);
	}




	/*
     * Function Name: testGetId
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: tests the getId() method of class Employee 
	 *			[Reads full employee table's employee_id column with manual select statement and through getId() method 
	 *			and then compare both results to pass/fail] 
	 * 
     */
	public function testGetID(){
		$sql = "SELECT employee_id FROM employee"; //array to test with
		$query = mysqli_query($this->conn,$sql);
		$myArray =[];

		while($row = mysqli_fetch_array($query)){//getting values for each row of the employee table
			$myArray[]=$row['employee_id'];
		}
		
		//array to test
		$employeeIdsTest = array();
		$employeeListResult = $this->employee->read();
		while ($employeeListResult->fetch()) {
			array_push($employeeIdsTest , $this->employee->getId());
		}
		
		$this->assertEquals($myArray, $employeeIdsTest);

	}
	
	/*
     * Function Name: testSearch
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: tests the search() method of class Employee 
	 *			[Search full employee table with manual select statement and through search() method 
	 *			and then compare both results to pass/fail] 
	 * 
     */
	public function testSearch(){
		$sql = "SELECT * FROM employee"; //array to test with
		$query = mysqli_query($this->conn,$sql);
		$myArray =[[]];
		$i=0;
		$rows=mysqli_num_rows($query);
		if($query  = mysqli_query($this->conn, $sql)){
		   if( $rows > 0){ 
				while($row = mysqli_fetch_array($query)){//getting values for each row of the employee table
					
					$myArray[$i][0]=$row['employee_id'];
					$myArray[$i][1]=$row['first_name'];
					$myArray[$i][2]=$row['last_name'];
					$myArray[$i][3]=$row['title'];
					$myArray[$i][4]=$row['department'];
					$myArray[$i][5]=$row['work_phone'];
					$myArray[$i][6]=$row['reports_to'];
					$myArray[$i][7]=$row['date_entered'];
					$myArray[$i][8]=$row['date_modified'];
					$myArray[$i][9]=$row['modified_by'];
					$myArray[$i][10]=$row['username'];
					$myArray[$i][11]=$row['STATUS'];
					$myArray[$i][12]=$row['employee_email'];
					$myArray[$i][13]=$row['password'];
					$i++;
				}
		   }	
		}
		
		$employeeTest=[[]];
		$employeeListResult = $this->employee->search("","","","","","","","","","","","","","");
		$i=0;
		while ($employeeListResult->fetch()) {
			$employeeTest[$i][0]=$this->employee->employee_id;
			$employeeTest[$i][1]=$this->employee->first_name;
			$employeeTest[$i][2]=$this->employee->last_name;
			$employeeTest[$i][3]=$this->employee->title;
			$employeeTest[$i][4]=$this->employee->department;
			$employeeTest[$i][5]=$this->employee->work_phone;
			$employeeTest[$i][6]=$this->employee->reports_to;
			$employeeTest[$i][7]=$this->employee->date_entered;
			$employeeTest[$i][8]=$this->employee->date_modified;
			$employeeTest[$i][9]=$this->employee->modified_by;
			$employeeTest[$i][10]=$this->employee->username;
			$employeeTest[$i][11]=$this->employee->STATUS;
			$employeeTest[$i][12]=$this->employee->employee_email;
			$employeeTest[$i][13]=$this->employee->password;
			$i++;
		}
		
		$this->assertEquals($myArray, $employeeTest);
		
	}
	
	
	/*
     * Function Name: testCreate
     * Version: 1.0
     * Date Modified: 12/18/2020
     * Author: Madhav Sachdeva
     * Purpose: tests the create() method of class Employee 
	 *			[Create a row in employee table with manual insert statement and again same row through create() method 
	 *			and then through search function number of times this row with the particualr values is counted,
	 *			it should be 2 to pass otherwise fail.] 
	 * 
     */
	public function testCreate(){
		
		$query = "INSERT INTO
                nylene.employee (first_name, last_name, title, department, work_phone, reports_to, date_entered, modified_by, username, STATUS, employee_email, password)
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
        
        $stmt = $this->conn->prepare($query);
        $first_name = htmlspecialchars(strip_tags("a"));
        $last_name = htmlspecialchars(strip_tags("b"));
        $title = htmlspecialchars(strip_tags("supervisor"));
        $department = htmlspecialchars(strip_tags("c"));
        $work_phone = htmlspecialchars(strip_tags("1"));
        $reports_to = htmlspecialchars(strip_tags("1"));
        $date_created = date("Y-m-d", time());
        $modified_by = htmlspecialchars(strip_tags("1"));
        $username = htmlspecialchars(strip_tags("d"));
        $STATUS = htmlspecialchars(strip_tags("0"));
        $employee_email = htmlspecialchars(strip_tags("e"));
        $password = password_hash("f",PASSWORD_BCRYPT);
        
        $stmt->bind_param("sssssisissss", $first_name, $last_name, $title, $department, $work_phone, $reports_to, $date_created, $modified_by, $username, $STATUS, $employee_email, $password);
        $stmt->execute();
		
		
		$this->employee->create('a','b','supervisor','c','1','1','1','d','0','e','f');

		$sql = "SELECT * FROM nylene.employee 
		WHERE first_name='a'
		AND last_name='b'
		AND title='supervisor' 
		AND department='c' 
		AND work_phone='1'
		AND reports_to=1 
		AND date_entered='".date("Y-m-d",time())."'
		AND modified_by=1
		AND username='d' 
		AND STATUS='0'
		AND employee_email='e' "; //array to test with
		$query = mysqli_query($this->conn,$sql);
		$rows=mysqli_num_rows($query);
		
		$this->assertIsInt($rows);		
		$this->assertEquals(2,$rows);
		
	}
	
	
}

?>