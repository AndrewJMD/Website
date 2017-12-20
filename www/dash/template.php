<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $PAGE_TITLE; ?> | CCDash</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo DASH; ?>libs/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  Theme style -->
  <link rel="stylesheet" href="<?php echo DASH; ?>css/admin.min.css">
  <link rel="stylesheet" href="<?php echo DASH; ?>css/skin-blue.min.css">

  <!-- Pace style -->
  <link rel="stylesheet" href="<?php echo DASH;?>libs/pace/pace.min.css">

  <style>
    a {
      cursor: pointer;
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo DASH;?>dashboard" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>CC</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CompCamps</b> Dash</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a onclick="" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a onclick="">
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
                </ul>
              </li>
              <li class="footer"><a onclick="">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a onclick="">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a onclick="">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a onclick="">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a onclick="">View all tasks</a>
              </li>
            </ul>
          </li>
          <li class="dropdown camps-menu">
            <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">2018, Week 1</span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a onclick="">
                      <p>
                        All Camps
                      </p>
                    </a>
                  </li>
                  <li><!-- Task item -->
                    <a onclick="">
                      <p>
                        2018, Week 1
                      </p>
                    </a>
                  </li>
                  <li><!-- Task item -->
                    <a onclick="">
                      <p>
                        2018, Week 2
                      </p>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a onclick="">View all camps</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a onclick="" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo $_SESSION['name']?></span>
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
                    <a onclick="">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a onclick="">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a onclick="">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a onclick="" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="process.php?f=signout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php include("includes/nav.php"); ?>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content-header">
      <h1 id='page_header'>
        <?php echo $PAGE_HEADER; ?>
      </h1>
      <!--<ol class="breadcrumb">
        <li><a onclick=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a onclick="">Examples</a></li>
        <li class="active">404 error</li>
      </ol>-->
    </section>
    <div id='page_content'>
      <?php OutputPage(); ?>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Active</b>
      <a target="_blank" href="https://github.com/CompCamps/Website/commit/<?php echo shell_exec("git log --pretty=format:'%H' -n 1"); ?>">
        <?php echo shell_exec("git log --pretty=format:'%h' -n 1"); ?>
      </a> on <a target="_blank" href="https://github.com/CompCamps/Website/tree/<?php echo shell_exec("git rev-parse --abbrev-ref HEAD"); ?>">
        <?php echo shell_exec("git rev-parse --abbrev-ref HEAD"); ?>
      </a>
    </div>
    <strong>CompCamps Dash</strong>
  </footer>
</div>
<!-- ./wrapper -->

<script>
  var PAGE_A = "<?php echo GetFromURL('a','dashboard'); ?>";
  var PAGE_B = "<?php echo GetFromURL('b',''); ?>";
  var PAGE_C = "<?php echo GetFromURL('c',''); ?>";
</script>

<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?php echo DASH; ?>libs/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo DASH; ?>libs/fastclick/fastclick.js"></script>
<!-- PACE -->
<script src="<?php echo DASH; ?>libs/pace/pace.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo DASH; ?>js/adminlte.min.js"></script>
<script src="<?php echo DASH; ?>js/dash.js"></script>

<script>
  Dash.Result = <?php echo json_encode((new ReflectionClass("Result"))->getConstants()); ?>;
  Dash.Level =  <?php echo json_encode((new ReflectionClass("Level"))->getConstants()); ?>;
  Dash.DASH = "<?php echo DASH; ?>";
  Dash.ROOT = "<?php echo ROOT; ?>";
  Dash.Campers =  {
    Filter: <?php echo json_encode((new ReflectionClass("CampersFilter"))->getConstants()); ?>
  }
</script>

<script src="<?php echo DASH; ?>js/main.js"></script>

<?php include(DROOT."dash/includes/scripts.php"); ?>

<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  })
</script>
</body>
</html>
