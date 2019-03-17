$(window).load(function(){
	if(top.location==location){
		if(getCookie('user_set_edit_layout_button')=='1'  && getCookie('edit_page_layout')=='true' && get_param('edit_page_layout')!='true' ){
			
			$.get("/receive.php?target=index::edit_page_layout&act=show_edit_button", function(data){
				if(data=='ok'){
					$("#edit_page_layout_button").css('display','block');	
					$("#edit_page_layout_button").html('<i class="fa fa-pencil-up">&#xf040;</i>');
					$("#edit_page_layout_button").click(function(){
						url=window.location.href;
						url=replace_get(url,'edit_page_layout','true');
						window.location.href=url;	
						return false;
					});
					
				}	
				
			});
		}	
	}
	
	if(getCookie('edit_page_layout_div')=='true' && get_param('edit_page_layout_view_module')!=''){
		$("#edit_page_layout_button").css('display','none');	
		$(".module_div").addClass('cloud_exe_hide_module_div');
		$(".separator_line").removeClass('separator_line');	
		$(".cloud_drag_div").css('display','none');
		$(".resize_div").css('display','none');
		$("#"+get_param('edit_page_layout_view_module')).removeClass('cloud_exe_hide_module_div');
		$("#"+get_param('edit_page_layout_view_module')).addClass('cloud_exe_show_module_div_1');
		$("#"+get_param('edit_page_layout_view_module')).css('width',parseInt($("#"+get_param('edit_page_layout_view_module')).css('width'))-10);
		$("#"+get_param('edit_page_layout_view_module')).css('height',parseInt($("#"+get_param('edit_page_layout_view_module')).css('height'))-20);
		window.setInterval(function(){switch_css();}, 200); 

		function switch_css(){
			if($("#"+get_param('edit_page_layout_view_module')).attr('class')=='module_div cloud_exe_show_module_div_1'){
				$("#"+get_param('edit_page_layout_view_module')).attr('class','module_div cloud_exe_show_module_div_2');
			}else{
				$("#"+get_param('edit_page_layout_view_module')).attr('class','module_div cloud_exe_show_module_div_1');
			}
		}
	}
		if($("textarea[id='content']").length==0){
		if($("#layout_inner").height()<$(window).height()){$("#layout_inner").height($(window).height());$("#layout_out").height($(window).height());}
		main_height=$("#layout_inner").height()-$("#layout_top").height()-$("#layout_bottom").height();
		if($("#layout_inner").height()>$(window).height()){main_height=0;}
		if($("#layout_space").length>0){
			max_height=Math.max($("#layout_left").height(),$("#layout_right").height(),main_height);
			$("#layout_left").css('min-height',max_height);
			$("#layout_space").css('min-height',max_height);
			$("#layout_right").css('min-height',max_height);
		}else if(main_height>0){
			$("#layout_full").height(main_height);
		}
	}
});

/**---------------------------------**/
$(window).scroll(function(){
	success_animate();
});
$(window).click(function(){
	success_animate();
});
//$(window).mousemove(function(){
//	success_animate();
//});
$(window).mouseout(function(){
	success_animate();
});

function success_animate(){
	$(".success").animate({
		 opacity: 'hide'
	}, 1000)
}