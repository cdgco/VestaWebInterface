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
    if(isset($_POST['username'])){

        if(isset($_POST['password'])){

            // Account
            $username2 = $_POST['username'];
            $password = $_POST['password'];

            // Prepare POST query
            $postvars = array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-check-user-password','arg1' => $username2,'arg2' => $password);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $vst_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postvars));
            $answer = curl_exec($curl);
        ***REMOVED***
    ***REMOVED***

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
        <link rel="icon" type="image/ico" href="plugins/images/favicon.ico">
        <title>***REMOVED*** echo $sitetitle . ' - ' . _("Login"); ***REMOVED***</title>
        <!-- Bootstrap Core CSS -->
        <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- animation CSS -->
        <link href="css/animate.css" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        ***REMOVED*** if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);***REMOVED*** gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; ***REMOVED*** ***REMOVED***
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
            ***REMOVED***</style>
        <!-- color CSS -->
        <link href="css/colors/***REMOVED*** if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); ***REMOVED*** else {echo $themecolor; ***REMOVED*** ***REMOVED***" id="theme"  rel="stylesheet">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
<![endif]-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.css" />
    </head>
    <body>
        ***REMOVED***

        if(isset($_GET['code'])){

            $answer = $_GET['code'];

            echo "<script> swal({title: '";
            if($answer == 0) {
                echo _("Account has been successfully created!") . "', type: 'success'***REMOVED***)</script>";
            ***REMOVED*** if($answer == 1) {
                echo _("Please fill out all sections of the form.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 2) {
                echo _("Invalid data entered in form. Please try again.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 3) {
                echo _("Server or form error (Code: 3). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 4) {
                echo _("Account already exists under same username.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 12) {
                echo _("System Error (Code: 12). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 13) {
                echo _("Server Error (Code: 13). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 14) {
                echo _("Server Error (Code: 14). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 15) {
                echo _("System Error (Code: 15). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 16) {
                echo _("Server Error (Code: 16). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 17) {
                echo _("Server Error (Code: 17). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 18) {
               echo _("Process Error (Code: 18). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 19) {
                echo _("Process Error (Code: 19). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED***
            if($answer == 20) {
                echo _("Fatal Error (Code: 20). Please contact support.") . "', type: 'error'***REMOVED***)</script>";
            ***REMOVED******REMOVED***
        ***REMOVED***
        <!-- Preloader -->
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel bg-theme">
                <div class="inner-panel">
                    <a href="javascript:void(0)" class="p-20 di"><img src="plugins/images/admin-logo.png" class="logo-1"></a>
                    <div class="lg-content">
                        <h2>***REMOVED*** echo $sitetitle . ' ' . _("Control Panel"); ***REMOVED*** <br></h2><p>***REMOVED*** require 'includes/versioncheck.php'; ***REMOVED***</p>

                    </div>
                </div>
            </div>
            <div class="new-login-box">
                <div class="white-box">
                    <form class="form-horizontal new-lg-form" id="loginform" method="post" action="login.php">
                        <h3 class="box-title m-b-0">***REMOVED*** echo _("Sign In to") . ' ' . $sitetitle . ' ' . _("CP"); ***REMOVED***</h3>
                        <small>***REMOVED*** echo _("Enter your details below"); ***REMOVED***</small>

                        ***REMOVED***
                        if(isset($_POST['username'])){
                            if(isset($_POST['password'])){

                                // Check result
                                if($answer == "OK") {
                                    $_SESSION['loggedin'] = base64_encode ( 'true' );
                                    $_SESSION['username'] = base64_encode ( $username2 );
                                    
                                    echo '<br><br>
                                        <div style="color: #000;" class="alert alert-success alert-dismissable">
                                            <button type="button" style="color: #000;" class="close text-inverse" aria-hidden="true">
                                                <i class="fa fa-circle-o-notch fa-spin" style="font-size:18px"></i>
                                            </button>
                                            <span style="opacity: 0.7;">' . _("Loading Dashboard") . '...</span>
                                        </div>
                                        <script>setTimeout(function(){ window.location = "index.php";***REMOVED***, 100);</script>';
                                ***REMOVED*** else {
                                    echo '<br><br><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . _("Error: Incorrect Login.") . '</div>';
                                ***REMOVED******REMOVED******REMOVED***

                        ***REMOVED***

                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <label>***REMOVED*** echo _("Username"); ***REMOVED***</label>
                                <input class="form-control" name="username" type="text" required="" placeholder="***REMOVED*** echo _('Username'); ***REMOVED***">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label>***REMOVED*** echo _("Password"); ***REMOVED***</label>
                                <input class="form-control" name="password" type="password" required="" placeholder="***REMOVED*** echo _('Password'); ***REMOVED***">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> ***REMOVED*** echo _("Forgot pwd?"); ***REMOVED***</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light bg-theme" style="border: none;" type="submit">***REMOVED*** echo _("Log in"); ***REMOVED***</button>
                            </div>
                        </div>
                        <br>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>***REMOVED*** echo _("Don't have an account?"); ***REMOVED*** <a href="register.php" class="text-primary m-l-5"><b>***REMOVED*** echo _("Sign Up"); ***REMOVED***</b></a></p>
                            </div>
                        </div>
                    </form>
                    <form class="form-horizontal" id="recoverform" method="post" action="***REMOVED*** echo $url8083; ***REMOVED***/reset/reset.php">
                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <h3 class="box-title m-b-0">***REMOVED*** echo _("Recover Password"); ***REMOVED***</h3>
                                <small>***REMOVED*** echo _("Enter your username and instructions will be sent to you."); ***REMOVED***</small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="user" type="text" required="" placeholder="***REMOVED*** echo _('Username'); ***REMOVED***">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                                <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"><i class="fa fa-sign-in m-r-5"></i> ***REMOVED*** echo _("Login"); ***REMOVED***</a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light bg-theme" style="border: none;" type="submit">***REMOVED*** echo _("Reset"); ***REMOVED***</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            


        </section>
        <!-- jQuery -->
        <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="bootstrap/dist/js/bootstrap.min.js"></script>
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
