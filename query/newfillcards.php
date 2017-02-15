<?php
require_once('../config.php');
require("../common.php"); 


$nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: 'NA'; 
$lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: 'NA'; 
$createurl=str_replace("index.php","create_card.php",$_SESSION['location']);
$logintocreate="onclick=\"window.location.href = '$createurl';\"";

if($nmemberid=='NA' && $lmemberid=='NA'){
	$logintocreate= "onclick=\"showloginalert();\"";
	$createurl='#';
}

$firstN=htmlentities($_SESSION['user']['firstname'], ENT_QUOTES, 'UTF-8')?: 'NA'; 
$lastN=htmlentities($_SESSION['user']['lastname'], ENT_QUOTES, 'UTF-8')?: 'NA'; 

$userfullname=$firstN." ".$lastN;
if ( $userfullname == 'NA NA'){
	$userfullname="";
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
	$addcardstyle="style=\"left: 122.5px; top: 1000px; opacity: 0;filter: alpha(opacity=0);\"";
	$addcardclassname="block addcardclass";				
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
	 	
	 }
	 else{

	 	$email="<img onclick=\"openEmail('user$num','".$row["email"]."');\" class=\"dont_open cardicon\" src=\"images/nmail.png\" alt=\"image host\" title=\"send email\" height=\"27\" width=\"27\" onmouseover=\"this.src='images/mail_hover.png'\"
onmouseout=\"this.src='images/nmail.png'\"/>
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
	 	$cvlink=" <span class=\"dont_open\" onclick=\" opencv('".$row["cvlink"]."') \" >
	                                   <a target=\"_blank\">
	                                       <img src=\"images/newcvicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\"/ onmouseover=\"this.src='images/newcvicon_hover.png'\" onmouseout=\"this.src='images/newcvicon.png'\"></a>
	                                   </span>";
	 
	 	}	
	 	
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
	 
	$output = "
	<div class=\"".$row["cardgroup"]."\">
	 <div id=\"user".$num."\" class=\"block\" onclick=\"gotoEditCard();\">

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
		          <div style=\"display: grid;position: relative;width:215px;height: 250px;vertical-align: middle;padding-top: 80px;/* padding-left: 10px; */color: white;background: rgba(77, 77, 77, 0.56);\">Edit Your Card</div>
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
	          <span id=\"step2\" style=\"float:left;margin-left:10px\">	          
	                 <img src=\"images/sayhi.png\" title=\"say hi\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon dont_open\" onclick=\"sendHi('user$num','".$row["email"]."');trackActivity('".$row["fullname"]."','".$userfullname."','sendhi');\" style=\"margin-right: 3px;\" onmouseover=\"this.src='images/hi_hover.png'\" onmouseout=\"this.src='images/sayhi.png'\">
	                 
	               ".$email."
	              </span>
	
	
	          <span id=\"step3\" style=\"float:right;margin-right:10px\">
	          
	               ".$linkedin.$phone.$weburl.$cvlink."
	                             
	                </span>
	          <div style=\"display:none\" class=\"commentoncard\">".$row["note"]."</div>
	          <div style=\"display:none\" class=\"cardevent\">".$row["event"]."</div>
	
	
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
         cards.nmemberid != :nmemberid AND cards.lmemberid != :lmemberid AND cards.eventid=:eventid ORDER BY cards.fullname ASC"; 
         
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
	 	$bottomofcard="Update Card";
	 }
	 else{
	 	$bottomofcard="Save Card";
	 	$row["note"]='';
	 	//$bottomofcard=$nmemberid.$lmemberid.$row["lmemberid"].$row["nmemberid"];
	 }
	
	 if(is_null($row["email"])||$row["email"]=="NULLVAR"){
	 	$email="";
	 	$messaging="";
	 	
	 }
	 else{

	 	$email="<img onclick=\"openEmail('user$num','".$row["email"]."');trackActivity('".$row["fullname"]."','".$userfullname."','checkemail','".$row["id"]."');\" class=\"dont_open cardicon\" src=\"images/nmail.png\" alt=\"image host\" title=\"send email\" height=\"27\" width=\"27\" onmouseover=\"this.src='images/mail_hover.png'\"
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
	 	$phone="<span class=\"dont_open\" id=\"phone".$num."\" onclick=\"openPhone(this.id);trackActivity('".$row["fullname"]."','".$userfullname."','checkphone','".$row["id"]."');\">
	                                   <a target=\"_blank\">
	                                       <img src=\"images/newphoneicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\" onmouseover=\"this.src='images/newphoneicon_hover.png'\" onmouseout=\"this.src='images/newphoneicon.png'\"/></a>
	                                    <div class=\"cardphone\">".$row["phone"]."</div></span>";
	        }
	 
	 if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){
	 	$linkedin="";
	 }
	 else{
	 	$linkedin="<span class=\"dont_open\"><a href=\"".$row["linkedin"]."\" target=\"_blank\" onclick=\"trackActivity('".$row["fullname"]."','".$userfullname."','checklinkedin','".$row["id"]."');\" ><img src=\"images/newlinkedinicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\" onmouseover=\"this.src='images/newlinkedinicon_hover.png'\"
onmouseout=\"this.src='images/newlinkedinicon.png'\"/></a></span>";
	 	}
	 	
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){
	 	$weburl="";
	 }
	 else{
	 	$weburl="<span class=\"dont_open\"  >
	                                   <a href=\"".$row["weburl"]."\" target=\"_blank\">
	                                       <img src=\"images/newwebicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\"/ onmouseover=\"this.src='images/newwebicon_hover.png'\" onmouseout=\"this.src='images/newwebicon.png'\" onclick=\"trackActivity('".$row["fullname"]."','".$userfullname."','checkweb','".$row["id"]."');\"></a>
	                                   </span>";
	 	}	
	 
	 if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){
	 	$cvlink="";
	 }
	 else{
	 	$cvlink=" <span class=\"dont_open\" onclick=\"trackActivity('".$row["fullname"]."','".$userfullname."','checkcv','".$row["id"]."'); opencv('".$row["cvlink"]."') \" >
	                                   <a target=\"_blank\">
	                                       <img src=\"images/newcvicon.png\" alt=\"image host\" height=\"27\" width=\"27\" class=\"cardicon\"/ onmouseover=\"this.src='images/newcvicon_hover.png'\" onmouseout=\"this.src='images/newcvicon.png'\"></a>
	                                   </span>";
	 
	 	}	
	 	
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
	 $output = "
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
		          <div style=\"display: grid;position: relative;width: 215px;height: 250px;vertical-align: middle;padding-top: 80px;/* padding-left: 10px; */color: white;background: rgba(77, 77, 77, 0.56);\">".$messaging."<span class=\"save\">".$bottomofcard."</span></div>
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
	          <div style=\"display:none\" class=\"cardevent\">".$row["event"]."</div>
	
	
	        </td>
	      </tr>
	
	    </table>
	  </div>
	</div>
	</div>
	
	";


		/*if (strlen ($row["bio"])>5 && $row["photourl"]!="http://cardstak.com/uploads/profileimage.png"){
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
		}*/
		
		
		/*if($row["photourl"]!="http://cardstak.com/uploads/profileimage.png"){
			$piccards[] = $output;
		}
		elseif($row["photourl"]=="http://cardstak.com/uploads/profileimage.png"){
			$biocards[] = $output;
		}
		else{
			$emptycards[] = $output;
		}*/
		$piccards[] = $output;

	 $num+=1;
	 
	}
	//foreach($picbiocards as $val) {echo $val;}
	foreach($piccards as $val) {echo $val;}
	//foreach($biocards as $val) {echo $val;}
	//foreach($emptycards as $val) {echo $val;}
}
	

/*$addcardoutput="
	 <div id=\"addcard\"  class=\"".$addcardclassname."\" ".$logintocreate." ".$addcardstyle." >
       		
	       		<a href=\"".$createurl."\" style=\"color:rgb(84, 84, 84);text-decoration:none;margin-top:60px;display:block;\">
	           		Add Your Card
	           	</a>
	           	<span class=\"whyadd dont_open_why\" onclick=\"showWhy();\">
	           		why add your card?
	           	</span>
           	
    	</div>";
	
echo $addcardoutput;*/





?>