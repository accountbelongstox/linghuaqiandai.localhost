<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);
if($act=='del'){
	$sql="select `wid`,`qr_code`,`username` from ".self::$table_pre."account where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['username']!=$_SESSION['user']['username']){exit("{'state':'fail','info':'is not your account'}");}
	$sql="delete from ".self::$table_pre."account where `id`='$id'";
	if($pdo->exec($sql)){
		self::del_account_receive_data($pdo,self::$table_pre,$r['wid']);
		@safe_unlink("./upload/weixin/qr_code/".$r['qr_code']);
		exit("{'state':'success','info':'".self::$language['success']."'}");
	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}");
	}
}
if($act =="account_add"){
	function add_default_auto_answer($language,$pdo,$table_pre,$wid){
		$time=time();
		$key=$language['while'].':'.$language['receive_subscribe'].'|MsgType:event|Event:subscribe';
		$v=$language['while'].':'.$language['receive_subscribe'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);
			
		$key=$language['while'].':'.$language['receive_unsubscribe'].'|MsgType:event|Event:unsubscribe';
		$v=$language['while'].':'.$language['receive_unsubscribe'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	
		
		$key=$language['while'].':'.$language['receive_location'].'|MsgType:location';
		$v=$language['while'].':'.$language['receive_location'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	
		
		$key=$language['while'].':'.$language['receive_image'].'|MsgType:image';
		$v=$language['while'].':'.$language['receive_image'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	

		$key=$language['while'].':'.$language['receive_voice'].'|MsgType:voice';
		$v=$language['while'].':'.$language['receive_voice'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	

		$key=$language['while'].':'.$language['receive_video'].'|MsgType:video';
		$v=$language['while'].':'.$language['receive_video'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	

		$key=$language['while'].':'.$language['receive_link'].'|MsgType:link';
		$v=$language['while'].':'.$language['receive_link'];
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	
		
		$key=$language['no_keyword_and_no_search_then_answer'].':no_keyword_and_no_search_then_answer';
		$v='';
		$sql="insert into ".$table_pre."auto_answer (`wid`,`key`,`input_type`,`output_type`,`time`,`text`,`author`) values ('".$wid."','".$key."','text','text','".$time."','".$v."','cloud')";
		$pdo->exec($sql);	

	}
	$time=time();
	$null_able=array('area','keyword','qr_code_file','AppId','AppSecret');
	foreach($_POST as $key=>$v){
		if($v=='' && !in_array($key,$null_able)){
			$r="{'state':'fail','info':'".self::$language['is_null']."','id':'".$key."'}";
			exit($r);
		}
	}
	$_POST=safe_str($_POST);

	$sql="select count(id) as c from ".self::$table_pre."account where `account`='".$_POST['account']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'".self::$language['exist']."','id':'account'}");}

	$sql="select count(id) as c from ".self::$table_pre."account where `wid`='".$_POST['wid']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'".self::$language['exist']."','id':'wid'}");}

	$_POST['qr_code']="http://open.weixin.qq.com/qr/code/?username=".$_POST["account"];

	if($_POST['AppId']!='' && $_POST['AppSecret']!=''){
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$_POST['AppId']."&secret=".$_POST['AppSecret'];
		$content = file_get_contents($url);
		$info = json_decode($content,1);	
		if(!isset($info['access_token'])){exit("{'state':'fail','info':'".self::$language['AppId'].self::$language['or'].self::$language['AppSecret'].self::$language['err']." '}");}	
	}


	$sql="insert into ".self::$table_pre."account (`qr_code`,`username`,`name`,`wid`,`account`,`area`,`keyword`,`AppId`,`AppSecret`,`token`,`time`) values ('".$_POST['qr_code']."','".$_SESSION['user']['username']."','".$_POST['name']."','".$_POST['wid']."','".$_POST['account']."','".intval($_POST['area'])."','".$_POST['keyword']."','".$_POST['AppId']."','".$_POST['AppSecret']."','".$_POST['token']."','".$time."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		add_default_auto_answer(self::$language,$pdo,self::$table_pre,$_POST['wid']);
		
		exit("{'state':'success','info':'".self::$language['success']."'}");
	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}");
	}
}
if($act =="get_weixin_info"){
	$re=self::get_weixin_info($pdo,self::$table_pre,$_SESSION["user"]["username"]);
	exit($re);
}
