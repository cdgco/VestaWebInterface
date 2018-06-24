<?php 

if (file_exists( '../includes/config.php' )) { header( 'Location: index.php' );}; 

if((isset($_POST['MYSQL_HOST'])) && (isset($_POST['MYSQL_UNAME'])) && (isset($_POST['MYSQL_PW'])) && (isset($_POST['MYSQL_DB'])) && (isset($_POST['MYSQL_TABLE']))) {

    $mysqli = new mysqli($_POST['MYSQL_HOST'], $_POST['MYSQL_UNAME'], $_POST['MYSQL_PW'], $_POST['MYSQL_DB']);

    if ($mysqli->connect_errno) {
        $connection = "failed";
        exit();
    }

    if ($mysqli->ping()) {

        $writestr = "<?php

///////////////////////////////////////
// VESTA WEB INTERFACE CONFIGURATION //
///////////////////////////////////////

\$mysql_server = '" . $_POST['MYSQL_HOST'] . "'; // MySQL Server Address.
\$mysql_uname = '" . $_POST['MYSQL_UNAME'] . "'; // MySQL Database Username.
\$mysql_pw = '" . $_POST['MYSQL_PW'] . "'; // MySQL Database Password'.
\$mysql_db = '" . $_POST['MYSQL_DB'] . "'; // MySQL Database Name.
\$mysql_table = '" . $_POST['MYSQL_TABLE'] . "'; // MySQL Table Prefix

?>";

        file_put_contents('../includes/config.php', $writestr);

        $connection = "success";

    } else {
        $connection = "failed";
    }

    $mysqli->close();
}

?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Install Vesta Web Interface</title>
        <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>



        <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css'>

        <link rel="stylesheet" href="css/style.css">


    </head>

    <body><br><br>
        <div class="container">

            <form class="form-horizontal" method="post" action="step2.php">
                <fieldset>

                    <!-- Form Name -->
                    <legend>Install Vesta Web Interface</legend>
                    <br>
                    <center>
                        <?php if($connection == "success") { echo '<div style="background-color:limegreen;color:white;font-weight:bold;">MySQL Connection Successful. Loading ...</div><br>'; header( "refresh:1;url=step3.php" ); }
                        elseif($connection == "failed") { echo '<div style="background-color:#f30505;color:white;font-weight:bold;line-height:40px;border-radius:10px;">MySQL Connection Failed. Try Again.</div><br>'; } ?>
                        <h3>Server Configuration</h3>
                    </center><br>
                    <input type="hidden" value="1" name="x"/>


                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">MySQL Host</label>  
                        <div class="col-md-4">
                            <input name="MYSQL_HOST" type="text" value="localhost" class="form-control input-md" required="">

                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">MySQL Username</label>  
                        <div class="col-md-4">
                            <input name="MYSQL_UNAME" type="text" class="form-control input-md" required="">

                        </div>
                    </div>
                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">MySQL Password</label>
                        <div class="col-md-4">
                            <input name="MYSQL_PW" type="password" class="form-control input-md" required="">

                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Database Name</label>  
                        <div class="col-md-4">
                            <input name="MYSQL_DB" type="text" class="form-control input-md" required="">
                        </div>
                    </div>

                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">Table Prefix</label>  
                        <div class="col-md-4">
                            <input name="MYSQL_TABLE" type="text" value="vwi_" class="form-control input-md" required="">
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="singlebutton"></label>
                        <div class="col-md-4">
                            <button class="btn btn-primary">Submit</button>
                        </div>
                    </div>

                </fieldset>
            </form>
            <br><br><br>

        </div>

        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
        <script src="js/index.js"></script>
        <script type="text/javascript">
            var _paq = _paq || [];
            _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
            _paq.push(['trackPageView']);
            _paq.push(['enableLinkTracking']);
            (function() {
                var u="//tracking.cdgtech.one/";
                _paq.push(['setTrackerUrl', u+'piwik.php']);
                _paq.push(['setSiteId', '1']);
                var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
                g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
            })();
        </script>
    </body>
</html>
