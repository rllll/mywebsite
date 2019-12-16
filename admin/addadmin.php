<?php

if (!isset($_COOKIE['login']) or $_COOKIE['login'] == '') {
	echo "<center>";
	echo "<h4 style='margin-top:20px'>没有登录或登录有效期已过！请重新<a href='../login.php'>登录</a></h4>";
	echo "</center>";
} else {
	include "../config.php";
	$username = $_COOKIE['login'];
	$sql = "SELECT * FROM $table_user WHERE username='$username'";
	$result = $mysqli->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if ($info['admin'] == 0) {
			echo "<center>";
			echo "<h4 style='margin-top:20px'>您不是管理员用户，不能查看此页面！</h4>";
			echo "</center>";
		} else {
			if (isset($_POST['username'])) {
				$username = $_POST["username"];
				$password = md5($_POST["password_login"]);
				$phonenumber = $_POST["phonenumber"];
				$email = $_POST["email"];
				$address = $_POST["address"];
				$time = date("Y年m月d日");
				$sql = "SELECT * FROM $table_user WHERE username='$username'";
				$re = $mysqli->query($sql) or die($mysqli->error);
				echo "<center><h4 style='margin-top:20px'>";
				if ($re->num_rows > 0) {
					echo "<meta http-equiv='refresh' content='2;url='addadmin.php'>";
					echo "名称已经被使用，请再想一个独一无二的名字-_-！（2秒后返回）";
				} else {
					$sql = "INSERT INTO $table_user(username,password,phonenumber,email,address,reg_date) VALUES('$username','$password','$phonenumber','$email','$address','$time')";
					$re = $mysqli->query($sql) or die($mysqli->error);
					if ($re) {
						echo "成功注册管理员用户：" . $username . "<br>";
						echo "<meta http-equiv='refresh' content='2;url='addadmin.php'>";
					}
				}
				echo "</h4></center>";
			} else {

				?>




<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>添加管理员</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
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
			alert("请输入所在地！");
			f.address.focus();
			return (false);
		}
	}

	</script>
</head>
<body>

<!-- 导航栏 -->

<nav class="navbar navbar-expand-sm bg-info navbar-dark fixed-top">
  <!-- LOGO -->
  <a class="navbar-brand font-weight-bold" href="myinfo.php">管理员界面</a>
  <ul class="navbar-nav">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle font-weight-bold" data-toggle='dropdown' id="navbardrop1" href="#">修改个人信息</a>
      <div class="dropdown-menu">
      	<a href="myinfo.php" class="dropdown-item">修改基本信息</a>
      	<a href="password.php" class="dropdown-item">修改密码</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="addadmin.php">添加管理员</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="addtype.php">添加美食种类</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="usereditor.php">管理登录用户</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="addfood.php">添加新美食</a>
    </li>

  </ul>

  <div class="collapse navbar-collapse justify-content-end">
	<ul class="navbar-nav">
		<li class='nav-item dropdown'>
			<a class='nav-link dropdown-toggle font-weight-bold active' href='../index.php' id='navbardrop2' data-toggle='dropdown'>
				欢迎，<?php echo $_COOKIE['login']; ?>
			</a>
			<div class='dropdown-menu'>
				<a class='dropdown-item' href='myinfo.php'>修改个人信息</a>
				<a class='dropdown-item' href='addadmin.php'>添加管理员</a>
				<a class='dropdown-item' href='addtype.php'>添加美食种类</a>
				<a class='dropdown-item' href='usereditor.php'>管理登录用户</a>
				<a class='dropdown-item' href='addfood.php'>添加新美食</a>
				<a class='dropdown-item' href='logout.php'>返回主页</a>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link font-weight-bold active" href="../index.php"><i class="fa fa-home fa-fw"></i>主页</a>
		</li>
	</ul>
  </div>
</nav>


<div class="container-fluid" style="margin-top: 100px">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<h2>欢迎您！<?php echo $_COOKIE['login']; ?>管理员</h2>
			<hr>
			<div class="list-group" id="parent">
				<a href="#collapse1" class="list-group-item list-group-item-info" data-toggle="collapse">修改个人信息</a>
				<div id="collapse1" class="collapse">
					<a href="myinfo.php" class="list-group-item list-group-item-secondary" data-parent="#parent">修改基本信息</a>
				</div>
				<div id="collapse1" class="collapse">
					<a href="password.php" class="list-group-item list-group-item-secondary" data-parent="#parent">修改密码</a>
				</div>
				<a href="addadmin.php" class="list-group-item list-group-item-info active">添加管理员</a>
				<a href="addtype.php" class="list-group-item list-group-item-info">添加美食种类</a>
				<a href="usereditor.php" class="list-group-item list-group-item-info">管理登录用户</a>
				<a href="addfood.php" class="list-group-item list-group-item-info">添加新美食</a>
			</div>
		</div>
		<div class="col-sm-8 col-md-9">
			<h4>添加管理员</h4>
			<hr>
			<form method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return check(this)">
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">管理员登录名称</label>
					<div class="col-sm-6 col-md-8">
						<input type="text" name="username" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">设置密码</label>
					<div class="col-sm-6 col-md-8">
						<input type="password" name="password_login" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">确认密码</label>
					<div class="col-sm-6 col-md-8">
						<input type="password" name="password_confirm" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">联系方式</label>
					<div class="col-sm-6 col-md-8">
						<input type="text" name="phonenumber" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">邮箱</label>
					<div class="col-sm-6 col-md-8">
						<input type="text" name="email" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable text-center">所在地址</label>
					<div class="col-sm-6 col-md-8">
						<input type="text" name="address" class="form-control">
					</div>
				</div>

				<div class="row" style="margin-top: 50px">
					<div class="col-sm-6 col-md-4 text-center">
						<input type="reset" class="btn btn-warning" value="重写">
					</div>
					<div class="col-sm-6 col-md-8">
						<input type="submit" class="btn btn-success" value="提交">
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
</html>



<?php

			}
		}
	} else {
		echo "不存在该用户！";
	}
}
?>