<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="ThemeBucket">
    <link rel="shortcut icon" href="#" type="image/png">

    <title>Login</title>

    <link href="/static/adminex/css/style.css" rel="stylesheet">
    <link href="/static/adminex/css/style-responsive.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/static/adminex/js/html5shiv.js"></script>
    <script src="/static/adminex/js/respond.min.js"></script>
    <![endif]-->
</head>

<body class="login-body">

<div class="container">

    <div class="form-signin" action="index.html">
        <div class="form-signin-heading text-center">
            <h1 class="sign-title">{{ __("title.平台商管理登录") }}</h1>
            <img src="/style/media/image/logo.png" width="70%" alt=""/>
        </div>
        <div class="login-wrap">
            <form method="post" action="{{ route('manage.login') }}">
                {{ csrf_field() }}
                <input type="text" class="form-control" placeholder="输入用户名" autofocus name="name" value="{{ $old_input['name'] }}" required>
                <input type="password" class="form-control" placeholder="密码" name="password" required>
                <input class="form-control" type="text" placeholder="验证码" name="code" required>
                <img  height="40" style="margin-bottom: 1em;" alt="验证码" title="点击刷新" src="{{ route('captcha', ['group' => 'login']) }}" onclick="javascript:this.src=this.src+'?time='+Math.random()">
                <!--错误输出-->
                <div class="form-group">
                    <div class="alert alert-danger fade in @if(!count($errors) > 0) hidden @endif" id="alert_error">
                        <a href="#" class="close" data-dismiss="alert">×</a>
                        <span>
                            @foreach($errors->all() as $error)
                               {{ $error }}
                            @endforeach
                        </span>
                    </div>
                </div>
                <button class="btn btn-lg btn-login btn-block" type="submit">
                    <i class="fa fa-check"></i>
                </button>
            </form>
            <div class="registration">
                还没有帐号?
                <a class="" href="/manage/register">
                    注册
                </a>
                |
                切换语言：
                @if(config('app.locale') == 'en')
                        <a href="{{ route("language", ['locale' => 'zh-cn']) }}">中文</a>
                        @else
                        <a href="{{ route("language", ['locale' => 'en']) }}">英文</a>
                @endif
            </div>
        </div>
    </div>

</div>



<!-- Placed js at the end of the document so the pages load faster -->

<!-- Placed js at the end of the document so the pages load faster -->
<script src="/static/adminex/js/jquery-1.10.2.min.js"></script>
<script src="/static/adminex/js/bootstrap.min.js"></script>
</body>
</html>
