<?php
$type=intval(@$_GET['type']);
if($type==0){exit("{'state':'fail','info':'<span class=fail>".self::$language['lack_params'].':type'."</span>'}");}
$sql="select `title_power` from ".self::$table_pre."type where `id`='".$type."' and `visible`=1";
$r=$pdo->query($sql,2)->fetch(2);
$power=explode('|',$r['title_power']);
if(!in_array($_SESSION['user']['group_id'],$power)){exit("{'state':'fail','info':'<span class=fail>".self::$language['act_noPower']."</span>'}");}

$time=time();
$_POST['title']=safe_str(@$_POST['title']);
$_POST['content']=safe_str(@$_POST['content']);
$_POST['key']=safe_str(@$_POST['key']);
$_POST['email']=intval(@$_POST['email']);

if(strtolower($_POST['authcode'])!=strtolower($_SESSION["authCode"])){
	exit("{'state':'fail','info':'<span class=fail>".self::$language['authcode_err']."</span>'}");			
}

if($_POST['title']!=''){
	if($_POST['key']!=''){
		$sql="select count(id) as c from ".self::$table_pre."title where `key` like '%".$_POST['key'].",%'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>key:".$_POST['key'].self::$language['exist_same']."</span>'}");}
	}
	$_POST['key']=trim($_POST['key'],',').',';
	$sql="insert into ".self::$table_pre."title (`type`,`title`,`username`,`time`,`ip`,`key`,`email`) values ('".$type."','".$_POST['title']."','".$_SESSION['user']['username']."','".$time."','".get_ip()."','".$_POST['key']."','".$_POST['email']."')";	
	//echo $sql;
	if($pdo->exec($sql)){
		$insret_id=$pdo->lastInsertId();
		$sql="update ".self::$table_pre."type set `title_sum`=`title_sum`+1,`day_title_sum`=`day_title_sum`+1 where `id`=".$type;
		$pdo->exec($sql);
		if($_POST['content']!=''){
			self::add_content($pdo,$_POST['content'],$insret_id,$type);	
		}
		$_SESSION["authCode"]=rand(-9999999999,9999999999999999);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span><script>window.location.href='index.php?cloud=".self::$config['class_name'].".content&id=".$insret_id."';</script>'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}

}	
