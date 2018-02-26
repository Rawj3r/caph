<?php
define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );

// require_once 'controller/index.php';
require_once(PATH_ROOT.'/caphleave/controller/index.php');


$controller = new Controller();

$data = array('first_name' => 'Mane', 'last_name' => 'Nkosi', 'email' => 'emp@gmail.com',
'cell' => '012355656', 'pass' => '1234', 'isManager' => '3', 'HireDate' => '2017-05-01', 'CompanyId' => 1, 'IdNumber' => 9454544566, 'Address1' => "15 Maskhane diskfreespace", 'City' => "popularised", 'ProvinceId' => 3, 'PostalCode' => 45, 'HomeNumber' => 5496264, 'DateOfBirth' => '1991-05-45', 'ManagerId' => '2', 'JobTitle' => 'Stripper',);

if (!$controller->isUserExist($data['email'])) {
	// $controller->register($data);
	$controller->addEmployee($data);

}else{
	// $controller->login($data);
	// $controller->getProvinces();
	// $controller->getLoggedInUser(4);
	// $controller->getManangers(4);
	// echo(json_encode($controller->listEmployees()));
	print_r($controller->isEmployee(3));
}

