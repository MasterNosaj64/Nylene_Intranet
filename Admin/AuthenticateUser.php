<?php
/*
 * FileName: AuthenticateUser.php
 * Version Number: 2.0
 * Date Modified: 12/07/2020
 * Author: Madhav Sachdeva
 * Purpose:
 * Validates the login attempt and updates the number of attempt in the database if failed
 */
if (! session_id()) {
    session_start();
}
include '../Database/connect.php';
$conn = getDBConnection();
$userQuery = "SELECT * FROM nylene.employee WHERE username = '" . $_POST['username'] . "'";
$result = $conn->query($userQuery);
$row = mysqli_fetch_array($result);
$msg = "";
$username = "";
$num_tries = "";
/*
 * }
 */

if ($row == 0) {
    ?>
<meta http-equiv="refresh" content="0; url = ../login.php" />
<?php

    exit();
}

if ($row > 0) {
    if (strcmp($row['STATUS'], "blocked") == 0) {
        $msg = "User is blocked...";
        $_SESSION['field'] = $msg;
        ?>
<meta http-equiv="refresh" content="0; url = ../login.php" />
<?php
        exit();
    } else {
        $username = $row['username'];
        if (strcmp($row['STATUS'], "0") == 0) {
            $num_tries = "1";
            $msg = "Failed login . Two tries left.";
        } else if (strcmp($row['STATUS'], "1") == 0) {
            $num_tries = "2";
            $msg = "Failed login. One try left.";
        } else if (strcmp($row['STATUS'], "2") == 0) {
            $num_tries = "blocked";
            $msg = "User is blocked...";
        } else {
            $num_tries = "0";
            $qy = $conn->prepare("UPDATE employee SET STATUS=? WHERE username=?");
            $qy->bind_param("ss", $num_tries, $username);
            // array_push($qry,qy->execute());
            $qy->execute();
            $qy->close();
        }

        $password1 = $_POST['password'];
        $password2 = $row['password'];

        if (password_verify($password1, $password2)) {
            $_SESSION['name'] = $row['first_name'] . " " . $row['last_name'];
            $_SESSION['role'] = $row['title'];
            $_SESSION['reports_to'] = $row['reports_to'];
            $_SESSION['userid'] = $row['employee_id'];
            $num_tries = "0";
            $qy = $conn->prepare("UPDATE employee SET STATUS=? WHERE username=?");
            $qy->bind_param("ss", $num_tries, $username);
            $qy->execute();
            $qy->close();
            ?>

<meta http-equiv="refresh" content="0; url = ../Home/Homepage.php" />
<?php
            exit();
        } // Added this if so we can still use our admin accounts that were originally created
        else if (! strcmp($password1, $password2)) {
            $_SESSION['name'] = $row['first_name'] . " " . $row['last_name'];
            $_SESSION['role'] = $row['title'];
            $_SESSION['userid'] = $row['employee_id'];
            $_SESSION['reports_to'] = $row['reports_to'];

            $num_tries = "0";
            $qy = $conn->prepare("UPDATE employee SET STATUS=? WHERE username=?");
            $qy->bind_param("ss", $num_tries, $username);
            $qy->execute();
            $qy->close();

            ?>
<meta http-equiv="refresh" content="0; url = ../Home/Homepage.php" />
<?php
            exit();
        } else {
            $qy = $conn->prepare("UPDATE employee SET STATUS=? WHERE username=?");
            $qy->bind_param("ss", $num_tries, $username);
            $qy->execute();
            $qy->close();
            $_SESSION['field'] = $msg;
            ?>
<meta http-equiv="refresh" content="0; url = ../login.php" />
<?php
            exit();
        }
    }
}

?>
