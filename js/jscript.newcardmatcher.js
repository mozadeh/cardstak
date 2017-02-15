
function gotoStak() {
	var event_id = document.getElementById("eventid").value;
	
	var eventurl="index.php"+"?event_id="+event_id;
	
	window.location.href = eventurl;
}



function myFunction() {
	
	
	$("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	whitenFields();
	
	var event_id = document.getElementById("eventid").value;
	
	var eventurl="index.php"+"?event_id="+event_id;
	

	if ((String)(document.getElementById('myrole').innerHTML).indexOf('ms-sel-item') <= -1) {
		sweetAlert("Oops...", "Please complete this field", "error");
		document.getElementById("myrole").style.border="2px solid red";
		document.getElementById("myrole").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	} 
	else if ((String)(document.getElementById('myexp').innerHTML).indexOf('ms-sel-item') <= -1) {
		sweetAlert("Oops...", "Please complete this field", "error");
		document.getElementById("myexp").style.border="2px solid red";
		document.getElementById("myexp").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	} 
	else if ((String)(document.getElementById('targetrole').innerHTML).indexOf('ms-sel-item') <= -1) {
		sweetAlert("Oops...", "Please complete this field", "error");
		document.getElementById("targetrole").style.border="2px solid red";
		document.getElementById("targetrole").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	}
	else if ((String)(document.getElementById('targetexp').innerHTML).indexOf('ms-sel-item') <= -1) {
		sweetAlert("Oops...", "Please complete this field", "error");
		document.getElementById("targetexp").style.border="2px solid red";
		document.getElementById("targetexp").style.background="rgb(255, 238, 238)";
		 $("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	} 
	else if (document.querySelector('input[name="goals[]"]:checked') == null) {
		sweetAlert("Oops...", "Please complete this field", "error");
		document.getElementById("lookinglabel").style.color="red";
		 ("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
	} else {
	
		document.getElementById("myForm").submit();
		 ("body").css("cursor", "default");
  		 $(":button").css("cursor", "pointer");
			
	}

}


function whitenFields(){
	document.getElementById("myrole").style.border="";
	document.getElementById("myrole").style.background="";
	document.getElementById("myexp").style.border="";
	document.getElementById("myexp").style.background="";
	document.getElementById("targetrole").style.border="";
	document.getElementById("targetrole").style.background="";
	document.getElementById("targetexp").style.border="";
	document.getElementById("targetexp").style.background="";
	document.getElementById("lookinglabel").style.color="";
}