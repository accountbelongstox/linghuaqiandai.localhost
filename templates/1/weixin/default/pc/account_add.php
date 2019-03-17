<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left  >

<?php require("./include/return_data/js/weixin_account_add.php");?>


<style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;display:block;}
    #<?php echo $module['module_name'];?>_html #keyword{ width:800px;}
    #<?php echo $module['module_name'];?>_html #qr_code_file{ border:none;}
 	#<?php echo $module['module_name'];?>_html .line_div{ line-height:50px;}
 	#<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:120px; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .m_label .required{ }
	#replace_div{ display:none; vertical-align:top;}
/*表单DIYMODULE设计CSS 载入weixin_account_add 2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>

<?php require("./include/return_data/css/weixin_account_add.php"); ?>
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html">
    <form id="cloud_form" name="cloud_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin'];?><?php echo self::$language['qr_code'];?></span><span class=input><span id=qr_code_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_name'];?></span><span class=input><input type="text" name="name" id="name"><span id=name_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_account'];?></span><span class=input><input type="text" name="account" id="account"><span id=account_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_id'];?></span><span class=input><input type="text" name="wid" id="wid"><span id=wid_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span>token</span><span class=input><input type="text" name="token" id="token"><span id=token_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppId'];?></span><span class=input><input type="text" name="AppId" id="AppId"><span id=AppId_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppSecret'];?></span><span class=input><input type="text" name="AppSecret" id="AppSecret"><span id=AppSecret_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['area'];?></span><span class=input>
     <input type="hidden" id="area" name="area" />
    <script src="include/core/area_js.php?callback=set_area&input_id=area&id=0&output=select&level=4" id='area_area_js'></script>
    <span id=area_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['keyword'];?></span><span class=input><input type="text" name="keyword" id="keyword"><span id=keyword_state  class=state></span></span></div>
   
    
    
    <div class=line_div><span class=m_label>&nbsp;</span><span class=input><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span></span></div>
    
      
    </form>
    
    </div>
</div>

