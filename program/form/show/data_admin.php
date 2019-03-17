
<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}

$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_GET['search']=safe_str(@$_GET['search']);
$_GET['search']=trim($_GET['search']);
$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):200;//默认显示200条数据每页
$page_size=min($page_size,100);


$sql="select * from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_nameinfo=$r;//$table_nameinfo["table_join"]
$members=get_member($pdo,$table_nameinfo["creater"],$table_nameinfo["admin_is_edit"],"");//获得团队成员
//$sql="select * from cloud_index_user where `user_group` REGEXP '^4025[|]|[|]4025[|]'";
//$r=$pdo->query($sql,2);
function Give_shortcut($shortcut){
	//资料不齐全|不是本人操作|不配合提供资料|暂时不借|信用分不达标|尚有逾期未清|资料齐全属实
	$shortcut=explode("|", $shortcut);
	$t="";
	foreach ($shortcut as  $value) {
		$t.='<span class="span_shortcut" onclick="set_span_shortcut(this);" title="'.$value.'">'.$value.'</span>';
		# code...
	}
	return $t;
}
$module['shortcut']=Give_shortcut($table_nameinfo['shortcut']);
$table_name=$table_nameinfo['name'];
if($table_name == ""){
	exit("<div style='width:300px;text-align:center;font-size:22px;margin:0 auto;padding-top:150px;'>该表单不存在</div>");
}

$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` asc,`id` asc";
$r=$pdo->query($sql,2);
$where="";

$authority=check_is_table_admin($pdo,$table_id,$_SESSION);//查询用户权限.1,管理员,2编辑权(数据维护),3数据查看
if($authority < 1 || $authority > 3){
	$alert_info=alert_info("你没有查看该表的权限","没有权限",$click="$(this).parent().parent().parent().hide();");
	exit($alert_info);
}
//如果不是总管理员 查询时将过滤
switch ($authority) {
	case 1:
		# code...
		break;
	case 2:
		$where.=" and `assessor` ='".$_SESSION['user']['username']."'";
		break;
	case 3:
		# 表查看 ...
		break;
	
	default:
		# code...
		break;
}


//自动分配审核员

auto_user_give_assessor($pdo,$table_id,0);


if(@$_GET['publish']!=''){if($_GET['publish']==0 || $_GET['publish']==1){$where.=" and `publish` ='".$_GET['publish']."'";}}

$export_checkbox='';
$fields='';
$search_able='';
$input_type=array();
$input_args=array();
$module['head_field']='';
$module['body_field']='';
$module['search_placeholder']=self::$language['writer'].'ID';
$module['filter']='<select id=publish><option value="-1">'.self::$language['state'].'</option><option value="" selected>'.self::$language['all'].'</option><option value="0">'.self::$language['publish_0'].'</option><option value="1">'.self::$language['publish_1'].'</option></select>';
$i=0;
$fieldinfo="";
foreach($r as $v){
	if($v['name'] == $table_nameinfo["table_join"]){
		$fieldinfo=$v;
	}

	$export_checked='';
	$input_type[$v['name']]=$v['input_type'];
	$input_args[$v['name']]=$v['input_args'];
	$fields.='`'.$v['name'].'`,';
	if($v['back_list_show']){
		$module['head_field'].="<td><a href=# title=".self::$language['order']."  class='sorting'  desc='".$v['name']."|desc' asc='".$v['name']."|asc'>".$v['description']."</a></td>";
		$module['body_field'].=$v['name'].",";
		$export_checked='checked';
	}
	$export_checkbox.='<span class=checkbox_span><input type="checkbox" '.$export_checked.' id="export_'.$v['name'].'" name="export_'.$v['name'].'" /><m_label for="export_'.$v['name'].'">'.$v['description'].'</m_label></span>';	
	if($v['search_able']){$module['search_placeholder'].='/'.$v['description'];$search_able.="`".$v['name']."` like '%".$_GET['search']."%' or ";}	
	if($v['input_type']=='select' || $v['input_type']=='radio' || $v['input_type']=='checkbox'){
		$options='';
		$args=format_attribute($v['input_args']);
		$temp=explode('/',$args[$v['input_type'].'_option']);
		$vv_n = 0;/*标记审核的VALUE值*/
		foreach($temp as $vv){
			if(@$_GET[$v['name']]==$vv){$selected='selected';}else{$selected='';}
			$vv_value = $vv;
			if($v['name'] == 'examined')
			/*审核状态排序*/
			{
				$vv_value = $vv_n;
				$vv_n++;
			}
			$options.='<option value="'.$vv_value.'" '.$selected.'>'.$vv.'</option>';
		}
		$module['filter'].='<select id='.$v['name'].'><option value="-1">'.$v['description'].'</option><option value="" selected>'.self::$language['all'].'</option>'.$options.'</select>';
		if(@$_GET[$v['name']]!=''){
			if($v['input_type']=='checkbox'){
				$where.=" and `".$v['name']."` like '%".$_GET[$v['name']]."|%'";
			}else{
				$where.=" and `".$v['name']."` ='".$_GET[$v['name']]."'";
			}	
		}
	}
	$i++;
}

//自定义条件区
if(!empty($_GET['examined'])){
	$where.=" and `examined` ='".$_GET['examined']."'";

}

//var_dump($where);

if(!empty($_GET['overdue'])){
	$where.=" and `overdue` ='".$_GET['overdue']."'";
}
//今日新提交
if(!empty($_GET['write_time']) && $_GET['write_time'] == "today"){
	//将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2015-10-12 00:00:00)
	$where.=" and `write_time` >=".mktime(0,0,0,date("m"),date("d"),date("Y"));
}
//审核员
if(!empty($_GET['assessor']) && $_GET['assessor'] != ""){
	//将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2015-10-12 00:00:00)
	$where.=" and `assessor` ='".$_GET['assessor']."'";
}



$fields=trim($fields,',');
$search_able=trim($search_able,'or ');
$sql="select `publish`,`id`,`write_time`,`writer`,`sequence`,".$fields." from ".self::$table_pre.$table_name;
//$where='';


if($_GET['search']!=''){
	$where.=" and (`writer` like '%".$_GET['search']."%' or `editor` like '%".$_GET['search']."%' or ".$search_able.")";	
}

if(@$_GET['start_time']!=''){
	$start_time=get_unixtime($_GET['start_time'],self::$config['other']['date_style']);
	$where.=" and `write_time`>$start_time";	
}
if(@$_GET['end_time']!=''){
	$end_time=get_unixtime($_GET['end_time'],self::$config['other']['date_style'])+86400;
	$where.=" and `write_time`<$end_time";	
}

if(@$_GET['order']==''){
	$order=" order by `id` desc";
}else{
	$_GET['order']=safe_str($_GET['order']);
	$temp=safe_order_by($_GET['order']);
	if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
		
}

$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
	$sum_sql=$sql.$where;
	$sum_sql=str_replace(" `publish`,`id`,`write_time`,`writer`,`sequence`,".$fields." "," count(id) as c ",$sum_sql);
	$sum_sql=str_replace("_".$table_name." and","_".$table_name." where",$sum_sql);
	//echo $sum_sql;
	$r=$pdo->query($sum_sql,2)->fetch(2);
	$sum=$r['c'];
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_".$table_name." and","_".$table_name." where",$sql);
//echo($sql);
$r=$pdo->query($sql,2);



$list='';
$pngCode="";

foreach($r as $v){
	$filed_data='';
	$v=de_safe_str($v);
	$temp=explode(',',$module['body_field']);
	$temp=array_filter($temp);
	foreach($temp as $vv){
		//echo $vv.'<br />';
		if(in_array($vv,self::$config['sys_field'])){
			switch ($vv){
				case 'write_time':
					$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['write_time']);
					break;
				case 'writer':
					if($v['writer']>0){$data=get_username($pdo,$v['writer']);}else{$data=self::$language['unlogin_user'];}
					break;
				case 'edit_time':
					$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['edit_time']);
					break;
				case 'editor':
					if($v['editor']>0){$data=get_username($pdo,$v['writer']);}else{$data='';}
					break;
				case 'sequence':
					$data="<input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."'  class='sequence' value='".$v['sequence']."' />";
					break;
				case 'publish':
					$data="<input type='checkbox' name='publish_".$v['id']."' id='publish_".$v['id']."'  class='publish' value='".$v['publish']."' />";
					break;
				default:
					$data=$v[$vv];	
			}
			$filed_data.='<td><span class='.$vv.'>'.$data.'</span></td>';
			continue;	
		}
		
		$args=format_attribute($input_args[$vv]);
		$data='';
		switch ($input_type[$vv]) {
			case 'img':
				if(is_file('./upload/form/img_thumb/'.$v[$vv])){
					$data='<a href="/upload/form/img/'.$v[$vv].'" target="_blank"><img onclick="show_img(this);" src="/upload/form/img_thumb/'.$v[$vv].'" style="width:'.$args['img_width'].'px;border:0px;"></a>';
				}else{
					$data='<a href="javascript:void(0);" onclick="show_img(this);" target="_blank"><img onclick="show_img(this);" src="/upload/form/img/'.$v[$vv].'" class="list_show_img"></a>';
				}
				break;
			case 'imgs':
				if($v[$vv]!=''){
					$temp3=explode('|',$v[$vv]);
					$temp3=array_filter($temp3);
					$temp4='';	
					foreach($temp3 as $v3){
						$temp4.='<a href="/upload/form/imgs/'.$v3.'" target="_blank">'.substr($v3,11).'</a><br />';
					}
					$data=$temp4;
				}
				break;
			case 'file':
				$data='<a href="/upload/form/file/'.$v[$vv].'" target="_blank">'.substr($v[$vv],11).'</a>';
				break;
			case 'files':
				if($v[$vv]!=''){
					$temp3=explode('|',$v[$vv]);
					$temp3=array_filter($temp3);
					$temp4='';	
					foreach($temp3 as $v3){
						$temp4.='<a href="/upload/form/files/'.$v3.'" target="_blank">'.substr($v3,11).'</a><br />';
					}
					$data=$temp4;
				}
				break;
			case 'time':
				$data=get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v[$vv]);
				break;
			case 'area':
				$data="<span class=load_js_span  src='include/core/area_js.php?callback=set_area&input_id=".$vv."&id=".$v[$vv]."&output=text2' id='home_area_".$v[$vv]."'></span>";
				break;
			case 'map':
				if($v[$vv]!==''){
					$data='<a href="'.$v[$vv].'" target="_blank" class=map title="'.self::$language['view'].'">&nbsp;</a>';
				}
				break;
			default:
				$data=$v[$vv];
		}

		//最后组合判断
		switch ($input_type[$vv]) {

			case 'map':
			$filed_data.='<td><span class='.$vv.'>'.$data.'</span></td>';
			break;

			case 'img':
			$filed_data.='<td><span class='.$vv.'>'.$data.'</span></td>';
			break;

			default:
				//类型判断
				switch ($vv) {
					//是否逾期
					case 'overdue':
					switch($v[$vv]){
						case 0:
						$_data="无";
						$_data_style="";
						break;
						case 1:
						$_data="逾期";
						$_data_style=" style='color:#F92672;'";
						break;
						case 2:
						$_data="严重";
						$_data_style=" style='color:red;font-weight:bold;'";
						break;
						default:
						$_data="无";
						$_data_style="";
						break;
					}
					$filed_data.='<td><span onclick="javascript:alert(\'等待开发中...\');" '.$_data_style.' class='.$vv.'>&nbsp;'.$_data.'</span></td>';
					break;
					case $table_nameinfo['table_join']:
					$join_filed_data="";
					$chipsql="select `chip` from ".$pdo->sys_pre."index_user where `username`='".$v['assessor']."'";
					$chip=$pdo->query($chipsql,2)->fetch();
					$weixin=$chip['chip'];
					if ($authority == 1 or $authority == 2) {//如果是管理员或者维护 员
						$join_filed_data=self::get_input_html_new(self::$language,$fieldinfo,$v['state'],$table_nameinfo['table_sms'],$v["id"]);//由68行代码处取得该值 
					}else{
						$join_filed_data=get_examined($pdo,$data,$table_nameinfo["id"]);
					}
					
					$filed_data.='<td id="'.$v["id"].'_'.$table_nameinfo['table_join'].'" data-phone="'.get_true_phone($v)/*由function文件智能获取*/.'" data-table_name="'.$table_name.'" data-table_id="'.$table_id.'" data-shortcut="'.$table_nameinfo["shortcut"].'"  data-weixin="'.$weixin.'" class="admin_changetable" >'.$join_filed_data.'</td>';
					break;
					case "assessor"://assessor
					if($authority == 1){/*允许修改审核员*/
						$option_v="";
						foreach ($members as $v_v) {
							$option_v.="<option ";
							if($v_v["username"] == $data){
								$option_v.='selected="selected"';
							}
							$option_v.=" value=\"".$v_v["username"]."\">".$v_v["username"]."</option>";
						}
						$filed_data.='<td><select data-table_id="'.$table_id.'" data-table_name="'.$table_name.'" id="assessor_'.$v['id'].'"  check_reg="" cloud_required="0" onchange="change_assessor(this);" class="cloud_input">'.$option_v.'</select></td>';
					}else{
						$filed_data.='<td><span class='.$vv.'>'.$v[$vv].'</span></td>';
					}
					
					break;
					default:
					$filed_data.='<td><span class='.$vv.'>'.$v[$vv].'</span></td>';
					break;
			}
		}
	}
	
	
	$pngCode.=$v['id'].",";
	$submit_="";
	$module['operation_td_width']="width:16px;";
	if($authority < 4 && $authority > 0){//3查看
		$submit_.="<a title='查看数据' onclick='GetDatas(this,\"tr\");' data-id=\"".$v['id']."\" data-href='index.php?cloud=".$class.".data_show_detail&table_id=".$table_id."&id=".$v['id']."' href=\"javascript:;\" date-id=\"".$v['id']."\" target=_blank  class='view'></a>";/*查看数据权限*/
	}
	if($authority < 3 && $authority > 0){//2表维护 
		$submit_.="<a title='编辑数据' href='index.php?cloud=".$class.".data_edit&table_id=".$table_id."&id=".$v['id']."' target=_blank class='edit'></a>";/*表编辑*/

	}
	if($authority < 2 && $authority > 0){//1表管理
		$submit_.="<a title='删除数据' href='#' onclick='return del(".$v['id'].")'  class='del'></a>";/*表删除*/

	}
	$list.="<tr data-id='tr_".$v['id']."' id='tr_".$v['id']."'>
	<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
	 <td class=operation_td style=\"".$module['operation_td_width']."\">".$submit_."<span id=state_".$v['id']." class='state'></span></td>
	 ".$filed_data."
	 </tr>
";	
}

if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id;
$module['list']=$list;
$module['page']=cloudDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);

if($_SESSION['user']['group_id'] == 1){
	if($where==''){
	$module['export']='<a href="'.$module['action_url'].'&act=export_csv" target="_blank" class=export>'.self::$language['export'].self::$language['all'].self::$language['data'].'</a>';
	}else{
		$module['export']='<a href="'.$module['action_url'].'&act=export_csv" target="_blank" class=export>'.self::$language['export'].self::$language['matching'].self::$language['data'].$sum.self::$language['a'].'</a>';
	}
}else{
	$module['export']="";
}

$module['export_div']='<fieldset id="export_div" style="display:none;"><legend>'.self::$language['export'].self::$language['field'].'</legend>'.$export_checkbox."<br /><br /><a href='#' id=export_submit class='submit'>".self::$language['confirm'].self::$language['export']."</a>".'<form id="export_form" style="display:none;" target="_blank" name="export_form" method="post" action="'.$module['action_url'].'&act=export"><input type="text" name="where" id="where" value="'.$where.'" /><input type="text" name="field" id="field" /></form>'."</fieldset>";




		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);


