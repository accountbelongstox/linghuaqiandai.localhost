<?php
$id=@intval($_GET['id']);
$_SESSION['token'][$method]=get_random(8);
if(isset($_GET['get_token'])){
	exit("token___________________=".$_SESSION['token'][$method]."\"");
}
if($id==0){exit('id err');}

$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method.'&id='.$id;

function get_field_type($language){
	$option='<option value="">'.$language['please_select'].'</option>';
	foreach($language['field_type'] as $key=>$v){
		$option.='<option value="'.$key.'">'.$v.'</option>';	
	}
	return $option;	
}

$module['field_type']=get_field_type(self::$language);

$sql="select * from ".self::$table_pre."field where `id`=$id";
$module['data']=$pdo->query($sql,2)->fetch(2);
$table_id=$module['data']['table_id'];
if($table_id==''){exit('table does not exist');}
$module['args']=format_attribute($module['data']['input_args']);

$sql="select * from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$module['table_name']=$r['name'];
$module['table_description']=$r['description'];
echo ' <div id="user_position_reset" style="display:none;"><a href="index.php"><span id=user_position_icon>&nbsp;</span>'.self::$config['web']['name'].'</a><a href="index.php?cloud=index.user">'.self::$language['user_center'].'</a><a href="index.php?cloud=form.table_admin">'.self::$language['program_name'].'</a><a href="index.php?cloud=form.table_admin&id='.$table_id.'">'.$r['description'].'</a><a href="index.php?cloud=form.table_edit&id='.$table_id.'">'.self::$language['field'].self::$language['admin'].'</a><span class=text>'.self::$language['edit'].self::$language['field'].'</span></div>';	





		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);
