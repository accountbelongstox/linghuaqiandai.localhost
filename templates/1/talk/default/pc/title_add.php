<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #type").val('<?php echo @$_GET['type'];?>');
		
		$("#<?php echo $module['module_name'];?> #authcode").focus(function(){
			if(!$("#<?php echo $module['module_name'];?> #authcode_img").attr('src')){
				$("#<?php echo $module['module_name'];?> #authcode_img").attr('src',$("#<?php echo $module['module_name'];?> #authcode_img").attr('wsrc'));	
			}
		});
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        var title=$("#<?php echo $module['module_name'];?> #title");
        var authcode=$("#<?php echo $module['module_name'];?> #authcode");
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        if(title.prop('value')==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['title']?>');title.focus();return false;}
        if(authcode.prop('value')==''){alert('<?php echo self::$language['please_input']?><?php echo self::$language['authcode']?>');authcode.focus();return false;}
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class=\'fa fa-spinner fa-spin\'></span>");		
        top_ajax_form('cloud_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		

        if(json.state=='fail'){$("#<?php echo $module['module_name'];?> #submit_state").html(json.info);$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");}
        
            
    }
    </script>
    
<style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
	#<?php echo $module['module_name'];?> .input_div{ line-height:60px;} 
	#<?php echo $module['module_name'];?> .input_div .m_label{ display:inline-block; width:100px; padding-right:5px; text-align:right; vertical-align:top;} 
	#<?php echo $module['module_name'];?> .input_div .input_span{ display:inline-block;} 
	#<?php echo $module['module_name'];?> .input_div #key{ width:600px;} 
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
	#<?php echo $module['module_name'];?> #email{ height:13px;} 
	#<?php echo $module['module_name'];?> #advanced_options_div_state{ height:18px;}
	#<?php echo $module['module_name'];?> #submit{ line-height:2rem; height:2rem;}
/*表单DIYMODULE设计CSS 载入 2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html">
    
    <form id="cloud_form" name="cloud_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><span class=require>*</span><?php echo self::$language['title'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><input type="text" name="title" id="title"/></span></div>
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><?php echo self::$language['content'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><textarea name="content" id="content" style="display:none; width:100%; height:400px;"></textarea></span></div>
      <div class="input_div"><span class=m_label>&nbsp;</span><span class=input_span><input type="checkbox" id="email" name="email" /><?php echo self::$language['when_replies_or_comments_remind_me'];?></span></div>
      <div class="input_div" ><span class=m_label>&nbsp;</span><span class=input_span><div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show> </span></a></div><div id=advanced_options_div>key: <input type="text" name="key" id="key" /></div></span></div>
      <div class="input_div"><span class=m_label><span class="m_label_start">&nbsp;</span><span class="m_label_middle"><span class=require>*</span><?php echo self::$language['authcode'];?></span><span class="m_label_end">&nbsp;</span></span><span class=input_span><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;" /> <a href="#" onclick="return change_authcode();" title="<?php echo self::$language['click_change_authcode']?>"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>

	  <div class="input_div"><span class=m_label>&nbsp;</span><span class=input_span><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span></span></div>
    
    
      
    </form>
    
    </div>
</div>

