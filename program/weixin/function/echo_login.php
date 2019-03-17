<?php
function echo_login($pdo,$table_pre,$language,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$data[0]['title']=$language['welcome'].$language['login'];
	$data[0]['description']=$language['click'].$language['login'];
	$data[0]['url']=get_cloud_path().'index.php?cloud=index.login&openid='.$openid;
	$data[0]['picurl']=get_cloud_path().'logo.png';
	return $data;	
}
