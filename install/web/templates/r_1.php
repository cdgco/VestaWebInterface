<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/plugins/images/favicon.png">
<title>CDG Host - Reset Password</title>
<!-- Bootstrap Core CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/css/colors/default.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
  <div class="login-box">
    <div class="white-box">
      <form class="form-horizontal form-material" autocomplete="off" id="loginform" method="post" action="/reset/reset.php">
        <h3 class="box-title m-b-20">Recover Password</h3>
<div style="height:20px">***REMOVED*** if (isset($ERROR)) echo $ERROR ***REMOVED***</div>

        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" name="user" required="" placeholder="Username">
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

<!-- jQuery -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/js/custom.min.js"></script>
<!--Style Switcher -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
