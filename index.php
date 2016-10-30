<?php session_start();
	if ($_SESSION['logged'] !== true) {
		 header("Location: login");
		 exit();
	}
?>
<!DOCTYPE html>
<html ng-app="exam_module">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>British Way</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="javascript:void(0)" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>British Way</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>British Way</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">


    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
				<?php foreach($_SESSION['menus'] as $key => $menu): ?>

				<li class="treeview">
          <a href="#/<?php echo $menu['path']; ?>">
            <i class="fa fa-pie-chart"></i>
            <span> <?php echo $key; ?> </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>

			<?php if(is_array($menu)) :?>
			<li class="treeview active">
				<ul class="treeview-menu menu-open">
					<?php foreach($menu as $k => $sub): ?>
						<?php if($k != 'path') :?>
					<li><a href="#/<?php echo $k;?>"><i class="fa fa-circle-o"></i> <?php echo $sub;?> </a></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>

			</li>
		<?php endif; ?>
			<?php endforeach; ?>
				<li><a href="login/"><span>Loggout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{title}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">{{title}}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-view>


      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.6
    </div>
    <strong>Copyright &copy; 2016-2016 <a href="#">Group 5</a>.</strong> All rights
    reserved.
  </footer>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="bower_components/angular/angular.min.js"></script>
<script src="bower_components/angular-route/angular-route.min.js"></script>
<script src="bower_components/angular-cookies/angular-cookies.min.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/angular-animate/angular-animate.js"></script>
<script src="bower_components/angular-strap/dist/angular-strap.min.js"></script>
<script src="bower_components/angular-strap/dist/angular-strap.tpl.min.js"></script>
<script src="js/app.js"></script>
<script src="js/service/route.js"></script>
<script src="js/service/ajax.js"></script>
<script src="js/service/authoService.js"></script>
<script src="js/service/dataService.js"></script>
<script src="js/controller/masterStudentsController.js"></script>
<script src="js/controller/masterRegistrationsController.js"></script>
<script src="js/controller/masterBatchesController.js"></script>
<script src="js/vendor/FileSaver.js"></script>

</body>
</html>
