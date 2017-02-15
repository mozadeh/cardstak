<?php

require_once 'Mandrill.php';
$mandrill = new Mandrill('B8Sm8xi3BNSIdoMVvWDHrQ');

if(!$_POST) exit;


if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");


$email    = $_POST['emailfrom'];
$replyemail    = $_POST['replyemail'];
$messageText = $_POST['emailmessage'];
$address = $_POST['emailto'];
$subject = $_POST['emailsubject'];
$fromname =!empty( $_POST['fromname']) ?  $_POST['fromname'] : $email ;
$toname = $_POST['toname'];
$eventurl = $_POST['eventurl'];
$title = $_POST['title'];
$pic = $_POST['pic'];
/*if ($replyemail=='no.reply@cardstak.com'){
	if(empty( $_POST['title']) ){
		$messageText = '<p>'.$messageText.'<br><br>To visit the Cardstak event page <a href="http://www.cardstak.com/'.$eventurl.'">click here</a><br><br>----------<br>Please do not reply to this email</p>';
	}
	else{
		$messageText = '<p>'.$messageText.'<br><br>To visit the Cardstak event page <a href="http://www.cardstak.com/'.$eventurl.'">click here</a><br><br>----------<br>Please do not reply to this email</p>';
	}
}
else{
	$messageText = '<p>'.$messageText.'<br><br>To visit the Cardstak event page <a href="http://www.cardstak.com/'.$eventurl.'">click here</a><br><br>----------<br>To reply to sender hit Reply or send an email to </p>';
	$messageText = '<p>'.$fromname.' <i>'.$title.'</i> sent you a message: ' .$messageText.'<br><br>To visit the Cardstak event page <a href="http://www.cardstak.com/'.$eventurl.'">click here</a></p>';
}*/
try{
 
        $message = array(
                'subject' => $subject ,
                'html' => $messageText, // or just use 'html' to support HTMl markup
                'from_email' => 'emailer@cardstak.com',
                'from_name' => $email, //optional
                'to' => array(
                        array( // add more sub-arrays for additional recipients
                                'email' => $address,
                                'name' => $toname, // optional
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
    echo $messageText;
} catch(Mandrill_Error $e) {
 
    echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
 
    throw $e;
}

?>