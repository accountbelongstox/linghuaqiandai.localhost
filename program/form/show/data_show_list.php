<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id;


$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);


$sql="select `name`,`publish_condition` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$module['condition']=$r['publish_condition'];
$module['tablename']=$r['name'];


$sql="select * from ".self::$table_pre."field where `table_id`='$table_id' and `name`='".$module['condition']."'";
$r=$pdo->query($sql,2)->fetch(2);
$module['description']=$r['description'];


$module['search']="<div class=\"table_scroll search_table_public\">
<span>查询页面二维码</span><br />
<img onerror=\"reloadimg(this,'query','".$table_id."');\" id=\"codeImg\" src='/upload/form/code/table_query_id_".$table_id.".jpg' width='180' height='180'><br />
<span style='line-height:31px;font-size:16px;display:inline-block;margin-bottom:20px;'>输入".$module['description']."查询进度</span><br />
<input type=\"text\" name=\"search_schedule\" id=\"search_schedule\" placeholder=\"请输入".$module['description']."\" value=\"\" /><br />
<a data-tablename=\"".$module['tablename']."\" data-name=\"".$module['description']."\" data-reg=\"".$r['reg']."\" href=\"javascript:;\" onclick=\"search_schedule(this,document.getElementById('search_schedule'));\"  data-condition=\"".$module['condition']."\" data-id=\"".$table_id."\" class=\"search_schedule\">查询进度</a><br />

</div>";


$module['head_field']='';
$module['body_field']='';

$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);