<?php
class form{
	public static $config,$language,$table_pre,$module_config;
	
	function __construct($pdo){
		if(!self::$config){
			//echo 'construct<br>';
			global $config,$language,$page;
			$program=__CLASS__;
			$program_config=require './program/'.$program.'/config.php';
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			self::$config=array_merge($config,$program_config);
			self::$language=array_merge($language,$program_language);
			self::$table_pre=$pdo->sys_pre.self::$config['class_name']."_";
			self::$module_config=require './program/'.$program.'/module_config.php';

		}		
	
	}
	function __call($method,$args){
		//echo $args[1];
		//var_dump( $args);
		$pdo=$args[0];
		$call=$method;
		$class=__CLASS__;
		$method=$class."::".$method;
		if(in_array($class.'.'.$call,self::$config['program_unlogin_function_power'])){$m_require_login=0;}else{$m_require_login=1;}		
		require './program/'.$class.'/show/'.$call.'.php';
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

	function table_admin_color(){
		$n = rand(1,5);
		$color_admArr=array("red","green","blue","purple");
		$color_admCode=array("red"=>"#EF1E25","green"=>"#2AB4C0","blue"=>"#5C9BD1","purple"=>"#4E9D4E");
		$name=$color_admArr[$n];
		$arr["name"]=$name;
		$arr["code"]=$color_admCode[$name];
		return $arr;
	}
	
	function data_add_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		if($table_id>0){
			$sql="select `description` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			return $v;
		}
	}

	function data_show_list_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		if($table_id>0){
			$sql="select `description` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			return $v;
		}
	}

	function data_show_detail_head_data($pdo){
		$table_id=intval(@$_GET['table_id']);
		$id=intval(@$_GET['id']);
		if($table_id>0){			
			$sql="select `description`,`name`,`read_state` from ".self::$table_pre."table where `id`='$table_id'";
			$r=$pdo->query($sql,2)->fetch(2);
			$r=de_safe_str($r);
			$v['title']=@$r['description'];	
			$v['keywords']=@$r['description'];	
			$v['description']=@$r['description'];	
			if(@$r['read_state']==1){
				$sql="select * from ".self::$table_pre.$r['name']." where `id`=".$id;
				$r2=$pdo->query($sql,2)->fetch(2);
				if($r2['publish']!=1){return $v;}
				$temp='';
				$sql="select * from ".self::$table_pre."field where `table_id`=$table_id order by `sequence` desc,`id` asc";
				$r=$pdo->query($sql,2);
				$module['fields']='';
				foreach($r as $v2){
					if(!in_array($v2['name'],self::$config['sys_field'])){$temp.=$r2[$v2['name']].' ';}
				}
				$temp=strip_tags($temp);
				$temp=mb_substr($temp,0,40,'utf-8');
				$temp.=' ';
				$v['title']=$temp.$v['title'];	
				$v['keywords']=$temp.$v['keywords'];		
				$v['description']=$temp.$v['description'];		
			}
			
			return $v;
		}
	}

	function get_input_html($language,$v,$table_v=null/*$table_v 传表的总属性进入*/){
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.@$args['text_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'authcode':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$language['authcode'].'</span><span class=input_span><input type=text id='.$v['name'].'   cloud_required="'.$v['required'].'"  class="cloud_input" size="8" style="vertical-align:middle;"  /> <span class=state id='.$v['name'].'_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';
			break;
		case 'textarea':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="cloud_input" >'.$args['textarea_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="cloud_input" >'.$args['editor_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><select id='.$v['name'].' cloud_value="'.$args['select_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" >'.$option.'</select> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			$n=0;
			foreach($temp as $vv){
				$option.='<input type="radio" name="'.$v['name'].'" id="'.$v['name'].'_'.$n.'" value="'.$vv.'" /><label class=radio_text for="'.$v['name'].'_'.$n.'" >'.$vv.'</label>';
				$n++;
			}
			$style="";
			$javascript="";
			$spanStyleClass = "m_label";
			$input_span = "input_span";
			$add_table_line_style_ = "";
			switch (intval($v['data_style'])) {
				case 1:
				/*复选框列表样式..*/
					$input_span = "input_span_style1";
					$style.='#'.$v['name'].' label,#'.$v['name'].' .radio_text{
						width: 90%;
					max-width: 90%;
					padding: 0;
					white-space: nowrap;
					font-size: 23px;
					border-radius: 0;
					line-height: 52px;
					height: 52px;
					display: inline-block;
					border: 1px solid  '.$table_v["titlefontcolor"] .';
					background: '.$table_v["mainbackgroundcolor"] .';
					color: '.$table_v["titlefontcolor"] .';
					margin-top: 20px;
					text-align: center;
					margin-left: 5%;
					margin-right: 5%;}#'.$v['name'].' input[type=radio]{
						display:none;

					}';
					$spanStyleClass = "radioStyleList";
					$javascript.="
					function changeLabelBacgoundColor(ele,e){
						$(ele+'').removeAttr('style');
						var ca=$(e).css('background-color');
						var cb=$(e).css('color');
						$(e).css({
							'color':ca,
							'background':cb
						});
					}
					$('#".$v['name']." label').click(function(){
						changeLabelBacgoundColor('#".$v['name']." label',this);
					});
					$('#".$v['name']." label').mousedown(function(){
						changeLabelBacgoundColor('#".@$v['name']." label',this);
					})
					$('#".$v['name']." label').mouseup(function(){
						setTimeout(function(){
							$('#next_add_submit_sel').trigger('click');
							$('.Header_Bj').show();
							$('.header_title').show();
						},800);
					})

					";
					$add_table_line_style_ = "style1_add_table_line_style";
					break;
				
				default:
					$add_table_line_style_ = "add_table_line_style";
					break;
			}
			$style_='<style>'.@$style.'</style><script>'.@$javascript.'</script>';
			return '<div class="'.$add_table_line_style_.'" data-style="'.@$v['style'].'" id="'.@$v['name'].'_div" ><span class="'.$spanStyleClass.'">'.@$required.''.@$v['description'].'</span><span class="'.$input_span.'"><cloud_radio id='.@$v['name'].' cloud_value="'.@$args['radio_default_value'].'" value="'.@$args['radio_default_value'].'" check_reg="'.@$v['reg'].'" cloud_required="'.@$v['required'].'" class="cloud_input"  >'.@$option.'</cloud_radio> <span class=state id='.@$v['name'].'_state></span></span></div>'.@$style_;
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_checkbox id='.$v['name'].' cloud_value="'.$args['checkbox_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$input_img=$html4Upfile->return_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return $input_img.'<div class="img_add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.$v['description'].'</span><span class=input_span><fieldset><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="img_add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$file_input=$html4Upfile->return_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			//echo $file_input;
			return $file_input.'<div class="file_add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="file_add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$args['number_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
		//百度KEY
		$config=require("./config.php");
		$baidu_map_key=$config['web']['map_secret'];
			return '<div class="map_add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span>
<style>#l'.$v['name'].'{height: 300px;width:100%;}</style><div id="l'.$v['name'].'"></div>
<span class="input_span"><input type="hidden" id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" cloud_type="map" />  <span class=state id='.$v['name'].'_state></span> </span>
<script>
var map = new BMap.Map("l'.$v['name'].'");
var point = new BMap.Point(116.331398,39.897445);
var geolocation = new BMap.Geolocation();
map.disableDoubleClickZoom();
map.disableInertialDragging();
map.disableScrollWheelZoom();
map.disableDragging();
geolocation.getCurrentPosition(function(r){
if(this.getStatus() == BMAP_STATUS_SUCCESS){
var icon = new BMap.Icon("/images/icon/user.png",new BMap.Size(32,32));
var mk = new BMap.Marker(r.point,{icon:icon});
map.addOverlay(mk);
map.centerAndZoom(r.point,15);
$("#"+"'.$v['name'].'").val(r.point.lng+","+r.point.lat);
$.ajax({
url: "http://api.map.baidu.com/geocoder/v2/",
data:"ak='.$baidu_map_key.'&location="+r.point.lat+","+r.point.lng+"&output=json",
dataType: "JSONP",
success: function (data){
var infoWindow = new BMap.InfoWindow(data.result.formatted_address+" <br />(如位置不准确,请开启定位权限)");
map.openInfoWindow(infoWindow,r.point);
map.setCenter(r.point);
console.log(r.point);
}
});
}
else{
alert("failed"+this.getStatus());
}
},{enableHighAccuracy: true})
</script>
</div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span><script src="include/core/area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id=0&output=select" id="'.$v['name'].'_area_js"></script>
</span></div>';
			break;
		default:

		}
		
	}	

	function get_input_html_new($language,$v,$default_val=false,$sms_arr=false,$ele_id=""){
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.@$args['text_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'authcode':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$language['authcode'].'</span><span class=input_span><input type=text id='.$v['name'].'   cloud_required="'.$v['required'].'"  class="cloud_input" size="8" style="vertical-align:middle;"  /> <span class=state id='.$v['name'].'_state ></span> <a href="#" onclick="return change_authcode();" title="'.self::$language['click_change_authcode'].'"><img id="authcode_img" src="/lib/authCode.class.php" style="vertical-align:middle; border:0px;" /></a></span></div>';
			break;
		case 'textarea':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="cloud_input" >'.$args['textarea_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="cloud_input" >'.$args['editor_default_value'].'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			$selected="";

			foreach($temp as $vv){
				$data_sms=0;
				/*处理短信发送*/
				if($sms_arr != false){
					if(strstr($sms_arr, $vv."&sms") != false){
						$data_sms=1;
					}
				}
				if($default_val !=false && $default_val == $vv){
					$selected="selected";
				}else{
					$selected="";
				}
				$option.='<option '.$selected.' data-sms="'.$data_sms.'" value="'.$vv.'">'.$vv.'</option>';
			}
			$the_id=$ele_id ? $ele_id : $v["id"];
			return '<div id='.$v['name'].'_'.$the_id.'_div><span class=input_span><select onchange="id_data_admin_select(this);" id_data_admin="select" data-id="'.$the_id.'" tabindex="'.$the_id.'"  cloud_value="'.$args['select_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" >'.$option.'</select> <span class=state id='.$v['name'].'_'.$the_id.'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_radio id='.$v['name'].' cloud_value="'.$args['radio_default_value'].'" value="'.$args['radio_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_radio> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_checkbox id='.$v['name'].' cloud_value="'.$args['checkbox_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend><span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$args['number_default_value'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" cloud_type="map" />  <span class=state id='.$v['name'].'_state></span> </span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span><script src="include/core/area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id=0&output=select" id="'.$v['name'].'_area_js"></script>
</span></div>';
			break;
		default:

		}
		
	}
	

	function get_input_html2($language,$v,$data){
		$old_data=$data;
		$args=format_attribute($v['input_args']);
		if($v['required']){$required='<span class=required>*</span>';}else{$required='';}
		//echo $v['name'].$required.'<br />';
		switch ($v['input_type']) {
		case 'text':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  maxlength="'.@$args['text_length'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'textarea':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['textarea_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="width:'.$args['textarea_width'].'; height:'.$args['textarea_height'].';"  class="cloud_input" >'.$data.'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'editor':
			return '<script charset="utf-8" src="editor/kindeditor.js"></script>
<script charset="utf-8" src="editor/create.php?id='.$v['name'].'&program=form&language=chinese_simplified"></script><div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label style="display:inline-block; vertical-align:top; height:'.$args['editor_height'].';">'.$required.''.$v['description'].'</span><span class=input_span><textarea  name='.$v['name'].' id='.$v['name'].'  check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" style="display:none;width:100%;height:'.$args['editor_height'].';"  class="cloud_input" >'.$data.'</textarea> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'select':
			$temp=explode('/',$args['select_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<option value="'.$vv.'">'.$vv.'</option>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><select id='.$v['name'].' cloud_value="'.$data.'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" >'.$option.'</select> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'radio':
			$temp=explode('/',$args['radio_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="radio" name="'.$v['name'].'" value="'.$vv.'" /><span class=radio_text>'.$vv.'</span>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_radio id='.$v['name'].' cloud_value="'.$data.'"  value="'.$data.'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_radio> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'checkbox':
			$temp=explode('/',$args['checkbox_option']);
			$temp=array_filter($temp);
			$option='';
			foreach($temp as $vv){$option.='<input type="checkbox" name="'.$v['name'].'" value="'.$vv.'" /><span class=checkbox_text>'.$vv.'</span>';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><cloud_checkbox id='.$v['name'].'  cloud_value="'.$data.'" value="'.$data.'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  >'.$option.'</cloud_checkbox> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'img':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['img_allow_image_type']),1024*10,'1');
			if($data!=''){
				if(is_file('./upload/form/img_thumb/'.$data)){
					$data="<a href='/upload/form/img/".$data."' target=_blank><img src='/upload/form/img_thumb/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='/upload/form/img/".$data."' target=_blank><img src='/upload/form/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'imgs':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['imgs_allow_image_type']),1024*10,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
		
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./upload/form/imgs_thumb/'.$v3)){
						$temp4.="<a href='/upload/form/imgs/".$v3."' target=_blank><img src='/upload/form/imgs_thumb/".$v3."' class=img_thumb   /></a> <a href=# class='del_imgs' input_name='".$v['name']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}else{
						$temp4.="<a href='/upload/form/imgs/".$v3."' target=_blank><img src='/upload/form/imgs/".$v3."' class=img_thumb  /></a> <a href=# class='del_imgs' input_name='".$v['name']."' file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'file':
			require_once("./plugin/html4Upfile/createHtml4.class.php");
			$html4Upfile=new createHtml4();
			$html4Upfile->echo_input($v['name'],'auto','./temp/','true','false',str_replace(',','|',$args['file_allow_file_type']),1024*30,'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			if($data!=''){
				if(is_file('./upload/form/file/'.$data)){
					$data="<a href='/upload/form/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'files':
			require_once("./plugin/html5Upfile/createHtml5.class.php");
			$html5Upfile=new createHtml5();
			$html5Upfile->echo_input(self::$language,$v['name'],'auto','multiple','./temp/','true','false',str_replace(',','|',$args['files_allow_file_type']),1024*get_upload_max_size(),'1');
			echo "<script>$(document).ready(function(){
		$('#".$v['name']."').attr('old_value','".$old_data."');			
		$('#".$v['name']."').attr('class','cloud_input');			
		$('#".$v['name']."').attr('cloud_required','".$v['required']."');			
		$('#".$v['name']."_ele').insertBefore($('#".$v['name']."_state'));});</script>";
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./upload/form/files/'.$v3)){
						$temp4.="<a href='/upload/form/files/".$v3."' target=_blank>".substr($v3,11)."</a> <a href=# class='del_files' input_name='".$v['name']."'  file=".$v3.">".self::$language['del']."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.'&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'<span id='.$v['name'].'_state class=state></span></fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" value="'.$data.'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  class="cloud_input" /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'time':
			if($args['time_style']=="Y-m-d"){$time_style='date';}else{$time_style='date_time';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" value="'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'" onclick=show_datePicker(this.id,"'.$time_style.'") onblur= hide_datePicker() class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'map':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=text id='.$v['name'].' placeholder="'.$v['placeholder'].'" check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'"  value="'.$data.'" class="cloud_input" cloud_type="map" />  <span class=state id='.$v['name'].'_state></span></span></div>';
			break;
		case 'area':
			echo '<script>function set_'.$v['name'].'(id,v){
				 $("#"+id).prop("value",v);
				}</script>';
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>'.$required.''.$v['description'].'</span><span class=input_span><input type=hidden id='.$v['name'].' check_reg="'.$v['reg'].'" cloud_required="'.$v['required'].'" class="cloud_input"  /> <span class=state id='.$v['name'].'_state></span><script src="include/core/area_js.php?callback=set_'.$v['name'].'&input_id='.$v['name'].'&id='.$data.'&output=select" id="'.$v['name'].'_area_js"></script></span></div>';
			break;
		default:

		}
		
	}
	
	function get_input_html3($pdo,$language,$v,$data){
		$old_data=$data;
		$args=format_attribute($v['input_args']);
		//echo $v['name'].$required.'<br />';
		
		switch ($v['input_type']) {
		case 'text':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'textarea':

			
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.rn_to_br($data).'</fieldset></span></div>';
			break;
		case 'editor':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'select':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'radio':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'checkbox':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'img':
			if($data!=''){
				if(is_file('./upload/form/img_thumb/'.$data)){
					$data="<a href='/upload/form/img/".$data."' target=_blank><img src='/upload/form/img_thumb/".$data."' class=img_thumb  /></a><br />";
				}else{
					$data="<a href='/upload/form/img/".$data."' target=_blank><img src='/upload/form/img/".$data."' class=img_thumb  /></a><br />";
				}	
			}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'imgs':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./upload/form/imgs_thumb/'.$v3)){
						$temp4.="<a href='/upload/form/imgs/".$v3."' target=_blank><img src='/upload/form/imgs_thumb/".$v3."' class=img_thumb /></a>";
					}else{
						$temp4.="<a href='/upload/form/imgs/".$v3."' target=_blank><img src='/upload/form/imgs/".$v3."' class=img_thumb /></a>";
					}	
				}
				$data=$temp4;
			}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'file':
			if($data!=''){
				if(is_file('./upload/form/file/'.$data)){
					$data="<a href='/upload/form/file/".$data."' target=_blank>".substr($data,11)."</a><br />";
				}	
			}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'files':
			if($data!=''){
				$temp3=explode('|',$data);
				$temp3=array_filter($temp3);
				$temp4='';	
				foreach($temp3 as $v3){
					if(is_file('./upload/form/files/'.$v3)){
						$temp4.="<a href='/upload/form/files/".$v3."' target=_blank>".substr($v3,11)."</a><br />";
					}	
				}
				$data=$temp4;
			}
	
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label>&nbsp;</span><span class=input_span><fieldset><legend>'.$v['description'].'</legend>'.$data.'</fieldset></span></div>';
			break;
		case 'number':
			if($data==0){$data='';}
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'time':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.get_time(self::$config['other']['date_style'],self::$config['other']['timeoffset'],self::$language,$data).'</span></div>';
			break;
		case 'map':
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span style="line-height:15px;"><iframe width="100%" id="map" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="/include/core/get_point.php?point='.$data.'&zoom=15&map_width=100%&map_height=100%">
</iframe><a href="/include/core/get_point.php?point='.$data.'&zoom=15&map_width=100%&map_height=100%" target="_blank">'.$language['full_screen_view_map'].'</a></span></div>';
			break;
		case 'area':
			$data="<span class=load_js_span  src='include/core/area_js.php?callback=set_area&input_id=".$v['name']."&id=".$data."&output=text2' id='".$v['name']."_".$data."'></span>";
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'bool':
			$data=($data)?$language['yes']:$language['no'];
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
		case 'user':
			$data=($data)?get_username($pdo,$data):$language['unlogin_user'];
			return '<div class="add_table_line_style" id="'.$v['name'].'_div" ><span class=m_label><span class=m_label_start>&nbsp;</span><span class=m_label_middle>'.$v['description'].'</span><span class=m_label_end>&nbsp;</span></span><span class=input_span>'.$data.'</span></div>';
			break;
			
		default:

		}
		
	}

	function get_col($v,$retype="default"){
		if(intval($v["sequence"]) == 1){
			$up_txt="取消置顶"; 
		}else{
			$up_txt="置顶";
		}


		if(intval($v["index_show"]) == 1){
			$index_show_txt="取消推荐";
		}else{
			$index_show_txt="首页推荐";
		}


		if(!isset($v["sublime_url_"])){
			$v["sublime_url_"]="";
		}

		$top		/*置顶*/='<a onclick="sequence('.$v["id"].',this);" class="btn btn-minor form_top fll" href="javascript:;" target="_blank">'.$up_txt.'</a>';
		$index_show /*首页列表显示*/ ='<a onclick="index_show('.$v["id"].',this);" class="btn btn-minor form_top fll" href="javascript:;" target="_blank">'.$index_show_txt.'</a>'; 
		$move	/*移动*/='<a onclick="move('.$v["id"].',this);" class="btn btn-minor form_move fll" href="javascript:;" target="_blank">移动</a>';
		$change	/*改变*/='<a onclick="change_table('.$v["id"].',\''.$v["table_join"].'\');" href="javascript:;" class="btn btn-minor form_change fll">修改</a>';
		$code	/*二维码*/='<a class="btn btn-minor form_preCode fll" href="/index.php?cloud=form.field_add&amp;id='.$v["id"].'" target="_blank">扫码</a>';
		$edit	/*编辑*/='<a class="btn btn-minor form_edit fll" href="index.php?cloud=form.table_add&amp;edit='.$v["id"].'">编辑</a>';
		$vive	/*查看*/='<a class="btn btn-minor form_preView fll" href="'.$v["sublime_url_"].'" target="_blank">预览</a>';
		$del	/*删除*/='<a data-type="'.$retype.'" onclick="del('.$v["id"].',this);" class="btn btn-minor form_delete fll" href="javascript:;" target="_blank">删除</a>';
		$publish/*发表*/='<a class="btn btn-minor form_publish fll" title="发布" data-container="false" data-placement="bottom" href="/index.php?cloud=form.field_add&id='.$v["id"].'" data-original-title="">发布</a>';
		$html="";
		switch ($retype) {
			case 'admin':
				$html=$top.$index_show.$move.$change.$code.$edit.$vive.$del;
				break;
			case "folder-admin":
					$html=$top/*.$move*/.$index_show.$change.$del;
				break;
			case "user":
				$edit="";
				switch ($v["is_table_admin"]) {
					case 1://管理员 叠加一个选项
						$edit.='<a class="btn btn-minor form_edit fll" title="编辑" href="index.php?cloud=form.table_add&edit='.$v["id"].'">编辑</a>';
						break;
					case 2://管维护
						# code...
						break;
					case 3://管查看
						# code...
						break;
					default:
						# code...
						break;
				}
				$html=$vive.$move.$edit.$publish.$code;
				break;
			default:
				# code...
				break;
		}
		$r='<div class="admin_col_panel">'.$html."</div>";
		return $r;
	}
	function get_table_html_row($pdo,$SESSION_,$SERVER_,$v/*$_SESSION*/,$retype="user"){
		if($retype!="folder"){
			$all_sql="select `id` from ".$pdo->sys_pre."form_".$v['name'];
			$v["all_data"]=$pdo->query($all_sql,2)->rowCount();
			if($v["adm_color"] == "" || $v["adm_color_code"] == ""){
				$admin_color_arr=table_admin_color();
				$v["adm_color"]=$admin_color_arr["name"];
				$v["adm_color_code"]=$admin_color_arr["code"];
				$color_sql="update ".$pdo->table_pre."table set `adm_color`='".$v["adm_color"]."',`adm_color_code`='".$v["adm_color_code"]."' where `id`=".$v["id"];
				$pdo->exec($color_sql);
			}
			$y = date("Y"); //获取当天的月份
			$m = date("m");//获取当天的号数
			$d = date("d");//将今天开始的年月日时分秒，转换成unix时间戳(开始示例：2015-10-12 00:00:00)
			$v["todayTime_"]= mktime(0,0,0,$m,$d,$y);//今日提交用户
			$today_sql="select `id` from ".$pdo->sys_pre."form_".$v['name']." where `write_time` >= ".$v["todayTime_"];
			$v["today_data"]=$pdo->query($today_sql,2)->rowCount();//未审核用户
			$sql="select `id` from ".$pdo->sys_pre."form_".$v['name']." where `examined` = 0";
			$v["examined_N_data"]=$pdo->query($sql,2)->rowCount();//复审用户
			$sql="select `id` from ".$pdo->sys_pre."form_".$v['name']." where `examined` = 1";
			$v["examined_F_data"]=$pdo->query($sql,2)->rowCount();//通过用户
			$sql="select `id` from ".$pdo->sys_pre."form_".$v['name']." where `examined` = 2";
			$v["examined_Y_data"]=$pdo->query($sql,2)->rowCount();//逾期用户
			$sql="select `id` from ".$pdo->sys_pre."form_".$v['name']." where `overdue`=1";
			$v["overdue"]=$pdo->query($sql,2)->rowCount();//$overdue="0";
			$pos_arr=array(intval($v['pv_statistics']),intval($v["today_data"]),intval($v["examined_Y_data"]),intval($v["overdue"]));//取最大值求百分比
			$pos__ = array_search(max($pos_arr), $pos_arr);
			$v["max_number"]=100;
			$v["sublime_url_"]=create_table($SERVER_,$v["id"],"urlt");//预览URL地址
			$v["is_table_admin"]=check_is_table_admin($pdo,$v["id"],$SESSION_);//表的权限级别
			$create=return_username_info($pdo,$v["creater"],"all");//短信余数
		}
		if(intval($v["sequence"]) == 1){
			$gd_hs="gd-show";
		}else{
			$gd_hs="gd-hide";
		}
		switch ($retype){
			case 'user':
				return '<div id="folder_'.$v["id"].'" class="col-table-admin" data-tableid="'.$v["id"].'">
<img class="pinned-img '.$gd_hs.'" src="/images/top_fixed.png" alt="">
<div class="dashboard-stat2 bordered">
<div class="tableadmin-title">
<div class="caption"> 
<span class="caption-subject font-dark bold subject_title uppercase">'.$v['description'].'</span>
<span class="font-dark-remark ">'.$v['remark'].'</span>
</div>

<div class="admin_show_colDiv actions"><a class="folder-link" href="javascript:void(0)"></a><div class="admin_show_colli"><a class="folder-link" href="javascript:void(0)"><i class="fa-cog i_admin"></i></a><div class="admin_show_col_div" style="display:none;"><a class="folder-link" href="javascript:void(0)">
</a>'.self::get_col($v,$retype).'
</div>
</div>
</div>

</div>
<div class="display">
<div class="number">
<h3 class="font-'.$v["adm_color"].'-sharp">
<a href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'" class="font-'.$v["adm_color"].'-sharp"><span data-counter="counterup" data-value="'.$v["all_data"].'">'.$v["all_data"].'</span></a>
<small class="font-'.$v["adm_color"].'-sharp">条</small>
</h3>
<small class="pv_st">PV: '.$v['pv_statistics'].'</small><small class="pv_st">独立ip: '.$v['ip_statistics'].'</small>
</div>
<div class="icon">
<i class="icon-folder-open-alt"></i>
</div>
</div>
<div class="chat_col">
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["today_data"])/$v["max_number"])*100).'">
<span>'.$v["today_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&write_time=today">今日
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["examined_F_data"])/$v["max_number"])*100).'">
<span>'.$v["examined_F_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&examined=1">复审
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["examined_Y_data"])/$v["max_number"])*100).'">
<span>'.$v["examined_Y_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&examined=2">已审
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["overdue"])/$v["max_number"])*100).'">
<span>-</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&overdue=1">逾期
<i class="icon-arrow-right"></i>
</a>
</div>
</div>
<div class="progress-info">
<div class="progress">
<span style="width: 0;" data-full="'.$create["msg_money"].'" data-count="'.$v['msg_count'].'" class="progress-bar progress-bar-success '.$v["adm_color"].'-sharp">
</span>
</div>
<div class="status">
<div class="status-title"> <a style="color: #AAB5BC;" href="/index.php?cloud=index.admin_site_msg" target="_blank">短信发送</a></div>
<div class="status-number"> '.$v['msg_count'].'/'.$create["msg_money"].'</div>
</div>
</div>
<div class="progress-info">
<div class="progress">
<span style="width:0;" class="progress-bar progress-bar-success '.$v["adm_color"].'-sharp">
</span>
</div>
<div class="status">
<div class="status-title"> 空间剩余</div>
<div class="status-number"> 100%</div>
</div>
</div>
<div class="user_admin_group"><i class="fa-user"> </i> <a href="javascript:;" title="由['.$v["creater"].']创建"><span class="span_admin"> '.check_is_table_admin_string($pdo,$v["id"],$SESSION_).' </span></a>'./*<span class="span_usercreate">团队'.get_member($pdo,$v["creater"],$v["admin_is_edit"],"count").'人</span>*/''.'</div>
</div>
</div>';
				break;
			case "admin_folder":
				return '<div class="col-table-admin" id="folder_'.$v["id"].'" data-tableid="'.$v["id"].'">
<img class="pinned-img '.$gd_hs.'" src="/images/top_fixed.png" alt="">
<div class="dashboard-stat2 bordered overvisi">
<div class="tableadmin-title">
<div class="caption"> 
<span class="caption-subject font-dark bold subject_title uppercase"><input id="description_'.$v['id'].'" type="text" class="admin_fo des" data-creater="'.$v['description'].'" value="'.$v['description'].'" /></span>
<span class="font-dark-remark "><input id="remark_'.$v['id'].'" type="text" class="admin_fo rem" data-remark="'.$v['remark'].'" value="'.$v['remark'].'" /></span>
</div>
</div>
<div class="display">
<div class="number">
<h3 class="font-'.$v["adm_color"].'-sharp">
<a href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'" class="font-'.$v["adm_color"].'-sharp"><span data-counter="counterup" data-value="'.$v["all_data"].'">'.$v["all_data"].'</span></a>
<small class="font-'.$v["adm_color"].'-sharp">条</small>
</h3>
<small class="pv_st">PV: '.$v['pv_statistics'].'</small><small class="pv_st">独立ip: '.$v['ip_statistics'].'</small>
</div>
<div class="icon">
<i class="icon-folder-open-alt"></i>
</div>
</div>
<div class="chat_col">
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["today_data"])/$v["max_number"])*100).'">
<span>'.$v["today_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&write_time=today">今日
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["examined_F_data"])/$v["max_number"])*100).'">
<span>'.$v["examined_F_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&examined=1">复审
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["examined_Y_data"])/$v["max_number"])*100).'">
<span>'.$v["examined_Y_data"].'</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&examined=2">已审
<i class="icon-arrow-right"></i>
</a>
</div>
<div class="easy-pie-chart">
<div class="number transactions" data-barColor="'.$v["adm_color_code"].'" data-percent="'.((intval($v["overdue"])/$v["max_number"])*100).'">
<span>-</span><canvas height="50" width="50"></canvas>
<canvas height="50" width="50"></canvas></div>
<a class="title" href="/index.php?cloud=form.data_admin&table_id='.$v["id"].'&overdue=1">逾期
<i class="icon-arrow-right"></i>
</a>
</div>
</div>
<div class="progress-info">
<div class="progress">
<span style="width: 0;" data-full="'.$create["msg_money"].'" data-count="'.$v['msg_count'].'" class="progress-bar progress-bar-success '.$v["adm_color"].'-sharp">
</span>
</div>
<div class="status">
<div class="status-title"> <a style="color: #AAB5BC;" href="/index.php?cloud=index.admin_site_msg" target="_blank">短信发送</a></div>
<div class="status-number"> '.$v['msg_count'].'/'.$create["msg_money"].'</div>
</div>
</div>
<div class="progress-info">
<div class="progress">
<span style="width:0;" class="progress-bar progress-bar-success '.$v["adm_color"].'-sharp">
</span>
</div>
<div class="status">
<div class="status-title"> 空间剩余</div>
<div class="status-number"> 100%</div>
</div>
</div>
<div class="user_admin_group"><i class="fa-user i_admin_c"> </i><span class="span_usercreate_admin"> <input id="creater_'.$v['id'].'" type="text" class="admin_fo rem" data-creater="'.$v['creater'].'" value="'.$v['creater'].'" /></span>
<div class="admin_show_colDiv"><div class="admin_show_colli"><i class="fa-cog i_admin"></i><div class="admin_show_col_div" style="display:none;">
'.self::get_col($v,"admin").'
</div></div></div></div>
</div>
</div>';
				break;
			case "admin_list":
				return '<tr id="tr_'.$v['id'].'" style="border: 1px #DDDDDD solid;">
<td>
<div class="formSettings formtable_div"  style="margin-top: 5px;">
<ul class="dashboard-list ">
<li>
<a href="/index.php?cloud=index.admin_edit_user&id='.$create["id"].'">
<img class="dashboard-avatar" alt="'.$create["username"].'" src="'.($create['icon'] ? "/upload/index/user_icon/".$create['icon'] : "/images/avatar_default-a.png").'"></a>
<a href="#"><input id="description_'.$v['id'].'" type="text" class="description" data-description="'.$v['description'].'" value="'.$v['description'].'" />
</a>
<strong> 创建:</strong> <input id="creater_'.$v['id'].'" type="text" class="creater" data-creater="'.$v['creater'].'" value="'.$v['creater'].'" />
<strong> 团队:</strong> '.get_member($pdo,$v["creater"],$v["admin_is_edit"],"count").'人
<strong> PV:</strong> '.$v['pv_statistics'].'
<strong> 独立IP:</strong> '.$v['ip_statistics'].'
<strong> 日期:</strong> '.date('Y-m-d',$v['create_time']).'
<br>
<input type="text" class="remark" id="remark_'.$v['id'].'" data-remark="'.$v['remark'].'" value="'.$v['remark'].'" />
<a href="/index.php?cloud=form.data_admin&table_id='.$v['id'].'" target="_blank"><span class="label-success label label-default">数据量:'.$v["all_data"].'</span></a>
<a href="/index.php?cloud=form.data_admin&table_id='.$v['id'].'" target="_blank"><span class="label-today label label-default">今日:'.$v["today_data"].'</span></a>
<a href="/index.php?cloud=form.data_admin&table_id='.$v['id'].'&examined=1" target="_blank"><span class="label-warning label label-default">复审:'.$v["examined_F_data"].'</span></a>
<a href="/index.php?cloud=form.data_admin&table_id='.$v['id'].'&examined=2" target="_blank"><span class="label-warning label label-default">已审:'.$v["examined_Y_data"].'</span></a>
<a href="/index.php?cloud=form.data_admin&table_id='.$v['id'].'&overdue=1" target="_blank"><span class="label-default label label-danger">逾期:'.$v["overdue"].'</span></a>
<span class="label label-info">短信:'.$v['msg_count'].'/'.$create['msg_money'].'</span>
<span class="label-success label label-default">￥:'.$create['money'].'</span>
<span class="label-warning label label-default">积:'.$create['credits'].'</span>
</li>
</ul>
</div>
</td>
<td width="260">
<div class="formSettings formtable_col"  style="">
<a onclick="sequence('.$v["id"].');" class="btn btn-minor fll" href="javascript:;" target="_blank"><i class="fa-thumbs-up"></i>置顶</a>
<a style="margin-left: 0; padding-left: 10px;" onclick="change_table('.$v['id'].',\'list\');" href="javascript:;" class="btn btn-primary btn_feedback fll"><img src="/images/icon/feedbackWhite.png">修改</a>
<a class="btn btn-minor form_preCode fll" href="/index.php?cloud=form.field_add&id='.$v['id'].'" target="_blank">扫码</a><span class="clear"></span>
<a class="btn btn-minor form_edit fll" href="index.php?cloud=form.table_add&amp;edit='.$v['id'].'">编辑</a>
<a class="btn btn-minor form_preView fll" href="'.$v["sublime_url"].'" target="_blank">预览</a>
<a onclick="del('.$v['id'].',\'list\');" class="btn btn-minor form_delete fll" href="javascript:;" target="_blank">删除</a>
</div>
</td>
</tr>';
				break;
				case "folder":
				if($v["creater"] != $SESSION_["user"]["username"]){
					return "";
				}
					return '<div id="folder_'.$v["id"].'" class="folder folder-item form-color-'.$v["backgroundcolor"].'">
				
<img class="pinned-img '.$gd_hs.'" src="/images/top_fixed.png" alt="">
<a class="folder-link" href="/index.php?cloud=form.table_admin&folder='.$v["id"].'">
<div class="name" style="overflow: hidden; text-overflow: ellipsis; -webkit-box-orient: vertical; display: -webkit-box; -webkit-line-clamp: 2;">'.$v["description"].'</div>
<div class="symbol">
<i class="symbol-color">
<i class="symbol-icon '.$v["backgroundimage"].'"></i>
</i>
</div>
<div class="form-data">
<span class="count">'.self::get_forder_count($pdo,$SESSION_,$v["id"]).'</span>
<span class="text">表单</span>
</div>
</a>
<div class="admin_show_colDiv"><a class="folder-link" href="javascript:void(0)"></a><div class="admin_show_colli"><a class="folder-link" href="javascript:void(0)"><i class="fa-cog i_admin"></i></a><div class="admin_show_col_div" style="display:none;"><a class="folder-link" href="javascript:void(0)">
</a>'.self::get_col($v,"folder-admin").'
</div>
</div>
</div>
<div class="settings info-icons tooltipstered">
<i class="fa-icon-cog"></i>
</div>
</div>';
				break;
			default:
				# code...
				break;
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