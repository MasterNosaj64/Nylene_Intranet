<?php
/*
 * FileName: login.php
 * Version Number: 2.0
 * Date Modified: 12/07/2020
 * Author: Madhav Sachdeva (Modified By Jason Waid)
 * Purpose:
 * The login interface for the Nylene Intranet
 */
if (! session_id()) {
    session_start();
}
include 'Database/connect.php';
$msg = "";
if (isset($_SESSION['field'])) {
    $msg = $_SESSION['field'];
}
?>
<html>
<head>
<link rel="stylesheet" href="CSS/login.css">
<link rel="icon" href="favicon.png">
<title>Login</title>
</head>
<div class="background">
	<div class="login">
		<h1>Nylene Web App</h1>
		<form method="post" action="Admin/AuthenticateUser.php"
			name="verifyUser" autocomplete="off">
			<p>
				<input type="text" name="username" required placeholder="Username">
			</p>
			<p>
				<input type="password" name="password" required
					placeholder="Password">
			</p>
			<p class="submit">
				<input type="submit" name="commit" value="Login">
			</p>
    <?php echo $msg ?>	

  </form>
	</div>
</div>
</html>