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

		}catch(PDOException $e){

		}catch(Exception $e){

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

	public function listEmployees(){

		try{
			$db = Utils::connect();
			$sql = $db->prepare("SELECT * FROM `caphusers`");
			$data = array();
			$sql->execute();
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
	    print_r($sql);
	    } catch (Exception $e) {
	    	print_r($e->getMessage());
	    }

	}

	public function getProvinces(){
		$data = array();
		$db = Utils::connect();
		$sql = $db->prepare("SELECT * FROM `provinces`");
		$sql->execute();
		while($result = $sql->fetch()){
			$data1['provinceId'] = $result['ProvinceId']; 
			$data1['Name'] = $result['Name'];
			array_push($data, $data1);
		}
		return $data;
	}

	public function addCompany(){

	}

	public function getCompany(){

	}

	public function getManangers($user_id){		

		$db = Utils::connect();
		$data = array();

		$companyId = $this->getLoggedInUser($user_id)[0]['companyId'];
		$sql = $db->prepare("SELECT * FROM `caphusers` WHERE `CompanyId` = ? AND `IsManager` = ?");
		$sql->execute(array($companyId, 2));
		while($result = $sql->fetch()){
			$data1['user_id'] = $result['user_id'];
			$data1['full_name'] = $result['Name']." ".$result['Surname'];
			array_push($data, $data1);
		}

		return $data;

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