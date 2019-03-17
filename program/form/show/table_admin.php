<link rel="stylesheet" type="text/css" href="/css/formRelease.css">
<link rel="stylesheet" type="text/css" href="/css/formManager.css">
<?php
$_SESSION['token'][$method]=get_random(8);
$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
admin_return($pdo,$_SESSION);
$authority=check_is_admin_user($pdo,$_SESSION);//权限字符
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$id=intval(@$_GET['id']);
$search=safe_str(@$_GET['search']);
$search=trim($search);
$current_page=intval(isset($_GET['current_page'])?$_GET['current_page']:1);
$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

$page_size=100;

$sql="select * from ".self::$table_pre."table";
$where="";
if($search!=''){$where=" and (`name` like '%$search%' or `description` like '%$search%')";}
if($id!=0){$where=" and `id`=".$id;}
$limit=" limit ".($current_page-1)*$page_size.",".$page_size;
$sum_sql=$sql.$where;
$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
$sum_sql=str_replace("_table and","_table where",$sum_sql);

$r=$pdo->query($sum_sql,2)->fetch(2);
$sum=$r['c'];

//权限判读读取那些表
if($_SESSION["user"]["group_id"] != 1) {
	$where.=" and `creater`='".$_SESSION["user"]["username"]."' or `admin_power` like '%".$_SESSION['user']['id']."|%' or `edit_power` like '%".$_SESSION['user']['id']."|%' or `read_power` like '%".$_SESSION['user']['id']."|%' ";//
}

$module["re_html_head"]="";/*返回*/
$re_html_head2='<div class="re_html_head"><a class="re_html_head_a" href="/index.php?cloud=form.table_admin">< 桌面</a></div>';
if(isset($_GET["folder"])){
	$folder_id=@$_GET["folder"];
	if(!is_numeric($folder_id)){
		$folder_id=0;
	}else{
		$module["re_html_head"]=$re_html_head2;
	}
}else{
	$folder_id=0;
}

if(!isset($_GET["showtype"])){
	/*判断显示方式*/
	$_GET["showtype"]="folder";
}
//智能分配审核员
//$auto_sql=auto_user_give_assessor($pdo,$id,$nnn,$retype="default");
//var_dump($auto_sql);
//auto_user_give_assessor_Table($pdo,"sql");

$order=" order by `sequence` desc,`id` desc";
$sql=$sql.$where.$order.$limit;
$sql=str_replace("_table and","_table where",$sql);
//exit($sql);
$r=$pdo->query($sql,2);
$list='';
$module['tablename_option']="";//复制表选项
$folder_sequence="";
if($_SESSION["user"]["folder_sequence"] == ""){
	$_folder_arr=array();
}else{
	$_folder_arr=self::get_folder_user($_SESSION,"number",$folder_id);//过滤文件夹.
	$all_folder_arr=self::get_folder_user($_SESSION,"all");//过滤文件夹.
}
//exit(var_dump($_folder_arr));
foreach($r as $v){
	if($_SESSION["user"]["folder_sequence"] == ""){
		/*初始化用户个人文件夹*/
		$folder_sequence.=$v["id"]."=>0,";
		array_push($_folder_arr,$v["id"]);
	}else{
		if( !in_array(intval($v["id"]), $all_folder_arr) ){
			/*如果该表还没有生成*/
			$new_folder_arr[$v["id"]]=0;
			$_SESSION["user"]["folder_sequence"]=self::write_folder_user($pdo,$_SESSION,$new_folder_arr);
		}
	}

	if( in_array(intval($v["id"]), $_folder_arr) ){//没有上级文件夹
		if($v["table_join"] == "__folder__"){
			/*读取文件夹*/
			$list.=self::get_table_html_row($pdo,$_SESSION,$_SERVER,$v,"folder");
		}else{
			/*读取表单*/
			auto_user_give_assessor($pdo,$v["id"],0);//自动分配
			$module['tablename_option'].='<option data-id="'.$v["id"].'" value="'.$v["id"].'">'.$v["description"].'</option>';
			if($_SESSION["user"]["group_id"] == 1){
				/*管理员*/
				$list.=self::get_table_html_row($pdo,$_SESSION,$_SERVER,$v,"admin_".$_GET["showtype"]/*showtype == 显示方式*/);
			}else{
				/*非管理员*/
				$list.=self::get_table_html_row($pdo,$_SESSION,$_SERVER,$v,"user");
			}
		}
	}
}

if($_SESSION["user"]["folder_sequence"] == ""){
	/*初始化用户个人文件夹*/
	//exit($folder_sequence);
	$_SESSION["user"]["folder_sequence"]=self::create_folder_user($pdo,$_SESSION,$folder_sequence);
}

$module["showtypehtml"]="";
if($_SESSION["user"]["group_id"] == 1){
	$module["showtypehtml"]='
	<div class="admin_table_list_left" style="height: 40px;line-height: 40px;font-size:13px;"> 显示方式:
	<a href="./index.php?cloud=form.table_admin&showtype=folder" class="col_show_list_tableadmin"><i class="fa-th-large"></i> 文件夹</a>
	<a href="./index.php?cloud=form.table_admin&showtype=list" class="col_show_list_tableadmin"><i class="fa-th-list"></i> 列表</a>
	<a href="./index.php?cloud=form.table_admin&showtype=user" class="col_show_list_tableadmin"><i class="fa-group"></i> 用户名</a>
	</div>';
}
if($authority == 1){
	$list='<table class="table table-striped table-bordered table-hover dataTable no-footer" role="grid" id="form_table_admin_table" style="width:100%" cellpadding="0" cellspacing="0">
            <tbody>
            '.$list.'
            </tbody>
        </table>';
}
if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td style="text-align:center;"><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}		
$module['list']=$list;
$module['class_name']=self::$config['class_name'];
$module['page']=cloudDigitPage($sum,$current_page,$page_size,'#'.$module['module_name']);


$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}

require($t_path);
