<?php
session_start();
$_SESSION['loggedIn'] = false;
session_destroy();
unset($_SESSION['Sys_U_Name']);
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8 lt-ie7" ng-app="inquiries"> <![endif]-->
<!--[if IE 7]> <html lang="en" class="no-js lt-ie9 lt-ie8" ng-app="inquiries"> <![endif]-->
<!--[if IE 8]> <html lang="en" class="no-js lt-ie9" ng-app="inquiries"> <![endif]-->
<!--[if gt IE 8]><!--><html lang="en" class="no-js"><!--<![endif]-->
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>British Way - English Language Institute </title>
    <meta name="description" content="EXAM Management Application">
    <meta name="keywords" content="">

    <!-- Reset -->
    <link rel="stylesheet" href="css/normalizr-min.css">

    <!-- Bootstrap 3.3.1-->
    <link rel="stylesheet" href="css/bootstrap.min.css">


    <!-- Fonts -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>

    <!-- Styles -->
    <link rel="stylesheet" href="css/pre-classes.css">
    <link rel="stylesheet" href="css/style.css">

    <!-- jQuery 1.11.1-->
    <script src="js/jquery-1.11.1.min.js"></script>

    <!-- Bootstrap 3.3.1-->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.flip.min.js"></script>

    <!-- Other JS -->
    <script src="js/jquery.custom.js"></script>

    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
    <![endif]-->

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
  </head>
  <body>

    <!-- Login Wrap -->
    <section class="login-wrap">

      <!-- Heading -->
      <h1><i class="secondary">FRONT OFFICE</i> <br><br><i class="main">British Way</i>  </h1><!-- // Heading -->

      <!-- Flip Card -->

	<div id="card" >
        <!-- Login Form -->
        <div class="front">
          <div class="login-form">
                  <form action="../php/login.php" method="post">
            <!-- Content -->
            <div class="login-content">

              <label><input type="text" name="user_name" placeholder="User Name"></label>
              <label><input type="password" name="password" placeholder="Password"></label>

              <span class="actions">
                <input type="submit" value="Login">
              </span>
            </div><!-- // Content -->

            <!-- Content Footer -->
            <div class="content-footer">
              <P>Need Help? </P>
            </div><!-- // Content Footer -->
	</form>
          </div>
        </div> <!-- // Login Form -->

        <!-- Forgot Pass Form -->
        <div class="back">
          <div class="login-form">
           <form>
            <!-- Content -->
            <div class="login-content">

              <label><input type="text" name="user" placeholder="User Name"></label>
              <label>
              	<input type="password" name="password" placeholder="New Password" style="width: 45.5%;margin-right:1.5%;">
              	<input type="password" name="password" placeholder="Confirm New Password" style="width: 50.5%;margin-left:1.5%;">
              </label>

              <span class="actions">
                <input type="submit" value="Reset" style="background: #93A1B3;">
                <a href="#" class="back-to-login" title="Back to login">Back to login</a>
              </span>

            </div><!-- // Content -->

            <!-- Content Footer -->
            <div class="content-footer">
              <P></P>
            </div><!-- // Content Footer -->

          </div>
        </div><!-- // Forgot Pass Form -->
	</form>
      </div><!-- //Flip Card -->

      <!-- Copyrights -->
      <p class="copyrights">2016 &copy; All rights reserved - Britishway</p><!-- // Copyrights -->

    </section><!-- // Login Wrap -->

  </body>
</html>
