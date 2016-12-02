<!DOCTYPE html>
<html>	
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

<link href='{{url("cc_admin/css/style.css")}}' rel='stylesheet' type='text/css'>

</head>
<body>

<!--SIGN UP-->
<h1>{{trans('cc_admin_login.title')}}</h1>
<!--if login failed then show message -->
@if(isset($error))
	{!! $error !!}
@endif
<div class="login-form">
	<div class="close" onclick="location.href = '{{url("/")}}'"> </div>
	<div class="head-info">
		<label class="lbl-1"> </label>
		<label class="lbl-2"> </label>
		<label class="lbl-3"> </label>
	</div>
	<div class="clear"> </div>
	<div class="avtar">
		<img src='{{url("cc_admin/images/avtar.png")}}'>
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