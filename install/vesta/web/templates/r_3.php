<!-- /** 
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
*/ -->
<!DOCTYPE html>  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="16x16" href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/images/favicon.png">
        <title>Reset Password</title>
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/css/style.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/css/colors/default.css" id="theme"  rel="stylesheet">
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
                    <form class="form-horizontal form-material" autocomplete="off" id="loginform" method="post">
                        <h3 class="box-title m-b-20">Confirm Password</h3>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input type="hidden" name="action" value="confirm">
                                <input type="hidden" name="user" value="<?php print_r($_GET['user']); ?>">
                                <input type="hidden" name="user" value="<?php print_r($_GET['code']); ?>">
                                <input class="form-control" type="password" name="password" required="" placeholder="New Password">
                                <input class="form-control" type="password" name="password_confirm" required="" placeholder="Confirm Password">
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
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/jquery/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/Waves/waves.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/js/main.js"></script>
        <script>
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
        </script>
    </body>
</html>
