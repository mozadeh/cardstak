<?php
require_once('../config.php');
require("../common.php"); 
require_once 'Mandrill.php';

$mandrill = new Mandrill('B8Sm8xi3BNSIdoMVvWDHrQ');
$replyemail    = "admin@cardstak.com"; 

//change name, emailto, email subject, email from name, event id variable, event id in email text


$name= 'Michael';
$emailingto = 'hosein88@gmail.com';



$Emailmessage = '<body id=\"largebackground\" style=" width: 100%;
  background: #fff;
    ">
    
  <div id="background" style=" width: 400px;
  background: #E9ECEC;
  padding: 10px 30px 40px;
  margin-left: auto;
  margin-right: auto;
  -webkit-border-radius: 5px;
  -moz-border-radius: 5px;
  border-radius: 5px;">
    <h1 style=" font-family: Arial, sans-serif;
  font-weight: 300;
  font-size: 25pt;
  width: 100%;
  text-align: center;
  color: #6F6F6F;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;">
Hi '.$name.'
  </h1>
    <div id="intro" style=" font-family: Arial, sans-serif;
  margin-bottom: 30px;
  font-size: 14pt;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
  text-align: center;
  color: #6F6F6F;">
      Based on your profile, you might be interested in meeting the following people. You can message them in the Event Page.
      
      
      
       <table style="background-color: #51A8E2; border-collapse: separate!important; border-radius: 3px;margin-left:auto;margin-right:auto;margin-top:20px; margin-bottom:20px;" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td style="color: #ffffff; font-family: Helvetica,Arial,sans-serif; font-size: 15px; font-weight: bold; line-height: 100%;width:100%; padding: 15px;" align="center" valign="middle"><a style="color: #ffffff;  text-decoration: none;" href="http://www.cardstak.com/index.php?event_id=QsnjkV9b8k" target="_blank">Open Event Page</a></td>
          </tr>
        </tbody>
      </table>
      
       <table id="cardstable" style="margin-left: auto;
  margin-right: auto; cellspacing:20px;">
     
';



$nmemberid='Not Available'; 
$lmemberid='Not Available'; 





//$createurl=$_SESSION['location'];

$num=2;

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";

$eventid = 'QsnjkV9b8k';




//Query to show everyone else's card

$query = "Select *,cards.eventid AS eventid FROM cards  WHERE
         cards.eventid=:eventid   AND
(
    id = 8448
)"; 
         
/*   OR id = 8216  $query = "Select *,cards.eventid AS eventid FROM cards LEFT JOIN savedcards ON 
        (savedcards.nmemberid = :nmemberid OR savedcards.lmemberid = :lmemberid) AND savedcards.cardid=cards.id WHERE
         cards.nmemberid != :nmemberid AND cards.lmemberid != :lmemberid";*/  
                
$query_params = array(      
        ':eventid' => $eventid
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
	$picbiocards = [];
	$piccards = []; 
	$biocards = [];
	$emptycards = [];  
    
    foreach ($rows as $row) {
    

	
	 if(is_null($row["email"])||$row["email"]=="NULLVAR"){
	 	$email="";
	 	
	 }
	 else{

	 	$email="<img  src=\"http://www.cardstak.com/images/nmail.png\" alt=\"image host\" title=\"send email\" height=\"29\" width=\"29\"/>";

	 	}
	 
	 if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){
	 	$phone="";
	 	
	 }
	 else{
	 	$phone=" <img src=\"http://www.cardstak.com/images/call.png\" style=\"padding-right:5px\" alt=\"image host\" height=\"30\" width=\"30\" />";
	        
	        }
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 	
	 }
	 else{
	 	$pos = strpos($row["linkedin"], 'linkedin');
		 if ($pos !== false) {
		 	$row["linkedin"]="http://www.".substr($row["linkedin"],$pos);
		 }
	 	
	 	$linkedin=" <a href=\"".$row["linkedin"]."\" target=\"_blank\" style=\"padding-right:5px\" ><img src=\"http://www.cardstak.com/images/linkedinicon.png\" alt=\"image host\" height=\"30\" width=\"30\" /></a>";
	 	}
	 
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 }
	 else{
	 	$weburl="<a href=\"".$row["weburl"]."\" target=\"_blank\"  style=\"padding-right:5px\" ><img src=\"http://www.cardstak.com/images/weburl.png\" alt=\"image host\" height=\"30\" width=\"30\" /></a>";
	 	}	
	 
	 
	 	
	 if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){
	 	$cvlink="";
	 }
	 else{
	 	$cvlink="<a href=\"".$row["cvlink"]."\" target=\"_blank\"   style=\"padding-right:5px\" ><img src=\"http://www.cardstak.com/images/cv.png\" alt=\"image host\" height=\"30\" width=\"30\" /></a>";
	 	}	
	 	
	 if(is_null($row["cardgroup"])||$row["cardgroup"]=="NULLVAR"){
	 	$color="rgb(36, 127, 189)";
	 }
	 else{
	 	if ($row["cardgroup"]==1) {$color="rgb(52, 152, 219)";  $tcolor="rgb(149, 211, 255)";}
	 	if ($row["cardgroup"]==2) {$color="rgb(56, 174, 160)";  $tcolor="rgb(142, 232, 221)";}
	 	if ($row["cardgroup"]==3) {$color="rgb(149, 165, 166)";  $tcolor="rgb(228, 228, 228)";}
	 }
	 
	
	 $Emailmessage .= "<tr>
	<td style=\"padding-bottom:20px\">
	<div class=\"".$row["cardgroup"]."\">
	 <div id=\"user".$num."\" id=\"block\"   >
	 
	 	
	            <table  id=\"topcard\" cellpadding=\"0\" cellspacing=\"0\" style=\"width: 350px;
  max-height: 80px;
  display: block;
  overflow: hidden;
  -moz-border-radius-topleft: 8px;
  -webkit-border-radius-topleft: 8px;
  border-top-left-radius: 8px;
  -moz-border-radius-topright: 8px;
  -webkit-border-radius-topright: 8px;
  border-top-right-radius: 8px;
  border-spacing: 0px;\" id=\"top_card_user".$num."\" >
	                <tr>
	                    <td style=\"-moz-border-radius-topleft: 0px;
  -webkit-border-radius-topleft: 8px;
  border-top-left-radius: 8px;
  background: rgb(84, 92, 97) ;
  color: white;
  width: 100%;
  margin-left: auto;
  margin-right: auto;
  text-align: center;\">
	                        <table style=\"width: 97%;
  color: white;
  text-align: left;
  padding-left: 10px;
  display: inline-box;
  display: -webkit-inline-box;
  display: -moz-inline-box;
  overflow: hidden;\">
	                            <tr>
	                                <td style=\"font-size: 18pt;
  text-shadow: -1px -1px 0 #222222, 1px -1px 0 #222222, -1px 1px 0 #222222, 1px 1px 0 #222222;
  height: 29px;
  display: block;
  overflow: hidden;\">".$row["fullname"]."</td>
	                            </tr>
	                            <tr>
	                                <td style=\"font-size: 12pt;
  text-shadow: -1px -1px 0 #3C3C3C, 1px -1px 0 #3C3C3C, -1px 1px 0 #3C3C3C, 1px 1px 0 #3C3C3C;\" >".substr($row["title"],0,100)."</td>
	                            </tr>
	                        </table>
	                    </td>
	                    <td style=\" background-color: #247fbd;
  -moz-border-radius-topright: 8px;
  -webkit-border-radius-topright: 8px;
  border-top-right-radius: 8px;
  \" align=\"center\"  style=\"background:".$color."\">
	                        <img id=\"circle\" src=\"".$row["photourl"]."\"  
style=\" -moz-border-radius-topright: 8px;
  -webkit-border-radius-topright: 8px;
  border-top-right-radius: 8px;
  width: 80px;
  height: 80px;
  background-size: cover;\"/>
	                    </td>
	                </tr>
	            </table>
	            <table id=\"bottomcard\" style=\"min-height: 61px;
  -moz-border-radius-bottomleft: 8px;
  -webkit-border-radius-bottomleft: 8px;
  border-bottom-left-radius: 8px;
  -moz-border-radius-bottomright: 8px;
  -webkit-border-radius-bottomright: 8px;
  border-bottom-right-radius: 8px;
  background: white;
  padding-top: 5px;
  padding-left: 10px;
  width: 350px;
  border-left: 1px solid rgb(155, 155, 155);
  border-right: 1px solid rgb(155, 155, 155);
  border-bottom: 1px solid rgb(155, 155, 155);
  font-size: 11pt;
  font-family: Arial, sans-serif; border-top:5px solid ".$color.";\">
	                <tr>
	                    <td style=\" display: block;
  max-height: 150px;
  width: 324px;
  text-align:left;
  line-height: 18px;
  overflow: hidden;\">".$row["bio"]."</td>
	                </tr>
	                <tr>
	                    <td align=\"right\">
	                    	".$linkedin.$weburl.$cvlink."
	                    </td>
	                </tr>
	            </table>
	        </div>
	    </div>
	</td></tr>";

	
		
		
		if($row["photourl"]!="http://cardstak.com/uploads/profileimage.png"){
			$piccards[] = $output;
		}
		elseif($row["photourl"]=="http://cardstak.com/uploads/profileimage.png"){
			$biocards[] = $output;
		}
		else{
			$emptycards[] = $output;
		}

	 $num+=1;
	 
	}
	//foreach($picbiocards as $val) {echo $val;}
	foreach($piccards as $val) {echo $val;}
	foreach($biocards as $val) {echo $val;}
	foreach($emptycards as $val) {echo $val;}
}
	

echo '</table>
</div>
</div>
</body>';


/*** creating email message ***/




try{
 
        $message = array(
                'subject' => 'One person you should meet' ,
                'html' => $Emailmessage, // or just use 'html' to support HTMl markup
                'from_email' => 'emailer@cardstak.com',
                'from_name' => 'MEng Visit Day 2016 Attendees', //optional
                'to' => array(
                        array( // add more sub-arrays for additional recipients
                                'email' => $emailingto,
                                'name' => $name, // optional
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
    echo $Emailmessage;
} catch(Mandrill_Error $e) {
 
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
 
    throw $e;
}



?>