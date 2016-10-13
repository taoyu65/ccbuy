
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="renderer" content="webkit">
    <title>ccBuy-后台管理</title>
    <link rel="stylesheet" href='{{url("cc_admin/css/pintuer.css")}}'>
    <link rel="stylesheet" href='{{url("cc_admin/css/admin.css")}}'>
    <script src='{{url("js/jquery-1.8.3.mini.js")}}' type="text/javascript"></script>
    <script src='{{url("cc_admin/js/pintuer.js")}}' type="text/javascript"></script>

    <link type="image/x-icon" href='{{url("cc_admin/images/cc.ico")}}' rel="shortcut icon" >
    <link href='{{url("cc_admin/images/cc.ico")}}' rel="bookmark icon" >
</head>

<body>
{{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
<div class="lefter">
    <div class="logo">
        <a href="#" target="_blank"><img src='{{url("cc_admin/images/logo.png")}}' alt="后台管理系统" ></a>
    </div>
</div>
<div class="righter nav-navicon" id="admin-nav">
    <div class="mainer">
        <div class="admin-navbar">
            <span class="float-right">
                <a class="button button-little bg-main" href="#" target="_blank">前台首页</a>
                <a class="button button-little bg-yellow" href="#">注销登录</a>
            </span>
            <ul class="nav nav-inline admin-nav">
                <li id="li_main">
                    <a href="index.html" class="icon-home"> 开始</a>
                    <ul>
                        <li id="li_main_system"><a href="system.html">系统设置</a></li>
                        <li id="li_main_content"><a href="content.html">内容管理</a></li>
                        <li><a href="#">订单管理</a></li>
                        <li><a href="#">会员管理</a></li>
                        <li><a href="#">文件管理</a></li>
                        <li><a href="#">栏目管理</a></li>
                    </ul>
                </li>
                <li id="li_system">
                    <a href="system.html" class="icon-cog"> 系统</a>
                    <ul>
                        <li><a href="#">全局设置</a></li>
                        <li class="active"><a href="#">系统设置</a></li>
                        <li><a href="#">会员设置</a></li>
                        <li><a href="#">积分设置</a></li>
                    </ul>
                </li>
                <li>
                    <a href="content.html" class="icon-file-text"> 数据</a>
                    <ul>
                        <li><a href="#">添加内容</a></li>
                        <li class="active"><a href="#">内容管理</a></li>
                        <li><a href="#">分类设置</a></li>
                        <li><a href="#">链接管理</a></li>
                    </ul>
                </li>
                <li><a href="#" class="icon-shopping-cart">待定</a></li>
                <li><a href="#" class="icon-user"> 待定</a></li>
                <li><a href="#" class="icon-file"> 待定</a></li>
                <li><a href="#" class="icon-th-list"> 待定</a></li>
            </ul>
        </div>
        <div class="admin-bread">
            <span>您好，admin，欢迎您的光临。</span>
            <ul class="bread">
                <li>{{--<a href="index.html" class="icon-home"> 开始</a>--}}</li>
                <li>{{--后台首页--}}</li>
            </ul>
        </div>
    </div>
</div>
@yield('content1')
</body>

</html>