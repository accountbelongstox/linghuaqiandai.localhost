<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit("{'state':'fail','info':'<span class=fail>table_id err</span>'}");}

$sql="select `name`,`description` from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_name=$r['name'];
$table_description=$r['description'];


$act=@$_GET['act'];
$id=intval(@$_POST['id']);


if($act=='get_examined'){
	$data_id=intval(@$_GET['data_id']);
	$table_name=@@$_GET['table_name'];
	$examined=return_table_info($pdo,$pdo->table_pre.$table_name,"assessor","id",$data_id,/*$all=*/false);
	$weixin=return_table_info($pdo,$pdo->index_pre."user","chip","username",$examined,/*$all=*/false);
	exit($weixin);
}
if($act=='get_data'){
	$id=intval(@$_GET['id']);
	$is_admin=check_is_table_admin($pdo,$table_id,$_SESSION/*1表管理,2表维护,3表查看*/);
	if($is_admin <1 || $is_admin >3){
		exit("你没有查看权限");
	}
	$table_name=@$_GET["table_name"];
	$sql="select * from ".$pdo->table_pre.$table_name." where `id`=$id";
	$data=$pdo->query($sql,2)->fetch(2);
	//$data=return_table_info($pdo,$pdo->table_pre.$table_name,"all","id",$id,false,"sql");
	//exit($sql);
	$data_json=array();
	foreach ($data as $key => $value) {
		$newkey=return_table_info($pdo,$pdo->table_pre."field","page,sequence,description,input_type,type","table_id,name",$table_id.",".$key,false);
		if($newkey["description"] != ""){
			$data_json[$key]["name"]=$newkey["description"];
			$data_json[$key]["value"]=$value;
			$data_json[$key]["type"]=$newkey["type"];
			$data_json[$key]["input_type"]=$newkey["input_type"];
			$data_json[$key]["sequence"]=$newkey["sequence"];
			$data_json[$key]["page"]=$newkey["page"];
		}
	}
	$data_json=multi_array_sort($data_json,"sequence",SORT_ASC);
	//$data_json=multi_array_sort($data_json,"page",SORT_ASC);
	$data_json=json_encode($data_json);
	exit($data_json);
}

//取得用户短信数量
if($act=='msg_money'){
	$table_create=return_table_info($pdo,self::$table_pre."table","creater","id",$table_id,false);
	$msg_money=return_table_info($pdo,$pdo->index_pre."user","msg_money","username",$table_create,false);
	exit($msg_money);
}


//取得用户短信内容
if($act=='getsmscontent'){
	$examined = intval(@$_GET['examined']);
	$weixin = @$_GET['weixin'];
	$smscontent= getSmsCotent($examined,false,$weixin)."【".self::$config['web']['name']."】";
	exit($smscontent);
}



if($act=='change_assessor'){
	//ID
	//内容
	$value=@$_POST['value'];
	//字段名
	$table=@$_POST['table'];
	$sql="update ".self::$table_pre.$table_name." set `$table`='$value' where `id`=$id";
	//exit($sql);
	if($pdo->exec($sql)){
		exit('修改成功');
	}
	exit('修改失改');
}

if($act=='getData_maxNum'){/*获取最大的*/
	$table_name=return_table_info($pdo,$pdo->table_pre."table","name","id",$table_id,/*$all=*/false);
	$sql="select `id` from ".self::$table_pre.$table_name." order by `id` desc";
	$r=$pdo->query($sql,2);
	$a=array();
	foreach ($r as $v) {
		array_push($a, $v["id"]);
		# code...
	}
	exit(json_encode($a));
}

if($act=='change_examined'){
	$weixin=@$_POST['weixin'];
	$state_txt=@$_POST['state_txt'];//理由
	$state=@$_POST['state'];//状态
	$table_name=@$_POST['table_name'];//表名
	$phone=@$_POST['phone'];//电话
	$sms=intval(@$_POST['sms']);//短信验证
	$examined=intval(@$_POST['examined']);//状态码
	$sql="select `creater`,`name` from ".self::$table_pre."table where `id`=$table_id"; //查询上面操作的表的数据
	$r=$pdo->query($sql,2)->fetch(2); 
	$table_name=$r['name'];
	$table_create=$r["creater"];
	$sql="update ".self::$table_pre.$table_name." set `state`='$state',`state_txt`='$state_txt',`examined`='$examined' where `id`=$id";
	$sms_txt="";
	if($pdo->exec($sql)){
		$sql_sms="";
		$sms_content="";
		if($sms == 1){
			$msg_money=return_table_info($pdo,$pdo->index_pre."user","msg_money","username",$table_create,false);
			if(intval($msg_money) < 1){
				exit("成功,短信未发送:余额已经不足");	
			}
			//$sms_content="尊敬的用户,你的申请资料进行".$state."，添加审核员微信号：".$weixin." 为您办理,搜索并关注公众号：[百仟贷]"; 
			$sms_content = $weixin;
			$examined = intval($examined);
			$sms_content = getSmsCotent($examined,false,$weixin);//取得短信内容
			$sms_txt="已向用户发送了短信!"; 
			auto_send_sms($pdo,$table_create,$phone,$sms_content,0,$examined);
			//$pdo,$sender,$phone,$content,$tmp_id=0,$sendtmpid=0/*发送类型*/
			exit($state.'成功!'.$sms_txt);
		}
		exit("更改成功");
	}else{
		exit('此操作未成功!');
	}
}



if($act=="join_GetTable"){
	$description=@$_POST['description'];
	$sql="select * from ".self::$table_pre."field where `table_id`=$table_id and `description`='".$description."'";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		exit(self::get_input_html(self::$language,$v));
		
	}
}



if($act=='export'){
	  if($_POST['field']==''){exit('field is null');}
	  $field=explode('|',trim($_POST['field'],'|'));
	  
	  //======================================================get thead
	  $sql="select `name`,`description` from ".self::$table_pre."table where `id`=$table_id";
	  $r=$pdo->query($sql,2)->fetch(2);
	  $table_name=$r['name'];	  
	  $sql="select `name`,`description`,`input_type` from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
	  $r=$pdo->query($sql,2);
	  $temp='';	 
	  $input_type=array(); 
	  foreach($r as $v){
		  $input_type[$v['name']]=$v['input_type'];
		  if(in_array($v['name'],$field)){$temp.=$v['description'].','; }
	  }
	  $list=trim($temp,',')."\r\n";		
	  
	  $fields='';
	  foreach($field as $v){$fields.='`'.$v.'`,';}
	  $fields=rtrim($fields,',');
	  $sql="select ".$fields." from ".self::$table_pre.$table_name;
	  if(isset($_POST['where'])){
			if($_POST['where']!=''){
				$sql.=$_POST['where'];
				$sql=str_replace($table_name.' and',$table_name.' where',$sql);
			}  
	  }
	  
	  //var_dump($input_type);
	  //echo $sql;
	  $r=$pdo->query($sql,2);
	  foreach($r as $v){
		  $temp='';
		  foreach($field as $k){
			  if($input_type[$k]=='time' || $k=='write_time' || $k=='edit_time'){$v[$k]=date('Y-m-d H:i',$v[$k]);}
			  if($input_type[$k]=='area'){$v[$k]=get_area_name($pdo,$v[$k]);}
			  $temp.=str_replace(',',' ',$v[$k]).',';
		  }
		  $list.=rtrim($temp,',')."\r\n";	;
		  	
	  }
	  
	  $list=iconv("UTF-8",self::$config['other']['export_csv_charset'].'//IGNORE',$list);
	  //$list=mb_convert_encoding($list,"UTF-8",self::$config['other']['export_csv_charset']);
	  header("Content-Type: text/csv");
	  header("Content-Disposition: attachment; filename=".$table_description."_".date("Y-m-d H_i_s").".csv");
	  header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	  header('Expires:0');
	  header('Pragma:public');
	  echo $list;
	  exit;

}


if($act=='update'){
	$_GET['id']=intval(@$_GET['id']);
	$assessor=@$_GET['assessor'];
	$examined=@$_GET['examined'];

	if($_GET['id']==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="update ".self::$table_pre.$table_name." set `examined`='".$assessor."',`examined`='".$examined."',`publish`='".intval($_GET['publish'])."',`sequence`='".intval($_GET['sequence'])."' where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
	}		
}

if($act=='submit_select'){
	//var_dump($_POST);	
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['publish']=intval($v['publish']);
		$v['sequence']=intval($v['sequence']);
		$sql="update ".self::$table_pre.$table_name." set `publish`='".intval($v['publish'])."',`sequence`='".intval($v['sequence'])."' where `id`='".$v['id']."'";
		//echo $sql;
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

if($act=='del' || $act=='del_select'){
	$sql="select `name`,`search_able`,`description`,`input_type`,`input_args` from ".self::$table_pre."field where `table_id`=$table_id  order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	
	$fields=array();
	$input_type=array();
	$input_args=array();
	
	foreach($r as $v){
		$input_type[$v['name']]=$v['input_type'];
		$input_args[$v['name']]=$v['input_args'];
		$fields[$v['name']]=$v['name'];
	}
	
}

if($act=='del'){
	$_GET['id']=intval(@$_GET['id']);
	if($_GET['id']==0){exit("{'state':'fail','info':'<span class=fail>id err</span>'}");}
	$sql="select * from ".self::$table_pre.$table_name." where `id`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="delete from ".self::$table_pre.$table_name." where `id`='".$_GET['id']."'";
	if($pdo->exec($sql)){
		foreach($fields as $v){
			switch ($input_type[$v]) {
				case 'img':
					if($r[$v]!=''){
						safe_unlink('./upload/form/img/'.$r[$v]);
						@safe_unlink('./upload/form/img_thumb/'.$r[$v]);
					}
					break;
				case 'imgs':
					if($r[$v]!=''){
						$temp3=explode('|',$r[$v]);
						$temp3=array_filter($temp3);
						$temp4='';	
						foreach($temp3 as $v3){
							safe_unlink('./upload/form/imgs/'.$v3);
							@safe_unlink('./upload/form/imgs_thumb/'.$v3);
						}
					}
					break;
				case 'file':
					if($r[$v]!=''){
						safe_unlink('./upload/form/file/'.$r[$v]);
					}
					break;
				case 'files':
					if($r[$v]!=''){
						$temp3=explode('|',$r[$v]);
						$temp3=array_filter($temp3);
						$temp4='';	
						foreach($temp3 as $v3){
							safe_unlink('./upload/form/files/'.$v3);
						}
					}
					break;
				case 'editor':
					if($r[$v]!=''){
						$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
						$imgs=get_match_all($reg,$r[$v]);
						reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
					}
					break;
				default:
			}
			
		}
		exit("成功!");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
	}	
}

if($act=='del_select'){
	$ids=@$_GET['ids'];
	if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
	$ids=explode("|",$ids);
	$ids=array_filter($ids);
	$success='';
	foreach($ids as $id){
		$id=intval($id);
		$sql="select * from ".self::$table_pre.$table_name." where `id`='".$id."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="delete from ".self::$table_pre.$table_name." where `id`='".$id."'";
		if($pdo->exec($sql)){
			foreach($fields as $v){
				switch ($input_type[$v]) {
					case 'img':
						if($r[$v]!=''){
							safe_unlink('./upload/form/img/'.$r[$v]);
							@safe_unlink('./upload/form/img_thumb/'.$r[$v]);
						}
						break;
					case 'imgs':
						if($r[$v]!=''){
							$temp3=explode('|',$r[$v]);
							$temp3=array_filter($temp3);
							$temp4='';	
							foreach($temp3 as $v3){
								safe_unlink('./upload/form/imgs/'.$v3);
								@safe_unlink('./upload/form/imgs_thumb/'.$v3);
							}
						}
						break;
					case 'file':
						if($r[$v]!=''){
							safe_unlink('./upload/form/file/'.$r[$v]);
						}
						break;
					case 'files':
						if($r[$v]!=''){
							$temp3=explode('|',$r[$v]);
							$temp3=array_filter($temp3);
							$temp4='';	
							foreach($temp3 as $v3){
								safe_unlink('./upload/form/files/'.$v3);
							}
						}
						break;
					case 'editor':
						if($r[$v]!=''){
							$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
							$imgs=get_match_all($reg,$r[$v]);
							reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
						}
						break;
				}
			}
			$success.=$id."|";
			
		}
	}
	$success=trim($success,"|");			
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}

/*首页置顶*/
if($act == 'index_show'){
	exit('ok');
}