
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" >
    <meta name="renderer" content="webkit">
    <title>ccBuy-{{trans('cc_admin/ccadmin.back')}}</title>
    <link rel="stylesheet" href='{{url("cc_admin/css/pintuer.css")}}'>
    <link rel="stylesheet" href='{{url("cc_admin/css/admin.css")}}'>
    <script src='{{url("js/jquery-1.8.3.mini.js")}}' type="text/javascript"></script>
    <script src='{{url("cc_admin/js/pintuer.js")}}' type="text/javascript"></script>
    <script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>

    <link type="image/x-icon" href='{{url("cc_admin/images/cc.ico")}}' rel="shortcut icon" >
    <link href='{{url("cc_admin/images/cc.ico")}}' rel="bookmark icon" >
    <script>
        function setLanguage(lang) {
            location.href='{{url('setLanguage/')}}/' + lang;
        }
    </script>
</head>

<body>
{{--<input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
<div class="lefter">
    <div class="logo">
        <a href="#"><img src='{{url("cc_admin/images/logo.png")}}' alt="{{trans('cc_admin/ccadmin.backSystem')}}" ></a>
    </div>
</div>
<div class="righter nav-navicon" id="admin-nav">
    <div class="mainer">
        <div class="admin-navbar">
            <span class="float-right">Click to Change Language (点击切换语言)
                <img src="{{url('images/lang.en.png')}}" onclick="setLanguage('en');" style="cursor: pointer;">  <img src="{{url('images/lang.zh.png')}}" onclick="setLanguage('zh_cn');" style="cursor: pointer">
                <a class="button button-little bg-main" href='{{url('firstpage')}}' target="_blank">{{trans('cc_admin/ccadmin.front')}}</a>
                <a class="button button-little bg-yellow" href="{{url('cc_admin/logout')}}">{{trans('cc_admin/ccadmin.logout')}}</a>
            </span>
            <ul class="nav nav-inline admin-nav">
                <li id="li_main">
                    <a href='{{url("cc_admin/main")}}' class="icon-home"> {{trans('cc_admin/ccadmin.star')}}</a>
                    <ul>
                        <li id="li_main_system"><a href='#'>{{trans('cc_admin/ccadmin.system')}}</a></li>
                        <li id="li_main_content"><a href="#">{{trans('cc_admin/ccadmin.content')}}</a></li>
                        <li><a href="#">{{trans('cc_admin/ccadmin.orders')}}</a></li>
                        <li><a href="#">{{trans('cc_admin/ccadmin.member')}}</a></li>
                        <li><a href="#">{{trans('cc_admin/ccadmin.files')}}</a></li>
                        <li><a href="#">{{trans('cc_admin/ccadmin.tabs')}}</a></li>
                    </ul>
                </li>
                <li id="li_system">
                    <a href='{{url("cc_admin/system")}}' class="icon-cog"> {{trans('cc_admin/ccadmin.system2')}}</a>
                    <ul>
                        <li id="li_system_setup"><a href="#">{{trans('cc_admin/ccadmin.orderClose')}}</a></li>
                    </ul>
                </li>
                <li id="li_table">
                    <a href='{{url("cc_admin/table/items")}}' class="icon-file-text">{{trans('cc_admin/ccadmin.data')}} </a>
                    <ul>
                        <li id="li_table_carts"><a href='{{url("cc_admin/table/carts")}}'>{{trans('cc_admin/ccadmin.orderManage')}}</a></li>
                        <li id="li_table_customs"><a href='{{url("cc_admin/table/customs")}}'>{{trans('cc_admin/ccadmin.memberManage')}}</a></li>
                        <li id="li_table_incomes"><a href='{{url("cc_admin/table/incomes")}}'>{{trans('cc_admin/ccadmin.incomeManage')}}</a></li>
                        <li id="li_table_items"><a href='{{url("cc_admin/table/items")}}'>{{trans('cc_admin/ccadmin.itemManage')}}</a></li>
                        <li id="li_table_stores"><a href='{{url("cc_admin/table/stores")}}'>{{trans('cc_admin/ccadmin.storeManage')}}</a></li>
                        <li id="li_table_users"><a href='{{url("cc_admin/table/users")}}'>{{trans('cc_admin/ccadmin.logInManage')}}</a></li>
                    </ul>
                </li>
                <li><a href="#" class="icon-shopping-cart">{{trans('cc_admin/ccadmin.none')}}</a></li>
                <li><a href="#" class="icon-user"> {{trans('cc_admin/ccadmin.none')}}</a></li>
                <li><a href="#" class="icon-file"> {{trans('cc_admin/ccadmin.none')}}</a></li>
                <li><a href="#" class="icon-th-list"> {{trans('cc_admin/ccadmin.none')}}</a></li>
            </ul>
        </div>
        <div class="admin-bread">
            <span>{{trans('cc_admin/ccadmin.hello')}}，{{Auth::user()->name}}，{{trans('cc_admin/ccadmin.welcome')}}。</span>
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
    <p class="text-right text-gray">{{trans('cc_admin/ccadmin.baseOn')}}<a class="text-gray" target="_blank" href="http://www.pintuer.com">{{trans('cc_admin/ccadmin.pt')}}</a></p>
</div>
</body>

</html>