<?php
		$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
		$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
		$sql="select * from ".$pdo->index_pre."user_set_item order by `sequence` desc,`id` asc";
		$r=$pdo->query($sql,2);
		$list='';
		foreach($r as $v){
			$list.="<tr id='tr_".$v['id']."'>
				<td><input type='text' name='variable_".$v['id']."' id='variable_".$v['id']."' value='".$v['variable']."'  class='variable' /></td>
				<td><input type='text' name='name_".$v['id']."' id='name_".$v['id']."' value='".$v['name']."'  class='name' /></td>
				<td><input type='text' name='options_".$v['id']."' id='options_".$v['id']."' value='".$v['options']."'  class='options' /></td>
			  <td><input type='text' name='default_value_".$v['id']."' id='default_value_".$v['id']."' value='".$v['default_value']."'  class='default_value' /></td>
			  <td><input type='text' name='sequence_".$v['id']."' id='sequence_".$v['id']."' value='".$v['sequence']."'  class='sequence' /></td>
			  <td class=operation_td><a href='#' onclick='return update(".$v['id'].")'  class='submit'>".self::$language['submit']."</a> <a href='#' onclick='return del(".$v['id'].")'  class='del'>".self::$language['del']."</a> <span id=state_".$v['id']." class='state'></span></td>
			</tr>
	";	

		}
		$module['list']=$list;
		if($module['list']==''){$module['list']='<tr><td colspan="30" class=no_related_content_td><span class=no_related_content_span>'.self::$language['no_related_content'].'</span></td></tr>';}
		
		$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/'.$_COOKIE['cloud_device'].'/'.str_replace($class."::","",$method).'.php';
		if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
		require($t_path);	
