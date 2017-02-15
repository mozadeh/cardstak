function hover(element) {
    element.setAttribute('src', '/images/evsignin-hover.png');
}

function unhover(element) {
    element.setAttribute('src', '/images/evsignin.png');
}

var eventurl;
var accesstoken;
var eventname="";


function prepevent(eventurlv, accesstokenv, eventnamev){
	eventurl = eventurlv;
	accesstoken = accesstokenv;
	eventname = eventnamev;
	document.getElementById("selector").innerHTML = eventname;
	$('.n1').css({'display':'none'});
	$('.createsection').css({'opacity': '1', 'filter': 'alpha(opacity=100)'} );
}


function showmenu(){
	$('.n1').css({'display':'block'});
}

function hidemenu(){
	$('.n1').css({'display':'none'});
}

function previewEvent(){
	$(".preloader").fadeIn();
	if (eventname!=""){
		var re = /([0-9]*)\?ref=ebapi/i;
		var eventid = eventurl.match(re);	
		//var dataString_buildevent = 'eventname=' + eventname + " Preview" + '&groupno=1'  ;
		var dataString_buildevent = 'eventname=' + eventname + '&groupno=1'  ;
		$.ajax({
			type: "POST",
			url: "http://www.cardstak.com/query/neweventquery.php",
			data: dataString_buildevent,
			cache: false,
			success: function(event_id) {
				var dataString_buildattendees = 'eventid=' + eventid[1] + '&accesstoken=' + accesstoken + '&eventname=' + eventname + " Preview"  + '&dbeventid=' + event_id  + '&preview=yes';
				
				$.ajax({
				type: "POST",
				url: "http://www.cardstak.com/query/buildevent.php",
				data: dataString_buildattendees,
				cache: false,
				success: function(html) {
						$(".preloader").fadeOut();
						var url="index.php?event_id="+event_id+"&preview=true";
						var win = window.open(url, '_blank');
		 				win.focus();
						
					},
						//
						error: function (request, status, error) {  
						 
						$(".preloader").fadeOut();     
						//alert(dataString_buildattendees);      
					}   
				});
				
				
				
			},
		
				error: function (request, status, error) {
					$(".preloader").fadeOut();
				       
			}     
		});
	}
}

function buildEvent(nmemberid){
	$(".preloader").fadeIn();
	if (eventname!=""){
		var re = /([0-9]*)\?ref=ebapi/i;
		var eventid = eventurl.match(re);	
		var dataString_buildevent = 'eventname=' + eventname  + '&groupno=1' + '&nmemberid1='+ nmemberid  + '&ebid='+ eventid[1]  + '&eburl='+ eventurl;
		
		$.ajax({
			type: "POST",
			url: "http://www.cardstak.com/query/neweventquery.php",
			data: dataString_buildevent,
			cache: false,
			success: function(event_id) {
				var dataString_buildattendees = 'eventid=' + eventid[1] + '&accesstoken=' + accesstoken + '&eventname=' + eventname + '&dbeventid=' + event_id  + '&preview=no';
				//alert(dataString_buildattendees);
				$.ajax({
				type: "POST",
				url: "http://www.cardstak.com/query/buildevent.php",
				data: dataString_buildattendees,
				cache: false,
				success: function(html) {
						$(".preloader").fadeOut();
						var dataString_emailer = 'dbeventid=' + event_id;
						var url="http://www.cardstak.com/index.php?event_id="+event_id;
						//var win = window.open(url, '_blank');
		 				//win.focus();
		 				//window.open(url,'mywindow').focus()
		 				
						$.ajax({
						type: "POST",
						url: "http://www.cardstak.com/query/emailer.php",
						data: dataString_emailer,
						cache: false,
						success: function(html) {
								//alert(html);
								window.location.href = url;
							},
								error: function (request, status, error) { 
								//alert(error);   
								//alert(dataString_buildattendees);      
							}   
						});
						
						
						
						
					},
						error: function (request, status, error) {      
							$(".preloader").fadeOut();
						//alert(error);   
						//alert(dataString_buildattendees);      
					}   
				});
				
				
				
			},
		
				error: function (request, status, error) {
					$(".preloader").fadeOut();       
			}     
		});
	}
	
}




function logout(){
	$.ajax({
		type: "POST",
		url: "query/evlogout.php",
		cache: false,
		success: function(html) {
				//alert(html);
				location.reload();
			},
				error: function (request, status, error) {      
				alert(error);      
			}   
		});
}