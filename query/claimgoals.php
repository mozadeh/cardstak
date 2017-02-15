<?php


require_once('../config.php');

$myrole = isset($_POST['myrole']) ? $_POST['myrole'] : array();
$myrole = implode(",", $myrole);

$myexp = isset($_POST['myexp']) ? $_POST['myexp'] : array();
$myexp = implode(",", $myexp);

$targetrole = isset($_POST['targetrole']) ? $_POST['targetrole'] : array();
$targetrole = implode(",", $targetrole);

$targetexp = isset($_POST['targetexp']) ? $_POST['targetexp'] : array();
$targetexp = implode(",", $targetexp);

$goals = isset($_POST['goals']) ? $_POST['goals'] : array();
$goals = implode(",", $goals);

$cardid = $_POST['cardid'];

$eventid = $_POST['eventid'];




// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
mysql_set_charset('utf8',$conn);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";

/*$eventname = $_POST['eventname'];
$cardid = $_POST['cardid'];*/


if (isset($_POST['eventid'])) {
	$query = mysql_query("insert into goals(cardid, eventid, myrole, myexp, goal, targetrole, targetexp) values ('$cardid', '$eventid', '$myrole', '$myexp','$goals','$targetrole','$targetexp')"); 
	
	//$query = mysql_query("insert into goals(cardid, eventid, myrole, myexp, goal, targetrole, targetexp) values ('123', '456', '123', '123','123','123','123')"); 
}
else {
	echo "There was an error";
}
mysql_close($conn); // Connection Closed


ob_start(); // ensures anything dumped out will be caught

// do stuff here
$url = 'http://www.cardstak.com/index.php?event_id='.$eventid; 

// clear out the output buffer
while (ob_get_status()) 
{
    ob_end_clean();
}

// no redirect
header( "Location: $url" );


?>
<!--<html>
<head>
    <title></title>
</head>
<body>
        My Role: <?php print_r($myrole) ?></p>
        My Experience: <?php print_r($myexp) ?></p>
        
        Goal(s): <?php print_r($goals) ?></p>
        
        Target Role: <?php print_r($targetrole) ?></p>
        Target Experience: <?php print_r($targetexp) ?></p>     

</body>
</html>-->