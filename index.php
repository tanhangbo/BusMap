<?
	require "config.php";
	@header("content-Type: text/html; charset=utf-8");
	

	if (!mysql_select_db($db_name,$link)){
		echo "sql error";
		return;
	}




	/*从main_id 得到对应时段的所有车次id*/
	function get_main_list($time_period)
	{
		$ret = array();
		$index = 0;
		$result=mysql_query("select * from main where which_time='$time_period' ORDER BY id  ASC");
		while($row = mysql_fetch_array($result)):
			$one_entry=array();
			$one_entry['id'] = $row['id'];
			$one_entry['which_time'] = $row['which_time'];
			$one_entry['which_bus'] = $row['which_bus'];
			$ret[$index++] = $one_entry;
		endwhile;
		return $ret;
	}
	/*根据某时段的所有车次id 匹配传入的车次名称得到单个车次的id*/
	function get_one_path_id($paths,$bus_name)
	{
		$id = -1;
		foreach($paths as $one_entry)
		{
			if($one_entry['which_bus'] == $bus_name)
			{
				$id = $one_entry['id'];
			}
		}
		return $id;
	}
	/*根据单个车次的id得到这个车次的路线*/
	function get_one_path($path_id)
	{
		$ret = array();
		$index = 0;
		$result=mysql_query("select * from bus_detail where main_id=$path_id ORDER BY id  ASC");
		while($row = mysql_fetch_array($result)):
			$one_entry=array();
			$one_entry['id'] = $row['id'];
			$one_entry['main_id'] = $row['main_id'];
			$one_entry['time'] = $row['time'];
			$one_entry['place'] = $row['place'];
			$one_entry['xy'] = $row['xy'];
			$ret[$index++] = $one_entry;
		endwhile;
		return $ret;
	}
	
	
	function print_second_list($time_period)
	{
		$ret = get_main_list($time_period);
		
		/*第二行的着色代码*/
		$clicked_path_id = -1;
		if(isset($_POST['hidden_input_detail']))
			$clicked_path_id = $_POST['hidden_input_detail'];
		
		
		
		foreach($ret as $one_entry)
		{
			$readable_entry = get_readable($one_entry['which_bus']);
			$one_path_id = get_one_path_id($ret,$one_entry['which_bus']);
			//$one_path = get_one_path($one_path_id);
			if($clicked_path_id == $one_path_id)
				echo "<li style='background-color:#3FF;'><a onclick=my_post_detail(".$one_path_id.")>";
			else
				echo "<li><a onclick=my_post_detail(".$one_path_id.")>";
			echo $readable_entry;
			echo '</a></li>';
		}
	}
	
	
	function get_readable($bus_name)
	{
		switch($bus_name)
		{
		case "A":
			return "A_best";
		break;
		case "B":
			return "B";
		break;
		case "C":
			return "Just_c";
		break;
		case "D":
			return "D";
		break;
		case "E":
			return "E";
		break;
		case "F":
			return "F";
		break;
		default:
			return "err!";
		}
	}
	
	
	if(!isset($_SESSION['second_list']))
	{
		$_SESSION['second_list']='idx0'; //设置初始值为id为1的车
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="busmap">
<meta name="description" content="busmap">
<title>welcome to busmap - tanhangbo</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=qdTBeCINQjN0GAbh9IRegqFb"></script>

<script type="text/javascript" src="main.js" type="text/javascript"></script>
</head>

<body>



<div id="real_map">
</div>

<script>
	var map = new BMap.Map("real_map"); // 创建地图实例
	var point = new BMap.Point(121.490406,31.243036); // 创建点坐标
	map.centerAndZoom(point, 15); // 初始化地图，设置中心点坐标和地图级别
	add_pointer(map,121.490406,31.243036,0,0,'alien\'s home','00:00:00');
	
	/*控件*/
	map.addControl(new BMap.NavigationControl());    
	map.addControl(new BMap.MapTypeControl());    

	/*全景*/
	var stCtrl = new BMap.PanoramaControl();  
	stCtrl.setOffset(new BMap.Size(40, 60));  
	map.addControl(stCtrl);


</script>


<div id="header">

	<!--第一栏-->
	<div class="toolbar top">
	
	<ul>
	<li id="logo"><img src="logo.jpg" height="30px"/></li>
	<li id="Pidx0"><a onclick="my_post_main('idx0');">morning</a></li>
	<li id="Pidx1"><a onclick="my_post_main('idx1');">noon</a></li>
	<li id="Pidx2"><a onclick="my_post_main('idx2');">afternoon</a></li>
	<li id="Pidx3"><a onclick="my_post_main('idx3');">night</a></li>
	</ul>
	</div>


	<!--第二栏-->
	<div class="toolbar">
	<ul>
	<?
	if(isset($_POST['hidden_input_main'])) {
		$time_period = $_POST['hidden_input_main'];
		$_SESSION['second_list'] = $time_period;
		
		/*第一行的着色代码*/
		echo "<script>";
		echo "document.getElementById('P".$time_period."').style.backgroundColor = '#F66';";
		echo "</script>";

		print_second_list($time_period);
	} else {
		$time_period = $_SESSION['second_list'];
		
		/*第一行的着色代码*/
		echo "<script>";
		echo "document.getElementById('P".$time_period."').style.backgroundColor = '#F66';";
		echo "</script>";
		print_second_list($_SESSION['second_list']);
	}
	?>
	</ul>
	</div>

</div>

<?
if(isset($_POST['hidden_input_detail']))
{
	$one_path_id = $_POST['hidden_input_detail'];
	$ret = get_one_path($one_path_id);
	$last_x = 0;
	$last_y = 0;
	echo '<script>';
	foreach($ret as $one_entry)
	{
		$time =  $one_entry['time'];
		$place = $one_entry['place'];
		$xy = explode(",",$one_entry['xy']);
		$x = $xy[0];
		$y = $xy[1];
		echo "add_pointer(map,$x,$y,$last_x,$last_y,'$place','$time');\n";
		$last_x = $x;
		$last_y = $y;
	}
	echo '</script>';
}
?>







<div class="hidden">
	<form id="hidden_form_main" method="post">
	<input id="hidden_input_main" name="hidden_input_main"></input>
	</form>
</div>
<div class="hidden">
	<form id="hidden_form_detail" method="post">
	<input id="hidden_input_detail" name="hidden_input_detail"></input>
	</form>
</div>


//put your baidu map api url here



</html>