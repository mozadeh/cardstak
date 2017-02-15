<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";


//$event_name = $_POST['event'];
$event_id = $_POST['eventid'];

if (isset($_POST['eventid'])) {
	//$query = mysql_query("Select * FROM events WHERE eventname='$event_name' AND eventid='$event_id'");
	$query = mysql_query("Select * FROM events WHERE eventid='$event_id'");
	 //Insert Query
	$row= mysql_fetch_row($query);
	//echo $row[0].",".$row[1].",".$row[3].",".$row[6].",".$row[7].",".$row[8].",".$row[9];	
	if (empty($row[0])){
		echo "doesnt exist";	
	} 
	else{
		//echo $row[0].",".$row[1].",".$row[3].",".$row[6].",".$row[7].",".$row[8].",".$row[9].",".$row[10].",".$row[11];	
		echo json_encode($row);
	}	
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>