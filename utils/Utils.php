<?php

require_once 'Constants.php';

class Utils{

	public static function connect(){
		return new PDO('mysql:dbname='.Constants::$db.';host='.Constants::$hostname.";port=".Constants::$port, Constants::$musername, Constants::$mpassword);/*Change The Credentials to connect to database.*/
	}

	public static function startSession(){
		// Start the session
		session_start();
	}

	public static function destroySession(){
		// remove all session variables
		session_unset(); 

		// destroy the session 
		session_destroy(); 
	}

	public static function disconnect(){

	}

	/* http://subinsb.com/php-generate-random-string */
	public static function rand_string($length) {
    	$str="";
      	$chars = "subinsblogabcdefghijklmanopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
      	$size = strlen($chars);
      	for($i = 0;$i < $length;$i++) {
       		$str .= $chars[rand(0,$size-1)];
    	}
      	return $str; 
    }

    public static function validatePhoneNumber($phoneNumber){

    	if(preg_match( "/^\+27[0-9]{9}$/", $phoneNumber)){
		  return true;
		} else {
		  return false;
		}

    } 
}