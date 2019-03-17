<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		if('<?php echo $module['weixin_auto_login']?>'=='0' || !isWeiXin()){
			$("#<?php echo $module['module_name'];?> .unlogin").css('display','inline-block');	
		}

    });	
	
	</script>
    
    
    
    
    <style>
	#index_foot,#index_device{ display:none;}
	.container{ }
    #<?php echo $module['module_name'];?>{background:<?php echo $_POST['cloud_user_color_set']['container']['background']?>;}
    #<?php echo $module['module_name'];?>_html{ margin:0px; box-shadow: 0px 1px 1px 1px rgba(0, 0, 0, 0.1); margin-bottom:0.5rem; background:#fff; }
	
	#<?php echo $module['module_name'];?>_html .head_user_info{}
	#<?php echo $module['module_name'];?>_html .head_user_info .bg{ max-height:13rem; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .head_user_info .bg img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo{ margin-top:-4.5rem;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .icon{ display:inline-block; vertical-align:top; width:35%; overflow:hidden; text-align:center;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .icon img{ width:70%; border-radius:50%; border:#FFF 3px solid; }
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo{display:inline-block; vertical-align:top; width:65%; overflow:hidden;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top{  height:4.5rem; color:#fff;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top a{color:#fff;	}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .m_nickname{ line-height:2.5rem; font-weight:bold; font-size:1.5rem; display:block; width:60%;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .m_nickname:after{font: normal normal normal 1rem/1 FontAwesome;margin-left: 10px;content: "\f040";}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .group{}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .unlogin{ float:right;  padding-right:0.5rem; display:none;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_top .unlogin:after{font: normal normal normal 18px/1 FontAwesome;margin-left: 5px;content: "\f08b";}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom{ padding-top:0.5rem; padding-bottom:0.5rem;} 
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom a{ display:inline-block; vertical-align:top; width:33%; text-align:center; border-right:1px solid #d3d3d3;overflow:hidden;} 
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom a:last-child{ border:none;}
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom a span{ display:block; } 
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom a .value{font-size:1.3rem; } 
	#<?php echo $module['module_name'];?>_html .head_user_info .icon_uinfo .uinfo .u_bottom a .name{ } 
	
	
	#<?php echo $module['module_name'];?> .background_mode_1{list-style:none; line-height:2rem; padding-top:1rem; }
	#<?php echo $module['module_name'];?> .background_mode_1 ul{ list-style:none; background:#fff;}
	#<?php echo $module['module_name'];?> .background_mode_1 li{ list-style:none;background:#fff;  }
	#<?php echo $module['module_name'];?> .background_mode_1 li a{ background:#fff; color:#000; }
	#<?php echo $module['module_name'];?> .background_mode_1 li a .value_int{ display:inline-block; vertical-align:top;  border-radius:50%; text-indent:0px; width:1.5rem; text-align:center; height:1.5rem; line-height:1.5rem; margin-top:0.8rem; margin-right:0.8rem; float:right; font-size:1rem;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 li a .value_str{ display:inline-block; vertical-align:top;height:2rem; line-height:2rem; margin-top:1rem; margin-right:0.8rem; float:right; opacity:0.3; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li:first-child{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li{ line-height:2rem; font-size:1rem; list-style:none;   margin-bottom:1rem; border-bottom:1px solid #d7d7d7; white-space:nowrap;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li:before{ font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f04c";  margin-left:0px; display:inline-block; vertical-align:top; width:3%; overflow:hidden;color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a{border-bottom:1px solid #d7d7d7; display:inline-block; vertical-align:top; width:97%; overflow:hidden; margin-left:-3%; text-indent:1rem;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a img{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > a i{ display:none;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul{list-style:none; line-height:4rem; font-size:1.2rem; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li{ white-space:nowrap;list-style:none;border-bottom:1px  dashed #d7d7d7; display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li:after{font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f105";  }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li:first-child{ display:none; }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li a{ text-indent:2rem; display:inline-block; vertical-align:top; width:95%;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li a img{ width:2rem;  border-radius:20%; margin-right:0.4rem; background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul{ }
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li{ white-space:nowrap;list-style:none;border-bottom:1px  dashed #d7d7d7; display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li:after{font: normal normal normal 2rem/1 FontAwesome;margin-right: 5px;content:"\f105";  }	
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li:first-child{ display:block;}
	#<?php echo $module['module_name'];?> .background_mode_1 > li > ul >li >ul > li a{ text-indent:4rem; display:inline-block; vertical-align:top; width:95%;}

	.no_after:after{ display:none !important;}
	.no_after{ display:block !important;}
	.sum_card{ display:none;}
    </style>
    
    <div id="<?php echo $module['module_name'];?>_html">
        <div class=head_user_info>
        	<div class=bg><img src="<?php echo $module['banner_path']?>" /></div>
            <div class=icon_uinfo>
            	<div class=icon><a href="/index.php?cloud=index.personal_center"><img alt="" class="user_icon" src="/upload/index/user_icon/default.png"></a></div><div class=uinfo>
                	<div class=u_top>
                    	<a href='/index.php?cloud=index.edit_user' class=m_nickname><?php echo $module['user']['nickname']?></a>
                        <span class=group><?php echo $module['user']['group']?></span> <a class="unlogin" href="/receive.php?target=index::user&act=unlogin" class="icon-logout"><span><?php echo self::$language['unlogin_short'];?></span></a>
                    </div>
                    <div class=u_bottom>
                    	<a href="/index.php?cloud=index.money_log"><span class=value><?php echo $module['user']['money']?></span><span class=name><?php echo self::$language['user_money']?></span></a><a href="/index.php?cloud=index.credits_log"><span class=value><?php echo $module['user']['credits']?></span><span class=name><?php echo self::$language['credits']?></span></a><a href="/index.php?cloud=index.site_msg_addressee"><span class=value><?php echo $module['msg'];?></span><span class=name><?php echo self::$language['site_msg']?></span></a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    
    <ul class=background_mode_1></ul>
    
    
    
    
	<script src="/public/idangerous.swiper.js"></script>
    <link rel="stylesheet" href="/public/idangerous.swiper.css">
    <script>
    $(document).ready(function(){
		html='';
		temp='(<?php echo $module['data'];?>)';
		if(temp!='()'){
			arr=eval(temp);
			index=1;
			page_size=8;
			page=1;
			html_sub='';
			for(i in arr){
				if(!arr[i]['name']){continue;}
				html_sub+='<a class="c_'+index+'" href="'+arr[i]['url']+'" target="'+arr[i]['open_target']+'"><span class=icon><img src="'+arr[i]['icon_path']+'" /></span><span class=name>'+arr[i]['name']+'</span></a>';
				if(index%page_size==0){
					html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
					page++;
					html_sub='';
				}
				index++;
			}
			index--;
			if(index%page_size!=0){
				html+='<div class="page_'+page+' swiper-slide">'+html_sub+'</div>';
			}
			if(index<5){$('.swiper-container').css('height',$('.swiper-container').height()/2+20);}
			//alert(index);
			$("#<?php echo $module['module_name'];?> .swiper-wrapper").html(html);
			
		  var mySwiper = new Swiper('.swiper-container',{
			pagination: '.pagination',
			loop:true,
			grabCursor: true,
			paginationClickable: true
		  })
			if($("#<?php echo $module['module_name'];?> .pagination span").length==1){$("#<?php echo $module['module_name'];?> .pagination").css('display','none');}
			$(".sum_card").css('display','inline-block');
		}else{
			$("#<?php echo $module['module_name'];?> .swiper-container").css('display','none');
			$("#<?php echo $module['module_name'];?> .background_mode_1").html($(".nv_ul").html());	
			
			$("#more_admin").next('ul').children('li').css('display','block');
			$("#<?php echo $module['module_name'];?> .background_mode_1 li ul li").each(function(index, element) {
                if($(this).children('ul').html()){$(this).addClass('no_after');}
            });
			
			$("#<?php echo $module['module_name'];?> .background_mode_1 a").each(function(index, element) {
				//if($(this).attr('href')=='#' || $(this).attr('href')==''){return false;}
                obj=$(".sum_card a[href='"+$(this).attr('href')+"']");
				if(obj.html()){
					v_a=obj.children('.big_num').html();	
					v_b=obj.children('.value').html();	
					
					if(v_a){
						v=v_a;
					}else{
						v=v_b;	
					}
					if(parseInt(v)==0){return false;}
					if($.isNumeric(v) && parseInt(v)<100){
						$(this).html($(this).html()+'<span class=value_int>'+v+'</span>');
					}else{
						$(this).html($(this).html()+'<span class=value_str>'+v+'</span>');
					}
				}
            });
		}
			
		
		
    });
    </script>

	<style>
	.container { background:<?php echo $_POST['cloud_user_color_set']['container']['background']?>  !important;}
    #<?php echo $module['module_name'];?> .swiper-container{  padding-top:0.5rem; padding-bottom:0.5rem; background:<?php echo $_POST['cloud_user_color_set']['head']['background']?>;}
	#<?php echo $module['module_name'];?> .swiper-wrapper div a{ display:inline-block; vertical-align:top; text-align:center;  width:25%;  margin-top:0.2rem; }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a:hover{  }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a span{ display:block;}
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .icon{ }
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .icon img{ width:60%; border:0px; border-radius:25%;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>;}
	#<?php echo $module['module_name'];?> .swiper-wrapper div a .name{ line-height:2rem; }

	
		
	.swiper-slide{ padding:0px; margin:0px; overflow:hidden;}
	
	.swiper-container {
		height:14rem;
	  width: 100%;
	  overflow:hidden;
	  margin-bottom:1rem;
	}
	.content-slide {
	  
	 
	}
	.pagination { text-align:center; margin:0px !important;	  width: 100%;
	}
	.swiper-pagination-switch {
	  display: inline-block;
	  width:8px;
	  height: 8px;
	  border-radius: 8px;
	  background: #999;
	  box-shadow: 0px 2px 4px #555 inset;
	  margin: 0 8px;
	  cursor: pointer;
	}
	.swiper-active-switch {
	  background: #fff;
	}

	
    </style>
    <div class="swiper-container">
      <div class="swiper-wrapper">
      	
      </div>
     
    </div>
    <div class="pagination"></div>
    

    
    
</div>

