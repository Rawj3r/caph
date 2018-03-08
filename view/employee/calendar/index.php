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

    if (isset($_POST['boo_leave'])) {
      echo "string";
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

  <title>Calendar</title>

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
    <div class="row">
       <p class="text-right"><button class="btn btn-default" data-toggle="modal" ><a href="apply.php" style="color: #FFFFFF">+ Apply leave</a></button></p>
    </div>
    <div class="row panel">
      <div class="col-md-7 col-xs-4">
            <label class="label-heading">Calendar</label><br>
          </div>
      <div class="col-md-5 col-xs-8">
            <div class="btn-group pull-right">
              <button class="btn btn-warning" data-calendar-view="year">Year</button>
              <button class="btn btn-warning active" data-calendar-view="month">Month</button>
              <button class="btn btn-warning" data-calendar-view="week">Week</button>
              <button class="btn btn-warning" data-calendar-view="day">Day</button>
          </div>
      </div>
      <div class="col-md-12 col-sx-12">
        <div id="calendar"></div>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Cap &copy; <?php echo(date('Y')) ?></p>
    </div>
  </footer>
  <!-- Leave Modal -->
    <div class="modal fade" id="book-time" tabindex="-1" role="dialog" aria-labelledby="timeLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border-radius: 0px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="timeLabel">Apply leave</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form name="boo_leave" action="index.php" method="POST">
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
                                    <label for="reason-input" class="small-heading">Reason</label>
                                    <textarea class="md-textarea" name="reason" id="reason-input" placeholder=""></textarea>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" id="submit" value="apply leave" class="btn btn-default no-radius" />
                </div>
            </div>
        </div>
    </div>
    <!--End-->
    	<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
type: 'line',
data: {
labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
datasets: [{
label: 'Leave activity',
data: [12, 19, 3, 5, 2, 3, 0, 0, 0, 0, 0, 0],
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

// Get the modal
var modal = document.getElementById('book-time');

// Get the button that opens the modal
var btn = document.getElementById("submit");

// When the user clicks on <span> (x), close the modal
btn.onclick = function() {
   alert("sd");
}

</script>
  <script src="../../assets/js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
  <script src="../../assets/js/bootstrap.js"></script>
  <script src="../../assets/js/mdb.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>