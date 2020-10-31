<?php

// Redirect the user to the login page if no user is logged in
if (! isset($_SESSION['userid'])) {
    echo "No user logged in, redirecting to login page";
    echo "<meta http-equiv = \"refresh\" content = \"5; url = ../login.php\" />";
    exit();
}

// Company Buffer Controller
// If the user navigates to a different page after visiting the searchCompany page the buffer will be destroyed
if (isset($_SESSION['searchCompanyVisited'])) {
    if (basename($_SERVER['PHP_SELF']) != $_SESSION['searchCompanyVisited']) {
        unset($_SESSION['searchCompanyVisited']);
        unset($_SESSION['buffer']);
    }
}

// Customer Buffer Controller
// If the user navigates to a different page after visiting the viewCompany page the buffer will be destroyed
if (isset($_SESSION['viewCompanyVisited'])) {
    if (basename($_SERVER['PHP_SELF']) != $_SESSION['viewCompanyVisited']) {
        unset($_SESSION['viewCompanyVisited']);
        unset($_SESSION['buffer']);
    }
}

// Interaction Buffer Controller
// If the user navigates to a different page after visiting the companyHistory page the buffer will be destroyed
if (isset($_SESSION['companyHistoryVisited'])) {
    if (basename($_SERVER['PHP_SELF']) != $_SESSION['companyHistoryVisited']) {
        unset($_SESSION['companyHistoryVisited']);
        unset($_SESSION['buffer']);
    }
}
?>