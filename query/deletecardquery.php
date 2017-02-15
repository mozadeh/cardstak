<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";



$eventid2 = $_POST['eventid1'];
$nmemberid2 = !empty($_POST['nmemberid1']) ? $_POST['nmemberid1'] : "NULLVAR";
$lmemberid2 = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULLVAR";

if (isset($_POST['eventid1'])) {
	$query = mysql_query("DELETE FROM cards WHERE eventid='$eventid2' AND (nmemberid='$nmemberid2' OR lmemberid='$lmemberid2')"); //Insert Query
echo "Card deleted";	
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>