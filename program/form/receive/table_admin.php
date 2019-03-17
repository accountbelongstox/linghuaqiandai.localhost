<?php

$act=@$_GET['act'];
if($act=='pngcode'){
	auto_PngCode($_GET['id'],$_SERVER);
	exit('ok');
}
$table_id=intval(@$_GET['table_id']);

if($act=="setAccEn"){
	$nameid=intval(@$_GET['nameid']);
	$sql="update ".$pdo->index_pre."user set `is_enterprise`='1' where `id`=".$nameid;
	if($pdo->exec($sql)){
		exit('ok');
	}else{
		exit('no');
	};
}
//移入文件夹
if($act=="move_folder"){
	$folder_id=intval(@$_GET['folder_id']);
	//$r=return_table_info($pdo,$pdo->table_pre."table","add_power","id",$table_id,/*$all=*/false);
	//$arr["add_power"]=insert_arr($r,$folder_id);
	//$arr["parent"]=$table_id;
	//$r=mysql_update($pdo,$pdo->index_pre."user",$arr,"id",$table_id,"default");
	$sequenceArr[$folder_id]=$table_id;
	//exit(var_dump($sequenceArr));
	$_SESSION["user"]["folder_sequence"]=self::write_folder_user($pdo,$_SESSION,$sequenceArr);
	exit($_SESSION["user"]["folder_sequence"]);
}

//创建文件夹
if($act=="create_folder"){
	$time=time();
	$arr["description"]=@$_GET['description'];//名字
	$arr["backgroundcolor"]=@$_GET['backgroundcolor'];//背景色
	$arr["backgroundimage"]=@$_GET['backgroundimage'];//背景图标
	$arr["create_time"]=$time;
	$arr["edit_time"]=$time;
	$arr["name"]=auto_give_Diyfolder_name($pdo,$_SESSION['user']['id']);
	$arr["creater"]=$_SESSION["user"]["username"];
	$arr["remark"]="文件夹";
	$arr["read_state"]=1;
	$arr["table_join"]="__folder__";
	//exit($arr["name"]);
	$lastInsertId=mysql_write($pdo,self::$table_pre."table",$arr,"lastInsertId");
	//创建个人文件夹排序
	$sequenceArr[$lastInsertId[1]]=0;
	//exit(var_dump($sequenceArr));
	$_SESSION["user"]["folder_sequence"]=self::write_folder_user($pdo,$_SESSION,$sequenceArr);
	exit($_SESSION["user"]["folder_sequence"]);
}
//排序 置顶
if($act=="sequence"){
	if(empty($_GET["val"])){
		$arr["sequence"]=1;
	}else{
		$arr["sequence"] = intval(@$_GET["val"]);
	}
	$re=mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$table_id,"default");
	exit($re);
	
}

/*首页置顶*/
if($act == 'index_show'){
	if(empty($_GET["val"])){
		$arr["index_show"] = 2;
	}else{
		$arr["index_show"] = intval(@$_GET["val"]);
	}
	$re=mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$table_id,"default");
	exit($re);
}


if($act=='copy_table'){

	if($table_id==0){exit('table_id err');}
    $description=@$_GET['newtablename_description'];
    if($description==""){exit('description err');}

	/*开始复制form_table表*/
    $sql="select * from ".self::$table_pre."table where `id`=".$table_id;
    $r=$pdo->query($sql,2)->fetch(2);
    $oldtablename=$r["name"];
    /*取得表名*/
	$diy_table_name=auto_give_Diytable_name($pdo,$_SESSION['user']['id']);

	/*开始复制表并设置ID为自增*/
    //$sql="CREATE TABLE ".$diy_table_name." LIKE ".$oldtablename;
    $sql="CREATE TABLE ".self::$table_pre.$diy_table_name." SELECT * FROM ".self::$table_pre.$oldtablename." WHERE 1=2";

    $pdo->exec($sql);
    $sql="ALTER TABLE ".self::$table_pre.$diy_table_name." ADD PRIMARY KEY(`id`)";
    $pdo->exec($sql);
    $sql="ALTER TABLE ".self::$table_pre.$diy_table_name." DROP PRIMARY KEY, ADD PRIMARY KEY(`id`)";
    $pdo->exec($sql);
    $sql="ALTER TABLE ".self::$table_pre.$diy_table_name." CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT";
    $pdo->exec($sql);


    $copy_table_arr=array();
	$priv_copy_arr=array('pv_statistics','ip_statistics','today_statistics','msg_count','callback');
	$no_copy_arr=array('id','name','description','tmp');
	$time_copy_arr=array('create_time','edit_time');
	foreach($r as $key => $value){
		if(in_array($key,$priv_copy_arr)){
			$value=0;
		}
		if(in_array($key,$time_copy_arr)){
			$value=time();
		}
		if(!in_array($key,$no_copy_arr)){
			$copy_table_arr[$key]=$value;
		}
	}
	$copy_table_arr["name"]=$diy_table_name;
	$copy_table_arr["description"]=$description;

	$re=mysql_write($pdo,self::$table_pre."table",$copy_table_arr,"lastInsertId");
	//$re=mysql_write($pdo,self::$table_pre."table",$copy_table_arr,"sql");
	/*开始复制form_feild表*/
    $newtable_id=$re["lastInsertId"];
    $sql="select * from ".self::$table_pre."field where `table_id`=".$table_id;
    $r=$pdo->query($sql,2);
    foreach ($r as $v) {
    	$copy_field_arr=array();
    	foreach ($v as $key => $value) {
			if($key != "id" && $key != "table_id"){
				$copy_field_arr[$key]=$value;
			}
    	}
		$copy_field_arr["table_id"]=$newtable_id;
    	mysql_write($pdo,self::$table_pre."field",$copy_field_arr);
    }



    exit('success');
/*----------------------------------*/
    
    exit('fail');
}

if($act=='getTable_joins'){
	$table_name=@$_GET['name'];
    $sql="select `input_args` from ".self::$table_pre."field where `table_id`=".$table_id." and `name`='".$table_name."'";
    $r=$pdo->query($sql,2)->fetch(2);
	exit($r['input_args']);
}

if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit('id err');}
	$_GET['name']=@$_GET['name'];
	$_GET['description']=@$_GET['description'];
	$authorization=intval(@$_GET['authorization']);
	$table_join_detail=@$_GET['table_join_detail'];
	$table_join=@$_GET['table_join'];
	$remark=@$_GET['remark'];
	if($_GET['description']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['name'].self::$language['is_null']."</span>','id':'description'}");}
	if($_GET['name']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['is_null']."</span>'}");}
	if(!is_passwd($_GET['name'])){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['only_letters_numbers_underscores']."</span>','id':'name''}");}
	
	if($_GET['inform_user']!=''){
		$_GET['inform_user']=safe_str($_GET['inform_user']);
		if(get_user_id($pdo,$_GET['inform_user'])==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username_err']."</span>'}");}	
	}
	
	$sql="select `name` from ".self::$table_pre."table where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']!=$_GET['name']){
		if(field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){exit("{'state':'fail','info':'<span class=fail>".self::$language['table_name'].self::$language['already_exists']."</span>','id':'name'}");}
		$sql="RENAME TABLE  `".self::$table_pre.$r['name']."` TO  `".self::$table_pre.$_GET['name']."`";
		$pdo->exec($sql);
		if(!field_exist($pdo,$pdo->sys_pre.'form_'.$_GET['name'],'id')){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	}
	
	
	$sql = "update ".self::$table_pre."table set `remark`='".$remark."',`table_join`='".$table_join."',`table_join_detail`='".$table_join_detail."',`authorization`=".$authorization.",`publish_condition`='".$_GET['publish_condition']."',`name`='".$_GET['name']."',`description`='".$_GET['description']."',`write_state`='".intval($_GET['write_state'])."',`read_state`='".intval($_GET['read_state'])."',`default_publish`='".intval($_GET['default_publish'])."',`authcode`='".intval($_GET['authcode'])."',`sms_inform`='".intval($_GET['sms_inform'])."',`email_inform`='".intval($_GET['email_inform'])."',`inform_user`='".$_GET['inform_user']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}
}
if($act=='get_folder'){
	$r=return_table_info($pdo,$pdo->table_pre."table","id,parent,sequence,description","creater,table_join",$_SESSION["user"]["username"].",__folder__",/*$all=*/true);
	$a=array();
	foreach ($r as $k => $v) {
		$a[$k]=$v;
	}
	$r=json_encode($a);
	exit($r);
}

if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	/*删除文件夹*/
	if(isset($_GET["type"])){
		$_GET["type"]=@$_GET["type"];
		if($_GET["type"]=="folder-admin"){
			$r=self::get_forder_count($pdo,$_SESSION,$_GET['id']);
			if($r > 0){
				exit("当前文件夹下包含表单,不能删除.");
			}
			$sql="delete from ".self::$table_pre."table where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			exit("删除成功");
		}
	}
	//系统保留表拒绝删除
	if($_GET['id']==0){exit('id err');}
	$sql="select `name` from ".self::$table_pre."table where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['name']==''){exit("{'state':'fail','info':'<span class=fail>table is not exist</span>'}");}
	$name=$r['name'];
	$sql="select count(id) as c from ".self::$table_pre.$r['name']."";
	$r=$pdo->query($sql,2)->fetch(2);
	//if($r['c'] > 0){exit("{'state':'fail','info':'<span class=fail>".self::$language['refuse_del_table']."</span>'}");}
	$sql="DROP TABLE `".self::$table_pre.$name."`";
	$pdo->exec($sql);
	if(field_exist($pdo,self::$table_pre.$name,'id')){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}else{
		$sql="delete from ".self::$table_pre."table where `id`='".$_GET['id']."'";
		$pdo->exec($sql);
		$sql="delete from ".self::$table_pre."field where `table_id`='".$_GET['id']."'";
		$pdo->exec($sql);
		exit("删除成功");
	}
	
}


if($act=='change_table'){
	$is_admin=check_is_admin_user($pdo,$_SESSION);//检查是否管理员
	if($is_admin != 1){
		exit("你不是管理员");
	}
	$_GET['id']=intval(@$_GET['id']);
	$arr['description']=@$_GET['description'];
	$arr['remark']=@$_GET['remark'];
	$new_table_name=change_table_usename($pdo,$_GET['id'],$_GET['creater']);
	if($new_table_name == false){
		exit("修改不成功"); 
	}
	if(mysql_update($pdo,self::$table_pre."table",$arr,"id",$_GET['id'])){
		exit("1");
	}else{
		exit("修改不成功");
	}
}