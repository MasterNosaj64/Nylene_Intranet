<?php
if($_SESSION['userid'] == ""){
    echo "No user logged in";
    echo "<meta http-equiv = \"refresh\" content = \"5; url = ./login.php\" />;";
 exit();
   
}
/* if (!session_id()) {
session_start();

} */

?>

<html>
<div>
<head>
<link rel="stylesheet" href="nav.css">

<div class="navigation">

<!-- 	<a href="homepage.php">Nylene</a> -->

  <a href="homepage.php"><span title="Home"><img  width="180" align="middle" heigth="auto" src="Nylene-alt.png"></span></a>
  
<!--  <a href="sample.php">Sample</a> -->

 <?php //$image_url='Nylene.png'; ?>

<!--   <a href="#employee">Employee</a> -->

<?php
if($_SESSION['role'] == "admin"){

    echo "<div class=\"dropdown\">";
    echo "<button class=\"dropbtn\">Admin Panel";
    echo "</button>";
    echo "<div class=\"dropdown-content\">";
	echo "<a href=\"createUser.php\">Create User</a>";
	echo "</div>";
	echo "</div>";
}
?>


  <div class="dropdown">
    <button class="dropbtn">Company Directory
    </button>
    <div class="dropdown-content">
      <a href="./searchCompany.php">Search Company</a>
      <a href="./addCompany.php">Add Company</a>



    </div>
  </div>

<?php 
if(isset($_SESSION['company_id'])){
if($_SESSION['company_id'] != ""){
    echo "<div class=\"dropdown\">";
    echo "<a class=\"dropbtn\" href=\"viewCompany.php\">View Company</a>";
    echo "</div>";
}
}
if(isset($_SESSION['interaction_id']) || isset($_POST['interaction_id']) || isset($_SESSION['navToAddInteractionPage'])){
//if($_SESSION['interaction_id'] != ""){
    unset($_SESSION['navToAddInteractionPage']);
    echo "<div class=\"dropdown\">";
    echo "<a class=\"dropbtn\" href=\"companyHistory.php\">Company History</a>";
    echo "</div>";
//}
}
?>



<!--   <div class="dropdown"> -->
<!--     <button class="dropbtn">Clients -->
<!--     </button> -->
<!--     <div class="dropdown-content"> -->
<!--       <a href="#">Search Client</a> -->
<!--       <a href="#">Add Client</a> -->
<!--     </div> -->
<!--   </div> -->

<!--   <a href="InteractionManager.php">interaction Manager</a> -->


  <div class="dropdown-user">

    <button class="dropbtn"><img src="userIcon.png" width="20" heigth="auto" align="middle"> <?php echo $_SESSION['name'];?>
    </button>
    <div class="dropdown-content">
      <a href="./logout.php">Log Out</a>
      <!--  -->

    </div>
  </div>


</div>

</div>
</html>
