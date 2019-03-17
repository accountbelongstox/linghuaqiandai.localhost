<div id=<?php echo $module['module_name'];?>  cloud-module="<?php echo $module['module_name'];?>">
<script>
$(document).ready(function(){
	last_right=$('.nv_ul').width()-$("#<?php echo $module['module_name'];?> .nv_ul > li:last").offset().left;
	$("#<?php echo $module['module_name'];?> .nv ul li:last-child").children('ul').css('right',last_right);
	$("#<?php echo $module['module_name'];?> .nv ul li ul").each(function(index, element) {
        if($(this).children('li').length>3){
			$(this).addClass('multiple_columns');	
		}
    });
	if($("#<?php echo $module['module_name'];?> .nv_ul > li:last-child").children('ul').attr('class')=='multiple_columns'){
		
		$("#<?php echo $module['module_name'];?> .nv_ul > li:last-child").children('ul').css('right',last_right);
	}
	
	
	$("#<?php echo $module['module_name'];?> .multiple_columns li").each(function(index, element) {
        if($(this).children('ul').html()){
			$(this).addClass('have_three');	
		}
    });
	$("#<?php echo $module['module_name'];?> .multiple_columns li").each(function(index, element) {
        if($(this).children('ul').html()){
			$(this).addClass('have_three');	
		}
    });
	$("#<?php echo $module['module_name'];?> .nv li").hover(function(){
		
		if($(this).children('ul').html()){
			if($(this).children('ul').width()<$(this).width()){$(this).children('ul').css('width',$(this).width());}	
		}	
	});
	
	$("#<?php echo $module['module_name'];?> .multiple_columns").parent().hover(function(){
		
		if(!$(this).next('li').html()){
			//$(this).children('.multiple_columns').css('left',$(this).width());	
		}
		if($(this).children('.multiple_columns').height()>$(window).height()){
			$(this).children('.multiple_columns').css('width',$(window).width()-200);
			if($(this).children('.multiple_columns').css('left')!='0px'){
				
				$(this).children('.multiple_columns').BlocksIt({
					numOfCol: 5,
					offsetX: 8,
					offsetY: 8,
					blockElement: 'li'
				});
			}
			$(this).children('.multiple_columns').css('left','0px');	
		}
			
	});
	if(touchAble){
		$("#<?php echo $module['module_name'];?> .nv_ul i").each(function(index, element) {
			if($(this).parent('a').next('ul').children('li').children('a').attr('href')!=$(this).parent('a').attr('href')){
				$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html());
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').parent('li').hover(function(){
				$(this).parent('a').next().css('display','block');
			},function(){
				$(this).parent('a').next().css('display','none');	
		});	
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').click(function(){
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-down").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-right").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());
			}
			return false;
		});
	}
});
</script>
<!--头部导航-->
    <div class=nv user_color=shape_head>
        <div class="container">
			<div class="nv_left"><a href="/" ><img src="/images/logo.png" title="信贷云" /></a></div>
			<div class="nv_right"><ul class=nv_ul ><?php echo $module['data'];?></ul></div>
		</div>
    </div>
    
</div>


