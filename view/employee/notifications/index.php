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
    $getUserNotification = $controller->getUserNotifications($loggedInUserID);

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

  <title>Notifications</title>

  <link href="../../assets/css/bootstrap.css" rel="stylesheet">
  <link href="../../assets/css/mdb.css" rel="stylesheet">
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
          <li style="display:none">
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
  <div class="container">
     <?php
        while ($row = $getUserNotification->fetch(PDO::FETCH_ASSOC)){
              // print_r($row1);
      ?>
    <div class="row panel">
      <div class="col-xs-6 col-sm-3 ">
        <div class="row">
          <div class="col-sm-12">
            <div class="media">
              <a class="media-left waves-light avatar-listed">
                <img class="img-circle z-depth-3" src="../../assets/img/team-avatar-1.png" width="60" alt="">
              </a>
              <div class="media-body">
                <h4 class="media-heading"><?php echo($controller->getLoggedInUser($loggedInUserID)[0]['surname'].' '.$controller->getLoggedInUser($loggedInUserID)[0]['name']); ?></h4>
                <label class="text-muted"><small><?php echo $controller->getLoggedInUser($loggedInUserID)[0]['jobTitle']; ?></small></label>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-3 ">
        <div class="row">
          <div class="col-sm-3 col-xs-3">
            <?php
              $from = $row['StartDate'];
              $from = explode('-', $from);
              $dateObj   = DateTime::createFromFormat('!m', $from[1]);
              $monthName = $dateObj->format('M'); // March
            ?>
            <span><b><?php echo $monthName ?></b></span><br>
            <span><?php echo($from[2]) ?></span><br>
            <span><b><?php echo($from[0]) ?></b></span>
          </div>
          <div class="col-sm-6 col-xs-6">
            <center><img class="" src="../../assets/brand/next.svg" width="50" /><br>
              <label class="small"><?php echo Utils::getWorkingDays($row['StartDate'], $row['EndDate']);?> days <?php echo(Utils::getLeaveTypeNames($row['LeaveType'])); ?></label>
            </center>
          </div>
          <div class="col-sm-3 col-xs-3">
             <?php
              $from = $row['EndDate'];
              $from = explode('-', $from);
              $dateObj   = DateTime::createFromFormat('!m', $from[1]);
              $monthName = $dateObj->format('M'); // March
            ?>
            <span><b><?php echo $monthName ?></b></span><br>
            <span><?php echo($from[2]) ?></span><br>
            <span><b><?php echo($from[0]) ?></b></span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            <label class="small label label-success"><?php echo(Utils::leaveStatus($row['Approved'])); ?> </label>
          </div>
        </div>
      </div>
    </div>
     <?php } ?>
    
  </div>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Cap &copy; <?php echo(date('Y')); ?></p>
    </div>
  </footer>
  <!-- Leave Modal -->
  <div class="modal fade" id="book-time" tabindex="-1" role="dialog" aria-labelledby="timeLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="timeLabel">Ramsy Baltomore <small>(iOS developer)</small></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="row">
                <div class="col-md-4 col-xs-4"><label class="label-heading">
                <span class="flaticon-calendar"></span></label>
                </div>
                <div class="col-md-8 col-xs-8">
                  <label>Annual leave</label><br>
                  <label>Sick leave</label><br>
                  <label>Maternity leave</label><br>
                  <label>Family responsibility leave</label><br>
                  <label>Study leave</label><br>
                  <label>Leave for religious holidays</label><br>
                </div>
              </div>
              <hr/>
              <small><a href=""><span class="flaticon-garbage"></span> delete employee</a></small>
              <small><a href=""><span class="flaticon-edit-1"></span> edit details</a></small>
              <small><a href=""><span class="flaticon-calendar-1"></span> book leave</a></small>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default no-radius">close</button>
        </div>
      </div>
    </div>
  </div>
  <!--End-->
  <script src="../../assets/js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
  <script src="../../assets/js/bootstrap.js"></script>
  <script src="../../assets/js/mdb.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>