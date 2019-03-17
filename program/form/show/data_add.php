<?php
$table_id=intval(@$_GET['table_id']);
if($table_id==0){exit('table_id err');}
$module['table_id']=$table_id;
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method."&table_id=".$table_id;

//统计PV
$pv_statistics="update ".self::$table_pre."table set `pv_statistics`=pv_statistics+1 where `id`=$table_id";
$pdo->exec($pv_statistics);

//独立IP统计
if(empty($_SESSION['client_ip'])){
	$ip_statistics="update ".self::$table_pre."table set `ip_statistics`=ip_statistics+1 where `id`=$table_id";
	$pdo->exec($ip_statistics);
	$_SESSION['client_ip']=get_client_ip();
}

$sql="select * from ".self::$table_pre."table where `id`=$table_id";
$r=$pdo->query($sql,2)->fetch(2);
$table_r=$r;
$table_v=$r;
$module['data']=de_safe_str($r);
$module['data']['css_pc_top_int']=@intval($module['data']['css_pc_top']);
$module['data']['bg_css']='';
if($_COOKIE['cloud_device']=='pc'){
	if(@$module['data']['css_pc_bg'] != ''){
		$module['data']['bg_css']="
		[user_color='container']{background-image:url(/upload/form/img/".$module['data']['css_pc_bg']."); background-size: contain;background-repeat:no-repeat;}
		#".$module['module_name']."{border-radius:5px; margin:auto; margin-top:". $module['data']['css_pc_top'].";width:".$module['data']['css_width']."; }
		
		 #".$module['module_name']."_html{}";
	}else{
		$module['data']['bg_css']="\n
		#".$module['module_name']."{margin-top:70px;}";
	}
}else{
	if($module['data']['css_phone_bg']!=''){
		$module['data']['bg_css']="
		[user_color='container']{background-image:url(/upload/form/img/".$module['data']['css_phone_bg']."); background-size: contain;background-repeat:no-repeat;}
		#".$module['module_name']."{border-radius:5px; margin:auto; margin-top:". $module['data']['css_phone_top'].";width:90%; }

		 #".$module['module_name']."_html{}";
	}else{
		$module['data']['bg_css']="
		
		#".$module['module_name']."{margin-top:10px; }";
	}
}
/*是否查询*/
$module['data']['submit-code']='/upload/form/code/table_submit_id_'.$table_id.'.jpg';
$module['data']['query-code']='/upload/form/code/table_query_id_'.$table_id.'.jpg';
$module['data']['publish_condition']="";
$module['data']['describe']=$r["describe"];
if($r["publish_condition"] != ""){
	$module['data']['query-url']=create_table($_SERVER,$table_id,"urlq");
	$module['data']['publish_condition']='<hr /><img onerror="ReLoadImg(this,\'query\','.$module['table_id'].');" class="sharecode" src="'.$module['data']['query-code'].'"><div class="share_des"><a href="'.$module['data']['query-url'].'">查询二维码</a></div>';
}

/*用户自定义样式*/
if($r["titlebackgroundlogo"] == ""){
	$module['data']['titlebackgroundlogo']="/images/qr_icon.jpg";
	$module['data']['titlebackgroundlogo_sryle']="display:none;";
}else{
	$module['data']['titlebackgroundlogo']="/upload/form/titlebackgroundlogo/".$r["titlebackgroundlogo"];
	$module['data']['titlebackgroundlogo_sryle']="display:block;";
}
$module['data']['form_title_background']="";
if($r["titlebackgroundimage"] != ""){
	$module['data']['form_title_background']="/upload/form/titlebackgroundimage/".$r["titlebackgroundimage"];
}
$module['data']['defind_style']=add_defind_style($r,$module);
function add_defind_style($r,$module,$retype="default"){
	//add_defind_style($r,$module,"titlebackgroundcolor")  //$table_r["titlebackgroundcolor"]
	$background='';
	$cssatt=$r["backgroundposition"];
	if($cssatt!=''){
		$background.="background-position: ".$cssatt.";\n";
	}
	$cssatt=$r["backgroundimage"];
	if($cssatt!=''){
		$background.="background-image: url(/upload/form/backgroundimage/".$cssatt.");\n
		    background-size: 100%;\n";
	}
	$cssatt=$r["background_fix"];
	if($cssatt!=''){
		$background.="background-attachment: ".$cssatt.";\n";
	}
	$cssatt=$r["backgroundrepeat"];
	if($cssatt!=''){
		$background.="background-repeat: ".$cssatt.";\n";
	}
	$cssatt=$r["backgroundcolor"];
	if($cssatt!=''){
		$background.="background-color: ".$cssatt.";\n";
	}

	$form_title_background="padding-top: 15px;\n";
	$cssatt=$r["titlebackgroundcolor"];
	if($retype == "titlebackgroundcolor"){
		return $cssatt;
	}
	if($cssatt!=''){
		//$form_title_background.="background-color: ".$cssatt.";\n";
	}
	$cssatt=$r["titlebackgroundimage"];
	if($cssatt!=''){
		$imagPath="/upload/form/titlebackgroundimage/".$cssatt;
		$imagHW=getRatioSize(".".$imagPath, 750);
		$form_title_background.="background-image: url(".$imagPath.");\n
		    background-size: 100%;\n
    		background-repeat: no-repeat;\n
			width:100%;\n
			max-height:".($imagHW["height"]-15)."px;\n";
	}
	$desfontcolor="color:#000000;\n";
	$titlebackgroundlogo="float: left;\n
    width: 30%;\n
    max-height: 100%;\n
    margin-left: 5%;\n";
    $title_f_text="
	    float: left;\n
	    padding-top: 5px;\n";
	$form_title="";
	$cssatt=$r["titlebackgroundlogo"];
	if($cssatt!=''){
		$titlebackgroundlogo.="display: block;\n";
   		$title_f_text.="width: 75%;\n";
   		$form_title.="text-align: left;\n
						text-indent:10px;\n";
		$desfontcolor.=$form_title;
	}else{
		$titlebackgroundlogo.="display: none;\n";
   		$title_f_text.="width: 100%;\n";
   		$form_title.="text-align: center;\n";
		$desfontcolor.=$form_title;
	}

	$titlefontcolor="color:#000000;\n";
	$cssatt=$r["titlefontcolor"];
	$input_color="";
	if($cssatt!=''){
		$titlefontcolor="color: ".$cssatt.";\n";
		$form_title.="color: ".$cssatt.";\n";
		$input_color.="\n.show_input_content legend,#form_data_add select,#form_data_add select, #form_data_add input[type=text],.radio_text{
			color: ".$cssatt.";\n
			border-color: ".$cssatt.";\n
			border: none;\n
		}\n
		.form_data_add .m_label{\n
		    font-size: 20px;\n
		    height: 50px;\n
		    display: block;\n
		    width: 30%;\n
		    line-height: 50px;\n\n
		    float: left;\n
		    overflow: hidden;\n
		    color: ".$cssatt.";\n
		    margin-bottom: 10px;\n
		}\n
		.form_data_add .input_span, .show_input_content .input_span{\n
			width: 70%;
		    float: left;
		}\n";
	}
	$mainfontcolor="color:#000000;\n";
	$mainfont_color_m_lable="";
	$cssatt=$r["mainfontcolor"];
	if($cssatt!=''){
		$mainfontcolor="color: ".$cssatt.";\n";
		$mainfont_color_m_lable.=".form_data_add .m_label, .show_input_content .m_label,.form_data_add legend{
			color: ".$r["mainbackgroundcolor"].";\n
		    font-size: 14px;\n
		    line-height: 14px;\n
		    height: 14px;\n
		}\n";
	}
	$cssatt=$r["desfontcolor"];
	if($cssatt!=''){
		$desfontcolor.="color: ".$cssatt.";\n";
	}
	$mainbackgroundcolor="";
	$cssatt=$r["mainbackgroundcolor"];
	if($cssatt!=''){
		$mainbackgroundcolor.="background-color: ".$cssatt.";\n";
		$mainfont_color_m_lable.="#form_data_add select,#form_data_add input[type=text]{
		background:".$cssatt.";\n
	}";
	}
	$add_submit="";//按钮样式
	$cssatt=$r["add_submit_css"];
	if($cssatt!=''){
		$add_submit.=$cssatt;
	}
	$add_submit="";//按钮样式
	$cssatt=$r["input_css"];
	if($cssatt!=''){
		$add_submit.=$cssatt;
	}
	/*预定接口*/
	$add_submit.="
	width: 100%;\n
	max-width: 100%;\n
	padding:0;\n";
	$style="
	.table_add_defind_style,[table_container='table_container']{/*表背景图,色*/\n
		".$background."
	}\n
	.form_title_background,.form_title_div{/*表头背景图*/\n
		".$form_title_background."
	}\n
	.titlefontcolor{/*表标题*/\n
		".$titlefontcolor."
	}\n
	.form_title{
		".$form_title."
	}
	.desfontcolor,.desfontcolor{/*表描述色*/\n
		".$desfontcolor."
	}\n
	.titlebackgroundlogo,.formLogo{/*表头LOGO*/\n
		".$titlebackgroundlogo."
	}\n
	.titlebackgroundlogo img,.formLogo img{/*表头LOGO*/\n
		max-height:60px;
		max-width:100%;
	}\n
	.title_f_text{/*配套表头LOGO的CSS*/\n
		".$title_f_text."
	}\n
	.mainbackgroundcolor,#".$module['module_name'].".portlet,#".$module['module_name'].".form_data_add_page{/*内容底色*/\n
		".$mainbackgroundcolor."
	}\n
	.mainfontcolor{/*子标题文字色*/\n
		".$mainfontcolor."
	}\n
	".$mainfont_color_m_lable."
	.search_schedule, .next_add_div .next_add_submit, .page-container .add_submit{\n
		".$add_submit."
	}\n
	.state{\n
	    position: absolute;\n
	    right: 5px;\n
	    font-size: 14px;\n
	    bottom: 10px;\n
	}\n
	input:focus, textarea:focus {\n
	    outline: 0;\n
	    border-color: rgba(82, 168, 236, 0.8);\n
	    -webkit-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 0 8px rgba(82, 168, 236, 0.6);\n
	    -moz-box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 0 8px rgba(82, 168, 236, 0.6);\n
	    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 0 8px rgba(82, 168, 236, 0.6);\n
	}\n
	.fail:before{\n
		font-size: 14px;\n
	}\n
	.Header_Bj {\n
        width: 100%;\n
	    height: 64px;\n
	    line-height: 32px;\n
	    background: #E1D2D7;\n
	    padding: 10px 0;\n
	    text-align: center;\n
	    color: #f00;\n
	    font-size: 14px;\n
	    position:relative;\n
	}\n
	.Header_Bj .gb_click {\n
		width: 25px;\n
	    height: 25px;\n
	    text-align: center;\n
	    line-height: 25px;\n
	    border-radius: 100%;\n
	    font-size: 18px;\n
	    font-family: Arial, sans-serif;\n
	    background: #f00;\n
	    color: #fff;\n
	    position: absolute;\n
	    top: 10px;\n
	    right: 10px;\n
	}\n
	.header_title{\n
	    height: 48px;\n
	    line-height: 48px;\n
	    font-size: 23px;\n
	    color: #969696;\n
	    margin-top: 20px;\n
	    padding-left: 2%;\n
	    background: #3F3F3F;\n
	    width: 100%;\n
	}\n
	fieldset {\n
	    padding: 0 0 10px 0;\n
    	height: 40px;\n
	}\n
	.required{\n
	    position: absolute;\n
    	left: -15px;\n
    	top: 5px;\n
	}\n
	.input_ele_style{\n
		\n
	}\n
	cloud_radio{\n
		height: 50px;\n
	    line-height: 50px;\n
	    font-size: 20px;\n
        position: relative;\n
	}\n
	input[type=\"radio\"]{
	    width: 20px;\n
	    height: 20px;\n
	    position: absolute;\n
	    top: 0;\n
	}\n
	.radio_text{\n
	    padding-left: 27px;\n
    	margin-right: 20px;\n
	}\n
	".$input_color;
	return $style;
}

$table_name=$r['name'];
$table_description=$r['description'];
$table_add_power=explode('|',$r['add_power']);
$authcode=$r['authcode'];
if($r['write_state']==0){echo $r['description'].self::$language['write_able_is_off']; return false;}
if(!in_array('0',$table_add_power)){
	if(!isset($_SESSION['user']['group_id'])){$_SESSION['user']['group_id']='0';}
	if(!in_array($_SESSION['user']['group_id'],$table_add_power)){echo self::$language['without'].self::$language['add'].self::$language['power']; return false;}	
}

//得到全部分页table_add_defind_style
$sql="select `page` from ".self::$table_pre."field where `table_id`=$table_id  and `write_able`=1 and `input_type`!='系统自带' and `input_type`!='系统添加' and `input_type`!='系统' order by `sequence` asc";
$r=$pdo->query($sql,2);
$sequenceArray=Array();
array_push($sequenceArray,1);
$n=0;
foreach ($r as $v) {
	$seq=intval($v['page']);
	if($seq > 0 && $seq != $sequenceArray[$n]){
		array_push($sequenceArray,$seq);
		$n++;
	}
}
$sequenceArray=array_unique($sequenceArray);
sort($sequenceArray);

$module['fields']='';/*输入分页提交列表 */
$n=0;
$next="";

$next_style="";//如果有表头背景图,则提交按钮也调用.
if($table_r["titlebackgroundcolor"]!=""){
	$next_style.="background:".$table_r["titlebackgroundcolor"].";";
}

$module['add_submit']="<div style=\"display:block;\" class=\"add_submit_div\"><span class='m_label'> </span><span class='input_span'><a href=\"javascript:;\" id=\"submit\" style=\"".$next_style."\" class=\"add_submit\"><span class='b_start'> </span><span class='b_middle'>提 交</span><span class='b_end'> </span></a> <span></span></span></div>";
foreach ($sequenceArray as $arr_k) {
	$where="`table_id`=$table_id  and `write_able`=1";
	$where.=" and `page`=$arr_k and `type`!='系统自带' and `type`!='系统添加' and `type`!='系统'";
	$sql="select * from ".self::$table_pre."field where ".$where." order by `sequence` asc";
	$r=$pdo->query($sql,2);
	if($n > 0){
		$next_topdiv='<div class="prev_next_css" style="'.$next_style.'">';
		$next_prev_style='float:left;width:100%;';
		$next2="";
		$show='style="display:none;"';
		if($n >= 1){
			$next2Style="";
			if($table_r["titlebackgroundcolor"]!=""){
				$next2Style.="border: 1px solid ".$table_r["titlebackgroundcolor"].";color: ".$table_r["titlebackgroundcolor"]." !important;";
			}
			$next2="\n<div id=\"prev_add_divselect\" style=\"".$next_prev_style."display:none;margin-right: 5%;\" class=\"next_add_div\"><a onclick=\"prev_add_submit(this);\" style=\"border: 1px solid #b68e56;color: #b68e56 !important;background: #fff;".$next2Style."\" data-page=\"add_page_1\" href=\"javascript:;\" class=\"next_add_submit\">上一步</a></div>\n";
		}
		if($module['add_submit']!=""){
			$next_submit="<div style=\"display:none;float: left;\" class=\"add_submit_div\" style=\"float:left;\" ><a style=\"".$next_style."\" href=\"javascript:;\" id=\"submit\" class=\"add_submit\"><span class='b_start'> </span><span class='b_middle'>提 交</span><span class='b_end'> </span></a> <span></span></div>";
			$module['add_submit']="";
		}
		$next=$next_topdiv.$next2."\n<div style=\"".$next_prev_style."\" class=\"next_add_div\"><a id=\"next_add_submit_sel\" onclick=\"next_add_submit(this);\" data-page=\"add_page_1\" style=\"".$next_style.";font-weight:bold;\" href=\"javascript:;\" class=\"next_add_submit\">下一步</a></div>\n".$next_submit."</div>\n<div class=\"clear\"></div>\n";

		;
	}else{
		$next="";
		$show='style="display:block;"';
	}
	$module['fields'].="\n<div $show ".$show." class='sequence_page page_".$arr_k."' id=\"add_page_".$arr_k."\" data-page=\"".$arr_k."\">\n
	<div class=\"header_title\" style=\"display:none;\">基本资料</div>";
	foreach($r as $v){
		//echo $v['description'].'<br />';
		$module['fields'].=$this->get_input_html(self::$language,$v,$table_v);
	}
	$module['fields'].="\n</div>\n";
	$n++;
}
$module['fields'].=$next;

 

if($authcode){/*是否要验证码*/
	$v['name']='authcode';
	$v['input_type']='authcode';
	$v['required']=1;
	$v['input_args']='';
	$module['fields'].=$this->get_input_html(self::$language,$v,$table_v);	
}
echo '<div style="display:none;" id="visitor_position_append">'.$table_description.'</div>';
$module['map_api']=self::$config['web']['map_secret'];
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';
if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


