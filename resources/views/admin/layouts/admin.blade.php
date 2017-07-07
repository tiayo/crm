<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="keywords" content="admin, dashboard, bootstrap, template, flat, modern, theme, responsive, fluid, retina, backend, html5, css, css3">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Manage</title>
    @section('style')
        <!--icheck-->
        <link href="/static/adminex/js/iCheck/skins/minimal/minimal.css" rel="stylesheet">
        <link href="/static/adminex/js/iCheck/skins/square/square.css" rel="stylesheet">
        <link href="/static/adminex/js/iCheck/skins/square/red.css" rel="stylesheet">
        <link href="/static/adminex/js/iCheck/skins/square/blue.css" rel="stylesheet">
        <!--common-->
        <link href="/static/adminex/css/style.css" rel="stylesheet">
        <link href="/static/adminex/css/style-responsive.css" rel="stylesheet">
    @show

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="/static/adminex/js/html5shiv.js"></script>
  <script src="/static/adminex/js/respond.min.js"></script>
  <![endif]-->
</head>

<body class="sticky-header">

<section>
    <!-- left side start-->
    <div class="left-side sticky-left-side">

        <!--logo and iconic logo start-->
        <div class="logo">
            <img style="width:200px" src="http://www.startce.com/skin/zd/images/logo_2.png" alt="">
            <a href="index.html"></a>
        </div>

        <div class="logo-icon text-center">
            <a href="index.html"></a>
        </div>
        <!--logo and iconic logo end-->
        <div class="left-side-inner">

            <!--sidebar nav start-->
            <ul style="margin-top:100px;" class="nav nav-pills nav-stacked custom-nav">

                <li class="menu-list"><a href=""><i class="fa fa-search"></i> <span>插件系统</span></a>
                    <ul class="sub-menu-list">
                        <li><a href="{{ Route('admin_plugins_add') }}">添加插件</a></li>
                        <li><a href="{{ Route('home_plugins') }}">前台插件</a></li>
                        <li><a href="{{ Route('admin_plugins') }}">后台插件</a></li>
                    </ul>
                </li>

            </ul>
            <!--sidebar nav end-->

        </div>
    </div>
    <!-- left side end-->

    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">
            <div class="col-md-10">
                <!--toggle button start-->
                <a class="toggle-btn"><i class="fa fa-bars"></i></a>
                <if condition="can('status', [session('user.id') ? : 0])">
                    <a class="pull-right" style="line-height: 50px;" href="{{ Route('admin.logout') }}">退出登录</a>
                </if>
                <!--toggle button end-->
            </div>
        </div>
        <!-- header section end-->

        <!--body wrapper start-->
        <div class="wrapper">
            @section('breadcrumb')

            @show

            @section('body')

            @show
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer>Copyright © 2015 - 2017 startce. All Rights Reserved  <strong>v0.01</strong></footer>
        <!--footer section end-->


    </div>
    <!-- main content end-->
</section>

@section('script')
<!-- Placed js at the end of the document so the pages load faster -->
<script src="/static/adminex/js/jquery-1.10.2.min.js"></script>
<script src="/static/adminex/js/jquery-ui-1.9.2.custom.min.js"></script>
<script src="/static/adminex/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/static/adminex/js/bootstrap.min.js"></script>
<script src="/static/adminex/js/modernizr.min.js"></script>
<script src="/static/adminex/js/jquery.nicescroll.js"></script>

<!--icheck -->
<script src="/static/adminex/js/iCheck/jquery.icheck.js"></script>
<script src="/static/adminex/js/icheck-init.js"></script>


<!--common scripts for all pages-->
<script src="/static/adminex/js/scripts.js"></script>
@show
</body>
</html>
