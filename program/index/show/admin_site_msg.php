<?php

$authority=check_is_admin_user($pdo,$_SESSION);
			$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
			$_GET['search']=safe_str(@$_GET['search']);
			$_GET['search']=trim($_GET['search']);
			$_GET['current_page']=(intval(@$_GET['current_page']))?intval(@$_GET['current_page']):1;
			$page_size=self::$module_config[str_replace('::','.',$method)]['pagesize'];
$page_size=(intval(@$_GET['page_size']))?intval(@$_GET['page_size']):$page_size;
$page_size=min($page_size,100);

			$sql="select * from ".$pdo->index_pre."msg_template";
			
			$where="";
			if(is_numeric(@$_GET['state'])){$where=" and `state`='".$_GET['state']."'";}
			if($_GET['search']!=''){$where=" and (`title` like '%".$_GET['search']."%' or `content` like '%".$_GET['search']."%' or `username` like  '%".$_GET['search']."%' or `state` like  '%".$_GET['search']."%')";}
			if(@$_GET['order']==''){
				$order=" order by `id` desc";
			}else{
				$_GET['order']=safe_str($_GET['order']);
				$temp=safe_order_by($_GET['order']);
				if($temp[1]=='desc' || $temp[1]=='asc'){$order=" order by `".$temp[0]."` ".$temp[1];}else{$order='';}
					
			}
			$limit=" limit ".($_GET['current_page']-1)*$page_size.",".$page_size;
				$sum_sql=$sql.$where;
				$sum_sql=str_replace(" * "," count(id) as c ",$sum_sql);
				$sum_sql=str_replace("_msg_template and","_msg_template where",$sum_sql);
				$r=$pdo->query($sum_sql,2)->fetch(2);
				$sum=$r['c'];

			switch ($authority) {//非管理员查询限制 
				case 1:
					//管理员则没有查询限制
					break;
				case 2:
					$where=" and `username`='".$_SESSION["user"]["username"]."'";
					break;
				default:
					$where=" and `username`='".$_SESSION["user"]["username"]."'";
					break;
			}

			$sql=$sql.$where.$order.$limit;
			$sql=str_replace("_msg_template and","_msg_template where",$sql);
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($v['template_id']== ""){
					$v['template_id']="-";
				}

				if($authority == 1){//管理员
					/*
                <td >提交用户</td>
                <td >短信签名</td>
                <td >短信内容</td>
                <td >模板ID</td>
                <td >提交时间</td>
                <td >审核状态</td>
                <td >未通过原因</td>
                <td >操作</td>
                */
                /*
				addressee_state 未通过原因
                */
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
			 	<td class=operation_td>
			 	<select class='edit edit_select' data-id='".$v['id']."'>
			 		<option value=''>操作</option>
				 	<option value='通过'>通过</option>
				 	<option value='不通过'>不通过</option>
			 	</select>
			 	<a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			 	<td>".$v['username']."</td>
			 	<td>".$v['title']."</td>
				<td>".$v['content']."</td>
			 	<td>".$v['template_id']."</td>
			 	<td>".get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$v['time'])."</td>
			 	<td><span style='color:#4E9D4E'>".$v['state']."</span></td>
				<td>".$v['explain']."</td>
			</tr>";			
				}

				if($authority == 2){//普通用户
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
			 	<td>".$v['template_id']."</td>
				<td>".$v['content']."</td>
			 	<td><span style='color:#4E9D4E'>".$v['state']."</span></td>
				<td>".$v['explain']."</td>
			 	<td>".$v['state']."</td>
			 	<td class=operation_td><a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			</tr>";			
				}

			}
		if($sum==0){$list='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['filter']="<select id='state' name='state'><option value='-1'>".self::$language['state']."</option><option value='' selected>".self::$language['all']."</option><option value='0'>".self::$language['site_msg_state'][0]."</option><option value='4'>".self::$language['site_msg_state'][4]."</option></select>";
		$module['list']=$list;
		$module['page']=cloudDigitPage($sum,$_GET['current_page'],$page_size,'#'.$module['module_name'],self::$language['page_template']);
		
		switch ($authority) {
			case 1:
			$module["thead"]='
            <tr>                 
                <td><input type="checkbox" group-checkable=1></td>
                <td >操作</td>
                <td >提交用户</td>
                <td >短信签名</td>
                <td >短信内容</td>
                <td >模板ID</td>
                <td >提交时间</td>
                <td >审核状态</td>
                <td >未通过原因</td>
            </tr>';
				break;
			case 2:		
			$module["thead"]='
            <tr>                 
                <td><input type="checkbox" group-checkable=1></td>
                <td >模板ID</td>
                <td >模板</td>
                <td >审核状态</td>
                <td >未通过原因</td>
                <td >模板类型</td>
                <td >操作</td>
            </tr>';
				break;
			default:
				$module["thead"]=alert_info("该权限还未向您开放,敬请谅见");
				break;
		}
$module['sms100']=self::$config["api"]["sms_money"]*100;
$module['sms500']=self::$config["api"]["sms_money"]*500;
$module['sms1000']=self::$config["api"]["sms_money"]*1000;
$module['sms5000']=self::$config["api"]["sms_money"]*5000;
$module['sms10000']=self::$config["api"]["sms_money"]*10000;
$module['money']=return_username_info($pdo,$_SESSION["user"]["username"],"money");
$module['msg_money']=return_username_info($pdo,$_SESSION["user"]["username"],"msg_money");


		//print_arr($_SESSION);
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	