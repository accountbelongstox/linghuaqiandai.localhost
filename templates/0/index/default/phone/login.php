<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    var login_count=0;
    $(document).ready(function(){
		if(!isWeiXin()){$(".icons .wx").css('display','none');}	
		$("#<?php echo $module['module_name'];?> input").keydown(function(event){
			if(event.keyCode==13){exe_check();}	
			if($(this).attr('id')=='password' && event.keyCode==9 && $("#authCode_Div").css('display')=='none'){$("#<?php echo $module['module_name'];?> #login").focus(); return false;}	  	
			if($(this).attr('id')=='authcode' && event.keyCode==9){$("#<?php echo $module['module_name'];?> #login").focus(); return false;}	  	
		});
		
		$(window).focus(function(){
			//alert(getCookie('cloud_nickname'));
				if(getCookie('cloud_nickname')!=''){
					//alert('zz');
					window.location.href='<?php echo $module['backurl_2'];?>';
				}
		});
		$(".oauth_switch").click(function(){
			return false;
			$(this).css('display','none');
			$(".icons").css('display','block');
			return false;
		});
		$(".oauth_div .icons").click(function(event){
			if(event.target.tagName=='DIV'){
				return false;
				$(this).css('display','none');
				$(".oauth_switch").css('display','block');
				return false;	
			}
		});

		
		$("html,body").animate({scrollTop: $("#<?php echo $module['module_name'];?>").offset().top}, 1000);
       	$("#<?php echo $module['module_name'];?> #authCode_Div").css("display",authCodeStyle);
        $("#<?php echo $module['module_name'];?> #username").focus();
        $("#<?php echo $module['module_name'];?> input").focus(function(data){
			$("#"+this.id+"_state").html('');
        });
		
        $("#<?php echo $module['module_name'];?> input").blur(function(data){
            $("#"+this.id+"_state").html('');
        });
    	
		$("#<?php echo $module['module_name'];?> #login").click(function(){
			exe_check();
			return false;	
		});
		
		
    });
	
    
    <?php echo $module['authCodeStyle'];?>
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var username=$("#<?php echo $module['module_name'];?> #username");
        var password=$("#<?php echo $module['module_name'];?> #password");
        var au_Div=$("#<?php echo $module['module_name'];?> #authCode_Div");
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
         
		var authcode=$("#<?php echo $module['module_name'];?> #authcode");
        if(au_Div.css('display')=='block'){
            if(authcode.prop('value')==''){authcode.focus();return false;}	
        }
        
        $("#<?php echo $module['module_name'];?> #username_state").html('');
        $("#<?php echo $module['module_name'];?> #password_state").html('');
        $("#<?php echo $module['module_name'];?> #authcode_state").html('');
        $("#<?php echo $module['module_name'];?> #submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		$("#<?php echo $module['module_name'];?> #login").attr('disabled',true).addClass('btn btn-default btn-lg disabled');
        $.get('<?php echo $module['action_url'];?>',{username:username.prop('value'),password:password.prop('value'),authcode:authcode.prop('value')}, function(data){
            //alert(data);
			v=data;
			v=v.split("|");
temp=v[0];
			try{json=eval("("+temp+")");}catch(exception){alert(temp);}
			if(json.errType!='none'){$("#<?php echo $module['module_name'];?> #submit").css('display','inline-block');login_count++;}
			if(login_count>2){$("#<?php echo $module['module_name'];?> #authCode_Div").css('display','block');}
			if(json.errType!='none'){
				$("#submit_state").html(json.errInfo);
				$("#<?php echo $module['module_name'];?> #login").attr('disabled',false).removeClass('btn btn-default btn-lg disabled');
				$("#<?php echo $module['module_name'];?> #"+json.errType).focus();
				$("#<?php echo $module['module_name'];?> #"+json.errType+"_state").html('<span class=fail title="'+json.errInfo+'"> </span>');
				cloud_alert($("#<?php echo $module['module_name'];?> #"+json.errType+"_state span").attr('title'));
			}else{
				//window.location.href=v[1];
				$("#submit_state").html('<span class=\'fa fa-spinner fa-spin\'></span>  loading....'+v[1]);
				
			}
			});
        return false;
        }
        
    </script>
    <style>
	#index_foot,#index_device{ display:none;}
	.container{ height:100%; }
	body,.container,.page-footer{}
	#<?php echo $module['module_name'];?>{ margin:0px; line-height:2.85rem; width:100%; margin:0px; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div{ width:100%; margin:auto;   text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body{ padding:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div{}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login_logo_div img{ width:100%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div{  margin-left:1rem; margin-right:1rem; border:#CCC 1px solid; text-align:left; padding:0.6rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input{ border:none; outline-width:0px;  width:75%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body  input:focus{  border:none; outline-width:0px; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div{ border-bottom:#CCC 1px solid;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .username_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;background:<?php echo $_POST['cloud_user_color_set']['button']['background']?>;color:<?php echo $_POST['cloud_user_color_set']['button']['text']?>;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div{}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #input_div .password_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:"\f023";   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;background:<?php echo $_POST['cloud_user_color_set']['button']['background']?>;color:<?php echo $_POST['cloud_user_color_set']['button']['text']?>;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div{ text-align:left;margin-left:1rem; margin-right:1rem;margin-top:1rem; }
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div{ border:1px #CCCCCC solid; padding-left:1rem; display:inline-block; vertical-align:top; width:50%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div input{ width:60%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div #authcode_div:before{margin-right:8px; font: normal normal normal 1rem/1 FontAwesome; content:'\f007';   border-radius:50%;  display:inline-block; width:2rem; height:2rem; line-height:2rem; text-align:center;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a{display:inline-block; padding-left:1rem; vertical-align:top; width:40%;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #authCode_Div .authcode_img_a img{ height:3rem; }
	
	
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login{display:block;   border-radius:0.3rem; margin-left:1rem; margin-right:1rem;}
	#<?php echo $module['module_name'];?>_html .form_div .f_body #login:hover{ opacity:0.8;}
	
	#<?php echo $module['module_name'];?>_html .oauth_div{ text-align:center;}
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch{color:#ccc; font-size:0.9rem; }
	#<?php echo $module['module_name'];?>_html .oauth_div .oauth_switch:after{display:none; }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons{ }
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a{ margin:0.3rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img{ width:2rem; height:2rem;}
  	#<?php echo $module['module_name'];?>_html .oauth_div .icons a img:hover{ opacity:0.8;}
	#<?php echo $module['module_name'];?>_html #submit_state{ }
	#<?php echo $module['module_name'];?>_html #get_password{ display:inline-block; vertical-align:top; width:50%; text-align:left; }	  
	#<?php echo $module['module_name'];?>_html #register{ display:inline-block; vertical-align:top; width:43%; text-align:right; }	  
  </style>
        <div id=<?php echo $module['module_name'];?>_html >
        
        <div class=form_div>
        	<div class=f_body>
            	<div id=login_logo_div><img src='logo.png'></div>
                <div id=input_div>
                  <div class=username_div><input  type="text" name="username" id="username" title="<?php echo self::$language['username_hint'];?>" placeholder="<?php echo self::$language['username_hint'];?>" /><span id=username_state></span></div>
                  <div class=password_div><input type="password" name="password" id="password"  placeholder="<?php echo self::$language['password'];?>"  /><span id=password_state></span></div>
                </div>
                <div id="authCode_Div" style=" display:none;" >
					<div id="authcode_div"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;"  placeholder="<?php echo self::$language['authcode'];?>"  /><span id=authcode_state style="vertical-align:middle;"></span></div><a href="#" class=authcode_img_a onclick="return change_authcode();" title="<?php echo self::$language['change_authcode'];?>"><img id="authcode_img" src="./lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
                </div>
                
                <a href="./index.php?cloud=index.resetPassword&field=password" id=get_password><?php echo self::$language['get_password']?></a><a href="./index.php?cloud=index.reg_user&group_id=<?php echo $module['default_group_id'];?>" id="register" ><?php echo self::$language['register']?></a>
                <a href="#" type="submit" name="submit" id="login" onclick="return exe_check();"  user_color=button><?php echo self::$language['login']?></a>
                <span id=submit_state></span>
                <?php echo $module['oauth'];?>
                
            </div>
            
        </div>
        
        <div id=login_div style="display:none;" ></div>
        </div>
</div>
