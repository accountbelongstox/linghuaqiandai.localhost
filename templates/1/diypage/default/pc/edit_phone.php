<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left  >
	<script charset="utf-8" src="editor/kindeditor.js"></script>
    <script charset="utf-8" src="editor/create.php?id=content&program=<?php echo $module['class_name'];?>&language=<?php echo $module['web_language']?>"></script>
    <script>
    $(document).ready(function(){
    
    });
    
    
    function exe_check(){
        //表单输入值检测... 如果非法则返回 false
        editor.sync();
        var content=$("#<?php echo $module['module_name'];?> #content");
        $("#<?php echo $module['module_name'];?> #submit_state").html("<span class='fa fa-spinner fa-spin'></span>");
        top_ajax_form('cloud_form','submit_state','show_result');
        return false;
        }
        
    
    function show_result(){
        $("#<?php echo $module['module_name'];?> #submit_state").css("display","none");
        v=$("#<?php echo $module['module_name'];?> #submit_state").html();
        //alert(v);
        try{json=eval("("+v+")");}catch(exception){alert(v);}
		
        $("#<?php echo $module['module_name'];?> #submit_state").html(json.info);
		$("#<?php echo $module['module_name'];?> #submit_state").css("display","inline-block");
        
            
    }
    </script>
    
<style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?> #parent{}
    #<?php echo $module['module_name'];?> #title{ width:600px;}
    #<?php echo $module['module_name'];?> #content{}
/*表单DIYMODULE设计CSS 载入 2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html">
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="/index.php?cloud=diypage.edit&id=<?php echo $_GET['id']?>&type=pc"><?php echo self::$language['pc_device'];?></a></li>
      <li role="presentation" class="active"><a href="/index.php?cloud=diypage.edit&id=<?php echo $_GET['id']?>&type=phone"><?php echo self::$language['phone_device'];?></a></li>
	</ul>
    <form id="cloud_form" name="cloud_form" method="POST" action="<?php echo $module['action_url'];?>&id=<?php echo $_GET['id'];?>" onSubmit="return exe_check();">
      <?php echo self::$language['phone_device'];?><?php echo self::$language['content'];?>：<br />
      
    <textarea name="content" id="content" style="display:none; width:720px; height:1280px;"><?php echo $module['phone_content']?></textarea>
    
    <br />
    <div><a href=# class="advanced_options"><?php echo self::$language['advanced_options'];?><span id=advanced_options_div_state class=show>&nbsp;</span></a></div>
    <div id=advanced_options_div>
      <span class="m_label"><?php echo self::$language['open_image_mark'];?>：</span><select id="image_mark" name="image_mark">
      <?php echo $module['image_mark_option'];?>
      </select><br /><br />
	</div>
    <br />
    
    
    <input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span>
    </form>
    </div>
</div>

