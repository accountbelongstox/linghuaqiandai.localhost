<?php
if(@$_GET['act']=='unlogin'){
	@session_destroy();
	setcookie(session_name(),'',time()-3600);
	$_SESSION = array();
	setcookie("cloud_nickname",'',time()-3600);
	setcookie("cloud_icon",'',time()-3600);
	setcookie("edit_page_layout",'',time()-3600);
	//echo "退出成功！";
	$backurl=isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'./index.php?cloud=index.login';
	if(!strpos($backurl,'?')){$backurl.='?refresh='.time();}else{$backurl.='&refresh='.time();}
	//$backurl=isset($_GET['backurl'])?$_GET['backurl']:'index.php?cloud=index.login';
	echo "backurl=".$backurl;exit;	
}	