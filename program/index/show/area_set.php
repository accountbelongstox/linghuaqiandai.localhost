<?php
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;

$upid=@$_GET['upid'];
$province=intval(@$_GET['province']);	
$city=intval(@$_GET['city']);	
$county=intval(@$_GET['county']);	
$twon=intval(@$_GET['twon']);	
$village=intval(@$_GET['village']);	
$group=intval(@$_GET['group']);	
$province_html='';	
$city_html='';	
$county_html='';	
$twon_html='';	
$village_html='';	
$group_html='';	

$province_html='<select id=province name=province><option value="">'.self::$language['province'].'</option>'.get_area_option($pdo,0).'</select>';	
if($province!=0){
	$city_html='<select id=city name=city><option value="">'.self::$language['city'].'</option>'.get_area_option($pdo,$province).'</select>';	
}
if($province!=0 && $city!=0){
	$v=get_area_option($pdo,$city);
	if($v!=''){$county_html='<select id=county name=county><option value="">'.self::$language['county'].'</option>'.$v.'</select>';}
}
if($province!=0 && $city!=0 && $county!=0){
	$v=get_area_option($pdo,$county);
	if($v!=''){$twon_html='<select id=twon name=twon><option value="">'.self::$language['twon'].'</option>'.$v.'</select>';	}
}
if($province!=0 && $city!=0 && $county!=0 && $twon!=0){
	$v=get_area_option($pdo,$twon);
	if($v!=''){$village_html='<select id=village name=village><option value="">'.self::$language['village'].'</option>'.$v.'</select>';	}
}

/*if($province!=0 && $city!=0 && $county!=0 && $twon!=0 && $village!=0){
	$v=get_area_option($pdo,$village);
	if($v!=''){$group_html='<select id=group name=group><option value="">'.self::$language['group'].'</option>'.$v.'</select>';	}
}
*/

$module['filter']=$province_html.$city_html.$county_html.$twon_html.$village_html.$group_html;

$list='';

if($upid==''){
	$sql="select * from ".$pdo->index_pre."area where `upid`=0 order by `sequence` desc,`id` asc";	
}else{
	$sql="select * from ".$pdo->index_pre."area where `upid`='".intval($_GET[$upid])."' order by `sequence` desc,`id` asc";	
}
$r=$pdo->query($sql,2);
foreach($r as $v){
	$list.="<tr id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
</tr>
";	
}

$module['list']=$list;


		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);