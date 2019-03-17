<?php
//print_arr($_SESSION);
admin_return($pdo,$_SESSION);
$module['publish_condition']="";
$module["property_json"]="";
$module["field_json"]="";
//如果是编辑模式,则提供数据
if(isset($_GET['edit'])){
//edit
	$is_table_admin=check_is_table_admin($pdo,$_GET['edit'],$_SESSION);
	if($is_table_admin != 1){
		exit(alert_info("你不能修改该表",$title="没有权限",$click="history.go(-1);"));
	}
	function get_invite_userType($pdo,$table_id,$type,$user){
		$re=return_table_info($pdo,$pdo->table_pre."table","invite_".$type,"id",$table_id,false);
		$re=explode(",", $re);
		switch ($user) {
			case 'phone':
				$reg="/^(1)[0-9]{10}$/";
				break;
			case 'email':
				$reg="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/";
				break;
			default:
				$reg="//";
				break;
		}
		$s="";
		foreach ($re as $value) {
			if(preg_match($reg, $value)){
				/*提取PHONE*/
				$s.=$value.",";
			}
		}
		return $s;
	}

	$table_id=intval(@$_GET['edit']);
	$sql="select * from ".$pdo->table_pre."table where `id`=".$table_id;
	$r=$pdo->query($sql,2)->fetch();

	/*--给属性*/
	$property["description"]=$r["description"];//表名
	$property["write_state"]=$r["write_state"];//是否开启表
	$property["id"]=$r["id"];//表ID
	$property["name"]=$r["name"];//表NAME
	/*-是否允许查询----------------*/
	$property["read_state"]["check"]=$r["read_state"];
	$property["read_state"]["read_state"]=$r["read_state"];//开启查询
	$property["read_state"]["publish_condition"]=$r["publish_condition"];//查询条件

	$property["default_publish"]=$r["default_publish"];//默认显示
	$property["authcode"]=$r["authcode"];//是否开启验证码
	$property["shortcut"]=$r["shortcut"];//快捷语
	
	/*-团队协作----------------*/
	$property["admin_is_edit"]=$r["admin_is_edit"];//表维护成员
	$property["Member_ADDPower_check"]["edit_power"]=$r["edit_power"];//表维护成员
	$property["Member_ADDPower_check"]["read_power"]=$r["read_power"];//表查看成员
	$property["Member_ADDPower_check"]["admin_power"]=$r["admin_power"];//表管理成员
	$property["Member_ADDPower_check"]["invite"]["phones"]["read"]=get_invite_userType($pdo,$table_id,"read","phone");//邀请中表维护 
	$property["Member_ADDPower_check"]["invite"]["phones"]["edit"]=get_invite_userType($pdo,$table_id,"edit","phone");//邀请中表编辑
	$property["Member_ADDPower_check"]["invite"]["phones"]["admin"]=get_invite_userType($pdo,$table_id,"admin","phone");//邀请中表查看
	$property["Member_ADDPower_check"]["invite"]["emails"]["read"]=get_invite_userType($pdo,$table_id,"read","email");//邀请中表维护 
	$property["Member_ADDPower_check"]["invite"]["emails"]["edit"]=get_invite_userType($pdo,$table_id,"edit","email");//邀请中表编辑
	$property["Member_ADDPower_check"]["invite"]["emails"]["admin"]=get_invite_userType($pdo,$table_id,"admin","email");//邀请中表查看 

	$property["sms_inform"]=$r["sms_inform"];//有新填写时是否通透用户,目前默认否
	$property["email_inform"]=$r["email_inform"];//有新填写时是否邮箱
	$property["inform_user"]=$r["inform_user"];//通知到那个用户
	$property["css_width"]="";//$r["css_width"];//css宽度 预定接口
	$property["css_pc_bg"]="";//$r["css_pc_bg"];//背景图片 预定接口
	$property["css_pc_top"]="";//$r["css_pc_top"];//图到顶距离 预定接口
	$property["css_phone_bg"]="";//$r["css_phone_bg"];//背景图 预定接口
	$property["css_phone_top"]="";//$r["css_phone_top"];//图到顶部距离  预定接口
	$property["css_diy"]="";//$r["css_diy"];//个性化CSS
	$property["remark"]=$r["remark"];//表简介(描述 )
	/*-是否重复提交----------------*/
	$property["uniqueness"]["check"]=intval($r["uniqueness"]);//是否重复
	$property["uniqueness"]["uniqueness"]=intval($r["uniqueness"]);//是否重复
	$property["uniqueness"]["uniqueness_name"]=$r["uniqueness_name"];//判断用户重复字段

	//$property["authorization"]=$r["authorization"];//授权用户组 已废弃
	$property["edit_time"]=$r["edit_time"];		
	$property["adm_color"]=$r["adm_color"];//后台随机分的显示色
	$property["adm_color_code"]=$r["adm_color_code"];//后台随机分的显示色16进度码
	/*-表背景图----------------*/
	if($r["backgroundimage"] != ""){
		$property["form_background"]["check"]=1;//是否开启
	}else{
		$property["form_background"]["check"]=0;//是否开启
	}
	$property["form_background"]["backgroundimage"]=$r["backgroundimage"];//背景图
	$property["form_background"]["backgroundposition"]=$r["backgroundposition"];//背景图居中(左,中,右)
	$property["form_background"]["background_fix"]=$r["background_fix"];//背景图是否固定
	$property["form_background"]["backgroundrepeat"]=$r["backgroundrepeat"];//背景图重复
	/*-表头背景图----------------*/
	if($r["titlebackgroundimage"] != ""){
		$property["form_title_background"]["check"]=1;
	}else{
		$property["form_title_background"]["check"]=0;
	}
	$property["form_title_background"]["titlebackgroundimage"]=$r["titlebackgroundimage"];//表头背景图
	/*-是否短信----------------*/
	$property["table_sms"]["table_sms"]=$r["table_sms"];//是否短信
	if(strstr($property["table_sms"]["table_sms"],"sms")){
		$property["table_sms"]["check"]=1;//是否短信
	}else{
		$property["table_sms"]["check"]=0;//是否短信
	}
	/*-表头LOGO----------------*/
	if($r["titlebackgroundlogo"] != ""){
		$property["form_changelogo"]["check"]=1;
	}else{
		$property["form_changelogo"]["check"]=0;
	}
	$property["form_changelogo"]["titlebackgroundlogo"]=$r["titlebackgroundlogo"];//表头LOGO图片
	$property["form_changelogo"]["titleclass"]=$r["titleclass"];//需要有的CLASS
	$property["form_changelogo"]["titlestyle"]=$r["titlestyle"];//表标题style属性
	$property["backgroundcolor"]=$r["backgroundcolor"];
	$property["titlebackgroundcolor"]=$r["titlebackgroundcolor"];
	$property["titlefontcolor"]=$r["titlefontcolor"];
	$property["mainfontcolor"]=$r["mainfontcolor"];
	$property["mainbackgroundcolor"]=$r["mainbackgroundcolor"];
	$property["desfontcolor"]=$r["desfontcolor"];
	$property["describe"]=$r["describe"];
	/*提交后动作 1=二维码*/
	$property["callback"]=$r["callback"];

	/*JSON数据打包*/
	$module["property_json"]=json_encode($property);

	
}
//上传控件
require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$module['backgroundimage']=$html4Upfile->return_tableAdd_input("backgroundimage",'100%','/upload/form/backgroundimage/','true','false','jpg|gif|png|jpeg',1024*10,'5');//表底图
$module['titlebackgroundlogo']=$html4Upfile->return_tableAdd_input("titlebackgroundlogo",'100%','/upload/form/titlebackgroundlogo/','true','false','jpg|gif|png|jpeg',1024*10,'5');//表头LOGO
$module['titlebackgroundimage']=$html4Upfile->return_tableAdd_input("titlebackgroundimage",'100%','/upload/form/titlebackgroundimage/','true','false','jpg|gif|png|jpeg',1024*10,'5');//表头底图 

$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


$_SESSION['token'][$method]=get_random(8);
$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['token']=$_SESSION['token'][$method];

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
