<!DOCTYPE html>
<html>	
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<script type="text/javascript" src='{{url("js/jquery-1.8.3.mini.js")}}'></script>
<script type="text/javascript" src='{{url("ui/layer/layer.js")}}'></script>
<link href='{{url("cc_admin/css/style.css")}}' rel='stylesheet' type='text/css'>
<link href='{{url("css/radio.css")}}' rel='stylesheet' type='text/css'>
<script>
	function setDatabase(url) {
		var index = layer.load(0, {shade: 0.5}); //0代表加载的风格，支持0-2
		location.href=url;
	}
</script>
</head>
<body>

<!--SIGN UP-->
<h1>{{trans('cc_admin_login.title')}}</h1>
<!--if login failed then show message -->
@if(isset($error))
	{!! $error !!}
@endif

<div class="login-form">
	<div class="close"> </div>

	<div class="head-info">
		<label class="lbl-1"> </label>
		<label class="lbl-2"> </label>
		<label class="lbl-3"> </label>
	</div>
	<div class="clear"> </div>
	<div class="avtar">
		<img src='{{url("cc_admin/images/avtar.png")}}'>
		<div class="switch">
			@if(!isset($_REQUEST['t']) || $_REQUEST['t'] != 'demo')
			<input type="radio" class="switch-input" name="view" value="0" id="nopay" checked onclick="setDatabase('{{url("type/user")}}')">
			<label for="nopay" class="switch-label switch-label-off">{{trans('cc_admin_login.no')}}</label>
			<input type="radio" class="switch-input" name="view" value="1" id="yespay"  onclick="setDatabase('{{url("type/demo")}}')">
			<label for="yespay" class="switch-label switch-label-on">{{trans('cc_admin_login.yes')}}</label>
			<span class="switch-selection"></span>
			@else
				<input type="radio" class="switch-input" name="view" value="0" id="nopay"  onclick="setDatabase('{{url("type/user")}}')">
				<label for="nopay" class="switch-label switch-label-off">{{trans('cc_admin_login.no')}}</label>
				<input type="radio" class="switch-input" name="view" value="1" id="yespay" checked onclick="setDatabase('{{url("type/demo")}}')">
				<label for="yespay" class="switch-label switch-label-on">{{trans('cc_admin_login.yes')}}</label>
				<span class="switch-selection"></span>
			@endif
		</div>
	</div>
	<form method="post" action="{{url('cc_admin/submit')}}">
		{!! csrf_field() !!}
		<input type="text" name="name" class="text" value="{{trans('cc_admin_login.username')}}" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '{{trans('cc_admin_login.username')}}';}" >
		<div class="key">
			<input type="password" name="password" value="123123" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '123123';}">
		</div>

		<div class="signin">
			<input type="submit" value="log in" >
		</div>
	</form>
</div>

<div class="copy-rights">
	<p>Copyright &copy; 2015.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="{{trans('cc_admin_login.mbzj')}}">{{trans('cc_admin_login.mbzj')}}</a> - Collect from
		<a href="http://www.cssmoban.com/" title="{{trans('cc_admin_login.wymb')}}" target="_blank">{{trans('cc_admin_login.wymb')}}</a></p>
</div>
@include('language')
</body>
</html>