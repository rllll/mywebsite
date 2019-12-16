<?php
if (isset($_POST['username'])) {
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	include "config.php";
	$sql = "SELECT * FROM $table_user WHERE username='$username' AND password='$password'";
	$re = $mysqli->query($sql) or die($mysqli->error());
	$info = $re->fetch_assoc();
	if ($re->num_rows > 0) {
		if (isset($_POST['remember'])) {
			setcookie("login", $username, time() + 3600 * 3, '/');
		} else {
			setcookie("login", $username, time() + 600, '/');
		}
		echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
		echo "<center><h4 style='margin-top:20px'>成功登录！</h4></center>";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"2; url=login.php\">";
		echo "<center><h4 style='margin-top:20px'>登录失败！</h4></center>";
	}
} else {
	?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>用户登录</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>
<script type="text/javascript">
	function check(f)
	{
		if (f.username.value == '')
		{
			alert("请输入登录用户名！");
			f.username.focus();
			return (false);
		}
		if (f.password.value == '')
		{
			alert("请输入登录密码！");
			f.password.focus();
			return (false);
		}
	}
</script>

<div class="container" style="margin-top: 150px">

 <center><h2>用户登录</h2></center>

 <form style="margin-top: 120px" method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return check(this)">
 	<div class="form-group row">
 		<div class="col-sm-6 col-md-4 text-center">
 			<label>用户名：</label>
 		</div>
		<div class="col-sm-6 col-md-8">
			<input type="text" name="username" class="form-control">
		</div>
 	</div>
 	<div class="form-group row">
 		<div class="col-sm-6 col-md-4 text-center">
 			<label>密码：</label>
 		</div>
		<div class="col-sm-6 col-md-8">
			<input type="password" name="password" class="form-control">
		</div>

 	</div>
 	<div class="row" style="margin-top: 50px">
 		<div class="col-sm-6 col-md-4 text-center">
 			<label><input type="checkbox" name="remember" value="yes">记住账号</label>
 		</div>
 		<div class="col-sm-6 col-md-8 text-right">
 			<input type="submit" class="btn btn-success" value="登录">
 		</div>
 	</div>
 </form>

</div>

</body>
</html>
<?php
}?>
