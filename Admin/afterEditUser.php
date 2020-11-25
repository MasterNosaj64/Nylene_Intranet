<?php
 if (!session_id()) {
session_start();
include '../Database/databaseConnection.php';
include '../Database/connect.php';

} 



			//$qry=array();
try{
			
			$field=$_SESSION['field'];



			if(trim($_POST['first_name'])!=""){
						

				$first_name=$_POST['first_name'];
				$qy=$conn->prepare("UPDATE employee SET first_name=? WHERE employee_id=?");
				$qy->bind_param("ss" , $first_name, $field);
			//array_push($qry,qy);
				$qy->execute();
				$qy->close();
			}
			//print_r($qry);



			if(trim($_POST['last_name'])!=""){

				$last_name=$_POST['last_name'];
				//array_push($qry,"UPDATE employee SET last_name='$last_name' WHERE employee_id='$field'");
				$qy=$conn->prepare("UPDATE employee SET last_name=? WHERE employee_id=?");
				$qy->bind_param("ss" , $last_name, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}

			if(trim($_POST['title'])!=""){

				$title=$_POST['title'];
				//array_push($qry,"UPDATE employee SET title='$title' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET title=? WHERE employee_id=?");
				$qy->bind_param("ss" , title, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}


			if(trim($_POST['department'])!=""){

				$department=$_POST['department'];
				//array_push($qry,"UPDATE employee SET department='$department' WHERE employee_id='$field'");
$qy=$conn->prepare("UPDATE employee SET department=? WHERE employee_id=?");
				$qy->bind_param("ss" , department, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}

			if(trim($_POST['work_phone'])!=""){

				$work_phone=$_POST['work_phone'];
					//			array_push($qry,"UPDATE employee SET work_phone='$work_phone' WHERE employee_id='$field'");
				//array_push($qry,"INSERT INTO employee(work_phone) VALUE ('".$work_phone."') WHERE employee_id=".$_SESSION['field']);
			$qy=$conn->prepare("UPDATE employee SET work_phone=? WHERE employee_id=?");
				$qy->bind_param("ss" , $work_phone, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}

			if(trim($_POST['reports_to'])!=""){

				$reports_to=$_POST['reports_to'];
				//array_push($qry,"UPDATE employee SET reports_to='$reports_to' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET reports_to=? WHERE employee_id=?");
				$qy->bind_param("ss" , $reports_to, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}

			


			$date_modified=date("Y/m/d");
				//array_push($qry,"UPDATE employee SET date_modified='$date_modified' WHERE employee_id='$field'");
$qy=$conn->prepare("UPDATE employee SET date_modified=? WHERE employee_id=?");
				$qy->bind_param("ss" , $date_modified, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();


			$modified_by=$_SESSION['userid'];
				//array_push($qry,"UPDATE employee SET modified_by='$modified_by' WHERE employee_id='$field'");
$qy=$conn->prepare("UPDATE employee SET modified_by=? WHERE employee_id=?");
				$qy->bind_param("ss" , $modified_by, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();

			if(trim($_POST['username'])!=""){

				$username=$_POST['username'];
				//array_push($qry,"UPDATE employee SET username='$username' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET username=? WHERE employee_id=?");
				$qy->bind_param("ss" , $username, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}

			

			if(trim($_POST['STATUS'])!=""){

				$STATUS=$_POST['STATUS'];
				//array_push($qry,"UPDATE employee SET STATUS='$STATUS' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET STATUS=? WHERE employee_id=?");
				$qy->bind_param("ss" , $STATUS, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}



			if(trim($_POST['password'])!=""){

				$password=$_POST['password'];
				$password=password_hash($password,PASSWORD_DEFAULT);
				//array_push($qry,"UPDATE employee SET password='$password' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET password=? WHERE employee_id=?");
				$qy->bind_param("ss" , $password, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}


			if(trim($_POST['employee_email'])!=""){

				$employee_email=$_POST['employee_email'];
				//array_push($qry,"UPDATE employee SET employee_email='$employee_email' WHERE employee_id='$field'");
			$qy=$conn->prepare("UPDATE employee SET employee_email=? WHERE employee_id=?");
				$qy->bind_param("ss" , $employee_email, $field);
			//array_push($qry,qy->execute());
				$qy->execute();
				$qy->close();
				}
				
}catch(PDOException $e) {
  echo "Error: " . $e->getMessage();
}
			
									header('Location: ../Home/Homepage.php');


			/*$DB_HOST = "localhost";
			$DB_USER = "root";
			$DB_PASSWORD = "";
			$DB_DATABASE = "nylene";
			$connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
			$db=mysqli_select_db($conn,"nylene");

					$check1=0;

			foreach($qry as $sql){

				$query = mysqli_query($conn,$sql);
			
				if (!$query) {
					echo (mysqli_error($conn)) ;
					$check1=1;
				}
				else{
						$check1=2;
			}
		
				if($check1==2){
					header('Location: ../Home/Homepage.php');

				}
				
			
			}
			unset($sql);
*/

//if($check1==2){
	//				header('Location: ../Home/Homepage.php');

		//		}

?>		
