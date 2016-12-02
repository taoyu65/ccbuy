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
<h1>ccBuy Admin</h1>
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
		<input type="text" name="name" class="text" value="Username" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Username';}" >
		<div class="key">
			<input type="password" name="password" value="123123" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '123123';}">
		</div>
		<div class="signin">
			<input type="submit" value="log in" >
		</div>
	</form>
</div>
<div class="copy-rights">
	<p>Copyright &copy; 2015.Company name All rights reserved.More Templates <a href="http://www.cssmoban.com/" target="_blank" title="模板之家">模板之家</a> - Collect from <a href="http://www.cssmoban.com/" title="网页模板" target="_blank">网页模板</a></p>
</div>

</body>
</html>