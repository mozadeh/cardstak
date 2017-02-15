<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";
	


$eventname = mysql_real_escape_string($_POST['eventname']);
$eventid = $_POST['eventid'];
$eventdate = $_POST['eventdate'];
$groupno = $_POST['groupno'];
$group1name = !empty($_POST['group1name']) ? mysql_real_escape_string($_POST['group1name']) : "NULL";
$group2name = !empty($_POST['group2name']) ? mysql_real_escape_string($_POST['group2name']) : "NULL";
$group3name = !empty($_POST['group3name']) ? mysql_real_escape_string($_POST['group3name']) : "NULL";
$nmemberid = !empty($_POST['nmemberid1']) ? $_POST['nmemberid1'] : "NULL";
$lmemberid = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULL";

if (isset($_POST['eventname'])) {
	$query = mysql_query("update events set eventname='$eventname', eventdate='$eventdate', groupno='$groupno', group1='$group1name', group2='$group2name', group3='$group3name' where eventid='$eventid' and ( creatornmemberid='$nmemberid' or creatorlmemberid='$lmemberid' )");
$resultrows=mysql_affected_rows();	
if ($resultrows!=''){
	echo $resultrows;		
	$query = mysql_query("update cards set event='$eventname' where eventid='$eventid'"); 
	}
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>