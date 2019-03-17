<?php
function search_mall_goods($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `group` from ".$pdo->index_pre."user where `username`='".$account['username']."' limit 0,1";
	$r=$pdo->query($sql,2)->fetch(2);
	$mall_config=require('./program/mall/config.php');
	if($mall_config['shopkeeper_group_id']==$r['group']){
		$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."mall_goods where `username`='".$account['username']."' and (`title` like '%".$key."%') and `state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,9";
	}else{
		$sql="select `title`,`id`,`icon` from ".$pdo->sys_pre."mall_goods where (`title` like '%".$key."%') and `state`=1 order by `bidding_show` desc,`sequence` desc,`monthly` desc limit 0,9";
	}
	
	//file_put_contents('wx.txt',$sql);
	//echo $sql;
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==9){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_cloud_path().'index.php?cloud=mall.goods_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_cloud_path().'index.php?cloud=mall.goods&id='.$v['id'];
		$data[$i]['url']=get_cloud_path().'index.php?cloud=mall.goods&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['icon']!=''){$data[$i]['picurl']=get_cloud_path().'program/mall/img_thumb/'.$v['icon'];}
		if($i==0){
			$data[$i]['picurl']=get_cloud_path().'logo.png';	
			if($v['icon']!=''){$data[$i]['picurl']=get_cloud_path().'program/mall/img/'.$v['icon'];}
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
