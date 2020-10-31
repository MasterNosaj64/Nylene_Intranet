<?php

//Redirect the user to the login page if no user is logged in
if(!isset($_SESSION['userid'])){
    echo "No user logged in, redirecting to login page";
    echo "<meta http-equiv = \"refresh\" content = \"5; url = ../login.php\" />";
    exit();
    
}



//If the user navigates to a different page after visiting the searchCompany page the buffer will be destroyed
if (isset($_SESSION['searchCompanyVisited'])) {
    if (basename($_SERVER['PHP_SELF']) != $_SESSION['searchCompanyVisited']) {
    unset($_SESSION['searchCompanyVisited']);
    unset($_SESSION['buffer']);
    }
}

//Customer Buffer Controller


//interaction Buffer Controller

?>