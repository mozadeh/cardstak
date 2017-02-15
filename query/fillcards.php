<?php
require_once('../config.php');
require("../common.php"); 

$logintocreate="";
$nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: 'NA'; 
$lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: 'NA'; 
$createurl=str_replace("index.php","create_card.php",$_SESSION['location']);

if($nmemberid=='NA' && $lmemberid=='NA'){
	$logintocreate= "onclick=\"showloginalert();\"";
	$createurl='#';
}



//$createurl=$_SESSION['location'];

$num=1;

$conn = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
// selecting database
if(!mysql_select_db(DB_DATABASE))
  print "Not connected with database.";

$eventid = $_POST['eventid'];

if (isset($_POST['eventid'])) {
	$countquery = mysql_query("Select Count(*) FROM cards WHERE eventid='$eventid' AND (lmemberid='$lmemberid' OR nmemberid='$nmemberid')"); //Insert
}

if(mysql_result($countquery, 0)=="1"){		
	$addcardstyle="style=\"display:none\"";
	$addcardclassname="block1";
} 
else{
	$addcardstyle="style=\"left: 2000px; top: 2000px;\"";
	$addcardclassname="block";		
} 




//Query to show your card

//$query = "Select *,cards.eventid AS eventid FROM cards LEFT JOIN savedcards ON savedcards.cardid=cards.id WHERE (cards.nmemberid = :nmemberid OR cards.lmemberid = :lmemberid) AND cards.eventid=:eventid ";
                
$query = "Select *,cards.eventid AS eventid FROM cards WHERE (cards.nmemberid = :nmemberid OR cards.lmemberid = :lmemberid) AND cards.eventid=:eventid ";                
                
$query_params = array(      
        ':nmemberid' => $_POST['nmemberid'],
	':lmemberid' => $_POST['lmemberid'],
        ':eventid' => $_POST['eventid']
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

	 $bottomofcard="edit";

	
	 if(is_null($row["email"])||$row["email"]=="NULLVAR"){
	 	$email="";
	 	$temail="";
	 }
	 else{
	 	/*$email="
	 <td><a href=\"https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=".$row["email"]."&su=".$_POST['event']."\" target=\"_blank\" class=\"dont_open\"><img src=\"http://smartikymail.com/webservice/cards/mailicon.png\" alt=\"image host\" height=\"30\" width=\"30\"/></a></td>";*/
	 	$email="<td><img onclick=\"openEmail('user$num','".$row["email"]."');\" class=\"dont_open cardicon\" src=\"images/mailicon.png\" alt=\"image host\" height=\"30\" width=\"30\"/></td>";
	 	$temail="<td align=\"left\" class=\"contactinfo\"><p>".$row["email"]."</p></td>";}
	 
	 if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){
	 	$phone="";
	 	$tphone="";
	 }
	 else{
	 	$phone="
	 <td class=\"dont_open\" id=\"phone".$num."\" onclick=\"openPhone(this.id);\">
	                                   <a target=\"_blank\">
	                                       <img src=\"images/call.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a>
	                                    <div class=\"cardphone\"><a href=\"tel:".$row["phone"]."\">".$row["phone"]."</a></div></td>";
	        $tphone="<td align=\"left\" class=\"contactinfo\"><p>".$row["phone"]."</p></td>";}
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 	$tlinkedin="";
	 }
	 else{
	 	$linkedin="<td><a href=\"".$row["linkedin"]."\" target=\"_blank\" class=\"dont_open\"><img src=\"images/linkedinicon.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a> </td>";
	 	$tlinkedin="<td align=\"left\" class=\"contactinfo\"><p>".str_replace("https://www.", "", $row["linkedin"])."</p></td>";}
	 	
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 	$tweburl="";
	 }
	 else{
	 	$weburl="<td><a href=\"".$row["weburl"]."\" target=\"_blank\" class=\"dont_open\"><img src=\"images/weburl.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a> </td>";
	 	$tweburl="<td align=\"left\" class=\"contactinfo\"><p>".str_replace("http://www.", "", $row["weburl"])."</p></td>";}	
	 	
	 if(is_null($row["cardgroup"])||$row["cardgroup"]=="NULLVAR"){
	 	$color="rgb(36, 127, 189)";
	 }
	 else{
	 	if ($row["cardgroup"]==1) {$color="rgb(52, 152, 219)";  $tcolor="rgb(149, 211, 255)";}
	 	if ($row["cardgroup"]==2) {$color="rgb(56, 174, 160)";  $tcolor="rgb(142, 232, 221)";}
	 	if ($row["cardgroup"]==3) {$color="rgb(149, 165, 166)";  $tcolor="rgb(228, 228, 228)";}
	 	//if ($row["group"]==1) {$color="rgb(255, 255, 255)";}
	 	//if ($row["group"]==2) {$color="rgb(255, 255, 255)";}
	 	//if ($row["group"]==3) {$color="rgb(255, 255, 255)";}
	 }
	 
	 $output="
	 <div class=\"".$row["cardgroup"]."\">
	 <div id=\"user".$num."\" class=\"block\" onclick=\"gotoEditCard();\" style=\"left: 85px; top: 150px; opacity: 0;
    filter: alpha(opacity=0);\">
	 
	 	<div class=\"cardid\" style=\"display:none\">".$row["id"]."</div>
	        <div class=\"hover\">
	            <table class=\"topcard \">
	                <tr>
	                    <td class=\"name\">
	                        <table class=\"namestyle\">
	                            <tr>
	                                <td class=\"cardname\">".$row["fullname"]."</td>
	                            </tr>
	                            <tr>
	                                <td class=\"cardtitle\"; style=\"color:$tcolor\">".substr($row["title"],0,35)."</td>
	                            </tr>
	                        </table>
	                    </td>
	                    <td class=\"picture\" align=\"center\" style=\"background:".$color."\">
	                        <div style=\"background-image: url('".$row["photourl"]."');\" class=\"circle\"></div>
	                    </td>
	                </tr>
	            </table>
	            <table class=\"bottomcard\" style=\"border-top:5px solid ".$color.";\">
	                <tr>
	                    <td class=\"bio\">".$row["bio"]."</td>
	                </tr>
	                <tr>
	                    <td align=\"right\">
	                        <table style=\"min-height:40px\" class=\"contactinfotop\" align=\"right\">
	                            <tr>
	                                <td class=\"save\">".$bottomofcard."</td>
	                                ".$linkedin.$email.$phone.$weburl."
	                                </td>
	                            </tr>
	                        </table>
	                        
	                        <div style=\"display:none\" class=\"commentoncard\">".$row["note"]."</div>
	                        <div style=\"display:none\" class=\"cardevent\">".$row["event"]."</div>
	                        <table align=\"left\" style=\"display:none\" class=\"contactinfobottom\">
	                                <tr >"
	                                    .$linkedin.$tlinkedin."
	                                    
	                                </tr>
	                                <tr>"
	                                    .$email.$temail."
	                                    
	                                </tr>
	                                <tr>"
	                                    .$phone.$tphone."
	                                </tr>
	                                <tr>"
	                                    .$weburl.$tweburl."
	                                </tr>
	                                <tr style=\"height:25px\">
	                                    <td class=\"save2\">".$bottomofcard."</td>
	                                </tr>
	                            </table>
	
	                
	                        
	                        
	                    </td>
	                </tr>
	            </table>
	        </div>
	    </div>
	</div>";
	echo $output;
	 $num+=1;
	}
}
 


//Query to show everyone else's card



$query = "Select *,cards.eventid AS eventid FROM cards LEFT JOIN savedcards ON 
        (savedcards.nmemberid = :nmemberid OR savedcards.lmemberid = :lmemberid) AND savedcards.cardid=cards.id WHERE
         cards.nmemberid != :nmemberid AND cards.lmemberid != :lmemberid AND cards.eventid=:eventid ORDER BY cards.id ASC"; 
         
/*$query = "Select *,cards.eventid AS eventid FROM cards LEFT JOIN savedcards ON 
        (savedcards.nmemberid = :nmemberid OR savedcards.lmemberid = :lmemberid) AND savedcards.cardid=cards.id WHERE
         cards.nmemberid != :nmemberid AND cards.lmemberid != :lmemberid";*/  
                
$query_params = array(      
        ':nmemberid' => $_POST['nmemberid'],
	':lmemberid' => $_POST['lmemberid'],
        ':eventid' => $_POST['eventid']
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

	 if (!is_null($row["cardid"]) and ( $lmemberid==$row["lmemberid"] or $nmemberid==$row["nmemberid"])  ){	
	 	$bottomofcard="edit";
	 }
	 else{
	 	$bottomofcard="save";
	 	$row["note"]='';
	 	//$bottomofcard=$nmemberid.$lmemberid.$row["lmemberid"].$row["nmemberid"];
	 }
	
	 if(is_null($row["email"])||$row["email"]=="NULLVAR"){
	 	$email="";
	 	$temail="";
	 }
	 else{
	 	/*$email="
	 <td><a href=\"https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=".$row["email"]."&su=".$_POST['event']."\" target=\"_blank\" class=\"dont_open\"><img src=\"http://smartikymail.com/webservice/cards/mailicon.png\" alt=\"image host\" height=\"30\" width=\"30\"/></a></td>";*/
	 	$email="<td><img onclick=\"openEmail('user$num','".$row["email"]."');\" class=\"dont_open cardicon\" src=\"images/mailicon.png\" alt=\"image host\" height=\"30\" width=\"30\"/></td>";
	 	$temail="<td align=\"left\" class=\"contactinfo\"><p>".$row["email"]."</p></td>";}
	 
	 if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){
	 	$phone="";
	 	$tphone="";
	 }
	 else{
	 	$phone="
	 <td class=\"dont_open\" id=\"phone".$num."\" onclick=\"openPhone(this.id);\">
	                                   <a target=\"_blank\">
	                                       <img src=\"images/call.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a>
	                                    <div class=\"cardphone\"><a href=\"tel:".$row["phone"]."\">".$row["phone"]."</a></div></td>";
	        $tphone="<td align=\"left\" class=\"contactinfo\"><p>".$row["phone"]."</p></td>";}
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 	$tlinkedin="";
	 }
	 else{
	 	$linkedin="<td><a href=\"".$row["linkedin"]."\" target=\"_blank\" class=\"dont_open\"><img src=\"images/linkedinicon.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a> </td>";
	 	$tlinkedin="<td align=\"left\" class=\"contactinfo\"><p>".str_replace("https://www.", "", $row["linkedin"])."</p></td>";}
	 	
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 	$tweburl="";
	 }
	 else{
	 	$weburl="<td><a href=\"".$row["weburl"]."\" target=\"_blank\" class=\"dont_open\"><img src=\"images/weburl.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a> </td>";
	 	$tweburl="<td align=\"left\" class=\"contactinfo\"><p>".str_replace("http://www.", "", $row["weburl"])."</p></td>";}	
	 	
	 if(is_null($row["cardgroup"])||$row["cardgroup"]=="NULLVAR"){
	 	$color="rgb(36, 127, 189)";
	 }
	 else{
	 	if ($row["cardgroup"]==1) {$color="rgb(52, 152, 219)";  $tcolor="rgb(149, 211, 255)";}
	 	if ($row["cardgroup"]==2) {$color="rgb(56, 174, 160)";  $tcolor="rgb(142, 232, 221)";}
	 	if ($row["cardgroup"]==3) {$color="rgb(149, 165, 166)";  $tcolor="rgb(228, 228, 228)";}
	 	//if ($row["group"]==1) {$color="rgb(255, 255, 255)";}
	 	//if ($row["group"]==2) {$color="rgb(255, 255, 255)";}
	 	//if ($row["group"]==3) {$color="rgb(255, 255, 255)";}
	 }
	 $output="
	 <div class=\"".$row["cardgroup"]."\">
	 <div id=\"user".$num."\" class=\"block\" onclick=\"addComment(this.id);\"  style=\"left: ".strval(($num)*200)."px; top: 700px;  opacity: 0;
    filter: alpha(opacity=0);\" >
	 
	 	<div class=\"cardid\" style=\"display:none\">".$row["id"]."</div>
	        <div class=\"hover\">
	            <table class=\"topcard \">
	                <tr>
	                    <td class=\"name\">
	                        <table class=\"namestyle\">
	                            <tr>
	                                <td class=\"cardname\">".$row["fullname"]."</td>
	                            </tr>
	                            <tr>
	                                <td class=\"cardtitle\"; style=\"color:$tcolor\">".substr($row["title"],0,35)."</td>
	                            </tr>
	                        </table>
	                    </td>
	                    <td class=\"picture\" align=\"center\"  style=\"background:".$color."\">
	                        <div style=\"background-image: url('".$row["photourl"]."');\" class=\"circle\"></div>
	                    </td>
	                </tr>
	            </table>
	            <table class=\"bottomcard\" style=\"border-top:5px solid ".$color.";\">
	                <tr>
	                    <td class=\"bio\">".$row["bio"]."</td>
	                </tr>
	                <tr>
	                    <td align=\"right\">
	                        <table style=\"min-height:40px\" class=\"contactinfotop\" align=\"right\">
	                            <tr>
	                                <td class=\"save\">".$bottomofcard."</td>
	                                ".$linkedin.$email.$phone.$weburl."
	                                </td>
	                            </tr>
	                        </table>
	                        
	                        <div style=\"display:none\" class=\"commentoncard\">".$row["note"]."</div>
	                        <div style=\"display:none\" class=\"cardevent\">".$row["event"]."</div>
	                        <table align=\"left\" style=\"display:none\" class=\"contactinfobottom\">
	                                <tr >"
	                                    .$linkedin.$tlinkedin."
	                                    
	                                </tr>
	                                <tr>"
	                                    .$email.$temail."
	                                    
	                                </tr>
	                                <tr>"
	                                    .$phone.$tphone."
	                                </tr>
	                                 <tr>"
	                                    .$weburl.$tweburl."
	                                </tr>
	                                <tr style=\"height:25px\">
	                                    <td class=\"save2\">".$bottomofcard."</td>
	                                </tr>
	                            </table>
	
	                
	                        
	                        
	                    </td>
	                </tr>
	            </table>
	        </div>
	    </div>
	</div>";


		if (strlen ($row["bio"])>5 && $row["photourl"]!="http://cardstak.com/uploads/profileimage.png"){
			$picbiocards[] = $output;
		}
		elseif(strlen ($row["bio"])<5 && $row["photourl"]!="http://cardstak.com/uploads/profileimage.png"){
			$piccards[] = $output;
		}
		elseif(strlen ($row["bio"])>5 && $row["photourl"]=="http://cardstak.com/uploads/profileimage.png"){
			$biocards[] = $output;
		}
		else{
			$emptycards[] = $output;
		}

	 $num+=1;
	 
	}
	foreach($picbiocards as $val) {echo $val;}
	foreach($piccards as $val) {echo $val;}
	foreach($biocards as $val) {echo $val;}
	foreach($emptycards as $val) {echo $val;}
}
	


$addcardoutput="
	  <div id=\"addcard\"  class=\"".$addcardclassname."\" ".$logintocreate." ".$addcardstyle.">
       		
	       		<a href=\"".$createurl."\" style=\"color:rgb(84, 84, 84);text-decoration:none\" class=\"addcardclass\">
	           		Add Your Card
	           	</a>
           	
    	</div>";
	
echo $addcardoutput;	





?>