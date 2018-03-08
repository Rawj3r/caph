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

  <title>Profile</title>

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
          <li><a href="../../employer/dashboard/index.php">Dashboard</a></li>
          <li><a href="../../employer/calendar/index.php">Calendar</a></li>
          <li><a href="../../employer/notifications/index.php">Notifications</a></li>
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
    <!--Cover-->
    <div class="row">
      <div class="col-md-12 profile-cover">
        <div class="row ">
          <div class="col-xs-4 col-sm-2">
            <p class="text-right">
              <br/>
            </p>
            <center><a href="" data-toggle="modal" data-target="#file-browser"><img class="img-circle z-depth-3" src="../../assets/img/team-avatar-1.png" width="80" alt="profile" /></a></center>
          </div>
          <div class="col-xs-8 col-sm-10">
            <p class="text-right"><a href="" data-toggle="modal" data-target="#edit-information"><i class="flaticon-edit"></i></a></p>
            <h3><?php echo($controller->getLoggedInUser($loggedInUserID)[0]['surname'].' '.$controller->getLoggedInUser($loggedInUserID)[0]['name']); ?></h3>
            <h6><?php echo($controller->getLoggedInUser($loggedInUserID)[0]['jobTitle']); ?></h6>
            <label><i class="flaticon-placeholder-2 flush-left"></i> <?php echo($controller->getLoggedInUser($loggedInUserID)[0]['city']); ?></label>
          </div>
        </div>
        <p class="text-right">
          <a href="" data-toggle="modal" data-target="#file-browser"><i class="flaticon-photo-camera-1"></i></a>
        </p>
      </div>
    </div>
    <!--End Cover-->
    <div class="row panel">
      <div class="col-md-6 col-xs-12">
        <div class="row">
          <div class="col-md-2 col-xs-2"><label class="label-heading"><span class="flaticon-briefcase"></span></label></div>
          <div class="col-md-10 col-xs-10">
            <label class="label-heading"> Experience</label><br>
            <label class="small col-neu-2">State experience from jobs, internships and etc</label><br>
            <a href="" data-toggle="modal" data-target="#add-work-experience"><label class="small"> add work experience</label></a>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-xs-12">
        <div class="row">
          <div class="col-md-2 col-xs-2"><label class="label-heading"><span class="flaticon-agenda"></span></label></div>
          <div class="col-md-10 col-xs-10">
            <label class="label-heading"> Education</label><br>
            <label class="small col-neu-2">List your qualifications</label><br>
            <a href="" data-toggle="modal" data-target="#add-education"><label class="small"> add a qualification</label></a>
          </div>
        </div>
      </div>
    </div>
    <div class="row panel">
      <div class="col-md-12 col-xs-12">
        <h3 class="medium-heading">Introduction</h3>
        <div class="col-md-11 co-xs-11">
          <label class="small">I currently work for toybox ux as a chief get shxt done.</label>
        </div>
        <div class="col-md-1 co-xs-1">
          <a href="" href="" data-toggle="modal" data-target="#edit-add-introduction"><label class="small"><span class="flaticon-edit"></span></label></a>
        </div>
      </div>
    </div>
    <div class="row panel">
      <div class="col-md-12 col-xs-12">
        <h3 class="medium-heading">Skills</h3>
        <center><a href="" data-toggle="modal" data-target="#add-proven-skills"><label class="small">add your proven skills</label></a></center>
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
          <h4 class="modal-title small-heading" id="file-browserLabel"><b>Profile picture</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <span class="btn btn-info btn-file">upload<input type="file"></span>
            </div>
            <div class="col-md-6">
              <label class="text-muted">display image here</label>
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
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="edit-informationLabel"><b>Edit</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <form action="" method="">
                <div class="form-group">
                    <label for="second-name-input" class="small-heading">Your names</label>
                    <input type="text" class="form-control no-radius" id="name-input" value="Thabang Mangope">
                </div>
                <div class="form-group">
                    <label for="second-name-input" class="small-heading">Your location</label>
                    <input type="text" class="form-control no-radius" id="location-input" value="Pretoria, South Africa">
                </div>
              </form>
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
  <!-- Work Experience Modal -->
  <div class="modal fade" id="add-work-experience" tabindex="-1" role="dialog" aria-labelledby="experienceLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="experienceLabel"><b>Work experience</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form>
                <div class="form-group">
                  <label for="position-input" class="small-heading">Position</label>
                  <input type="text" class="form-control no-radius" id="position-input">
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="graduation-input" class="small-heading">Year (from)</label>
                      <input type="date" class="form-control no-radius" id="year-from-input">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="graduation-input" class="small-heading">Year (to)</label>
                      <input type="date" class="form-control no-radius" id="year-to-input">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="graduation-input" class="small-heading">Description</label>
                  <textarea type="text" id="position-description-input" class="md-textarea"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->
  <!-- Education Modal -->
  <div class="modal fade" id="add-education" tabindex="-1" role="dialog" aria-labelledby="educationLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="educationLabel"><b>Education</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form>
                <div class="form-group">
                  <label for="college-name-input" class="small-heading">College name</label>
                  <input type="text" class="form-control no-radius" id="college-name-input">
                </div>
                <div class="form-group">
                  <label for="qualification-input" class="small-heading">Qualification</label>
                  <select class="form-control select" id="qualification-input">
                                            <option>Degree</option>
                                            <option>Masters</option>
                                        </select>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="graduation-input" class="small-heading">Year</label>
                      <input type="date" class="form-control no-radius" id="graduation-input">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="qualification-input" class="small-heading">Description</label>
                  <textarea type="text" id="qualification-input" class="md-textarea"></textarea>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->
  <!-- Introduction Modal -->
  <div class="modal fade" id="edit-add-introduction" tabindex="-1" role="dialog" aria-labelledby="introductionLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="introductionLabel"><b>Introduction</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form>
                <div class="form-group">
                  <div class="form-group">
              <label for="reason-input" class="small-heading">Summary</label>
                <textarea type="text" id="reason-input" class="md-textarea"></textarea>
            </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->
  <!-- Skills Modal -->
  <div class="modal fade" id="add-proven-skills" tabindex="-1" role="dialog" aria-labelledby="skillsLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content" style="border-radius: 0px;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title small-heading" id="skillsLabel"><b>Proven skills</b></h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <form>
              <div class="form-group">
              <label for="skills-input" class="small-heading">Skills</label>
                <textarea type="text" id="skills-input" class="md-textarea"></textarea>
            </div>
              </form>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default">Save Changes</button>
        </div>
      </div>
    </div>
  </div>
  <!-- End -->
  <script src="../../assets/js/jquery.js"></script>
  <script>window.jQuery || document.write('<script src="../../assets/js/jquery.js"><\/script>')</script>
  <script src="../../assets/js/bootstrap.js"></script>
  <script src="../../assets/js/mdb.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../../assets/js/src/ie10-viewport-bug-workaround.js"></script>
</body>

</html>