<?php
$module['module_name']="index_top_bar";
$module['data']='';
$module['nickname']='';
$json=array();
$json['msg']=0;


if(!isset($_SESSION['user']['id'])){ 
	$module['data'].="<a class=login href='index.php?cloud=index.login'>".self::$language['login']."</a><a href='index.php?cloud=index.reg_user&group_id=".self::$config['reg_set']['default_group_id']."' class=reg_user>".self::$language['reg_user']."</a>"; 
}else{

	$module['data'].='<span class=hello>'.self::$language['user_welcome'].'</span>';
	$module['data'].="<a href='index.php?cloud=index.user' class=icon_a><img class=icon_img src='/upload/index/user_icon/".$_SESSION['user']['icon']."' border=0></a>";
	$module['data'].="<a class=nickname href='index.php?cloud=index.user'>".$_SESSION['user']['nickname']."<span>|".$_SESSION['user']['group'].'</span></a>';
	$module['icon']="<a href='index.php?cloud=index.user' class=iocn_a><img class=icon_img src='/upload/index/user_icon/".$_SESSION['user']['icon']."' border=0></a>";
	$module['nickname']="<a class=nickname href='index.php?cloud=index.user'>".$_SESSION['user']['nickname'].'</a>';
	$module['group']=$_SESSION['user']['group'];
	
	$module['msg']='';
	$sql="select count(id) as c from ".$pdo->index_pre."site_msg where `addressee_state`=1 and `addressee`='".$_SESSION['user']['username']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>0){
		$module['msg']="<a class=msg_show href='index.php?cloud=index.site_msg_addressee' class='fadeIn animated infinite'>".$r['c']."</a>";
		$json['msg']=$r['c'];
	}
	$module['data'].=$module['msg'];
	
	$module['data'].=" <a class=unlogin href='/receive.php?target=index::user&act=unlogin&callback=unlogin&backurl=index.php?cloud=index.login'  class='ajax'>".self::$language['unlogin']."</a>"; 
	$module['unlogin']=" <a class=unlogin href='/receive.php?target=index::user&act=unlogin&callback=unlogin&backurl=index.php?cloud=index.login'  class='ajax'>".self::$language['unlogin']."</a>"; 
	
	$json['nickname']=$_SESSION['user']['nickname'];
	$json['group']=$_SESSION['user']['group'];
	$json['icon']="upload/index/user_icon/".$_SESSION['user']['icon'];

	
}

$module['top_welcome_info']=@self::$config['web']['top_welcome_info'];
$module['data']=str_replace("\r\n","",$module['data']);
$module['data']='"'.$module['data'].'"';	

$module['json']=json_encode($json);

$m_require_login=0;	
$t_path='./templates/'.$m_require_login.'/index/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';

if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/index/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);