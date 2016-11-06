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
			          <!-- Messages: style can be found in dropdown.less-->
			          <li class="dropdown messages-menu">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-envelope-o"></i>
			              <span class="label label-success">4</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 4 messages</li>
			              <li>
			                <!-- inner menu: contains the actual data -->
			                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
			                  <li><!-- start message -->
			                    <a href="#">
			                      <div class="pull-left">
			                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
			                      </div>
			                      <h4>
			                        Support Team
			                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
			                      </h4>
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                  <!-- end message -->
			                  <li>
			                    <a href="#">
			                      <div class="pull-left">
			                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
			                      </div>
			                      <h4>
			                        AdminLTE Design Team
			                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
			                      </h4>
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <div class="pull-left">
			                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
			                      </div>
			                      <h4>
			                        Developers
			                        <small><i class="fa fa-clock-o"></i> Today</small>
			                      </h4>
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <div class="pull-left">
			                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
			                      </div>
			                      <h4>
			                        Sales Department
			                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
			                      </h4>
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <div class="pull-left">
			                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
			                      </div>
			                      <h4>
			                        Reviewers
			                        <small><i class="fa fa-clock-o"></i> 2 days</small>
			                      </h4>
			                      <p>Why not buy a new awesome theme?</p>
			                    </a>
			                  </li>
			                </ul><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>
			              </li>
			              <li class="footer"><a href="#">See All Messages</a></li>
			            </ul>
			          </li>
			          <!-- Notifications: style can be found in dropdown.less -->
			          <li class="dropdown notifications-menu">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-bell-o"></i>
			              <span class="label label-warning">10</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 10 notifications</li>
			              <li>
			                <!-- inner menu: contains the actual data -->
			                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
			                  <li>
			                    <a href="#">
			                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
			                      page and may cause design problems
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <i class="fa fa-users text-red"></i> 5 new members joined
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
			                    </a>
			                  </li>
			                  <li>
			                    <a href="#">
			                      <i class="fa fa-user text-red"></i> You changed your username
			                    </a>
			                  </li>
			                </ul><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>
			              </li>
			              <li class="footer"><a href="#">View all</a></li>
			            </ul>
			          </li>
			          <!-- Tasks: style can be found in dropdown.less -->
			          <li class="dropdown tasks-menu">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <i class="fa fa-flag-o"></i>
			              <span class="label label-danger">9</span>
			            </a>
			            <ul class="dropdown-menu">
			              <li class="header">You have 9 tasks</li>
			              <li>
			                <!-- inner menu: contains the actual data -->
			                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 200px;"><ul class="menu" style="overflow: hidden; width: 100%; height: 200px;">
			                  <li><!-- Task item -->
			                    <a href="#">
			                      <h3>
			                        Design some buttons
			                        <small class="pull-right">20%</small>
			                      </h3>
			                      <div class="progress xs">
			                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
			                          <span class="sr-only">20% Complete</span>
			                        </div>
			                      </div>
			                    </a>
			                  </li>
			                  <!-- end task item -->
			                  <li><!-- Task item -->
			                    <a href="#">
			                      <h3>
			                        Create a nice theme
			                        <small class="pull-right">40%</small>
			                      </h3>
			                      <div class="progress xs">
			                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
			                          <span class="sr-only">40% Complete</span>
			                        </div>
			                      </div>
			                    </a>
			                  </li>
			                  <!-- end task item -->
			                  <li><!-- Task item -->
			                    <a href="#">
			                      <h3>
			                        Some task I need to do
			                        <small class="pull-right">60%</small>
			                      </h3>
			                      <div class="progress xs">
			                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
			                          <span class="sr-only">60% Complete</span>
			                        </div>
			                      </div>
			                    </a>
			                  </li>
			                  <!-- end task item -->
			                  <li><!-- Task item -->
			                    <a href="#">
			                      <h3>
			                        Make beautiful transitions
			                        <small class="pull-right">80%</small>
			                      </h3>
			                      <div class="progress xs">
			                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
			                          <span class="sr-only">80% Complete</span>
			                        </div>
			                      </div>
			                    </a>
			                  </li>
			                  <!-- end task item -->
			                </ul><div class="slimScrollBar" style="background: rgb(0, 0, 0) none repeat scroll 0% 0%; width: 3px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 1px;"></div><div class="slimScrollRail" style="width: 3px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 1px;"></div></div>
			              </li>
			              <li class="footer">
			                <a href="#">View all tasks</a>
			              </li>
			            </ul>
			          </li>
			          <!-- User Account: style can be found in dropdown.less -->
			          <li class="dropdown user user-menu">
			            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
			              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
			              <span class="hidden-xs">Alexander Pierce</span>
			            </a>
			            <ul class="dropdown-menu">
			              <!-- User image -->
			              <li class="user-header">
			                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

			                <p>
			                  Alexander Pierce - Web Developer
			                  <small>Member since Nov. 2012</small>
			                </p>
			              </li>
			              <!-- Menu Body -->
			              <li class="user-body">
			                <div class="row">
			                  <div class="col-xs-4 text-center">
			                    <a href="#">Followers</a>
			                  </div>
			                  <div class="col-xs-4 text-center">
			                    <a href="#">Sales</a>
			                  </div>
			                  <div class="col-xs-4 text-center">
			                    <a href="#">Friends</a>
			                  </div>
			                </div>
			                <!-- /.row -->
			              </li>
			              <!-- Menu Footer-->
			              <li class="user-footer">
			                <div class="pull-left">
			                  <a href="#" class="btn btn-default btn-flat">Profile</a>
			                </div>
			                <div class="pull-right">
			                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
			                </div>
			              </li>
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
<script src="bower_components/moment/moment.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="bower_components/angular-daterangepicker/js/angular-daterangepicker.js"></script>
<script src="js/app.js"></script>
<script src="js/service/route.js"></script>
<script src="js/service/ajax.js"></script>
<script src="js/service/authoService.js"></script>
<script src="js/service/dataService.js"></script>
<script src="js/controller/masterStudentsController.js"></script>
<script src="js/controller/masterRegistrationsController.js"></script>
<script src="js/controller/masterBatchesController.js"></script>
<script src="js/controller/masterPaymentsController.js"></script>
<script src="js/controller/reportIncomeController.js"></script>
<script src="js/controller/reportRegistrationsController.js"></script>
<script src="js/controller/reportBatchWiseController.js"></script>
<script src="js/controller/reportDuesController.js"></script>
<script src="js/controller/reportSearchController.js"></script>
<script src="js/vendor/FileSaver.js"></script>

</body>
</html>
