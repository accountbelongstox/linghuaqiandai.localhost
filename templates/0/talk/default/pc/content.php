<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left save_name="<?php echo $module['module_save_name'];?>"  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		
		$("#comment_input_div_close").click(function(){$("#comment_input_div").css('display','none');});
		
		$(".content_div .m_hide").click(function(){
			var id=$(this).attr('cid');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=hide',{cid:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);				
			});        	
			return false; 
		});
		$(".content_div .m_show").click(function(){
			var id=$(this).attr('cid');
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=show',{cid:id}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);				
			});        	
			return false; 
		});
         $("#replay_input_div input").keyup(function(event){
            keycode=event.which;
            if(keycode==13){subimt_content();}	
        });
		 $("#comment_input_div input").keyup(function(event){
			keycode=event.which;
			if(keycode==13){submit_comment();}	
		});
		$("#<?php echo $module['module_name'];?> .comment_button").click(function(){
			if(getCookie('cloud_nickname')==''){window.location.href='/index.php?index.login';}
				var position=$(this).offset();
				
				$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','block').css('left',position.left+$(this).width()+5).css('top',position.top);
				if($("#<?php echo $module['module_name'];?> #comment_input_div").offset().top!=position.top){
					distance=position.top-$("#<?php echo $module['module_name'];?> #comment_input_div").offset().top;
					$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','block').css('left',position.left+$(this).width()+5).css('top',position.top+distance);
				}
				$("#<?php echo $module['module_name'];?> #comment_input_div").attr('click_id',$(this).attr('click_id'));
				$("#<?php echo $module['module_name'];?> #comment_state").html('');
			
			
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> #comment_input_div").hover(function(){
			$("#<?php echo $module['module_name'];?> [click_id='"+$(this).attr('click_id')+"']").parent('.buttons').css('display','block');
			},function(){
			$("#<?php echo $module['module_name'];?> [click_id='"+$(this).attr('click_id')+"']").parent('.buttons').css('display','block');	
		});
		
		
		$("#<?php echo $module['module_name'];?> .replay").click(function(){
			if(getCookie('cloud_nickname')==''){window.location.href='/index.php?index.login';}
			if($("#<?php echo $module['module_name'];?> #replay_input_div").css('display')=='block'){
				$("#<?php echo $module['module_name'];?> #replay_input_div").css('display','none');
			}else{
				$("#<?php echo $module['module_name'];?> #replay_input_div").css('display','block');
			}
			
		});
		
		$("#<?php echo $module['module_name'];?> #authcode").focus(function(){
			if(!$("#<?php echo $module['module_name'];?> #authcode_img").attr('src')){
				$("#<?php echo $module['module_name'];?> #authcode_img").attr('src',$("#<?php echo $module['module_name'];?> #authcode_img").attr('wsrc'));	
			}
		});
		
		$("#<?php echo $module['module_name'];?> #comment_auth").focus(function(){
			$("#<?php echo $module['module_name'];?> #comment_auth_img").attr('src',$("#<?php echo $module['module_name'];?> #comment_auth_img").attr('wsrc'));	
		});
		$.get("<?php echo $module['count_url']?>");
    });
    
    function subimt_content(){
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content").val();
		if(content==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var authcode=$("#<?php echo $module['module_name'];?> #authcode").val();
		if(authcode==''){$("#<?php echo $module['module_name'];?> #replay_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #authcode").focus();return false;}	
        var email=0;
		if($("#<?php echo $module['module_name'];?> #email").prop('checked')){email=1;}
        $("#<?php echo $module['module_name'];?> #replay_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_content',{content:content,authcode:authcode,email:email}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #replay_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #replay_input_div .submit").css('display','none');
				window.location.href=$("#<?php echo $module['module_name'];?> #replay_state .view").attr('href');
			}
        });
        return false; 	
        
    }
	
    function submit_comment(){
		var for_id=$("#<?php echo $module['module_name'];?> #comment_input_div").attr('click_id');
        var comment_input=$("#<?php echo $module['module_name'];?> #comment_input").val();
		if(comment_input==''){$("#<?php echo $module['module_name'];?> #comment_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['content']?></span>');return false;}	
        var comment_auth=$("#<?php echo $module['module_name'];?> #comment_auth").val();
		if(comment_auth==''){$("#<?php echo $module['module_name'];?> #comment_state").html('<span class=fail><?php echo self::$language['please_input']?><?php echo self::$language['authcode']?></span>');$("#<?php echo $module['module_name'];?> #comment_auth").focus();return false;}	
        
        $("#<?php echo $module['module_name'];?> #comment_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.post('<?php echo $module['action_url'];?>&act=submit_comment',{comment_input:comment_input,comment_auth:comment_auth,for_id:for_id,current_page:'<?php echo @$_GET['current_page'];?>'}, function(data){
           //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			
            $("#<?php echo $module['module_name'];?> #comment_state").html(v.info);
			if(v.state=='success'){
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth_img").attr('src',"./lib/authCode.class.php?save_name=comment_auth&r="+Math.random());
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_input").val('');
				$("#<?php echo $module['module_name'];?> #comment_input_div #comment_auth").val('');
				if(v.html){
					$(v.html).insertAfter("#<?php echo $module['module_name'];?> #content_"+for_id+" .content_content");
					$("#<?php echo $module['module_name'];?> #comment_input_div").css('display','none');
				}
				
			}
        });
        return false; 	
        
    }
	
    function del(id){
		$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$.get('<?php echo $module['action_url'];?>&act=del',{cid:id}, function(data){
			//alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#<?php echo $module['module_name'];?> #state_"+id).html(v.info);
			if(v.state=='success'){
				$("#content_"+id).animate({opacity:0},"slow",function(){$("#content_"+id).css('display','none');});
			}
		});        	
        return false; 
    }

    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
    #<?php echo $module['module_name'];?>_html{  border:1px solid #e3d1b9; padding-bottom:20px;}
	#<?php echo $module['module_name'];?>_html #comment_auth_img{ height:27px;}
	#<?php echo $module['module_name'];?>_html #authcode_img{ height:27px;}
	#<?php echo $module['module_name'];?>_html #comment_input{ border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html #comment_auth{ border:1px solid #ddd;}
	#<?php echo $module['module_name'];?>_html #authcode{box-shadow:1px 1px 3px 0px rgba(0,0,0,.1);}
	    
    #<?php echo $module['module_name'];?>_html .title_div{   height:10rem;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>; }
	#<?php echo $module['module_name'];?>_html .title_div div{ display:inline-block;} 
	#<?php echo $module['module_name'];?>_html .title_div .username{ display:inline-block; margin-top:20px; margin-left:20px;}
	#<?php echo $module['module_name'];?>_html .title_div .time{ display:inline-block; margin-left:20px;}
    #<?php echo $module['module_name'];?>_html .title_div .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .title_div .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	#<?php echo $module['module_name'];?>_html .title_div .title{ margin-left:30px; display:inline-block;}
	#<?php echo $module['module_name'];?>_html .title_div .title:before{ display:block; font: normal normal normal 2rem/1 FontAwesome; content:"\f0d8";padding-right:2px;  padding-left:0.5rem; height:1.2rem;color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .title_div .title .v{   border-radius:0.4rem; padding:0.8rem;background:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['text']?>;}
	
	#<?php echo $module['module_name'];?>_html .content_div .buttons{ display:none; margin-top:0.5rem;}
	#<?php echo $module['module_name'];?>_html .content_div .buttons a{ display:inline-block; vertical-align:top; padding:0.3rem; border-radius:0.3rem;  }
	#<?php echo $module['module_name'];?>_html .content_div .buttons a:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .content_div:hover .comment_div .buttons2 a{ display:inline-block; vertical-align:top; padding:0.3rem; border-radius:0.3rem;  }
	#<?php echo $module['module_name'];?>_html .content_div:hover .comment_div .buttons2  a:hover{ opacity:0.8;}
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content{ padding-bottom:2.2rem;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover{ padding-bottom:0px;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover .buttons{ display:block;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content:hover .comment_div .buttons2{ display:inline-block;}
	
	
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .buttons2{ display:none; margin-right:1rem;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div{ padding-left:45px; margin-top:20px; margin-bottom:20px; text-align:right; border-bottom:1px dotted #f1e8dc; padding-bottom:20px; margin-left:20px; margin-right:20px;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .username{ height:20px; line-height:20px; display:inline-block; margin-top:20px; }
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .time{  height:20px; line-height:20px;display:inline-block; margin-left:20px;}
	
   #<?php echo $module['module_name'];?>_html .content_div .comment_div .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .content_div .comment_div .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comment_content{}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt:after{font: normal normal normal 2rem/1 FontAwesome; content:"\f0da";padding-right:2px;  margin-left:-1px; height:1.2rem;color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .content_div .comment_div .comemnt .v{   border-radius:0.4rem; padding:0.8rem;background:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['text']?>;}

	
    #<?php echo $module['module_name'];?>_html .content_div{ border-bottom:1px solid #e3d1b9; padding-bottom:20px; margin-left:30px; margin-right:30px;}
    #<?php echo $module['module_name'];?>_html .content_div .comment_div div{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .content_div .content_author .username{  height:20px; line-height:20px;  display:inline-block; margin-top:20px;}
	#<?php echo $module['module_name'];?>_html .content_div .content_author .time{  height:20px; line-height:20px;  display:inline-block; margin-left:20px;}
    #<?php echo $module['module_name'];?>_html .content_div .content_author .username:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f007"; padding-right:2px;}
    #<?php echo $module['module_name'];?>_html .content_div .content_author .time:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f017";padding-right:2px;}
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content{ margin-top:5px;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer:before{ display:block; font: normal normal normal 2rem/1 FontAwesome; content:"\f0d8";padding-right:2px;  padding-left:0.5rem; height:1.2rem;color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>;}
	#<?php echo $module['module_name'];?>_html .content_div .content_content .answer .v{   border-radius:0.4rem; padding:0.8rem;background:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_1_hover']['text']?>;}
	
	
	
	#<?php echo $module['module_name'];?>_html .content_div .content_content .comment_button{ display:inline-block; margin-left:10px;}
	#<?php echo $module['module_name'];?>_html .m_hide{display:inline-block; margin-left:10px; width:auto;}
	
	#<?php echo $module['module_name'];?>_html #replay_input_div{ margin-left:40px; margin-right:40px;}
	#<?php echo $module['module_name'];?>_html .input_span{ }
	 
    #<?php echo $module['module_name'];?>_html #comment_input_div{ display:none; position:absolute;}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_input{}
    #<?php echo $module['module_name'];?>_html #comment_input_div #comment_auth{ width:60px;}
    #<?php echo $module['module_name'];?>_html #comment_input_div .submit{  margin-right:20px;}
	
    #<?php echo $module['module_name'];?>_html #replay_input_div{ display:none; }
	#<?php echo $module['module_name'];?>_html .view{ }
	#<?php echo $module['module_name'];?>_html #email{ height:13px;}
	#<?php echo $module['module_name'];?>_html #comment_input_div_close{ cursor:pointer;}
	#<?php echo $module['module_name'];?>_html .comment_div .m_hide{ display:none;}
	#<?php echo $module['module_name'];?>_html .comment_div .m_show{ display:none;}
	
	#<?php echo $module['module_name'];?>_html .title_div .replay{ float:right; margin-right:40px; display:inline-block; margin-top:28px;   border-radius:5px; padding:5px;background:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['text']?>;}
    #<?php echo $module['module_name'];?>_html .title_div .replay:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f044";padding-right:2px;}
	#<?php echo $module['module_name'];?>_html .title_div .replay:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html .replay{ display:inline-block; margin-left:20px; margin-top:15px; margin-bottom:20px;   border-radius:5px; padding:5px;background:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['background']?>; color:<?php echo $_POST['cloud_user_color_set']['nv_2_hover']['text']?>;}
    #<?php echo $module['module_name'];?>_html .replay:before{font: normal normal normal 1rem/1 FontAwesome; content:"\f044";padding-right:2px;}
	#<?php echo $module['module_name'];?>_html .replay:hover{ opacity:0.8;}

	
    </style>
    <div id="<?php echo $module['module_name'];?>_html" >
     <div class=title_div><?php echo $module['title']?><a href="#replay_input_div" class="replay"><?php echo self::$language['replay'];?></a></div>             
     <div class=content_div><?php echo $module['list']?></div>              
    <?php echo $module['page']?>
    
    <a href="#replay_input_div" class="replay"><?php echo self::$language['replay'];?></a>
    <div id=replay_input_div><textarea name="content" id="content" style="display:none; width:100%; height:200px;"></textarea>
    <br />
     <span class=m_label>&nbsp;</span><span class=input_span><input type="checkbox" id="email" name="email" /><?php echo self::$language['when_comments_remind_me'];?></span>
	<br /><br />
    <?php echo self::$language['authcode'];?> <input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" />  <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
    <br /><br /><a href="#" class="submit" onclick="return subimt_content();"><?php echo self::$language['submit']?></a> <span id=replay_state></span>
    </div>
    
    <div id=comment_input_div><span class=s>&nbsp;</span><span class=m><input type=text id=comment_input maxlength="300" size="40"/> &nbsp; &nbsp; <?php echo self::$language['authcode'];?><input type=text id=comment_auth /> <img id="comment_auth_img" src="/lib/authCode.class.php?save_name=comment_auth" style="vertical-align:middle; border:0px;" />  &nbsp; &nbsp; <a href=# onclick="return submit_comment()" class="submit"><?php echo self::$language['submit'];?></a> <span id=comment_state></span></span><span id=comment_input_div_close class="e">&nbsp;</span>
    </div>
    </div>
</div>
