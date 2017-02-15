var timeoutcounternewevent=3000;


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



function myFunction() {
	$("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	whitenFields();
	var eventname = document.getElementById("eventname").value;
	eventname= encodeURIComponent(eventname.replace(/,/g, " "));
	var eventdate = document.getElementById("eventdate").value;
	var groupno = document.querySelector('input[name="eventgroupno"]:checked').value;
	var eventtype = document.querySelector('input[name="evtype"]:checked').value;
	var group1name = encodeURIComponent(document.getElementById("group1name").value);	
	var group2name = encodeURIComponent(document.getElementById("group2name").value);
	var group3name = encodeURIComponent(document.getElementById("group3name").value);
	var nmemberid = document.getElementById("eventnmemberid").value;
	var lmemberid = document.getElementById("eventlmemberid").value;

	
	var dataString = 'eventname=' + eventname + '&eventdate=' + eventdate + '&groupno=' + groupno + '&group1name=' + group1name + '&group2name=' + group2name + '&group3name=' + group3name + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid + '&eventtype=' + eventtype  ;
	
		
	
	
	if (eventname == '') {
		//alert("Please create a name for your event");
		sweetAlert("Oops...", "Please create a name for your event", "error");
		document.getElementById("eventname").style.border="2px solid red";
		document.getElementById("eventname").style.background="rgb(255, 238, 238)";
		$("body").css("cursor", "default");
	 	$(":button").css("cursor", "pointer");
	}
	else if (groupno=='2' && (group1name=='' || group2name=='') )	{
		//alert("Please choose a name for groups 1 & 2");
		sweetAlert("Oops...", "Please choose a name for groups 1 & 2", "error");
		if(group1name==''){
			document.getElementById("group1name").style.border="2px solid red";
			document.getElementById("group1name").style.background="rgb(255, 238, 238)";
		}
		if(group2name==''){
			document.getElementById("group2name").style.border="2px solid red";
			document.getElementById("group2name").style.background="rgb(255, 238, 238)";
		}
		$("body").css("cursor", "default");
	 	$(":button").css("cursor", "pointer");
	}
	else if (groupno=='3' && (group1name=='' || group2name=='' || group3name==''))	{
		//alert("Please choose a name for groups 1, 2 & 3");
		sweetAlert("Oops...", "Please choose a name for groups 1, 2 & 3", "error");
		if(group1name==''){
			document.getElementById("group1name").style.border="2px solid red";
			document.getElementById("group1name").style.background="rgb(255, 238, 238)";
		}
		if(group2name==''){
			document.getElementById("group2name").style.border="2px solid red";
			document.getElementById("group2name").style.background="rgb(255, 238, 238)";
		}
		if(group3name==''){
			document.getElementById("group3name").style.border="2px solid red";
			document.getElementById("group3name").style.background="rgb(255, 238, 238)";
		}
		$("body").css("cursor", "default");
	 	$(":button").css("cursor", "pointer");
	} 
	/*else if (!isValid(eventname) || !isValid(group1name) || !isValid(group2name) || !isValid(group3name) ){
		sweetAlert("Oops...", "Please do not include special characters in event title and group names", "error");
		$("body").css("cursor", "default");
	 	$(":button").css("cursor", "pointer");
	}*/
	else {
		document.getElementById("createbutton").disabled = true;
		// AJAX code to submit form.
		$(function neweventf() {	
			$.ajax({
			type: "POST",
			url: "query/neweventquery.php",
			data: dataString,
			timeout:timeoutcounternewevent,
			cache: false,
			success: function(event_id) {
			window.location="index.php?event_id="+event_id+"&givesharetips=true";
			$("body").css("cursor", "default");
		 	$(":button").css("cursor", "pointer");	
		 	document.getElementById("createbutton").disabled = false;
				},

			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcounternewevent=timeoutcounternewevent*2;
					neweventf();
			            } else {
					$("body").css("cursor", "default");
					$(":button").css("cursor", "pointer");
					document.getElementById("createbutton").disabled = false;
			            }
			    }     
			    
			    
			});
		});	
	}
	return false;
}




function whitenFields(){
	document.getElementById("eventname").style.border="";
	document.getElementById("eventname").style.background="";
	document.getElementById("group1name").style.border="";
	document.getElementById("group1name").style.background="";
	document.getElementById("group2name").style.border="";
	document.getElementById("group2name").style.background="";
	document.getElementById("group3name").style.border="";
	document.getElementById("group3name").style.background="";	
}

function isValid(str){
 return !/[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/g.test(str);
}