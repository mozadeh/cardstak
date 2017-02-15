<?php
 require("common.php"); 
 
if (isset($_GET['event_id'])) {
	$event_id = $_GET['event_id'];}


if (isset($_GET['event_name'])) {
	$event = $_GET['event_name'];}
	
if (isset($_GET['lard'])) {
	$cardtop = $_GET['card'];
	}
		
if (isset($_GET['preview'])) {
	$preview = "true";
	}	

if (isset($_GET['mobile'])) {
	$mobile = $_GET['mobile'];}
	

$styleSheet = '<link rel="stylesheet" type="text/css" href="style/newmystyle.css">';
$hideonmobile="";
$hideondesktop='style="display:none;"';
	
if ($mobile=='yes'){
	$styleSheet = '<link rel="stylesheet" type="text/css" href="style/newmobilestyle.css">';
	$hideonmobile='style="display:none;"';
	$hideonmobiledisplay='display:none;';
	$hideondesktop='';
}		
	
$_SESSION['location']="index.php"."?event_id=".$event_id;
	
$page="";
if (isset($_GET['page'])) {
	$page = $_GET['page'];
	$_SESSION['location']="index.php"."?event_name=".$event."&event_id=".$event_id."&page=".$page;
	}	

 
 
 $_SESSION['event']=$event_name;
 
 $statsulr = 'http://www.cardstak.com/eventstats.php?event_id='.$event_id;
 
 $useremail='';
 
 $changepass="";
 
 if(htmlentities($_SESSION['user']['linkedinlogin'], ENT_QUOTES, 'UTF-8')=="false"){
	 $changepass="|<a href=\"http://www.cardstak.com/changepassword.php\" style=\"text-decoration:none;color:#DBDBDB\"  >&nbsp;&nbsp;&nbsp;&nbsp;Change Password&nbsp;&nbsp;&nbsp;&nbsp;</a>";
	 }
 
 $nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: ''; 
 $lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: ''; 
 
 if(empty($_SESSION['user'])) 
	    { 
	        $logoutlink='';
	        $createurl="login.php";
	        
	        //$login="<span >Login</span>";
	        //$loginonclick="onclick=\"savecreateSession();window.location.href='login.php';\"";
	        
	        $login="<td class=\"topbutton\"  id=\"loginbutton\" onclick=\"window.location.href='login.php';\">  <span >Login</span> </td>";
	        $savedcards="";
	        
	        $loggedinuserid="<span  style=\"display:none\" id=\"nmemberid\"></span> <span  style=\"display:none\" id=\"lmemberid\"></span>";
	    }
 else{
	  	$createurl="create_card.php"."?event_name=".$event."&event_id=".$event_id;
	  	$useremail=$_SESSION['user']['email'];
	  	$userfullname=$_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];
	  	
	  	//$login="<span id=\"userstak\">Saved Cards</span>";
	  	//$loginonclick="onclick=\"myCards();\"";
	  	
	  	$savedcards="<li id=\"savedcardsbutton\" onclick=\"myCards();\">Saved Cards</li>";
	        $login="";
	        
	  	$loggedinuserid="<span  style=\"display:none\" id=\"nmemberid\">".$nmemberid."</span> <span  style=\"display:none\" id=\"lmemberid\">".$lmemberid."</span>";
	  	if( $_SESSION['user']['linkedinlogin']=="true" ){
		    	$logoutlink='<li onclick="logout()" >Logout</li>';
		    }
		    else {
		    	$logoutlink='<li onclick="nonLinkedInLogout()">Logout</li>';
	   	 }
	  }

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.highlighter.js"></script>
  <script type="text/javascript" language="javascript" src="js/jquery.dotdotdot.js"></script>
  <script type="text/javascript" language="javascript" src="intro/intro.js"></script>
  <script src="js/sweet-alert.js"></script> 
  <script type="text/javascript" src="js/multiple-emails.js"></script>
  
  <link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
  <link href='http://fonts.googleapis.com/css?family=Pathway+Gothic+One' rel='stylesheet' type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
  <?=$styleSheet?>
  <link rel="stylesheet" type="text/css" href="intro/introjs.css">
  <link type="text/css" rel="stylesheet" href="style/multiple-emails.css" />
  
  <script type="text/javascript">
	
		//Plug-in function for the bootstrap version of the multiple email
		$(function() {
			//To render the input device to multiple email input using BootStrap icon
			$('#example_emailBS').multiple_emails({position: "bottom"});
			//$('#example_emailBS').multiple_emails("Bootstrap");
			
			//Shows the value of the input device, which is in JSON format
			$('#current_emailsBS').text($('#example_emailBS').val());
			$('#example_emailBS').change( function(){
				$('#current_emailsBS').text($(this).val());
			});
		});
		
		

  </script>
  
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57633709-1', 'auto');
  ga('send', 'pageview');

</script>

 
 
 <script type="text/javascript" src="https://platform.linkedin.com/in.js">
  api_key: 75d7x1c1fkydj1
  scope: r_basicprofile r_emailaddress 
  onLoad: onLinkedInLoad
  authorize: true
</script>
 
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
  
</head>

<title><?=$event?></title>
<body onload="setupBlocks();" style="background-color:rgb(211, 211, 211)">
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5494e4c2313203f7" async="async">
</script>

<!--<div style="width:0px; height:0px; visibility:hidden; overflow:hidden">
    <img src="http://www.cardstak.com/images/sendcard_black.png" />
</div>-->

<div id="sharebtn" <?=$hideonmobile?> class="sharebtnstyle" > share  Stak</div>
<div id="ranksection" <?=$hideonmobile?> >
	<table>
		<tr>
			</td>
				<div id="rankbtnstyle">your card rank</div>
			</td>
		</tr>
		<tr>
			</td>
				<div id="ranktopdownstyle">top</div>
			</td>
		</tr>
		<tr>
			</td>
				<div id="rankstyle"></div>
			</td>
		</tr>
		<tr  >
			</td>
			       <div id="rankhelpstyle" onclick="startrankintro(); trackActivity('<?=$userfullname?>','<?=$userfullname?>','usetips');"><u>tips</u></div>
			</td>
		</tr>
	</table>	
</div>

    <div style="display:none" id="useremail"><?=$useremail?></div>
    <div style="display:none" id="userfullname"><?=$userfullname?></div>
    <div style="display:none" id="cardtop"><?=$cardtop?></div>
    <div style="display:none" id="displaying">event</div>
    <div style="display:none" id="page"><?=$page?></div>
    <div style="display:none" id="preview"><?=$preview?></div>
    <?=$loggedinuserid?>
    <div style="display:none" id="eventtag"><?=$event?></div>
    <div style="display:none" id="eventid"><?=$event_id?></div>		
    <div id="top-menu" class="topmenustyle" >
     <div class="menuback"> 	
        <div class="menu-center">
            <table style="width:100%;border-collapse: collapse;
	border-spacing: 0;" cellspacing="0">
                <tr style="height:50px">
                    </td>
                    <td style="width:28%;text-align:center;<?=$hideonmobiledisplay?>" id="cardstakbuttontop"> <a target="_blank" href="http://www.cardstak.com" style="padding-right: 5px;"><img src="images/logo-nn.png" border="0" alt="" style="height: 25px;width: 25px;vertical-align: bottom; padding-bottom:2px"></a><a href="http://www.cardstak.com" target="_blank" class="topmenulink">CardStak</a> 
                   
                    <!--<td style="width:28%;text-align:center;" id="cardstakbuttontop"> <a target="_blank" href="http://www.cardstak.com" style="padding-right: 5px;"><img src="images/logo-nnw.png" onmouseover="this.src='images/logo-nn.png'" onmouseout="this.src='images/logo-nnw.png'" border="0" alt="" style="height: 27px;width: 27px;vertical-align: top;"></a><a href="http://www.cardstak.com" target="_blank" class="topmenulink">Cardstak</a>-->
                    
                    </td>
                    <td style="width:44%;text-align:center" id="eventtd" > <div id="event" style="color:#FFFFFF;font-family:'Pathway Gothic One', sans-serif"><?=$event?><span id="spandate" ></span></div>
                    </td>
                    
                    <td style="width:28%;text-align:center;<?=$hideonmobiledisplay?>" id="createbuttontop"> <a href="create_event.php" class="topmenulinkright" id="createstep">Build a Stak</a></td>
                    
                    
                    
                    
			
                    
                </tr> 
                
                </table>
                 </div>
    
       <div id="topmenubottom" style="height:30px">     
	               <table style="width:auto" align="left" >
		               <tr style="height:30px">
		               		
		               		<td class="topbutton" id="showallbuttonback" <?=$hideondesktop?> onclick="removeBios();return false;" >No Bio</td>
			               
			                <td class="g1buttonstyle" id="g1buttonback" onclick="showg1();return false;" > <a id="g1button" href="#" style="text-decoration:none;color:white;vertical-align:middle;"></a></td>
			
			                
			                <td class="g2buttonstyle" id="g2buttonback" onclick="showg2();return false;" > <a id="g2button" href="#"  style="text-decoration:none;color:white;vertical-align:middle;"></a></td>
			                    
			                 <td class="g3buttonstyle" id="g3buttonback" onclick="showg3();return false;"  > <a id="g3button" href="#" style="text-decoration:none;color:white;vertical-align:middle;"></a></td>
			                 
			                  <td class="topbutton" id="showallbutton" onclick="showAll();return false;" > &nbsp;All&nbsp;</td>
			                 
				
				</tr>	
	                 </table>
	                 
	                  <table style="width:auto" align="left" id="searchtable">
		               <tr style="height:30px">
		               
			                
			                <td class="searchtd" id="search" onclick="" > 
			                
			                	<textarea rows="1" id="searchquery" cols="30" class="searchbar" placeholder="search cards" onkeypress="onTestChange(event);"></textarea>
			                
			                	<img id="searchbutton" src="images/search_icon.png" class="searchbutton" onclick="search();">
			                </td>
			                
				
				</tr>	
	                 </table>
	               
	              
	               <table style="width:auto" align="right">
		               <tr style="height:30px">
		               
		               		 <td class="topbutton" style="display:none;" id="helpbutton" onclick="starthelpintro();  trackActivity('<?=$userfullname?>','<?=$userfullname?>','usehelp');">Help</td>
		               
			                 <td class="topbutton" id="backbutton" style="display:none;" onclick="goBack();"> Back</td>
			                 
			                  <td class="topbutton" id="statsbutton" onclick="window.open('<?=$statsulr?>','_blank'); trackActivity('<?=$userfullname?>','<?=$userfullname?>','getstats');" >   <img src="http://www.cardstak.com/images/wgraph1.png" style="height: 21px;margin-right: 4px;vertical-align:inherit"><span style="vertical-align:inherit">Stak Stats</span></td> 
			                 
			                 <td class="topbutton" id="addcardbutton" onclick="showloginalert();"  > Add Card</td>                 
			                
			                <?=$login?>
			                
			                
			                
			                 <td id="menuwrapper">
			                  	
						    <ul>
						        <li>Account <span style="font-size:9pt">&#9660;</span>
						            <ul>
						                <?=$savedcards?>
						                <li id="myeventsbutton" onclick="myEvents();">My Staks</li>
						                <?=$logoutlink?>
						                
						                 
						            </ul>
						        </li>
						    </ul>
						
			                  </td>
				
				</tr>	
	                 </table>
                   
          </div>
         </div>  
         
         	<!--<div id="boardmenu" style="height:30px;display:none">     
	
		               <table style="width:auto;border-spacing: 0" id="toggletable" align="left">
			               <tr style="height:30px">
				                 
				                
				                <td class="topbutton" onclick="downloadData();" id="boardtoggle" style="background:linear-gradient(to right, #5F5F5F 0%, #353535 100%);color:white;width:350px;text-align:center;border-top: 2px solid #A3A3A3;border-bottom-right-radius:50px">download contact sheet <span class="fourtha">&#10095;</span><span class="thirda">&#10095;</span><span class="seconda">&#10095;</span><span class="firsta">&#10095; </span></td>
				               </tr>	
		                 </table>  

		                 
		                  
	          </div>-->
  
         </div>  
         
         
    <div id="contactbackground" class="contact_overlay" onclick="closeContact();" ></div>        
    <div class="contact" id="contact" >
    	<form method="post" action="contact.php" name="contactform" id="contactform" class="form c-form contactbox" >
			 <fieldset style="text-align:center;border:0px;padding-top:10px;padding-bottom:20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10pt;font-weight:300;">
				<table align="center"><tr><td><span style="font-size:16pt;padding-bottom:20px">sending Email to</span>
				<b style="font-size:16pt;padding-bottom:20px;" id="contactname">Firstname Lastname</b></td>
				<td id="contactpicture"><div style="background-image: url('http://www.cardstak.com/images/profilepics/profile_picture_2927.jpg');" class="commentpicture"></div></td></td></table>
				<table  style="margin-top:20px;width:100%;border-spacing:0px"><tr style="vertical-align:baseline;display:none"><td style="width:65px">
				<label for="contactemailfrom" style="font-weight:bold">From:</label>
				</td><td>
				<input name="contactemailfrom" type="text" id="contactemailfrom" placeholder="Your E-mail"/>
				</td>
				<td style="display:none">
				<input name="contactemailto" type="text" id="contactemailto" placeholder="E-mail to"/>
				</div>
				</td>
				</tr></table>
				<table  style="width:100%;border-spacing:0px">
				<tr style="display:none"><td style="width:65px;padding-bottom:10px">
				<label for="contactsubject" style="font-weight:bold">Subject:</label>
				</td><td>
				<input name="contactsubject" type="text" id="contactsubject" placeholder="Subject" />
				</td></td><tr><td>
				<textarea name="contactmessage" id="contactmessage" placeholder="Example: We should meet" style="height:80px;margin:0px"></textarea>
				</td></tr></table>
				<input type="button" onclick="closeContact();" value="cancel"  style="width:100px;margin-bottom:0px"/>
				<input type="button" onclick="sendEmail();" id="contactsendemail" value="send" style="width:100px;margin-bottom:0px"/>
				
			</fieldset>
			</form>
			
			<!--<form method="post" action="contact.php" name="contactform" id="contactform" class="form c-form contactbox" >
			 <fieldset style="text-align:center;border:0px;padding-top:10px;padding-bottom:20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10pt;font-weight:300;">
				<table align="center"><tr><td><span style="font-size:16pt;padding-bottom:20px">Email Address:</span>
				<b style="font-size:16pt;padding-bottom:20px;" id="contactname">Firstname Lastname</b></td>
				<td id="contactpicture"><div style="background-image: url('http://www.cardstak.com/images/profilepics/profile_picture_2927.jpg');" class="commentpicture"></div></td></td></table>
				<table  style="margin-top:20px;width:100%;border-spacing:0px"><tr style="vertical-align:baseline"><td style="display:none">
				<input name="contactemailfrom" type="text" id="contactemailfrom" placeholder="Your E-mail"/>
				</td>
				
				<td>
				<input name="contactemailto" type="text" id="contactemailto" placeholder="E-mail to"/>
				</div>
				</td>
				</tr></table>
				<table  style="width:100%;border-spacing:0px">
				<tr style="display:none"><td style="width:65px;padding-bottom:10px">
				<label for="contactsubject" style="font-weight:bold">Subject:</label>
				</td><td>
				<input name="contactsubject" type="text" id="contactsubject" placeholder="Subject" />
				</td></td><tr style="display:none"><td>
				<textarea name="contactmessage" id="contactmessage" placeholder="Example: We should meet" style="height:80px;margin:0px"></textarea>
				</td></tr></table>
				<input type="button" onclick="closeContact();" value="cancel"  style="width:100px;margin-bottom:0px"/>
				<input type="button" onclick="sendEmail();" id="contactsendemail" value="send" style="width:100px;margin-bottom:0px;display:none"/>
				
			</fieldset>
			<div align="right" style="font-size:14pt;padding-right:20px;padding-bottom:10px;color:black;padding-top:10px"><i style="vertical-align:bottom">use another Email service</i> <a id="gmailcontact" href="#" target="_blank" class="dont_open"> <img style="height: 50px;vertical-align: middle;padding-left:10px" src="images/gmail_icon.png"></a> <a id="yahoocontact" href="#" target="_blank" class="dont_open"> <img style="height: 50px;vertical-align: middle;padding-left:10px" src="images/yahoo_icon.png"></a></div>
			</form>-->
			
	
			
	
	
    
    </div>
    
    
    
    
    
    
           
   
    
    
    
    
    
    
         
    <div id="wizardbackground" class="wizard_overlay" onclick="closeWizard();" ></div>        
    <div class="wizard" id="wizard" onclick="closeWizard();">
    <table style="margin-left:5px">
    <tr>
	    
	    <td> 
	    	<IMG SRC="images/rightbr.png" style="height:30px;width:71px" id="leftbr">
	    </td>
	    
	    <td > 
	    	<IMG SRC="images/leftbr.png" style="height:30px" id="rightbr">
	    </td>
    </tr>
    </table>
    <table id="wizardtext" style="padding-left:5px"> 
    <tr >
	    
	    <td style="padding:0;margin:0;text-align:left;display:inherit"> 
	    	<IMG SRC="images/nobio.png" style="height:75px"  id="nobiotext">
	    </td>
	    <td style="width:100%"> 
	    	<IMG SRC="images/roles.png" style="height:75px" id="rolestext">
	    </td>
    </tr>
    </table>
    <IMG SRC="images/bottomwizard.png" style="width:772px;cursor: pointer">
    </div>
    <div  id="mainbody">
    <!-- Create multiple versions of this with different content -->
    <div style="width: 100%;position: fixed;top: 300px;padding-left: auto;" >
    	<!--<IMG SRC="images/loader3.gif" class="loader">-->
    	<div class="sk-folding-cube">
	  <div class="sk-cube1 sk-cube"></div>
	  <div class="sk-cube2 sk-cube"></div>
	  <div class="sk-cube4 sk-cube">CS</div>
	  <div class="sk-cube3 sk-cube" ></div>
	</div>
   </div>
 <!-- end of mainbodydiv -->
    </div>
    
    <div class="bottombar" id="bottombar">
    	<a href="http://www.cardstak.com/#sharing" style="text-decoration:none;color:#DBDBDB"  target="_blank">How It Works&nbsp;&nbsp;&nbsp;&nbsp;</a>|<a href="http://www.cardstak.com/#about" style="text-decoration:none;color:#DBDBDB"  target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;About Cardstak&nbsp;&nbsp;&nbsp;&nbsp;</a><?=$changepass?>|<a href="http://www.cardstak.com/#contact" style="text-decoration:none;color:#DBDBDB"  target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;Send Feedback</a></a></td>
    </div>
 
    <!-- Chat stuff -->
       
    <div id="commentbackground" class="black_overlay" onclick="closeComment();"></div>
    <div id="commentbox" class="white_content" align="center">
        <form >
            <table>
                <tr>
                    <td>
                        <table style="padding:10px 20px 20px 10px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-weight: 300;">
                            <tr>
                                <td>
                                    <div id="commentnoteid" class="commentnote"></div>
                                    
                                    <div id="commentcardrole" style="margin-top:10px;font-size:12pt"></div><span id="commentcardevent" style="font-size:12pt"></span>
                                </td>
                                <td>
                                    <div id="commentpicture" class="commentpicture"></div>
                                    <div id="commentcardid" style="display:none"></div>
                                    <div id="commentcardsaved" style="display:none"></div>
                                    <div id="commentcardname" style="display:none"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea id="commentspace" class="input" name="comment" rows="6" placeholder="Add a note (optional) &#13;&#10;&#13;&#10;Example: we talked during the event and I was asked to email my resume"></textarea>
                    </td>
                </tr>
            </table>
            <input type="button" onclick="closeComment();" value="cancel"></input>
            <input type="button" onclick="deleteCard(event);" id="deletecardbutton" value="delete" style="display:none"></input>
            <input type="button" onclick="saveCard(event);" id="savecardbutton" value="save"></input>
        </form>
    </div>
    
    
    <div id="phonebackground" class="black_overlay" onclick="closePhone();"></div>
    <div id="phonebox" class="white_content_phone" align="center">
        <table>
            <tr>
                <td align="center" id="phoneboxnumber">408-667-9312</td>
            </tr>
            <tr>
                <td align="center">
                    <input type="button" onclick="closePhone();" value="ok" align="right"></input>
                </td>
            </tr>
        </table>
    </div>
   
    
    
    
    
    <div id="sendcardbackground" class="black_overlay_sendcard" onclick="closeSendcard();"></div>
    <div id="sendcardbox"  class="white_content_sendcard" align="center">
        
        
	<div class='container'>
		<div class='row'>
			<div style="font-size: 16pt;margin-bottom: 15px;font-weight: 400;">Email Your Card</div>
			<div class='form-group'>
				<div class='col-sm-4'>
					<div style="margin-bottom: 10px;">enter email addresses</div>
					<input type='text' id='example_emailBS' name='example_emailBS' class='form-control' value=''>
				</div>
				<div class='col-sm-offset-2 col-sm-4' style="display:none;">
					<h4>Current email addresses</h4>
					<pre id='current_emailsBS'></pre>
				</div>
			</div>
		</div>
	</div>
	
	 <input type="button" onclick="closeSendcard();" value="cancel" id="cancelsendcardbutton"></input>
         <input type="button" onclick="sendCard();"  value="add" id="sendcardbutton"></input>

    </div>
    
    
    <div class="blur_background" id="blurbackground"  onclick="closeJoin();" style="display:none" ></div>        
	    <div class="blur_display" id="blurdisplay"  style="display:none" >
	    			
				 <fieldset style="text-align:center;border:0px;padding-top:10px;padding-bottom:20px;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;font-size:10pt;font-weight:300;">
				 	<a href="http://www.cardstak.com" class="introicon"></a>
					<table style="width:100%;">
						<tr>
							<td  style="font-size:13pt;padding-top:10px;padding-bottom:10px;border-bottom: 1px solid black;">
								Login to view Stak
							</td>
						</tr>
						<tr>
							<td style="font-size:11pt;padding-top:10px">
								 Add your card to interact with others and we&#39;ll suggest some people to meet based on your interests
							</td>
						</tr>
						
					</table>
					
					<div onclick="LogIn();" class="btn" style="margin-top:20px">Login<div>
					
					
				</fieldset>
				
	   </div>
   </div>
    
    
<!--<div id="whybackground" class="black_overlay" onclick="closeWhy();"></div>
	    <div id="whybox" class="whybox"  onclick="closeWhy();">
	    <div style="font-family: 'Pathway Gothic One', sans-serif;font-size: 27pt;color: white;margin-bottom: 10pt;">Add Your Card</div>
	    <div class="btable bsize" align="center">
	        <div class="cell1">
	            <table class="btable">
	                <tr>
	                    <td class="benefiticon"> <i class="fa fa-street-view fa-4x"></i>
	
	                    </td>
	                </tr>
	                <tr>
	                    <td class="benefit">Make People Come to You</td>
	                </tr>
	                <tr>
	                    <td class="benefitdesc">Write why you are attending the event on your card and interested people will make sure to talk to you at the event.</td>
	                </tr>
	            </table>
	        </div>
	        <div class="cell2">
	            <table class="btable">
	                <tr>
	                    <td class="benefiticon"> <i class="fa fa-briefcase fa-4x"></i>
	
	                    </td>
	                </tr>
	                <tr>
	                    <td class="benefit">Get Offers</td>
	                </tr>
	                <tr>
	                    <td class="benefitdesc">Recruiters and investors attend events and it’s common for attendees who placed their card to receive interview requests.</td>
	                </tr>
	            </table>
	        </div>
	        <div class="cell3">
	            <table class="btable">
	                <tr>
	                    <td class="benefiticon"> <i class="fa fa-comments fa-4x"></i>
	
	                    </td>
	                </tr>
	                <tr>
	                    <td class="benefit">Join The Conversation</td>
	                </tr>
	                <tr>
	                    <td class="benefitdesc">By adding your card, you can message other users and send quick hellos.</td>
	                </tr>
	            </table>
	        </div>
	    </div>
	<div style="margin-top: 20px;"><input type="button" id="whyaddb" onclick="skipwiz();" value="skip tutorial" style="width: 150px;">
	<input type="button" value="show tutorial" id="whyaddbt" style="width: 150px;"></div>  
	</div>
    
   --> 
    
    
    
    
    <script src="js/jquery.newmo.js" type="text/javascript"> </script>
    
    
</body>
    
    
    
    
  </html>