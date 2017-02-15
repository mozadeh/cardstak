<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";



$event2 = $_POST['event1'];
$useremail2 = $_POST['useremail1'];
$cardid2 = $_POST['cardid1'];
$note2 = !empty($_POST['note1']) ? mysql_real_escape_string($_POST['note1']) : "";
$cardrole2 = $_POST['cardrole1'];
$nmemberid2 = $_POST['nmemberid1'];
$lmemberid2 = $_POST['lmemberid1'];

if (isset($_POST['event1'])) {
	$query = mysql_query("insert into savedcards(event, useremail, cardid, note,role,nmemberid,lmemberid) values ('$event2', '$useremail2', '$cardid2','$note2','$cardrole2','$nmemberid2','$lmemberid2')"); //Insert Query
echo "Card added to your Cardstak";	
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>