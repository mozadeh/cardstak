<?php
require_once('../config.php');


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";


$cardid = $_POST['cardid'];
$eventid = $_POST['eventid'];
//$nmemberid2 = $_POST['nmemberid1'];
//$lmemberid2 = $_POST['lmemberid1'];

if (isset($_POST['eventid'])) {

	$query = mysql_query("Select count(*) FROM cards WHERE eventid='$eventid' "); 
	$totalcards = mysql_result($query, 0);	



	$result = mysql_query("Select cardid, count(*) as cnt FROM activities WHERE eventid='$eventid' and type!='usetips' group by cardid "); 
	
	$numactivities=0;
	$cart = array();
	//$test = array();
	
	while ($row = mysql_fetch_assoc($result)) {
	    if (!empty($row["cardid"]) ) {$cart[] = $row["cnt"];}	    
	    if ( $row["cardid"] == $cardid ) { $numactivities =  $row["cnt"]; }
	    
	}
	if ( count($cart)==0 || $totalcards<2){
		echo "NA";
	}
	else{
		
		//need to add back in cards that don't appear in activities
		$added = $totalcards - count($cart);
		sort($cart);
		//repeating values
		$vals = array_count_values($cart);
		$vals = $vals[$numactivities] - 1;

		$key = array_search($numactivities, $cart);
		
		if ($key > -1 ){
			$key = $key + $added + $vals + 1;
		}
		else{ 
			$key = 0;
		} 
		
		echo $key/$totalcards;
		//echo var_dump($cart);
		//echo $vals;
	}	

}
else {
echo "There was an error";
}
mysql_close($conn); // Connection Closed




?>