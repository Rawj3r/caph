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
		$mail_subject = 'Cap H account activation';

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

 	public static function notifyEmployee($data){
 		$employeeName = $data['employee'];
      	// $employerName = $data['employer'];
      	// $leaveContent = $data['content'];
      	$status = $data['status'];

    	// $mail_to = 'rogermphile1991@gmail.convm';
    	$mail_to = $data['sendto'];
		$from_name = 'Cap H leave management';
		// $from_mail = $data['from'];
		$from_mail = 'no-reply@cap-h.co';
		$mail_subject = 'Cap H leave management';

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
		  <title>Cap H leave management</title>
		</head>
		<body>
		  <p>Hi '.$employeeName.',</p>
		  <p>Your leave apprication has been '.$status.'.</p>
		  <p>Regards,</p>
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

      public static function notifyLeaveApplication($data){

      	$employeeName = $data['employee'];
      	$employerName = $data['employer'];
      	$leaveContent = $data['content'];

    	// $mail_to = 'rogermphile1991@gmail.com';
    	$mail_to = $data['sendto'];
		$from_name = 'Cap H account activation';
		// $from_mail = $data['from'];
		$from_mail = 'no-reply@cap-h.co';
		$mail_subject = 'Cap H account activation';

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
		  <title>Cap H leave management</title>
		</head>
		<body>
		  <p>$employeeName has applied for $leaveContent. Please click to <a href="https://uat.cap-h.co/view/auth/as-admin/">sign in</a> and view your notifications."</p>
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



function getWorkingDays($startDate, $endDate){
	$begin = strtotime($startDate);
	$end = strtotime($endDate);
	if ($begin > $end)
		{
		echo "startdateisinthefuture!";
		return false;
		}
	  else
		{
		$no_days = 0;
		$weekends = 0;
		while ($begin <= $end)
			{
			$no_days++; // no of days in the given interval
			$what_day = date("N", $begin);
			if ($what_day > 5)
				{ // 6 and 7 are weekend days
				$weekends++;
				};
			$begin+= 86400; // +1 day
			};
		$working_days = $no_days - $weekends;
		return $working_days;
		}
	}

	public static function getLeaveTypeNames($leave_ID){

		switch ($leave_ID) {
			case 1:
				return "Annual leave";
			break;

			case 2:
				return "Sick leave";
			break;

			case 3:
				return "Maternity leave";
			break;

			case 4:
				return "Family leave";
			break;

			case 5:
				return "Unpaid leave";
				# code...
			break;

			case 6:
				return "Study leave";
			break;	
			
			default:
				# code...
				break;
		}
	}

	public static function leaveStatus($status){
		switch ($status) {
			case 0:
				// pending
				return "Pending";
				break;
			case 1:
				// approved
				return "Approved";
				break;
			case 2:
				// rejected
				return "Declined";
				break;
			default:
				# code...
				break;
		}
	}

}