<?php
require_once('../config.php');
require("../common.php"); 
if(!filter_var($_POST['registeremail'], FILTER_VALIDATE_EMAIL)) 
{ 
		//echo '<script language="javascript">';
		//echo 'alert("Invalid E-Mail Address")';
		//echo '</script>';
		echo 'Invalid E-Mail Address';
		
} 

else{
        $query = " 
            SELECT 
                1 
            FROM users 
            WHERE 
                email = :registeremail 
        "; 
         
        $query_params = array( 
            ':registeremail' => $_POST['registeremail'] 
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
		//echo '<script language="javascript">';
		//echo 'alert("This email address is already registered")';
		//echo '</script>';
		echo 'This email address is already registered';
        } 
        else{ 
	       
	        
	        $query = " 
	            INSERT INTO users ( 
	                email,
	                firstname,
	                lastname,  
	                password, 
	                salt,
	                firsttime 
	            ) VALUES ( 
	                :registeremail,
	                :registerfistname,
	                :registerlastname,
	                :registerpassword, 
	                :salt,
	                'yes' 
	            ) 
	        "; 
	         
	       
	        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647)); 
	         
	      
	        $registerpassword = hash('sha256', $_POST['registerpassword'] . $salt); 
	     
	        for($round = 0; $round < 65536; $round++) 
	        { 
	            $registerpassword = hash('sha256', $registerpassword . $salt); 
	        } 

	        $query_params = array( 
	             ':registeremail' => $_POST['registeremail'],
	             ':registerfistname' => $_POST['registerfirstname'],
	             ':registerlastname' => $_POST['registerlastname'],
	            ':registerpassword' => $registerpassword, 
	            ':salt' => $salt
	           
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
	         echo"User Registered"; 
	      
	        //die("Redirecting to login.php"); 
        }
    } 

?>