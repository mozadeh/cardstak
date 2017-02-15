<?php
require_once('../config.php');
require("../common.php"); 


if(!empty($_POST))
    { 

        $query = " 
            SELECT 
                id,ebtoken
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':email' => $_POST['email'] 
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 

		echo 'Login Failed';
		
        } 

        $login_ok = false; 

        $row = $stmt->fetch(); 
        $rowcount = $stmt->rowCount();
        if($rowcount == 0){
        //email not found
        	  if (!empty($_POST['firstname'])) {
	        	 $query = " 
		            INSERT INTO users ( 
		                email,
		                firstname,
		                lastname,  
				ebtoken,
				firsttime
				
		            ) VALUES ( 
		                :ebemail,
		                :ebfirstname,
		                :eblastname,
		                :ebtoken,
		                :firsttime
		            ) 
		        "; 
		         
		      
		        $query_params = array( 
		             ':ebemail' => $_POST['email'],
		             ':ebfirstname' => $_POST['firstname'],
		             ':eblastname' => $_POST['lastname'],
	             	     ':ebtoken' => $_POST['ebtoken'],
		             ':firsttime' => 'yes'  
		        ); 
	        } 
	        else{
	        	 $query = " 
		            INSERT INTO users ( 
		                email,
				ebtoken,
				firsttime
		            ) VALUES ( 
		                :ebemail,
		                :ebtoken,
		                :firsttime
		            ) 
		        "; 
		         
		      
		        $query_params = array( 
		             ':ebemail' => $_POST['email'],
		             ':ebtoken' => $_POST['ebtoken'],
		             ':firsttime' => 'yes'  
		        ); 
	        }
	        try 
	        { 
	            
			$stmt = $db->prepare($query); 
			$result = $stmt->execute($query_params);
			if (!empty($_POST['firstname'])) {$firstname = $_POST['firstname'];} else {$firstname = "";}
			if (!empty($_POST['lastname'])) {$lastname = $_POST['lastname'];} else {$lastname = "";}
			
			$insertedid = $db->lastInsertId();
			
			$sessionvalue = [
			"email" => $_POST['email'],
			"firstname" => $firstname,
			"lastname" => $lastname,
			"nmemberid" => $insertedid,
			"linkedinlogin" => "false"
			];
			
			$_SESSION['user'] = $sessionvalue; 
			//added here
			$url = 'https://www.eventbriteapi.com/v3/webhooks/';
			$ch = curl_init();                    // initiate curl
			$postf = "endpoint_url=http://www.cardstak.com/query/update_event.php?user_id=".$insertedid."&actions=order.placed";
			$authorization = "Authorization: Bearer ".$_POST['ebtoken'];
			
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
			curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postf); // define what you want to post
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
			$output = curl_exec ($ch); // execute
			 
			curl_close ($ch); // close curl handle
	            
	        } 
	        catch(PDOException $ex) 
	        { 
	         
	            die("Failed to run query: " . $ex->getMessage()); 
	        } 
	        
	       
	        
		echo 'inserted row';
		
        } 
        else{
        //email found 
        
        	if (!empty($_POST['firstname'])) {
        		$query =" 
		            UPDATE users 
		            SET firstname = :ebfirstname,
		                lastname = :eblastname,
		                ebtoken = :ebtoken,
		                firsttime = :firsttime
			    WHERE email = :ebemail
		        "; 
		         
		      
		        $query_params = array( 
		             ':ebemail' => $_POST['email'],
		             ':ebfirstname' => $_POST['firstname'],
		             ':eblastname' => $_POST['lastname'],
	             	     ':ebtoken' => $_POST['ebtoken'],
		             ':firsttime' => 'no'  
		        ); 
	        } 
	        else{
	        	 $query =" 
		            UPDATE users 
		            SET ebtoken = :ebtoken,
		                firsttime = :firsttime
			    WHERE email = :ebemail
		        "; 
		         
		      
		        $query_params = array( 
		             ':ebemail' => $_POST['email'],
		             ':ebtoken' => $_POST['ebtoken'],
			     ':firsttime' => 'no'  		           
		        ); 
	        }
	        try 
	        { 
	        //echo "damn shit is:".var_dump($row)."-EOD";  	
	          	if( $row['ebtoken'] === NULL ){
				$url = 'https://www.eventbriteapi.com/v3/webhooks/';
				$ch = curl_init();                    // initiate curl
				$postf = "endpoint_url=http://www.cardstak.com/query/update_event.php?user_id=".$row['id']."&actions=order.placed";
				$authorization = "Authorization: Bearer ".$_POST['ebtoken'];
				
				curl_setopt($ch, CURLOPT_URL,$url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
				curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
				curl_setopt($ch, CURLOPT_POSTFIELDS, $postf); // define what you want to post
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
				$output = curl_exec ($ch); // execute
				 
				curl_close ($ch); 
			}
	          	
	          	  
			$stmt = $db->prepare($query); 
			$result = $stmt->execute($query_params);
	            	
	            	if (!empty($_POST['firstname'])) {$firstname = $_POST['firstname'];} else {$firstname = "";}
	            	if (!empty($_POST['lastname'])) {$lastname = $_POST['lastname'];} else {$lastname = "";}

	            	
			$sessionvalue = [
			"email" => $_POST['email'],
			"firstname" => $firstname,
			"lastname" => $lastname,
			"nmemberid" => $row['id'],
			"linkedinlogin" => "false"
			];
			
			$_SESSION['user'] = $sessionvalue; 
			
			
			
				
	            
	        } 
	        catch(PDOException $ex) 
	        { 
	         
	            die("Failed to run query: " . $ex->getMessage()); 
	        } 
	        
		echo 'updated row';

	       } 
	        
     } 


?>