<?php
$act=$_GET['act'];
if($act=='inquiries_pay_state'){
	$id=intval(@$_GET['id']);
	$sql="select * from ".$pdo->index_pre."recharge where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	$v=inquiries_pay_state(self::$config,$r['type'],$r['in_id']);
	if($v){
		update_recharge($pdo,self::$config,self::$language,$r['in_id']);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','url':'".$r['return_url']."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}	
}


if($act=='share'){
	$browser_md5=md5($_SERVER['HTTP_USER_AGENT']);
	self::$config['credits_set']['share']=intval(self::$config['credits_set']['share']);
	$temp=explode('#',$_POST['url']);
	if($_SERVER["HTTP_REFERER"]!=$temp[0]){echo $_SERVER["HTTP_REFERER"].'!='.$_POST['url'].','; exit('HTTP_REFERER');}
	if($_POST['url']=='' || $_POST['title']=='' ||  $_POST['share']==''){exit('is null');}
	$share=intval($_POST['share']);
	if($share==0){exit('user err');}
	$sql="select `id`,`username` from ".$pdo->index_pre."user where `id`=".$share;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){exit('user err');}
	$username=$r['username'];
	$_SESSION['share']=$share;
	$url=explode('index.php?cloud=',$_POST['url']);
	if(isset($url[1])){
		$url=explode('&share=',$url[1]);
		$url=safe_str($url[0]);
	}else{
		$url=explode('share=',$_POST['url']);
		if(!isset($url[1])){exit('url is err');}
		$url='';
	}
	
	
	$title=mb_substr(safe_str($_POST['title']),0,30,'utf-8');
	$time=time();
	$visit_is_ip=false;
	if(isset($_SESSION['user']['username'])){$visit=$_SESSION['user']['username'];}else{$visit=get_ip();$visit_is_ip=true;}
	$time_start=$time-86400;
	if($visit_is_ip){
		$sql="select count(id) as c from ".$pdo->index_pre."share_visit where `visit`='".$visit."' and `browser_md5`='".$browser_md5."' and `time`>".$time_start." limit 0,3";
	}else{
		if($share==$_SESSION['user']['id']){exit('is your self');}
		$sql="select count(id) as c from ".$pdo->index_pre."share_visit where `visit`='".$visit."' and `time`>".$time_start." limit 0,3";
	}
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']==3){exit('share click >3');}
			
	
	$sql="select `id` from ".$pdo->index_pre."share where `user_id`='".$share."' and `url`='".$url."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$new=false;
	if($r['id']==''){
		$sql="insert into ".$pdo->index_pre."share (`user_id`,`url`,`title`,`time`,`contribution`,`username`) values ('".$share."','".$url."','".$title."','".$time."','".self::$config['credits_set']['share']."','".$username."')";
		if($pdo->exec($sql)){$r['id']=$pdo->lastInsertId();$new=true;}
		if($r['id']==''){exit('share_id err');}
	}else{
		$sql="update ".$pdo->index_pre."share set `contribution`=`contribution`+".self::$config['credits_set']['share'].",`time`=".$time." where `id`=".$r['id'];
		$pdo->exec($sql);
	}
	$_SESSION['share_url_id']=$r['id'];

	$sql="select `id` from ".$pdo->index_pre."share_visit where `share_id`=".$r['id']." and `visit`='".$visit."' limit 0,1";
	$temp=$pdo->query($sql,2)->fetch(2);
	if($temp['id']!=''){
		if($new){
			$sql="delete from ".$pdo->index_pre."share where `id`=".$r['id'];
			$pdo->exec($sql);
		}else{
			$sql="update ".$pdo->index_pre."share set `contribution`=`contribution`-".self::$config['credits_set']['share'].",`time`=".$time." where `id`=".$r['id'];
			$pdo->exec($sql);			
		}
		exit('is old user');
	}
	
	$sql="insert into ".$pdo->index_pre."share_visit (`share_id`,`visit`,`time`,`browser_md5`,`user_id`) values ('".$r['id']."','".$visit."','".$time."','".$browser_md5."','".$share."')";
	$pdo->exec($sql);
	$reason=str_replace('{page_title}','<a href=/index.php?cloud='.$url.'>'.$title.'</a>',self::$language['share_reson']);
	operation_credits($pdo,self::$config,self::$language,$username,self::$config['credits_set']['share'],$reason,'share');	
}
