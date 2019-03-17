<?php
header('Content-Type:text/html;charset=utf-8');
//在线获取地图
$config=require("../../config.php");
$baidu_map_key=$config['web']['map_secret'];
/*---------使用说明-------*/
//直接给 &point = 110,220
//第一个数据为x坐标,第二个为y坐标
//参数 point 地图坐票
//location_aotu 自动定位
if(isset($_GET['point'])){
	$baidu_XY=$_GET['point'];
}
?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
		body, html,#allmap {width: 100%;height: 100%;margin:0;font-family:"微软雅黑";font-size:14px;}
		#l-map{width:100%;    height: 100%;}
		#r-result{width:100%;}
	</style>
	<script src="/public/jquery.js"></script>
	<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $baidu_map_key;?>"></script>
	<title>百度地图位置</title>
</head>
<body>
	<div id="l-map"></div>
	<div id="r-result"></div>
</body>
</html>
<?php 
require("../return_data/js/get_point.php");
?>
