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
		if ($info['admin'] == 1) {
			echo "<center>";
			echo "<h4 style='margin-top:20px'>这里是用户管理界面，您是管理员而非用户，不能查看此页面！</h4>";
			echo "</center>";
		} else {
			$sql = "SELECT * FROM $table_user WHERE username='$username'";
			$re = $mysqli->query($sql) or die($mysqli->error);
			$info = $re->fetch_assoc();
			$user_id = $info['user_id'];

			$password = $info['password'];

			if (isset($_POST['password'])) {

				$password_new = md5($_POST['password']);
				if ($password_new != $password) {
					$sql_update = "UPDATE $table_user SET password='$password_new' WHERE user_id=$user_id";
					$result = $mysqli->query($sql_update) or die($mysqli->error);
					if ($result) {
						echo "<center><h4>密码已经修改！</h4></center>";
						echo "<meta http-equiv=\"refresh\" content=\"2; url=password.php\">";
					}
				} else {
					echo "<center><h4>新密码不能与旧密码一致！</h4></center>";
					echo "<meta http-equiv=\"refresh\" content=\"2; url=password.php\">";
				}

			} else {

				?>

<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>修改密码</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
	  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

	  <script type="text/javascript">
	  	function check(f){
	  		if (f.password.value == '')
	  		{
	  			alert("不能提交空字段，请设置密码！");
	  			f.password.focus();
	  			return (false);
	  		}
	  		if (f.re_password.value != f.password.value){
	  			alert("密码不一致！");
	  			f.re_password.focus();
	  			return (false);
	  		}
	  	}
	  </script>
</head>
<body>

<!-- 导航栏 -->

<nav class="navbar navbar-expand-sm bg-info navbar-dark">
  <!-- LOGO -->
  <a class="navbar-brand font-weight-bold" href="myinfo.php">用户信息界面</a>
  <ul class="navbar-nav">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle font-weight-bold active" data-toggle='dropdown' id="navbardrop1" href="#">修改个人信息</a>
      <div class="dropdown-menu">
      	<a href="myinfo.php" class="dropdown-item">修改基本信息</a>
      	<a href="password.php" class="dropdown-item">修改密码</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="show_sale.php">查看历史订单</a>
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
				<a class='dropdown-item' href='show_sale.php'>查看历史订单</a>
				<a class='dropdown-item' href='logout.php'>返回主页</a>
			</div>
		</li>
		<li class="nav-item">
			<a class="nav-link font-weight-bold active" href="../index.php"><i class="fa fa-home fa-fw"></i>主页</a>
		</li>
	</ul>
  </div>
</nav>


<div class="container-fluid" style="margin-top: 40px">
	<div class="row">
		<div class="col-sm-4 col-md-3">
			<h2>欢迎您！<?php echo $_COOKIE['login']; ?></h2>
			<hr>
			<div class="list-group" id="parent">
				<a href="#collapse1" class="list-group-item list-group-item-info" data-toggle="collapse">修改个人信息</a>
				<div id="collapse1" class="collapse">
					<a href="myinfo.php" class="list-group-item list-group-item-secondary" data-parent="#parent">修改基本信息</a>
				</div>
				<div id="collapse1" class="collapse">
					<a href="password.php" class="list-group-item list-group-item-secondary active" data-parent="#parent">修改密码</a>
				</div>
				<a href="show_sale.php" class="list-group-item list-group-item-info">查看历史订单</a>
			</div>
		</div>
		<div class="col-sm-8 col-md-9">
			<h4>修改密码</h4>
			<hr>
			<form method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return check(this)">
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable">新密码</label>
					<div class="col-sm-6 col-md-8">
						<input type="password" name="password" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable">确认密码</label>
					<div class="col-sm-6 col-md-8">
						<input type="password" name="re_password" class="form-control">
					</div>
				</div>

				<div class="row" style="margin-top: 50px">
					<div class="col-sm-6 col-md-4">
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