<?php
if (!session_id()) {
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../NavPanel/navigation.php';
include '../Database/databaseConnection.php';
include '../Database/connect.php';
} 
$accessLevel=$_SESSION['role'];
/*$sql = "SELECT * FROM employee";
$query = mysqli_query($conn, $sql);
$value=array();
while ($row = mysqli_fetch_array($query)){
    $value[] =  $row['first_name'] . " " . $row['last_name'];
	}
	
	*/
	

$check=0;
//if(isset($_POST['myInput'] )){
 //$field=trim($_POST['myInput']);
$sql=NULL;	
if($accessLevel=='admin'){
	$sql = "SELECT * FROM employee"; 
}else if($accessLevel=='supervisor'){
		$sql = "SELECT * FROM employee WHERE title='sales_rep' OR title='ind_rep'"; 
}



$query = mysqli_query($conn, $sql);

$myArray =[[]];
$i=0;
$rows=mysqli_num_rows($query);
		if($query  = mysqli_query($conn, $sql)){
		   if( $rows > 0){ 
	//echo "<table border='1' id='myTable'>";
	
            while($row = mysqli_fetch_array($query)){
			
				$myArray[$i][0]=$row['employee_id'];
				$myArray[$i][1]=$row['first_name'];
				$myArray[$i][2]=$row['last_name'];
				$myArray[$i][3]=$row['title'];
				$myArray[$i][4]=$row['department'];
				$myArray[$i][5]=$row['work_phone'];
				
				/*$sqlReportsTo = "SELECT Concat(Ifnull(first_name,' ') ,' ', Ifnull(last_name,' ')) FROM employee WHERE employee_id=$row['reports_to']"; 
				$queryRT = mysqli_query($conn, $sqlReportsTo);	
				$rowRT = mysqli_fetch_array($queryRT)
				*/
				
				$myArray[$i][6]= $row['reports_to'];
				$myArray[$i][7]=$row['employee_email'];
				$i++;
			}
		  
		  
		  /*  <echo "<tr>";
                echo "<td>" . $row['first_name'] . "</td>";
                echo "<td>" . $row['last_name'] . "</td>";
				echo "<td>" . $row['title'] . "</td>";
				echo "<td>" . $row['department'] . "</td>";
				echo "<td>" . $row['work_phone'] . "</td>";
				echo "<td>" . $row['reports_to'] . "</td>";
                echo "<td>" . $row['employee_email'] . "</td>";
				
            echo "</tr>";*/
        }
        //echo "</table>";	
			
			
		
			
		}
 

  
		   
		//echo '<pre>'; print_r($myArray); echo '</pre>';


if($check==1 && isset($_POST['Submit'] )){
  
			$_SESSION['field'] = $field;
			header('location:editUser.php');

}

	
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../CSS/table.css">
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>


<style>
.block {
  display: block;
  width: 100%;
  border: none;
  background-color: #6495ED;
  color: white;
  padding: 14px 28px;
  font-size: 16px;
  cursor: pointer;
  text-align: center;
}

.block.active {
  background-color: #F8F8FF;
  color: black;
}


.block:hover {
  background-color: #ddd;
  color: black;
}
</style>

<!--<form autocomplete="off" method="post" action="../Admin/editUserDatabase.php" >-->
<h1>Search by</h1> 

<input id="myInput" onkeyup="myFunction()" >


<!--
<tr>
<!--<div style="display:inline;">--
<th><button type="button" name="first_name">First Name</button></th>
<th><button type="button" name="last_name">Last Name</button></th>
<th><button type="button" name="title">Title</button></th>
<th><button type="button" name="department">Department</button></th>
<th><button type="button" name="work_phone">Work Phone</button></th>
<th><button type="button" name="reports_to">Reports To</button></th>
<th><button type="button" name="employee_email">Employee Email</button></th>
 <!--</div>->
 </tr>-->
<script type="text/javascript">	
var j=1;
var names = JSON.parse('<?php echo json_encode($myArray)?>');
var rows= "<?php echo $rows ?>";


function generate_table(array) {
    // get the reference for the body
    var body = document.getElementsByTagName("body")[0];

    // creates a <table> element and a <tbody> element
    var tbl = document.createElement("table");
    tbl.setAttribute("id", "myTable");
    var header=  document.createElement('thead')
    var headingRow = document.createElement('tr')

   

var headingCell0 = document.createElement('th')
    var headingText0 = document.createTextNode('Employee ID')
	var button0 = document.createElement("button")
	button0.setAttribute("class", "block")
	button0.setAttribute("id", "empId")
	button0.setAttribute("onclick", "j=0")
	button0.appendChild(headingText0)
    headingCell0.appendChild(button0)
    headingRow.appendChild(headingCell0)


   var headingCell1 = document.createElement('th')
    var headingText1 = document.createTextNode('First Name')
	var button1 = document.createElement("button")
	button1.setAttribute("class", "block active")
	button1.setAttribute("id", "fName")
	button1.setAttribute("onclick", "j=1")
	button1.appendChild(headingText1)
    headingCell1.appendChild(button1)
    headingRow.appendChild(headingCell1)
    
    var headingCell2 = document.createElement('th')
    var headingText2 = document.createTextNode('Last Name')
   	var button2 = document.createElement("button")
	button2.setAttribute("class", "block")
	button2.setAttribute("id", "lName")
	button2.setAttribute("onclick", "j=2")
	button2.appendChild(headingText2) 
	headingCell2.appendChild(button2)
    headingRow.appendChild(headingCell2)
	
	var headingCell3 = document.createElement('th')
    var headingText3 = document.createTextNode('Title')
    var button3 = document.createElement("button")
	button3.setAttribute("class", "block")
	button3.setAttribute("id", "tilte")
	button3.setAttribute("onclick", "j=3")
	button3.appendChild(headingText3)
	headingCell3.appendChild(button3)
    headingRow.appendChild(headingCell3)
	
	var headingCell4 = document.createElement('th')
    var headingText4 = document.createTextNode('Department')
   	var button4 = document.createElement("button")
	button4.setAttribute("class", "block")
	button4.setAttribute("id", "department")
	button4.setAttribute("onclick", "j=4")
	button4.appendChild(headingText4)
	headingCell4.appendChild(button4)
    headingRow.appendChild(headingCell4)
	
	
	var headingCell5 = document.createElement('th')
    var headingText5 = document.createTextNode('Work Phone')
    var button5 = document.createElement("button")
	button5.setAttribute("class", "block")
	button5.setAttribute("id", "wPhone")
	button5.setAttribute("onclick", "j=5")
	button5.appendChild(headingText5)
	headingCell5.appendChild(button5)
    headingRow.appendChild(headingCell5)
	
	var headingCell6 = document.createElement('th')
    var headingText6 = document.createTextNode('Reports To')
    var button6 = document.createElement("button")
	button6.setAttribute("class", "block")
	button6.setAttribute("id", "reportsTo")
	button6.setAttribute("onclick", "j=6")
	button6.appendChild(headingText6)
	headingCell6.appendChild(button6)
    headingRow.appendChild(headingCell6)


	var headingCell7 = document.createElement('th')
    var headingText7 = document.createTextNode('Employee Email')
   	var button7 = document.createElement("button")
	button7.setAttribute("class", "block")
	button7.setAttribute("id", "email")
	button7.setAttribute("onclick", "j=7")
	button7.appendChild(headingText7)
	headingCell7.appendChild(button7)
    headingRow.appendChild(headingCell7)
	

    header.appendChild(headingRow)
    tbl.appendChild(header)
    //var header = "<th>Header</th>";
    var tblBody = document.createElement("tbody");


    // creating all cells
    for (var i = 0; i < array.length; i++) {
        // creates a table row
        var row = document.createElement("tr");
    row.setAttribute("class", "clickable-row");

        for (var j = 0; j < array[i].length; j++) {
            // Create a <td> element and a text node, make the text
            // node the contents of the <td>, and put the <td> at
            // the end of the table row
            var cell = document.createElement("td");
            //if (j == 0) {
                var cellText = document.createTextNode(array[i][j]);
          
          //      var cellText = document.createTextNode(results.weak_sent[i]);
            //}


            cell.appendChild(cellText);
            row.appendChild(cell);
        }

        // add the row to the end of the table body
        tblBody.appendChild(row);
    }
    // This is for the quick solution
    // tbl.innerHTML = header

    // put the <tbody> in the <table>
    tbl.appendChild(tblBody);



    // appends <table> into <body>
    body.appendChild(tbl);
    // sets the border attribute of tbl to 2;
    tbl.setAttribute("border", "2");
}

generate_table(names)



function myFunction() {
  var input, filter, table, tr,b, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
	  
		td = tr[i].getElementsByTagName("td")[j];
	
	  
    
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";

		
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}



$("button").click(function() {
  if ($(this).hasClass("active")) {
  } else {
    $(".active").removeClass("active");
    $(this).addClass('active');
  }
});

$(window).ready(function () {
    //bind the event using jquery not the onclick attribute of the button
    $('.clickable-row').on('click', updateClick);
});

function updateClick(e) {
    var dataid = $(e.target).closest('tr').find('td:eq(0)').text();
    //alert(dataid);
    window.location.href = "editUser.php?w1=" + dataid;


/*	 
 $.ajax({
 type: "POST",
 url: 'editUser.php',
 data: {dataid: dataid},
 success: function(data){
 window.location.href='editUser.php';
 },
 error: function(xhr, status, error){
 console.error(xhr);
 }
});
*/

}
</script>




</html>
<!--<script>
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

var names = echo json_encode($value);?>;

//var countries =[];
// ?php echo json_encode($value); ?>
//countries.push('		

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), names);
</script>-->



<!--?php
ob_start();
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
ob_end_flush();
?>-->




