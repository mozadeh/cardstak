<?php
require_once('../config.php');
require("../common.php"); 
require_once 'Mandrill.php';

$mandrill = new Mandrill('B8Sm8xi3BNSIdoMVvWDHrQ');


$cardid = $_POST['cardid'];
$eventid = $_POST['eventid'];
$userfrom = $_POST['userfrom'];
//$emailto = $_POST['emailto'];
$emailtoarray = json_decode($_POST['emailto']);
$emailfrom = $_POST['emailfrom'];

$emailto=array();

foreach($emailtoarray as $emailadd) {
    $emailtoadd = array("email"=>$emailadd , "type"=>"to");
    array_push($emailto,$emailtoadd);
}

$emailtoadd = array("email"=>$emailfrom , "type"=>"cc");
array_push($emailto,$emailtoadd);



$subject = 'View '.$userfrom.'\'s Card';


$Emailmessage = '<body id=\"largebackground\" style=" width: 100%;
  background: #fff;
    ">
  
  <img src="http://www.cardstak.com/images/emaillogo.png" alt="Cardstak" style="
    margin-left: auto;
    margin-right: auto;
    display: block;
    margin-bottom: 10px;
    width: 130px;
    height: 34px;
">
  
    
  <div id="background" style=" width: 400px;
  background: #E9ECEC;
  padding: 10px 30px 20px;
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
  color: #2F2F2F;
  -webkit-border-radius: 3px;
  -moz-border-radius: 3px;
  border-radius: 3px;">
 
  </h1>
    <div id="intro" style=" font-family: Arial, sans-serif;
  margin-bottom: 30px;
  font-size: 14pt;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
  text-align: center;
  color: #2F2F2F;">

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


//Query to show everyone else's card

$query = "Select *,cards.eventid AS eventid FROM cards  WHERE
         id =:cardid "; 
         

                
$query_params = array(      
        ':cardid' => $cardid 
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

echo var_dump($rows);

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

	 	$email=' 
	 <tr>
         	<td style="width:40px">
         		<img src="http://cardstak.com/images/mailicon.png" alt="image host" height="30" width="30" class="cardicon">
         	</td>
          	<td>
          		<a href="mailto:'.$row["email"].'" style="
			    color: black;
			    font-family: Arial, sans-serif;
			    text-decoration:none;
			">'.$row["email"].'</a>
		</td>
        </tr>';

	 	}
	 
	 if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){
	 	$phone="";
	 	
	 }
	 else{
	 	$phone='
		<tr>
		        <td style="width:40px">
		         	<img src="http://cardstak.com/images/call.png" alt="image host" height="30" width="30" class="cardicon">
		        </td>
		        <td>
		        	<a href="tel:'.$row["phone"].'" style="
				color: black;
				font-family: Arial, sans-serif;
				text-decoration:none;
				">'.$row["phone"].'</a>
			</td>
		</tr>
	 	';
	        
	        }
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 	
	 }
	 else{
	 	$pos = strpos($row["linkedin"], 'linkedin');
		 if ($pos !== false) {
		 	$row["linkedin"]="http://www.".substr($row["linkedin"],$pos);
		 }
	 	
	 	$linkedin='
	 	<tr>
                        <td style="width:40px">
                         	<img src="http://cardstak.com/images/linkedinicon.png" alt="image host" height="30" width="30" class="cardicon">
                        </td>
                        <td>
                        	<a href="'.$row["linkedin"].'" style="
				    color: black;
				    font-family: Arial, sans-serif;
				">click to view</a>
			</td>
                </tr>
	 	
	 	';
	 	}
	 
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 }
	 else{
	 	$weburl='
	 	<tr>
                        <td style="width:40px">
                        	<img src="http://cardstak.com/images/weburl.png" alt="image host" height="30" width="30" class="cardicon">
                        </td>
                        <td>
                        	<a href="'.$row["weburl"].'" style="
				    color: black;
				    font-family: Arial, sans-serif;
				    text-decoration:none;
				">'.$row["weburl"].'</a>
			</td>
                </tr>
	 	';
	 	}	
	 
	 
	 	
	 if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){
	 	$cvlink="";
	 }
	 else{
	 	$cvlink='
	 	<tr>
                        <td style="width:40px">
                        	<img src="http://cardstak.com/images/cv.png" alt="image host" height="30" width="30" class="cardicon">
                        </td>
                        <td>
                        	<a href="'.$row["cvlink"].'" style="
				    color: black;
				    font-family: Arial, sans-serif;
				">click to open</a>
			</td>
                </tr>
                ';
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
  max-height: 100px;
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
  display: inline;
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
  width: 100px;
  height: 100px;
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
	                    	<table style=\"margin-right: auto;text-align: left;margin-top:10px\">
	                    	".$email.$phone.$weburl.$cvlink.$linkedin."
	                    	</table>
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
	

$Emailmessage .='



</table>

</div>

<table style="background-color: #35978b; border-collapse: separate!important; border-radius: 3px;margin-left:auto;margin-right:auto;margin-top:20px; margin-bottom:20px;" border="0" cellspacing="0" cellpadding="0">
        <tbody>
          <tr>
            <td style="color: #ffffff; font-family: Helvetica,Arial,sans-serif; font-size: 15px; font-weight: bold; line-height: 100%;width:100%; padding: 15px;" align="center" valign="middle"><a style="color: #ffffff;  text-decoration: none;" href="http://www.cardstak.com/index.php?event_id='.$eventid.'" target="_blank">Open Stak</a></td>
          </tr>
        </tbody>
      </table>

</div>





</body>';


// creating email message




try{
 
        $message = array(
                'subject' => $subject ,
                'html' => $Emailmessage, // or just use 'html' to support HTMl markup
                'from_email' => 'emailer@cardstak.com',
                'from_name' => $userfrom, //optional
                'to' => $emailto,
 		'headers' => array('Reply-To' => $emailfrom),
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