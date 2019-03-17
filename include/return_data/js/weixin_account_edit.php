    <script>
    $(document).ready(function(){
		
		$('#qr_code_ele').insertBefore($('#qr_code_state'));
		$("<br/>").insertAfter("#replace_div");
		$("#<?php echo $module['module_name'];?> .replace").toggle(
		  function () {
			$(this).next('div').css('display','inline-block');
		  },
		  function () {
			$(this).next('div').css('display','none');
		  }
		);
		
		$("#<?php echo $module['module_name'];?> .if_checkbox").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            $(this).val($(this).attr('cloud_value'));
        });
		if(1==<?php echo $module['data']['receptionist_power']?>){
			$("#<?php echo $module['module_name'];?> #receptionist_div").css('display','block');	
		}else{
			//$("#<?php echo $module['module_name'];?> #inform_div").css('display','block');	
		}
		$("#<?php echo $module['module_name'];?> #receptionist_power").change(function(){
			if($(this).val()==0){
				$("#<?php echo $module['module_name'];?> #receptionist_div").css('display','none');	
				//$("#<?php echo $module['module_name'];?> #inform_div").css('display','block');	
			}else{
				//$("#<?php echo $module['module_name'];?> #inform_div").css('display','none');	
				$("#<?php echo $module['module_name'];?> #receptionist_div").css('display','block');	
			}	
		});
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
		
		$("#<?php echo $module['module_name'];?> .if_checkbox").each(function(index, element) {
            if($(this).prop('checked')){$(this).prop('value','1');}else{$(this).prop('value','0');}
			//$(this).prop('checked',true);
			////alert($(this).attr('id')+'='+$(this).val());
        });
		
		
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");		
		$("#<?php echo $module['module_name'];?>_html .state").html('');
        top_ajax_form('cloud_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
      	 //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
		$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
        if(json.state=='fail'){
			if(json.id){
				$("#<?php echo $module['module_name'];?> #submit_state").html('<?php echo self::$language['fail'];?>');
				$("#"+json.id+'_state').html(json.info);
			}
			$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");
		}else{
			$("#<?php echo $module['module_name'];?> #submit").css('display','none');
			$("#<?php echo $module['module_name'];?> #submit_state").html(json.info+'<a href=/index.php?cloud=weixin.account_list class=return_button><span class=b_start></span><span class=b_middle><?php echo self::$language['return'];?></a>');	
		}
        
            
    }
	
    function set_area(id,v){
        $("#"+id).prop('value',v);
    }
    </script>