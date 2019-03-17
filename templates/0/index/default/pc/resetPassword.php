<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    function clear_defaut_value(){
        username=$("#<?php echo $module['module_name'];?>_html #username");
        if(username.prop('value')=='<?php echo self::$language['resetPassword_hint'];?>'){username.prop('value','');}
    }
    function reset_deault_value(){
        username=$("#<?php echo $module['module_name'];?>_html #username");
        if(username.prop('value')==''){username.prop('value','<?php echo self::$language['resetPassword_hint'];?>');}		
    }	
    function send_checkcode(){
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        usernameErr=$("#<?php echo $module['module_name'];?>_html #username_state");
        if(authcode.prop('value')==''){authcode.focus();return false;}
        if(username.prop('value')==''){username.focus();return false;}
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','none');
        usernameErr.html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['send_url'];?>',{authcode:authcode.prop('value'),username:username.prop('value')}, function(data){
            //alert(data);
             try{v=eval("("+data+")");}catch(exception){alert(data);}
			

            if(v.errType=='authcode'){
                authcode.focus();
                $("#<?php echo $module['module_name'];?>_html #authcode_state").html(v.errInfo);usernameErr.html('');
                $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');
            }
            if(v.errType=='username'){
                username.focus();
                $("#<?php echo $module['module_name'];?>_html #username_state").html(v.errInfo);
                $("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');
            }
            if(v.errType=='none'){
                if(v.state=='fail'){$("#<?php echo $module['module_name'];?>_html #send_checkcode_div").css('display','inline-block');}
                $("#<?php echo $module['module_name'];?>_html #username_state").html(v.info);
                $("#<?php echo $module['module_name'];?>_html #newPassword_div").css('display','block');
                }
        });
        return false;	
    }
    
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
    
        
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        identifying=$("#<?php echo $module['module_name'];?>_html #identifying");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        password=$("#<?php echo $module['module_name'];?>_html #password");
        confirm_password=$("#<?php echo $module['module_name'];?>_html #confirm_password");
        if(authcode.prop('value')==''){authcode.focus();return false;}
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['resetPassword_hint'];?>'){username.focus();return false;}
        if(identifying.prop('value')==''){identifying.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
        if(confirm_password.prop('value')==''){confirm_password.focus();return false;}
        if(password.prop('value').length<6){$("#<?php echo $module['module_name'];?>_html #password_state").html('<?php echo self::$language['password_min']?>');password.focus();return false;}
        if(password.prop('value')!=confirm_password.prop('value')){
            $("#<?php echo $module['module_name'];?>_html #password_state").html('<?php echo self::$language['twice_password_not_same']?>');password.focus();return false;
        }
        $("#<?php echo $module['module_name'];?>_html #username_state").html('');
        $("#<?php echo $module['module_name'];?>_html #password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #confirm_password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #identifying_state").html('');
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','inline-block');
        $("#<?php echo $module['module_name'];?>_html #submit").css('display','none');
        top_ajax_form('cloud_form','act_div','show_result');
        return false;
        }
    
    
    function show_result(){
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','none');
        v=$("#<?php echo $module['module_name'];?>_html #act_div").html();
		//cloud_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.errType=='authcode'){$("#<?php echo $module['module_name'];?>_html #authcode").focus();return false;$("#<?php echo $module['module_name'];?>_html #authcode_state").html(json.errInfo);}
        if(json.errType=='username'){$("#<?php echo $module['module_name'];?>_html #username").focus();return false;$("#<?php echo $module['module_name'];?>_html #username_state").html(json.errInfo);}
        if(json.errType=='identifying'){$("#<?php echo $module['module_name'];?>_html #identifying").focus();return false;$("#<?php echo $module['module_name'];?>_html #identifying_state").html(json.errInfo);}
        if(json.errType=='none'){cloud_alert(json.errInfo);window.location.href="index.php?cloud=index.login&backurl=index.php?cloud=index.user";}else{
            $("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');
            }
            
    }
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>_html #authcode").focus();return false;
		$("#<?php echo $module['module_name'];?>_html input").focus(function(data){
			$(this).addClass("focus");	 
		});
		$("#<?php echo $module['module_name'];?>_html input").blur(function(data){
			if(this.id=='username'){if($(this).prop('value')==''){$(this).prop('value','<?php echo self::$language['resetPassword_hint'];?>');}}
			$("#"+this.id+"_state").html('');
			$(this).removeClass("focus"); 
		});
            
    });
    </script>
    

    <div id=<?php echo $module['module_name'];?>_html>
    <div id=act_div style="display:none;" ></div>
	<style>
    #<?php echo $module['module_name'];?>_html{margin:30px; line-height:3rem;}
    #<?php echo $module['module_name'];?>_html .input_text{width:220px; height:30px; line-height:30px; border-radius:3px; margin-bottom:25px; font-size:18px;}
	#<?php echo $module['module_name'];?>_html #authcode{width:120px; height:30px; line-height:30px; border-radius:3px; margin-bottom:25px; font-size:18px;}
	#<?php echo $module['module_name'];?>_html #authcode_img{width:100px; height:30px; margin-bottom:25px;}
	#<?php echo $module['module_name'];?>_html #send_checkcode_div{ }
	#<?php echo $module['module_name'];?>_html #submit{ display:inline-block; width:200px; height:3.5rem; line-height:3.5rem; text-align:center; font-size:1.2rem; font-family:"SimHei"; }
    #<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; vertical-align: top; width:30%; overflow:hidden; text-align:right; padding-right:5px;}
    </style>
    <form id="cloud_form" name="cloud_form" method="GET" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    
      <span class="m_label"><?php echo self::$language['authcode'];?>：</span><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['change_authcode'];?>"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a> <span id=authcode_state style="vertical-align:middle;"></span><br />
      <span class="m_label"><?php echo self::$language['identifying'];?><?php echo self::$language['send_to'];?>：</span><input type="text" class="input_text" title="<?php echo self::$language['resetPassword_hint'];?>" name="username" id="username" value="<?php echo self::$language['resetPassword_hint'];?>" onfocus="clear_defaut_value();" /> <a href="#" id="send_checkcode_div" onclick="return send_checkcode()" ><?php echo self::$language['send'];?></a><span id=username_state></span><br />
      
      <div id=newPassword_div style="display:none;">
      <span class="m_label"><?php echo self::$language['identifying'];?>：</span><input type="text" class="input_text" name="identifying" id="identifying" /><span id=identifying_state></span><br />
       <span class="m_label"><?php echo $module['field_name'];?>：</span><input type="password" class="input_text" name="password" id="password" /><span id=password_state></span><br />
       <span class="m_label"><?php echo self::$language['confirm'];?><?php echo $module['field_name'];?>：</span><input type="password" class="input_text" name="confirm_password" id="confirm_password" /><span id=confirm_password_state></span><br />
      <span class="m_label">&nbsp;</span> <a href="#" onclick="return exe_check();" name="submit" id="submit" class=submit><?php echo self::$language['submit'];?></a> <span class=loading id=executing  style="display:none;">&nbsp;</span><span id=submit_state></span>
      </div>
    </form>
    <br /><br />
    </div>

</div>