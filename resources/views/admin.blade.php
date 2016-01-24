<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} | Dashboard</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Morris chart -->
    <link href="/assets/admin/css/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <!-- jvectormap -->
    <link href="/assets/admin/css/plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker -->
    <link href="/assets/admin/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/assets/admin/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="/assets/admin/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="skin-blue">
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="/admin/dashboard" class="logo"><b>Admin</b>LTE</a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

              <li class="dropdown user user-menu">
               <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                   <i class="glyphicon glyphicon-user"></i>
                   <span>{{ Auth::admin()->user()->name }} <i class="caret"></i></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="/assets/admin/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                    <p>
                      {{ Auth::admin()->user()->name }}
                    </p>
                  </li>

                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="/admin/admins/edit/{{ Auth::admin()->user()->id }}" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="/admin/auth/logout" class="btn btn-default btn-flat">Sign out</a>
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
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="active">
                <a>
                    <i class="fa fa-cogs"></i>
                    <span>Admin</span>
                </a>
                <ul class="treeview-menu" style="display: block;">
                    <li><a href="/admin/users"><i class="fa fa-group"></i> Users</a></li>
                    <li><a href="/admin/admins"><i class="fa fa-user"></i>Admins</a></li>
                    <li><a href="/admin/achievements"><i class="fa fa-th"></i>Achievements</a></li>
                    <li><a href="/admin/cards"><i class="fa fa-picture-o"></i>Cards</a></li>
                    <li><a href="/admin/awards"><i class="fa fa-trophy"></i>Gears</a></li>
                </ul>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            @yield('title')
            <small>@yield('subtitle')</small>
        </h1>
        @yield('breadcrumbs')
        {{ notification() }}
    </section>

        <!-- Main content -->
          @yield('content')
        <!-- /.content -->


      </div><!-- /.content-wrapper -->


    </div><!-- ./wrapper -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='/assets/admin/css/plugins/fastclick/fastclick.min.js'></script>

    <script src="/assets/admin/js/jquery-upload/js/vendor/jquery.ui.widget.js"></script>
    <script src="/assets/admin/js/jquery-upload/js/jquery.iframe-transport.js"></script>
    <script src="/assets/admin/js/jquery-upload/js/jquery.fileupload.js"></script>

    <script src="/assets/admin/js/app.js" type="text/javascript"></script>
  </body>
</html>