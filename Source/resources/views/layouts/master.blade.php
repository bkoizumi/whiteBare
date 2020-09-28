<?php
$user = \Auth::user();
$routeBaseParts = explode('\\', Route::current()->getActionName());
$routeBaseName = substr(strtolower(explode('@', end($routeBaseParts) )[0]), 0, -10);

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <title>{{trans($routeBaseName . '.sysName') .   ' | ' . trans('website.customerName')  .   ' | ' . trans('website.sysName') }}</title>

  <!-- Tell the browser to be responsive to screen width -->
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="/bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/dist/css/skins/_all-skins.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel="stylesheet" href="/dist/css/icon.css">
  <link rel="stylesheet" href="/dist/css/override.css">

@yield('style')

</head>
<body class="hold-transition skin-purple-light sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="/home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{trans('website.customerName-mini') }}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo">{{trans('website.customerName') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->

    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="/dist/img/icon_user.png" class="user-image" alt="User Image">
              <span class="hidden-xs">{{$user->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="/dist/img/icon_user.png" class="img-circle" alt="User Image">
                <p>{{$user->name}}
                  <small>{{trans('admin.authority' . '.' . $user->authority)}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>

        <li><a href="/home"><i class="fa fa-home"></i><span>{{trans('home.sysName') }}</span></a></li>
        <li><a href="/dashboard"><i class="fa fa-dashboard"></i><span>{{trans('dashboard.sysName') }}</span></a></li>
        <li><a href="/friends"><i class="fa fa-users"></i><span>{{trans('friends.sysName') }} </span></a></li>

        <li class="treeview">
          <a href="#"><i class="fa fa-target"></i><span>{{trans('target.sysName') }}</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
            <li><a href="/target"><i class="fa fa-list"></i>{{trans('target.path.index') }}</a></li>
            <li><a href="/target/create"><i class="fa fa-edit"></i>{{trans('target.path.create') }}</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-envelope"></i><span>{{trans('message.sysName')}}</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
            <li><a href="/message"><i class="fa fa-list"></i>{{trans('message.path.index') }}</a></li>
            <li><a href="/message/create"><i class="fa fa-edit"></i>{{trans('message.path.create') }}</a></li>
            <li><a href="/message/receive"><i class="fa fa-inbox"></i>{{trans('message.path.receive') }}</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-paper-plane-o"></i> <span>{{trans('keywords.sysName') }} </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
            <li><a href="/keywords"><i class="fa fa-list"></i>{{trans('keywords.path.index') }}</a></li>
            <li><a href="/keywords/create"><i class="fa fa-edit"></i>{{trans('keywords.path.create') }}</a></li>
          </ul>
        </li>

        <!-- イベント -->
        <li class="treeview">
          <a href="#"><i class="fa fa-fire"></i> <span>{{trans('event.sysName') }} </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
            <li><a href="/event"><i class="fa fa-list"></i>{{trans('event.path.index') }}</a></li>
            <li><a href="/event/create"><i class="fa fa-edit"></i>{{trans('event.path.create') }}</a></li>
          </ul>
        </li>

        <!-- 管理者 -->
        <li class="treeview">
          <a href="#"><i class="fa fa-cog"></i> <span>{{trans('admin.sysName') }} </span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
                <li><a href="/admin"><i class="fa fa-list"></i>{{trans('admin.path.index') }}</a></li>
                <li><a href="/admin/create"><i class="fa fa-user-plus"></i>{{trans('admin.path.create') }}</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa fa-cogs"></i> <span>{{trans('config.sysName') }}</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>
          <ul class="treeview-menu">
            <li><a href="/config"><i class="fa fa-cog"></i>{{trans('website.configuration_title') }}</a></li>
            <li><a href="/config"><i class="fa fa-account_configuration"></i><span>{{trans('website.account_configuration') }}</span></a></li>
            <li><a href="/bot"><i class="fa fa-bot_configuration"></i><span>{{trans('website.bot_configuration') }}</span></a></li>
            <li><a href="/reminder"><i class="fa fa-bot_configuration"></i><span>{{trans('website.bot_configuration') }}</span></a></li>
          </ul>
        </li>




      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  @yield("content")
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2017 B.Koizumi</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">

      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="/bower_components/fastclick/lib/fastclick.js"></script>
<script src="/dist/js/adminlte.min.js"></script>
<script src="/dist/js/demo.js"></script>

@yield('script')

</body>
</html>
