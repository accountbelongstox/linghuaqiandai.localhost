<?php
$id=intval(@$_GET['id']);
$act=@$_GET['act'];
if($act=='add'){
	$time=time();
	$editor=$_SESSION['user']['id'];
	$_GET['duration']=(intval(@$_GET['duration'])==0)?20:$_GET['duration'];
	$_GET['delay']=(intval(@$_GET['delay'])==0)?20:$_GET['delay'];
	$_GET['width']=safe_str(@$_GET['width']);
	$_GET['height']=safe_str(@$_GET['height']);
	$_GET['width']=add_px($_GET['width']);
	$_GET['height']=add_px($_GET['height']);
	$_GET['title']=safe_str(@$_GET['title']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="insert into ".self::$table_pre."group (`title`,`style`,`width`,`height`,`duration`,`delay`,`editor`,`time`) values ('".$_GET['title']."','".$_GET['style']."','".$_GET['width']."','".$_GET['height']."','".$_GET['duration']."','".$_GET['delay']."','".$editor."','".$time."')";
	//echo $sql;
	if($pdo->exec($sql)){
		$this->update_slider($pdo);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}


if($act=='update'){
	$time=time();
	$editor=$_SESSION['user']['id'];
	$_GET['duration']=(intval(@$_GET['duration'])==0)?20:$_GET['duration'];
	$_GET['delay']=(intval(@$_GET['delay'])==0)?20:$_GET['delay'];
	$_GET['width']=safe_str(@$_GET['width']);
	$_GET['height']=safe_str(@$_GET['height']);
	$_GET['width']=add_px($_GET['width']);
	$_GET['height']=add_px($_GET['height']);
	$_GET['title']=safe_str(@$_GET['title']);
	$_GET['style']=safe_str(@$_GET['style']);
	$sql="update ".self::$table_pre."group set `width`='".$_GET['width']."',`height`='".$_GET['height']."',`duration`='".$_GET['duration']."',`delay`='".$_GET['delay']."',`title`='".$_GET['title']."',`style`='".$_GET['style']."',`time`='$time',`editor`='$editor' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		$this->update_slider($pdo);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}
if($act=='del'){
	$sql="delete from ".self::$table_pre."group where `id`='$id'";
	if($pdo->exec($sql)){
		$this->update_slider($pdo,$id);			
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}
}

if($act=='del_select'){
	$ids=safe_str(@$_GET['ids']);
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="delete from ".self::$table_pre."group where `id`='$id'";
		if($pdo->exec($sql)){
			$this->update_slider($pdo,$id);	
			$success.=$id."|";
		}
	}
	$success=trim($success,"|");	
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$time=time();
	$editor=$_SESSION['user']['id'];
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['duration']=(intval($v['duration'])==0)?20:$v['duration'];
		$v['delay']=(intval($v['delay'])==0)?20:$v['delay'];
			
		$v['width']=safe_str($v['width']);
		$v['height']=safe_str($v['height']);
		$v['width']=add_px($v['width']);
		$v['height']=add_px($v['height']);
		$v['title']=safe_str($v['title']);
		$v['style']=safe_str($v['style']);
		$sql="update ".self::$table_pre."group set `width`='".$v['width']."',`height`='".$v['height']."',`duration`='".$v['duration']."',`delay`='".$v['delay']."',`title`='".$v['title']."',`style`='".$v['style']."',`time`='$time',`editor`='$editor' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");	
	$this->update_slider($pdo);		
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload(); class=refresh>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

