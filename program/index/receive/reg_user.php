<?php
$act=@$_GET['act'];
if($act=='get_verification_code'){
	//if($_SESSION['form_token']!=$_POST['token']){exit("{'state':'fail','info':'".self::$language['fail'].$_SESSION['form_token'].'!='.$_POST['token']."'}"); }
	$_SESSION['verification_code']=get_verification_code(6);
	if(self::$config['reg_set']['check']!='weixin'){
		if(self::$config['reg_set']['phone']==false && self::$config['reg_set']['email']==false){self::$config['reg_set']['check']='image';}
		if(self::$config['reg_set']['check']=='email' && self::$config['reg_set']['email']==false){self::$config['reg_set']['check']='image';}
		if(self::$config['reg_set']['check']=='phone' && self::$config['reg_set']['phone']==false){self::$config['reg_set']['check']='image';}
	}
	switch(self::$config['reg_set']['check']){
		case 'image':
			exit("{'state':'success','info':'image'}");
			break;
		case 'weixin':
			$sql="select `url`,`name` from ".$pdo->sys_pre."weixin_diy_qr where `wid`='".self::$config['web']['wid']."' and `key`='get_reg_authcode' limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['url']==''){
				exit("{'state':'success','info':'image'}");
				break;
			}
			$html='<div>'.$r['name'].'</div><img class="qr_img" src="/plugin/qrcode/index.php?text='.$r['url'].'&logo=1&logo_path=../../program/weixin/diy_qr_icon/'.self::$config['web']['wid'].'.png">';
			if($_COOKIE['cloud_device']=='phone'){
				$html='<div>'.$r['name'].'<br /><a href=# class=weixin_scan_img_demo>'.self::$language['view'].self::$language['weixin_scan_img_demo'].'</a></div><img class="qr_img" src="/plugin/qrcode/index.php?text='.$r['url'].'&logo=1&logo_path=../../program/weixin/diy_qr_icon/'.self::$config['web']['wid'].'.png">';
			}
			exit("{'state':'success','info':'weixin','html':'".$html."'}");
			break;
		case 'phone':
			$phone=@$_POST['phone'];
			if(!is_match(self::$config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
			
			if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
			//是否被占用
			$sql="select `id` from ".$pdo->index_pre."user where `phone`='".$phone."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");}		
			if(sms(self::$config,self::$language,$pdo,'cloud',$phone,$_SESSION['verification_code'])){
				$_SESSION['reg_phone']=$phone;
				$success=str_replace('{device}',self::$language['phone'],self::$language['verification_code_sent_notice']);
				exit("{'state':'success','info':'".$success."'}");

			}else{
				exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
			}
			break;
		case 'email':
			$email=@$_POST['email'];
			if(!is_email($email)){exit("{'state':'fail','info':'".self::$language['email'].self::$language['pattern_err']."','key':'email'}");}
			if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
			//是否被占用
			$sql="select `id` from ".$pdo->index_pre."user where `email`='".$email."'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['email'].self::$language['exist']."','key':'email'}");}
			

			$title=self::$config['web']['name']."-".self::$language['authcode'];
			$content=self::$config['web']['name']."-".self::$language['authcode'].":".$_SESSION['verification_code'];		
			if(email(self::$config,self::$language,$pdo,'cloud',$email,$title,$content)){
				$_SESSION['reg_email']=$email;
				$success=str_replace('{device}',self::$language['email'],self::$language['verification_code_sent_notice']);
				exit("{'state':'success','info':'".$success."'}");
			}else{
				exit("{'state':'fail','info':'".self::$language['fail']."'}"); 
			}
			
			break;
		
	}
	
	exit();
	
}
//============================================================================================================================================执行注册开始
$_GET['group_id']=intval(@$_GET['group_id']);
if(@$act=='check_group'){
	$sql="select `reg_able`,`require_check` from ".$pdo->index_pre."group where `id`='".$_GET['group_id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$require_check=($r['require_check']==1)?self::$language['require_check']:'';
	if($r['reg_able']==1){
		$info="{'state':'ok','info':'<span class=success>".self::$language['reg_able'].",$require_check </span>'}";
	}else{
		$info="{'state':'no','info':'<span class=fail>".self::$language['reg_unable']."</span>'}";
	}	
	exit($info);
}


$openid='';
if(self::$config['reg_set']['check']!='weixin'){
	if(strtolower($_GET['authcode'])!=strtolower(@$_SESSION["verification_code"])){
		exit ("{'errType':'authcode','errInfo':'".self::$language['authcode_err']."'}");			
	}
}else{
	$min_time=time()-600;
	$sql="select `openid`,`time`,`wid` from ".$pdo->sys_pre."weixin_authcode where `code`='".safe_str($_GET['authcode'],1,0)."' order by `id` desc limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['openid']=='')exit ("{'errType':'authcode','errInfo':'".self::$language['authcode_err']."'}");
	if($r['time']<$min_time)exit ("{'errType':'authcode','errInfo':'".self::$language['authcode_expire']."'}");
	if($r['wid']!=self::$config['web']['wid'])exit ("{'errType':'authcode','errInfo':'".self::$language['weixin_is_not_web_master']."'}");
	$openid=$r['openid'];
	
	$sql="select `username` from ".$pdo->index_pre."user where `openid`='".$openid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=''){exit("{'errType':'authcode','errInfo':'".self::$language['openid_name'].self::$language['exist']."'}");}
	
}




if(self::$config['reg_set']['email']){
	$_GET['email']=safe_str(@$_GET['email'],1,0);
	$sql="select count(id) as c from ".$pdo->index_pre."user where `username`='".$_GET['email']."' or `email`='".$_GET['email']."'";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);
	if($v['c']!=0){exit("{'errType':'email','errInfo':'".self::$language['email'].self::$language['exist']."'}");}
	if(self::$config['reg_set']['check']=='email'){
		if($_SESSION['reg_email']!=$_GET['email']){exit("{'errType':'email','errInfo':'".self::$language['email'].'!='.$_SESSION['reg_email']."'}");}
	}
	
}else{$_GET['email']='';}


if(self::$config['reg_set']['phone']){
	$_GET['phone']=safe_str(@$_GET['phone'],1,0);
	if(!is_match(self::$config['other']['reg_phone'],$_GET['phone'])){exit("{'errType':'phone','errInfo':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>'}");}
	$sql="select count(id) as c from ".$pdo->index_pre."user where `phone`='".$_GET['phone']."'";
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);
	if($v['c']!=0){exit("{'errType':'phone','errInfo':'".self::$language['phone'].self::$language['exist']."'}");}
	if(self::$config['reg_set']['check']=='phone'){if($_SESSION['reg_phone']!=$_GET['phone']){exit("{'errType':'phone','errInfo':'".self::$language['phone'].'!='.$_SESSION['reg_phone']."'}");}
}else{$_GET['phone']='';}

}

$_GET['phone']=safe_str(@$_GET['phone']);
$_GET['username']=safe_str(@$_GET['username'],1,0);

$_GET['group']=intval(@$_GET['group']);

$sql="select count(id) as c from ".$pdo->index_pre."user where `username`='".$_GET['username']."' or `email`='".$_GET['username']."'  or `phone`='".$_GET['username']."'";
$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);
if($v['c']!=0 || strtolower($_GET['username'])=='cloud'){exit("{'errType':'username','errInfo':'".self::$language['username'].self::$language['exist']."'}");}
$_GET['password']=md5(@$_GET['password']);

$sql="select `reg_able`,`require_check` from ".$pdo->index_pre."group where `id`='".$_GET['group']."' limit 0,1";
//exit($sql);
$stmt=$pdo->query($sql,2);
$v=$stmt->fetch(2);
if($v['reg_able']!=1){exit("{'errType':'group','errInfo':'".self::$language['no_registration']."'}");}
$state=($v['require_check']==1)?0:1;
$time=time();
$ip=get_ip();
$manager=$this->get_manager($pdo,$_GET['group']);;
//echo $manager;
$sql="insert into ".$pdo->index_pre."user (`nickname`,`email`,`username`,`password`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`phone`,`openid`) values ('".$_GET['username']."','".$_GET['email']."','".$_GET['username']."','".$_GET['password']."','$time','$ip','".$_GET['group']."',$state,$manager,'".$_GET['phone']."','".$openid."')";
if(isset($_SESSION['share'])){
	$sql="select `username`,`group` from ".$pdo->index_pre."user where `id`=".$_SESSION['share'];
	$r=$pdo->query($sql,2)->fetch(2);
	$share_username=$r['username'];
	
	//=======================================================================================如是注册推荐是店主，则添加到店内会员
	if(is_file('./program/mall/config.php')){
		$sql="select `id` from ".$pdo->sys_pre."mall_shop where `username`='".$r['username']."' and `state`=2 limit 0,1";
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['id']!=''){
			$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer where `shop_id`=".$r2['id']." and `username`='".$_GET['username']."' limit 0,1";
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['id']==''){
				$sql="select `id` from ".$pdo->sys_pre."mall_shop_buyer_group where `shop_id`=".$r2['id']." order by `discount` desc limit 0,1";
				$r4=$pdo->query($sql,2)->fetch(2);
				$sql="insert into ".$pdo->sys_pre."mall_shop_buyer (`username`,`time`,`shop_id`,`group_id`) value ('".$_GET['username']."','".time()."','".$r2['id']."','".$r4['id']."')";
				$pdo->exec($sql);	
			}
		}
	}
	
	$sql="insert into ".$pdo->index_pre."user (`nickname`,`email`,`username`,`password`,`reg_time`,`reg_ip`,`group`,`state`,`manager`,`phone`,`introducer`,`openid`) values ('".$_GET['username']."','".$_GET['email']."','".$_GET['username']."','".$_GET['password']."','$time','$ip','".$_GET['group']."',$state,$manager,'".$_GET['phone']."','".$r['username']."','".$openid."')";
}

//file_put_contents('t.txt',$sql);
if($pdo->exec($sql)){
	$user_id=$pdo->lastInsertId();
	if(self::$config['reg_set']['check']=='weixin'){
		$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','wx:".$openid."','".$time."')";
		$pdo->exec($sql);
	}
	$exit_str=array("money","withdraw","credits","cumulative_credits","nickname","email","username","password","reg_time","reg_ip","group","state","manager","phone","introducer","openid");/*禁止注册字段*/

	//将余下的字段插入表
	if($user_id!= ""){
		foreach ($_GET as $getK => $r_uvalue) {
			if(!in_array($getK,$exit_str)){
				$sql="update ".$pdo->index_pre."user set `".$getK."`='".$_GET[$getK]."' where `id`=".$user_id;
				$pdo->exec($sql);
			}
		}
		$user_group_="|".$user_id."|".
		$sql="update ".$pdo->index_pre."user set `user_group`='".$user_group_."' where `id`=".$user_id;
		$pdo->exec($sql);
	}

	$info=self::$language['success'];
	$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
	$_SESSION['verification_code']='';
	$_SESSION['form_token']='';
	if($state==0){$info=self::$language['reg_user'].$info.",".self::$language['please_wait_check'];}
	
	if($openid !=''){
		$sql="delete from ".$pdo->sys_pre."weixin_authcode where `openid`='".$openid."'";
		$pdo->exec($sql);	
	}
	
	if(isset($_SESSION['share'])){
		self::$config['credits_set']['introduce']=intval(self::$config['credits_set']['introduce']);
		$sql="select `username` from ".$pdo->index_pre."user where `id`=".$_SESSION['share'];
		$r=$pdo->query($sql,2)->fetch(2);
		$username=$r['username'];
		$reason=self::$language['new_user_introduce'].$_GET['username'];
		operation_credits($pdo,self::$config,self::$language,$username,self::$config['credits_set']['introduce'],$reason,'introduce');	
	}
	
	if(intval(@$_GET['oauth'])==1 && @$_SESSION['oauth']['open_id']!=''){
		
		oauth_bind($pdo,$user_id);
		oauth_login($pdo,self::$language,self::$config);
		
		/*
		if(oauth_bind($pdo,$v['userid'],$user_id)){
			$sql="update ".$pdo->index_pre."user set `reg_oauth`=1 where `id`=".$user_id;
			$pdo->exec($sql);
		}
		*/	
	}

	/*最后判断用户是否被邀请注册*/
	$invite=$_GET['username'];
	$sql="select `id`,`invite_admin`,`invite_edit`,`invite_read`,`description`,`creater` from ".$pdo->table_pre."table where `invite_admin` like '%,".$invite."%' or `invite_edit` like '%,".$invite."%' or `invite_read` like '%,".$invite."%'";
	$r=$pdo->query($sql,2);
	foreach ($r as $v) {
		$type1="read_power";
		$type2="invite_read";
		if(strstr($v[$type2],$invite)){/*被邀请为数据查看*/
			$_power=return_table_info($pdo,$pdo->table_pre."table",$type1.",".$type2.",creater","id",$v['id'],false);
			$arr=null;
			$arr[$type1]=$_power[$type1].$user_id."|";
			$_invite=explode($invite, $_power[$type2]);
			$arr[$type2]=implode("", $_invite);
			mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$v['id']);
		}
		$type1="edit_power";
		$type2="invite_edit";
		if(strstr($v[$type2],$invite)){/*被邀请为数据维护*/
			$_power=return_table_info($pdo,$pdo->table_pre."table",$type1.",".$type2.",creater","id",$v['id'],false);
			$arr=null;
			$arr[$type1]=$_power[$type1].$user_id."|";
			$_invite=explode($invite, $_power[$type2]);
			$arr[$type2]=implode("", $_invite);
			mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$v['id']);
		}
		$type1="admin_power";
		$type2="invite_admin";
		if(strstr($v[$type2],$invite)){/*被邀请为管理员*/
			$_power=return_table_info($pdo,$pdo->table_pre."table",$type1.",".$type2.",creater","id",$v['id'],false);
			$arr=null;
			$arr[$type1]=$_power[$type1].$user_id."|";
			$_invite=explode($invite, $_power[$type2]);
			$arr[$type2]=implode("", $_invite);
			mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$v['id']);
		}
		/*将用户加入团队*/
		$user_group=return_username_info($pdo,$_power["creater"],"id");
		$user_group_=return_username_info($pdo,$_GET['username'],"user_group");
		$user_arr["user_group"] = $user_group_.$user_group."|";
		mysql_update($pdo,$pdo->index_pre."user",$user_arr,"id",$user_id);
	}

	
	exit("{'errType':'exe_success','errInfo':'".$info."'}");
}else{
	exit("{'errType':'exe_fail','errInfo':'".self::$language['fail']."'}");	
}