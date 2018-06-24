<?php 
require '../includes/arrays.php';
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Install Vesta Web Interface</title>
        <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
        <style>
            .tooltip-inner {
                max-width: 350px;
                width: 350px; 
            }
        </style>
        <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/css/bootstrapValidator.min.css'>
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body><br><br>
        <div class="container">

            <form class="form-horizontal" method="post" action="step2.php">
                <fieldset>

                    <legend>Install Vesta Web Interface</legend>
                    <h3 style="text-align:center;">Checking Requirements</h3>
                    <center style="width:80%;">

                        <br><br>


                        <table style="width:80%; line-height: 200%;position:relative;left:12%;">
                            <tr>
                                <td style="font-size:16px; text-align:">PHP Version >= 5.4:</td>
                                <td style="font-size:16px;"><span style="color:<?php if(phpversion() >= 5.4) {echo "limegreen"; $a1 = 0; } else { echo "red"; $a1 = 1;} ?>"><?php echo phpversion(); ?></span></td>
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP cURL Extension:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (extension_loaded('curl')) {echo "limegreen";  $a2 = 0; } else { echo "red";  $a2 = 1; } ?>"><?php if (extension_loaded('curl')) {echo "Installed"; } else { echo "Not Installed"; } ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP gettext Extension:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (extension_loaded('gettext')) {echo "limegreen";  $a3 = 0; } else { echo "red";  $a3 = 1; } ?>"><?php if (extension_loaded('gettext')) {echo "Installed"; } else { echo "Not Installed"; } ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP OpenSSL Extension:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (extension_loaded('openssl')) {echo "limegreen";  $a4 = 0; } else { echo "red";  $a4 = 1; } ?>"><?php if (extension_loaded('openssl')) {echo "Installed"; } else { echo "Not Installed"; } ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP MySQLi Extension:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (extension_loaded('mysqli')) {echo "limegreen";  $a5 = 0; } else { echo "red";  $a5 = 1; }  ?>"><?php if (extension_loaded('mysqli')) {echo "Installed"; } else { echo "Not Installed"; } ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP FTP Extension:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (extension_loaded('ftp')) {echo "limegreen";  $a6 = 0; } else { echo "red";  $a6 = 1; } ?>"><?php if (extension_loaded('ftp')) {echo "Installed"; } else { echo "Not Installed"; } ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">PHP File Uploads (On):</td>
                                <td style="font-size:16px;"><span style="color:<?php if(ini_get('file_uploads') == 1) {echo "limegreen";  $a7 = 0; } else { echo "red";  $a7 = 1; } ?>"><?php if(ini_get('file_uploads') == 1) {echo "Enabled"; } else { echo "Disabled"; } ?></span></td> 
                            </tr> 
                            <tr>
                                <td style="font-size:16px;">PHP Display Errors (Off):</td>
                                <td style="font-size:16px;"><span style="color:<?php if(ini_get('display_errors') != 1) {echo "limegreen";  $a8 = 0; } else { echo "red";  $a8 = 1; } ?>"><?php if(ini_get('display_errors') != 1) {echo "Disabled"; } else { echo "Enabled"; } ?></span></td> 
                            </tr>  
                            <tr>
                                <td style="font-size:16px;">'includes/config.php' Does Not Exist:</td>
                                <td style="font-size:16px;"><span style="color:<?php if (file_exists( '../includes/config.php') === false) {echo "limegreen";  $a9 = 0; } else { echo "red";  $a9 = 1; } ?>"><?php if (file_exists( '../includes/config.php') === false) {echo "Does Not Exist";} else { echo "Exists";} ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">'includes' Is Writable (777):</td>
                                <td style="font-size:16px;"><span style="color:<?php if (substr(sprintf("%o",fileperms("../includes")),-3) == "777") {echo "limegreen";  $a10 = 0; } else { echo "red";  $a10 = 1; } ?>"><?php if (substr(sprintf("%o",fileperms("../includes")),-3) == "777") {echo "Writable";} else { echo "Not Writable";} ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">'tmp' Is Writable (777):</td>
                                <td style="font-size:16px;"><span style="color:<?php if (substr(sprintf("%o",fileperms("../tmp")),-3) == "777") {echo "limegreen";  $a11 = 0; } else { echo "red";  $a11 = 1; } ?>"><?php if (substr(sprintf("%o",fileperms("../tmp")),-3) == "777") {echo "Writable";} else { echo "Not Writable";} ?></span></td> 
                            </tr>
                            <tr>
                                <td style="font-size:16px;">'plugins/images/uploads' Is Writable (777):</td>
                                <td style="font-size:16px;"><span style="color:<?php if (substr(sprintf("%o",fileperms("../tmp")),-3) == "777") {echo "limegreen";  $a12 = 0; } else { echo "red";  $a12 = 1; } ?>"><?php if (substr(sprintf("%o",fileperms("../tmp")),-3) == "777") {echo "Writable";} else { echo "Not Writable";} ?></span></td> 
                            </tr>           
                        </table>
                        <br><br><br>
                        <div class="form-group" style="float:right;">
                            <label class="col-md-4 control-label" for="singlebutton"></label>
                            <div class="col-md-4"> 
                                <?php if(($a1+$a2+$a2+$a3+$a5+$a6+$a7+$a8+$a9+$a10+$a11+$a12) != 0) { echo '<span class="d-inline-block" boundary="viewport" tabindex="0" data-toggle="tooltip" title="Please Meet All Requirements">'; } ?>
                                <button class="<?php if(($a1+$a2+$a2+$a3+$a5+$a6+$a7+$a8+$a9+$a10+$a11+$a12) != 0) { echo "disabled"; } ?> btn btn-primary">Continue</button>
                                <?php if(($a1+$a2+$a2+$a3+$a5+$a6+$a7+$a8+$a9+$a10+$a11+$a12) != 0) { echo '</span>'; } ?>
                            </div>
                        </div>

                    </center>
                </fieldset>
            </form>
            <br><br><br>
        </div>
        <script src="js/popper.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
        <script src="js/index.js"></script>
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        </script>
    </body>
</html>
