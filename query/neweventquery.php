<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";
	


$eventname = mysql_real_escape_string($_POST['eventname']);
$eventdate = $_POST['eventdate'];
$groupno = $_POST['groupno'];
$group1name = !empty($_POST['group1name']) ? mysql_real_escape_string($_POST['group1name']) : "NULL";
$group2name = !empty($_POST['group2name']) ? mysql_real_escape_string($_POST['group2name']) : "NULL";
$group3name = !empty($_POST['group3name']) ? mysql_real_escape_string($_POST['group3name']) : "NULL";
$nmemberid = !empty($_POST['nmemberid1']) ? $_POST['nmemberid1'] : "NULL";
$lmemberid = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULL";
$ebid = !empty($_POST['ebid']) ? $_POST['ebid'] : "NULL";
$eburl = !empty($_POST['eburl']) ? $_POST['eburl'] : "NULL";
$random_eventid = generateRandomString();
$eventtype = $_POST['eventtype'];


if (isset($_POST['eventname'])) {
	$query = mysql_query("insert into events(eventid, eventname, eventdate, creatornmemberid, creatorlmemberid, groupno, group1, group2, group3, ebid, eburl,eventtype) values ('$random_eventid', '$eventname', '$eventdate ', '$nmemberid','$lmemberid','$groupno','$group1name','$group2name','$group3name','$ebid','$eburl','$eventtype')"); //Insert Query
//echo mysql_insert_id();	
echo $random_eventid;
}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


?>