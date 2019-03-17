<div id=<?php echo $module['module_name'];?>  class="portlet light sum_card" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
    });
    </script>
    

	<style>
	#<?php echo $module['module_name'];?>_html{}
	#<?php echo $module['module_name'];?>_html .big_num  {background-color: #f4756e;}
</style>
<div id="<?php echo $module['module_name'];?>_html" >
    	<a href="/index.php?cloud=index.money_log" class=card_head>
        	<span class=big_num>￥:<?php echo $module['user_money'];?></span>
            <span class=remark>账户基本情况</span>
        </a>
    	<div class=card_body>
        	<a href='/index.php?cloud=index.login_log' class=item>
            	<span class=name><?php echo self::$language['last_login_time']?></span>
            	<span class=value><?php echo $module['last_login_time'];?></span>
            </a><a href='/index.php?cloud=index.login_log' class=item>
            	<span class=name><?php echo self::$language['last_login_site']?></span>
            	<span class=value><?php echo $module['last_login_position'];?></span>
            </a><a href='/index.php?cloud=form.table_admin' class=item>
            	<span class=name>表单统计</span>
            	<span class=value>创建:<?php echo $module['table']['all'];?> 团队:<?php echo $module['table']['edit'];?></span>
            </a><a href='/index.php?cloud=index.admin_site_msg' class=item>
                <span class=name>短信模板</span>
                <span class=value>余数:<?php echo $module['msg']['balance'];?> 模板:<?php echo $module['msg']['yes'];?></span>
            </a>
            </a><a href='/index.php?cloud=index.credits_log' class=item>
            	<span class=name><?php echo self::$language['credits']?></span>
            	<span class=value><?php echo $module['credits'];?></span>
            </a><a href='/index.php?cloud=index.recharge_log' class=item>
            	<span class=name><?php echo self::$language['cumulative']?><?php echo self::$language['success']?><?php echo self::$language['recharge']?></span>
            	<span class=value><?php echo $module['recharge'];?></span>
        </div>
        
        
    </div>
</div>