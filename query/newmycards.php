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
	 	$messaging="";
	 }
	 else{

	 	$email="<img onclick=\"openEmail('user$num','".$row["email"]."')\" class=\"dont_open cardicon\" src=\"images/nmail.png\" alt=\"image host\" title=\"send email\" height=\"25\" width=\"25\" onmouseover=\"this.src='images/mail_hover.png'\"
onmouseout=\"this.src='images/nmail.png'\"/>
	 	";
	 	$messaging="<table style=\"top: -60px;position: relative;\"><tr >
	 			<td ><img src=\"images/w_sendhi.png\" style=\"width: 100px;\" onclick=\"sendHi('user$num','".$row["email"]."');trackActivity('".$row["fullname"]."','".$userfullname."','sendhi');\" onmouseover=\"this.src='images/g_sendhi.png'\" onmouseout=\"this.src='images/w_sendhi.png'\" class=\"dont_open\">
			</td><td>
			<img src=\"images/w_message.png\" style=\"width: 100px;\" onclick=\"openEmail('user$num','".$row["email"]."');trackActivity('".$row["fullname"]."','".$userfullname."','checkemail','".$row["id"]."');\" onmouseover=\"this.src='images/b_message.png'\" onmouseout=\"this.src='images/w_message.png'\" class=\"dont_open\">
			</td></tr></tbody></table>
		";
	 	}
	 
	 if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){
	 	$phone="";
	 	
	 }
	 else{
	 	$phone="<span class=\"dont_open\" id=\"phone".$num."\" onclick=\"openPhone(this.id); \" >
	                                   <a target=\"_blank\">
	                                       <img src=\"images/newphoneicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\" onmouseover=\"this.src='images/newphoneicon_hover.png'\" onmouseout=\"this.src='images/newphoneicon.png'\"/></a>
	                                    <div class=\"cardphone\">".$row["phone"]."</div></span>";
	        }
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 }
	 else{
	 	$linkedin="<span class=\"dont_open\"><a href=\"".$row["linkedin"]."\" target=\"_blank\"><img src=\"images/newlinkedinicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\" onmouseover=\"this.src='images/newlinkedinicon_hover.png'\"
onmouseout=\"this.src='images/newlinkedinicon.png'\"/></a></span>";
	 	}
	 	
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 }
	 else{
	 	$weburl="<span class=\"dont_open\"  >
	                                   <a href=\"".$row["weburl"]."\" target=\"_blank\">
	                                       <img src=\"images/newwebicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\"/ onmouseover=\"this.src='images/newwebicon_hover.png'\" onmouseout=\"this.src='images/newwebicon.png'\"></a>
	                                   </span>";
	 	}	
	 
	 if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){
	 	$cvlink="";
	 }
	 else{
	 	$cvlink=" <span class=\"dont_open\" opencv('".$row["cvlink"]."') \" >
	                                   <a target=\"_blank\">
	                                       <img src=\"images/newcvicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\"/ onmouseover=\"this.src='images/newcvicon_hover.png'\" onmouseout=\"this.src='images/newcvicon.png'\"></a>
	                                   </span>";
	 
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
	 <div id=\"user".$num."\" class=\"block\" onclick=\"addComment(this.id);\">

	  <div class=\"cardid\" style=\"display:none\">".$row["id"]."</div>
	  <div class=\"hover\">
	    <table class=\"topcard\" id=\"top_card_user".$num."\" style=\"width: 215px;\">
	
	      <tr>
	        <td class=\"picture\" align=\"center\" style=\"background:#fff\">
	          <div style=\"background-image: url('".$row["photourl"]."');\" class=\"circle\"></div>
	        </td>
	      </tr>
	      
	      <tr class=\"cardnameback\">
	        <td style=\"width: 215px;text-align: left;\">
	          <div class=\"cardname\" style=\"display: grid;position: relative;width: 100%;height: 35px;padding-top: 5px;padding-left: 10px;color: white;background: rgba(127, 140, 141, 0.68);\">".$row["fullname"]."</div> 
	        </td>
	      </tr>
	      
	      
	      <tr class=\"savehover\">
		        <td style=\"width: 215px;text-align: center;\">
		          <div style=\"display: grid;position: relative;width: 215px;height: 250px;vertical-align: middle;padding-top: 80px;/* padding-left: 10px; */color: white;background: rgba(77, 77, 77, 0.56);\">".$messaging."<span class=\"save\">Update Card</span></div>
		        </td>
		</tr>
	      
	      
	      
	      
	
	    </table>
	
	    <table class=\"middlecard\">
	
	      <tr style=\"width:215px;display:flex\">
	        <td class=\"bio\"><span class=\"cardtitle\">".$row["title"]."</span>".$row["bio"]."</td>
	      </tr>
	    </table>
	    <table class=\"bottomcard\">
	      <tr>
	        <td style=\"width:215px\">
	          <span style=\"float:left;margin-left:10px\">	          
	                 <img src=\"images/sayhi.png\" title=\"say hi\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon dont_open\" onclick=\"sendHi('user$num','".$row["email"]."');trackActivity('".$row["fullname"]."','".$userfullname."','sendhi');\" style=\"margin-right: 3px;\" onmouseover=\"this.src='images/hi_hover.png'\" onmouseout=\"this.src='images/sayhi.png'\">              
	               ".$email."
	              </span>
	
	          <span style=\"float:right;margin-right:10px\">
	          
	               ".$linkedin.$phone.$weburl.$cvlink."
	                             
	                </span>
	       <div style=\"display:none\" class=\"commentoncard\">".$row["note"]."</div>
               <div style=\"display:none\" class=\"cardevent\"><a href=\"index.php?event_id=".$row["eventid"]."\" class=\"savedcardevent\">".$row["event"]."</a></div>
               <div style=\"display:none\" class=\"cardrole\">".$row["role"]."</div>
	
	
	        </td>
	      </tr>
	
	    </table>
	  </div>
	</div>
	</div>
	";
	
	 echo $output;
	 $num+=1;


	}
}

//$mysqli->close();


?>