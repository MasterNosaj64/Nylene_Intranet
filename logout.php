<?php
/*
 * FileName: logout.php
 * Version Number: 1.0
 * Date Modified: 12/07/2020
 * Author: Madhav Sachdeva
 * Purpose:
 * The logout logic which clears the session
 */

session_start();
session_destroy();
?>
<meta http-equiv = "refresh" content = "0; url = ./login.php" />
<?php
exit();		
?>