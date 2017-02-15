<?php
require_once('../config.php');

// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset('utf8',$conn);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";

//var dataString = 'eventid=' + eventid + '&eventname=' + eventname + '&to=' + to+ '&from=' + from+ '&activity=' + activity;

$eventname = $_POST['eventname'];
$eventid = $_POST['eventid'];
$to = $_POST['to'];
$emailto = !empty($_POST['emailto']) ? $_POST['emailto'] : "NULLVAR";
$from = !empty($_POST['from']) ? $_POST['from'] : "NULLVAR";
$message = !empty($_POST['message']) ? $_POST['message'] : "NULLVAR";
$cardid = !empty($_POST['cardid']) ? $_POST['cardid'] : "NULLVAR";
$activity = $_POST['activity'];

if (isset($_POST['eventid'])) {
	$query = mysql_query("insert into activities(eventid, eventname, type, userfrom, userto,message,emailto,cardid) values ('$eventid', '$eventname', '$activity', '$from','$to','$message','$emailto','$cardid')"); //Insert Query
	//$query = mysql_query("insert into activities(eventid, eventname, type, from, to) values ('123', '123', '123', '123','123')"); 
echo $query;	
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>