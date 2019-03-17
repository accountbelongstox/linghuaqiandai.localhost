<script type="text/javascript">
	<?php 
		if(isset($_GET['point'])){
			echo "var is_click=false;var get_point=true;";
		}else{
			echo "var is_click=true;var get_point=false;";
		}
	?>
	//写cookies
	function setCookie(name,value){
		var Days = 30;
		var exp = new Date();
		exp.setTime(exp.getTime() + Days*24*60*60*1000);
		document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
	}

/*---------------------------------------自动定位或拾取坐标--------------------*/
	if(!get_point){
		var map = new BMap.Map("l-map");
		var point = new BMap.Point(116.331398,39.897445);
		map.centerAndZoom(point,16);
		var geolocation = new BMap.Geolocation();
		if(is_click){
			map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
			map.enableDragging();// 拖动
			map.enableScrollWheelZoom()//缩放
			map.enableInertialDragging();
		}else{
			map.disableDoubleClickZoom();//禁双击
			map.disableInertialDragging();//拖动
			map.disableScrollWheelZoom();//禁放大
			map.disableDragging();//禁拖
			
		}
		//点击得到坐标
		geolocation.getCurrentPosition(function(r){
			if(this.getStatus() == BMAP_STATUS_SUCCESS){
				var icon = new BMap.Icon("images/icon/user.png",new BMap.Size(32,32));
				var mk = new BMap.Marker(r.point,{icon:icon});
				map.addOverlay(mk);
				map.centerAndZoom(r.point,16);
				map.panTo(r.point);
				$.ajax({
				url: "http://api.map.baidu.com/geocoder/v2/",
				data:'ak=<?php echo $baidu_map_key;?>&location='+r.point.lat+','+r.point.lng+'&output=json',
				dataType: 'JSONP',
				success: function (data){
					//将当前坐标传给浏览器
					setCookie("Map_AddName",data.result.formatted_address);
					setCookie("Map_localX", r.point.lng);
					setCookie("Map_localY", r.point.lat);
					var infoWindow = new BMap.InfoWindow('定位：'+data.result.formatted_address+' 这是否是您当前地址！');  // 创建信息窗口对象
					map.openInfoWindow(infoWindow,r.point); //开启信息窗口
					
				}
			});
			}
			else {
				alert('failed'+this.getStatus());
			}		
		},{enableHighAccuracy: true})
		//关于状态码
		//BMAP_STATUS_SUCCESS	检索成功。对应数值“0”。
		//BMAP_STATUS_CITY_LIST	城市列表。对应数值“1”。
		//BMAP_STATUS_UNKNOWN_LOCATION	位置结果未知。对应数值“2”。
		//BMAP_STATUS_UNKNOWN_ROUTE	导航结果未知。对应数值“3”。
		//BMAP_STATUS_INVALID_KEY	非法密钥。对应数值“4”。
		//BMAP_STATUS_INVALID_REQUEST	非法请求。对应数值“5”。
		//BMAP_STATUS_PERMISSION_DENIED	没有权限。对应数值“6”。(自 1.1 新增)
		//BMAP_STATUS_SERVICE_UNAVAILABLE	服务不可用。对应数值“7”。(自 1.1 新增)
		//BMAP_STATUS_TIMEOUT	超时。对应数值“8”。(自 1.1 新增)
	}else{
		/*---------------------------------------如果不是自动定位--------------------*/
		// 百度地图API功能
		<?php
			if(isset($baidu_XY)){
				echo "var baidu_XY='".$baidu_XY."';\n";
			}else{
				echo "var baidu_XY=false;\n";
			}
		?>
		if(baidu_XY != false){
			var baidu_X=parseFloat(baidu_XY.split(',')[0]);
			var baidu_Y=parseFloat(baidu_XY.split(',')[1]);
		}else{
			var baidu_X=116.404;
			var baidu_Y=39.915;
		}	
		// 百度地图API功能
		//获取地实际地址
		var formatted_address='';
		$.ajax({
			url: "http://api.map.baidu.com/geocoder/v2/",
			data:'ak=<?php echo $baidu_map_key;?>&location='+baidu_Y+','+baidu_X+'&output=json',
			dataType: 'JSONP',
			success: function (data){
				formatted_address=data.result.formatted_address;
				
				//请求成功再开始建立地图
				var sContent = formatted_address;
				var map = new BMap.Map("l-map");	
				
				//点击得到坐标
				var point = new BMap.Point(baidu_X, baidu_Y);
				var icon = new BMap.Icon("/images/icon/user.png",new BMap.Size(32,32));
				//设置标注的经纬度
				var marker = new BMap.Marker(point,{icon:icon});
				//把标注添加到地图上
				map.addOverlay(marker);
				map.centerAndZoom(point, 16);
				var infoWindow = new BMap.InfoWindow(sContent);  // 创建信息窗口对象
				map.openInfoWindow(infoWindow,point); //开启信息窗口		
				if(is_click){
					map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
					map.enableDragging();// 拖动
					map.enableScrollWheelZoom()//缩放
					map.enableInertialDragging()
					
					//getBaiduMapXY();
					
				}else{
					map.disableDoubleClickZoom()//禁双击
					map.disableInertialDragging()//拖动
					map.disableScrollWheelZoom()//禁放大
					map.disableDragging()//禁拖
				}
				
			}
		});
	}
</script>