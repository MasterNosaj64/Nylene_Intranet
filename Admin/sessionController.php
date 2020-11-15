<?php

/*
 * FileName: sessionController.php
 * Version Number: 0.75
 * Author: Jason Waid
 * Purpose:
 * Controls sensitive session variables used to track navigation of the website
 * Assists with clearing the buffer when neccisary
 * Date Modified: 11/02/2020
 */

/*
 * Function name: checkRefresh
 * Purpose: checks if user refreshed page
 * return: boolean
 */
/*
 * function refresh()
 * {
 * $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
 * return $pageWasRefreshed;
 * }
 */
/*
 * Unsets company_id session var if the var isn't needed for said page
 * This to to avoid breaking the logic on some pages, which if a session var is set prematurly unexpected
 * results will occur
 */
if (! strcmp(basename($_SERVER['PHP_SELF']), "Homepage.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "logout.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "createUser.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "editUserDatabase.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "searchCompany.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "addCompany.php")) {
    unset($_SESSION['company_id']);
    unset($_SESSION['interaction_id']);
}
if (! strcmp(basename($_SERVER['PHP_SELF']), "companyHistory.php")) {
    unset($_SESSION['interaction_id']);
}

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