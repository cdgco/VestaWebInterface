<?php
require 'includes/config.php';
if(isset($_COOKIE['loggedin'])) { 
if(base64_decode($_COOKIE['loggedin']) == 'true') { header('Location: index.php'); }
}

// Setup API Call
$vst_command = 'v-check-user-password';

if(isset($_POST['username'])){

    if(isset($_POST['password'])){

      // Account
      $username2 = $_POST['username'];
      $password = $_POST['password'];

      // Prepare POST query
      $postvars = array(
          'user' => $vst_username,
          'password' => $vst_password,
          'cmd' => $vst_command,
          'arg1' => $username2,
          'arg2' => $password
      );
      $postdata = http_build_query($postvars);

      // Send POST query via cURL
      $postdata = http_build_query($postvars);
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $vst_url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
      $answer = curl_exec($curl);
    }      
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
<link rel="icon" type="image/ico" href="plugins/images/favicon.ico">
<title><?php echo $sitetitle; ?> - Login</title>
<!-- Bootstrap Core CSS -->
<link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="css/style.css" rel="stylesheet">
<style>
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus
input:-webkit-autofill, 
textarea:-webkit-autofill,
textarea:-webkit-autofill:hover
textarea:-webkit-autofill:focus,
select:-webkit-autofill,
select:-webkit-autofill:hover,
select:-webkit-autofill:focus {
  border: 1px solid #e4e7ea;
  -webkit-text-fill-color: #565656 !important;
  -webkit-box-shadow: 0 0 0px 1000px #ffffff inset;
  transition: background-color 5000s ease-in-out 0s;
}</style>
<!-- color CSS -->
<link href="css/colors/blue.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<![endif]-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.css" />
</head>
<body>
<?php

if($_GET['code'] != ''){
// Check result

$answer = $_GET['code'];

echo "<script> swal({title: '";
if($answer == 0) {
    echo "Account has been successfully created!', type: 'success'})</script>";
} if($answer == 1) {
    echo "Please fill out all sections of the form.', type: 'error'})</script>";
}
if($answer == 2) {
    echo "Invalid data entered in form. Please try again.', type: 'error'})</script>";
}
if($answer == 3) {
    echo "Server or form error (Code: 3). Please contact support.', type: 'error'})</script>";
}
if($answer == 4) {
    echo "Account already exists under same username.', type: 'error'})</script>";
}
if($answer == 12) {
    echo "System Error (Code: 12). Please contact support.', type: 'error'})</script>";
}
if($answer == 13) {
    echo "Server Error (Code: 13). Please contact support.', type: 'error'})</script>";
}
if($answer == 14) {
    echo "Server Error (Code: 14). Please contact support.', type: 'error'})</script>";
}
if($answer == 15) {
    echo "System Error (Code: 15). Please contact support.', type: 'error'})</script>";
}
if($answer == 16) {
    echo "Server Error (Code: 16). Please contact support.', type: 'error'})</script>";
}
if($answer == 17) {
    echo "Server Error (Code: 17). Please contact support.', type: 'error'})</script>";
}
if($answer == 18) {
    echo "Process Error (Code: 18). Please contact support.', type: 'error'})</script>";
}
if($answer == 19) {
    echo "Process Error (Code: 19). Please contact support.', type: 'error'})</script>";
}
if($answer == 20) {
    echo "Fatal Error (Code: 20). Please contact support.', type: 'error'})</script>";
}}
?>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="new-login-register">
      <div class="lg-info-panel">
              <div class="inner-panel">
<a href="javascript:void(0)" class="p-20 di"><img src="plugins/images/admin-logo.png" class="logo-1"></a>
                  <div class="lg-content">
                      <h2>CDG Host Control Panel <br></h2><p>Beta v2.0</p>
                     
                  </div>
              </div>
      </div>
      <div class="new-login-box">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Sign In to CDG Host CP</h3>
                    <small>Enter your details below</small>

                  <form class="form-horizontal new-lg-form" id="loginform" method="post" action="login.php">


                    <?php
if(isset($_POST['username'])){
    if(isset($_POST['password'])){

// Check result
if($answer == "OK") {
            $cookie1 = base64_encode ( 'true' );
            $cookie2 = base64_encode ( $username2 );
            setcookie('loggedin', $cookie1, time() + (86400 * 30), "/");
            setcookie('username', $cookie2, time() + (86400 * 30), "/");

ob_start();
    echo '<div style="color: #000;" class="alert alert-success alert-dismissable"><button type="button" style="color: #000;" class="close text-inverse" data-dismiss="alert" aria-hidden="true">×</button><span style="opacity: 0.7;">Loading Dashboard ...</span></div><script>setTimeout(function(){ window.location = "index.php";}, 1000);</script>';
} else {
    echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Error: Incorrect Login.</div>';
}}}

?>

                    <div class="form-group  m-t-20">
                      <div class="col-xs-12">
                        <label>Username</label>
                        <input class="form-control" name="username" type="text" required="" placeholder="Username">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>Password</label>
                        <input class="form-control" name="password" type="password" required="" placeholder="Password">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        
                        <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a> </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
                      </div>
                    </div>
<br>
                    <div class="form-group m-b-0">
                      <div class="col-sm-12 text-center">
                        <p>Don't have an account? <a href="register.php" class="text-primary m-l-5"><b>Sign Up</b></a></p>
                      </div>
                    </div>
                  </form>
                  <form class="form-horizontal" id="recoverform" method="post" action="https://host.cdgtech.one:8083/reset/reset.php">
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <h3>Recover Password</h3>
                        <p class="text-muted">Enter your Username and instructions will be sent to you! </p>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" name="user" type="text" required="" placeholder="Username">
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
