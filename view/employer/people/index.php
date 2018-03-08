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
    $listEmployees = $controller->listEmployees($loggedInUserID);

    // while ($row1 = $listEmployees->fetch(PDO::FETCH_ASSOC)){
    //   print_r($row1);
    // }

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
  <link rel="icon" href="../../assets/brand/favicon.ico">

  <title>settings // Cap</title>

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
    <div class="row">
      <p class="text-right"><a href="../../employer/add/index.php" class="btn btn-default">+ add employee</a></p>
    </div>
    <div class="row panel hidden-sm-down">
      <div class="col-md-12 col-xs-12 table-responsive">
        <table class="table" width="100%">
          <thead class="thead-inverse">
            <tr>
              <td>Name</td>
              <td>Role</td>
              <td>Export</td>
              <td>Hire date</td>
              <td>Last modified</td>
            </tr>
          </thead>
          <tbody>
            <?php
            while ($row1 = $listEmployees->fetch(PDO::FETCH_ASSOC)){
              // print_r($row1);
            ?>
            <tr>
              <td width="30%">
                <div class="media">
                  <a class="media-left waves-light avatar-listed" data-toggle="modal" >
                    <img class="img-circle z-depth-3" src="../../assets/img/team-avatar-1.png" width="60" alt="">
                  </a>
                  <div class="media-body">
                    <h4 class="media-heading"><?php echo $row1['Name'].' '.$row1['Surname']; ?> </h4>
                    <label style="display: none;" class="text-muted"><small></small></label>
                  </div>
                </div>
              </td>
              <td width="20%">
                <br>
                <label class="small"><?php echo $row1['JobTitle']; ?></label>
              </td>
              <td width="20%">
                <br>
                <label class="small"><a href="export.php?user_id=<?php echo($row1['user_id']); ?>">Export</a></label>
              </td>
              <td width="10%">
                <br>
                <label class="small"><?php echo $row1['HireDate']; ?></label>
              </td>
              <td width="10%">
                <br>
                <label class="small"><?php echo $row1['LastModified']; ?></label>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <nav style="display: none;" aria-label="...">
        <ul class="pager">
          <li><a href="#">Previous</a></li>
          <li><a href="#">Next</a></li>
        </ul>
      </nav>
      </div>
    </div>
  </div>
  <footer class="footer">
    <div class="container">
      <p class="text-muted">Cap &copy; <?php echo(date('Y')); ?></p>
    </div>
  </footer>
  <!-- Leave Modal -->
  <div class="modal fade" id="book-time" tabindex="-1" role="dialog" aria-labelledby="timeLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="timeLabel">Ramsy Baltomore <small>(iOS developer)</small></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12 col-xs-12">
                  <ul class="list-group">
              <li class="list-group-item" style="border-top: 0;">
                <span class="badge">14</span>
                Annual leave
              </li>
              <li class="list-group-item">
                <span class="badge">14</span>
                Sick leave
              </li>
              <li class="list-group-item">
                <span class="badge">14</span>
                Maternity leave
              </li>
              <li class="list-group-item">
                <span class="badge">14</span>
                Family responsibility leave
              </li>
              <li class="list-group-item">
                <span class="badge">14</span>
                Study leave
              </li>
              <li class="list-group-item">
                <span class="badge">14</span>
                Leave for religious holidays
              </li>
            </ul>
                </div>
              </div>
              <hr/>
              <small><a href=""><span class="flaticon-garbage"></span> delete employee</a></small>
              <small><a href=""><span class="flaticon-edit-1"></span> edit details</a></small>
              <small><a href=""><span class="flaticon-calendar-1"></span> book time</a></small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default no-radius">close</button>
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
  </script>
  <script src="../../assets/js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
  <script src="../../assets/js/bootstrap.js"></script>
  <script src="../../assets/js/mdb.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>