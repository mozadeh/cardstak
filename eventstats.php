<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.js"></script>
  <script type="text/javascript" src="js/jquery.form.min.js"></script>
  <script src="js/sweet-alert.js"></script> 
  <link rel="stylesheet" type="text/css" href="style/sweet-alert.css">
  <script type="text/javascript" language="javascript" src="js/jquery.dotdotdot.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Pathway+Gothic+One' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" type="text/css" href="style/eventstatsstyle.css">
  <title>Stak Analytics</title>
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57633709-1', 'auto');
  ga('send', 'pageview');

</script>
  


<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
  
</head>


<body>

  
<div style="display:none">



<?php

 require("common.php"); 
 require_once('config.php');
 
  if (isset($_GET['event_id'])) {
	$event_id = $_GET['event_id'];}

 
 if(empty($_SESSION['user'])) 
    { 
        // If they are not, we redirect them to the login page. 
        //header("Location: login.php"); 
         
        // Remember that this die statement is absolutely critical.  Without it, 
        // people can view your members-only content without logging in. 
        //die("Redirecting to login.php"); 
    }
    
    
  if (strpos($_SESSION['location'],'index.php') !== false ){
  	$backbutton='<input type="button" onclick="goBack()" align="center" value="Cancel" />';
   }
   else{
   	$backbutton='';
   }
 
 //$_SESSION['location']="index.php";
    
  
    
/***** getting basic activities	 ****/
	
$query = "Select * FROM activities WHERE  eventid=:eventid";
  
                
$query_params = array(      
        ':eventid' => $event_id
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

$cardsaved=0;
$lastcardsaved=0;

$linkedinview=0;
$lastlinkedinview=0;

$cvview=0;
$lastcvview=0;

$phoneview=0;
$lastphoneview=0;

$websiteview=0;
$lastwebsiteview=0;

$usetips=0;
$lastusetips=0;

$messagessent=0;
$lastmessagessent=0;

$hellossent=0;
$lasthellossent=0;


if ($rows) {   

        foreach ($rows as $row) {
        		if( $row["type"]=="sendhi" ){
        			$hellossent += 1;	
        			if( $row["created"] > $lasthellossent){
        				$lasthellossent =  $row["created"];
        			}
        		}
        		if( $row["type"]=="sendemail" ){
        			$messagessent += 1;
        			if( $row["created"] > $lastmessagessent){
        				$lastmessagessent =  $row["created"];
        			}	
        		}
        		if( $row["type"]=="checklinkedin" ){
        			$linkedinview += 1;	
        			if( $row["created"] > $lastlinkedinview){
        				$lastlinkedinview =  $row["created"];
        			}
        		}
        		if( $row["type"]=="checkcv" ){
        			$cvview += 1;	
        			if( $row["created"] > $lastcvview){
        				$lastcvview =  $row["created"];
        			}
        		}
        		if( $row["type"]=="checkphone" ){
        			$phoneview += 1;	
        			if( $row["created"] > $lastphoneview){
        				$lastphoneview =  $row["created"];
        			}
        		}
        		if( $row["type"]=="checkweb" ){
        			$websiteview += 1;	
        			if( $row["created"] > $lastwebsiteview){
        				$lastwebsiteview =  $row["created"];
        			}
        		}
        		if( $row["type"]=="usetips" ){
        			$usetips += 1;	
        			if( $row["created"] > $lastusetips){
        				$lastusetips =  $row["created"];
        			}
        		}
       }
}


if ($hellossent > 0){
    	$hellossenttimeago = getTimeAgo($lasthellossent);   
    	$hellossentrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/sayhi.png" alt="image host" height="27" width="27"></td>
	        <td>Hellos sent</td>
	        <td>'.$hellossent.'</td>
	        <td>'.$hellossenttimeago.'</td>
        </tr>';
}
else{
	$hellossentrow='';
}

if ($messagessent > 0){
    	$messagessenttimeago = getTimeAgo($lastmessagessent);  
    	$messagessentrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/nmail.png" alt="image host" height="27" width="27"></td>
	        <td>Messages sent</td>
	        <td>'.$messagessent.'</td>
	        <td>'.$messagessenttimeago.'</td>
        </tr>';  
}
else{
	$messagessentrow='';
}

if ($linkedinview > 0){
    	$linkedinviewtimeago = getTimeAgo($lastlinkedinview); 
    	$linkedinviewrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/newlinkedinicon_hover.png" alt="image host" height="27" width="27"></td>
	        <td>LinkedIn Views</td>
	        <td>'.$linkedinview.'</td>
	        <td>'.$linkedinviewtimeago.'</td>
        </tr>';     	
}
else{
	$linkedinviewrow='';
}

if ($cvview > 0){
    	$cvviewtimeago = getTimeAgo($lastcvview);  
    	$cvviewrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/newcvicon_hover.png" alt="image host" height="27" width="27"></td>
	        <td>CV Views</td>
	        <td>'.$cvview.'</td>
	        <td>'.$cvviewtimeago.'</td>
        </tr>';     	
}
else{
	$cvviewrow='';
}

if ($phoneview > 0){
    	$phoneviewtimeago = getTimeAgo($lastphoneview); 
    	$phoneviewrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/newphoneicon_hover.png" alt="image host" height="27" width="27"></td>
	        <td>Phone Views</td>
	        <td>'.$phoneview.'</td>
	        <td>'.$phoneviewtimeago.'</td>
        </tr>';    	
}
else{
	$phoneviewrow='';
}


if ($websiteview > 0){
    	$websiteviewtimeago = getTimeAgo($lastwebsiteview);  
    	$websiteviewrow =' 
    	<tr>
	        <td><img src="http://cardstak.com/images/newwebicon_hover.png" alt="image host" height="27" width="27"></td>
	        <td>Website Views</td>
	        <td>'.$websiteview.'</td>
	        <td>'.$websiteviewtimeago.'</td>
        </tr>';    	
}
else{
	$websiteviewrow ='';
}

if ($usetips > 0){
    	$usetipstimeago = getTimeAgo($lastusetips);    	
    	$usetipsrow =' 
    	<tr>
	        <td></td>
	        <td>Use tips</td>
	        <td>'.$usetips.'</td>
	        <td>'.$usetipstimeago.'</td>
        </tr>';   
}
else{
	$usetipsrow ='';
}	

/***** getting saved cards  ****/

$query = "SELECT savedcards.created as ctr FROM savedcards join cards on savedcards.cardid = cards.id WHERE  eventid=:eventid";
  
                
$query_params = array(      
        ':eventid' => $event_id
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
		$cardsaved += 1;	
		if( $row["ctr"] > $lastcardsaved){
			$lastcardsaved =  $row["ctr"];
		}
        		
	}    
}    		

if ($cardsaved > 0){
    	$lastcardsavedago = getTimeAgo($lastcardsaved);    	
    	$savedcardsrow =' 
    	<tr>
	        <td></td>
	        <td>Cards saved</td>
	        <td>'.$cardsaved.'</td>
	        <td>'.$lastcardsavedago.'</td>
        </tr>';   
}
else{
	$savedcardsrow ='';
}	


$total = $cardsaved + $linkedinview + $cvview + $phoneview + $websiteview + $usetips + $messagessent + $hellossent;
$lastiteraction = max($lastcardsaved, $lastlinkedinview, $lastcvview, $lastphoneview, $lastwebsiteview, $lastusetips, $lastmessagessent, $lasthellossent);

if ($lastiteraction != 0 ){
	$lastiteraction = getTimeAgo($lastiteraction);  
}
 
$totalinteractionrow =   ' 
    	<tr>
	        <td></td>
	        <td>Total</td>
	        <td>'.$total.'</td>
	        <td>'.$lastiteraction.'</td>
        </tr>';  


/***** getting cards created  ****/

$query = "SELECT cards.Created as ctr, cards.cardgroup as crg,events.groupno as grpno, events.group1 as g1, events.group2 as g2, events.group3 as g3 FROM cards join events on cards.eventid = events.eventid where  cards.eventid=:eventid";
  
                
$query_params = array(      
        ':eventid' => $event_id
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

$group1count=0;
$group1lastcreatedate = 0;
$group2count=0;
$group2lastcreatedate = 0;
$group3count=0;
$group3lastcreatedate = 0;
	
$rows = $stmt->fetchAll();
if ($rows) {  
	$firstrow = $rows[0]; 
	//echo var_dump($firstrow);
	$groupno = $firstrow["grpno"];
	$group1 = $firstrow["g1"];
	$group2 = $firstrow["g2"];
	$group3 = $firstrow["g3"];
	
	
        foreach ($rows as $row) {
        				
		if( $row["crg"]=="1" ){
			$group1count += 1;
			if ( !empty($row["ctr"]) ){
				if( $row["ctr"] > $group1lastcreatedate){
					$group1lastcreatedate =  $row["ctr"];
				}
			}
		}
		
		
		if( $row["crg"]=="2" ){
			$group2count += 1;
			if ( !empty($row["ctr"]) ){
				if( $row["ctr"] > $group2lastcreatedate){
					$group2lastcreatedate =  $row["ctr"];
				}
			}	
		}
		
		if( $row["crg"]=="3" ){
			$group3count += 1;
			if ( !empty($row["ctr"]) ){
				if( $row["ctr"] > $group3lastcreatedate){
					$group3lastcreatedate =  $row["ctr"];
				}
			}	
		}
        		
	}    
}    		

echo 'count: '.$groupno.' end';

if ($group1count > 0 && $groupno > 1){
    	$group1ago = getTimeAgo($group1lastcreatedate); 	
    	$group1row =' 
    	<tr>
	        <td>'.$group1.'</td>
	        <td>'.$group1count.'</td>
	        <td>'.$group1ago.'</td>
        </tr>'; 
        
}
else{
	$group1row ='';
}

if ($group2count > 0){
    	$group2ago = getTimeAgo($group2lastcreatedate);    	
    	$group2row =' 
    	<tr>
	        <td>'.$group2.'</td>
	        <td>'.$group2count.'</td>
	        <td>'.$group2ago.'</td>
        </tr>';   
}
else{
	$group2row ='';
}

if ($group3count > 0){
    	$group3ago = getTimeAgo($group3lastcreatedate);    	
    	$group3row =' 
    	<tr>
	        <td>'.$group3.'</td>
	        <td>'.$group3count.'</td>
	        <td>'.$group3ago.'</td>
        </tr>';   
}
else{
	$group3row ='';
}


$total = $group1count + $group2count + $group3count;
$lastcard = max($group1lastcreatedate, $group2lastcreatedate, $group3lastcreatedate);

if ($lastcard != 0 ){	
	$lastcard = getTimeAgo($lastcard);  
}



$totalcardsrow =   ' 
    	<tr>
	        <td>Total</td>
	        <td>'.$total.'</td>
	        <td>'.$lastcard.'</td>
        </tr>';  





function getTimeAgo($time){
	if ($time==0) {return 'N/A';}
	$date1 = DateTime::createFromFormat('Y-m-d H:i:s', $time);
        $date2 = new DateTime();
        
        //var date2 = new Date(now.getTime() + now.getTimezoneOffset() * 60000);
	//var date2 = new Date(now.toUTCString());
	$timeDiff = abs(($date2->getTimestamp()  - $date1->getTimestamp() ));
	//$hellossenttimeago = date_format($date2, 'Y-m-d H:i:s');
	//$hellossenttimeago  = $timeDiff;
	$diffDays = floor($timeDiff / (3600 * 24)); 
	$diffHours = floor( ($timeDiff - $diffDays*(3600 * 24)) / (3600) ); 
	$diffMinutes = floor( ($timeDiff - $diffDays*(3600 * 24) - $diffHours*(3600)) / (60) ); 
	$timeago="";
	if ($diffDays>365) {$timeago="a year ago";}
	else if ($diffDays>1) {$timeago=$diffDays." days ago";}
	else if ($diffDays>0) {$timeago="yesterday";}
	else if ($diffHours>1) {$timeago=$diffHours." hours ago";}
	else if ($diffHours>0) {$timeago="an hour ago";}
	else if ($diffMinutes>1) {$timeago=$diffMinutes." minutes ago";}
	else if ($diffMinutes>0) {$timeago="a minute ago";}
	else {$timeago="now";}
	
	return $timeago;
}





?>

</div>

<div style="display:none" id="eventtag"><?=$event?></div>
<div style="display:none" id="eventid"><?=$event_id?></div>	



<div class="contents">
  <table class="flat-table flat-table-1">
    <thead>
      <th class="header-left"></th>
      <th>Profiles</th>
      <th class="header-right">Last created</th>
    </thead>
    <tbody>
      <?=$totalcardsrow?>
      <?=$group1row?>
      <?=$group2row?>
      <?=$group3row?>
    </tbody>
  </table>
  <div class="note" style="display:none;">
    Interactions typically increase exponentially with more cards created
  </div>
  <table class="flat-table flat-table-2">
    <thead>
      <th class="header-left"></th>
      <th>Interaction</th>
      <th>Total</th>
      <th class="header-right">Last interaction</th>
    </thead>
    <tbody>
      <?=$totalinteractionrow?>
      <?=$hellossentrow?>
      <?=$messagessentrow?>
      <?=$cvviewrow?>
      <?=$linkedinviewrow?>
      <?=$websiteviewrow?>
      <?=$phoneviewrow?>
      <?=$savedcardsrow?>
      <?=$usetipsrow?>
      
    </tbody>
  </table>
</div>

<!-- <script type="text/javascript" src="js/jscript.editcard.js" > </script> -->




    </body>
    
    
  </html>
  
 
 
 