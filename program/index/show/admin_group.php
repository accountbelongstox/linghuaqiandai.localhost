<?php

		function admin_group_get_list($pdo,$language,$parent,$module_name){
			$sql="select * from ".$pdo->index_pre."group";
			$where=" and `parent`='$parent'";
			$order=" order by `sequence` desc";
			$sql=$sql.$where.$order;
			$sql=str_replace("_group and","_group where",$sql);
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($v['reg_able']==1){$reg_able='checked';}else{$reg_able='';}
				if($v['require_login']==1){$require_login='checked';}else{$require_login='';}
				if($v['require_check']==1){$require_check='checked';}else{$require_check='';}
				if($v['is_admin']==1){$is_admin='checked';}else{$is_admin='';}

				//是否管理员
				$is_style="";
				if($v['is_admin'] == 1){
					$is_style="style=\"border:1px solid red;\"";
					$checkbox="hidden";
					$checkbox_txt="-";
				}else{
					$checkbox="checkbox";
					$checkbox_txt="";
				}
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
				<td width=180><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."' class='name' style='width:".(100-$v['deep']*10+10)."%;' /></td>
				<td style='text-align:center'>".index::count_group($pdo,$v['id'])."</td>
          <td><input ".$is_style." type='checkbox' name='is_admin_".$v['id']."' id='is_admin_".$v['id']."' $is_admin /></td>
          <td><input type='".$checkbox."' name='reg_able_".$v['id']."' id='reg_able_".$v['id']."' $reg_able />".$checkbox_txt."</td>
          <td><input type='checkbox' name='require_check_".$v['id']."' id='require_check_".$v['id']."' $require_check  /></td>
          <td><input type='checkbox' name='require_login_".$v['id']."' id='require_login_".$v['id']."' $require_login /></td>
			  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
			  <td><input type='text' name='credits_".$v['id']."' id='credits_".$v['id']."' value='".$v['credits']."' class='credits' /></td>
			  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a>  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a><span id=state_".$v['id']." class='state'></span> </td>
          <td><a href='index.php?cloud=index.edit_group_parent&id=".$v['id']."' class='change_parent'>".$language['change'].$language['parent']."</a></td>
		  <td><a href='index.php?cloud=index.group_require_info&id=".$v['id']."' class='require_info'>".$language['require_info']."</a></td>
          <td><a href='index.php?cloud=index.view_menu&id=".$v['id']."' class='power'>".$language['power']."</a></td>
			</tr>
	";	
			$list.=admin_group_get_list($pdo,$language,$v['id'],$module_name);
		}
			
			return $list;
		}


		function user_group_get_lise($pdo,$language,$parent,$module_name){
			$sql="select * from ".$pdo->index_pre."group where `is_admin' = '0' and 'cretor'= '".$_SESSION["user"]["username"]."'";
			$where=" and `parent`='$parent'";
			$order=" order by `sequence` desc";
			$sql=$sql.$where.$order;
			$sql=str_replace("_group and","_group where",$sql);
			//echo($sql);
			//exit();
			$r=$pdo->query($sql,2);
			$list='';
			foreach($r as $v){
				if($v['reg_able']==1){$reg_able='checked';}else{$reg_able='';}
				if($v['require_login']==1){$require_login='checked';}else{$require_login='';}
				if($v['require_check']==1){$require_check='checked';}else{$require_check='';}
				if($v['is_admin']==1){$is_admin='checked';}else{$is_admin='';}

				//是否管理员
				$is_style="";
				if($v['is_admin'] == 1){
					$is_style="style=\"border:1px solid red;\"";
				}
				$list.="<tr id='tr_".$v['id']."'>
				<td><input type='checkbox' name='".$v['id']."' id='".$v['id']."' class='id' /></td>
				<td width=180><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."' class='name' style='width:".(100-$v['deep']*10+10)."%;' /></td>
				<td style='text-align:center'>".index::count_group($pdo,$v['id'])."</td>
          <td><input style=\"display:none\" type='checkbox' name='reg_able_".$v['id']."' id='reg_able_".$v['id']."' $reg_able /><input ".$is_style." type='checkbox' name='is_admin_".$v['id']."' id='is_admin_".$v['id']."' $is_admin /></td>
          <td></td>
          <td><input type='checkbox' name='require_check_".$v['id']."' id='require_check_".$v['id']."' $require_check  /></td>
          <td><input type='checkbox' name='require_login_".$v['id']."' id='require_login_".$v['id']."' $require_login /></td>
			  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."' class='sequence' /></td>
			  <td><input type='text' name='credits_".$v['id']."' id='credits_".$v['id']."' value='".$v['credits']."' class='credits' /></td>
			  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".$language['submit']."</a>  <a href='#' onclick='return del(".$v['id'].")'  class='del'>".$language['del']."</a><span id=state_".$v['id']." class='state'></span> </td>
          <td><a href='index.php?cloud=index.edit_group_parent&id=".$v['id']."' class='change_parent'>".$language['change'].$language['parent']."</a></td>
		  <td><a href='index.php?cloud=index.group_require_info&id=".$v['id']."' class='require_info'>".$language['require_info']."</a></td>
          <td><a href='index.php?cloud=index.view_menu&id=".$v['id']."' class='power'>".$language['power']."</a></td>
			</tr>
	";	
			$list.=admin_group_get_list($pdo,$language,$v['id'],$module_name);
		}
			
			return $list;
		}
		
		switch (check_is_admin_user($pdo,$_SESSION)) {
			case 1://管理员
				$module['list']=admin_group_get_list($pdo,self::$language,0,$module['module_name']);
				$module['tbody']='<tr id="group_new">
		                <td colspan="2" id="new_td_first" style="text-align:left;"><div>
		                <?php echo self::$language["parent"]?>：<select name="parent_new" id="parent_new" class="group_parent" >
		                <option value="-1"><?php echo self::$language["select_please"]?></option>
		                <?php echo $module["parent"]?>
		                </select></div><div><span class="pro_span"><?php echo self::$language["name"]?>：</span><input type="text" name="name_new" id="name_new" class="group_name"/></div>
		              <div><span style="color:red;">是否管理员组：</span><input type="checkbox" name="is_admin" id="is_admin" /></div>
		              </td>
		              <td>&nbsp;</td>
		              <td></td>
		              <td><input type="hidden" name="require_check_new" id="require_check_new" checked="checked"  /></td>
		              <td><input type="hidden" name="require_login_new" id="require_login_new" checked="checked"  /></td>
		              <td><input type="text" name="sequence_new" id="sequence_new" value="0" class="sequence" /></td>
		              <td><input type="text" name="credits_new" id="credits_new" value="0" class="credits" /></td>
		              <td id="new_td_last" style="text-align:left;"><a href="#" onclick="return add()"  class="add"><?php echo self::$language["add"]?></a> <span id=state_new  class="group_state"></span> </td>
		              <td>&nbsp;</td>
		              <td>&nbsp;</td>
		              <td>&nbsp;</td>
		              <td>&nbsp;</td>
		            </tr>';
				break;
			case 2:

				//$module['list']=user_group_get_list($pdo,self::$language,0,$module['module_name']);
				$module['list']=alert_info("该页面权限还未开放,请耐心等待");
				$module['tbody']="";
				break;
			default:
				$module['list']="该权限还未开放";
				$module['tbody']="";
				break;
		}

		$count=1;
		$module['parent']=index::get_group_select($pdo,'-1',0);
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$name_count=0;
		$last_width=100;
		$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);