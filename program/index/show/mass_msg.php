<?php
$menu=require("./program/".$class."/menu.php");
$pages=require("./program/".$class."/pages.php");
$list='';
foreach($menu[str_replace("::",".",$method)] as $key=>$v){
	if(is_array($v)){$v=$key;}
	$t=explode(".",$pages[$v]['url']);
	$v2['icon_path']="./templates/1/".$class."/".self::$config['program']['template_1']."/page_icon/".$pages[$v]['url'].".png";
	$list.="<li><a href=index.php?cloud={$pages[$v]['url']} target='".$pages[$v]['target']."'><img src='".$v2['icon_path']."' /><br><span>".self::$language['pages'][$v]['name']."</span></a></li>";
	
}
$list.="<li><a href=index.php?cloud=index.config&id=sms ><img src='/templates/1/index/".self::$config['program']['template_1']."/page_icon/index.config&id=sms.png' /><br><span>".self::$language['config_language']['sms']['this_name']."</span></a></li>";

$module['list']="<ul id=icons>{$list}<div style='clear:both;'></div></ul>";
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);