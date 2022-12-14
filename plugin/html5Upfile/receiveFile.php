<?php
header("Content-type:text/html; charset=utf-8");
$config=require_once '../../config.php';
$config['upload']['upAllowSuffix']=explode(',',$config['upload']['upAllowSuffix']);
require_once '../../config/functions.php';
$language=require_once '../../language/'.$config['web']['language'].'.php';
$timeoffset=($config['other']['timeoffset']>0)? "-".$config['other']['timeoffset']:str_replace("-","+",$config['other']['timeoffset']);
date_default_timezone_set("Etc/GMT$timeoffset");

function reset_save_name($name){
	$name=strtolower($name);
	$t=explode('.',$name);
	$post_fix=$t[count($t)-1];
	$forbidden=array('php','asp','jsp');
	if(in_array($post_fix,$forbidden)){$name.='_up';}
	$name=str_replace('.php.','.php_lock.',$name);
	$name=str_replace('.asp.','.asp_lock.',$name);
	$name=str_replace('.jsp.','.jsp_lock.',$name);
	return $name;
}



if(@$_GET['act']=='upfile'){
@session_start();
//if($_SESSION['html5Upfile_token']!=@$_GET['token']){exit('token err');}	
	
$dir=str_replace('//','/',trim(@$_GET['saveDir']).'/');
$dir="../../".$dir;
$dir=str_replace('//','/',$dir);
$dir=str_replace('/./','/',$dir);

if(!is_dir($dir)){
	exit("{'failedList':'".$dir." ".$language['not_exist_dir']."'}");
	}
$maxSize=trim(@$_GET['maxSize']);
$minSize=trim(@$_GET['minSize']);
$sourceName=trim(@$_GET['sourceName']);
$top_html5_suffix=explode("|",trim(@$_GET['top_html5_suffix']));
$failedList='';
$succeedList='';
$hiddenValue='';
$file_count=count($_FILES);
if($file_count==0){$failedList="<br />".$language['upload']['sys_post_max_size'].ini_get('post_max_size');}
$rename_suffix=array('php','asp','aspx','jsp');
$rename_suffix_after=array('php_up','asp_up','aspx_up','jsp_up');

for($i=0;$i<$file_count;$i++){
	$name=$_FILES['file_'.$i]['name'];
	if(is_uploaded_file($_FILES['file_'.$i]['tmp_name'])){
	$temp=explode('.',$name);
	$upfile_top_html5_suffix=strtolower($temp[count($temp)-1]);
	if(in_array($upfile_top_html5_suffix,$rename_suffix)){$upfile_top_html5_suffix.='_up';}
	//echo $upfile_top_html5_suffix;
	
	if(!in_array($upfile_top_html5_suffix,$config['upload']['upAllowSuffix']) && !in_array($upfile_top_html5_suffix,$rename_suffix_after) ){$failedList.=$name." (.".$upfile_top_html5_suffix.") ".$language['sys_forbidden_suffix']."<br />";continue;}
	if(!in_array($upfile_top_html5_suffix,$top_html5_suffix) && !in_array($upfile_top_html5_suffix,$rename_suffix_after) ){$failedList.=$name." (.".$upfile_top_html5_suffix.") ".$language['page_forbidden_suffix']."<br />";continue;}
	$file_size=ceil($_FILES['file_'.$i]["size"]/1024);
	if($maxSize<$file_size){$failedList.=$name." =".$file_size."KB ".$language['page_max_upload_size']." <b>.".$maxSize."KB</b>"."<br />";continue;}	
	if(is_numeric($minSize) && $minSize>$file_size){$failedList.=$name." =".$file_size."KB ".$language['page_min_upload_size']." <b>.".$minSize."KB</b>"."<br />";continue;}	
	$save_name=time().'_'.$i.'_'.rand(1000,9999).'.'.$upfile_top_html5_suffix;
	if($sourceName=='true'){
		$save_name=iconv("utf-8",$config['server']['os_charset'],$name);
		$save_name=reset_save_name($save_name);
	}
	if(@$_GET['dir_append_date']=='true'){$save_path=get_date_dir($dir);$save_path.=$save_name;}else{$save_path=$dir.$save_name;}
	move_uploaded_file($_FILES['file_'.$i]['tmp_name'],$save_path);
	$succeedList.=$name.'<br />';
	$hiddenValue.='|'.str_replace($dir,"",$save_path);
	}else{
		$failedList.=$name." ".$language['upload']['sys_upload_max_filesize'].ini_get('upload_max_filesize')."<br />";
	}
}	
echo "{'failedList':'$failedList','succeedList':'$succeedList','hiddenValue':'$hiddenValue'}";
exit();  
}
?>