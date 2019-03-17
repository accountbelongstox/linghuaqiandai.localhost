<style type="text/css">
	<?php require("./include/return_data/css/admin_css.php");?>
</style>
<link type="text/css" rel="stylesheet" href="/css/admin_css.css" />
<div id=<?php echo $module['module_name'];?> cloud-module="<?php echo $module['module_name'];?>" >
<div class="page-header-top">
		<div class="container" style="z-index:9999999999;">
			<div class="page-logo">
				<a href="/index.php" class=logo><img src="/images/logo.png"></a>
                <div class=head_diy_container>
                
                </div>
			</div><div class="top-menu">
				<ul>
					
					<li class="user_info">
                    	<a href="/index.php?cloud=index.user">
                            <img alt="" class="user_icon" src="/upload/index/user_icon/default.png">
                            <span class="username username-hide-mobile"><span class=nickname></span></span>
						</a>
						<ul class="user_edit_list">
							<li><a href="/index.php?cloud=index.edit_user"><?php echo self::$language['pages']['index.edit_user']['name']?></a></li>
							<li><a href="/index.php?cloud=index.edit_phone"><?php echo self::$language['pages']['index.edit_phone']['name']?></a></li>							
							<li><a href="/index.php?cloud=index.edit_email"><?php echo self::$language['pages']['index.edit_email']['name']?></a></li>
							<li><a href="/index.php?cloud=index.edit_user&field=password"><?php echo self::$language['pages']['index.edit_user&field=password']['name']?></a></li>
							<li><a href="/index.php?cloud=index.edit_user&field=transaction_password"><?php echo self::$language['pages']['index.edit_user&field=transaction_password']['name']?></a></li>
							<li><a href="/index.php?cloud=index.site_msg_addressee"><?php echo self::$language['pages']['index.site_msg_addressee']['name']?></a></li>
							<li><a href="/index.php?cloud=index.login_log"><?php echo self::$language['pages']['index.login_log']['name']?></a></li>
							<li><a href="/index.php?cloud=index.user_set"><?php echo self::$language['pages']['index.user_set']['name']?></a></li>
							<li><a href="/index.php?cloud=index.my_oauth"><?php echo self::$language['pages']['index.my_oauth']['name']?></a></li>
							<li><a href="/index.php?cloud=index.financial_center"><?php echo self::$language['pages']['index.financial_center']['name']?></a></li>
						</ul>
					</li>
                    <li class="fadeIn animated infinite  user_msg "><a href="/index.php?cloud=index.site_msg_addressee"></a></li>
                    <li class="unlogin"><a href="/receive.php?target=index::user&act=unlogin" class="icon-logout"></a>
	                </li>
				</ul>
			</div>
		</div>
	</div>
<script>
    str='<?php echo $module['user_json']?>';
var user_info=eval("("+str+")"); 
 jQuery(document).ready(function() {
	 //user_info.msg=5;
	 if(user_info.msg>0){
		if($(".msg_div .user_msg").attr('href')){
			$(".user_msg").html(user_info.msg).css('display','block');
		}else{
			
			$(".user_msg a").html(user_info.msg).css('display','block');
		}
			 
	 }else{$(".user_msg").css('display','none');}    
     $('#<?php echo $module['module_name'];?> .nickname').html(user_info.nickname+'/'+user_info.group);
     $('.user_icon').attr('src',user_info.icon);   
     $('.unlogin a').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
     $('.unlogin').click(function(){
        $.get($(this).attr('href'),function(data){unlogin(data);});
        return false;
     });
  });   
</script>










<script type="text/javascript">
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?> .nv > div > ul > li > ul").each(function(index, element) {
        if($(this).children('li').length>10){
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
<style>
#<?php echo $module['module_name'];?>  {}
#<?php echo $module['module_name'];?> .nv{ text-align:left; margin:0px; padding:0px; height:50px; height:3.572rem; line-height:50px;line-height:3.572rem;   font-size:1rem;   white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv a{ white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv .nv_ul{ width:75%;}
#<?php echo $module['module_name'];?> .nv > ul{  white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv ul ul {display: none;}
#<?php echo $module['module_name'];?> .nv ul li:hover > ul {display: block;}
#<?php echo $module['module_name'];?> .nv ul {list-style: none;position: relative;display: inline-block;white-space:nowrap;}
#<?php echo $module['module_name'];?> .nv ul:after {content: ""; clear: both; display: block;}
#<?php echo $module['module_name'];?> .nv ul > li { display: inline-block;text-align: center; }
#<?php echo $module['module_name'];?> .nv ul li:hover {background: #0b7cd2;}
#<?php echo $module['module_name'];?> .nv ul li:hover a {}
#<?php echo $module['module_name'];?> .nv ul li a {display: block; text-decoration: none; padding-left:20px; padding-right:20px;}
#<?php echo $module['module_name'];?> .nv ul li a i{ padding-left:5px;}
#<?php echo $module['module_name'];?> .nv ul ul {line-height:40px;line-height:2.85rem;background: #0b7cd2; border-radius: 0px; padding: 0;position: absolute; top: 100%;}
#<?php echo $module['module_name'];?> .nv ul ul li { display:block; width:100%;float: none;position: relative; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul ul li a {}	
#<?php echo $module['module_name'];?> .nv ul ul li a i{ float:right;line-height:40px;line-height:2.85rem; margin-left:10px;}
#<?php echo $module['module_name'];?> .nv ul ul li a .fa-angle-right{ padding-right:10px;	}
#<?php echo $module['module_name'];?> .nv ul ul li:hover {background:#84adff;}
#<?php echo $module['module_name'];?> .nv ul ul ul {width:100%;position: absolute; left: 100%; top:0; }
#<?php echo $module['module_name'];?> .nv ul ul ul li:hover{}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul{ left:-100%; text-align:right;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}

#<?php echo $module['module_name'];?> .nv ul li .have_three	{ font-weight:bold; margin-bottom:20px;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	li{ font-weight: normal;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three:hover{ background:none; }
#<?php echo $module['module_name'];?> .nv ul li .have_three > a{ border-bottom:#fff 1px dashed;}
#<?php echo $module['module_name'];?> .nv ul li .have_three a:hover{background:#84adff; }
#<?php echo $module['module_name'];?> .nv ul li .have_three	ul{background: #0b7cd2;  }
#<?php echo $module['module_name'];?> .nv ul li .have_three	i{ display:none; }

#<?php echo $module['module_name'];?> .nv ul li .multiple_columns{ width:600px; height:auto; white-space:normal; text-align:left; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li{display:inline-block;  height:auto; border-top:none; vertical-align:top; width:200px; padding-left:10px; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li a{ display:block; text-align:left;}
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul{ display:block; position:static;  height:auto; white-space:normal; }
#<?php echo $module['module_name'];?> .nv ul li .multiple_columns li ul li{  display:block; width:100%; height:32px; line-height:32px; height:2.3rem; line-height:2.3rem;}
#<?php echo $module['module_name'];?> .nv ul li:last-child:hover >  ul li ul a{padding-right: 25px ;}
#<?php echo $module['module_name'];?> .nv .nv_search{ display:inline-block; vertical-align:top; width:25%; }
#<?php echo $module['module_name'];?> .nv .nv_search .input-group { margin-top:8px;margin-top:0.57rem; width:80%; float:right;}
#<?php echo $module['module_name'];?> .nv .nv_search .input-group button { margin-top:-16px;}
#<?php echo $module['module_name'];?> .nv .nv_search .input-group input { height:2.4rem;}
@media (min-width:1900px){
	#<?php echo $module['module_name'];?> .nv .nv_search .input-group { margin-top:12px;margin-top:0.8rem; }
	#<?php echo $module['module_name'];?> .nv .nv_search .input-group button {margin-top:-1.2rem; height:2.45rem; }
}
.user_edit_list{ }
</style>

<div class=nv>
<ul class=nv_ul ><?php echo $module['map'];?></ul>
</div>
</div>