<?php
$act=@$_GET['act'];
if($act=='add'){
	$_GET['sequence']=intval(@$_GET['sequence']);
	$_GET['name']=safe_str(@$_GET['name']);
	$sql="insert into ".$pdo->index_pre."color (`name`,`sequence`) values ('".$_GET['name']."','".$_GET['sequence']."')";
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
	$sql="update ".$pdo->index_pre."color set `name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$id=intval(@$_GET['id']);
	if($id<1){exit();}
	$sql="delete from ".$pdo->index_pre."color where `id`='$id'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}
