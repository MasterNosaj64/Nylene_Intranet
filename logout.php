<?php
session_start();

// unset($_SESSION["id"]);
// unset($_SESSION["name"]);
session_destroy();
echo "<meta http-equiv = \"refresh\" content = \"0; url = ./login.php\" />;";
exit();		
?>