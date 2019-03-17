    <script>
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var addressee=$("#<?php echo $module['module_name'];?> #addressee");
        var title=$("#<?php echo $module['module_name'];?> #title");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(addressee.prop('value')==''){cloud_alert('<?php echo self::$language['please_select']?><?php echo self::$language['addressee']?>');addressee.focus();return false;}
        if(title.prop('value')==''){cloud_alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
        if(content.prop('value')==''){cloud_alert('<?php echo self::$language['please_input']?><?php echo self::$language['content']?>');}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
        top_ajax_form('cloud_form','submit_state','show_result');
        return false;
       }
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //cloud_alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
        if(json.state=='fail'){
            $("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
            $("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
    }
    </script>