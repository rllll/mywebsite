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
			if (isset($_POST['type'])) {
				$typename = $_POST['type'];
				$des = $_POST['description'];
				$sql = "SELECT * FROM $table_type WHERE typename='$typename'";
				$result = $mysqli->query($sql) or die($mysqli->error);
				if ($result->num_rows > 0) {
					echo "已经存在该种类，请重新编写！";
					echo "<meta http-equiv=\"refresh\" content=\"2; url=addtype.php\">";
				} else {
					$sql = "INSERT INTO $table_type(typename,description) VALUES('$typename','$des')";
					$result = $mysqli->query($sql) or die($mysqli->error);
					if ($result) {
						echo "成功添加！";
						echo "<meta http-equiv=\"refresh\" content\"2; url=addtype.php\">";
					}
				}
			} else {

				?>


<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>编辑/添加美食信息</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		function check(f){
			if (f.type.value == ''){
				alert("类型名称不能为空，请重新填写！");
				f.type.focus();
				return (false);
			}
			if (f.description.value == ''){
				alert("详细描述不能为空，请重新填写！");
				f.description.focus();
				return (false);
			}
		}
	</script>
</head>
<body>

<!-- 导航栏 -->

<nav class="navbar navbar-expand-sm bg-info navbar-dark">
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
      <a class="nav-link" href="addadmin.php">添加管理员</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="addtype.php">添加美食种类</a>
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

<div class="container-fluid" style="margin-top: 40px">
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
				<a href="addadmin.php" class="list-group-item list-group-item-info">添加管理员</a>
				<a href="addtype.php" class="list-group-item list-group-item-info active">添加美食种类</a>
				<a href="usereditor.php" class="list-group-item list-group-item-info">管理登录用户</a>
				<a href="addfood.php" class="list-group-item list-group-item-info">添加新美食</a>
			</div>
		</div>
		<div class="col-sm-8 col-md-9">
			<h4>添加美食种类</h4>
			<hr>
			<form method="post" action="<?php $_SERVER['PHP_SELF']?>" onsubmit="return check(this)">
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable">您想添加的种类名称</label>
					<div class="col-sm-6 col-md-8">
						<input type="text" name="type" class="form-control">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-6 col-md-4 col-form-lable">该种类的详细描述</label>
					<div class="col-sm-6 col-md-8">
						<textarea name="description" class="form-control" rows="10"></textarea>
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

			<div style="margin-top: 50px">
				<h4>所有种类</h4>
				<?php
$sql = "SELECT * FROM $table_type";
				$result = $mysqli->query($sql) or die($mysqli->error);
				if ($result->num_rows > 0) {
					echo "<table class='table table-hover'>";
					echo "<thead><tr><th>编号</th><th>种类名称</th><th>介绍</th></tr></thead>";
					echo "<tbody>";
					while ($info = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td>" . $info['type_id'] . "</td>";
						echo "<td>" . $info['typename'] . "</td>";
						echo "<td>" . $info['description'] . "</td>";
						echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";
				} else {
					echo "没有划分类别！";
				}
				?>
			</div>
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