<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";
	
$eventid = $_POST['eventid'];
$nmemberid = !empty($_POST['nmemberid1']) ? $_POST['nmemberid1'] : "NULL";
$lmemberid = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULL";

if (isset($_POST['eventid'])) {
	$query = mysql_query("delete from events  where eventid='$eventid' and ( creatornmemberid='$nmemberid' or creatorlmemberid='$lmemberid' )");
$resultrows=mysql_affected_rows();
	$chatfile = "../chattxt/".$eventid.".txt";
	if (file_exists($chatfile)) {
        	unlink($chatfile);
    	}
	//$path = $_SERVER['DOCUMENT_ROOT'].'items/item2.txt';
	//unlink($path);	
if ($resultrows!=''){
	echo $resultrows;		
	$query = mysql_query("delete from cards where eventid='$eventid'"); 
	}
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>