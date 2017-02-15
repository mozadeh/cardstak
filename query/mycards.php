<?php
require_once('../config.php');


 

$query = "Select * FROM savedcards,cards WHERE 
               (savedcards.nmemberid = :nmemberid OR savedcards.lmemberid = :lmemberid) AND savedcards.cardid=cards.id  ORDER BY savedcards.created DESC";
  
                
$query_params = array(      
        ':nmemberid' => $_POST['nmemberid'],
        ':lmemberid' => $_POST['lmemberid']
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

    
//$rows = $stmt->fetchAll();

//while($row = $stmt->fetch()) {

	 if(is_null($row["email"])||$row["email"]=="NULLVAR"){
	 	$email="";
	 	$temail="";
	 }
	 else{
	 	/*$email="
	 <td><a href=\"https://mail.google.com/mail/?view=cm&amp;fs=1&amp;to=".$row["email"]."&su=".$_POST['event']."\" target=\"_blank\" class=\"dont_open\"><img src=\"http://smartikymail.com/webservice/cards/mailicon.png\" alt=\"image host\" height=\"30\" width=\"30\"/></a></td>";*/
	 	$email="<img onclick=\"openEmail('user$num','".$row["email"]."');\" class=\"dont_open cardicon\" src=\"images/nmail.png\" alt=\"image host\" height=\"29\" width=\"29\"/>";
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
	 	
	 if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){
	 	$cvlink="";
	 }
	 else{
	 	$cvlink="<td><a href=\"".$row["cvlink"]."\" target=\"_blank\" class=\"dont_open\"><img src=\"images/cv.png\" alt=\"image host\" height=\"30\" width=\"30\" class=\"cardicon\"/></a> </td>";
	 	}				
	 	
	 if(is_null($row["cardgroup"])||$row["cardgroup"]=="NULLVAR"){
	 	$color="rgb(36, 127, 189)";
	 }
	 else{
	 	//$color="rgb(36, 127, 189)";  
	 	//$tcolor="rgb(94, 180, 239)";
	 	$color="rgb(36, 127, 189)";  
	 	$tcolor="#ffffff";
	 	//if ($row["group"]==1) {$color="rgb(36, 127, 189)";  $tcolor="rgb(94, 180, 239)";}
	 	//if ($row["group"]==2) {$color="rgb(48, 152, 139)";  $tcolor="rgb(103, 192, 181)";}
	 	//if ($row["group"]==3) {$color="rgb(160, 77, 182)";  $tcolor="rgb(207, 139, 226)";}
	 }
	 
	 //$row["note"] = str_replace("&amp;", "&", $row["note"]);
	 
	 $output="
	 <div class=\"".$row["cardgroup"]."\">
	 <div id=\"user".$num."\" class=\"block\" onclick=\"addComment(this.id);\" style=\"opacity: 0;filter: alpha(opacity=0);\">
	 	<div class=\"cardid\" style=\"display:none\">".$row["id"]."</div>
	        <div class=\"hover\">
	            <table class=\"topcard \" id=\"top_card_user".$num."\">
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
	                        <table style=\"min-height:40px;height:40px;\" class=\"contactinfotop\" align=\"right\">
	                            <tr>
	                                <td class=\"connect\">
	                            	<img src=\"images/sayhi.png\" title=\"say hi\" alt=\"image host\" height=\"29\" width=\"29\" class=\"cardicon dont_open\" onclick=\"sendHi('user$num','".$row["email"]."');\" style=\"margin-right: 3px;\">
	                            	".$email."
	                            	</td>
	                                <td class=\"save\">edit</td>
	                                ".$linkedin.$phone.$weburl.$cvlink."
	                                </td>
	                            </tr>
	                        </table>
	                        
	                        <div style=\"display:none\" class=\"commentoncard\">".$row["note"]."</div>
	                       <div style=\"display:none\" class=\"cardevent\"><a href=\"index.php?event_id=".$row["eventid"]."\" class=\"savedcardevent\">".$row["event"]."</a></div>
	                       <div style=\"display:none\" class=\"cardrole\">".$row["role"]."</div>
	                        
	                        
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

//$mysqli->close();


?>