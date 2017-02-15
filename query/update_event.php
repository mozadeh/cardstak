<?php
require_once('../config.php');
require_once 'Mandrill.php';
require_once "../eventbrite/Eventbrite.php"; 
require_once realpath(dirname(__FILE__) . '/../imagesearch/src/Google/autoload.php');
include_once "../imagesearch/examples/templates/base.php"; 

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";

$client = new Google_Client();
$client->setApplicationName("Cardstak Image Finder");
$apiKey = "AIzaSyC2nugqaJqf9flLY0xUxMsQ2IkcwKh_gog"; // Change this line.
// Warn if the API key isn't changed.
if (strpos($apiKey, "<") !== false) {
  echo missingApiKeyWarning();
  exit;
}
$client->setDeveloperKey($apiKey);

$service = new Google_Service_Customsearch($client);
$optParams = array(
'searchType' => 'image',
'num' => '1',
'imgType' => 'face',
'cx' => '001596038216601089707:3dsmxb6ngf8',
);

if (isset($_GET['user_id'])) {
	$user_id = $_GET['user_id'];
	$result = mysql_query("Select ebtoken FROM users WHERE id='$user_id'");
	$row = mysql_fetch_assoc($result);
	$token= $row['ebtoken'];
	}
else{
	$user_id = "not set";
}	

//echo $token;
//echo 'salam';
//echo var_dump(json_decode($request_body));

//echo var_dump(file_get_contents('php://input'));

$input = file_get_contents('php://input');
$inputdecoded = json_decode($input);
$inputarray = get_object_vars($inputdecoded);
//echo $inputarray["api_url"];
// when post used to work
//$body = $_POST["api_url"];
//$url = $body;
$url = $inputarray["api_url"];
$params = array('token' => $token , 'expand' => 'attendees');
$url .= '?' . http_build_query($params);

//echo $_POST["api_url"];
echo $url;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, false);
$data = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
	
$json = json_decode($data, true);

echo 'hello'; 
	
echo 'echo'.var_dump($json);

//print_r($_POST);
//echo 'here0';
if ($status == 200 && !empty($input) ) {
	//echo 'here1';

        for ($i = 0; $i < count($json[attendees]); $i++) {    
        	//echo 'here2';
	        $firstname = $json[attendees][$i][profile][first_name];
	        $lastname = $json[attendees][$i][profile][last_name];
		$jobtitle = $json[attendees][$i][profile][job_title];
		$company = $json[attendees][$i][profile][company];
		
		$fullname = $json[attendees][$i][profile][name];
		$fulltitle = $jobtitle.' '.$company;
		
		
		
		//$email = if(!empty($attendee->email))
		$email = !empty($json[attendees][$i][profile][email]) ? $json[attendees][$i][profile][email] : "NULLVAR";
		$phone = !empty($json[attendees][$i][profile][cell_phone]) ? $json[attendees][$i][profile][cell_phone] : "NULLVAR";
		if ($phone == "NULLVAR") {  $phone = !empty($json[attendees][$i][profile][home_phone]) ? $json[attendees][$i][profile][home_phone] : "NULLVAR";}
		if ($phone == "NULLVAR") {  $phone = !empty($json[attendees][$i][profile][work_phone]) ? $json[attendees][$i][profile][work_phone] : "NULLVAR";}
		
		$myfile = fopen("update_file.txt", "a") or die("Unable to open file!");
		$txt = $phone.$email;
		//$txt = var_dump($data);
		fwrite($myfile, "\n". $txt);
		fclose($myfile);
		
		
		$linkedin = "NULLVAR";
		
		for ($x=0; $x <11; $x++) {
			$extraquestion = $json[attendees][$i][answers][$x][question];
			$extraquestion = strtolower($extraquestion);
			
	   		if ( strpos($extraquestion,'linkedin') !== false  ){
	   			$extraquestionanswer = $json[attendees][$i][answers][$x][answer];
	   				if ( strpos($extraquestionanswer,'linkedin.com/') !== false ) {
	   					$linkedin = $extraquestionanswer;
	   					$x=11;
	   				}
	   		}
	   		
		} 
	
		
		$weburl = !empty($json[attendees][$i][profile][website]) ? $json[attendees][$i][profile][website] : "NULLVAR";
		if ($weburl == "NULLVAR") {  $weburl = !empty($json[attendees][$i][profile][blog]) ? $json[attendees][$i][profile][blog] : "NULLVAR";}
		
		//$photourl2 = "http://cardstak.com/uploads/profileimage.png";
		//$nmemberid = "NULL";
		//$lmemberid = "NULL";
		$group = "1";
		
		//$bio = buildbio( $fullname, $jobtitle , $company , $weburl );
		
		$bio = "";
		
		if ($linkedin!="NULLVAR") {$bio = $bio.'. '.$fullname.' Linkedin page is: '.$linkedin;} 
		
		//$myfile = fopen("update_file.txt", "a") or die("Unable to open file!");
		//$txt = $bio;
		//$txt = serialize($data);
		//fwrite($myfile, "\n". $txt);
		//fclose($myfile);
		
		$ebeventid = $json[event_id];
		
		
		$result_e = mysql_query("Select eventname,eventid FROM events WHERE ebid='$ebeventid'");
		$row_e = mysql_fetch_assoc($result_e);
		$eventname = $row_e['eventname'];
		$dbeventid = $row_e['eventid'];
		
		
		
		//$eventname = 'Scooby Doo!';
		//$dbeventid = 'ozRR7UsDRN';
			
		$query = $fullname.' is a '.$jobtitle.' at '.$company; 
	
		$results = $service->cse->listCse($query, $optParams);
		$photourl = $results[modelData][items][0][image][thumbnailLink];
	
		if(empty($photourl)){ $photourl = "http://cardstak.com/uploads/profileimage.png"; }
		
		if(empty($company)){ $photourl = "http://cardstak.com/uploads/profileimage.png"; }
			
		if($fulltitle==' '){ $fulltitle = "attendee"; }
		
		if ($dbeventid!=''){
			$par = "insert into cards(event, eventid, fullname, title, bio, phone, email, linkedin, weburl, photourl, cardgroup, nmemberid, lmemberid, emailed) values ('$eventname', '$dbeventid', '$fullname', '$fulltitle','$bio','$phone','$email','$linkedin' ,'$weburl' ,'$photourl' ,'$group', 'NULL','NULL', 'no')";
			
			echo $par;
			
			$query = mysql_query($par); //Insert Query
			echo "Card added to Cardstak";	
		}
	}
        
        
        
        
        
        mysql_close($conn);   
       
        
    
        
   
}
else{
	
}

 
//////   emailing all attendees //////

if (!empty($dbeventid) && $dbeventid!='ejJExfvIb9'){
	
	$mandrill = new Mandrill('B8Sm8xi3BNSIdoMVvWDHrQ');
	$replyemail    = "admin@cardstak.com";
	
	/*** change eventid here ***/
	$theeventid= $dbeventid;
	
	/*** fetching the cards created  ***/
	
	$query = "Select * FROM cards WHERE cards.eventid = :eventid AND cards.emailed=:emailed ";
	                
	$query_params = array(      
	        ':eventid' => $theeventid,
	        ':emailed' => "no"
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
	
	
	if ($rows) {
	    foreach ($rows as $row) {
			
			/*** check if user already has an account ***/
			
			$checkquery = "Select id FROM users WHERE email = :checkemail";
	                
			$checkquery_params = array(      
			        ':checkemail' => $row["email"]
			    );
			
			
			try {
			    $checkstmt   = $db->prepare($checkquery);
			    $checkresult = $checkstmt->execute($checkquery_params);
			}
			catch (PDOException $ex) {
			    $response["success"] = 0;
			    $response["message"] = "Database Error!";
			    die(json_encode($response));
			}
	
			//$num_rows = $checkstmt->fetch(PDO::FETCH_NUM); 
			//$num_rows = $num_rows[0];
			$rows = $checkstmt->fetchAll(); 
			$id = $rows[0]['id'];
	
			$num_rows = count($rows);
			
			//echo 'row exists: '.$exists.' EOD';
			
			
			/*** creating the variables ***/
	
			$eventname = $row["event"];
			$eventid = $row["eventid"];
			$address = $row["email"];
			//$firstname="Hosein";
			//$lastname="Ghasemzadeh";
			$fullname =$row["fullname"];
			$title =$row["title"];
			$picurl =$row["photourl"];
			list($firstname, $lastname) = explode(' ', $fullname, 2);
			$password = strtolower($firstname).generateRandomString();
			$subject = "View your card for ".$eventname." and see who else is coming";
				
			if ($num_rows == 0){	
				
				/*** creating user account ***/
				
				$query = " 
				    INSERT INTO users ( 
				        email,
				        firstname,
				        lastname,  
				        password, 
				        salt 
				    ) VALUES ( 
				        :registeremail,
				        :registerfistname,
				        :registerlastname,
				        :registerpassword, 
				        :salt 
				    ) 
				"; 
				
				 
				$salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
				 
				
				$registerpassword = hash('sha256', $password . $salt); 
				
				for($round = 0; $round < 65536; $round++) 
				{ 
				    $registerpassword = hash('sha256', $registerpassword . $salt); 
				} 
				
				$query_params = array( 
				     ':registeremail' => $address,
				     ':registerfistname' => $firstname,
				     ':registerlastname' => $lastname,
				     ':registerpassword' => $registerpassword, 
				     ':salt' => $salt
				   
				); 
				 
				try 
				{ 
				    // Execute the query to create the user 
				    $stmt = $db->prepare($query); 
				    $result = $stmt->execute($query_params);
				    $id = $db->lastInsertId();
				    echo $id;
				} 
				catch(PDOException $ex) 
				{ 
				 
				    die("Failed to run query: " . $ex->getMessage()); 
				} 
			
			}
			
			
			/*** creating email message ***/
			
			$uniqueurl = "http://www.cardstak.com/index.php?event_id=".$eventid."&card=".$row["id"];	
			$messageText = writeMsg($fullname,$title, $picurl ,$eventname,$uniqueurl,$address,$password, $num_rows);	
			
			
			
			try{
			 
			        $message = array(
			                'subject' => $subject ,
			                'html' => $messageText, // or just use 'html' to support HTMl markup
			                'from_email' => 'emailer@cardstak.com',
			                'from_name' => $eventname, //optional
			                'to' => array(
			                        array( // add more sub-arrays for additional recipients
			                                'email' => $address,
			                                'name' => $fullname, // optional
			                                'type' => 'to' //optional. Default is 'to'. Other options: cc & bcc
			                                )
			                ),
			 		'headers' => array('Reply-To' => $replyemail),
				        'important' => false,
				        'track_opens' => null,
				        'track_clicks' => null,
				        'auto_text' => null,
				        'auto_html' => null,
				        'inline_css' => null,
				        'url_strip_qs' => null,
				        'preserve_recipients' => null,
				        'view_content_link' => null,
				        'tracking_domain' => null,
				        'signing_domain' => null,
				        'return_path_domain' => null,
				        'merge' => true
			
			        );
			 
			    $result = $mandrill->messages->send($message);
			    print_r($result); //only for debugging
			    echo $messageText;
			} catch(Mandrill_Error $e) {
			 
			    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			 
			    throw $e;
			}
			
			
			
			$query = "Update cards SET cards.emailed=:emailed, cards.nmemberid=:nmemberid WHERE cards.eventid=:eventid AND cards.id=:cardid ";
	                
			$query_params = array(      
			        ':eventid' => $eventid,
			        ':emailed' => "yes",
			        ':nmemberid' => $id,
			        ':cardid' => $row["id"]
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
						
			
		}
	}
}
////// done emailing ///////



function buildbio ($name, $title, $company, $website) {
	
	$occupation="";
	if (!empty($title) && !empty($company)) {$occupation = $name.' is a '. $title.' at '.$company; }
	else if (empty($title) && !empty($company)) {$occupation = $name.' works at '.$company; }
	else if (!empty($title) && empty($company)) {$occupation = $name.' is a '. $title; }
	
	if ($website!="NULLVAR") {$web = $name.'s website is '.$website;} else {$web="";}
	
	//return $occupation.'. '.$web; 
	
	
	
	if (!empty($occupation) && !empty($web)) {return $occupation.'. '.$web; }
	else if (empty($occupation) && !empty($web)) {return $web;  }
	else if (!empty($occupation) && empty($web)) {return $occupation; }
	else return "";

}



/*** emailer functions required ***/
		
function generateRandomString($length = 4) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function writeMsg($name, $title, $picurl, $eventname, $eventurl, $username, $password, $num_rows) {
	if ($num_rows>0){
		$passhtml = '<br>if you have forgotten your password <a href="http://www.cardstak.com/forgotpassword.php"  style="text-decoration:none;font-size:20px;font-family:inherit;font-variant:normal;color:inherit" target="_blank"><b>Click Here</b></a>' ;
	}
	else{
		$passhtml = '<br> <b>Password:</b> '.$password.'</h1>';
	}
	
	
	return '<div style="background-color:#f2f2f2">
	<center>
	<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#f2f2f2">
	    <tbody>
	        <tr>
	            <td align="center" valign="top" style="padding:20px 20px">
	                <table border="0" cellpadding="0" cellspacing="0" style="width:600px;text-align:center">
	                    <tbody>
	                        <tr>
	                            <td><a href="http://www.cardstak.com" title="Cardstak" style="text-decoration:none;font-size:24pt;font-family:inherit;font-variant:normal" target="_blank"><img src="http://www.cardstak.com/images/emaillogo.png" alt="Cardstak" width="auto" style="border:0;color:#35978b!important;font-family:Helvetica,Arial,sans-serif;font-size:60px;font-weight:bold;min-height:auto!important;letter-spacing:-4px;line-height:100%;outline:none;text-align:center;text-decoration:none;vertical-align:middle" class="CToWUd"></a> 
	                            </td>
	                        </tr>
	                        <tr>
	                            <td align="center" valign="top" style="padding-top:10px;padding-bottom:20px">
	                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px;-webkit-border-radius: 4px;-moz-border-radius: 4px;margin-top:10px;padding-top:10px">
	                                    <tbody>
	                                        <tr>
	                                            <td align="center"> <div style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin:10px 0 0 0;padding:0;text-align:center;"><span style="font-weight:300">Hi</span> '.$name.' <span style="color:rgb(53,151,139)">'.$title.'</span> 
	                                                <div style="margin-top:10px;margin-bottom:5px">
	                                                    <img src="'.$picurl.'" style="width:80px;border-radius:15px;-webkit-border-radius: 15px;-moz-border-radius: 15px;">
	                                                </div>
	</div>
	
	<h1 style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:300;letter-spacing:-1px;line-height:145%;padding:0;text-align:center"><div style="border-bottom:1px solid grey;padding-bottom:10px;margin-bottom:10px;color:#606060"> <b>Congrats!</b> Your card has been created for <span style="color:#35978b">'.$eventname.'</span>, to see your card (and others) click the button below </div> <span style="color:#606060"> to modify your card, <b style="color: rgb(53, 151, 139);">log in</b> with the following information </span>
	                                                    <br> <b style="color:#606060">Username:</b> <a href="#" style="color:#606060; text-decoration:none">'.$username.'</a>'.$passhtml.'
	                                                        
	
	</td>
	</tr>
	<tr>
	<td align="center" valign="middle" style="padding-right:40px;padding-bottom:40px;padding-left:40px">
	<table border="0" cellpadding="0" cellspacing="0" style="background-color:#35978b;border-collapse:separate!important;border-radius:3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;margin-top: 15px;">
	    <tbody>
	        <tr>
	            <td align="center" valign="middle" style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:bold;line-height:100%;padding-top:15px;padding-right:15px;padding-bottom:15px;padding-left:15px"> <a href="'.$eventurl.'" style="color:#ffffff;text-decoration:none" target="_blank">Open Event Page</a> 
	            </td>
	        </tr>
	    </tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	<tr>
	<td align="center" valign="top">
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	    <tbody>
	        <tr>
	            <td align="center" valign="top" style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:125%">create your own events for <b style="color:#35978b">FREE</b> with Cardstak.com<span style="font-size:10px">                                            </span>
	
	            </td>
	        </tr>
	    </tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</center>
	</div>';
}	



?>