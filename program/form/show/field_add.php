<link rel="stylesheet" type="text/css" href="/css/formRelease.css">
<link rel="stylesheet" type="text/css" href="/css/formManager.css">

<?php

$id=@intval($_GET['id']);
if($id == '' || !is_numeric($id)){
	exit(alert_info("表参数提交错误.."));
}

$is_table_admin=check_is_table_admin($pdo,$id,$_SESSION);
if($is_table_admin < 1 || $is_table_admin > 3){
	exit(alert_info("你不是该表单的团队成员","权限不足","history.go(-1);"));
}
$table_name=return_table_info($pdo,$pdo->table_pre."table","name","id",$id,false);
if($table_name == ""){
	exit(alert_info("表不存在.."));
}

$_SESSION['token'][$method]=get_random(8);

$module['id']=$id;
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;





$module['submit-url']=create_table($_SERVER,$id,"urlt");
//"http://".$_SERVER['SERVER_NAME']."/c.php?".shortUrl2("http://".$_SERVER['SERVER_NAME']."/index.php?cloud=form.data_add&table_id=".$id,$pdo);
$module['query-url']=create_table($_SERVER,$id,"urlq");
//"http://".$_SERVER['SERVER_NAME']."/c.php?".shortUrl2("http://".$_SERVER['SERVER_NAME']."/index.php?cloud=form.data_show_list&table_id=".$id,$pdo);

$module['submit-code']='/upload/form/code/table_submit_id_'.$id.'.jpg';
$module['query-code']='/upload/form/code/table_query_id_'.$id.'.jpg';



$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);
