@inject('app', 'App\Services\Manage\SidebarService')

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
            @include('manage.layouts.sidebar')
        </div>
    </div>
    <!-- left side end-->

    <!-- main content start-->
    <div class="main-content" >

        <!-- header section start-->
        <div class="header-section">
            <div class="menu-right">
                <ul class="notification-menu">
                    <li>
                        @if(config('app.locale') == 'en')
                            <a href="{{ route("language", ['locale' => 'zh-cn']) }}" class="btn btn-default dropdown-toggle">切换到中文</a>

                            @else

                            <a href="{{ route("language", ['locale' => 'en']) }}" class="btn btn-default dropdown-toggle">Change English</a>
                        @endif
                        |
                    </li>

                    <li>
                        <a href="#" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                            当前帐号:
                            {{ Auth::guard('manager')->user()['name'] }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                            <li><a href="{{ route('manage.logout') }}"><i class="fa fa-sign-out"></i>退出登录</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
        <!-- header section end-->

        <!--body wrapper start-->
        <div class="wrapper">

            {{--面包屑开始--}}
            <div class="row">
                <div class="col-md-12">
                    <!--breadcrumbs start -->
                    <ul class="breadcrumb panel">
                        <li><a href="/manage"><i class="fa fa-home"></i> {{ __('sidebar.主页') }}</a></li>

                        @if (!empty($parent_breadcrumb))
                            @foreach($breadcrumb = array_reverse($app->breadcrumb($parent_breadcrumb)) as $value)
                                <li navValue="nav_{{ $value['sidebar_id'] }}">{{  __('sidebar.'.$value['name']) }}</li>
                            @endforeach

                            @else

                            @foreach($breadcrumb = array_reverse($app->breadcrumb(Route::currentRouteName())) as $value)
                                <li navValue="nav_{{ $value['sidebar_id'] }}">{{  __('sidebar.'.$value['name']) }}</li>
                            @endforeach
                        @endif

                        @if(empty($breadcrumb))
                            <li navValue="nav_0">{{ __('sidebar.菜单管理') }}</li>
                        @endif
                    </ul>
                    <!--breadcrumbs end -->
                </div>
            </div>
            {{--面包屑结束--}}

            @section('body')

            @show
        </div>
        <!--body wrapper end-->

        <!--footer section start-->
        <footer>Copyright © 2015 - {{ date('Y') }} startce. All Rights Reserved  <strong>v3.0.0</strong></footer>
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

{{--自动打开菜单层级--}}
<script type="text/javascript">
    $(document).ready(function () {
        var num = $('.breadcrumb li').length;
        for (i=0; i<=num; i++) {
            var nav_value = $('.breadcrumb li:eq('+i+')').attr('navValue');
            $('#'+nav_value).addClass('active nav-active');
        }
    })
</script>
@show
</body>
</html>
