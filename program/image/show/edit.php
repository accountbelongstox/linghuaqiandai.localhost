<?php
$id=intval(@$_GET['id']);
if($id==0){echo (self::$language['need_params']);	return false;}
$sql="select `type`,`title`,`content`,`src`,`link` from ".self::$table_pre."img where `id`='$id'";
$module=$pdo->query($sql,2)->fetch(2);
$module=de_safe_str($module);
$module['parent']=$this->get_parent($pdo);
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['class_name']=self::$config['class_name'];
$module['web_language']=self::$config['web']['language'];
$module['thumb_width']=self::$config['program']['thumb_width'];
$module['thumb_height']=self::$config['program']['thumb_height'];
$module['image_mark_option']=get_image_mark_option(self::$config['program']['imageMark'],self::$language);

		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();
$html4Upfile->echo_input("html4_up",'100%','./temp/','true','false','jpg|gif|png|jpeg','1024','1');
//echo_input("控件名称",'控件宽度(百分比或像素)','保存目录','文件夹是否附加日期','是否原名保存','允许文件后缀','文件大小 上限','文件大小 下限','指定保存名');


