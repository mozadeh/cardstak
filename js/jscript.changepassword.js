function goBack(){
	 $("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	 window.history.back();
}


function changepasswordattempt(){
	$("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	whitenFields();
	var oldpassword = document.getElementById("oldpassword").value;
	var newpassword =  document.getElementById("newpassword").value;
	var confirmnewpassword = document.getElementById("confirmnewpassword").value;

	var dataString = 'oldpassword=' + oldpassword + '&newpassword=' + newpassword;

	if (oldpassword == '') {
		swal("Oops...", "Please enter your old password", "error");
		document.getElementById("oldpassword").style.border="2px solid red";
		document.getElementById("oldpassword").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}	
	else if( newpassword== '' ){
		sweetAlert("Oops...", "Please enter your new password", "error");
		document.getElementById("newpassword").style.border="2px solid red";
		document.getElementById("newpassword").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}
	else if( confirmnewpassword== '' ){
		sweetAlert("Oops...", "Please confirm your new password", "error");
		document.getElementById("confirmnewpassword").style.border="2px solid red";
		document.getElementById("confirmnewpassword").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	}
	else if( newpassword!= confirmnewpassword ){
		sweetAlert("Oops...", "Your new passwords must match", "error");
		document.getElementById("newpassword").style.border="2px solid red";
		document.getElementById("newpassword").style.background="rgb(255, 238, 238)";
		document.getElementById("confirmnewpassword").style.border="2px solid red";
		document.getElementById("confirmnewpassword").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	} else {
		// AJAX code to submit form.
		$.ajax({
		type: "POST",
		url: "query/changepasswordquery.php",
		data: dataString,
		cache: false,
		success: function(result) {
		if(result=="Password changed"){
			sweetAlert("Congrats!", result, "success");
			setInterval(goBack, 1500);
			
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
	document.getElementById("oldpassword").style.border="";
	document.getElementById("oldpassword").style.background="";
	document.getElementById("newpassword").style.border="";
	document.getElementById("newpassword").style.background="";
	document.getElementById("confirmnewpassword").style.border="";
	document.getElementById("confirmnewpassword").style.background="";

	
}