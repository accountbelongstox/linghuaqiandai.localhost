$(document).ready(function(){
	/*-----------------------------------*/
	$('.sdi_block').each(function(a,b){
		var color="ffffff";
		var obj={//取色器加载的JSON
			layout: 'hex',
			submit: 0,
			//submitText:'提交',
			color:color,
			onChange: function(c1,c2,c3){
				//code...
			},
			onSubmit:function(){
			}
		}
		if($(b).hasClass("sdi_backgroundcolor")){//背景色
			var c=$(b).find(".in_color").css("background-color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'background-color':"#"+c2
				}
				set_Table_Colors("sdi_backgroundcolor",cObj);
			}
		}
		if($(b).hasClass("sdi_titlebackgroundcolor")){//表头底色
			var c=$(b).find(".in_color").css("background-color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'background-color':"#"+c2
				}
				set_Table_Colors("sdi_titlebackgroundcolor",cObj);
			}
			
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_mainfontcolor")){//题目文字色
			var c=$(b).find(".in_color").css("color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'color':"#"+c2
				}
				set_Table_Colors("sdi_mainfontcolor",cObj);
			}
		}
		if($(b).hasClass("sdi_mainbackgroundcolor")){//内容底色
			var c=$(b).find(".in_color").css("background-color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'background-color':"#"+c2
				}
				set_Table_Colors("sdi_mainbackgroundcolor",cObj);
			}
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_titlefontcolor")){//表头文字色
			var c=$(b).find(".in_color").css("color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'color':"#"+c2
				}
				set_Table_Colors("sdi_titlefontcolor",cObj);
			}
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_desfontcolor")){//描述文字 
			var c=$(b).find(".in_color").css("color");
			obj["color"]=getHexBackgroundColor(c);
			obj["onChange"]=function(c1,c2,c3){
				var cObj={
					'color':"#"+c2
				}
				set_Table_Colors("sdi_desfontcolor",cObj);
			}
		}
		$(b).colpick(obj);
	})
	/*-----------------------------------*/
})


$("[tabindex='5004']").find(".formBuilder_color_items").click(function(){
	set_Table_AllStyles(this);
})
$(".upload_background_image_style").find(".stateBtn").click(function(){
	$(".upload_background_image_style").find(".stateBtn").removeClass("active");
	$(this).addClass("active");
	Set_Background_Position($(this).attr("chose-info"));
	
})
function Set_Background_Position(imgPosition){
	var obj={
		'background-position':imgPosition+' top'
	}
	set_Table_Colors('sdi_backgroundposition',obj)
}
$("#background_repeat").change(function(){
	set_background_repeatOrfix(this.id,this);
})
$("#background_fix").change(function(){
	set_background_repeatOrfix(this.id,this);
})
function set_background_repeatOrfix(type,this_){
	var obj={};
	switch(type){
		case "background_repeat":
			obj['background-repeat']=$(this_).get(0).checked ? 'repeat' : 'no-repeat';
			set_Table_Colors('sdi_backgroundrepeat',obj);
		break;
		case "background_fix":
			obj['background-attachment']=$(this_).get(0).checked ? 'fixed' : 'scroll';
			set_Table_Colors('sdi_backgroundfix',obj);
		break;
	}
}
function set_Table_Colors(type,obj){
	//参数说明,type=设置类型,color_json=传入的颜色JSON
	//set_Table_Colors('sdi_backgroundposition',obj)
	switch(type){
		case 'sdi_backgroundcolor'://背景色
			$(".formBuilder_example").css(obj);
			$(".sdp_color.sdp_color_wb").css(obj);
			$(".sdi_backgroundcolor").find(".in_color").css(obj);
		break;
		case 'sdi_backgroundimage'://背景图
			$(".formBuilder_example").css(obj);
		break;
		case 'sdi_backgroundposition'://背景图位置
			$(".formBuilder_example").css(obj);
		break;
		case 'sdi_backgroundfix'://背景图是否滚动
			$(".formBuilder_example").css(obj);
		break;
		case 'sdi_backgroundrepeat'://背景图是否重复/固定
			$(".formBuilder_example").css(obj);
		break;
		case 'sdi_titlebackgroundcolor'://表头底色
			$(".formBuilder_example_form").find(".form_title").css(obj);
			$(".sdp_color.sdp_color_lb").css(obj);
			$(".sdi_titlebackgroundcolor").find(".in_color").css(obj);
		break;
		case 'sdi_titlebackgroundimage'://表头底图
			$("[tabindex='5000']").find(".form_title").css(obj);
		break;
		case 'sdi_titlebackgroundlogo'://LOGO
		
			$("[tabindex='5000']").find(".form_title .title").addClass('haslogo');
			$("[tabindex='5000']").find(".form_title .title").css({
				'padding-left': '115px',
    			'width': '385px'
			});
			$("[tabindex='5000']").find("#face").attr(obj);
			$("[tabindex='5000']").find("#face").show();
			$("[tabindex='5000']").find(".formLogo").show();
			
		break;
		case 'sdi_mainfontcolor'://题目文字色
			$(".formBuilder_example_form").find("label.title").css(obj);
			var obj_={
				"background-color":obj["color"]
			}
			$(".sdp_color.sdp_color_ft").css(obj_);
			$(".sdi_mainfontcolor").find(".in_color").css(obj);
		break;
		case 'sdi_mainbackgroundcolor'://内容底色
			$("#ui-sortable").css(obj);
			$(".sdp_color.sdp_color_fb").css(obj);
			$("#ui-sortable").children("li").css(obj);
			$(".sdi_mainbackgroundcolor").find(".in_color").css(obj);
		break;
		case 'sdi_titlefontcolor'://表头文字色
			$(".formBuilder_example_form").find(".form_title").find(".title").find("h2").css(obj);
			var obj_={
				"background-color":obj["color"]
			}
			$(".sdp_color.sdp_color_lt").css(obj_);
			$(".sdi_titlefontcolor").find(".in_color").css(obj);
		break;
		case 'sdi_desfontcolor'://描述文字 
			$(".formBuilder_example_form").find("#data-remark").css(obj);
			var obj_={
				"background-color":obj["color"]
			}
			$(".sdp_color.sdp_color_it").css(obj_);
			$(".sdi_desfontcolor").find(".in_color").css(obj);
		break;
		default:
		break;
	}
}

function set_Table_AllStyles(e){
	var obj={}
	obj['background-color']="#"+$(e).find(".color_show_block").attr("bk");//背景色
	set_Table_Colors("sdi_backgroundcolor",obj);
	obj=null;
	obj={};
	/*-----------------------------------*/
	obj['background-color']="#"+$(e).find(".csb_title").attr("bk");//表头底色
	set_Table_Colors("sdi_titlebackgroundcolor",obj);
	obj=null;
	obj={};
	/*-----------------------------------*/
	obj['color']="#"+$(e).find(".csb_contect").attr("t");//题目文字色
	set_Table_Colors("sdi_mainfontcolor",obj);
	obj=null;
	obj={};
	/*-----------------------------------*/
	obj['background-color']="#"+$(e).find(".csb_contect").attr("bk");//内容底色
	set_Table_Colors("sdi_mainbackgroundcolor",obj);
	obj=null;
	obj={};
	/*-----------------------------------*/
	obj['color']="#"+$(e).find(".csb_title").attr("t");//表头文字色
	set_Table_Colors("sdi_titlefontcolor",obj);
	obj=null;
	obj={};
	/*-----------------------------------*/
	//obj['color']="#"+$(e).find(".csb_des").attr("t");//描述文字 
	obj['color']="#"+$(e).find(".csb_title").attr("t");//描述文字
	set_Table_Colors("sdi_desfontcolor",obj);
	/*-----------------------------------*/
}
function UploadimagesucceedCollBack(e){
	setTimeout(function(){
		var id=e.attr('id');
		var obj={
			'background-image':'url(/upload/form/'+id+'/'+e.val()+')'
		}
		switch(id){
			case 'backgroundimage'://背景图
				set_Table_Colors('sdi_backgroundimage',obj);
			break;
			case 'titlebackgroundimage'://头部底图
				set_Table_Colors('sdi_titlebackgroundimage',obj);
			break;
			case 'titlebackgroundlogo'://头部LOGO
				obj['src']=obj['background-image'].split('url(')[1].split(')')[0];
				obj['background-image']=null;
				set_Table_Colors('sdi_titlebackgroundlogo',obj);
			break;
		}
		
	},500)
	
	/*
	*/
}
$("#form_changelogo").change(function(){
	form_Img_UP(this);
})
$("#form_background").change(function(){
	form_Img_UP(this);
})
$("#form_title_background").change(function(){
	form_Img_UP(this);
})
function form_Img_UP(e){
	if($(e).get(0).checked){
		$(e).parent().next().show();
	}else{
		$(e).parent().next().hide();
	}
	
}
function getHexBackgroundColor(rgb){
	if(rgb.indexOf("rgb") != -1){
		rgb=rgb.split('(')[1].split(')')[0].split(',');
	    //rgb=rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/); 
	    function hex(x){ 
	      return ("0"+parseInt(x).toString(16)).slice(-2); 
	    } 
	    rgb="#"+hex(rgb[0])+hex(rgb[1])+hex(rgb[2]); 
	}
  return rgb; 
} 
$(".style_design_pad").click(function(){
	if($(this).attr("data-click") == "0"){
		$(this).parent().prev().animate({
			bottom:'32px'
		},300)
		$(this).parent().animate({
			height:'32px'
		},300,function(){
			$(".style_design_pad").attr({
				"data-click":"1"
				})
		})
	}else{
		$(this).parent().prev().animate({
			bottom:'62%'
		},300)
		$(this).parent().animate({
			height:'62%'
		},300,function(){
			$(".style_design_pad").attr({
				"data-click":"0"
				})
		})
	}
	})
function formBuilder_color_resite(){
    //窗口变小时,将右边颜色窗口加入切换
    if($(window).width() <= 1220){
      $('.formBuilder_color').addClass('formBuilder_edit');
      $('.formBuilder_color').hide();
    }else{
      $('.formBuilder_color').removeClass('formBuilder_edit');
      $('.formBuilder_color').show();
    }
  }
//窗口变小时,将右边颜色窗口加入切换
$('.formBuilder_interim_edit').eq(0).trigger('click');
formBuilder_color_resite();
//window辅助表单编辑区
$(window).bind("keydown",function(){
	$("#ui-sortable").children("li").attr({
		"data-ctrl-copy":"1"
	})
})
$(window).bind("keyup",function(){
	$("#ui-sortable").children("li").attr({
		"data-ctrl-copy":"0"
	})
})
$(document).bind("mouseup",function(){
	setTimeout(function(){
		$("#ui-sortable").children("li").removeClass('data-draggable-yes');
	},3000)
})
 $(window).resize(function(){    
  formBuilder_color_resite()
 })
	//表单控制CSS
	$('.form_edit_titlefield p').click(function(){
		$('.form_edit_titlefield p').removeClass('formBuilder_interim_edit_active');
		$(this).addClass('formBuilder_interim_edit_active');
    formBuilder_color_resite();
		$('.formBuilder_edit').hide();
		$('.formBuilder_edit').eq($(this).index()).show();
	});
	$('.form_edit_titlefield p').click(function(){
		$('.form_edit_titlefield p').removeClass('formBuilder_interim_edit_active');
		$(this).addClass('formBuilder_interim_edit_active');
		$('.formBuilder_edit').hide();
		$('.formBuilder_edit').eq($(this).index()).show();
	});
	$('.form_edit_expand_title').click(function(){
		$(this).next().toggle();
		if($(this).find('img').attr('src') == 'images/icon/pullupBlue.png'){
			$(this).find('img').attr({src:'images/icon/pulldownBlue.png'})
		}else{
			$(this).find('img').attr({src:'images/icon/pullupBlue.png'})

		}
	});
	//标题
	$('.formName_input').change(function(){
		copy_text_form($(this),$('.form_title .title').find('h2'))
	});
	$('.formName_input').keyup(function(){
		copy_text_form($(this),$('.form_title .title').find('h2'))
	});
	$('.formName_input').blur(function(){
		copy_text_form($(this),$('.form_title .title').find('h2'))
	});
	//描述
	$('.formDescribe_input').change(function(){
		copy_text_form($(this),$('.form_title .title').find('div'))
	});
	$('.formDescribe_input').keyup(function(){
		copy_text_form($(this),$('.form_title .title').find('div'))
	});
	$('.formDescribe_input').blur(function(){
		copy_text_form($(this),$('.form_title .title').find('div'))
	});
	//复制文本到对方
	function copy_text_form(ele1,ele2){
		ele2.html(ele1.val());
	}

	//对应的拖动JSON
  var varchar_text='<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">单行文本</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><input type="text" class="input medium" disabled="true"></div></li>';
	var DForm={
		'text':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">单行文本</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><input type="text" class="input medium" disabled="true"></div></li>',
		'textarea':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">多行文本</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><textarea class="textarea medium" disabled="true"></textarea></div></li>',
		'editor':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">编辑器</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><textarea class="textarea medium" disabled="true"></textarea></div></li>',
		'select':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">下拉菜单</label><span class="com_required"></span></span><p class="instruct" style=""></p><div class="select"><select class="medium" disabled="true"><option name="-1">请选择</option><option name="1">男</option><option name="2">女</option></select></div></li>',
		'radio':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">单选</label><span class="com_required"></span></span><p class="instruct" style=""></p><div class="radio"><ul class="optionGarden ui-sortable"><li class="optionsLine medium"><input type="radio" name="radio4" value="男" disabled="true"><label class="optionValue">男</label></li><li class="optionsLine medium"><input type="radio" name="radio4" value="女" disabled="true"><label class="optionValue">女</label></li></ul><div class="clearB"></div></div></li>',
		'checkbox':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">多选</label><span class="com_required"></span></span><p class="instruct" style=""></p><div class="checkbox"><ul class="optionGarden ui-sortable"><li class="optionsLine medium"><input type="checkbox" name="checkbox5" value="男" disabled="true" class="input_checkbox"><label class="optionValue">男</label></li><li class="optionsLine medium"><input type="checkbox" name="checkbox5" value="女" disabled="true" class="input_checkbox"><label class="optionValue">女</label></li></ul><div class="clearB"></div></div></li>',
		'img':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><p class="instruct" style=""></p><div class="title_field img_title"><img src="/images/icon/formDefaultPicture.png" style="width: 100%;"></div><div class="subtitle">这里是图片,写下你对它的描述</div></li>',
		'imgs':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><p class="instruct" style=""></p><div class="title_field img_title"><img src="/images/icon/formDefaultPicture.png" style="width: 100%;"></div><div class="subtitle">这里是图片,写下你对它的描述</div></li>',
		'file':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">文件</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><div class="upload_file medium"><input type="file" class="input_file" name="_FILE_" data-url="" disabled="true"><p>请选择小于20M的文件进行上传</p><img src="/images/icon/importFileAdd.png"></div></div></li>',
		'files':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">多文件</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><div class="upload_file medium"><input type="file" class="input_file" name="_FILE_" data-url="" disabled="true"><p>请选择小于20M的文件进行上传</p><img src="/images/icon/importFileAdd.png"></div></div></li>',
		'number':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">数字</label><span class="com_required"></span></span><p class="instruct" style=""></p><div><input type="text" class="input medium" disabled="true"></div></li>',
		'time':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">日期</label><span class="com_required"></span></span><div><input type="text" class="date input medium" datetype="d" disabled="true"></div></li>',
		'map':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><div class="title_field img_title"><img src="/images/icon/formDefaultmap.jpg" style="width: 100%;"><p class="instruct" style=""></p></div><div class="subtitle">这里是图片,写下你对它的描述</div></li>',
		'area':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><span class="title_field"><label class="title">地区选择器</label><span class="com_required"></span></span><p class="instruct" style=""></p><div class="select"><select class="medium" disabled="true"><option name="-1">请选择</option><option name="0">北京</option><option name="1">上海</option><option name="2">天津</option></select></div></li>',
		'page':'<li data-page="1" onclick="show_edit_or_hide($(this).attr(\'input_type\'),this);" onmousedown="data_draggable_yes=this;$(\'ui-sortable\').attr({\'data-name\':$(this).attr(\'name\')});" class="ui-draggable " data-title="点击选择或拖动到左侧" title="点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."><div class="deleteButton" onclick="deleteButton_close(this);" onmouseover="deleteButton_onmouseover(this);" onmouseout="deleteButton_onmouseout(this);"></div><div class="page_pre">第 1 页</div><div class="page"><div class="same-as-break break_color"></div></div><div class="page_next">第2 页</div></li>',
    'name':varchar_text,
    'company':varchar_text,
    'job':varchar_text,
    'adress':varchar_text,
    'phone':varchar_text,
    'email':varchar_text,
    'qq':varchar_text,
    'weixin':varchar_text,
    'gender':varchar_text,
    'city':varchar_text,
    'fixedphone':varchar_text,
    'fax':varchar_text,
    'website':varchar_text,
    'birthday':varchar_text,
    'note':varchar_text
}
function args_inputTohtml(ele){
  var ele=$(ele);
  var args=ele.attr('args');
  var type=args.split('_')[0].split('|')[1];
  switch(type){
      case 'select':
        var temp=args.split(':')[1].split('|')[0].split('/');
        var option='';
        for(var i=0;i<temp.length;i++){
          option+='<option value="'+temp[i]+'">'+temp[i]+'</option>';
        }
        option='<select class="medium" disabled="true">'+option+'</select>';
        ele.find('.select').html(option);
        return option;
        break;
      case 'radio':
        var temp=args.split(':')[1].split('|')[0].split('/');
        var option='';
        for(var i=0;i<temp.length;i++){
          option+='<li class="optionsLine medium"><input type="radio" value="'+temp[i]+'" disabled="true"><label class="optionValue">'+temp[i]+'</label></li>';
        }
        ele.find('.optionGarden').html(option);
        return option;
        break;
      case 'checkbox':
        var temp=args.split(':')[1].split('|')[0].split('/');
        var option='';
        for(var i=0;i<temp.length;i++){
          option+='<li class="optionsLine medium"><input type="checkbox" name="checkbox5" value="'+temp[i]+'" disabled="true" class="input_checkbox"><label class="optionValue">'+temp[i]+'</label></li>';
        }
        ele.find('.optionGarden').html(option);
        return option;
        break;
        default:
        return false;
      }
}

//获取元素的全部属性名
function get_attr_name(e){              
  var a=$(e).get(0).attributes;
  var b=[];
      $.each(a,function(f,s){
        b.push(s.name);
       //console.dir(s.name);
      })
  return b;
}
/*--往表里添加元素*/
function append_To_tableEle(type){
    var e=$($(DForm[type]).get(0));
    var length=$(".form_component").find("[input_type='"+type+"']").length;
    	length=length+1;

    switch(type){
      case 'text':
      e.attr({
      //单行文本
      description:'单行文本',
      name:type+(length+1),
      input_type:type,
      args:'|text_length'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;

      //多行
      case 'textarea':
      e.attr({
      description:'多行文本',
      name:type+(length+1),
      input_type:type,
      args:'|textarea_width:'+'|textarea_height:'+'|textarea_default_value:'+'|textarea_allow_html:',
      placeholder:'',//提示
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;


      //编辑器
      case 'editor':
      e.attr({
      description:'编辑器',
      name:type+(length+1),
      input_type:type,
      args:'|editor_height:'+'|editor_default_value:'+'|editor_open_image_mark:0',
      placeholder:'',//提示
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;


      //下拉
      case 'select':
      e.attr({
      description:'下拉选择',
      name:type+(length+1),
      input_type:type,
      args:'|select_option:男/女'+'|select_default_value:男',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;

      //单选
      case 'radio':
      e.attr({
      description:'单选',
      name:type+(length+1),
      input_type:type,
      args:'|radio_option:男/女'+'|radio_default_value:男',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;

      //复选
      case 'checkbox':
      e.attr({
      description:'多选框',
      name:type+(length+1),
      input_type:type,
      args:'|checkbox_option:男/女'+'|checkbox_default_value:男',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':0,
      search_able:1,
      data_style:0
      })
      break;


      //图片
      case 'img':
      e.attr({
      description:'图片',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|img_allow_image_type:bmp,jpg,jpeg,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,WMF'+'|img_open_image_mark:0'+'|img_width:'+'|img_height:',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //
      //多图片
      case 'imgs':
      e.attr({
      description:'多图片',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|imgs_allow_image_type:bmp,jpg,jpeg,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw,WMF'+'|imgs_open_image_mark:0'+'|imgs_width:'+'|imgs_height:',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //允许搜索
      //文件上传
      case 'file':
      e.attr({
      description:'文件上传',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|file_allow_file_type:rar,zip,doc,docx',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //
      //多文件上传
      case 'files':
      e.attr({
      description:'多文件上传',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|files_allow_file_type:rar,zip,doc,docx',
      
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //

      //数字 
      case 'number':
      e.attr({
      description:'数字',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|number_min:0'+'|number_max:'+'|number_decimal_places:0'+'|number_default_value:',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //允许搜索

      //时间
      case 'time':
      e.attr({
      description:'时间',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'|time_style:Y-m-d',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //允许搜索
	case 'page'://page判断
	if($(".ui-sortable li").length < 1 || $(".ui-sortable li").last().attr("input_type") == "page"){
		show_success("请先添加数据再分页");
		return false;
	}
	var page_n=$(".ui-sortable").find("li[input_type=page]").length+1;
	e.addClass('page_select_'+page_n);
	e.attr({
		input_type:type,
		"data-page":page_n,
		"data-return":'0'
	});
	//set_page_pv_html(e,page_n);
	break;
      //地图坐标
      case 'map':
      e.attr({
      description:'地图坐标',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
  //允许搜索

      //地区选择器
      case 'area':
      e.attr({
      description:'地区选择',//名字
      name:type+(length+1),//字母名
      input_type:type,//类型
      args:'',
      placeholder:'',//提示
      reg:'',
      set_reg:'',//正则
      unique:0,//唯一
      'data-required':0,//必填 
      search_able:1,
      data_style:0
      })
      break;
    //允许搜索
      case 'name':
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'姓名',
      name:thename,
      input_type:'text',
      args:'|text_length:3'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'company':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'公司名称',
      name:thename,
      input_type:'text',
      args:'|text_length:40'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'job':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'职位',
      name:thename,
      input_type:'text',
      args:'|text_length:10'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'address':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'通讯地址',
      name:thename,
      input_type:'text',
      args:'|text_length:50'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'phone':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'手机号码',
      name:thename,
      input_type:'text',
      args:'|text_length:11'+'|text_default_value',
      placeholder:'',
      reg:'/^(1)[0-9]{10}$/',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'email':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'电子邮件',
      name:thename,
      input_type:'text',
      args:'|text_length'+'|text_default_value',
      placeholder:'',
      reg:'/^[\\w\\-\\.]+@[\\w\\-\\.]+(\\.\\w+)+$/',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'qq':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'QQ',
      name:thename,
      input_type:'text',
      args:'|text_length:12'+'|text_default_value',
      placeholder:'',
      reg:'/^[0-9.-]+$/',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'weixin':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'微信',
      name:thename,
      input_type:'text',
      args:'|text_length:15'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'gender':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'性别',
      name:thename,
      input_type:'text',
      args:'|text_length:2'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'city':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'城市',
      name:thename,
      input_type:'text',
      args:'|text_length:8'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'fixedphone':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'固定电话',
      name:thename,
      input_type:'text',
      args:'|text_length'+'|text_default_value',
      placeholder:'',
      reg:'/^[0-9-]{6,13}$/',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'fax':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'传真',
      name:thename,
      input_type:'text',
      args:'|text_length'+'|text_default_value',
      placeholder:'',
      reg:'/^[0-9-]{6,13}$/',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'website':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'网站(http"//)',
      name:thename,
      input_type:'text',
      args:'|text_length'+'|text_default_value',
      placeholder:'',
      reg:'/^http:\\/\\//',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'birthday':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'生日',
      name:thename,
      input_type:'text',
      args:'|text_length:20'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      e.find('.title').html(e.attr('description'));
      break;
      case 'note':
      
      var length=get_name_type(type);
      if(length>0){
      var thename=type+(length+1);
      }else{
      var thename=type;
      }
      e.attr({
      description:'备注',
      name:thename,
      input_type:'text',
      args:'|text_length:255'+'|text_default_value',
      placeholder:'',
      reg:'',
      set_reg:'',
      unique:0,
      'data-required':1,
      search_able:1,
      data_style:0
      })
      
      e.find('.title').html(e.attr('description'));
      break;
    }
    e.attr({
    	'data-ctrl-copy':'0',/*默认不拖动复制*/
    	'data-page':1
    })
    $(".form_component").append(e);
    return e;
}
//设置分页参数
	function set_page_pv_html(e,n){
		e.find(".page_pre").html("第 "+n+" 页");
		e.find(".page_next").html("第 "+(n+1)+" 页");
	}
	$('.utilityCol li').click(function (){
		//用户选择的元素送入编辑区
		var type=$(this).attr('id').split('_')[1];
	    if(!type){
	      var type=$(this).attr('id');
	    }
	    var e=append_To_tableEle(type);
	    e.css({
	    	"background-color":$(".sdi_mainbackgroundcolor").find(".in_color").css("background-color")
	    })
	    e.find(".title_field").find(".title").css({
	    	"color":$(".sdi_mainfontcolor").find(".in_color").css("color")
	    });
	    if(e == false){
	    	return false;
	    }
	    set_page_pv();
		$('.formBuilder_interim_edit').eq(2).trigger('click');
		//显示编辑
		$('.formBuilder_example_form').scrollTop($('.form_component').height());


		show_edit_or_hide(type,e);
    /*draggable({})拖动  
     * 初始：$('.selector').draggable({ cursor: 'crosshair' });   
		 * 获取：var cursor = $('.selector').draggable('option', 'cursor');   
		 * 设置：$('.selector').draggable('option', 'cursor', 'crosshair');   
		 * 
     * axis 方向(xy)
     * containment : Selector,Element,String, Array : false 强制draggable只允许在指定元素或区域的范围内移动，可选值：'parent', 'document',
     * cursor : String : 'auto'  指定在做拖拽动作时，鼠标的CSS样式。    crosshair,cursor,crosshair
     * opacity : Float : false  当元素开始拖拽时，改变元素的透明度。   
     * snap : Boolean, Selector : false  当设置为true或元素标签时，元素拖动到其它元素的边缘时，会自动吸附其它元素。   
     * snapMode : String : 'both'   确定拖拽的元素吸附的模式。可选值：'inner', 'outer', 'both'  
     * snapTolerance : Integer : 20   确定拖拽的元素移动至其它元素多少像素的距离时，发生吸附的动作。   
     * zIndex : Integer : false  控制当拖拽元素时，改变元素的z-index值。
     * start   当鼠标开始拖拽时，触发此事件。   初始：$('.selector').draggable({ start: function(event, ui){...} });    
     * 绑定：$('.selector').bind('dragstart', function(event, ui){...});
     * drag   当鼠标拖拽移动时，触发此事件。   bind('drag'
     * stop   当鼠标松开时，触发此事件。   bind('dragstop'
     * $("#draggable2").draggable({ revert: true, helper: ‘clone' }); //helper:'clone' 复制拖动  original
     * */
 		 $(e).draggable({
 			addClasses:false,
 			axis:'y',
 			containment:'parent',
 			cursor:'auto',
 			snap: true,//吸附
 			snapMode:'outer',//吸附模式
 			snapTolerance: 50,
 			connectToSortable: '#ui-sortable',
 			helper:"original",
 			start:function(){
 				
 			},
 			drag:function(){/*拖动中,计算和上下元素的关系*/ 
 			},
 			stop:function(){/*拖动结束,更新表排序*/

 			}
 		});
 		
})
$("#set_reg").change(function(){
	/*正则*/
	var reg=$(this).val();
	$("#reg").val(reg);
	$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr({
		"reg":reg,
		"set_reg":reg
	})
})
$("#data-required").change(function(){
	/*用户必填*/
	var v=$(this).val();
	$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr({
		"data-required":v
	})
})
$("#search_able").change(function(){
	/*可搜索*/
	var v=$(this).val();
	$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr({
		"search_able":v
	})
})
$("#unique").change(function(){
	/*唯一值*/
	var v=$(this).val();
	$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr({
		"unique":v
	})
})

$("#textarea_allow_html").change(function(){
	/*是否HTML*/
	set_ages_attribute(this);
})
$("#editor_open_image_mark").change(function(){
	/*是否图片水印*/
	set_ages_attribute(this);
})
$("#textarea_allow_html").change(function(){
	/*是否允许HTML*/
	set_ages_attribute(this);
})
$("#number_decimal_places").change(function(){
	/*小数位数*/
	set_ages_attribute(this);
})
$("#time_style").change(function(){
	/*时间格式*/
	set_ages_attribute(this);
})
$("#imgs_open_image_mark").change(function(){
	/*是否水印*/
	set_ages_attribute(this);
})
$("#img_open_image_mark").change(function(){
	/*是否水印*/
	set_ages_attribute(this);
})


function set_ages_attribute(e){
	var id=$(e).attr("id");
	var args=$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr("args").split("|");
	var v_=[];
	for(var i=0;i<args.length;i++){
		if(args[i].indexOf(id) != -1){
			var a_arr=args[i].split(":");
			args[i]=a_arr[0]+':'+$(e).val();
		}
		v_.push(args[i]);
	}
	$("#ui-sortable").find("[name='"+$("[tabindex='5003']").attr("name")+"']").attr(id,v_.join('|'));
}

var data_draggable_yes="null";
function deleteButton_onmouseover(e){
	$(e).parent().attr({
		"onclick":null
	});
}
function deleteButton_onmouseout(e){
	$(e).parent().click(function(){
		show_edit_or_hide($(e).parent().attr('input_type'),$(e).parent());
	});
}
/*------------------------------------------*/
function set_page_pv(){
	var lis=$("#ui-sortable").children("li");
			lis.each(function(a,b){
				//移除多余的page标签 
				if($(b).attr("input_type") == 'page'){
					if($(b).prev().attr("input_type") == 'page'){
						$(b).prev().remove();
					}
				}
			})
			//重新排序标签 & 给元素排序
			var pag_n=1;
			var sequence=1;
			$("#ui-sortable").children("li").each(function(a,b){
				$(b).attr({
						"data-page":pag_n
				})
				if($(b).attr("input_type") == 'page'){
					set_page_pv_html($(b),pag_n);
					pag_n++;
				}else{
					//排序
					$(b).attr({
						'data-sequence':sequence
					})
					sequence++;
				}
			})
	if($("#data-uniqueness").get(0).checked){
		ifUniqueness();
	}
	$('.formBuilder_interim_edit').eq(0).trigger('click');
}
function ifUniqueness(){
	if($("#data-uniqueness").get(0).checked){//判断重复的元素已经被用户删除
      	var ele_arr=[];//用来判断用户是否允许重复提交的数组,存放列表区是否有对应的表单
      	var val=$('.uniqueness input[name="formuniqueness"]:checked').val();
      	$("#ui-sortable").children("li").each(function(a,b){
	      	if($(b).attr("name") && $(b).attr("name").indexOf(val) != -1){
	      		ele_arr.push(b);
	      	}
      	})
		if(ele_arr.length < 1){
			$("#data-uniqueness").trigger("click");
		}
	}
}
$("#ui-sortable").sortable({
	revert:true,
	axis:'y',
	cursor:'auto',
	drag:function(){/*拖动中,计算和上下元素的关系*/ 
		
	},
	stop:function(){/*拖动结束,更新表排序*/
		//---------------------------------------------
		set_page_pv();
		//---------------------------------------------
	}
})

//检测碰撞 只检查上下
function javascriptImpact(ele, nextele) {
    var a = {
        t: ele.offset().top,
        b: ele.height()+ele.offset().top
    } 
    var b = {
        t: nextele.offset().top,
        b: nextele.height()+nextele.offset().top
        }
   	var h=(nextele.height()/100)*60;
   if(a.b > b.t && a.t < b.b || a.b < b.b && a.b > b.t){
	   	if(a.b > (b.t+h)){//大于20%时向下移动.
	   		return 'up';
	   	}
	   	if(a.t > (b.b+h)){
	   		return 'down';
	   	}
   		return true;
   }else{
   		return false;
   }
}
 

  function get_name_type(reg){
    var a=$(".form_component").find("[name]");
    var arr=[];
    for(var i=0;i<a.length;i++){
      if($(a[i]).attr('name').indexOf(reg) != -1){
        arr.push(a[i]);
      }
    }
    return arr.length;
  }
	$("#prev_page_radio_limit").change(function(){
		var e=$("#ui-sortable").find(".page_select_"+$(this).attr("data-page"));
		if($(this).get(0).checked){
			e.attr({
				"data-return":"1"
			})
		}else{
			e.attr({
				"data-return":"0"
			})
		}
	})
	

  function give_attrVal(type,e){
  		if(type == 'page'){
  			$("#form_edit_prev_page").find("#prev_page_radio_limit").attr({
  				'data-page':$(e).attr('data-page')
  			})
  			return false;
  		}
      var attrs=get_attr_name(e);
      for (var i = 0; i <attrs.length; i++) {
        if(attrs[i] != 'class' && attrs[i] != 'title'){
          if($('#'+attrs[i])){
            $('#'+attrs[i]).val($(e).attr(attrs[i]));//将本身的值覆盖到编辑器
            $('#'+attrs[i]).find("option[value='"+attrs[i]+"']").attr("selected",true);
          }
        }
      }
      var vals=$(e).attr('args').split('|');
      for(var i=0;i<vals.length;i++){
        var valsv=vals[i].split(':');
        if(valsv[1] != ''){
          $('#'+valsv[0]).val(valsv[1]);
        }
      }
      var str=$(e).attr('args').split(type+'_option:')[1];
      if(str && str.indexOf('|')!= -1){
        str=str.split('|')[0];
      }
     $('#'+type+'_option').val(str);//属性区

      var str=$(e).attr('args').split(type+'_default_value:')[1];
      if(str && str.indexOf('|')!= -1){
        str=str.split('|')[0];
      }
     $('#'+type+'_default_value').val(str);//默认属性区
       $('#'+type+'_default_value').val(str);//默认属性区
  }
	function show_edit_or_hide(type,e){
		var e=$(e);
    /*表单点击事件,将表单值传送给编辑区*/
		var toggle_e=$('.formBuilder_interim_edit').eq(2);
		var div_e=$("[tabindex='5003']");
		div_e.attr({
			name:$(e).attr('name')
		});
    	$('.form_componentEdit_tips').hide();
		if(type == 'page'){
			div_e.find('div').hide();
			$('#form_edit_prev_page').show();
      		$('#form_edit_prev_page').children().show();
			$('#args_div').find('[id]').hide();
			$('#args_div').find('input').hide();
			set_propertys_reutnr1or2($(e).attr('data-return'),$("#prev_page_radio_limit"));
			$('#args_'+type).hide();
			$('#args_'+type).find('input').hide();
			$('#args_'+type).find('textarea').hide();
			$('#args_'+type).find('select').hide();
		}else{
			$('#description').val($(e).attr('description'));
			div_e.find('div').show();
			$('#form_edit_prev_page').hide();
			$('#args_div').find('[id]').hide();
			$('#args_div').find('input').hide();
			$('#args_'+type).show();
			$('#args_'+type).find('input').show();
			$('#args_'+type).find('textarea').show();
			$('#args_'+type).find('select').show();
		}
	toggle_e.trigger('click');
	give_attrVal(type,e);
			
   	$("#ui-sortable").children("li").removeClass("unedited");
   	$(e).addClass("unedited");
   	
	}

	$("[tabindex='5003']").find('input,select,textarea').keyup(function(){
		var e=$(this);
		var id=e.attr('id');
		switch(id){
			case 'description':
			give_toggle_ele_val(e,false,'title');
			break;
			case 'placeholder':
			give_toggle_ele_val(e,false,'instruct');
			break;
			case 'set_reg':
			give_toggle_ele_val(e,$('#reg'),false,function(){
				give_toggle_ele_val(e,$('.form_component').find("[name="+$("[tabindex='5003']").attr('name')+"]"),true);
			});
			break;
			default:
			give_toggle_ele_val(e,false,false);
			break;
		}
	})
	function give_toggle_ele_val(my,ele,ty,fn){/*本身,目标*/
		var my=$(my);
		var v=my.val();
		var id=my.attr('id')

		if(!ele){
			var ele=$('.form_component').find("[name="+$("[tabindex='5003']").attr('name')+"]");
		}else{
			if(ty){
				var obj={};
				obj[id]=v;
				ele.attr(obj);
			}else{
				ele.val($(my).val());
			}
			if(fn){fn();}
		}
		if(my.parent().parent().parent().attr('id') == 'args_'+ele.attr('input_type')){
			var a=ele.attr('args').split('|');
			var new_arr=[''];
			for(var i=0;i<a.length;i++){
				if( a[i] != ''){
					if(a[i].indexOf(id) != -1){
						new_arr.push(id+':'+v);
					}else{
						new_arr.push(a[i]);
					}
				}
			}
			ele.attr({
				'args':new_arr.join('|')
			})
		}else{
      var obj={};
      switch(id){
        case 'required':/*绕过H5保留字*/
        obj['data-'+id]=v;
        break;
        default:
        obj[id]=v;
        break;
      }
			ele.attr(obj);
		}

		if(ty){
			switch(ty){
				case 'title':
				ele.find('.title').html(v);
				break;
				case 'instruct':
				ele.find('.instruct').html(v);
				break;
				default:
				break;
			}
		}
	}

  //用于判断两种状态,如与参数1相同返回true,与参数2相同返回false
  function reutrn_true(val1,val2){
      if(val1==val2){
        return true;
      }else{
        return false;
      }
  }

  //初始化表操作区
  $('.formName_input').val($('.form_title').find('.title').children('h2').html());
  $('.formInstruct_input').val($('.form_title').find('.title').children('div').html());

  if(reutrn_true($('#data-uniqueness').attr('data-uniqueness'),'1')){
      $('#data-uniqueness').trigger('click');
      uniqueness()
  }

 $('#data-uniqueness').change(function(){//是否允许重复数据开关
    uniqueness();
 })
  
$('.uniqueness input[name="formuniqueness"]').change(function(){//是否允许重复数据条件
	uniqueness();
})
  //重复提交数据
  function uniqueness(){
      if($('#data-uniqueness').is(':checked')){
	      //如果所选择的元素没有,则默认添加
	      var arr=[];
	      var val=$('#val-uniqueness input[name="formuniqueness"]:checked').val();
	      $("#ui-sortable").children("li").each(function(a,b){
	      	if($(b).attr("name") && $(b).attr("name").indexOf(val) != -1){
	      		arr.push(b);
	      		$('#val-uniqueness input[name="formuniqueness"]:checked').val($(b).attr("name"));
	      		return false;
	      	}
	      })
	      if(arr.length < 1){
	      	$("#"+val).trigger('click');
	      }
          $('#val-uniqueness').show();
      }else{
          $('#val-uniqueness').hide();
      }

  }
if($('#publish_condition').attr('data-publish_condition')!=''){
    $('#publish_condition').trigger('click');
    $(window).bind('load',function(){
        publish_condition();

    })
}
$("#publish_condition_select").mousedown(function(){
    publish_condition_children();
})
$("#publish_condition_select").change(function(){
		$(this).attr({
			'data-publish_condition':$(this).val()
		});
    publish_condition_children();
})
  function publish_condition_children(){
      var option_=""; 
      $('.form_component').children('li').each(function(a,b){
          var e=$(b);
          if($('#publish_condition_select').attr('data-publish_condition') == e.attr('name')){
              var checked_is='selected';
          }else{
              var checked_is='';
          }
          if(e.attr('input_type') != 'page' && e.attr('input_type') != '系统自带' && e.attr('input_type') != 'map' &&e.attr('input_type') != 'img' &&e.attr('input_type') != 'imgs' && e.attr('input_type') != 'file' && e.attr('input_type') != 'files' && e.attr('input_type') != 'time' && e.attr('input_type') != 'select' &&e.attr('input_type') != 'radio' &&e.attr('input_type') != 'editor' &&  e.attr('input_type') != 'number' ){
              option_+='<option '+checked_is+' value=\''+e.attr('name')+'\' data-value=\''+e.attr('name')+'\'>'+e.attr('description')+'</option>';
          }

      });
      if(option_ != ''){
       		$('#publish_condition_select option').remove();
          $('#publish_condition_select').append(option_);
      }

  }
//用户查询条件
  function publish_condition(){
      publish_condition_children();
      if(  $('#publish_condition').is(':checked')){
          $('#publish_condition_div').show();
      }else{
          $('#publish_condition_div').hide();
      }

  }
  $('#publish_condition').click(function(){
      publish_condition();
  })
