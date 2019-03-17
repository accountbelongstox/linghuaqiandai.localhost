<?php
class receive{
	public static $config,$language,$table_pre;
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$program,$page;
			$program_config=require_once './program/'.$program.'/config.php';
			$program_language=require_once './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
		}		
	
	}
	
	function __call($method,$args){
		//var_dump( $args);
		@require "./plugin/set_magic_quotes_gpc_off/set_magic_quotes_gpc_off.php";
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		require './program/'.self::$config['class_name'].'/receive/'.$call.'.php';
   }
	//======================================================================================================= 生成二维码
	function create_qr($txt,$logo_path,$save_path,$width){
		require('./plugin/qrcode/qrcode.php');
		$txt=str_replace('|||','&',$txt);
		QRcode::png($txt,$save_path);
		ob_end_clean();
		require('./lib/image.class.php');
		$image=new image();
		$image->thumb($save_path,$save_path,$width,$width);
		$image->thumb($logo_path,'./ico.png',$width/8,$width/8);
		$image->imageMark($save_path,$save_path,'./ico.png',5,100,1);
	}
	
	
	function get_input_html($language,$v){
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.@$args['text_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'authcode':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$language['authcode'].'</span><span class=input_span><input type=text id='.$v['name'].'   cloud_required="'.$v['required'].'"  class="cloud_input" size="8" style="vertical-align:middle;"  /> <span class=state id='.$v['name'].'_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';
			break;
		case 'textarea':
			return '<div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="cloud_input" >'.$args['textarea_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div id='.$v['name'].'_div><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="cloud_input" >'.$args['editor_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><select id='.$v['name'].' cloud_value="'.$args['select_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" >'.$option.'</select> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_radio id='.$v['name'].' cloud_value="'.$args['radio_default_value'].'" value="'.$args['radio_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_radio> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_checkbox id='.$v['name'].' cloud_value="'.$args['checkbox_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$args['number_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" cloud_type="map" />  <span class=state id='.$v['name'].'_state></span> </span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div id='.$v['name'].'_div><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span><script src="include/core/area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id=0&output=select" id="'.$v['name'].'_area_js"></script>
</span></div>';
			break;
		default:

		}
		
	}

	/*--------------------------------------------------------------*/
	function get_forder_count($pdo,$SESSION_,$folder_id){
		/*取得该文件夹下的所有表单。*/
		$r=self::get_folder_user($SESSION_,"number",$folder_id);
		return count($r);
	}
	function get_folder_user($SESSI,$retype="format",$token=0){
		/*格式化用户的个人文件夹 100=>0,*/
		$folder_sequence=explode(",", $SESSI["user"]["folder_sequence"]);
		$folder_sequence=arr_to_arr($folder_sequence);//去重
		$arr=array();
		foreach ($folder_sequence as $v) {
			$r=explode("=>", $v);
			switch ($retype) {
				case 'format':
					$arr[$r[0]]=$r[1];
					break;
				case 'number':
					if($r[1] == $token){
						array_push($arr,$r[0]);
					}
					break;
				case 'all':
					array_push($arr,$r[0]);
					break;
				default:
					# code...
					break;
			}
		}
		return $arr;
	}

	function write_folder_user($pdo,$SESSI,$sequenceArr){
		$arr=self::get_folder_user($SESSI,"format");
		foreach ($sequenceArr as $key => $value) {
			$arr[$key]=$value;
		}
		$id=$SESSI["user"]["id"];
		$str="";
		foreach ($arr as $k => $v) {
			$str.=$k."=>".$v.",";
		}
		$arr_["folder_sequence"]=$str;
		mysql_update($pdo,$pdo->index_pre."user",$arr_,"id",$id);
		//return $r;
		return $str;
	}
	function create_folder_user($pdo,$SESSI,$folder_sequence){
		/*$pdo,$_SESSION,$folder_sequence*/
		/*用户初次建立表格顺序*/
		$id=$SESSI["user"]["id"];
		$Arr["folder_sequence"]=$folder_sequence;
		mysql_update($pdo,$pdo->index_pre."user",$Arr,"id",$id);
		return $Arr["folder_sequence"];
	}
	/*--------------------------------------------------------------*/

	
}
?>