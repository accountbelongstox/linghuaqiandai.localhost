<?php
if(empty(@$_GET))
{
	exit("{'state':'$key','info':'<span class=fail>GET值".self::$language['is_null']."</span>'}");
}
foreach($_GET as $key=>$v){
	if($v == ''){
		exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");
	}
}
$_GET['id'] =intval(@$_GET['id']);
$_GET['parent'] =intval(@$_GET['parent']);
$_GET['sequence'] =intval(@$_GET['sequence']);
$_GET['credits'] =intval(@$_GET['credits']);
$_GET['reg_able'] =intval(@$_GET['reg_able']);
$_GET['require_check'] =intval(@$_GET['require_check']);
$_GET['require_login'] =intval(@$_GET['require_login']);
$_GET['name']= safe_str(@$_GET['name']);
$act=$_GET['act'];
$_GET['is_admin']=intval(@$_GET['is_admin']);
if($_GET['id'] == 1){
	exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>该组不能修改'}");
}
if($act=='add'){
	if($_GET['parent']>0){
		$sql="select count(id) as c from ".$pdo->index_pre."group where `id`='".$_GET['parent']."'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
	}else{exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}

	if($_GET['is_admin'] == 1){
		//可否注册
		$_GET['reg_able']=0;
		//是否审核
		$_GET['require_check']=1;
		//升级积分
		$_GET['credits']=0;
		//初始权限
		$page_power="index.personal_center,ci.my_info,ci.reflash,ci.top,ci.user_sum,talk.add,talk.my,talk.title_add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question,form.table_admin,form.table_add,form.table_edit,form.field_edit,form.data_admin,form.data_edit,form.power,form.sum,index.admin_users,weixin.admin_index,weixin.account_add,feedback.index,feedback.admin,feedback.config,form.field_add,index.edit_page_layout,form.table_admin,form.field_add,index.personal_center,mall.agent_finance,index.my_share,index.my_share_visit,index.my_share_reg,mall.my_agent,talk.index,talk.type_admin,talk.set_group,talk.type,talk.type_set,talk.title_set,talk.title_module,talk.title_module_set,talk.sum,talk.my,talk.add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,ci.my_info,ci.reflash,ci.top,ci.user_sum,agency.commission,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,form.table_edit,form.table_css,form.sum,form.table_add,form.data_admin,form.data_edit,diymodule.show_149";
		$function_power=$page_power;
		$require_info="username,password,";
		$map="<li user_color=nv_1><a href=\"./index.php\">首页</a></li><li user_color=nv_1><a  href=\"./index.php?cloud=form.table_admin\"><span>表单审核</span></a></li>";
		$map_update_token="38be83f7fb7c1ffb6630349f603fab3a";
		$user_sum="form.sum,index.user_sum,";
	}else{
		//可否注册
		//$_GET['reg_able']=intval(@$_GET['reg_able']);
		//是否审核
		$_GET['require_check']=0;
		//初始权限
		$page_power="index.personal_center,ci.my_info,ci.reflash,ci.top,ci.user_sum,talk.add,talk.my,talk.title_add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question";
		$function_power=$page_power;
		$map="<li user_color=nv_1><a href=\"./index.php\">首页</a></li><li user_color=nv_1><a href=\"./index.php?cloud=talk.my\"><img src=/templates/1/talk/default/page_icon/talk.my.png /><span>我的谈谈</span><i class=\"fa fa-angle-down\"></i></a><ul><li user_color=nv_2><a href=\"./index.php?cloud=talk.add\"><img src=/templates/1/talk/default/page_icon/talk.add.png /><span>发布新帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_title\"><img src=/templates/1/talk/default/page_icon/talk.my_title.png /><span>我的发帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_content\"><img src=/templates/1/talk/default/page_icon/talk.my_content.png /><span>我的回帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_comment\"><img src=/templates/1/talk/default/page_icon/talk.my_comment.png /><span>我的评论</span></a></li></ul></li>";
		$map_update_token="97aeb30eb3e54254d522f80a3b5e36cc";
		$user_sum="index.user_sum,talk.user_sum,";
	}
	$sql="insert into ".$pdo->index_pre."group (`user_sum`,`map_update_token`,`map`,`require_info`,`function_power`,`page_power`,`is_admin`,`parent`,`name`,`sequence`,`reg_able`,`require_check`,`require_login`,`credits`) values ('".$user_sum."','".$map_update_token."','".$map."','".$require_info."','".$function_power."','".$page_power."',".$_GET['is_admin'].",".$_GET['parent'].",'".$_GET['name']."',".$_GET['sequence'].",".$_GET['reg_able'].",".$_GET['require_check'].",1,".$_GET['credits'].")";
	
	auto_set_table_write($pdo);
	if($pdo->exec($sql)){
		$sql="update ".$pdo->index_pre."group set `deep`='".$this->get_group_deep($pdo,$_GET['parent'])."' where `id`='".$pdo->lastInsertId()."'";
		$pdo->exec($sql);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail'].var_dump($pdo->errorInfo())."</span>'}");
	}
}
if($act=='update'){
	$sql="update ".$pdo->index_pre."group set `is_admin`='".$_GET['is_admin']."',`name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`credits`='".$_GET['credits']."',`reg_able`='".$_GET['reg_able']."',`require_check`='".$_GET['require_check']."',`require_login`='".$_GET['require_login']."' where `id`='".$_GET['id']."'";
	//echo $sql;
	if($pdo->exec($sql)){
		if($_GET['is_admin'] == 1){
			/*可否注册*/
			$reg_able=0;
			/*是否审核*/
			$require_check=1;
			/*升级积分*/
			$_GET['credits']=0;
			/*初始权限*/
			$page_power="index.edit_page_layout,form.table_admin,index.personal_center,mall.agent_finance,index.my_share,index.my_share_visit,index.my_share_reg,mall.my_agent,talk.index,talk.type_admin,talk.set_group,talk.type,talk.type_set,talk.title_set,talk.title_module,talk.title_module_set,talk.sum,talk.my,talk.add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,ci.my_info,ci.reflash,ci.top,ci.user_sum,agency.commission,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,form.table_edit,form.table_css,form.sum,form.table_add,form.data_admin,form.data_edit,diymodule.show_149";
			$function_power="index.edit_page_layout,form.table_admin,index.personal_center,mall.agent_finance,index.my_share,index.my_share_visit,index.my_share_reg,mall.my_agent,talk.index,talk.type_admin,talk.set_group,talk.type,talk.type_set,talk.title_set,talk.title_module,talk.title_module_set,talk.sum,talk.my,talk.add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,ci.my_info,ci.reflash,ci.top,ci.user_sum,agency.commission,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,form.table_edit,form.table_css,form.sum,form.table_add,form.data_admin,form.data_edit,diymodule.show_149";
			$require_info = "username,password,";
			$map = "<li user_color='nv_1'><a href=\"./index.php\">首页</a></li><li user_color='nv_1'><a  href=\"./index.php?cloud=form.table_admin\"><span>表单审核</span></a></li>";
			$map_update_token="38be83f7fb7c1ffb6630349f603fab3a";
			$user_sum="form.sum,index.user_sum,";
		}else{
			/*可否注册*/
			$reg_able=$_GET['reg_able'];
			/*是否审核*/
			$require_check=0;
			$_GET['credits']=@$_GET['credits'];
			/*初始权限*/
			$page_power="index.personal_center,ci.my_info,ci.reflash,ci.top,ci.user_sum,talk.add,talk.my,talk.title_add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question";
			$function_power="index.personal_center,ci.my_info,ci.reflash,ci.top,ci.user_sum,talk.add,talk.my,talk.title_add,talk.my_title,talk.my_content,talk.content_edit,talk.user_sum,talk.my_comment,scanpay.pay,mall.buyer,mall.my_order,mall.buyer_comment,mall.my_order_detail,mall.order_cancel,mall.apply_refund,mall.refund_express_voucher,mall.buyer_sum,mall.coupon,mall.my_cart,mall.my_visit,mall.my_collect,mall.receiver,mall.receiver_add,mall.receiver_edit,mall.coupon_usable,mall.privilege,mall.money_transfer,mall.recommendation,mall.recommendation_gain,agency.buyer,agency.set,agency.buyer_sum,agency.type,agency.shop,agency.order,agency.agency,agency.spread,agency.restock,agency.agency_goods,index.edit_user,index.admin_nv,index.user_sum,index.user,index.edit_phone,index.openid,index.edit_email,index.edit_user&field=password,index.edit_user&field=transaction_password,index.site_msg_addressee,index.site_msg_detail,index.login_log,index.user_set,index.my_oauth,index.financial_center,index.money_log,index.recharge,index.recharge_log,index.withdraw,index.withdraw_log,index.money_transfer,index.money_transfer_log,index.credits_log,index.safe_question_set,index.safe_question";
			$require_info="username,password,nickname,email,phone,transaction_password,";
			$map="<li user_color=nv_1><a href=\"./index.php\">首页</a></li><li user_color=nv_1><a href=\"./index.php?cloud=talk.my\"><img src=/templates/1/talk/default/page_icon/talk.my.png /><span>我的谈谈</span><i class=\"fa fa-angle-down\"></i></a><ul><li user_color=nv_2><a href=\"./index.php?cloud=talk.add\"><img src=/templates/1/talk/default/page_icon/talk.add.png /><span>发布新帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_title\"><img src=/templates/1/talk/default/page_icon/talk.my_title.png /><span>我的发帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_content\"><img src=/templates/1/talk/default/page_icon/talk.my_content.png /><span>我的回帖</span></a></li><li user_color=nv_2><a href=\"./index.php?cloud=talk.my_comment\"><img src=/templates/1/talk/default/page_icon/talk.my_comment.png /><span>我的评论</span></a></li></ul></li>";
			$map_update_token="97aeb30eb3e54254d522f80a3b5e36cc";
			$user_sum="index.user_sum,talk.user_sum,";
		}	
			$sql="update ".$pdo->index_pre."group set `require_info`='".$require_info."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `function_power`='".$function_power."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `require_check`='".$require_check."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `reg_able`='".$reg_able."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `page_power`='".$page_power."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `credits`='".$_GET['credits']."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `map`='".$map."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `map_update_token`='".$map_update_token."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			$sql="update ".$pdo->index_pre."group set `user_sum`='".$user_sum."' where `id`='".$_GET['id']."'";
			$pdo->exec($sql);
			auto_set_table_write($pdo);
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
	}else{
		exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
	}
}
if($act=='del'){
	$config=require("./config.php");
	if(!is_numeric($_GET['id'])){exit();}
	$id=intval(@$_GET['id']);
	if($id == intval($config["reg_set"]["en_group_id"]) or $id == 1 or $id == 13){
		exit("{'state':'fail','info':'<span class=fail>系统保留分组,不可删除!</span>'}");
	}
	$sql="select count(id) as c from ".$pdo->index_pre."group where `parent`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
	
	$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='".$_GET['id']."'";
	$r=$pdo->query($sql,2)->fetch(2);
	if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_user']."'}");}
	
	$sql="delete from ".$pdo->index_pre."group where `id`='".$_GET['id']."'";
	auto_set_table_write($pdo);
	if($pdo->exec($sql)){
		exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
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
		$sql="select count(id) as c from ".$pdo->index_pre."group where `parent`='$id'";
		$r=$pdo->query($sql,2)->fetch(2);
		if($r['c']==0){
			$sql="select count(id) as c from ".$pdo->index_pre."user where `group`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']==0){
				$sql="delete from ".$pdo->index_pre."group where `id`='$id'";
				if($pdo->exec($sql)){$success.=$id."|";}
			}
		}
	}
	$success=trim($success,"|");
	auto_set_table_write($pdo);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
if($act=='submit_select'){
	//var_dump($_POST);	
	$success='';
	foreach($_POST as $v){
		$v['id']=intval($v['id']);
		$v['sequence']=intval($v['sequence']);
		$v['credits']=intval($v['credits']);
		$v['reg_able']=intval($v['reg_able']);
		$v['require_check']=intval($v['require_check']);
		$v['require_login']=intval($v['require_login']);
		$v['name']=safe_str($v['name']);
		$sql="update ".$pdo->index_pre."group set `name`='".$v['name']."',`sequence`='".$v['sequence']."',`credits`='".$v['credits']."',`reg_able`='".$v['reg_able']."',`require_check`='".$v['require_check']."',`require_login`='".$v['require_login']."' where `id`='".$v['id']."'";
		if($pdo->exec($sql)){$success.=$v['id']."|";}
	}
	$success=trim($success,"|");
	auto_set_table_write($pdo);
	exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
}
		