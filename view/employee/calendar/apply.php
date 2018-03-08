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

    $companyID = $controller->getLoggedInUser($loggedInUserID)[0]['companyId'];
    $managerID = $controller->getLoggedInUser($loggedInUserID)[0]['managerId'];

    // print_r($companyID);

    if (isset($_POST['boo_leave'])) {
      $leave_type = $_POST['leave_type']; 
      $from_date = $_POST['from_date'];
      $to_date = $_POST['to_date'];
      $additional = $_POST['reason'];

      $employeeName = $controller->getLoggedInUser($loggedInUserID)[0]['name'] .' '.$controller->getLoggedInUser($loggedInUserID)[0]['surname'];
      $employerName = $controller->getLoggedInUser($managerID)[0]['name'] .' '.$controller->getLoggedInUser($managerID)[0]['surname'];
      $employerEmail = $controller->getLoggedInUser($managerID)[0]['email'];
      $content = Utils::getWorkingDays($from_date, $to_date).' days '.Utils::getLeaveTypeNames($leave_type);

      $mail = array('employee' => $employeeName, 'employer' => $employerName, 'content' => $content, 'sendto' => $employerEmail);

      if ($leave_type != '' && $from_date != '' && $to_date != '' ) {
        $data = array('leaveType' => $leave_type, 'startDate' => $from_date, 'endDate' => $to_date, 'managerId' => $managerID, 'companyId' => $companyID, 'reason' => $additional, 'employeeID' => $loggedInUserID);
        if ($controller->applyLeave($data)) {
          Utils::notifyLeaveApplication($mail);          
          echo "
            <script type=\"text/javascript\">
            if(confirm(\"Your leave application has been sent for approval.\")){
              window.location.href=\"http://127.0.0.1:90/caphleave/view/employee/notifications/index.php\";



            }
            </script>
        ";
  
        }
      }else{
        echo "
            <script type=\"text/javascript\">
            alert(\"Please fill in all fields.\");
            return false;
            </script>
        ";
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
  <link rel="icon" href="../../favicon.ico">

  <title>Apply leave</title>

  <link href="../../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../../assets/css/mdb.css" rel="stylesheet">
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../../assets/fonts/flaticon/flaticon.css" rel="stylesheet">
  <link href="../../assets/css/app.css" rel="stylesheet">
	<script src="../../assets/js/Chart.bundle.js"></script>

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
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
          <li><a href="../../employee/dashboard/index.php">Dashboard</a></li>
          <li><a href="../../employee/calendar/index.php">Calendar</a></li>
          <li><a href="../../employee/notifications/index.php">Notifications</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="../notifications/"><img src="../../assets/brand/bell.svg" width="20"></a>
          </li>
          <li style="display: none;">
            <a href=""><img src="../../assets/brand/help.svg" width="20"></a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo($controller->getLoggedInUser($loggedInUserID)[0]['surname'].' '.$controller->getLoggedInUser($loggedInUserID)[0]['name']); ?><span class="caret"></span></a>
               <ul class="dropdown-menu">
              <li class="dropdown-header">Profile</li>
              <li><a href="../../employee/profile/index.php">View profile</a></li>
              <li style="display: none;"><a  href="#">Edit profile</a></li>
              <li style="display: none;"><a href="../../employee/timeline/index.html">View timeline</a></li>
              <li style="display: none;" role="separator" class="divider"></li>
              <li style="display: none;" class="dropdown-header">Settings</li>
              <li style="display: none;"><a href="../settings/">Edit information</a></li>
              <li style="display: none;"><a href="#">Preferences</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="../../auth/as-employee/">Sign out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <!-- Leave Modal -->
      <div class="container">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 0px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><a href="index.php">&times;</a></span></button>
                    <h4 class="modal-title" id="timeLabel">Apply leave</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form name="boo_leave" action="apply.php" method="POST">
                                <div class="form-group">
                                    <label for="leave-type-input" class="small-heading">On</label>
                                    <select name="leave_type" class="form-control select" id="leave-type-input">
                                        <option>Select leave type</option>
                                        <option value="1">Annual leave</option>
                                        <option value="2">Sick leave</option>
                                        <option value="3">Maternity leave</option>
                                        <option value="4">Family responsibility leave</option>
                                        <option value="6">Study leave</option>
                                        <option value="5">Leave for religious holidays</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="from-input" class="small-heading">From</label>
                                            <input type="date" name="from_date" class="form-control no-radius" id="from-input">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to-input" class="small-heading">To</label>
                                            <input type="date" name="to_date" class="form-control no-radius" id="to-input">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="reason-input" class="small-heading">Additional information(optional)</label>
                                    <textarea class="md-textarea" name="reason" id="reason-input" placeholder=""></textarea>
                                </div>

                                <div class="form-group">
                                  <input type="submit" name="boo_leave" value="apply leave" class="btn btn-default no-radius" />
                                </div>

                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>