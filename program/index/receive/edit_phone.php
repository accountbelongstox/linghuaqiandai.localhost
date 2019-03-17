<?php
$act=@$_GET['act'];
if($act=='get_verification_code'){
	$_SESSION['verification_code']=get_verification_code(6);
	$phone=@$_POST['phone'];
	//if(!is_match(self::$config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['pattern_err']."','key':'phone'}");}
	//if(sms_frequency($pdo,$phone,self::$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".self::$language['sms_frequent']."'}");}
	//$sql="select `id` from ".$pdo->index_pre."user where `phone`='".$phone."' and `id`!=".$_SESSION['user']['id'];
	//$r=$pdo->query($sql,2)->fetch(2);
	//if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");}
	
	//$sql="select `phone` from ".$pdo->index_pre."user where `id`=".$_SESSION['user']['id'];
	//$r=$pdo->query($sql,2)->fetch(2);
	//if($r['phone']==$phone){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['not_modified']."','key':'phone'}");}

	if(sms(self::$config,self::$language,$pdo,'动点云',$phone,$_SESSION['verification_code'])){
		$_SESSION['reg_phone']=$phone;
		$success=str_replace('{device}',self::$language['phone'],self::$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");

	}else{
		exit("{'state':'fail','info':'".self::$language['fail']."'}"); 	
	}
}

if($act=='update'){
	$phone=@$_POST['phone'];
	if($_POST['authcode']=='' || @$_SESSION['verification_code']!=$_POST['authcode']){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode'].self::$language['err']."</span>','key':'authcode'}");
	}
	if(!is_match(self::$config['other']['reg_phone'],$phone)){
		exit("{'state':'fail','info':'<span class=fail>".self::$language['phone'].self::$language['pattern_err']."</span>','key':'phone'}");
	}
	$sql="select `id` from ".$pdo->index_pre."user where `phone`='".$phone."' and `id`!=".$_SESSION['user']['id'];
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){exit("{'state':'fail','info':'".self::$language['phone'].self::$language['exist']."','key':'phone'}");}
	if($_SESSION['reg_phone']!=$phone){exit("{'key':'phone','state':'fail','info':'".self::$language['phone'].'!='.$_SESSION['reg_phone']."'}");}

	$sql="update ".$pdo->index_pre."user set `phone`='".$phone."' where `id`=".$_SESSION['user']['id'];
	if($pdo->exec($sql)){
		$_SESSION['verification_code']='';
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span]>'}"); 
	}
	
}