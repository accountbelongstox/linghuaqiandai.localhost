<?php
if(empty($_GET["appid"]) || empty($_GET["secret"])){
	exit("参数不足");
}


require 'HttpsRequest.php';
require 'CodeImg.php';
$CodeImg = new CodeImg;
$CodeImg->setappid($_GET["appid"]);
$CodeImg->setsecret($_GET["secret"]);
$CodeImg->setId($_GET["setId"]);//二维码场景ID


echo $CodeImg->getTicket().'<br/><img src="'.$CodeImg->getCodeUrl().'">';//根据自身业务需要取出ticket或url