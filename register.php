***REMOVED***

session_start();

if (file_exists( 'includes/config.php' )) { require( 'includes/config.php'); ***REMOVED***  else { header( 'Location: install' );***REMOVED***;
if(isset($_SESSION['loggedin'])) {
    if(base64_decode($_SESSION['loggedin']) == 'true') { header('Location: index.php'); ***REMOVED***
***REMOVED***

    $postvars0 = array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json');

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
    $serverconnection = array_values(json_decode(curl_exec($curl0), true))[0]['OS'];

    setlocale(LC_CTYPE, $locale);
    setlocale(LC_MESSAGES, $locale);
    bindtextdomain('messages', 'locale');
    textdomain('messages');

***REMOVED***

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
        <title>***REMOVED*** echo $sitetitle; ***REMOVED*** - ***REMOVED*** echo _('Register'); ***REMOVED***</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="bootstrap/dist/css/bootstrap-select.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        ***REMOVED*** if(isset(GOOGLE_ANALYTICS_ID)){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);***REMOVED*** gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; ***REMOVED***
        <style>
            html {
                overflow-y: scroll;
            ***REMOVED***
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
            ***REMOVED***
        </style>
        <!-- color CSS -->
        <link href="css/colors/***REMOVED*** if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); ***REMOVED*** else {echo $themecolor; ***REMOVED*** ***REMOVED***" id="theme" rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel bg-theme">
                <div class="inner-panel">
                    <a href="javascript:void(0)" class="p-20 di"><img src="plugins/images/admin-logo.png" class="logo-1"></a>
                    <div class="lg-content">
                        <h2>***REMOVED*** echo $sitetitle; ***REMOVED*** ***REMOVED*** echo _('Control Panel'); ***REMOVED*** <br></h2><p>***REMOVED*** require 'includes/versioncheck.php'; ***REMOVED***</p> </div>
                </div>
            </div>

            <div class="new-login-box" style="position:relative;top:-10%">
                <div class="white-box">
                    <h3 class="box-title m-b-0">***REMOVED*** echo _('Sign up for'); ***REMOVED*** ***REMOVED*** echo $sitetitle; ***REMOVED***</h3> <small>***REMOVED*** echo _('Enter your details below'); ***REMOVED***</small>
                    <form class="form-horizontal new-lg-form" method="post" id="loginform" action="process/process.php">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" style="width:49%; float:left;" required="" name="fname" required x-autocompletetype="given-name" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,27***REMOVED***$" placeholder="***REMOVED*** echo _('First Name'); ***REMOVED***" title="***REMOVED*** echo _('2 to 28 Letters Only. Apostrophes and hyphens allowed.'); ***REMOVED***" autocomplete="on"> 
                                <input class="form-control" type="text" style="width:49%; float:right;" required="" name="lname" required x-autocompletetype="family-name" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,27***REMOVED***$" placeholder="***REMOVED*** echo _('Last Name'); ***REMOVED***" title="***REMOVED*** echo _('2 to 28 Letters Only. Apostrophes and hyphens allowed.'); ***REMOVED***" autocomplete="on"></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="email" x-autocompletetype="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,20***REMOVED***$" title="***REMOVED*** echo _('Invalid Email Address'); ***REMOVED***" autocomplete="on" required="" placeholder="***REMOVED*** echo _('Email'); ***REMOVED***"> </div>
                        </div>   
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required autocomplete="on" pattern="^[a-zA-Z][a-zA-Z0-9-_.]{1,27***REMOVED***$" title="***REMOVED*** echo _('2 to 28 Characters A-Z, 0-9, \'-\' \'.\' and \'_\' Only.'); ***REMOVED***" placeholder="***REMOVED*** echo _('Username'); ***REMOVED***" /> </div>
                        </div>       
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" title="***REMOVED*** echo _('Minimum 6 Characters: One uppercade letter, lowercase letter and number reuired.'); ***REMOVED***" id="pass" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,***REMOVED***$" autocomplete="new-password" required="" placeholder="***REMOVED*** echo _('Password'); ***REMOVED***" style="width:49%; float:left;">

                                <input class="form-control" type="password" id="cpass" autocomplete="new-password" required="" placeholder="***REMOVED*** echo _('Confirm Pass'); ***REMOVED***" style="width:49%; float:right;"></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <select class="selectpicker m-b-20 m-r-10" name="plan" data-style="btn btn-info bg-theme" style="border:none;">
                                    <option value="default" data-tokens="default">***REMOVED*** echo _('Default'); ***REMOVED***</option>
                                </select>
                            </div></div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button disabled class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light bg-theme" style="border:none;" type="submit">***REMOVED*** echo _('Sign Up'); ***REMOVED***</button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>***REMOVED*** echo _('Already have an account?'); ***REMOVED*** <a href="login.php" class="text-danger m-l-5"><b>***REMOVED*** echo _('Sign in'); ***REMOVED***</b></a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script>
            var password = document.getElementById("pass"),
                confirm_password = document.getElementById("cpass");

            function validatePassword(){
                if(password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("***REMOVED*** echo _('Passwords do not match'); ***REMOVED***");
                ***REMOVED*** else {
                    confirm_password.setCustomValidity('');
                ***REMOVED***
            ***REMOVED***

            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>
        <!-- jQuery -->
        <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bootstrap/dist/js/bootstrap-select.min.js"></script>
        <!-- Menu Plugin JavaScript -->
        <script src="plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <!--slimscroll JavaScript -->
        <script src="js/jquery.slimscroll.js"></script>
        <!--Wave Effects -->
        <script src="js/waves.js"></script>
        <!-- Custom Theme JavaScript -->
        <script src="js/custom.js"></script>
        <!--Style Switcher -->
        <script src="plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script>
        ***REMOVED*** if(!isset($serverconnection)){
            echo "$.toast({
                        heading: '" . _("Error") . "'
                        , text: '" . _("Failed to connect to server.") . "<br>" . _("Please check config.php") . "'
                        , icon: 'error'
                        , position: 'top-right'
                        , hideAfter: false
                        , allowToastClose: false
                    ***REMOVED***);"; ***REMOVED***
if(substr(sprintf('%o', fileperms('includes')), -4) == '0777') {
         echo "$.toast({
                        heading: '" . _("Warning") . "'
                        , text: '" . _("Includes folder has not been secured") . "'
                        , icon: 'warning'
                        , position: 'top-right'
                        , hideAfter: 3500
                        , bgColor: '#ff8000'
                    ***REMOVED***);";
        
                ***REMOVED*** ***REMOVED***
        </script>
    </body>

</html>
