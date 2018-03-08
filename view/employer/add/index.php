<?php
    define("PATH_ROOT", realpath($_SERVER["DOCUMENT_ROOT"]) );
    require_once(PATH_ROOT.'/caphleave/utils/Utils.php');
    require_once PATH_ROOT.'/caphleave/controller/index.php';
    Utils::startSession();

    if (!isset($_SESSION['user_id'])) {
      header("Location: http://127.0.0.1:90/caphleave/view/auth/as-admin/");  
    }

    $loggedInUserID = $_SESSION['user_id'];

    $controller = new Controller();
    $getProvinces = $controller->getProvinces();
    $getManangers = $controller->getManangers($loggedInUserID);
    $companyID = $controller->getCompanyID($loggedInUserID);

    if (isset($_POST['add'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $identitynumber = $_POST['identitynumber'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $province = $_POST['province'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $ismanager = $_POST['ismanager'];
        $manager = $_POST['manager'];
        $cell = $_POST['cell'];
        $tel = $_POST['tel'];
        $jobtitle = $_POST['jobtitle'];
        $date_hired = $_POST['date_hired'];
        $code = $_POST['code'];

        if ($firstname != '' && $lastname != '' && $identitynumber != '' && $address != '' && $city != '' && $province != '' && $email != '' && $dob != '' && $ismanager != '' && $manager != '' && $cell != '' && $jobtitle != '' && $date_hired != '' && $code != '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo"
                <script type=\"text/javascript\">
                    alert(\"Invalid email, please check email\");
                </script>";
            }else{
                if (Utils::validatePhoneNumber($cell)) {

                    $data = array('first_name' => $firstname, 'last_name' => $lastname, 'email' => $email, 'isManager' => $ismanager, 'HireDate' => $date_hired, 'CompanyId' => $companyID, 'IdNumber' => $identitynumber, 'Address1' => $address, 'City' => $city, 'ProvinceId' => $province, 'PostalCode' => $code, 'HomeNumber' => $tel, 'DateOfBirth' => $dob, 'ManagerId' => $manager, 'JobTitle' => $jobtitle, 'cell' => $cell);

                    print_r($data);
                    if ($controller->addEmployee($data)) {
                        // header("Location: http://127.0.0.1:90/caphleave/view/employer/people/index.php");  
                    }else{
                        echo"
                <script type=\"text/javascript\">
                    alert(\"Failed, could not add employee.\");
                </script>";
                    }

                }else{
                     echo"
                <script type=\"text/javascript\">
                    alert(\"Invalid cellphone number.\");
                </script>";
                }
            }
        }else{
            echo "
            <script type=\"text/javascript\">
            alert(\"Please fill in all employee information.\");
            </script>
        ";
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
    <link rel="icon" href="../../favicon.ico">

    <title>Hello Cap-H</title>

    <link href="../../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../../assets/css/mdb.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-year-calendar.css" rel="stylesheet">
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
        <ul class="nav navbar-nav">
          <li><a href="../../employer/dashboard/index.php">Dashboard</a></li>
          <li><a href="../../employer/calendar/index.php">Calendar</a></li>
          <li><a href="../../employer/people/index.php">People</a></li>
          <li><a href="../../employer/notifications/index.php">Notifications</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="../notifications/"><img src="../../assets/brand/bell.svg" width="20"></a>
          </li>
          <li style="display: none;">
            <a href="../../employer/settings/index.html"><img src="../../assets/brand/help.svg" width="20"></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($controller->getLoggedInUser($loggedInUserID)[0]['surname'].' '.$controller->getLoggedInUser($loggedInUserID)[0]['name']); ?><span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header">Profile</li>
              <li><a href="../../employer/profile/index.php">View profile</a></li>
              <li style="display: none;"><a  href="#">Edit profile</a></li>
              <li style="display: none;"><a href="../../employer/timeline/index.html">View timeline</a></li>
              <li style="display: none;" role="separator" class="divider"></li>
              <li style="display: none;" class="dropdown-header">Settings</li>
              <li style="display: none;"><a href="../settings/">Edit information</a></li>
              <li style="display: none;"><a href="#">Preferences</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="../../auth/as-employer/">Sign out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <div class="container">
            <div class="row row-centered">
              <div class="col-md-5 col-xs-12 col-centered">
<h3 class="large-heading">Employee Intake Form</h3>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <form action="index.php" method="POST" name="add">
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="small-heading primary-1">1. PERSONAL INFORMATION</h3>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="first-name-input" class="small-heading">First name</label>
                                        <input type="text" name="firstname" class="form-control no-radius" id="first-name-input" placeholder="John">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="second-name-input" class="small-heading">Last name</label>
                                        <input type="text" name="lastname" class="form-control no-radius" id="second-name-input" placeholder="Doe">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="identity-input" class="small-heading">SA Identity number</label>
                                        <input type="text" name="identitynumber" class="form-control no-radius" id="identity-input" placeholder="">
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="identity-input" class="small-heading">Job title</label>
                                        <input type="text" name="jobtitle" class="form-control no-radius" id="identity-input" placeholder="Developer">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone-input" class="small-heading">Date hired</label>
                                                <input type="date" name="date_hired" class="form-control no-radius" id="phone-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <div style="display: none;" class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone-input" class="small-heading">Birth date</label>
                                                <input type="date" name="dob" class="form-control no-radius" id="phone-input">
                                            </div>
                                        </div>
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
                                        <input type="text" name="address" class="form-control no-radius" id="address-input" placeholder="123 xyz Street">
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
                                        <select name="province" name="province" class="form-control select">
                                                <option>Please select one</option>
                                                <?php
                                                    while ($row2 = $getProvinces->fetch(PDO::FETCH_ASSOC)) {
                                                        echo "<option value='".$row2['ProvinceId']."'>".$row2['Name']."</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="address-input" class="small-heading">Zip code</label>
                                        <input type="text" name="code" class="form-control no-radius" id="address-input" placeholder="0001">
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
                                        <label for="phone-input" class="small-heading">Phone number (Home)</label>
                                        <input type="text" name="tel" class="form-control no-radius" id="phone-input" placeholder="+27 ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-input" class="small-heading">Phone number (Mobile)</label>
                                        <input type="text" name="cell" class="form-control no-radius" id="phone-input" placeholder="+27721234567">
                                    </div>
                                </div>
                                <div " class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phone-input" class="small-heading">Birth date</label>
                                                <input type="date" name="dob" class="form-control no-radius" id="phone-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <h3 class="small-heading primary-1">4. MANAGER</h3>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <label class="small-heading">Is manager</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">

                                                <label for="is-manager-input" class="small-heading control control--radio">No
                                                        <input type="radio" value="3" name="ismanager" id="is-manager-input" name="radio"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="is-not-manager-input" class="small-heading control control--radio">Yes
                                                        <input type="radio" value="2" name="ismanager" id="is-not-manager-input" name="radio"/>
                                                        <div class="control__indicator"></div>
                                                    </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone-input" class="small-heading">Is managed by</label>
                                        <select name="manager" class="form-control select">
                                                <option>Assign a manager</option>
                                                 <?php
                                                    while ($row = $getManangers->fetch(PDO::FETCH_ASSOC)) {
                                                        echo "<option value='".$row['user_id']."'>".$row['Name'].' '.$row['Surname']."</option>";
                                                    }
                                                ?>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>
                            <!-- <a href="../../employer/people/index.html" class="btn btn-primary btn-block no-radius">Create employee</a> -->
                            <input type="submit" value="Create employee" name="add" class="btn btn-primary btn-block no-radius"/>
                        </form>
              </div>
            </div>
        </div>
    </div>
    </div>
    <footer class="footer">
        <div class="container">
            <p class="text-muted">Cap &copy; <?php echo(date('Y')); ?></p>
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