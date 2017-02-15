/*$(function () {
	
});*/

window.onload = function () { 
    	if (document.getElementById("evemail").innerHTML!=""){
		
		

		var email = document.getElementById("evemail").innerHTML;
		var ebtoken =  document.getElementById("ebtoken").innerHTML;
		var fullname =	document.getElementById("evfullname").innerHTML; 
		
		var dataString = 'email=' + email + '&ebtoken=' + ebtoken;
		
		if (fullname != ""){
			var firstname= fullname.substring(0, fullname.indexOf(' '));
			var lastname= fullname.substring(fullname.indexOf(' ')+1, fullname.length);
			var dataString = 'email=' + email + '&ebtoken=' + ebtoken + '&firstname=' + firstname + '&lastname=' + lastname;
			
		}
		//alert (dataString);
		// AJAX code to submit form.
		$.ajax({
		type: "POST",
		url: "query/evloginquery.php",
		data: dataString,
		cache: false,
		success: function(result) {
				//alert(result);
				sweetAlert("We're in!", "Login successful" , "success");
				//if(result==='inserted row') {setInterval(gotoCreateEvent, 1500);}
				//else {setInterval(gotoURL, 1500);}
				// gotoURL();
				setTimeout(gotoURL, 1500);
				//gotoURL();
			},
		error: function (request, status, error) {
		        	sweetAlert("Error", "Error" , "error");
		    }
		});
	
		
		
	}
}


/*function registerattempt(){
	//alert(document.getElementById("registeremail").value);
	registeremail=document.getElementById("registeremail").value;
}*/

function gotoURL(){
	//alert("salam");
	var gotourl =  document.getElementById("goto").value;
	window.location= gotourl;
	//var location = "http://www.cardstak.com/"+gotourl;
	//alert(location);
	return false;
}


function gotoCreateEvent(){
	window.location="http://www.cardstak.com/create_event.php";
}

function evhover(element) {
    element.setAttribute('src', 'http://cardstak.com/images/evsignin-hover.png');
}

function evunhover(element) {
    element.setAttribute('src', 'http://cardstak.com/images/evsignin.png');
}

function hover(element) {
    element.setAttribute('src', 'http://cardstak.com/images/Sign-In-Large---Hover.png');
}
function unhover(element) {
    element.setAttribute('src', 'http://cardstak.com/images/Sign-In-Large---Default.png');
}



function loginattempt(){
	$("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	whitenFields();
	var email = document.getElementById("email").value;
	var password =  document.getElementById("password").value;
	

	var dataString = 'email=' + email + '&password=' + password;
	
	if (email == '') {
		swal("Oops...", "Please enter your email", "error");
		document.getElementById("email").style.border="2px solid red";
		document.getElementById("email").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");
	}	
	else if( password== '' ){
		sweetAlert("Oops...", "Please enter your password", "error");
		document.getElementById("password").style.border="2px solid red";
		document.getElementById("password").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");
	} else {
	
		// AJAX code to submit form.
		$.ajax({
		type: "POST",
		url: "query/loginquery.php",
		data: dataString,
		cache: false,
		success: function(result) {
		if(result=="Login successful"){
			sweetAlert("We're in!", result , "success");
			setInterval(gotoURL, 1500);
		}
		else{
			sweetAlert("Oops...", result, "error");
		}
		//alert(html);		
		//window.location=eventurl;
		 $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");	
			},
		error: function (request, status, error) {
		        //alert(request.responseText);
		  $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");
		    }
		});
	}
	return false;
}


function registerattempt(){
	$("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	whitenFields();
	var registeremail = document.getElementById("registeremail").value;
	var registerpassword =  document.getElementById("registerpassword").value;
	var registerfirstname = document.getElementById("registerfirstname").value;
	var registerlastname = document.getElementById("registerlastname").value;

	var dataString = 'registeremail=' + registeremail + '&registerpassword=' + registerpassword + '&registerfirstname=' + registerfirstname + '&registerlastname=' + registerlastname;
	
	if (registeremail == '') {
		swal("Oops...", "Please enter your email", "error");
		document.getElementById("registeremail").style.border="2px solid red";
		document.getElementById("registeremail").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}	
	else if( registerpassword== '' ){
		sweetAlert("Oops...", "Please enter your password", "error");
		document.getElementById("registerpassword").style.border="2px solid red";
		document.getElementById("registerpassword").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}
	else if( registerfirstname== '' ){
		sweetAlert("Oops...", "Please enter your firstname", "error");
		document.getElementById("registerfirstname").style.border="2px solid red";
		document.getElementById("registerfirstname").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}
	else if( registerlastname== '' ){
		sweetAlert("Oops...", "Please enter your lastname", "error");
		document.getElementById("registerlastname").style.border="2px solid red";
		document.getElementById("registerlastname").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	} else {
		// AJAX code to submit form.
		$.ajax({
		type: "POST",
		url: "query/registerquery.php",
		data: dataString,
		cache: false,
		success: function(result) {
		if(result=="User Registered"){
			clearFields();
			document.getElementById("password").focus();
			sweetAlert("Congrats!", result+", please re-enter your password to Login" , "success");
			document.getElementById("loginmessage").innerHTML="<b>Please re-enter your password to Login</b>";
			document.getElementById("email").value=registeremail;
			document.getElementById("password").style.border="2px solid blue";
			
		}
		else{
			sweetAlert("Oops...", result, "error");
		}
		 $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");	
			},
		error: function (request, status, error) {
		        //alert(request.responseText);
		 $("body").css("cursor", "default");
		 $(":button").css("cursor", "pointer");
		    }
		});
	}
	return false;
}


function whitenFields(){
	document.getElementById("email").style.border="";
	document.getElementById("email").style.background="";
	document.getElementById("password").style.border="";
	document.getElementById("password").style.background="";

	document.getElementById("registeremail").style.border="";
	document.getElementById("registeremail").style.background="";
	document.getElementById("registerpassword").style.border="";
	document.getElementById("registerpassword").style.background="";
	document.getElementById("registerfirstname").style.border="";
	document.getElementById("registerfirstname").style.background="";
	document.getElementById("registerlastname").style.border="";
	document.getElementById("registerlastname").style.background="";
	
}


function clearFields(){
	document.getElementById("email").value="";
	document.getElementById("password").value="";	
	document.getElementById("registeremail").value="";
	document.getElementById("registerpassword").value="";
	document.getElementById("registerfirstname").value="";
	document.getElementById("registerlastname").value="";
}