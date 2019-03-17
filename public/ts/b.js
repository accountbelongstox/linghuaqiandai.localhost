

   var html = document.querySelector('html');
   var rem = html.offsetWidth / 6.4;
   html.style.fontSize = rem + "px";

$(function(){
  
  $(".main").click(function(){
  $("#Article h1").toggle(8);
  $("nav").toggle(8);
  $(".jiange").toggle(288);
});




/*  电脑测试，先不用识别。
 var MobileUA = (function() {  
        var ua = navigator.userAgent.toLowerCase();  
  
        var mua = {  
            IOS: /ipod|iphone|ipad/.test(ua), //iOS  
            IPHONE: /iphone/.test(ua), //iPhone  
            IPAD: /ipad/.test(ua), //iPad  
            ANDROID: /android/.test(ua), //Android Device  
            WINDOWS: /windows/.test(ua), //Windows Device  
            TOUCH_DEVICE: ('ontouchstart' in window) || /touch/.test(ua), //Touch Device  
            MOBILE: /mobile/.test(ua), //Mobile Device (iPad)  
            ANDROID_TABLET: false, //Android Tablet  
            WINDOWS_TABLET: false, //Windows Tablet  
            TABLET: false, //Tablet (iPad, Android, Windows)  
            SMART_PHONE: false //Smart Phone (iPhone, Android)  
        };  
  
        mua.ANDROID_TABLET = mua.ANDROID && !mua.MOBILE;  
        mua.WINDOWS_TABLET = mua.WINDOWS && /tablet/.test(ua);  
        mua.TABLET = mua.IPAD || mua.ANDROID_TABLET || mua.WINDOWS_TABLET;  
        mua.SMART_PHONE = mua.MOBILE && !mua.TABLET;  
  
        return mua;  
    }());  
  
    //SmartPhone   
    if (MobileUA.SMART_PHONE) {  
       
     //YJB 16-1203 正好是手机版 不管这个   document.location.href = 'http://www.bairongbank.com';  
    }  
	else {
		document.location.href = 'http://www.bairongbank.cn';  
	}

*/	

});

