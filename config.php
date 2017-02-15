<?php
/**
 * Database config variables
 */
define("DB_HOST", "localhost");
define("DB_USER", "cardslju_mozadeh");
define("DB_PASSWORD", "ghasem641");
define("DB_DATABASE", "cardslju_cards");

/*
 * Google Cloud Messaging API Key
 
//define("GOOGLE_API_KEY", "AIzaSyDeCWf_LJ7w3ZgsVfDwOt5V2MT_13Oc_sU"); // Place your Google API Key

*/

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'); 
	
try 
{ 

$db = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE.";charset=utf8", DB_USER, DB_PASSWORD, $options); 
} 
catch(PDOException $ex) 
{ 

die("Failed to connect to the database: " . $ex->getMessage()); 
} 

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); 
                         

?>