<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select `time`,`sender`,`title`,`content` from ".$pdo->index_pre."site_msg where `id`='$id' and (`addressee`='".$_SESSION['user']['username']."' or `sender`='".$_SESSION['user']['username']."')";
	$module=$pdo->query($sql,2)->fetch(2);
	$module['time']=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$module['time']);
	$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
	$module['module_name']=str_replace("::","_",$method);
	$_SESSION['token'][$method]=get_random(8);$module['set_read_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
	if(isset($module['title'])){
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
	}
		
}else{
	echo (self::$language['need_params']);
}
