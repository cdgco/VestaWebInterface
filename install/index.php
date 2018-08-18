<?php 

/** 
*
* Vesta Web Interface v0.5.1-Beta
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

require '../includes/arrays.php';
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Install Vesta Web Interface</title>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrapvalidator/bootstrapValidator.css'>
        <link rel="stylesheet" href="css/style.css">
        <style>
            .tooltip-inner {
                max-width: 350px;
                width: 350px; 
            }
            #success_message{ display: none;}
        </style>
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
                                <td style="font-size:16px;"><span style="color:<?php if (substr(sprintf("%o",fileperms("../plugins/images/uploads")),-3) == "777") {echo "limegreen";  $a12 = 0; } else { echo "red";  $a12 = 1; } ?>"><?php if (substr(sprintf("%o",fileperms("../plugins/images/uploads")),-3) == "777") {echo "Writable";} else { echo "Not Writable";} ?></span></td> 
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
        <script src='../plugins/components/jquery/jquery.min.js'></script>
        <script src='../plugins/components/bootstrap/dist/js/bootstrap.min.js'></script>
        <script src='../plugins/components/bootstrapvalidator/bootstrapValidator.js'></script>
        <script src="../plugins/components/popper.js/popper.js"></script>
        <script type="text/javascript">
        $(document).ready(function(){$("#contact_form").bootstrapValidator({feedbackIcons:{valid:"glyphicon glyphicon-ok",invalid:"glyphicon g lyphicon-remove",validating:"glyphicon glyphicon-refresh"},fields:{first_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your first name"}}},last_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your last name"}}},email:{validators:{notEmpty:{message:"Please supply your email address"},emailAddress:{message:"Please supply a valid email address"}}},phone:{validators:{notEmpty:{message:"Please supply your phone number"},phone:{country:"US",message:"Please supply a vaild phone number with area code"}}},address:{validators:{stringLength:{min:8},notEmpty:{message:"Please supply your street address"}}},city:{validators:{stringLength:{min:4},notEmpty:{message:"Please supply your city"}}},state:{validators:{notEmpty:{message:"Please select your state"}}},zip:{validators:{notEmpty:{message:"Please supply your zip code"},zipCode:{country:"US",message:"Please supply a vaild zip code"}}},comment:{validators:{stringLength:{min:10,max:200,message:"Please enter at least 10 characters and no more than 200"},notEmpty:{message:"Please supply a description of your project"}}}}}).on("success.form.bv",function(e){$("#success_message").slideDown({opacity:"show"},"slow"),$("#contact_form").data("bootstrapValidator").resetForm(),e.preventDefault();var s=$(e.target);s.data("bootstrapValidator");$.post(s.attr("action"),s.serialize(),function(e){console.log(e)},"json")})});
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        </script>
    </body>
</html>
