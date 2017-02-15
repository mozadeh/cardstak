<?php 

// First we execute our common code to connection to the database and start the session 
require("common.php"); 
require_once "eventbrite/Eventbrite.php"; 

$useremailinitial='';
if(!empty($_SESSION['location'])) 
{ 
	$goto=$_SESSION['location'];
} 
else{
	$goto="index.php?&page=myevents";
}

// This variable will be used to re-display the user's username to them in the 
// login form if they fail to enter the correct password.  It is initialized here 
// to an empty value, which will be shown if the user has not submitted the form. 

if(!empty($_SESSION['user'])) 
{ 
	// If they are not, we redirect them to the login page.
	if( $_SESSION['user']['linkedinlogin']=="false" ){
		
		header("Location: ".$goto); 
		 
		// Remember that this die statement is absolutely critical.  Without it, 
		// people can view your members-only content without logging in. 
		die("Redirecting to ".$goto);
	} 
} 

$submitted_username = ''; 

// This if statement checks to determine whether the login form has been submitted 
// If it has, then the login code is run, otherwise the form is displayed 

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

$appkey="DMASKB3LYZJJUCOEWP";    


$authentication_tokens = array('app_key'=>$appkey, 
                                     'client_secret'=>'OUKFFEMXBUMPMLV4SJYSXGPO54YOFLVHG2VW6W4FE7WRF5LGOM',
                                     );

$strings = Eventbrite::loginWidget($authentication_tokens,
                               $get_access_token,
                               $save_access_token,
                               $delete_access_token);                                
	                                     

if(isset($_SESSION['EB_OAUTH_ACCESS_TOKEN'])){
	//echo var_dump($_SESSION['EB_OAUTH_ACCESS_TOKEN']);
	
	$authentication_tokens1 = array('app_key'=>$appkey, 
                                             'client_secret'=>'VVECR3EUALYA7YJQW52MTJYPA252YYRZ36KRKL7ITCKVY5X57N',
                                              'access_token'=>$_SESSION['EB_OAUTH_ACCESS_TOKEN']
	                                             );	
	$result = Eventbrite::OAuthLogin($authentication_tokens1);
	$evemail = $result[user_email];
	$evfullname = $result[user_name];
	$ebtoken = $_SESSION['EB_OAUTH_ACCESS_TOKEN'];
	
	$sessionvalue = [
		"email" => $evemail,
		"fullname" => $evfullname
		]; 

	$_SESSION['user'] = $sessionvalue; 
	
	//$result = '<b>welcome</b><br>user email: '.$result[user_email].' user name:'.$result[user_name].'<br>';
	//echo $result;
}     
?>

<html> 



<title>Login</title>


<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
<script src="js/sweet-alert.js"></script> 
<link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
<link href='http://fonts.googleapis.com/css?family=Pathway+Gothic+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="http://cardstak.com/style/loginstyle.css">

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57633709-1', 'auto');
  ga('send', 'pageview');

</script>


<!-- 1. Include the LinkedIn JavaScript API and define a onLoad callback function -->
  
<script type="text/javascript" src="https://platform.linkedin.com/in.js">
  api_key: 75d7x1c1fkydj1
  scope: r_basicprofile r_emailaddress 
  onLoad: onLinkedInLoad
  authorize: true
</script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">

</head>


<script type="text/javascript">
  // 2. Runs when the JavaScript framework is loaded
   // 2. Runs when the JavaScript framework is loaded
  function onLinkedInLoadButton(){
  	IN.UI.Authorize().place(); 
  	onLinkedInLoad();
  } 
	   
  function onLinkedInLoad() {
       	
    IN.Event.on(IN, "auth", onLinkedInAuth);
  }

  // 2. Runs when the viewer has authenticated
  function onLinkedInAuth() {
     var fields = ['id','first-name', 'last-name', 'headline','picture-urls::(original)', 'picture-url','summary','email-address','public-profile-url','phone-numbers'];
    IN.API.Profile("me").fields(fields).result(displayProfiles);
  }

  // 2. Runs when the Profile() API call returns successfully
  function displayProfiles(profiles) {
    member = profiles.values[0];
    //alert(JSON.stringify(member, null, 4));
    //alert(member.join('\n'));
    
    
    var email = member.emailAddress;
    var firstname =  member.firstName;
    var lastname =   member.lastName;
    var bio =  member.summary;
    //var picurl =  member.pictureUrl;
    var picurl =  member.pictureUrls.values;
    var linkedinurl =  member.publicProfileUrl;
    var lmemberid =  member.id;
    var title = member.headline;
    
    var dataString = 'email=' + email + '&picurl=' + picurl + '&firstname=' + firstname + '&lastname=' + lastname + '&title=' + title + '&bio=' + bio + '&linkedinurl=' + linkedinurl + '&lmemberid=' + lmemberid;

	//alert(dataString);
	// AJAX code to submit form.
	$.ajax({
	type: "POST",
	url: "query/linkedinloginquery.php",
	data: dataString,
	cache: false,
	success: function(result) {
	//alert(result);
		}
	});
    
    sweetAlert("We're in!", "Login successful" , "success");
    setInterval(gotoURL, 1500);
  } 
  
  
 

</script>





<body >

<div style="display:none" id="evemail"><?=$evemail?></div>
<div style="display:none" id="evfullname"><?=$evfullname?></div>
<div style="display:none" id="ebtoken"><?=$ebtoken?></div>

<div style="display:none;">
	<img src="http://cardstak.com/images/Sign-In-Large---Hover.png" width="1" height="1" border="0" alt="Image 01">
	<img src="http://cardstak.com/images/Sign-In-Large---Active.png" width="1" height="1" border="0" alt="Image 02">
	<img src="http://cardstak.com//images/evsignin.png" width="1" height="1" border="0" alt="Image 01">
	<img src="http://cardstak.com//images/evsignin-hover.png" width="1" height="1" border="0" alt="Image 02">
</div>



 <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>

<a href="http://www.cardstak.com" style="text-decoration:none">
<div class="testbox"><a href="http://www.cardstak.com" style="text-decoration:none">
<div class="top" style="text-align: right;padding-right: 20px;"> 
CardStak.com<br>

</div></a>
      
    <table style="width:100%">
	
	
	
	<tbody><tr>
	       <!-- <td style="color:#4c4c4c;font-size:32px;font-family:'Open Sans', sans-serif">
	        		<h1>
<b>Recommended</b>
</h1> -->
	        </td>
        </tr>
        <tr align="center">
            <td style="padding-bottom:10px">
            
            	<img onclick="onLinkedInLoadButton()" class="linkedinbutton" src="http://cardstak.com/images/Sign-In-Large---Default.png" onmouseover="hover(this);" onmouseout="unhover(this);" style="padding-top:20px"  >
            	
            	<!-- <table>
            		<tbody><tr>
            			<td style="font-size: 17pt;">
              				 Attendees
                		</td>
                		<td style="padding-left: 50px;font-size: 17pt;">
               				Organizers
                		</td>
                	</tr>
            		<tr>
            			<td>
                <img onclick="onLinkedInLoadButton()" class="linkedinbutton" src="http://cardstak.com/images/Sign-In-Large---Default.png" onmouseover="hover(this);" onmouseout="unhover(this);">
                		</td>
                		<td style="padding-left: 50px;">
                <a href="https://www.eventbrite.com/oauth/authorize?response_type=code&amp;client_id=<?=$appkey?>"><img src="http://cardstak.com/images/evsignin.png" class="eventbritebutton" onmouseover="evhover(this);" onmouseout="evunhover(this);"></a>
                		</td>
                	</tr>
                	
                </tbody>
                
                </table> -->	
                
                </td>  
                
            </tr>
	
	<tr>
		<td>
		
			<hr>
			    <div style="color:blue" id="loginmessage" align="center">&nbsp;</div> 
			    <h1 style="padding-bottom:5px"><b>Sign In</b></h1>
			    
				    
				<form id="loginForm" name="login" style="padding-bottom:10px">  
					<input id="email" type="text" name="email" value="" placeholder="Email"> 
					
					<input id="password" type="password" name="password" value="" placeholder="Password"> 
					<input id="firstname" type="hidden" name="firstname" value=""> 
					<input id="lastname" type="hidden" name="lastname" value=""> 
					<input id="title" type="hidden" name="title" value="">
					<input id="bio" type="hidden" name="bio" value="">  
					<input id="picurl" type="hidden" name="picurl" value=""> 
					<input id="linkedinurl" type="hidden" name="linkedinurl" value="">  
					<input id="memberid" type="hidden" name="memberid" value="">  
					<input id="goto" type="hidden" name="memberid" value="<?=$goto?>">  
					<input id="linkedinlogin" type="hidden" name="linkedinlogin" value="false"> 
					<input type="button" value="Login" onclick="loginattempt();" name="loginsubmit"> 
				</form>  
		
				
			<div style="text-align:center;padding-top:10px"><a href="forgotpassword.php" style="color:#4c4c4c;font-size:18px; text-decoration:none">Forgot Password</a></div>

		
		</td>
	</tr>
	
	
	
	
        <tr>
        
            	<td style="padding-bottom:5px;padding-top: 10px;">
            	<hr>      
            <h1><b>Register</b></h1>
            	</td>
            </tr>
           <tr>
               <td>
    			  
		<form name="register"> 
		   <table style="width:100%">
		      <tbody><tr>
		          <td style="padding-bottom:20px;">
		    <input type="text" id="registerfirstname" name="registerfirstname" value="" placeholder="First Name">
		              <input type="text" id="registerlastname" name="registerlastname" value="" placeholder="Last Name" stye="padding-left:40px;"> 
		          </td>
		          
		       </tr>
		       <tr>
		           <td style="padding-bottom:10px">
		    <input type="text" name="registeremail" id="registeremail" value="" placeholder="Email">     
		    <input type="password" name="registerpassword" id="registerpassword" value="" placeholder="Password">          
		    <input type="button" onclick="registerattempt();" value="Register" name="registersubmit"> 
		           </td>
		       </tr>
		       <tr>
		       	   <td>
		       	   	<div style="text-align:center;padding-top:10px;">By logging in or registering on Cardstak you agree to <a href="terms.html" target="_blank" style="color: #0073B1;font-size: 12pt; text-decoration:none;">Cardstak Terms</a></div>
		       	   </td>
		       </tr>
		    </tbody></table>
		</form>
		    

               </td>
        </tr>
        
            
    </tbody></table>
    
    
    
	    
	 

      
</div>






<script src="js/jscript.login.js" type="text/javascript"> </script>
    



</body>
</html>