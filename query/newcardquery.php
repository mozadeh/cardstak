<?php
require_once('../config.php');

// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset('utf8',$conn);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";


$event2 = $_POST['event1'];
$eventid2 = $_POST['eventid1'];
$fullname2 = mysql_real_escape_string($_POST['fullname1']);
$title2 = mysql_real_escape_string($_POST['title1']);
$bio2 = !empty($_POST['bio1']) ? mysql_real_escape_string($_POST['bio1']) : null;
$email2 = !empty($_POST['email1']) ? $_POST['email1'] : "NULLVAR";
$phone2 = !empty($_POST['phone1']) ? $_POST['phone1'] : "NULLVAR";
$linkedin2 = !empty($_POST['linkedin1']) ? $_POST['linkedin1'] : "NULLVAR";
$weburl2 = !empty($_POST['weburl1']) ? $_POST['weburl1'] : "NULLVAR";
$cvlink2 = !empty($_POST['cvlink1']) ? $_POST['cvlink1'] : "NULLVAR";
$photourl2 = $_POST['photourl1'];
$nmemberid2 = !empty($_POST['nmemberid1']) ? $_POST['nmemberid1'] : "NULL";
$lmemberid2 = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULL";
$group2 = !empty($_POST['group1']) ? $_POST['group1'] : "1";

if (isset($_POST['event1'])) {
	$query = mysql_query("insert into cards(event, eventid, fullname, title, bio, phone, email, linkedin, weburl, photourl, cardgroup, nmemberid, lmemberid, cvlink) values ('$event2', '$eventid2', '$fullname2', '$title2','$bio2','$phone2','$email2','$linkedin2' ,'$weburl2','$photourl2','$group2','$nmemberid2','$lmemberid2', '$cvlink2')"); //Insert Query
//echo "Card added to Cardstak";
	$inserted = mysql_insert_id();
	echo $inserted;		
}
else {
	echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>