	$(".navItem_box").hover(function(){
		$(this).css("backgroundColor",'#3A6C92').stop(true).animate({width:"110px"},200);
		return false;
	},function(){
		$(this).stop(true).animate({width:"38px",backgroundColor:"transparent"},200);
		return false;
	});