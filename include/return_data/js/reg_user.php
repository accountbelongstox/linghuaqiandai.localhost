	<script>
    var reg_email=<?php echo $module['reg_email']?>;
	var reg_phone=<?php echo $module['reg_phone']?>;
	var remain_time;
	var t1;
    $(document).ready(function(){
    	$("#<?php echo $module['module_name'];?>").height($(window).height());
		var is_enterprise="92";//企业组
		if(window.location.search.indexOf('group_id='+is_enterprise) != -1){
			$("#is_enterprise").val("1");
		}
		$("html,body").animate({scrollTop: $("#<?php echo $module['module_name'];?>").offset().top}, 1000);
		$("#username").focus();			

	group_id=get_param('group_id');
	if(group_id!=''){
		$("#<?php echo $module['module_name'];?>_html #group").prop('value',group_id);
		$("#<?php echo $module['module_name'];?>_html #group_id_div").css('display','none');
	}	
	$("#<?php echo $module['module_name'];?>_html #group").change(function(data){
		if($(this).prop("value")!=0){
			group_id=$(this).prop("value");
			$("#<?php echo $module['module_name'];?>_html #group_state").html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.get('<?php echo $module['action_url'];?>&act=check_group',{group_id:group_id}, function(data){
            //alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
			

			$("#<?php echo $module['module_name'];?>_html #group_state").html(v.info);
            if(v.state=='ok'){
				
            }else{
				
			}
			
          });
		}else{
			$("#<?php echo $module['module_name'];?>_html #group_state").html('');
		}	 
	});
	

	$("#<?php echo $module['module_name'];?>_html input").focus(function(data){
		$(this).addClass("focus");	 
	});
	$("#<?php echo $module['module_name'];?>_html input").blur(function(data){
		if(this.id=='username'){if($(this).prop('value')==''){$(this).prop('value','<?php echo self::$language['username_hint'];?>');}}
		$("#"+this.id+"_state").html('');
		$(this).removeClass("focus"); 
	});
	$(".get_verification_code").click(function(){
		if($("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity')!=1){return false;}
		window.clearInterval(t1);
		if($("#<?php echo $module['module_name'];?>_html #phone").attr('type')){			
			if(!reg_phone.test($("#<?php echo $module['module_name'];?>_html #phone").val()) ){		
				
				alert('<?php echo self::$language['phone']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #phone").focus();
				return false;
				}
			
		}
		
		if($("#<?php echo $module['module_name'];?>_html #email").attr('type')){
			if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val()) ){		
				
				alert('<?php echo self::$language['email']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #email").focus();
				return false;
				}
			
		}
			$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',0.3);
			//$("#<?php echo $module['module_name'];?> .get_verification_code").next().html('<span class=\'fa fa-spinner fa-spin\'></span>');
			
			$.post('<?php echo $module['action_url'];?>&act=get_verification_code',{phone:$("#<?php echo $module['module_name'];?> #phone").val(),email:$("#<?php echo $module['module_name'];?> #email").val(),token:$("#<?php echo $module['module_name'];?> #token").val(),}, function(data){
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}				
				
				if(v.info=='weixin'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
					$("#<?php echo $module['module_name'];?> .weixin_reg").html(v.html);
					
					return false;
				}
				if(v.info=='image'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<img src=/lib/verification_code.class.php?'+Math.random()+' />');
					return false;
				}
				alert(v.info);
				if(v.state=='fail'){
					$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				}else{

					$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>(<b>60</b>)');
					remain_time=60;

					t1 = window.setInterval(update_remain,1000);  

				}
				
			});
			return false;	

		
	});
	
	
    });
	
	
		function update_remain(){
			if(remain_time==0){
				
				$("#<?php echo $module['module_name'];?> .get_verification_code").css('opacity',1);
				$("#<?php echo $module['module_name'];?> .get_verification_code").html('<?php echo self::$language['recapture']?>');
				window.clearInterval(t1);
			}
			$("#<?php echo $module['module_name'];?> .get_verification_code b").html(remain_time--);	
		}
    
	
	
    function clear_defaut_value(){
	username=$("#<?php echo $module['module_name'];?>_html #username");
	if(username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.prop('value','');}	
    }	
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		is_null=false;
		$("#<?php echo $module['module_name'];?> input").each(function(index, element) {
			if($(this).val()=='' && $(this).attr('type')!='file'){
				$(this).focus();
				is_null=true; 
				console.log($(this));
				return false;
				}
		});
		if(is_null){return false;}
       	group=$("#<?php echo $module['module_name'];?>_html #group");
        username=$("#<?php echo $module['module_name'];?>_html #username");
        password=$("#<?php echo $module['module_name'];?>_html #password");
        confirm_password=$("#<?php echo $module['module_name'];?>_html #confirm_password");
        authcode=$("#<?php echo $module['module_name'];?>_html #authcode");
        au_Div=$("#<?php echo $module['module_name'];?>_html #authCode_Div");
        if(group.prop('value')=='0'){group.focus();return false;}
        if(username.prop('value')=='' || username.prop('value')=='<?php echo self::$language['username_hint'];?>'){username.focus();return false;}
        if(password.prop('value')==''){password.focus();return false;}
        if(confirm_password.prop('value')==''){confirm_password.focus();return false;}
        if(password.prop('value').length<6){alert('<?php echo self::$language['password_min']?>');password.focus();return false;}
        if(password.prop('value')!=confirm_password.prop('value')){
          alert('<?php echo self::$language['twice_password_not_same']?>');password.focus();return false;
        }
        if(authcode.prop('value')==''){authcode.focus();return false;}
        
		if($("#<?php echo $module['module_name'];?>_html #phone").attr('type')){			
			if(!reg_phone.test($("#<?php echo $module['module_name'];?>_html #phone").val()) ){		
				
				alert('<?php echo self::$language['phone']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #phone").focus();
				return false;
				}
			
		}
		
		if($("#<?php echo $module['module_name'];?>_html #email").attr('type')){
			if(!reg_email.test($("#<?php echo $module['module_name'];?>_html #email").val()) ){		
				
				alert('<?php echo self::$language['email']?><?php echo self::$language['pattern_err']?>');
				$("#<?php echo $module['module_name'];?>_html #email").focus();
				return false;
				}
			
		}
		
		if(!$("#<?php echo $module['module_name'];?> .input_checkbox").prop('checked')){
			alert('<?php echo self::$language['please_agreement']?>');
			return false;
		}
        $("#<?php echo $module['module_name'];?>_html #phone_state").html('');
        $("#<?php echo $module['module_name'];?>_html #email_state").html('');
        $("#<?php echo $module['module_name'];?>_html #username_state").html('');
        $("#<?php echo $module['module_name'];?>_html #password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #confirm_password_state").html('');
        $("#<?php echo $module['module_name'];?>_html #authcode_state").html('');
        $("#<?php echo $module['module_name'];?>_html #submit_state").html('');
        $("#<?php echo $module['module_name'];?>_html #submit").css('display','none');
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','inline-block');
        top_ajax_form('cloud_form','login_div','show_result');//提交注册
        return false;
       }
    function show_result(){
        $("#<?php echo $module['module_name'];?>_html #executing").css('display','none');
        v=$("#<?php echo $module['module_name'];?>_html #login_div").html();
		//document.write(v);
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
        if(json.errType!='exe_success'){$("#<?php echo $module['module_name'];?>_html #submit").css('display','inline-block');}
        if(json.errType=='exe_success'){cloud_alert(json.errInfo);window.location.href='index.php?cloud=index.login';return false;}
       // if(json.errType=='exe_fail'){cloud_alert(json.errInfo);}
        //cloud_alert(json.errType);
		alert(json.errInfo);
		$("#"+json.errType).focus();
		//$("#"+json.errType+"_state").html('<span class=fail>'+json.errInfo+'</span>');
		            
    }
    $(".title_div a").each(function(a,b){
	    if(window.location.search.indexOf("group_id="+$(b).attr("data-id")) != -1){
	    	$(b).find("span").addClass("active");
	    }
    })
    $("#username").focus(function(){
    var v=$(this).val();
    if(v.indexOf("邮箱")!= -1){
   	 	$(this).val('')
    }
    })
    
    $("#username").blur(function(){
	    if(v.length < 1){
	   		$(this).val('用户名/邮箱/手机')
	    }
    })
    </script>