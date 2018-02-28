<?php
    define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );
    require_once(PATH_ROOT.'/caphleave/utils/Utils.php');
    require_once PATH_ROOT.'/caphleave/controller/index.php';
    Utils::startSession();
    $controller = new Controller();

    if (!isset($_SESSION['user_id'])) {
        header("Location: http://127.0.0.1:90/caphleave/view/auth/as-admin/");  
    }

    $companyTypes = $controller->listCompanyTypes();
    $listNumberOfEmployees = $controller->listNumberOfEmployees();
    $getProvinces = $controller->getProvinces();

    if(isset($_POST['finish'])){
        
        $companyName = $_POST['companyName'];
        $companyType = $_POST['companyType'];
        $numOfEmployees = $_POST['numOfEmployees'];
        $address1 = $_POST['address1'];
        $address2 = $_POST['address2'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $email = $_POST['email'];
        $phone_number = $_POST['phone_number'];
        $contactUserId = $_SESSION['user_id'];
        $code = $_POST['code'];

        if ($companyName != '' && $companyType != '' && $numOfEmployees != '' && $address1 != '' && $address2 != '' && $city != '' && $province != '' && $email != '' && $phone_number != '' && $code != '' && $contactUserId != '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo"
                <script type=\"text/javascript\">
                    alert(\"Invalid email, please check your email\");
                </script>";
            }else{
                if (Utils::validatePhoneNumber($phone_number)) {
                    $data = array('Name' => $companyName, 'Address1' => $address1, 'Address2' => $address2, 'City' => $city, 'ProvinceId' => $province, 'PostalCode' => $code, 'CompanyType' => $companyType, 'ContactUserId' => $contactUserId, 'NumberOfEmployees' => $numOfEmployees, 'PostalCode' => $code, 'email' => $email, 'phone_number' => $phone_number);
                    if ($controller->addCompany($data)) {
                            header("Location: http://127.0.0.1:90/caphleave/view/auth/as-admin/index.php");
                    }else{
                        echo"
                            <script type=\"text/javascript\">
                                alert(\"Account creation failed, we could not finish creating your account please contact admin.\");
                            </script>";
                    }
                }else{
                    echo"
                <script type=\"text/javascript\">
                    alert(\"Invalid phone number.\");
                </script>";
                }
            }
        }else{
            echo "
            <script type=\"text/javascript\">
            alert(\"Please fill in all your company information.\");
            </script>
        ";
        }

    }

    // print_r($companyTypes);
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

	<title>Company Information</title>

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
				<h3 class="large-heading">Tell us about your company</h3>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <form action="index.php" name="finish" method="POST">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="small-heading primary-1">1. COMPANY INFORMATION</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="company-name-input" class="small-heading">What is your company name</label>
                                        <input type="text" name="companyName" class="form-control no-radius" id="company-name-input" placeholder="xyz holdings">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="second-name-input" class="small-heading">Company type</label>
                                        <select name="companyType" class="form-control select">
                                        <option>Please select</option>
                                            <?php
                                                while ($row = $companyTypes->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<option value='".$row['companyTypeID']."'>".$row['title']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="numOfEmployees" class="small-heading">Num of employees</label>
                                        <select name="numOfEmployees" class="form-control select">
                                        <option>Please select</option>
                                            <?php
                                                while ($row1 = $listNumberOfEmployees->fetch(PDO::FETCH_ASSOC)) {
                                                    echo "<option value='".$row1['ID']."'>".$row1['title']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="small-heading primary-1">2. ADDRESS</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address-input" class="small-heading">Address</label>
                                        <input type="text" name="address1" class="form-control no-radius" id="address-input" placeholder="Address 1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" name="address2" class="form-control no-radius" id="address-input" placeholder="Address 2">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city-input" class="small-heading">City</label>
                                        <input type="text" name="city" class="form-control no-radius" id="city-input" placeholder="Central Park">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="second-name-input" class="small-heading">Province</label>
                                        <select name="province" class="form-control select">
                                                <option>Please select one</option>
                                                <?php
                                                    while ($row2 = $getProvinces->fetch(PDO::FETCH_ASSOC)) {
                                                        echo "<option value='".$row2['ProvinceId']."'>".$row2['Name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="code-input" class="small-heading">Postal Code</label>
                                        <input type="text" name="code" class="form-control no-radius" id="code-input" placeholder="0001">
                                    </div>                                    
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="small-heading primary-1">3. CONTACT INFORMATION</h3>
                                    <hr>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email-input" class="small-heading">Email address</label>
                                        <input type="email" name="email" class="form-control no-radius" id="email-input" placeholder="johndoe@example.com">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-input" class="small-heading">Phone number</label>
                                        <input type="text" name="phone_number" class="form-control no-radius" id="phone-input" placeholder="+27 ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                    </div>
                                </div>
                            </div>
                            <input type="submit" name="finish" value="Finish" href="" class="btn btn-primary btn-block no-radius"></a>
                        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<footer class="footer">
		<div class="container">
			<p class="text-muted">Cap &copy; <?php echo date('Y') ?></p>
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