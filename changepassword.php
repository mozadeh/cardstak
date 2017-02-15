<?php 

    // First we execute our common code to connection to the database and start the session 
    require("common.php"); 
    

    

     if(!empty($_SESSION['location'])) 
     { 
        $goto=$_SESSION['location'];
     } 
    else{
    	$goto="index.php?&page=myevents";
    }

    
     if(!empty($_SESSION['user'])) 
    { 
        if( $_SESSION['user']['linkedinlogin']!="false" ){
     
        header("Location: ".$goto); 
         
        die("Redirecting to ".$goto);
        } 
    } 
       
    // This if statement checks to determine whether the login form has been submitted 
    // If it has, then the login code is run, otherwise the form is displayed 
   
     
?>

<html> 




<title>Cardstak:Change Password</title>

<head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
<script src="js/sweet-alert.js"></script> 
<link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
<link href='http://fonts.googleapis.com/css?family=Pathway+Gothic+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="style/loginstyle.css">

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






<body >







 <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600' rel='stylesheet' type='text/css'>


<div class="testbox" style="width:500px">
<div class="top" align="center" >
<!--Change Password<br>
<b style="color:#2B8BC0;font-size:32px">Network Better</b>-->
</div>
      
    <table style="width: 100%;text-align: center;">

        <tr >
            	<td style="padding-bottom:10px">
            <h1 style="text-align: -webkit-center;margin-left: 0px;"><b>Change Password</b></h1>
            	</td>
            </tr>
           <tr >
               <td>
    <form id="loginForm"   name="login"> 
    	 <tr >
          	<td  style="padding-bottom:20px;padding-top:10px">
	<input id="oldpassword" type="password" name="oldpassword"  placeholder="Old Password"/> 
		</td>
         </tr>
          <tr >
          	<td  style="padding-bottom:20px;padding-top:10px">
	<input id="newpassword" type="password" name="newpassword"  placeholder="New Password"/> 
		</td>
         </tr>
          <tr >
          	<td  style="padding-bottom:20px;padding-top:10px">
	<input id="confirmnewpassword" type="password" name="confirmnewpassword" placeholder="Confirm New Password" /> 
		</td>
	</tr>	
	
	<tr >
          	<td  style="padding-bottom:20px;padding-top:10px">
			
			<input type="button" onclick="goBack();" value="Back" name="back" style="float: none;margin-left:0"/> 
			
			<input type="button" onclick="changepasswordattempt();" value="Change" name="change" style="float: none;"/>
		</td>
         </tr>
	
</form> 
        
    


      
</div>   






<script src="js/jscript.changepassword.js" type="text/javascript"> </script>
    



</body>
</html>