<?php
if($_GET['update'] == "update_enterprise"){
	$username=return_table_info($pdo,$pdo->index_pre."enterprise","id","username",$_SESSION["user"]["username"],false);
	$authentication=return_table_info($pdo,$pdo->index_pre."enterprise","authentication","username",$_SESSION["user"]["username"],false);//判断认证状态

	$Arr["enterprisename"]=@$_GET["enterprisename"];
	$Arr["enterprisecode"]=@$_GET["enterprisecode"];
	$Arr["enterprise_person"]=@$_GET["enterprise_person"];
	$Arr["enterprise_contact"]=@$_GET["enterprise_contact"];
	$Arr["enterprisephone"]=@$_GET["enterprisephone"];
	$Arr["enterprise_photo"]=@$_GET["enterprise_photo"];
	$Arr["enterpriseide_a"]=@$_GET["enterpriseide_a"];
	$Arr["enterpriseide_b"]=@$_GET["enterpriseide_b"];
	$Arr["enterpriseadd"]=@$_GET["enterpriseadd"];
	$Arr["enterprisecale"]=@$_GET["enterprisecale"];
	$Arr["username"]=$_SESSION["user"]["username"];

	if($authentication == 1){
		exit("你已经认证过了");
	}

	if( $username != "" && $authentication != 1){//authentication认证状态为其他.
		//如果有则更新.
		$Arr["authentication"]="0";
		$Arr["state"]="0";
		$Arr["remark"]="认证中";
		if(mysql_update($pdo,$pdo->index_pre."enterprise",$Arr,"username",$_SESSION["user"]["username"])){
		exit("ok");
		}else{
			exit("未作任何修改");
		}
	}

	$Arr["authentication"]="0";
	$Arr["state"]="0";
	$Arr["remark"]="认证中";
	if(mysql_write($pdo,$pdo->index_pre."enterprise",$Arr)){
		exit("ok");
	}else{
		exit("no");
	}
	
}

$update=strtolower(safe_str(@$_GET['update'],1,0));
//echo $update;
$$update=safe_str(@$_POST[$update],1,0);
//echo $$update;
$forbid=array('id','username','group','money','state','identifying','phone','email','introducer');
if(in_array($update,$forbid)){exit("forbid update $update field");}
$allow=array('manager','nickname','icon','banner','tel','address','chat_type','chat','home_area','current_area','birthday','introducer','real_name','license_type','license_id','license_photo_front','license_photo_reverse','gender','blood_type','profession','education','height','weight','married','annual_income','domain','homepage','chip','password','transaction_password','new_transaction_password','confirm_new_transaction_password','add_transaction_password','old_password','new_password','confirm_new_password','old_transaction_password','weixincode'); //允许提交的数据字段
if(!in_array($update,$allow)){exit("forbid update $update field");}
function is_same($pdo,$field,$v){
	$sql="select count(id) as c from ".$pdo->index_pre."user where `$field`='".$v."' and `id`!='".$_SESSION['user']['id']."'";
	$v=$pdo->query($sql,2)->fetch(2);
	if($v['c']!=0){return false;}else{return true;}

}

switch ($update) {
	case 'introducer':
		$sql="select `$update` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v[$update]!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['forbidden_modify']."</span>'}");}
		$sql="select id from ".$pdo->index_pre."user where `username`='".$$update."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['username_err']."</span>'}");}
		if($v['id']>=$_SESSION['user']['id']){exit("{'state':'fail','info':'<span class=fail>".self::$language['introducer'].self::$language['illegal']."</span>'}");}
		break;
	case 'real_name':
		$sql="select `$update` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v[$update]!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['forbidden_modify']."</span>'}");}
		break;
	case 'manager':
		$sql="select `group` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$sql="select `parent` from ".$pdo->index_pre."group where `id`='".$r['group']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		$group=$r['parent'];
		$sql="select `id`,`group` from ".$pdo->index_pre."user where `real_name`='".$$update."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['id']==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['parent_not_exist']."</span>'}");}
		if($r['group']!=$group){exit("{'state':'fail','info':'<span class=fail>".self::$language['not_your_parent']."</span>'}");}
		$$update=$r['id'];
		
		break;
	case 'nickname':
		if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
		break;
	case 'license_id':
		if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
		break;
	case 'domain':
		if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
		break;
	case 'chip':
		if(!is_same($pdo,$update,$$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['exist']."</span>'}");}
		break;
	case 'birthday':
		$$update=get_unixtime($$update,self::$config['other']['date_style']);
		if($$update>time()){exit("{'state':'fail','info':'<span class=fail>".self::$language['illegal']."</span>'}");}
		break;	
	case 'homepage':
		$$update=strtolower($$update);
		if(substr($$update,0,4)!='http'){$$update="http://".$$update;}
		if(!is_url($$update)){exit("{'state':'fail','info':'<span class=fail>".self::$language['homepage'].self::$language['pattern_err']."</span>'}");}
		break;
		
	case 'old_password':	
		//echo 'old_password';
		$$update=md5($$update);
		$sql="select `password` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		//echo $sql;
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['password']!=$$update){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['right']."'}");	
		}
		break;
	case 'new_password':	
		if(mb_strlen($$update,'utf-8')<6){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['qualified']."'}");	
		}
		break;
	case 'confirm_new_password':	
		if(mb_strlen($$update,'utf-8')<6){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['qualified']."'}");	
		}
		break;
	case 'password':
		if(@$_POST['new_password']==@$_POST['old_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['password_new_equal_old']."</span>'}");}
		if(@$_POST['new_password']!=@$_POST['confirm_new_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['twice_password_not_same']."</span>'}");}
		if(mb_strlen(@$_POST['new_password'],'utf-8')<6){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");}
		$_POST['old_password']=md5(@$_POST['old_password']);
		$sql="select `password` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['password']!=$_POST['old_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['old_password'].self::$language['err']."</span>'}");}
		$$update=md5($_POST['confirm_new_password']);
		break;	



	case 'old_transaction_password':	
		$$update=md5($$update);
		$sql="select `transaction_password` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		//echo $sql;
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['transaction_password']!=$$update){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['err']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['right']."'}");	
		}
		break;
	case 'new_transaction_password':	
		if(mb_strlen($$update,'utf-8')<6){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['qualified']."'}");	
		}
		break;
	case 'confirm_new_transaction_password':	
		if(mb_strlen($$update,'utf-8')<6){
			exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");
		}else{
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['qualified']."'}");	
		}
		break;
	case 'transaction_password':
		if(@$_POST['new_transaction_password']==@$_POST['old_transaction_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['transaction_password_new_equal_old']."</span>'}");}
		if(@$_POST['new_transaction_password']!=@$_POST['confirm_new_transaction_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['twice_transaction_password_not_same']."</span>'}");}
		if(mb_strlen(@$_POST['new_transaction_password'],'utf-8')<6){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");}
		$_POST['old_transaction_password']=md5(@$_POST['old_transaction_password']);
		$sql="select `transaction_password` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['transaction_password']!=$_POST['old_transaction_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['old_transaction_password'].self::$language['err']."</span>'}");}
		$$update=md5($_POST['confirm_new_transaction_password']);
		break;	
		
	case 'add_transaction_password':
		if(@$_POST['new_transaction_password']!=@$_POST['confirm_new_transaction_password']){exit("{'state':'fail','info':'<span class=fail>".self::$language['twice_transaction_password_not_same']."</span>'}");}
		if(mb_strlen(@$_POST['new_transaction_password'],'utf-8')<6){exit("{'state':'fail','info':'<span class=fail>".self::$language['less_six']."</span>'}");}
		$update='transaction_password';
		$$update=md5(@$_POST['confirm_new_transaction_password']);
		$sql="select `transaction_password` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
		$v=$pdo->query($sql,2)->fetch(2);
		if($v['transaction_password']!=''){exit("{'state':'fail','info':'<span class=fail>".self::$language['old_transaction_password'].self::$language['err']."</span>'}");}

		break;	
		
		
}
if($update=='icon' || $update=='license_photo_front' || $update=='license_photo_reverse'|| $update=='weixincode'){
	$sql="select `$update` from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	//删除文件
	@safe_unlink("./upload/index/user_{$update}/".$r[$update]);
	if($update=='icon'){$_SESSION['user']['icon']=$$update;}
	//$$update=trim($$update,"|");
}
$sql="update ".$pdo->index_pre."user set `$update`='".$$update."' where `id`='".$_SESSION['user']['id']."'";
$temp=explode('group',strtolower($sql));
if(isset($temp[1])){exit("{'state':'success','info':'<span class=success>group err</span>'}");}
if($pdo->exec($sql)){
	exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
}else{
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span>'}");
}
