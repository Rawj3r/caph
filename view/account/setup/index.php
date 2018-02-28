<?php

	define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );
    require_once(PATH_ROOT.'/caphleave/utils/Utils.php');
    require_once PATH_ROOT.'/caphleave/controller/index.php';
    Utils::startSession();

    $controller = new Controller();


    if (isset($_POST['setup'])) {
    	$email = $_POST['email'];
    	$password = $_POST['password'];
    	$confirmpassword = $_POST['confirmpassword'];

    	if ($email != '' && $password != '' && $confirmpassword != '') {
    		 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo"
                <script type=\"text/javascript\">
                    alert(\"Invalid email, please check your email\");
                </script>";
            }else{
            	if ($password == $confirmpassword) {
            		$data = array('email' => $email, 'pass' => $password);
            		if ($controller->activateAccount($data)) {
            			header("Location: http://127.0.0.1:90/caphleave/view/auth/as-admin/");
            		}
            	}else{
            		  echo"
		                <script type=\"text/javascript\">
		                    alert(\"Failed, passwords do not match\");
		                </script>";
            	}
            }
    	}else{
    		  echo"
                <script type=\"text/javascript\">
                    alert(\"Please fill all fields.\");
                </script>";
    	}
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../favicon.ico">

    <title>Setup account</title>

    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../../assets/css/mdb.css" rel="stylesheet">
    <link href="../../assets/css/bootstrap-year-calendar.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../assets/fonts/flaticon/flaticon.css" rel="stylesheet">
    <link href="../../assets/css/app.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .row-centered{
            text-align: center;
          }
          .col-centered{
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
                <a class="navbar-brand" href="#"><img src="../../assets/brand/33-1.png" width="30"/></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href=""><img src="../../assets/brand/help.svg" width="20"></a>
                    </li>
                    
                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
    </nav>
    <div class="container">
            <div class="row row-centered">
              <div class="col-md-5 col-xs-12 col-centered">
		<center><h3>Continue your account setup</h3></center>
		<br>
		<br>
                  <form action="index.php" method="POST" name="setup">
                      <div class="form-group">
                          <label for="email-input">Email address</label>
                          <input type="email" name="email" class="form-control no-radius" id="email-input" placeholder="Email">
                      </div>
                      <div class="form-group">
                          <label for="password-input">Password</label>
                          <input type="password" name="password" class="form-control no-radius" id="email-input" placeholder="Password">
                      </div>
                      <div class="form-group">
                          <label for="password-input">Confirm Password</label>
                          <input type="password" name="confirmpassword" class="form-control no-radius" id="email-input" placeholder="Confirm password">
                      </div>
                      <!-- <button type="submit" class="btn btn-primary btn-block no-radius">Send me instructions</button> -->
                      <input type="submit" name="setup" value="Continue" class="btn btn-primary btn-block no-radius">
                  </form>
              </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Cap H &copy; <?php echo(date('Y')); ?></p>
        </div>
    </footer>
    <script src="../../assets/js/jquery.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
    <script src="../../assets/js/bootstrap.js"></script>
    <script src="../../assets/js/mdb.js"></script>
    <script src="../../assets/js/bootstrap-year-calendar.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>