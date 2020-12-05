<?php
/*
 * Name: afterEditUser.php
 * Author: Madhav Sachdeva (Modified by: Isha Isha)
 * Last Modified: November 29th, 2020
 * Purpose: Saves the edited information in the database
 */
if (! session_id()) {
    session_start();
    include '../Database/connect.php';
}
$conn=getDBConnection();
try {
    $field = $_SESSION['field'];
    if (trim($_POST['first_name']) != "") {
        $first_name = $_POST['first_name'];
        $qy = $conn->prepare("UPDATE employee SET first_name=? WHERE employee_id=?");
        $qy->bind_param("ss", $first_name, $field);
        $qy->execute();
        $qy->close();
    }
    if (trim($_POST['last_name']) != "") {
        $last_name = $_POST['last_name'];
        $qy = $conn->prepare("UPDATE employee SET last_name=? WHERE employee_id=?");
        $qy->bind_param("ss", $last_name, $field);
        $qy->execute();
        $qy->close();
    }
    if (trim($_POST['title']) != "") {
        $title = $_POST['title'];
        $qy = $conn->prepare("UPDATE employee SET title=? WHERE employee_id=?");
        $qy->bind_param("ss", $title, $field);
        $qy->execute();
        $qy->close();
    }
    if (trim($_POST['department']) != "") {
        $department = $_POST['department'];
        $qy = $conn->prepare("UPDATE employee SET department=? WHERE employee_id=?");
        $qy->bind_param("ss", $department, $field);
        $qy->execute();
        $qy->close();
    }
    if (trim($_POST['work_phone']) != "") {
        $work_phone = $_POST['work_phone'];
        $qy = $conn->prepare("UPDATE employee SET work_phone=? WHERE employee_id=?");
        $qy->bind_param("ss", $work_phone, $field);
        // array_push($qry,qy->execute());
        $qy->execute();
        $qy->close();
    }
    if (trim($_POST['reports_to']) != "") {
        $reports_to = $_POST['reports_to'];
        $qy = $conn->prepare("UPDATE employee SET reports_to=? WHERE employee_id=?");
        $qy->bind_param("ss", $reports_to, $field);
        $qy->execute();
        $qy->close();
    }
    
	$date_modified = date("Y/m/d");//hidden
    $qy = $conn->prepare("UPDATE employee SET date_modified=? WHERE employee_id=?");
    $qy->bind_param("ss", $date_modified, $field);
    $qy->execute();
    $qy->close();
	
    $modified_by = $_SESSION['userid'];//hidden from user
    $qy = $conn->prepare("UPDATE employee SET modified_by=? WHERE employee_id=?");
    $qy->bind_param("ss", $modified_by, $field);
    $qy->execute();
    $qy->close();

    if (trim($_POST['username']) != "") {
        $username = $_POST['username'];
        $qy = $conn->prepare("UPDATE employee SET username=? WHERE employee_id=?");
        $qy->bind_param("ss", $username, $field);
        $qy->execute();
        $qy->close();
    }

    if (trim($_POST['STATUS']) != "") {
        $STATUS = $_POST['STATUS'];
        $qy = $conn->prepare("UPDATE employee SET STATUS=? WHERE employee_id=?");
        $qy->bind_param("ss", $STATUS, $field);
        $qy->execute();
        $qy->close();
    }

    if (trim($_POST['password']) != "") {
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $qy = $conn->prepare("UPDATE employee SET password=? WHERE employee_id=?");
        $qy->bind_param("ss", $password, $field);
        $qy->execute();
        $qy->close();
    }

    if (trim($_POST['employee_email']) != "") {
        $employee_email = $_POST['employee_email'];
        $qy = $conn->prepare("UPDATE employee SET employee_email=? WHERE employee_id=?");
        $qy->bind_param("ss", $employee_email, $field);
        $qy->execute();
        $qy->close();
    }
	
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
header('Location: ../Home/Homepage.php');//once everything is done go to homepage
?>		
