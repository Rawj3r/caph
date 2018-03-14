<?php

  	define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );
  	require_once(PATH_ROOT.'/caphleave/utils/Utils.php');
  	require_once PATH_ROOT.'/caphleave/controller/index.php';
	Utils::startSession();
  	$controller = new Controller();

  	if(isset($_POST['register'])){

  		$first_name = $_POST['first_name'];
  		$last_name = $_POST['last_name'];
  		$email = $_POST['email'];
  		$password = $_POST['password'];
  		$confirmpassword = $_POST['confirmpassword'];
  		$phone_number = $_POST['phone_number'];

  		$data = array('first_name' => $first_name, 'last_name' => $last_name, 'email' => $email,'cell' => $phone_number, 'pass' => $password, 'isManager' => '1', 'HireDate' => '0000-00-00', 'CompanyId' => null, 'IdNumber' => null, 'Address1' => null, 'City' =>null, 'ProvinceId' => null, 'PostalCode' => null, 'HomeNumber' => null, 'DateOfBirth' => null, 'ManagerId' => null, 'JobTitle' => null,);

  		if ($first_name != '' || $last_name != '' || $email != '' || $password != '' || $confirmpassword != '' || $phone_number != '') {
  			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	        	echo"
	            <script type=\"text/javascript\">
	            	alert(\"Invalid email, please check your email\");
	            </script>";
      		}else{
      			if ($password == $confirmpassword) {

      			if (Utils::validatePhoneNumber($phone_number)) {
      				if (!$controller->isUserExist($data['email'])) {
						if ($controller->register($data)) {
							header("Location: http://127.0.0.1:90/caphleave/view/auth/as-admin/company-info/");
						}else{
							echo"
			            <script type=\"text/javascript\">
			            	alert(\"Account creation failed, please try again.\");
			            </script>";
						}
						// $controller->addEmployee($data);
					}else{
						echo"
			            <script type=\"text/javascript\">
			            	alert(\"Email already exists, please try to recover your account.\");
			            </script>";
					}
      			}else{
      				echo"
		            <script type=\"text/javascript\">
		            	alert(\"Invalid phone number, please check your phone number\");
		            </script>";
      			}
      		}else{
      			 echo"
		                <script type=\"text/javascript\">
		                    alert(\"Failed, passwords do not match\");
		                </script>";
      		}
      		}
  		}else{
  			echo "
            <script type=\"text/javascript\">
            	alert(\"Please fill in all input fields.\");
            </script>";
  		}

  	}

?>

<!DOCTYPE html>
<html lang="en" style="background: #fff;">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="../../../assets/brand/favicon.ico">

	<title>Sign Up</title>

	<link href="../../../assets/css/bootstrap.css" rel="stylesheet">
	<link href="../../../assets/css/mdb.css" rel="stylesheet">
	<link href="../../assets/css/bootstrap-year-calendar.css" rel="stylesheet">
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="../../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="../../../assets/fonts/flaticon/flaticon.css" rel="stylesheet">
	<link href="../../../assets/css/app.css" rel="stylesheet">

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
	<style>
		.row-centered {
			text-align: center;
		}
		
		.col-centered {
			display: inline-block;
			float: none;
			text-align: left;
			margin-right: -4px;
		}
	</style>
</head>

<body style="background: #fff;">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
					aria-controls="navbar">
<span class="sr-only">Toggle navigation</span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
<span class="icon-bar"></span>
</button>
				<a class="navbar-brand" href="#"><img src="../../../assets/brand/33-1.png" width="30"/></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href=""><img src="../../../assets/brand/help.svg" width="20"></a>
					</li>

				</ul>
			</div>
			<!--/.nav-collapse -->
		</div>
	</nav>
	<div class="container" style="background: #fff;">
		<div class="row row-centered">
			<div class="col-md-5 col-xs-12 col-centered">
				<center>
					<h3>Create an account</h3>
				</center>
				<div class="row">
					<div class="col-md-12 col-xs-12">
						<form action="index.php" name="register" method="POST">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="first-name-input">First name</label>
										<input type="text" class="form-control no-radius" id="first-name-input" name="first_name" placeholder="John">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="second-name-input">Last name</label>
										<input type="text" name="last_name" class="form-control no-radius" id="second-name-input" placeholder="Doe">
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="email-input">Email address</label>
								<input type="email" class="form-control no-radius" id="email-input" name="email" placeholder="johndoe@example.com">
							</div>
							<div class="form-group">
								<label for="password-input">Password</label>
								<input type="password" name="password" class="form-control no-radius" id="password-input">
								<small style="font-size: small;">6-character minimum</small>
							</div>
							<div class="form-group">
								<label for="re-password-input">Confirm password</label>
								<input type="password" name="confirmpassword" class="form-control no-radius" id="re-password-input">
							</div>
							<div class="form-group">
								<label for="phone-input">Phone number</label>
								<input type="text" class="form-control no-radius" id="phone-input" name="phone_number" placeholder="+27 ">
							</div>
							<br>
							<center><label class="label-heading">Clicking <b>Create account</b> means that you agree to the <a href="../../agreement.html">Cap-H Services Agreement</a> and <a href="../../policy.html">privacy and cookies statement</a>.</label></center>
							<br>
							<!--button type="submit" class="btn btn-primary btn-block no-radius">Create account</button
                            <a href="../company-info/index.html" class="btn btn-primary btn-block no-radius">Create account</a>-->
                            <input type="submit" class="btn btn-primary btn-block" name="register" value="Create account" >
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted">Cap &copy; <?php echo(date('Y')) ?></p>
		</div>
	</footer>
	<script src="../../../assets/js/jquery.js"></script>
	<script>window.jQuery || document.write('<script src="../../../assets/js/jquery.js"><\/script>')</script>
	<script src="../../../assets/js/bootstrap.js"></script>
	<script src="../../../assets/js/mdb.js"></script>
	<script src="../../../assets/js/bootstrap-year-calendar.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="../../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>