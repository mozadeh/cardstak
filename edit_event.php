<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script src="js/sweet-alert.js"></script> 
  <link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
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
  
  
  <title>Edit Event</title>
  
  


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

  


<?php
error_reporting(E_ERROR | E_PARSE);
 require("common.php"); 
 

 if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        die("Redirecting to login.php"); 
    }
    
   if (isset($_GET['event_id'])) {
	$eventid = $_GET['event_id'];}


   if (isset($_GET['event_name'])) {
	$event = $_GET['event_name'];} 

 
 $_SESSION['location']="create_event.php";
    
    
    if( $_SESSION['user']['linkedinlogin']=="true" ){
    	$logoutlink='<a href="#" onclick="logout()"  style="color:black">Logout</a>';
    }
    else {
    	$logoutlink='<a href="logout.php"  style="color:black">Logout</a>';
    }
   
     
    $firstname=htmlentities($_SESSION['user']['firstname'], ENT_QUOTES, 'UTF-8');
    $lastname=htmlentities($_SESSION['user']['lastname'], ENT_QUOTES, 'UTF-8');
    $nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: 'NULLMEMBERID'; 
    $lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: 'NULLMEMBERID'; 
    //$eventid=htmlentities($_SESSION['eventid'], ENT_QUOTES, 'UTF-8');
    //$eventid='114';
    //$event='salam';
    $semail=htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8')?: '';  
     
    
	

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
                    <td style="width:20%;text-align:center"> <a href="http://www.cardstak.com" style="color:#79a09c">Cardstak</a>

                    </td>
                    <td style="width:20%;text-align:center" > <a href="#">Edit Event</a>

                    </td>
                    <td style="width:20%;text-align:center;display:gone"> <a href="index.php?event_name=<?=$event?>&event_id=<?=$eventid?>" style="color:#79a09c" id="event"><?=$event?></a>

                    </td>
                </tr>
                <tr id="tmenu-bottom" align="right">
                
                    <td class="topbutton"> <?=$logoutlink?>

                    </td>
                    <!--<td class="topbutton"> <a id="biobutton" href="#" onclick="removeBios();" style="color:black">Hide Bios</a>

                    </td>
                    <td class="topbutton"> <a href="#" onclick="removeBios();" style="color:black">Create Event</a>

                    </td>-->
                </tr>
            </table>
        </div>
    </div>




<table class="tablestyle"  align="center">
	<tr>
		<td style="border-bottom: 1px solid #7E7E7E;padding-bottom: 20px;" >
			<div style="font-size: 12pt;color:#A02B4F;font-family: aria,sans-serif;text-align: right;" align="right"> * <span style="color: #4C4C4C;font-size: 10pt;font-style: italic;">indicates required field</span>			
					
			<form style="margin-bottom: 2px;">
			<table style="color:#4c4c4c;padding-top:20px">
				<tr>
					<td>
						<label for="eventname" style="margin-right:30px"><span style="font-size:12pt;color:#A02B4F;">*</span> Stak Name</label>
					</td>
					<td>
						<input id="eventname" type="text" class="inputform" placeholder="Networking Event" maxlength="35"  />
						
					</td>
				</tr>
				
				<tr >
					<td style="padding-top:20px;padding-left:10px">
						<label for="eventdate">Date</label>
					</td>
					<td style="padding-top:20px">
						<input id="eventdate" type="text" class="inputform"/>
						
					</td>
				</tr>
				<tr style="display:none">
					
					<td>
						<input id="eventnmemberid" type="text" style="display:none"  value="<?=$nmemberid?>"/>
						
						<input id="eventlmemberid" type="text" style="display:none" value="<?=$lmemberid?>"/>
						
						<input id="eventid" type="text" style="display:none" value="<?=$eventid?>"/>
						
						<input id="eventid" type="text" style="display:none" value="<?=$eventid?>"/>
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
						
						<label>	<input type="radio" id="radio1" name="eventgroupno" value="1"  onClick="document.getElementById('group1row').style.display='none';document.getElementById('group2row').style.display='none';document.getElementById('group3row').style.display='none'; " checked/>One</label>
						
						<label><input type="radio" id="radio2" name="eventgroupno" value="2"  onClick="document.getElementById('group1row').style.display='';document.getElementById('group2row').style.display='';document.getElementById('group3row').style.display='none'; "/>Two</label>
						
						<label><input type="radio" id="radio3" name="eventgroupno" value="3"  onClick="document.getElementById('group1row').style.display='';document.getElementById('group2row').style.display='';document.getElementById('group3row').style.display=''; " />Three</label>
						
					</td>
				</tr>
				
				<tr id="group1row" style="display:none">
					<td>
						<label for="group1name" ><span style="font-size:12pt;color:#A02B4F;">*</span> Group 1 name</label>
					</td>
					<td>
						<input id="group1name" type="text" class="inputform" placeholder="example: Students" maxlength="22"  />
					</td>
				</tr>
				
				<tr id="group2row" style="display:none">
					<td>
						<label for="group2name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 2 name</label>
					</td>
					<td>
						<input id="group2name" type="text" class="inputform" placeholder="example: Recruiters" maxlength="22"/>
						
					</td>
				</tr>
				
				<tr id="group3row" style="display:none">
					<td>
						<label for="group3name"><span style="font-size:12pt;color:#A02B4F;">*</span> Group 3 name</label>
					</td>
					<td>
						<input id="group3name" type="text" class="inputform" placeholder="example: Sponsors" maxlength="22"/>
						
					</td>
				</tr>
			
			</table>
		
		</td>
	
	</tr>
			
			
			
			
	<tr>
		<td>
			<table align="center" style="margin-top:30px;margin-bottom:20px" >
				<tr>
					<td  style="padding-bottom:10px" align="center">
						<input type="button" onclick="window.history.back();" align="center" value="Cancel" style="margin-right:40px"/>
				
						<input type="button"  onclick="myFunction();" align="center" value="Update" />
					</td>
				</tr>
			</table>
		</td>	
	</tr>
	
    
</table>

  <script type="text/javascript" src="js/jscript.editevent.js" > </script>

</body>
    
    
</html>
  
 
 
 