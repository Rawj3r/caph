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
    $numOfManagers = $controller->countManagers($loggedInUserID);
    $numOfEmpoyees =  $controller->countEmployees($loggedInUserID);

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

  <title>dashboard // Cap</title>

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
          <li><a href="../../employer/dashboard/index.php">Dashboard</a></li>
          <li><a href="../../employer/calendar/index.php">Calendar</a></li>
          <li><a href="../../employer/people/index.php">People</a></li>
          <li><a href="../../employer/notifications/index.php">Notifications</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li>
            <a href="../notifications/"><img src="../../assets/brand/bell.svg" width="20"></a>
          </li>
          <li>
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
    <div class="row panel">
      <div class="col-md-12 col-xs-12">
        <div class="row">
          <div class="col-md-3 col-xs-3"><a href="../../employer/people/index.php"><center><h2><?php echo $numOfEmpoyees; ?></h2><span>employees</span><br><img src="../../assets/brand/group.svg" width="20" alt="group" /></center><a/></div>
          <div class="col-md-3 col-xs-3"><a href="#"><center><h2><?php echo $numOfManagers ?></h2><span>managers</span><br><img src="../../assets/brand/user-1.svg" width="20" alt="group" /></center></a></div>
          <div class="col-md-3 col-xs-3"><a href="#"><center><h2>0</h2><span>teams</span><br><img src="../../assets/brand/group.svg" width="20" alt="group" /></center></a></div>
          <div class="col-md-3 col-xs-3"><a href="../../employer/calendar/index.php"><center><h2>0</h2><span>total days left</span><br><img src="../../assets/brand/calendar.svg" width="20" alt="group" /></center></a></div>
        </div>
      </div>
    </div>
    <div class="row panel">
      <div class="col-md-12 col-xs-12">
        <div class="row">
          <div class="col-md-8 col-xs-12"><canvas id="myChart" width="100%" height="30px"></canvas></div>
          <div class="col-md-4 col-xs-12">
            <label>summary</label>
            <ul class="list-group">
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Annual leave</small>
              </li>
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Sick leave</small>
              </li>
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Maternity leave</small>
              </li>
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Family responsibility leave</small>
              </li>
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Study leave</small>
              </li>
              <li class="list-group-item">
                <span class="badge">0</span>
                <small>Leave for religious holidays</small>
              </li>
            </ul>
          </div>
          </div>
      </div>
    </div>
    <div class="row" style="display: none;">
      <div class="col-md-6 col-xs-12">
        <h3 class="large-heading">timeline</h3>
        <div class="row panel">
          <div class="col-md-2 col-xs-2"><h4>Today</h4></div>
          <div class="col-md-10 col-xs-10 timeline">
            <label class="label-heading">On Sick leave</label><br>
            <label class="small col-neu-2">Some notes about this leave</label><br>
            <a href=""><span class="flaticon-calendar flush-left"></span> view in the calendar</a>
          </div>
        </div>
        <div class="row panel">
          <div class="col-md-2 col-xs-2"><h4>13 Jan</h4></div>
          <div class="col-md-10 col-xs-10 timeline">
            <label class="label-heading">On Sick leave</label><br>
            <label class="small col-neu-2">Some notes about this leave</label><br>
            <a href=""><span class="flaticon-calendar flush-left"></span> view in the calendar</a>
          </div>
        </div>
        <div class="row panel">
          <div class="col-md-2 col-xs-2"><h4>13 Jan</h4></div>
          <div class="col-md-10 col-xs-10 timeline">
            <label class="label-heading">On Sick leave</label><br>
            <label class="small col-neu-2">Some notes about this leave</label><br>
            <a href=""><span class="flaticon-calendar flush-left"></span> view in the calendar</a>
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
  <!--File Browser -->
  <div class="modal fade" id="file-browser" tabindex="-1" role="dialog" aria-labelledby="file-browserLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="file-browserLabel"><b>Profile Picture</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <span class="btn btn-file">upload<input type="file"></span>
            </div>
            <div class="col-md-6">
              <label>drag files here</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default no-radius">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!--End File Browser -->

  <!-- Edit Information -->
  <div class="modal fade" id="edit-information" tabindex="-1" role="dialog" aria-labelledby="edit-informationLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="edit-informationLabel"><b>Edit</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <span class="btn btn-file">upload<input type="file"></span>
            </div>
            <div class="col-md-6">
              <label>drag files here</label>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!--End Edit Information -->
  <script>
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
    label: 'Leave activity',
    data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0],
    backgroundColor: [
    'rgba(255, 99, 132, 0.2)',
    'rgba(54, 162, 235, 0.2)',
    'rgba(255, 206, 86, 0.2)',
    'rgba(75, 192, 192, 0.2)',
    'rgba(153, 102, 255, 0.2)',
    'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
    'rgba(255,99,132,1)',
    'rgba(54, 162, 235, 1)',
    'rgba(255, 206, 86, 1)',
    'rgba(75, 192, 192, 1)',
    'rgba(153, 102, 255, 1)',
    'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
    }]
    }
    });

    var ctx = document.getElementById("doughnutChart").getContext('2d');
    Chart.defaults.global.legend.display = false;
    var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
    labels: ["a", "b", "c", "d", "e", "f"],
    datasets: [{
    backgroundColor: [
    "#BA68C8",
    "#C6FF00",
    "#FF5722",
    "#7E57C2",
    "#FFEE58",
    "#40C4FF"
    ],
    data: [12, 19, 3, 17, 28, 7]
    }]
    },options: {
    cutoutPercentage: 60,
    }

    });
  </script>
  <script src="../../assets/js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
  <script src="../../assets/js/bootstrap.js"></script>
  <script src="../../assets/js/mdb.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>