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
			?>













<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>历史订单</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	<script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- 导航栏 -->

<nav class="navbar navbar-expand-sm bg-info navbar-dark">
  <!-- LOGO -->
  <a class="navbar-brand font-weight-bold" href="myinfo.php">用户信息界面</a>
  <ul class="navbar-nav">
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle font-weight-bold" data-toggle='dropdown' id="navbardrop1" href="#">修改个人信息</a>
      <div class="dropdown-menu">
      	<a href="myinfo.php" class="dropdown-item">修改基本信息</a>
      	<a href="password.php" class="dropdown-item">修改密码</a>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="show_sale.php">查看历史订单</a>
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
					<a href="password.php" class="list-group-item list-group-item-secondary" data-parent="#parent">修改密码</a>
				</div>
				<a href="show_sale.php" class="list-group-item list-group-item-info active">查看历史订单</a>
			</div>
		</div>
		<div class="col-sm-8 col-md-9">
			<h4>查看历史订单</h4>

			<?php

			$sql = "SELECT * FROM $table_sales";
			$result = $mysqli->query($sql) or die($mysqli->error);
			if ($result->num_rows > 0) {
				echo "<table class='table table-hover'>";
				echo "<thead><tr>
					<th>订单号</th>
					<th>美食名称</th>
					<th>美食售价</th>
					<th>订购数量</th>
					<th>需付总额</th>
					<th>状态</th>
				</tr></thead>";
				echo "<tbody>";
				while ($info = $result->fetch_assoc()) {
					echo "<tr>";
					echo "<td>" . $info['sale_id'] . "</td>";
					echo "<td>" . $info['sale_food_name'] . "</td>";
					echo "<td>" . $info['sale_food_cost'] . "</td>";
					echo "<td>" . $info['sale_food_num'] . "</td>";
					echo "<td>" . $info['sale_food_cost'] * $info['sale_food_num'] . "</td>";
					echo "<td>";
					if ($info['sale_state'] == 1) {
						echo "已购买";
					} else {
						echo "未处理";
					}
					echo "</td>";
					echo "</tr>";
				}
				echo "<tbody>";
				echo "</table>";
			} else {
				echo "您还没有购买记录！";
			}

			?>

		</div>
	</div>

</div>

</body>
</html>



<?php
}
	} else {
		echo "不存在该用户！";
	}
}
?>