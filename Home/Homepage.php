<?php 
session_start();

unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../NavPanel/navigation.php';
echo "<a href='../Database/testFile.php'>testfile</a>";
include '../Calendar/calendar.php';
?>

<html>
<body>

	<!--link rel="stylesheet" href="../CSS/login.css">  -->	


</body>
</html>
