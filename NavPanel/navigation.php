<?php
include '../admin/sessionController.php';
?>

<html>
<head>
<link rel="stylesheet" href="../CSS/nav.css">
<link rel="icon" href="../favicon.png">
</head>

<div class="navigation">
	<a href="../Home/homepage.php"><span title="Home"><img width="180"
			align="middle" height="auto" src="../Graphics/Nylene-alt.png"></span></a>
<?php

if ($_SESSION['role'] == "admin" || $_SESSION['role'] == "supervisor") {

    echo "<div class='dropdown-user'>";
    echo "<button class='dropbtn'>Admin Panel";
    echo "</button>";
    echo "<div class='dropdown-content'>";

    if (strcmp(basename($_SERVER['PHP_SELF']), "createUser.php")) {
        echo "<a href='../Admin/createUser.php'>Create User</a>";
    }
    echo "<a href='../Admin/editUserDatabase.php'>Edit User</a>";
    echo "</div>";
    echo "</div>";
}

?>
  <div class="dropdown-user">
		<button class="dropbtn">Company Directory</button>
		<div class="dropdown-content">
    <?php

    // hides searchCompany button if user is already on the searchCompany.php page
    if (strcmp(basename($_SERVER['PHP_SELF']), "searchCompany.php")) {
        echo "<a href='../Company.Customer/searchCompany.php?sort=1'>Search Company</a>";
    }

    if (strcmp(basename($_SERVER['PHP_SELF']), "addCompany.php")) {
        echo "<a href='../Company.Customer/addCompany.php'>Add Company</a>";
    }
    ?>
		</div>
	</div>

<?php
if (isset($_SESSION['company_id'])) {
    if (strcmp(basename($_SERVER['PHP_SELF']), "viewCompany.php")) {

        echo "<div class='dropdown'>";
        echo "<a class='dropbtn' href='../Company.Customer/viewCompany.php?sort=1'>View Company</a>";
        echo "</div>";
    }
}
if (isset($_SESSION['interaction_id']) || isset($_POST['interaction_id']) || isset($_SESSION['navToAddInteractionPage'])) {
    unset($_SESSION['navToAddInteractionPage']);
    echo "<div class='dropdown'>";
    echo "<a class='dropbtn' href='../Interactions/companyHistory.php?sort=1'>Company History</a>";
    echo "</div>";
}
?>
	<div class="dropdown-user">

		<button class="dropbtn">
			<img src="../Graphics/userIcon.png" width="20" height="auto"
				align="middle"/> <?php echo $_SESSION['name'];?>
    </button>
		<div class="dropdown-content">
			<a href="../Admin/viewProfile.php">View Profile</a> 
			<a href="../logout.php">Log Out</a>
		</div>
	</div>
</div>
</html>
