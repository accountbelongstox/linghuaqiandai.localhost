<?php

	$_POST['money']=floatval(@$_POST['money']);
	if($_POST['money']==0){exit('money_err');}
	$_POST['return_url']=safe_str(@$_POST['return_url']);
	//var_dump($_POST);var_dump($_GET);exit;
	
	//if($_POST['return_url']==''){$_POST['return_url']='http://'.$_SERVER['SERVER_NAME'].'/payment/alipay/return_url.php';}

	$_POST['title']=self::$language['for2'].self::$language['account'].$_SESSION['user']['username'].self::$language['recharge'];
	
	$_POST['pay_info']=safe_str(@$_POST['pay_info']);
	$_POST['pay_photo']=safe_str(@$_POST['pay_photo']);
	if($_POST['pay_photo']!=''){
		$temp=explode("|",$_POST['pay_photo']);	
		$_POST['pay_photo']=$temp[count($temp)-1];
	}

	if($_POST['pay_info']=='' && $_POST['pay_photo']==''){$state=2;$method='online_payment';}else{$state=1;$method='offline_payment';$_POST['return_url']='./index.php?cloud=index.recharge_log';$_POST['payment']='offline_pay';}
	$sql="insert into ".$pdo->index_pre."recharge (`username`,`money`,`time`,`state`,`title`,`return_url`,`pay_info`,`pay_photo`,`method`,`type`) values ('".$_SESSION['user']['username']."','".$_POST['money']."','".time()."','".$state."','".$_POST['title']."','".$_POST['return_url']."','".$_POST['pay_info']."','".$_POST['pay_photo']."','$method','".safe_str($_POST['payment'])."')";
	
	if($pdo->exec($sql)){
		$new_id=$pdo->lastInsertId();
		$in_id=date('Ymdh',time()).$new_id;
		$sql="update ".$pdo->index_pre."recharge set `in_id`='".$in_id."' where `id`=".$new_id;
		$pdo->exec($sql);
		
		if($state==1){
			if(is_file("./temp/".$_POST['pay_photo'])){
				@mkdir('./program/index/pay_photo/'.date("Y").'_'.date('m'));
				@mkdir('./program/index/pay_photo/'.date("Y").'_'.date('m').'/'.date('d'));
				safe_rename("./temp/".$_POST['pay_photo'],"./program/index/pay_photo/".$_POST['pay_photo']);	
			}
			//exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['submit'].self::$language['success'].",".self::$language['recharge_state'][1]." <a href='/index.php?cloud=index.user'>".self::$language['return']."</a>'}");
			exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['submit'].self::$language['success'].",".self::$language['recharge_state'][1]." <a href='".str_replace('|||','&',urldecode($_POST['return_url']))."' class=return_button>".self::$language['return']."</a>'}");
		}else{
			
			$temp=explode('scanpay_',$_POST['payment']);
			if(!isset($temp[1])){
				echo '<form id="payment_form" name="payment_form" method="POST" action="./payment/'.$_POST['payment'].'/">
  <input type="hidden" name="id" id="id" value="'.$in_id.'" />
  <input type="hidden" name="money" id="money" value="'.$_POST['money'].'" />
  <input type="hidden" name="title" id="title" value="'.$_POST['title'].'" />
  <input type="hidden" name="notify_url" id="return_url" value="'.@$_POST['notify_url'].'" />
  <input type="hidden" name="return_url" id="return_url" value="'.@$_POST['return_url'].'" />
</form>
';
			}else{
				$payment=safe_str($temp[1]);
				$sql="select `id` from ".$pdo->sys_pre."scanpay_account where `type`='".$payment."' and `is_web`=1 and `state`=1 order by `sequence` desc limit 0,1";
				$t=$pdo->query($sql,2)->fetch(2);
				echo '<form id="payment_form" name="payment_form" method="post" action="./index.php?cloud=scanpay.pay&id='.$t['id'].'">
  <input type="hidden" name="success_fun" id="success_fun" value="update_recharge|'.$in_id.'" />
  <input type="hidden" name="money" id="money" value="'.$_POST['money'].'" />
  <input type="hidden" name="payer" id="payer" value="'.$_SESSION['user']['username'].'" />
  <input type="hidden" name="reason" id="reason" value="'.self::$language['recharge'].'" />
</form>
';
			}
			
			exit;
		}
	}else{
		exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");	
	}
		
