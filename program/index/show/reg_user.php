<?php
if(isset($_SESSION['user']['username']) && $_SESSION['user']['username']!=''){header('location:./index.php?cloud=index.user');exit;}
if(@$_GET['refresh']!=''){header('location:./index.php?cloud=index.user');exit;}
$group_id=intval(@$_GET['group_id']);


$module["readonly"]="";
$module["input_username_hint"]="邮箱/手机/用户名";
$module["input_username_title"]="";
if(isset($_GET['invite'])){
	if($_GET['invite'] != ""){
		$invite=@$_GET['invite'];
		$sql="select `invite_admin`,`invite_edit`,`invite_read`,`description`,`creater` from ".$pdo->table_pre."table where `invite_admin` like '%,".$invite."%' or `invite_edit` like '%,".$invite."%' or `invite_read` like '%,".$invite."%'";
		$r=$pdo->query($sql,2);
		$module["input_username_title"]='<div class="line" style="margin: 0;"><span class="m_label">&nbsp;</span><span style="color:red;" class=input_span>您的邀请已经过期!</span></div>';
		$input_username_title="";
		foreach ($r as $v) {
			$module["readonly"]="readonly disabled";
			$module["input_username_hint"]=$invite;
			$admin_type="";
			if(strstr($v['invite_read'],$invite)){
				$admin_type.="[管理员]";
			}
			if(strstr($v['invite_edit'],$invite)){
				$admin_type.="[管理员]";
			}
			if(strstr($v['invite_admin'],$invite)){
				$admin_type.="[管理员]";
			}
			$input_username_title.='<div class="line" style="margin: 0;"><span class="m_label">&nbsp;</span><span style="color:#7266ba;" class=input_span>你受邀请['.$v["description"].']的'.$admin_type.'</span></div>';
			$module["input_username_title"]=$input_username_title;
		}
	}
}
 
$sql="select * from ".$pdo->index_pre."group where `id`='$group_id'";
//如果后台设置该注的必注册项,则下面数组中包含的字段将是单行字符提交,新加了字段请添加到该表中
//username password 默认已经经解析出来
$inputs_arr=Array("home_area","current_area","address","nickname","email","tel","phone","introducer","chat","birthday","real_name","license_id","profession","height","weight","domain","homepage","chip","recommendation","openid");
function giveReguser_inputs($str,$language){
	$t='<div class=line><span class="m_label">'.$language[$str].'：</span><span class=input_span><input class="input_text" type="text" name="'.$str.'" id="'.$str.'"  /></span><span id='.$str.'_state></span></div>';
	return $t;
}
//地址
$area_arr=Array();
function giveReguser_areas($str,$language){
	$t='<div class=line><span class="m_label">'.$language[$str].'：</span><span class=input_span>';
	$t.='<input type="hidden" id="'.$str.'" name="'.$str.'" value="" />';
    $t.='<script src="include/core/area_js.php?callback=set_area&input_id='.$str.'&id=0&output=select" id="'.$str.'_area_js"></script>';
    $t.='</span><span id='.$str.'_state></span></div>';

	return $t;
}
//下拉
$select_arr=Array("license_type","education","blood_type","married","chat_type","gender","annual_income");
	
function giveReguser_selects($type,$language,$pdo){
	$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
	$stmt=$pdo->query($sql,2);
	//$module[$type]="<option value=''></option>";
	$module["list"]="";
	foreach($stmt as $v){
		$module["list"].="<option value='".$v['id']."' >".$v['name']."</option>";	
	}
	$select= "<select id=\"".$type."\" name=\"".$type."\" >".$module["list"]."</select>";

	$t='<div class=line><span class="m_label">'.$language[$type].'：</span><span class=input_span>';
	$t.=$select;
	$t.='</span><span id='.$type.'_state></span></div>';
	return $t;	
}

//用于支持用户上传图片
require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
//图形
$photos_arr=Array("icon","license_photo_front","license_photo_reverse","banner","weixincode");
	
function giveReguser_photos($str,$language,$html4Upfile){
	$input="<span id='".$str."_ele'>";
	$input.=$html4Upfile->return_input("$str",'100%','/upload/index/user_'.$str.'/','true','false','jpg|gif|png|jpeg',1024*10,'5');
	$input.='</span>';
	$html='<img id="'.$str.'_img" class="up_img" src="/templates/1/index/default/pc/img/defualt.png" width="150"><br>
<span id="'.$str.'_ele">
<!--top_html4 echo_input(license_photo_reverse) 开始-->
'.$input.'
<!--top_html4 echo_input(license_photo_reverse) 结束-->
</span><span id="license_photo_reverse_state"></span>';
	$t='<div class=line><span class="m_label">'.$language[$str].'：</span><span class=input_span>';
	$t.=$html;
	$t.='</span><span id='.$str.'_state></span></div>';
	return $t;	
}


//密码
//"password", 默认已经存在
$passwords_arr=Array("transaction_password");
function giveReguser_passwords($str,$language){
	$t='<div class=line><span class="m_label">'.$language[$str].'：</span><span class=input_span><input class="input_text" type="password" name="'.$str.'" id="'.$str.'"  /></span><span id='.$str.'_state></span></div>';
	return $t;
}

//地图定位
$maps=Array("geolocation");


$r=$pdo->query($sql,2)->fetch(2);


if($r['reg_able']==0 && $group_id>0){
	echo self::$language['no_registration'].": ".$r['name'];
}else{
	$module['group']="<option value='0'>".self::$language['please_select']."</option>".index::get_group_select($pdo,0,0);
	$backurl=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'./index.php?cloud=index.user';
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&oauth=".@$_GET['oauth']."&backurl=".$backurl;
	$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
	$module['module_name']=str_replace("::","_",$method);
	$module['user_agreement_url']=self::$config['reg_set']['user_agreement_url'];
	


	$ohter_input_arr=explode(",",$r["require_info"]);
	//var_dump($ohter_input_arr);
	$module['ohter_input']='';
	foreach ($ohter_input_arr as $v) {
		if(in_array($v, $inputs_arr)){ //单行文本.
			$module['ohter_input'].=giveReguser_inputs($v,self::$language);
		}
		if(in_array($v, $area_arr)){ //地址选择器.
			$module['ohter_input'].=giveReguser_areas($v,self::$language);
		}
		if(in_array($v, $select_arr)){ //地址选择器.
			$module['ohter_input'].=giveReguser_selects($v,self::$language,$pdo);
		}
		if(in_array($v, $photos_arr)){//图片上传
			$module['ohter_input'].=giveReguser_photos($v,self::$language,$html4Upfile);
		}
		if(in_array($v, $passwords_arr)){
			$module['ohter_input'].=giveReguser_passwords($v,self::$language);

		}

	}
	$_SESSION['form_token']=get_verification_code(10);
	$module['ohter_input'].='<input type=hidden id=token name=token value="'.$_SESSION['form_token'].'" />';
	$module['reg_phone']=self::$config['other']['reg_phone'];
	$module['reg_email']="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";
	
	echo '<div style="display:none;" id="visitor_position_append"><append>'.self::$language['reg_user'].'</append></div>';
	$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	
}
