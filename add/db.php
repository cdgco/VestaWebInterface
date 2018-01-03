***REMOVED***

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;

    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
      else { header('Location: ../login.php'); ***REMOVED***

    $postvars = array(
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-database','arg1' => $username,'arg2' => $requestdb, 'arg3' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-database-types', 'arg1' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-database-hosts', 'arg1' => 'json'));

    $curl0 = curl_init();
    $curl1 = curl_init();
    $curl2 = curl_init();
    $curl3 = curl_init();
    $curlstart = 0; 

    while($curlstart <= 3) {
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    ***REMOVED*** 

    $admindata = json_decode(curl_exec($curl0), true)[$username];
    $useremail = $admindata['CONTACT'];
    $dbname = array_keys(json_decode(curl_exec($curl1), true));
    $dbdata = array_values(json_decode(curl_exec($curl1), true));
    $dbtypes = array_values(json_decode(curl_exec($curl2), true));
    $dbhosts = array_values(json_decode(curl_exec($curl3), true));

***REMOVED***

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" href="../plugins/images/favicon.ico">
    <title>***REMOVED*** echo $sitetitle; ***REMOVED*** - Database</title>
    <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
    <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/colors/***REMOVED*** echo $themecolor; ***REMOVED***" id="theme" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
    <!--[if lt IE 9]>
       <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
       <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
        </svg>
    </div>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="../index.php">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>      
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">

                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs">***REMOVED*** print_r($uname); ***REMOVED***</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-text">
                                        <h4>***REMOVED*** print_r($uname); ***REMOVED***</h4>
                                        <p class="text-muted">***REMOVED*** print_r($useremail); ***REMOVED***</p></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../profile.php"><i class="ti-home"></i> My Account</a></li>
                            <li><a href="../profile.php?settings=open"><i class="ti-settings"></i> Account Setting</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../process/logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3>
                        <span class="fa-fw open-close">
                            <i class="ti-menu hidden-xs"></i>
                            <i class="ti-close visible-xs"></i>
                        </span> 
                        <span class="hide-menu">Navigation</span>
                    </h3>  
                </div>
               <ul class="nav" id="side-menu">
                            <li> 
                                <a href="../index.php" class="waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">Dashboard</span>
                                </a> 
                            </li>

                            <li class="devider"></li>
                            <li>
                                <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> ***REMOVED*** print_r($uname); ***REMOVED***<span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> My Account</span></a></li>
                                    <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> Account Setting</span></a></li>
                                </ul>
                            </li>
                            ***REMOVED*** if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                                <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Management <span class="fa arrow"></span> </span></a>
                                    <ul class="nav nav-second-level">'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($webenabled == 'true') { echo '<li> <a href="../list/web.php"><i class="ti-world fa-fw"></i><span class="hide-menu">Web</span></a> </li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">DNS</span></a> </li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">Mail</span></a> </li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php" class="active"><i class="fa fa-database fa-fw"></i><span class="hide-menu">Database</span></a> </li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                                </li>'; ***REMOVED*** ***REMOVED***
                            <li> <a href="../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Cron Jobs</span></a> </li>
                            <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">Backups</span></a> </li>
                            ***REMOVED*** if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {***REMOVED*** else { echo '<li class="devider"></li>
                                <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Apps<span class="fa arrow"></span></span></a>
                                    <ul class="nav nav-second-level">'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">FTP</span></a></li>';***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">Webmail</span></a></li>';***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">phpMyAdmin</span></a></li>';***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">phpPgAdmin</span></a></li>';***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {***REMOVED*** else { echo '</ul></li>';***REMOVED*** ***REMOVED***
                            <li class="devider"></li>
                            <li><a href="process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                            ***REMOVED*** if ($oldcpurl == '' || $supporturl == '') {***REMOVED*** else { echo '<li class="devider"></li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> Control Panel v1</span></a></li>'; ***REMOVED*** ***REMOVED***
                            ***REMOVED*** if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">Support</span></a></li>'; ***REMOVED*** ***REMOVED***
                        </ul>
            </div>
        </div>
        <div id="page-wrapper">
           <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Add Database</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" autocomplete="off" method="post" action="../create/database.php">
                                <div class="form-group">
                                    <label class="col-md-12">Database</label>
                                    <div class="col-md-12">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <div class="input-group-addon">***REMOVED*** print_r($uname); ***REMOVED***_</div>
                                            <input type="text" class="form-control" name="v_database" style="padding-left: 0.5%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Username</label>
                                    <div class="col-md-12">
                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                            <div class="input-group-addon">***REMOVED*** print_r($uname); ***REMOVED***_</div>
                                            <input type="text" class="form-control" autocomplete="new-password" name="v_dbuser" style="padding-left: 0.5%;">    
                                        </div>
                                        <small class="form-text text-muted">Max Length 16 Characters Including Prefix</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-md-12">Password / <a style="cursor:pointer" onclick="generatePassword(10)"> Generate</a></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="password" pattern=".{6,***REMOVED***" autocomplete="new-password" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                        <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                        </span>  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Type</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="v_type">
                                            ***REMOVED***
                                            if($dbtypes[0] != '') {
                                                $x2 = 0; 

                                                do {
                                                    echo '<option value="' . $dbtypes[$x2] . '">' . $dbtypes[$x2] . '</option>';
                                                    $x2++;
                                                ***REMOVED*** while ($dbtypes[$x2] != ''); ***REMOVED***

                                            ***REMOVED***
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Hosts</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="v_host">
                                            ***REMOVED***
                                            if($dbhosts[0] != '') {
                                                $x3 = 0; 

                                                do {
                                                    echo '<option value="' . $dbhosts[$x3]['HOST'] . '">' . $dbhosts[$x3]['HOST'] . '</option>';
                                                    $x3++;
                                                ***REMOVED*** while ($dbhosts[$x3] != ''); ***REMOVED***

                                            ***REMOVED***
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Charset</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="v_charset">
                                        <option value="big5">big5</option>
                                        <option value="dec8">dec8</option>
                                        <option value="cp850">cp850</option>
                                        <option value="hp8">hp8</option>
                                        <option value="koi8r">koi8r</option>
                                        <option value="latin1">latin1</option>
                                        <option value="latin2">latin2</option>
                                        <option value="swe7">swe7</option>
                                        <option value="ascii">ascii</option>
                                        <option value="ujis">ujis</option>
                                        <option value="sjis">sjis</option>
                                        <option value="hebrew">hebrew</option>
                                        <option value="tis620">tis620</option>
                                        <option value="euckr">euckr</option>
                                        <option value="koi8u">koi8u</option>
                                        <option value="gb2312">gb2312</option>
                                        <option value="greek">greek</option>
                                        <option value="cp1250">cp1250</option>
                                        <option value="gbk">gbk</option>
                                        <option value="latin5">latin5</option>
                                        <option value="armscii8">armscii8</option>
                                        <option value="utf8" selected>utf8</option>
                                        <option value="ucs2">ucs2</option>
                                        <option value="cp866">cp866</option>
                                        <option value="keybcs2">keybcs2</option>
                                        <option value="macce">macce</option>
                                        <option value="macroman">macroman</option>
                                        <option value="cp852">cp852</option>
                                        <option value="latin7">latin7</option>
                                        <option value="cp1251">cp1251</option>
                                        <option value="cp1256">cp1256</option>
                                        <option value="cp1257">cp1257</option>
                                        <option value="binary">binary</option>
                                        <option value="geostd8">geostd8</option>
                                        <option value="cp932">cp932</option>
                                        <option value="eucjpms">eucjpms</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success">Add Database</button> &nbsp;
                                            <a href="../list/db.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button">Back</button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           <footer class="footer text-center">&copy; Copyright ***REMOVED*** echo date("Y") . ' ' . $sitetitle; ***REMOVED***. All Rights Reserved. Vesta Web Interface ***REMOVED*** require '../includes/versioncheck.php'; ***REMOVED*** by CDG Web Services.</footer>
    </div>
    </div>
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="../js/jquery.slimscroll.js"></script>
    <script src="../js/waves.js"></script>
    <script src="../plugins/bower_components/moment/moment.js"></script>
    <script src="../plugins/bower_components/footable/js/footable.min.js"></script>
    <script src="../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="../plugins/bower_components/custom-select/custom-select.min.js"></script>
    <script src="../js/footable-init.js"></script>
    <script src="../js/custom.js"></script>
    <script src="../js/dashboard1.js"></script>
    <script src="../js/cbpFWTabs.js"></script>
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
    <script type="text/javascript">
        (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                new CBPFWTabs(el);
            ***REMOVED***);
        ***REMOVED***)();
        function toggler(e) {
            if( e.name == 'Hide' ) {
                e.name = 'Show'
                document.getElementById('password').type="password";
            ***REMOVED*** else {
                e.name = 'Hide'
                document.getElementById('password').type="text";
            ***REMOVED***
        ***REMOVED***
        function generatePassword(length) {
            var password = '', character; 
            while (length > password.length) {
                if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                    password += character;
                ***REMOVED***
            ***REMOVED***
            document.getElementById('password').value = password;
            document.getElementById('tg').name='Hide';
            document.getElementById('password').type="text";
        ***REMOVED***
        jQuery(function($){
            $('.footable').footable();
        ***REMOVED***);
        function confirmDelete(e){
            e1 = String(e)
            swal({
                title: 'Delete Web Domain:<br>' + e1 +' ?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            ***REMOVED***).then(function () {
                swal({
                    title: 'Processing',
                    text: '',
                    timer: 5000,
                    onOpen: function () {
                        swal.showLoading()
                    ***REMOVED***
                ***REMOVED***).then(
                    function () {***REMOVED***,
                    // handling the promise rejection
                    function (dismiss) {
                        if (dismiss === 'timer') {
                            console.log('I was closed by the timer')
                        ***REMOVED***
                    ***REMOVED***
                )
                $.ajax({  
                    type: "GET",  
                    url: "../delete/domain.php",  
                    data: { 'domain':e1, 'verified':'yes' ***REMOVED***,
                    success:  function(){ window.location = "web.php?delcode=0"; ***REMOVED***,
                    error:  function(){ window.location = "web.php?delcode=0"; ***REMOVED***
                ***REMOVED***)
            ***REMOVED***)***REMOVED***

        ***REMOVED*** if($_GET['delcode'] == "0"){ echo "swal({title:'Successfully Deleted!', type:'success'***REMOVED***);";***REMOVED*** ***REMOVED***
    </script>
</body>

</html>