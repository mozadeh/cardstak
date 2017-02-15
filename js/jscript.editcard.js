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
	    	document.getElementById("delete-btn").style.display= 'block';
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
var timeoutcountereditcard=3000;
var timeoutcounterdeletecard=3000;

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
	    	document.getElementById("delete-btn").style.display= 'block';
	    	//document.getElementById("submit-btn").style.display= 'none';
	    	document.getElementById("FileInput").style.display= 'none';
    	}
  	if ( document.getElementById("formemail").value == "") {document.getElementById("cardemail").style.display= 'none';}
  	else { document.getElementById("cardemail").style.display = '';}
  	if ( document.getElementById("formlinkedin").value == "") {	document.getElementById("cardlinkedin").style.opacity='0';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=0);'; }
				
    	else { 			document.getElementById("cardlinkedin").style.opacity='1';
				document.getElementById("cardlinkedin").style.filter='alpha(opacity=100);';}
	
	
	//var event = document.getElementById("eventtag").innerHTML;
	var event_id = document.getElementById("eventid").innerHTML;
	var eventurl="index.php?event_id="+event_id;
	var nmemberid = document.getElementById("formnmemberid").value;
	var lmemberid = document.getElementById("formlmemberid").value;
        var dataString = 'eventid1=' + event_id + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid;
	
        
	// AJAX code to submit form.
	//$(function checkcardf() {	
		$.ajax({
		type: "POST",
		url: "query/checkcardquery.php",
		timeout:timeoutcountercheckcard,
		data: dataString,
		cache: false,
		success: function(result) {
				if(result<1){
					//alert('please create a card for the event first')
					sweetAlert("Oops...", "please create a card for the event first", "error");
					window.location=eventurl;
				}
			},
		error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
			                location.reload();
					//timeoutcountercheckcard=timeoutcountercheckcard*2;
					//checkcardf();
			            } else {

			            }
			    }   	
		});
	//});	
	
	
	
	var eventidurl = document.getElementById("eventid").innerHTML;
        var dataString = 'eventid=' + eventidurl;
	// AJAX code to submit form.
	$(function checkeventf() {	
		$.ajax({
		type: "POST",
		url: "query/checkeventquery.php",
		data: dataString,
		dataType: "json",
		cache: false,
		timeout:timeoutcounterecheckevent,
		success: function(result) {
		
		/*var resultarray = result.split(",");
		var eventid=resultarray[0];
		eventname=resultarray[1];
		var eventdate=resultarray[2];
		var groupno=resultarray[3];
		var group1name=resultarray[4];
		var group2name=resultarray[5];
		var group3name=resultarray[6];*/
		
		var eventid=result[0];
		eventname=result[1];
		var eventdate=result[3];
		var groupno=result[6];
		var group1name=result[7];
		var group2name=result[8];
		var group3name=result[9];
		
		//alert(result.toString());
		
		if(eventidurl!=eventid || eventidurl=='' ){
				window.location='http://www.cardstak.com';
				}
		else{
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
		
			}
		document.getElementById("event").innerHTML=eventname;	
		document.getElementById("grouptable").style.display = '';
		document.getElementById("loaderdiv").style.display = 'none';
			},
		error: function (request, status, error) {
				
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcounterecheckevent=timeoutcounterecheckevent*2;
					checkeventf();
			            } else {
					window.location='http://www.cardstak.com';
			            }
			    }
		});
	});
	
	
	
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
	var event_id = document.getElementById("eventid").innerHTML;
   	//var event = document.getElementById("eventtag").innerHTML;
    	var eventurl="index.php"+"?event_id="+event_id;
	var fullname = encodeURIComponent(document.getElementById("formname").value);
	var title = encodeURIComponent(document.getElementById("formtitle").value);
	var bio = encodeURIComponent(document.getElementById("formbio").value);
	var phone = document.getElementById("formphone").value;
	var email = document.getElementById("formemail").value;
	var weburl = document.getElementById("formweb").value;
	var cvlink = document.getElementById("formcv").value;
	var linkedin = document.getElementById("formlinkedin").value;
	var nmemberid = document.getElementById("formnmemberid").value;
	var lmemberid = document.getElementById("formlmemberid").value;
	var group = document.querySelector('input[name="group"]:checked').value;
	
        var photourl =$("#photourldb").css('background-image');
        //photourl = photourl.replace('url(','').replace(')','');
        photourl = photourl.substring(4, photourl.length-1);
        photourl = photourl.replace(/['"]+/g, '');
        //'"'"
        
        if (weburl.substring(0, 4)=="www.") weburl="http://"+weburl;
        if (linkedin.substring(0, 4)=="www.") linkedin="http://"+linkedin;
        if (cvlink.substring(0, 4)=="www.") cvlink="http://"+cvlink;
	
	var dataString = 'event1=' + eventname + '&eventid1=' + event_id + '&fullname1=' + fullname + '&title1=' + title + '&bio1=' + bio + '&phone1=' + phone + '&email1=' + email + '&cvlink1=' + cvlink + '&linkedin1=' + linkedin + '&weburl1=' + weburl + '&photourl1=' + photourl + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid  + '&group1=' + group ;
	
	
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
	} else {
		// AJAX code to submit form.
		$(function editcardf() {		
			$.ajax({
			type: "POST",
			url: "query/editcardquery.php",
			data: dataString,
			timeout:timeoutcountereditcard,
			cache: false,
			success: function(html) {
			//alert(html);		
			window.location=eventurl;
			$("body").css("cursor", "default");
	 		$(":button").css("cursor", "pointer");
				},
	
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcountereditcard=timeoutcountereditcard*2;
					editcardf();
			            } else {
			            	$("body").css("cursor", "default");
		 			$(":button").css("cursor", "pointer");
			            }
			    }     
			    
			    
			});
		});	
	}
	return false;
}


function whitenFields(){
	document.getElementById("formname").style.border="";
	document.getElementById("formname").style.background="";
	document.getElementById("formtitle").style.border="";
	document.getElementById("formtitle").style.background="";
	document.getElementById("formemail").style.border="";
	document.getElementById("formemail").style.background="";
	document.getElementById("formweb").style.border="";
	document.getElementById("formweb").style.background="";	
	document.getElementById("formcv").style.border="";
	document.getElementById("formcv").style.background="";	
	document.getElementById("formphone").style.border="";
	document.getElementById("formphone").style.background="";	
}




function myDeleteFunction() {
	swal({   title: "Are you sure?",   text: "Do you want to delete your card for this event",   type: "warning",   showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Yes, delete it!",   closeOnConfirm: false }, 
	function(){   swal("Deleted!", "Your card been deleted for this event.", "success"); 
	$("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	var event_id = document.getElementById("eventid").innerHTML;
   	//var event = document.getElementById("eventtag").innerHTML;
    	var eventurl="index.php"+"?event_id="+event_id;
	var nmemberid = document.getElementById("formnmemberid").value;
	var lmemberid = document.getElementById("formlmemberid").value;
	// Returns successful data submission message when the entered information is stored in database.id="photourldb" 
	
	var dataString = 'eventid1=' + event_id+ '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid ;
	
	
	// AJAX code to submit form.
	$(function deletecardf() {	
		$.ajax({
		type: "POST",
		url: "query/deletecardquery.php",
		data: dataString,
		cache: false,
		timeout:timeoutcounterdeletecard,
		success: function(html) {
		//alert(html);
		$("body").css("cursor", "default");
	 	$(":button").css("cursor", "pointer");
		window.location=eventurl;
			},

		error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcounterdeletecard=timeoutcounterdeletecard*2;
					deletecardf();
			            } else {
			            	$("body").css("cursor", "default");
		 			$(":button").css("cursor", "pointer");
			            }
			    } 
		
		    
			
		});
	});
	return false;
});
	
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