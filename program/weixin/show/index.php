<?php

$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['data']='';
$show=@$_GET['show'];

if($show=='dialog'){
	$path=@$_GET['path'];
	$type=@$_GET['type'];
	$openid=safe_str(@$_GET['openid']);
	if($type=='voice'){
		$module['data']='<img src="/program/weixin/img/voice.png" style="width:100%;" /><br /><audio src="/program/weixin/voice/'.$path.'" controls="controls" style="width:100%;" autoplay="autoplay">'.self::$language['your_browser_does_not_support_the_audio_tag'].'</audio>';	
	}
	if($type=='video'){
		$module['data']='<video src="/program/weixin/video/'.$path.'" controls="controls" style="width:100%;" autoplay="autoplay">'.self::$language['your_browser_does_not_support_the_video_tag'].'</video>';	
	}
}


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);

?>