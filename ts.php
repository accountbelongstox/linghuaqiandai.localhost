<?php 
header('Content-Type:text/html;charset=utf-8');
require_once './config/functions.php';
$config=require_once './config.php';
$language=require_once './language/'.$config['web']['language'].'.php';
$pdo=new  ConnectPDO();
$divHtml = '';
$tables=return_table_info($pdo,$pdo->table_pre."table",false,"table_join[no],index_show",'__folder__,1',/*$all=*/true);//[no]=!=符号
foreach ($tables as $k => $v) {
	$logo = $v["titlebackgroundlogo"] ? "/upload/form/titlebackgroundlogo/".$v["titlebackgroundlogo"] : "/public/images/tableicon.jpg";
	$divHtml .= '<a href="/a/t'.$v["id"].'/">
		<div class="div">
		  <div class="l"><img src="'.$logo.'"></div>
		  <div class="r">
			<h3>'.$v["description"].'</h3>
			<span>1000元-5000元<br>'.$v["describe"].'</span></div>
			<div class="sq">立即申请</div>
		  <div class="tj">推荐</div>     
		</div>
	</a>';
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta content="telephone=no" name="format-detection" />
<meta name="keywords" content="好好金融">
<meta name="description" content="好好金融贷款申请表">
<title>手机贷 - 好好金融</title>
<link href="/public/ts/b.css" rel="stylesheet" type="text/css" />
<script src="/public/ts/jquery.js"></script>
<script src="/public/ts/b.js"></script>
</head>
<body>
<style>
.list .div{ border-bottom:.01rem solid #e4e4e4; padding:.22rem 0 0; margin:0 auto; position: relative;}
.div .l, .div .r {height:1.1rem;}
.div .l img {width:0.88rem; height:0.88rem; display:block; margin:0 auto ; border-radius:188px;}
.div .r {}
.div .r h3{ font-size:.31rem; font-weight: 700; color:#000; height:.44rem; line-height:.44rem;}
.div .r span{ color:#727171;  display:inline-block;line-height: .28rem;
    font-size: .24rem; }
.div .b {width:6.3rem;  height:.66rem; line-height:.66rem; white-space:nowrap; text-overflow:ellipsis; background:url(http://www.bairongbank.com/statics/images/icon/coins.png) no-repeat; background-size:auto .24rem; background-position:0 .18rem; padding-left:.3rem; font-size:.22rem;}
.sq{ position: absolute; right: 0; top: .38rem; z-index: 99; background-image: url(http://www.bairongbank.com/statics/images/icon/jt_r.png);
background-size: auto .20rem;
background-repeat: no-repeat;
background-position: 1.66rem .128rem;width: 1.88rem; height: .44rem; line-height: .44rem; font-size: .26rem; text-align:right; padding-right: .38rem; color: #0BB9EE;}
.tj{ background:#0BB9EE; border-radius: 88px; position: absolute; left: 3.5rem; top: .22rem; font-size: .24rem; color: #fff; text-align: center; width: .88rem; height: .38rem; line-height: .38rem; }
.foot_jd{border-bottom: 1px solid #e4e4e4; margin-top: .38rem; width: 100%; height: 1.77rem; line-height: 1.77rem; text-align: center;}
.foot_jd img{margin: .26rem auto 0; height: 1.44rem;}
.logo{overflow: hidden;}
.logo img{ width: 100%; border-bottom: 1px solid #e4e4e4;}
</style>
<div class="main logo"><img src="/public/images/ts.jpg"></div>
<div class="main" style="height: 4rem;">
	<div class="list">   
	<?php echo $divHtml;?>      
	<div id="pages" class="text-c"></div>
    </div>
    
</div>
<div class="main">
	<div class="foot_jd">
	</div>
</div>
<footer id="footer">
	<p class="info">&copy; 2017 <strong>好好金融    </strong> </p>
</footer>
</body>
</html>