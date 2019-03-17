<?php
$sql="select * from ".$pdo->index_pre."user where `id`='".$_SESSION['user']['id']."'";
$module=$pdo->query($sql,2)->fetch(2);
$_SESSION['token'][$method]=get_random(8);$module['action_url']="/receive.php?token=".$_SESSION['token'][$method]."&target=".$method;
$module['weight']=trim($module['weight'],'0');
//$module['birthday']=date(self::$config['other']['date_style'],$module['birthday']);

$module['birthday']=get_date($module['birthday'],self::$config['other']['date_style'],self::$config['other']['timeoffset']);
$module['married']=get_select_id($pdo,'married',$module['married']);
$module['education']=get_select_id($pdo,'education',$module['education']);
$module['blood_type']=get_select_id($pdo,'blood_type',$module['blood_type']);
$module['gender']=get_select_id($pdo,'gender',$module['gender']);
$module['license_type']=get_select_id($pdo,'license_type',$module['license_type']);
$module['annual_income']=get_select_id($pdo,'annual_income',$module['annual_income']);
$module['chat_type']=get_select_id($pdo,'chat_type',$module['chat_type']);
$module['domain_postfix']=str_replace('www.','.',$_SERVER['SERVER_NAME']);
$module['cloud_table_name']=self::$language['functions'][str_replace("::",".",$method)]['description'];
$module['module_name']=str_replace("::","_",$method);
$module['transaction_password_act']=($module['transaction_password']=='')?'add':'update';
$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';

require "./plugin/html4Upfile/createHtml4.class.php";
$html4Upfile=new createHtml4();

$module['icon_ele']=$html4Upfile->return_input("icon",'100%','/upload/'.$class.'/user_icon/','true','false','jpg|gif|png|jpeg',1024*10,'1');

$module['banner_ele']=$html4Upfile->return_input("banner",'100%','/upload/'.$class.'/user_banner/','true','false','jpg|gif|png|jpeg',1024*10,'1');


$module['license_photo_front_ele']=$html4Upfile->return_input("license_photo_front",'100%','/upload/index/user_license_photo_front/','true','false','jpg|gif|png|jpeg',1024*10,'1');

$module['license_photo_reverse_ele']=$html4Upfile->return_input("license_photo_reverse",'100%','/upload/index/user_license_photo_reverse/','true','false','jpg|gif|png|jpeg',1024*10,'1');

$module['weixincode_ele']=$html4Upfile->return_input("weixincode",'100%','/upload/index/user_weixincode/','true','false','jpg|gif|png|jpeg',1024*10,'1');
$module['enterprise_html']="";
$module['enterprise_select']="";

//$sql="select * from ".$pdo->index_pre."user";
//$stmt=$pdo->query($sql,2);
//for($i=0; $i<$stmt->columnCount(); $i++) {
//echo $stmt->getColumnMeta($i)['name']."<br>";//php5.4适使用，之前的版本需拆成两句
//}
//exit();
if($_SESSION["user"]["is_enterprise"] == 1){
	//如果是企业用户
	//企业名称
	$module["enterprise"]=return_table_info($pdo,$pdo->index_pre."enterprise",$info=false,"username",$_SESSION["user"]["username"],false);
	$authentication=return_table_info($pdo,$pdo->index_pre."enterprise","authentication","username",$_SESSION["user"]["username"],false);
	
	$module['enterprise_select']='<div class="c_option">企业资料 ('.$module["enterprise"]['remark'].')</div>';

	//print_arr($module["enterprise"]);
	if( $authentication == 0 ||  $authentication == 1){//认证中, 或认证成功
		$table_toby=return_table_fieldname($pdo,$pdo->index_pre."enterprise");
		function give_enterprise_html($m,$arr,$module_module_name){
			$tr='';
			$n=0;
			$name_arr=array("id","authentication","state");//不显示字段
			foreach ($m as $key => $value) {
				//print_arr($arr[$n]);
				if(!in_array($key, $name_arr)){
					$v=$value;
					$imgs=array('营业执照扫描件','法人身份证正面','法人身份证反面');
					if(in_array($arr[$n]["column_comment"], $imgs)){
						$v='<img style="max-width:580px" src="/upload/index/'.$arr[$n]["column_name"].'/'.$value.'" />';
					}

				$tr.='<tr>
	                <td class="m_label">'.$arr[$n]["column_comment"].'</td>
	                <td align="left"><span id="'.$key.'_show">'.$v.'</span></td>
	            </tr>';
				}
	            $n++;
			}
			$tr='<table border="0" cellpadding="0" cellspacing="0" class="'.$module_module_name.'_table " align=left >'.$tr.'</table>';
			//return $tr;
			return $tr;

		}
		$module['enterprise_html']=give_enterprise_html($module["enterprise"],$table_toby,$module["module_name"]);
	}else{
	
	//参数说明 : info = 返回的字段 $if_A = 条件 $if_B 条件的值 (INFO没有则返回全部字段)

	$module['enterprise_photo_ele']=$html4Upfile->return_input("enterprise_photo",'100%','/upload/index/enterprise_photo/','true','false','jpg|gif|png|jpeg',1024*10,'5');
	$module['enterpriseide_a_ele']=$html4Upfile->return_input("enterpriseide_a",'100%','/upload/index/enterpriseide_a/','true','false','jpg|gif|png|jpeg',1024*10,'5');
	$module['enterpriseide_b_ele']=$html4Upfile->return_input("enterpriseide_b",'100%','/upload/index/enterpriseide_b/','true','false','jpg|gif|png|jpeg',1024*10,'5');

	$module['enterprise_html']='<div class="from_select_div" style="display:none">
    <table border="0" cellpadding="0" cellspacing="0" class="'.$module["module_name"].'_table " align=left   >
    <form id="edit_enterprise_form" name="edit_enterprise_form" method="POST" action="'.$module["enterprise"]["action_url"].'" onSubmit="return exe_check();">
        <tr border="0" cellpadding="0" cellspacing="0" class='.$module["enterprise"]["module_name"].'_table  class="portlet light '.$module["enterprise"]["module_name"].'" cloud-module="'.$module["enterprise"]["module_name"].'" align=left _table >
            <tr id="tr_enterprisename">
                <td class="m_label">公司名称</td>
                <td align="left"><input type="text" id="enterprisename" name="enterprisename" value="'.$module["enterprise"]["enterprisename"].'" />
                    <span id="enterprisename_state"></span></td>
            </tr>
            <tr id="tr_enterprisecode">
                <td class="m_label">营业执照号码</td>
                <td align="left"><input type="text" id="enterprisecode" name="enterprisecode" value="'.$module["enterprise"]["enterprisecode"].'" />
                    <span id="enterprisecode_state"></span></td>
            </tr>
            <tr id="tr_enterprise_photo">
                <td class="m_label">营业执照扫描件</td>
                <td align="left" id="tr_td_enterprise_photo">
                    <img id="enterprise_photo_img" class="up_img" onerror="default_img(this);" src="/upload/index/enterprise_photo/'.$module["enterprise"]["enterprise_photo"].'" height="100"><br />
                    '.$module["enterprise_photo_ele"].'
                    <span id="enterprise_photo_state"></span>
                </td>
            </tr>
            <tr id="tr_enterprise_person">
                <td class="m_label">企业法人</td>
                <td align="left"><input type="text" id="enterprise_person" name="enterprise_person" value="'.$module["enterprise"]["enterprise_person"].'" />
                    <span id="enterprise_person_state"></span></td>
            </tr>
            <tr id="tr_enterpriseide_a">
                <td class="m_label">法人身份证正面</td>
                <td align="left" id="tr_td_enterpriseide_a">
                    <img id="enterpriseide_a_img" class="up_img" onerror="default_img(this);" src="/upload/index/enterpriseide_a/'.$module["enterprise"]["enterpriseide_a"].'" height="100"><br />
                    '.$module["enterpriseide_a_ele"].'
                    <span id="enterpriseide_a_state"></span>
                </td>
            </tr>
            <tr id="tr_enterpriseide_b">
                <td class="m_label">法人身份证反面</td>
                <td align="left" id="tr_td_enterpriseide_b">
                    <img id="enterpriseide_b_img" class="up_img" onerror="default_img(this);" src="/upload/index/enterpriseide_b/'.$module["enterprise"]["enterpriseide_b"].'" height="100"><br />
                    '.$module["enterpriseide_b_ele"].'
                    <span id="enterpriseide_b_state"></span>
                </td>
            </tr>
            <tr id="tr_enterprisecontcat">
                <td class="m_label">联系人</td>
                <td align="left"><input type="text" id="enterprise_contact" name="enterprise_contact" value="'.$module["enterprise"]["enterprise_contact"].'" />
                    <span id="enterprisecontcat_state"></span></td>
            </tr>
            <tr id="tr_enterprisephone">
                <td class="m_label">联系电话</td>
                <td align="left"><input type="text" id="enterprisephone" name="enterprisephone" value="'.$module["enterprise"]["enterprisephone"].'" />
                    <span id="enterprisephone_state"></span></td>
            </tr>
            <tr id="tr_enterpriseadd">
                <td class="m_label">公司地址</td>
                <td align="left"><input type="text" id="enterpriseadd" name="enterpriseadd" value="'.$module["enterprise"]["enterpriseadd"].'" />
                    <span id="enterpriseadd_state"></span></td>
            </tr>
            <tr id="tr_enterprisescale">
                <td class="m_label">企业规模</td>
                <td align="left">
                    <select id="enterprisecale" name="enterprisecale">
                        <option value="0-20" selected="">0-20人</option>
                        <option value="20-50">20-50人</option>
                        <option value="50-100">50-100人</option>
                    </select>
                    <span id="enterprisescale_state"></span></td>
            </tr>
            <tr>
                <td class="m_label"><a href="#" onclick="return update_enterprise()" class="submit">提交认证</a></td>
                <td align="left"></td>
            </tr>
    </form>
    </table>
</div>';
	}
}

if(!is_file($t_path)){$t_path='./templates/'.$m_require_login.'/'.$class.'/'.self::$config['program']['template_'.$m_require_login].'/pc/'.str_replace($class."::","",$method).'.php';}
require($t_path);


/*	require "./plugin/html5Upfile/createHtml5.class.php";
$html5Upfile=new createHtml5();

echo "<span id='icon_ele'>";			   
$html5Upfile->echo_input("icon",'500px','multiple','/upload/index/user_icon/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';
echo "<span id='license_photo_front_ele'>";	
$html5Upfile->echo_input("license_photo_front",'500px','','/upload/index/user_license_photo_front/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';	
echo "<span id='license_photo_reverse_ele'>";	
$html5Upfile->echo_input("license_photo_reverse",'500px','','/upload/index/user_license_photo_reverse/','true','false','jpg|gif|png|rar','500','5');
echo '</span>';	
*/