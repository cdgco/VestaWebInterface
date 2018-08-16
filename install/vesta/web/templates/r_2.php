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
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/images/favicon.png">
<title>CDG Host - Reset Password</title>
<!-- Bootstrap Core CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/animate.css/animate.min.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/css/colors/default.css" id="theme"  rel="stylesheet">
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
      <form class="form-horizontal form-material" autocomplete="off" id="loginform" action="/reset/reset.php">
<div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> Please check your email and enter the verification code below.</div>
<div style="height:20px"><?php if (isset($ERROR)) echo $ERROR ?></div>

        <h3 class="box-title m-b-20">Recover Password</h3>
        <div class="form-group ">
          <div class="col-xs-12">
            <input type="hidden" name="action" value="confirm">
            <input type="hidden" name="user" value="<?php print_r($_GET['user']); ?>">
            <input class="form-control" type="text" name="code" required="" placeholder="Reset Code">
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
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/plugins/components/metismenu/dist/metisMenu.min.js"></script>

<!--slimscroll JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.1-Beta/js/custom.js"></script>
</body>
</html>
