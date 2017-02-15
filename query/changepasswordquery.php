<?php
require_once('../config.php');
require("../common.php"); 



if(!empty($_POST))
    { 
        // This query retreives the user's information from the database using 
        // their username. 
        $query = " 
            SELECT 
                id,
                firstname,
                lastname, 
                email, 
                password, 
                salt 
            FROM users 
            WHERE 
                email = :email 
        "; 
         
        // The parameter values 
        $query_params = array( 
            ':email' => $_SESSION['user']['email']
        ); 
         
        try 
        { 
            // Execute the query against the database 
            $stmt = $db->prepare($query); 
            $result = $stmt->execute($query_params); 
        } 
        catch(PDOException $ex) 
        { 
            // Note: On a production website, you should not output $ex->getMessage(). 
            // It may provide an attacker with helpful information about your code.  
            //die("Failed to run query: " . $ex->getMessage()); 
		
		//echo '<script language="javascript">';
		//echo 'sweetAlert("Oops...", "Login Failed", "error")';
		//echo '</script>';
		//$message="Login Failed";
		echo 'Login Failed';
		
        } 
         
        // This variable tells us whether the user has successfully logged in or not. 
        // We initialize it to false, assuming they have not. 
        // If we determine that they have entered the right details, then we switch it to true. 
        $login_ok = false; 
         
        // Retrieve the user data from the database.  If $row is false, then the username 
        // they entered is not registered. 
        $row = $stmt->fetch(); 
        
        if(!$row){
        	//echo '<script language="javascript">';
		//echo 'sweetAlert("Oops...", "Email not found", "error")';
		//echo '</script>';
		//$message="Email not found";
		echo 'Email not found';
		
        } 
        else{ 
	           // if( $_POST['linkedinlogin']=="false"){
		            // Using the password submitted by the user and the salt stored in the database, 
		            // we now check to see whether the passwords match by hashing the submitted password 
		            // and comparing it to the hashed version already stored in the database. 
            $check_password = hash('sha256', $_POST['oldpassword'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']);
            } 
            
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
                
            }
	          
	        if($login_ok) 
	        { 
	            
	            
	            
	         		$query = " 
			            Update users set 
			                password=:newpassword
			                where email=:email
			        "; 
			         
			       
			        $salt = $row['salt']; 
			         
			      
			        $newpassword = hash('sha256', $_POST['newpassword'] . $salt); 
			     
			        for($round = 0; $round < 65536; $round++) 
			        { 
			            $newpassword = hash('sha256', $newpassword . $salt); 
			        } 
		
			        $query_params = array( 
			             ':email' =>  $_SESSION['user']['email'],
			            ':newpassword' => $newpassword		           
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

	            
	            echo 'Password changed';
	            //header("Location: ".$goto); 
	            //die("Redirecting to: ".$goto); 
	        } 
	        else 
	        { 
	            // Tell the user they fai// 
	            //print("Login Failed.");
			//echo '<script language="javascript">';
			//echo 'customalert()';
			//echo '</script>';
			echo "Incorrect password";
			//$message="Incorrect Password";
			 
	             
	            // Show them their username again so all they have to do is enter a new 
	            // password.  The use of htmlentities prevents XSS attacks.  You should 
	            // always use htmlentities on user submitted values before displaying them 
	            // to any users (including the user that submitted them).  For more information: 
	            // http://en.wikipedia.org/wiki/XSS_attack 
	            
	            
	            //$submitted_email = htmlentities($_POST['email'], ENT_QUOTES, 'UTF-8'); 
	        }
        } 
    }

?>