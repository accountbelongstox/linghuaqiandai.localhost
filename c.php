<?php
header('Content-Type:text/html;charset=utf-8');
if(!isset($_GET)){
	exit();
}
if(isset($_GET["t"])){//table -- 表单
	Header("HTTP/1.1 303 See Other");
	$t=$_GET['t'];
	$url="./index.php?cloud=form.data_add&table_id=".$t;
	echo '<script type="text/javascript">window.location.href="'.$url.'"</script>';
	Header("Location: $url");
	exit("");
}

if(isset($_GET["q"])){//query --  查询
	Header("HTTP/1.1 303 See Other");
	$t=$_GET['t'];
	$url="./index.php?cloud=form.data_show_list&table_id=".$t;
	echo '<script type="text/javascript">window.location.href="'.$url.'"</script>';
	Header("Location: $url");
	exit("");
}

require_once './config/functions.php';
$config=require_once './config.php';
$language=require_once './language/'.$config['web']['language'].'.php';
$pdo=new  ConnectPDO();
$url="";
foreach($_GET as $key => $value){
	$url=$key;
	break;
}
$url=restoreUrl($url,$pdo);
//$fe1 = fsockopen($url2,80, $errno, $errstr, 30);
//echo $fe1;
//var_dump(shortUrl2("EcsTA4"));
//$re2=file_get_contents($url2);
Header("HTTP/1.1 303 See Other"); 
Header("Location: $url"); 
exit("");

$fp = fopen($url, 'r');  
//返回请求流信息（数组：请求状态，阻塞，返回值是否为空，返回值http头等）  

//需要解决token问题
$result="";
stream_get_meta_data($fp);  
while(!feof($fp)) {  
	$result .= fgets($fp, 1024);  
} 
echo $result;  
fclose($fp);  
?>