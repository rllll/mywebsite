<?php

if (!isset($_COOKIE['login']) or $_COOKIE['login'] == '') {
	echo "您现在是游客身份，不能购买！" . "<br>";
	echo "如果您想注册，点击<a href='reg.php'>这里</a>" . "<br>";
	echo "如果您想登录，点击<a href='login.php'>这里</a>" . "<br>";
	echo "如果您想继续浏览商品，点击<a href='index.php'>这里</a>" . "<br>";
} else {
	include "config.php";
	$username = $_COOKIE['login'];
	$sql = "SELECT * FROM $table_user WHERE username='$username'";
	$result = $mysqli->query($sql) or die($mysqli->error);
	if ($result->num_rows > 0) {
		$info = $result->fetch_assoc();
		if ($info['admin'] == 1) {
			echo "<center>";
			echo "<h4 style='margin-top:20px'>您是管理员用户，不能购买！</h4>";
			echo "</center>";
			echo "<meta http-equiv=\"refresh\" content=\"2; url=index.php\">";
		} else {
			if (isset($_POST['foodname'])) {
				include "config.php";
				$username = $_COOKIE['login'];
				$food_id = $_POST['food_id'];
				$foodname = $_POST['foodname'];
				$foodcost = $_POST['foodcost'];
				$foodnum = $_POST['foodnum'];
				$time = date("Y年m月d日");

				$sql = "INSERT INTO $table_sales(sale_user_name,sale_food_id,sale_food_name,sale_food_num,sale_food_cost,sale_state,sale_date) VALUES('$username','$food_id','$foodname','$foodnum','$foodcost','1','$time')";
				$result = $mysqli->query($sql) or die($mysqli->error);
				if ($result) {
					echo "购买成功！现在您可以在<a href='user/show_sale.php'>历史订单</a>中查看";
				}
			}
		}
	}
}

?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>购买结果</title>
</head>
<body>

</body>
</html>