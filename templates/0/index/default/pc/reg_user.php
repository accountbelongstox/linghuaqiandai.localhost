<div id=<?php echo $module['module_name'];?>  cloud-module="<?php echo $module['module_name'];?>" align=left >
<?php 
//动态返回CSS/JS文件
    require ("./include/return_data/css/reg_user.php");
?>
    <div id=<?php echo $module['module_name'];?>_html  class="container">
        <div class=form_div>
        	<div class=f_body> 
                <div id=login_logo_div>
                    <h1 class="logo-name">H</h1>
                    <p>注册一个好好数据账号</p></div>

        		<div class=title_div>
        		<a href="/index.php?cloud=index.reg_user&group_id=13" data-id="13"><span style="padding-right: 15px;">用户注册</span></a>
        		<a href="/index.php?cloud=index.reg_user&group_id=92" data-id="92"><span style="padding-left: 15px;border:none;">企业注册</span></a>
        		<a href="/index.php?cloud=index.login" style="    margin-left: 10px;">我要登陆</a></div>
                <form id="cloud_form" name="cloud_form" method="GET" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
                    <input type="hidden" name="is_enterprise" id="is_enterprise" value="0">
                  <div id=group_id_div style="display: none"><span class="m_label"><?php echo self::$language['user_group'];?>：</span><span class=input_span><select id="group" name="group"><?php echo $module['group'];?></select></span><span id=group_state></span><br /></div>
                    <?php echo $module["input_username_title"];?>
                  <div class=line><span class="m_label"><?php echo self::$language['account'];?>：</span><span class=input_span><input class="input_text" type="text" name="username" id="username" <?php echo $module["readonly"];?> title="<?php echo self::$language['username_hint'];?>" value="<?php echo $module["input_username_hint"];?>" onfocus="clear_defaut_value();" /></span><span id=username_state></span></div>
                  <div class=line><span class="m_label"><?php echo self::$language['password'];?>：</span><span class=input_span><input class="input_text" type="password" name="password" id="password" /></span><span id=password_state></span></div>
                  <div class=line><span class="m_label"><?php echo self::$language['confirm'];?><?php echo self::$language['password'];?>：</span><span class=input_span><input class="input_text" type="password" name="confirm_password" id="confirm_password" /></span><span id=confirm_password_state></span></div>
                  <?php echo $module['ohter_input'];?>
                  <div class=line><span class="m_label"><?php echo self::$language['authcode'];?>：</span><span class=input_span><span id="authcode_box"><input type="text" name="authcode" id="authcode" size="8" style="width:40%;" /> <span id=authcode_state></span> <a href=# class=get_verification_code><?php echo self::$language['get_verification_code']?></a> <span class=state></span></span></span></div>
                  <div class=weixin_reg style="line-height:20px;text-align:center; padding-top:10px;"></div>
                </form>
                  <div class="line agreement_div" style="margin-bottom:0;">
                      <span class="m_label">&nbsp;</span>
                      <span class=input_span><input type="checkbox" class=agreement /><a href="<?php echo $module['user_agreement_url'];?>" target="_blank" id=user_agreement> 同意注册协议</a>
                      </span>
                  </div>
            </div>
             <div id="reg_button_true"><span class="reg_button"><a href="#" onclick="return exe_check();" name="submit" id="submit"><?php echo self::$language['register_immediately']?></a></span><span class=loading id=executing  style="display:none;"><span class='fa fa-spinner fa-spin'></span></span><span id=submit_state></span></div>
        </div>
    <div id=login_div style="display:none;" ></div>
    </div>
    </div>
</div>
<?php
    require ("./include/return_data/js/reg_user.php");
?>
<script type="text/javascript" src="/js/reg_user.js"></script>
