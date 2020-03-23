<?php 

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
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

if (file_exists( '../includes/config.php' )) { header( 'Location: index.php' ); exit();}; 

function randomPassword() { $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; $pass = array(); $alphaLength = strlen($alphabet) - 1; for ($i = 0; $i < 8; $i++) { $n = rand(0, $alphaLength); $pass[] = $alphabet[$n]; } return implode($pass); }


if((isset($_POST['MYSQL_HOST'])) && (isset($_POST['MYSQL_UNAME'])) && (isset($_POST['MYSQL_PW'])) && (isset($_POST['MYSQL_DB'])) && (isset($_POST['MYSQL_TABLE']))) {

    $mysqli = new mysqli($_POST['MYSQL_HOST'], $_POST['MYSQL_UNAME'], $_POST['MYSQL_PW'], $_POST['MYSQL_DB']);

    if ($mysqli->connect_errno) {
        $connection = "failed";
        exit();
    }

    if ($mysqli->ping()) {

        $writestr = "<?php

// VESTA WEB INTERFACE CONFIGURATION

\$mysql_server = '" . $_POST['MYSQL_HOST'] . "'; // MySQL Server Address.
\$mysql_uname = '" . $_POST['MYSQL_UNAME'] . "'; // MySQL Database Username.
\$mysql_pw = '" . $_POST['MYSQL_PW'] . "'; // MySQL Database Password'.
\$mysql_db = '" . $_POST['MYSQL_DB'] . "'; // MySQL Database Name.
\$mysql_table = '" . $_POST['MYSQL_TABLE'] . "'; // MySQL Table Prefix

\$KEY3 = '".randomPassword()."';
\$KEY4 = '".randomPassword()."';
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
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrap/dist/css/bootstrap-theme.min.css'>
        <link rel='stylesheet prefetch' href='../plugins/components/bootstrapvalidator/bootstrapValidator.css'>
        <style>
        #success_message{ display: none;}
        </style>
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
                            <input name="MYSQL_UNAME" type="text" class="form-control input-md">

                        </div>
                    </div>
                    <!-- Password input-->
                    <div class="form-group">
                        <label class="col-md-4 control-label">MySQL Password</label>
                        <div class="col-md-4">
                            <input name="MYSQL_PW" type="password" class="form-control input-md">

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
        <script src='../plugins/components/jquery/jquery.min.js'></script>
        <script src='../plugins/components/bootstrap/dist/js/bootstrap.min.js'></script>
        <script src='../plugins/components/bootstrapvalidator/bootstrapValidator.js'></script>
        <script type="text/javascript">
        $(document).ready(function(){$("#contact_form").bootstrapValidator({feedbackIcons:{valid:"glyphicon glyphicon-ok",invalid:"glyphicon glyphicon-remove",validating:"glyphicon glyphicon-refresh"},fields:{first_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your first name"}}},last_name:{validators:{stringLength:{min:2},notEmpty:{message:"Please supply your last name"}}},email:{validators:{notEmpty:{message:"Please supply your email address"},emailAddress:{message:"Please supply a valid email address"}}},phone:{validators:{notEmpty:{message:"Please supply your phone number"},phone:{country:"US",message:"Please supply a vaild phone number with area code"}}},address:{validators:{stringLength:{min:8},notEmpty:{message:"Please supply your street address"}}},city:{validators:{stringLength:{min:4},notEmpty:{message:"Please supply your city"}}},state:{validators:{notEmpty:{message:"Please select your state"}}},zip:{validators:{notEmpty:{message:"Please supply your zip code"},zipCode:{country:"US",message:"Please supply a vaild zip code"}}},comment:{validators:{stringLength:{min:10,max:200,message:"Please enter at least 10 characters and no more than 200"},notEmpty:{message:"Please supply a description of your project"}}}}}).on("success.form.bv",function(e){$("#success_message").slideDown({opacity:"show"},"slow"),$("#contact_form").data("bootstrapValidator").resetForm(),e.preventDefault();var s=$(e.target);s.data("bootstrapValidator");$.post(s.attr("action"),s.serialize(),function(e){console.log(e)},"json")})});
        </script>
    </body>
</html>
