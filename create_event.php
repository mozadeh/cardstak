<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="js/sweet-alert.js"></script> 
  <link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css"> 
  <link rel="stylesheet" type="text/css" href="http://www.cardstak.com/style/eventbuilder.css">
  <link href='http://fonts.googleapis.com/css?family=Pathway+Gothic+One' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="style/createeventstyle.css">
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57633709-1', 'auto');
  ga('send', 'pageview');

</script>


  <script>
  $(function() {
    $( "#eventdate" ).datepicker();
  });
  </script>
  
  
  <title>Create Stak</title>
  
  


<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  api_key: 75d7x1c1fkydj1
  scope: r_basicprofile r_emailaddress 
  onLoad: onLinkedInLoad
  authorize: true
</script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

  
</head>


<body>

<!--<div style="display:none;">
<img src="http://www.cardstak.com/images/evsignin.png" width="1" height="1" border="0" alt="Image 01">
<img src="http://www.cardstak.com/images/evsignin-hover.png" width="1" height="1" border="0" alt="Image 02">
</div> -->


<?php
error_reporting(E_ERROR | E_PARSE);
 require("common.php"); 
 require_once "eventbrite/Eventbrite.php"; 
 

 if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    }
    
    

 
 $_SESSION['location']="create_event.php";
    
    
    if( $_SESSION['user']['linkedinlogin']=="true" ){
    	$logoutlink='<a href="#" onclick="logout()"  style="color:black">Logout</a>';
    }
    else {
    	$logoutlink='<a href="logout.php"  style="color:black">Logout</a>';
    }
   
     
    $firstname=htmlentities($_SESSION['user']['firstname'], ENT_QUOTES, 'UTF-8');
    $lastname=htmlentities($_SESSION['user']['lastname'], ENT_QUOTES, 'UTF-8');
    $nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: 'NULL'; 
    $lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: 'NULL'; 
    $semail=htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8')?: '';  
     
     


$eventnum=0;


$get_access_token = function(){
        if(isset($_SESSION['EB_OAUTH_ACCESS_TOKEN'])){
            return $_SESSION['EB_OAUTH_ACCESS_TOKEN'];
        }else{
            return null;
        }   
    };
    
$save_access_token = function( $access_token ){
        $_SESSION['EB_OAUTH_ACCESS_TOKEN'] = $access_token;
    };   
    
$delete_access_token = function( $access_token=null ){
        unset($_SESSION['EB_OAUTH_ACCESS_TOKEN']);
        
        ob_start(); // ensures anything dumped out will be caught
	// do stuff here
	$url = 'http://www.cardstak.com/eventbuilder.php'; // this can be set based on whatever
	// clear out the output buffer
	while (ob_get_status()) 
	{
		ob_end_clean();
	}
	// no redirect
	header( "Location: $url" );    
        
    };
     

$authentication_tokens = array('app_key'=>$appkey, 
                                             'client_secret'=>$client_secret,
                                             );

$strings = Eventbrite::loginWidget($authentication_tokens,
                                       $get_access_token,
                                       $save_access_token,
                                       $delete_access_token); 
                                       
                                       
$authentication_tokens1 = array('app_key'=>$appkey, 
                                             'client_secret'=>$client_secret,
                                              'access_token'=>$_SESSION['EB_OAUTH_ACCESS_TOKEN']
                                             );

$result = Eventbrite::OAuthLogin($authentication_tokens1);
$eb_client = new Eventbrite( $authentication_tokens1 );

if(isset($_SESSION['EB_OAUTH_ACCESS_TOKEN'])){
	try {
	        $events = $eb_client->user_list_events();
	        //var_dump($events);
	        events_list_to_html( $events );
	        if ($eventnum == 0 ) {$existsevent="false";}
	        else {$existsevent="true";}
	    } catch ( Exception $e ) {
	        //var_dump($e);
	        //$events = array();
	        $existsevent="false";
	    }
} 

if(isset($_SESSION['EB_OAUTH_ACCESS_TOKEN']) && $existsevent=="true"){
	//$todisplay= $strings.'<h1>Events:</h1>'.events_list_to_html( $events ).'<h1>Event Attendee List:</h1>'.attendee_list_to_html( $attendees );
	$todisplay= events_list_to_html( $events );
	$todisplay = '<tr>
				<td>
					<div style="width: 100%;" align="center" >
			    	
					    	<div class="preloader">
						 	<img src="http://cardstak.com/images/builderloader.gif" alt="Loading..."/>
						   	<br>Building Event
						</div>'.
					
					    	 $todisplay
					
						.'
						<div class="createsection">
							<input type="button" onclick="previewEvent();" value="Preview" style="width: 150px;">
							<input type="button" onclick="buildEvent('.$nmemberid.');" value="Create" id="whyaddbt" style="width: 150px;">
						</div>
						
						<div style="
						    font-family: sans-serif;
						    line-height: 17pt;
						    font-size: 12pt;
						    font-weight: 200;
						    list-style-type: none;
						    background-color: white;
						    padding-bottom: 10px;
						    -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;
						">
						  <span style="
						    font: bold 16px/35px arial, sans-serif;
						    background-color: rgb(42, 195, 177);
						    color: white;
						    display: block;
						    margin-bottom: 10px;
						    -webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px;
						">Tips on improving your events:</span>
						  <div style="
						    text-align: left;
						    padding: 10px;
						">
						  <li>Add the <b>following questions</b> to your Eventbrite event registration form</li>
						<ul>
						  <li>Company / Organization</li>
						  <li>Job Title</li>
						  <li>Website / Blog</li>
						  <li>Cell Phone / Work Phone</li>
						  <li>An additional question asking for attendees\' LinkedIn profile URL</li>
						</ul>  
						 
						  
						<li>
						To learn how to create custom questions for attendees on Eventbrite <a style="
						    font-size: 14pt;
						    color: rgb(0, 115, 177);
						    font-weight: normal;" target="_blank" href="http://help.eventbrite.com/customer/portal/articles/426127-how-to-create-custom-questions-for-attendees"> click here </a>
						  </li></div> 
						
						
						</div>
								
				  	 </div>
				</td>
			</tr>
			<tr>
				<td  style="padding-bottom:20px;padding-top:20px" align="center">
						<input type="button" onclick="window.history.back();" align="center" value="Cancel"/>
				</td>
			</tr>
			
			';
			
			
	
	//$params = array('token' => $_SESSION['EB_OAUTH_ACCESS_TOKEN']);
	 
	/*
	$url = 'https://www.eventbriteapi.com/v3/webhooks/';
	$ch = curl_init();                    // initiate curl
	$postf = "endpoint_url=http://www.cardstak.com/query/update_event.php?user_id=".$nmemberid."&actions=order.placed";
	$authorization = "Authorization: Bearer ".$_SESSION['EB_OAUTH_ACCESS_TOKEN'];
	
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
	curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
	curl_setopt($ch, CURLOPT_POSTFIELDS, $postf); // define what you want to post
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
	$output = curl_exec ($ch); // execute
	 
	curl_close ($ch); // close curl handle
	*/
	 	
} 
else if ($existsevent=="false"){
	$todisplay = '<tr>
				<td>
					<div style="width: 100%;" align="center" >
			    			<div style="padding-top:15px;padding-bottom:15px;font:16px/35px arial, sans-serif">
					    	To import an event on Cardstak, you must have an <b>upcoming public event</b> on Eventbrite.<br>To  create an event on Eventbrite<a style="
						    font-size: 14pt;
						    color: rgb(0, 115, 177);
						    font-weight: normal;" target="_blank" href="https://www.eventbrite.com/create"> click here </a>
						    
						</div>
						
						<div style="
						    font-family: sans-serif;
						    line-height: 17pt;
						    font-size: 12pt;
						    font-weight: 200;
						    list-style-type: none;
						    background-color: white;
						    padding-bottom: 10px;
						    -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px;
						">
						  <span style="
						    font: bold 16px/35px arial, sans-serif;
						    background-color: rgb(42, 195, 177);
						    color: white;
						    display: block;
						    margin-bottom: 10px;
						    -webkit-border-top-left-radius: 5px; -webkit-border-top-right-radius: 5px; -moz-border-radius-topleft: 5px; -moz-border-radius-topright: 5px; border-top-left-radius: 5px; border-top-right-radius: 5px;
						">Tips on improving your events:</span>
						  <div style="
						    text-align: left;
						    padding: 10px;
						">
						  <li>Add the <b>following fields</b> to your Eventbrite event registration form</li>
						<ul>
						  <li>Company / Organization</li>
						  <li>Job Title</li>
						  <li>Website / Blog</li>
						  <li>Cell Phone / Work Phone</li>
						  <li>An additional question asking for attendees\' LinkedIn profile URL</li>
						</ul>  
						 
						  
						<li>
						To learn how to create custom questions for attendees on Eventbrite <a style="
						    font-size: 14pt;
						    color: rgb(0, 115, 177);
						    font-weight: normal;" target="_blank" href="http://help.eventbrite.com/customer/portal/articles/426127-how-to-create-custom-questions-for-attendees"> click here </a>
						  </li></div> 
						
						
						</div>
								
				  	 </div>
				</td>
			</tr>
			<tr>
				<td  style="padding-bottom:20px;padding-top:20px" align="center">
						<input type="button" onclick="window.history.back();" align="center" value="Cancel"/>
				</td>
			</tr>
			
			';
}
else{
	$todisplay='<tr>
		<td style="border-bottom: 1px solid #7E7E7E;padding-bottom: 20px;" >
			<div style="font-size: 12pt;color:#A02B4F;font-family: aria,sans-serif;text-align: right;" align="right"> * <span style="color: #4C4C4C;font-size: 10pt;font-style: italic;">indicates required field</span>
                                   		 </div>
					
			<form style="margin-bottom: 2px;">
			<table style="color:#4c4c4c;padding-top:20px">
				<tr>
					<td>
						<label for="eventname" style="margin-right:30px"><span style="font-size:12pt;color:#A02B4F;">*</span> Stak Name</label>
					</td>
					<td>
						<input id="eventname" type="text"  class="inputform" placeholder="Networking Event" maxlength="35"  />
						
					</td>
				</tr>
				
				<tr >
					<td style="padding-top:20px;padding-left:10px">
						<label for="eventdate">Date</label>
					</td>
					<td style="padding-top:20px">
						<input id="eventdate" type="text"  class="inputform"/>
						
					</td>
				</tr>
				<tr style="display:none">
					
					<td>
						<input id="eventnmemberid" type="text" style="display:none"  value="'.$nmemberid.'"/>
						
						<input id="eventlmemberid" type="text" style="display:none" value="'.$lmemberid.'"/>
					</td>	
				</tr>
			
			</table>
			</form>
		</td>	
		
	</tr>
	 
	
	<tr>
		<td style="padding-top:20px">
		
			<table style="color:#4c4c4c">
				 <span class="imageupload" style="font-size:15px;color:#4c4c4c;width:100%;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif" align="right"><b >Recommended</b>: More groups better filter attendees</span>   
				
				<tr>
					<td style="padding-top:20px">
						<label for="eventgroupno" style="margin-right:20px"><span style="font-size:12pt;color:#A02B4F;">*</span> Number of Groups</label>
					</td>
					<td style="padding-top:20px">
						
						<label>	<input type="radio" name="eventgroupno" value="1"  onClick="document.getElementById(\'group1row\').style.display=\'none\';document.getElementById(\'group2row\').style.display=\'none\';document.getElementById(\'group3row\').style.display=\'none\'; " />One</label>
						
						<label><input type="radio" name="eventgroupno" value="2"  onClick="document.getElementById(\'group1row\').style.display=\'\';document.getElementById(\'group2row\').style.display=\'\';document.getElementById(\'group3row\').style.display=\'none\'; " />Two</label>
						
						<label><input type="radio" name="eventgroupno" value="3"  onClick="document.getElementById(\'group1row\').style.display=\'\';document.getElementById(\'group2row\').style.display=\'\';document.getElementById(\'group3row\').style.display=\'\'; " checked/>Three</label>
						
					</td>
				</tr>
				
				<tr id="group1row" >
					<td>
						<label for="group1name" ><span style="font-size:12pt;color:#A02B4F;">*</span> Group 1 name</label>
					</td>
					<td>
						<input id="group1name" type="text"  class="inputform" placeholder="example: Students" maxlength="22"  />
					</td>
				</tr>
				
				<tr id="group2row" >
					<td>
						<label for="group2name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 2 name</label>
					</td>
					<td>
						<input id="group2name" type="text"  class="inputform" placeholder="example: Recruiters" maxlength="22"/>
						
					</td>
				</tr>
				
				<tr id="group3row" >
					<td>
						<label for="group3name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 3 name</label>
					</td>
					<td>
						<input id="group3name" type="text"  class="inputform" placeholder="example: Sponsors" maxlength="22"/>
						
					</td>
				</tr>
			
			</table>
		
		</td>
	
	</tr>
			
			
			
			
	<tr>
		<td>
			<table align="center" style="margin-top:30px" >
				<tr>
					<td  style="padding-bottom:10px" align="center">
						<input type="button" onclick="window.history.back();" align="center" value="Cancel" style="margin-right:40px"/>
				
						<input type="button"  id="createbutton" onclick="myFunction();" align="center" value="Create" />
					</td>
				</tr>
			</table>
		</td>	
	</tr>'; 
}

                                            

function event_to_html( $event ){
    if($event->status=='Live' && $event->privacy=='Public'){
    	
    	global $eventnum;
    	
        $eventnum+=1;
    	
    	return '<li class="n1"><span onclick="prepevent(\''.$event->url.'\', \''.$_SESSION['EB_OAUTH_ACCESS_TOKEN'].'\' , \''.$event->title.'\')" class="eventitem">'.$event->title.'</span></li>';
    	
        //return "<div class='eb_event_list_item'>".$event->status.' '.$event->title.' '.$event->url."</div>\n";
        
        //return "<div class='eb_attendee_list_item'>".var_dump(get_object_vars($attendee))."</div>\n";
    }else{
        return '';
    }
}


 
function events_list_to_html( $events ){
    //$event_list_html = "<div class='eb_event_list'>\n";
    $event_list_html = '<ul class="navigation" onmouseover="showmenu()" onmouseout="hidemenu()">
  				<a class="main" id="selector" href="#url">Select Event</a>';
    if( isset($events->events) ){ 
        //sort the attendee list?
        //usort( $events->events, "sort_events_by_created_date");
        //render the attendee as HTML
        foreach( $events->events as $event ){
            $event_list_html .= event_to_html( $event->event);
            
        }
    }else{
        $event_list_html .= '';
    }   
    return $event_list_html . '</ul>';
}
     
     
     
    
	

/*if (isset($_COOKIE['action'])) {
  // action already done
} else {
  setcookie('action');
  // run query
}*/
//$event="UC Berkeley Networking Event";
//$login="login";
?>

</div>

<div id="top-menu" style="display:none">
        <div class="menu-center">
            <table style="width:100%;border-collapse: collapse;
	border-spacing: 0;font-size: 2.5vw;" cellspacing="0">
                <tr style="height:40px">
                    <td style="width:20%;text-align:center"> <a href="http://www.cardstak.com" style="color:#79a09c">CardStak</a>

                    </td>
                    <td style="width:20%;text-align:center" > <a href="#">Create Stak</a>

                    </td>
                    <td style="width:20%;text-align:center"> <a href="index.php?&page=myevents" style="color:#79a09c" id="event">My Staks</a>

                    </td>
                </tr>
                <tr id="tmenu-bottom" align="right">
                
                    <td class="topbutton"> <?=$logoutlink?>

                    </td>

                </tr>
            </table>
        </div>
    </div>
    




<table class="tablestyle"  align="center">	
	
	<tr>
		<td style="border-bottom: 1px solid #7E7E7E;padding-bottom: 20px;" >
			<div style="font-size: 12pt;color:#A02B4F;font-family: aria,sans-serif;text-align: right;" align="right"> * <span style="color: #4C4C4C;font-size: 10pt;font-style: italic;">indicates required field</span>
                                   		 </div>
					
			<form style="margin-bottom: 2px;">
			<table style="color:#4c4c4c;padding-top:20px">
				<tr>
					<td>
						<label for="eventname" style="margin-right:30px"><span style="font-size:12pt;color:#A02B4F;">*</span> Stak Name</label>
					</td>
					<td>
						<input id="eventname" type="text"  class="inputform" placeholder="Networking Event" maxlength="35"  />
						
					</td>
				</tr>
				
				<tr >
					<td style="padding-top:20px;padding-left:10px">
						<label for="eventdate">Date</label>
					</td>
					<td style="padding-top:20px">
						<input id="eventdate" type="text"  class="inputform"/>
						
					</td>
				</tr>
				<tr >
					<td style="padding-top:20px;padding-left:10px">
						<label>Suggest people<br> to meet<div style="font-size: 9pt;margin-top: 5px;font-weight: 400;font-style: italic;">min 50 cards required</div></label>
					</td>
					<td style="padding-top:20px;">
						<label><input type="radio" name="evtype" value="matcher" style="margin-left:20px" checked />Enabled</label>
						<label><input type="radio" name="evtype" value="basic" style="margin-left:20px" />Disabled</label>
						
					</td>
				</tr>
				
				<tr style="display:none">
					
					<td>
						<input id="eventnmemberid" type="text" style="display:none"  value="<?= $nmemberid ?>"/>
						
						<input id="eventlmemberid" type="text" style="display:none" value="<?= $lmemberid ?>"/>
					</td>	
				</tr>
			
			</table>
			</form>
		</td>	
		
	</tr>
	 
	
	<tr>
		<td style="padding-top:20px">
		
			<table style="color:#4c4c4c">
				 <span class="imageupload" style="font-size:15px;color:#4c4c4c;width:100%;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif" align="right"><b >Recommended</b>: More groups better filter attendees</span>   
				
				<tr>
					<td style="padding-top:20px">
						<label for="eventgroupno" style="margin-right:20px"><span style="font-size:12pt;color:#A02B4F;">*</span> Number of Groups</label>
					</td>
					<td style="padding-top:20px">
						
						<label>	<input type="radio" name="eventgroupno" value="1"  onClick="document.getElementById('group1row').style.display='none';document.getElementById('group2row').style.display='none';document.getElementById('group3row').style.display='none'; " />One</label>
						
						<label><input type="radio" name="eventgroupno" value="2"  onClick="document.getElementById('group1row').style.display='';document.getElementById('group2row').style.display='';document.getElementById('group3row').style.display='none'; " />Two</label>
						
						<label><input type="radio" name="eventgroupno" value="3"  onClick="document.getElementById('group1row').style.display='';document.getElementById('group2row').style.display='';document.getElementById('group3row').style.display=''; " checked/>Three</label>
						
					</td>
				</tr>
				
				<tr id="group1row" >
					<td>
						<label for="group1name" ><span style="font-size:12pt;color:#A02B4F;">*</span> Group 1 name</label>
					</td>
					<td>
						<input id="group1name" type="text"  class="inputform" placeholder="example: Students" maxlength="22"  />
					</td>
				</tr>
				
				<tr id="group2row" >
					<td>
						<label for="group2name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 2 name</label>
					</td>
					<td>
						<input id="group2name" type="text"  class="inputform" placeholder="example: Recruiters" maxlength="22"/>
						
					</td>
				</tr>
				
				<tr id="group3row" >
					<td>
						<label for="group3name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 3 name</label>
					</td>
					<td>
						<input id="group3name" type="text"  class="inputform" placeholder="example: Sponsors" maxlength="22"/>
						
					</td>
				</tr>
			
			</table>
		
		</td>
	
	</tr>
			
			
			
			
	<tr>
		<td>
			<table align="center" style="margin-top:30px" >
				<tr>
					<td  style="padding-bottom:10px" align="center">
						<input type="button" onclick="window.history.back();" align="center" value="Cancel" style="margin-right:40px"/>
				
						<input type="button"  id="createbutton" onclick="myFunction();" align="center" value="Create" />
					</td>
				</tr>
			</table>
		</td>	
	</tr>
	
    
</table>

  <script type="text/javascript" src="js/jscript.newevent.js" > </script>
  <script src="http://www.cardstak.com/js/jscript.eventbuilder.js" type="text/javascript"> </script>   

</body>
    
    
</html>
  
 
 
 