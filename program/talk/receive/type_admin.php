<?php
		foreach($_GET as $key=>$v){
			if($v==''){exit("{'state':'$key','info':'<span class=fail>".@self::$language[$key]."".self::$language['is_null']."</span>'}");}
		}
		$act=@$_GET['act'];
		if($act=='add'){
			$_GET['parent']=intval(@$_GET['parent']);
			if($_GET['parent']>0){
				$sql="select count(id) as c from ".self::$table_pre."type where `id`='".$_GET['parent']."'";
				$r=$pdo->query($sql,2)->fetch(2);
				if($r['c']==0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['parent_not_exist']."'}");}
				$sql="select `read_power`,`title_power`,`content_power` from ".self::$table_pre."type where `id`='".$_GET['parent']."'";
				$r=$pdo->query($sql,2)->fetch(2);
			}
			$_GET['sequence']=intval(@$_GET['sequence']);
			$_GET['visible']=intval(@$_GET['visible']);
			$_GET['name']=safe_str(@$_GET['name']);
			$sql="insert into ".self::$table_pre."type (`parent`,`name`,`sequence`,`visible`,`manager`,`read_power`,`title_power`,`content_power`) values ('".$_GET['parent']."','".$_GET['name']."','".$_GET['sequence']."','".$_GET['visible']."','".$_SESSION['user']['username']."','".@$r['read_power']."','".@$r['title_power']."','".@$r['content_power']."')";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>','id':'".$pdo->lastInsertId()."'}");
			}else{
				exit("{'state':'fail','info':'<span class=fail>".self::$language['fail']."</span>'}");
			}
		}
		if($act=='update'){
			$_GET['id']=intval(@$_GET['id']);
			$_GET['parent']=intval(@$_GET['parent']);
			$_GET['sequence']=intval(@$_GET['sequence']);
			$_GET['manager']=safe_str(@$_GET['manager']);
			$_GET['visible']=intval(@$_GET['visible']);
			$_GET['name']=safe_str(@$_GET['name']);
			//var_dump($_GET);
			if(get_user_id($pdo,$_GET['manager'])==''){exit("{'state':'fail','info':'<span class=fail>".self::$language['manager'].self::$language['not_exist']."</span>'}");}
			$sql="update ".self::$table_pre."type set `parent`='".$_GET['parent']."',`name`='".$_GET['name']."',`sequence`='".$_GET['sequence']."',`manager`='".$_GET['manager']."',`visible`='".$_GET['visible']."' where `id`='".$_GET['id']."'";
			if($pdo->exec($sql)){
				exit("{'state':'success','info':'<span class=success>".self::$language['success']."</span>'}");
			}else{
				exit("{'state':'success','info':'<span class=success>&nbsp;</span>".self::$language['executed']."'}");
			}
		}
		if($act=='update_visible'){
			$_GET['id']=intval(@$_GET['id']);
			$_GET['visible']=intval(@$_GET['visible']);
			$sql="update ".self::$table_pre."type set `visible`='".$_GET['visible']."' where `id`='".$_GET['id']."'";	
			$pdo->exec($sql);
			exit();
		}
		if($act=='del'){
			$id=intval(@$_GET['id']);
			if($id<1){exit();}
			$sql="select count(id) as c from ".self::$table_pre."type where `parent`='$id'";
			$r=$pdo->query($sql,2)->fetch(2);
			if($r['c']!=0){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['have_sub']."'}");}
			$sql="select count(id) as c from ".self::$table_pre."title where `type`='$id'";
			$r2=$pdo->query($sql,2)->fetch(2);

			$sql="delete from ".self::$table_pre."type where `id`='$id'";
			if($pdo->exec($sql)){
				@safe_unlink('./program/talk/type_icon/'.$id.'.png');
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
				$sql="select count(id) as c from ".self::$table_pre."type where `parent`='$id'";
				$r=$pdo->query($sql,2)->fetch(2);
				
				$sql="select count(id) as c from ".self::$table_pre."title where `type`='$id'";
				$r2=$pdo->query($sql,2)->fetch(2);
								
				if($r['c']==0 && $r2['c']==0){
					$sql="delete from ".self::$table_pre."type where `id`='$id'";
					if($pdo->exec($sql)){@safe_unlink('./program/talk/type_icon/'.$id.'.png');$success.=$id."|";}
				}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		if($act=='operation_visible'){
			$ids=@$_GET['ids'];
			if($ids==''){exit("{'state':'fail','info':'<span class=fail>&nbsp;</span>".self::$language['select_null']."'}");}
			$ids=str_replace("|",",",$ids);
			$ids=trim($ids,",");
			$ids=explode(",",$ids);
			$ids=array_map('intval',$ids);
			$temp='';
			foreach($ids as $id){
				$temp.=$id.",";	
			}
			$ids=trim($temp,","); 
			$_GET['visible']=intval(@$_GET['visible']);
			$sql="update ".self::$table_pre."type set `visible`='".$_GET['visible']."' where `id` in ($ids)";
			$pdo->exec($sql);
			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>'}");
		}
		
		if($act=='submit_select'){
			$success='';
			foreach($_POST as $v){
				$v['id']=intval($v['id']);
				$v['parent']=intval($v['parent']);
				$v['sequence']=intval($v['sequence']);
				$v['name']=safe_str($v['name']);
				$v['manager']=safe_str($v['manager']);
				if(get_user_id($pdo,$v['manager'])==''){$v['manager']='';}
				$sql="update ".self::$table_pre."type set `parent`='".$v['parent']."',`name`='".$v['name']."',`sequence`='".$v['sequence']."',`manager`='".$v['manager']."' where `id`='".$v['id']."'";
				if($pdo->exec($sql)){$success.=$v['id']."|";}
			}
			$success=trim($success,"|");			
			exit("{'state':'success','info':'<span class=success>".self::$language['executed']."</span> <a href=javascript:window.location.reload();>".self::$language['refresh']."</a>','ids':'".$success."'}");
		}
		
