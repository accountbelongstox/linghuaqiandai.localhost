<?php
function search_article($account,$pdo,$language,$key,$openid){
	if($openid==''){$openid=@$_GET['openid'];}
	$sql="select `title`,`id`,`src` from ".$pdo->sys_pre."article_article where (`title` like '%".$key."%' or `content` like '%".$key."%') and `visible`=1 order by `sequence` desc,`visit` desc limit 0,10";
	$r=$pdo->query($sql,2);
	$data=array();
	$i=0;
	foreach($r as $v){
		if($i==9){
			$data[$i]['title']=$language['click_show_all'];
			$data[$i]['url']=get_cloud_path().'index.php?cloud=article.show_article_list&current_page=2&search='.urlencode($key);
			$data[$i]['picurl']='';
			break;
		}
		$data[$i]['title']=$v['title'];
		$data[$i]['url']=get_cloud_path().'index.php?cloud=article.show&id='.$v['id'];
		$data[$i]['picurl']='';
		if($v['src']!=''){$data[$i]['picurl']=get_cloud_path().'program/article/img_thumb/'.$v['src'];}
		if($i==0){
			$data[$i]['picurl']=get_cloud_path().'logo.png';	
			if($v['src']!=''){$data[$i]['picurl']=get_cloud_path().'program/article/img/'.$v['src'];}
		}
		$i++;	
	}
	if($i==0){return '';}
	return $data;
}
