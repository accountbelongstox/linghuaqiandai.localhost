<?php
if(@$_GET['args']==''){echo 'need args';return false;}
if(@$_GET['url']==''){echo 'need url';return false;}
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$attribute=format_attribute($_GET['args']);
$module=array_merge($module,$attribute);
$all=array('title'=>self::$language['title'],'tag'=>self::$language['tag'],'visit'=>self::$language['visit_count'],'time'=>self::$language['update_time'],'src'=>self::$language['image'],'content'=>self::$language['content']);
$module['field_checkbox']=get_field_checkbox($attribute['field'],$all);
$module['action_url']="/receive.php?target=index::edit_page_layout&act=update_attribute&old_module=article.show".$_GET['args'].'&url='.$_GET['url'].'&new_module=article.show';


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);