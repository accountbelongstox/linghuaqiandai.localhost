<?php
$id=intval($_GET['id']);
if($id==0){echo 'id err';return false;}
$sql="select * from ".$pdo->index_pre."color where `id`=".$id;
$color=$pdo->query($sql,2)->fetch(2);
if($color['id']==''){echo 'id err';return false;}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&id=".$id;
$module['cloud_table_name']=$color['name'].' '.self::$language['pages'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$color=$color['data'];
if($color==''){
	$color=array();
	$color['head']=array();
	$color['head']['border']='';
	$color['head']['background']='';
	$color['head']['text']='';
	$color['container']=array();
	$color['container']['border']='';
	$color['container']['background']='';
	$color['container']['text']='';
	$color['shape_head']=array();
	$color['shape_head']['border']='';
	$color['shape_head']['background']='';
	$color['shape_head']['text']='';
	$color['shape_bottom']=array();
	$color['shape_bottom']['border']='';
	$color['shape_bottom']['background']='';
	$color['shape_bottom']['text']='';
	$color['nv_1']=array();
	$color['nv_1']['border']='';
	$color['nv_1']['background']='';
	$color['nv_1']['text']='';
	$color['nv_1_hover']=array();
	$color['nv_1_hover']['border']='';
	$color['nv_1_hover']['background']='';
	$color['nv_1_hover']['text']='';
	$color['nv_2']=array();
	$color['nv_2']['border']='';
	$color['nv_2']['background']='';
	$color['nv_2']['text']='';
	$color['nv_2_hover']=array();
	$color['nv_2_hover']['border']='';
	$color['nv_2_hover']['background']='';
	$color['nv_2_hover']['text']='';
	$color['nv_3']=array();
	$color['nv_3']['border']='';
	$color['nv_3']['background']='';
	$color['nv_3']['text']='';
	$color['nv_3_hover']=array();
	$color['nv_3_hover']['border']='';
	$color['nv_3_hover']['background']='';
	$color['nv_3_hover']['text']='';
	$color['button']=array();
	$color['button']['border']='';
	$color['button']['background']='';
	$color['button']['text']='';
	$color['button_hover']=array();
	$color['button_hover']['border']='';
	$color['button_hover']['background']='';
	$color['button_hover']['text']='';
	$color['module']=array();
	$color['module']['border']='';
	$color['module']['background']='';
	$color['module']['text']='';
	$color['table']=array();
	$color['table']['border']='';
	$color['table']['thead_background']='';
	$color['table']['thead_text']='';
	$color['table']['odd_background']='';
	$color['table']['odd_text']='';
	$color['table']['even_background']='';
	$color['table']['even_text']='';
	$color['table']['hover_background']='';
	$color['table']['hover_text']='';
	$color['page']=array();
	$color['page']['border']='';
	$color['page']['background']='';
	$color['page']['text']='';
	$color['page']['hover_background']='';//页码hover背景色
	$color['page']['current_background']='';//当前页码背景颜色
	$color['page']['current_text']='';//当前页码文字颜色
	
}else{
	$color=json_decode(de_safe_str($color),1);
}

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);