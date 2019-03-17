<?php

$act=@$_GET['act'];
if($act=='submit'){
	$method=intval(@$_POST['method']);
	$money=floatval(@$_POST['money']);
	$billing_info=safe_str(@$_POST['billing_info']);
	if($method==0){
		if(@$_POST['billing_info']==self::$language['billing_info_template'] || @$_POST['billing_info']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['billing_info'].self::$language['is_null']."</span>'}");}
	}
	
	if($money==0 || $money<0){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	if($money<1){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_than_one']."</span>'}");}
	
	$sql="select `real_name`,`money` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($money>$r['money']){exit("{'state':'fail','info':'<span class=fail>".self::$language['must_be_less_than'].self::$language['user_money']."</span>'}");}
	
	
	$sql="insert into ".$pdo->index_pre."withdraw (`username`,`money`,`billing_info`,`time`,`ip`,`state`,`method`) values ('".$_SESSION['user']['username']."','$money','".$billing_info." ".$r['real_name']."','".time()."','".get_ip()."','1','".$method."')";
	if($pdo->exec($sql)){
		$id=$pdo->lastInsertId();
		if($method==1 && self::$config['web']['wx_withdraw_auto_pay']){
			$r=wexin_transfers($pdo,$_SESSION['user']['username'],self::$config['web']['name'].' '.self::$language['withdraw'],$money,'index');
			if($r){
				$sql="update ".$pdo->index_pre."withdraw set `state`='3',`operator`='".$_SESSION['user']['username']."' where `id`='$id' and `state`='1'";
				if($pdo->exec($sql)){
					if(!operator_money(self::$config,self::$language,$pdo,$_SESSION['user']['username'],'-'.$money,self::$language['withdraw'],self::$config['class_name'])){
						$sql="update ".$pdo->index_pre."withdraw set `state`='1',`operator`='' where `id`='$id' and `state`='3'";
						$pdo->exec($sql);
						
					}
				}
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>,".self::$language['withdraw_state'][3]."'}");
			}
				
		}
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>,".self::$language['withdraw_state'][1]."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
	
	
}