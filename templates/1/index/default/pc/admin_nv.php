
<link type="text/css" rel="stylesheet" href="/css/admin_css.css" />
<style type="text/css">
	<?php require("./include/return_data/css/admin_css.php");?>
	<?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<!--左侧工具栏-->
<?php require("./templates/1/left_bar.php");?>
<script type="text/javascript" src="/js/table_global.js" charset="utf-8"></script>
<div id=<?php echo $module['module_name'];?> cloud-module="<?php echo $module['module_name'];?>" >
<div class="page-header-top">
			<div class="top-menu">
				<ul>
					
					<li class="user_info">
                    	<a href="/index.php?cloud=index.user">
                            <img alt="" class="user_icon" src="/upload/index/user_icon/default.png">
                            <span class="username username-hide-mobile"><span class=nickname></span></span>
						</a>
						<ul class="user_edit_list">
							<li><a href="/index.php?cloud=index.edit_user"><?php echo self::$language['pages']['index.edit_user']['name']?></a></li>
							<li><a href="/index.php?cloud=index.openid"><?php echo self::$language['pages']['index.openid']['name']?></a></li>							
							<li><a href="/index.php?cloud=index.edit_phone"><?php echo self::$language['pages']['index.edit_phone']['name']?></a></li>							
							<li><a href="/index.php?cloud=index.edit_email"><?php echo self::$language['pages']['index.edit_email']['name']?></a></li>
							<li><a href="/index.php?cloud=index.edit_user&field=password"><?php echo self::$language['pages']['index.edit_user&field=password']['name']?></a></li>
							<li><a href="/index.php?cloud=index.edit_user&field=transaction_password"><?php echo self::$language['pages']['index.edit_user&field=transaction_password']['name']?></a></li>
							<li><a href="/index.php?cloud=index.site_msg_addressee"><?php echo self::$language['pages']['index.site_msg_addressee']['name']?></a></li>
							<li><a href="/index.php?cloud=index.login_log"><?php echo self::$language['pages']['index.login_log']['name']?></a></li>
							<li><a href="/index.php?cloud=index.user_set"><?php echo self::$language['pages']['index.user_set']['name']?></a></li>
							<li><a href="/index.php?cloud=index.my_oauth"><?php echo self::$language['pages']['index.my_oauth']['name']?></a></li>
							<li><a href="/index.php?cloud=index.financial_center"><?php echo self::$language['pages']['index.financial_center']['name']?></a></li>
							<li><a href="/index.php?cloud=index.credits_log"><?php echo self::$language['pages']['index.credits_log']['name']?></a></li>
						</ul>
					</li>
                    <li class="fadeIn animated infinite  user_msg "><a href="/index.php?cloud=index.site_msg_addressee"></a></li>
                    <li class="unlogin"><a href="/receive.php?target=index::user&act=unlogin" class="icon-logout"></a>
	                </li>
				</ul>
			</div>
	</div>
<script>
	str='<?php echo $module['user_json']?>';
	var user_info=eval("("+str+")"); 
	jQuery(document).ready(function() {
	if($(".newest_user_msg").html()){
		user_info.msg=parseInt($(".newest_user_msg").html());
	}	
	 
	 if(user_info.msg>0){
		if($(".user_info .msg_div .user_msg").attr('href')){
			$(".user_info .user_msg").html(user_info.msg).css('display','block');
		}else{
			
			$(".user_msg a").html(user_info.msg).css('display','block');
		}
	 }else{$(".user_msg").css('display','none');}
     $('.user_info .nickname').html(user_info.nickname+'/'+user_info.group);
     $('.user_info .user_icon').attr('src',user_info.icon);   
     $('.unlogin a').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
     $('.unlogin').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
  });   
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .nv > div > ul > li > ul").each(function(index, element) {
        if($(this).children('li').length>11){
			$(this).addClass('multiple_columns');	
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
				if($(this).parent('a').children('span').html()){$(this).parent('a').next('ul').html('<li><a href='+$(this).parent('a').attr('href')+'>'+$(this).parent('a').children('span').html()+'</a></li>'+$(this).parent('a').next('ul').html());}
				
				//alert($(this).parent('a').next('ul').html());
			}
        });
		$("#<?php echo $module['module_name'];?> .nv_ul i").parent('a').parent('li').hover(function(){
				$(this).parent('a').next().css('display','block');
			},function(){
				$(this).parent('a').next().css('display','none');	
		});	
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-down").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				if($(this).children('span').html()){$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());}
				
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> .nv_ul .fa-angle-right").parent('a').click(function(){
			if($(this).next('ul').children('li').children('a').attr('href')!=$(this).attr('href')){
				if($(this).children('span').html()){$(this).next('ul').html('<li><a href='+$(this).attr('href')+'>'+$(this).children('span').html()+'</a></li>'+$(this).next('ul').html());}
			}
			return false;
		});
	}
	
	
	
	
});
</script>
<div class=nv user_color='shape_head'>
<a href="/index.php?cloud=index.user" class="yun_logo">
	<img width="242" height="48" src="/images/logo2.png"></a>
	<ul class=nv_ul ><?php echo $module['map'];?></ul>
</div>
</div>