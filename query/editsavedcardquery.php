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

if (isset($_POST['event1'])) {
	$query = mysql_query("UPDATE savedcards SET note='$note2' WHERE cardid='$cardid2'"); //Insert Query
echo "Card edited";	
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>