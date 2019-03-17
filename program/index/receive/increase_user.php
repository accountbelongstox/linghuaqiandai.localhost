<?php
$act=@$_GET['act'];

if($act=='add'){
	foreach($_POST as $k=>$v){
		if($v=='' && $k!='email' && $k!='chip' && $k!='introducer'){exit("{'state':'fail','info':'<span class=fail>".self::$language['is_null']."</span>','id':'".$k."'}");}	
	}
	$_POST=safe_str($_POST);
	$username=$_POST['username'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$chip=$_POST['chip'];
	$introducer=$_POST['introducer'];
	$user_group=return_username_info($pdo,$_SESSION["user"]["username"],"id");
	if($introducer!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$introducer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_exist']."</span>','id':'introducer'}");}	
	}
	
	if(!is_match(self::$config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'phone'}");}
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$username."' or `phone`='".$username."' or `email`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'username'}");}	
	
	$sql="select `id` from ".$pdo->index_pre."user where `username`='".$phone."' or `phone`='".$phone."' or `email`='".$phone."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'phone'}");}	
	
	if($email!=''){
		if(!is_email($email)){exit("{'state':'fail','info':'<span class=fail>".self::$language['pattern_err']."</span>','id':'email'}");}	
		$sql="select `id` from ".$pdo->index_pre."user where `username`='".$email."' or `phone`='".$email."' or `email`='".$email."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'email'}");}	
	}
	if($chip!=''){
		$sql="select `id` from ".$pdo->index_pre."user where `chip`='".$chip."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['already_exists']."</span>','id':'chip'}");}	
	}
	$group=self::$config['reg_set']['default_group_id'];
	
	$sql="insert into ".$pdo->index_pre."user (`username`,`phone`,`email`,`password`,`transaction_password`,`chip`,`reg_time`,`state`,`group`,`introducer`) values ('".$username."','".$phone."','".$email."','".md5($_POST['password'])."','".md5($_POST['transaction_password'])."','".$chip."','".time()."','1','".$group."','".$introducer."')";
	if($pdo->exec($sql)){
		$userid=$pdo->lastInsertId();/*------------新添加用户被更改为团队成员-----------*/
		$arr["user_group"]="|".$userid."|".$_SESSION["user"]["id"]."|";
		mysql_update($pdo,$pdo->index_pre."user",$arr,"id",$userid);
		//format_value($arr_val,$str,$token="|");
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}
