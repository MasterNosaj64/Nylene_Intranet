<?php
 if (!session_id()) {
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../navigation.php';
include '../Database/databaseConnection.php';
include '../Database/connect.php';
} 
?>

<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">



<link rel="stylesheet" href="../CSS/table.css">
</head>

<body>


<form autocomplete="off" method="post" action="" >
  <tr><h2>Name of the user to be edited</h2>
</tr><tr>
  <div class="autocomplete" style="width:300px;">
 <input name="myInput" id="myInput"   />
 </div>
</tr>
  <input type="submit" name="Submit">
			<input type="reset" name="Reset">
		
</form>
<?php
ob_start();
$sql = "SELECT * FROM employee";
$query = mysqli_query($conn, $sql);
$value=array();
while ($row = mysqli_fetch_array($query)) {
    //echo '<option style="width: 260px" value=' . $row['employee_id'] . '>' . $row['first_name'] . " " . $row['last_name'] . '</option>';
    $value[] =  $row['first_name'] . " " . $row['last_name'];
    //echo $row["first_name"];
}
ob_end_flush();
?>
<script>
function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}

/*An array containing all the country names in the world:*/

var names =<?php echo json_encode($value); ?>;

//var countries =[];
// ?php echo json_encode($value); ?>
//countries.push('		

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), names);
</script>
<?php
$check=0;
if(isset($_POST['myInput'] )){
 $field=trim($_POST['myInput']);
	

   



  
		   
		$sql = "SELECT * FROM employee";
		$query = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($query)) {
			$str=$row['first_name'] . " " . $row['last_name'];
			if(strcmp($field,$str)==0){
				$field=(int)$row['employee_id'];
				$check=1;
			}
		}	


}
if($check==1 && isset($_POST['Submit'] )){
   
	//$field=$_POST['edit_user'];
			$_SESSION['field'] = $field;
//echo("'$field'");
//echo("<script> location.href = '".ADMIN_URL."/index.php?msg=$msg';</script>");

			header('location:editUser.php');

	}
?>
</html>



