<script>
    $(document).ready(function(){
		$('#qr_code_ele').insertBefore($('#qr_code_state'));
    });
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");		
		$("#<?php echo $module['module_name'];?>_html .state").html('');
        top_ajax_form('cloud_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        alert(v);
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