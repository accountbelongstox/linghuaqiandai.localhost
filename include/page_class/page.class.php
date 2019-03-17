<?php
class page{
	static $edit_page_layout;
	
	function __construct(){
		$this->pdo=new  ConnectPDO();
		session_start();
		//global $config,$language,$program,$page;
		$edit_page_layout=(@$_GET['edit_page_layout']=='true')?true:false;
		if(isset($_SESSION['user']['function']) && $edit_page_layout){
			if(in_array('index.edit_page_layout',$_SESSION['user']['function'])){
				$edit_page_layout=true;
			}else{
				$edit_page_layout=false;
			}
		}else{
			$edit_page_layout=false;
		}


		if(isset($_GET['share'])){
			$sql="select `username` from ".$this->pdo->index_pre."user where `id`=".intval($_GET['share']);
			$r=$this->pdo->query($sql,2)->fetch(2);
			$_SESSION['share']=$r['username'];
		}

		set_reg_introducer($this->pdo);
		self::$edit_page_layout=$edit_page_layout;	
		global $config,$page,$program,$language;
		if($config['web']['wid']!=''){get_weixin_info($config['web']['wid'],$this->pdo); get_weixin_js_config($config['web']['wid'],$this->pdo);}

		if($config['web']['weixin_auto_login'] && $_COOKIE['cloud_device']=='phone' && isWeiXin() && !isset($_SESSION['user']['username']) && @$_GET['cloud']!='index.oauth_bind_option'){
			header('location:./oauth/wx/?backurl=http://'.str_replace('&','|||',get_url()));	
		}
		
		$_POST['cloud_user_color_set']=get_color_array($this->pdo);
		$color_data=get_color_data($this->pdo);
		
		$url=$_SERVER['QUERY_STRING'];
		$url=str_replace("index=","",$url);
		$url=str_replace("#","",$url);
		$url=str_replace("\\","",$url);
		$url=safe_str($url);
		$sql="select count(id) as c from ".$this->pdo->index_pre."page where `url`='$url'";
		$r=$this->pdo->query($sql,2)->fetch(2);
		if($r['c']!=0){
			$url=$url;
		}else{
			$url=$page;
		}
		$url=safe_str($url);
		//echo $url."<hr>";
		
		$sql="select `head`,`left`,`right`,`full`,`bottom`,`layout`,`require_login`,`tutorial`,`phone` from {$this->pdo->index_pre}page where url='".$url."' limit 0,1";
		//exit ($sql);
		//$sql="select * from cloud_page";
		$stmt=$this->pdo->query($sql,2);
		$v=$stmt->fetch(2);	
		//var_dump($v);
		
		if($v){
			$obj=array();
			$temp=$v['head'].','.$v['bottom'].','.$v['full'].','.$v['left'].','.$v['right'];
			$temp=explode(',',$temp);
			$programs=array();
			foreach($temp as $vvv){
				if($vvv==''){continue;}
				$temp2=explode('.',$vvv);
				$programs[$temp2[0]]=$temp2[1];	
			}
			foreach($programs as $k=>$vvvv){
				require_once("./program/".$k."/".$k.".class.php");
				$obj[$k]=new $k($this->pdo);
				//echo 'new '.$k.'<br>';
			}


			if(!isset($_SESSION['user']['page'])){
				if($v['require_login']=='1'){
					$backurl=get_url();
					$backurl=str_replace('&','|||',$backurl);
					header("location:./index.php?cloud=index.login&backurl=".$backurl);
				}else{
					send_user_set_cookie($this->pdo);	
				}
			}else{
				if(!in_array($url,$_SESSION['user']['page']) && $v['require_login']=='1'){
					if(!$edit_page_layout){
						exit('<div align="center" style="padding-top:20px;">'.$language['page_noPower'].' <a href=/index.php>'.$language['go_home'].'</a></div>');
					}
				}
					
			}
			setcookie("tutorial",$v['tutorial']);
			$t=explode(".",$page);
			$program=$t[0];
			//$obj=new $t[0]($this->pdo);
			
			$program_config=require './program/'.$program.'/config.php';
			if($program_config['program']['state']=='closed'){header("location:./index.php?cloud=index.closed&program=$program");}
			$program_language=require './program/'.$program.'/language/'.$program_config['program']['language'].'.php';
			//var_dump($program_language);
			//var_dump($obj);
			
			if(method_exists(@$obj[$t[0]],$t[1]."_head_data")){
				$m=$t[1]."_head_data";
				$head=$obj[$t[0]]->$m($this->pdo);
			}else{
				$head['title']='';
				$head['keywords']='';
				$head['description']='';
			}
			if($v['require_login']==0){
				@$head['title'].="-".$program_language['pages'][$page]['title']."-".$config['web']['name'];
				@$head['keywords'].="-".$program_language['pages'][$page]['keywords']."-".$config['web']['name'];
			}else{
				$head['title'].="-".$program_language['pages'][$page]['title']."_".$config['web']['name'];
				$head['keywords'].="-".$program_language['pages'][$page]['keywords']."_".$config['web']['name'];
			}
			
			
			@$head['description'].="-".$program_language['pages'][$page]['description'];
			$head['title']=trim($head['title'],"-");
			$head['keywords']=trim($head['keywords'],"-");
			$head['description']=trim($head['description'],"-");
			
			if($t[0]=='index' && $t[1]=='index'){
				$head['title']=$config['web']['title'];
				$head['keywords']=$config['web']['keywords'];
				$head['description']=$config['web']['description'];
			}
			
			
			$v['name']=$program_language['pages'][$page]['name'];
			$modules['head']=array();
			$modules['bottom']=array();
			$modules['full']=array();
			$modules['left']=array();
			$modules['right']=array();
			if($_COOKIE['cloud_device']=='phone'){
				if($v['require_login']=='1'){$v['head']='index.admin_nv,';}else{$v['head']='index.head,index.navigation';}
				$v['bottom']='index.foot,index.device';		
				if($v['layout']=='right'){
					$v['full']=$v['right'];
				}elseif($v['layout']=='left'){
					$v['full']=$v['left'];
				}
				if($v['phone']!=''){$v['full']=$v['phone'];$v['head']='';$v['bottom']='';}
				if($edit_page_layout){$v['full']=$v['phone'];$v['head']='';$v['bottom']='';}
				
				$v['layout']='full';
				$v['bottom'].=',index.phone_bottom';
				if($config['web']['circle']){$v['bottom'].=',index.circle_module';}
			}else{
				if($config['web']['circle']){$v['head']=str_replace(',mall.search',',index.circle_module,mall.search',$v['head']);}
			}
			if(isset($_GET['edit_page_layout_view_module'])){
				$v['head']='';
				$v['full']=preg_replace('/_/','.',$_GET['edit_page_layout_view_module'],1);
				$v['bottom']='';
			}
			
			if($url=='index.user'){
				$sql="select `user_sum` from ".$this->pdo->index_pre."group where `id`=".$_SESSION['user']['group_id'];
				$temp=$this->pdo->query($sql,2)->fetch(2);
				$v['full']='index.user,'.$temp['user_sum'];
			}
			
			if(!empty($v['head'])){
			    $modules['head']=$this->get_moudule($v['head'],$obj);
			}
			if(!empty($v['bottom'])){
			    $modules['bottom']=$this->get_moudule($v['bottom'],$obj);
			}
			if($v['layout']=='full'){
				if(!empty($v['full'])){
				    $modules['full']=$this->get_moudule($v['full'],$obj);
				}
			}else{
				if(!empty($v['left'])){
				    $modules['left']=$this->get_moudule($v['left'],$obj);
				}
				if(!empty($v['right'])){
				    $modules['right']=$this->get_moudule($v['right'],$obj);
				}
			}
			$css_path="/css/main.css";
			if(!is_file($css_path)){
				$temp=require("./program/index/config.php");
				$css_path="/css/main.css";
			}
			if($edit_page_layout){
				$edit_layout_language=require './language/'.$config['web']['language'].'.php';
				$_GET['cloud']=(@$_GET['cloud']!='')?$_GET['cloud']:'index.index';
				$edit_panel='<p id=edit_page_layout_div style="display:none;"><span id=save_composing_state></span><a class=add_module href="/index.php?cloud=index.edit_page_layout_add_module&area=head&url=">'.$edit_layout_language['add']. $edit_layout_language['module'].'</a><a href=# id=save_composing>'.$edit_layout_language['save'].$edit_layout_language['composing'].'</a><a href=# id=cancel_composing>'.$edit_layout_language['cancel'].$edit_layout_language['composing'].'</a><a href="/index.php?cloud=index.edit_page_layout&program='.$program.'&url='.$_GET['m'].'" id=expert_mode>'.$edit_layout_language['expert_mode'].'</a><a href=# id=switch_composing>'.$edit_layout_language['switch'].$edit_layout_language['composing'].'</a>
     <span id=composing_selection style="display:none;">
     	<a class=set_composing_full href="#" title="'.$edit_layout_language['full_screen'].'"></a>
     	<a class=set_composing_right href="#" title="'.$edit_layout_language['right_screen'].'"></a>
     	<a class=set_composing_left href="#" title="'.$edit_layout_language['left_screen'].'"></a>
        <span id=set_composing_state></span>
     </span>
     </span>
     </p>';
				require './include/core/edit_layout_'.$v['layout'].'.php';
			}else{
				$edit_panel='';
				require './include/core/layout_'.$v['layout'].'.php';
			}
			
			
		}
	}
	
	 protected function get_moudule($str,$obj){
	    /*index.head,index.navigation*/
		global $config,$language,$program;
		
		$module=explode(",",$str);
		$module=array_filter($module);
		
		foreach($module as $v){
			$v2=explode(".",$v);
			$args=get_match_single("/(\(.*\))/",$v2[1]);
			$v2[1]=preg_replace("/(\(.*\))/",'',$v2[1]);
			
			$temp_v=preg_replace('#(_[0-9]{1,})#','',$v);
			$temp_v=preg_replace("/(\(.*\))/",'',$temp_v);
			if(!isset($_SESSION['user']['function'])){
				if(!in_array($temp_v,$config['unlogin_function_power'])){$v2[0]='index';$v2[1]='need_login';}
				
			}else{
				if(!in_array($temp_v,$config['unlogin_function_power']) && !in_array($temp_v,$_SESSION['user']['function'])){
					if(self::$edit_page_layout==false){$v2[0]='index';$v2[1]='noPower';}
				}	
			}
			
				
			$this->pdo->pro_fix=$this->pdo->index_pre.$v2[0].'_';

			if(!isset($obj[$v2[0]])){
				require_once("./program/".$v2[0]."/".$v2[0].".class.php");
				$obj[$v2[0]]=new $v2[0]($this->pdo);
			}
			$temp=array(
			    'object'=>$obj[$v2[0]],
                'method'=>$v2[1],
                'pdo'=>$this->pdo,
                'args'=>$args
            );
			$modules[]=$temp;	
		}
		//if(!isset($modules)){$modules=array();}
		return $modules;	
	}
}
?>