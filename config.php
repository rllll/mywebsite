<?php

$host_name = "localhost";
$host_user = "root";
$host_pass = "";
$db_name = "order_food";
$table_user = "user";
$table_type = "type";
$table_food = "food";
$table_sales = "sales";

$mysqli = new mysqli($host_name, $host_user, $host_pass, $db_name);

$mysqli->query("set names 'utf8'");

?>