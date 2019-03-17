<?php
function mall_shop($pdo,$table_pre,$language,$openid,$postObj,$id){
	//$id=62;
	if($openid==''){$openid=@$_GET['openid'];}
	$id=intval($id);
	$sql="select `name`,`main_business` from ".$pdo->sys_pre."mall_shop where `id`=".$id;
	$r=$pdo->query($sql,2)->fetch(2);
	$r=de_safe_str($r);
	$r['main_business'].="
	
点击进入店铺 > >";
	$data[0]['title']=$r['name'];
	$data[0]['description']=$r['main_business'];
	$data[0]['url']=get_cloud_path().'index.php?cloud=mall.shop_index&shop_id='.$id;
	$data[0]['picurl']=get_cloud_path().'program/mall/ticket_logo/'.$id.'.png';
	return $data;	
}
