<?php
$id=intval(@$_GET['id']);
if($id>0){
	$sql="select `width`,`height`,`title`,`content`,`title_visible` from ".self::$table_pre."module where `id`='$id'";
	$module=$pdo->query($sql,2)->fetch(2);
	$module['content']=de_safe_str($module['content']);
	$module['title']=de_safe_str($module['title']);	
	if($module['title_visible']==1){$module['title_visible_checked']='checked';}else{$module['title_visible_checked']='';}	
	$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
	$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
	$module['class_name']=self::$config['class_name'];
	$module['web_language']=self::$config['web']['language'];
	$module['image_mark_option']=get_image_mark_option(self::$config['program']['imageMark'],self::$language);

			$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
}else{
	echo (self::$language['need_params']);	
}
