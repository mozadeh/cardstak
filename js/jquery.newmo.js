var colCount = 0;
var colWidth = 350;
var margin = 30;
var spaceLeft = 0;
var windowWidth = 0;
var blocks = []; 
var removebio = true;
var hidegroupone=true;
var hidegrouptwo=true;
var hidegroupthree=true;
var searching=false;
var bottomofpage=0;
var firstload=1;
var timeoutcounterfillcards=5000;
var timeoutcountermycards=5000;
var timeoutcountercheckcard=10000;
var timeoutcountercheckevent=3000;
var timeoutcountersendemail=10000;
var timeoutcountersavecard=3000;
var timeoutcountereditcard=3000;
var timeoutcounterdeletesavedcard=3000;
var timeoutcountermyevents=3000;
var timeoutcounterdeleteevent=6000;
var groupno=0;
var createurl;
var eventurl;
var savestate;
var eventname;
var usersid;
var boardopen=false;
var boardwidth=0;
var boardsize=300;
var onphone=false;
var pageInitialized = false;
var wizload=false;
var cardtop;
var preview;
var firstTime=true;
var state="nologin";
var fillquery = "query/newfillcards.php";
var fillmyquery= "query/newmycards.php";
var loaderHTML='<div style=\"width: 100%;position: fixed;top: 300px;padding-left: auto;\" >\r\n<div class=\"sk-folding-cube\">\r\n\t  <div class=\"sk-cube1 sk-cube\" ><\/div>\r\n\t  <div class=\"sk-cube2 sk-cube\"><\/div>\r\n\t  <div class=\"sk-cube4 sk-cube\">CS<\/div>\r\n\t  <div class=\"sk-cube3 sk-cube\" ><\/div>\r\n\t<\/div>\r\n<\/div>';


$(function () {

    windowWidth = $(window).width();
	var mobile = getUrlParameter('mobile');
	if(windowWidth <500) {
		if(mobile!='yes'){
			window.location.href = window.location.href + "&mobile=yes";
		}
		fillquery = "query/addfillcards.php";
		fillmyquery= "query/mycards.php";	
	}
	else {
		   	 
	}	
 	
    $(window).resize(setupBlocks);
    $(window).resize(placebottombar);
    
    
    /* $("#sendcard").mouseover(function() {
        $("#sendcard").html('<img src="http://www.cardstak.com/images/sendcard_black.png" style="height: 12px;margin-right: 4px;">Send Card</td>');
    }).mouseout(function() {
        $("#sendcard").html('<img src="http://www.cardstak.com/images/sendcard.png" style="height: 12px;margin-right: 4px;">Send Card</td>');
    }); */
    
    
});

function onLinkedInLoad() {
  IN.Event.on(
    IN
    , "auth"
    , function() {
      Instant().onAuth();
    }
  );
};

function skipwiz(){
	wizload=false;
	closeWhy();
	setTimeout(function() { document.getElementById("whyaddbt").style.display="none"}, 1000);
	setTimeout(function() { document.getElementById("whyaddb").value="close"}, 1000);
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


function startrankintro(){
	//scrolling to top first
	
	document.body.scrollTop = document.documentElement.scrollTop = 0;
	
	var intro = introJs();
	
          intro.setOptions({
            steps: [
              {
                element: document.querySelector('#ranksection'),
                intro: "Your card rank is based on how many people clicked on your CV, LinkedIn, Phone and Website",
                position: 'right'
              },
              {
                element: document.querySelectorAll('#step2')[0],
                intro: "Don't be shy, reach out and make new connections",
                position: 'top'
              },
              {
                element: '#step3',
                intro: 'The more links you add here, the easier it gets to know about you',
                 position: 'top'
              },
              {
                element: '#user1',
                intro: 'Save cards and takes notes by clicking on them',
                 position: 'right'
              }
            ]
          });
          
          intro.setOption('scrollToElement', false);
          intro.setOption('showProgress', true).start();
          
}

function givesharetips(){
	
	
	 if (RegExp('givesharetips', 'gi').test(window.location.search)  && $(window).width()>500  ) {
		var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: '#at4-share',
		                intro: 'Now, use these sharing options to invite others to this Stak',
		                position: 'left'
		              }
		            ]
		          });
		var event_id = document.getElementById("eventid").innerHTML;
		var urlchanged="http://www.cardstak.com/index.php?event_id="+event_id;
		window.history.pushState("string", "Title", urlchanged);  
		
		
		addthis.update('share', 'url', urlchanged); 
		addthis.url = urlchanged;                
		addthis.toolbox(".addthis_toolbox");
		
		        		
		intro.start();	
	}

}






function eventSpecificafter(){
	var event_id = document.getElementById("eventid").innerHTML;
	if(event_id=='tz9mXMfVCL' || event_id=='N9eVwYp479'){
		document.getElementById("addcard").style.display="none";
		}
}


function eventSpecificbefore(){
	var event_id = document.getElementById("eventid").innerHTML;
	
	if(event_id=='tz9mXMfVCL'){
	document.getElementById("eventtd").innerHTML='<img src=\"http://cardstak.com/images/callogo.png" border=\"0\" alt=\"\" style=\"\/* height: 40px; *\/width: 50px;vertical-align: bottom; padding-bottom:2px\">  <div id=\"event\" style=\"color:#FFFFFF;font-family:\'Pathway Gothic One\', sans-serif;display: inline;\">UC Berkeley Entrepreneurs Happy Hour<\/div>\t';
	}
	
	if(event_id=='N9eVwYp479'){
	document.getElementById("eventtd").innerHTML='<img src=\"http:\/\/cardstak.com\/images\/BTLogo.png\" border=\"0\" alt=\"\" style=\"\/* height: 40px; *\/width: 40px;vertical-align: bottom; padding-bottom:2px;border-radius: 10px;\">\r\n  <div id=\"event\" style=\"color: rgb(255, 255, 255); font-family: \'Pathway Gothic One\', sans-serif; font-size: 19pt;display: inline;\">BTN State of Cloud<\/div>';
	}
	
	if(event_id=='tz9mXMfVCL' || event_id=='N9eVwYp479'){
 		
 		//document.getElementById("loginbutton").style.display="none";
 		document.getElementById("addcardbutton").style.display="none";
		$(".cardtitle").css("fontSize", "13pt");  
		
		
		
		document.getElementById("contact").innerHTML='<form method=\"post\" action=\"contact.php\" name=\"contactform\" id=\"contactform\" class=\"form c-form contactbox\" >\r\n\t\t\t<fieldset style=\"text-align:center;border:0px;padding-top:10px;padding-bottom:20px;font-family:Arial,sans-serif;font-size:10pt\">\r\n\t\t\t\t<table align=\"center\"><tr><td><span style=\"font-size:16pt;padding-bottom:20px\">Email Address:<\/span>\r\n\t\t\t\t<b style=\"font-size:16pt;padding-bottom:20px;\" id=\"contactname\">Firstname Lastname<\/b><\/td>\r\n\t\t\t\t<td id=\"contactpicture\"><div style=\"background-image: url(\'http:\/\/www.cardstak.com\/images\/profilepics\/profile_picture_2927.jpg\');\" class=\"commentpicture\"><\/div><\/td><\/td><\/table>\r\n\t\t\t\t<table  style=\"margin-top:20px;width:100%;border-spacing:0px\"><tr style=\"vertical-align:baseline\"><td style=\"display:none\">\r\n\t\t\t\t<input name=\"contactemailfrom\" type=\"text\" id=\"contactemailfrom\" placeholder=\"Your E-mail\"\/>\r\n\t\t\t\t<\/td>\r\n\t\t\t\t\r\n\t\t\t\t<td>\r\n\t\t\t\t<input name=\"contactemailto\" type=\"text\" id=\"contactemailto\" placeholder=\"E-mail to\"\/>\r\n\t\t\t\t<\/div>\r\n\t\t\t\t<\/td>\r\n\t\t\t\t<\/tr><\/table>\r\n\t\t\t\t<table  style=\"width:100%;border-spacing:0px\">\r\n\t\t\t\t<tr style=\"display:none\"><td style=\"width:65px;padding-bottom:10px\">\r\n\t\t\t\t<label for=\"contactsubject\" style=\"font-weight:bold\">Subject:<\/label>\r\n\t\t\t\t<\/td><td>\r\n\t\t\t\t<input name=\"contactsubject\" type=\"text\" id=\"contactsubject\" placeholder=\"Subject\" \/>\r\n\t\t\t\t<\/td><\/td><tr style=\"display:none\"><td>\r\n\t\t\t\t<textarea name=\"contactmessage\" id=\"contactmessage\" placeholder=\"Example: We should meet\" style=\"height:80px;margin:0px\"><\/textarea>\r\n\t\t\t\t<\/td><\/tr><\/table>\r\n\t\t\t\t<input type=\"button\" onclick=\"closeContact();\" value=\"cancel\"  style=\"width:100px;margin-bottom:0px\"\/>\r\n\t\t\t\t<input type=\"button\" onclick=\"sendEmail();\" id=\"contactsendemail\" value=\"send\" style=\"width:100px;margin-bottom:0px;display:none\"\/>\r\n\t\t\t\t\r\n\t\t\t<\/fieldset>\r\n\t\t\t<div align=\"right\" style=\"font-size:14pt;padding-right:20px;padding-bottom:10px;color:black;padding-top:10px\"><i style=\"vertical-align:bottom\">use another Email service<\/i> <a id=\"gmailcontact\" href=\"#\" target=\"_blank\" class=\"dont_open\"> <img style=\"height: 50px;vertical-align: middle;padding-left:10px\" src=\"images\/gmail_icon.png\"><\/a> <a id=\"yahoocontact\" href=\"#\" target=\"_blank\" class=\"dont_open\"> <img style=\"height: 50px;vertical-align: middle;padding-left:10px\" src=\"images\/yahoo_icon.png\"><\/a><\/div>\r\n\t\t\t<\/form>';
		
		
			
	}
	
	
	
	
	
	   	 
}


function logout(){
	$("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
	IN.User.logout(onLinkedInLogout);
}

function onLinkedInLogout(){
	$("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
	window.location='login.php';
	$.get("logout.php");
    	return false;
}

function nonLinkedInLogout(){
	$("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
	window.location='logout.php';
    	return false;
}


function downloadData(){

	var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
	if (nmemberid=="") {nmemberid='NULLVAR';}
	if (lmemberid=="") {lmemberid='NULLVAR';}
	var location = "query/downloaddata.php?nmemberid="+nmemberid+"&lmemberid="+lmemberid;
	
	document.location.href = location;
	
}

function showloginalert(){
	//swal("Oops...", "Please login to add your card", "error");
	swal({   title: "Oops...",   text: "Please login to add your card",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   savecreateSession(); });
	
}

function showloginalertevent(){
	//swal("Oops...", "Please login to create an event", "error");
	swal({   title: "Oops...",   text: "Please login to create an event",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   saveeventSession(); });	
	
}

function showloginalertchat(){
	
	//swal("Oops...", "Please login and add your card to chat", "error");
	swal({   title: "Oops...",   text: "Please login and add your card to chat",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   window.location='login.php';});
	//savecreateSession();
}

function showaddcardemailalert(){
	var useremail = document.getElementById("useremail").innerHTML;		
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	 if (useremail == '' ) {
	 	swal({   title: "Oops...",   text: "Please add your card to email other members",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){ savecreateSession(); });
	} 	
	else{
		swal({   title: "Oops...",   text: "Please add your card to email other members",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){  window.location=url;});
	}
	
}


function showaddcardphonealert(){	
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	if (useremail == '' ) {
		swal({   title: "Oops...",   text: "Please add your card to see phone numbers",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){  savecreateSession(); });
	}
	else{
		swal({   title: "Oops...",   text: "Please add your card to see phone numbers",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){  window.location=url;});
	}
	
}

function showaddcardsavealert(){
	var useremail = document.getElementById("useremail").innerHTML;	
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	if (useremail == '' ) {
		swal({   title: "Oops...",   text: "Please add your card to save other cards",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){  savecreateSession(); });
	}
	else{
		swal({   title: "Oops...",   text: "Please add your card to save other cards",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){  window.location=url;});
	}	
}
function showaddcardalert(){
	var user=document.getElementById('userfullname').innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	swal({   title: "Oops...",   text: "Please add your card to chat",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){   window.location=url;});
}

function showaddcardhialert(){	
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	var useremail = document.getElementById("useremail").innerHTML;	
	if (useremail == '' ) {
		swal({   title: "Oops...",   text: "Please add your card to say HI",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){    savecreateSession(); });
	}
	else{
		swal({   title: "Oops...",   text: "Please add your card to say HI",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){   window.location=url;});
	}	
}

function showaddcardcvalert(){	
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	var useremail = document.getElementById("useremail").innerHTML;	
	if (useremail == '' ) {
		swal({   title: "Oops...",   text: "Please add your card to view CVs",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){    savecreateSession(); });
	}	
	else{
		swal({   title: "Oops...",   text: "Please add your card to view CVs",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Add Card",   closeOnConfirm: false }, function(){   window.location=url;});
	}	
}

function LogIn(){ 
	savecreateSession();
}

function Blur(){
	/*var useremail = document.getElementById("useremail").innerHTML;
	if (useremail == '' ) {
		setTimeout(function() { 
				document.getElementById("blurbackground").style.display='';
				document.getElementById("blurdisplay").style.display='';
			        $('#mainbody').css({
			            '-webkit-filter': 'blur(3px)',
			            'filter': 'blur(3px)',
			            'filter': 'progid:DXImageTransform.Microsoft.Blur(PixelRadius=\'3\')'
			        });
			        
			         $('.topcard, .bottomcard, .middlecard').css({
			            'filter': 'url(blur.svg#blur)'
			        })
			       
			        //window.scrollTo(0, 0);
			        
				setTimeout(function() { $('.introicon').focus();}, 1500);
				
		}, 4500);
	}*/
}

function ActivateTopMenu(){

	var useremail = document.getElementById("useremail").innerHTML;
	
	if (useremail != '' ) {
		var lastScrollTop = 0;
		var topheight = $('#top-menu').height();
		topheight = '-' + topheight + 'px';
		$(window).scroll(function(event){
		   var st = $(this).scrollTop();
		   if (st > lastScrollTop && st > 200 ){
		       $('#top-menu').css({ top: topheight }); 
		   } else {
		      $('#top-menu').css({ top: '0px' }); 
		   }
		   lastScrollTop = st;
		});
	}
}

$(function () {
	if(pageInitialized) return;
    	pageInitialized = true;
    	cardtop = document.getElementById("cardtop").innerHTML;
	var useremail = document.getElementById("useremail").innerHTML;
	//var event = document.getElementById("eventtag").innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
	var preview = document.getElementById("preview").innerHTML;
        var dataString = 'eventid1=' + event_id + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid;
        createurl="create_card.php?event_id="+event_id;
        eventurl="index.php?event_id="+event_id;
        if (useremail != '' ) {
		// AJAX code to submit form.

			ActivateTopMenu();
			$.ajax({
			type: "POST",
			url: "query/checkcardquery.php",
			data: dataString,
			timeout:timeoutcountercheckcard,
			cache: false,
			success: function(result) {
			if(result>0){
				usersid = result;
				var editurl="edit_card.php?event_id="+event_id;
				document.getElementById("addcardbutton").innerHTML = 'Edit Card';
				/*if(document.title!="My Staks"){
					document.getElementById("sendcard").style.display = '';
				}*/
				state="cardadded"
				document.getElementById("addcardbutton").setAttribute('onclick',"window.location.href='"+editurl+"'");
				
				var windowWidth = $(window).width();
    				if(windowWidth >500 && document.getElementById("page").innerHTML!="myevents") {
					//ranksection
				
					var dataString = 'eventid=' + event_id + '&cardid=' + result;
		
			        	$.ajax({
						type: "POST",
						url: "query/getrankingquery.php",
						data: dataString,
						cache: false,
						success: function(html) {
								showrank(html);
								document.getElementById("ranksection").style.opacity='1';
								document.getElementById("ranksection").style.filter='alpha(opacity=100);'; 
								document.getElementById("ranksection").style.display='table-cell';
							},
						error: function (request, status, error) {
							        //alert(error);
							        if (status == "timeout") {
							}  
						} 
					});
					//end of rank section	
				}
				
				
			}
			else{
				//alert(result);
				document.getElementById("addcardbutton").innerHTML = '<a href="#" style="color: inherit;text-decoration:none;vertical-align:middle;">Add Card</a></td>';
				state="login"
				document.getElementById("addcardbutton").setAttribute('onclick',"window.location.href='"+createurl+"'");
			}
				},
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             location.reload();
				             //timeoutcountercheckcard=timeoutcountercheckcard*2;
				             //checkcardf();
			            } else {
			                // another error occured  
			                //alert("error: " + request + status + err);
			            }
			    }
			
			});
	}
	else{
		document.getElementById("menuwrapper").style.display='none';
		 
		 //adding blur and preventing scroll
		 
		 /*$('html, body').css({
			    'overflow': 'hidden',
			    'height': '100%'
			});*/
		
	}
	
	
	if(document.getElementById("page").innerHTML=="myevents"){
		document.getElementById("searchtable").style.display='none';
		document.getElementById("bottombar").style.display='none';
		/*document.getElementById("boardmenu").style.display='none';
		document.getElementById("board").style.display='none';*/
		fillmyEventsCards();	
		if(event_id==''){document.getElementById("backbutton").style.display='none';}
		
		
		document.getElementById("top-menu").style.opacity='1';
		document.getElementById("top-menu").style.filter='alpha(opacity=100);';

	}
	else{	
		
		//var event = document.getElementById("eventtag").innerHTML;
		var eventidurl = document.getElementById("eventid").innerHTML;
		var dataString = 'eventid=' + eventidurl;
		//var dataString = 'eventid=' + eventidurl;
		// AJAX code to submit form.
		$(function checkeventf() {	
			$.ajax({
			type: "POST",
			url: "query/checkeventquery.php",
			data: dataString,
			dataType: "json",
			timeout:timeoutcountercheckevent,
			cache: false,
			success: function(result) {
			
			/*var resultarray = result.split(",");
			var eventid=resultarray[0];
			eventname=resultarray[1];
			var eventdate=resultarray[2];
			groupno=resultarray[3];
			var group1name=resultarray[4];
			var group2name=resultarray[5];
			var group3name=resultarray[6];*/
			
			var eventid=result[0];
			eventname=result[1];
			var eventdate=result[3];
			groupno=result[6];
			var group1name=result[7];
			var group2name=result[8];
			var group3name=result[9];
			var ebid=result[10];
			var eburl=result[11];
			//alert(result);
			var width=0;
			if( (eventidurl!=eventid || eventidurl=='' ) && (useremail!='') ){
				window.location='http://www.cardstak.com/index.php?&page=myevents';
				}
			else if( (eventidurl!=eventid || eventidurl=='' ) && (useremail=='') ){
				window.location='http://www.cardstak.com/login.php';
				}
			else{
				if(groupno==3){
					document.getElementById("g1button").innerHTML = group1name;
					document.getElementById("g2button").innerHTML = group2name;
					document.getElementById("g3button").innerHTML = group3name;
					width = document.getElementById("g1buttonback").clientWidth + document.getElementById("g2buttonback").clientWidth + document.getElementById("g3buttonback").clientWidth + document.getElementById("showallbutton").clientWidth+5;
				}
				if(groupno==2){
					document.getElementById("g1button").innerHTML = group1name;
					document.getElementById("g2button").innerHTML = group2name;
					document.getElementById("g3buttonback").style.display = 'none';
					width = document.getElementById("g1buttonback").clientWidth + document.getElementById("g2buttonback").clientWidth + document.getElementById("showallbutton").offsetWidth+2;
				}
				if(groupno==1){
					document.getElementById("g1buttonback").style.display = 'none';
					document.getElementById("g2buttonback").style.display = 'none';
					document.getElementById("g3buttonback").style.display = 'none';
					//document.getElementById("showallbutton").style.display = 'none';
					document.getElementById("rolestext").style.display='none';
				}
			
			}
			document.getElementById("eventtag").innerHTML = eventname;
			if (window!=window.top) { 
					document.getElementById("event").innerHTML = eventname+" attendees";
				}
				else{		
					document.getElementById("event").innerHTML = eventname;
				}
			
			document.title = eventname;
			document.getElementById("rightbr").style.width=width+'px';
			document.getElementById("rolestext").style.paddingLeft=(((width)/2)-82)+'px';
			//document.getElementById("wizardtext").style.width = (width+136)+'px';
			if(eventdate!='' && eventdate!=' '){	
				if (window!=window.top) { 				document.getElementById("event").innerHTML=eventname+" attendees<span id=\"spandate\" style=\"font-size: 14pt;color:#6BAEA6;\">&nbsp;&nbsp;("+eventdate+")</span>";
				}
				else{		document.getElementById("event").innerHTML="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+eventname+"<span id=\"spandate\" style=\"font-size: 14pt;color:#6BAEA6;\">&nbsp;&nbsp;("+eventdate+")</span>";
				}
			
			}
			
			//if(eburl!='' && eburl!=' '  && eburl!='NULL' && eburl!='null'){	
			if ( eburl !== undefined && eburl !== null && eburl !== 'NULL'){
				//alert(eburl);
				document.getElementById("event").innerHTML = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+eventname+"<span id=\"spandate\" style=\"font-size: 14pt;color:#6BAEA6;cursor:pointer\" onclick=\"window.open('"+eburl+"','_blank');\">&nbsp;&nbsp;(Eventbrite page)</span>";
			}
				
			document.getElementById("top-menu").style.opacity='1';
			document.getElementById("top-menu").style.filter='alpha(opacity=100);';
			document.getElementById("sharebtn").style.opacity='1';
			document.getElementById("sharebtn").style.filter='alpha(opacity=100);'; 

			//if (useremail == '' && preview == '') {showWhy();}
			if (window!=window.top) { /* in iframe */
		    		document.getElementById("ranksection").style.display='none';
		   		}

			},
			error: function (request, status, error) {
			        
	
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             
				             timeoutcountercheckevent=timeoutcountercheckevent*2;
				             checkeventf();
			            } else {
			                // another error occured  
			                //alert("error: " + request + status + err);
			                if(useremail!='' ){
					window.location='http://www.cardstak.com/index.php?&page=myevents';
					}
					else {
						window.location='http://www.cardstak.com/login.php';
					}
			            }
			    }
			});
		});
		
		
		
		document.getElementById("bottombar").style.display='';
		document.getElementById("page").innerHTML="";
		if(nmemberid==''){nmemberid="Not Available";}
		if(lmemberid==''){lmemberid="Not Available";}

	        var dataString = 'eventid=' + event_id + '&lmemberid=' + lmemberid + '&nmemberid=' + nmemberid  + '&event=' + event ;
	        
	        //alert(useremail=='');
	        if (useremail == '' ) {
			//alert("Please login to build your Cardstak");
			//swal("Oops...", "Please login to build your Cardstak", "error");
			document.getElementById("myeventsbutton").style.display='none';
			/*document.getElementById("createbuttontop").innerHTML="<a href=\"#\" class=\"topmenulink\" onclick=\"showloginalertevent();\"><span style=\"font-size: 25pt;padding-right: 5px;font-family: sans-serif;\">+</span>Create Event</a>";*/
			document.getElementById("createbuttontop").innerHTML="<a href=\"#\" class=\"topmenulinkright\" onclick=\"showloginalertevent();\">Create a Stak</a>";
		} 
		
		//var fillcards="query/addfillcards.php";
		
		
		if(cardtop!=""){
			fillcards="query/addfillcardstop.php";
			var dataString = 'eventid=' + event_id + '&lmemberid=' + lmemberid + '&nmemberid=' + nmemberid  + '&event=' + event + '&cardtop=' + cardtop ;
		}
		
		
		document.getElementById("mainbody").innerHTML = loaderHTML;
		// AJAX code to submit form.
		$(function fillcardsf() {
			$.ajax({
			type: "POST",
			url: fillquery,
			data: dataString,
			timeout:timeoutcounterfillcards,
			cache: false,
			success: function(html) {
			
			document.getElementById("mainbody").innerHTML=html;
			
			if (window!=window.top) {
    				$('.bio').css("line-height", "23px");
    				$('.bottomcard').css("font-size", "15pt");
       			 }
       			
       			
       			
			if (preview == "true"){
				swal("Preview Closes in 1 Minute");
				setInterval(function () {
					window.close();	
				}, 60000);
			}
       			
       			if (firstTime && $(window).width()<500) {removeBios();}
       			else{ 
			setupBlocks();
			}
			//alert('salam');
			
			$('.block').each(function (i) {
				$(this).css({
					'-webkit-transition': 'all .6s ease-out',
					'-moz-transition': 'all .6s ease-out',
					'-o-transition': 'all .6s ease-out',
					'transition': 'all .6s ease-out',  'opacity': '1', 'filter': 'alpha(opacity=100)'
					});
			});
			
			$('.dont_open').click(function(e){ e.stopPropagation(); });
			
			$('.dont_open_why').click(function(e){ e.stopPropagation(); });
			
			
			
		        $(".bio").dotdotdot();
		      
		      
		   	placebottombar();  
		   			   			   	
		   	//resizechat();
		   	eventSpecificafter();
		   	
		   	Blur();
		   	
		   	
		   	setTimeout(function() { givesharetips(); }, 3000);
		   	
			},
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             
				             //clearInterval(ajax_call);
				             timeoutcounterfillcards=timeoutcounterfillcards*2;
				             //window.location.reload(); 
				             fillcardsf();
			            } else {
			                // another error occured  
			                //alert("error: " + request + status + err);
			            }
			    }
			});
		
		});

	eventSpecificbefore();	
	
	
	//if (useremail == '') {showWhy();}
	}
		

});

function resizechat(){
	if(document.getElementById("page").innerHTML!="myevents"){
		var bottom = document.getElementById('top-menu').scrollHeight;
		document.getElementById("chats").style.height= (windowheight - bottom -94)+'px';
		document.getElementById("chatwindow").style.bottom = '210px';
	}	      
}


function placebottombar(){
	//document.getElementById("bottombar").style.opacity='0';
	//document.getElementById("bottombar").style.filter='alpha(opacity=0);'; 
	bottomofpage=Math.max(Math.max.apply(null,blocks),($(window).height()-44));
	document.getElementById("bottombar").style.top=bottomofpage+ 'px';
	document.getElementById("bottombar").style.opacity='1';
	document.getElementById("bottombar").style.filter='alpha(opacity=100);'; 
		      
}


function gotoEditCard(){
	$("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
	//var event = document.getElementById("eventtag").innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var edit_url="edit_card.php?"+"event_id="+event_id;
	window.location=edit_url;	
}


function setupBlocks() {
	//workd!!!
    windowWidth = $(window).width();
    windowheight = $(window).height();
    blocks = [];    
    var top=90;
    margin=30;
    
    
    if(	windowWidth <500) {
    	document.getElementById("sharebtn").style.display='none';
    }
    else{
    	document.getElementById("sharebtn").style.display='';
    }
    
    
    
    
    if (window!=window.top) { /* in iframe */
       
    	top=50;
    	document.getElementById("topmenubottom").style.display='none';
    	document.getElementById("createbuttontop").innerHTML='<a href="login.php" class="topmenulink" onclick="savecreateSession()">Add Your Card<span style="font-size: 18pt;padding-left: 5px;font-family: sans-serif;color:rgb(53, 151, 139); vertical-align:middle">+</span></a>';
    	//document.getElementById("wizardbackground").style.display='none';
	//document.getElementById("wizard").style.display='none';
	document.getElementById("contact").style.top='10%';
	document.getElementById("commentbox").style.top='10%';
	document.getElementById("commentbox").style.width='26%';
	document.getElementById("commentbox").style.left='37%';
	document.getElementById("sharebtn").style.background='rgba(74, 74, 74, 0.89)';
	//document.getElementById("sharebtn").style.display='none';
	document.getElementById("top-menu").style.background='rgba(74, 74, 74, 0.89)';
	document.getElementById("bottombar").style.display='none';
    	margin=45;
    	document.body.style.zoom= '0.6'; /* Other non-webkit browsers */
   	document.body.style.zoom= '60%'; /* Webkit browsers */
   	document.body.style.MozTransform = "scale(0.6)";
	document.body.style.MozTransformOrigin = "0 0";
	

	
	var FIREFOX = /Firefox/i.test(navigator.userAgent);

	if (FIREFOX) {
		  document.getElementById("top-menu").style.width='167%';
	}
	

	if (detectIE() == true)
	{
		document.body.style.transform = "scale(1)";
		document.getElementById("top-menu").style.transform = "scale(.6)";
		document.getElementById("top-menu").style.width='167%';
		document.getElementById("top-menu").style.transformOrigin = "0 0";
		document.getElementById("sharebtn").style.display='none';
		sharebtns = document.getElementsByClassName("addthis-smartlayers");
	        for (var i = 0; i < sharebtns.length; i++) {
	            sharebtns[i].style.display = 'none';
	        }
	}	
	
	
   	windowWidth=windowWidth/.6;
	$('a').attr('target','_blank');
	document.getElementById("eventtd").innerHTML='<a id="event" style="font-family:Pathway Gothic One, sans-serif" class="topmenulink" target="_blank" href="#">'+document.getElementById("event").innerHTML+'</a>';
	document.body.style.backgroundImage = "none";
	
	$(".block").attr("onclick","window.open('"+eventurl+"', '_blank');");
	$(".cardicon").attr("onclick","");
	$(".dont_open").attr("onclick","window.open('"+eventurl+"', '_blank');");
	$("#addcard").attr("onclick","savecreateSession()");
	//document.body.attr("onclick","window.open('"+eventurl+"', '_blank');");
	//window.onClick=window.open(eventurl, '_blank');
	
	$('.dont_open').attr('href','');
	$('.dont_open').attr('target','');
	$('.addcardclass').attr('href','');
	$('.addcardclass').attr('target','');
	
	
	//$("#cardstakbuttontop").attr("onclick","window.open('http://www.cardstak.com', '_blank');");
	
	/*sharebtns = document.getElementsByClassName("at4-share-btn");
        for (var i = 0; i < sharebtns.length; i++) {
            sharebtns[i].style.display = 'none';
        }*/
	

    }
    
    
    
    
    
    
    if(	windowWidth <500) {    
    	colWidth=windowWidth*0.9; 
    	margin=windowWidth*0.05;
    	colCount = Math.floor(windowWidth / (colWidth + margin * 2));
    	for (var i = 0; i < colCount; i++) {
        blocks.push(margin + windowheight*0.35);
    	}
    }
    else {
        margin=15;
    	if(boardopen==true) {
    		windowWidth=windowWidth-boardsize;
    	}
    	colWidth=215;
    	colCount = Math.floor(windowWidth / (colWidth + margin * 2));
    	for (var i = 0; i < colCount; i++) {
        blocks.push(margin + top);
    	}	
    }
    // Calculate the margin so the blocks are evenly spaced within the window
    
    spaceLeft = (windowWidth - ((colWidth * colCount) + (margin * (colCount - 1)))) / 2;
    //console.log(spaceLeft);
    
    //eventSpecific();
    positionBlocks();
    
    
}

function positionBlocks() {
	var event_id = document.getElementById("eventid").innerHTML;
	if(windowWidth <500) {
		onphone=true;
		//closeWhy();
		wizload=false;
		//document.getElementById("whyaddbt").style.display="none";
    		//document.getElementById("whyaddb").value="close";
    		
	    	$('.block').each(function (i) {
	        var min = Array.min(blocks);
	        var index = $.inArray(min, blocks);
	        var leftPos = (index * (colWidth + margin));
	        $(this).css({
	            'left': (leftPos + spaceLeft) + 'px',
	                'top': min + 'px', 'width': colWidth + 'px'
	        		});
	        blocks[index] = min + $(this).outerHeight() + margin;
	   	 }); 

	   	
	   	$('.topcard').each(function (i) {
	        $(this).css({
	            'width': colWidth + 'px'
	        		});
	   	 }); 

	   	 $('.bio').each(function (i) {
	        $(this).css({
	            'width': (colWidth-26) + 'px'
	        		});
	   	 }); 
	   	

	   	 $('.contactinfo').each(function (i) {
	        $(this).css({
	            'width': (0.7*windowWidth)+'px'
	        		});
	   	 });
	   	 
		 firstload=0;
    		
    		 
    		
	}
	else {
		
		onphone=false;      
	    	$('.block').each(function (i) {
	        var min = Array.min(blocks);
	        var index = $.inArray(min, blocks);
	        var leftPos = (index * (colWidth + margin));
	        $(this).css({
	            'left': (leftPos + spaceLeft) + 'px',
	                'top': min + 'px', 'width': '215px'
	        });
	        blocks[index] = min + $(this).outerHeight() + margin;
	   	 }); 

		 firstload=0;
        }
	
	
	
	if(windowheight <500) {
	    	document.getElementById("contact").style.top='25%';
		document.getElementById("commentbox").style.top='25%';
	}
	else {
		   
	    	
        }
  
}





// Function to get the Min value in Array
Array.min = function (array) {
    return Math.min.apply(Math, array);
};

function showrank(rank){
	//alert("rank: "+rank);
	if(rank=="NA"){
		document.getElementById("ranktopdownstyle").innerHTML='N/A';	
		document.getElementById("ranktopdownstyle").style.color = '#983043';
		document.getElementById("rankstyle").style.display = 'none';
	}
	else if(rank>0.9){
		document.getElementById("rankstyle").innerHTML='10%';		
	}
	else if(rank>0.8){
		document.getElementById("rankstyle").innerHTML='20%';		
	}
	else if(rank>0.7){
		document.getElementById("rankstyle").innerHTML='30%';		
	}
	else if(rank>0.6){
		document.getElementById("rankstyle").innerHTML='40%';		
	}
	else if(rank>=0.5){
		document.getElementById("rankstyle").innerHTML='50%';		
	}
	else if(rank<0.5){
		document.getElementById("ranktopdownstyle").innerHTML='bottom';	
		document.getElementById("ranktopdownstyle").style.color = '#983043';
		document.getElementById("rankstyle").innerHTML='50%';	
		document.getElementById("rankstyle").style.background = '#983043';	
	}
}


function openPhone(hostDivName) {
	var user=document.getElementById('userfullname').innerHTML;

	if (document.getElementById("displaying").innerHTML == 'savedcards') {
		$('#phonebackground, #phonebox').fadeIn(350);
		var hostDiv = document.getElementById(hostDivName);   
		var theElements = hostDiv.getElementsByClassName("cardphone");
		var cardPhone = theElements[0].innerHTML;   
		document.getElementById("phoneboxnumber").innerHTML = cardPhone;
	}
	else{
		
		if( (user.length == 0  || state!="cardadded")  ){
			showaddcardphonealert();
		}
		else{
			$('#phonebackground, #phonebox').fadeIn(350);
			var hostDiv = document.getElementById(hostDivName);   
			var theElements = hostDiv.getElementsByClassName("cardphone");
			var cardPhone = theElements[0].innerHTML;   
			document.getElementById("phoneboxnumber").innerHTML = cardPhone;
		}
		
	}

}

function closePhone() {
    $('#phonebackground, #phonebox').fadeOut(350);
	//asdf
}








function showWhy(){
    $('#whybackground, #whybox').fadeIn(350);
}


function closeWhy() {
    	
    $('#whybackground, #whybox').fadeOut(350);
    if(wizload==true) {
    	showWizard();
    	wizload=false;
    	setTimeout(function() { document.getElementById("whyaddbt").style.display="none"}, 1000);
    	setTimeout(function() { document.getElementById("whyaddb").value="close"}, 1000);
    }
}

function toggleBio(hostTableName) {
	if(removebio == false){
		var hostTable = document.getElementById(hostTableName);
		var parentId = hostTable.parentNode.parentNode.id;
		var hostDiv = document.getElementById(parentId);
		var bottomCardElement = (hostDiv.getElementsByClassName("bottomcard"))[0];
		//bottomCardElement.show();
		if (bottomCardElement.style.display == 'none'){
			bottomCardElement.style.display = "";
		}
		else{
			bottomCardElement.style.display = "none";
		}	
		setupBlocks(); 
		placebottombar(); 
	}
}

function addComment(hostDivName) {
	document.getElementById("savecardbutton").disabled = false;
        $('#commentbackground, #commentbox').fadeIn(350);
        var hostDiv = document.getElementById(hostDivName);
        var cardRole = hostDiv.parentNode.className;
        var cardName = (hostDiv.getElementsByClassName("cardname"))[0].innerHTML;
        var cardTitle = (hostDiv.getElementsByClassName("cardtitle"))[0].innerHTML;
        var cardPicture = (hostDiv.getElementsByClassName("picture"))[0].innerHTML;
        var cardid = (hostDiv.getElementsByClassName("cardid"))[0].innerHTML; 
        var cardcomment = (hostDiv.getElementsByClassName("commentoncard"))[0].innerHTML;
        var cardsaved = (hostDiv.getElementsByClassName("save"))[0].innerHTML;
        var cardEvent = (hostDiv.getElementsByClassName("cardevent"))[0].innerHTML;
        cardPicture = cardPicture.replace("class=\"circle\"", "class=\"commentpicture\"");
        //alert(firstName);
        if (cardEvent=="") {cardEvent=document.getElementById("eventtag").innerHTML;}
        document.getElementById("commentnoteid").innerHTML = "saving <b>" + cardName + "</b>'s card<br><b>" + cardTitle + "</b>";
        document.getElementById("commentpicture").innerHTML = cardPicture;
        document.getElementById("commentcardid").innerHTML = cardid;
        document.getElementById("commentcardname").innerHTML = hostDivName;
        document.getElementById("commentspace").value=cardcomment.replace(/&amp;/g, "&");
        document.getElementById("commentcardevent").innerHTML = "<b style=\"color:#30DBA7\">Event: </b>"+cardEvent+"";
	if(document.getElementById("displaying").innerHTML == 'savedcards'){
		document.getElementById("commentcardrole").innerHTML =  "<b style=\"color:#30DBA7\">Role: </b>"+(hostDiv.getElementsByClassName("cardrole"))[0].innerHTML;
		
        }
        else if (groupno==1){
        	document.getElementById("commentcardrole").innerHTML = "<b style=\"color:#30DBA7\">Role: </b>participant";
        }else{
	if (cardRole=="1") {  document.getElementById("commentcardrole").innerHTML = "<b style=\"color:#30DBA7\">Role: </b>"+document.getElementById("g1button").textContent;}
	if (cardRole=="2") {  document.getElementById("commentcardrole").innerHTML = "<b style=\"color:#30DBA7\">Role: </b>"+document.getElementById("g2button").textContent;}
	if (cardRole=="3") {  document.getElementById("commentcardrole").innerHTML = "<b style=\"color:#30DBA7\">Role: </b>"+document.getElementById("g3button").textContent;}
	
        }

        if (cardsaved=="Save Card" || cardsaved=="save" ){
        	//document.getElementById("commentcardsaved").innerHTML ="not saved";
        	savestate="not saved";
        	document.getElementById("savecardbutton").value="save";
        	document.getElementById("deletecardbutton").style.display = 'none';
        }
        else{
        	//document.getElementById("commentcardsaved").innerHTML ="edit"; 
        	savestate="edit";
        	document.getElementById("savecardbutton").value="update";
        	document.getElementById("deletecardbutton").style.display = '';
        }	
        
        //alert(document.getElementById("commentcardsaved").innerHTML);
        
    

}



function openEmail(hostDivName,email) {
	var user=document.getElementById('userfullname').innerHTML;
	document.getElementById("contactsendemail").disabled = false;
	document.getElementById("deletecardbutton").disabled = false;
        $('#contactbackground, #contact').fadeIn(350);
        var hostDiv = document.getElementById(hostDivName);
        var cardName = (hostDiv.getElementsByClassName("cardname"))[0].innerHTML;
        var cardPicture = (hostDiv.getElementsByClassName("picture"))[0].innerHTML;
        var cardEvent = (hostDiv.getElementsByClassName("cardevent"))[0].innerHTML;
        cardPicture = cardPicture.replace("class=\"circle\"", "class=\"commentpicture\"");
	if(document.getElementById("displaying").innerHTML == 'savedcards'){
		cardEvent="Follow Up";
	}

        
        if (cardEvent=="") {cardEvent=document.getElementById("eventtag").innerHTML;}
        document.getElementById("contactpicture").innerHTML = cardPicture;
        document.getElementById("contactname").innerHTML = cardName;
        document.getElementById("contactemailfrom").value =document.getElementById("useremail").innerHTML;
        document.getElementById("contactemailto").value = email;
        if (user.length == 0 ) {document.getElementById("contactsubject").value = cardEvent;}
        else {document.getElementById("contactsubject").value = "Message from "+user;}
        document.getElementById("contactmessage").focus();
        var gmailaddress="https://mail.google.com/mail/?view=cm&amp;fs=1&to="+email+"&su="+cardEvent;
        var yahooaddress="http://compose.mail.yahoo.com/?to="+email+"&subject="+cardEvent;
        
        document.getElementById("gmailcontact").setAttribute('href', gmailaddress);
        document.getElementById("yahoocontact").setAttribute('href', yahooaddress);
	
}

function opencv(cvlink){
	//getting user info
	var user=document.getElementById('userfullname').innerHTML;
	//checking to see if should run
	if (document.getElementById("displaying").innerHTML == 'savedcards') {
			window.open(cvlink);
		}
		else{
			if( (user.length == 0  || state!="cardadded")  ){
				showaddcardcvalert();
			}
			else{
				window.open(cvlink);
		}
	}
}


function sendEmail() {
	whitenContact();
	var Emailfrom=document.getElementById("contactemailfrom").value;
	var Emailto=document.getElementById("contactemailto").value;
	var Emailmessage=document.getElementById("contactmessage").value;
	Emailmessage = Emailmessage.replace(/\r?\n/g, '<br />');
	var Toname=document.getElementById("contactname").innerHTML;
	var Fromname=document.getElementById("userfullname").innerHTML;
	var user=document.getElementById('userfullname').innerHTML;
	var Emailsubject=document.getElementById("contactsubject").value;
	var Eventname=document.getElementById("eventtag").innerHTML;
        /*if(validateEmail(Emailfrom)==false){
        	sweetAlert("Oops...", "Please add your Email address", "error");
		document.getElementById("contactemailfrom").style.border="1px solid red";
		document.getElementById("contactemailfrom").style.background="rgb(255, 238, 238)";
        }
        else if(validateEmail(Emailto)==false){
        	sweetAlert("Oops...", "Please add a valid Email address to send to", "error");
		document.getElementById("contactemailto").style.border="1px solid red";
		document.getElementById("contactemailto").style.background="rgb(255, 238, 238)";
        }
        else if(Emailsubject==""){
        	sweetAlert("Oops...", "Please add an Email subject", "error");
		document.getElementById("contactsubject").style.border="1px solid red";
		document.getElementById("contactsubject").style.background="rgb(255, 238, 238)";
        }
        else */if(Emailmessage==""){
        	sweetAlert("Oops...", "Please add an Email message", "error");
		document.getElementById("contactmessage").style.border="1px solid red";
		document.getElementById("contactmessage").style.background="rgb(255, 238, 238)";
        }
        else if(Emailto=="test@test.com"){
        	sweetAlert("Oops...", "This is a sample card not a real one", "error");
		document.getElementById("contactemailto").style.border="1px solid red";
		document.getElementById("contactemailto").style.background="rgb(255, 238, 238)";
        }
        else if (document.getElementById("displaying").innerHTML == 'savedcards') {
		document.getElementById("contactsendemail").disabled = true;
        	$("body").css("cursor", "progress");
      		$(":button").css("cursor", "progress");
      		
      		//var title = document.getElementsByClassName("cardtitle")[0].innerHTML;
		//var img = document.getElementsByClassName("circle")[0];
		//var style = img.currentStyle || window.getComputedStyle(img, false);
		//var userimage = style.backgroundImage.slice(4, -1);
		var HTMLmessage=createemailmessage_savedcards(Fromname,Emailmessage,"message");
        	var dataString = 'emailfrom=' + Eventname + '&emailto=' + Emailto + '&emailsubject=' + Emailsubject + '&emailmessage=' + HTMLmessage + '&fromname=' + Fromname + '&toname=' + Toname  + '&replyemail=' + Emailfrom + '&eventurl=' + eventurl+ '&title=' + title+ '&pic=' + img;
        	
	        $(function sendemailf() {	
	        	$.ajax({
			type: "POST",
			url: "query/emailquery.php",
			data: dataString,
			cache: false,
			timeout:timeoutcountersendemail,
			success: function(html) {
			//alert(html);
			trackEmail(Toname,Fromname,'sendemail','undefined','undefined',Emailmessage);
			swal({   title: "Email Sent",    timer: 1000 });
			document.getElementById("contactmessage").value="";
			closeContact();
			$("body").css("cursor", "default");
			$(":button").css("cursor", "pointer");
			document.getElementById("contactsendemail").disabled = false;
				},
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             
				             timeoutcountersendemail=timeoutcountersendemail*2;
				             sendemailf();
			            } else {
			                document.getElementById("contactsendemail").disabled = false;
			                document.getElementById("contactmessage").value="";
					$("body").css("cursor", "default");
					$(":button").css("cursor", "pointer");
			            }
			            
			    }   
 
			});
		});
	}
	else{
		
		
		if( (user.length == 0  || state!="cardadded")  ){
			showaddcardemailalert();
		}
		else{
			document.getElementById("contactsendemail").disabled = true;
	        	$("body").css("cursor", "progress");
	      		$(":button").css("cursor", "progress");
	      		
	      		var title = document.getElementsByClassName("cardtitle")[0].innerHTML;
			var img = document.getElementsByClassName("circle")[0];
			var style = img.currentStyle || window.getComputedStyle(img, false);
			var userimage = style.backgroundImage.slice(4, -1);
			userimage = userimage.replace(/['"]+/g, '');
			//userimage = userimage.replace(/['""]+/g, '');
			var HTMLmessage=createemailmessage(userimage,Fromname,title,Emailmessage,eventurl,Eventname,"message");
	        	var dataString = 'emailfrom=' + Eventname + '&emailto=' + Emailto + '&emailsubject=' + Emailsubject + '&emailmessage=' + HTMLmessage + '&fromname=' + Fromname + '&toname=' + Toname  + '&replyemail=' + Emailfrom + '&eventurl=' + eventurl+ '&title=' + title+ '&pic=' + img;
		        $(function sendemailf() {	
		        	$.ajax({
				type: "POST",
				url: "query/emailquery.php",
				data: dataString,
				cache: false,
				timeout:timeoutcountersendemail,
				success: function(html) {
				//alert(html);
				trackEmail(Toname,Fromname,'sendemail','undefined','undefined',Emailmessage);
				swal({   title: "Email Sent",    timer: 1000 });
				document.getElementById("contactmessage").value="";
				closeContact();
				$("body").css("cursor", "default");
				$(":button").css("cursor", "pointer");
				document.getElementById("contactsendemail").disabled = false;
					},
				error: function (request, status, error) {
				        if (status == "timeout") {
				                // timeout -> reload the page and try again
					             
					             timeoutcountersendemail=timeoutcountersendemail*2;
					             sendemailf();
				            } else {
				                document.getElementById("contactsendemail").disabled = false;
				                document.getElementById("contactmessage").value="";
						$("body").css("cursor", "default");
						$(":button").css("cursor", "pointer");
				            }
				            
				    }   
	 
				});
			});
		}
		
	}
        
	
}

function whitenContact(){
	document.getElementById("contactemailfrom").style.border="";
	document.getElementById("contactemailfrom").style.background="";
	document.getElementById("contactemailto").style.border="";
	document.getElementById("contactemailto").style.background="";
	document.getElementById("contactsubject").style.border="";
	document.getElementById("contactsubject").style.background="";
	document.getElementById("contactmessage").style.border="";
	document.getElementById("contactmessage").style.background="";
}



function sendHi(hostDivName,email) {
        var hostDiv = document.getElementById(hostDivName);
        var Toname = (hostDiv.getElementsByClassName("cardname"))[0].innerHTML;       
        var Emailfrom=document.getElementById("useremail").innerHTML;
	var Emailto=email;
	var cardEvent=document.getElementById("eventtag").innerHTML;


	var Emailmessage="";
	var Fromname=cardEvent;
	var user=document.getElementById('userfullname').innerHTML;
	//var Emailsubject=document.getElementById("contactsubject").value;
	if (user.length == 0 ) {var Emailsubject = cardEvent;}
        else {var Emailsubject = user+" says HI!";}
	
	
	var Eventname=document.getElementById("eventtag").innerHTML;
        if(Emailto=="test@test.com"){
        	sweetAlert("Oops...", "This is a sample card not a real one", "error");
        }
        else if (document.getElementById("displaying").innerHTML == 'savedcards') {

        	$(".block").css("cursor", "progress");
	        $(".dont_open").css("cursor", "progress");
      		

		var HTMLmessage=createemailmessage_savedcards(user,Emailmessage,"hi");
        	var dataString = 'emailfrom=' + Eventname + '&emailto=' + Emailto + '&emailsubject=' + Emailsubject + '&emailmessage=' + HTMLmessage + '&fromname=' + Fromname + '&toname=' + Toname  + '&replyemail=' + Emailfrom + '&eventurl=' + eventurl+ '&title=' + title+ '&pic=' + img;
        	
	        $(function sendemailf() {	
	        	$.ajax({
			type: "POST",
			url: "query/emailquery.php",
			data: dataString,
			cache: false,
			timeout:timeoutcountersendemail,
			success: function(html) {
			//alert(html);
			swal({  title: "Sweet!",   text: "Hello Sent",   imageUrl: "images/thumbs-up.jpg",    timer: 3000 });
			document.getElementById("contactmessage").value="";
			closeContact();
			$(".block").css("cursor", "pointer");
			$(".dont_open").css("cursor", "pointer");
			document.getElementById("contactsendemail").disabled = false;
				},
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             
				             timeoutcountersendemail=timeoutcountersendemail*2;
				             sendemailf();
			            } else {
					$(".block").css("cursor", "pointer");
					$(".dont_open").css("cursor", "pointer");
			            }
			            
			    }   
 
			});
		});
	}
	else{
		
		
		if( user.length == 0  || state!="cardadded"){
			showaddcardhialert();
		}
		else{
	        	
	        	$(".block").css("cursor", "progress");
	        	$(".dont_open").css("cursor", "progress");
	      		
	      		
	      		var title = document.getElementsByClassName("cardtitle")[0].innerHTML;
			var img = document.getElementsByClassName("circle")[0];
			var style = img.currentStyle || window.getComputedStyle(img, false);
			var userimage = style.backgroundImage.slice(4, -1);
			userimage = userimage.replace(/['"]+/g, '');
			//userimage = userimage.replace(/['""]+/g, '');
			
			var HTMLmessage=createemailmessage(userimage,user,title,Emailmessage,eventurl,Eventname,"hi");
	        	
	        	var dataString = 'emailfrom=' + Eventname + '&emailto=' + Emailto + '&emailsubject=' + Emailsubject + '&emailmessage=' + HTMLmessage + '&fromname=' + Fromname + '&toname=' + Toname  + '&replyemail=' + Emailfrom + '&eventurl=' + eventurl+ '&title=' + title+ '&pic=' + img;
	        	
		        $(function sendemailf() {	
		        	$.ajax({
				type: "POST",
				url: "query/emailquery.php",
				data: dataString,
				cache: false,
				timeout:timeoutcountersendemail,
				success: function(html) {
				//alert(html);
				swal({  title: "Sweet!",   text: "Hello Sent",   imageUrl: "images/thumbs-up.jpg",    timer: 3000 });
				document.getElementById("contactmessage").value="";
				closeContact();
				$(".block").css("cursor", "pointer");
				$(".dont_open").css("cursor", "pointer");
				

					},
				error: function (request, status, error) {
				        if (status == "timeout") {
				                // timeout -> reload the page and try again
					             
					             timeoutcountersendemail=timeoutcountersendemail*2;
					             sendemailf();
				            } else {

						$(".block").css("cursor", "pointer");
						$(".dont_open").css("cursor", "pointer");
				            }
				            
				    }   
	 
				});
			});
		}
		
	}
        
	
}


function showWizard() {
    $('#wizard, #wizardbackground').fadeIn(350);

}


function closeWizard() {
    $('#wizard, #wizardbackground').fadeOut(350);

}

function closeComment() {
    $('#commentbackground, #commentbox').fadeOut(350);
    document.getElementById("commentspace").value = "";

}


function closeContact() {
    $('#contactbackground, #contact').fadeOut(350);
    whitenContact();
    document.getElementById("contactmessage").value="";
}

function removeBios() {
    
    window.scrollTo(0, 0);	
    firstTime = false;	
    if (removebio) {
        document.getElementById("showallbuttonback").innerHTML = '&nbsp;&nbsp;&nbsp;Bio&nbsp;&nbsp;&nbsp;';
	$(".bottomcard").hide();  
	$('.name').css('background', 'rgba(71, 71, 71, 0.67)');  
	$( ".topcard" ).addClass( "dont_open" );   
	$(".topcard").attr("onclick","toggleBio(this.id);");
        
        $('.dont_open').click(function (e) {
   		 e.stopPropagation();
		});	
	removebio = false;
	//alert('list mode');
	setupBlocks();  
        
    } else {
        document.getElementById("showallbuttonback").innerHTML = 'No Bio';
        $(".bottomcard").show();
        $('.name').css('background', 'linear-gradient(to right, rgba(45,57,62,.85) 0%, rgba(45,55,62,0.75) 100%)');      
        $(".topcard").removeClass( "dont_open" );
        $(".topcard").attr("onclick","return false;");
	removebio = true; 
	//alert('bio mode');
	setupBlocks();
	 
    }
    placebottombar();
}





$('.searchbar').focus(function()
	{
	    //$(this).css({'width': '190px'});
	    document.getElementById("searchbutton").style.background='rgb(110, 165, 197)';
	}
);

function showAll(){
	if(searching==true){
		endsearch();
		if (!hidegroupone) {hideg1(); hidegroupone=true;}
		if (!hidegrouptwo) {hideg2(); hidegrouptwo=true;}
		if (!hidegroupthree) {hideg3(); hidegroupthree=true;}
		setupBlocks();
		placebottombar();		
	} 
		
	else{
		if ( hidegroupone==true && hidegrouptwo==true && hidegroupthree==true && document.getElementById("displaying").innerHTML != 'savedcards'){
			location.reload();
		}
		else{
			window.scrollTo(0, 0);	
			if (!hidegroupone) {hideg1(); hidegroupone=true;}
			if (!hidegrouptwo) {hideg2(); hidegrouptwo=true;}
			if (!hidegroupthree) {hideg3(); hidegroupthree=true;}
			setupBlocks();
			placebottombar();		
		}
	}	
}

function showg1(){
	window.scrollTo(0, 0);	
	
	if(searching==true){
		endsearch();	
	} 
	
	if (!hidegroupone) {hideg1(); hidegroupone=true;}
	if (hidegrouptwo) {hideg2(); hidegrouptwo=false;}
	if (hidegroupthree) {hideg3(); hidegroupthree=false;}
	
	 setupBlocks();
	placebottombar();
	
	
}

function showg2(){

	window.scrollTo(0, 0);	
	
	
	if(searching==true){
		endsearch();
	} 
	
	if (hidegroupone) {hideg1(); hidegroupone=false;}
	if (!hidegrouptwo) {hideg2(); hidegrouptwo=true;}
	if (hidegroupthree) {hideg3(); hidegroupthree=false;}
	setupBlocks();

	placebottombar();
	
}


function showg3(){

	window.scrollTo(0, 0);	
	
	
	if(searching==true){
		endsearch();		
	} 
	
	if (hidegroupone) {hideg1(); hidegroupone=false;}
	if (hidegrouptwo) {hideg2(); hidegrouptwo=false;}
	if (!hidegroupthree) {hideg3(); hidegroupthree=true;}
	setupBlocks();

	placebottombar();

}

function onTestChange(e) {
    
    //var key = window.event.keyCode;
    var key = e.keyCode || window.event.keyCode;
    
    //alert(key);

    // If the user has pressed enter
    if (key == 13) {
        search(); 
        return false;       
    }
    else {
        return true;
    }
}

$(document).ready(function() {
  $("#searchquery").keypress(function(event) {
    if(event.which == '13') {
      return false;
    }
  });
});


function unhideresults(){
	docblocks=document.getElementsByClassName("block2");
		while (docblocks.length > 0) {
				docblocks[0].parentNode.style.display = 'block';
				docblocks[0].className = "block";
	}
}


function endsearch(){
	window.scrollTo(0, 0);	
	unhideresults();
	document.getElementById("searchquery").value="";
	searching=false;
	//$('.searchbar').css({'width': '170px'});
	document.getElementById("searchbutton").style.background='rgb(202, 202, 202)';	
	$('.cardname').removeHighlight();
	$('.cardtitle').removeHighlight();
	$('.bio').removeHighlight();
}

function search(){
	searching=true;
	//$('.searchbar').css({'width': '190px'});
	document.getElementById("searchbutton").style.background='rgb(110, 165, 197)';
	$('.cardname').removeHighlight();
	$('.cardtitle').removeHighlight();
	$('.bio').removeHighlight();
	window.scrollTo(0, 0);	
	unhideresults();		
	query=document.getElementById("searchquery").value.toLowerCase();
	if(query!=""){
		docblocks=document.getElementsByClassName("block");
		for (var i = 0; i < docblocks.length; i++) {
			if(docblocks[i].id!="addcard"){
				cardname=docblocks[i].getElementsByClassName("cardname")[0].innerHTML.toLowerCase();
				cardtitle=docblocks[i].getElementsByClassName("cardtitle")[0].innerHTML.toLowerCase();
				cardbio=docblocks[i].getElementsByClassName("bio")[0].innerHTML.toLowerCase();
				searchcontent=cardname+cardtitle+cardbio;
				if(searchcontent.indexOf(query) == -1){
					docblocks[i].parentNode.style.display = 'none';
					docblocks[i].className = "block2";
				i=i-1;
				}
			}
			
		}
				
		$('.bio').highlight(query);
		$('.cardname').highlight(query);
		$('.cardtitle').highlight(query);
		
		 
	}
	setupBlocks();
	placebottombar();
	document.activeElement.blur();
   	$("input").blur();
	//window.parent.document.body.style.zoom = '100%';
}


function hideg1() {
    classoneelements = document.getElementsByClassName("1");
    if (hidegroupone) {
        document.getElementById("g1buttonback").style.background= 'rgb(71, 71, 71)';
        //hidegroupone = false;
        for (var i = 0; i < classoneelements.length; i++) {
             classoneelements[i].style.display = 'none';
             
             blocke1=classoneelements[i].getElementsByClassName("block")
             blocke1[0].className = "block1";

         }  
    } else {
        document.getElementById("g1buttonback").style.background= '';
        //hidegroupone = true;
        for (var i = 0; i < classoneelements.length; i++) {
             classoneelements[i].style.display = 'block';
             
             blocke1=classoneelements[i].getElementsByClassName("block1")
             blocke1[0].className = "block";
              
         }
    }
    //setupBlocks();
}

function hideg2() {
    classtwoelements = document.getElementsByClassName("2");
    if (hidegrouptwo) {
        document.getElementById("g2buttonback").style.background= 'rgb(71, 71, 71)';
        //hidegrouptwo = false;
        for (var i = 0; i < classtwoelements.length; i++) {
             classtwoelements[i].style.display = 'none';
	     
             blocke2=classtwoelements[i].getElementsByClassName("block")
             blocke2[0].className = "block1";
              
         }  
    } else {
        document.getElementById("g2buttonback").style.background= '';
        //hidegrouptwo = true;
        for (var i = 0; i < classtwoelements.length; i++) {
             classtwoelements[i].style.display = 'block';
	     
	     
             blocke2=classtwoelements[i].getElementsByClassName("block1")
             blocke2[0].className = "block";
         }
    }
    //setupBlocks();
}

function hideg3() {
    classthreeelements = document.getElementsByClassName("3");
    if (hidegroupthree) {
        document.getElementById("g3buttonback").style.background= 'rgb(71, 71, 71)';
        //hidegroupthree = false;
        for (var i = 0; i < classthreeelements.length; i++) {
             classthreeelements[i].style.display = 'none';
             
             blocke3=classthreeelements[i].getElementsByClassName("block")
             blocke3[0].className = "block1";
         }  
    } else {
        document.getElementById("g3buttonback").style.background= '';
        //hidegroupthree = true;
        for (var i = 0; i < classthreeelements.length; i++) {
             classthreeelements[i].style.display = 'block';
             
             
             blocke3=classthreeelements[i].getElementsByClassName("block1")
             blocke3[0].className = "block";
         }
    }
    //setupBlocks();
}

function saveCard(ev) {
	var event = document.getElementById("eventtag").innerHTML;
	var useremail = document.getElementById("useremail").innerHTML;
	var note = document.getElementById("commentspace").value;
	encodednote = encodeURIComponent(note);
	
	var cardid=document.getElementById("commentcardid").innerHTML;
	var hostdivName=document.getElementById("commentcardname").innerHTML;
	var hostdiv=document.getElementById(hostdivName);
        //var savestate=document.getElementById("commentcardsaved").innerHTML;
        var cardRole=document.getElementById("commentcardrole").innerHTML.replace("<b style=\"color:#30DBA7\">Role: </b>", "");
        var cardRole = cardRole.replace("<b></b>", "");
        var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
        var dataString = 'event1=' + event + '&useremail1=' + useremail + '&note1=' + encodednote + '&cardid1=' + cardid + '&cardrole1=' + cardRole + '&lmemberid1=' + lmemberid + '&nmemberid1=' + nmemberid;
        
        $("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	ev.preventDefault();
        if (useremail == '' ) {
		//alert("Please login to save cards");
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
		//swal("Oops...", "Please login to save cards", "error");
		swal({   title: "Oops...",   text: "Please login to save cards",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   window.location='login.php';});
	} else {
		var user = document.getElementById('userfullname').innerHTML;
		var state1 = document.getElementById("displaying").innerHTML;
			if ( state1 == 'savedcards' ) {
				if (savestate=="not saved") {
					// AJAX code to submit form.
					document.getElementById("savecardbutton").disabled = true;
					$(function savecardf() {		
						$.ajax({
						type: "POST",
						url: "query/savecardquery.php",
						data: dataString,
						cache: false,
						timeout:timeoutcountersavecard,
						success: function(html) {
						swal({   title: "Saved",    timer: 1000 });
						closeComment();
						savestate="edit";
				        	document.getElementById("savecardbutton").value="update";
				        	(hostdiv.getElementsByClassName("save"))[0].innerHTML ="Update Card";
				        	//(hostdiv.getElementsByClassName("save2"))[0].innerHTML ="edit";
				        	(hostdiv.getElementsByClassName("commentoncard"))[0].innerHTML =note;
				        	$("body").css("cursor", "default");
				        	$(":button").css("cursor", "pointer");
				        	document.getElementById("savecardbutton").disabled = false;
							},
						
						error: function (request, status, error) {
						        if (status == "timeout") {
						                // timeout -> reload the page and try again  
								timeoutcountersavecard=timeoutcountersavecard*2;
								savecardf();
						            } else {
								$("body").css("cursor", "default");
								$(":button").css("cursor", "pointer");
								document.getElementById("savecardbutton").disabled = false;
						            }
						    }      
			  
						});
					});
				}
				else {
					
					document.getElementById("savecardbutton").disabled = true;
					$(function editcardf() {	
						$.ajax({
						type: "POST",
						url: "query/editsavedcardquery.php",
						timeout:timeoutcountereditcard,
						data: dataString,
						cache: false,
						success: function(html) {
						swal({   title: "Updated",      timer: 1000 });
						//blinksavecard();
						//alert(html);
						closeComment();
						(hostdiv.getElementsByClassName("commentoncard"))[0].innerHTML =note;
						$("body").css("cursor", "default");
						$(":button").css("cursor", "pointer");
						document.getElementById("savecardbutton").disabled = false;	
							},
						    
						error: function (request, status, error) {
						        if (status == "timeout") {
						                // timeout -> reload the page and try again  
								timeoutcountereditcard=timeoutcountereditcard*2;
								editcardf();
						            } else {
						            	document.getElementById("savecardbutton").disabled = false;
								$("body").css("cursor", "default");
								$(":button").css("cursor", "pointer");
						            }
						    }      
							
							
						});
					});	
					
				}
			}
			else{
				
				if( user.length == 0  || state!="cardadded"   ){
					showaddcardsavealert();
				}
				else{
					if (savestate=="not saved") {
						
						// AJAX code to submit form.
						document.getElementById("savecardbutton").disabled = true;
						$(function savecardf() {		
							$.ajax({
							type: "POST",
							url: "query/savecardquery.php",
							data: dataString,
							cache: false,
							timeout:timeoutcountersavecard,
							success: function(html) {
							swal({   title: "Saved",    timer: 1000 });
							closeComment();
							savestate="edit";
					        	document.getElementById("savecardbutton").value="update";
					        	(hostdiv.getElementsByClassName("save"))[0].innerHTML ="Update Card";
					        	//(hostdiv.getElementsByClassName("save2"))[0].innerHTML ="edit";
					        	(hostdiv.getElementsByClassName("commentoncard"))[0].innerHTML =note;
					        	$("body").css("cursor", "default");
					        	$(":button").css("cursor", "pointer");
					        	document.getElementById("savecardbutton").disabled = false;
								},
							
							error: function (request, status, error) {
							        if (status == "timeout") {
							                // timeout -> reload the page and try again  
									timeoutcountersavecard=timeoutcountersavecard*2;
									savecardf();
							            } else {
									$("body").css("cursor", "default");
									$(":button").css("cursor", "pointer");
									document.getElementById("savecardbutton").disabled = false;
							            }
							    }      
				  
							});
						});
					}
					else {
						document.getElementById("savecardbutton").disabled = true;
						
						$(function editcardf() {	
							$.ajax({
							type: "POST",
							url: "query/editsavedcardquery.php",
							timeout:timeoutcountereditcard,
							data: dataString,
							cache: false,
							success: function(html) {
							swal({   title: "Updated",      timer: 1000 });
							//blinksavecard();
							//alert(html);
							closeComment();
							(hostdiv.getElementsByClassName("commentoncard"))[0].innerHTML =note;
							$("body").css("cursor", "default");
							$(":button").css("cursor", "pointer");
							document.getElementById("savecardbutton").disabled = false;	
								},
							    
							error: function (request, status, error) {
							        if (status == "timeout") {
							                // timeout -> reload the page and try again  
									timeoutcountereditcard=timeoutcountereditcard*2;
									editcardf();
							            } else {
							            	document.getElementById("savecardbutton").disabled = false;
									$("body").css("cursor", "default");
									$(":button").css("cursor", "pointer");
							            }
							    }      
								
								
							});
						});	
						
					}
				}
				
			}
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");	
	}

}



function deleteCard(ev) {
	
	var event = document.getElementById("eventtag").innerHTML;
	var useremail = document.getElementById("useremail").innerHTML;
	var note = document.getElementById("commentspace").value;
	var cardid=document.getElementById("commentcardid").innerHTML;
	var hostdivName=document.getElementById("commentcardname").innerHTML;
	var hostdiv=document.getElementById(hostdivName);
        //var savestate=document.getElementById("commentcardsaved").innerHTML;
        var dataString = 'event1=' + event + '&useremail1=' + useremail + '&cardid1=' + cardid;
        $("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	ev.preventDefault();
        if (useremail == '' ) {
		//alert("Please login to save cards");
		
	} else {
		document.getElementById("deletecardbutton").disabled = true;
		// AJAX code to submit form.
		$(function deletesavedcardf() {
			$.ajax({
			type: "POST",
			url: "query/deletesavedcardquery.php",
			data: dataString,
			timeout:timeoutcounterdeletesavedcard,
			cache: false,
			success: function(html) {
			//alert(html);
			//window.location='index.php';
			if(document.getElementById("displaying").innerHTML != 'savedcards'){swal({   title: "Deleted",     timer: 1000 });}
			closeComment();
			//document.getElementById("commentcardsaved").innerHTML ="not saved"; 
			savestate="not saved";
	        	document.getElementById("savecardbutton").value="save";
	        	(hostdiv.getElementsByClassName("save"))[0].innerHTML ="Save Card";
	        	(hostdiv.getElementsByClassName("commentoncard"))[0].innerHTML ="";
		        	if(document.getElementById("displaying").innerHTML == 'savedcards'){
				  hostdiv.style.display = 'none';
				  hostdiv.className = "block1";
				  
				  setupBlocks();
				  
		        	}
		        	$("body").css("cursor", "default");
		        	$(":button").css("cursor", "pointer");
		        	document.getElementById("deletecardbutton").disabled = false;
				},

			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcounterdeletesavedcard=timeoutcounterdeletesavedcard*2;
					deletesavedcardf();
			            } else {
					$("body").css("cursor", "default");
			       		$(":button").css("cursor", "pointer");
			       		document.getElementById("deletecardbutton").disabled = false;
			            }
			    }     
			    
			});
		});	
	}
	
	//return false;
}


function myCards() {
	//closeWizard();
	$('body').css('background-image','');
	//chat related
	//document.getElementById("board").style.display='none';
	//document.getElementById("boardmenu").style.display='none';
	//boardopen=false;
	//var event = document.getElementById("event").innerHTML;
	
	//for export
	//document.getElementById("boardmenu").style.display='';
	
	var useremail = document.getElementById("useremail").innerHTML;
	document.getElementById("displaying").innerHTML = 'savedcards';
	var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
	document.getElementById("ranksection").style.display='none';
	document.getElementById("statsbutton").style.display='none';
	//document.getElementById("sendcard").style.display='none';
	//document.getElementById("helpbutton").style.display='none';
	if(nmemberid==''){nmemberid="Not Available";}
	if(lmemberid==''){lmemberid="Not Available";}

        var dataString = 'useremail=' + useremail + '&lmemberid=' + lmemberid + '&nmemberid=' + nmemberid;
        $("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
        
        //alert(useremail=='');
        if (useremail == '' ) {
		//alert("Please login to build your Cardstak");
		$("body").css("cursor", "default");
		$('.topbutton').css("cursor", "pointer");
		$('a').css("cursor", "pointer");
		//swal("Oops...", "Please login to save cards", "error");
		swal({   title: "Oops...",   text: "Please login to save cards",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   window.location='login.php';});
	} else {
		document.getElementById("mainbody").innerHTML = loaderHTML;
		// AJAX code to submit form.
		$(function mycardsf() {
			$.ajax({
			type: "POST",
			url: fillmyquery,
			data: dataString,
			cache: false,
			timeout:timeoutcountermycards,
			success: function(html) {
			document.getElementById("mainbody").innerHTML=html;
			//setupBlocks();
			
			if ($(window).width()<500) {removeBios();}
       			else{ 
			setupBlocks();
			}
			
			$('.block').each(function (i) {
				$(this).css({
					'-webkit-transition': 'all .6s ease-out',
					'-moz-transition': 'all .6s ease-out',
					'-o-transition': 'all .6s ease-out',
					'transition': 'all .6s ease-out',  'opacity': '1', 'filter': 'alpha(opacity=100)'
					});
			});
			
			$('.dont_open').click(function (e) {
	   		 e.stopPropagation();
			});
		      $(".bio").dotdotdot();
		      placebottombar();	
		      $("body").css("cursor", "default");
		      $('.topbutton').css("cursor", "pointer");
		      $('a').css("cursor", "pointer");
				},
			error: function (request, status, error) {
			        //alert(request.responseText);
			        if (status == "timeout") {
			                // timeout -> reload the page and try again
				             
				             //clearInterval(ajax_call);
				             timeoutcountermycards=timeoutcountermycards*2;
				             //window.location.reload(); 
				             mycardsf();
			            } else {
			                 $("body").css("cursor", "default");
					 $('.topbutton').css("cursor", "pointer");
					 $('a').css("cursor", "pointer");
			            }
			    }
			});
		});
			
		document.getElementById("event").innerHTML="Saved Cards";
		document.getElementById("addcardbutton").style.display = 'none';
		document.getElementById("backbutton").style.display = '';
		//document.getElementById("loginbutton").style.display = 'none';
		document.getElementById("myeventsbutton").style.display = '';
		document.getElementById("g1buttonback").style.display = 'none';
		document.getElementById("g2buttonback").style.display = 'none';
		document.getElementById("g3buttonback").style.display = 'none';
		
		document.getElementById("showallbuttonback").innerHTML = 'No Bio';
		removebio = true;   
		
	}
	return false;
}


function goBack() {
    $("body").css("cursor", "progress");
    $('.topbutton').css("cursor", "progress");
    $(':button').css("cursor", "progress");
    $('a').css("cursor", "progress");
    //document.getElementById("displaying").innerHTML = 'event';
    var event = document.getElementById("eventtag").innerHTML;
    var eventid = document.getElementById("eventid").innerHTML;
    window.location="index.php?event_id="+eventid;
}


function myEvents() {
	$("body").css("cursor", "progress");
        $('.topbutton').css("cursor", "progress");
        $('a').css("cursor", "progress");
	var useremail = document.getElementById("useremail").innerHTML;
	if (useremail == '' ) {
		$("body").css("cursor", "default");
		$('.topbutton').css("cursor", "pointer");
		$('a').css("cursor", "pointer");
		//swal("Oops...", "Please login to see your events", "error");
		swal({   title: "Oops...",   text: "Please login to see your events",   type: "error",   showCancelButton: true,   confirmButtonColor: "#30988b",  confirmButtonText: "Login",   closeOnConfirm: false }, function(){   window.location='login.php';});
		
	} else {
		var event = document.getElementById("eventtag").innerHTML;
		var eventid = document.getElementById("eventid").innerHTML;
		window.location="index.php?event_id="+eventid+"&page=myevents";
	}		
}

function fillmyEventsCards() {
	document.getElementById("page").innerHTML="myevents";
	document.title="My Staks";
	var event = document.getElementById("eventtag").innerHTML;
	var eventid = document.getElementById("eventid").innerHTML;
	var useremail = document.getElementById("useremail").innerHTML;
	$('body').css('background-image','url("/images/background.jpg")');
	document.getElementById("displaying").innerHTML = 'savedevents';
	document.getElementById("ranksection").style.display='none';
	document.getElementById("statsbutton").style.display='none';
	//document.getElementById("helpbutton").style.display='none';
	//document.getElementById("sendcard").style.display='none';
	var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
	if(nmemberid==''){nmemberid="Not Available";}
	if(lmemberid==''){lmemberid="Not Available";}

        var dataString = 'useremail=' + useremail + '&lmemberid=' + lmemberid + '&nmemberid=' + nmemberid;
        
        //alert(useremail=='');
        if (useremail == '' ) {
		//alert("Please login to create events");
		//sweetAlert("Oops...", "Something went wrong!", "error");
		window.location="index.php?event_id="+eventid;
		$("body").css("cursor", "default");
		$('.topbutton').css("cursor", "pointer");
		$('a').css("cursor", "pointer");
		
	} else {
		// AJAX code to submit form.
		$(function myeventsf() {	
			$.ajax({
			type: "POST",
			url: "query/myevents.php",
			data: dataString,
			cache: false,
			timeout:timeoutcountermyevents,
			success: function(html) {
			document.getElementById("mainbody").innerHTML=html;
			if(eventid==''){document.getElementById("createeventbackbutton").style.display='none';}
			setupBlocks();
			$('.dont_open').click(function (e) {
	   		 e.stopPropagation();
			});
			$(".bio").dotdotdot();	
			$("body").css("cursor", "default"); 
			$('.topbutton').css("cursor", "pointer");    
			$('a').css("cursor", "pointer"); 	
				},
			    
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcountermyevents=timeoutcountermyevents*2;
					myeventsf();
			            } else {
					$("body").css("cursor", "default");
				        $('.topbutton').css("cursor", "pointer");
				        $('a').css("cursor", "pointer");
			            }
			    }      
			    
			    
			});
		});	
		
		document.getElementById("event").innerHTML="My Staks";
		document.getElementById("addcardbutton").style.display = 'none';
		document.getElementById("backbutton").style.display = '';
		//document.getElementById("loginbutton").style.display = '';
		document.getElementById("myeventsbutton").style.display = 'none';
		document.getElementById("showallbutton").style.display = 'none';
		document.getElementById("g1buttonback").style.display = 'none';
		document.getElementById("g2buttonback").style.display = 'none';
		document.getElementById("g3buttonback").style.display = 'none';
		document.getElementById("showallbuttonback").style.display = 'none';
		
		

		
	}
	return false;
}



function deleteEvent(eventid) {
	swal({   title: "Are you sure?",   text: "You will not be able to recover this event",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, 
	function(){   


	var nmemberid = document.getElementById("nmemberid").innerHTML;
	var lmemberid = document.getElementById("lmemberid").innerHTML;
	if(nmemberid==''){nmemberid="Not Available";}
	if(lmemberid==''){lmemberid="Not Available";}

	
	var dataString = 'eventid=' + eventid + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid  ;
	$("body").css("cursor", "progress");

	// AJAX code to submit form.
	$(function deleteeventf() {	
		$.ajax({
		type: "POST",
		url: "query/deleteeventquery.php",
		data: dataString,
		cache: false,
		timeout:timeoutcounterdeleteevent,
		success: function(event_id) {
		swal("Deleted!", "Your event has been deleted.", "success"); 
		location.reload();
		//document.getElementById("createeventbackbutton").style.display = 'none';
		//document.getElementById("backbutton").style.display = 'none';
		$("body").css("cursor", "default");
			},

		error: function (request, status, error) {
			        if (status == "timeout") {
			                //alert('salam');
			                // timeout -> reload the page and try again  
					timeoutcounterdeleteevent=timeoutcounterdeleteevent*2;
					deleteeventf();
			            } else {
					$("body").css("cursor", "default");
			            }
			    }   
		
		
		});
		
		return false;
		
		});
	});	
}



function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return true; //parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return true; //return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
       // IE 12 => return version number
       return true; //return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}


function savecreateSession() {		
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/create_card.php?event_id="+event_id;
	var dataString = 'url=' + url;
	$.ajax({
	type: "POST",
	url: "query/savesession.php",
	data: dataString,
	cache: false,
	success: function(html) {
		window.location='login.php';

		},
	error: function (request, status, error) {

	    }
	});
            
}


function saveeditSession() {		
	var event_id = document.getElementById("eventid").innerHTML;
	var url="http://www.cardstak.com/edit_card.php?event_id="+event_id;
	var dataString = 'url=' + url;
	$.ajax({
	type: "POST",
	url: "query/savesession.php",
	data: dataString,
	cache: false,
	success: function(html) {
	//alert(html);

		},
	error: function (request, status, error) {

	    }
	});
            
}



function saveeventSession() {		
	var dataString = 'url=http://www.cardstak.com/create_event.php';
	$.ajax({
	type: "POST",
	url: "query/savesession.php",
	data: dataString,
	cache: false,
	success: function(html) {
	//alert(html);
		window.location='login.php';
		},
	error: function (request, status, error) {

	    }
	});
            
}	


function trackActivity(to,from,activity,email,cardid){
	var eventid = document.getElementById("eventid").innerHTML;
	var dataString = 'eventid=' + eventid + '&cardid=' + cardid + '&eventname=' + eventname + '&to=' + to+ '&from=' + from + '&emailto=' + email+ '&activity=' + activity;
	$.ajax({
	type: "POST",
	url: "query/recordactivity.php",
	data: dataString,
	cache: false,
	success: function(html) {
		/*if( (activity=="checkweb" || activity=="checklinkedin") && (from!="" && email!="" && email!="test@test.com" && document.getElementById('addcard').style.display=='none')){
				var activitytype;
				if (activity=="checkweb") activitytype=" just visited your website";
				if (activity=="checklinkedin") activitytype=" just visited your LinkedIn profile";
				
				var Emailsubject=from+activitytype;
				
				var title = document.getElementsByClassName("cardtitle")[0].innerHTML;
				var img = document.getElementsByClassName("circle")[0];
				var style = img.currentStyle || window.getComputedStyle(img, false);
				var userimage = style.backgroundImage.slice(4, -1);
				
				var HTMLmessage=createemailmessage(userimage,from,title,activitytype,eventurl,eventname,"visit");
				
				var dataString1 = 'emailfrom=' + eventname + '&emailto='+email+ '&emailsubject=' + Emailsubject + '&emailmessage=' + HTMLmessage + '&fromname=Cardstak' + '&toname=' + to  + '&replyemail=no.reply@cardstak.com'  + '&eventurl=' + eventurl+ '&title=' + title+ '&pic=' + img;
					
		        	$.ajax({
				type: "POST",
				url: "query/emailquery.php",
				data: dataString1,
				cache: false,
				timeout:timeoutcountersendemail,
				success: function(html) {
				//alert(html);
				//swal({   title: "Email Sent",    timer: 1000 });
					},
				error: function (request, status, error) {
				            
				    }    
				});	
	
		}*/
	
	

		},
	error: function (request, status, error) {
	    }
	
	});
}

function trackEmail(to,from,activity,email,cardid,message){
	var eventid = document.getElementById("eventid").innerHTML;
	var dataString = 'eventid=' + eventid + '&cardid=' + cardid + '&eventname=' + eventname + '&to=' + to+ '&from=' + from + '&emailto=' + email+ '&activity=' + activity +'&message=' + message;
	$.ajax({
	type: "POST",
	url: "query/recordactivity.php",
	data: dataString,
	cache: false,
	success: function(html) {
		},
	error: function (request, status, error) {
	    }
	
	});
}

	


function createemailmessage(img,Fromname,title,Emailmessage,eventurl,Eventname,type){

	var hibubble = '';
	img = img.replace(/['"]+/g, '');
	//'"'"
	var messageadd="";
	if(type=="message"){
		 Emailmessage = '<div style="font-weight: 300;text-align: left;padding-left: 40px;">'+Emailmessage+'</div>';
		 messageadd = 'sent you a message';		 
	}
	if(type=="hi"){
		Emailmessage = 'Says Hi! <br><br><span style="font-weight: 300">Open Stak to say Hi back</span>';
		hibubble = '<img src="http://www.cardstak.com/images/hibubble.png" style="width:110px;height: 80px;">';
	}
	var eventurl = 'http://www.cardstak.com/'+eventurl;
	var emailcontent = '<div style="background-color:#f2f2f2">\
    <center>\
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#f2f2f2">\
            <tbody>\
                <tr>\
                    <td align="center" valign="top" style="padding:20px 20px;">\
                        <table border="0" cellpadding="0" cellspacing="0" style="width:600px;text-align:center">\
                            <tbody>\
                                <tr>\
                                     <a href="http://www.cardstak.com" title="Cardstak" style="text-decoration:none;font-size: 24pt;font-family: inherit;font-variant: normal;color: #35978B!important;" target="_blank"><img src="http://www.cardstak.com/images/emaillogo.png" alt="Cardstak"   style="margin-left: auto;margin-right: auto;display: block;margin-bottom: 10px;width: 130px;height: 34px;"/></a>\
                                    </td>\
                                </tr>\
                                <tr>\
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:20px">\
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px">\
                                            <tbody>\
                                                <tr>\
                                                    <td align="center" style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;padding-top:40px;padding-right:40px;padding-bottom:0px;padding-left:40px;text-align:center">\
                                                        <div style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin:0;padding:0;text-align:center;border-bottom:1px solid grey">\
                                                          '+hibubble+'<img src="'+img+'" style="width: 80px;height: 80px;margin-right:10px;border-radius: 15px;-webkit-border-radius: 15px;-moz-border-radius: 15px;"><div style="margin-top:10px">'+Fromname+' <span style="color:rgb(53, 151, 139)">'+title+'</span></div><div style="margin-top:10px;margin-bottom:10px;font-weight:300">'+messageadd+'</div>\
                                                        </div>\
                                                         <h1 style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin-top:20px;padding:0;text-align:center">'+Emailmessage+'</h1>\
                                                        <br>\
                                                         <h3 style="color:#35978B!important;font-family:Helvetica,Arial,sans-serif;font-size:18px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center;font-weight:300;">@ '+ Eventname +'</h3>\
                                                        <br>\
                                                    </td>\
                                                </tr>\
                                                <tr>\
                                                    <td align="center" valign="middle" style="padding-right:40px;padding-bottom:40px;padding-left:40px">\
                                                        <table border="0" cellpadding="0" cellspacing="0" style="background-color:#35978b;border-collapse:separate!important;border-radius:3px">\
                                                            <tbody>\
                                                                <tr>\
                                                                     <td align="center" valign="middle" style="color:#ffffff;font-family:Helvetica,Arial,sans-serif;font-size:15px;font-weight:bold;line-height:100%;padding-top:15px;padding-right:15px;padding-bottom:15px;padding-left:15px"> <a href="'+eventurl+'" style="color:#ffffff;text-decoration:none" target="_blank">Open Stak</a>\
                                                                    </td>\
                                                                </tr>\
                                                            </tbody>\
                                                        </table>\
                                                    </td>\
                                                </tr>\
                                            </tbody>\
                                        </table>\
                                    </td>\
                                </tr>\
                                <tr>\
                                    <td align="center" valign="top">\
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">\
                                            <tbody>\
                                                <tr>\
                                                    <td align="center" valign="top" style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:125%">create your own Staks for <b style="color:#35978b;">FREE</b> with Cardstak.com<span style="font-size:10px">\
                                            </td>\
                                        </tr>\
                                    </tbody></table>\
                                </td>\
                            </tr>\
                        </tbody></table>\
                    </td>\
                </tr>\
            </tbody></table>\
        </center>\
</div></div>';
	return emailcontent;
}



function createemailmessage_savedcards(Fromname,Emailmessage,type){
	//now work!
	var messageadd="";
	
	if(type=="message"){
		Emailmessage = '<div style="font-weight: 300;text-align: left;padding-left: 40px;">'+Emailmessage+'</div>';
		messageadd = 'sent you a message';
	}
	if(type=="hi"){
		Emailmessage = 'Says Hi!';
	}
	var emailcontent = '<div style="background-color:#f2f2f2">\
    <center>\
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="background-color:#f2f2f2">\
            <tbody>\
                <tr>\
                    <td align="center" valign="top" style="padding:20px 20px;">\
                        <table border="0" cellpadding="0" cellspacing="0" style="width:600px;text-align:center">\
                            <tbody>\
                                <tr>\
                                     <a href="http://www.cardstak.com" title="Cardstak" style="text-decoration:none;font-size: 24pt;font-family: inherit;font-variant: normal;color: #35978B!important;" target="_blank"><img src="http://www.cardstak.com/images/emaillogo.png" alt="Cardstak"   style="margin-left: auto;margin-right: auto;display: block;margin-bottom: 10px;width: 130px;height: 34px;"/></a>\
                                    </td>\
                                </tr>\
                                <tr>\
                                    <td align="center" valign="top" style="padding-top:10px;padding-bottom:20px">\
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#ffffff;border-collapse:separate!important;border-radius:4px">\
                                            <tbody>\
                                                <tr>\
                                                    <td align="center" style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:150%;padding-top:40px;padding-right:40px;padding-bottom:0px;padding-left:40px;text-align:center">\
                                                        <div style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin:0;padding:0;text-align:center;border-bottom:1px solid grey">\
                                                            <div style="margin-top:10px">'+Fromname+'</div><div style="margin-top:10px;margin-bottom:10px;font-weight:300">'+messageadd+'</div>\
                                                        </div>\
                                                         <h1 style="color:#606060!important;font-family:Helvetica,Arial,sans-serif;font-size:20px;font-weight:bold;letter-spacing:-1px;line-height:115%;margin-top:20px;padding:0;text-align:center">'+Emailmessage+'</h1>\
                                                        <br>\
                                                         <h3 style="color:#35978B!important;font-family:Helvetica,Arial,sans-serif;font-size:18px;letter-spacing:-.5px;line-height:115%;margin:0;padding:0;text-align:center;font-weight:300;"> To reply, press reply button in your email client </h3>\
                                                        <br>\
                                                    </td>\
                                                </tr>\
                                                <tr>\
                                                    <td align="center" valign="middle" style="padding-right:40px;padding-bottom:40px;padding-left:40px">\
                                                        <table border="0" cellpadding="0" cellspacing="0" style="background-color:#35978b;border-collapse:separate!important;border-radius:3px">\
                                                        </table>\
                                                    </td>\
                                                </tr>\
                                            </tbody>\
                                        </table>\
                                    </td>\
                                </tr>\
                                <tr>\
                                    <td align="center" valign="top">\
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">\
                                            <tbody>\
                                                <tr>\
                                                    <td align="center" valign="top" style="color:#606060;font-family:Helvetica,Arial,sans-serif;font-size:15px;line-height:125%">create your own Staks for <b style="color:#35978b;">FREE</b> with Cardstak.com<span style="font-size:10px">\
                                            </td>\
                                        </tr>\
                                    </tbody></table>\
                                </td>\
                            </tr>\
                        </tbody></table>\
                    </td>\
                </tr>\
            </tbody></table>\
        </center>\
</div></div>';
	return emailcontent;
}




function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    /* \"'"  */
    return re.test(email);
}



/* unused functions */

/*function starthelpintro(){
	

	document.body.scrollTop = document.documentElement.scrollTop = 0;
	
	var useremail = document.getElementById("useremail").innerHTML;
	
	if ($(window).width()<500) { 
	
	
		if (state=="login"){	
			var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#loginbutton'),
		                intro: "View and manage the cards you&#39;ve saved here",
		                position: 'bottom'
		              },
		              {
		                element: '#menuwrapper',
		                intro: 'View Staks you&#39;ve created or joined here',
		                position: 'left'
		              },
		              {
		                element: '#showallbuttonback',
		                intro: 'Use this button to expand cards and view additional information',
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();
	          }
	          else if (state=="nologin"){
	          	var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#addcardbutton'),
		                intro: "Click this button to add your card",
		                position: 'left'
		              },
		              {
		                element: document.querySelectorAll('#showallbuttonback')[0],
		                intro: "Use this button to expand cards and view additional information",
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();	
	          }
	          else {
	          	var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#sendcard'),
		                intro: "Click here to Email your card",
		                position: 'bottom'
		              },
		              {
		                element: document.querySelector('#loginbutton'),
		                intro: "View and manage the cards you&#39;ve saved here",
		                position: 'bottom'
		              },
		              {
		                element: '#menuwrapper',
		                intro: 'View Staks you&#39;ve created or joined here',
		                position: 'left'
		              },
		              {
		                element: '#showallbuttonback',
		                intro: 'Use this button to expand cards and view additional information',
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();	
	          }
          }
          else{
          
          	if (state=="login"){	
			var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#loginbutton'),
		                intro: "View and manage the cards you&#39;ve saved here",
		                position: 'bottom'
		              },
		              {
		                element: document.querySelectorAll('#createstep')[0],
		                intro: "Use this button to create new Staks for events, classes and small projects",
		              },
		              {
		                element: '#menuwrapper',
		                intro: 'View Staks you&#39;ve created or joined here',
		                position: 'left'
		              },
		              {
		                element: '#at4-share',
		                intro: 'Use these sharing options to invite others to this Stak',
		                position: 'left'
		              },
		              {
		                element: '#showallbuttonback',
		                intro: 'Use this button to only see names, titles and pictures',
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();
	          }
	          else if(state=="nologin"){
	          	var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#addcardbutton'),
		                intro: "Click this button to add your card",
		                position: 'left'
		              },
		              {
		                element: '#at4-share',
		                intro: 'Use these sharing options to invite others to this Stak',
		                position: 'left'
		              },
		              {
		                element: document.querySelectorAll('#showallbuttonback')[0],
		                intro: "Use this button to only see names, titles and pictures",
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();	
	          }
	          else{
	          	var intro = introJs();
		          intro.setOptions({
		            steps: [
		              {
		                element: document.querySelector('#sendcard'),
		                intro: "Click here to Email your card",
		                position: 'bottom'
		              },
		              {
		                element: document.querySelector('#loginbutton'),
		                intro: "View and manage the cards you&#39;ve saved here",
		                position: 'bottom'
		              },
		              {
		                element: document.querySelectorAll('#createstep')[0],
		                intro: "Use this button to create new Staks for events, classes and small projects",
		              },
		              {
		                element: '#menuwrapper',
		                intro: 'View Staks you&#39;ve created or joined here',
		                position: 'left'
		              },
		              {
		                element: '#showallbuttonback',
		                intro: 'Use this button to only see names, titles and pictures',
		              }
		            ]
		          });
		          intro.setOption('showProgress', true).start();
	          }
              
          }
}


function openSendcard() {
	
    $('#sendcardbackground, #sendcardbox').fadeIn(350);
    var theElements = hostDiv.getElementsByClassName("multiple_emails-input text-left");
    theElements[0].focus();

}

function closeSendcard() {
    $('#sendcardbackground, #sendcardbox').fadeOut(350);
    
    setTimeout(function() {
    	 document.getElementsByClassName("multiple_emails-ul")[0].innerHTML="";
   	 document.getElementById("current_emailsBS").innerHTML="";
   	 document.getElementById("sendcardbutton").value="add";
    }, 400);
 
}


function toggleBoard(){
	//closeboard
	window.scrollTo(0, 0);
	if(boardopen==true){
		boardopen=false;
		document.getElementById("board").style.width="0px";
		document.getElementById("boardtoggle").innerHTML='<span class="firsta"> &#10094;</span><span class="seconda">&#10094;</span><span class="thirda">&#10094;</span><span class="fourtha">&#10094; </span> Open Chat';
	}
	//openboard
	else {
		boardopen=true;
		if(onphone==true){
			document.getElementById("board").style.width="100%";
			document.getElementById("chatarea").style.width="100%";
			document.getElementById("chatwindow").style.width="100%";
			document.getElementById("chats").style.width="94%";
		}
		else{
			document.getElementById("board").style.width=boardsize+"px";
			document.getElementById("chatarea").style.width=boardsize+"px";
			document.getElementById("chatwindow").style.width="";
			document.getElementById("chats").style.width="";
		}	
		document.getElementById("boardtoggle").innerHTML='Close Chat <span class="fourtha">&#10095;</span><span class="thirda">&#10095;</span><span class="seconda">&#10095;</span><span class="firsta">&#10095; </span>';
	}
	//alert("salam");
	setupBlocks();
	placebottombar();
}


$(function () {
	
	$('#example_emailBS').change(function() {
		var email_to = $('#example_emailBS').val();
		if(email_to=="" || email_to=="[]"){
			document.getElementById("sendcardbutton").value="add";
		}
		else{
			document.getElementById("sendcardbutton").value="send";
		}
	});	 
});


function sendCard(){
	//work dude
	var event_id = document.getElementById("eventid").innerHTML;
	var card_id = usersid;
	var email_from = document.getElementById("useremail").innerHTML;
	var user_from = document.getElementById('userfullname').innerHTML;
	var email_to = $('#example_emailBS').val();
	
	//alert(email_to);
	
	var dataString = 'eventid=' + event_id + '&cardid=' + card_id + '&userfrom=' + user_from + '&emailfrom=' + email_from + '&emailto=' + email_to;	
	
	//work dude!
	//alert(dataString);
	
	if(email_to=="" || email_to=="[]"){
        	$('.white_content_sendcard').css('z-index', 222);
        	
        	swal({   title: "Oops...",  text: "Please enter atleast one Email address",   type: "error",  showCancelButton: false,   confirmButtonColor: "#30988b",  confirmButtonText: "OK",   closeOnConfirm: true }, function(){  $('.white_content_sendcard').css('z-index', 2222222);  });
        	
        	
		
        }
	else{
		$('#sendcardbutton').prop('disabled', true);
		$.ajax({
			type: "POST",
			url: "query/sendcardquery.php",
			data: dataString,
			cache: false,
			success: function(result) {
					//alert(result);
					swal({   title: "Email Sent",    timer: 1000 });
					$('#sendcardbutton').prop('disabled', false);
				},
			error: function (request, status, error) {
				        //alert(error);
				        $('#sendcardbutton').prop('disabled', false);
				        if (status == "timeout") {
				}  
			} 
		});
	closeSendcard();
	document.getElementById("sendcardbutton").value="add";	
	}
	
	
}

function reply(email,name){
	//asdas
	replybool=true;
	replyto=name;
	replytoemail=email;
	document.getElementById("adchat").value='@'+replyto+': ';
	document.getElementById("adchat").focus();

}

*/