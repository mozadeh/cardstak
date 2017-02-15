function goBack(){
	$("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	 window.history.back();
}

function gotoLogin(){
	window.location.href = 'login.php';
}

function resetpasswordattempt(){
	$("body").css("cursor", "progress");
	$(":button").css("cursor", "progress");
	var email = document.getElementById("email").value;
	
	var dataString = 'email=' + email;

	if (email == '') {
		swal("Oops...", "Please enter your email address", "error");
		document.getElementById("email").style.border="2px solid red";
		document.getElementById("email").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
		$(":button").css("cursor", "pointer");
	} else {
		// AJAX code to submit form.
		$.ajax({
		type: "POST",
		url: "query/forgotpasswordquery.php",
		data: dataString,
		cache: false,
		success: function(result) {
		if(result=="A temporary password has been sent to you email"){
			sweetAlert("Congrats!", result, "success");
			setInterval(gotoLogin, 2000);
			
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