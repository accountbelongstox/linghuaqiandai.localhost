<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
	<script>
	var replace_file='';
    $(document).ready(function(){
		$("#close_button").click(function(){
			$("#fade_div").css('display','none');
			$("#set_cloud_iframe_div").css('display','none');
			$("img[src='"+replace_file+"']").attr('src',replace_file+"?&reflash="+Math.random());
			return false;
		});
		$('.replace').click(function(){
			replace_file=$(this).attr('file');
			set_iframe_position($(window).width()-100,$(window).height()-200);
			//cloud_alert(replace_file);
			$("#fade_div").css('display','block');
			$("#set_cloud_iframe_div").css('display','block');
			$("#cloud_iframe").attr('src','index.php?cloud=index.replace_file&path='+replace_file+'&width='+$(this).attr('img_width')+'&height='+$(this).attr('img_height'));
			return false;	
		});
		
            
    });
    </script>
    

    <style>
	#<?php echo $module['module_name'];?>_html{ }
	#<?php echo $module['module_name'];?> fieldset{ margin:20px; display:inline-block; text-align:center;}
	#set_cloud_iframe_div{top:40%; left:420px; }
	#cloud_iframe{ height:100px;width:500px;}
	legend{ }
    </style>
    <div id="<?php echo $module['module_name'];?>_html">
    
    	<fieldset><legend><?php echo self::$language['web_logo'];?>(400*150 png) <a href=# class="replace" file='/images/logo.png' img_width='400' img_height='150' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/logo.png">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['phone_logo'];?>(360*85 png) <a href=# class="replace" file='/images/phone_logo.png' img_width='360' img_height='85' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/phone_logo.png">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['web_icon'];?>(32*32 ico) <a href=# class="replace" file='./favicon.ico' img_width='' img_height='' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/favicon.ico">
        </fieldset>
    	<fieldset><legend><?php echo self::$language['pc_user_position_icon'];?>(25*25 png) <a href=# class="replace" file='/images/pc_user_position_icon.png' img_width='25' img_height='25' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/pc_user_position_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['phone_user_position_icon'];?>(50*50 png) <a href=# class="replace" file='/images/phone_user_position_icon.png' img_width='50' img_height='50' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/phone_user_position_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['phone_menu_icon'];?>(128*128 png) <a href=# class="replace" file='/images/phone_menu_icon.png' img_width='128' img_height='128' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/phone_menu_icon.png">
        </fieldset>
    
    	<fieldset><legend><?php echo self::$language['login_bg'];?>( png) <a href=# class="replace" file='./login_bg.png' img_width='0' img_height='0' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/login_bg.png" style="width:100%;">
        </fieldset>
        
    	<fieldset><legend><?php echo self::$language['regist_bg'];?>( png) <a href=# class="replace" file='/images/regist_bg.png' img_width='0' img_height='0' ><?php echo self::$language['replace'];?></a></legend>
        <img src="/images/regist_bg.png" style="width:100%;">
        </fieldset>
    </div>
</div>
