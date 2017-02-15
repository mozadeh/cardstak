<?PHP
// Original PHP code by Chirp Internet: www.chirp.com.au
// Please acknowledge use of this code by including this header.
require_once('../config.php');
require("../common.php"); 

if (isset($_GET['nmemberid'])) {
	$nmemberid = $_GET['nmemberid'];}
	
if (isset($_GET['lmemberid'])) {
	$lmemberid = $_GET['lmemberid'];}

//$lmemberid2 = !empty($_POST['lmemberid1']) ? $_POST['lmemberid1'] : "NULL";
//if ($lmemberid == "") { $lmemberid = "NULLVAR" }
//if ($nmemberid == "") { $nmemberid = "NULLVAR" }

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
	print "Not connected with database.";


 $query = "Select cards.fullname,cards.title,savedcards.event,cards.email,cards.phone,cards.linkedin,cards.weburl,cards.bio,savedcards.note FROM cards,savedcards WHERE (savedcards.nmemberid = :nmemberid OR savedcards.lmemberid = :lmemberid) AND  savedcards.cardid=cards.id AND savedcards.event=cards.event ORDER BY savedcards.created DESC";
        
                
$query_params = array(      
        ':nmemberid' => $nmemberid,
        ':lmemberid' => $lmemberid
    );



try {
	$stmt   = $db->prepare($query);
	$result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
	$response["success"] = 0;
	$response["message"] = "Database Error!";
	die(json_encode($response));
}

$rows = $stmt->fetchAll();






$colnames = array(
'fullname' => "Full Name",
'title' => "Title",
'event' => "Event Name",
'email' => "Email Address",
'phone' => "Phone Number",
'linkedin' => "LinkedIn URL",
'weburl' => "Website URL",
'bio' => "Bio",
'note' => "Note"
);

function map_colnames($input)
{
	global $colnames;
	return isset($colnames[$input]) ? $colnames[$input] : $input;
}

function cleanData(&$str)
{
	if($str == 't') $str = 'TRUE';
	if($str == 'f') $str = 'FALSE';
	if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		$str = "'$str";
	}
	if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// filename for download
$filename = "Savedcards " . date('Ymd') . ".csv";
//$filename = $eventid;

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: text/csv");

$out = fopen("php://output", 'w');



$flag = false;
foreach($rows as $row) {
if ($row["weburl"]=="NULLVAR") {$row["weburl"]=" ";}
if ($row["phone"]=="NULLVAR") {$row["phone"]=" ";}
if ($row["linkedin"]=="NULLVAR") {$row["linkedin"]=" ";}
if ($row["email"]=="NULLVAR") {$row["email"]=" ";}
if(!$flag) {	
	// display field/column names as first row
	$firstline = array_map("map_colnames", array_keys($row));
	fputcsv($out, $firstline, ',', '"');
	$flag = true;
}
array_walk($row, 'cleanData');
fputcsv($out, array_values($row), ',', '"');
}

fclose($out);
exit;
?>