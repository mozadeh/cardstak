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
  <link rel="stylesheet" type="text/css" href="style/newcreatecardstyle.css">
  <title>Edit Card</title>
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-57633709-1', 'auto');
  ga('send', 'pageview');

</script>
  
  
<script type="text/javascript">
$(document).ready(function() { 
	var options = { 
			target: '#output',   // target element(s) to be updated with server response 
			beforeSubmit: beforeSubmit,  // pre-submit callback 
			success: afterSuccess,  // post-submit callback 
			resetForm: true        // reset the form after successful submit 
		}; 
	$("#imageInput").change(function(){
			$('#MyUploadForm').ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
	});	
		
	var optionscv = { 
			target:   '#output1',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmitcv,  // pre-submit callback 
			success:       afterSuccesscv,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#FileInput').change(function(){

			$('#MyUploadFormcv').ajaxSubmit(optionscv);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		}); 
}); 

function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	document.getElementById("update_card").disabled = false;
	document.getElementById("delete_card").disabled = false;

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#imageInput').val()) //check empty input filed
		{
			//$("#output").html("Are you kidding me?");
			//alert("Please Choose file first");
			sweetAlert("Oops...", "Please choose file first", "error");
			return false
		}
		
		var fsize = $('#imageInput')[0].files[0].size; //get file size
		var ftype = $('#imageInput')[0].files[0].type; // get file type
		

		//allow only valid image file types 
		switch(ftype)
        {
            case 'image/png': case 'image/gif': case 'image/jpeg': case 'image/pjpeg':
                break;
            default:
                //$("#output").html("<b>"+ftype+"</b> Unsupported file type!");
                var mes=ftype+" Unsupported file type!"
               //alert(mes);
               sweetAlert("Oops...", mes, "error");
				return false
        }
		
		//Allowed file size is less than 4 MB (1048576)
		if(fsize>4048576) 
		{
			var mes=bytesToSize(fsize)+" Too big Image file! Please reduce the size of your photo using an image editor."
               		sweetAlert("Oops...", mes, "error");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
		document.getElementById("update_card").disabled = true;
		document.getElementById("delete_card").disabled = true;
	}
	else
	{
		//Output error to older browsers that do not support HTML5 File API
		alert("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

function afterSuccesscv()
{
	$('#delete-btn').show(); //hide submit button
	//$('#loading-img').hide(); //hide submit button
	$('#progressbox').hide();
	//$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
	document.getElementById("update_card").disabled = false;
	document.getElementById("delete_card").disabled = false;
        if ( $('#formcv').val() == "") {
	  	document.getElementById("cardcv").style.display= 'none'; 	
	}
	else { 
	    	document.getElementById("cardcv").style.display = '';
    	}


}

//function to check file size before uploading.
function beforeSubmitcv(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$msg="Please choose a file first!";
            		sweetAlert("Oops...", $msg, "error");
			return false
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
		var ftype = $('#FileInput')[0].files[0].type; // get file type
		

		//allow file types 
		switch(ftype)
        {
            case 'image/png': 
			case 'image/gif': 
			case 'image/jpeg': 
			case 'image/pjpeg':
			case 'text/plain':
			case 'text/html':
			case 'application/x-zip-compressed':
			case 'application/pdf':
			case 'application/msword':
			case 'application/vnd.ms-excel':
			case 'video/mp4':
                break;
            default:
            	$msg=ftype+" Unsupported file type!";
            	sweetAlert("Oops...", $msg, "error");
               // $("#output1").html("<b>"+ftype+"</b> Unsupported file type!");
				return false
        }
		
		//Allowed file size is less than 5 MB (1048576)
		if(fsize>5242880) 
		{
			$msg=bytesToSize(fsize) +" File is too big, it should be less than 5 MB.";
			sweetAlert("Oops...", $msg, "error");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		//$('#loading-img').show(); //hide submit button
		$("#output1").html("");
		$('#FileInput').hide();  
		document.getElementById("update_card").disabled = true;
		document.getElementById("delete_card").disabled = true;
		
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output1").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}


//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

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


<body>

  
<div style="display:none">



<?php

 require("common.php"); 
 require_once('config.php');
 
  if (isset($_GET['event_id'])) {
	$event_id = $_GET['event_id'];}


if (isset($_GET['event_name'])) {
	$event = $_GET['event_name'];}
	
$eventurl="index.php?event_id=".$event_id;


 
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
    
    
    if( $_SESSION['user']['linkedinlogin']=="true" ){
    	$logoutlink='<a href="#" onclick="logout()"  style="color:black">Logout</a>';
    }
    else {
    	$logoutlink='<a href="logout.php"  style="color:black">Logout</a>';
    }
    
   
    $defaultbio='';
     
    $nmemberid=htmlentities($_SESSION['user']['nmemberid'], ENT_QUOTES, 'UTF-8')?: ''; 
    $lmemberid=htmlentities($_SESSION['user']['lmemberid'], ENT_QUOTES, 'UTF-8')?: ''; 
    
    
  
    
	 
	
	$query = "Select * FROM cards WHERE 
	               (nmemberid = :nmemberid OR lmemberid = :lmemberid) AND eventid=:eventid";
	  
	                
	$query_params = array(      
	        ':nmemberid' => $nmemberid,
	        ':lmemberid' => $lmemberid,
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
	
	$row=$rows[0];

    
	if(is_null($row["email"])||$row["email"]=="NULLVAR"){$row["email"]="";}
	
	
	if(is_null($row["phone"])||$row["phone"]=="NULLVAR"){$row["phone"]="";}
	
	if(is_null($row["linkedin"])||$row["linkedin"]=="NULLVAR"){$row["linkedin"]="";}
	
	if(is_null($row["weburl"])||$row["weburl"]=="NULLVAR"){$row["weburl"]="";}
	
	if(is_null($row["cvlink"])||$row["cvlink"]=="NULLVAR"){$row["cvlink"]="";}
	
	
	// s is card, n is form  
    
	    $firstname=htmlentities($_SESSION['user']['firstname'], ENT_QUOTES, 'UTF-8');
	    $lastname=htmlentities($_SESSION['user']['lastname'], ENT_QUOTES, 'UTF-8');
	    $nosavedemail=htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8')?: ''; 
	    $semail=$row["email"]?: $nosavedemail;  	
	        
	    $replacentitle=substr(htmlentities($_SESSION['user']['title'], ENT_QUOTES, 'UTF-8'),0,35) ?: '';
	    $replacestitle=substr(htmlentities($_SESSION['user']['title'], ENT_QUOTES, 'UTF-8'),0,35) ?: 'Student, UC Berkeley';
	    $ntitle=$row["title"]?: $replacentitle;  
	    $stitle=$row["title"]?: $replacestitle;  
	   
	    $replacepic=htmlentities($_SESSION['user']['picurl'], ENT_QUOTES, 'UTF-8')?: 'http://cardstak.com/uploads/profileimage.png';  
	    $spicurl=$row["photourl"]?: $replacepic;
	    if($spicurl=='undefined') $spicurl='http://cardstak.com/uploads/profileimage.png';
	    $replacelinkedin=htmlentities($_SESSION['user']['linkedinurl'], ENT_QUOTES, 'UTF-8')?: '';  
	    
	    $slinkedinurl=$row["linkedin"]?: $replacelinkedin;  
	    //$replacenbio=htmlentities($_SESSION['user']['bio'], ENT_QUOTES, 'UTF-8') ?: '';  
	    //$nbio=$row["bio"] ?: $replacenbio;   
	    //$replacesbio=htmlentities($_SESSION['user']['bio'], ENT_QUOTES, 'UTF-8') ?: $defaultbio;
	    //$sbio=$row["bio"] ?: $replacesbio;
	    //$biolength=strlen($sbio);
	    //$sbio=substr($sbio,0,min(350,$biolength));
	    //if ($biolength>350) {$sbio="$sbio...";}
	    //$nbio=$sbio ?: '';
	    $nbio=$row["bio"];
	    $sbio=$row["bio"];
	    //$nbio=$row["bio"] ? $sbio: '';  
	    if (htmlentities($_SESSION['user']['bio'], ENT_QUOTES, 'UTF-8')=="undefined" ) { $nbio=""; $sbio=$defaultbio;}
	    $lastlength=strlen($lastname);
	    $cutlastlenght=min($lastlength,21);
	    $firstlength=min(strlen($firstname),(21-$lastlength));
	    $sfullname= $row["fullname"]?:substr($firstname,0,$firstlength).' '.substr($lastname,0,$cutlastlenght);   
    
            $sphone=$row["phone"];
            $sweb=$row["weburl"];	
	    $cvlink=$row["cvlink"];
    
            $check1='';
            $check2='';
            $check3='';
            $color1="rgb(52, 152, 219)";
	    $tcolor1="rgb(149, 211, 255)";
	    $color2="rgb(56, 174, 160)";
	    $tcolor2="rgb(142, 232, 221)";
	    $color3="rgb(149, 165, 166)";
	    $tcolor3="rgb(228, 228, 228)";
            if($row["cardgroup"]=='1'){$check1='checked'; $color=$color1;  $tcolor=$tcolor1;}
            if($row["cardgroup"]=='2'){$check2='checked'; $color=$color2;  $tcolor=$tcolor2;}
            if($row["cardgroup"]=='3'){$check3='checked'; $color=$color3;  $tcolor=$tcolor3;}
            	
   
	

if (isset($_COOKIE['action'])) {
  // action already done
} else {
  setcookie('action');
  // run query

$picurl="my photo.png";

if (basename($_FILES["fileToUpload"]["name"])!=""){
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
     	//$alertval= "alert(\"File is an image - " . $check["mime"] . ".\")";
        //echo '<script language="javascript">';;
	//echo $alertval;
	//echo '</script>';
        $uploadOk = 1;
    } else {
        $alertval= "alert(\"File is not an image.\")";
        echo '<script language="javascript">';;
	echo $alertval;
	echo '</script>';
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    $alertval= "alert(\"Sorry, file already exists.\")";
	echo '<script language="javascript">';;
	echo $alertval;
	echo '</script>';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    $alertval= "alert(\"Sorry, your file is too large.\")";
	echo '<script language="javascript">';;
	echo $alertval;
	echo '</script>';
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	$alertval= "alert(\"Sorry, only JPG, JPEG, PNG & GIF files are allowed.\")";
	echo '<script language="javascript">';;
	echo $alertval;
	echo '</script>';
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $alertval= "alert(\"The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.\")";
        echo '<script language="javascript">';
	echo $alertval;
	echo '</script>';
    } else {
    	 $alertval= "alert(\"Sorry, there was an error uploading your file.\")";
        echo '<script language="javascript">';
	echo $alertval;
	echo '</script>';
    }
   
}}
}



?>

</div>

<div style="display:none" id="eventtag"><?=$event?></div>
<div style="display:none" id="eventid"><?=$event_id?></div>	

<div id="top-menu" style="display:none">
        <div class="menu-center">
            <table style="width:100%;border-collapse: collapse;
	border-spacing: 0;font-size: 2.5vw;" cellspacing="0">
                <tr style="height:40px">
                    <td style="width:20%;text-align:center"> <a href="http://www.cardstak.com" style="color:#79a09c">Cardstak</a>

                    </td>
                    <td style="width:20%;text-align:center" > <a href="http://www.cardstak.com">Customize Your Card</a>

                    </td>
                    <td style="width:20%;text-align:center;"> <a href="<?=$eventurl?>" style="color:#79a09c" id="event"><?=$event?></a>

                    </td>
                </tr>
                <tr id="tmenu-bottom" align="right">
                
                    <td class="topbutton"> <?=$logoutlink?>

                    </td>

                </tr>
            </table>
        </div>
    </div>







<table style="border-spacing:0px; padding-top:0px;padding-top:4%;" align="center">
    <!--<tr>
        <td style="padding:0px;">
            <div class="pagetitle" align="center">customize your card</div>
            <a href="index.php" style="text-decoration: none;"><div class="eventtitle" align="center" id="event">UC Berkeley Networking Event</div></a>
        </td>
    </tr>-->
    <tr>
        <td class="tablestyle">
           <div id="wrapper">  
        
            <table align="center" style="border-spacing:0px;">
                <tr >
                    
                    <td class="leftround">
                       
                             
                        
                        
                       
                        
                        
                        
                            <table style="color:#4c4c4c;text-align:right;">
                            
                            <form action="query/processupload.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
                            <tr>
  				<td></td>            
  					<td align="center" style="padding-bottom: 5px;padding-top: 8px;"> 
                                   		 <div style="font-size: 12pt;color:#A02B4F;font-family: aria,sans-serif;text-align: right;" align="right"> * <span style="color: #4C4C4C;font-size: 10pt;font-style: italic;">indicates required field</span>
                                   		 </div>
                                   		
                                   	</td>
                                </tr>
                                <tr>
                                	<td class="imageupload" style="text-align:right;"> 
                                   		<label for="imageInput">Image</label>
                                	</td>
                                	
                                	<td  >
                                        
	                                    <input name="image_file" id="imageInput" type="file" style="width:230px" class="picuploader"/>
					
					<img src="images/ajax-loader.gif" id="loading-img" style="display:none;float:right" alt="Please Wait"/>
	                                  
	                                </td>
                                </tr>
                                </form>
                            
                            
                            <form>
                            	<tr style="margin-top:5px;margin-bottom:5px">
                                    <td>
                                        <label id="rolelabel"><span style="font-size:12pt;color:#A02B4F;">*</span> Role</label>
                                    </td>
                                    <td>
                                        
	                                    <form><table align="center" style="border-spacing:0px;display:none;width:100%" id="grouptable">
	                        <tr class="inputstyle">
		                                	<td  style="max-width: 260px;">
		                               <label id="g1buttonback" style="display:block;"><input type="radio" name="group" value="1"  <?=$check1?>/><span id="g1button" class="radioitem"></span></label>
						
						<label id="g2buttonback" style="display:block;"><input type="radio" name="group" value="2"  <?=$check2?>/><span id="g2button" class="radioitem"></span></label>
						
						<label id="g3buttonback" style="display:block;"><input type="radio" name="group" value="3"  <?=$check3?>/><span id="g3button" class="radioitem"></span></label>
						</td>
						
	                        </tr></table> </form>
	                        <div id="loaderdiv" align="center"><img src="images/loader.gif" id="loadergif" alt="Please Wait"/></div>    
                                        
                                                                            
                                    </td>
                                </tr>
                            
                            	
                                <tr>
                                    <td>
                                        <label for="name"><span style="font-size:12pt;color:#A02B4F;">*</span> Full Name</label>
                                    </td>
                                    <td>
                                        <input id="formname" type="text" class="inputform" value="<?=$sfullname?>" id="name" placeholder="John Smith" maxlength="22"  />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="title"><span style="font-size:12pt;color:#A02B4F;">*</span> Title</label>
                                    </td>
                                    <td>
                                        <input id="formtitle" type="text" class="inputform" id="title" placeholder="Student, UC Berkeley" maxlength="35" value="<?=$ntitle?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="bio">About Me<br/><span style="font-size:13px;">(max 350 chars)</span></label>
                                    </td>
                                    <td>
                                        <textarea id="formbio"  class="inputform" rows="8" placeholder="A second year Computer Science undergraduate student at UC Berkeley with an interest in Artifical Intelligence and Social Media. Seeking a summer internship." maxlength="350" ><?=$nbio?></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="formcv">Resume</label>
                                    </td>
                                    <td style="height:33px">
                                    	<div id="output1">
                                        	<input id="formcv" type="text" style="width:230px;display:none" placeholder="www.dropbox.com/mycv.pdf" value="<?=$cvlink?>" /> 
                                        </div> 
                                        <div id="upload-wrapper">
						
						<form action="query/processupload_cv.php" method="post" enctype="multipart/form-data" id="MyUploadFormcv" style="display:inline">
						<input name="FileInput" id="FileInput" type="file" style="width:230px"/>
						<!--<input type="submit"  id="submit-btn" value="Upload"  />-->
						<input  id="delete-btn" value="Delete" onclick="removeCV();"/>
						<!--<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>-->
						</form>
						<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
						
						
					</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="linkedinurl">LinkedIn URL</label>
                                    </td>
                                    <td>
                                        <input id="formlinkedin" type="text" class="inputform" placeholder="www.linkedin.com/in/johnsmith/" value="<?=$slinkedinurl?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="emailaddress">Email Address</label>
                                    </td>
                                    <td>
                                        <input id="formemail" type="text" class="inputform"  placeholder="johnsmith@gmail.com" value="<?=$semail?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="phonenumber">Phone Number</label>
                                    </td>
                                    <td>
                                        <input id="formphone" type="text" class="inputform" placeholder="123-456-7890" value="<?=$sphone?>"/>
                                    </td>
                                    <input id="formnmemberid" type="text" style="display:none"  value="<?=$nmemberid?>"/>
                                    <input id="formlmemberid" type="text" style="display:none" value="<?=$lmemberid?>"/>
                                </tr>
                                 <tr>
                                    <td>
                                        <label for="phonenumber">Website URL</label>
                                    </td>
                                    <td>
                                        <input id="formweb" type="text" class="inputform" placeholder="http://www.mysite.com" value="<?=$sweb?>"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <table style="padding-top: 30;">
		                   <tr>
					<td  style="padding-bottom:20px;" align="center">
						<input type="button" id="update_card" onclick="myFunction()" align="center" value="Update Card" />
						<input type="button" id="delete_card"  onclick="myDeleteFunction()" align="center" value="Delete Card" />
						
					</td>
					
					
					<td  style="padding-bottom:20px" align="center">
						  <?=$backbutton?> 
						  
							    
					</td>

				</tr>
			  </table>
                    </td>
                    <!-- right side of table -->
                      <td style="width: 300px;height: 520px;vertical-align: top; padding:0px;" class="rightround">
                       
                        <div style="padding-left:20px; padding-right:20px;padding-top:10px">
                        	<div id="user1" class="block">
					<table class="topcard" style="width: 215px;">
			     			 <tr>
			        			<td id="output" class="picture" align="center" style="cursor:pointer" onclick="$('#imageInput').trigger('click');">
			         				<div id="photourldb" style="background-image: url('<?=$spicurl?>');" class="circle"></div>
			        			</td>
			      			</tr>
			      
			     			<tr class="cardnameback">
			        			<td style="width: 215px;text-align: left;position:absolute;">
			          				<div class="cardname" style="display: grid;position: relative;width: 100%;height: 35px;padding-top: 5px;padding-left: 10px;color: white;background: rgba(127, 140, 141, 0.68);" id="name"><?=$sfullname?></div> 
			        			</td>
			      			</tr>
			    		</table>
			
			    		<table class="middlecard">
			
						<tr style="width:215px;display:flex">
					        	 <td class="bio" style="word-wrap: break-word;"><span class="cardtitle" id="title" style="padding-top: 10px;"><?=$stitle?></span><span id="bio"><?=$sbio?></span>
					        	</td>
					      </tr>
			    		</table>
			    		
			    		<table class="bottomcard">
			      			<tr>
			        			<td style="width:215px;padding-top: 5px;">
			          				<span style="float:left;margin-left:10px">	          
							                
							                <img src="images/sayhi.png" title="say hi" alt="image host" height="25" width="25" class="cardicon dont_open" style="margin-right: 3px;" onmouseover="this.src='images/hi_hover.png'" onmouseout="this.src='images/sayhi.png'">              
							                
							                <img id="cardemail" class="dont_open cardicon" src="images/nmail.png" alt="image host" title="send email" height="25" width="25" onmouseover="this.src='images/mail_hover.png'" onmouseout="this.src='images/nmail.png'">
			 	
			              				</span>
			
			          				<span style="float:right;margin-right:10px">
			          
			               					<span class="dont_open" id="cardlinkedin">
			               						<a target="_blank" >
			               							<img src="images/newlinkedinicon.png" alt="image host" height="25" width="25" class="cardicon" onmouseover="this.src='images/newlinkedinicon_hover.png'" onmouseout="this.src='images/newlinkedinicon.png'">
			               						</a></span>
			               					<span class="dont_open" id="cardphone">
			                                  			<a target="_blank">
			                                       				<img src="images/newphoneicon.png" alt="image host" height="25" width="25" class="cardicon" onmouseover="this.src='images/newphoneicon_hover.png'" onmouseout="this.src='images/newphoneicon.png'">
			                                       			</a>
			                                    		</span>
			                                    		
			                                    		<span class="dont_open" id="cardweb">
			                                   			<a target="_blank">
			                                       				<img src="images/newwebicon.png" alt="image host" height="25" width="25" class="cardicon" onmouseover="this.src='images/newwebicon_hover.png'" onmouseout="this.src='images/newwebicon.png'">
			                                       			</a>
			                                   		</span> 
			                                   		
			                                   		<span class="dont_open" id="cardcv">
			                                   			<a target="_blank">
			                                       				<img src="images/newcvicon.png" alt="image host" height="25" width="25" class="cardicon" onmouseover="this.src='images/newcvicon_hover.png'" onmouseout="this.src='images/newcvicon.png'"></a>
			                                   		</span>
			                             
			               				 </span>
			          			</td>
			      			</tr>
					</table>
				</div>
			</div> 
                    </td>
                </tr>
                
		
		
            </table>
            </div>
        </td>
    </tr>
   
    
</table>

<script type="text/javascript" src="js/jscript.editcard.js" > </script>




    </body>
    
    
  </html>
  
 
 
 