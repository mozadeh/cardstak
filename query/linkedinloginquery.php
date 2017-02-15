<?php
require("../common.php"); 
require_once('../config.php');

$sessionvalue = [
		"email" => $_POST['email'],
		"title" => $_POST['title'],
		"firstname" => $_POST['firstname'],
		"lastname" => $_POST['lastname'],
		"bio" => $_POST['bio'],
		"picurl" => $_POST['picurl'],
		"linkedinurl" => $_POST['linkedinurl'],
		"lmemberid" => $_POST['lmemberid'],
		"linkedinlogin" => "true"
		]; 

$_SESSION['user'] = $sessionvalue; 

/*

$query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :registeremail AND lmemberid IS NOT NULL
        "; 
         
        $query_params = array( 
            ':registeremail' => $_POST['email']
        ); 
         
        try 
        { 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            die("Failed to run query: " . $ex->getMessage()); 
        } 
         
        $row = $stmt->fetch(); 
         
        if($row) 
        { 
		echo 'This email address is already registered';
		//echo 'This email address is already registered';
        } 
        else{ 
		echo 'registering user';
	        
	        $query = " 
	            INSERT INTO users ( 
	                email,
	                firstname,
	                lastname,
	                password, 
	                salt,
	                lmemberid
	            ) VALUES ( 
	                :registeremail,
	                :registerfistname,
	                :registerlastname,
	                :registerpassword, 
	                :salt,
	                :registerlmemberid
	            ) "; 
	         
	       
	       

	        $query_params = array( 
	             ':registeremail' => $_POST['email'],
	             ':registerfistname' => $_POST['firstname'],
	             ':registerlastname' => $_POST['lastname'],
	             ':registerlmemberid' => $_POST['lmemberid'],
	             ':registerpassword' => "linkedinaccount", 
	             ':salt' => "linkedinaccount"
	        ); 
	         
	        try 
	        { 
	            // Execute the query to create the user 
	            $stmt = $db->prepare($query); 
	            $result = $stmt->execute($query_params);
	            
	        } 
	        catch(PDOException $ex) 
	        { 
	         
	            die("Failed to run query: " . $ex->getMessage()); 
	        } 
	         
	        //header("Location: login.php"); 
	         //echo"User Registered"; 
	      
	        //die("Redirecting to login.php"); 
        }



*/




?>