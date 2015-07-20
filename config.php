<?php
@ob_start();
session_start (); //开启session 
date_default_timezone_set('Asia/Shanghai');
$db_host="localhost";
$db_user="root";
$db_pass="1";
$db_name="test";
$table_main="main";
$table_detail="bus_detail";

$link=@mysql_connect($db_host,$db_user,$db_pass) or die("不能连接到服务器".mysql_error());
mysql_query("SET NAMES UTF8");//指定编码



?>