<!DOCTYPE html>
<head>
<link rel="shortcut icon" href="/favicon.ico"/>
<?php echo $_POST['diy_meta'];?>
<meta charset="utf-8" />
<title><?php echo $head['title']?></title>
<meta name=keywords content="<?php echo $head['keywords']?>">
<meta name="description" content="<?php echo $head['description']?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1;" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="/public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link href="/public/animate.min.css" rel="stylesheet" type="text/css">
<link href="/templates/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"> 
<link href="/css/easypiechart.css" rel="stylesheet" type="text/css">
<link href="/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.min.css" rel="stylesheet" type="text/css">
<link href="/css/colpick.css" rel="stylesheet" type="text/css">
<script src="/public/jquery.js"></script>
<script src="/public/jquery-ui.min.js"></script>
<script src="/public/blocksit.min.js"></script>
<script src="/templates/bootstrap/js/bootstrap.js" type="text/javascript"></script>
<script src="/public/sys_head.js"></script>
<script src="/public/top_ajax_form.js"></script>
<script src="/js/jquery.zclip.min.js"></script>
<script src="/js/Global.js"></script>
<script src="/js/jquery.easing.min.js"></script>
<script src="/js/jquery.easypiechart.min.js"></script>
<script src="/js/colpick.js"></script>
<script src="/malihu-custom-scrollbar-plugin-master/js/uncompressed/jquery.mousewheel.js"></script>
<script src="/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.js"></script>

<script>

wx.config({
	debug: false, 
	appId: '<?php echo @$_POST['weixin_js_config']['appId'];?>', 
	timestamp:'<?php echo @$_POST['weixin_js_config']['timestamp'];?>', 
	nonceStr: '<?php echo @$_POST['weixin_js_config']['nonceStr'];?>', 
	signature: '<?php echo @$_POST['weixin_js_config']['signature'];?>',
	jsApiList: ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone',	] 
});	

wx.ready(function(){							
	wx.onMenuShareTimeline({
		title: $('title').html(), 
		link: window.location.href+'#&share='+getCookie('cloud_id')+'&', 
		imgUrl: get_share_img(), 
		success: function () {},
		cancel: function () {}
	});		
	
	wx.onMenuShareAppMessage({
		title: $('title').html(), 
		desc: '', 
		link: window.location.href+'#&share='+getCookie('cloud_id')+'&', 
		imgUrl: get_share_img(), 
		type: '', 
		dataUrl: '', 
		success: function () {},
		cancel: function () {}
	});	
	
	wx.onMenuShareQQ({
		title: $('title').html(), 
		desc: $('title').html(), 
		link: window.location.href+'#&share='+getCookie('cloud_id')+'&', 
		imgUrl: get_share_img(), 
		success: function () {},
		cancel: function () {}
	});
});
</script>
<link rel="stylesheet" href="<?php  echo  $css_path;?>" type="text/css">
<!--??????CSS-->
<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body >
<div class="spinner" id="loading">
  <div class="spinner-container container1">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container2">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
  <div class="spinner-container container3">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
  </div>
</div>
<!--BEGIN HEADER -->
<div class="page-header" cloud_layout="head" user_color='head'>
<!--??????bar -->
<?php
if(!(isset($_GET["cloud"]) && $_GET["cloud"] == "form.data_add")){
    echo '<script id="top_bar_js" src="/receive.php?target=index::top_bar&QUERY_STRING=m=article.show_article_list&type=73"></script>';
}
foreach($modules['head'] as $v){
	/*php 7 ????????????????????????????????? $v['method'] = (STRING)$v['method']*/
	$method_fun=(STRING)$v['method'];
	$v['object']->$method_fun($v['pdo'],$v['args']);
}
?>
</div>
<!-- END HEADER -->
<!-- BEGIN PAGE CONTAINER -->
<?php
/*??????????????????*/
if(!isset($_GET['cloud'])){
	require("./templates/default/templates_index.php");
}
/*?????????????????????????????????*/
?>
<div class="page-container" user_color='container'>
   <div class="page-content table_add_defind_style" table_container="table_container">
   <?php echo_content("container_list",$_GET);?> 
	    <div class="container " cloud_layout="full" m_container="m_container">
	    	<?php
	    		if(isset($_GET["cloud"])){
	    			if($_GET["cloud"]=="index.user"){
		    			//??????????????????????????????DIV?????????
		    			echo "<div class=\"module_admin_user\">\n";
		    			echo "<div class=\"module_admin_user_html\">";
	    			}
	    		}	
	    	?>
        <?php 
        foreach($modules['full'] as $v){
	  			/*php 7 ????????????????????????????????? $v['method'] = (STRING)$v['method']*/
	    		$method_fun=(STRING)$v['method'];
	   			$v['object']->$method_fun($v['pdo'],$v['args']);
   			}
        ?> 
		<div data-e="SPLIT TOKEN"></div>    	
	    	<?php
	    		if(isset($_GET["cloud"])){
	    			if($_GET["cloud"]=="index.user"){
		    			//??????????????????????????????DIV?????????
		    			echo "</div>\n";
		    			echo "</div>";
	    			}
	    		}	
	    	?>
		
        </div>
    </div>
</div>
<!-- END PAGE CONTAINER -->
<!-- BEGIN FOOTER -->
<div class="page-footer" cloud_layout="bottom" user_color='shape_bottom'>
    <!--????????????-->
    <?php
    if(!(isset($_GET["cloud"]) && $_GET["cloud"] == "form.data_add")){
        require('./templates/default/pc_bottom.php');
    }
    ?>
</div>
<script src="/public/sys_foot.js"></script> 

<!-- END FOOTER -->
     <audio id="notice_audio" src="" autoplay></audio>
     <p id=fade_div>
		 <p id=set_cloud_iframe_div>
			<a href=# id=close_button  title="<?php echo C_CLOSE;?>">&nbsp;</a>
			<iframe  id=cloud_iframe frameborder=0 src='' scrolling="yes" marginwidth=0 marginheight=0 vspace=0 hspace=0 allowtransparency=true></iframe>
		</p>
	 </p>
<div id="success_info" class="success_info" data-module="success" data-html="??????" style="display: none;">??????</div>
<div class="help_bubble" id="help_div" data-show="0">
    <div class="help clearfix">
<span class="triangle"></span>
	<div class="article">?????????????????????:./help??????.</div>
</div>
</div>
<div id="shelter" data-help="?????????"></div>
<img src="/images/weixin_share.png" class=weixin_share />
</body>
</html>