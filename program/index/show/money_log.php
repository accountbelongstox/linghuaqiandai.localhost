<?php
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$sql="select * from ".$pdo->index_pre."money_log where `username`='".$_SESSION['user']['username']."'";

$where="";
if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `time`<$end_time";	
}


if($_GET['search']!=''){$where=" and (`username` like '%".$_GET['search']."%' || `money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
}

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_money_log and","_money_log where",$sum_sql);
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_money_log and","_money_log where",$sql);
//echo($sql);
//exit();
$r=$pdo->query($sql,2);
$list='';
foreach($r as $v){
	$operation="<a href=".$v['id']." class='del'>".self::$language['del']."</a>";
	$v['money']=($v['money']<0)?$v['money']:'+'.$v['money'];
	$list.="<tr id='tr_".$v['id']."'>
	<td><span class=time><a href=#  title='ip:".$v['ip']."'>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</a></span></td>
	<td><span class=before_money>".$v['before_money']."</span></td>
	<td><span class=money>".$v['money']."</span></td>
	<td><span class=after_money>".$v['after_money']."</span></td>
	<td><span class=reason>".$v['reason']."</span></td>
</tr>
";	
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}

$sql="select sum(money) as c from ".$pdo->index_pre."money_log where `username`='".$_SESSION['user']['username']."' and `money`>0";
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%' || `money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$sql=str_replace("_money_log and","_money_log where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['add']=$r['c']==''?0:$r['c'];


$sql="select sum(money) as c from ".$pdo->index_pre."money_log where `username`='".$_SESSION['user']['username']."' and `money`<0";
if($_GET['search']!=''){$sql.=" and (`username` like '%".$_GET['search']."%' || `money` like '%".$_GET['search']."%' || `reason` like '%".$_GET['search']."%' || `operator` like '%".$_GET['search']."%')";}
if(isset($start_time)){$sql.=" and `time`>$start_time";	}
if(isset($end_time)){$sql.=" and `time`<$end_time";	}
$sql=str_replace("_money_log and","_money_log where",$sql);
$r=$pdo->query($sql,2)->fetch(2);
$module['deduction']=$r['c']==''?'-0':$r['c'];

	
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['list']=$list;
$module['page']=cloudDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);	