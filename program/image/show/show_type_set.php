<?php
		if(@$_GET['args']==''){echo 'need args';return false;}
		if(@$_GET['url']==''){echo 'need url';return false;}
		$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$attribute=format_attribute($_GET['args']);
		$module=array_merge($module,$attribute);
		$module['action_url']="/receive.php?target=index::edit_page_layout&act=update_attribute&old_module=image.show_type".$_GET['args'].'&url='.$_GET['url'].'&new_module=image.show_type';
		
		
		$module['target_option']=get_select_value($pdo,'target',$attribute['target']);
		$module['data_src_option']=$this->get_parent($pdo);
				
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	