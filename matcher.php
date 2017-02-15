<?php

if (isset($_GET['event_id'])) {
	$event_id = $_GET['event_id'];}
	
if (isset($_GET['card_id'])) {
	$card_id = $_GET['card_id'];}	
	

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Suggest People to Meet</title>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="js/sweet-alert.js"></script> 
    <link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
    <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/magicsuggest.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://nicolasbize.com/magicsuggest/tutorial/3/css/style.css">
    <style>   		
	input[type=button] {
	    font-size: 14px;
	  font-weight: 600;
	  color: white;
	  padding: 6px 15px 6px 15px;
	  margin-left:10px;
	  margin-top:5px;
	  display: inline-block;
	  float: center;
	  text-decoration: none;
	  width: 120px; height: auto; 
	  -webkit-border-radius: 5px; 
	  -moz-border-radius: 5px; 
	  border-radius: 5px; 
	    border:none;
	  background-color: #0073b1; 
	  -webkit-box-shadow: 0 3px rgba(58,87,175,2); 
	  -moz-box-shadow: 0 3px rgba(58,87,175,2); 
	  box-shadow: 0 3px rgba(58,87,175,2);
	  transition: all 0.1s linear 0s; 
	  -webkit-transition: all 0.1s linear 0s;
	  -moz-transition: all 0.1s linear 0s;
	  -o-transition: all 0.1s linear 0s; 
	  top: 0px;
	  position: relative;
	  cursor:pointer;
	}
	
	input[type=button]:hover {
	  top: 3px;
	  background-color:#2e458b;
	  -webkit-box-shadow: none; 
	  -moz-box-shadow: none; 
	  box-shadow: none;
	  
	} 
    </style>
  </head>
  <body style="background:url('http://cardstak.com/images/background.jpg');background-position:center center; background-size:cover;background-attachment:fixed">
    
     

    <div class="container" style="padding-bottom:30px;background:rgba(255, 255, 255, 0.67);">
        <div style="font-size:23pt; width:100%; font-weight:300; margin-top:40px;text-align: center;">why are you here?</div>
         <div style="font-size: 14pt;color: #0073B1;width:100%; font-weight:300; margin-bottom:30px; text-align: center;">if there is a match, we&#39;ll suggest people you should meet</div>
 	<form id="myForm" action="query/claimgoals.php" method="post">
            
            
            <input id="cardid" name="cardid" style="display:none" value="<?=$card_id?>"/>
    	    <input id="eventid"  name="eventid" style="display:none" value="<?=$event_id?>"/>
            
            <div class="form-group">
                <label>I am a</label>
                <input id="myrole" class="form-control" name="myrole[]"/>
            </div>
            
             <div class="form-group">
                <label>with industry experience in</label>
                <input id="myexp" class="form-control" name="myexp[]"/>
            </div>
            
             <div class="form-group">
                <label style="margin-right:10px;" id="lookinglabel">Looking to </label>
                <label class="checkbox-inline"><input name="goals[]" type="checkbox" value="Meet">Meet</label>
		<label class="checkbox-inline"><input name="goals[]" type="checkbox" value="Get Hired">Get hired for</label>
		<label class="checkbox-inline"><input name="goals[]" type="checkbox" value="Hire">Hire</label>		
            </div>
            
             <div class="form-group">
                <label>a (role) </label>
                <input id="targetrole" class="form-control" name="targetrole[]"/>
            </div>
            
             <div class="form-group">
                <label>in (industry) </label>
                <input id="targetexp" class="form-control" name="targetexp[]"/>
            </div>
            
            <input type="button" style="float:left;margin-left:40px;margin-top:10px" value="Skip"  onclick="gotoStak();" /> 
            
            <input type="button" style="float:right;margin-right:40px;margin-top:10px"  value="Submit"  onclick="myFunction();" /> 
        </form>
    </div>


    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="assets/magicsuggest.js"></script>
    <!--<script src="http://nicolasbize.com/magicsuggest/tutorial/3/js/script.js"></script>-->
    
    <script type="text/javascript">
     
	$(function() {
	
	    $('#myrole').magicSuggest({
	        data: 'assets/suggest_role.php',
	        valueField: 'id',
	        displayField: 'name',
	        maxSelection: 3
	    });
	    
	    $('#targetrole').magicSuggest({
	        data: 'assets/suggest_role.php',
	        valueField: 'id',
	        displayField: 'name',
	        maxSelection: 3
	    });
	    
	     $('#myexp').magicSuggest({
	        data: 'assets/suggest_exp.php',
	        valueField: 'id',
	        displayField: 'name',
	        maxSelection: 3
	    });
	    
	    $('#targetexp').magicSuggest({
	        data: 'assets/suggest_exp.php',
	        valueField: 'id',
	        displayField: 'name',
	        maxSelection: 3
	    });
	
	});
	
	
	
	 
    

  </script>
  
  
  <script type="text/javascript" src="js/jscript.newcardmatcher.js" > </script>
    
  </body>
</html>