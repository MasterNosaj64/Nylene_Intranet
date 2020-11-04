<?php session_start(); 
session_destroy();?>
<html>
<head>
<link rel="stylesheet" href="CSS/login.css">
</head>
<div class="background">
<div class="login">
  <h1>Nylene Web App</h1>
  <form method="post" action="Admin/AuthenticateUser.php" name="verifyUser">
    <p><input type="text" name="username" required placeholder="Username"></p>
    <p><input type="password" name="password" required placeholder="Password"></p>
    <p class="submit"><input type="submit" name="commit" value="Login"></p>
  </form>  
</div>
</div>
</html>