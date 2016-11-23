
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
    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>

    <link type="image/x-icon" href='{{url("cc_admin/images/cc.ico")}}' rel="shortcut icon" >
    <link href='{{url("cc_admin/images/cc.ico")}}' rel="bookmark icon" >
</head>

<body>
{{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
<div class="lefter">
    <div class="logo">
        <a href="#"><img src='{{url("cc_admin/images/logo.png")}}' alt="后台管理系统" ></a>
    </div>
</div>
<div class="righter nav-navicon" id="admin-nav">
    <div class="mainer">
        <div class="admin-navbar">
            <span class="float-right">
                <a class="button button-little bg-main" href='{{url('firstpage')}}' target="_blank">前台首页</a>
                <a class="button button-little bg-yellow" href="{{url('cc_admin/logout')}}">注销登录</a>
            </span>
            <ul class="nav nav-inline admin-nav">
                <li id="li_main">
                    <a href='{{url("cc_admin/main")}}' class="icon-home"> 开始</a>
                    <ul>
                        <li id="li_main_system"><a href='#'>系统设置</a></li>
                        <li id="li_main_content"><a href="#">内容管理</a></li>
                        <li><a href="#">订单管理</a></li>
                        <li><a href="#">会员管理</a></li>
                        <li><a href="#">文件管理</a></li>
                        <li><a href="#">栏目管理</a></li>
                    </ul>
                </li>
                <li id="li_system">
                    <a href='{{url("cc_admin/system")}}' class="icon-cog"> 系统</a>
                    <ul>
                        <li id="li_system_setup"><a href="#">订单结算</a></li>
                    </ul>
                </li>
                <li id="li_table">
                    <a href='{{url("cc_admin/table/items")}}' class="icon-file-text"> 数据</a>
                    <ul>
                        <li id="li_table_carts"><a href='{{url("cc_admin/table/carts")}}'>订单管理</a></li>
                        <li id="li_table_customs"><a href='{{url("cc_admin/table/customs")}}'>客户管理</a></li>
                        <li id="li_table_incomes"><a href='{{url("cc_admin/table/incomes")}}'>收入管理</a></li>
                        <li id="li_table_items"><a href='{{url("cc_admin/table/items")}}'>物品管理</a></li>
                        <li id="li_table_stores"><a href='{{url("cc_admin/table/stores")}}'>商店管理</a></li>
                        <li id="li_table_users"><a href='{{url("cc_admin/table/users")}}'>登录管理</a></li>
                    </ul>
                </li>
                <li><a href="#" class="icon-shopping-cart">待定</a></li>
                <li><a href="#" class="icon-user"> 待定</a></li>
                <li><a href="#" class="icon-file"> 待定</a></li>
                <li><a href="#" class="icon-th-list"> 待定</a></li>
            </ul>
        </div>
        <div class="admin-bread">
            <span>您好，{{Auth::user()->name}}，欢迎您的光临。</span>
            <ul class="bread">
                <li>{{--<a href="index.html" class="icon-home"> 开始</a>--}}</li>
                <li>{{--后台首页--}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="admin">
    @yield('content1')
    <br>
    <p class="text-right text-gray">基于<a class="text-gray" target="_blank" href="http://www.pintuer.com">拼图前端框架</a>构建</p>
</div>
</body>

</html>