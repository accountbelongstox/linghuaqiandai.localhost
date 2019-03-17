<div id=<?php echo $module['module_name'];?> cloud-module="<?php echo $module['module_name'];?>" align=left >
    <?php
        include ("./include/return_data/css/login.php");
    ?>
        <div id=<?php echo $module['module_name'];?>_html class="container">
        
        <div class=form_div>
        	<div class=f_body>
            	<div id=login_logo_div>
                    <h1 class="logo-name">h</h1>
                	<p>欢迎使用好好数据!</p>
                </div>
                <div id=input_div>
                  <div class=username_div><input  type="text" name="username" id="username" title="<?php echo self::$language['username_hint'];?>" placeholder="<?php echo self::$language['username_hint'];?>" /><span id=username_state></span></div>
                  <div class=password_div><input type="password" name="password" id="password"  placeholder="<?php echo self::$language['password'];?>"  /><span id=password_state></span></div>
                </div>
                <div id="authCode_Div" style=" display:none;" >
					<div id="authcode_div"><input type="text" name="authcode" id="authcode" size="8" style="vertical-align:middle;"  placeholder="<?php echo self::$language['authcode'];?>"  /><span id=authcode_state style="vertical-align:middle;"></span></div><a href="#" class=authcode_img_a onclick="return change_authcode();" title="<?php echo self::$language['change_authcode'];?>"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a>
                </div>
                
                <a href="/index.php?cloud=index.resetPassword&field=password" id=get_password>忘记密码了?</a><a href="/index.php?cloud=index.reg_user&group_id=<?php echo $module['default_group_id'];?>" id="register">立即注册账号</a>
                <a href="#" type="submit" name="submit" id="login" onclick="return exe_check();" user_color=button>登陆</a>
                <span id=submit_state></span>
                <?php echo $module['oauth'];?>
                
            </div>
            
        </div>
        
        <div id=login_div style="display:none;" ></div>
        </div>
</div>
<?php
    include ("./include/return_data/js/login.php");
?>
