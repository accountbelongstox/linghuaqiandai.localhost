<?php
		$act=@$_GET['act'];
		$id=intval(@$_GET['id']);


		if($act=='del'){
			$sql="select `username`,`content` from ".$pdo->index_pre."msg_template where `id`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);

				if(check_is_admin_user($pdo,$_SESSION) != 1 && $r["username"] != $_SESSION["user"]["username"]){
					exit("您没有权限");
				}
			$sql="delete from ".$pdo->index_pre."msg_template where `id`='$id'";
			if($pdo->exec($sql)){
				$sql="select count(id) as c from ".$pdo->index_pre."msg_template where `content`='".$r['content']."'";
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['c']==0){
					$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
					$imgs=get_match_all($reg,$r['content']);
					reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
				}
							
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
				$sql="select `content`,`username` from ".$pdo->index_pre."msg_template where `id`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);

				if(check_is_admin_user($pdo,$_SESSION) != 1 && $r["username"] != $_SESSION["user"]["username"]){
					exit("您没有权限");
				}

				$sql="delete from ".$pdo->index_pre."msg_template where `id`='$id'";
				if($pdo->exec($sql)){
					$sql="select count(id) as c from ".$pdo->index_pre."msg_template where `content`='".$r['content']."'";
					$r2=$pdo->query($sql,2)->fetch(2);
					if($r2['c']==0){
						$reg='#<img.*src=&\#34;(program/'.self::$config['class_name'].'/attachd/.*)&\#34;.*>#iU';
						$imgs=get_match_all($reg,$r['content']);
						reg_attachd_img("del",self::$config['class_name'],$imgs,$pdo);	
					}
					$success.=$id."|";
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
		if($act=='update_msg'){

                $arr["title"]=$_GET["msgtitle"];
               	$arr["content"]=$_GET["msgcontent"];
               	$arr["time"]=time();
               	$arr["state"]="审核中";
               	$arr["username"]=$_SESSION["user"]["username"];
               	$arr["explain"]="无";//说明
               	$arr["type"]="自定义";
               	$arr["statistics"]=0;
               	$arr["template_id"]="";

                //addressee_state 被拒原因
                //$sql="insert into ".$pdo->index_pre."site_msg (`state`,`sender`,`addressee`,`title`,`content`,`time`,`sender_state`,`addressee_state`) values('审核中','".$_SESSION["user"]["username"]."','".$_SESSION["user"]["username"]."','".$msgtitle."','【".$msgtitle."】".$msgcontent."',".time().",'自定义','无')";
                //exit($sql);
                if(table_write($pdo,$pdo->index_pre."msg_template",$arr)){
					exit("ok");
                }else{
                	//exit(var_dump($pdo->errorInfo()));
					exit("no");
                }

		}
		if($act=='edit'){
                //addressee_state 被拒原因
				if(check_is_admin_user($pdo,$_SESSION) != 1 ){
					exit("您没有权限");
				}
				$type=$_GET["type"];
				$id=$_GET["id"];

				if( $type == "yes"){
					$state="通过";
					$template_id=$_GET["value"];
					$addressee_state="无";
				}else{
					$state="不通过";
					$template_id="-";
					$addressee_state=$_GET["value"];
				}

                $sql="update ".$pdo->index_pre."msg_template set `template_id`='".$template_id."',`state`='".$state."',`explain`='".$addressee_state."' where `id`=".$id;
                //exit($sql);
                if($pdo->exec($sql)){
					exit("ok");
                }else{
                	//exit(var_dump($pdo->errorInfo()));
					exit("no");
                }

		}
		if($act=='buy_sms'){
				$arr["msg_money"]=$_GET["number"];
				$conf=require("./config.php");
				$_money=$arr["msg_money"]*$conf["api"]["sms_money"];
				$userMoney=return_username_info($pdo,$_SESSION["user"]["username"],"money");
				//exit($_money);
				if($userMoney < $_money){
					exit("no");
				}
                $sql="update ".$pdo->index_pre."user set `money`=money-".$_money.",`msg_money`=msg_money+".$arr["msg_money"]." where `username`='".$_SESSION["user"]["username"]."'";
                //exit($sql);
                if($pdo->exec($sql)){
                	$arrset=array();
                	$arrset["time"]=time();
                	$arrset["username"]=$_SESSION["user"]["username"];
                	$arrset["money"]="-".$_money;
                	$arrset["reason"]="购买短信包".$arr["msg_money"]."条";
                	$arrset["operator"]=$_SESSION["user"]["nickname"];
                	$arrset["program"]="index";
                	$arrset["before_money"]=$userMoney;
                	$arrset["after_money"]=return_username_info($pdo,$_SESSION["user"]["username"],"money");
                	$arrset["ip"]=$_SERVER['REMOTE_ADDR'];
                	mysql_write($pdo,$pdo->index_pre."money_log",$arrset);
					exit("ok");
                }else{
					exit("no");
                }
                exit("no");
		}
		