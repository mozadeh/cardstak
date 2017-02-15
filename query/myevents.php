<?php
require_once('../config.php');


$eventdiv="<table class=\"tablestyle\" cellpadding=\"6\" align=\"center\">";

$query = "Select * FROM events WHERE 
               creatornmemberid = :nmemberid OR creatorlmemberid = :lmemberid";
  
                
$query_params = array(      
        ':nmemberid' => $_POST['nmemberid'],
        ':lmemberid' => $_POST['lmemberid']
    );


try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

	
$rows = $stmt->fetchAll();


if ($rows) {
   $notcreatedevent=true;
    $eventdiv=$eventdiv."
         <tr align=\"center\">
             <td class=\"eventgrouptitle\"> Created

            </td>
        </tr><tr><td><table>";
    foreach ($rows as $row) {
	$eventdiv=$eventdiv."
	<tr>
            <td> <a href=\"index.php?event_id=".$row["eventid"]."\">&#149; ".$row["eventname"]."</a>
            	
            </td>
            <td style=\"padding-left:50px\">	
            	<a href=\"edit_event.php?event_id=".$row["eventid"]."\">edit</a>

            </td>
            <td style=\"padding-left:10px\" onclick=\"deleteEvent('".$row["eventid"]."');\">	
            	<a href=\"#\">delete</a>

            </td>
        </tr>";
	}
	$eventdiv=$eventdiv."</td></tr></table>";
}

else {
	$notcreatedevent=false;
}




$query = "Select * FROM cards WHERE 
               nmemberid = :nmemberid OR lmemberid = :lmemberid";
  
                
$query_params = array(      
        ':nmemberid' => $_POST['nmemberid'],
        ':lmemberid' => $_POST['lmemberid']
    );


try {
    $stmt   = $db->prepare($query);
    $result = $stmt->execute($query_params);
}
catch (PDOException $ex) {
    $response["success"] = 0;
    $response["message"] = "Database Error!";
    die(json_encode($response));
}

	
$rows = $stmt->fetchAll();


if ($rows) {
   
    $eventdiv=$eventdiv."
         <tr align=\"center\">
             <td class=\"eventgrouptitle\">Attended

            </td>
        </tr><tr><td><table>";
    foreach ($rows as $row) {
	$eventdiv=$eventdiv."
	<tr>
            <td> <a href=\"index.php?event_id=".$row["eventid"]."\">&#149; ".$row["event"]."</a>
		 
	    </td>
        </tr>";
	}
	$eventdiv=$eventdiv."</td></tr></table>";
}

else {
	if($notcreatedevent==false){
		$eventdiv=$eventdiv."
         <tr align=\"center\">
             <td class=\"eventgrouptitle\"> No events attended or created yet

            </td>
        </tr>";
	}
}

$eventdiv=$eventdiv."<tr>
            		<td >
<table align=\"center\" style=\"margin-top:20px\">
				<tr>
					<td  align=\"center\">
					
						<input type=\"button\" id=\"createeventbackbutton\"  onclick=\"goBack();\" style=\"width:120px;margin-right:60px\" align=\"center\" value=\"Back\"/>
					</td>
					<td  align=\"center\">
					
						<input type=\"button\" onclick=\"window.location='create_event.php';\" style=\"width:120px; align=\"center\" value=\"Create\"/>
					</td>
				</tr>
			</table>
			 </td>
        </tr>";

$eventdiv=$eventdiv."</table>";



echo $eventdiv;



?>