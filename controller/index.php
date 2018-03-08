<?php
// define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );

require_once(PATH_ROOT.'/caphleave/utils/Constants.php');
require_once(PATH_ROOT.'/caphleave/utils/Utils.php');

/**
* 
*/
class Controller
{
	
	function __construct()
	{
		# code...
	}

	public function register($data){

		try{

			$db = Utils::connect();
	     	$p_salt = Utils::rand_string(20);
	     	$site_salt="subinsblogsalt"; /*Common Salt used for password storing on site.*/
	    	$salted_hash = hash('sha256', $data['pass'].$site_salt.$p_salt);
	    	$first_name = $data['first_name'];
	    	$last_name = $data['last_name'];
	    	$email = $data['email'];
	    	$cell = $data['cell'];
	    	$isManager = $data["isManager"];

	    	$sql = $db->prepare("INSERT INTO `caphusers` (`user_id`, `Name`, `Surname`, `Email`, `PhoneNumber`, `PasswordHash`, `SecurityStamp`, `IsManager`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);");
	    	$sql->execute(array($first_name, $last_name, $email, $cell, $salted_hash, $p_salt, $isManager));

	    	if ($db->lastInsertId() > 0) {
	    		$_SESSION['user_id'] = $db->lastInsertId();
	    		return true;
	    	}else{
				return false;
	    	}

		}catch(PDOException $e){
			return false;
		}catch(Exception $e){
			return false;
		}
	}

	public function isUserExist($data){

		$db = Utils::connect();
		$email = $data;

		$sql = $db->prepare("SELECT COUNT(*) FROM `caphusers` WHERE `Email` = ?");
		$sql->execute(array($email));

		if($sql->fetchColumn()!=0){
			return true;
    	}else{
    		return false;
    	}

	}

	public function login($data){
		try{
			$db = Utils::connect();
			$email = $data['email'];
			$password = $data['pass'];
			$p = '';
			$p_salt = '';
			$id = 0;

			$sql=$db->prepare("SELECT user_id, PasswordHash, SecurityStamp FROM caphusers WHERE Email = ? ");
			$sql->execute(array($email));
			while($result = $sql->fetch()){
				$p = $result['PasswordHash'];
				$p_salt = $result['SecurityStamp'];
				$id = $result['user_id'];
			}

			$site_salt="subinsblogsalt";/*Common Salt used for password storing on site. You can't change it. If you want to change it, change it when you register a user.*/
			$salted_hash = hash('sha256',$password.$site_salt.$p_salt);


			if($p==$salted_hash){
				$_SESSION['user_id'] = $id;
			 	return true;	
			 }else{
			  return false;
			}
		}catch(PDOException $e){
			return false;
		}catch(Exception $e){
			return false;
		}

	}

	public function respondLeaveApplication($data){
		$db = Utils::connect();
		try {
			$sql = $db->prepare("UPDATE `leaveapplications` SET `Approved` = ?, `ApproverUserId` = ? WHERE `leaveapplications`.`LeaveApplicationId` = ?;");
			$sql->execute(array($data['approved'], $data['approverID'], $data['leaveID']));
			header("Location: http://127.0.0.1:90/caphleave/view/employer/notifications/index.php");  
		} catch (Exception $e) {
			
		}

	}

	public function isAdmin($user_id){
		$db = Utils::connect();
		$data = array();
		$sql = $db->prepare("SELECT `IsManager` FROM `caphusers` WHERE `user_id` = ?");
		$sql->execute(array($user_id));
		while ($result = $sql->fetch()) {
			$isAdmin["isManager"] = $result['IsManager']; 
		}

		return $isAdmin["isManager"] == "2";
	}

	public function isManager($user_id){
		$db = Utils::connect();
		$data = array();
		$sql = $db->prepare("SELECT `IsManager` FROM `caphusers` WHERE `user_id` = ?");
		$sql->execute(array($user_id));
		while ($result = $sql->fetch()) {
			$isAdmin["isManager"] = $result['IsManager']; 
		}

		return $isAdmin["isManager"] == "1";
	}

	public function isEmployee($user_id){
		$db = Utils::connect();
		$data = array();
		$sql = $db->prepare("SELECT `IsManager` FROM `caphusers` WHERE `user_id` = ?");
		$sql->execute(array($user_id));
		while ($result = $sql->fetch()) {
			$isAdmin["isManager"] = $result['IsManager']; 
		}

		if ($isAdmin["isManager"] == "3") {
			return true;
		}else{
			return false;
		}
	}

	public function listEmployees($user_id){

		$companyID = '';

		if($this->getLoggedInUser($user_id)[0]['isManager'] == 1){
			$companyID = $this->getCompanyID($user_id);			
		}elseif ($this->getLoggedInUser($user_id)[0]['isManager'] == 2) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}

		try{
			$db = Utils::connect();
			$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `CompanyId` = ?");
			$data = array();
			$sql->execute(array($companyID));
			// while($result = $sql->fetch()){
			// 	$data1['user_id'] = $result['user_id'];
			// 	$data1['name'] = $result['Name'];
			// 	$data1['surname'] = $result['Surname'];
			// 	$data1['profilePicUrl'] = $result['ProfilePicUrl'];
			// 	$data1['email'] = $result['Email'];
			// 	$data1['phoneNumber'] = $result['PhoneNumber'];
			// 	$data1['hireDate'] = $result['HireDate'];
			// 	$data1['lastModified'] = $result['LastModified'];
			// 	$data1['companyId'] = $result['CompanyId'];
			// 	$data1['idNumber'] = $result['IdNumber'];
			// 	$data1['address1'] = $result['Address1'];
			// 	$data1['city'] = $result['City'];
			// 	$data1['provinceId'] = $result['ProvinceId'];
			// 	$data1['postalCode'] = $result['PostalCode'];
			// 	$data1['homeNumber'] = $result['HomeNumber'];
			// 	$data1['dateOfBirth'] = $result['DateOfBirth'];
			// 	$data1['isManager'] = $result['IsManager'];
			// 	$data1['managerId'] = $result['ManagerId'];
			// 	$data1['jobTitle'] = $result['JobTitle'];
			// 	array_push($data, $data1);
			// }
			return $sql;

		}catch(Exception $e){

		}

	}



	public function addEmployee($data){
		$first_name = $data['first_name'];
	    $last_name = $data['last_name'];
	    $email = $data['email'];
	    $cell = $data['cell'];
	    $isManager = $data['isManager'];
	    $hireDate = $data['HireDate'];	
	    $companyID = $data['CompanyId'];
	    $idNumber = $data['IdNumber'];
	    $address = $data['Address1'];
	    $city = $data['City'];
	    $provinceId = $data['ProvinceId'];
	    $postalCode = $data['PostalCode'];
	    $homeNumber = $data['HomeNumber'];
	    $dateOfBirth = $data['DateOfBirth'];
	    $managerId = $data['ManagerId'];
	    $jobTitle = $data['JobTitle'];

	    try {
	    	$db = Utils::connect();
	    $sql = $db->prepare("INSERT INTO `caphusers` (`user_id`, `Name`, `Surname`, `Email`, `PhoneNumber`, `HireDate`, `CompanyId`, `IdNumber`, `Address1`, `City`, `ProvinceId`, `PostalCode`, `HomeNumber`, `DateOfBirth`, `IsManager`, `ManagerId`, `JobTitle`) VALUES(NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
	    $sql->execute(array($first_name, $last_name, $email, $cell, $hireDate, $companyID, $idNumber, $address, $city, $provinceId, $postalCode, $homeNumber, $dateOfBirth, $isManager, $managerId, $jobTitle));

	    $mail = array('sendto' => $email);
	    // Utils::activateAccountemail($mail);
	    return true;
	    } catch (Exception $e) {
	    	print_r($e->getMessage());
	    	return false;
	    }

	}

	public function getProvinces(){
		$data = array();
		$db = Utils::connect();
		$sql = $db->prepare("SELECT * FROM `provinces`");
		$sql->execute();
		// while($result = $sql->fetch()){
		// 	$data1['provinceId'] = $result['ProvinceId']; 
		// 	$data1['Name'] = $result['Name'];
		// 	array_push($data, $data1);
		// }
		return $sql;
	}

	public function activateAccount($data){
		$active = '';
		$user_id = '';

		try {
		$db = Utils::connect();
		$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `Email` = ? ");
		$sql->execute(array($data['email']));
		$number_of_rows = $sql->fetchColumn();

			if ($number_of_rows > 0) {

				$db = Utils::connect();
				$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `Email` = ? ");
				$sql->execute(array($data['email']));

				while ($result = $sql->fetch()) {
					echo "string";
					$active = $result['activated'];
					$user_id = $result['user_id'];
					print_r($result);
				}

				$db = Utils::connect();
				$p_salt = Utils::rand_string(20);
		     	$site_salt = "subinsblogsalt"; /*Common Salt used for password storing on site.*/
		    	$salted_hash = hash('sha256', $data['pass'].$site_salt.$p_salt);

				$update = $db->prepare("UPDATE `caphusers` SET `PasswordHash` = ?, `SecurityStamp` = ?, `LastModified` = NOW(), `activated` = ? WHERE `caphusers`.`user_id` = ?;");
				$update->execute(array($salted_hash, $p_salt, 1, $user_id));
				return true;
			}else{
				return false;
			}	
		}catch(Exception $e){
			print_r($e->getMessage());
			return false;
		}
	}

	public function listCompanyTypes(){
		$data = array();
		$db = Utils::connect();
		$sql = $db->prepare("SELECT * FROM `companytypes`");
		$sql->execute();
		// while(){
		// 	$data1['companyTypeID'] = $result['companyTypeID']; 
		// 	$data1['title'] = $result['title'];
		// 	array_push($data, $data1);
		// }
		return $sql;
	}

	public function listNumberOfEmployees(){
		$data = array();
		$db = Utils::connect();
		$sql = $db->prepare("SELECT * FROM `numberOfEmployees`");
		$sql->execute();
		// while(){
		// 	$data1['companyTypeID'] = $result['companyTypeID']; 
		// 	$data1['title'] = $result['title'];
		// 	array_push($data, $data1);
		// }
		return $sql;
	}

	public function addCompany($data){

		$companyName = $data['Name'];
		$address1 = $data['Address1'];
		$address2 = $data['Address2'];
		$city = $data['City'];
		$provinceId = $data['ProvinceId'];
		$postalCode = $data['PostalCode'];
		$companyType = $data['CompanyType'];
		$contactUserId = $data['ContactUserId'];
		$numberOfEmployees = $data['NumberOfEmployees'];
		$email = $data['email'];
		$phone_number = $data['phone_number'];

		try {
			$db = Utils::connect();
			$sql = $db->prepare("INSERT INTO `companies` (`CompanyId`, `Name`, `Address1`, `Address2`, `City`, `ProvinceId`, `PostalCode`, `CompanyType`, `NumberOfEmployees`, `ContactUserId`, `email`, `cellphone`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
			$sql->execute(array($companyName, $address1, $address2, $city, $provinceId, $postalCode, $companyType, $numberOfEmployees, $contactUserId, $email, $phone_number));
			return true;
		} catch (Exception $e) {
			print_r($e->getMessage());
			return false;
		}catch (PDOException $e) {
		    echo 'Connection failed: ' . $e->getMessage();
			return false;

		}

	}

	//after we add a company, we have to return the company ID, and then update the User 
	// data with the new companyID
	public function updateAdminCompanyID(){

	}

	public function applyLeave($data){
		// $data = array();

		$leaveType = $data['leaveType'];
		$startDate = $data['startDate'];
		$endDate = $data['endDate'];
		$managerId = $data['managerId'];
		$companyId = $data['companyId']; 
		$reason = $data['reason'];
		$employeeID = $data['employeeID'];

		try {
			$db = Utils::connect();

			$sql = $db->prepare("INSERT INTO `leaveapplications` (`LeaveApplicationId`, `LeaveId`, `EmployeeId`, `StartDate`, `EndDate`, `Reason`, `LeaveType`, `Approved`, `managerID`, `DisapprovalReason`, `CompanyId`, `ApproverName`, `ApproverUserId`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, NULL, ?, NULL, NULL);");
			$sql->execute(array($leaveType, $employeeID, $startDate, $endDate, $reason, $leaveType, '', $managerId, $companyId));
			return true;
		} catch (Exception $e) {
			return false;
		}	
		return true;

	}

	public function getCompanyID($user_id){
		$db = Utils::connect();
		$data = array();
		$companyId = '';

		$sql = $db->prepare("SELECT CompanyId FROM `companies` WHERE `ContactUserId` = ?"); 
		$sql->execute(array($user_id));
		while ($result = $sql->fetch()) {
			$companyId = $result['CompanyId'];
		}

		return $companyId;
	}

	public function countManagers($user_id){
		$companyID = '';

		if($this->getLoggedInUser($user_id)[0]['isManager'] == 1){
			$companyID = $this->getCompanyID($user_id);			
		}elseif ($this->getLoggedInUser($user_id)[0]['isManager'] == 2) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}

		// print_r($companyId);		
		$db = Utils::connect();
		$sql = $db->prepare("SELECT COUNT(*) FROM `caphusers` WHERE `IsManager` = ? AND `CompanyId` = ?");
		$sql->execute(array(2, $companyID));
		$number_of_rows = $sql->fetchColumn();
		return $number_of_rows;
	}

	public function countEmployees($user_id){

			$companyID = '';

		if($this->getLoggedInUser($user_id)[0]['isManager'] == 1){
			$companyID = $this->getCompanyID($user_id);			
		}elseif ($this->getLoggedInUser($user_id)[0]['isManager'] == 2) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}

		// $companyId = $this->getCompanyID($user_id);	

		$db = Utils::connect();
		$sql = $db->prepare("SELECT COUNT(*) FROM `caphusers` WHERE `IsManager` = ? AND `CompanyId` = ?");
		$sql->execute(array(3, $companyID));
		$number_of_rows = $sql->fetchColumn();
		return $number_of_rows;
	}

	public function getManangers($user_id){		

		$companyID = '';
		if($this->getLoggedInUser($user_id)[0]['isManager'] == 1){
			$companyID = $this->getCompanyID($user_id);			
		}elseif ($this->getLoggedInUser($user_id)[0]['isManager'] == 2) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}

		$db = Utils::connect();
		$data = array();
		// $companyId = $this->getCompanyID($user_id);

		// $companyId = $this->getLoggedInUser($user_id)[0]['companyId'];
		$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `CompanyId` = ? AND `IsManager` = ?");
		$sql->execute(array($companyID, 2));
		// while($result = $sql->fetch()){
		// 	$data1['user_id'] = $result['user_id'];
		// 	$data1['full_name'] = $result['Name']." ".$result['Surname'];
		// 	array_push($data, $data1);
		// }

		return $sql;

	}

	public function getUserNotifications($user_id){
		$companyID = '';
		if($this->getLoggedInUser($user_id)[0]['isManager'] == 1){
			$companyID = $this->getCompanyID($user_id);			
		}elseif ($this->getLoggedInUser($user_id)[0]['isManager'] == 2) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}else if ($this->getLoggedInUser($user_id)[0]['isManager'] == 3) {
			$companyID = $this->getLoggedInUser($user_id)[0]['companyId'];
		}

		try {
			$db = Utils::connect();
			$sql = $db->prepare("SELECT * FROM `leaveapplications` WHERE `EmployeeId` = ? AND `CompanyId` = ?");
			$sql->execute(array($user_id, $companyID));
			return $sql;
		} catch (Exception $e) {
			echo($e->getMessage());
			return false;
		}
	}

	public function getManagerNotifications($user_id){

		try {
			$db = Utils::connect();
			$sql = $db->prepare("SELECT * FROM `leaveapplications` WHERE managerID = ? AND Approved = ?");
			$sql->execute(array($user_id, 0));
			return $sql;
		} catch (Exception $e) {
			echo($e->getMessage());
			return false;
		}

	}

	public function pendingRequest($data){

		$user_id = $data['user_id'];
		$approved = $data['approved'];

		try {

			$db = Utils::connect();
			$sql = $db->prepare("SELECT COUNT(*) FROM `leaveapplications` WHERE `managerID` = ? AND `Approved` = ? ;");
			$sql->execute(array($user_id, $approved));
			$number_of_rows = $sql->fetchColumn();
			print_r($number_of_rows);
			return $number_of_rows;

		} catch (Exception $e) {
			die($e->getMessage());
		}

	}

	public function getLoggedInUser($user_id){

		try{
			$db = Utils::connect();
			$data = array();
			$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `user_id` = ?");
			$sql->execute(array($user_id));
			while($result = $sql->fetch()){
				$data1['user_id'] = $result['user_id'];
				$data1['name'] = $result['Name'];
				$data1['surname'] = $result['Surname'];
				$data1['profilePicUrl'] = $result['ProfilePicUrl'];
				$data1['email'] = $result['Email'];
				$data1['phoneNumber'] = $result['PhoneNumber'];
				$data1['hireDate'] = $result['HireDate'];
				$data1['lastModified'] = $result['LastModified'];
				$data1['companyId'] = $result['CompanyId'];
				$data1['idNumber'] = $result['IdNumber'];
				$data1['address1'] = $result['Address1'];
				$data1['city'] = $result['City'];
				$data1['provinceId'] = $result['ProvinceId'];
				$data1['postalCode'] = $result['PostalCode'];
				$data1['homeNumber'] = $result['HomeNumber'];
				$data1['dateOfBirth'] = $result['DateOfBirth'];
				$data1['isManager'] = $result['IsManager'];
				$data1['managerId'] = $result['ManagerId'];
				$data1['jobTitle'] = $result['JobTitle'];
				array_push($data, $data1);
			}
			return $data;

		}catch(PDOException $e){

		}
	}

}