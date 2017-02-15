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
            $check_password = hash('sha256', $_POST['password'] . $row['salt']); 
            for($round = 0; $round < 65536; $round++) 
            { 
                $check_password = hash('sha256', $check_password . $row['salt']);
            } 
            
            if($check_password === $row['password']) 
            { 
                // If they do, then we flip this to true 
                $login_ok = true; 
                
            }
	           /* }
		   elseif ( $_POST['linkedinlogin']=="true"){
	            		$login_ok = true; 
	            }   */       
	         
	         
	        // If the user logged in successfully, then we send them to the private members-only page 
	        // Otherwise, we display a login failed message and show the login form again 
	        if($login_ok) 
	        { 
	            // Here I am preparing to store the $row array into the $_SESSION by 
	            // removing the salt and password values from it.  Although $_SESSION is 
	            // stored on the server-side, there is no reason to store sensitive values 
	            // in it unless you have to.  Thus, it is best practice to remove these 
	            // sensitive values first. 
	            unset($row['salt']); 
	            unset($row['password']); 
	             
	            // This stores the user's data into the session at the index 'user'. 
	            // We will check this index on the private members-only page to determine whether 
	            // or not the user is logged in.  We can also use it to retrieve 
	            // the user's details.
			 //if( $_POST['linkedinlogin']=="false"){
	 	$sessionvalue = [
		"email" => $row['email'],
		"firstname" => $row['firstname'],
		"lastname" => $row['lastname'],
		"nmemberid" => $row['id'],
		"linkedinlogin" => "false"
		];
			 /*}
			 else{
				$sessionvalue = [
				"email" => $_POST['email'],
				"title" => $_POST['title'],
				"firstname" => $_POST['firstname'],
				"lastname" => $_POST['lastname'],
				"bio" => $_POST['bio'],
				"picurl" => $_POST['picurl'],
				"linkedinurl" => $_POST['linkedinurl'],
				"lmemberid" => $_POST['memberid'],
				"linkedinlogin" => "true"
				]; 
			 }*/
			
			
			
	         $_SESSION['user'] = $sessionvalue; 
	             
	            // Redirect the user to the private members-only page. 
	            
	            
	            echo 'Login successful';
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