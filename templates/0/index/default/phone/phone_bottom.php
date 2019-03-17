<div id=<?php echo $module['module_name'];?> cloud-module="<?php echo $module['module_name'];?>" >
<script>
$(document).ready(function(){
	if(<?php echo $module['request_geolocation'];?>==1){
		if (navigator.geolocation){navigator.geolocation.getCurrentPosition(showPosition);}
		function showPosition(position){
			v=(position.coords.latitude+<?php echo $module['gps_y']?>)+','+(position.coords.longitude+<?php echo $module['gps_x']?>)+','+position.coords.accuracy;
			$.post('<?php echo $module['action_url'];?>&act=geolocation',{v:v}, function(data){
				//alert(data);
			});
		  
		}
	}
	
	function set_cloud_bottom_current(){
		$('.cloud_bottom a').removeClass('current');
		if(get_param('m')!=''){
			$('.cloud_bottom [cloud="'+get_param('m')+'"]').addClass('current');
		}else{
			$('.cloud_bottom [cloud="index.index"]').addClass('current');
		}
	}
	set_cloud_bottom_current();
	
	if(get_param('show_cloud_head')!=''){
		if(get_param('show_cloud_head')=='1'){
			setCookie('show_cloud_head','1',300);	
		}else{
			setCookie('show_cloud_head','0',300);	
		}	
	}
	if(getCookie('show_cloud_head')==1){$(".cloud_head").css('display','block');$(".page-container").css('padding-top',$(".cloud_head").height());}
	if((getCookie('cloud_bottom')===false || getCookie('cloud_bottom')=='')  && <?php echo $module['phone_show_cloud_bottom'];?>==1){setCookie('cloud_bottom','1',300);}
	
	if(getCookie('cloud_bottom')==1){
		$(".cloud_bottom").css('left','0px');
		$(".cloud_bottom_switch i").addClass('fa-angle-right');
		$(".cloud_bottom_switch i").removeClass('fa-angle-left');
	}else{
		$(".cloud_bottom").css('left','100%');
		$(".cloud_bottom_switch i").addClass('fa-angle-left');
		$(".cloud_bottom_switch i").removeClass('fa-angle-right');
	}
	if($(".page_name").html()==''){
		temp=$('title').html().split('_');
		if(!temp[1]){temp=$('title').html().split('-');}
		if(!temp[1]){temp=$('title').html().split(' ');}
		if(temp[0]=='' || temp[0]==' '){temp[0]=$('title').html();}
		$(".page_name").html(temp[0]);
	}
	
	$('.right_nv_div').append($('.nv_ul'));
	$(".nv_ul").prepend('<li class="right_serach" general_search=1><input type="text"  placeholder="<?php echo $module['search_placeholder'];?>" url="<?php echo $module['search_url']?>" /><span class="fa fa-search"  search_button=1></span></li>');   
	$(".nv_ul").css('height',$(window).height()).css('width',$(".nv_ul").parent().width());
	$("#<?php echo $module['module_name'];?> .nv_ul a .fa-angle-right").each(function(index, element) {
        $(this).removeClass('fa-angle-right');
        $(this).addClass('fa-angle-down');
    });
	
	$(".cloud_bottom_switch").click(function(){
		//alert($(document).scrollLeft());
		if($(".cloud_bottom").offset().left-$(document).scrollLeft()==0){
			$(this).children('i').addClass('fa-angle-left');
			$(this).children('i').removeClass('fa-angle-right');
			$(".cloud_bottom").animate({left:'100%'},'fast');	
			$(".right_nv_div").animate({right:'-100%'},'fast');	
			$(".cart_goods_sum").css('display','none');
			setCookie('cloud_bottom','0',300);
		}else{
			$(".cloud_bottom").animate({left:'0'},'fast');
			$(this).children('i').addClass('fa-angle-right');
			$(this).children('i').removeClass('fa-angle-left');
			$(".cart_goods_sum").css('display','block');
			setCookie('cloud_bottom','1',300);
		}
		return false;	
	});
	
	$(".bottom_show_more").click(function(){
		if($(".right_nv_div").css('right')=='0px'){
			$(".right_nv_div").animate({right:'-100%'},'fast');
			set_cloud_bottom_current();	
		}else{
			$(".right_nv_div").animate({right:'0px'},'fast');
			$('.cloud_bottom a').removeClass('current');
			$(this).addClass('current');
		}
		return false;	
	});
	
	
		$("#<?php echo $module['module_name'];?> .nv_ul i").each(function(index, element) {
			if($(this).parent('a').next('ul').children('li').children('a').attr('href')!=$(this).parent('a').attr('href')){
				if($(this).parent('a').children('span').html()){$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html()); 	}
				
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').click(function(){
			if($(this).next('ul').css('display')=='none'){
				$(this).next('ul').css('display','block');
			}else{
				$(this).next('ul').css('display','none');
			}
			return false;
		});
	$(".right_nv_div").preventScroll();
	
	$("[general_search] input").keyup(function(event){
		keycode=event.which;
		if(keycode==13){
			if($(this).val()!=''){
				window.location.href=$(this).attr('url')+$(this).val();	
			}
		}	
	});
	$("[general_search] [search_button]").click(function(event){
		if($("[general_search] input").val()!=''){window.location.href=$("[general_search] input").attr('url')+$("[general_search] input").val();}
		return false;
	});
	
	if($("#<?php echo $module['module_name'];?> a[href='/index.php?cloud=mall.buyer']").html()){
		$("#<?php echo $module['module_name'];?> a[cloud='index.user']").addClass('current');	
	}
});
</script>
<style>
.page-footer{padding-bottom:3.5rem;}	
#<?php echo $module['module_name'];?>{}
#<?php echo $module['module_name'];?>_html{}
.cloud_bottom{ width:100%; height:3.57rem; line-height:3.57rem; position:fixed; bottom:0px; left:100%; box-shadow: 0px -2px 1px 1px rgba(0, 0, 0, 0.1); z-index:999999; background:#fff;color: #777;}
.cloud_bottom a{ padding-top:3px; display:inline-block; vertical-align:top; width:19%; text-align:center;color: #777; }
.cloud_bottom a i{ font-size:1.6rem;  display:block; }
.cloud_bottom .current{color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;  }
.cloud_bottom a span{ line-height:1.2rem; display:block; font-size:0.8rem; }
.cloud_bottom_switch{ position:fixed; bottom:0px;right:0px;height:3.57rem; width:2.57rem; text-align:center; line-height:3.57.rem; font-size:2.5rem; z-index:999999999999999999;color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?> !important;}
.right_nv_div{ position:fixed;  height:100%;  overflow:scroll;  width:60%;right:-100%; top:0px;z-index:99999; background:<?php echo $_POST['cloud_user_color_set']['nv_1']['background']?>; }
.nv_ul{ margin:0px; padding-left:1rem; padding-bottom:3.57rem; overflow: visible;  width:100%; vertical-align:bottom; display: table-cell;}
.nv_ul a{ white-space:nowrap;}
.nv_ul a i{ padding-left:2px;}
.nv_ul li{list-style:none; }
.nv_ul li ul{display:none; padding-left:3rem;}
.nv_ul > li{ display:block; list-style:none; line-height:3rem; border-bottom:#ccc 1px dashed;}
.nv_ul > li > a{display:block;}
.nv_ul li  a  img{ display:none;}
.nv_ul > li > a > span{ }
.nv_ul > li > ul > li{  display:block; list-style:none; line-height:2.5rem; border-bottom:#ccc 1px dashed; }

.right_serach{ line-height:3rem; height:3rem;}
.right_serach input{ width:70%;}
.right_serach span{ padding-left:1rem;display:inline-block; width:25%; line-height:3rem;}

.cloud_head{ display:none; position:fixed;top:0px; width:100%; white-space:nowrap; line-height:3rem; height:3rem;text-align:center;  box-shadow: 0px 2px 1px 1px rgba(0, 0, 0, 0.1); z-index:9; background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>;}
.cloud_head a{ font-size:2rem;}
.cloud_head a:hover{ }
.cloud_head .return_last_page{ display: inline-block; vertical-align:top; width:15%; padding-right:5%; height:100%; line-height:3rem;}
.cloud_head .page_name{ display: inline-block; vertical-align:top; width:70%; overflow:hidden; height:100%; line-height:3rem;text-overflow: ellipsis;}
.cloud_head .refresh{ display: inline-block; vertical-align:top; width:15%;padding-left:5%;   height:100%; line-height:3rem; font-size:1.3rem; font-weight:100; }
.cloud_head .home{ text-align:left; display: inline-block; vertical-align:top; width:15%;padding-left:2%;   height:100%; line-height:3rem; font-size:1rem; font-weight:100; }
.cloud_head .home:before{margin-right:2px; font: normal normal normal 1.1rem/1 FontAwesome; content:"\f015";}

</style>
    <div id="<?php echo $module['module_name'];?>_html">  
    	<div class=cloud_head><a href="javascript:history.back(-1)" class="fa fa-angle-left return_last_page"></a><span class=page_name></span><a href="javascript:window.location.reload();" class="fa fa-refresh refresh"></a></div>
		<div class=right_nv_div></div>
	 	<div class=cloud_bottom>
       
        	<?php echo $module['data'];?>
        </div>
        
        <a class=cloud_bottom_switch><i class="fa fa-angle-right"></i></a>
    </div>
</div>

