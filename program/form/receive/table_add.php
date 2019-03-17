<?php
/*表id*/
$id=intval(@$_GET['id']);
/*会员等级 1管理员 2企业用户 3普通用户 4+未定义*/
$level=check_is_admin_user($pdo,$_SESSION);
$act=@$_GET['act'];
//请求用户数据
function check_this_user_levelTo2($level){
	if($level > 2){
		exit("{'fail':'你的会员等级不能建立表'}");
	}
}

if($act=="getMyMember"){
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","admin_is_edit,creater","id",$id,false);
	//get_member($pdo,$table_creater,$admin_is_edit,$retype="default")
	$r=get_member($pdo,$tableInfo["creater"],$tableInfo["admin_is_edit"]);
	exit(json_encode($r));
}
if($act=="getuser"){
	$username=@$_GET['username'];
	$a=return_username_info($pdo,$username,"id,reg_time,last_time,real_name,username,email,nickname,icon,phone,weixincode,chip");
	if($a["id"] != ""){
		exit(json_encode($a));
	}else{
		exit('{"failed":"'.$username.'"}');
	}
}

if($act=="create_html"){
	/*生成静态*/
	create_table($_SERVER,$id);
}

//编辑模式给前端表的数据
if($act=="getfields"){
	$table_id=@intval($_GET['table_id']);
	if($table_id == ""){
		exit("");
	}
	$sql="select * from ".self::$table_pre."field where `type`!='系统自带' and `type`!='系统添加' and `type`!='系统' and `table_id`=".$table_id." order by `sequence` asc";
	$json_arr=array();
	$r=$pdo->query($sql,2);
	foreach ($r as $value) {
		array_push($json_arr, json_encode($value));
	}
	$fields=json_encode($json_arr);
	exit($fields);
}

//新建表 为配合前端,失败时不返回任何数据
if($act=='add'){
	check_this_user_levelTo2($level);
	//exit('{"fail":"创建失败_请检查表名"}');
	$_GET['description']=@$_GET['description'];//表名(中文)
	$_GET['remark']=@$_GET['remark'];//
	$create_username=$_SESSION['user']['username'];
	$create_time=time();
	$table_name=auto_give_Diytable_name($pdo,$_SESSION['user']['id']);//表名(英文)
	//exit($table_name);
	if($_GET['description'] == ''){
		exit('{"fail":"创建失败_请检查表名"}');
	}

	if(field_exist($pdo,$table_name,'id')){
		exit("{'fail':'表名已经存在".$table_name."'}");
	}
/*创建建新表语句 */
$sql="CREATE TABLE ".$pdo->table_pre.$table_name." (`id` BIGINT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
`write_time` BIGINT(12) DEFAULT NULL COMMENT '写入时间',
`writer` INT(11) DEFAULT NULL COMMENT '写入者',
`edit_time` BIGINT(12) DEFAULT NULL COMMENT '编辑时间',
`editor` INT(11) DEFAULT NULL COMMENT '编辑者',
`publish` INT(1) DEFAULT NULL COMMENT '发布',
`sequence` INT(5) DEFAULT 0 COMMENT '排序',
`visit` INT(10) DEFAULT 0 COMMENT '用户来访',
`statistics` BIGINT(12) DEFAULT 0 COMMENT '访问统计',
`examined` INT(1) DEFAULT 0 COMMENT '默认表审核数字状态',
`creater` VARCHAR(20) DEFAULT NULL COMMENT '表创始人',
`assessor` VARCHAR(20) DEFAULT NULL COMMENT '表操作员',
`state` VARCHAR(10) DEFAULT NULL COMMENT '表状态',
`state_txt` VARCHAR(50) DEFAULT NULL COMMENT '表状态备注',
`overdue` INT(1) DEFAULT 0 COMMENT '逾期',
`shrink_img` INT(1) DEFAULT 0 COMMENT '图片压缩') ENGINE = MYISAM DEFAULT CHARSET=UTF8";
$pdo->exec($sql);
	if(field_exist($pdo,$pdo->table_pre.$table_name,'id')){
		//创建完表后往  总表列表  里添加该表的资料
		$time=time();
		$sql="insert into ".$pdo->table_pre."table (`remark`,`creater`,`table_join`,`name`,`description`,`authorization`,`table_sms`,`create_time`,`edit_time`) value ('".$_GET['remark']."','".$create_username."','examined','".$table_name."','".$_GET['description']."','0','|审核中&|复审中&|已通过&sms|未通过&',".$time.",".$time.")";	//查询条件publish_condition	
		$pdo->exec($sql);
		//============================================================================================添加默认字段
		$table_id=$pdo->lastInsertId();
		/*默认所有用户可以向该表单提交数据*/
		auto_set_table_write($pdo,$table_id);
		/*
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','address','用户地址','varchar','text','','0','255','','0','1','0','','0','1','1','1')";
		$pdo->exec($sql);
		//手机号码
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','phone','手机号码','varchar','text','','','11','/^(1)[0-9]{10}$/','0','1','1','|text_length:11|text_default_value:','1','1','1','1')";
		$pdo->exec($sql);
		*/
		//self::$language['sys_bring'] 系统自带
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','state','状态','".self::$language['sys_bring']."','varchar','','0','255','','0','1','0','','0','1','1','10003')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','edit_time','编辑时间','".self::$language['sys_bring']."','varchar','','0','12','','0','0','1','','0','1','0','10002')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','editor','编辑','".self::$language['sys_bring']."','varchar','','0','12','','0','0','1','','0','1','0','10001')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','write_time','填写时间','".self::$language['sys_bring']."','varchar','','0','12','','0','0','1','','0','1','0','10000')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','writer','填写者','".self::$language['sys_bring']."','varchar','','0','11','','0','0','1','','0','1','0','9999')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','publish','公开状态','".self::$language['sys_bring']."','varchar','','0','12','','0','0','1','','0','1','0','9998')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','sequence','排序','".self::$language['sys_bring']."','varchar','','0','10','','0','0','1','','0','1','0','9997')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','visit','访问量','".self::$language['sys_bring']."','varchar','','0','10','','0','0','1','','0','1','0','9996')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','statistics','访问统计','".self::$language['sys_bring']."','varchar','','0','12','','0','1','0','','0','1','1','9995')";
		$pdo->exec($sql);
		//默认审核表单
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','overdue','逾期','".self::$language['sys_bring']."','varchar','','0','12','','0','1','0','','0','1','1','-996')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','assessor','审核员','".self::$language['sys_bring']."','varchar','','0','50','','0','1','0','','0','1','1','-997')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','examined','审核状态','".self::$language['sys_bring']."','select','','0','12','','0','1','0','|select_option:审核中/复审中/已通过/未通过|select_default_value:审核中','0','1','1','-998')";
		$pdo->exec($sql);
		$sql="insert into ".self::$table_pre."field (`table_id`,`name`,`description`,`type`,`input_type`,`placeholder`,`default_value`,`length`,`reg`,`unique`,`search_able`,`required`,`input_args`,`fore_list_show`,`back_list_show`,`read_able`,`sequence`) values ('".$table_id."','state_txt','状态备注','".self::$language['sys_bring']."','varchar','','0','255','','0','1','0','','0','1','1','-999')";
		$pdo->exec($sql);
		
		exit("{'table_id':'".$table_id."','table_name':'".$table_name."'}");
	}else{
		exit("{'fail':'创建失败:代码:".$pdo->errorCode()."'}");
	}
}

//给表返回字段.
if($act=='get_join_table'){
	if($id == 0){
		exit('');
	}else{
		//$tableInfo=return_table_info($pdo,$pdo->table_pre."field","name,description,id","table_id,type",$id.","."系统自带",true);
		$tableInfo=return_table_info($pdo,$pdo->table_pre."field","id,name,description,id","table_id",$id,true);
		$a=echo_json($tableInfo);
		exit($a);
	}
}
if($act=='get_shortcut'){
	if($id == 0){
		exit('资料不齐全,不是本人操作,不配合提供资料,暂时不借,信用分不达标,尚有逾期未清,资料齐全属实');
	}else{
		//$tableInfo=return_table_info($pdo,$pdo->table_pre."field","name,description,id","table_id,type",$id.","."系统自带",true);
		$tableInfo=return_table_info($pdo,$pdo->table_pre."table","shortcut","id",$id,false);
		$tableInfo=str_replace("|",',',$tableInfo);
		exit($tableInfo);
	}
}
//返回团队成员资料
if($act=='Member_Poweradmin'){
	check_this_user_levelTo2($level);//用户会员等级
	$user_id=@$_POST["userid"];
	$userInfo=return_table_info($pdo,$pdo->index_pre."user","username,phone,icon","id",$user_id,false);
	$json=json_encode($userInfo);
	exit($json);
}
if($act=='Member_Poweredit'){
	check_this_user_levelTo2($level);//用户会员等级
	$user_id=@$_POST["userid"];
	$userInfo=return_table_info($pdo,$pdo->index_pre."user","username,phone,icon","id",$user_id,false);
	$json=json_encode($userInfo);
	exit($json);
}
if($act=='Member_Powerread'){
	check_this_user_levelTo2($level);//用户会员等级
	$user_id=@$_POST["userid"];
	$userInfo=return_table_info($pdo,$pdo->index_pre."user","username,phone,icon","id",$user_id,false);
	$json=json_encode($userInfo);
	exit($json);
}
//是否给予删除
if($act=='deletebutton'){
	check_this_user_levelTo2($level);//用户会员等级
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","name,creater,admin_power","id",$id,false);
	$table_creater=$tableInfo["creater"];
	$table_name=$tableInfo["name"];
	$table_adminId=explode("|", $tableInfo["admin_power"]);
	if($_SESSION["user"]["username"] == $table_creater || in_array($_SESSION["user"]["id"], $table_adminId) || $_SESSION["user"]["group_id"] == 1){
		$deleteid=intval(@$_GET["deleteid"]);
		$deleteidfield=return_table_info($pdo,$pdo->table_pre."field","name,default_value","id",$deleteid,false);
		$sql="select `".$deleteidfield["name"]."` from ".$pdo->table_pre.$table_name;
		
		$r=$pdo->query($sql,2);
		foreach ($r as $value) {
			if($value[$deleteidfield["name"]] != "" && $value[$deleteidfield["name"]] != $deleteidfield["default_value"]){
				exit("");
			}
		}
		exit("ok");
	}else{
		exit("{'fail':'你未获得此表单的管理权'}");
	}
}

//修改表属性
if($act=='update_property'){
	check_this_user_levelTo2($level);//用户会员等级
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","name,creater,admin_power","id",$id,false);
	$table_creater=$tableInfo["creater"];
	$table_name=$tableInfo["name"];
	$table_adminId=explode("|", $tableInfo["admin_power"]);
	if($_SESSION["user"]["username"] == $table_creater || in_array($_SESSION["user"]["id"], $table_adminId) || $_SESSION["user"]["group_id"] == 1){
		if($id == '' || $id == 0){
			exit("{'fail':'服务器未接收到表名'}");
		}
		//$id=intval(@$_POST['id']);//本次以POST方式
		$time=time();
		$update_arr["description"]=@$_POST["description"];//表名
		$update_arr["describe"]=@$_POST["describe"];//副标题
		$update_arr["write_state"]=@$_POST["write_state"];//是否开启表
		/*-是否允许查询----------------*/
		$read_state=@$_POST["read_state"];
		if(intval($read_state["check"]) == 1){
			$update_arr["read_state"]=intval($read_state["check"]);//开启查询
			$update_arr["publish_condition"]=$read_state["publish_condition"];//查询条件
		}else{
			$update_arr["read_state"]=0;//开启查询
			$update_arr["publish_condition"]="";//查询条件
		}
		$update_arr["default_publish"]=@$_POST["default_publish"];//默认显示
		$update_arr["authcode"]=@$_POST["authcode"];//是否开启验证码
		/*-是否开启表----------------*/
		if(intval($update_arr["write_state"]) == 1){
			auto_set_table_write($pdo,$id,true);//允许所有用户添加
		}else{
			auto_set_table_write($pdo,$id,false);//关闭所有用户添加
		}
		/*-团队协作----------------*/
		$Member_ADDPower_check=@$_POST["Member_ADDPower_check"];//团队协作
		$update_arr["admin_is_edit"]=@$_POST["admin_is_edit"];//表管理是否维护数据
		$table_createrId=return_username_info($pdo,$table_creater,"id");
		$update_arr["edit_power"]=return_usernames_infoStr($pdo,$Member_ADDPower_check["edit_power"],"id",$table_createrId);//表维护成员
		$update_arr["read_power"]=return_usernames_infoStr($pdo,$Member_ADDPower_check["read_power"],"id",$table_createrId);//表查看成员
		$update_arr["admin_power"]=return_usernames_infoStr($pdo,$Member_ADDPower_check["admin_power"],"id",$table_createrId);//表管理成员
		$update_arr["invite_edit"]=$Member_ADDPower_check["invite"]["phones"]["edit"].$Member_ADDPower_check["invite"]["emails"]["edit"];//表管理成员
		$update_arr["invite_read"]=$Member_ADDPower_check["invite"]["phones"]["read"].$Member_ADDPower_check["invite"]["emails"]["read"];//表管理成员
		$update_arr["invite_admin"]=$Member_ADDPower_check["invite"]["phones"]["admin"].$Member_ADDPower_check["invite"]["emails"]["admin"];//表管理成员
		invite_users($pdo,$Member_ADDPower_check["invite"],$id,$_SESSION["user"]["username"],$update_arr["description"]);

		$update_arr["sms_inform"]=0;//有新填写时是否通透用户,目前默认否
		$update_arr["email_inform"]=@$_POST["email_inform"];//有新填写时是否邮箱
		$update_arr["inform_user"]='';//通知到那个用户
		$update_arr["css_width"]=@$_POST["css_width"];//css宽度
		$update_arr["css_pc_bg"]=@$_POST["css_pc_bg"];//背景图片
		$update_arr["css_pc_top"]=@$_POST["css_pc_top"];//图到顶距离
		$update_arr["css_phone_bg"]=@$_POST["css_phone_bg"];//背景图
		$update_arr["css_phone_top"]=@$_POST["css_phone_top"];//图到顶部距离 
		$update_arr["css_diy"]=@$_POST["css_diy"];//个性化CSS
		$update_arr["remark"]=@$_POST["remark"];//表简介(描述 )
		$update_arr["shortcut"]=@$_POST["shortcut"];//快捷

		/*-是否重复提交----------------*/
		$uniqueness=@$_POST["uniqueness"];
		if(intval($uniqueness["check"]) == 1){
			$update_arr["uniqueness"]=intval($uniqueness["check"]);//是否重复
			$update_arr["uniqueness_name"]=$uniqueness["uniqueness_name"];//判断用户重复字段
		}else{
			$update_arr["uniqueness"]=0;//是否重复
			$update_arr["uniqueness_name"]="";//判断用户重复字段
		}
		//$update_arr["authorization"]=@$_POST["authorization"];//授权用户组 已废弃
		$update_arr["edit_time"]=$time;		
		$admin_color_arr=table_admin_color();
		$update_arr["adm_color"]=$admin_color_arr["name"];//后台随机分的显示色
		$update_arr["adm_color_code"]=$admin_color_arr["code"];//后台随机分的显示色16进度码
		/*-表背景图----------------*/
		$form_background=@$_POST["form_background"];
		if(intval($form_background["check"]) == 1){
			$update_arr["backgroundimage"]=$form_background["backgroundimage"];//背景图
			$update_arr["backgroundposition"]=$form_background["backgroundposition"];//背景图居中(左,中,右)
			$update_arr["background_fix"]=$form_background["background_fix"];//背景图是否固定
			$update_arr["backgroundrepeat"]=$form_background["backgroundrepeat"];//背景图重复
		}else{
			$update_arr["backgroundimage"]="";//背景图
			$update_arr["backgroundposition"]="";//背景图居中(左,中,右)
			$update_arr["background_fix"]="";//背景图是否固定
			$update_arr["backgroundrepeat"]="";//背景图重复
		}
		/*-表头背景图----------------*/
		$form_title_background=@$_POST["form_title_background"];
		if(intval($form_title_background["check"]) == 1){
			$update_arr["titlebackgroundimage"]=$form_title_background["titlebackgroundimage"];//表头背景图
		}else{
			$update_arr["titlebackgroundimage"]="";//表头背景图
		}
		/*-是否短信----------------*/
		$table_sms=@$_POST["table_sms"];
		if(intval($table_sms["check"]) == 1){
			$update_arr["table_sms"]=$table_sms["table_sms"];//是否短信
		}else{
			$update_arr["table_sms"]=str_replace("&sms","&",$table_sms["table_sms"]);//后端替换
		}
		$examined=explode("&sms",$update_arr["table_sms"]);
		$examinedb=implode("", $examined);
		$examined=explode("&",$examinedb);
		$examinedb=implode("", $examined);
		$examined=rtrim($examinedb,"|");
		$examinedb=ltrim($examined,"|");
		$examined=str_replace("|","/",$examinedb);
		$examinedArr["examined"]="|select_option:".$examined."|select_default_value:".(explode("/", $examined)[0]);
		mysql_update($pdo,$pdo->table_pre."field",$examinedArr,"table_id,name",$id.",examined","sql");//PDO,表名,数组,条件,条件值(必须) retype = 返回的类型 default=boolean sql=sql语句 
		//|select_option:审核中/复审中/已通过/未通过|select_default_value:审核中
		//审核中&|复审中&|已通过&sms|未通过&|
		/*-表头LOGO----------------*/
		$form_changelogo=@$_POST["form_changelogo"];
		if(intval($form_changelogo["check"]) == 1){
			$update_arr["titlebackgroundlogo"]=$form_changelogo["titlebackgroundlogo"];//表头LOGO图片
			$update_arr["titleclass"]=$form_changelogo["titleclass"];//需要有的CLASS
			$update_arr["titlestyle"]=$form_changelogo["titlestyle"];//表标题style属性
		}else{
			$update_arr["titlebackgroundlogo"]="";//表头背景图
			$update_arr["titleclass"]="";//表头背景图
			$update_arr["titlestyle"]="";//表头背景图
		}
		$update_arr["backgroundcolor"]=@$_POST["backgroundcolor"];
		$update_arr["titlebackgroundcolor"]=@$_POST["titlebackgroundcolor"];
		$update_arr["titlefontcolor"]=@$_POST["titlefontcolor"];
		$update_arr["mainfontcolor"]=@$_POST["mainfontcolor"];
		$update_arr["mainbackgroundcolor"]=@$_POST["mainbackgroundcolor"];
		$update_arr["desfontcolor"]=@$_POST["desfontcolor"];
		/*提交后是否显示二维码*/
		$update_arr["callback"]=@$_POST["callback"];

		$re_mysql=mysql_update($pdo,$pdo->table_pre."table",$update_arr,"id",$id);
		if($re_mysql){
			exit("1");
		}else{
			exit($pdo->errorCode());
		}
	}else{
		exit("{'fail':'你未获得此表单的管理权'}");
	}


}

//用户提交的字段保存.判断是否新添加还是直接保存
//如果该字段存在,则更新,不存在,则新添加
if($act=="save_field"){
	$fieldName=@$_POST['name'];
	$r=return_table_info($pdo,$pdo->table_pre."field","id,name,table_id,fore_list_show,back_list_show","name,table_id",$fieldName.",".intval($id),false);
	if($r["id"] != ""){
		/*如果数据存在,则为更新*/
		$act="update";
	}else{
		/*不存在,则添加*/
		$act="field_add";
	}
}

//修改表
if($act=="update"){
	check_this_user_levelTo2($level);//用户会员等级
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","name,creater,admin_power","id",$id,false);
	$table_creater=$tableInfo["creater"];
	$table_name=$tableInfo["name"];
	$table_adminId=explode("|", $tableInfo["admin_power"]);
	if($_SESSION["user"]["username"] == $table_creater || in_array($_SESSION["user"]["id"], $table_adminId) || $_SESSION["user"]["group_id"] == 1){
		/*如果存在则更新,不存在则添加*/
		$_POST['name']=@$_POST['name'];
		$_POST['description']=safe_str(@$_POST['description']);
		if($_POST['description']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['name'].self::$language['is_null']."</span>','id':'description'}");}
		if($_POST['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
		if(!is_passwd($_POST['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['only_letters_numbers_underscores']."</span>','id':'name''}");}
		/*$r 已经由 $act='save_field' 传入*/
		$old_name=$r['name'];
		$table_id=$r['table_id'];
		$field_id=$r['id'];
		if($table_id ==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']." field does not exist</span>'}");}
		$fore_list_show=$r['fore_list_show'];
		$back_list_show=$r['back_list_show'];
		/*写入数据库的字段*/
		$update_arr["fore_list_show"]=$r['fore_list_show'];//1
		$update_arr["back_list_show"]=$r['back_list_show'];//2
		
		$args=@$_POST['args'];
		//echo @$_POST['args'];
		$input_type=@$_POST['input_type'];
		$args_array=array();
		$default_value='';
		$length='';
		$field_sql='';
		if($args != ''){
			$args_array=format_attribute($args);
		}
		$config=require("./config.php");
		switch ($input_type) {
			case 'text':
				$type='varchar';
				$default_value=@$args_array['text_default_value'];
				$length=@min(255,max(intval($args_array['text_length']),strlen($default_value)));
				if($length==0){$length=255;}
				break;
			case 'textarea':
				$type='text';
				$default_value=$args_array['textarea_default_value'];
				$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
				break;
			case 'editor':
				$type='text';
				$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
				$default_value=$args_array['editor_default_value'];
				break;
			case 'select':
				$type='varchar';
				$default_value=$args_array['select_default_value'];
				$length=255;
				break;
			case 'radio':
				$type='varchar';
				$default_value=$args_array['radio_default_value'];
				$length=255;
				break;
			case 'checkbox':
				$type='varchar';
				$default_value=$args_array['checkbox_default_value'];
				$length=255;
				break;
			case 'img':
				$type='varchar';
				$length=100;
				$args_array['img_allow_image_type']=$config['upload']['upImgSuffix'];
				if($args!=''){
					$args=ReArgsToString($args_array);
				}
				break;
			case 'imgs':
				$type='text';
				$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
				$args_array['img_allow_image_type']=$config['upload']['upImgSuffix'];
				if($args!=''){
					$args=ReArgsToString($args_array);
				}
				break;
			case 'file':
				$type='varchar';
				$length=100;
				break;
			case 'files':
				$type='text';
				$field_sql="ALTER TABLE  ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".$_POST['name']."` ".$type." NULL ";
				break;
			case 'number':
				if($args_array['number_decimal_places']==0){
					if($args_array['number_max']<2147483647 || $args_array['number_max']==''){$type='int';$length=11;}else{$type='bigint';$length=12;}
				}else{
					$type='decimal';
					$length=max(strlen($args_array['number_max']),10).','.$args_array['number_decimal_places'];
				}
				$default_value=intval($args_array['number_default_value']);
				break;
			case 'time':
				$type='bigint';
				$length=12;
				$default_value=0;
				break;
			case 'map':
				$type='varchar';
				$length=255;
				break;
			case 'area':
				$type='int';
				$length=10;
				$default_value=0;
				break;
			default:
				$type='varchar';
				$input_type='text';
				$default_value='';
				$length=255;

		}
		//if($input_type=='textarea' || $input_type=='editor'){$fore_list_show=0;$back_list_show=0;}
		$update_arr["read_able"]=intval(@$_POST['required']);//3 是否可读
		$update_arr["description"]=@$_POST['description'];//4 字段名(中文)
		$update_arr["sequence"]=@$_POST['sequence'];//5 排序  
		$update_arr["write_able"]=@$_POST['write_able'];//6 是否可写
		$update_arr["type"]=$type;//7 类型
		$update_arr["input_type"]=$input_type;//8 类型
		$update_arr["placeholder"]=@$_POST['placeholder'];//9 提示值
		$update_arr["default_value"]=$default_value;//10 默认值
		$update_arr["length"]=$length;//11 长度
		$update_arr["reg"]=@$_POST['reg'];//12 正则
		$update_arr["unique"]=intval(@$_POST['unique']);//13 独一无二
		$update_arr["search_able"]=intval(@$_POST['search_able']);//14 可搜索
		$update_arr["required"]=intval(@$_POST['required']);//15 必填
		$update_arr["input_args"]=$args;//16 输入框值
		$update_arr["page"]=intval(@$_POST['page']);//17 页码
		$update_arr["data_style"]=intval(@$_POST['data_style']);//18 样式
		if($old_name != @$_POST['name']){
			if(field_exist($pdo,self::$table_pre.$table_name,$_POST['name'])){exit("{'state':'fail','info':'<span class=fail>已经存在了.</span>','id':'name'}");}
		}
		/*---使用升级函数更新数据*/
		$re_mysql=mysql_update($pdo,self::$table_pre."field",$update_arr,"id",$field_id,"lastInsertId"/*lastInsertId为返回类型*/);
		if($re_mysql[0]){
			$insret_id=$re_mysql["lastInsertId"];
			if($field_sql==''){
				$field_sql="ALTER TABLE ".self::$table_pre.$table_name." CHANGE `".$old_name."` `".@$_POST['name']."` ".$type."( ".$length." ) NULL DEFAULT '".$default_value."' ";
			}
			$r=$pdo->exec($field_sql);//file_put_contents('test.sql',$field_sql);
			if($r!==false){
				exit("1");	
			}else{
				exit($pdo->errorCode());
			}
			
		}else{
			exit($re_mysql[0]);
			exit($re_mysql["errorCode"]);
		}
	}else{
		exit("你未获得此表单的管理权");
	}	
}

//编新建字段
if($act=='field_add'){
	check_this_user_levelTo2($level);//用户会员等级
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","name,creater,admin_power","id",$id,false);
	$table_creater=$tableInfo["creater"];
	$table_name=$tableInfo["name"];
	$table_adminId=explode("|", $tableInfo["admin_power"]);
	if($_SESSION["user"]["username"] == $table_creater || in_array($_SESSION["user"]["id"], $table_adminId) || $_SESSION["user"]["group_id"] == 1){
		$config=require("./config.php");
		$_POST['name']=@$_POST['name'];
		$_POST['description']=safe_str(@$_POST['description']);
		if($_POST['description']==''){exit("");}
		if($_POST['name']==''){exit("");}
		if(!is_passwd($_POST['name'])){exit("");}
		$sql="select `name` from ".self::$table_pre."table where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		$table_name=$r['name'];
		if($table_name == ''){exit("表名不存在");}
		
		$args=@$_POST['args'];
		$input_type=@$_POST['input_type'];
		$args_array=array();
		$default_value='';
		$length='';
		$field_sql='';
		if($args!=''){
			$args_array=format_attribute($args);
		}
		switch ($input_type) {
			case 'text':
				$type='varchar';
				$length=255;
				$default_value=@$args_array['text_default_value'];
				$length=@min(255,max(intval($args_array['text_length']),strlen($default_value)));
				if($length==0){$length=255;}
				break;
			case 'textarea':
				$type='text';
				$length=255;
				$default_value=$args_array['textarea_default_value'];
				$field_sql="alter table ".self::$table_pre.$table_name." add `".$_POST['name']."` ".$type." NULL";
				break;
			case 'editor':
				$type='text';
				$length=255;
				$field_sql="alter table ".self::$table_pre.$table_name." add `".$_POST['name']."` ".$type." NULL";
				$default_value=$args_array['editor_default_value'];
				break;
			case 'select':
				$type='varchar';
				$default_value=$args_array['select_default_value'];
				$length=255;
				break;
			case 'radio':
				$type='varchar';
				$default_value=$args_array['radio_default_value'];
				$length=255;
				break;
			case 'checkbox':
				$type='varchar';
				$default_value=$args_array['checkbox_default_value'];
				$length=255;
				break;
			case 'img':
				$type='varchar';
				$length=100;
				//调用服务器预设图片格式
				$args_array['img_allow_image_type']=$config['upload']['upImgSuffix'];
				if($args!=''){
					$args=ReArgsToString($args_array);
				}
				break;
			case 'imgs':
				$type='text';
				$field_sql="alter table  ".self::$table_pre.$table_name." add  `".$_POST['name']."` ".$type." NULL";
				$args_array['img_allow_image_type']=$config['upload']['upImgSuffix'];	
				if($args!=''){
					$args=ReArgsToString($args_array);
				}
				break;
			case 'file':
				$type='varchar';
				$length=100;
				break;
			case 'files':
				$type='text';
				$field_sql="alter table  ".self::$table_pre.$table_name." add  `".$_POST['name']."` ".$type." NULL";
				break;
			case 'number':
				if($args_array['number_decimal_places']==0){
					if($args_array['number_max']<2147483647 || $args_array['number_max']==''){$type='int';$length=11;}else{$type='bigint';$length=12;}
				}else{
					$type='decimal';
					$length=max(strlen($args_array['number_max']),10).','.$args_array['number_decimal_places'];
				}
				$default_value=intval($args_array['number_default_value']);
				break;
			case 'time':
				$type='bigint';
				$length=12;
				$default_value=0;
				break;
			case 'map':
				$type='varchar';
				$length=255;
				break;
			case 'area':
				$type='int';
				$length=10;
				$default_value=0;
				break;
			default:
				$type='varchar';
				$input_type='text';
				$default_value='';
				$length=255;

		}
		//if($input_type=='textarea' || $input_type=='editor'){$fore_list_show=0;$back_list_show=0;}else{$fore_list_show=1;$back_list_show=1;}
		$insert_arr["table_id"]=intval(@$_POST['table_id']);//18表id
		$insert_arr["name"]=@$_POST['name'];//19表名
		$insert_arr["description"]=@$_POST['description'];//4 字段名(中文)
		$insert_arr["sequence"]=intval(@$_POST['sequence']);//5 排序  
		$insert_arr["write_able"]=intval(@$_POST['write_able']);//6 是否可写
		$insert_arr["type"]=$type;//7 类型
		$insert_arr["input_type"]=$input_type;//8 类型
		$insert_arr["placeholder"]=@$_POST['placeholder'];//9 提示值
		$insert_arr["default_value"]=$default_value;//10 默认值
		$insert_arr["length"]=$length;//11 长度
		$insert_arr["reg"]=@$_POST['reg'];//12 正则
		$insert_arr["unique"]=intval(@$_POST['unique']);//13 独一无二
		$insert_arr["search_able"]=intval(@$_POST['search_able']);//14 可搜索
		$insert_arr["required"]=intval(@$_POST['required']);//15 必填
		$insert_arr["input_args"]=$args;//16 输入框值
		$insert_arr["fore_list_show"]=intval(@$_POST['fore_list_show']);//1前端显示
		$insert_arr["back_list_show"]=intval(@$_POST['back_list_show']);//2后端显示
		$insert_arr["page"]=intval(@$_POST['page']);//17 页码
		$update_arr["data_style"]=intval(@$_POST['data_style']);//18 样式
		$insert_arr["read_able"]=intval(@$_POST['read_able']);//3 是否可读
		$re_mysql=table_write($pdo,$pdo->table_pre."field",$insert_arr,"lastInsertId");
		/* 废弃执行语句*/
		if($re_mysql[0]){
			$insret_id=$re_mysql["lastInsertId"];
			if($field_sql==''){
				/*插入一条数据后,需要同步更新表字段,以便用户提交数据*/
				$field_sql="ALTER TABLE ".self::$table_pre.$table_name." ADD `".$insert_arr['name']."` ".$type."( ".$length." ) DEFAULT '".$default_value."' COMMENT '".$insert_arr["description"]."'";
			}
			$pdo->exec($field_sql);
			$r=$pdo->errorCode();
			if((string)$r == "00000"){
				exit("field_id=".$insret_id);
			}else{
				$sql="delete from ".self::$table_pre."field where `id`=".$insret_id;
				$pdo->exec($sql);
				$sql="ALTER TABLE ".self::$table_pre.$table_name." DROP COLUMN `".$insert_arr['name']."`";
				$pdo->exec($sql);
				exit($pdo->errorCode());
			}
		}else{
			exit($re_mysql["errorCode"]);
		}
	}else{
		exit("你未获得此表单的管理权");
	}
}

//保存表时清掉没有的数据
if($act=='clearids'){

	check_this_user_levelTo2($level);//用户会员等级
	$tableInfo=return_table_info($pdo,$pdo->table_pre."table","name,creater,admin_power","id",$id,false);
	$table_creater=$tableInfo["creater"];
	$table_name=$tableInfo["name"];
	$table_adminId=explode("|", $tableInfo["admin_power"]);
	if($_SESSION["user"]["username"] == $table_creater || in_array($_SESSION["user"]["id"], $table_adminId) || $_SESSION["user"]["group_id"] == 1){
		$clearids=@$_POST["clearids"];
		if($clearids == ""){
			exit();
		}
		$clearids=explode("|",$clearids);
		$clearids=array_filter($clearids);
		$testsql="";
		foreach ($clearids as $value) {
			$sql="delete from ".self::$table_pre."field where `id`=".$value." and `table_id`=".$id;
			$testsql.=$sql;
			$pdo->exec($sql);
		}
		exit($testsql);
	}else{
		exit("你未获得此表单的管理权");
	}
}

