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

    public static function sendMail(){
    	$to      = 'rogermphile1991@gmail.com';
		$subject = 'the subject';
		$message = 'hello';
		$headers = 'From: rogermkosi@outlook.com' . "\r\n" .
		    'Reply-To: rogermkosi@outlook.com' . "\r\n" .
		    'X-Mailer: PHP/' . phpversion();
		mail($to, $subject, $message, $headers);
    }

    public static function activateAccountemail($data){

    	// $mail_to = 'rogermphile1991@gmail.com';
    	$mail_to = $data['sendto'];
		$from_name = 'Cap H account activation';
		// $from_mail = $data['from'];
		$from_mail = 'no-reply@cap-h.co';
		$mail_subject = 'Cap H account actiation';

	    $encoding = "utf-8";
	    // Preferences for Subject field
	    $subject_preferences = array(
	        "input-charset" => $encoding,
	        "output-charset" => $encoding,
	        "line-length" => 76,
	        "line-break-chars" => "\r\n"
	    );

		    // Message
		$message = '
		<html>
		<head>
		  <title>Cap H account actiation</title>
		</head>
		<body>
		  <p>Your employee account on Cap H has been created, please click the <a href="http://127.0.0.1:90/caphleave/view/account/setup/">link</a> below to continue with your account set up.</p>
		</body>
		</html>
		';

		// Mail header
		$header = "Content-type: text/html; charset=".$encoding." \r\n";
		$header .= "From: ".$from_name." <".$from_mail."> \r\n";
		// $header .= "MIME-Version: 1.0 \r\n";
		// $header .= "Content-Transfer-Encoding: 8bit \r\n";
		// $header .= "Date: ".date("r (T)")." \r\n";
		// $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);

		// Send mail
		mail($mail_to, $mail_subject, $message, $header);
    }

}