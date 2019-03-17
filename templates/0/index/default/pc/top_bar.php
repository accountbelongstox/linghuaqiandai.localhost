document.write("<div id=<?php echo $module['module_name'];?> cloud-module='<?php echo $module['module_name'];?>' align=center >"+
	"<style>"+
    "#<?php echo $module['module_name'];?>{ background-color: #F9F9F9; width:100%; }"+
    "#<?php echo $module['module_name'];?> .top_bar{color:#ccc;height:30px; line-height: 30px;background: #F9F9F9;border-bottom: 1px solid #E3E3E4;margin:auto;position:relative;z-index:999;clear:both;text-align:left;margin-left:auto; margin-right:auto;overflow: hidden;}"+
        "#<?php echo $module['module_name'];?> .top_bar a{color:#ccc;}"+
        "#<?php echo $module['module_name'];?> .top_bar .welcome{width:59%; font-size:13px; padding-left:1%; overflow:hidden; text-align:left; display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> .top_bar .user_info{ width:40%; overflow:hidden; text-align:right;display:inline-block; vertical-align:top;}"+
    "#<?php echo $module['module_name'];?> .top_bar .icon{ height:26px; vertical-align:middle;}"+
    "#<?php echo $module['module_name'];?> .top_bar a{ display:inline-block; margin-right:0px; vertical-align:top;}"+
	"#<?php echo $module['module_name'];?> .login{ height:25px; font-size:13px; text-align:left;  margin-left:10px;}"+
	"#<?php echo $module['module_name'];?> .login:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f007';}"+
	"#<?php echo $module['module_name'];?> .reg_user{ height:25px; font-size:13px;  margin-left:10px;}"+
	"#<?php echo $module['module_name'];?> .reg_user:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f040';}"+
	"#<?php echo $module['module_name'];?> .print_a{ display:none; }"+
	"#<?php echo $module['module_name'];?> .icon_a{ margin-right:0px; }"+
	"#<?php echo $module['module_name'];?> .icon_img{ display:block; height:1.8rem;border-radius:0.9rem; border:#FFF 2px solid;vertical-align:middle;}"+
	"#<?php echo $module['module_name'];?> .nickname{ margin-left:0px;padding-left:0px; font-size:13px;}"+
	"#<?php echo $module['module_name'];?> .unlogin{ font-size:13px; text-align:left;}"+
	"#<?php echo $module['module_name'];?> .unlogin:before{font: normal normal normal 18px/1 FontAwesome;margin-right:5px;content:'\\f08b';}"+
	"#<?php echo $module['module_name'];?> .hello{ font-size:13px;vertical-align:top;}"+
	"#<?php echo $module['module_name'];?> .msg_show{ margin-left:10px;  text-align:left;font-size:13px; color: #F60; font-weight:bold;}"+
	"#<?php echo $module['module_name'];?> .msg_show:before{font: normal normal normal 13px/1 FontAwesome;margin-right:2px;content:'\\f1d7';}"+
    "</style>"+
    "<div class='top_bar container'><span class=welcome><?php echo $module['top_welcome_info'];?></span><span class=user_info>"+
    <?php echo $module['data'];?>
    +"</span></div>"+ 
"</div>");