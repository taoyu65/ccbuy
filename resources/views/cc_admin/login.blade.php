<!DOCTYPE html>
<html>	
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">

<link href='{{url("cc_admin/css/style.css")}}' rel='stylesheet' type='text/css'>
<style>
	.switch {
		position: relative;
		margin: 20px auto;
		height: 26px;
		width: 120px;
		background: rgba(0, 0, 0, 0.25);
		border-radius: 3px;
		-webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
		box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
	}

	.switch-label {
		position: relative;
		z-index: 2;
		float: left;
		width: 58px;
		line-height: 26px;
		font-size: 11px;
		color: rgba(255, 255, 255, 0.35);
		text-align: center;
		text-shadow: 0 1px 1px rgba(0, 0, 0, 0.45);
		cursor: pointer;
	}
	.switch-label:active {
		font-weight: bold;
	}

	.switch-label-off {
		padding-left: 2px;
	}

	.switch-label-on {
		padding-right: 2px;
	}

	/*
     * Note: using adjacent or general sibling selectors combined with
     *       pseudo classes doesn't work in Safari 5.0 and Chrome 12.
     *       See this article for more info and a potential fix:
     *       http://css-tricks.com/webkit-sibling-bug/
     */
	.switch-input {
		display: none;
	}
	.switch-input:checked + .switch-label {
		font-weight: bold;
		color: rgba(0, 0, 0, 0.65);
		text-shadow: 0 1px rgba(255, 255, 255, 0.25);
		-webkit-transition: 0.15s ease-out;
		-moz-transition: 0.15s ease-out;
		-o-transition: 0.15s ease-out;
		transition: 0.15s ease-out;
	}
	.switch-input:checked + .switch-label-on ~ .switch-selection {
		left: 60px;
		/* Note: left: 50% doesn't transition in WebKit */
	}

	.switch-selection {
		display: block;
		position: absolute;
		z-index: 1;
		top: 2px;
		left: 2px;
		width: 58px;
		height: 22px;
		background: #65bd63;
		border-radius: 3px;
		background-image: -webkit-linear-gradient(top, #9dd993, #65bd63);
		background-image: -moz-linear-gradient(top, #9dd993, #65bd63);
		background-image: -o-linear-gradient(top, #9dd993, #65bd63);
		background-image: linear-gradient(to bottom, #9dd993, #65bd63);
		-webkit-box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
		box-shadow: inset 0 1px rgba(255, 255, 255, 0.5), 0 0 2px rgba(0, 0, 0, 0.2);
		-webkit-transition: left 0.15s ease-out;
		-moz-transition: left 0.15s ease-out;
		-o-transition: left 0.15s ease-out;
		transition: left 0.15s ease-out;
	}
	.switch-blue .switch-selection {
		background: #3aa2d0;
		background-image: -webkit-linear-gradient(top, #4fc9ee, #3aa2d0);
		background-image: -moz-linear-gradient(top, #4fc9ee, #3aa2d0);
		background-image: -o-linear-gradient(top, #4fc9ee, #3aa2d0);
		background-image: linear-gradient(to bottom, #4fc9ee, #3aa2d0);
	}
	.switch-yellow .switch-selection {
		background: #c4bb61;
		background-image: -webkit-linear-gradient(top, #e0dd94, #c4bb61);
		background-image: -moz-linear-gradient(top, #e0dd94, #c4bb61);
		background-image: -o-linear-gradient(top, #e0dd94, #c4bb61);
		background-image: linear-gradient(to bottom, #e0dd94, #c4bb61);
	}
</style>

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
			<input type="radio" class="switch-input" name="view" value="0" id="nopay" checked onclick="location.href='{{url("type/user")}}'">
			<label for="nopay" class="switch-label switch-label-off">{{trans('cc_admin_login.no')}}</label>
			<input type="radio" class="switch-input" name="view" value="1" id="yespay"  onclick="location.href='{{url("type/demo")}}'">
			<label for="yespay" class="switch-label switch-label-on">{{trans('cc_admin_login.yes')}}</label>
			<span class="switch-selection"></span>
			@else
				<input type="radio" class="switch-input" name="view" value="0" id="nopay"  onclick="location.href='{{url("type/user")}}'">
				<label for="nopay" class="switch-label switch-label-off">{{trans('cc_admin_login.no')}}</label>
				<input type="radio" class="switch-input" name="view" value="1" id="yespay" checked onclick="location.href='{{url("type/demo")}}'">
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