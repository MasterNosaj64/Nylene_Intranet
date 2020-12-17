<?php
/*
 * FileName: Homepage.php
 * Version Number: 1.0
 * Date Modified: 12/05/2020
 * Author: Ahmad Syed
 * Purpose:
 * Generic Homepage
 */
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../NavPanel/navigation.php';
echo "<a href='../Database/jasonTestFile.php'>Jason's PDF Testing</a>";
echo " || ";
echo "<a href='../Database/UnitTesting.php'>Jason's Unit Testing</a>";
include '../Calendar/calendar.php';
?>

