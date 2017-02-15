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
		echo 'Failed';
		
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

                $newpass= randString(7);
                
 	            
	            
	         		$query = " 
			            Update users set 
			                password=:newpassword
			                where email=:email
			        "; 
			         
			       
			        $salt = $row['salt']; 
			         
			      
			        $newpassword = hash('sha256', $newpass . $salt); 
			     
			        for($round = 0; $round < 65536; $round++) 
			        { 
			            $newpassword = hash('sha256', $newpassword . $salt); 
			        } 
		
			        $query_params = array( 
			             ':email' =>  $_POST['email'],
			            ':newpassword' => $newpassword		           
			        ); 
			         
			        try 
			        { 
			            // Execute the query to create the user 
			            $stmt = $db->prepare($query); 
			            $result = $stmt->execute($query_params);
			            sendEmail($newpass,$_POST['email']);
			            
			        } 
			        catch(PDOException $ex) 
			        { 
			            die("Failed to run query: " . $ex->getMessage()); 
			        } 

	            //header("Location: ".$goto); 
	            //die("Redirecting to: ".$goto); 
        	} 
    }
    
function randString($length)
{
    $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';	
    $str = '';
    $count = strlen($charset);
    while ($length--) {
        $str .= $charset[mt_rand(0, $count-1)];
    }
    return $str;
}

function sendEmail($passtosend,$to)
{
	$subject = "Cardstak-Password reset";
	$message = "Your temporary password is: ".$passtosend."\r\nPlease change password once you login.";
	$header = "From:admin@cardstak.com \r\n";
	$retval = mail ($to,$subject,$message,$header);
	if( $retval == true )  
	{
	echo "A temporary password has been sent to you email";
	}
	else
	{
	echo "Message could not be sent...";
	}
}


?>