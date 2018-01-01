<?php
require 'includes/config.php';

if($_GET['action'] == "code"){
$code = "block";
$confirm = "none";
}

if($_GET['action'] == "confirm"){
$code = "none";
$confirm = "block";
}
?>
<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
<title><?php echo $sitetitle; ?> - Recover</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="css/colors/<?php echo $themecolor; ?>" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<section style="display:<?php print_r($code); ?>" id="wrapper" class="login-register">
  <div class="login-box">
    <div class="white-box">
      <form class="form-horizontal form-material" autocomplete="off" id="loginform" action="https://host.cdgtech.one:8083/reset/reset.php">
        <h3 class="box-title m-b-20">Recover Password</h3>
        <div class="form-group ">
          <div class="col-xs-12">
            <input type="hidden" name="action" value="confirm">
            <input type="hidden" name="user" value="<?php print_r($_GET['user']); ?>">
            <input class="form-control" type="text" name="code" required="" placeholder="Reset Code">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<section style="display:<?php print_r($confirm); ?>" id="wrapper" class="login-register">
  <div class="login-box">
    <div class="white-box">
      <form class="form-horizontal form-material" autocomplete="off" id="loginform" action="https://host.cdgtech.one:8083/reset/reset1.php">
        <h3 class="box-title m-b-20">Confirm Password</h3>
        <div class="form-group ">
          <div class="col-xs-12">
            <input type="hidden" name="action" value="confirm">
            <input type="hidden" name="user" value="<?php print_r($_GET['user']); ?>">
            <input type="hidden" name="user" value="<?php print_r($_GET['code']); ?>">
            <input class="form-control" type="password" autocomplete="new-password" name="password" required="" placeholder="New Password">
            <input class="form-control" type="password" autocomplete="new-password" name="password_confirm" required="" placeholder="Confirm Password">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Confirm</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- jQuery -->
<script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="js/custom.min.js"></script>
<!--Style Switcher -->
<script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
