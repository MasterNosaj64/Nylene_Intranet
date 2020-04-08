<?php
session_start();
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

  <a href="homepage.php">Nylene</a>

 <?php //$image_url='Nylene.png'; ?>

<!--   <a href="#employee">Employee</a> -->

  <div class="dropdown">
    <button class="dropbtn">Navigation
    </button>
    <div class="dropdown-content">
      <a href="./searchCompany.php">Search Company</a>
      <a href="./addCompany.php">Add Company</a>
    </div>
  </div>


<!--   <div class="dropdown"> -->
<!--     <button class="dropbtn">Clients -->
<!--     </button> -->
<!--     <div class="dropdown-content"> -->
<!--       <a href="#">Search Client</a> -->
<!--       <a href="#">Add Client</a> -->
<!--     </div> -->
<!--   </div> -->

<!--   <a href="InteractionManager.php">interaction Manager</a> -->


  <div class="dropdown">

    <button class="dropbtn"> Hello <?php echo $_SESSION['name']?>
    </button>
    <div class="dropdown-content">
      <a href="./logout.php">Log Out</a>
      <!--  -->

    </div>
  </div>


</div>

</div>
</html>
