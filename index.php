<?php session_start();
	if ($_SESSION['logged'] !== true) {
		 header("Location: login");
		 exit();
	}
?>
<!DOCTYPE html>
<html ng-app="britishway" moznomarginboxes mozdisallowselectionprint>
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
	<link rel="stylesheet" href="bower_components/angular-loading-bar/build/loading-bar.min.css">

	<link rel="stylesheet" href="css/style.css">

  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css"/>
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
			<div class="navbar-custom-menu">
			        <ul class="nav navbar-nav">
			          <li class="user user-menu">
			            <a href="javascript:void(0)">
										<i class="fa fa-user"></i>
			              <span class="hidden-xs"><?php echo $_SESSION['user']['data'][0]->user_display_name; ?></span>
			            </a>
								</li>
								<li><a href="login/"><span>Logout</span></a></li>
			          </ul>
			          </li>

			        </ul>
			      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
			<div class="sidebar-form">
			        <div class="input-group">
			          <input name="q" class="form-control" placeholder="Search..." type="text" ng-model="global_search">
			              <span class="input-group-btn">
			                <a href="#/search?r={{global_search}}" class="btn btn-flat"><i class="fa fa-search"></i></a>
			              </span>
			        </div>
			      </div>
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

							<?php if($k == "students_edit"): ?>
								<div class="input-group">
									<input name="q" class="form-control" placeholder="Edit Students" type="text" ng-model="global_student__search">
											<span class="input-group-btn">
												<a href="#/students_edit?s={{global_student__search}}" class="btn btn-flat"><i class="fa fa-edit"></i></a>
											</span>
								</div>
								<?php continue; ?>
							<?php endif;?>

							<?php if($k == "registrations_edit"): ?>
								<div class="input-group">
				          <input name="q" class="form-control" placeholder="Edit Registration" type="text" ng-model="global_search">
				              <span class="input-group-btn">
				                <a href="#/registrations_edit?r={{global_search}}" class="btn btn-flat"><i class="fa fa-edit"></i></a>
				              </span>
				        </div>
								<?php continue; ?>
							<?php endif;?>

					<li><a href="#/<?php echo $k;?>"><i class="fa fa-circle-o"></i> <?php echo $sub;?> </a></li>
					<?php endif; ?>
				<?php endforeach; ?>
				</ul>

			</li>
		<?php endif; ?>
			<?php endforeach; ?>
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


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Bootstrap 3.3.6 -->
<script src="bower_components/angular/angular.min.js"></script>
<script src="bower_components/angular-route/angular-route.min.js"></script>
<script src="bower_components/angular-cookies/angular-cookies.min.js"></script>
<script src="bower_components/jquery/jquery.min.js"></script>
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="bower_components/angular-animate/angular-animate.js"></script>
<script src="bower_components/angular-strap/dist/angular-strap.min.js"></script>
<script src="bower_components/angular-strap/dist/angular-strap.tpl.min.js"></script>
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/angular-daterangepicker/js/angular-daterangepicker.js"></script>
<script src="bower_components/angular-loading-bar/build/loading-bar.min.js"></script>
<script src="js/app.js"></script>
<script src="js/service/route.js"></script>
<script src="js/service/ajax.js"></script>
<script src="js/service/authoService.js"></script>
<script src="js/service/dataService.js"></script>
<script src="js/controller/masterStudentsController.js"></script>
<script src="js/controller/masterRegistrationsController.js"></script>
<script src="js/controller/masterRegistrationsDeleteController.js"></script>
<script src="js/controller/masterBatchesController.js"></script>
<script src="js/controller/masterPaymentsController.js"></script>
<script src="js/controller/masterPaymentsDeleteController.js"></script>
<script src="js/controller/reportIncomeController.js"></script>
<script src="js/controller/reportRegistrationsController.js"></script>
<script src="js/controller/reportBatchWiseController.js"></script>
<script src="js/controller/reportDuesController.js"></script>
<script src="js/controller/reportSearchController.js"></script>
<script src="js/controller/indexController.js"></script>
<script src="js/controller/masterRegistrationsEditController.js"></script>
<script src="js/controller/masterStudentsEditController.js"></script>
<script src="js/controller/reportStudentDetailsController.js"></script>
<script src="js/directive/focus.js"></script>
<script src="js/vendor/FileSaver.js"></script>

</body>
</html>
