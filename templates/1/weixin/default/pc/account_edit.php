<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left  >
<?php require("./include/return_data/js/weixin_account_edit.php");?>
<style>
    #<?php echo $module['module_name'];?>_html{ padding:20px;}
    #<?php echo $module['module_name'];?>_html #keyword{ width:800px;}
    #<?php echo $module['module_name'];?>_html #qr_code_file{ border:none;}
 	#<?php echo $module['module_name'];?>_html .line_div{ line-height:50px;}
 	#<?php echo $module['module_name'];?>_html .m_label{ display:inline-block; width:120px; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?>_html .input{ display:inline-block;}
	#<?php echo $module['module_name'];?>_html .input img{ max-height:200px;}
	#<?php echo $module['module_name'];?>_html .m_label .required{ }
	#<?php echo $module['module_name'];?>_html .return_button span{ vertical-align:top;margin-top:10px; }
	#<?php echo $module['module_name'];?>_html .return_button{  }
	#<?php echo $module['module_name'];?>_html #replace_div{ display:inline-block;}
/*表单DIYMODULE设计CSS 载入 .php2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>

<?php 
require("./include/return_data/css/weixin_css.php");
?>
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
    </div>
                        
                        

    <form id="cloud_form" name="cloud_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin'];?><?php echo self::$language['qr_code'];?></span><span class=input>
      <img src=/program/weixin/qr_code/<?php echo $module['data']['qr_code'];?> /><br />        
	<a href=# class="replace"><?php echo self::$language['replace'];?></a>  
	<div id=replace_div><span id=qr_code_state class=state></span></div>
    </span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_name'];?></span><span class=input><input type="text" name="name" id="name" value="<?php echo $module['data']['name'];?>" /><span id=name_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span><?php echo self::$language['weixin_account'];?></span><span class=input><input type="text" name="account" id="account" value="<?php echo $module['data']['account'];?>" /><span id=account_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['weixin_id'];?></span><span class=input><?php echo $module['data']['wid'];?><span id=wid_state class=state></span></span></div>
    <div class=line_div><span class=m_label><span class=required>*</span>token</span><span class=input><input type="text" name="token" id="token" value="<?php echo $module['data']['token'];?>" /><span id=token_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppId'];?></span><span class=input><input type="text" name="AppId" id="AppId" value="<?php echo $module['data']['AppId'];?>" /><span id=AppId_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['AppSecret'];?></span><span class=input><input type="text" name="AppSecret" id="AppSecret" value="<?php echo $module['data']['AppSecret'];?>" /><span id=AppSecret_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['area'];?></span><span class=input>
     <input type="hidden" id="area" name="area"  value="<?php echo $module['data']['area'];?>" />
    <script src="include/core/area_js.php?callback=set_area&input_id=area&id=<?php echo $module['data']['area'];?>&output=select&level=4" id='area_area_js'></script>
    <span id=area_state class=state></span></span></div>
    <div class=line_div><span class=m_label><?php echo self::$language['keyword'];?></span><span class=input><input type="text" name="keyword" id="keyword" value="<?php echo $module['data']['keyword'];?>" /><span id=keyword_state  class=state></span></span></div>
    
    <div class=line_div><span class=m_label><?php echo self::$language['administrator'];?><?php echo self::$language['username'];?></span><span class=input><input type="text" name="manager" id="manager" value="<?php echo $module['data']['manager'];?>" /><span id=manager_state  class=state></span></span></div>
    
    
    
    <div class=line_div><span class=m_label><?php echo self::$language['no_keyword'];?></span><span class=input><input type="checkbox" class=if_checkbox id=open_search name=open_search value="<?php echo $module['data']['open_search'];?>"><?php echo self::$language['open_search'];?></span></div>
    <div class=line_div><span class=m_label>已开通多客服</span><span class=input><select id=receptionist_power name=receptionist_power cloud_value="<?php echo $module['data']['receptionist_power'];?>"><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select> (人工客服)</span></div>
  
  
    <div class=line_div id=inform_div  style="display:none;">
	<span class=m_label>&nbsp;</span><span class=input>
    	<fieldset><legend><?php echo self::$language['inform'];?><?php echo self::$language['set'];?></legend>
          <div class=table_scroll><table width="500" border="0">
            <tr>
              <td><?php echo self::$language['state'];?></td>
              <td><?php echo self::$language['inform'];?><?php echo self::$language['email'];?></td>
              <td><?php echo self::$language['inform'];?><?php echo self::$language['weixin'];?></td>
            </tr>
            <tr>
              <td><?php echo self::$language['receive'];?></td>
              <td><input type="checkbox" class=if_checkbox id=receive_if_email name=receive_if_email value="<?php echo $module['data']['receive_if_email'];?>"></td>
              <td><input type="checkbox" class=if_checkbox id=receive_if_weixin name=receive_if_weixin value="<?php echo $module['data']['receive_if_weixin'];?>"></td>
            </tr>
            <tr>
              <td><?php echo self::$language['no_keyword'];?></td>
              <td><input type="checkbox" class=if_checkbox id=no_keyword_if_email name=no_keyword_if_email value="<?php echo $module['data']['no_keyword_if_email'];?>"></td>
              <td><input type="checkbox" class=if_checkbox id=no_keyword_if_weixin name=no_keyword_if_weixin value="<?php echo $module['data']['no_keyword_if_weixin'];?>"></td>
            </tr>
            <tr>
              <td><?php echo self::$language['no_search'];?></td>
              <td><input type="checkbox" class=if_checkbox id=no_search_if_email name=no_search_if_email value="<?php echo $module['data']['no_search_if_email'];?>"></td>
              <td><input type="checkbox" class=if_checkbox id=no_search_if_weixin name=no_search_if_weixin value="<?php echo $module['data']['no_search_if_weixin'];?>"></td>
            </tr>
          </table></div>
          <div class=line_div><span class=m_label style=" width:200px;"><?php echo self::$language['addressee'];?><?php echo self::$language['weixin'];?>openId</span><span class=input><input type="text" name="if_weixin" id="if_weixin" value="<?php echo $module['data']['if_weixin'];?>" /><span id=if_weixin_state class=state></span></span></div>
		<div class=line_div><span class=m_label style=" width:200px;"><?php echo self::$language['addressee'];?><?php echo self::$language['email'];?></span><span class=input><input type="text" name="if_email" id="if_email" value="<?php echo $module['data']['if_email'];?>" /><span id=if_email_state class=state></span></span></div>
		<div class=line_div><span class=m_label style=" width:200px;">&nbsp;</span><span class=input>
        	<fieldset><legend><?php echo self::$language['smtp_config'];?></legend>
				<div class=line_div><span class=m_label><?php echo self::$language['smtp_url'];?></span><span class=input><input type="text" name="smtp_url" id="smtp_url" value="<?php echo $module['data']['smtp_url'];?>" /><span id=smtp_url_state class=state></span></span></div>
				<div class=line_div><span class=m_label><?php echo self::$language['smtp_account'];?></span><span class=input><input type="text" name="smtp_account" id="smtp_account" value="<?php echo $module['data']['smtp_account'];?>" /><span id=smtp_account_state class=state></span></span></div>
				<div class=line_div><span class=m_label><?php echo self::$language['smtp_password'];?></span><span class=input><input type="password" name="smtp_password" id="smtp_password" value="<?php echo $module['data']['smtp_password'];?>" /><span id=smtp_password_state class=state></span></span></div>
            </fieldset>
        </span></div>
        </fieldset>
    
    </span></div>
   
    
    <div class=line_div id=receptionist_div style="display:none;"><span class=m_label>&nbsp;</span><span class=input>
    	<fieldset><legend>人工客服设置</legend>
   			<div class=line_div><span class=m_label style="width:200px;">启用人工服务</span><span class=input><select id=receptionist_open name=receptionist_open cloud_value="<?php echo $module['data']['receptionist_open'];?>"><option value="0"><?php echo self::$language['no'];?></option><option value="1"><?php echo self::$language['yes'];?></option></select> </span></div>
   			<div class=line_div><span class=m_label style="width:200px;">转人工客服条件,当</span><span class=input><select id=receptionist_where name=receptionist_where cloud_value="<?php echo $module['data']['receptionist_where'];?>"><option value="0">收到信息时</option><option value="1">无自动回复时</option><option value="2">无搜索结果时</option></select> </span></div>
        </fieldset>
    
    </span></div>
   
    
    
    <div class=line_div><span class=m_label>&nbsp;</span><span class=input><input type="submit" name="submit" id="submit" value="<?php echo self::$language['submit']?>" /><span id=submit_state></span></span></div>
    
      
    </form>
    
    </div>
</div>
<script >
//自动设置表单
	$('#manager').val('admin'); 
	$('#if_email').val('admin@linghuaqingdai.com'); 
	$('#smtp_url').val('smtp.ddweb.com.cn'); 
	$('#smtp_account').val('service@ddweb.com.cn'); 
	$('#smtp_password').val('Forwindows123'); 
	
	
</script>
