<?php
ini_set('session.save_path', dirname(__FILE__).'/session/');
//@ini_set('memory_limit', '128M'); 
  
//ini_set('session.cookie_lifetime', 18000);
//ini_set('session.gc_probability', 1);
//ini_set('session.gc_divisor', 1);
	function decrese_module_size($v,$number){
		$temp=explode('%',$v);
		if(isset($temp[1])){
			return ($temp[0]-1).'%';	
		}else{
			return ($temp[0]-$number).'px'; 
		}
	}
	function add_module_size($v,$number){
		$temp=explode('%',$v);
		if(isset($temp[1])){
			return ($temp[0]+1).'%';	
		}else{
			return ($temp[0]+$number).'px';
		}
	}

//正则提取邮箱（PHP代码/函数）	
function get_email_account($str){ 
	preg_match_all('/[a-zA-Z0-9_\.]+@[a-zA-Z0-9-]+[\.a-zA-Z]+/',$str,$r);
	$r=array_unique($r['0']);
	return $r; 
} 

//正则提取手机号（PHP代码/函数）	
function get_phone_account($str){ 
	preg_match_all('/1[0-9]{10}/',$str,$r);
	$r=array_unique($r['0']);
	return $r; 
} 

//判断mysql字段是否存在（PHP代码/函数）	
function field_exist($pdo,$table,$field){
	$exist=false;
	$sql="select `$field` from ".$table." limit 0,1";
	$r=$pdo->query($sql);
	if($pdo->errorCode()==00000){$exist=true;}
	return $exist;
}

//获取图片水印位置下接框（PHP代码/函数）	
function get_image_mark_option($v,$language){
	if($v){
		$option='<option value="1" selected>'.$language['yes'].'</option><option value="0">'.$language['no'].'</option>';
	}else{
		$option='<option value="1">'.$language['yes'].'</option><option value="0"  selected>'.$language['no'].'</option>';
	}
	return $option;
}

//判断访问设备是手机还是电脑（PHP代码/函数）	
function isMobile(){  
	$useragent=isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';  
	$useragent_commentsblock=preg_match('|\(.*?\)|',$useragent,$matches)>0?$matches[0]:'';  	  
	function CheckSubstrs($substrs,$text){  
		foreach($substrs as $substr)  
			if(false!==strpos($text,$substr)){  
				return true;  
			}  
			return false;  
	}
	$mobile_os_list=array('Google Wireless Transcoder','Windows CE','WindowsCE','Symbian','Android','armv6l','armv5','Mobile','CentOS','mowser','AvantGo','Opera Mobi','J2ME/MIDP','Smartphone','Go.Web','Palm','iPAQ');
	$mobile_token_list=array('Profile/MIDP','Configuration/CLDC-','160×160','176×220','240×240','240×320','320×240','UP.Browser','UP.Link','SymbianOS','PalmOS','PocketPC','SonyEricsson','Nokia','BlackBerry','Vodafone','BenQ','Novarra-Vision','Iris','NetFront','HTC_','Xda_','SAMSUNG-SGH','Wapaka','DoCoMo','iPhone','iPod');  
		  
	$found_mobile=CheckSubstrs($mobile_os_list,$useragent_commentsblock) ||  
			  CheckSubstrs($mobile_token_list,$useragent);  
		  
	if ($found_mobile){  
		return true;  
	}else{  
		return false;  
	}  
}



function stripslashes_deep($value) {
	 //$value=is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value); 
	 //return trim($value);
	if(!is_array($value)){
		$r=stripslashes($value);
	}else{
		$r=array();
		foreach($value as $key=>$v){
			$r[$key]=stripslashes($v);
		}		
	}
	
	return $r;
}
	 

function __autoload($className){
	$path='./lib/'.$className.'.class.php';
	if(file_exists($path)){require_once $path;}else{exit('Class <b>'.$className.'</b> not exists');}
	

	}

//正则判断是否邮箱email（PHP代码/函数）	
function is_email($email){ 
	$pattern="/^([\w\.-]+)@([a-zA-Z0-9-]+)(\.[a-zA-Z\.]+)$/i";//包含字母、数字、下划线_和点.的名字的email 
	if(preg_match($pattern,$email)){ 
		return true; 
	}else{ 
		return false; 
	} 
} 

//获取访问者IP（PHP代码/函数）	
function get_ip($isDev=false){
	if(getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
	  $ip=getenv("HTTP_CLIENT_IP");
	}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"),"unknown")){
	  $ip=getenv("HTTP_X_FORWARDED_FOR");
	}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
	  $ip=getenv("REMOTE_ADDR");
	}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'],"unknown")){
	  $ip=$_SERVER['REMOTE_ADDR'];
	}else{
	  $ip="unknown" ;  
	}
	return $isDev ? "47.245.30.190":safe_str($ip,1,0);  
}

//判断是否URL网址（PHP代码/函数）	
function is_url($v){
	$pattern="#(http|https)://(.*\.)?.*\..*#i";
	if(preg_match($pattern,$v)){ 
		return true; 
	}else{ 
		return false; 
	} 
}



//翻页（PHP代码/函数）	
function cloudDigitPage($sum,$current_page,$page_size,$touch_id='',$page_template='当前：{start}-{end}条,共{sum}条'){
	//$sum=1000;
	$page_sum=ceil($sum/$page_size);
	if($page_sum==1){return '';}
	$min_page=max($current_page-4,1);
	$max_page=min($current_page+4,$page_sum);
	if($current_page<5){$max_page=min($min_page+8,$page_sum);}
	if(($current_page+4)>$page_sum){$min_page=max($max_page-8,1);}
	
	$page_list='';
	
	
	for($i=$min_page;$i<=$max_page;$i++){
		if($i<10){
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_1'>{$i}</a></li>";
		}elseif($i<100){
			$page_figure=2;
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_2'>{$i}</a></li>";	
		}else{
			$page_figure=3;
			$page_list.="<li class='paginate_button'><a href='".replace_get('current_page',$i)."' id='page_".$i."' class='page_3'>{$i}</a></li>";
		}
		
			
	}
	if($current_page<10){$page_figure=1;}elseif($current_page<100){$page_figure=2;}else{$page_figure=3;}
	$page_list="<li class='paginate_button'><a href='".replace_get('current_page',max($current_page-1,1))."' id=page_pre><i class='fa fa-angle-left'></i></a></li>".$page_list."<li class='paginate_button'><a href='".replace_get('current_page',min($current_page+1,$page_sum))."' id=page_next><i class='fa fa-angle-right'></i></a></li>";
	
	$list="<div class='dataTables_paginate paging_simple_numbers'><ul class='pagination' id='cloudDigitPage' user_color='page'>{$page_list}</ul></div>";
	$touch_event='';
	if($touch_id!=''){
		$touch_event="		
		if(touchAble){
			//$('".$touch_id."').attr('ontouchstart','set_touch_start(event)');
			//$('".$touch_id."').attr('ontouchmove','exe_touch_move(event,\"cloud_page_go\")');
		}
";	
	}
	
	$list.="<script>
$(document).ready(function(){
	$('#cloudDigitPage #page_".$current_page."').parent().addClass('active');
	$('#current_page').prop('value','".$current_page."');
	$('#current_page').change(function(){
		id=$(this).attr('id');
		page_go(id);	
	});	
	$('#page_size').change(function(){
		id=$(this).attr('id');
		page_go(id);	
	});	
		".$touch_event."
		$(document).keydown(function(event){
			if(event.keyCode==37 && event.target.tagName!='INPUT' && event.target.tagName!='TEXTAREA'){cloud_page_go('left');}			  	
			if(event.keyCode==39 && event.target.tagName!='INPUT' && event.target.tagName!='TEXTAREA'){cloud_page_go('right');}			  	
		});		
	
});
function page_go(id){
			url=window.location.href;
			url=replace_get(url,id,$('#'+id).prop('value'));
			if(id=='page_size'){url=replace_get(url,'current_page',1);}
			//cloud_alert(url);
			window.location.href=url;	
}
	function cloud_page_go(v){
		url=window.location.href;
		c_page=get_param('current_page');
		if(c_page==''){c_page=1;}
		if(v!='left' && v!='right'){return false;}
		if(v=='left'){
			url=replace_get(url,'current_page',Math.max(1,c_page-1));
		}else{
			url=replace_get(url,'current_page',Math.min(".$page_sum.",parseInt(c_page)+1));
		}
		window.location.href=url;	
	}

</script>
";
	if($page_sum<2){return '';}
	if($current_page==1){$start=1;}else{$start=($current_page-1)*$page_size;}
	$temp=str_replace('{start}',1,$page_template);
	$temp=str_replace('{end}',$current_page*$page_size,$temp);
	$temp=str_replace('{sum}',$sum,$temp);
	$list='<div class=page_row><div>'.$temp.'</div><div>'.$list.'</div></div>';
	
	return $list;
}


//替换GET参数（PHP代码/函数）	
function replace_get($key,$v){
	$url=GetCurUrl();
	$temp=explode("&",$url);
	if(count($temp)==1){
		$symbol="?";
		$temp=explode("?",$url);
		if(count($temp)==1){return $url."?".$key."=".urlencode($v);}
	}else{
		$symbol="&";
	}
	$url='';
	for($i=0;$i<count($temp);$i++){
		$temp2=explode("=",$temp[$i]);
		if($temp2[0]!=$key){$url.=$temp[$i].$symbol;}
	}
	$url=trim($url,$symbol);
	$url.="&".$key."=".urlencode($v);
	return $url;
}

//获取当前网址URL（PHP代码/函数）	
function GetCurUrl(){ 
	if(!empty($_SERVER["REQUEST_URI"])){ 
		$scriptName=$_SERVER["REQUEST_URI"]; 
		$nowurl=$scriptName; 
	}else{ 
		$scriptName=$_SERVER["PHP_SELF"]; 
		if(empty($_SERVER["QUERY_STRING"])) { 
			$nowurl=$scriptName; 
		}else{ 
			$nowurl=$scriptName."?".$_SERVER["QUERY_STRING"]; 
		} 
	} 
	return $nowurl; 
} 

//获取选项ID 		
function get_select_id($pdo,$type,$v){
	$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	//$module[$type]="<option value=''></option>";
	$module[$type]="";
	foreach($stmt as $v){
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$module[$type].="<option value='".$v['id']."' $selected >".$v['name']."</option>";	
	}
	return $module[$type];			
}

//获取选项value 		
function get_select_value($pdo,$type,$v){
	$sql="select * from ".$pdo->index_pre."select where `type`='$type'";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	//$module[$type]="<option value=''></option>";
	$module[$type]="";
	foreach($stmt as $v){
		if($temp==$v['value']){$selected='selected';}else{$selected='';}
		$module[$type].="<option value='".$v['value']."' $selected >".$v['name']."</option>";	
	}
	return $module[$type];			
}

//多维数据排序
function multi_array_sort($multi_array,$sort_key,$sort=SORT_ASC){ 
	/*$multi_array = 需排序的数组 $sort_key => 作为条件的键值*/
	if(is_array($multi_array)){ 
		foreach ($multi_array as $row_array){
			if(is_array($row_array)){
				$key_array[] = $row_array[$sort_key]; 
			}else{ 
				return false; 
			} 
		} 
	}else{
		return false; 
	}
	array_multisort($key_array,$sort,$multi_array);
	return $multi_array; 
}
//获取用户组选项option 	）	
function get_group($pdo,$v){
	$sql="select `id`,`name` from ".$pdo->index_pre."group order by `sequence` desc";
	$stmt=$pdo->query($sql,2);
	$temp=$v;
	$list='';
	foreach($stmt as $v){
		if($temp==$v['id']){$selected='selected';}else{$selected='';}
		$list.="<option value='".$v['id']."' $selected >".$v['name']."</option>";	
	}
	return $list;			
}

//获取用户账户状态 	
function get_user_state($language,$user_state){
	$list='';
	foreach($language['user_state'] as $key=>$v){
		if($key==$user_state){$selected='selected';}else{$selected='';}
		$list.="<option value='".$key."' $selected >".$v."</option>";	
	}
	return $list;			
}

//获取选项值 		
function get_select_txt($pdo,$v){
	$sql="select `name` from ".$pdo->index_pre."select where `id`='$v'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];			
}

//获取模板所在目录 		
function get_template_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	return "templates/".$dir;	
}

//获取cloud_table.css路径 		
function get_cloud_table_css_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	$dir="./templates/".$dir;
	if(file_exists($dir.'cloud_table.css')){
		return $dir;	
	}else{
		$dir='./templates/index/'.$t[count($t)-3].'/'.$t[count($t)-2];
		if(file_exists($dir.'/cloud_table.css')){
			return $dir;
		}else{
			return './templates/index/default/'.$t[count($t)-2];
		}
	}
}

//获取cloud_table.js 路径 		
function get_cloud_table_js_dir($path){
	$t=str_replace(DIRECTORY_SEPARATOR,"/",$path);
	//echo $t;
	$t=explode("templates/",$t);
	$t=explode("/",$t[1]);
	$dir='';
	for($i=0;$i<count($t)-1;$i++){$dir.=$t[$i]."/";}
	$dir="./templates/".$dir;
	if(file_exists($dir.'cloud_table.js')){
		return $dir;	
	}else{
		$dir='./templates/index/'.$t[count($t)-3].'/'.$t[count($t)-2];
		if(file_exists($dir.'/cloud_table.js')){
			return $dir;
		}else{
			return './templates/index/default/'.$t[count($t)-2];
		}
	}
}

//获取用户名 		
function get_username($pdo,$id){
	$sql="select `username` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['username'];	
}

//检测用户名是否存在 		
function check_username($pdo,$username){
	$sql="select count(id) as c from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql)->fetch(2);	
	if($r['c']==1){return true;}else{return false;}
}

//获取用户真实姓名 		
function get_real_name($pdo,$id){
	$sql="select `real_name` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['real_name'];	
}

//获取用户ID 		
function get_user_id($pdo,$username){
	$sql="select `id` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['id'];	
}

//获取用户呢称 		
function get_nickname($pdo,$id){
	$sql="select `nickname` from ".$pdo->index_pre."user where `id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['nickname'];	
}

//获取用户所在用户组名称 		
function get_user_group_name($pdo,$username){
	$sql="select `group` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	$sql="select `name` from ".$pdo->index_pre."group where `id`='".$r['group']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];	
}

//格式化模板调用参数 返回数组 			
function format_attribute($args){
	$args=trim($args,'(');
	$args=trim($args,')');
	$temp=explode('|',$args);
	$attribute=array();
	foreach($temp as $v){
		$temp2=explode(':',$v);
		$attribute[$temp2[0]]=@$temp2[1];
		if($temp2[0]=='field'){
			$temp3=explode('/',@$temp2[1]);
			$temp4='';
			foreach($temp3 as $v3){
				$temp4.='`'.$v3.'`,';	
			}
			$temp4=trim($temp4,',');	
			$attribute[$temp2[0]]=$temp4;
		}
	}
	return $attribute;
}

//将数组再次格式化为字段 args

function ReArgsToString($args){
	$str="";
	foreach ($args as $key => $value) {
		if($key != ""){
		$str.="|".$key.":".$value;
		}
	}
	return $str;

}

//格式化字段 		
function get_field_array($v){
	$v=str_replace('`','',$v);
	$v=explode(',',$v);
	return $v;
}

//格式化字段为checkbox 		
function get_field_checkbox($checked,$all){
	$checked=str_replace('`','',$checked);
	$checked=explode(',',$checked);
	$checkbox='';
	foreach($all as $key=>$v){
		$state='';
		foreach($checked as $v2){
			if($v2==$key){$state='checked';break;}	
		}
		$checkbox.='<input type="checkbox" id="field[]" name="field[]" field=field value="'.$key.'" '.$state.' /> <span>'.$v.'</span> ';				
	}
	return $checkbox;
}

//是否匹配 正则（PHP代码/函数）		
function is_match($reg,$str){
	preg_match($reg,$str,$r);
	return (isset($r[0]))?true:false;
}

//返回所有匹配结果 正则（PHP代码/函数）		
function get_match_all($reg,$str){
	preg_match_all($reg,$str,$r);
	//var_dump($r);
	return @$r[1];
}

//返回单个匹配结果 正则（PHP代码/函数）
function get_match_single($reg,$str){
	preg_match($reg,$str,$r);
	return @$r[1];
}

//正则提取内容图片路径 		
function reg_attachd_img($act,$class_name,$imgs,$pdo,$image_mark=''){
	//var_dump($imgs);
	if($act=='add'){
		$config=require("./program/{$class_name}/config.php");
		$image=new image();
		
		
		$image_mark=($image_mark==='')?$config['program']['imageMark']:$image_mark;
		//var_dump($image_mark);
		foreach($imgs as $v){
			$sql="select count(id) as c from ".$pdo->index_pre."attachd_img where `path`='$v'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){
				$sql="insert into ".$pdo->index_pre."attachd_img (`path`) values ('$v')";
				$pdo->exec($sql);
				resize_big_image($image,$v);
				if($image_mark){$image->addMark($v);}
			}	
		}
	}
	if($act=='del'){
		//var_dump($imgs);
		if(!is_array($imgs)){
			$temp=explode('.',$imgs);
			if(strtolower($temp[count($temp)-1])=='php'){return false;}
			$sql="delete from ".$pdo->index_pre."attachd_img where `path`='$imgs'";
			$pdo->exec($sql);
			@safe_unlink($imgs);
		}else{
	 		foreach($imgs as $v){
				$temp=explode('.',$v);
				if(strtolower($temp[count($temp)-1])=='php'){continue;}
				$sql="delete from ".$pdo->index_pre."attachd_img where `path`='$v'";
				$pdo->exec($sql);
				@safe_unlink($v);	
			}	
		}
	}
}

function resize_big_image($image,$v){
	$width=1920;
	$info=$image->getInfo($v);
	//file_put_contents('t.txt',$info['width']);
	if($info['width']<$width){return true;}
	$zoom=$width/$info['width'];
	$height=$info['height']*$zoom;
	$image->thumb($v,$v,$width,$height);	
}


//PHP过虑禁用字符，入数据库前（PHP代码/函数）		
function safe_str($str,$replace_script=true,$allow_html=true){
	$array=array('receive.php','select','insert','update','delete','union','into','load_file','outfile','@SQL');
	if(!is_array($str)){
		foreach($array as $v){
			$str=preg_replace("#({$v})#iU","-\${1}-",$str);	
		}
		//$str=preg_replace("![][xX]([A-Fa-f0-9])!","x \${1}",$str);`
		$str=str_replace("'",'&#39;',$str);
		$str=str_replace('"','&#34;',$str);
		$str=str_replace("--",'- - ',$str);
		$str=str_replace("\*",'\-*',$str);
		$str=str_replace("\\",'cloud_backslash',$str);
		if($replace_script){
			$str = preg_replace("/<script/iUs", "<cloud_script", $str); 
			$str = preg_replace("/script>/iUs", "cloud_script>", $str); 
		}
		if(!$allow_html){$str=htmlspecialchars($str);}
		$r=$str;
	}else{
		$r=array();
		foreach($str as $key=>$value){
			//$key=safe_str($key);
			$r[$key]=safe_str($value,$replace_script,$allow_html);
		}		
	}
	
	return $r;
}

//PHP还原禁用字符，出数据库后（PHP代码/函数）		
function de_safe_str($str){
	$array=array('receive.php','select','insert','update','delete','union','into','load_file','outfile','@SQL','0x');
	if(!is_array($str)){
		foreach($array as $v){
			$str=preg_replace("#-({$v})-#i","\${1}",$str);	
		}
		//$str=preg_replace("![][xX]([A-Fa-f0-9])!","x \${1}",$str);
		$str=str_replace("&#39;","'",$str);
		$str=str_replace('&#34;','"',$str);
		$str=str_replace('- - ',"--",$str);
		$str=str_replace("\-*",'\*',$str);
		
		$str=str_replace('cloud_backslash',"\\",$str);
		$r=$str;
	}else{
		$r=array();
		foreach($str as $key=>$value){
			//$key=de_safe_str($key);
			$r[$key]=de_safe_str($value);
		}		
	}
	return $r;
}

//按年月日创建目录（PHP代码/函数）		
function get_date_dir($path){
	$path=trim($path,"/")."/";
	$Y=date("Y");
	$m=date("m");
	$d=date("d");
	if(!is_dir($path.$Y."_".$m)){mkdir($path.$Y."_".$m,0777, true);}
	if(!is_dir($path.$Y."_".$m."/".$d)){mkdir($path.$Y."_".$m."/".$d,0777, true);}
	return $path.$Y."_".$m."/".$d."/";	
}

//获取地区选项option 		
function get_area_option($pdo,$upid){
	$sql="select `id`,`name` from ".$pdo->index_pre."area where `upid`='$upid' order by `sequence` desc,`id` asc";	
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.$v['name'].'</option>';	
	}
	return $list;
}

//获取地区选项ids 		
function get_area_ids($pdo,$id){
	$sql="select `id` from ".$pdo->index_pre."area where `upid`='$id'";
	$r=$pdo->query($sql,2);
	$ids=$id.',';
	foreach($r as $v){
		$ids.=$v['id'].',';
		$sql2="select count(id) as c from ".$pdo->index_pre."area where `upid`='".$v['id']."'";	
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['c']>0){$ids.=get_area_ids($pdo,$v['id']);}
	}
	return $ids;
	
}

//获取年份选项option（PHP代码/函数）		
function get_year_option($year_range){
	$list='';
	$year_range=explode("-",$year_range);
	//var_dump($year_range);
	$start=intval($year_range[0]);
	$end=intval($year_range[1]);
	for($i=$start;$i<=$end;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取月份选项option（PHP代码/函数）		
function get_month_option(){
	$list='';
	for($i=1;$i<13;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取天数选项option（PHP代码/函数）		
function get_day_option($year,$month){
	$list='';
	for($i=1;$i<get_days($year,$month)+1;$i++){
		$list.='<option value="'.$i.'">'.$i.'</option>';	
	}
	return $list;	
}

//获取指定年月的天数（PHP代码/函数）		
function get_days($year,$month){
	return cal_days_in_month(CAL_GREGORIAN,$month,$year);
}

//获取地区名称 		
function get_area_name($pdo,$id){
	$list='';
	$flag=true;
	$v['upid']=$id;
	while($flag){
		
		$sql="select `upid`,`name`,`id` from ".$pdo->index_pre."area where `id`='".$v['upid']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		$list=$v['name']." ".$list;
		if($v['upid']==0){$flag=false;}
	}
	return $list;
}

//16进制转RGB （PHP代码/函数）		
function hex2rgb($hex){
	$hex=str_replace('#','',$hex);
	$length=strlen($hex);
	$rgb='';
	if($length==3){
		$rgb.=hexdec($hex[0].$hex[0]).',';
		$rgb.=hexdec($hex[1].$hex[1]).',';
		$rgb.=hexdec($hex[2].$hex[2]);
	}
	if($length==6){
		$rgb.=hexdec($hex[0].$hex[1]).',';
		$rgb.=hexdec($hex[2].$hex[3]).',';
		$rgb.=hexdec($hex[4].$hex[5]);
	}
	return $rgb;
}


//转换文件大小单位 （PHP代码/函数）		
function format_size($fileSize){
	if(!$fileSize){return false;}           
	$size=sprintf("%u ",$fileSize);           
	if($size==0){return( "0 Bytes ");}           
	$sizename=array( "Bytes","KB ","MB","GB","TB","PB","EB","ZB","YB");         
	return round($size/pow(1024,($i=floor(log($size,1024)))),2).$sizename[$i];   
}   

//查询可用短信余额 		
function inquiry_available_SMS($config){
	$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
		$param='';
		if($config['sms']['inquiry_method']=='GET'){
			$param.="&".$config['sms']['username_field']."=".$config['sms']['username'];
			$param.="&".$config['sms']['password_field']."=".$config['sms']['password'];
			$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
			if(strpos($config['sms']['available_url'],"?")==false){
				$url=$config['sms']['available_url']."?".trim($param,"&");	
			}else{
				$url=$config['sms']['available_url'].$param;	
			}
			$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
			//echo $url;
			$state=@file_get_contents($url,false,$ctx);
			$state=iconv($config['sms']['server_charset'],"utf-8",$state);
			$state=trim($state);
			return $state;
			//var_dump(strpos($state,$config['sms']['success_val']));
			
		}else{
			$post_data=array();  
			$post_data[$config['sms']['username_field']]=$config['sms']['username'];  
			$post_data[$config['sms']['password_field']]=$config['sms']['password'];  
			$o="";  
			foreach ($post_data as $k=>$v){$o.= "$k=".urlencode($v)."&";}  
			$post_data=substr($o,0,-1);  
			$ch=curl_init();  
			curl_setopt($ch, CURLOPT_POST, 1);  
			curl_setopt($ch, CURLOPT_HEADER, 0);  
			curl_setopt($ch, CURLOPT_URL,$config['sms']['available_url']);  
			//为了支持cookie  
			curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');  
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);  
			$state=curl_exec($ch);  
			
			//echo ",".$state;
			$state=iconv($config['sms']['server_charset'],"utf-8",$state);
			$state=trim($state);
			return $state;
		}
}

function getSmsPostUrl($config,$language,$phone/*手机地址*/,$content/*内容*/,$posttype/*发送类型 0,审核中,1,复审中,2,已通过,3,未通过*/,$sendtmpid=0/*如果用指定发送模板*/){/*解析出短信发送URL*/
	$arr = array();
	$posttype = intval($posttype);
	 switch ($posttype) {/*发送类型*/
	 	case 0://审核中
	 		$arr['tpl_id'] = @$config['sms']['examined_template_id'];
	 		break;
	 	case 1://复审中
	 		$arr['tpl_id'] = @$config['sms']['recheck_template_id'];
	 		break;
	 	case 2://已通过
	 		$arr['tpl_id'] = @$config['sms']['succeed_template_id'];
	 		break;
	 	case 3://未通过
	 		$arr['tpl_id'] = @$config['sms']['fail_template_id'];
	 		break;
	 	default:
	 		$arr['tpl_id'] = $sendtmpid;
	 		break;
	 }
	 $arr['tpl_id'] = intval($arr['tpl_id']);

	 if($arr['tpl_id'] < 0){
	 	return false;
	 }
	 $type = $config['sms']['sms_api'];//短信API类型
	 switch($type)
	 {
	 	case 'newsms_a':
 	/*聚合数据/*聚合数据http://v.juhe.cn/sms/send?mobile={phone}&tpl_id={tpl_id}&tpl_value=%23code%23%3D{code}&key={key}
	请求参数说明：
	名称	类型	必填	说明
	 	mobile	string	是	接收短信的手机号码
	 	tpl_id	int	是	短信模板ID，请参考个人中心短信模板设置
	 	tpl_value	string	是	变量名和变量值对，如：#code#=431515，整串值需要urlencode，比如正确结果为：%23code%23%3d431515。如果你的变量名或者变量值中带有#&=中的任意一个特殊符号，请先分别进行utf-8 urlencode编码后再传递，详细说明>
	 	key	string	是	应用APPKEY(应用详细页查询)
	 	dtype	string	否	返回数据的格式,xml或json，默认json
	返回参数说明：
	名称	类型	说明
	 	error_code	int	返回码
	 	reason	string	返回说明
	*/	
	 	$url="http://222.73.66.76:8000/sendsms.asp?Account=%s&Password=%s&Phones=%s&Content=%s&Channel=1";
		$Account = urlencode("hxtz");
		$Password = urlencode("abc123");
		$Phones = urlencode($phone);
		$Content = urlencode($content);
		$arr["url"] = sprintf($url, $Account, $Password, $Phones, $Content);
		
	 	break;
	 	case 'juhe':
 	/*聚合数据/*聚合数据http://v.juhe.cn/sms/send?mobile={phone}&tpl_id={tpl_id}&tpl_value=%23code%23%3D{code}&key={key}
	请求参数说明：
	名称	类型	必填	说明
	 	mobile	string	是	接收短信的手机号码
	 	tpl_id	int	是	短信模板ID，请参考个人中心短信模板设置
	 	tpl_value	string	是	变量名和变量值对，如：#code#=431515，整串值需要urlencode，比如正确结果为：%23code%23%3d431515。如果你的变量名或者变量值中带有#&=中的任意一个特殊符号，请先分别进行utf-8 urlencode编码后再传递，详细说明>
	 	key	string	是	应用APPKEY(应用详细页查询)
	 	dtype	string	否	返回数据的格式,xml或json，默认json
	返回参数说明：
	名称	类型	说明
	 	error_code	int	返回码
	 	reason	string	返回说明
	*/	
	 	 $arr["url"] = "http://v.juhe.cn/sms/send?mobile={phone}&tpl_id={tpl_id}&tpl_value=%23code%23%3D{code}&key={key}";
		 $arr["url"] = str_replace("{phone}", $phone, $arr["url"]);
		 $arr["url"] = str_replace("{tpl_id}", $arr['tpl_id'], $arr["url"]);
		 $arr["url"] = str_replace("{code}", $content, $arr["url"]);
		 $arr["url"] = str_replace("{key}", $config['sms']['sms_key'], $arr["url"]);
	 	break;
	 	case 'haoservice'://聚合数据
		/*好好数据 http://apis.haoservice.com/sms/send?mobile={phone}&tpl_id={tpl_id}&tpl_value=%23code%23%3D{code}&key={key}
		请求参数说明：
		 	mobile	string	是	接收短信的手机号码
		 	tpl_id	int	是	短信模板ID，请参考个人中心短信模板设置
		 	tpl_value	string	是	变量名和变量值对，如：#code#=431515，整串值需要urlencode，比如正确结果为：%23code%23%3d431515。如果你的变量名或者变量值中带有#&=中的任意一个特殊符号，请先分别进行utf-8 urlencode编码后再传递，详细说明>
		 	key	string	是	应用APPKEY(应用详细页查询)
		*/
	 	 $arr["url"] = "http://apis.haoservice.com/sms/send?mobile={phone}&tpl_id={tpl_id}&tpl_value=%23code%23%3D{code}&key={key}";
		 $arr["url"] = str_replace("{phone}", $phone, $arr["url"]);
		 $arr["url"] = str_replace("{tpl_id}", $arr['tpl_id'], $arr["url"]);
		 $arr["url"] = str_replace("{code}", $content, $arr["url"]);
		 $arr["url"] = str_replace("{key}", $config['sms']['sms_key'], $arr["url"]);
	 	break;
	 	default:
	 		return false;
	 	break;
	 }
	 return $arr["url"];
}

//调用发送短信 		
function send_sms($config,$language,$pdo,$id=0,$sendtmpid/*发送类型*/,$template_id=0){
	$id=intval($id);
	if($id==0){
		$sql="select * from ".$pdo->index_pre."phone_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."phone_msg where `id`='$id' and `state`='1'";
	}
   
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
		$r=de_safe_str($r);
		$ctx=stream_context_create(array('http'=>array('timeout'=>30)));

		$url = getSmsPostUrl($config,$language,$r['addressee'],$r['content'],$sendtmpid,$template_id/*通过getSmsPostUrl 直接取得发送的URL*/);
		//getSmsPostUrl($config,$language,$phone/*手机地址*/,$content/*内容*/,$posttype/*发送类型 0,审核中,1,复审中,2,已通过,3,未通过*/,$sendtmpid=0/*如果用指定发送模板*/)
		$state=@file_get_contents($url,false,$ctx);
		$state=trim($state);
		$send_state=match_result____($config['sms']['success_val'],$state);
		if($send_state){
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='2' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 return true;
		}else{
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='3' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 $title=str_replace('{web_name}',$config['web']['name'],$language['config_language']['sms']['fail_email_content']);
			 $content='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.config#sms';
			 $content=$language['config_language']['sms']['this_name'].' <a href='.$content.' >'.$content.'</a>';
			 //var_dump($language);
			 //file_put_contents('sms_fail_mail_title.txt',$title.'<br >'.$content);
			 email($config,$language,$pdo,'cloud',$config['sms']['fail_email'],$title,$content);
			 return false;
		}
	}
}

//PHP发送短信 		
function sms($config,$language,$pdo,$sender,$phone_number,$content){
	$time=time();
	$sql="insert into ".$pdo->index_pre."phone_msg (`sender`,`addressee`,`content`,`state`,`time`,`count`,`timing`) values ('$sender','".$phone_number."','".$content."','1','$time','1','0')";	
	//file_put_contents('t.txt',$sql);
	if($pdo->exec($sql)){
		return  send_sms($config,$language,$pdo,$pdo->lastInsertId(),2115);
	}else{
		return false;
	}
}

//获取邮件发件箱SMTP信息 		
function get_mail_info($pdo,$email,$id=0){
	if($id!=0){
		$sql="select * from ".$pdo->index_pre."smtp where `id`='$id'";
	}else{
		$temp=explode('@',$email);
		$postfix=$temp[1];
		$sql="select * from ".$pdo->index_pre."smtp where `postfix`='$postfix' order by `time` asc limit 0,1";	
	}
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	if(@$r['url']==''){
		$sql="select * from ".$pdo->index_pre."smtp order by `time` asc limit 0,1";	
		$r=$pdo->query($sql,2)->fetch(2);	
		$r=de_safe_str($r);
	}
	if($r['url']==''){return false;}
	
	$mail_info=$r['url']."|".$r['username']."|".$r['password'];
		$sql="update ".$pdo->index_pre."smtp set `time`=`time`+1 where `id`=".$r['id'];
		$pdo->exec($sql);
	return $mail_info;
}
//全自动直接发邮箱
function auto_send_email($pdo,$addressee,$title,$content,$sender){
	/*邮箱地址,邮箱标题,邮箱内容,发送者*/
	if($addressee != '' && $title !='' && $content != ''){
		$config=require("./config.php");
		$time=time();
		$sql="insert into ".$pdo->index_pre."email_msg (`sender`,`addressee`,`title`,`content`,`state`,`time`) values ('$sender','$addressee','".$title."','".$content."','1','".$time."')";	
		$pdo->exec($sql);
		send_email($config,$pdo,$pdo->lastInsertId());
	}
}

//调用发送邮件 		
function send_email($config,$pdo,$id=0){
	$id=intval($id);
	if($id==0){
		$sql="select * from ".$pdo->index_pre."email_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."email_msg where `id`='$id'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
			$r=de_safe_str($r);
			$path="./plugin/mail/class.phpmailer.php";
			if(!is_file($path)){$path="../plugin/mail/class.phpmailer.php";}
			if(!is_file($path)){$path="../../plugin/mail/class.phpmailer.php";}
			if(!is_file($path)){return false;}
			require_once($path);

			$sendmail_name=$_SESSION['user']['nickname'];
			if($sendmail_name=""){
				$sendmail_name=$config['web']['name'];
			}
			$result=sendmail($sendmail_name,$r['addressee'],$r['title'],$r['content'],get_mail_info($pdo,$r['addressee']));
			@ob_clean(); 
			@ob_end_flush(); 

			if($result){
				 $sql="update ".$pdo->index_pre."email_msg set `state`='2' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 return true;
			}else{
				 $sql="update ".$pdo->index_pre."email_msg set `state`='3' where `id`='".$r['id']."'";
				 $pdo->exec($sql);
				 return false;
			}
	
	}else{return false;}
	
}

//发送邮件 		
function email($config,$language,$pdo,$sender,$addressee,$title,$content){
	
	$sender=safe_str($sender);
	$addressee=safe_str($addressee);
	$title=safe_str($title);
	$content=safe_str($content);
	$time=time();
	$sql="insert into ".$pdo->index_pre."email_msg (`sender`,`addressee`,`title`,`content`,`state`,`time`) values ('$sender','$addressee','".$title."','".$content."','1','$time')";
	if($pdo->exec($sql)){
		return  send_email($config,$pdo,$pdo->lastInsertId());
	}else{
		return false;
	}

}

function return_selected($v,$v2){
	if($v==$v2){return "selected";}	
}

//年月日转 unixtime时间戳（PHP代码/函数）		
function get_unixtime($date,$date_style) {
	if($date_style[0]=='m'){
		$temp=explode($date_style[1],$date);
		$temp2=explode($date_style[1],$date);
		$temp[0]=$temp2[1];	
		$temp[1]=$temp2[0];	
		$date=implode($date_style[1],$temp);
	}
	$r=strtotime($date);
	if($r!=false){return $r;}
	try{$datetime= new DateTime($date);return $datetime->format('U');}catch(Exception $e){return 0;}
    
} 

//unixtime时间戳 转 年月日（PHP代码/函数）		
function get_date($unixtime,$date_style,$timeoffset) {
	if(!is_numeric($unixtime)){return '';};
	if($unixtime>-1 && $unixtime<2147472000){return date($date_style,$unixtime);}
	//echo "datetime_date";
    $time=$unixtime + $timeoffset * 3600;
    $datetime=new DateTime("@$time");
    return $datetime->format($date_style);
}

//年月日 转 年龄（PHP代码/函数）		
function get_age($birthday){
	if($birthday==0){return '';}
	$age=date("Y")-get_date($birthday,"Y",0);
	return $age;
}


//获取内容发布时间与当前的时差 		
function get_time($style,$timeoffset,$language,$time){
	if($time==0){return $language['none'];}
	$stime=$time;
	$time=time()-$time;
	if($time>43200){$time2=get_date($stime,$style,$timeoffset);}
	if($time<43200){$time2=floor($time/60/60).$language['hours_ago'];}
	if($time<3600){$time2=floor($time/60).$language['minutes_ago'];}
	if($time<60){$time2=floor($time).$language['seconds_ago'];}
	if($time<0){$time2=get_date($stime,$style,$timeoffset);}
	return $time2;
}


function uninstall_program($name){
	return true;
}

//操作用户余额 		
function operator_money($config,$language,$pdo,$username,$money,$reason,$program,$negative=false){
	//if($pdo=='' || $username=='' || $money=='' || $program==''){return false;}
	$sql="select `money` from ".$pdo->index_pre."user where `username`='$username'";
	$r=$pdo->query($sql,2)->fetch(2);
	$money=sprintf("%.2f",$money);
	$r['money']=sprintf("%.2f",$r['money']);
	$money=str_replace('+','',$money);
	$after_money=$r['money']+$money;
	$after_money=sprintf("%.2f",$after_money);
	if($after_money<0 && $negative==false){
		$money=str_replace('-','',$money);
		$_POST['operator_money_err_info']='<a href=/index.php?cloud=index.recharge&money='.$money.'&return_url='.urlencode(str_replace('&','|||',@$_SERVER['HTTP_REFERER'])).' id=please_recharge>'.$language['please'].$language['recharge'].'</a>';	
		return false;
	}
	$sql="update ".$pdo->index_pre."user set `money`=`money`+$money where `username`='$username'";
	//file_put_contents('./temp/test.txt',$sql);
	if($pdo->exec($sql)){
		$sql="insert into ".$pdo->index_pre."money_log (`time`,`username`,`money`,`reason`,`operator`,`program`,`before_money`,`after_money`,`ip`) values ('".time()."','$username','$money','$reason','".@$_SESSION['user']['username']."','$program','".$r['money']."','$after_money','".get_ip()."')";
		
		if(!$pdo->exec($sql)){
			$sql="update ".$pdo->index_pre."user set `money`=`money`+$money where `username`='$username'";
			if(!$pdo->exec($sql)){add_err_log($sql);}
			//echo 'err_1';
			return false;
		}
		if($money>0){
			push_money_add_info($pdo,$config,$language,$username,$reason,$money,$r['money']+$money);
		}else{
			push_money_deduction_info($pdo,$config,$language,$username,$reason,$money,$r['money']+$money);
		}
		
		
		
		return true;	
	}else{
		//echo 'err_2';
		return false;
	}
	
}


//记录出错SQL语句 		
function add_err_log($v){
	$err_log=require("./include/core/err_log.php");
	$config=require("./config.php");
	$err_log=get_date(time(),'Y-m-d H:i',$config['other']['timeoffset']).' '.str_replace("'",'&#39;',$v)."\r\n".$err_log;
	return file_put_contents('./include/core/err_log.php',"<?php return '$err_log'?>");
}

//更新用户充值状态 		
function update_recharge($pdo,$config,$language,$id){
	$id=floatval($id);
	$sql="select `state` from ".$pdo->index_pre."recharge where `in_id`='$id'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['state']==4){return true;}
	
	
	$sql="update ".$pdo->index_pre."recharge set `state`='4' where `in_id`='$id' and `state`='2'";
	if($pdo->exec($sql)){
		$sql="select `username`,`money` from ".$pdo->index_pre."recharge where `in_id`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username']!=''){
			if(operator_money($config,$language,$pdo,$r['username'],$r['money'],$language['recharge'],'index')===true){
				return true;
			}else{
				$sql="update ".$pdo->index_pre."recharge set `state`='2' where `in_id`='$id' and `state`='4'";
				if(!$pdo->exec($sql)){
					add_err_log($sql);	
				}
				return false;
			}
		}else{
			return true;
		}
	}else{
			return false;
	}


	
}


//获取程序中文名 		
function get_program_names($path=''){
	if($path==''){$path='./program/';}	
	$r=scandir($path);
	$lang=array();
	foreach($r as $key=>$v){
		if($v!='.' && $v!='..'){
			if(is_file($path.$v.'/config.php')){
				$config=require($path.$v.'/config.php');
				$language=require($path.$v.'/language/'.$config['program']['language'].'.php');
				$lang[$v]=$language['program_name'];	
			}
		}
			
	}
	return $lang;
	
}


//根据URL判断是否本地局域网访问（PHP代码/函数）		
function is_local($url){
	if(stristr($url,'localhost') || stristr($url,'127.') || stristr($url,'192.') ){
		return true;	
	}else{
		return false;	
	}	
}

//获取当前URL（PHP代码/函数）		
function get_url(){
	if(empty($_SERVER["REQUEST_URI"])){
		return $_SERVER["HTTP_HOST"].'?'.$_SERVER["QUERY_STRING"];
	}else{
		return $_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
	}
}

//获取cloud所在目录 		
function get_cloud_path(){
	$path=get_url();
	$path=explode('index.php',$path);
	if(count($path)==2){return 'http://'.$path[0];}
	$path=explode('receive.php',$path[0]);
	if(count($path)==2){return 'http://'.$path[0];}
	return 'http://'.$path[0];		
}

//跳转cloud所设网址 		
function go_domain($domain){
	if(!is_local($_SERVER['HTTP_HOST'])){
		if($_SERVER['HTTP_HOST']!=$domain){
			if(!is_file('./install_cloud.php')){
				$url=str_ireplace($_SERVER['HTTP_HOST'],$domain,get_url());
				header("location:http://".$url);	
			}else{
				header("location:./install_cloud.php");	
			}
		}	
	}
}


//解压ZIP压缩文件（PHP代码/函数）		
function extract_zip($path,$del_zip=true){
	$zip=new ZipArchive;
	if ($zip->open($path)=== TRUE) {
		$temp_dir='./temp_dir/'.md5(time().rand(999,9999));
		$zip->extractTo($temp_dir);
		$zip->close();
		if($del_zip){safe_unlink($path);}
		return $temp_dir;
	} else {
		return false;
	}
}

//检测cloud子程序使用权限 		
function program_permissions($config,$language,$program,$path){
	return true;
	$dir=new Dir();
	$_POST['files_size']=$dir->get_dir_size($path.'show/');
	$_POST['files_list']=$dir->show_dir($path.'show/',array('php'),false,false);
	$_POST['files_list']=implode('|',$_POST['files_list']);
	$_POST['files_list']=str_replace($path.'show/','',$_POST['files_list']);
	//echo $_POST['files_size'].','.$_POST['files_list'];

	if($program=='index'){return true;}
	$url=$config['server_url']."/receive.php?target=server::program_server&act=program_permissions&program=".$program."&site_id=".$config['web']['site_id']."&site_key=".$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST'].'&files_size='.$_POST['files_size'].'&files_list='.$_POST['files_list'].'&language='.$config['web']['language'];
	//echo $url;
	$c=@file_get_contents($url);
	//echo $c;
	if(trim($c)==1){return true;}else{return false;}
}

//检测cloud子程序安装包的完整性 		
function check_installation_files($path,$class){
	$files=array($class.'.class.php','config.php','icon.png','menu.php','pages.php','receive.class.php','install.php','uninstall.php');	
	$dirs=array('language','receive','show','install_templates');	
	$dir=new Dir();
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	if(is_dir($path.'/'.$class)){
		$r=scandir($path.'/'.$class);
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		$lack='';
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: '.$v.'<br />';}	
		}
		foreach($dirs as $v){
			if(!isset($dir_list[$v])){$lack.='Dir: '.$v.'<br />';}	
		}
		$_POST['files_size']=$dir->get_dir_size($path.'/'.$class.'/show/');
		$_POST['files_list']=$dir->show_dir($path.'/'.$class.'/show/',array('php'),false,false);
		$_POST['files_list']=implode('|',$_POST['files_list']);
		$_POST['files_list']=str_replace($path.'/'.$class.'/show/','',$_POST['files_list']);
		$_POST['get_config_info']=safe_get_config($path.'/'.$class.'/config.php');
	}else{
		return 'Dir: '.$class.'<br />';
	}
	if($del && is_dir($path)){
		$dir->del_dir($path);	
	}
	return $lack;
}

//检测cloud子程序升级包的完整性 		
function check_patch_files($path,$class){
	$files=array('upgrade.php','info.txt','uninstall.php');	
	$dirs=array('default');	
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	
	
	if(is_dir($path.'/patch')){
		$_POST['get_txt_info']=get_txt_info($path.'/patch/info.txt');
		$r=scandir($path.'/patch');
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		$lack='';
		foreach($dirs as $v){
			if(!is_dir($path.'/patch/'.$v)){$lack.='Dir: patch/'.$v.'<br />';}	
		}
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: patch/'.$v.'<br />';}	
		}
	}else{
		return 'Dir: patch<br />';
	}
	if($del && is_dir($path)){
		//echo $path;
		$dir=new Dir();
		$dir->del_dir($path);	
	}	
	return $lack;
}

//检测模板的使用权限 		
function template_permissions($config,$language,$program,$template,$path){
	return true;
	//if($template=='default'){return true;}
	//echo $path;
	$dir=new Dir();
	$_POST['files_size']=$dir->get_dir_size($path.'pc/img/');
	if(is_file($path.'pc/img/Thumbs.db')){$_POST['files_size']-=filesize($path.'pc/img/Thumbs.db'); }
	$_POST['files_list']=$dir->show_dir($path.'pc/img/',array('jpg','jpeg','png','gif'),false,false);
	$_POST['files_list']=implode('|',$_POST['files_list']);
	$_POST['files_list']=str_replace($path.'pc/img/','',$_POST['files_list']);
	//echo $_POST['files_size'].','.$_POST['files_list'];
	
	$url=$config['server_url']."/receive.php?target=server::template_server&act=template_permissions&program=".$program."&template=".$template."&site_id=".$config['web']['site_id']."&site_key=".$config['web']['site_key']."&domain=".$_SERVER['HTTP_HOST'].'&files_size='.$_POST['files_size'].'&files_list='.$_POST['files_list'].'&language='.$config['web']['language'];
	$c=@file_get_contents($url);
	//echo $c;
	if(trim($c)==1){return true;}else{return false;}
}

//检测模板的完整性 		
function check_template_files($path,$template,$program=''){
	//echo $template.','.$program;
	$files=array('icon.png','info.txt');	
	//$dirs=array('page_icon','pc','phone');
	$dirs=array('pc','phone');
	$dir=new Dir();	
	if(is_file($path)){
		$path=extract_zip($path,false);
		$del=true;
	}else{$del=false;}
	if(is_dir($path.'/'.$template)){
		$lack='';
		if(is_file($path.'/'.$template.'/info.txt') && $program!=''){
			//echo 'xx';
			$template_info=get_txt_info($path.'/'.$template.'/info.txt');
			
			if($template_info['for']!=$program){
				
				$lack.='The template and the program does not match<br />';	
			}
		}
		$r=scandir($path.'/'.$template);
		$dir_list=array();
		foreach($r as $v){
			$dir_list[$v]=$v;	
		}
		
		foreach($files as $v){
			if(!isset($dir_list[$v])){$lack.='File: '.$v.'<br />';}	
		}
		foreach($dirs as $v){
			if(!isset($dir_list[$v])){$lack.='Dir: '.$v.'<br />';}	
		}
				
		$_POST['files_size']=$dir->get_dir_size($path.'/'.$template.'/pc/img/');
		if(is_file($path.'/'.$template.'/pc/img/Thumbs.db')){$_POST['files_size']-=filesize($path.'/'.$template.'/pc/img/Thumbs.db'); }
		$_POST['files_list']=$dir->show_dir($path.'/'.$template.'/pc/img/',array('jpg','jpeg','png','gif'),false,false);
		$_POST['files_list']=@implode('|',$_POST['files_list']);
		$_POST['files_list']=str_replace($path.'/'.$template.'/pc/img/','',$_POST['files_list']);
		$_POST['get_txt_info']=get_txt_info($path.'/'.$template.'/info.txt');
		
	}else{
		return 'Dir: '.$template.'<br />';
	}
	if($del && is_dir($path)){
		$dir->del_dir($path);	
	}
	return $lack;
}

//判断密码是否合法 （PHP代码/函数）		
function is_passwd($v){
	$pattern="/^(\w){1,100}$/";
	if(preg_match($pattern,$v)){ 
		return true; 
	}else{ 
		return false; 
	} 
}


//清空文件的BOM头（PHP代码/函数）		
function clear_bom($str){
    $charset[1]= substr($str, 0, 1); 
    $charset[2] = substr($str, 1, 1); 
    $charset[3] = substr($str, 2, 1); 
    if(ord($charset[1])== 239 && ord($charset[2]) == 187 && ord($charset[3])== 191){$str=substr($str, 3);}
	return $str;
}

function get_txt_info($path){
	if(!is_file($path)){return false;}
	$info=file_get_contents($path);
	$info=clear_bom($info);
	$info=explode("\r\n",$info);
	$info=array_filter($info);
	$i=array();
	foreach($info as $i2){
		$temp=explode("=",$i2);	
		$i[trim($temp[0])]=@$temp[1];
	}
	return $i;
}

//自动给宽高加后缀 （PHP代码/函数）		
function add_px($v){
	$v2=floatval($v);
	$last=substr($v,strlen($v)-1);
	if($last=='x'){return $v2.'px';}
	if($last=='%'){return $v2.'%';}
	if($last=='m'){return $v2.'rem';}
	return $v2.'px';
}

//跳转到404页面 		
function not_find(){
	header('location:index.php?cloud=index.not_found');exit;
	echo('404');	
}

	function update_navigation_function($pdo){
		$proPath = "./program/index/";
		$config=require($proPath.'config.php');
		$language=require_once $proPath.'language/chinese_simplified.php';
		$one_max=$config['navigation_one_max'];
		$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->index_pre."navigation where `parent_id`=0 and `visible`=1 order by `sequence` desc";
		$r=$pdo->query($sql,2);
		$i=0;
		$list=array();
		$other='';
		$navigation_activeNumber = 0;
		foreach($r as $v){
			$navigation_activeNumber++;
			$navigation_active="navigation_active".$navigation_activeNumber;
			$temp='';
			if($i<$one_max){
				$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
					$icon='./program/index/navigation_icon/'.$v['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp='<a href="'.$v['url'].'" target="'.$v['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v['name'].'</span><i class="fa fa-angle-down"></i></a>';
					$temp2='';
				
					foreach($r2 as $v2){
						$temp3='';
						$sql3="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v2['id']."' and `visible`=1 order by `sequence` desc";
						$r3=$pdo->query($sql3,2);
							foreach($r3 as $v3){
								$icon='./program/index/navigation_icon/'.$v3['id'].'.png';
								if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
								$temp3.='<li class="'.$navigation_active.'"><a href="'.$v3['url'].'" target="'.$v3['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v3['name'].'</span></a></li>';
							}
						$icon='./program/index/navigation_icon/'.$v2['id'].'.png';
						if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
						if($temp3!=''){	
							if($temp3!=''){$temp3='<ul>'.$temp3.'</ul>';}	
						$temp2.='<li class="'.$navigation_active.'"><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v2['name'].'</span><i class="fa fa-angle-right"></i></a>'.$temp3.'</li>';							
						}else{
							$temp2.='<li class="'.$navigation_active.'"><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v2['name'].'</span></a></li>';
						}
					}
				if($temp2!=''){	
					if($temp2!=''){$temp2='<ul>'.$temp2.'</ul>';}
					$temp.=$temp2;	
				}else{
					$icon='./program/index/navigation_icon/'.$v['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp='<a href="'.$v['url'].'" target="'.$v['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v['name'].'</span></a>';
				}
				$list[$i]='<li class="'.$navigation_active.'">'.$temp.'</li>';	
				$i++;	
			}else{
	//--------------------------------------------------------------------------------------------------------------------------------more start					
				if(!isset($list[$one_max])){$list[$one_max]='';}
				$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
				$r2=$pdo->query($sql2,2);
				$temp='';
				$temp2='';
			
				foreach($r2 as $k2=>$v2){
					$icon='./program/index/navigation_icon/'.$v2['id'].'.png';
					if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
					$temp2.='<li><a href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v2['name'].'</span></a></li>';
				}
				$temp.=$temp2;	
				$icon='./program/index/navigation_icon/'.$v['id'].'.png';
				if(!is_file($icon)){$icon='./program/index/navigation_icon/default.png';}
				$list[$one_max].='<li><a href="'.$v['url'].'" target="'.$v['open_target'].'"><img class="receive_nav_img" src="'.$icon.'" /><span>'.$v['name'].'</span></a><ul>'.$temp.'</ul></li>';				
	//----------------------------------------------------------------------------------------------------------------------------------more end					
			}	
			
			
		}
		//var_dump($other);
		if($other!=''){$other='<li><a>'.$language['composite'].'</a><ul>'.$other.'</ul></li>';}
		if(!isset($list[$one_max])){$list[$one_max]='';}
		$list[$one_max]=$other.$list[$one_max];
		if($list[$one_max]!=''){
			$icon='./program/index/navigation_icon/more.png';
			$list[$one_max]='<li><a href="#"  id=more_admin><img class="receive_nav_img" src="'.$icon.'" /><span>'.$language['more'].'</span><i class="fa fa-angle-down"></i></a><ul>'.$list[$one_max].'</ul></li>';	
		}
		
		
		$str='';
		foreach($list as $k=>$v){
			$str.=$v;	
		}
		//echo $str;
		return file_put_contents('./program/index/navigation.txt',$str);
	}

//更新导航条静态数据  stop		
function update_navigation_txt($pdo){
	$sql="select `id`,`name`,`url`,`open_target`,`parent_id` from ".$pdo->index_pre."navigation where `parent_id`=0 and `visible`=1 order by `sequence` desc";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$v=de_safe_str($v);
		$navigation_1.='<a href="'.$v['url'].'" target="'.$v['open_target'].'" id="'.$v['id'].'"><img class="navigationimg" src="/program/index/navigation_icon/'.$v['id'].'.png" /><span>'.$v['name'].'</span></a>';	
		$sql2="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc";
		$r2=$pdo->query($sql2,2);
		$navigation_2_temp='';
		foreach($r2 as $v2){
			$v2=de_safe_str($v2);
			$navigation_2_temp.='<a href="'.$v2['url'].'" target="'.$v2['open_target'].'" id="'.$v2['id'].'"><img class="navigationimg" src="/program/index/navigation_icon/'.$v2['id'].'.png" /><span>'.$v2['name'].'</span></a>';	
			$sql3="select * from ".$pdo->index_pre."navigation where `parent_id`='".$v2['id']."' and `visible`=1 order by `sequence` desc";
			$r3=$pdo->query($sql3,2);
			$navigation_3_temp='';
			foreach($r3 as $v3){
				$v3=de_safe_str($v3);
				$navigation_3_temp.='<a href="'.$v3['url'].'" target="'.$v3['open_target'].'" id="'.$v3['id'].'"><img class="navigationimg" src="/program/index/navigation_icon/'.$v3['id'].'.png" /><span>'.$v3['name'].'</span></a>';	
			}
			if($navigation_3_temp!=''){$navigation_3.='<div class="navigation_3" id="'.$v2['id'].'_sub"><a class="for_touch" href="'.$v2['url'].'" target="'.$v2['open_target'].'"><img src="/program/index/navigation_icon/'.$v2['id'].'.png" /><span>'.$v2['name'].'</span></a>'.$navigation_3_temp.'</div>';}
		}
		if($navigation_2_temp!=''){$navigation_2.='<div class="navigation_2" id="'.$v['id'].'_sub"><a class="for_touch" href="'.$v['url'].'" target="'.$v['open_target'].'" ><img src="/program/index/navigation_icon/'.$v['id'].'.png" /><span>'.$v['name'].'</span></a>'.$navigation_2_temp.'</div>';}
	}
	if($navigation_1!=''){$navigation_1='<div id=navigation_bar><span id=navigation_start>&nbsp;</span><div class="navigation_1">'.$navigation_1.'</div><span id=navigation_end>&nbsp;</span></div>
';}
	return file_put_contents('./program/index/navigation.txt',$navigation_1.$navigation_2.$navigation_3);
}



//记录用户的访问设备 		
function set_device(){
	$device_array=array('pc','phone');
	//if(!isset($_COOKIE['cloud_device'])){$_COOKIE['cloud_device']=$device_array[0];return true;}
	
	if(isset($_GET['cloud_device']) && in_array(@$_GET['cloud_device'],$device_array)){	
		$_COOKIE['cloud_device']=$_GET['cloud_device'];
		//echo $_COOKIE['cloud_device'].'=cloud_device';
		return true;	
	}
	if(!in_array(@$_COOKIE['cloud_device'],$device_array)){
		$_COOKIE['cloud_device']=$device_array[0];
		return true;
	}
	if(isset($_COOKIE['cloud_device'])){return true;}
	
	$pc=array('Windows','Macintosh');
	$phone=array('Android','iPhone','iPod','BlackBerry','Windows Phone');
	foreach($pc as $v){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$v)!==false){$_COOKIE['cloud_device']='pc';break;}	
	}
	foreach($phone as $v){
		if(strpos($_SERVER['HTTP_USER_AGENT'],$v)!==false){$_COOKIE['cloud_device']='phone';break;}	
	}
	
	
	return false;
}

//删除cloud子程序的相关数据表 		
function del_program_table($pdo,$program){
	$sql="show tables like '".$pdo->sys_pre.$program."\_%'";
	//exit($sql);
	$r=$pdo->query($sql);
	foreach($r as $v) {
		$pdo->exec("DROP TABLE IF EXISTS `".$v[0]."`");
		//echo $v[0];
	}
	return true;
}

//导出mysql数据表 		
function output_table($pdo,$save_dir,$program='',$flag=1){
	set_time_limit(0);
    $mysql='cloud_sql_start';
	if($program!=''){
		$statments=$pdo->query("show tables like '".$pdo->sys_pre.$program."\_%'");	
	}else{
		$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	}
	$file_count=0;
	$save_dir.='/';
	$save_dir=str_replace('//','/',$save_dir.'/');
	$save_path=$save_dir.date('Y-m-d_H-i',time()).'_'.rand(100,99999).'__';
	$files=array();
    foreach ($statments as $value) {
        $table_name=$value[0];
        $mysql.="DROP TABLE IF EXISTS `$table_name`;m;o;n;\n\r";
        $table_query=$pdo->query("show create table `$table_name`");
        $create_sql=$table_query->fetch();
        $mysql.=$create_sql['Create Table'] .";m;o;n;\n\r";
        if ($flag != 0) {
            $iteams_query=$pdo->query("select * from `$table_name`");
            $values="";
            $items="";
			$i=0;
			
            while ($item_query=$iteams_query->fetch(PDO::FETCH_ASSOC)){ 
                $i++;
				$item_names=array_keys($item_query);
                $item_names=array_map("addslashes", $item_names);
                $items=join('`,`', $item_names); 
                $item_values=array_values($item_query);
                $item_values=array_map("addslashes", $item_values);
                $value_string=join("','", $item_values);
                $value_string="('" . $value_string . "'),";
                $values.="\n" . $value_string;
				
				if($i==50){
					$mysql.= "INSERT INTO `$table_name` (`$items`) VALUES" . rtrim($values, ",") . ";m;o;n;\n\r";
					$i=0;
					$items='';
					$values='';
				}
				if(strlen($mysql)>(1024*1024*10)){
					$file_count++;
					file_put_contents($save_path.$file_count.'.sql',$mysql);
					//echo $save_path.$file_count.'.sql'.'<br/>';
					$mysql='';
					$files[]=$save_path.$file_count.'.sql';	
				}
            }
            if ($values != "" && $i!=50) {
               $insert_sql="INSERT INTO `$table_name` (`$items`) VALUES" . rtrim($values, ",") . ";m;o;n;\n\r";
               $mysql.=$insert_sql;
             }
         }
      }
	  if($mysql!=''){
		  $file_count++;
		  file_put_contents($save_path.$file_count.'.sql',$mysql.'cloud_sql_end');
		  //echo $save_path.$file_count.'.sql'.'<br/>';
		  $mysql='';
		  $files[]=$save_path.$file_count.'.sql';
	  }elseif($file_count>0){
		  //echo $save_path.$file_count.'.sql<hr>';
		  file_put_contents($save_path.$file_count.'.sql',file_get_contents($save_path.$file_count.'.sql').'cloud_sql_end');
	  }
	  $_POST['output_table']=$files;
     return  true;
}

//获取本批数据备份文件名 		
function get_sql_series($path){
	 if(file_exists($path)){
		 $series=array();
		$i=get_match_single('/__(\d)\.sql/i',$path);
	   	$path_prefix=str_replace('__'.$i.'.sql','',$path);
	 	for($i=1;$i<1000;$i++){
			 $path=$path_prefix.'__'.($i).'.sql';
			// echo $path.',';
			  if(file_exists($path)){
				  $series[]=$path;
			  }else{break;}
		 }
		return $series;
	 }
	 return false;
}

//数据导入mysql 		
function input_table($pdo,$path,$auto=true){
	set_time_limit(0);
   if (file_exists($path)) {
	   $i=get_match_single('/__(\d)\.sql/i',$path);
	   if(is_numeric($i) && $auto){
		   $series=get_sql_series($path);
		  // var_dump( $series);
		   if(count($series)==0){$_POST['err_info']='lack_series_file';return false;}
		   if(strpos(file_get_contents($series[0]),'cloud_sql_start')===false){$_POST['err_info']='lack_series_file';return false;}
		   if(strpos(file_get_contents($series[count($series)-1]),'cloud_sql_end')===false){$_POST['err_info']='lack_series_file';return false;}
		   
		   foreach($series as $v){
			  $pdo=new  ConnectPDO();
			  input_table($pdo,$v,false);
		   }
		}else{
		   $sql_stream=file_get_contents($path);
		   $sql_stream=rtrim($sql_stream);
		   $sql_stream=trim($sql_stream,'cloud_sql_start');
		   $sql_stream=trim($sql_stream,'cloud_sql_end');
		   $sql_array=explode(";m;o;n;\n\r",$sql_stream);
		   array_filter($sql_array);
		  if(count($sql_array)==0){$_POST['err_info']='the_sql_is_not_for_cloud';return false;}
		   foreach ($sql_array as $value) {
			   if($value==''){continue;}
			   $pdo->exec($value);
		   }
		}
	 return true;  
	}
	return false;
}

//优化MYSQL数据库 		
function optimize_db($pdo){
	$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	foreach ($statments as $value) {
        $table_name=$value[0];
		$pdo->exec("OPTIMIZE TABLE `$table_name`");
	}
	return true;
}

//修复MYSQL数据库 		
function repair_db($pdo){
	$statments=$pdo->query("show tables like '".$pdo->sys_pre."%'");	
	foreach ($statments as $value) {
        $table_name=$value[0];
		$pdo->exec("REPAIR TABLE `$table_name`");
	}
	return true;
}



function safe_get_config($path){
	$str=file_get_contents($path);
	$str=explode(',',$str);
	$config=array();
	foreach($str as $key=>$v){
		trim($v);
		trim($v,'"');
		trim($v,"'");
		$temp=explode('=>',$v);
		if(isset($temp[1])){
			$temp[0]=trim($temp[0]);
			$temp[0]=trim($temp[0],'"');
			$temp[0]=trim($temp[0],"'");
			$temp[1]=trim($temp[1]);
			$temp[1]=trim($temp[1],'"');
			$temp[1]=trim($temp[1],"'");
			$config[$temp[0]]=$temp[1];	
		}	
	}
	return $config;
}

//转换文件大小单（PHP代码/函数）		
function formatSize($size){           
	//$size=sprintf("%u ",$size);           
	if($size==0){return( "0 Bytes ");}           
	$sizename=array(" Bytes"," KB"," MB"," GB"," TB"," PB"," EB"," ZB"," YB");         
	return round($size/pow(1024,($i=floor(log($size,1024)))),2).$sizename[$i];	   
}   

//文件直接下载 （PHP代码/函数）		
function file_download($file,$filename='')
{
	file_exists($file) or exit('文件不存在');
	$filename = $filename ? $filename : basename($file);
	$filetype = get_file_postfix($filename);
	$filesize = filesize($file);
	header('Cache-control: max-age=31536000');
	header('Expires: '.gmdate('D, d M Y H:i:s', time() + 31536000).' GMT');
	header('Content-Encoding: none');
	header('Content-Length: '.$filesize);
	header('Content-Disposition: attachment; filename='.$filename);
	header('Content-Type: '.$filetype);
	readfile($file);
	exit;
}

//获取文件后缀名（PHP代码/函数）		
function get_file_postfix($filename){return trim(substr(strrchr($filename, '.'),1));}

//文件路径转A链接（PHP代码/函数）		
function get_dir_link($dir,$href_pre){
	$temp=trim($dir,'/');
	$temp=explode('/',$temp);
	$deep=count($temp);
	$href='';
	$dir_link='';
	for($i=0;$i<$deep;$i++){
		if($temp[$i]==''){continue;}
		$href.=$temp[$i].'/';
		$dir_link.='<a href='.$href_pre.$href.'>'.$temp[$i].'</a> / ';	
	}
	return $dir_link;
}

function get_dir_path($path=null){
	if (!empty($path)) {
		if (strpos($path,'\\')!==false) {
			return substr($path,0,strrpos($path,'\\')).'/';
		} elseif (strpos($path,'/')!==false) {
			return substr($path,0,strrpos($path,'/')).'/';
		}
	}
	return './';
}

//启用用户的个人设置 		
function send_user_set_cookie($pdo){
	$sql="select * from ".$pdo->index_pre."user_set_item";
	$r=$pdo->query($sql,2);
	foreach($r as $v){
		$sql2="select `item_value` from ".$pdo->index_pre."user_set where `user_id`='".@$_SESSION['user']['id']."' and `item_variable`='".$v['variable']."'";
		$r2=$pdo->query($sql2,2)->fetch(2);
		if($r2['item_value']==''){
			$value=$v['default_value'];
			if($v['variable']=='user_set_color'){
				$sql="select `id` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
				$r3=$pdo->query($sql,2)->fetch(2);
				$value=$r3['id'];	
			}
		}else{
			$value=$r2['item_value'];
		}
		//var_dump($v['variable'].'='.$value);
		@setcookie($v['variable'],$value,0,'/');
	}				
}	

//浏览器直接查看数组 （PHP代码/函数）		
function cloud_var_dump($array){
	echo '<pre>';
	var_dump($array);
	echo '</pre>';	
}				

//更新同步程序的page.php文件 		
function update_pages_file($pdo,$id){
	clear_file_cache();
	if(is_numeric($id)){
		$sql="select * from ".$pdo->index_pre."page where `id`=$id";
	}else{
		$sql="select * from ".$pdo->index_pre."page where `url`='$id'";
	}
	
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['url']==''){return false;}
	$t=explode('.',$r['url']);
	if(!file_exists('./program/'.$t[0].'/pages.php')){return false;}
	$pages=require('./program/'.$t[0].'/pages.php');
	$pages[$r['url']]['layout']=$r['layout'];
	$pages[$r['url']]['head']=$r['head'];
	$pages[$r['url']]['left']=$r['left'];
	$pages[$r['url']]['right']=$r['right'];
	$pages[$r['url']]['full']=$r['full'];
	$pages[$r['url']]['bottom']=$r['bottom'];	
	$pages[$r['url']]['target']=$r['target'];	
	$pages[$r['url']]['tutorial']=$r['tutorial'];	
	$pages[$r['url']]['require_login']=$r['require_login'];	
	$pages[$r['url']]['url']=$r['url'];	
	if(file_put_contents('./program/'.$t[0].'/pages.php','<?php return '.var_export($pages,true).'?>')){
		return true;
	}else{
		return false;	
	}

}

//获取服务器支持文件最大上传大小 （PHP代码/函数）		
function get_upload_max_size(){
	return min(intval(get_cfg_var('upload_max_filesize')),intval(get_cfg_var('post_max_size')),intval(get_cfg_var('memory_limit')));	
}

//转HTML 换行（PHP代码/函数）		
function rn_to_br($v){
	$arr= array("\n", "\r", "\r\n");
	return str_replace($arr,"<br />",$v);
}

//清空临时文件 		
function clear_temp_file(){
	$path='./program/index/day.txt';
	if(is_file($path)){
		$day=file_get_contents($path);	
	}else{$day=date("d",time())-1;}
	if($day!=date("d",time())){
		$dir=new Dir();
		$dir->del_dir('./temp');
		$dir->del_dir('./temp_dir');
		$dir->del_dir('./cache');
		mkdir('./temp');
		mkdir('./temp_dir');
		mkdir('./cache');
		file_put_contents($path,date("d",time()));
	}	
}

//https_post提交（PHP代码/函数）		
function https_post($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url); 
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    if (curl_errno($curl)) {
       return 'Errno'.curl_error($curl);
    }
    curl_close($curl);
    return $result;
}

function request_post($url = '', $param = '') {
	if (empty($url) || empty($param)) {
		return false;
	}
	$postUrl = $url;
	$curlPost = $param;
	$ch = curl_init();//初始化curl
	curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
	curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
	curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
	$data = curl_exec($ch);//运行curl
	curl_close($ch);
	
	return $data;
}

function replace_str($key,$str){
	$temp1=explode(',',$key);
	foreach($temp1 as $v){
		$v=explode('==',$v);
		if(isset($v[1])){
			$str=str_replace($v[0],$v[1],$str);	
		}
	}
	return $str;
}

//CURL获取网页（PHP代码/函数）		
function curl_open($url){
	$ch = curl_init();  
	curl_setopt($ch, CURLOPT_URL, $url);  
	curl_setopt($ch, CURLOPT_HEADER, false);  
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.1 Safari/537.11');  	  
	$res = curl_exec($ch);  
	$rescode = curl_getinfo($ch, CURLINFO_HTTP_CODE);   
	curl_close($ch) ;  
	return $res;  
}

//获取图片绝对路径 采集图片用到（PHP代码/函数）		
function get_img_absolute_path($img_url,$page_url){
	if($img_url=='' || $page_url==''){return '';}
	if(stripos($img_url,'http')===false){
		$url=parse_url($page_url);
		$domain=$url['scheme'].'://'.$url['host'].'/';
		if(stripos($img_url,'/')===0){return $domain.trim($img_url,'/');}
		$dir=array();
		if(isset($url['path'])){
			$temp=explode('/',$url['path']);
			foreach($temp as $v){
				if($v!=''){
					if(stripos($v,'.')===false){$dir[]=$v;}
				}	
			}
		}
		if(substr_count($img_url,'../')==0 && count($dir)==0){return $domain.trim($img_url,'./');}
		$deep=count($dir)-substr_count($img_url,'../');
		//echo $deep;
		$path='';
		for($i=0;$i<$deep;$i++){
			$path.=$dir[$i].'/';	
		}
		$img_url=str_replace('../','',$img_url);
		return $domain.$path.trim($img_url,'./');
	}else{
		return $img_url;	
	}	
}
//加密部分内容(敏感信息，如:密码，用户名等...)（PHP代码/函数）
function encryption_str($str){
	if($str==''){return $str;}
	$length=mb_strlen($str,'utf-8');
	switch($length){
		case 1:
			return mb_substr($str,0,1,'utf-8');
			break;	
		case 2:
			return '*'.mb_substr($str,1,1,'utf-8');
			break;	
		case 3:
			return mb_substr($str,0,1,'utf-8').'*'.mb_substr($str,2,1,'utf-8');
			break;	
		case 4:
			return mb_substr($str,0,2,'utf-8').'*'.mb_substr($str,3,1,'utf-8');
			break;	
		case 5:
			return mb_substr($str,0,1,'utf-8').'**'.mb_substr($str,3,2,'utf-8');
			break;	
		case 6:
			return mb_substr($str,0,2,'utf-8').'**'.mb_substr($str,4,2,'utf-8');
			break;	
		case 7:
			return mb_substr($str,0,2,'utf-8').'***'.mb_substr($str,5,2,'utf-8');
			break;	
		case 8:
			return mb_substr($str,0,3,'utf-8').'****'.mb_substr($str,7,2,'utf-8');
			break;	
		case 9:
			return mb_substr($str,0,4,'utf-8').'****'.mb_substr($str,8,1,'utf-8');
			break;	
		case 10:
			return mb_substr($str,0,5,'utf-8').'****'.mb_substr($str,9,1,'utf-8');
			break;	
		case 11:
			return mb_substr($str,0,6,'utf-8').'****'.mb_substr($str,10,1,'utf-8');
			break;	
		default :
			return mb_substr($str,0,$length-8,'utf-8').'******'.mb_substr($str,$length-1,1,'utf-8');
	}	
}


function get_verification_code($length){
	$code="123456789"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}

	return $string;
}

function get_random_str($length){
	$code="ABCDEFGHIJKLMNOPQRSTUVWXYZ"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}
	return $string;
}
function get_random($length){
	$code="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"; //这是随机数
	$string=''; //定义一个空字符串
	for($i=0; $i<$length; $i++){ //codeNum为验证码的位数,一般为4
		$char=$code{mt_rand(0, strlen($code)-1)}; //随机数,如果$code{0}那就是2
		$string.=$char; //附加验证码符号到字符串
	}
	return $string;
}


function sms_frequency($pdo,$phone,$frequency=''){
	$phone=safe_str($phone);
	if($frequency==''){return true;}
	$temp=explode('/',$frequency);
	$frequency=array_filter($temp);
	foreach($frequency as $v){
		$temp=explode(':',$v);
		if(!isset($temp[1])){continue;}
		if(!is_numeric($temp[0]) || !is_numeric($temp[1])){continue;}
		$start=time()-$temp[0]*60;
		$sql="select count(id) as c from ".$pdo->index_pre."phone_msg where `time`>".$start." and `addressee`='".$phone."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']>$temp[1]){return false; }
	}
	return true;
}

function email_frequency($pdo,$email){
	$email=safe_str($email);
	$start=time()-300;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>2){return false; }
	$start=time()-600;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>3){return false; }
	$start=time()-3600;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>6){return false; }
	$start=time()-86400;
	$sql="select count(id) as c from ".$pdo->index_pre."email_msg where `time`>".$start." and `addressee`='".$email."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']>10){return false; }
	return true;

}

function oauth_bind($pdo,$user_id){
	$open_id=safe_str($_SESSION['oauth']['open_id']);

	if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
		$sql="select `openid` from ".$pdo->index_pre."user where `id`=".$user_id;
		$r3=$pdo->query($sql,2)->fetch(2);
		if($r3['openid']==''){
			$sql="update ".$pdo->index_pre."user set `openid`='".str_replace('wx:','',$open_id)."' where `id`=".$user_id;
			$pdo->exec($sql);
		}	
	}
	
	$sql="select `id` from ".$pdo->index_pre."oauth where `user_id`=".$user_id." and `open_id`='".$open_id."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']!=''){return true;}
	$sql="insert into ".$pdo->index_pre."oauth (`user_id`,`open_id`,`time`) values ('".$user_id."','".$open_id."','".time()."')";
	if($pdo->exec($sql)){return true;}else{return false;}
	
}


function oauth_login($pdo,$language,$config){
	$open_id=safe_str($_SESSION['oauth']['open_id']);
	$sql="select `user_id` from ".$pdo->index_pre."oauth where `open_id`='".$open_id."' limit 0,1";
	//echo $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['user_id']!=''){
		$user_id=$r['user_id'];		
	}else{
		return false;		
	}
	
	$sql="select {$pdo->index_pre}user.id as userid,{$pdo->index_pre}group.id as group_id,`nickname`,`username`,`name`,`page_power`,`function_power`,`state`,`icon`,`reg_oauth`,`recommendation`,`introducer` from ".$pdo->index_pre."user,".$pdo->index_pre."group where {$pdo->index_pre}user.id=".$user_id." and `group`=".$pdo->index_pre."group.id";
	//exit($sql);
	$stmt=$pdo->query($sql,2);
	$v=$stmt->fetch(2);	
	if($v==false){
		$sql="delete from ".$pdo->index_pre."oauth where `open_id`='".$open_id."'";
		$pdo->exec($sql);
		return false;
	}	
			
	if($v['state']!=1){
		exit($language['user_state'][$v['state']]);
		
	}else{
			
		if(strpos($_SESSION['oauth']['open_id'],'wx:')!==false){
			$sql="select `openid` from ".$pdo->index_pre."user where `id`=".$v['userid'];
			$r3=$pdo->query($sql,2)->fetch(2);
			if($r3['openid']==''){
				$sql="update ".$pdo->index_pre."user set `openid`='".str_replace('wx:','',$open_id)."' where `id`=".$v['userid'];
				$pdo->exec($sql);
			}	
			
		}
		push_login_info($pdo,$config,$language,$v['username']);
		login_credits($pdo,$config,$language,$v['userid'],$v['username'],$config['credits_set']['login'],$language['login_credits'],$config['other']['timeoffset']);
		if($v['recommendation']==''){
			$recommendation=$v['userid'].get_random_str(8-strlen($v['userid']));
			$sql="update ".$pdo->index_pre."user set `recommendation`='".$recommendation."' where `id`=".$v['userid'];
			$pdo->exec($sql);	
		}

		$_SESSION['user']['id']=$v['userid'];
		$_SESSION['user']['introducer']=$v['introducer'];
		$_SESSION['user']['username']=$v['username'];
		$_SESSION['user']['nickname']=$v['nickname'];
		$_SESSION['user']['icon']=$v['icon'];
		if($v['icon']==''){$_SESSION['user']['icon']='default.png';}
		$_SESSION['user']['group']=$v['name'];
		$_SESSION['user']['group_id']=$v['group_id'];
		$_SESSION['user']['page']=explode(",",$v['page_power']);
		$_SESSION['user']['function']=explode(",",$v['function_power']);
		setcookie("cloud_id",$v['userid'],0,'/');
		setcookie("cloud_nickname",$v['nickname'],0,'/');
		setcookie("cloud_icon",$_SESSION['user']['icon'],0,'/');
		if(in_array('index.edit_page_layout',$_SESSION['user']['function'])){
			//setcookie("edit_page_layout",'true',time() + 24 * 3600,'/',$_SERVER['HTTP_HOST']);	
			setcookie("edit_page_layout",'true',0,'/');	
		}
		//user_set cookie					
		send_user_set_cookie($pdo);
		$time=time();
		$ip=get_ip();
		$sql="update ".$pdo->index_pre."user set `last_time`='$time',`last_ip`='$ip' where `id`='".$_SESSION['user']['id']."'";
		$pdo->exec($sql);
		$sql="select count(id) as c from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['user']['id']."'";
		$stmt=$pdo->query($sql,2);
		$v=$stmt->fetch(2);
		if($v['c']<$config['other']['user_login_log']){
			$sql="insert into ".$pdo->index_pre."user_login (`userid`,`ip`,`time`) values ('".$_SESSION['user']['id']."','$ip','$time')";
		}else{
			$sql="select `id` from ".$pdo->index_pre."user_login where `userid`='".$_SESSION['user']['id']."' order by time asc limit 0,1";
			$stmt=$pdo->query($sql,2);
			$v=$stmt->fetch(2);
			$sql="update ".$pdo->index_pre."user_login set `ip`='$ip',`time`='$time' where `id`='".$v['id']."'";
		}
		$pdo->exec($sql);
		$sql="update ".$pdo->index_pre."user set `login_num`=login_num+1 where `id`='".$_SESSION['user']['id']."'";
		$pdo->exec($sql);
		$backurl=str_replace('|||','&',$_SESSION['oauth']['backurl']);
		$_SESSION['oauth']=array();

		//var_dump($_SESSION['oauth']['backurl']);
		if(@$_COOKIE['cloud_device']=='phone'){exit('<script>window.location.href="'.$backurl.'";</script>');}
		exit("<script>window.close();</script>");
		
		
	}
}

function get_ip_position($ip,$ak=''){
	return '';
	if($ak==''){
		//return file_get_contents('./get_position.php?ip='.$ip);	
	}else{
		//$r=file_get_contents('http://api.map.baidu.com/location/ip?ak='.$ak.'&ip='.$ip.'&coor=bd09ll');
		//$r=(json_decode($r,1));
		//if(isset($r['content']['address_detail']['city'])){return $r['content']['address_detail']['city'];}else{return '未知';}
	}
	
}

function operation_credits($pdo,$config,$language,$username,$number,$reason,$type='other'){
	if($number<1){
		$sql="select `credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		if(($r['credits']+$number)<1){return false;}
	}
	
	$sql="update ".$pdo->index_pre."user set `credits`=`credits`+".$number.",`cumulative_credits`=`cumulative_credits`+".$number." where `username`='".$username."'  limit 1";	
	if($number<0){
		if($type!='buy_return'){
			$sql="update ".$pdo->index_pre."user set `credits`=`credits`+".$number." where `username`='".$username."'  limit 1";		
		}	
	}
		

	if($pdo->exec($sql)){
		
		$time=time();
		$sql="insert into ".$pdo->index_pre."credits (`time`,`username`,`money`,`reason`,`type`) values ('".$time."','".$username."','".$number."','".$reason."','".$type."')";
		$pdo->exec($sql);
		$sql="select `credits` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		push_credits($pdo,$config,$language,$username,$type,$number,$r['credits']);
		if($number>0){group_auto_upgrade($pdo,$config,$language,$username);}
		return true;
	}else{
		return false;
	}	
}

function group_auto_upgrade($pdo,$config,$language,$username){
	$sql="select `cumulative_credits`,`group` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";	
	$user=$pdo->query($sql,2)->fetch(2);
	
	$sql="select `credits`,`name` from ".$pdo->index_pre."group where `id`='".$user['group']."'";
	$group=$pdo->query($sql,2)->fetch(2);
	if($group['credits']<0){return false;}
	
	$sql="select `id`,`credits`,`name` from ".$pdo->index_pre."group where `id`!=".$user['group']." and `credits`>".$group['credits']." and `credits`<".($user['cumulative_credits']+1)." order by `credits` desc limit 1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==1){return false;}
	if($r['id']!='' && $r['credits']>0){
		$sql="update ".$pdo->index_pre."user set `group`=".$r['id']." where `username`='".$username."' limit 1";
		$pdo->exec($sql);
		push_group_change($pdo,$config,$language,$username,$group['name'],$r['name']);	
	}
}

function login_credits($pdo,$config,$language,$userid,$username,$credits,$reason,$timeoffset){
	$time=time();
	$today=get_date($time,'Y-m-d',$timeoffset);
	$today=get_unixtime($today,'y-m-d');
	$sql="select `id` from ".$pdo->index_pre."user_login where `time`>".$today." and `userid`='".$userid."' limit 1";
	$t_r=$pdo->query($sql,2)->fetch(2);
	if($t_r['id']=='' && $credits>0){
		operation_credits($pdo,$config,$language,$username,$credits,$reason,'login');	
	}
}

function remain_time($language,$second){
	$day=floor($second/(3600*24));
	$second = $second%(3600*24);
	$hour = floor($second/3600);
	$second = $second%3600;
	$minute = floor($second/60);
	$second = $second%60;
	return $day.$language['d2'].$hour.$language['h'].$minute.$language['i'];
}

function clear_attribute_dot($v){
	$a=explode('.',$v);
	$i=0;
	$new='';
	foreach($a as $v){
		if($i==0){
			$new.=$v.'.';	
		}else{
			$new.=$v;	
		}
		$i++;	
	}
	return $new;
}

function write_err_log($path,$sql){
	$old=@file_get_contents($path);	
	$new=$sql."	".date('Y-m-d H:i',time())."\r\n ".$old;
	file_put_contents($path,$new);
}

function isWeiXin(){
	$v=strtolower($_SERVER['HTTP_USER_AGENT']);
	if(strpos($v,'micromessenger')===false){return false;}else{return true;}
}

function reset_weixin_info($wid,$pdo){
	$sql="update ".$pdo->sys_pre."weixin_account set `weixin_token`='' where `wid`='".$wid."' limit 1";
	$pdo->exec($sql);
	set_weixin_info($wid,$pdo);
	return get_weixin_info($wid,$pdo);
}

function set_weixin_info($wid,$pdo){
	$sql="select `AppId`,`AppSecret` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	if(@$r['AppSecret']==''){
		if(isset($_POST['AppSecret'])){
			$r['AppId']=$_POST['AppId'];
			$r['AppSecret']=$_POST['AppSecret'];
		}else{
			return false;		
		}		
	}
	$config=array();
	$token=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$r['AppId'].'&secret='.$r['AppSecret']);
	$token=json_decode($token,1);
	if(!isset($token['access_token'])){return false;}
	$ticket=file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token['access_token'].'&type=jsapi');
	//var_dump($ticket);
	$ticket=json_decode($ticket,1);	
	if(!isset($ticket['ticket'])){return false;}
	$_POST['cloud_weixin'][$wid]=array();
	$_POST['cloud_weixin'][$wid]['AppId']=$r['AppId'];
	$_POST['cloud_weixin'][$wid]['token']=$token['access_token'];
	$_POST['cloud_weixin'][$wid]['ticket']=$ticket['ticket'];
	$_POST['cloud_weixin'][$wid]['expires_in']=time()-60;
	$r=json_encode($_POST['cloud_weixin'][$wid]);
	$r=safe_str($r);
	$sql="update ".$pdo->sys_pre."weixin_account set `weixin_token`='".$r."' where `wid`='".$wid."' limit 1";
	$pdo->exec($sql);
	//echo $sql;
	$_POST['cloud_weixin'][$wid]['new']=date('Y-m-d H:i',time());
	return true;	
}

function set_weixin_info_ReAccess_token($wid,$pdo){
	$sql="select `AppId`,`AppSecret` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	if(@$r['AppSecret']==''){
		if(isset($_POST['AppSecret'])){
			$r['AppId']=$_POST['AppId'];
			$r['AppSecret']=$_POST['AppSecret'];
		}else{
			return false;		
		}		
	}
	$config=array();
	$token=file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$r['AppId'].'&secret='.$r['AppSecret']);
	$token=json_decode($token,1);
	if(!isset($token['access_token'])){return false;}
	$ticket=file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$token['access_token'].'&type=jsapi');
	//var_dump($ticket);
	$ticket=json_decode($ticket,1);	
	if(!isset($ticket['ticket'])){return false;}
	$_POST['cloud_weixin'][$wid]=array();
	$_POST['cloud_weixin'][$wid]['AppId']=$r['AppId'];
	$_POST['cloud_weixin'][$wid]['token']=$token['access_token'];
	$_POST['cloud_weixin'][$wid]['ticket']=$ticket['ticket'];
	$_POST['cloud_weixin'][$wid]['expires_in']=time()-60;
	$r=json_encode($_POST['cloud_weixin'][$wid]);
	$r=safe_str($r);
	$sql="update ".$pdo->sys_pre."weixin_account set `weixin_token`='".$r."' where `wid`='".$wid."' limit 1";
	$pdo->exec($sql);
	//echo $sql;
	$_POST['cloud_weixin'][$wid]['new']=date('Y-m-d H:i',time());
	return $token['access_token'];	
}

function get_weixin_info($wid,$pdo){
	if(isset($_POST['cloud_weixin'][$wid]['expires_in'])){if(time()<$_POST['cloud_weixin'][$wid]['expires_in']+3600){return true;}}
	$sql="select `weixin_token` from ".$pdo->sys_pre."weixin_account where `wid`='".$wid."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['weixin_token']==''){return set_weixin_info($wid,$pdo);}
	
	$r=de_safe_str($r);
	$r=json_decode($r['weixin_token'],1);
	if(count($r)==0){return set_weixin_info($wid,$pdo);}
	$_POST['cloud_weixin'][$wid]=array();
	foreach($r as $k=>$v){
		if($v==''){continue;}
		$_POST['cloud_weixin'][$wid][$k]=$v;	
	}
	//var_dump(date('Y-m-d H:i',$_POST['cloud_weixin'][$wid]['expires_in']));
	
	if(time()<$_POST['cloud_weixin'][$wid]['expires_in']+3600){return true;}else{return  set_weixin_info($wid,$pdo); }
		
}

function get_weixin_js_config($wid,$pdo){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['cloud_weixin'][$wid]['ticket'])){return false;}
	$_POST['weixin_js_config']['appId'] =$_POST['cloud_weixin'][$wid]['AppId'];
	$_POST['weixin_js_config']['timestamp'] = time();
	$_POST['weixin_js_config']['nonceStr'] = get_random_str(6);
	$_POST['weixin_js_config']['signature']=sha1(sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s",$_POST['cloud_weixin'][$wid]['ticket'], $_POST['weixin_js_config']['nonceStr'], $_POST['weixin_js_config']['timestamp'],'http://'.get_url()));
		
}

function get_user_openid($pdo,$username){
	$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['openid'];
}

function notice_app($pdo,$wid,$data){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['cloud_weixin'][$wid]['token'])){return false;}
	$r= https_post('https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$_POST['cloud_weixin'][$wid]['token'],$data);
	//file_put_contents('t.txt',$data.' '.$r);
	$r=json_decode($r,1);
	if($r['errcode']==0){return true;}else{set_weixin_info($wid,$pdo);return false;}
}

function get_weixin_template_id($pdo,$wid,$id){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['cloud_weixin'][$wid]['token'])){return false;}
	$data='{
           "template_id_short":"'.$id.'"
       }';
	$r= https_post('https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token='.$_POST['cloud_weixin'][$wid]['token'],$data);
	var_dump($r);
	$r=json_decode($r,1);
	if($r['errcode']==0){return $r['template_id'];}else{return false;}
}

function authcode_push($pdo,$config,$language,$username){
	$sql="select `id`,`email`,`phone`,`openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}
	$_SESSION['verification_code']=get_verification_code(6);
	switch($config['web']['authcode_push_mode']){
		case 'sms':
			authcode_push_sms($pdo,$config,$language,$r['phone'],$_SESSION['verification_code']);
			break;	
		case 'email':
			authcode_push_email($pdo,$config,$language,$r['email'],$_SESSION['verification_code']);
			break;	
		case 'openid':
			authcode_push_openid($pdo,$config,$language,$r['openid'],$_SESSION['verification_code']);
			break;	
	}
	return true;	
}
function other_push($pdo,$config,$language,$username,$email_data,$openid_data,$isDev){
	$sql="select `id`,`email`,`openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['id']==''){return false;}
	$state=false;
	switch($config['web']['other_push_mode']){
		case 'email':
			if($r['email']==''){$config['web']['other_push_mode']='openid';}else{
				$state=other_push_email($pdo,$config,$language,$r['email'],$email_data,$isDev);
				break;					
			}
		case 'openid':
			if($r['openid']!=''){
				$openid_data=str_replace('{openid}',$r['openid'],$openid_data);
				$state=notice_app($pdo,$config['web']['wid'],$openid_data);			
			}elseif($r['email']!=''){
				$state=other_push_email($pdo,$config,$language,$r['email'],$email_data,$isDev);
			}
			break;	
	}
	return $state;
}

function other_push_email($pdo,$config,$language,$email,$data,$isDev){
	if(!is_email($email)){return false;}
	if($isDev){
		return true;
	}
	//if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	if(email($config,$language,$pdo,'cloud',$email,$data['title'],$data['content'])){
		return true;
	}else{
		return false;
	}
}

function authcode_push_sms($pdo,$config,$language,$phone,$code){
	if(!is_match($config['other']['reg_phone'],$phone)){exit("{'state':'fail','info':'".$language['phone'].$language['pattern_err']."','key':'phone'}");}
	//if(sms_frequency($pdo,$phone,$config['sms']['frequency_limit'])==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	if(sms($config,$language,$pdo,'cloud',$phone,$code)){
		$success=str_replace('{device}',$language['phone'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".$language['fail']."'}"); 
	}
}

function authcode_push_email($pdo,$config,$language,$email,$code){
	if(!is_email($email)){exit("{'state':'fail','info':'".$language['email'].$language['pattern_err']."','key':'email'}");}
	//if(email_frequency($pdo,$email)==false){exit("{'state':'fail','info':'".$language['sms_frequent']."'}");}
	$title=$config['web']['name']."-".$language['authcode'];
	$content=$config['web']['name']."-".$language['authcode'].":".$_SESSION['verification_code'];		
	if(email($config,$language,$pdo,'cloud',$email,$title,$content)){
		$success=str_replace('{device}',$language['email'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".$language['fail']."'}"); 
	}
}

function authcode_push_openid($pdo,$config,$language,$openid,$code){
	$notice=array();
	$notice['touser']=$openid;
	$notice['template_id']=$config['openid_notice_template']['OPENTM203026900'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$code;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$language['verification_code_expires_in'];	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['verification_code_remark'];	
	$notice['data']['remark']['color']='#173177';
	$notice=json_encode($notice);
	if(notice_app($pdo,$config['web']['wid'],$notice)){
		$success=str_replace('{device}',$language['openid'],$language['verification_code_sent_notice']);
		exit("{'state':'success','info':'".$success."'}");
	}else{
		exit("{'state':'fail','info':'".$language['fail']."'}"); 
	}
}

function push_credits($pdo,$config,$language,$username,$type,$money,$balance){
	if($money>0){$money='+'.$money;}
	$notice=array();
	$notice['touser']='{openid}';	
	$notice['template_id']=$config['openid_notice_template']['TM00335'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.credits_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['account']=array();
	$notice['data']['account']['value']=$username;
	$notice['data']['account']['color']='#173177';	
	$notice['data']['time']=array();
	$notice['data']['time']['value']=date('Y-m-d H:i');	
	$notice['data']['time']['color']='#173177';	
	$notice['data']['type']=array();
	$notice['data']['type']['value']=$language['credits_type'][$type];	
	$notice['data']['type']['color']='#173177';
	$notice['data']['number']=array();
	$notice['data']['number']['value']=$money;	
	$notice['data']['number']['color']='#173177';
	$notice['data']['amount']=array();
	$notice['data']['amount']['value']=$balance;	
	$notice['data']['amount']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	$email=$notice['data'];
	$email['account']['label']=$language['username'];
	$email['time']['label']=$language['time'];
	$email['type']['label']=$language['type'];
	$email['number']['label']=$language['credits'];
	$email['amount']['label']=$language['user_money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['TM00335'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_audit($pdo,$config,$language,$username,$project,$state){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM205258520'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$username;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$project;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$state;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=date('Y-m-d H:i');	
	$notice['data']['keyword4']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['relist'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['username'];
	$email['keyword2']['label']=$language['content'];
	$email['keyword3']['label']=$language['state'];
	$email['keyword4']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM205258520'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	
	other_push($pdo,$config,$language,$username,$email_data,$notice);
	//notice_app($pdo,$config['web']['wid'],$notice);	
}
function push_group_change($pdo,$config,$language,$username,$old,$new){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['TM00891'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'];	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['grade1']=array();
	$notice['data']['grade1']['value']=$old;
	$notice['data']['grade1']['color']='#173177';	
	$notice['data']['grade2']=array();
	$notice['data']['grade2']['value']=$new;
	$notice['data']['grade2']['color']='#173177';
	$notice['data']['time']=array();
	$notice['data']['time']['value']=date('Y-m-d H:i');	
	$notice['data']['time']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['relist'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['grade1']['label']=$language['old_group'];
	$email['grade2']['label']=$language['new_group'];
	$email['time']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['TM00891'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	
	other_push($pdo,$config,$language,$username,$email_data,$notice);
	//notice_app($pdo,$config['web']['wid'],$notice);	
}

function push_money_add_info($pdo,$config,$language,$username,$reason,$money,$balance){
	$reason=strip_tags($reason);
	$balance=sprintf("%.2f",$balance);
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM207112032'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.money_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$reason;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$money;
	$notice['data']['keyword2']['color']='#173177';
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=date('Y-m-d H:i').' '.$language['balance'].': '.$balance;	
	$notice['data']['keyword3']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['reason'];
	$email['keyword2']['label']=$language['money'];
	$email['keyword3']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM207112032'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_money_deduction_info($pdo,$config,$language,$username,$reason,$money,$balance){
	$reason=strip_tags($reason);
	$balance=sprintf("%.2f",$balance);
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM204690186'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.money_log';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['verification_code_title']).' '.$username;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=date('Y-m-d H:i');	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$money;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$balance;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['reason'].':'.$reason;	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['time'];
	$email['keyword2']['label']=$language['money'];
	$email['keyword3']['label']=$language['balance'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM204690186'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}


function push_new_order_info($pdo,$config,$language,$username,$title,$shop_name,$goods_name,$money,$state,$id){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM200750297'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=mall.order_admin&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$shop_name;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=date('Y-m-d H:i',time());
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=$money;
	$notice['data']['keyword4']['color']='#173177';
	$notice['data']['keyword5']=array();
	$notice['data']['keyword5']['value']=$language['pay_state_option'][$state];
	$notice['data']['keyword5']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['shop_name'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['order_time'];
	$email['keyword4']['label']=$language['order_money'];
	$email['keyword5']['label']=$language['pay_state'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM200750297'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}


function push_cancel_order_info($pdo,$config,$language,$username,$title,$id,$money,$page,$goods_name){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM201490123'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud='.$page.'&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['order_money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM201490123'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_send_order_info($pdo,$config,$language,$username,$title,$id,$company,$code,$url){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM200565259'];	
	$notice['url']=$url;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$company;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$code;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['logistics_company'];
	$email['keyword3']['label']=$language['logistics_code'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM200565259'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}


function push_order_apply_refund_info($pdo,$config,$language,$username,$title,$goods_name,$money,$id,$reason){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM204146731'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=mall.order_admin&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$reason.' '.$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['money'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM204146731'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_order_agree_refund_info($pdo,$config,$language,$username,$title,$goods_name,$money,$id){
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM202849987'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=mall.my_order&search='.$id;	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=$title;	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$id;	
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=$goods_name;
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['keyword3']=array();
	$notice['data']['keyword3']['value']=$money;
	$notice['data']['keyword3']['color']='#173177';
	$notice['data']['keyword4']=array();
	$notice['data']['keyword4']['value']=date('Y-m-d H:i',time());
	$notice['data']['keyword4']['color']='#173177';
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['click_view_more'];	
	$notice['data']['remark']['color']='#173177';
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['orderid'];
	$email['keyword2']['label']=$language['goods_name'];
	$email['keyword3']['label']=$language['money'];
	$email['keyword3']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM202849987'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice);
}

function push_login_info($pdo,$config,$language,$username,$isDev){
	$notice=array();
	$notice=array();
	$notice['touser']='{openid}';
	$notice['template_id']=$config['openid_notice_template']['OPENTM201673425'];	
	$notice['url']='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.edit_user&field=password';	
	$notice['topcolor']='#FF0000';	
	$notice['data']=array();	
	$notice['data']['first']=array();	
	$notice['data']['first']['value']=str_replace('{webname}',$config['web']['name'],$language['login_notice_app_title']);	
	$notice['data']['first']['color']='#173177';	
	$notice['data']['keyword1']=array();
	$notice['data']['keyword1']['value']=$username;
	$notice['data']['keyword1']['color']='#173177';	
	$notice['data']['keyword2']=array();
	$notice['data']['keyword2']['value']=date('Y-m-d H:i',time());	
	$notice['data']['keyword2']['color']='#173177';	
	$notice['data']['remark']=array();
	$notice['data']['remark']['value']=$language['login_notice_app_remark'];	
	$notice['data']['remark']['color']='#173177';
	
	
	$email=$notice['data'];
	$email['keyword1']['label']=$language['username'];
	$email['keyword2']['label']=$language['time'];
	$email['remark']['value']='<a href='.$notice['url'].'>'.$email['remark']['value'].'</a>';
	$email_data=array();
	$email_data['title']=$config['web']['name'].' '.$language['config_language']['openid_notice_template']['OPENTM201673425'];
	$email_data['content']='';
	foreach($email as $v){
		$email_data['content'].='<tr><td>'.@$v['label'].'</td><td>'.$v['value'].'</td></tr>';		
	}
	$email_data['content']='<table width=50% style="margin:auto;">'.$email_data['content'].'</table>';
	
	$notice=json_encode($notice);
	other_push($pdo,$config,$language,$username,$email_data,$notice,$isDev);
}


function get_circle_option($pdo){
	$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`=0 and `visible`=1 order by `sequence` desc,`id` asc";
	$r=$pdo->query($sql,2);
	$list='';
	foreach($r as $v){
		$list.='<option value="'.$v['id'].'">'.de_safe_str($v['name']).'</option>';
		$sql="select `id`,`name` from ".$pdo->index_pre."circle where `parent_id`='".$v['id']."' and `visible`=1 order by `sequence` desc,`id` asc";
		$r2=$pdo->query($sql,2);
		foreach($r2 as $v2){
			$list.='<option value="'.$v2['id'].'">&nbsp;&nbsp;'.de_safe_str($v2['name']).'</option>';	
		}
	}
	return $list;
}

function get_circle_ids($pdo,$circle){
	$sql="select `id` from ".$pdo->index_pre."circle where `parent_id`=".$circle;
	$r=$pdo->query($sql,2);
	$circle.=',';
	foreach($r as $v){
		$circle.=$v['id'].',';	
	}
	return trim($circle,',');
}

function get_circle_name($pdo,$circle){
	$sql="select `name` from ".$pdo->index_pre."circle where `id`=".$circle;
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['name'];
}

function get_color_array($pdo){
	if(isset($_COOKIE['user_set_color']) && intval($_COOKIE['user_set_color'])>0){
		$sql="select `data` from ".$pdo->index_pre."color where `id`=".intval($_COOKIE['user_set_color']);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['data']==''){
			$sql="select `data` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}	
	}else{
		$sql="select `data` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);		
	}
	if($r['data']==''){return '';}
	//var_dump(de_safe_str($r['data']));
	$color=json_decode(de_safe_str($r['data']),1);
	//var_dump($color);
	return 	$color;
}
function get_color_data($pdo){
	if(isset($_COOKIE['user_set_color']) && intval($_COOKIE['user_set_color'])>0){
		$sql="select `data` from ".$pdo->index_pre."color where `id`=".intval($_COOKIE['user_set_color']);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['data']==''){
			$sql="select `data` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
			$r=$pdo->query($sql,2)->fetch(2);
		}	
	}else{
		$sql="select `data` from ".$pdo->index_pre."color order by `sequence` desc limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);		
	}
	if($r['data']==''){return '';}
	//var_dump(de_safe_str($r['data']));
	$color=json_decode(de_safe_str($r['data']),1);
	//var_dump($color);
	return 	color_to_css($color);
}

function color_to_css($color){
	$css="<style>
		[user_color='head']{ border-color:".$color['head']['border']."; background:".$color['head']['background']."; color:".$color['head']['text'].";}
		[user_color='head'] a{color:".$color['head']['text'].";}
		[user_color='head'] input,[user_color='head'] select,[user_color='head'] textarea{background:".$color['head']['background']."; color:".$color['head']['text'].";}

		[user_color='container'],#mall_layout{ border-color:".@$color['container']['border']."; background:".$color['container']['background']."; color:".$color['container']['text'].";}
		
		[user_color='container'] a,#mall_layout a{ color:".$color['container']['text'].";}
		.sum_card .card_head{background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		[user_color='shape_head']{ border-color:".$color['shape_head']['border']."; background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		[user_color='shape_head'] a{color:".$color['shape_head']['text'].";}
		[user_color='shape_head'] input,[user_color='shape_head'] select,[user_color='shape_head'] textarea{background:".$color['shape_head']['background']."; color:".$color['shape_head']['text'].";}
		.caption{color:".$color['shape_head']['background']."; }
		[user_color='shape_bottom']{ border-color:".$color['shape_bottom']['border']."; background:".$color['shape_bottom']['background']."; color:".$color['shape_bottom']['text'].";}
		[user_color='shape_bottom'] a{  color:".$color['shape_bottom']['text'].";}
		[user_color='shape_bottom'] input,[user_color='shape_bottom'] select,[user_color='shape_bottom'] textarea{background:".$color['shape_bottom']['background']."; color:".$color['shape_bottom']['text'].";}

		[user_color='nv_1']{ border-color:".$color['nv_1']['border']."; background:".$color['nv_1']['background']."; color:".$color['nv_1']['text'].";}
		[user_color='nv_1'] > a{ border-color:".$color['nv_1']['border']."; background:".$color['nv_1']['background']."; color:".$color['nv_1']['text'].";}
		[user_color='nv_1']:hover{ border-color:".$color['nv_1_hover']['border']."; background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		.dropdown-menu li:hover{background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		.dropdown-menu li:hover a{color:".$color['nv_1_hover']['text'].";}

		[user_color='nv_1']:hover a{ border-color:".$color['nv_1_hover']['border']."; background:".$color['nv_1_hover']['background']."; color:".$color['nv_1_hover']['text'].";}
		[user_color='nv_2']{ border-color:".$color['nv_2']['border']."; background:".$color['nv_2']['background']."; color:".$color['nv_2']['text'].";}
		[user_color='nv_2']>a{ border-color:".$color['nv_2']['border']."; background:".$color['nv_2']['background']."; color:".$color['nv_2']['text'].";}
		[user_color='nv_2']:hover{ border-color:".$color['nv_2_hover']['border']."; background:".$color['nv_2_hover']['background']."; color:".$color['nv_2_hover']['text'].";}
		[user_color='nv_2']:hover a{ border-color:".$color['nv_2_hover']['border']."; background:".$color['nv_2_hover']['background']."; color:".$color['nv_2_hover']['text'].";}
		[user_color='nv_3']{ border-color:".$color['nv_3']['border']."; background:".$color['nv_3']['background']."; color:".$color['nv_3']['text'].";}
		[user_color='nv_3']>a{ border-color:".$color['nv_3']['border']."; background:".$color['nv_3']['background']."; color:".$color['nv_3']['text'].";}
		[user_color='nv_3']:hover{ border-color:".$color['nv_3_hover']['border']."; background:".$color['nv_3_hover']['background']."; color:".$color['nv_3_hover']['text'].";}
		[user_color='nv_3']:hover a{ border-color:".$color['nv_3_hover']['border']."; background:".$color['nv_3_hover']['background']."; color:".$color['nv_3_hover']['text'].";}

		
		[user_color='container'] [cloud-module]{ border-color:".$color['module']['border']."; background:".$color['module']['background']."; color:".$color['module']['text'].";}
		[user_color='container'] [cloud-module] a{ color:".$color['module']['text'].";}
		[user_color='container'] [cloud-module] input,[user_color='container'] [cloud-module] select,[user_color='container'] [cloud-module] textarea{background:".$color['module']['background']."; color:".$color['module']['text'].";}
		.portlet{box-shadow: 0px 2px 5px 2px ".$color['module']['border'].";}
		
		.table_scroll table{ border-color:".$color['table']['border'].";  background:".$color['table']['thead_background']."; color:".$color['table']['thead_text'].";}
		.table_scroll{ border:1px solid ".$color['table']['border'].";}
		.table_scroll table tr td{ border-color:".$color['table']['border']."; }
		.table_scroll table thead{ border-color:".$color['table']['border']."; background:".$color['table']['thead_background']."; color:".$color['table']['thead_text'].";}
		.table_scroll table thead a{ color:".$color['table']['thead_text'].";}
		
		.table_scroll table tbody tr:nth-of-type(odd){ border-color:".$color['table']['border']."; background:".$color['table']['odd_background']."; color:".$color['table']['odd_text'].";}
		.table_scroll table tbody tr:nth-of-type(odd) input,.table_scroll table tbody tr:nth-of-type(odd) select,.table_scroll table tbody tr:nth-of-type(odd) textarea{  background:".$color['table']['odd_background']."; color:".$color['table']['odd_text'].";}
		.table_scroll table tbody tr:nth-of-type(odd) a{  color:".$color['table']['odd_text'].";}
		
		.table_scroll table tbody tr:nth-of-type(even){ border-color:".$color['table']['border']."; background:".$color['table']['even_background']."; color:".$color['table']['even_text'].";}
		.table_scroll table tbody tr:nth-of-type(even) input,.table_scroll table tbody tr:nth-of-type(even) select,.table_scroll table tbody tr:nth-of-type(even) textarea{  background:".$color['table']['even_background']."; color:".$color['table']['even_text'].";}
		.table_scroll table tbody tr:nth-of-type(even) a{color:".$color['table']['even_text'].";}
		
		.table_scroll table tbody tr:hover{ border-color:".$color['table']['border']."; background:".$color['table']['hover_background']."; color:".$color['table']['hover_text'].";}
		.table_scroll table tbody tr:hover a{ color:".$color['table']['hover_text'].";}

		.container [user_color='page']{ border-color:".$color['page']['border']."; background:".$color['page']['background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] a{ border-color:".$color['page']['border']."; background:".$color['page']['background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] a:hover{ border-color:".$color['page']['border']."; background:".$color['page']['hover_background']."; color:".$color['page']['text'].";}
		.container [user_color='page'] .active a{ border-color:".$color['page']['border']."; background:".$color['page']['current_background']."; color:".$color['page']['current_text'].";}
		.container [user_color='page'] .active:hover a{ border-color:".$color['page']['border']."; background:".$color['page']['current_background']."; color:".$color['page']['current_text'].";}
		
		.container [user_color='button'],.submit,#submit,.add,.btn,.replace,.increase,#add{ border-color:".$color['button']['border']."; background:".$color['button']['background']."; color:".$color['button']['text'].";}
		.container [user_color='button']:hover,.submit:hover,#submit:hover,.add:hover,.replace:hover,.increase:hover,#add:hover{border-color:".$color['button_hover']['border']."; background:".$color['button_hover']['background']."; color:".$color['button_hover']['text'].";}
		.container [user_color='button'] .view{color:".$color['button_hover']['text'].";}
		
		#icons li a img{ border-color:".$color['button']['border']."; background:".$color['button']['background']."; color:".$color['button']['text'].";}
		#icons li a img:hover{border-color:".$color['button_hover']['border']."; background:".$color['button_hover']['background']."; color:".$color['button_hover']['text'].";}
		
	</style>";
	return $css;
}
	
function send_info_to_openid($pdo,$wid,$username,$content){
	get_weixin_info($wid,$pdo);
	if(!isset($_POST['cloud_weixin'][$wid]['token'])){return false;}
	$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['openid']==''){return false;}
	$v='{
"touser":"'.de_safe_str($r['openid']).'",
"msgtype":"text",
"text":
{
	 "content":"'.$content.'"
}
}  ';
	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$_POST['cloud_weixin'][$wid]['token'];
	$r=https_post($url,$v);
	$r=json_decode($r,1);
	if($r['errcode']!=0){return $r['errmsg'];}else{return true;}

}	

function get_distance($lat1, $lng1, $lat2, $lng2){ 
	$earthRadius = 6367000; 
	$lat1 = ($lat1 * pi() ) / 180; 
	$lng1 = ($lng1 * pi() ) / 180; 
	$lat2 = ($lat2 * pi() ) / 180; 
	$lng2 = ($lng2 * pi() ) / 180; 
	$calcLongitude = $lng2 - $lng1; 
	$calcLatitude = $lat2 - $lat1; 
	$stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2); 
	$stepTwo = 2 * asin(min(1, sqrt($stepOne))); 
	$calculatedDistance = $earthRadius * $stepTwo; 
	return round($calculatedDistance); 
} 

function format_distance($v){
	if($v>999){
		return sprintf("%.1f",($v/1000)).'km';
	}else{
		return $v.'m';
	}
	return $v;
}

function safe_order_by($v){
	$v=explode("|",$v);
	if(strlen($v[0])>10){$v[0]='id';}	
	if($v[1]!='asc'){$v[1]='desc';}	
	return $v;
}


  //GCJ-02(火星，高德) 坐标转换成 BD-09(百度) 坐标
  	//@param bd_lon 百度经度
    //@param bd_lat 百度纬度
  function bd_encrypt($gg_lon,$gg_lat){
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $gg_lon;
    $y = $gg_lat;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['0'] = $z * cos($theta) + 0.0065;
    $data['1'] = $z * sin($theta) + 0.006;
    return $data;
  }
  //BD-09(百度) 坐标转换成  GCJ-02(火星，高德) 坐标
  	//@param bd_lon 百度经度
    //@param bd_lat 百度纬度
  function bd_decrypt($bd_lon,$bd_lat){
    $x_pi = 3.14159265358979324 * 3000.0 / 180.0;
    $x = $bd_lon - 0.0065;
    $y = $bd_lat - 0.006;
    $z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
    $theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
    $data['0'] = $z * cos($theta);
    $data['1'] = $z * sin($theta);
    return $data;
  }
  
  function t_browser($v){
	  $v[0]=$v[0]+0.005;
	  $v[1]=$v[1]+0.005;
	  return $v;
	}
	
	function set_sql_cache($config,$sql,$c){
		if(!$config['cache']['sql_cache_switch']){return false;}
		$key=md5($sql);
		$cache_path='./cache/sql/'.$key.'.json';
		//var_dump($c);
		$c=json_encode($c);
		if($config['cache']['cache_type']=='file'){
			if(!@file_put_contents($cache_path,$c)){
				require_once 'lib/Dir.class.php';
				$dir=new Dir();
				$dir->del_dir('./cache/sql/');
				mkdir('./cache/sql/');
				file_put_contents($cache_path,$c);
			}
		}else{
			if(in_array('memcache',$php_extensions)){
				$memcache=new Memcache;
				$memcache->connect("localhost",11211);
				$memcache->add($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
				//$memcache->set($cache_path,$c,MEMCACHE_COMPRESSED,$config['cache']['cache_time']);
				$memcache->close();
				}
		}	
	
		return true;
	}

	function get_sql_cache($config,$sql){
		if(!$config['cache']['sql_cache_switch']){return false;}
		//echo 'get';
		$key=md5($sql);
		$cache_path='./cache/sql/'.$key.'.json';
		
		if($config['cache']['cache_type']=='file'){
			$cache_file_time=@filemtime($cache_path)+$config['cache']['cache_time'];
			//echo $cache_file_time.'-'.time().'='.$cache_file_time-time();
			if($cache_file_time>time()){
				/*echo 'I am cache<br/>';*/
				$r=file_get_contents($cache_path);
				$r=json_decode($r,1);
				return $r;
			}
		}else{
			$php_extensions=get_loaded_extensions();
			if(in_array('memcache',$php_extensions)){
				@$memcache=new Memcache;
				@$memcache->connect($config['cache']['memcache_host'],$config['cache']['memcache_port']);
				@$r=$memcache->get($cache_path);
				@$memcache->close();
				if(!empty($r)){
					$r=json_decode($r,1);
					return $r;
				}
			}
		}	
		
		return false;	
	}
	
	function safe_path($v){
		$v=str_replace('..','',$v);	
		$v=trim($v,'/');
		return $v;	
	}
	
	function safe_rename($old,$new){
		$old=str_ireplace('temp/..','temp/',$old);
		compress_img($old,-1);
		return rename($old,$new);
	}
	
	function compress_img($path,$max){
		//compress_img($path,self::$config['web']['img_max']);
		if(in_array(substr($path,strlen($path)-4,4),array('.png','.jpg','.gif'))){
			if($max==-1){
				$config=require('./config.php');
				$max=$config['web']['img_max'];
			}
			$max=intval($max);
			if($max==0){$max=1024;}
			$file_size=sprintf("%u",filesize($path));
			if($file_size/1024>$max){
				$image =new Image();
				$state=$image->thumb($path,$path,1920,-1);
			}
		}
	}
	
	function safe_unlink($v){
		$v=str_ireplace('../','',$v);
		@unlink($v);
	}
	
	
	function inquiries_pay_state($config,$type,$in_id){
		//$r=inquiries_pay_state(self::$config,'weixin','20160817111120');
		if(is_local($_SERVER['SERVER_NAME'])){return false;}
		$url='http://'.$_SERVER['SERVER_NAME'].'/payment/'.$type.'/inquire.php?in_id='.$in_id;
		$r=file_get_contents($url);
		//file_put_contents('t.txt',$url.'<br />'.$r);
		if($r=='success'){return true;}else{return false;}	
	}
	
	

	
	function wexin_red_pack($pdo,$username,$sender,$wishing,$money,$program){
		//wexin_red_pack($pdo,$_SESSION['user']['username'],$sender,$wishing,$money,'prize')
		//if(!$r){echo($_POST['err_code_des']);}else{}
		$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['openid']==''){$_POST['err_code_des']='openid is null';return false;}
		$wxid= date('YmdHis').rand(10, 99);
		$sql="insert into ".$pdo->index_pre."wxpay (`time`,`username`,`openid`,`money`,`reason`,`operator`,`program`,`ip`,`send_state`,`receive_state`,`type`,`wxid`) values ('".time()."','".$username."','".$user['openid']."','".$money."','".$sender.','.$wishing."','".@$_SESSION['user']['username']."','".$program."','".get_ip()."','0','0','0','".$wxid."')";
		if(!$pdo->exec($sql)){$_POST['err_code_des']='insert redpack err';return false;}
		$log_id=$pdo->lastInsertId();
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}

		 $money = $money*100;
		 $obj2 = array();
		 $obj2['wxappid']         	= $config['appid'];
		 $obj2['mch_id']         	= $config['mchid'];
		 $obj2['mch_billno']			=  $wxid;
		 $obj2['client_ip']    		= $_SERVER['REMOTE_ADDR'];
		 $obj2['re_openid']         	= $user['openid'];
		 $obj2['total_amount']       = $money;
		 $obj2['min_value']         	= $money;
		 $obj2['max_value']         	= $money;
		 $obj2['total_num']         	= 1;
		 $obj2['nick_name']      	= $sender;
		 $obj2['send_name']      	= $sender;
		 $obj2['wishing']        	= $wishing;
		 $obj2['act_name']      	= $sender;
		 $obj2['remark']      		= $sender;

		// var_dump($obj2);

		 $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
		 $wxHongBaoHelper2 = new WxPay();
		 $result = $wxHongBaoHelper2->pay($url, $obj2,$config);
		 //var_dump( $result);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($result->result_code=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `send_state`=1 where `id`=".$log_id;
				$pdo->exec($sql);
				return true;
			}else{
				$_POST['err_code_des']=$result->err_code_des;return false;
			}
		}else{
			$_POST['err_code_des']='';return false;	
		}
	
	}
	
	
	function wexin_red_pack_inquiry($pdo,$id){
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}
		$sql="select `wxid` from ".$pdo->index_pre."wxpay where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['wxid']==0){return false;}
		$obj2 = array();
		$obj2['appid']         	= $config['appid'];
		$obj2['mch_id']         	= $config['mchid'];
		$obj2['mch_billno']			= $r['wxid'];
		$obj2['bill_type']        	= "MCHT";
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo';
		$wxHongBaoHelper4 = new WxPay();
		$result = $wxHongBaoHelper4->pay($url, $obj2,$config);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);	
			if($result->status=='RECEIVED'){
				$sql="update ".$pdo->index_pre."wxpay set `receive_state`=1 where `id`=".$id;	
				$pdo->exec($sql);
			}
			return $result->status;
		}else{return false;}
	}
	
	
	function wexin_transfers($pdo,$username,$sender,$money,$program){
		//$r=wexin_transfers($pdo,$_SESSION['user']['username'],self::$config['web']['name'].' '.self::$language['withdraw'],1,'index');
		//if(!$r){echo($_POST['err_code_des']);}else{}
		$sql="select `openid` from ".$pdo->index_pre."user where `username`='".$username."' limit 0,1";
		$user=$pdo->query($sql,2)->fetch(2);
		if($user['openid']==''){$_POST['err_code_des']='openid is null';return false;}
		$wxid= date('YmdHis').rand(10, 99);

		$sql="insert into ".$pdo->index_pre."wxpay (`time`,`username`,`openid`,`money`,`reason`,`operator`,`program`,`ip`,`send_state`,`receive_state`,`type`,`wxid`) values ('".time()."','".$username."','".$user['openid']."','".$money."','".$sender."','".@$_SESSION['user']['username']."','".$program."','".get_ip()."','0','0','1','".$wxid."')";
		if(!$pdo->exec($sql)){$_POST['err_code_des']='insert redpack err';return false;}
		$log_id=$pdo->lastInsertId();
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}

		 $money = $money*100;
		 $obj1 = array();
		 
		 $obj1['openid']         	= $user['openid'];
		 $obj1['amount']         	= $money;
		 $obj1['desc']        		=$sender;
		 $obj1['mch_appid']         	= $config['appid'];
		 $obj1['mchid']         		= $config['mchid'];
		 $obj1['partner_trade_no']	= $wxid;
		 $obj1['spbill_create_ip']   = $_SERVER['REMOTE_ADDR'];
		 $obj1['check_name']      	= "NO_CHECK";
		 $obj1['re_user_name']    	= "";
		 
		 

		// var_dump($obj2);

		 $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
		 $wxHongBaoHelper2 = new WxPay();
		 $result = $wxHongBaoHelper2->pay($url, $obj1,$config);
		 //var_dump( $result);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
			if($result->result_code=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `send_state`=1,`receive_state`=1 where `id`=".$log_id;
				$pdo->exec($sql);
				return true;
			}else{
				$_POST['err_code_des']=$result->err_code_des;return false;
			}
		}else{
			$_POST['err_code_des']='';return false;	
		}
	
	}
	

	function wexin_transfers_inquiry($pdo,$id){
		$config=require('./payment/weixin/config.php');
		if($config['state']!='opening'){$_POST['err_code_des']='weixin pay not is opening';return false;}
		$sql="select `wxid` from ".$pdo->index_pre."wxpay where `id`=".$id;
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['wxid']==''){return false;}
		$obj2 = array();
		$obj2['appid']         	= $config['appid'];
		$obj2['mch_id']         	= $config['mchid'];
		$obj2['partner_trade_no']			= $r['wxid'];
		$url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo';
		$wxHongBaoHelper4 = new WxPay();
		$result = $wxHongBaoHelper4->pay($url, $obj2,$config);
		if($result){
			$result = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);	
			if($result->status=='SUCCESS'){
				$sql="update ".$pdo->index_pre."wxpay set `receive_state`=1 where `id`=".$id;	
				$pdo->exec($sql);
			}
			return $result->status;
		}else{return false;}
	}
	
//清空前台页面缓存	
function clear_file_cache(){
	$dir=new Dir();
	$dir->del_dir('./cache/pc/');
	@mkdir('./cache/pc');
	$dir->del_dir('./cache/phone/');
	@mkdir('./cache/phone');
	return true;
}

//清空SQL结果缓存	
function clear_sql_cache(){
	$dir=new Dir();
	$dir->del_dir('./cache/sql/');
	@mkdir('./cache/sql');
	return true;
}

//记录会员注册推荐人
function set_reg_introducer($pdo){
	if(!isset($_SESSION['user']['id'])){return false;}
	if(!isset($_SESSION['user']['username'])){return false;}
	if(@$_SESSION['user']['introducer']!=''){return false;}
	if(isset($_COOKIE['store_id']) && $_COOKIE['store_id']!=''){
		$sql="select `username` from ".$pdo->sys_pre."agency_store where `id`=".intval($_COOKIE['store_id']);
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['username'] != $_SESSION['user']['username']){$introducer=$r['username'];}
	}
	if(isset($_SESSION['share']) && $_SESSION['share']!=''){$introducer=$_SESSION['share'];}
	if(isset($introducer)){
		$sql="select `reg_time` from ".$pdo->index_pre."user where `username`='".$introducer."' limit 0,1";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `reg_time` from ".$pdo->index_pre."user where `id`=".$_SESSION['user']['id'];
		$r2=$pdo->query($sql,2)->fetch(2);
		if($r2['reg_time']>$r['reg_time']){
			$sql="update ".$pdo->index_pre."user set `introducer`='".$introducer."' where `id`=".$_SESSION['user']['id'];
			$pdo->exec($sql);
		}
	}
}
//智能的获取一个手机号
function get_true_phone($v,$n=NULL,$phone="phone"){
	if($n != NULL){
		$phone=$phone.$n;
	}else{
		$n = 0;
	}
	if(isset($v[$phone])){
		return $v[$phone];
	}else{
		if($n > 20){
			return "";
		}
		$n++;
		return get_true_phone($v,$n);
	}
}
function get_examined($pdo,$examined,$table_id){
	if(is_numeric($examined)){
		$examined=intval($examined);
		$sms_arr=get_table_sms($pdo,$table_id);
		if(isset($sms_arr[$examined])){
			return $sms_arr[$examined];
		}else{
			return $examined;
		}
	}else{
		return $examined;
	}
}


/*格式化短信提交框数据*/
function get_table_sms($pdo,$table_id){
		$table_sms=return_table_info($pdo,$pdo->table_pre."table","table_sms","id",$table_id,false);
		$table_sms=explode("|", $table_sms);
		$a=array();
		foreach ($table_sms as $v) {
			if($v!=""){
				$sms=explode("&", $v);
				$sms=$sms[0];
				if($sms!=""){
					array_push($a, $sms);
				}
			}
		}
		return $a;
}
function get_member($pdo,$table_creater,$admin_is_edit,$retype="default"){
	/*为减少服务器查询次数,直接传入表的创建者,及是否表管理员分配*/
	if(!isset($table_creater) or !isset($admin_is_edit) or $table_creater == "" or $admin_is_edit == ""){
		return array();
	}
	$admin_is_edit=intval($admin_is_edit);
	if($admin_is_edit == 1){
		$where="";
	}else{
		$where=" and `username`!='".$table_creater."'";
	}
	$userid=return_table_info($pdo,$pdo->index_pre."user","id","username",$table_creater,false);
	$sql="select * from ".$pdo->index_pre."user where `user_group` REGEXP '^".$userid."[|]|[|]".$userid."[|]'".$where;
	//使用正则表达式,MYSQL转义符使用[|]而非\|
	//$sql="select * from cloud_index_user where `user_group` REGEXP '^4025[|]|[|]4025[|]'";
	if($retype == "sql"){
		return $sql;
	}
	$r=$pdo->query($sql,2);
	$arr=array();
	foreach ($r as $v) {
		array_push($arr,$v);
	}
	switch ($retype) {
		case 'count':
			return count($arr);
			break;
		
		default:
			return $arr;
			break;
	}
}
//获取IP
function get_client_ip(){
    static $realip;
    if(isset($_SERVER)){
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $realip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else if(isset($_SERVER['HTTP_CLIENT_IP'])){
            $realip=$_SERVER['HTTP_CLIENT_IP'];
        }else{
            $realip=$_SERVER['REMOTE_ADDR'];
        }
    }else{
        if(getenv('HTTP_X_FORWARDED_FOR')){
            $realip=getenv('HTTP_X_FORWARDED_FOR');
        }else if(getenv('HTTP_CLIENT_IP')){
            $realip=getenv('HTTP_CLIENT_IP');
        }else{
            $realip=getenv('REMOTE_ADDR');
        }
    }
    return $realip;
}

function auto_user_give_assessor_Table($pdo,$retype="default"){
	$sql="select `id` from ".$pdo->sys_pre."form_table";
	$r=$pdo->query($sql,2);
	$t=array();
	foreach($r as $v){
		array_push($t,auto_user_give_assessor($pdo,$v['id'],0,$retype));
	}
	return $t;
}
function arr_to_arr($arr){
	/*将数组去重及去空*/
	$arr=array_filter($arr);
	$arr=array_unique($arr);
	return $arr;
}
function str_to_arr($str,$token="|"){
	$a=explode($token, $str);
	return arr_to_arr($a);
}
//给用户智能分配审核员 指定ID能直接返回二维码
function auto_user_give_assessor($pdo,$id,$data_id=0,$retype="default"){
	$sql="select `creater`,`admin_power`,`admin_is_edit`,`edit_power`,`name` from ".$pdo->table_pre."table where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	if( $r['edit_power'] == "" && $r['admin_is_edit'] == 0){//即没有维护用户,也不让管理员维护的时候
		return "";
	}
	$table_name=$r['name'];
	$edit_power=$r["edit_power"];//参与这个表的维护成员
	if($r['admin_is_edit'] == 1){//如果表管理也参与维护数据
		$edit_power.=$r["admin_power"];
		$edit_power.=return_username_info($pdo,$r["creater"],"id");
	}
	$edit_powers=explode("|", $edit_power);
	$edit_powers=array_filter($edit_powers);//去空值
	$edit_powers=array_unique($edit_powers);//去重
	$edit_names=array();
	$table_where=" where ";//用于查询时跳过已经拥有审核员的用户,省约服务器资源
	foreach ($edit_powers as $v) {
		$user_name=return_table_info($pdo,$pdo->index_pre."user","chip,weixincode,username","id",$v,false);
		if($user_name["username"] != ""){
			array_push($edit_names, $user_name);
			$table_where.="`assessor`!='".$user_name["username"]."' and ";
		}else{/*如果该用户不存在,则清除掉*/

		}
	}
	$edit_names_length=count($edit_names);
	if($edit_names_length < 1){//得到的所有维护如果是0个
		return "";
	}
	if(intval($data_id) > 0){//如果指定了ID.则直接分配,用于用户提交数据之时.
		$sql="select `examined`,`id`,`assessor` from ".$pdo->table_pre.$table_name." where `id`=".$data_id;
		$r=$pdo->query($sql,2)->fetch();
		$number_=$data_id % $edit_names_length;
		$username_assessor=$edit_names[$number_]["username"];
		if(!in_array($r['assessor'], $edit_names) /*过期*/ || intval($r["examined"]) == 0 && $v['assessor'] != $username_assessor/*初数据*/ || $r['assessor'] == ""){
			/*当指定ID的时候.为了方便其他地方重复调取二维码.因此判断是否达成条件*/
			$arr["assessor"]=$username_assessor;
			mysql_update($pdo,$pdo->table_pre.$table_name,$arr,"id",$data_id);
		}
		if($edit_names[$number_]["weixincode"] == ""){
			$edit_names[$number_]["weixincode"]="default.jpg";
		}
		return "<br /><span class='weixinspan'>加速处理进度请加微信号</span><br /><span class='weixinspan'>微信号: ".$edit_names[$number_]["chip"]."</span><br /><span class='weixinspan'>扫描二维码添加</span><br /><img class='weixincode_img' onerror='reloadimg(this);' src='/upload/index/user_weixincode/".$edit_names[$number_]["weixincode"]."' />";
	}else{
		$table_where=rtrim($table_where," and ");
		$sql="select `examined`,`id`,`assessor` from ".$pdo->sys_pre."form_".$table_name.$table_where;
		if($retype == "sql"){
			return $sql;
		}
		$r=$pdo->query($sql,2);
		//return $sql;
		foreach($r as $v){
			$number_=$v["id"] % $edit_names_length;
			$username_assessor=$edit_names[$number_]["username"];
			if(!in_array($v['assessor'], $edit_names) /*过期*/ || intval($r["examined"]) == 0 && $v['assessor'] != $username_assessor/*初数据*/){
				$sql="update ".$pdo->table_pre.$table_name." set `assessor`='".$username_assessor."' where `id`=".$v['id'];
				//file_put_contents("temp/test.txt", $sql."\n", FILE_APPEND);
				$pdo->exec($sql);
			}
		}
	}
}

//调用发送短信（PHP代码/函数）
/*参数1，全站config配置，参数2，发送的内容，参数 3 #pdo查询类 参数4 发送的数据ID(ddweb_index_phone_msg) 参数5：短信模板ID 聚合数据查看*/
function newsend_sms($config,$language,$pdo,$id=0,$sendtmpid/*发送类型*/,$template_id=0){

	$id=intval($id);
	if($id==0){
		$sql="select * from ".$pdo->index_pre."phone_msg where `state`='1' order by `time` asc limit 0,1";
	}else{
		$sql="select * from ".$pdo->index_pre."phone_msg where `id`='$id' and `state`='1'";
	}

  
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['addressee']!='' && $r['content']!=''){
		$r=de_safe_str($r);
		$ctx=stream_context_create(array('http'=>array('timeout'=>30)));
		
		$url = getSmsPostUrl($config,$language,$r['addressee'],$r['content'],$sendtmpid,$template_id/*通过getSmsPostUrl 直接取得发送的URL*/);
		//exit();
		$state=@file_get_contents($url,false,$ctx);
		//return $url;
		$state=trim($state);
		$send_state=match_result____($config['sms']['success_val'],$state);
		if($send_state){
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='2' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 return true;
		}else{
			 $sql="update ".$pdo->index_pre."phone_msg set `state`='3' where `id`='".$r['id']."'";
			 $pdo->exec($sql);
			 $title=str_replace('{web_name}',$config['web']['name'],$language['config_language']['sms']['fail_email_content']);
			 $content='http://'.$_SERVER['SERVER_NAME'].'/index.php?cloud=index.config#sms';
			 $content=$language['config_language']['sms']['this_name'].' <a href='.$content.' >'.$content.'</a>';
			 //var_dump($language);
			 //file_put_contents('sms_fail_mail_title.txt',$title.'<br >'.$content);
			 email($config,$language,$pdo,'cloud',$config['sms']['fail_email'],$title,$content);

			 return false;
		}
	}
}

function match_result____($success_val,$state){
	$operational_character=array('=','≠','∈','>','<',);
	$temp=mb_substr($success_val,0,1,'utf-8');

	if(!in_array($temp,$operational_character)){
		$temp='=';
	}
	$success_val=mb_substr($success_val,1,1000,'utf-8');
	$send_state=false;
	switch($temp){
		case '=':
			if($state==$success_val){$send_state=true;}
			break;
		case '≠':
			if($state!=$success_val){$send_state=true;}
			break;
		case '∈':
			if(strpos($state,$success_val)!==false){$send_state=true;}
			break;
		case '<':
			if(intval($state)<intval($success_val)){$send_state=true;}
			break;
		case '>':
			if(intval($state)>intval($success_val)){$send_state=true;}
			break;
	}
	return $send_state;
}


	//======================================================================================================= 生成二维码

	function auto_PngCode($id,$SERVER){
		$url=create_table($SERVER,$id,"urlt");
		create_PNGcode($url,"./ico.png","./upload/form/ico/code_".$id.".png",260); 
	}
	/*二维码调试*/
	//生成二维码,参数1: 需要生成的URL地址 参数2:嵌在中间的LOGO 参数3:存放地址  参数4: 高宽px
	function create_PNGcode($txt,$logo_path,$save_path,$width,$create){
		require('./plugin/qrcode/qrcode.php');
		$txt=str_replace('|||','&',$txt);
		QRcode::png($txt,$save_path,0,0,1);
		ob_end_clean();
		require('./lib/image.class.php');
		$time=time();
		$icon_save_path='./upload/form/code_icon/';
		if(!is_dir($icon_save_path)) {
			//如果目录不存在则创建
		    mkdir($icon_save_path, 0777, true);
		}
		if(!is_dir($save_path)) {
		    mkdir($save_path, 0777, true);
		}
		$icon_save_path.=$create."_".$time.".png";
		$image=new image();
		$image->thumb($save_path,$save_path,$width,$width);
		$image->thumb($logo_path,$icon_save_path,$width/8,$width/8);
		$image->imageMark($save_path,$save_path,$icon_save_path,5,100,1);
		return $image;
	}
	//自动给表一个后台显示的色
	function table_admin_color(){
		$color_admArr=array("red","green","blue","purple");
		$color_admCode=array("red"=>"#EF1E25","green"=>"#2AB4C0","blue"=>"#5C9BD1","purple"=>"#4E9D4E");
		$n = rand(0,count($color_admArr)-1);
		$name=$color_admArr[$n];
		$arr["name"]=$name;
		$arr["code"]=$color_admCode[$name];
		return $arr;
	}
	function auto_give_Diytable_name($pdo,$userid){
		/*自动生成表名*/
		$table_name='zuser_'.$userid."_".time();
		if(field_exist($pdo,$pdo->table_pre.$table_name,'id')){
			return auto_give_Diytable_name($pdo,$userid);
		}else{
			return $table_name;
		}
	}
	function auto_give_Diyfolder_name($pdo,$userid){
		/*自动生成表名*/
		$folder_name='folder'.rand(10,99).'_'.$userid."_".time();
		$re=return_table_info($pdo,$pdo->table_pre."table","name","description",$folder_name,/*$all=*/false);
		if($re == ""){
			return $folder_name;
		}else{
			return auto_give_Diyfolder_name($pdo,$userid);
		}

	}
	//获取审核员的二维码 
	function get_callback($pdo,$id,$data_id,$retype="default"){
		/*code_arr 返回一个数组型的  code_html 返回HTML代码*/
		$table_callback=return_table_info($pdo,$pdo->table_pre."table","callback","id",$id,false);
		switch ($table_callback) {
			case 1:
				/*返回微信二维码 调用自动分配函数,指定ID则自动返回二维码信息.*/
				return auto_user_give_assessor($pdo,$id,$data_id,$retype);
				break;
			default:
				# code...
				break;
		}
	}

	function change_table_usename($pdo,$table_id,$username){
		/*传入表ID,新用户的ID*/
		if($table_id == "" || $username == ""){
			return false;
		}
		$new_cerater_id=return_username_info($pdo,$username,"id");
		$old_table_name=return_table_info($pdo,$pdo->table_pre."table","name","id",$table_id,false);
		$new_table_name=auto_give_Diytable_name($pdo,$new_cerater_id);//表名(英文)
		$arr['creater']=$username;
		$arr['name']=$new_table_name;
		$arr['edit_time']=time();
		$sql="rename table ".$pdo->table_pre.$old_table_name." to ".$pdo->table_pre.$new_table_name;
		$pdo->exec($sql);
		mysql_update($pdo,$pdo->table_pre."table",$arr,"id",$table_id);
		return $new_table_name;
	}
	//控制表单的写入状态,如果是true则默认可写,false默认关闭
	function auto_set_table_write($pdo,$id=false,$power=true,$retype="default"/*debug功能*/){
				/*默认所有用户的写入权限*/
		$_sql="select `id` from ".$pdo->index_pre."group";
		$_gr=$pdo->query($_sql,2);
		
		$add_power="0|";
		foreach($_gr as $_gv){
			$add_power.=$_gv['id']."|";
		}
		$where="";
		if($id!=false){
			$where="where `id`=".$id." and `write_state`=1";
		}
		if($power == true){
			$sql="update ".$pdo->sys_pre."form_table set `add_power`='".$add_power."'".$where;
		}else{
			if($id != false){
				$sql="update ".$pdo->sys_pre."form_table set `add_power`='1|'".$where;//清除全部用户.
			}else{
				$sql="";//防误操作
			}
		}
		if($retype == "sql"){
			return $sql;
		}
		$pdo->exec($sql);
		return re_type($retype,$pdo->lastInsertId(),$pdo->errorInfo(),$pdo->errorCode(),true);
	}
/*等比例拿到图片高|宽*/
function getRatioSize($image_path, $max_width=''){ 
	if(!file_exists($image_path)){
		return array('width'=>$max_width, 'height'=>'auto');
	}
    list($width, $height) = getimagesize($image_path);  
    $max_width = abs($max_width) <= 0 ? 1 : abs($max_width);
    if($max_width < $width ){
        $ratiow = ($width/100);
        $rn= $max_width/$ratiow;
    	$ratioh = ($height/100)*$rn;
    }
    $height = intval($ratioh)-5; 
    return array('width'=>$width, 'height'=>$height);  
} 

/*格式化提交框数据*/
function format_value($arr_val,$str,$token="|"){
	/*数据库中取出的值,需要填入的新值,分割符号*/
	return reset_arr($arr_val,$str,$token);
}
function reset_arr($arr_val,$str,$token="|"){
	$arr=explode($token, $arr_val);
	foreach ($arr as $value) {
		if($value == $str){
			return $arr_val;
		}
	}
	return $arr_val.$str.$token;
}
//插入一个值
function insert_arr($arr_str,$new_str,$token="|"){
	if($arr_str == ""){
		return $new_str.$token;
	}else{
		$arr=explode($token, $arr_str);
		foreach ($arr as $value) {
			if($value == $new_str){
				return $arr_str;
			}
		}
		return $arr_str.$new_str.$token;
	}
}
function return_usernames_infoStr($pdo,$usernames,$info,$table_createrId){//创建表时的返回.
	if($usernames == ""){
		return "";
	}
	$config=require("./config.php");
	$en_group_id=$config["reg_set"]["en_group_id"];//从系统配置中读取企业用户组
	$en_group_id=intval($en_group_id);
	$names=explode(",", $usernames);
	$t="";
	foreach ($names as $value) {
		if($value != ""){
			$user_group=return_username_info($pdo,$value,"group,id,user_group");
			if(intval($user_group["group"]) != $en_group_id){
				$update_arr["group"]=$en_group_id;
				$update_arr["is_enterprise"]=1;
				mysql_update($pdo,$pdo->index_pre."user",$update_arr,"username",$value);
			}
			/*将用户添加到工作组*/
			$user_arr=null;
			$user_arr["user_group"] = reset_arr($user_group["user_group"],$table_createrId);
			mysql_update($pdo,$pdo->index_pre."user",$user_arr,"username",$value);
			/*将用户添加到工作组*/
			$t.=$user_group["id"]."|";
		}
	}
	return $t;
}
//全自动发送短信 
function auto_send_sms($pdo,$sender,$phone,$content,$tmp_id=0,$sendtmpid=0/*发送类型*/){
	/*发送者,接收地址,内容*/
	$msg_money=return_table_info($pdo,$pdo->index_pre."user","msg_money","username",$sender,false);
	if(intval($msg_money) < 1){
		return false;
	}
	$Arr["msg_money"]="msg_money-1";//减短信数量 
	$Arr["msg_count"]="msg_count+1";//增加短信数量
	mysql_update($pdo,$pdo->index_pre."user",$Arr,"username",$sender,"number");
	$config=require("./config.php");
	$language=require("./language/chinese_simplified.php");
	//return $config;
	$sql="insert into ".$pdo->index_pre."phone_msg (`sender`,`addressee`,`content`,`state`,`time`,`count`,`timing`) values ('$sender','".$phone."','".$content."','1','".time()."','0','0')";	
	if($pdo->exec($sql)){
		return newsend_sms($config,$language,$pdo,$pdo->lastInsertId(),$sendtmpid/*发送类型*/,$tmp_id);
		//$config,$language,$pdo,$id=0,$sendtmpid/*发送类型*/,$template_id=0
	}else{
		return false;
	}
}

/*
 * 返回短信内容
 * */
function getSmsCotent($type=9999,$base=false,$weixin=null,$tablaname){
	$config = require("./config.php");
	$type = intval($type);
	$sms_content = "";
	switch ($type) {
		case 0://审核中.
			$sms_content = $config["sms"]["examined_template_content"];
			break;
		case 1://复审中.
			$sms_content = $config["sms"]["recheck_template_content"];
			break;
		case 2://审核成功.
			$sms_content = $config["sms"]["succeed_template_content"];
			break;
		case 3://审核成败.
			$sms_content = $config["sms"]["fail_template_content"];
			break;
	}
	if($weixin != null){
		$sms_content = str_replace("{weixin}",$weixin,$sms_content);
	}
	return $sms_content;
}


/*PHP的POST方法*/
function send_post($url,$post_data,$ajax_type="POST") {  
  $ajax_type=strtoupper($ajax_type);
  $postdata = http_build_query($post_data);  
  $options = array(  
    'http' => array(  
      'method' => $ajax_type,  
      'header' => 'Content-type:application/x-www-form-urlencoded',  
      'content' => $postdata,  
      'timeout' => 15 * 60 // 超时时间（单位:s）  
    )  
  );  
  $context = stream_context_create($options);  
  $result = @file_get_contents($url, false, $context);  
  return $result;  
}  
	function invite_users($pdo,$invite_users,$id,$sender,$tablename){
		/*Member_ADDPower_check[invite][phones][edit]:
		Member_ADDPower_check[invite][phones][read]:
		Member_ADDPower_check[invite][emails][admin]:
		Member_ADDPower_check[invite][emails][edit]:,games129@163.com
		Member_ADDPower_check[invite][emails][read]:
		*/

		$config=require("./config.php");
		$en_group_id=$config["reg_set"]["en_group_id"];//从系统配置中读取企业用户组
		$en_group_id=intval($en_group_id);
		foreach ($invite_users as $key => $v1) {
			switch ($key) {
				case 'phones':
					# 调用发短信
					foreach ($v1 as $key => $v2){
						$phones=explode(",", $v2);
						$phones=array_filter($phones);
						$phones=array_unique($phones);
						foreach ($phones as $v) {
							$url='http://'.$_SERVER['HTTP_HOST'].'/c.php?'.shortUrl2('http://'.$_SERVER['HTTP_HOST'].'/index.php?cloud=index.reg_user&group_id='.$en_group_id.'&invite='.$v,$pdo);
							$content=",注册【".$url."】";
							//您的团队成员邀请您注册成为@,请点击后注册,登陆入直接成为团队成员。
							auto_send_sms($pdo,$sender,$v,$content,$config["sms"]["other_template_id"]);/*调用通用模版ID*/
						}
					}
					break;
				case 'emails':
					# 调用发邮箱
					foreach ($v1 as $key => $v2){
						switch ($key) {
							case 'admin':
								# 管理者 邮箱 
								$admin_type="表管理员";
								break;
							case 'edit':
								# 数据维护 邮箱 
								$admin_type="数据维护员";
								break;
							case 'read':
								# 数据查看 邮箱 
								$admin_type="数据查看员";
								break;
							default:
								$admin_type="";
								break;
						}
						$title="【好好数据】您被邀请注册为【".$tablename."】的".$admin_type."(邀请者: ".$sender.")";
						$emails=explode(",", $v2);
						$emails=array_filter($emails);
						$emails=array_unique($emails);
						foreach ($emails as $v) {
							$addressee=$v;
							$url='http://'.$_SERVER['HTTP_HOST'].'/c.php?'.shortUrl2('http://'.$_SERVER['HTTP_HOST'].'/index.php?cloud=index.reg_user&group_id='.$en_group_id.'&invite='.$v,$pdo);
							$content='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
							<html xmlns="http://www.w3.org/1999/xhtml"><head>
							<meta http-equiv="content-type" content="text/html; charset=utf-8">
							<title>好好数据邀请你加入团队</title>
							<table width="590" cellpadding="0" cellspacing="0" border="0" style=" font-family:Verdana;"> 
							<tbody>
							<tr> 
							<td align="left" style="font-weight:bold; font-size:14px; padding-top:15px; padding-bottom:8px; color:#5b5b5b;"> 尊敬的<span> '.$addressee.' </span>您好： </td> 
							</tr> 
							<tr> 
							<td align="left" style="font-size:12px; color:#5b5b5b; padding-top:5px; padding-bottom:5px; line-height:25px;"> 你的团队成员 '.$sender.' 邀请您成为 表:<'.$tablename.'> 表的 '.$admin_type.'!<br> 
							请点击下面的注册连接。<br> 
							打开或复制到浏览器：<a href="'.$url.'" target="_blank">'.$url.'</a> 注册成功后直接登陆后加入团队。 </td> 
							</tr> 
							</tbody>
							</table> </td> 
							<td width="30" bgcolor="#ffffff" align="left" style>&nbsp;</td> 
							</tr> 
							</tbody>
							</table>
							<table width="590" cellpadding="0" cellspacing="0" border="0" style=" font-family:Verdana;"> 
							<tbody>
							<tr> 
							<td align="left"> <a href="http://'.$_SERVER['HTTP_HOST'].'" target="_blank"><img src="http://'.$_SERVER['HTTP_HOST'].'/images/mail_logo.png" width="242" height="48" border="0" alt="好好数据" style=" margin-top:5px;"></a>
							<br>
							<a href="" style="font-size: 12px;text-decoration: none" target="_blank"> <font color="#323335"> http://'.$_SERVER['HTTP_HOST'].' 金融数据专家 - 欢迎入驻! </font> </a> </td> 
							</tr> 
							</tbody> 
							</table>';
							auto_send_email($pdo,$addressee,$title,$content,$sender);
						}
					}
					break;
				default:
					return false;
					break;
			}
		}
		$invite_type=array("phones","emails");
		$admin_type=array("admin","edit","read");
	}

	function Get_GroupChrild_id($pdo,$id){
		$sql="select `id` from ".$pdo->index_pre."group where `parent`=".$id." and `parent`!=0 and `parent`!=1 or `id`=".$id;
		$r=$pdo->query($sql,2);
		$arr=Array();
		foreach($r as $v){
			array_push($arr,$v['id']);
		}
		return $arr;
	}
	
	
	function get_tables($pdo){
		$sql="select * from ".$pdo->sys_pre."form_table";
		return $pdo->query($sql,2);
	}
	
	function get_table_field_types($pdo,$table_id,$input_type){
		$sql="select `name`,`input_type` from ".$pdo->sys_pre."form_field where `input_type`='$input_type' and `table_id`=".$table_id;
		return $pdo->query($sql,2);
	}
	
	/*自动压缩全站图片*/
	function task_shrink_img($pdo){
		$a=array();
		$t="";
		foreach(get_tables($pdo) as $v){
			$select="`id`";
			foreach(get_table_field_types($pdo,$v['id'],"img") as $v2){
				$select.=",`".$v2['name']."`";
				array_push($a,$v2['name']); //需要处理的全部图片字段
			}
			$sql="select ".$select." from ".$pdo->sys_pre."form_".$v['name']." where `shrink_img`=0 order by `id` asc";
			foreach($pdo->query($sql,2) as $v3){
				foreach($a as $v4){
					$pdo->exec("update ".$pdo->sys_pre."form_".$v['name']." set `shrink_img`=".auto_shrink_img________________s("./upload/form/img_bak/".$v3[$v4])." where `id`=".$v3['id']);
				}
			}
			return $t;
			$a=NULL;/*清空*/
			$a=array();
		}
	}
	
	/*自动压缩图片,传入图片路径即可*/
	function auto_shrink_img________________s($pdo,$file_path,$id,$tablename){
		$a='1';
		$b='0';
		
		if($file_path == "" || !file_exists($file_path)){
			return $b;
		}

		switch(strtolower(substr($file_path,-3))){
			case "gif":
			imagegif(shrink___________s($file_path,imagecreatefromgif($file_path)),$file_path); //.GIF
			break;
			case "jpg":
			imagejpeg(shrink___________s($file_path,imagecreatefromjpeg($file_path)),$file_path); //.JPG
			break;
			case "peg":/*jpeg格式*/
			imagejpeg(shrink___________s($file_path,imagecreatefromjpeg($file_path)),$file_path); //.PEG
			break;
			case "png":
			imagepng(shrink___________s($file_path,imagecreatefrompng($file_path)),$file_path); //.PNG
			break;
			case "bmp":
			imagewbmp(shrink___________s($file_path,imagecreatefromwbmp($file_path)),$file_path); //.BMP
			break;
			case "wbmp":
			image2wbmp(shrink___________s($file_path,imagecreatefromwbmp($file_path)),$file_path); //.WBMP
			break;
			default:
			return $b;
			break;
		}
		
		$sql="update ".$pdo->sys_pre."form_$tablename set `shrink_img`=$a where `id`=$id";
		if($pdo->exec($sql)){
			return $a;
		}
		return $b;
	}

	function shrink___________s($file_path,$fn){
		$percent = 1.0;  //图片压缩比
		list($width, $height) = getimagesize($file_path); //获取原图尺寸
		//缩放尺寸
		$newwidth = $width * $percent;
		$newheight = $height * $percent;
		$src_im = $fn;
		$dst_im = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresized($dst_im, $src_im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		return $dst_im;
	}
	
	
	/**
 * 短连接生成
 * User: yangyulong/anziguoer@sina.com
 * Date: 2015/5/28
 * Time: 15:55
 */
 /*还原*/
function restoreUrl($s,$pdo){
	$sql="select `url` from ".$pdo->sys_pre."click where `crc32`='$s'";
	$r=$pdo->query($sql,2)->fetch(2);
	return $r['url'];
	
}
function shortUrl2($url,$pdo){
    $result = sprintf("%u",crc32($url));
    $show = '';
    while($result  >0){
        $s = $result % 62;
        if($s > 35){
            $s=chr($s+61);
        }elseif($s>9 && $s<=35){
            $s=chr($s+55);
        }
        $show .= $s;
        $result = floor($result / 62);
    }
	$sql="select `crc32` from ".$pdo->sys_pre."click where `crc32`='$show'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r != ""){/*重复*/
		$sql="update ".$pdo->sys_pre."click set `crc32`='$show',`url`='$url' where `crc32`='".$show."'";
		$pdo->exec($sql);
		return $show;
	}
	$sql="insert into ".$pdo->sys_pre."click (`crc32`,`url`) values ('$show','$url')";
	if($pdo->exec($sql)){
		return $show;
	};
    
}

function getGroupParents($pdo,$id){
	$a=array();
	$sql="select `id`,`parent` from ".$pdo->sys_pre."index_group where `id`='$id'";
	//return $sql;
	$r=$pdo->query($sql,2)->fetch(2);
	array_push($a, $r['id']);
	if($r['parent'] != "" && $r['parent'] != 1){
		array_push($a,getGroupParents($pdo,$r['parent']));
	}
	return $a;
}

/*多维数组转一维*/
function arr_foreach($arr)
{
  static $tmp=array();  

  for($i=0; $i<count($arr); $i++)
  {  
     if(is_array($arr[$i]))
     {  
        arr_foreach($arr[$i]);  
     }else{  
        $tmp[]=$arr[$i];  
     }  
  }  

  return $tmp;  
} 

//检查表的创建人
function check_table_create($table_id,$pdo,$SE){
	$Gid=$SE['user']['group_id'];
	$Cuser=$SE['user']['username'];

	if($table_id == '' || $table_id == 0){
		return false;
	}

	if($Gid != 1){
		$sql="select `creater` from ".$pdo->table_pre."table where `id`=".$table_id;
		$r=$pdo->query($sql,2)->fetch();
		if($r['creater'] == $Cuser){
			//是表创建员
			return true;
		}else{
			//不是表创建员
			return false;
		}
	}else{
		//管理员返回
		return true;
	}
}

//检查用户是否是管理员 1=管理员 2=企业用户 3=普通用户
//check_is_admin_user($pdo,$_SESSION);
function check_is_admin_user($pdo,$SE){
	$Gid=intval($SE['user']['group_id']);
	$Cuser=$SE['user']['username'];

	if($Gid == '' || $Cuser == ''){
		return 4;//空值 
	}
	if($Gid == 1){
		return 1;//管理员
	}
	$config=require("./config.php");
	$en_group_id=$config["reg_set"]["en_group_id"];//从系统配置中读取企业用户组
	$en_group_id=intval($en_group_id);
	if($Gid != 1){
		$sql="select `id`,`username`,`group`,`user_group`,`is_enterprise` from ".$pdo->index_pre."user where `username`='".$Cuser."'";
		//var_dump($sql);
		$r=$pdo->query($sql,2)->fetch();
		if($r['id'] == ""){
			return 4;//空值 
		}
		if($r['group'] == 1){
			return 1;//管理员
		}
		$isadmin_sql="select `is_admin` from ".$pdo->index_pre."group where `id`=".$r['group'];
		$isadmin=$pdo->query($isadmin_sql,2)->fetch();
		if($isadmin['is_admin'] == 1){
			return 1;//管理组成员一样返回管理员
		}

		if($r['is_enterprise'] == 1 || $r['group'] == $en_group_id){
			return 2;//企业用户
		}
		return 3;//普通用户
	}else{
		//管理员返回
		return 1;
	}
}
//查看用户的表权限 
function check_is_table_admin($pdo,$table_id,$SE/*1表管理,2表维护,3表查看*/,$retype="default"){
	$id=$SE['user']['id'];
	if(!isset($id)){
		return 0;
	}
	
	$table=return_table_info($pdo,$pdo->table_pre."table","creater,admin_power,edit_power,read_power","id",$table_id,false);
	$admin_power=explode("|", $table["admin_power"]);
	if($table["creater"] == $SE['user']['username'] || in_array($id, $admin_power) || intval($id) == 4/*管理员*/){
		/*包含在管理员中*/

		return 1;
	}
	$edit_power=explode("|", $table["edit_power"]);
	if(in_array($id, $edit_power)){
		/*包含在编辑员中*/
		return 2;
	}
	$read_power=explode("|", $table["read_power"]);
	if(in_array($id, $read_power)){
		/*包含在数据查看中*/
		return 3;
	}

	return 0;

}
function check_is_table_admin_string($pdo,$table_id,$SE/*1表管理,2表维护,3表查看*/,$retype="default"){
	$authority=check_is_table_admin($pdo,$table_id,$SE,$retype);
	switch ($authority) {
		case 1:
			return "表管理员";
			break;
		case 2:
			return "数据维护员";
			break;
		case 3:
			return "数据查看员";
			break;
		default:
			return "无权限";
			break;
	}
}

function admin_return($pdo,$SE){
switch (check_is_admin_user($pdo,$SE)) {
	case 1://管理员
		# code...
		break;
	case 2://管理员
		# code...
		break;
	default:
	exit('<div class="mm_detail"><div class="noMail"><p>你还不是企业用户！</p><a class="btn btn-primary btn-mail btn_newMail" data-accid="'.$SE['user']['group_id'].'" onclick="upgrade_acc(this);"><div class="icon mailWhite"></div><p class="title" >立即升级账号</p></a></div></div><script>	function upgrade_acc(e){
        var nameid=$(e).attr("data-accid");
        $.get("/receive.php?token=MSMCDXSI&target=form::table_admin&act=setAccEn",{
            nameid:nameid
        },function(data){
            window.location.reload();
        })
    }</script>');
		break;
	}
}



function retrun_table_power($pdo,$id){/*数组结构 $arr[table_admin],$arr[table_edit],$arr[table_show]*/
	//"table_admin:1,2,3,4,5|table_edit:1,2,3,4,5|table_show:1,2,3,4"
	$sql="select `power` from ".$pdo->table_pre."table where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch();
	$a=explode("|", $r["power"]);
	$arr=array();
	foreach ($a as $value) {
		$newarr=explode(":", $value);
		foreach ($newarr as $key => $newarr_v) {
			$newarr_arr=explode(",", $newarr_v);
			$arr[$key]=$newarr_arr;
		}
	}
	return $arr;
}
function return_table_fieldname($pdo,$tablename){
		//column_comment 描述 
		//column_name字段名
		//table_name 表名
		//table_schema 数据库名
		//data_type 表类型
		$sql="select `column_comment`,`column_name`,`data_type` from information_schema.columns where table_name='".$tablename."'";
		$stmt=$pdo->query($sql,2);
		foreach ($stmt as $key => $value) {
			$r[strtolower($key)]=$value;
		}
		return $r;
}

function return_username_info($pdo,$usernameOrId,$name,$retype="default"){//调用 return_username_info($pdo,$_SESSION["user"]["username"],"id");
	if($name == "all"){
		$select="*";
	}else{
		$names=explode(",", $name);
		$select="";
		foreach ($names as $value) {
			$select.="`".$value."`,";
		}
		$select=rtrim($select,",");
	}
	if(strpos($usernameOrId,'[') != false){//判断是否是其他条件
		$if__=explode("[", $usernameOrId);
		$usernameOrId=$if__[0];
		$if__=explode("]", $if__[1]);
		$if__=$if__[0];
		$where=" where `".$if__."`='".$usernameOrId."'";
	}else{
		$where=" where `username`='".$usernameOrId."'";
	}
	$sql="select ".$select." from ".$pdo->index_pre."user".$where;
	if($retype == "sql"){
		exit($sql);
	}
	$r=$pdo->query($sql,2)->fetch();
	if($name == "all" || count($names) > 1){
		return $r;
	}else{
		return $r[$name];
	}
}

function return_table_info($pdo,$tablename,$info=false,$if_A=false,$if_B=false,$all=false,$retype="default"/*6个参数*/){
	//调用 return_table_info($pdo,$pdo->index_pre."user","id","id",1,false/*6个参数*/);
	//返回任何表的任何信息 //$all返回可以遍历的数据组
	$where="";
	if($if_A==false || $if_B==false ){
		$where="";
	}else{
		$if_A=explode(",", $if_A);
		$if_B=explode(",", $if_B);
		$if_n=0;
		$where=" where ";
		foreach ($if_A as $value) {
			if(is_numeric($if_B[$if_n])){
			/*如果是数字型,则不加单引号,防止查询出错is_numeric*/
				$if_B_val=$if_B[$if_n];
			}else{
				$if_B_val="'".$if_B[$if_n]."'";
			}
			if(strpos($value,'[') != false){
			/*判断是否有[no]运算符*/
				$value_=explode("[", $value);
				$value=$value_[0];
				$value_=explode("]", $value_[1]);
				$operator=$value_[0];
				switch ($operator) {
					case 'no':
						$operator="!=";
						break;
					default:
						$operator="=";
						break;
				}
			}else{
				$operator="=";
			}
			$where.="`".$value."`".$operator.$if_B_val." and ";
			$if_n++;
		}
		$where=rtrim($where," and ");
	}
	$info_arr=array();
	if($info==false || $info=="all" ){//不指定则返回整个数组
		$select="*";
	}else{
		$info_arr=explode(",",$info);
		$str_sel="";
		foreach ($info_arr as $info_value) {
			$str_sel.="`".$info_value."`,";
		}
		$select=rtrim($str_sel,",");
	}
	if(strpos($retype,'order') != false){
		$order_by=$retype;
	}else{
		$order_by="";
	}
	$sql="select ".$select." from ".$tablename."".$where.$order_by;
	/*--返回SQL进行调试--*/
	if($retype == "sql"){
		return $sql;
	}
	$r=$pdo->query($sql,2);
	$stmt=$r; 

	//return var_dump($sql);
	if($r->rowCount() < 1 && $all == false){
		$r=NULL;
		for($i=0; $i<$stmt->columnCount(); $i++) {//得到字段数量
			$name=$stmt->getColumnMeta($i)['name'];//得到表字段名
			$r[$name]="";
		}
	}else{
		if($all==false){
			//是否返回可以遍历的数组.而不是一条.
			$r=$stmt->fetch();
		}else{
			return $r;
		}
	}

	if($info != "all" && $info != false && count($info_arr) < 2){
		return $r[$info];
	}else{
		return $r;
	}
}



function echo_json($arr){
	$a="[";
	$t="";
	foreach ($arr as $key => $value) {
		$t.="{";
		$str_json="";
		foreach ($value as $key2 => $value2) {
			$str_json.="\"".$key2."\":\"".$value2."\",";
		}
		$str_json=rtrim($str_json,",");
		$t.=$str_json."},";
	}

	$a.=rtrim($t,",");
	$a.="]";
	return $a;
	//return json_encode($a);
}
//自动往数据库写入数据
//调用mysql_write($pdo,$pdo->table_pre."table",$arr);
function mysql_write($pdo,$tablename,$arr,$retype="default"){
	return table_write($pdo,$tablename,$arr,$retype);
}
function table_write($pdo,$tablename,$arr,$retype="default"){
	$sql="insert into ".$tablename." ";
	$a="";
	$values="";
	foreach ($arr as $key => $value) {
		if(is_numeric($value)){
		/*如果是数字型,则不加单引号,防止查询出错is_numeric*/
			$val__=$value;
			//$val__="'".$value."'";
		}else{
			$val__="'".$value."'";
		}
		$a.="`".$key."`,";
		$values.=$val__.",";
	}
	$t=rtrim($a,",");
	$tit=" (".$t.")";
	$v=rtrim($values,",");
	$val=" values (".$v.")";
	$sql_=$sql.$tit.$val;

	if($retype == "sql"){
		return $sql_;
	}
	$r=$pdo->exec($sql_);
	if($r != false){
		return re_type($retype,$pdo->lastInsertId(),$pdo->errorInfo(),$pdo->errorCode(),true);
	}else{
		return re_type($retype,$pdo->lastInsertId(),$pdo->errorInfo(),$pdo->errorCode(),false);
	}
}
function mysql_update($pdo,$tablename,$arr,$if_A,$if_B,$retype="default"/*number设置数据类型 number-sql数字类型返回MYSQL语句*/){
	if(!isset($if_A) || !isset($if_B) || $if_A=="" || $if_B == ""){
		/*为了数据库安全,没有条件拒绝写入*/
		return false;
	}
	//mysql_update($pdo,$pdo->index_pre."enterprise",$Arr,"id","10");
	//PDO,表名,数组,条件,条件值(必须)
	$sql="update ".$tablename." set ";
	$a="";
	foreach ($arr as $key => $value) {
		if($retype != "number" && $retype != "number-sql"){
		/*如果是数字型,则不加单引号*/
			if(is_numeric($value)){
				//$value=$value;
			}else{
				$value="'".$value."'";
			}
		}
		$a.="`".$key."`=".$value.",";
	}
	$t=rtrim($a,",");
	/*成立where条件*/
	$if_A=explode(",", $if_A);
	$if_B=explode(",", $if_B);
	$if_n=0;
	$where=" where ";
	foreach ($if_A as $value) {
		if(is_numeric($if_B[$if_n])){
		/*如果是数字型,则不加单引号,防止查询出错is_numeric*/
			$if_B_val=$if_B[$if_n];
		}else{
			$if_B_val="'".$if_B[$if_n]."'";
		}
		$where.="`".$value."`=".$if_B_val." and ";
		$if_n++;
	}
	$where=rtrim($where," and ");
	$sql_=$sql.$t.$where;
	if($retype == "sql" || $retype == "number-sql"){
		return $sql_;
	}
	if($retype == "number"){
		$retype="default";
	}
	if($pdo->exec($sql_)){
		//$retype=strtolower($retype);
		return re_type($retype,$pdo->lastInsertId(),$pdo->errorInfo(),$pdo->errorCode(),true);
	}else{
		return re_type($retype,$pdo->lastInsertId(),$pdo->errorInfo(),$pdo->errorCode(),false);
	}
}
//mysql_update(表更新)的配套函数
function re_type($retype,$lastInsertId,$errorInfo,$errorCode,$bool){
	/*可自定义返回方法*/
	switch ($retype) {
		case 'default':
			return $bool;
			break;
		default:
			$re[0]=$bool;
			$re[1]=$lastInsertId;
			$re[2]=$errorInfo;
			$re[3]=$errorCode;
			$re["lastInsertId"]=$re[1];//lastInsertId
			$re["errorInfo"]=$re[2];//errorInfo
			$re["errorCode"]=$re[3];//errorCode
			return $re;
			break;
	}
}
//弹出警告信息
function alert_info($str,$title="系统消息",$click="history.go(-1);"){
	/*弹出警告信息history.go(-1)*/
	return '<link rel="stylesheet" type="text/css" href="/css/component.css" />
<div class="md-modal md-effect-1 md-show" id="modal-1">
<div class="md-content">
<h3>'.$title.'</h3>
<div>
<p>'.$str.'</p>
<ul>
<li><strong>页面:</strong> '.$_SERVER['REQUEST_URI'].'.</li>
<li><strong>时间:</strong> '.date('Y-m-d H:i:s',time()).'.</li>
</ul>
<button class="md-close button_alert" onclick="'.$click.'";>关闭</button>
</div>
</div>
</div>';
}
//快速打印数组 有阻断
function print_arr($a){
	echo "<pre>";
	print_r($a);
	echo "</pre>";
	exit();

}
//快速打印数组 无阻断
function echo_arr($a){
	echo "<pre>";
	print_r($a);
	echo "</pre>";
}

//创建一个企业组
function create_enterprise_group($pdo,$id){

}
//往表里添加载一个字段.
function add_table_field($pdo,$tablename,$fieldname,$fieldtype="text",$COMMENT="''",$DEFAULT="''"){
	$sql="alter table ".$tablename." add `".$fieldname."` ".$fieldtype." DEFAULT ".$DEFAULT." COMMENT ".$COMMENT;
	$pdo->exec($sql);
}
//生成HTML文件
function create_THML____bak($url,$html_path,$document_name,$server){
	if($url=="" || $html_path == ""){
		return false;
	}
	//$html_path=rtrim($html_path,"/"); 
	$ch = curl_init(); 
	//$html = file_get_contents($php_url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);    // 要求结果为字符串且输出到屏幕上
	curl_setopt($ch, CURLOPT_HEADER, 0); // 不要http header 加快效率
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	curl_setopt($ch, CURLOPT_TIMEOUT, 15);
	$html = curl_exec($ch);
	curl_close($ch);
	$html = str_replace("index.php?cloud=form.data_add&table_id=","a/t",$html);//表格连接换为静态
	echo $html;
	$content = ob_get_contents();//取得php页面输出的全部内容
	if(!is_dir($html_path)) {
		//如果目录不存在则创建
	    mkdir($html_path, 0777, true);
	}
	$fp = fopen($html_path.$document_name, "w");
	fwrite($fp, $content);
	fclose($fp);
}

function httpgeturldata($url) 
{   
$ch = curl_init(); 
curl_setopt ($ch, CURLOPT_URL, $url); 
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT,10); 
$content = curl_exec($ch); 
return $content; 
} 

    
//生成HTML文件
function create_THML($php_url,$html_path,$document_name,$server){
	if($php_url=="" || $html_path == ""){
		return false;
	}
	//$html_path=rtrim($html_path,"/"); 
	ob_start();
	$html = httpgeturldata($php_url);
	$html = str_replace("index.php?cloud=form.data_add&table_id=","a/t",$html);//表格连接换为静态
	//$html = str_replace("receive.php","http://".$server["HTTP_HOST"]."receive.php",$html);
	//$html = str_replace("receive.php","http://".$server["HTTP_HOST"]."receive.php",$html);
 

	echo $html;
	$content = ob_get_contents();//取得php页面输出的全部内容
	if(!is_dir($html_path)) {
		//如果目录不存在则创建
	    mkdir($html_path, 0777, true);
	}
	$fp = fopen($html_path.$document_name, "w");
	fwrite($fp, $content);
	fclose($fp);
}

/*生成表单静态*/
function create_table($server,$id,$retype="default"){
	if( $retype == "urlt" ){/*table*/
		return "http://".$server["HTTP_HOST"]."/a/t".$id."/";
	}
	if( $retype == "urlq" ){/*query*/
		return "http://".$server["HTTP_HOST"]."/a/q".$id."/";
	}
	/*create_table($_SERVER,$id);*/
	create_THML("http://".$server["HTTP_HOST"]."/index.php?cloud=form.data_add&table_id=".$id,"./a/t".$id."/","index.html",$server);
	create_THML("http://".$server["HTTP_HOST"]."/index.php?cloud=form.data_show_list&table_id=".$id,"./a/q".$id."/","index.html",$server);
}


function https_get($url, $args=null, $method="post", $withCookie = false, $headers=array())
{
    $ch = curl_init();
    $data = "";
    if(!empty($args)){
	    $data = "?";
	    foreach ($args as $k => $v) {
	        $data.=$k."=".$v."&";
	    }
	    $data=rtrim($data,"&");
    }
    $url .= $data;
    //$url = url_encode($url);
    //return $url;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.47 Safari/536.11');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    if(!empty($headers)) 
    {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    if($withCookie)
    {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
    }
    $r = curl_exec($ch);
    curl_close($ch);
    return $r;
}

function get_haodateserver($args=array())
{
    $url="http://www.haoservice.com/RegAndLogin/userlogin";
    //return $url;
    $re=https_post($url,$args);
    return $re;
}
function echo_content($type=null,$gets=array()){
	if(empty($gets) || empty($type)){
		return false;
	}
	switch($type){
		case 'container_list':
		$arr=array('feedback.list','diypage.show');
		$m = @$gets['m'];
		if(in_array($m,$arr)){
			echo '<div class="container_list"></div>';/*输入其他页面广告*/
		}
		break;
	}
}
