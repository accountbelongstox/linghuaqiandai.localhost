<?php
$time=time();
$_POST['type']=intval(@$_POST['type']);
$_POST['title']=safe_str(@$_POST['title']);
$_POST['content']=safe_str(@$_POST['content']);
$_POST['tag']=safe_str(@$_POST['tag']);
$_POST['tag']=str_replace("｜","|",$_POST['tag']);
$_POST['html4_up']=safe_str(@$_POST['html4_up']);
if($_POST['html4_up']!=''){
	if(file_exists('./temp/'.$_POST['html4_up'])){
		$path='./program/article/img/'.safe_path($_POST['html4_up']);
		get_date_dir('./program/article/img/');	
		get_date_dir('./program/article/img_thumb/');	
		if(safe_rename('./temp/'.safe_path($_POST['html4_up']),$path)==false){
			exit("{'state':'fail','info':'<span class=fail>image up failed</span>'}");
		}
		$thumb_width=(intval(@$_POST['thumb_width'])>0)?$_POST['thumb_width']:self::$config['program']['thumb_width'];
		$thumb_height=(intval(@$_POST['thumb_height'])>0)?$_POST['thumb_height']:self::$config['program']['thumb_height'];
		$image=new image();
		$image->thumb($path,'./program/article/img_thumb/'.$_POST['html4_up'],$thumb_width,$thumb_height);
		if($_POST['image_mark']){
			$image->addMark($path);
		}
	}	
}


if($_POST['type']>0 && $_POST['title']!='' && $_POST['content']!=''){
	$sql="insert into ".self::$table_pre."article (`type`,`title`,`content`,`editor`,`time`,`tag`,`src`) values ('".$_POST['type']."','".$_POST['title']."','".$_POST['content']."','".$_SESSION['user']['id']."','$time','".$_POST['tag']."','".$_POST['html4_up']."')";	
	//echo $sql;
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
		$imgs=get_match_all($reg,$_POST['content']);
		reg_attachd_img("add",self::$config['class_name'],$imgs,$pdo,$_POST['image_mark']);
		exit("{'state':'success','info':'<span class=success>&nbsp;</span><script>window.location.href=\"index.php?cloud=".self::$config['class_name'].".show&id=".$insret_id."\";</script>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}	
