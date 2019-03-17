<?php
$act=@$_GET['act'];
$id=intval(@$_GET['id']);

if($act=='paid'){
	$sql="select * from ".$pdo->index_pre."withdraw where `id`='$id' and `state`!='3'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `money` from ".$pdo->index_pre."user where `username`='".$r['username']."'";
	$r2=$pdo->query($sql,2)->fetch(2);
	if($r2['money']<$r['money']){
		exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['user'].self::$language['insufficient_balance']."'}");
	}
	
	if($r['method']==1){
		
		if(self::$config['web']['wid']==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['no_web_weixin']."'}");}
		$r3=wexin_transfers($pdo,$r['username'],self::$config['web']['name'].' '.self::$language['withdraw'],$r['money'],'index');
		if(!$r3){exit("{'state':'fail','info':'<span class=fail>".$_POST['err_code_des']."</span>'}");}
	}


	$sql="update ".$pdo->index_pre."withdraw set `state`='3',`operator`='".$_SESSION['user']['username']."' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		//var_dump($r);
		if(operator_money(self::$config,self::$language,$pdo,$r['username'],'-'.$r['money'],self::$language['withdraw'],self::$config['class_name'])){
			exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
		}else{
			$sql="update ".$pdo->index_pre."withdraw set `state`='1',`operator`='' where `id`='$id' and `state`='3'";
			$pdo->exec($sql);
			exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='refuse'){
	$_GET['reason']=safe_str(@$_GET['reason']);
	if($_GET['reason']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");}
	$sql="update ".$pdo->index_pre."withdraw set `state`='2',`operator`='".$_SESSION['user']['username']."',`reason`='".$_GET['reason']."' where `id`='$id' and `state`='1'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".$pdo->index_pre."withdraw where `id`='$id' and (`state`='1' or `state`='2')";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$sql="delete from ".$pdo->index_pre."withdraw where `id`='$id' and (`state`='1' or `state`='2')";
		if($pdo->exec($sql)){
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
