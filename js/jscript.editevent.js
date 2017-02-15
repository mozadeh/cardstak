
var timeoutcountereditevent=3000;
var timeoutcountercheckevent=2000;

$(function checkeventf() {
	var eventidurl = document.getElementById("eventid").value;
	//var event = document.getElementById("event").innerHTML;
        var dataString = 'eventid=' + eventidurl;
	// AJAX code to submit form.
	$.ajax({
	type: "POST",
	url: "query/checkeventquery.php",
	dataType: "json",
	data: dataString,
	cache: false,
	timeout:timeoutcountercheckevent,
	success: function(result) {
	
	/*var resultarray = result.split(",");
	var eventid=resultarray[0];
	var eventname=resultarray[1];
	var eventdate=resultarray[2];
	var groupno=resultarray[3];
	var group1name=resultarray[4];
	var group2name=resultarray[5];
	var group3name=resultarray[6];*/
	
	var eventid=result[0];
	var eventname=result[1];
	var eventdate=result[3];
	var groupno=result[6];
	var group1name=result[7];
	var group2name=result[8];
	var group3name=result[9];
	
	
	if(eventidurl!=eventid || eventidurl==''){

			window.location='http://www.cardstak.com/index.php?&page=myevents';
			}
	else{
			if(groupno==3){
				document.getElementById("radio3").checked = true;
				document.getElementById("group1name").value = group1name;
				document.getElementById("group2name").value = group2name;
				document.getElementById("group3name").value = group3name;
				document.getElementById('group1row').style.display='';
				document.getElementById('group2row').style.display='';
				document.getElementById('group3row').style.display='';
			}
			if(groupno==2){
			document.getElementById("radio2").checked = true;
				document.getElementById("group1name").value = group1name;
				document.getElementById("group2name").value = group2name;
				document.getElementById('group1row').style.display='';
				document.getElementById('group2row').style.display='';
				document.getElementById('group3row').style.display='none';
			}
			if(groupno==1){
				document.getElementById("radio1").checked = true;
				document.getElementById('group1row').style.display='none';
				document.getElementById('group2row').style.display='none';
				document.getElementById('group3row').style.display='none';			 		
			}
	
		}
	document.getElementById("eventdate").value=eventdate;	
	document.getElementById("eventname").value=eventname;	
		},
			
		error: function (request, status, error) {
		        if (status == "timeout") {
		                // timeout -> reload the page and try again  
				timeoutcountercheckevent=timeoutcountercheckevent*2;
				checkeventf();
		            } else {
		            	window.location='http://www.cardstak.com/index.php?&page=myevents';
		            }
		    }  
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



function myFunction() {
	$("body").css("cursor", "progress");
        $(":button").css("cursor", "progress");
	whitenFields();
	var eventname = document.getElementById("eventname").value;
	eventname= encodeURIComponent(eventname.replace(/,/g, " "));
	var eventid = document.getElementById("eventid").value;
	var eventdate = document.getElementById("eventdate").value;
	var groupno = document.querySelector('input[name="eventgroupno"]:checked').value;
	var group1name = encodeURIComponent(document.getElementById("group1name").value);	
	var group2name = encodeURIComponent(document.getElementById("group2name").value);
	var group3name = encodeURIComponent(document.getElementById("group3name").value);
	var nmemberid = document.getElementById("eventnmemberid").value;
	var lmemberid = document.getElementById("eventlmemberid").value;

	
	var dataString = 'eventname=' + eventname + '&eventid=' + eventid + '&eventdate=' + eventdate + '&groupno=' + groupno + '&group1name=' + group1name + '&group2name=' + group2name + '&group3name=' + group3name + '&nmemberid1=' + nmemberid + '&lmemberid1=' + lmemberid  ;
	
	
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
		// AJAX code to submit form.
		$(function editeventf() {	
			$.ajax({
			type: "POST",
			url: "query/editeventquery.php",
			timeout:timeoutcountereditevent,
			data: dataString,
			cache: false,
			success: function(event_id) {
			
			window.location="index.php?event_id="+eventid+"&page=myevents";
			//alert(event_id);
			$("body").css("cursor", "default");
		 	$(":button").css("cursor", "pointer");
				}  ,
			
			error: function (request, status, error) {
			        if (status == "timeout") {
			                // timeout -> reload the page and try again  
					timeoutcountereditevent=timeoutcountereditevent*2;
					editeventf();
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