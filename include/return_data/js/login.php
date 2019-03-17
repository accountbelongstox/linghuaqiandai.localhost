<script type="text/javascript">
	//login
	
    var login_count=0;
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?>").height($(window).height());
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
    $("#username").focus(function(){
    var v=$(this).val();
    if(v.indexOf("邮箱")!= -1){
   	 	$(this).val('')
    }
    })
        
</script>