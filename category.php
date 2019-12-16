<!DOCTYPE html>
<html lang="zh_CN">
<head>
	<meta charset="UTF-8">
	<title>美食分类</title>
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
	  <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
	  <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
	  <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>

	  <style type="text/css">
	  	  .carousel-inner img {
		      width: 100%;
		      height: 100%;
		  }
		  html,body{
		  	height: 100%
		  }
		  footer{
		  	position: absolute;
		  	bottom: 0px;
		  }
	  </style>

</head>
<body>

<!-- 导航栏 -->
<nav class="navbar navbar-expand-sm bg-warning navbar-dark">
  <a class="navbar-brand font-weight-bold" href="index.php">食客轩</a>

  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link font-weight-bold" href="index.php">首页</a>
    </li>
    <li class="nav-item dropdown active">
      <a class="nav-link dropdown-toggle font-weight-bold" href="index.php" id="navbardrop1" data-toggle="dropdown">
        所有美食分类
      </a>
<?php
include "config.php";
$sql = "SELECT * FROM $table_type";
$result = $mysqli->query($sql) or die($mysqli->error);
if ($result->num_rows > 0) {
	echo "<div class='dropdown-menu'>";
	while ($info = $result->fetch_assoc()) {
		echo "<a class='dropdown-item' href='category.php'>";
		echo $info['typename'];
		echo "</a>";
	}
	echo "</div>";
}
?>
    </li>
  </ul>
  <div class="collapse navbar-collapse justify-content-end">
	<ul class="navbar-nav">
		<?php
if (!isset($_COOKIE['login']) or $_COOKIE['login'] == '') {
	?>
		<li class="nav-item">
			<a class="nav-link font-weight-bold active" href="reg.php">注册</a>
		</li>
		<li>
			<a class="nav-link font-weight-bold active" href="login.php">登录</a>
		</li>
		<?php
} else {
	$username = $_COOKIE['login'];
	echo "<li class='nav-item dropdown'>";
	echo "<a class='nav-link dropdown-toggle font-weight-bold active' href='index.php' id='navbardrop2' data-toggle='dropdown'>";
	echo "欢迎，" . $username . "</a>";
	$sql = "SELECT * FROM $table_user WHERE username='$username'";
	$result = $mysqli->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if ($info['admin'] == 0) {
			echo "<div class='dropdown-menu'>";
			echo "<a class='dropdown-item' href='user/myinfo.php'>修改个人信息</a>";
			echo "<a class='dropdown-item' href='user/show_sale.php'>查看历史订单</a>";
			echo "<a class='dropdown-item' href='logout.php'>退出登录</a>";
			echo "</div>";
		} else {
			echo "<div class='dropdown-menu'>";
			echo "<a class='dropdown-item' href='admin/myinfo.php'>修改个人信息</a>";
			echo "<a class='dropdown-item' href='admin/addadmin.php'>添加管理员</a>";
			echo "<a class='dropdown-item' href='admin/addtype.php'>添加美食种类</a>";
			echo "<a class='dropdown-item' href='admin/usereditor.php'>管理登录用户</a>";
			echo "<a class='dropdown-item' href='admin/addfood.php'>添加新美食</a>";
			echo "<a class='dropdown-item' href='logout.php'>退出登录</a>";
			echo "</div>";
		}
	}

	echo "</li>";
}
?>
	</ul>
  </div>
</nav>


<div class="container-fluid" style="margin-top: 50px" >

	<div class="row">

		<!-- 所有美食分类 -->
		<div class="col-sm-4 col-md-3">
			<h3>所有美食分类</h3>
			<hr>

			<?php
$sql = "SELECT * FROM $table_type";
$result = $mysqli->query($sql) or die($mysqli->error);
if ($result->num_rows > 0) {
	$count = 1;
	echo "<div class='list-group'>";
	while ($info = $result->fetch_assoc()) {
		echo "<a href=#" . $count . " class='list-group-item list-group-item-action'>" . $info['typename'] . "</a>";
		$count++;
	}
	echo "</div>";

}
?>
			</ul>
		</div>

<!-- 美食 -->
<div class="col-sm-8 col-md-9">

	<?php
$sql = "SELECT * FROM $table_type";
$result = $mysqli->query($sql) or die($mysqli->error);

if ($result->num_rows > 0) {
	$count_type = 1;
	while ($count_type <= $result->num_rows and $info = $result->fetch_assoc()) {
		echo "<div id=" . $count_type . " style='margin-top:10px'>";
		echo "<h4>" . $info['typename'] . "</h4>";
		echo "<hr>";
		$foodtype = $info['typename'];
		$sql_food = "SELECT * FROM $table_food WHERE foodtype='$foodtype'";
		$result_food = $mysqli->query($sql_food) or die($mysqli->error);
		if ($result_food->num_rows > 0) {
			while ($info_food = $result_food->fetch_assoc()) {
				echo "<div class='col-sm-6 col-md-4' style='margin-top:20px'>";
				echo "<div class='card'>";
				echo "<img class='card-img-top' src='https://static.runoob.com/images/mix/img_avatar.png' alt='Card image' style='width:100%'>";
				echo "<div class='card-body'>";
				echo "<h4 class='card-title'>菜名：" . $info_food['foodname'] . "[" . $info_food['foodtype'] . "]</h4>";
				echo "<p class='card-text'>介绍：" . $info_food['fooddes'] . "</p>";
				echo "<div class='row'>";
				echo "<div class='col-sm-6 col-md-4'>";
				echo "<h5>售价：$" . $info_food['foodcost'] . "</h5>";
				echo "<h6>库存：" . $info_food['foodnum'] . "份</h6>";
				echo "</div>";

				echo "<div class='col-sm-6 col-md-8 text-right' style='margin-top:15px'>";
				echo "<button type='button' data-toggle='modal' data-target='#buydetails1' class='btn btn-secondary btn-sm' style='margin-right:5px'>加入购物车</button>";
				echo "<button type='button' data-toggle='modal' data-target='#buydetails2' class='btn btn-primary btn-sm'>购买</button>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</div>";

				//依附于购买按钮的模态框[1]
				echo "<div class='modal fade' id='buydetails1'>";
				echo "<div class='modal-dialog'>";
				echo "<div class='modal-content'>";
				//模态框的头部
				echo "<div class='modal-header'>";
				echo "<h4 class='modal-title'>订单详情</h4>";
				echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";

				echo "</div>";

				//模态框主体部分
				echo "<div class='modal-body'>";

				echo "<div class='container-fluid'>"; //设计了一个contailer-fluid容器，应用网格系统
				//提交至新页面的表单
				echo "<form method='post' action='order.php'>";
				//表单中的第1行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>美食编号</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='food_id' readonly class='form-control' value=" . $info_food['food_id'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第2行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>美食名称</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='foodname' readonly class='form-control' value=" . $info_food['foodname'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第3行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>售价</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='foodcost' readonly class='form-control' value=" . $info_food['foodcost'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第4行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>购买数量</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='number' name='foodnum' class='form-control' value='0' min='0' max=" . $info_food['foodnum'] . ">";
				echo "</div>";
				echo "</div>";

				echo "</div>";

				echo "</div>";
				//模态框的底部
				echo "<div class='modal-footer'>";
				echo "<div class='container-fluid'>";
				echo "<div class='col-12 text-right'>";
				echo "<input type='submit' class='btn btn-primary' value='加入购物车'>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</form>";

				echo "</div>";
				echo "</div>";
				echo "</div>";

				//依附于购买按钮的模态框[2]
				echo "<div class='modal fade' id='buydetails2'>";
				echo "<div class='modal-dialog'>";
				echo "<div class='modal-content'>";
				//模态框的头部
				echo "<div class='modal-header'>";
				echo "<h4 class='modal-title'>购买详情</h4>";
				echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";

				echo "</div>";

				//模态框主体部分
				echo "<div class='modal-body'>";

				echo "<div class='container-fluid'>"; //设计了一个contailer-fluid容器，应用网格系统
				//提交至新页面的表单
				echo "<form method='post' action='buy.php'>";
				//表单中的第1行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>美食编号</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='food_id' readonly class='form-control' value=" . $info_food['food_id'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第2行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>美食名称</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='foodname' readonly class='form-control' value=" . $info_food['foodname'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第3行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>售价</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='text' name='foodcost' readonly class='form-control' value=" . $info_food['foodcost'] . ">";
				echo "</div>";
				echo "</div>";
				//表单中的第4行
				echo "<div class='form-group row'>";
				echo "<div class='col-4' style='margin-top:5px'>";
				echo "<label>购买数量</label>";
				echo "</div>";
				echo "<div class='col-8'>";
				echo "<input type='number' name='foodnum' class='form-control' value='0' min='0' max=" . $info_food['foodnum'] . ">";
				echo "</div>";
				echo "</div>";

				echo "</div>";

				echo "</div>";
				//模态框的底部
				echo "<div class='modal-footer'>";
				echo "<div class='container-fluid'>";
				echo "<div class='col-12 text-right'>";
				echo "<input type='submit' class='btn btn-primary' value='确认购买'>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
				echo "</form>";

				echo "</div>";
				echo "</div>";
				echo "</div>";

			}
		} else {
			echo "该类别没有库存！";
		}

		echo "</div>";
		$count_type++;
	}
}
?>

</div>

	</div>
</div>

</body>
</html>