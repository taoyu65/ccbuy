
<!--
/**
 * Created by PhpStorm.
 * User: TAO YU
 * Date: 9/3/2016
 * Time: 6:02 PM
 */ -->

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="Keywords" content="">
    <meta name="Description" content="">

    <!-- 移动设备支持 -->
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="no-cache,must-revalidate" http-equiv="Cache-Control">
    <meta content="no-cache" http-equiv="pragma">
    <meta content="0" http-equiv="expires">
    <meta content="telephone=no, address=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <!--手机端重置样式-->
    <link href='{{url("css/mod88.css")}}' rel="stylesheet" type="text/css">
    <link rel="stylesheet" href='{{url("css/jquery.toastmessage.css")}}'>
    <!--微网站模板88样式-->
    {{--<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>--}}
    <script type="text/javascript" src='{{url("js/jquery-1.8.3.mini.js")}}'></script>
    <script type="text/javascript" src='{{url("js/jquery.toastmessage.js")}}'></script>
    <script type="text/javascript" src='{{url("ui/bootstrap-mini/bootstrap.min.js")}}'></script>
    <link type="text/css" rel="stylesheet" href='{{url("ui/bootstrap-mini/bootstrap.min.css")}}'>
    <script src='{{url("cc_admin/js/pintuer.js")}}' type="text/javascript"></script>
    <link rel="stylesheet" href='{{url("cc_admin/css/pintuer.css")}}'>
</head>

<body>
@include('language')

<div id="wrap" class="clr">
    <!--<div class="telphone"><img src="/www/images/tel.png"></div>-->
    <div class="navfoot"> <a href="{{ url('firstpage') }}">
            <div class="menu i01"  >{{trans('foot.tab1')}}</div>
        </a> <a href="{{url('collecting')}}" >
            <div class="menu i02"  >{{trans('foot.tab2')}}</div>
        </a> <a href="{{url('statistics/2016/profits')}}" >
            <div class="menu i03"  >{{trans('foot.tab3')}}</div>
        </a> <a href="{{url('cc_admin/table/items')}}" >
            <div class="menu i04"  >{{trans('foot.tab4')}}</div>
        </a>
    </div>

    @yield('content')


</div>
</body>
</html>
