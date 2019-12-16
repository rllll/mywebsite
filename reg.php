<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户注册</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<script language="javascript">
	function check(f)
	{
		if (f.username.value == '')
		{
			alert("请输入注册用户名！");
			f.username.focus();
			return (false);
		}
		if (f.password_login.value == '')
		{
			alert("请设置登录密码！");
			f.password_login.focus();
			return (false);
		}
		if (f.password_confirm.value != f.password_login.value)
		{
			alert("重复密码与设置密码不一致！");
			f.password_confirm.focus();
			return (false);
		}
		if (f.phonenumber.value == '')
		{
			alert("请输入注册手机号！");
			f.phonenumber.focus();
			return (false);
		}
		if (f.email.value == '')
		{
			alert("请输入注册邮箱！");
			f.email.focus();
			return (false);
		}
		if (f.address.value == '')
		{
			alert("请输入收货地址！");
			f.address.focus();
			return (false);
		}
	}

</script>

<div class="container" style="margin-top: 100px">
<?php

if (!isset($_POST['username'])) {
	?>

<center><h2>用户信息注册</h2></center>

<form style="margin-top: 100px" method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return check(this)">
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">用户名</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="text" name="username" placeholder="创建用户名">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">密码</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="password" name="password_login" placeholder="设置密码">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">确认密码</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="password" name="password_confirm" placeholder="再次输入密码">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">手机号</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="text" name="phonenumber" placeholder="常用手机号">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">邮箱</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="email" name="email" placeholder="邮箱作为第二凭证">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-6 col-md-4">收货地址</label>
		<div class="col-sm-6 col-md-8">
			<input class="form-control" type="text" name="address" placeholder="常住地址，具体到县">
		</div>
	</div>
	<div class="row" style="margin-top: 70px">
		<div class="col-6">
			<center><input type="reset" class="btn btn-outline-warning btn-lg" value="重写"></center>
		</div>
		<div class="col-6">
			<center><input type="submit" class="btn btn-outline-success btn-lg" value="注册"></center>
		</div>
	</div>
</form>

<?php

} else {

	$username = $_POST["username"];
	$password = md5($_POST["password_login"]);
	$phonenumber = $_POST["phonenumber"];
	$email = $_POST["email"];
	$address = $_POST["address"];
	$time = date("Y年m月d日");
	include 'config.php';
	$sql = "SELECT * FROM $table_user WHERE username='$username'";
	$re = $mysqli->query($sql) or die($mysqli->error);
	if ($re->num_rows > 0) {
		echo "已经存在同名用户！<br>";
		echo "点<a href=reg.php>这里</a>注册新用户&nbsp;点<a href=reg.php>这里</a>登录";
	} else {
		$sql = "INSERT INTO $table_user(username,password,phonenumber,email,address,reg_date)
	VALUES('$username','$password','$phonenumber','$email','$address','$time')";
		$re = $mysqli->query($sql) or die($mysqli->error);
		if ($re) {
			echo "<center><h4 style='margin-top:20px'>";
			echo "成功注册用户：" . $username . "<br>";
			echo "点<a href=login.php>这里</a>登录";
			echo "</h4></center>";
		}
	}
}
?>

</div>


</body>
</html>

