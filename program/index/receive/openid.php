<?php
$act=@$_GET['act'];
if($act=='update'){
	if($_POST['authcode']==''){
		exit ("{'state':'fail','info':'".self::$language['authcode'].self::$language['is_null']."'}");			
	}
	$min_time=time()-600;
	$sql="select `openid`,`time`,`wid` from ".$pdo->sys_pre."weixin_authcode where `code`='".safe_str($_POST['authcode'],1,0)."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['openid']=='')exit ("{'state':'fail','info':'".self::$language['authcode_err']."'}");
	if($r['time']<$min_time)exit ("{'state':'fail','info':'".self::$language['authcode_expire']."'}");
	if($r['wid']!=self::$config['web']['wid'])exit ("{'state':'fail','info':'".self::$language['weixin_is_not_web_master']."'}");
	$openid=$r['openid'];
	//$openid='oldEruMFw09sjJAJEIT0r2w6Uomc';
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".$openid."' and `id`!='".$_SESSION['user']['id']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=''){exit("{'state':'fail','info':'".self::$language['openid_name'].self::$language['exist']."'}");}
	
	$sql="select `openid` from ".$pdo->index_pre."user where `id`=".$_SESSION['user']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['openid']!=''){
		if($r['openid']!=$openid){exit("{'state':'fail','info':'".self::$language['need_old_username']."'}");}
		$sql="update ".$pdo->index_pre."user set `openid`=''  where `id`=".$_SESSION['user']['id'];
		$oauth_sql="delete from ".$pdo->index_pre."oauth where `user_id`='".$_SESSION['user']['id']."' and `open_id`='wx:".$openid."' limit 1";
	}else{
		$sql="update ".$pdo->index_pre."user set `openid`='".$openid."'  where `id`=".$_SESSION['user']['id'];
		$oauth_sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$_SESSION['user']['id']."','wx:".$openid."','".time()."')";
	}
	if($pdo->exec($sql)){
		$pdo->exec($oauth_sql);
		exit("{'state':'success','info':'".self::$language['success']."'}");
	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
	}
	
	
}