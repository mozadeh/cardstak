<?php
require_once('../config.php');
require_once('../common.php');
require_once "../eventbrite/Eventbrite.php"; 
require_once realpath(dirname(__FILE__) . '/../imagesearch/src/Google/autoload.php');
include_once "../imagesearch/examples/templates/base.php"; 


// connecting to mysql
$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";
	
$eventid = $_POST['eventid'];
$accesstoken = $_POST['accesstoken'];
//$eventname = $_POST['eventname'];
//$dbeventid = $_POST['dbeventid'];

$authentication_tokens1 = array('app_key'=>$appkey, 
                                             'client_secret'=> $client_secret,
                                              'access_token'=> $accesstoken
                                             );
$eb_client = new Eventbrite( $authentication_tokens1 );

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





if (isset($_POST['accesstoken'])) {
	/*$query = mysql_query("insert into events(eventid, eventname, eventdate, creatornmemberid, creatorlmemberid, groupno, group1, group2, group3) values ('$random_eventid', '$eventname', '$eventdate ', '$nmemberid','$lmemberid','$groupno','$group1name','$group2name','$group3name')"); //Insert Query
//echo mysql_insert_id();	
echo $random_eventid;*/
	try{
	// For more information about the functions that are available through the Eventbrite API, see http://developer.eventbrite.com/doc/
	    $attendees = $eb_client->event_list_attendees( array('id'=>$eventid) );
	} catch ( Exception $e ) {
	    $attendees = array();
	}
	
	//echo attendee_list_to_html( $attendees ).$eventname;
	attendee_list_to_html( $attendees, $service, $optParams );
	
	
	/*if ( $_POST['preview'] == 'yes'){
	
		//sleep for 5 seconds
		sleep(60);
		
		$deleteeventid = $_POST['dbeventid'];
	
		
		if (isset($_POST['dbeventid'])) {
			$query = mysql_query("delete from events  where eventid='$deleteeventid'");
			$resultrows=mysql_affected_rows();	
			if ($resultrows!=''){
				//echo $resultrows;		
				$query = mysql_query("delete from cards where eventid='$deleteeventid'"); 
			}
		}
		else {
			echo "There was an error";
		}
	
	}*/
	
	
}
else {
	echo "There was an error";
}


mysql_close($conn); // Connection Closed


function attendee_to_html( $attendee , $service, $optParams  ){
    if($attendee->first_name){ 
        /*return "<div class='eb_attendee_list_item'>".$attendee->first_name.' '.$attendee->last_name.' '.$attendee->email.' '.$attendee->job_title.' '.$attendee->company.' '.$attendee->website.' '.$attendee->answers[0]->answer->answer_text.' '.$attendee->answers[1]->answer->answer_text."</div>\n";*/
        /*return $attendee->first_name.' '.$attendee->last_name.' '.$attendee->email.' '.$attendee->job_title.' '.$attendee->company.' '.$attendee->website.' '.$attendee->answers[0]->answer->answer_text.' '.$attendee->answers[1]->answer->answer_text;*/
        
        //$attendee->answers[0]->answer->question.' '.$attendee->answers[0]->answer->question_type.' '.$attendee->answers[0]->answer->answer_text
        
        
	$jobtitle = $attendee->job_title;
	$company = $attendee->company;
	
	$fullname = $attendee->first_name.' '.$attendee->last_name;
	$fulltitle = $jobtitle.' '.$company;
	
	
	//$email = if(!empty($attendee->email))?
	$email = !empty($attendee->email) ? $attendee->email : "NULLVAR";
	$phone = !empty($attendee->cell_phone) ? $attendee->cell_phone : "NULLVAR";
	if ($phone == "NULLVAR") {  $phone = !empty($attendee->home_phone) ? $attendee->home_phone : "NULLVAR";}
	if ($phone == "NULLVAR") {  $phone = !empty($attendee->work_phone) ? $attendee->work_phone : "NULLVAR";}
	
	$linkedin = "NULLVAR";
	
	for ($x=0; $x <11; $x++) {
		$extraquestion = $attendee->answers[$x]->answer->question;
		$extraquestion = strtolower($extraquestion);
		$extraquestiontype = $attendee->answers[$x]->answer->question_type;
   		if ( strpos($extraquestion,'linkedin') !== false  ){ /*&& $extraquestiontype == "text"*/
   			$extraquestionanswer = $attendee->answers[$x]->answer->answer_text;
   				if ( strpos($extraquestionanswer,'linkedin.com/') !== false ) {
   					$linkedin = $extraquestionanswer;
   					$x=11;
   				}
   		}
   		
	} 

	
	$weburl = !empty($attendee->website) ? $attendee->website : "NULLVAR";
	if ($weburl == "NULLVAR") {  $weburl = !empty($attendee->blog) ? $attendee->blog : "NULLVAR";}
	
	//$photourl2 = "http://cardstak.com/uploads/profileimage.png";
	//$nmemberid = "NULL";
	//$lmemberid = "NULL";
	$group = "1";
	
	//$bio = buildbio( $fullname, $jobtitle , $company , $weburl );
	$bio = "";
	
	if ($linkedin!="NULLVAR") {$bio = $bio.'. '.$fullname.' Linkedin page is: '.$linkedin;} 
	
	$eventname = $_POST['eventname'];
	$dbeventid = $_POST['dbeventid'];
		
	$query = $fullname.' is a '.$jobtitle.' at '.$company; 

	$results = $service->cse->listCse($query, $optParams);
	$photourl = $results[modelData][items][0][image][thumbnailLink];

	if(empty($photourl)){ $photourl = "http://cardstak.com/uploads/profileimage.png"; }
	
	if(empty($company)){ $photourl = "http://cardstak.com/uploads/profileimage.png"; }
		
	if($fulltitle==' '){ $fulltitle = "attendee"; }
	
	$par = "insert into cards(event, eventid, fullname, title, bio, phone, email, linkedin, weburl, photourl, cardgroup, nmemberid, lmemberid, emailed) values ('$eventname', '$dbeventid', '$fullname', '$fulltitle','$bio','$phone','$email','$linkedin' ,'$weburl' ,'$photourl' ,'$group', 'NULL','NULL', 'no')";
	
	echo $par;
	
	$query = mysql_query($par); //Insert Query
	//echo "Card added to Cardstak";	

        
       
        
        
        
    }else{
        return '';
    }
}

function sort_attendees_by_created_date( $x, $y ){
    if($x->attendee->created == $y->attendee->created ){
        return 0;
    }
    return ( $x->attendee->created > $y->attendee->created ) ? -1 : 1;
}

function attendee_list_to_html( $attendees , $service, $optParams ){
    //$attendee_list_html = "<div class='eb_attendee_list'>\n";
    if( isset($attendees->attendees) ){ 
        //sort the attendee list?
        usort( $attendees->attendees, "sort_attendees_by_created_date");
        //render the attendee as HTML
        foreach( $attendees->attendees as $attendee ){
            $attendee_list_html .= attendee_to_html( $attendee->attendee , $service, $optParams  );
        }
    }else{
        $attendee_list_html .= 'no one is registered for this event';
    }   
    return $attendee_list_html;
}


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
	
	
	//return ( ($title!='') && ($web==''))?'0':'1';
	//return $occupation;
}



?>