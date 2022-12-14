var temp=window.location.href.split('index.php')[0];
temp=temp.split('?')[0];
var imgUrl = temp+'images/phone_menu_icon.png';
var lineLink =temp+'?cloud_device=phone';
var descContent = 'xx';
var shareTitle =document.title;
var appid = '';
function shareFriend() {
	WeixinJSBridge.invoke('sendAppMessage',{
		"appid": appid,
		"img_url": imgUrl,
		"img_width": "200",
		"img_height": "200",
		"link": lineLink,
		"desc": descContent,
		"title": shareTitle
	}, function(res) {
		//_report('send_msg', res.err_msg);
	})
}
function shareTimeline() {
	WeixinJSBridge.invoke('shareTimeline',{
		"img_url": imgUrl,
		"img_width": "200",
		"img_height": "200",
		"link": lineLink,
		"desc": descContent,
		"title": shareTitle
	}, function(res) {
		   //_report('timeline', res.err_msg);
	});
}
function shareWeibo() {
	WeixinJSBridge.invoke('shareWeibo',{
		"content": descContent,
		"url": lineLink,
	}, function(res) {
		//_report('weibo', res.err_msg);
	});
}
// 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
	// 发送给好友
	WeixinJSBridge.on('menu:share:appmessage', function(argv){
		shareFriend();
	});
	// 分享到朋友圈
	WeixinJSBridge.on('menu:share:timeline', function(argv){
		shareTimeline();
	});
	// 分享到微博
	WeixinJSBridge.on('menu:share:weibo', function(argv){
		shareWeibo();
	});
}, false);
