<?php
/*标识: 标记 导航代码*/
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$navigationPath = "./program/index/navigation.txt";
if(file_exists($navigationPath)){
	$module['data']=file_get_contents($navigationPath);
}else{
	fopen($navigationPath, "w");
	update_navigation_function($pdo);
	$module['data']=file_get_contents($navigationPath);
}


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);