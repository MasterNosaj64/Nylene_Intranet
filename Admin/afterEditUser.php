<?php
//session_start();
 if (!session_id()) {
session_start();

} 

//print_r();

?>

<?php

			$qry=array();

			$field=$_SESSION['field'];



			if(trim($_POST['first_name'])!=""){
						

				$first_name=$_POST['first_name'];
				array_push($qry,"UPDATE employee SET first_name='$first_name' WHERE employee_id='$field'");
			}
			print_r($qry);



			if(trim($_POST['last_name'])!=""){

				$last_name=$_POST['last_name'];
				array_push($qry,"UPDATE employee SET last_name='$last_name' WHERE employee_id='$field'");
			}

			if(trim($_POST['title'])!=""){

				$title=$_POST['title'];
				array_push($qry,"UPDATE employee SET title='$title' WHERE employee_id='$field'");
			}


			if(trim($_POST['department'])!=""){

				$department=$_POST['department'];
				array_push($qry,"UPDATE employee SET department='$department' WHERE employee_id='$field'");
			}

			if(trim($_POST['work_phone'])!=""){

				$work_phone=$_POST['work_phone'];
								array_push($qry,"UPDATE employee SET work_phone='$work_phone' WHERE employee_id='$field'");
				array_push($qry,"INSERT INTO employee(work_phone) VALUE ('".$work_phone."') WHERE employee_id=".$_SESSION['field']);
			}

			if(trim($_POST['reports_to'])!=""){

				$reports_to=$_POST['reports_to'];
				array_push($qry,"UPDATE employee SET reports_to='$reports_to' WHERE employee_id='$field'");
			}

			


			$date_modified=date("Y/m/d");
				array_push($qry,"UPDATE employee SET date_modified='$date_modified' WHERE employee_id='$field'");



			$modified_by=$_SESSION['userid'];
				array_push($qry,"UPDATE employee SET modified_by='$modified_by' WHERE employee_id='$field'");


			if(trim($_POST['username'])!=""){

				$username=$_POST['username'];
				array_push($qry,"UPDATE employee SET username='$username' WHERE employee_id='$field'");
			}

			if(trim($_POST['is_administrator'])!=""){

				$is_administrator=$_POST['is_administrator'];
				array_push($qry,"UPDATE employee SET is_administrator='$is_administrator' WHERE employee_id='$field'");
			}

			if(trim($_POST['STATUS'])!=""){

				$STATUS=$_POST['STATUS'];
				array_push($qry,"UPDATE employee SET STATUS='$STATUS' WHERE employee_id='$field'");
			}



			if(trim($_POST['password'])!=""){

				$password=$_POST['password'];
				$password=password_hash($password,PASSWORD_DEFAULT);
				array_push($qry,"UPDATE employee SET password='$password' WHERE employee_id='$field'");
			}


			if(trim($_POST['employee_email'])!=""){

				$employee_email=$_POST['employee_email'];
				array_push($qry,"UPDATE employee SET employee_email='$employee_email' WHERE employee_id='$field'");
			}

			$DB_HOST = "localhost";
			$DB_USER = "root";
			$DB_PASSWORD = "";
			$DB_DATABASE = "nylene";
			$connect = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
			$db=mysqli_select_db($connect,"nylene");

			//echo "  A ";
					$check1=0;

			foreach($qry as $sql){
			//echo "  B ";

				$query = mysqli_query($connect,$sql);
				
				if (!$query) {
					echo (mysqli_error($connect)) ;
					$check1=1;
					//echo "           fail";
				}
			}
		
				if($check!=1){
					header('Location: ../Home/Homepage.php');

				}
				
			
					//	echo "  B ";

			unset($sql);
//}	
//else{
//echo "Not Set";
//}	
?>		