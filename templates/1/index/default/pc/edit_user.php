<style type="text/css">
    <?php 
require("./include/return_data/css/form_data_admin.php");
 ?>
</style>
<div id=<?php echo $module['module_name'];?>  class="<?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script src="/plugin/datePicker/index.php"></script>
	<script>
    $(document).ready(function(){
		enter_to_tab();
		

               
        $("#edit_user_form input[type='text']").blur(function(){
            //cloud_alert(this.id);
            	
            json="{'"+this.id+"':'"+replace_quot(this.value)+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){
				//cloud_alert($(this).html());
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}

                    $(this).html(v.info);
					if(v.state=='success' && get_param('field')!=''){alert('<?php echo self::$language['success']?>');window.location.href='/index.php?cloud=index.user';return false;}
                    if(v.state=='fail'){}else{}
                }
            });
        });
        
  //       $("input[type='password']").focus(function(){
  //          $(this).css('background','#F00');	
  //      });
        $("#edit_user_form input[type='password']").blur(function(){
            //cloud_alert(this.id);
            $(this).css('background','');	
            json="{'"+this.id+"':'"+replace_quot(this.value)+"'}";
            try{json=eval("("+json+")");}catch(exception){alert(json);}
            $("#"+this.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
            $("#"+this.id+"_state").load('<?php echo $module['action_url'];?>&update='+this.id,json,function(){			
                if($(this).html().length>10){
                    try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
                    $(this).html(v.info);
                }
            });
        });
        
        
        
        $("#edit_user_form tr").css('display','none');
        $("#update_password tr").css('display','block');
        $("#update_transaction_password tr").css('display','block');
        
        field=get_param('field').split("|");
        for(var v in field){
            $("#tr_"+field[v]).css('display','block');
        }
        //cloud_alert(field);
        if(field==''){
			$("#tr_introducer").remove();
            $("#edit_user_form tr").css('display','block');
			$("#edit_user_form #tr_manager").css('display','none');
        }else{
			if(field!='password' && field!='transaction_password'){
				document.title='<?php echo self::$language['require_info']?>';	
				$("#user_position .text").html('<?php echo self::$language['require_info']?>');
			}
        }
        if(field!='transaction_password'){$("#tr_transaction_password").css("display","none");}else{
			document.title='<?php echo self::$language['modify_transaction_password']?>';
			$("#user_position .text").html('<?php echo self::$language['modify_transaction_password']?>');
		}
        if(field!='password'){$("#tr_password").css("display","none");}else{
			document.title='<?php echo self::$language['modify_password']?>';
			$("#user_position .text").html('<?php echo self::$language['modify_password']?>');	
		}
    
    
    });
    
    function update_password(){
        old_password=document.getElementById("old_password");
        new_password=document.getElementById("new_password");
        confirm_new_password=document.getElementById("confirm_new_password");
        //if(old_password.value.length<6){$("#old_password_state").html('<?php echo self::$language['less_six'];?>');$("#old_password").focus();return false}
        if(new_password.value.length<6){$("#new_password_state").html('<?php echo self::$language['less_six'];?>');$("#new_password").focus();return false}
        if(confirm_new_password.value.length<6){$("#confirm_new_password_state").html('<?php echo self::$language['less_six'];?>');$("#confirm_new_password").focus();return false}
        if(new_password.value!=confirm_new_password.value){$("#confirm_new_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');$("#confirm_new_password").focus();return false}
        if(new_password.value==old_password.value){$("#new_password_state").html('<?php echo self::$language['password_new_equal_old'];?>');$("#new_password").focus();return false}
        json="{'"+old_password.id+"':'"+old_password.value+"','"+new_password.id+"':'"+new_password.value+"','"+confirm_new_password.id+"':'"+confirm_new_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_password_state").load('<?php echo $module['action_url'];?>&update=password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
                if(v.state=='success'){$("#update_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    
    function update_transaction_password(){
        old_transaction_password=document.getElementById("old_transaction_password");
        new_transaction_password=document.getElementById("new_transaction_password");
        confirm_new_transaction_password=document.getElementById("confirm_new_transaction_password");
        //if(old_transaction_password.value.length<6){$("#old_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#old_transaction_password").focus();return false;}
        if(new_transaction_password.value.length<6){$("#new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#new_transaction_password").focus();return false;}
        if(confirm_new_transaction_password.value.length<6){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');$("#confirm_new_transaction_password").focus();return false;}
        if(new_transaction_password.value!=confirm_new_transaction_password.value){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');$("#confirm_new_transaction_password").focus();return false;}
        if(new_transaction_password.value==old_transaction_password.value){$("#new_transaction_password_state").html('<?php echo self::$language['transaction_password_new_equal_old'];?>');$("#new_transaction_password").focus();return false;}
        json="{'"+old_transaction_password.id+"':'"+old_transaction_password.value+"','"+new_transaction_password.id+"':'"+new_transaction_password.value+"','"+confirm_new_transaction_password.id+"':'"+confirm_new_transaction_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_transaction_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_transaction_password_state").load('<?php echo $module['action_url'];?>&update=transaction_password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
                if(v.state=='success'){$("#update_transaction_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    function add_transaction_password(){
        new_transaction_password=document.getElementById("new_transaction_password");
        confirm_new_transaction_password=document.getElementById("confirm_new_transaction_password");
        if(new_transaction_password.value.length<6){$("#new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');}
        if(confirm_new_transaction_password.value.length<6){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['less_six'];?>');}
        if(new_transaction_password.value!=confirm_new_transaction_password.value){$("#confirm_new_transaction_password_state").html('<?php echo self::$language['twice_password_not_same'];?>');}
        json="{'"+new_transaction_password.id+"':'"+new_transaction_password.value+"','"+confirm_new_transaction_password.id+"':'"+confirm_new_transaction_password.value+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#update_transaction_password_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#update_transaction_password_state").load('<?php echo $module['action_url'];?>&update=add_transaction_password',json,function(){
            if($(this).html().length>10){
                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}
				
                $(this).html(v.info);
				if(v.state=='success'){alert('<?php echo self::$language['success']?>');window.location.href='/index.php?cloud=index.user';}
                if(v.state=='success'){$("#update_transaction_password .submit_button").css("display","none");}
            }
        });
        
    
    }
    
    
    
    function submit_hidden(id){
        //cloud_alert(id);
        obj=document.getElementById(id);
		//cloud_alert(obj.value);
        if(obj.value==''){};
        if(obj.id.indexOf("enterprise") != -1){
            return;
        }
        json="{'"+obj.id+"':'"+replace_quot(obj.value)+"'}";
        try{json=eval("("+json+")");}catch(exception){alert(json);}
        $("#"+obj.id+"_state").html("<span class='fa fa-spinner fa-spin'></span>");
        $("#"+obj.id+"_state").load('<?php echo $module['action_url'];?>&update='+obj.id,json,function(){
            if($(this).html().length>10){

                try{v=eval("("+$(this).html()+")");}catch(exception){alert($(this).html());}


                $(this).html(v.info);
                if(v.state=='fail'){$(this).html('');}else{}
				
                imgs=obj.value.split("|");
                if(v.state=='success'){$("#"+id+"_img").attr("src","/upload/index/user_"+id+"/"+imgs[imgs.length-1]);}
            }
        });
        
    }
    
    
    function set_area(id,v){
        $("#"+id).prop('value',v);
        submit_hidden(id);	
    }
    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>_html{line-height:40px;} 
    #<?php echo $module['module_name'];?>_html #index_edit_user{ }
    #<?php echo $module['module_name'];?>_html #username_state{ display:inline-block; width:500px; margin-left:8px;}
    #<?php echo $module['module_name'];?>_html input{ margin-left:8px; width:250px; height:30px; line-height:30px; margin-bottom:10px; margin-top:10px; padding-left:5px;}
    #<?php echo $module['module_name'];?>_html select{ margin-left:8px; height:30px; line-height:30px; margin-bottom:10px; margin-top:10px;}
    #<?php echo $module['module_name'];?>_html #icon_img{ margin-left:8px;}
    #<?php echo $module['module_name'];?>_html .input_text{width:200px; height:30px;}
    #<?php echo $module['module_name'];?>_html #license_photo_front_img{ margin-left:8px;}
    #<?php echo $module['module_name'];?>_html #license_photo_reverse_img{ margin-left:8px;}
	#<?php echo $module['module_name'];?>_html #old_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #new_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #confirm_new_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #old_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #new_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #confirm_new_transaction_password{width:220px; height:30px; border-radius:3px; margin-bottom:10px; margin-top:15px; border:1px solid #999; margin-left:5px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #old_transaction_password_state{ font-size:18px; line-height:30px;}
	#<?php echo $module['module_name'];?>_html #find_transaction_password{ font-size:18px;  line-height:30px;}
    #<?php echo $module['module_name'];?>_html .m_label{width:200px; text-align:right; font-size:18px;}
	#<?php echo $module['module_name'];?>_html .submit_button{ margin-left:5px; margin-top:10px;}
	#<?php echo $module['module_name'];?>_html #icon_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #license_photo_front_file{ border:none;}
	#<?php echo $module['module_name'];?>_html #license_photo_reverse_file{ border:none;}
	#<?php echo $module['module_name'];?>_table .odd{ }
	#<?php echo $module['module_name'];?>_table .even{ }

</style>

<?php
require("./include/return_data/css/edit_user.php");
?>

<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html">

<div class="portlet-title" style="padding-bottom: 20px;">
<div class="caption">管理资料</div>
</div>

<div id="select_div">
    <div class="c_option active">用户资料</div>
    <?php echo $module['enterprise_select'];?>
</div>
<div class="from_select_div" style="display:none">

    <form id="edit_user_form" name="edit_user_form" method="POST" action="<?php echo $module['action_url'];?>" onSubmit="return exe_check();">
        <table border="0" cellpadding="0" cellspacing="0" class=<?php echo $module['module_name'];?>_table  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left _table >
            <tr id="tr_manager"><td class="m_label"><?php echo self::$language['manager']?></td><td align="left"><input type="text" id="manager" name="manager" value="" placeholder="<?php echo self::$language['please_input']?><?php echo self::$language['manager']?><?php echo self::$language['real_name']?>" /><span id="manager_state"></span></td></tr>
            <tr id="tr_username"><td class="m_label"><?php echo self::$language['username']?></td><td align="left"><span id="username_state"><?php echo $module['username']?></span></td></tr>

            <tr id="tr_nickname"><td class="m_label"><?php echo self::$language['nickname']?></td><td align="left"><input type="text" id="nickname" name="nickname" value="<?php echo $module['nickname']?>" /><span id="nickname_state"></span></td></tr>
            <tr id="tr_icon"><td class="m_label"><?php echo self::$language['icon']?></td><td align="left" id="tr_td_icon">
                    <img id="icon_img" data-img="1" class="up_img" onerror="default_img(this);" src="/upload/index/user_icon/<?php echo $module['icon']?>" width="100"><br />
                    <?php echo $module['icon_ele'];?>
                    <span id="icon_state"></span></td></tr>

            <tr id="tr_banner"><td class="m_label"><?php echo self::$language['banner']?></td><td align="left" id="tr_td_banner">
                    <img id="banner_img" class="up_img" onerror="default_img(this);" src="/upload/index/user_banner/<?php echo $module['banner']?>" width="100"><br />
                    <?php echo $module['banner_ele'];?>
                    <span id="banner_state"></span></td></tr>

            <tr id="tr_tel"><td class="m_label"><?php echo self::$language['tel']?></td><td align="left"><input type="text" id="tel" name="tel" value="<?php echo $module['tel']?>" /><span id="tel_state"></span></td></tr>
            <tr id="tr_address"><td class="m_label"><?php echo self::$language['address']?></td><td align="left"><input type="text" id="address" name="address" value="<?php echo $module['address']?>" /><span id="address_state"></span></td></tr>
            <tr id="tr_chat_type"><td class="m_label"><?php echo self::$language['chat_type']?></td><td align="left"><select id="chat_type" name="chat_type" onchange="submit_hidden('chat_type')"><?php echo $module['chat_type']?></select><span id="chat_type_state"></span></td></tr>
            <tr id="tr_chat"><td class="m_label"><?php echo self::$language['chat']?></td><td align="left"><input type="text" id="chat" name="chat" value="<?php echo $module['chat']?>" /><span id="chat_state"></span></td></tr>

            <tr id="tr_home_area"><td class="m_label"><?php echo self::$language['home_area']?></td><td align="left"><input type="hidden" id="home_area" name="home_area" value="<?php echo $module['home_area']?>" />
                    <script src="include/core/area_js.php?callback=set_area&input_id=home_area&id=<?php echo $module['home_area']?>&output=select" id='home_area_area_js'></script>
                    <span id="home_area_state" ></span></td></tr>
            <tr id="tr_current_area"><td class="m_label"><?php echo self::$language['current_area']?></td><td align="left"><input type="hidden" id="current_area" name="current_area" value="<?php echo $module['current_area']?>" />
                    <script src="include/core/area_js.php?callback=set_area&input_id=current_area&id=<?php echo $module['current_area']?>&output=select" id='current_area_area_js'></script>
                    <span id="current_area_state" ></span></td></tr>
            <tr id="tr_birthday"><td class="m_label"><?php echo self::$language['birthday']?></td><td align="left">
                    <input type="text" id="birthday" name="birthday" value="<?php echo $module['birthday'];?>"   onclick=show_datePicker(this.id,'date') onblur="hide_datePicker()"  />

                    <span id="birthday_state"></span></td></tr>
            <tr id="tr_introducer" ><td class="m_label"><?php echo self::$language['introducer']?></td><td align="left"><input type="text" id="introducer" name="introducer" value="<?php echo $module['introducer']?>" placeholder="<?php echo self::$language['please_input'];?><?php echo self::$language['introducer']?><?php echo self::$language['phone'];?>" /><span id="introducer_state"></span></td></tr>
            <tr id="tr_real_name"><td class="m_label"><?php echo self::$language['real_name']?></td><td align="left"><?php echo $module['real_name']?></td></tr>
            <tr id="tr_license_type"><td class="m_label"><?php echo self::$language['license_type']?></td><td align="left"><select id="license_type" name="license_type" onchange="submit_hidden('license_type')"><?php echo $module['license_type']?></select><span id="license_type_state"></span></td></tr>
            <tr id="tr_license_id"><td class="m_label"><?php echo self::$language['license_id']?></td><td align="left"><input type="text" id="license_id" name="license_id" value="<?php echo $module['license_id']?>" /><span id="license_id_state"></span></td></tr>

            <tr id="tr_license_photo_front"><td class="m_label"><?php echo self::$language['license_photo_front']?></td><td align="left" id="tr_td_license_photo_front">
                    <img id="license_photo_front_img" class="up_img" onerror="default_img(this);" src="/upload/index/user_license_photo_front/<?php echo $module['license_photo_front']?>" height="100"><br />
                    <?php echo $module['license_photo_front_ele'];?>
                    <span id="license_photo_front_state"></span></td></tr>

            <tr id="tr_license_photo_reverse"><td class="m_label"><?php echo self::$language['license_photo_reverse']?></td><td align="left" id="tr_td_license_photo_reverse">
                    <img id="license_photo_reverse_img" class="up_img" onerror="default_img(this);" src="/upload/index/user_license_photo_reverse/<?php echo $module['license_photo_reverse']?>" height="100"><br />
                    <?php echo $module['license_photo_reverse_ele'];?>
                    <span id="license_photo_reverse_state"></span></td></tr>


            <tr id="tr_gender"><td class="m_label"><?php echo self::$language['gender']?></td><td align="left"><select id="gender" name="gender" onchange="submit_hidden('gender')"><?php echo $module['gender']?></select><span id="gender_state"></span></td></tr>
            <tr id="tr_blood_type"><td class="m_label"><?php echo self::$language['blood_type']?></td><td align="left"><select id="blood_type" name="blood_type" onchange="submit_hidden('blood_type')"><?php echo $module['blood_type']?></select><span id="blood_type_state"></span></td></tr>
            <tr id="tr_profession"><td class="m_label"><?php echo self::$language['profession']?></td><td align="left"><input type="text" id="profession" name="profession" value="<?php echo $module['profession']?>" /><span id="profession_state"></span></td></tr>
            <tr id="tr_education"><td class="m_label"><?php echo self::$language['education']?></td><td align="left"><select id="education" name="education" onchange="submit_hidden('education')"><?php echo $module['education']?></select><span id="education_state"></span></td></tr>
            <tr id="tr_height"><td class="m_label"><?php echo self::$language['height']?></td><td align="left"><input type="text" id="height" name="height" value="<?php echo $module['height']?>" /><span id="height_state"></span></td></tr>
            <tr id="tr_weight"><td class="m_label"><?php echo self::$language['weight']?></td><td align="left"><input type="text" id="weight" name="weight" value="<?php echo $module['weight']?>" /><span id="weight_state"></span></td></tr>
            <tr id="tr_married"><td class="m_label"><?php echo self::$language['married']?></td><td align="left"><select id="married" name="married" onchange="submit_hidden('married')"><?php echo $module['married']?></select><span id="married_state"></span></td></tr>
            <tr id="tr_annual_income"><td class="m_label"><?php echo self::$language['annual_income']?></td><td align="left"><select id="annual_income" name="annual_income" onchange="submit_hidden('annual_income')"><?php echo $module['annual_income']?></select><span id="annual_income_state"></span></td></tr>
            <tr id="tr_domain"><td class="m_label"><?php echo self::$language['domain']?></td><td align="left"><input type="text" id="domain" name="domain" value="<?php echo $module['domain']?>" style="width:300px;"/><?php echo $module['domain_postfix']?> <span id="domain_state"></span></td></tr>
            <tr id="tr_homepage"><td class="m_label"><?php echo self::$language['homepage']?></td><td align="left"><input type="text" id="homepage" name="homepage" value="<?php echo $module['homepage']?>" /><span id="homepage_state"></span></td></tr>
            <tr id="tr_chip"><td class="m_label"><?php echo self::$language['chip']?></td><td align="left"><input type="text" id="chip" name="chip" value="<?php echo $module['chip']?>" /><span id="chip_state"></span></td></tr>

            <tr id="tr_weixincode"><td class="m_label">微信二维码</td><td align="left" id="tr_td_weixincode">
                    <img id="weixincode_img" class="up_img" onerror="default_img(this);" src="/upload/index/user_weixincode/<?php echo $module['weixincode']?>" height="100"><br />
                    <?php echo $module['weixincode_ele'];?>
                    <span id="weixincode_state"></span></td>
            </tr>
            <tr style="height: 50px"><td></td></tr>
            <tr id="tr_password"><td colspan="2">
                    <table id="update_password">
                        <tr><td class="m_label"><?php echo self::$language['old_password']?></td><td align="left"><input type="password" id="old_password" name="old_password" value="" /><span id="old_password_state"></span></td></tr>
                        <tr><td class="m_label"><?php echo self::$language['new_password']?></td><td align="left"><input type="password" id="new_password" name="new_password" value="" /><span id="new_password_state"></span></td></tr>
                        <tr><td class="m_label"><?php echo self::$language['confirm']?><?php echo self::$language['new_password'];?></td><td align="left"><input type="password" id="confirm_new_password" name="confirm_new_password" value="" /><span id="confirm_new_password_state"></span></td></tr>
                        <tr><td class="m_label">&nbsp;</td><td align="left"><a href="#"  class="submit_button"  user_color='button'  onclick="return update_password();"><?php echo self::$language['submit']?></a><span id="update_password_state"></span></td></tr>
                    </table>

                </td></tr>


            <tr id="tr_transaction_password"><td colspan="2">
                    <table id="update_transaction_password">
                        <?php if($module['transaction_password']!=''){?>
                            <tr><td class="m_label"><?php echo self::$language['old_transaction_password']?></td><td align="left"><input type="password" id="old_transaction_password" name="old_transaction_password" value="" /><span id="old_transaction_password_state"></span>  <a href="/index.php?cloud=index.resetPassword&field=transaction_password" id="find_transaction_password"><?php echo self::$language['get_password']?></a></td></tr>
                        <?php }?>
                        <tr><td class="m_label"><?php echo self::$language['new_transaction_password']?></td><td align="left"><input type="password" id="new_transaction_password" name="new_transaction_password" value="" /><span id="new_transaction_password_state"></span></td></tr>
                        <tr><td class="m_label"><?php echo self::$language['confirm']?><?php echo self::$language['new_transaction_password'];?></td><td align="left"><input type="password" id="confirm_new_transaction_password" name="confirm_new_transaction_password" value="" /><span id="confirm_new_transaction_password_state"></span></td></tr>
                        <tr><td class="m_label">&nbsp;</td><td align="left"><a href="#" class="submit_button"  user_color='button' onclick="return <?php echo $module['transaction_password_act']?>_transaction_password();"><?php echo self::$language['submit']?></a><span id="update_transaction_password_state"></span></td></tr>
                    </table>

                </td></tr>


        </table>
    </form>
</div>
<?php echo $module['enterprise_html'];?>
    </div>

</div>
<script>

    $("#select_div div").click(function(){
        $(".from_select_div").hide();
        $("#select_div div").removeClass("active")
        $(this).addClass("active")
        $(".from_select_div").eq($(this).index()).show();
    })

    $("#select_div div").eq(0).trigger("click");
    function update_enterprise(){
        var enterprisename=$("#enterprisename").val();
        var enterprisecode=$("#enterprisecode").val();
        var enterprise_person=$("#enterprise_person").val();
        var enterprise_contact=$("#enterprise_contact").val();
        var enterprisephone=$("#enterprisephone").val();
        var enterprise_photo=$("#enterprise_photo").val();
        var enterpriseide_a=$("#enterpriseide_a").val();
        var enterpriseide_b=$("#enterpriseide_b").val();
        var enterpriseadd=$("#enterpriseadd").val();
        var enterprisecale=$("#enterprisecale").val();
        var obj={
            'enterprisename':enterprisename,
            'enterprisecode':enterprisecode,
            'enterprise_person':enterprise_person,
            'enterprise_contact':enterprise_contact,
            'enterprisephone':enterprisephone,
            'enterprise_photo':enterprise_photo,
            'enterpriseide_a':enterpriseide_a,
            'enterpriseide_b':enterpriseide_b,
            'enterpriseadd':enterpriseadd,
            'enterprisecale':enterprisecale
        }
        for(var v in obj){
            if(obj[v] == ''){
                alert($("#tr_"+v).find(".m_label").html()+"不能为空");
                return false;
            }
            console.log(v);
        }

        $.get('<?php echo $module['action_url'];?>&update=update_enterprise',obj,function(d){
            console.log(d);
        })
    }
</script>