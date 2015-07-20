
function my_post_main(post_data)
{
	document.getElementById("hidden_input_main").value = post_data;
	document.getElementById("hidden_form_main").submit();    
}
function my_post_detail(post_data)
{
	document.getElementById("hidden_input_detail").value = post_data;
	document.getElementById("hidden_form_detail").submit();    
}




function add_pointer(map,x,y,last_x,last_y,name,time)
{
	var point = new BMap.Point(x,y); // 创建点坐标
	var marker = new BMap.Marker(point); // 创建标注 
	map.addOverlay(marker); // 将标注添加到地图中
	
	time = time.substring(0,5)

	if(time == '00:00')
		time = '未知';

	marker.addEventListener("click", function(){    
			var sContent ="到达时间:"+time;
			var infoWindow = new BMap.InfoWindow(sContent); 
			this.openInfoWindow(infoWindow);
 
	});

	var opts = {
		position : point,    // 指定文本标注所在的地理位置
		offset   : new BMap.Size(30, -30)    //设置文本偏移量
	}
	var label = new BMap.Label(name, opts);  // 创建文本标注对象
	label.setStyle({
		 color : "black",
		 fontSize : "12px",
     fontWeight : "bold",
		 height : "20px",
		 lineHeight : "20px",
	});
	map.addOverlay(label);  
	
	if(last_x != 0)
	{
		 var polyline = new BMap.Polyline([
		  new BMap.Point(x,y),
		  new BMap.Point(last_x,last_y)
		 ], {strokeColor:"blue", strokeWeight:6, strokeOpacity:0.5});
		 map.addOverlay(polyline);	
	}

}