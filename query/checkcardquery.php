<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";


//$event2 = $_POST['event1'];
$eventid2 = $_POST['eventid1'];
$nmemberid2 = $_POST['nmemberid1'];
$lmemberid2 = $_POST['lmemberid1'];

if (isset($_POST['eventid1'])) {
	$query = mysql_query("Select cards.id  FROM cards WHERE eventid='$eventid2' AND (lmemberid='$lmemberid2' OR nmemberid='$nmemberid2')"); 
	echo mysql_result($query, 0);		
}
else {
	echo "There was an error";
//echo $nmemberid2;
}
mysql_close($conn); // Connection Closed




?>