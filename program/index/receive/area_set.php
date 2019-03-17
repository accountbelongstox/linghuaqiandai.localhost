<?php
foreach($_GET as $key=>$v){
	if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
}
$act=@$_GET['act'];
if($act=='add'){
	$upid=intval(@$_GET['upid']);
	$sequence=intval(@$_GET['sequence']);
	$name=safe_str(@$_GET['name']);
	
	if($upid==0){
		$level=1;	
	}else{
		$sql="select `level` from ".$pdo->index_pre."area where `id`=".$upid;
		$r=$pdo->query($sql,2)->fetch(2);
		$level=$r['level'];	
		$level++;
	}
	
	$sql="insert into ".$pdo->index_pre."area (`name`,`sequence`,`upid`,`level`) values ('".$_GET['name']."','".$_GET['sequence']."','".$upid."','".$level."')";
	//file_put_contents('./test.sql',$sql);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="update ".$pdo->index_pre."area set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="select count(id) as c from ".$pdo->index_pre."area where `upid`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	$sql="delete from ".$pdo->index_pre."area where `id`='$id'";
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
		$id=intval($id);
		$sql="select count(id) as c from ".$pdo->index_pre."area where `upid`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);		
		if($r['c']==0){
			$sql="delete from ".$pdo->index_pre."area where `id`='$id'";
			if($pdo->exec($sql)){$success.=$id."|";}
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$v['name']=safe_str($v['name']);
		$sql="update ".$pdo->index_pre."area set `name`='".$v['name']."',`sequence`='".$v['sequence']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

