<?php
/*
 * FileName: editUserDatabase.php
 * Version Number: 2.5
 * Date Modified: 12/05/2020
 * Author: Madhav Sachdeva
 * Purpose:
 * Search/List for employees in the database.
 */

if (!session_id()) {
session_start();
unset($_SESSION['company_id']);
unset($_SESSION['interaction_id']);
include '../NavPanel/navigation.php';
include '../Database/connect.php';
} 
$conn=getDBConnection();
$accessLevel=$_SESSION['role'];

$check=0;
$sql=NULL;	
if($accessLevel=='admin'){//if logged in as admin
	$sql = "SELECT * FROM employee"; 
}else if($accessLevel=='supervisor'){
		$sql = "SELECT * FROM employee WHERE title='sales_rep' OR title='ind_rep'"; //if logged in as supervisor
}

$query = mysqli_query($conn, $sql);
$myArray =[[]];
$i=0;
$rows=mysqli_num_rows($query);
		if($query  = mysqli_query($conn, $sql)){
		   if( $rows > 0){ 
				while($row = mysqli_fetch_array($query)){//getting values for each row of the employee table
			
					$myArray[$i][0]=$row['employee_id'];
					$myArray[$i][1]=$row['first_name'];
					$myArray[$i][2]=$row['last_name'];
					$myArray[$i][3]=$row['title'];
					$myArray[$i][4]=$row['department'];
					$myArray[$i][5]=$row['work_phone'];
					$myArray[$i][6]= $row['reports_to'];
					$myArray[$i][7]=$row['employee_email'];
					$i++;
				}
			}
		}

if($check==1 && isset($_POST['Submit'] )){
  
			$_SESSION['field'] = $field;
			header('location:editUser.php');

}
?>
<!DOCTYPE html>
<html>
<head>
<title>Create User</title>
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
<h1>Filter Employees</h1> 
<input id="myInput" onkeyup="myFunction()" >
<script type="text/javascript">	
var j=1;
var names = JSON.parse('<?php echo json_encode($myArray)?>');
var rows= "<?php echo $rows ?>";





/*
 * Function: generate_table
 * Purpose:
 * Creates a table of employees
 */
function generate_table(array) {//
    // get the reference for the body
    var body = document.getElementsByTagName("body")[0];

    // creates a <table> element and a <tbody> element
    var tbl = document.createElement("table");
    tbl.setAttribute("id", "myTable");//<table> id
    var header=  document.createElement('thead')//first row in table is of headers
    var headingRow = document.createElement('tr')

   

	var headingCell0 = document.createElement('th')//column one header
    var headingText0 = document.createTextNode('Employee ID')
	var button0 = document.createElement("button")
	button0.setAttribute("class", "block")
	button0.setAttribute("id", "empId")
	button0.setAttribute("onclick", "j=0")
	button0.appendChild(headingText0)
    headingCell0.appendChild(button0)
    headingRow.appendChild(headingCell0)


	var headingCell1 = document.createElement('th')//column two header
    var headingText1 = document.createTextNode('First Name')
	var button1 = document.createElement("button")
	button1.setAttribute("class", "block active")
	button1.setAttribute("id", "fName")
	button1.setAttribute("onclick", "j=1")
	button1.appendChild(headingText1)
    headingCell1.appendChild(button1)
    headingRow.appendChild(headingCell1)
    
    var headingCell2 = document.createElement('th')//column three header
    var headingText2 = document.createTextNode('Last Name')
   	var button2 = document.createElement("button")
	button2.setAttribute("class", "block")
	button2.setAttribute("id", "lName")
	button2.setAttribute("onclick", "j=2")
	button2.appendChild(headingText2) 
	headingCell2.appendChild(button2)
    headingRow.appendChild(headingCell2)
	
	var headingCell3 = document.createElement('th')//column four header
    var headingText3 = document.createTextNode('Title')
    var button3 = document.createElement("button")
	button3.setAttribute("class", "block")
	button3.setAttribute("id", "tilte")
	button3.setAttribute("onclick", "j=3")
	button3.appendChild(headingText3)
	headingCell3.appendChild(button3)
    headingRow.appendChild(headingCell3)
	
	var headingCell4 = document.createElement('th')//column 5 header
    var headingText4 = document.createTextNode('Department')
   	var button4 = document.createElement("button")
	button4.setAttribute("class", "block")
	button4.setAttribute("id", "department")
	button4.setAttribute("onclick", "j=4")
	button4.appendChild(headingText4)
	headingCell4.appendChild(button4)
    headingRow.appendChild(headingCell4)
	
	
	var headingCell5 = document.createElement('th')//column 6 header
    var headingText5 = document.createTextNode('Work Phone')
    var button5 = document.createElement("button")
	button5.setAttribute("class", "block")
	button5.setAttribute("id", "wPhone")
	button5.setAttribute("onclick", "j=5")
	button5.appendChild(headingText5)
	headingCell5.appendChild(button5)
    headingRow.appendChild(headingCell5)
	
	var headingCell6 = document.createElement('th')//column 7 header
    var headingText6 = document.createTextNode('Reports To')
    var button6 = document.createElement("button")
	button6.setAttribute("class", "block")
	button6.setAttribute("id", "reportsTo")
	button6.setAttribute("onclick", "j=6")
	button6.appendChild(headingText6)
	headingCell6.appendChild(button6)
    headingRow.appendChild(headingCell6)


	var headingCell7 = document.createElement('th')//column eight header
    var headingText7 = document.createTextNode('Employee Email')
   	var button7 = document.createElement("button")
	button7.setAttribute("class", "block")
	button7.setAttribute("id", "email")
	button7.setAttribute("onclick", "j=7")
	button7.appendChild(headingText7)
	headingCell7.appendChild(button7)
    headingRow.appendChild(headingCell7)
	

    header.appendChild(headingRow)//inserting all headers in first row of table
    tbl.appendChild(header)
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
			var cellText = document.createTextNode(array[i][j]);
            cell.appendChild(cellText);
            row.appendChild(cell);
        }
        // add the row to the end of the table body
        tblBody.appendChild(row);
    }
    // put the <tbody> in the <table>
    tbl.appendChild(tblBody);
    // appends <table> into <body>
    body.appendChild(tbl);
    // sets the border attribute of tbl to 2;
    tbl.setAttribute("border", "2");
}
generate_table(names)


/*
 * Function: myFunction
 * Purpose:
 * Filtering the table rows as you type

 */
function myFunction() {
  var input, filter, table, tr,b, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
	td = tr[i].getElementsByTagName("td")[j];//j here represents the column number that has to be searched by
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


$("button").click(function() {//make the column active if you click it once
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

function updateClick(e) {//to get the employee id that is in column 0 when you click a certain row 
    var dataid = $(e.target).closest('tr').find('td:eq(0)').text();
    window.location.href = "editUser.php?w1=" + dataid;
}
</script>
</html>