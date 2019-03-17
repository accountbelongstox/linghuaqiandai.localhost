<?php
//处理类型
$act=@$_GET['act'];
if($act==""){exit('act err');}

if($act=="getCode"){
	$type=@$_POST['type'];
	$table_id=@$_POST['table_id'];
	$img_path="";
	$url="";
	$path="";
	switch ($type) {
		case 'query':/*查询表二维码*/
			$sql="select `id` from ".self::$table_pre."table where `id`=$table_id";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id'] == ''){
				exit('/images/tablenonentity.jpg');
			}
			$url=create_table($_SERVER,$table_id,"urlq");
			$path="./upload/form/code/";
			$img_path=$path.'table_query_id_'.$table_id.'.jpg';
			break;
		case 'submit':/*提交表二维码*/
			$sql="select `id` from ".self::$table_pre."table where `id`=$table_id";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['id'] == ''){
				exit('/images/tablenonentity.jpg');
			}
			$url=create_table($_SERVER,$table_id,"urlt");
			$path="./upload/form/code/";
			$img_path=$path.'table_submit_id_'.$table_id.'.jpg';
			break;
		case 'user_winxin_code':/*查询表二维码*/
			# code...
			break;
		default:
			exit('请指定类型');
			break;
	}
	if($img_path == "" || $url=="" || $path==""){
		exit('null');
	}
	if(!file_exists($img_path)){
		if(!is_dir($path)) {
			//如果目录不存在则创建
		    mkdir($path, 0777, true);
		}
		$create=return_table_info($pdo,$pdo->table_pre."table","creater","id",$table_id,false);
		$icon_png=return_table_info($pdo,$pdo->index_pre."user","icon","username",$create,false);
		$icon_png="./upload/index/user_icon/".$icon_png;
		create_PNGcode($url,$icon_png,$img_path,260,$create);
	}
	//var_dump($url);
	exit($img_path);
}





if($act=='search_schedule'){
	//ID
	$table_id=@$_POST['table_id'];
	if($table_id==""){exit('table_id err');}
	//提交内容
	$check_value=@$_POST['value'];
	if($check_value==""){exit('value err');}
	//查询条件
	$condition=@$_POST['condition'];
	if($condition==""){exit('condition err');}
	$table_ids=explode("|", $table_id);//支持多表查询
	$table_ids=array_filter($table_ids);
	$table_ids=array_unique($table_ids);
	$arr=array();
	foreach($table_ids as $v){
		$json_code=null;
		$tablename=return_table_info($pdo,$pdo->table_pre."table","callback,publish_condition,creater,name,description","id",$v,false);
		$json_code["description"]=$tablename["description"];
		$json_code["callback"]=$tablename["callback"];
		$data_detail=return_table_info($pdo,$pdo->table_pre.$tablename["name"],"id,assessor,state,state_txt,".$tablename["publish_condition"].",examined,write_time",$tablename["publish_condition"],$check_value,false);
		$json_code["assessor"]=$data_detail["assessor"];
		$json_code["state"]=$data_detail["state"];
		$json_code["state_txt"]=$data_detail["state_txt"];
		$json_code["examined"]=$data_detail["examined"];//得到审核状态
		$json_code["examined_txt"]=get_examined($pdo,$data_detail["examined"],$v);//得到审核状态
		$json_code["write_time"]=$data_detail["write_time"];
		$json_code[$condition]=$data_detail[$tablename["publish_condition"]];//查询条件
		$json_code["weixin"]=get_callback($pdo,$v,$data_detail["id"]);//返回微信
		array_push($arr,$json_code);
	}
	$r=json_encode($arr);
	exit($r);//张洪泽
}










