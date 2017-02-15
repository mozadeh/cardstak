$('#formname').on('input', function () {
    document.getElementById("name").innerHTML = $(this).val();
});
$('#formtitle').on('input', function () {
    document.getElementById("title").innerHTML = $(this).val();
});
$('#formbio').on('input', function () {
    document.getElementById("bio").innerHTML = $(this).val();
});
$('#formphone').on('input', function () {
    if ( $(this).val() == "") {document.getElementById("cardphone").style.display= 'none';}
    else { document.getElementById("cardphone").style.display = '';}
});
$('#formweb').on('input', function () {
    if ( $(this).val() == "") {document.getElementById("cardweb").style.display= 'none';}
    else { document.getElementById("cardweb").style.display = '';}
});
$('#formemail').on('input', function () {
    if ( $(this).val() == "") {document.getElementById("cardemail").style.display= 'none';}
    else { document.getElementById("cardemail").style.display = '';}
});
$('#formcv').on('input', function () {
    if ( $(this).val() == "") {
	  	document.getElementById("cardcv").style.display= 'none';
	  	document.getElementById("delete-btn").style.display= 'none';
	    	//document.getElementById("submit-btn").style.display= '';
	    	document.getElementById("FileInput").style.display= '';   	
	}
	else { 
	    	document.getElementById("cardcv").style.display = '';
	    	document.getElementById("delete-btn").style.display= '';
	    	//document.getElementById("submit-btn").style.display= 'none';
	    	document.getElementById("FileInput").style.display= 'none';
    	}
});
$('#formlinkedin').on('input', function () {
    if ( $(this).val() == "") {	document.getElementById("cardlinkedin").style.opacity='0';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=0);'; }
				
    else { 			document.getElementById("cardlinkedin").style.opacity='1';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=100);';}
});

var eventname="";
var timeoutcountercheckcard=10000;
var timeoutcounterecheckevent=2000;
var timeoutcounternewcard=200000;
var groupno;
var eventType;


$(window).on("orientationchange",function(){
  if(window.orientation==0){
  	document.body.style.transform = "rotate(90deg)";
  }
  else if(window.orientation==90){
  	document.body.style.transform = "";
  }
  else if(window.orientation==180){
  	document.body.style.transform = "rotate(-90deg)";
  }
  else if(window.orientation==-90){
  	document.body.style.transform = "";
  }
});

$(function () {
	
     $('.bio').dotdotdot();
     
     if( (window.innerHeight > window.innerWidth) && ($(window).width()<500) ){
     	document.body.style.transform = "rotate(90deg)";
	var winH = $(window).height();
	var winW = $(window).width();
	
	var iniH = $('#wrapper').outerHeight();
	var iniW = $('#wrapper').outerWidth();
	
	var scale = winH/iniW;
	
	$('#wrapper').css({ transform: 'scale('+scale+')' });

	window.scrollBy(100, 0);;
	
     }
     
});


$(function () {
	//workd!
	

	if ( document.getElementById("formphone").value == "") {document.getElementById("cardphone").style.display= 'none';}
	else { document.getElementById("cardphone").style.display = '';}
	if ( document.getElementById("formweb").value == "") {document.getElementById("cardweb").style.display= 'none';}
  	else { document.getElementById("cardlinkedin").style.display = '';}
  	if ( document.getElementById("formcv").value == "") {
	  	document.getElementById("cardcv").style.display= 'none';
	  	document.getElementById("delete-btn").style.display= 'none';
	    	//document.getElementById("submit-btn").style.display= '';
	    	document.getElementById("FileInput").style.display= '';   	
	}
	else { 
		
	    	document.getElementById("cardcv").style.display = '';
	    	document.getElementById("delete-btn").style.display= '';
	    	//document.getElementById("submit-btn").style.display= 'none';
	    	document.getElementById("FileInput").style.display= 'none';
    	}
  	if ( document.getElementById("formemail").value == "") {document.getElementById("cardemail").style.display= 'none';}
  	else { document.getElementById("cardemail").style.display = '';}
  	if ( document.getElementById("formlinkedin").value == "") {	document.getElementById("cardlinkedin").style.opacity='0';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=0);'; }
				
    	else { 			document.getElementById("cardlinkedin").style.opacity='1';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=100);';}
	
	var event = document.getElementById("eventtag").innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var eventurl="index.php?event_id="+event_id;
	var nmemberid = document.getElementById("formnmemberid").value;
	var lmemberid = document.getElementById("formlmemberid").value;
        
	
        var dataString = 'event=' + event + '&eventid=' + event_id;
	// AJAX code to submit form.
	$(function checkeventf() {	
		$.ajax({
		type: "POST",
		url: "query/checkeventquery.php",
		data: dataString,
		dataType: "json",
		timeout:timeoutcounterecheckevent,
		success: function(result) {
				var dataString1 = 'event1=' + event + '&eventid1=' + event_id + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid;
				
				
				var eventid=result[0];
				eventname=result[1];
				var eventdate=result[3];
				groupno=result[6];
				var group1name=result[7];
				var group2name=result[8];
				var group3name=result[9];
				eventType=result[10];
				
				
				if(event_id!=eventid || event_id=='' ){

						window.location='http://www.cardstak.com';
				}
				
				else{
								
				
					$.ajax({
						
						type: "POST",
						url: "query/checkcardquery.php",
						timeout:timeoutcountercheckcard,
						data: dataString1,
						cache: false,
						success: function(result1) {
								if(result1>0){
									//sweetAlert("Oops...", "can\'t submit more than one card per event", "error");
									window.location = eventurl;
								}
								else{
									$('#createtable').fadeIn();
									
									if(groupno==3){
										document.getElementById("g1button").innerHTML = group1name;
										document.getElementById("g2button").innerHTML = group2name;
										document.getElementById("g3button").innerHTML = group3name;
									}
									if(groupno==2){
										document.getElementById("g1button").innerHTML = group1name;
										document.getElementById("g2button").innerHTML = group2name;
										document.getElementById("g3buttonback").style.display = 'none';
									}
									if(groupno==1){
										document.getElementById("g1buttonback").style.display = 'none';
										document.getElementById("g2buttonback").style.display = 'none';
										document.getElementById("g3buttonback").style.display = 'none';
										document.getElementById("rolelabel").style.display = 'none';
									}
									
									
									document.getElementById("event").innerHTML=eventname;
									document.getElementById("grouptable").style.display = '';
									document.getElementById("loaderdiv").style.display = 'none';
								
								}
					
							},
						error: function (request, status, error) {

							        if (status == "timeout") {
							                // timeout -> reload the page and try again  
									window.location = eventurl;
									//timeoutcountercheckcard=timeoutcountercheckcard*2;
									//checkcardf();
							            } else {
					
							            }
							    }   
					
					});
					
					
				}
	
			},
		error: function (request, status, error) {

			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcounterecheckevent=timeoutcounterecheckevent*2;
					checkeventf();
			            } else {
					//window.location='http://www.yahoo.com';
					window.location = eventurl;
					//alert(error);
			            }
			    }   
		
		});
	});
	
	
	
	
	
	//return false;
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

function goBack() {
    $("body").css("cursor", "progress");
    $(":button").css("cursor", "progress");
    var event_id = document.getElementById("eventid").innerHTML;
    //var event = document.getElementById("eventtag").innerHTML;
    var eventurl="index.php?event_id="+event_id;
    window.location=eventurl;
}



function myFunction() {
	
	$("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	whitenFields();
	//var event = document.getElementById("eventtag").innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var matcherurl = "matcher.php"+"?event_id="+event_id +"&card_id=";
	var eventurl="index.php"+"?event_id="+event_id;
	var fullname = encodeURIComponent(document.getElementById("formname").value);
	var title = encodeURIComponent(document.getElementById("formtitle").value);
	var bio = encodeURIComponent(document.getElementById("formbio").value);
	var phone = document.getElementById("formphone").value;
	var email = document.getElementById("formemail").value;
	var linkedin = document.getElementById("formlinkedin").value;
	var cvlink = document.getElementById("formcv").value;
	var weburl = document.getElementById("formweb").value;
	var nmemberid = document.getElementById("formnmemberid").value;
	var lmemberid = document.getElementById("formlmemberid").value;
	var size=$('input[name="group"]:checked').size();
	
	if  (groupno==1){
		var group=1;
	}
	else if (size > 0 && groupno!=1){
		var group = document.querySelector('input[name="group"]:checked').value;
	}
	else { 
		sweetAlert("Oops...", "Please indicate your role", "error");
		document.getElementById("rolelabel").style.color="red";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
 		return false;
 	}
	
	if (weburl.substring(0, 4)=="www.") weburl="http://"+weburl;
	if (linkedin.substring(0, 4)=="www.") linkedin="http://"+linkedin;
	if (cvlink.substring(0, 4)=="www.") cvlink="http://"+cvlink;
	
        var photourl =$("#photourldb").css('background-image');
        //photourl = photourl.replace('url(','').replace(')','');
        photourl = photourl.substring(4, photourl.length-1);
	photourl = photourl.replace(/['"]+/g, '');
	//'"'"
	
	/*var dataString = 'event1=' + eventname + '&eventid1=' + event_id  + '&fullname1=' + fullname + '&title1=' + title + '&bio1=' + bio + '&phone1=' + phone + '&email1=' + email + '&linkedin1=' + linkedin + '&weburl1=' + weburl + '&photourl1=' + photourl + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid + '&group1=' + group ;*/
	
		
	
	
	if (fullname == '') {
		sweetAlert("Oops...", "Please include your name", "error");
		document.getElementById("formname").style.border="2px solid red";
		document.getElementById("formname").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	} 
	else if (title == '' ) {
		sweetAlert("Oops...", "Please include your title", "error");
		document.getElementById("formtitle").style.border="2px solid red";
		document.getElementById("formtitle").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
	}
	else if (email!="" && validateEmail(email) != true ) {
		sweetAlert("Oops...", "Please add a valid email address", "error");
		document.getElementById("formemail").style.border="2px solid red";
		document.getElementById("formemail").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
	}
	else if (weburl!="" && validateUrl(weburl) != true ) {
		sweetAlert("Oops...", "Please add a valid URL address", "error");
		document.getElementById("formweb").style.border="2px solid red";
		document.getElementById("formweb").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
	}
	else if (cvlink!="" && validateUrl(cvlink) != true ) {
		sweetAlert("Oops...", "Please add a valid URL address", "error");
		document.getElementById("formcv").style.border="2px solid red";
		document.getElementById("formcv").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
	}
	else if (phone!="" && validatePhone(phone) != true ) {
		sweetAlert("Oops...", "Please add a valid phone number", "error");
		document.getElementById("formphone").style.border="2px solid red";
		document.getElementById("formphone").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
 		$(":button").css("cursor", "pointer");
	}  else {
	
		document.getElementById("submitbutton").disabled = true;
		
		if(photourl.indexOf("media.licdn") > -1){
			var photoname = fullname + 'linkedinpic';
			var photoDataString = 'photoid1=' + lmemberid + '&photourl1=' + photourl;
			$.ajax({
			type: "POST",
			url: "query/uploadlinkedinimage.php",
			data: photoDataString,
			cache: false,
			success: function(newfilename) {
			//alert(newfilename);
				photourl='http://cardstak.com/uploads/'+newfilename;
				
				var dataString = 'event1=' + eventname + '&eventid1=' + event_id  + '&fullname1=' + fullname + '&title1=' + title + '&bio1=' + bio + '&phone1=' + phone + '&email1=' + email + '&cvlink1=' + cvlink  + '&linkedin1=' + linkedin + '&weburl1=' + weburl + '&photourl1=' + photourl + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid + '&group1=' + group ;
				

				
				
				$(function newcardf() {	
					$.ajax({
					type: "POST",
					url: "query/newcardquery.php",
					data: dataString,
					cache: false,
					timeout:timeoutcounternewcard,
				success: function(cardid) {
					
					matcherurl = matcherurl + cardid;
					
					if (eventType == 'basic'){
						window.location=eventurl;
					}
					else if ( eventType == 'matcher'){
						window.location=matcherurl;
					}
									
					$("body").css("cursor", "default");
			 		$(":button").css("cursor", "pointer");
					document.getElementById("submitbutton").disabled = false;	
						},
				
				error: function (request, status, error) {
					        if (status == "timeout") {
					                // timeout -> reload the page and try again  
							timeoutcounternewcard=timeoutcounternewcard*2;
							newcardf();
					            } else {
					            	$("body").css("cursor", "default");
				 			$(":button").css("cursor", "pointer");
				 			document.getElementById("submitbutton").disabled = false;	
					            }
					    }    

					});
				});
				
				
				
	
				},
				error: function (request, status, error) {
			        //alert(request.responseText);
				
				}
			});
		}
		else{

			var dataString = 'event1=' + eventname + '&eventid1=' + event_id  + '&fullname1=' + fullname + '&title1=' + title + '&bio1=' + bio + '&phone1=' + phone + '&email1=' + email + '&cvlink1=' + cvlink  + '&linkedin1=' + linkedin + '&weburl1=' + weburl + '&photourl1=' + photourl +  '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid + '&group1=' + group ;
			
			$(function newcardf() {	
				$.ajax({
				type: "POST",
				url: "query/newcardquery.php",
				data: dataString,
				cache: false,
				timeout:timeoutcounternewcard,
				success: function(cardid) {
				
				matcherurl = matcherurl + cardid;
				
				if (eventType == 'basic'){
					window.location=eventurl;
				}
				else if ( eventType == 'matcher'){
					window.location=matcherurl;
				}
				
				$("body").css("cursor", "default");
		 		$(":button").css("cursor", "pointer");
				document.getElementById("submitbutton").disabled = false;	
					},
			
			error: function (request, status, error) {
				        if (status == "timeout") {
				                // timeout -> reload the page and try again  
						timeoutcounternewcard=timeoutcounternewcard*2;
						newcardf();
				            } else {
				            	$("body").css("cursor", "default");
			 			$(":button").css("cursor", "pointer");
			 			document.getElementById("submitbutton").disabled = false;	
				            }
				    }    

				});
			});
		}
	

	
	
		
	}
	return false;
}

function whitenFields(){
	document.getElementById("rolelabel").style.color="";
	document.getElementById("formname").style.border="";
	document.getElementById("formname").style.background="";
	document.getElementById("formtitle").style.border="";
	document.getElementById("formtitle").style.background="";
	document.getElementById("formemail").style.border="";
	document.getElementById("formemail").style.background="";
	document.getElementById("formweb").style.border="";
	document.getElementById("formweb").style.background="";	
	document.getElementById("formphone").style.border="";
	document.getElementById("formphone").style.background="";
	document.getElementById("formcv").style.border="";
	document.getElementById("formcv").style.background="";		
}

function removeCV(){
	$("#formcv").val("");
	document.getElementById("cardcv").style.display= 'none';
	document.getElementById("delete-btn").style.display= 'none';
	//document.getElementById("submit-btn").style.display= '';
	document.getElementById("FileInput").style.display= '';   
}

function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
} 

function validateUrl(s) {
   var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
   return regexp.test(s);
}


function validatePhone(s) {
   return s.match(/\d/g).length>9;
}