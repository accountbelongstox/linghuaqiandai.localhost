/* 所有的编辑的操作，都在这里进行
 2013-12-10
 @Author samuel 第三次
 */


var MKFORM = {};

MKFORM.isChangingLogic = false;

// !!! TODO !!! 一定要记得上线修改！
//MKFORM.localHost = 'http://localhost/~samuel/Mike_CRM/trunk/_HTML/';
//MKFORM.localHost = 'http://www.mikecrm.com/';
//MKFORM.localHost = 'http://192.168.1.106/';
MKFORM.localHost = window.location.protocol + '//'+ window.location.host + '/';
// MKFORM.localHost = 'http://192.168.1.118/mikeCRM/trunk/_HTML/';
// MKFORM.localHost = 'http://192.168.1.222/mikeCRM/trunk/_HTML/';
// MKFORM.localHost = 'http://localhost/MikeCRM/trunk/_HTML/';

MKFORM.uploadhint = '请选择2M内的jpg、png图片';

// --- 组件关系表
// -- 组件名称 
//	form_edit_title \ form_edit_instruct \ form_edit_required \ form_edit_size
//	\ form_edit_texttype \ form_edit_checkboxset \ form_edit_selectset \ form_edit_selecttype \ form_edit_checkboxlogicset
//	\ form_edit_datetype \ form_edit_starnum  \ form_edit_textalign \ form_edit_picture


// !!!!! 这个部分 在添加新的修改方法的时候一定要过来加一下，不然一定会被editManager干掉的
MKFORM.editMap = {
	'id_singleLine': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size', 'form_edit_texttype'],
	'id_number': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'id_multiple': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size', 'form_edit_texttype'],
	'id_dropDown': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_selectset', 'form_edit_selecttype'],
	'id_radio': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_radioset', 'form_edit_selecttype','form_edit_selectlayout'],
	'id_checkBox': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_checkboxset', 'form_edit_selecttype', 'form_edit_checkboxlogicset','form_edit_selectlayout'],
	'id_section': ['form_edit_title', 'form_edit_instruct', 'form_edit_titlealign', 'form_edit_textalign'], // 分割线的粗细颜色 呵呵呵呵呵呵
	'id_page': ['form_edit_prev_page'],
	'id_picture': ['form_edit_instruct','form_edit_picture', 'form_edit_textalign', 'form_edit_picture_link','form_edit_pictureShow'],
	'id_fileUpload': ['form_edit_title', 'form_edit_required', 'form_edit_instruct', 'form_edit_filetype'],
	'id_star': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_starnum'],
	'id_date': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_datetype'],
	'id_shopping': ['form_alert_payment', 'form_edit_title', 'form_edit_required', 'form_edit_instruct', 'form_edit_shoppinglist', 'form_alipaysetting'],
	// TODO !!
	'id_pictureCheckbox': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_pic_checkboxset','form_edit_checkboxlogicset','form_edit_picselecttype'],
	'id_pictureRadio': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_pic_radioset','form_edit_picselecttype'],
	'basic_name': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_birthday': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_job': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_email': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_city': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_company': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_adress': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_phone': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_weixin': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_fax': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_gender': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_radioset','form_edit_selectlayout'],
	'basic_website': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_qq': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_position': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size'],
	'basic_mobile': ['form_edit_title', 'form_edit_instruct', 'form_edit_required','form_edit_smsvcode', 'form_edit_size'],
	'basic_note': ['form_edit_title', 'form_edit_instruct', 'form_edit_required', 'form_edit_size']
};

MKFORM.nameMap = {
	'basic_name': '姓名',
	'basic_job': '职位',
	'basic_city': '城市',
	'basic_company': '公司',
	'basic_adress': '通讯地址',
	'basic_phone': '固话',
	'basic_weixin': '微信',
	'basic_fax': '传真',
	'basic_gender': '称谓',
	'basic_email': 'E-mail',
	'basic_website': '网址',
	'basic_qq': 'QQ',
	'basic_position': '——',
	'basic_mobile': '手机',
	'basic_birthday': '生日',
	'basic_note': '备注'
};

// 这个部分是 绑定的时候调用函数的列表
MKFORM.editFunctionMap = {
	'id_singleLine': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired', 'settingTextType'],
	'id_number': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'id_multiple': ['settingTitle', 'settingTextSize', 'settingInstruct', 'settingRequired', 'settingTextType'],
	'id_dropDown': ['settingTitle', 'settingSelectField', 'settingInstruct', 'settingRequired', 'settingChooseType'],
	'id_radio': ['settingTitle', 'settingRadioField', 'settingInstruct', 'settingRequired', 'settingChooseType','settingSelectLayout'],
	'id_checkBox': ['settingTitle', 'settingCheckboxField', 'settingInstruct', 'settingRequired', 'settingChooseType', 'settingCheckboxSelectLogic','settingSelectLayout'],
	'id_section': ['settingTitle', 'settingSubTitle','settingTitleAlign','settingSubTitleAlign'],
	'id_page': ['settingPrevPage'],
	'id_picture': ['settingSubTitle','settingSubTitleAlign','settingPicture','settingPictureLink','settingPictureShow'],
	'id_star': ['settingTitle', 'settingInstruct', 'settingRequired', 'settingStarNum'],
	'id_date': ['settingTitle', 'settingInstruct', 'settingRequired', 'settingDateType'],
	'id_fileUpload': ['settingTitle', 'settingRequired', 'settingInstruct','settingFileType'],
	'id_shopping': ['settingTitle', 'settingRequired', 'settingInstruct', 'settingShoppingField'],
	'id_pictureCheckbox': ['settingTitle', 'settingPictureCheckboxField', 'settingInstruct', 'settingRequired','settingCheckboxSelectLogic','settingPicChooseType'],
	'id_pictureRadio': ['settingTitle', 'settingPictureRadioField', 'settingInstruct', 'settingRequired','settingPicChooseType'],
	'basic_name': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_birthday': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_job': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_city': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_company': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_adress': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_phone': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_weixin': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_fax': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_gender': ['settingTitle', 'settingGenderField', 'settingInstruct', 'settingRequired','settingSelectLayout'],
	'basic_email': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_website': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_qq': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_position': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired'],
	'basic_mobile': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired','settingMobileVcode'], //手机组件在选择了短信验证时，禁止了必填项设置，所以settingMobileVcode要在settingRequired后面执行
	'basic_note': ['settingTitle', 'settingInputSize', 'settingInstruct', 'settingRequired']
};

MKFORM.currentComponent = ''; // 记录id
MKFORM.currentChanged = true; // 记录完 id 要来修改一下这个 这个用来判断需不需要重新绑定事件

MKFORM.editManager = function (currentType) {
	// var editFieldAll = ['form_edit_title','form_edit_instruct','form_edit_required','form_edit_size','form_edit_texttype','form_edit_selectset','form_edit_selecttype','form_edit_radioset','form_edit_checkboxset','form_edit_checkboxlogicset','form_edit_starnum','form_edit_datetype','form_edit_shoppinglist'];
	// get ALL
	if (currentType) {
		$('.form_componentEdit_tips').hide();
	} else {
		$('.form_componentEdit_tips').show();
	}
	if (currentType) {
		if (currentType.indexOf('basic') >= 0) {
			$('.formBuilder_edit_titleTip').show();
			$('.formBuilder_edit_titleTip .formBuilder_edit_titleTip_highlight').text(MKFORM.nameMap[currentType]);
            var weichat_eidt_title = $('.formBuilder_edit_titleTip .weichat_component_faq');
            if(currentType === 'basic_weixin'){
                weichat_eidt_title.css({'display':'inline-block'});
            }else{
                weichat_eidt_title.css({'display':'none'});
            }
		} else {
			$('.formBuilder_edit_titleTip').hide();
		}
	}

	$('.form_edit').each(function (i) {
		var editId = $(this).attr('id');
		if ($.inArray(editId, MKFORM.editMap[currentType]) < 0) {
			$(this).hide();
		} else {
			$(this).show();
		}
		// -- 非列表的隐藏,其他的显示……先不要动画了，不知道怎么加
	});

}; // 判断元素是否已经显示，显示的

/**
 * 对于 emoji 表情的过滤正则，覆盖率比较高：95% 左右
 */
var MK_EMOJI = {
    ios: /([\u1F60-\u1F64]|[\u2702-\u27B0]|[\u1F68-\u1F6C]|[\u1F30-\u1F70]|[\u2600-\u26FF])|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFF6]|(\uD83D[\uDC00-\uDE4F])|(\uD83D[\uDE80-\uDFF0])|([\u0023\u0030-\u0039](\uFE0F\u20E3|\u20E3))|\uD83C\uDDE8\uD83C\uDDF3|\uD83C\uDDE9\uD83C\uDDEA|\uD83C\uDDEA\uD83C\uDDF8|\uD83C\uDDEB\uD83C\uDDF7|\uD83C\uDDEC\uD83C\uDDE7|\uD83C\uDDEE\uD83C\uDDF9|\uD83C\uDDEF\uD83C\uDDF5|\uD83C\uDDF0\uD83C\uDDF7|\uD83C\uDDF7\uD83C\uDDFA|\uD83C\uDDFA\uD83C\uDDF8|[\u25AA\u25AB\u25FB-\u25FE\u3297]|([\u2E19\u203C\u2049\u2139\u2194-\u2199\u21A9\u21AA\u231A\u231B]\uFE0F)|([\u002A\u0030-\u0039]\u20E3)|[\u231B\u231A\u23F0-\u23FA\u25C0\u23CF\u23E9-\u23EF]/igm,
    ios9: /\ud83c[\udf21\udf24-\udf2f\udf36\udf7d-\udf7f\udf96-\udf97\udf99-\udf9b\udf9e-\udf9f\udfc5\udfcb-\udfcf\udfd0-\udfd6\udfd9-\udfda\udfdc-\udfdf\udff3-\udff5\udff7-\udfff]|\ud83d[\udc41\udc3f\udc66-\udc69\udc8b\udcf8\udcfd\udcff\udd49-\udd6f\udd70\udd73-\udd79\udd87\udd8a-\udd8d\udd90\udd95-\udd96\udda5\udda8\uddb1-\uddb2\uddbc\uddc2-\uddc4\uddd1-\uddd3\udddc-\uddde\udde1\udde3\udde8\uddef\uddf3\uddfa\ude41-\ude44\udecb-\udecf\uded0\udee0-\udee5\udee9\udeeb-\udeec\udef0\udef3]|\ud83e[\udd10-\udd18\udd80-\udd84\uddc0]|[\u23f8\u23f9\u23fa\u2764\ufe0f]/igm
};

/**
 * 保存表单的时候，过滤 emoji 保持和后端字段长度相同
*/
function filterEmoji(data) {
    var ios = MK_EMOJI.ios,
        ios9 = MK_EMOJI.ios9;
        
    return data.replace(ios, '').replace(ios9, '');
}

function isIncludeEmoji(data) {
    var ios = MK_EMOJI.ios,
        ios9 = MK_EMOJI.ios9;

    return ios.test(data) || ios9.test(data);
}

/**
 * 之前：做一些用户输入的过滤
 * 必须放入事件处理的第一行，让之后调用获取 value 的时候都是过滤后的结果
*/
MKFORM.__beforeInput = function (el) {
    var $el = $(el);
    var currentValue = $el.val();

    if(currentValue !== '' && isIncludeEmoji(currentValue)) {
        $el.val(filterEmoji(currentValue));
    }
};

MKFORM.componentSetting = {
    /* 编辑标题 */
	'settingTitle': (function () {
		// -- return obj
		var $editField = $('#form_edit_title'), // 获取title 对象
			$selectedCom,
			$titleField,
			oldValue;
            
		// 对当前的组件进行事件的绑定
		function mkBind() {
			var titleVal;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$titleField = $selectedCom.find('.title');
				titleVal = $titleField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' ');
				oldValue = $titleField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' ');
				$editField.find('.title_textarea').val(titleVal).unbind('input keyup').bind('input keyup',function () {
                    MKFORM.__beforeInput(this);
                    
					$titleField.html($(this).val().replace(/[\r\n]/igm, '<br/>').replace(/\s/g,'&nbsp;')); // 回车转义保存
					MKGlobal.addUnsaveCount();
					// alert();
				}).bind('mkReset', function () {
                    $(this).val($titleField.html().replace(/<br(\/)*>/igm, "\n"));
                    MKGlobal.addUnsaveCount();
                });
			}
		}

		return {
			redo: function () {
				// current edit field clean
				return $titleField.text(oldValue.replace(/[\r\n]/igm, '<br/>'));
			},
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingTextSize': (function () {
		var $editField = $('#form_edit_size'), // 获取title 对象
			$selectedCom;

		function mkBind() {
			var $textareaField,
				inputClassList = ['small', 'medium', 'large'],
				oldVal = '';
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$textareaField = $selectedCom.find('.textarea');
				// set val
				for (var i = 0, len = inputClassList.length; i < len; i++) {
					if ($textareaField.hasClass(inputClassList[i])) {
						oldVal = inputClassList[i];
						break;
					}
				}
				$selectedCom.data('size', oldVal);
				$('#editsize_' + oldVal).attr('checked', 'checked');
				$editField.find('input:radio').unbind('change').bind('change', function () {
					$textareaField.attr('class', 'textarea ' + $(this).val());
					$selectedCom.data('size', $(this).val());
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingInputSize': (function () {
		var $editField = $('#form_edit_size'), // 获取title 对象
			$selectedCom;

		function mkBind() {
			var $inputField,
				inputClassList = ['small', 'medium', 'large'],
				oldVal = '';
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$inputField = $selectedCom.find('input');
				// set val
				for (var i = 0, len = inputClassList.length; i < len; i++) {
					if ($inputField.hasClass(inputClassList[i])) {
						oldVal = inputClassList[i];
						break;
					}
				}
				$selectedCom.data('size', oldVal);
				$('#editsize_' + oldVal).attr('checked', 'checked');

				$editField.find('input:radio').unbind('change').bind('change', function () {
                    $selectedCom.find('input').attr('class', 'input ' + $(this).val());
					$selectedCom.data('size', $(this).val());
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingRequired': (function () {
		var $editField = $('#form_edit_required'),
			$selectedCom;

		function mkBind() {
			var $requiredField;
			if (MKFORM.currentComponent) {
                $('#editrequired').removeAttr('disabled');

				$selectedCom = $('#' + MKFORM.currentComponent);
				$requiredField = $selectedCom.find('.title').next('span'); // com_required

				if ($requiredField.text() !== '') {
					$editField.find('input:checkbox').attr('checked', 'checked');
				} else {
					$editField.find('input:checkbox').removeAttr('checked');
				}

				$editField.find('input:checkbox').unbind('change').bind('change', function () {
					var showRequired = '*';
					if (!$(this).attr('checked')) {
						showRequired = '';
					}
					$requiredField.text(showRequired);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    /* 描述文字 */
	'settingInstruct': (function () {
		var $editField = $('#form_edit_instruct'),
			$selectedCom;

		function mkBind() {
			var $instructField;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$instructField = $selectedCom.find('.instruct');
				// set value

				$editField.find('.instruct_textarea').val('');
				if ($instructField.length > 0) {
					$editField.find('.instruct_textarea').val(MKFORM.formUtility.mkHtmlString($instructField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' ')));
				}
				$editField.find('.instruct_textarea').unbind('input keyup').bind('input keyup', function () {
                    MKFORM.__beforeInput(this);
                    
					var instructStyle = MKGlobal.formScheme.instruction,
						tmpHTML = '';
					if ($.trim($(this).val()) !== '') {

						if ($instructField.length === 0) {
							if (!instructStyle) {
								instructStyle = '';
							}
							$selectedCom.find('.title_field').after('<p class="instruct" style="' + instructStyle + '"></p>');
							$instructField = $selectedCom.find('.instruct');
						}

						tmpHTML =  MKFORM.formUtility.mkStringEval($(this).val().replace(/[\r\n]/igm, '<br/>').replace(/\s/g,'&nbsp;'));

						$instructField.html(tmpHTML);

					} else {
						$instructField.remove();
						$instructField = $selectedCom.find('.instruct');
					}
                    
					MKGlobal.addUnsaveCount();
				});
				// 添加链接
				$editField.find('.form_edit_addLink').unbind('click').bind('click', function () {
					var $instructField = $editField.find(".instruct_textarea"),
						ins_position = MKFORM.formUtility.getCurrentCursorPosition($instructField),
						__val = $instructField.val();

					$instructField.val(__val.substr(0,ins_position)+" [链接文字](http://www.mikecrm.com) "+__val.substr(ins_position)).trigger("keyup");
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    /* 分割线的描述 */
	'settingSubTitle': (function () {
		// 分割线的标题就都靠你了！
		// .subtitle
		var $editField = $('#form_edit_instruct'),
			$selectedCom;
            
		function mkBind() {
			var $subtitleField;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$subtitleField = $selectedCom.find('.subtitle');
				// set value

				$editField.find('.instruct_textarea').val(MKFORM.formUtility.mkHtmlString($subtitleField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' ')));

				$editField.find('.instruct_textarea').unbind('input keyup').bind('input keyup', function () {
                    MKFORM.__beforeInput(this);
                    
					$subtitleField.html(MKFORM.formUtility.mkStringEval($(this).val().replace(/[\r\n]/igm, '<br/>').replace(/\s/g,'&nbsp;')));
					MKGlobal.addUnsaveCount();
				});

				// 添加链接
				$editField.find('.form_edit_addLink').unbind('click').bind('click', function () {
					var $instructField = $editField.find(".instruct_textarea"),
						ins_position = MKFORM.formUtility.getCurrentCursorPosition($instructField),
						__val = $instructField.val();

					$instructField.val(__val.substr(0,ins_position)+" [链接文字](http://www.mikecrm.com) "+__val.substr(ins_position)).trigger("keyup");
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    'settingTitleAlign':(function(){
		// 分割线标题居中
		var $editField = $('#form_edit_titlealign'),
			$selectedCom;

		function mkBind(){
			var $subtitleField;
			if(MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
                $titleField = $selectedCom.find('.title_field');
                //set block for text-align
                $titleField.addClass("title_field_block");

				// set val
				var currentAlign = $titleField.css('text-align');
				$editField.find('#titlealignstyle_'+currentAlign).attr('checked','checked');

				$editField.find('input[type="radio"]').unbind('click').bind('click',function(){
					var selectedAlign = $(this).val();
                    $titleField.css('text-align',selectedAlign);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    'settingMobileVcode': (function(){
        var $editField = $('#form_edit_smsvcode'),
            $selectedCom;
        // 验证码子组件标题
        var bindTitleEdit = function($mobileVcodeCom){
            var titleEdit = $editField.find('.title_textarea'),
                $titleField = $mobileVcodeCom.find('.mbvc_title');
            if($titleField.length > 0){
                titleEdit.val($titleField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' '));
            }
            titleEdit.unbind('input keyup').bind('input keyup',function () {
                $titleField.html($(this).val().replace(/[\r\n]/igm, '<br/>').replace(/\s/g,'&nbsp;')); // 回车转义保存
                MKGlobal.addUnsaveCount();
            });
        };
        // 验证码子组件描述
        var bindInstructEdit = function($mobileVcodeCom) {
            var $instructField = $mobileVcodeCom.find('.mbvc_instruct'),
                $editInstruct = $editField.find('.instruct_textarea');
            $editInstruct.val('');
            if ($instructField.length > 0) {
                $editInstruct.val(MKFORM.formUtility.mkHtmlString($instructField.html().replace(/<br(\/)*>/igm, "\n").replace(/&nbsp;/g,' ')));
            }
            $editInstruct.unbind('input keyup').bind('input keyup', function () {
                var instructStyle = MKGlobal.formScheme.instruction,
                    tmpHTML = '';
                if ($.trim($(this).val()) !== '') {
                    if ($instructField.length === 0) {
                        if (!instructStyle) {
                            instructStyle = '';
                        }
                        $mobileVcodeCom.find('.mbvc_title_field').after('<p class="mbvc_instruct" style="' + instructStyle + '"></p>');
                        $instructField = $mobileVcodeCom.find('.mbvc_instruct');
                    }
                    tmpHTML =  MKFORM.formUtility.mkStringEval($(this).val().replace(/[\r\n]/igm, '<br/>').replace(/\s/g,'&nbsp;'));
                    $instructField.html(tmpHTML);
                } else {
                    $instructField.remove();
                    $instructField = $mobileVcodeCom.find('.mbvc_instruct');
                }
                MKGlobal.addUnsaveCount();
            });
            // 添加链接
            $editField.find('.form_edit_addLink').unbind('click').bind('click', function () {
                var ins_position = MKFORM.formUtility.getCurrentCursorPosition($editInstruct),
                    __val = $editInstruct.val();
                $editInstruct.val(__val.substr(0,ins_position)+" [链接文字](http://www.mikecrm.com) "+__val.substr(ins_position)).trigger("keyup");
            });
        };

        function mkBind(){
            if($editField.length == 0){
                return;
            }

            var mobileVcodeSwitch = $editField.find('#edit_check_smsvcode');
            mobileVcodeSwitch.removeAttr('checked').removeAttr('disabled').parent().removeClass('gray').siblings('.mobile_smsvcode_box').hide();

            if(MKFORM.currentComponent) {
                $selectedCom = $('#' + MKFORM.currentComponent);
                var mobileVcodeCom = $selectedCom.find('.mobile_vcode_com');

                mobileVcodeSwitch.off('change').on('change', function(){
                    var $this = $(this),
                        mblc = $selectedCom.find('.mobile_vcode_com');
                    if($this.attr('checked')==='checked'){//open
                        $this.parent().siblings('.mobile_smsvcode_box').show();
                        if(mblc.length == 0){
                            //mobile_vcode_com --> |mbvc_title_field -->|
                            //                     |                    |  mbvc_title
                            //                     |                    |  com_mbvc__required
                            //                     |mbvc_instruct
                            //                     |div              -->|input
                            $selectedCom.append('<div class="mobile_vcode_com"><span class="mbvc_title_field"><label class="mbvc_title">短信验证码</label><span class="com_mbvc_required">*</span></span><div><input type="text" class="input '+ ($selectedCom.data('size')||'medium') +'" disabled="disabled"/></div></div>');
                            mblc = $selectedCom.find('.mobile_vcode_com');
                            mblc.prev('div').addClass('with_mblc').append('<div class="button mblc_button" >获取验证码</div>');
                        }
                        // 开启了短信验证码，手机组件一定要必填
                        $('#editrequired').attr('checked','checked').attr('disabled','disabled').trigger('change');
                        // 子组件事件绑定须保证子组件一定存在
                        bindTitleEdit(mblc);
                        bindInstructEdit(mblc);
                        // 修改时提交标识
                        MKFORM.SMSRANDOMCODE = 1;
                    }else{
                        if(mblc.length){
                            mblc.siblings('.with_mblc').removeClass('with_mblc').find('.mblc_button').remove();
                            mblc.remove();
                        }
                        $this.parent().siblings('.mobile_smsvcode_box').hide();
                        // 关闭了短信验证码，手机组件恢复必填可设置
                        $('#editrequired').removeAttr('disabled');
                        // 修改时提交标识
                        MKFORM.SMSRANDOMCODE = 0;
                    }

                    var $componentList = $('.form_component').children('.ui-draggable');
                    MKFORM.formUtility.formLimitedItemCheck($componentList);
                });

                if($('.form_component>li[name="basic_mobile"]').length > 1){
                    // 手机组件大于1个，不能编辑短信验证码
                    mobileVcodeSwitch.removeAttr('checked').trigger('change');
                    mobileVcodeSwitch.attr('disabled', 'disabled').parent().addClass('gray');
                    return;
                }
                if(mobileVcodeCom.length){
                    mobileVcodeSwitch.attr('checked', 'checked').trigger('change');
                }else{
                    mobileVcodeSwitch.removeAttr('checked').trigger('change');
                }
            }
        }

        return {
            bind: function () {
                return mkBind();
            }
        };
    })(),
	'settingSubTitleAlign':(function(){
		// 分割线、 图片的说明文字的居中
		var $editField = $('#form_edit_textalign'),
			$selectedCom;

		function mkBind(){
			var $subtitleField;
			if(MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$subtitleField = $selectedCom.find('.subtitle');
				// set val
				var currentAlign = $subtitleField.css('text-align');
				$editField.find('#textalignstyle_'+currentAlign).attr('checked','checked');

				$editField.find('input[type="radio"]').unbind('click').bind('click',function(){
					var selectedAlign = $(this).val();
					$subtitleField.css('text-align',selectedAlign);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingPictureShow': (function(){

		var $editField = $('#form_edit_pictureShow'),
			$selectedCom;

		function mkBind(){
			var $imgField;
			if(MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$imgField = $selectedCom.find('img');

				var styleData = $imgField.data('style');
				
				// console.log(styleData);

				if(styleData === 'normal' || styleData === undefined){
					$editField.find('#pictureshow_tensile').attr('checked','checked');
				} else {
					$editField.find('#pictureshow_middle').attr('checked','checked');
				}

				$editField.find('input[type="radio"]').unbind('click').bind('click',function(){
					var selectedStyle = $(this).val();
					$imgField.data('style', selectedStyle);
					if(selectedStyle === 'normal'){
						$imgField.attr('style','width:100%');
					} else {
						$imgField.attr('style','max-width:100%');
					}
					MKGlobal.addUnsaveCount();
				});

			}
		}


				// set val
				// var currentAlign = $subtitleField.css('text-align');
				// $editField.find('#textalignstyle_'+currentAlign).attr('checked','checked');

				// $editField.find('input[type="radio"]').unbind('click').bind('click',function(){
				// 	var selectedAlign = $(this).val();
				// 	$subtitleField.css('text-align',selectedAlign);
				// 	MKGlobal.addUnsaveCount();
				// });
			// }

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingPicture': (function(){
		// 图片组件的图片上传
		var $editField = $('#form_edit_picture'),
			$selectedCom;

		function checkimg($ui){
			$ui.error(function () {
				$(this).hide();
				$ui.empty();
			});
		}

		function mkBind(){
			var $picField;
			if(MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$picField = $selectedCom.find('.title_field');
				// set val
                var inputFile = $editField.find('.upload_file p');
                inputFile.removeAttr('style').text('请选择小于2M的jpg、png、jpeg、gif文件进行上传');

                $editField.find('.uploadImageFromUrl').find('input').val('').blur();
				// 上传图片的设置

				MKFORM.formUtility.formImgUpload($selectedCom.find('.in_pic_upload'),(function(selectedCom){
					var $_selectedCom = $(selectedCom),
						$_picField = $_selectedCom.find('.title_field');
					return function (e, data) {
						var imgPath = data.result.data.url.replace(/[\\]/g, '/'),$img;
						if($_picField.find('img').length>0){
							// updatePicture
							$img = $_picField.find('img');
							checkimg($img);
							$img.attr('src',MKFORM.localHost + imgPath);
						} else {
							$img = $('<img>').attr('src',MKFORM.localHost + imgPath).css('width','100%');
							checkimg($img);
							$picField.empty().append($img);
						}
						MKGlobal.addUnsaveCount();
					};
				})('#' + MKFORM.currentComponent), inputFile);

				// 绑定上传部分事件
                $editField.find('.input_file').fileupload({
					dataType: "json",
                    pasteZone: null,
					url: 'handler/handleUploadFormPicture.php?inpc_a',
					drop: function (e) {
						return false;
					},
					add: function (e, data) {
						//$selectedCom.find('.in_pic_upload').fileupload('add', {
						//	files: data.files
						//});
                        $selectedCom.find('.in_pic_upload').fileupload('add', data);
					}
				});

                // 上传方式切换
                $('input[name="picturefileshow"]').off('change.showType').on('change.showType', function(){
                    var $this = $(this),
                        local = $editField.find('.uploadImageFromLocal'),
                        link = $editField.find('.uploadImageFromUrl');
                    if($this.val() === 'link'){
                        local.hide();
                        link.show().find('input').val('').blur();
                    }else{
                        link.hide();
                        local.show();
                        inputFile.removeAttr('style').text('请选择小于2M的jpg、png、jpeg、gif文件进行上传');
                    }
                });

                // 外链地址
                $editField.find('.uploadImageFromUrl .edit_input').unbind('input keyup paste').bind('input keyup paste',function () {
                    var $_picField = $selectedCom.find('.title_field'),
                        checkScript = function(str){
                            var p = (str||"").split(':');
                            if(p[0] && (p[0]==='javascript' || p[0]==='vbscript')){
                                return "";
                            }else{
                                return str;
                            }
                        };
                    var imgPath = checkScript($.trim($(this).val()))||(MKFORM.localHost + 'images/icon/formDefaultPicture.png'),$img;
                    if($_picField.find('img').length>0){
                        // updatePicture
                        $img = $_picField.find('img');
                        checkimg($img);
                        $img.attr('src', imgPath).show();
                    } else {
                        $img = $('<img>').attr('src', imgPath).css('width','100%');
                        checkimg($img);
                        $_picField.empty().append($img);
                    }
                    MKGlobal.addUnsaveCount();
                });


            }
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingTextType': (function () {
		var $editField = $('#form_edit_texttype'),
			$selectedCom;

		function mkBind() {
			var currentType;
			// -- 判断当前的组件的类型，进行渲染啊，更换啊，等等等的
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				currentType = $selectedCom.attr('name');
				if (currentType === 'id_singleLine') {
					$('#textfieldstyle_single').attr('checked', 'checked');
				} else if (currentType === 'id_multiple') {
					$('#textfieldstyle_multi').attr('checked', 'checked');
				}
			}

			$editField.find('input:radio').unbind('change').bind('change', function () {
				// ---
				var type = $(this).attr('id'),
					changeMap = {
						'textfieldstyle_multi': {
							'name': 'id_multiple',
							'componentType': '<textarea class="textarea %%SIZE%%" disabled="disabled"></textarea>'
						},
						'textfieldstyle_single': {
							'name': 'id_singleLine',
							'componentType': '<input type="text" class="input %%SIZE%%" disabled="disabled"/>'
						}
					},
					newInfo;

				newInfo = changeMap[type];

				$selectedCom.attr('name', newInfo.name).find('div').not('.deleteButton').html(newInfo.componentType.replace('%%SIZE%%', $selectedCom.data('size')));
				MKGlobal.addUnsaveCount();
				renderFormComponent($selectedCom);

			});

		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    //下拉
	'settingSelectField': (function () {
		// 选项设置
		var selectItemList = [],
			$editField = $('#form_edit_selectset'),
            maxNoForName = 0,
			$selectedCom;

        // 每个选项统一限选的个数，全局一个变量控制
        var commonLimitValue = '';

		function _addLine() {
			$editField.find('.addButton').unbind('click').bind('click', function () {
				// add Line ...
				var listNum = selectItemList.length,
					optionTemplate = '<option>选项'+(listNum+1)+'</option>',
					editTemplate = '<li class="editselect_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="select_' + $selectedCom.attr('id') + '"><textarea class="edittext textarea input_textarea">选项'+(listNum+1)+'</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="" placeholder="">个</div><p class="removeButton"></p></li>';

				$(optionTemplate).attr({
					'name': ++maxNoForName,
					'listfield': listNum
				}).appendTo($selectedCom.find('select'));
        
				var $editLine = $(editTemplate);

				$editField.find('.editselect_item').last().after($editLine);
				$editLine.find('.edittext').select().focus();
				$editField.find('.addButton').remove();
				$editField.find('.editselect_item').last().append('<p class="addButton"></p>');

				selectItemList.push('选项'+(listNum+1));
				MKGlobal.addUnsaveCount();

                var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

                if($isLimit){
                    // 判断是否统一限选
                    var $editWrap = $editField.find('.J-editWrap');
                    var isCommonLimit = $editWrap.hasClass('limited');
                    if(isCommonLimit) {
                        var $radio = $editField.find('.editselect_item').last().find('.radio_limit');
                        $radio.prop('disabled', true).val(commonLimitValue);
                        _updateOptionLimit($radio);
                    }
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				// ---
				_removeLine();
				_addLine();
				_editLine();
                _updateLimitValue();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _removeLine() {
			$editField.find('.removeButton').unbind('click').bind('click', function () {
				// remove 自己
				var num = $(this).parent().attr('lineNum'),
					$corElem = $selectedCom.find('option[listField="' + $(this).parent().attr('lineNum') + '"]');
				if ($editField.find('.editselect_item').length > 1) {
					var currentNum = $(this).attr('lineNum');
					delete selectItemList[currentNum];
					$corElem.remove();
					$(this).parent().remove();
					$editField.find('.addButton').remove();
					$editField.find('.editselect_item').last().append('<p class="addButton"></p>');
					if ($editField.find('.editstatus[checked="checked"]').length === 0) {
						$editField.find('.editstatus').first().attr('checked', 'checked');
						$selectedCom.find('select').find('option').first().attr('selected', 'selected');
					}
					_addLine();
				} else {
					$(this).siblings('.edittext').val('');
					$corElem.text('');
					selectItemList[num] = '';
				}
				if (num == "-1") {
					$selectedCom.find('select').attr('defaultTip',false);
				}
				MKGlobal.addUnsaveCount();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}
        
		function _editLine() {
			$editField.find('.edittext').unbind('input keyup').bind('input keyup', function (e) {
                MKFORM.__beforeInput(this);
                
				var $this = $(this),
                    num = $this.parent().attr('lineNum'),
					$corElem = $selectedCom.find('option[listField="' + $this.parent().attr('lineNum') + '"]'),
					keyCode = e.keyCode || e.which,
                    val_text = ($this.val()||'').replace(/[\r\n]/igm, '');

				$corElem.text(val_text);
				selectItemList[num] = val_text;
                
				MKGlobal.addUnsaveCount();

                if(val_text.length && val_text.length > 12){
                    if(!$this.hasClass('much_words')){
                        $this.addClass('much_words');
                    }
                }else{
                    $this.removeClass('much_words');
                }
                if(keyCode == 13){
                    $this.val(val_text).trigger('blur');
                    if($this.parent().find('.addButton').length > 0){
                        $this.parent().find('.addButton').trigger('click');
                        return false;
                    }
                }
			});
			$editField.find('.editstatus').unbind('change').bind('change', function () {
				var $corElem = $selectedCom.find('option[listField="' + $(this).parent().attr('lineNum') + '"]');
				$corElem.attr('selected', 'selected').siblings().removeAttr('selected');
				MKGlobal.addUnsaveCount();
			});
		}

        function _renderOtherInput(isLimited) {
            var isDisabled = isDisabledByCommonLimit();
            var content = '<span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+ commonLimitValue +'"'+ isDisabled +'>个</div><p class="removeOtherButton"></p>';

            if(isDisabled) {
                $selectedCom.find(".title_field").data('other-limit', commonLimitValue === '' ? false : commonLimitValue);
            }

            $editField.find('.other-input').html(content);
        }

		function _managerOther() {
			$editField.find('.removeOtherButton').unbind('click').bind('click', function () {
				//	$selectedCom.find('.other').remove();
				$selectedCom.find('select').attr('other','false');
				$editField.find('.other-input').html('<span class="add-other-select">添加其他选项</span>');
				_managerOther();
				MKGlobal.addUnsaveCount();
			});

			$editField.find('.add-other-select').unbind('click').bind('click', function () {
				$selectedCom.find('select').attr('other','true');
                // 1. 判断是否公共限选
                _renderOtherInput();

				_managerOther();
                _updateLimitValue();
                MKGlobal.addUnsaveCount();
			});

            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

            if($isLimit){
                $editField.find(".other-input").find(".radio_limit_tip").show();
            }else{
                $editField.find(".other-input").find(".radio_limit_tip").hide();
            }

		}

        function clearCommonLimitValue() {
            commonLimitValue = '';
            $selectedCom.find(".title_field").data('common-limit-value', '');
        }

       function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
           $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
               $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
               //$selectedCom.find('.title_field').data('limit-show-type', $(this).prop('value'));
               MKGlobal.addUnsaveCount();
           });

           /* 批量填写限选 */
           var $limitTipCommonCheckbox = $editField.find('.J-limitTipCommonCheckbox')
           $limitTipCommonCheckbox.off('change').on('change', function () {
               var $editWrap = $editField.find('.J-editWrap');
               if(!$editWrap.hasClass('limited')) {
                   $editWrap.addClass('limited');
                   $selectedCom.find(".title_field").data('common-limit', 1);
                   $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                   _disabledCommonLimitValue($editWrap);
               } else {
                   $editWrap.removeClass('limited');
                   $selectedCom.find(".title_field").data('common-limit', 0);
                   $editField.find('.J-limitTipCommonInput').val('');
                   clearCommonLimitValue();
                   _unDisabledCommonLimitValue($editWrap);
               }
               MKGlobal.addUnsaveCount();
           });
           var $limitTipCommonInput = $editField.find('.J-limitTipCommonInput');
           $limitTipCommonInput.off('change input').on('change input', function () {
               var reg = /^[0-9]+$/;
               var $self = $(this);
               commonLimitValue = $.trim($self.val());
               if (commonLimitValue !== '' && !reg.test(commonLimitValue)) {
                   $self.val('').focus();
                   commonLimitValue = '';
               }
               $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
               _updateCommonLimitValue($editField);
               MKGlobal.addUnsaveCount();
           });
           $limitTipCommonInput.off('focus').on('focus', function () {
               var $editWrap = $editField.find('.J-editWrap');
               if(!$editWrap.hasClass('limited')) {
                   $limitTipCommonCheckbox.trigger('click');
               }
           });
        }

        // 添加统一的限选值
        function _disabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', true);
        }

        function _unDisabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', false);
        }

        function _updateCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.each(function (i, radio) {
                var $radio = $(radio);
                if($radio.hasClass('other_limit')) {
                    $selectedCom.find(".title_field").data('other-limit', commonLimitValue);
                } else {
                    _updateOptionLimit($radio);
                }
                $radio.val(commonLimitValue);
            });
        }

        function _updateOptionLimit($radio) {
            var num = $radio.closest('li').attr('lineNum');
            var $corElem = $selectedCom.find('option[listField="' + num + '"]');
            $corElem.data('limit', commonLimitValue);
        }

        function isDisabledByCommonLimit() {
            var isDisabled = '';
            // 判断是否统一限选，来恢复下
            var $editWrap = $editField.find('.J-editWrap');
            if($editWrap.hasClass('limited')) {
                isDisabled = ' disabled ';
            }

            return isDisabled;
        }

        function _updateLimitValue(){
             $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {
                 MKGlobal.addUnsaveCount();
                 var re = /^[0-9]+$/;
                 if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                     alert("限额只能为大于或等于零的整数");
                     $(this).val('');
                     $(this).focus();
                 }

                 if($(this).hasClass("other_limit")) {
                     $selectedCom.find(".title_field").data('other-limit', $(this).val());
                 }else {
                     var num = $(this).closest('li').attr('lineNum');
                     var $corElem = $selectedCom.find('option[listField="' + num + '"]');
                     $corElem.data('limit', $(this).val());
                 }
            });
        }
        
		var hasDefaulTip = false; // 是否包含默认项
		var defaultTipValue = '请选择'; // 只读项的初始值，会使用 readonly 的值覆盖
        /* 进入编辑模式 */
        function _enterBatchMode() {
        	var $area = $editField.find('.batch_items');
        	var content = '';
        	// 1. 获取当前的选项
        	// 2. 填充入 textarea
        	$editField.find('.form_edit_batch').off('click.batch').on('click.batch', function (e) {
        		var items = _getBatchItems();
        		content = items.join('');
        		$area.val(content);

        		_changeMode('batch');
        	});
        	$editField.find('.btn_save').off('click.batch').on('click.batch', function (e) {
        		var newContent = $area.val();
                var items = newContent.split('\n');

                _renderLine(items);
                _changeMode();
                //重新绑定事件
                _addLine();
                _removeLine();
				_editLine();
                _updateLimit();
                _updateLimitValue();
                _managerOther();
				$(".formBuilder_edit").getNiceScroll().resize();

				hasDefaulTip = false;
        	});
        	$editField.find('.btn_cancel').off('click.batch').on('click.batch', function (e) {
        		_changeMode();

				hasDefaulTip = false;
        	});
            $area.off('.batch').on('input.batch, keyup.batch', function (e) {
				MKFORM.__beforeInput(this);
                MKGlobal.addUnsaveCount(); 
            });
        }

		function __hasDefaultTip () {
			// 判断是否含有 linenum = -1 （ -1是一个特殊的值 ）
			// 如果有 -> 最后如果没有删除第一行的［请选择］，第一个就是 num = -1, defaultTip
			// 如果没有 -> 不处理
			var $firstSelectItem = $editField.find('.editselect_item').first();
			var linenum = parseInt($firstSelectItem.attr('linenum'));
			if(linenum === -1) {
				hasDefaulTip = true;
				defaultTipValue = $firstSelectItem.find('.edittext').val();
			}
		}

        /* 获取选项的行 */
        function _getBatchItems() {
			__hasDefaultTip();

        	var $editText = $editField.find('.edittext');
			// 如果有，跳过第一个
			if(hasDefaulTip) {
				$editText = $editField.find('.editselect_item').not('[linenum=-1]').find('.edittext');
			}

            var n = $editText.length - 1;
        	var items = [];

        	$editText.each(function (idx, item) {
        		var text = $.trim(item.value);
                var content = '';
                if(idx < n) {
                    content = text + '\n';
                } else {
                    content = text;
                }
                items.push(content);
        	});

        	return items;
        }
        /* 编辑动画交互 */
        function _changeMode(type) {
        	var $select = $editField.find('.editChoiceSelect'),
        		$limit = $editField.find('.limitNumber'),
        		$batch = $editField.find('.editBatch');
                $batchBtn = $editField.find('.form_edit_batch');
                
        	if(type === 'batch') {
                $batchBtn.hide();
        		$select.hide();
	        	$limit.hide();
	        	$batch.addClass('on');

                $editField.find('.batch_items').focus();
        	} else {
                $batchBtn.css('display', 'block');
        		$select.css('display', 'block');
	        	$limit.css('display', 'block');
	        	$batch.removeClass('on');
        	}
        }
        function _renderLine(items) {
        	// 组件 id
        	var id = $selectedCom.attr('id');
        	// 数据
            selectItemList = [];

        	var n = items && items.length;
        	var editTemplate = [];
            var optionTemplate = [];
            var isChecked = '';

			// 如果有默认项的情况下，首先填充
			if(hasDefaulTip) {
				_renderLineByDefaultTip(id, editTemplate, optionTemplate);
			}

			// 之后判断批量编辑的情况
			var firstItemText = $.trim(items[0]);
            /* 全部删除，显示默认项 */
            if(n === 1 && firstItemText === '') {
                var text = firstItemText;
                selectItemList.push(text);

				editTemplate.push(_renderEditTemplate({
					id: id,
					text: text,
					isChecked: !hasDefaulTip ? 'checked' : ''
				}));

                optionTemplate.push(_renderOptionTemplate({
					checkboxName: ++maxNoForName,
					text: text
				}));
            } else {
                for(var i = 0; i < n; ++i) {
                    var text = items[i];
					selectItemList.push(text);

                    if(i === 0 && !hasDefaulTip) {
                        isChecked = 'checked';
                    } else {
                        isChecked = '';
                    }

					editTemplate.push(_renderEditTemplate({
						i: i,
						id: id,
						text: text,
						isChecked: isChecked
					}));

					if(i === 0 && !hasDefaulTip) {
						optionTemplate.push(_renderOptionTemplate({
							i: i,
							checkboxName: ++maxNoForName,
							text: text,
							isSelected: 'selected'
						}));
					} else {
						optionTemplate.push(_renderOptionTemplate({
							i: i,
							checkboxName: ++maxNoForName,
							text: text
						}));
					}
                }
            }

            var isDisabled = isDisabledByCommonLimit();

            var otherInput = '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="${otherLimit}"'+ isDisabled +'>个</div><p class="removeOtherButton"></p></li>';
            var otherSelect = '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
            
            if ($selectedCom.find('select').attr('other') === 'true') {
                var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                if(!(otherLimit >= 0)){
                    otherLimit = '';
                }
                var otherInputText = otherInput.replace(/\${otherLimit}/img, otherLimit);
                editTemplate.push(otherInputText);
            } else {
                editTemplate.push(otherSelect);
            }
            
        	$editField.find('.editselect_list').html(editTemplate.join(''));
            $editField.find('.editselect_item').last().append('<p class="addButton"></p>');
            
            $selectedCom.find('select').html(optionTemplate);
            
            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');
            if($isLimit) {
                $editField.find(".radio_limit_tip").show();
            } else {
                $editField.find(".radio_limit_tip").hide();
            }

            //更新一下限选数据（统一限选的时候）
            if(isDisabled) {
                _updateCommonLimitValue($editField);
            }
        }

		function _renderLineByDefaultTip (id, editTemplate, optionTemplate) {
			var edit = _renderEditTemplate({
				i: -1,
				id: id,
				text: defaultTipValue,
				isChecked: 'checked',
				isReadOnly: 'readonly'
			});
			var option = _renderOptionTemplate({
				i: -1,
				checkboxName: -1,
				text: defaultTipValue,
				isSelected: 'selected'
			});

			editTemplate.push(edit);
			optionTemplate.push(option);
		}

		function _renderEditTemplate(config) {
            var i = config.i || 0,
                id = config.id,
                text = config.text || '',
                isChecked = config.isChecked || '',
				isReadOnly = config.isReadOnly || '';
            
            /* 需要的组件类型，不要提取，避免提取不断 */
            var type = 'radio';

            // 判断是否统一限选，来恢复下
            var isDisabled = isDisabledByCommonLimit();

            var content = ['<li class="editselect_item" lineNum="' + i + '">',
			'<input class="editstatus" '+ isChecked +' type="'+ type +'" name="'+ type +'_' + id + '">',
			'<textarea '+ isReadOnly +' class="edittext textarea input_textarea" >'+ text +'</textarea>',
			'<div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ commonLimitValue +'"'+ isDisabled +'>个</div>',
			'<p class="removeButton"></p></li>'];

            if(isReadOnly) {
                content.splice(3, 1);
            }

            return content.join('');
        }
        
        function _renderOptionTemplate(config) {
            var i = config.i || 0,
                text = config.text,
				checkboxName = config.checkboxName,
				isSelected = config.isSelected;

			if(isSelected) {
				return '<option name="'+ checkboxName +'" listfield="'+ i +'" selected="'+ isSelected +'">'+ text +'</option>';
			}

			return '<option name="'+ checkboxName +'" listfield="'+ i +'">'+ text +'</option>';
        }

        function _initCommonLimitStatus(isCommonLimit) {
            if(isCommonLimit) {
                $editField.find('.J-editWrap').addClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', true);
                $editField.find('.J-limitTipCommonInput').val(commonLimitValue);

                var $editWrap = $editField.find('.J-editWrap');
                _disabledCommonLimitValue($editWrap);
                _updateCommonLimitValue($editField);
            } else {
                $editField.find('.J-editWrap').removeClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', false);
                $editField.find('.J-limitTipCommonInput').val('');

                var $editWrap = $editField.find('.J-editWrap');
                _unDisabledCommonLimitValue($editWrap);
            }
        }

		function mkBind() {
			var tempListHTML = '';
            maxNoForName = 0;
			selectItemList = [];

			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

                var $titleField = $selectedCom.find('.title_field');
                var titleData = $selectedCom.find('.title_field').data();

                var $isLimit = titleData.limit;
                // 是否统一限选
                var isCommonLimit = titleData.commonLimit || 0;
                commonLimitValue = titleData.commonLimitValue || '';

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

				// set selectItemList
				if ($selectedCom.find('option[selected="selected"]').length === 0) {
					$selectedCom.find('option').first().attr('selected', 'selected');
				}
				$selectedCom.find('option').each(function (i) {
					if ($(this).attr("name") == "-1") {
						$selectedCom.find('select').attr('defaultTip',true);
						var tmpVal = $(this).attr('listField', "-1").text();
						tempListHTML += '<li class="editselect_item" lineNum="-1"><input class="editstatus" type="radio" name="select_' + $selectedCom.attr('id') + '" ' + ($(this).attr('selected') ? 'checked="checked"' : '') + '><textarea class="edittext textarea input_textarea'+((tmpVal.length && tmpVal.length>12)? ' much_words':'')+'" readonly="readonly">' + tmpVal + '</textarea><p class="removeButton"></p></li>';
					}else{
						var listNum = selectItemList.length,
							tmpVal = $(this).attr('listField', listNum).text();
                        var tmpLimit = parseInt($(this).data('limit'), 10);
                        if(!(tmpLimit>=0)) tmpLimit = "";
                        var curNoForName = parseInt($(this).attr('name'));
                        if (curNoForName > maxNoForName) {
                            maxNoForName = curNoForName;
                        }
						selectItemList.push(tmpVal);
						tempListHTML += '<li class="editselect_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="select_' + $selectedCom.attr('id') + '" ' + ($(this).attr('selected') ? 'checked="checked"' : '') + '><textarea class="edittext textarea input_textarea'+((tmpVal.length && tmpVal.length>12)? ' much_words':'')+'">' + tmpVal + '</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+tmpLimit+'" placeholder="">个</div><p class="removeButton"></p></li>';
					}
				});

				if ($selectedCom.find('select').attr('other') == 'true') {
                    var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                    if(!(otherLimit>=0)){
                        otherLimit = '';
                    }
					tempListHTML += '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+otherLimit+'" >个</div><p class="removeOtherButton"></p></li>';
				} else {
					tempListHTML += '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
				}

				$editField.find('.editselect_list').empty().append(tempListHTML);
				$editField.find('.editselect_item').last().append('<p class="addButton"></p>');

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                //type_value = (type_value > 0 ) ? type_value : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                //$editField.find('input[value='+type_value+']').attr('checked', 'checked');
                $selectedCom.find('.title_field').data('limit-show-type', type_value);

                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				$selectedCom.unbind('getItemList').bind('getItemList', function (event, list) {
					function _dataInfo(){
                        var _res = {limit:[],data:[]};
						$selectedCom.find('option').each(function(){
							if($(this).attr('name') !== '-1'){
                                var limit = $(this).data('limit');
                                if(!limit) limit = '';
                                _res.limit.push(limit);
								_res.data.push($(this).text());
							}
						});
						return _res;
					}
					list.dataInfo = _dataInfo();
					list.hasOther = ($selectedCom.find('select').attr('other')=='true');
					list.defaultTip = ($selectedCom.find('select').attr('defaultTip')=='true');
				});

                _initCommonLimitStatus(isCommonLimit);

				// -- event bind
				_removeLine();
				_addLine();
				_editLine();
				_managerOther();
                _updateLimitValue();
                _updateLimit();
                
                _enterBatchMode();
			}
		}

		return {
			bind: function () {
				return mkBind();
			},
			getItemList: function () {
				return selectItemList;
			}
		};
	})(),
    //多选
	'settingCheckboxField': (function () {
		// 多选框设置
		var selectItemList = [],
			$editField = $('#form_edit_checkboxset'),
			$selectedCom, checkboxName;

        // 每个选项统一限选的个数，全局一个变量控制
        var commonLimitValue = '';

		function _addLine() {
			$editField.find('.addButton').unbind('click').bind('click', function () {
				// add Line ...
				var listNum = selectItemList.length,
					optionTemplate = '<li class="optionsLine medium"><input type="checkbox" name="' + checkboxName + '" value="0" disabled="disabled"><label class="optionValue">选项'+(listNum+1)+'</label></li>',
					editTemplate = '<li class="editcheckbox_item" lineNum="' + listNum + '"><input class="editstatus" type="checkbox" name="checkbox_' + $selectedCom.attr('id') + '"><textarea class="edittext textarea input_textarea">选项'+(listNum+1)+'</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="" >个</div><p class="removeButton"></p></li>';

				$(optionTemplate).insertAfter($selectedCom.find('.optionsLine').not('.other').last())
                    .attr('listfield', listNum)
                    .find('input:checkbox').attr({
                        'name': checkboxName,
                        'value': listNum
                    });

				var $editLine = $(editTemplate);
				$editField.find('.editcheckbox_item').last().after($editLine);
				$editLine.find('.edittext').select().focus();
				$editField.find('.addButton').remove();
				$editField.find('.editcheckbox_item').last().append('<p class="addButton"></p>');

                var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

                if($isLimit){
                    // 判断是否统一限选
                    var $editWrap = $editField.find('.J-editWrap');
                    var isCommonLimit = $editWrap.hasClass('limited');
                    if(isCommonLimit) {
                        var $radio = $editField.find('.editcheckbox_item').last().find('.radio_limit');
                        $radio.prop('disabled', true).val(commonLimitValue);
                        _updateOptionLimit($radio);
                    }
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

                selectItemList.push('选项'+(listNum+1));
				MKGlobal.addUnsaveCount();
				// ---
				_removeLine();
				_addLine();
				_editLine();
                _updateLimitValue();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _removeLine() {
			$editField.find('.removeButton').unbind('click').bind('click', function () {
				// remove 自己
				var num = $(this).parent().attr('lineNum'),
					$corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
				if ($editField.find('.editcheckbox_item').length > 1) {
					var currentNum = $(this).attr('lineNum');
					delete selectItemList[currentNum];
					$corElem.remove();
					$(this).parent().remove();
					$editField.find('.addButton').remove();
					$editField.find('.editcheckbox_item').last().append('<p class="addButton"></p>');

					_addLine();
				} else {
					$(this).siblings('.edittext').val('');
					$corElem.find('.optionValue').text('');
					selectItemList[num] = '';
				}
				MKGlobal.addUnsaveCount();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _editLine() {
			$editField.find('.edittext').unbind('input keyup').bind('input keyup', function (e) {
                MKFORM.__beforeInput(this);
                
				var $this = $(this),
                    num = $this.parent().attr('lineNum'),
					$corElem = $selectedCom.find('.optionsLine[listField="' + $this.parent().attr('lineNum') + '"]'),
					keyCode = e.keyCode || e.which,
                    val_text = ($this.val()||'').replace(/[\r\n]/igm, '');

                MKGlobal.addUnsaveCount();
				$corElem.find('.optionValue').text(val_text);
				selectItemList[num] = val_text;
                if(val_text.length && val_text.length > 12){
                    if(!$this.hasClass('much_words')){
                        $this.addClass('much_words');
                    }
                }else{
                    $this.removeClass('much_words');
                }
                if(keyCode == 13){
                    $this.val(val_text).trigger('blur');
                    if($this.parent().find('.addButton').length > 0){
                        $this.parent().find('.addButton').trigger('click');
                        return false;
                    }
                }
			});
			$editField.find('.editstatus').unbind('change').bind('change', function () {
				var $corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
				$corElem.find('input:checkbox').attr('checked', ($(this).attr('checked') === 'checked'));
				MKGlobal.addUnsaveCount();
			});
		}

        function _renderOtherInput(isLimited) {
            var isDisabled = isDisabledByCommonLimit();
            var content = '<span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+ commonLimitValue +'"'+ isDisabled +'>个</div><p class="removeOtherButton"></p>';

            if(isDisabled) {
                $selectedCom.find(".title_field").data('other-limit', commonLimitValue === '' ? false : commonLimitValue);
            }

            $editField.find('.other-input').html(content);
        }

		function _managerOther() {
			$editField.find('.removeOtherButton').unbind('click').bind('click', function () {
				$selectedCom.find('.other').remove();
				$editField.find('.other-input').html('<span class="add-other-select">添加其他选项</span>');
				_managerOther();
				MKGlobal.addUnsaveCount();
			});

			$editField.find('.add-other-select').unbind('click').bind('click', function () {
				$selectedCom.find('.optionGarden').append('<li class="optionsLine medium other"><input type="checkbox" name="' + checkboxName + '" disabled="disabled" >' + '其他:<input type="text" class="input medium" disabled="disabled"/>' + '</li>');

                // 1. 判断是否公共限选
                _renderOtherInput();

				// $editField.find('.other-input').html('<span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="" >个</div><p class="removeOtherButton"></p>');
				_managerOther();
				MKGlobal.addUnsaveCount();
                _updateLimitValue();
			});

            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

            if($isLimit){
                $editField.find(".other-input").find(".radio_limit_tip").show();
            }else{
                $editField.find(".other-input").find(".radio_limit_tip").hide();
            }

		}

        function clearCommonLimitValue() {
            commonLimitValue = '';
            $selectedCom.find(".title_field").data('common-limit-value', '');
        }

        function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
            $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
                $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
                //$selectedCom.find('.title_field').data('limit-show-type', $(this).prop('value'));
                MKGlobal.addUnsaveCount();
            });

            /* 批量填写限选 */
            var $limitTipCommonCheckbox = $editField.find('.J-limitTipCommonCheckbox')
            $limitTipCommonCheckbox.off('change').on('change', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $editWrap.addClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 1);
                    $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                    _disabledCommonLimitValue($editWrap);
                } else {
                    $editWrap.removeClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 0);
                    $editField.find('.J-limitTipCommonInput').val('');
                    clearCommonLimitValue();
                    _unDisabledCommonLimitValue($editWrap);
                }
                MKGlobal.addUnsaveCount();
            });
            var $limitTipCommonInput = $editField.find('.J-limitTipCommonInput');
            $limitTipCommonInput.off('change input').on('change input', function () {
                var reg = /^[0-9]+$/;
                var $self = $(this);
                commonLimitValue = $.trim($self.val());
                if (commonLimitValue !== '' && !reg.test(commonLimitValue)) {
                    $self.val('').focus();
                    commonLimitValue = '';
                }
                $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                _updateCommonLimitValue($editField);
                MKGlobal.addUnsaveCount();
            });
            $limitTipCommonInput.off('focus').on('focus', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $limitTipCommonCheckbox.trigger('click');
                }
            });
        }

        // 添加统一的限选值
        function _disabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', true);
        }

        function _unDisabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', false);
        }

        function _updateCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.each(function (i, radio) {
                var $radio = $(radio);
                if($radio.hasClass('other_limit')) {
                    $selectedCom.find(".title_field").data('other-limit', commonLimitValue);
                } else {
                    _updateOptionLimit($radio);
                }
                $radio.val(commonLimitValue);
            });
        }

        function _updateOptionLimit($radio) {
            var num = $radio.closest('li').attr('lineNum');
            var $corElem = $selectedCom.find('.optionsLine[listField="' + num + '"]');
            $corElem.find('.optionValue').data('limit', commonLimitValue);
        }

        function isDisabledByCommonLimit() {
            var isDisabled = '';
            // 判断是否统一限选，来恢复下
            var $editWrap = $editField.find('.J-editWrap');
            if($editWrap.hasClass('limited')) {
                isDisabled = ' disabled ';
            }

            return isDisabled;
        }

        function _updateLimitValue(){
             $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {

                 MKGlobal.addUnsaveCount();
                 var re = /^[0-9]+$/;
                 if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                     alert("限额只能为大于或等于零的整数");
                     $(this).val('');
                     $(this).focus();
                 }

                 if($(this).hasClass("other_limit")) {
                     $selectedCom.find('.title_field').data('other-limit', $(this).val());
                 }else {
                     var num = $(this).closest('li').attr('lineNum');
                     var $corElem = $selectedCom.find('.optionsLine[listField="' + num + '"]');
                     $corElem.find('.optionValue').data('limit', $(this).val());
                 }
            });
        }
        
        /* 进入编辑模式 */
        function _enterBatchMode() {
        	var $area = $editField.find('.batch_items');
        	var content = '';
        	// 1. 获取当前的选项
        	// 2. 填充入 textarea
        	$editField.find('.form_edit_batch').off('click.batch').on('click.batch', function (e) {
        		var items = _getBatchItems();
        		content = items.join('');
        		$area.val(content);

        		_changeMode('batch');
        	});
        	$editField.find('.btn_save').off('click.batch').on('click.batch', function (e) {
        		var newContent = $area.val();
                var items = newContent.split('\n');
                _renderLine(items);
                _changeMode();
                
                _addLine();
                _removeLine();
				_editLine();
                _updateLimit();
                _updateLimitValue();
                _managerOther();
				$(".formBuilder_edit").getNiceScroll().resize();
        	});
        	$editField.find('.btn_cancel').off('click.batch').on('click.batch', function (e) {
        		_changeMode();
        	});
            $area.off('.batch').on('input.batch, keyup.batch', function (e) {
				MKFORM.__beforeInput(this);
                MKGlobal.addUnsaveCount(); 
            });
        }
        /* 获取选项的行 */
        function _getBatchItems() {
        	var $editText = $editField.find('.edittext');
            var n = $editText.length - 1;
        	var items = [];
        	$editText.each(function (idx, item) {
        		var text = $.trim(item.value);
                var content = '';

                if(idx < n) {
                    content = text + '\n';
                } else {
                    content = text;
                }

                items.push(content);
        	});

        	return items;
        }
        /* 编辑动画交互 */
        function _changeMode(type) {
        	var $checkbox = $editField.find('.editChoiceCheckbox'),
        		$limit = $editField.find('.limitNumber'),
        		$batch = $editField.find('.editBatch');
                $batchBtn = $editField.find('.form_edit_batch');
        	if(type === 'batch') {
                $batchBtn.hide();
        		$checkbox.hide();
	        	$limit.hide();
	        	$batch.addClass('on');
                
                $editField.find('.batch_items').focus();
        	} else {
                $batchBtn.css('display', 'block');
        		$checkbox.css('display', 'block');
	        	$limit.css('display', 'block');
	        	$batch.removeClass('on');
        	}
        }
        
        function _renderLine(items) {
            // 组件 id
        	var id = $selectedCom.attr('id');
        	// 数据
            selectItemList = [];
            
        	var n = items && items.length;
        	var editTemplate = [];
            var optionTemplate = [];

            var isDisabled = isDisabledByCommonLimit();
            
            // 默认要保留一个空值的选项
            if(n === 1 && items[0] === '') {
                var text = items[0];
                selectItemList.push(text);
                editTemplate.push('<li class="editcheckbox_item" lineNum="0">',
                    '<input class="editstatus" type="checkbox" name="checkbox_' + id + '">',
                    '<textarea class="edittext textarea input_textarea">'+ text +'</textarea>',
                    '<div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ commonLimitValue +'" '+ isDisabled +'>个</div>',
                    '<p class="removeButton"></p></li>');
                
                optionTemplate.push('<li class="optionsLine medium" listfield="0"><input type="checkbox" name="' + checkboxName + '" value='+ i +'" disabled="disabled"><label class="optionValue">'+ text +'</label></li>');
            } else {
                for(var i = 0; i < n; ++i) {
                    var text = items[i];
                    selectItemList.push(text);
                    editTemplate.push('<li class="editcheckbox_item" lineNum="' + i + '">',
                        '<input class="editstatus" type="checkbox" name="checkbox_' + id + '">',
                        '<textarea class="edittext textarea input_textarea">'+ text +'</textarea>',
                        '<div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ commonLimitValue +'" '+ isDisabled +'>个</div>',
                        '<p class="removeButton"></p></li>');
                        
                    optionTemplate.push('<li class="optionsLine medium" listfield="'+ i +'"><input type="checkbox" name="' + checkboxName + '" value='+ i +'" disabled="disabled"><label class="optionValue">'+ text +'</label></li>');
                }
            }
            
            var otherInput = '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="${otherLimit}" '+ isDisabled +'>个</div><p class="removeOtherButton"></p></li>';
            var otherSelect = '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
            // 表单中的其它
            var otherOptionInput = '<li class="optionsLine medium other"><input type="checkbox" name="' + checkboxName + '" disabled="disabled">' + '其他:<input type="text" class="input medium" disabled="disabled"/>' + '</li>';
            
            if ($selectedCom.find('.other').length > 0) {
                var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                if(!(otherLimit >= 0)){
                    otherLimit = '';
                }
                var otherInputText = otherInput.replace(/\${otherLimit}/img, otherLimit);
                editTemplate.push(otherInputText);
                optionTemplate.push(otherOptionInput);
            } else {
                editTemplate.push(otherSelect);
            }
            
        	$editField.find('.editcheckbox_list').html(editTemplate.join(''));
            $editField.find('.editcheckbox_item').last().append('<p class="addButton"></p>');
            
            $selectedCom.find('.optionGarden').html(optionTemplate);
            
            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');
            if($isLimit) {
                $editField.find(".radio_limit_tip").show();
            } else {
                $editField.find(".radio_limit_tip").hide();
            }

            //更新一下限选数据（统一限选的时候）
            if(isDisabled) {
                _updateCommonLimitValue($editField);
            }
        }

        function _initCommonLimitStatus(isCommonLimit) {
            if(isCommonLimit) {
                $editField.find('.J-editWrap').addClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', true);
                $editField.find('.J-limitTipCommonInput').val(commonLimitValue);

                var $editWrap = $editField.find('.J-editWrap');
                _disabledCommonLimitValue($editWrap);
                _updateCommonLimitValue($editField);
            } else {
                $editField.find('.J-editWrap').removeClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', false);
                $editField.find('.J-limitTipCommonInput').val('');

                var $editWrap = $editField.find('.J-editWrap');
                _unDisabledCommonLimitValue($editWrap);
            }
        }
        
		function mkBind() {
			var tempListHTML = '';
			selectItemList = [];
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

                var $titleField = $selectedCom.find('.title_field');
                var titleData = $titleField.data();


                var $isLimit = titleData.limit;
                // 是否统一限选
                var isCommonLimit = titleData.commonLimit || 0;
                commonLimitValue = titleData.commonLimitValue || '';

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

				// set selectItemList
				checkboxName = $selectedCom.find('.optionsLine').first().find('input:checkbox').attr('name');
				$selectedCom.find('.optionsLine:not(.other)').each(function (i) {
					// var listNum = selectItemList.length,
					// 	tmpVal = $(this).attr('listField', listNum).find('.optionValue').text();
					// selectItemList.push(tmpVal);
					var listNum,
						tmpVal = $(this).find('.optionValue').text(),
                    tmpLimit = parseInt($(this).find('.optionValue').data('limit'), 10);
                    if(!(tmpLimit>=0)) tmpLimit = "";

					if($(this).find('input:checkbox').val()){
						var _tmpKey = parseInt($(this).find('input:checkbox').val(),0);
						if(selectItemList[_tmpKey]){
							selectItemList.push(tmpVal);
							$(this).find('input:checkbox').val(selectItemList.length-1);
						} else {
							selectItemList[_tmpKey]=tmpVal;
						}

					} else {
						selectItemList.push(tmpVal);
					}
					
					listNum = $(this).find('input:checkbox').val();
					$(this).attr('listField', listNum);

					tempListHTML += '<li class="editcheckbox_item" lineNum="' + listNum + '"><input class="editstatus" type="checkbox" name="checkbox_' + $selectedCom.attr('id') + '" ' + ($(this).find('input:checkbox').attr('checked')=='checked' ? 'checked="checked"' : '') + '/><textarea class="edittext textarea input_textarea'+((tmpVal.length && tmpVal.length>12)? ' much_words':'')+'">' + tmpVal + '</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+tmpLimit+'" placeholder="">个</div><p class="removeButton"></p></li>';
				});
				if ($selectedCom.find('.other').length > 0) {
                    var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                    if(!(otherLimit>=0)){
                        otherLimit = '';
                    }
                    tempListHTML += '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+otherLimit+'" >个</div><p class="removeOtherButton"></p></li>';
				} else {
					tempListHTML += '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
				}

				$editField.find('.editcheckbox_list').empty().append(tempListHTML);
				$editField.find('.editcheckbox_item').last().append('<p class="addButton"></p>');

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                //type_value = (type_value > 0 ) ? type_value : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                //$editField.find('input[value='+type_value+']').attr('checked', 'checked');
                $selectedCom.find('.title_field').data('limit-show-type', type_value);


                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				$selectedCom.unbind('getItemList').bind('getItemList', function (event, list) {
					function _dataInfo(){
					var _res = {limit:[],data:[]};
						$selectedCom.find('.optionsLine').not('.other').each(function(){
                            var option = $(this).find('.optionValue');
                            var limit = option.data('limit');
                            if(!limit) limit = '';
							_res.data.push(option.text());
                            _res.limit.push(limit);
						});
						return _res;
					}
					list.dataInfo = _dataInfo();
					list.hasOther = ($selectedCom.find('.other').length > 0);
					list.defaultTip = ($selectedCom.find('.optionGarden').attr('defaultTip')=='true');
				});

                _initCommonLimitStatus(isCommonLimit);

				_removeLine();
				_addLine();
				_editLine();
				_managerOther();
                _updateLimit();
                _updateLimitValue();
                
                _enterBatchMode();
			}
		}

		return {
			bind: function () {
				return mkBind();
			},
			getItemList: function () {
				return selectItemList;
			}
		};
	})(),
    //单选
	'settingRadioField': (function () {
		var selectItemList = [],
			$editField = $('#form_edit_radioset'),
			$selectedCom, radioName;

        // 每个选项统一限选的个数，全局一个变量控制
        var commonLimitValue = '';

		function _addLine() {
			$editField.find('.addButton').unbind('click').bind('click', function () {
				// add Line ...
				var listNum = selectItemList.length,
					optionTemplate = '<li class="optionsLine medium"><input type="radio" name="' + radioName + '" value="0" disabled="disabled"><label class="optionValue">选项'+(listNum+1)+'</label></li>',
					editTemplate = '<li class="editradio_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="radio_' + $selectedCom.attr('id') + '"><textarea class="edittext textarea input_textarea" >选项'+(listNum+1)+'</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="" >个</div><p class="removeButton"></p></li>';

				$(optionTemplate).insertAfter($selectedCom.find('.optionsLine').not('.other').last())
                    .attr('listfield', listNum)
                    .find('input:radio').attr({
                        'name': radioName,
                        'value': listNum
                    });
				var $editLine = $(editTemplate);
				$editField.find('.editradio_item').last().after($editLine);
				$editLine.find('.edittext').select().focus();
				$editField.find('.addButton').remove();
				$editField.find('.editradio_item').last().append('<p class="addButton"></p>');

                var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

                if($isLimit){
                    // 判断是否统一限选
                    var $editWrap = $editField.find('.J-editWrap');
                    var isCommonLimit = $editWrap.hasClass('limited');
                    if(isCommonLimit) {
                        var $radio = $editField.find('.editradio_item').last().find('.radio_limit');
                        $radio.prop('disabled', true).val(commonLimitValue);
                        _updateOptionLimit($radio);
                    }
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				selectItemList.push('选项'+(listNum+1));
				MKGlobal.addUnsaveCount();
				// ---
				_removeLine();
				_addLine();
				_editLine();
                _updateLimitValue();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _removeLine() {
			$editField.find('.removeButton').unbind('click').bind('click', function () {
				// remove 自己
				var num = $(this).parent().attr('lineNum'),
					$corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
				if ($editField.find('.editradio_item').length > 1) {
					var currentNum = $(this).attr('lineNum');
					delete selectItemList[currentNum];
					$corElem.remove();
					$(this).parent().remove();
					$editField.find('.addButton').remove();
					$editField.find('.editradio_item').last().append('<p class="addButton"></p>');
					_addLine();
				} else {
					$(this).siblings('.edittext').val('');
					$corElem.find('.optionValue').text('');
					selectItemList[num] = '';
				}
				MKGlobal.addUnsaveCount();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _editLine() {
			$editField.find('.edittext').unbind('input keyup').bind('input keyup', function (e) {
                MKFORM.__beforeInput(this);
                
				var $this = $(this),
                    num = $this.parent().attr('lineNum'),
					$corElem = $selectedCom.find('.optionsLine[listField="' + $this.parent().attr('lineNum') + '"]'),
					keyCode = e.keyCode || e.which,
                    val_text = ($this.val()||'').replace(/[\r\n]/igm, '');
				$corElem.find('.optionValue').text(val_text);
				selectItemList[num] = val_text;
                
				MKGlobal.addUnsaveCount();
                if(val_text.length && val_text.length > 12){
                    if(!$this.hasClass('much_words')){
                        $this.addClass('much_words');
                    }
                }else{
                    $this.removeClass('much_words');
                }
                if(keyCode == 13){
                    $this.val(val_text).trigger('blur');
                    if($this.parent().find('.addButton').length > 0){
                        $this.parent().find('.addButton').trigger('click');
                        return false;
                    }
                }
			});

            $editField.find('.editstatus').unbind('click').bind('click',function(){
                var $corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
                if($corElem.find('input:radio').attr('checked') === 'checked'){
                    $selectedCom.find('input:radio').removeAttr('checked');
                    $(this).removeAttr('checked');
                }else{
                    $selectedCom.find('input:radio').removeAttr('checked');
                    $corElem.find('input:radio').attr('checked', 'checked');
                }
                MKGlobal.addUnsaveCount();
            });
		}

        function _renderOtherInput(isLimited) {
            var isDisabled = isDisabledByCommonLimit();
            var content = '<span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+ commonLimitValue +'"'+ isDisabled +'>个</div><p class="removeOtherButton"></p>';

            if(isDisabled) {
                $selectedCom.find(".title_field").data('other-limit', commonLimitValue === '' ? false : commonLimitValue);
            }

            $editField.find('.other-input').html(content);
        }

		function _managerOther() {
			$editField.find('.removeOtherButton').unbind('click').bind('click', function () {
				$selectedCom.find('.other').remove();
				$editField.find('.other-input').html('<span class="add-other-select">添加其他选项</span>');
				_managerOther();
				MKGlobal.addUnsaveCount();
			});

			$editField.find('.add-other-select').unbind('click').bind('click', function () {
				$selectedCom.find('.optionGarden').append('<li class="optionsLine medium other"><input type="radio" name="' + radioName + '" disabled="disabled">' + '其他:<input type="text" class="input medium" disabled="disabled"/>' + '</li>');

                // 1. 判断是否公共限选
                _renderOtherInput();
				// $editField.find('.other-input').html('<span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="">个</div><p class="removeOtherButton"></p>');
				_managerOther();
                _updateLimitValue();
				MKGlobal.addUnsaveCount();
			});

            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

            if($isLimit){
                $editField.find(".other-input").find(".radio_limit_tip").show();
            }else{
                $editField.find(".other-input").find(".radio_limit_tip").hide();
            }
		}

        function clearCommonLimitValue() {
            commonLimitValue = '';
            $selectedCom.find(".title_field").data('common-limit-value', '');
        }

        function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
            $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
                $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
                //$selectedCom.find('.title_field').data('limit-show-type', $(this).prop('value'));
                MKGlobal.addUnsaveCount();
            });

            /* 批量填写限选 */
            var $limitTipCommonCheckbox = $editField.find('.J-limitTipCommonCheckbox')
            $limitTipCommonCheckbox.off('change').on('change', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $editWrap.addClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 1);
                    $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                    _disabledCommonLimitValue($editWrap);
                } else {
                    $editWrap.removeClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 0);
                    $editField.find('.J-limitTipCommonInput').val('');
                    clearCommonLimitValue();
                    _unDisabledCommonLimitValue($editWrap);
                }
                MKGlobal.addUnsaveCount();
            });
            var $limitTipCommonInput = $editField.find('.J-limitTipCommonInput');
            $limitTipCommonInput.off('change input').on('change input', function () {
                var reg = /^[0-9]+$/;
                var $self = $(this);
                commonLimitValue = $.trim($self.val());
                if (commonLimitValue !== '' && !reg.test(commonLimitValue)) {
                    $self.val('').focus();
                    commonLimitValue = '';
                }
                $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                _updateCommonLimitValue($editField);
                MKGlobal.addUnsaveCount();
            });
            $limitTipCommonInput.off('focus').on('focus', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $limitTipCommonCheckbox.trigger('click');
                }
            });
        }

        // 添加统一的限选值
        function _disabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', true);
        }

        function _unDisabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', false);
        }

        function _updateCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.each(function (i, radio) {
                var $radio = $(radio);
                if($radio.hasClass('other_limit')) {
                    $selectedCom.find(".title_field").data('other-limit', commonLimitValue);
                } else {
                    _updateOptionLimit($radio);
                }
                $radio.val(commonLimitValue);
            });
        }

        function _updateOptionLimit($radio) {
            var num = $radio.closest('li').attr('lineNum');
            var $corElem = $selectedCom.find('.optionsLine[listField="' + num + '"]');
            $corElem.find('.optionValue').data('limit', commonLimitValue);
        }

        function isDisabledByCommonLimit() {
            var isDisabled = '';
            // 判断是否统一限选，来恢复下
            var $editWrap = $editField.find('.J-editWrap');
            if($editWrap.hasClass('limited')) {
                isDisabled = ' disabled ';
            }

            return isDisabled;
        }

        function _updateLimitValue(){

             $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {

                 MKGlobal.addUnsaveCount();
                 var re = /^[0-9]+$/;
                 if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                     alert("限额只能为大于或等于零的整数");
                     $(this).val('');
                     $(this).focus();
                 }

                 if($(this).hasClass("other_limit")){
                     $selectedCom.find('.title_field').data('other-limit', $(this).val());
                 }else{
                     var num = $(this).closest('li').attr('lineNum');
                     var $corElem = $selectedCom.find('.optionsLine[listField="' + num + '"]');
                     $corElem.find('.optionValue').data('limit', $(this).val());
                 }

            });

        }

        /* 进入编辑模式 */
        function _enterBatchMode() {
        	var $area = $editField.find('.batch_items');
        	var content = '';
        	// 1. 获取当前的选项
        	// 2. 填充入 textarea
        	$editField.find('.form_edit_batch').off('click.batch').on('click.batch', function (e) {
        		var items = _getBatchItems();
        		content = items.join('');
        		$area.val(content);

        		_changeMode('batch');
        	});
        	$editField.find('.btn_save').off('click.batch').on('click.batch', function (e) {
        		var newContent = $area.val();
                var items = newContent.split('\n');

                _renderLine(items);
                _changeMode();
                //重新绑定事件
                _addLine();
                _removeLine();
                _editLine();
                _updateLimit();
                _updateLimitValue();
                _managerOther();
				$(".formBuilder_edit").getNiceScroll().resize();
        	});
        	$editField.find('.btn_cancel').off('click.batch').on('click.batch', function (e) {
        		_changeMode();
        	});
            $area.off('.batch').on('input.batch, keyup.batch', function (e) {
				MKFORM.__beforeInput(this);
                MKGlobal.addUnsaveCount(); 
            });
        }
        /* 获取选项的行 */
        function _getBatchItems() {
        	var $editText = $editField.find('.edittext');
            var n = $editText.length - 1;
        	var items = [];
        	$editText.each(function (idx, item) {
        		var text = $.trim(item.value);
                var content = '';
                
                if(idx < n) {
                    content = text + '\n';
                } else {
                    content = text;
                }
        	    
                items.push(content);
        	});

        	return items;
        }
        /* 编辑动画交互 */
        function _changeMode(type) {
        	var $radios = $editField.find('.editChoiceRadio'),
        		$limit = $editField.find('.limitNumber'),
        		$batch = $editField.find('.editBatch');
                $batchBtn = $editField.find('.form_edit_batch');
        	if(type === 'batch') {
                $batchBtn.hide();
        		$radios.hide();
	        	$limit.hide();
	        	$batch.addClass('on');
                
                $editField.find('.batch_items').focus();
        	} else {
                $batchBtn.css('display', 'block');
        		$radios.css('display', 'block');
	        	$limit.css('display', 'block');
	        	$batch.removeClass('on');
        	}
        }
        function _renderLine(items) {
        	// 组件 id
        	var id = $selectedCom.attr('id');
        	// 数据
            selectItemList = [];
            
        	var n = items && items.length;
        	var editTemplate = [];
            var optionTemplate = [];

            var isDisabled = isDisabledByCommonLimit();
            
            /* 全部删除，显示默认项 */
            if(n === 1 && items[0] === '') {
                var text = items[0];
                selectItemList.push(text);
                editTemplate.push('<li class="editradio_item" lineNum="0">',
                    '<input class="editstatus" type="radio" name="radio_' + id + '">',
                    '<textarea class="edittext textarea input_textarea">'+ text +'</textarea>',
                    '<div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ commonLimitValue +'" '+ isDisabled +'>个</div>',
                    '<p class="removeButton"></p></li>');
                optionTemplate.push('<li class="optionsLine medium" listfield="0"><input type="radio" name="' + radioName + '" value='+ i +'" disabled="disabled"><label class="optionValue">'+ text +'</label></li>');
            } else {
                for(var i = 0; i < n; ++i) {
                    var text = items[i];

                    selectItemList.push(text);
                    editTemplate.push('<li class="editradio_item" lineNum="' + i + '">',
                        '<input class="editstatus" type="radio" name="radio_' + id + '">',
                        '<textarea class="edittext textarea input_textarea">'+ text +'</textarea>',
                        '<div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+  commonLimitValue +'" '+ isDisabled +'>个</div>',
                        '<p class="removeButton"></p></li>');
                        
                    optionTemplate.push('<li class="optionsLine medium" listfield="'+ i +'"><input type="radio" name="' + radioName + '" value='+ i +'" disabled="disabled"><label class="optionValue">'+ text +'</label></li>');
                }
            }

            var otherInput = '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="${otherLimit}"'+ isDisabled +'>个</div><p class="removeOtherButton"></p></li>';
            var otherSelect = '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
            // 表单中的其它
            var otherOptionInput = '<li class="optionsLine medium other"><input type="radio" name="' + radioName + '" disabled="disabled">' + '其他:<input type="text" class="input medium" disabled="disabled"/>' + '</li>';
            
            if ($selectedCom.find('.other').length > 0) {
                var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                if(!(otherLimit >= 0)){
                    otherLimit = '';
                }
                var otherInputText = otherInput.replace(/\${otherLimit}/img, otherLimit);
                editTemplate.push(otherInputText);
                optionTemplate.push(otherOptionInput);
            } else {
                editTemplate.push(otherSelect);
            }
            
        	$editField.find('.editradio_list').html(editTemplate.join(''));
            $editField.find('.editradio_item').last().append('<p class="addButton"></p>');
            
            $selectedCom.find('.optionGarden').html(optionTemplate);
            
            var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');
            if($isLimit) {
                $editField.find(".radio_limit_tip").show();
            } else {
                $editField.find(".radio_limit_tip").hide();
            }
            
            //更新一下限选数据（统一限选的时候）
            if(isDisabled) {
                _updateCommonLimitValue($editField);
            }
        }

        function _initCommonLimitStatus(isCommonLimit) {
            if(isCommonLimit) {
                $editField.find('.J-editWrap').addClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', true);
                $editField.find('.J-limitTipCommonInput').val(commonLimitValue);

                var $editWrap = $editField.find('.J-editWrap');
                _disabledCommonLimitValue($editWrap);
                _updateCommonLimitValue($editField);
            } else {
                $editField.find('.J-editWrap').removeClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', false);
                $editField.find('.J-limitTipCommonInput').val('');

                var $editWrap = $editField.find('.J-editWrap');
                _unDisabledCommonLimitValue($editWrap);
            }
        }

		function mkBind() {
			var tempListHTML = '';
			selectItemList = [];

			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

				// 性别组件不需要
				$editField.find('.form_edit_batch').show().end().find('.radio_limit_tip_common').show();

                var $titleField = $selectedCom.find('.title_field');
                var titleData = $titleField.data();

                var $isLimit = titleData.limit;
                // 是否统一限选
                var isCommonLimit = titleData.commonLimit || 0;
                commonLimitValue = titleData.commonLimitValue || '';

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

				// set selectItemList
				radioName = $selectedCom.find('.optionsLine').first().find('input:radio').attr('name');
				$selectedCom.find('.optionsLine:not(.other)').each(function (i) {
					var listNum,
						tmpVal = $(this).find('.optionValue').text(),
                        tmpLimit = parseInt($(this).find('.optionValue').data('limit'), 10);
                    if(!(tmpLimit>=0)) tmpLimit = "";
					if($(this).find('input:radio').val()){
						var _tmpKey = parseInt($(this).find('input:radio').val(),0);
						if(selectItemList[_tmpKey]){
							selectItemList.push(tmpVal);
							$(this).find('input:radio').val(selectItemList.length-1);
						} else {
							selectItemList[_tmpKey]=tmpVal;
						}

					} else {
						selectItemList.push(tmpVal);
					}
					
					listNum = $(this).find('input:radio').val();
					$(this).attr('listField', listNum);
					
					tempListHTML += '<li class="editradio_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="radio_' + $selectedCom.attr('id') + '" ' + ($(this).find('input:radio').attr('checked')=='checked' ? 'checked="checked"' : '') + '><textarea class="edittext textarea input_textarea'+((tmpVal.length && tmpVal.length>12)? ' much_words':'')+'">' + tmpVal + '</textarea><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+tmpLimit+'">个</div><p class="removeButton"></p></li>';
				});

				if ($selectedCom.find('.other').length > 0) {
                    var otherLimit = parseInt($selectedCom.find('.title_field').data('other-limit'), 10); // isLimit
                    if(!(otherLimit>=0)){
                        otherLimit = '';
                    }
					tempListHTML += '<li class="other-input"><span>其他:</span><input type="text" class="text input" value="" disabled="disabled"><div class="radio_limit_tip">限选<input type="text" class="radio_limit other_limit input" value="'+otherLimit+'">个</div><p class="removeOtherButton"></p></li>';
				} else {
					tempListHTML += '<li class="other-input"><span class="add-other-select">添加其他选项</span></li>';
				}

				$editField.find('.editradio_list').empty().append(tempListHTML);
				$editField.find('.editradio_item').last().append('<p class="addButton"></p>');

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                //type_value = (type_value > 0 ) ? type_value : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                //$editField.find('input[value='+type_value+']').attr('checked', 'checked');
                $selectedCom.find('.title_field').data('limit-show-type', type_value);

                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				$selectedCom.unbind('getItemList').bind('getItemList', function (event, list) {
					function _dataInfo(){
						var _res = {limit:[],data:[],limitOther:''};
						$selectedCom.find('.optionsLine').not('.other').each(function(){
                            var option = $(this).find('.optionValue');
                            var limit = option.data('limit');
                            if(!limit) limit = '';
							_res.data.push(option.text());
                            _res.limit.push(limit);
                            var otherLimitField = $("other_limit",$editField);
                            if(otherLimitField.length > 0) {
                                _res.limitOther = otherLimitField.val();
                            }
						});
						return _res;
					}
					list.dataInfo = _dataInfo();
					list.hasOther = ($selectedCom.find('.other').length > 0);
					list.defaultTip = ($selectedCom.find('.optionGarden').attr('defaultTip')=='true');
				});

                _initCommonLimitStatus(isCommonLimit);

				_removeLine();
				_addLine();
				_editLine();
				_managerOther();
                _updateLimit();
                _updateLimitValue();

                /* 编辑模式 */
                _enterBatchMode();
			}
		}

		return {
			bind: function () {
				return mkBind();
			},
			getItemList: function () {
				return selectItemList;
			}
		};
	})(),
    /* 性别组件 */
	'settingGenderField': (function () {
		var selectItemList = [],
			$editField = $('#form_edit_radioset'),
			$selectedCom, radioName;

		function _editLine() {
			$editField.find('.edittext').unbind('input keyup').bind('input keyup', function () {
                MKFORM.__beforeInput(this);
                
				var num = $(this).parent().attr('lineNum'),
					$corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
				$corElem.find('.optionValue').text($(this).val());
				selectItemList[num] = $(this).val();
			});
			$editField.find('.editstatus').unbind('change').bind('change', function () {
				var $corElem = $selectedCom.find('.optionsLine[listField="' + $(this).parent().attr('lineNum') + '"]');
				$corElem.find('input:radio').attr('checked', 'checked');
				MKGlobal.addUnsaveCount();
			});
		}

        function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
            $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
                $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
                MKGlobal.addUnsaveCount();
            });
        }

        function _updateLimitValue(){
            $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {

                MKGlobal.addUnsaveCount();
                var re = /^[0-9]+$/;
                if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                    alert("限额只能为大于或等于零的整数");
                    $(this).val('');
                    $(this).focus();
                }

                var num = $(this).closest('li').attr('lineNum');
                var $corElem = $selectedCom.find('.optionsLine[listField="' + num + '"]');
                $corElem.find('.optionValue').data('limit', $(this).val());

            });
        }

		function mkBind() {
			var tempListHTML = '';
			selectItemList = [];
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

				$editField.find('.form_edit_batch').hide().end().find('.radio_limit_tip_common').hide();

                var $isLimit = $selectedCom.find('.title_field').data('limit'); // isLimit

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

                // set selectItemList
				radioName = $selectedCom.find('.optionsLine').first().attr('name');
				$selectedCom.find('.optionsLine:not(.other)').each(function (i) {
					var listNum = selectItemList.length,
						tmpVal = $(this).attr('listField', listNum).find('.optionValue').text(),
                        tmpLimit = parseInt($(this).find('.optionValue').data('limit'), 10);
                    if(!(tmpLimit>=0)) tmpLimit = "";

					selectItemList.push(tmpVal);
					tempListHTML += '<li class="editradio_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="radio_' + $selectedCom.attr('id') + '" ' + ($(this).attr('checked') ? 'checked="checked"' : '') + '><input type="text" class="edittext input" value="' + tmpVal + '"><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+tmpLimit+'">个</div></li>';
				});

				$editField.find('.editradio_list').empty().append(tempListHTML);

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                $selectedCom.find('.title_field').data('limit-show-type', type_value);

                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				_editLine();
                _updateLimit();
                _updateLimitValue();
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingChooseType': (function () {
		// 这个是选择 选择组件的类型 多选 单选 下拉 互相切换
		// 记得选择完成以后调用重新渲染
		// 记得修改当前的组件的类型
		// 修改后再重新渲染
		var $editField = $('#form_edit_selecttype'),
			$selectedCom,
			_typeMap = {
				'id_checkBox': 'editsize_checkbox',
				'id_radio': 'editsize_radio',
				'id_dropDown': 'editsize_select'
			},
			_map = {
				'id_checkBox': 'checkbox',
				'id_radio': 'radio',
				'id_dropDown': 'select'
			},
			_comMap = {
				'checkbox': 'id_checkBox',
				'radio': 'id_radio',
				'select': 'id_dropDown'
			};

		function generateHTML(type, id, obj,layout) {
			var _r = '',
				_layoutType = '';
			if(layout){
				_layoutType = 'layout-type-'+layout;
			}
			// console.log(obj);
			if (type === 'checkbox') {

				$.each(obj.dataInfo.data, function (k, v) {
                    var limit = obj.dataInfo.limit[k];
					_r += '<li class="optionsLine medium" listfield="' + k + '"><input type="checkbox" name="checkbox' + id + '" value="' + k + '" disabled="true"><label class="optionValue" data-limit="'+limit+'">' + v + '</label></li>';
				});
				if (obj.hasOther) {
					_r += '<li class="optionsLine medium other"><input type="checkbox" name="checkbox' + id + '" disabled="true">其他:<input type="text" class="input medium"></li>';
				}
				_r = '<ul class="optionGarden ui-sortable '+_layoutType+'" defaultTip="'+(obj.defaultTip||false)+'">' + _r + '</ul><div class="clearB"></div>';
			} else if (type === 'radio') {
				$.each(obj.dataInfo.data, function (k, v) {
                    var limit = obj.dataInfo.limit[k];
					_r += '<li class="optionsLine medium" listfield="' + k + '"><input type="radio" name="radio' + id + '" value="' + k + '" disabled="true"><label class="optionValue" data-limit="'+limit+'">' + v + '</label></li>';
				});
				if (obj.hasOther) {
					_r += '<li class="optionsLine medium other"><input type="radio" name="radio' + id + '" disabled="true">其他:<input type="text" class="input medium"></li>';
				}
				_r = '<ul class="optionGarden ui-sortable '+_layoutType+'" defaultTip="'+(obj.defaultTip||false)+'">' + _r + '</ul><div class="clearB"></div>';
			} else if (type === 'select') {
				$.each(obj.dataInfo.data, function (k, v) {
                    var limit = obj.dataInfo.limit[k];
					_r += '<option name="' + k + '" data-limit="'+limit+'">' + v + '</option>';
				});
				// if (obj.defaultTip) {
				_r = '<select class="medium" disabled="true" other="'+(obj.hasOther||false)+'" defaultTip="true"><option name="-1">请选择</option>' + _r + '</select>';
				// }else{
				// 	_r = '<select class="medium" disabled="true" other="'+(obj.hasOther||false)+'" defaultTip="'+(obj.defaultTip||false)+'">' + _r + '</select>';
				// }
			}
			return _r;
		}

		function mkBind() {
			var currentType,
				currentId_Num;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				currentId_Num = $selectedCom.attr('id').replace('com', '');
				currentType = _typeMap[$selectedCom.attr('name')];
				// show current state
				$editField.find('#' + currentType).attr('checked', 'checked');

				$editField.find('input:radio').unbind('change').bind('change', function () {
					// ----
					var selectedType = $(this).val(),
						selectVal = {'dataInfo': [], 'hasOther': false, 'defaultTip':false},
						tmpHTML = '';

					$selectedCom.trigger('getItemList', [selectVal]);

					$selectedCom.find('.' + _map[$selectedCom.attr('name')]).attr('class', selectedType).html(generateHTML(selectedType, currentId_Num, selectVal,$selectedCom.data('layoutType')));
					$selectedCom.attr('name', _comMap[selectedType]);
					renderFormComponent($selectedCom);
					addOptionDrag();
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'settingSelectLayout': (function () {
		var $editField = $('#form_edit_selectlayout'),
			$selectedCom,
			typeMap = {
				'single':1,
				'two':2,
				'three':3,
				'four':4
			},
			layoutClass = "layout-type";

		function mkBind(){
			var _layout = "single";
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				// --- set val
				$editField.find('input:radio').removeAttr('checked');
				if($selectedCom.data('layoutType')){
					_layout = $selectedCom.data('layoutType');
				}
				$selectedCom.data('layoutType',_layout);
				$editField.find('#editlayout_' + _layout).attr('checked', 'checked');
				$editField.find('input:radio').unbind('change').bind('change', function () {
					var selectedType = $(this).val(),
						$optionGarden = $selectedCom.find('.optionGarden');
					$selectedCom.data('layoutType',selectedType);
					$optionGarden.attr('class','optionGarden ui-sortable '+layoutClass+'-'+selectedType);
					$optionGarden.find('.clearB').remove();
					if(typeMap[selectedType] !== 1){
						var tmpList = [];
						$optionGarden.find('.optionsLine').each(function (i){
						// 
							if((i+1)%(typeMap[selectedType]) === 0 && i !== 0){
								// $(this).after('<li class="clearB"></li>');
								tmpList.push($(this));
							}
						});
						$.each(tmpList, function(k,v){
							v.after('<li class="clearB"></li>');
						});
					}
					MKGlobal.addUnsaveCount();
				});
			}
		}
		return {
			bind: function() {
				mkBind();
			}
		};
	})(),
    /* 商品组件 */
	'settingShoppingField': (function () {
		var $editField = $('#form_edit_shoppinglist'),
			$selectedCom,
			shoppingInfo,
			shoppingItemTemplate = '<div class="pic_place"><img src="%%PIC%%"/></div><div class="text_place"><a class="item_name" a_link="%%LINK%%">%%NAME%%</a><p class="item_price">%%PRICE%%</p><p class="item_select"><span class="remove">-</span><input class="itemnum" value="0"><span class="add">+</span></p></div>',
			$editItemTemplate = $editField.find('.meta').clone();

		// 商品组件限制条件的对象
		var shoppingLimit = {
			name: 63, // 商品名最大长度
			height: [] // 存储当前行，商品的高度的数组 -> 用于找出最大高度
		};

		$editItemTemplate.removeClass('meta').find('.shoppingitem_preview').hide();

		function _checkClearB(){
			$selectedCom.find('.shopping-item').not('.empty').each(function(i){
				if(i%3 === 0){
					$(this).addClass('clearB');
				} else {
					$(this).removeClass('clearB');
				}
			});
		}

		function _addLine() {
			$editField.find('.add_shopping_item').unbind('click').bind('click', function () {
				// -- add New line
				var $tmpEditField = $editItemTemplate.clone();

				$tmpEditField.find('.shoppingitem_edit').attr('newItem', true);
				$tmpEditField.find('.defaultimg').show();
				$tmpEditField.insertBefore($editField.find('.addShopping_item'));

				_editLine();
				$(".formBuilder_edit").getNiceScroll().resize();
				MKGlobal.addUnsaveCount();
			});
		}

		// 重新计算商品的高度，保证每行高度一致
		function _recalculate() {
			// 1. 找到现在总共的商品个数
			var $items = $selectedCom.find('.shopping-item:not(.empty)');
			if($items && $items.length > 0) {
				var total = $items.length;
				// 2. 当前添加到的行数计算
				var line = Math.ceil(total / 3);
				var moreNum = (total % 3) || 3;
				var startIndex = total - moreNum;
				var endIndex = total;
				var $cur = null;
				var maxHeight = _findMaxHeight(startIndex, endIndex);

				for(var i = startIndex; i < endIndex; ++i) {
					$cur = $items.eq(i);
					$cur.height(maxHeight);
				}
			}
		}

		function _recalculateByLine($curItem) {
			var curIndex = parseInt($curItem.attr('itemid')) + 1; // 从 1 开始
			var $items = $selectedCom.find('.shopping-item:not(.empty)');
			if($items && $items.length > 0) {
				var moreNum = curIndex % 3;
				var total = 0;
				var startIndex = 0;
				var endIndex = 0;
				if(moreNum === 0) {
					 total = curIndex;
					 startIndex = total - 3;
				} else {
					total = curIndex + (3 - moreNum);
					startIndex = curIndex - moreNum;
				}
				endIndex = total;

				var $cur = null;
				var maxHeight = _findMaxHeight(startIndex, endIndex);

				for(var i = startIndex; i < endIndex; ++i) {
					$cur = $items.eq(i);
					$cur.height(maxHeight);
				}
			}
		}

		function _findMaxHeight(startIndex, endIndex) {
			shoppingLimit.height = [];
			var $items = $selectedCom.find('.shopping-item:not(.empty)');
			if($items && $items.length > 0) {
				for(var i = startIndex; i < endIndex; ++i) {
					var $item = $items.eq(i);
					$item.removeAttr('style');
					var h = $item.outerHeight();
					shoppingLimit.height.push(h);
				}
			}

			return Math.max.apply(null, shoppingLimit.height);
		}
        
		function _editLine() {
			// ... 进行组件的编辑       --- add cancel delete
			$editField.find('.btn_canceledit').unbind('click').bind('click', function () {
				var $_editField = $(this).closest('.shoppingitem_edit'),
					$_deleteBtn = $_editField.closest('.shoppingitem_preview_container').siblings('.deleteitem');
				if ($_editField.attr('newItem')) {
					$(this).closest('.editShopping_item').remove();
				} else {
					$_editField.hide().siblings('.shoppingitem_preview').show();
					$_deleteBtn.show();
				}
				MKGlobal.addUnsaveCount();
			});

			$editField.find('.deleteitem').unbind('click').bind('click', function () {
				var $infoField = $(this).closest('.editShopping_item'),
					siid = $infoField.find('.shoppingitem_edit').attr('siid');
				shoppingInfo.splice(siid, 1);
				// 这个后面的所有的同级的元素要进行siid变化，item id 也要变化
				$infoField.nextAll('.editShopping_item').each(function(){
					var $shoppingitem_edit = $(this).find('.shoppingitem_edit');
					$shoppingitem_edit.attr('siid',$shoppingitem_edit.attr('siid')-1);
				});
				var $waitRemove = $selectedCom.find('.shopping-item[itemid="' + siid + '"]');
				$waitRemove.nextAll('.shopping-item').each(function(){
					var $this = $(this);
					$this.attr('itemid',$this.attr('itemid')-1);
				});
				$waitRemove.remove();
				if ($selectedCom.find('.shopping-item').not('.empty').length === 0) {
					$selectedCom.find('.empty').show();
				}
				$infoField.remove();
				$selectedCom.data('shoppingInfo', shoppingInfo);
				_recalculateBySortable($selectedCom);
				MKGlobal.addUnsaveCount();
				_checkClearB();
				$(".formBuilder_edit").getNiceScroll().resize();
				$(".formBuilder_example").getNiceScroll().resize();
			});

			$editField.find('.shoppingitem_preview').unbind('click').bind('click', function () {
				var $_editField = $(this).siblings('.shoppingitem_edit'),
					$_deleteBtn = $_editField.closest('.shoppingitem_preview_container').siblings('.deleteitem');
				$_editField.show();
				$(this).hide();
				$_deleteBtn.hide();
				$(".formBuilder_edit").getNiceScroll().resize();
			});

			MKFORM.formUtility.formButtonImgUpload($editField.find('.input_file'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/'),
					$currentField = $(e.target).closest('.editShopping_item');

				$currentField.find('.editimg').attr('src', MKFORM.localHost + imgPath).show().error(function () {
					$(this).hide();
					imgPath = '';
					$currentField.find('.defaultimg').show();
				});
				$currentField.find('.defaultimg').hide();
				$currentField.find('.upload_shopping_file').attr('imgsrc', ((imgPath) ? (MKFORM.localHost + imgPath) : ''));
				MKGlobal.addUnsaveCount();
			});


			$editField.find('.editShopping_list')
                .off('keyup.name input.name change.name')
                .on('keyup.name input.name change.name', '.shopping_name input', function (e) {
                
                MKFORM.__beforeInput(e.target);
                
                var $this = $(this),
                    val = $this.val();

                if(val.length > shoppingLimit.name) {
					$this.val(val.substr(0, shoppingLimit.name));
                    $('.globalLoading').fadeIn(300).find('.info').text('商品名称请控制在63字以内~');
                    window.setTimeout(function(){
                        $('.globalLoading').fadeOut(300);
                    },3000);
                }
            });
            
            $editField.find('.editShopping_list')
                .off('keyup.link input.link change.link')
                .on('keyup.link input.link change.link', '.shopping_link input', function (e) {
                
                MKFORM.__beforeInput(e.target);
            });
            
			$editField.find('.btn_additem').unbind('click').bind('click', function () {
				var $_editField = $(this).closest('.shoppingitem_edit'),
					$_previewField = $_editField.siblings('.shoppingitem_preview'),
					$_deleteBtn = $_editField.closest('.shoppingitem_preview_container').siblings('.deleteitem'),
					tmpObj = {},
					tmpHTML = '', reg = /^(file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp):\/\//;

				tmpObj["name"] = $_editField.find('.shopping_name input').val().replace(/\"/g, ' ');
				tmpObj["pic"] = $_editField.find('.upload_shopping_file').attr('imgsrc');
				tmpObj["link"] = $_editField.find('.shopping_link input').val();
				tmpObj["describe"] = ($_editField.find('.shopping_describe input').val() || '').replace(/\"/g, ' ');
				tmpObj["price"] = parseFloat(($_editField.find('.shopping_price input').val() || '0').replace(/[^\d^\.]/g, '')).toFixed(2);
				tmpObj["num"] = $_editField.find('.shopping_num input').val().replace(/[^\d]/g, '') || '';

				if ($.trim(tmpObj.link).length > 0) {
					tmpObj["link"] = ( (!reg.test(tmpObj["link"])) ? ("http://" + tmpObj["link"]) : tmpObj["link"] );
				}
				if (tmpObj['num'] == 0) {
					tmpObj["num"] = '';
				}
				if (isNaN(tmpObj['price'])) {
					tmpObj["price"] = 0;
				}
				$_editField.find('.shopping_price input').val(tmpObj['price']);

				if (tmpObj.name) {
					if (tmpObj.price > 100000) {
						$_editField.find('.errorinfo').show().text('抱歉，商品单价超出限制。');
						window.setTimeout(function () {
							$_editField.find('.errorinfo').fadeOut(200);
						}, 1200);
					} else {
						var imgFlag = false;
						tmpHTML = shoppingItemTemplate.replace(/(%%(.*?)%%)/igm, function () {
							var tmpVal = '';
							if (arguments[2] === 'PRICE') {
								if (tmpObj[arguments[2].toLowerCase()]) {
									tmpVal = '￥' + tmpObj[arguments[2].toLowerCase()];
								}
								return tmpVal;
							}
							return tmpObj[arguments[2].toLowerCase()] || '';
						});
						if(tmpObj.pic){
							imgFlag = true;
						}
						if ($_editField.attr('newItem')) {
							// 新增一个
							var dataLength = shoppingInfo.length;
							$selectedCom.find('.empty').hide();

							$_editField.removeAttr('newItem');
							$_editField.attr('siid', dataLength);

							var noPic = imgFlag ? '' : ' nopic';
							var $newItem = $('<li class="shopping-item' + noPic + '">' + tmpHTML + '</li>').attr('itemid', dataLength);
							$selectedCom.find('.shoppingList').append($newItem);
							shoppingInfo.push(tmpObj);

							_recalculate($newItem);
						} else {
							// 修改本来的值... 其实就是重新写值
							var $tmpItem = $selectedCom.find('.shopping-item[itemid="' + $_editField.attr('siid') + '"]');
							shoppingInfo[$_editField.attr('siid')] = tmpObj;
							$tmpItem.html(tmpHTML);
							if(!imgFlag){
								$tmpItem.addClass('nopic');
							} else {
								$tmpItem.removeClass('nopic');
							}

							_recalculateByLine($tmpItem);
						}
						$_previewField.find('.previewinfo').attr('title', tmpObj.name).text(tmpObj.name);
						if(imgFlag){
							$_previewField.find('img').attr('src', tmpObj.pic);
						} else {
							$_previewField.find('img').attr('src','images/icon/formDefaultImage.png');
						}
						_checkClearB();

						$selectedCom.data('shoppingInfo', shoppingInfo);
						$_editField.hide();
						$_previewField.show();
						$_deleteBtn.show();
						$(".formBuilder_edit").getNiceScroll().resize();
						$(".formBuilder_example").getNiceScroll().resize();
						MKGlobal.addUnsaveCount();
					}

				} else {
					$_editField.find('.errorinfo').show().text('必须填写商品名称');
					window.setTimeout(function () {
						$_editField.find('.errorinfo').fadeOut(200);
					}, 1200);
				}

			});
		}

		function mkBind() {
			var $tmp;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				// getList of
				shoppingInfo = $selectedCom.data('shoppingInfo');
				if (!shoppingInfo) {
					shoppingInfo = [];
					$selectedCom.data('shoppingInfo', []);
				}
				$editField.find('.editShopping_item').not('.meta').remove();
				// 通过 shopping Info 来创建 列表
				if (shoppingInfo.length > 0) {
					$.each(shoppingInfo, function (key, val) {
						// TODO shopping
						$tmp = $editItemTemplate.clone();

						$tmp.find('.shoppingitem_edit').attr('siid', key).hide();
						$tmp.find('.deleteitem').show();
						$tmp.find('.shoppingitem_preview').show();
						// --
						$tmp.find('.shopping_name input').val(val.name);
						$tmp.find('.upload_shopping_file').attr('imgsrc', val.pic);
                        
						if (!val.pic) {
							$tmp.find('.defaultimg').show();
						} else {
                            $tmp.find('.defaultimg').hide();
                            
                            $tmp.find('.editimg').attr('src', val.pic).show().error(function () {
                                $(this).hide();
                                $tmp.find('.defaultimg').show();
                            });
                        }

						$tmp.find('.shopping_link input').val(val.link);
						$tmp.find('.shopping_describe input').val(val.describe);
						$tmp.find('.shopping_price input').val(val.price);
						$tmp.find('.shopping_num input').val(val.num);

						$tmp.find('.previewinfo').attr('title', val.name).text(val.name);
						$tmp.find('.previewimg img').attr('src', val.pic||'images/icon/formDefaultImage.png');
						// --
                        
						$tmp.insertBefore($editField.find('.addShopping_item'));
					});
				}

				_addLine();
				_editLine();
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'settingCheckboxSelectLogic': (function () {
		// TODO finish checkbox logic
		var $editField = $('#form_edit_checkboxlogicset'),
			$selectedCom;

		function mkBind() {
			var componentData;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				componentData = $selectedCom.data('__MGComponentSelect');
				if (!componentData) {
					$selectedCom.data('__MGComponentSelect', {
						enable: false,
						number: '',
						type: 0
					});
					componentData = {
						enable: false,
						number: '',
						type: 0
					};
				}
				// setval
				$editField.find('.errorinfo').hide();
				if (componentData.enable) {
					$editField.find('.select-number-enable').attr('checked', 'checked');
					$editField.find('.edit-select-number').removeAttr('disabled');
					$editField.find('.select-number-type').removeAttr('disabled');
				} else {
					$editField.find('.select-number-enable').removeAttr('checked');
					$editField.find('.edit-select-number').attr('disabled', 'disabled').val('');
					$editField.find('.select-number-type').attr('disabled', 'disabled');
				}
				$editField.find('.select-number-type').find('option').each(function () {
					if (parseInt($(this).val(), 0) === componentData.type) {
						$(this).attr('selected', 'selected');
					} else {
						$(this).removeAttr('selected');
					}
				});
				$editField.find('.edit-select-number').val(componentData.number);

				// event bind
				$editField.find('.select-number-enable').unbind('change').bind('change', function () {
					var typeValue = $(this).attr('checked');
					$selectedCom.data('__MGComponentSelect').enable = (typeValue == 'checked');
					componentData.enable = (typeValue == 'checked');
					if (typeValue == 'checked') {
						$editField.find('.edit-select-number').removeAttr('disabled').val($selectedCom.data('__MGComponentSelect').number).select().focus();
						$editField.find('.select-number-type').removeAttr('disabled');
					} else {
						$editField.find('.edit-select-number').attr('disabled', 'disabled').val('');
						$editField.find('.select-number-type').attr('disabled', 'disabled');
					}

					MKGlobal.addUnsaveCount();
				});
				$editField.find('.select-number-type').unbind('change').bind('change', function () {
					var typeValue = parseInt($(this).val(), 0);
					$selectedCom.data('__MGComponentSelect').type = typeValue;
					componentData.type = typeValue;
					MKGlobal.addUnsaveCount();
				});
				$editField.find('.edit-select-number').unbind('input keyup').bind('input keyup', function () {
					var number = $(this).val().replace(/[^\d]/g, ''),
						check = statusCheck();
					if (!check.status) {
						number = check.num;
					}

					$(this).val(number);
					$selectedCom.data('__MGComponentSelect').number = number;
					componentData.number = number;
					MKGlobal.addUnsaveCount();

				});
			}
		}

		function statusCheck() {
			var choiceInfo = {},
				currentType = $selectedCom.data('__MGComponentSelect').type,
				choiceLength, _rStatus = true, _rNum, _errorInfo = false,
				$numberinput = $editField.find('.edit-select-number');

			$selectedCom.trigger('getItemList', [choiceInfo]);

			choiceLength = choiceInfo.dataInfo.length + ((choiceInfo.hasOther) ? 1 : 0);

			if (parseInt(currentType) === 0) {
				if (choiceLength < parseInt($numberinput.val()) || parseInt($numberinput.val()) <= 0) {
					_rStatus = false;
					_rNum = choiceLength;
					_errorInfo = true;
				} else {
					_rNum = parseInt($numberinput.val().replace(/[^\d]/g, ''));
				}
			} else if (parseInt(currentType) === 1) {
				if (choiceLength < parseInt($numberinput.val()) || parseInt($numberinput.val()) <= 0) {
					_rStatus = false;
					_rNum = 2;
					_errorInfo = true;
				} else {
					_rNum = parseInt($numberinput.val().replace(/[^\d]/g, ''));
				}
			} else if (parseInt(currentType) === 2) {
				if (choiceLength < parseInt($numberinput.val()) || parseInt($numberinput.val()) <= 0) {
					_rStatus = false;
					_rNum = 2;
					_errorInfo = true;
				} else {
					_rNum = parseInt($numberinput.val().replace(/[^\d]/g, ''));
				}
			}

			return {
				status: _rStatus,
				num: _rNum
			};
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'settingDateType': (function () {
		var $editField = $('#form_edit_datetype'),
			$selectedCom;

		function mkBind() {
			var dateType;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

				dateType = $selectedCom.find('.date').attr('datetype');

				$editField.find('input[value="' + dateType + '"]').attr('checked', 'checked');

				$editField.find('input:radio').unbind('change').bind('change', function () {
					var dateType = $(this).val();
					$selectedCom.find('.date').attr('datetype', dateType);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
    //图片多选
	'settingPictureCheckboxField': (function(){
		var selectItemList = [],
			$editField = $('#form_edit_pic_checkboxset'),
			$selectedCom, checkboxName;

        // 每个选项统一限选的个数，全局一个变量控制
        var commonLimitValue = '';

		// check clear
		function _checkClearB(){
			$selectedCom.find('.picturecheckbox-item').not('.empty').each(function(i){
				if(i%3 === 0){
					$(this).addClass('clearB');
				} else {
					$(this).removeClass('clearB');
				}
			});
		}

		// eventbind
		function _addLine(){
			$editField.find('.addButton').off('click').on('click',function(){
				// add Line ...
				var option = '<li class="picturecheckbox-item"><div class="piccheckbox_img"></div><div class="piccheckbox_contect"><input type="checkbox" name="' + checkboxName + '" value="0" disabled="disabled"><label class="optionValue">选项</label></div></li>',
					listNum = selectItemList.length,
					editTemplate = '<li class="editpicturecheckbox_item" lineNum="' + listNum + '"><input class="editstatus" type="checkbox" name="piccheckbox_' + $selectedCom.attr('id') + '"><div class="pictextcontect"><div class="imgcontect"><img src="" alt="" class="choicePicture"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/> <span class="upload_btn">上传图片<br/>(限2MB)</span> </div></div><input type="text" class="imgedittext" value="选项"><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="" placeholder="">个</div><p class="removeButton"></p></div></li>';
				$(option).appendTo($selectedCom.find('.pictureCheckboxList')).attr('listfield', listNum).find('input:checkbox').attr({
					'name': checkboxName,
					'value': listNum
				});

				var $editLine = $(editTemplate);
				$editField.find('.editpicturecheckbox_item').last().after($editLine);
				// $editLine.find('.edittext').select().focus();
				$editField.find('.addButton').remove();
                $editField.find('.pictextcontect').last().append('<p class="addButton"></p>');
				_checkClearB();
				selectItemList.push({name:'选项',img:'',limit:''});

				MKGlobal.addUnsaveCount();

                var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

                if($isLimit){
                    // 判断是否统一限选
                    var $editWrap = $editField.find('.J-editWrap');
                    var isCommonLimit = $editWrap.hasClass('limited');
                    if(isCommonLimit) {
                        var $radio = $editField.find('.editpicturecheckbox_item').last().find('.radio_limit');
                        $radio.prop('disabled', true).val(commonLimitValue);
                        _updateOptionLimit($radio);
                    }
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				// ---
				_removeLine();
				_addLine();
				_editLine();
                _updateLimitValue();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _removeLine(){
			$editField.find('.removeButton').off('click').on('click',function(){
				// remove 自己
				var $_editField = $(this).closest('.editpicturecheckbox_item'),
					num = parseInt($_editField.attr('lineNum')),
					$corElem = $selectedCom.find('.picturecheckbox-item[listField="' + $_editField.attr('lineNum') + '"]'),
					$editLine = $editField.find('.editpicturecheckbox_item');
				if ($editLine.length > 1) {
					delete selectItemList[num];
					$corElem.remove();
					$_editField.remove();
					$editField.find('.addButton').remove();
                    $editField.find('.pictextcontect').last().append('<p class="addButton"></p>');
					_checkClearB();
					_addLine();
				} else {
					$_editField.find('.imgedittext').val('选项');
					$_editField.find('.upload_btn').show();
					$_editField.find('.imgcontect img').hide();
					$corElem.find('.optionValue').text('选项');
					$corElem.find('.picc_img').remove();
					$corElem.find('.piccheckbox_img').removeAttr('style');
					selectItemList[num].name = '选项';
					selectItemList[num].img = '';
				}
				MKGlobal.addUnsaveCount();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _editLine(){
			// text edit
			$editField.off('keyup.editLine input.editLine').on('keyup.editLine input.editLine', '.imgedittext', function (e){
                MKFORM.__beforeInput(e.target);
                
				var $_editField = $(this).closest('.editpicturecheckbox_item'),
					num = $_editField.attr('lineNum'),
					$corElem = $selectedCom.find('.picturecheckbox-item[listField="' + num + '"]'),
					value = $.trim($(this).val());
				$corElem.find('.optionValue').text(value);
				selectItemList[num].name = value;
                
				MKGlobal.addUnsaveCount();
				if($_editField.find('.addButton').length > 0){
					// 最后一行， 按回车创建新的一个
					if(e.which == 13){
						$_editField.find('.addButton').trigger('click');
					}
				}
			});
			// status edit
			$editField.off('change.changeStatus').on('change.changeStatus','.editstatus',function (e){
				var $corElem = $selectedCom.find('.picturecheckbox-item[listField="' + $(this).closest('.editpicturecheckbox_item').attr('lineNum') + '"]');
				$corElem.find('input:checkbox').attr('checked', ($(this).attr('checked') === 'checked'));
				MKGlobal.addUnsaveCount();
			});
			// pic edit
			MKFORM.formUtility.formSelectImgUpload($editField.find('.uploadimg'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/'),
					$this = $(e.target),
					$currentField = $this.closest('.editpicturecheckbox_item');
				$this.siblings('.upload_btn').hide();
				// $this.parent().css('background-color','#FFF');
				$currentField.find('.choicePicture').attr('src', MKFORM.localHost + imgPath).show().error(function () {
					$(this).hide();
					imgPath = '';
					$this.siblings('.upload_btn').show();
					// $this.parent().css('background-color','#E4E3E4');
				});
				// $currentField.find('.upload_shopping_file').attr('imgsrc', ((imgPath) ? (MKFORM.localHost + imgPath) : ''));
				var $imgF = $selectedCom.find('.picturecheckbox-item[listField="' + $currentField.attr('linenum') + '"]').find('.piccheckbox_img');
				if($imgF.find('.picc_img').length===0){
					$imgF.show().append('<img class="picc_img"/>');
				}
				selectItemList[$currentField.attr('linenum')].img = MKFORM.localHost + imgPath;
				$imgF.find('.picc_img').attr('src', MKFORM.localHost + imgPath);
				MKGlobal.addUnsaveCount();
			});
		}

        function clearCommonLimitValue() {
            commonLimitValue = '';
            $selectedCom.find(".title_field").data('common-limit-value', '');
        }

        function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
            $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
                $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
                //$selectedCom.find('.title_field').data('limit-show-type', $(this).prop('value'));
                MKGlobal.addUnsaveCount();
            });

            /* 批量填写限选 */
            var $limitTipCommonCheckbox = $editField.find('.J-limitTipCommonCheckbox')
            $limitTipCommonCheckbox.off('change').on('change', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $editWrap.addClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 1);
                    $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                    _disabledCommonLimitValue($editWrap);
                } else {
                    $editWrap.removeClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 0);
                    $editField.find('.J-limitTipCommonInput').val('');
                    clearCommonLimitValue();
                    _unDisabledCommonLimitValue($editWrap);
                }
                MKGlobal.addUnsaveCount();
            });
            var $limitTipCommonInput = $editField.find('.J-limitTipCommonInput');
            $limitTipCommonInput.off('change input').on('change input', function () {
                var reg = /^[0-9]+$/;
                var $self = $(this);
                commonLimitValue = $.trim($self.val());
                if (commonLimitValue !== '' && !reg.test(commonLimitValue)) {
                    $self.val('').focus();
                    commonLimitValue = '';
                }
                $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                _updateCommonLimitValue($editField);
                MKGlobal.addUnsaveCount();
            });
            $limitTipCommonInput.off('focus').on('focus', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $limitTipCommonCheckbox.trigger('click');
                }
            });
        }

        // 添加统一的限选值
        function _disabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', true);
        }

        function _unDisabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', false);
        }

        function _updateCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.each(function (i, radio) {
                var $radio = $(radio);
                if($radio.hasClass('other_limit')) {
                    $selectedCom.find(".title_field").data('other-limit', commonLimitValue);
                } else {
                    _updateOptionLimit($radio);
                }
                $radio.val(commonLimitValue);
            });
        }

        function _updateOptionLimit($radio) {
            var num = $radio.closest('li').attr('lineNum');
            var $corElem = $selectedCom.find('.picturecheckbox-item[listField="' + num + '"]');
            $corElem.find('.optionValue').data('limit', commonLimitValue);

            selectItemList[num].limit = commonLimitValue;
        }

        function isDisabledByCommonLimit() {
            var isDisabled = '';
            // 判断是否统一限选，来恢复下
            var $editWrap = $editField.find('.J-editWrap');
            if($editWrap.hasClass('limited')) {
                isDisabled = ' disabled ';
            }

            return isDisabled;
        }

        function _updateLimitValue() {

            $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {

                MKGlobal.addUnsaveCount();
                var re = /^[0-9]+$/;
                if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                    alert("限额只能为大于或等于零的整数");
                    $(this).val('');
                    $(this).focus();
                }

                var num = $(this).closest('[lineNum]').attr('lineNum'),
                    $corElem = $selectedCom.find('.picturecheckbox-item[listField="' + num + '"]')
                $corElem.find('.optionValue').data('limit', $(this).val());
                selectItemList[num].limit = $(this).val();

            });

        }

        function _initCommonLimitStatus(isCommonLimit) {
            if(isCommonLimit) {
                $editField.find('.J-editWrap').addClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', true);
                $editField.find('.J-limitTipCommonInput').val(commonLimitValue);

                var $editWrap = $editField.find('.J-editWrap');
                _disabledCommonLimitValue($editWrap);
                _updateCommonLimitValue($editField);
            } else {
                $editField.find('.J-editWrap').removeClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', false);
                $editField.find('.J-limitTipCommonInput').val('');

                var $editWrap = $editField.find('.J-editWrap');
                _unDisabledCommonLimitValue($editWrap);
            }
        }

		function mkBind(){
			var tempListHTML = [];
			selectItemList = [];

			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

                var $titleField = $selectedCom.find('.title_field');
                var titleData = $titleField.data();

                var $isLimit = titleData.limit;
                // 是否统一限选
                var isCommonLimit = titleData.commonLimit || 0;
                commonLimitValue = titleData.commonLimitValue || '';

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

				checkboxName = $selectedCom.find('.piccheckbox_contect input[type="checkbox"]').attr('name'); 
				// 显示编辑项目
				var $items = $selectedCom.find('.picturecheckbox-item').not('.empty');
				if($items.length > 0){
					$items.each(function(){
						var listNum = selectItemList.length,
							tmpVal = $(this).attr('listField', listNum).find('.optionValue').text();
                        var tmpLimit = parseInt($(this).find('.optionValue').data('limit'), 10);
                        if(!(tmpLimit>=0)) tmpLimit = "";

						selectItemList.push({
							img: $(this).find('.picc_img').attr('src')||'',
                            limit: tmpLimit,
							name: tmpVal
						});
						var $imgInfo = $(this).find('.picc_img'),
							__img = '<img src="" alt="" class="choicePicture"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/><span class="upload_btn">上传图片<br/>(限2MB)</span>';
						if($imgInfo.length>0){
							__img = '<img src="'+$imgInfo.attr('src')+'" alt="" class="choicePicture" style="display: inline;"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/><span class="upload_btn" style="display:none">上传图片<br/>(限2MB)</span>';
						}
						tempListHTML.push('<li class="editpicturecheckbox_item" lineNum="' + listNum + '"><input class="editstatus" type="checkbox" name="piccheckbox_' + $selectedCom.attr('id') + '" ' + ($(this).find('input:checkbox').attr('checked')=='checked'? 'checked="checked"' : '') + '><div class="pictextcontect"><div class="imgcontect">'+__img+'</div></div><input type="text" class="imgedittext" value="' + tmpVal + '"><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ tmpLimit +'" placeholder="">个</div><p class="removeButton"></p>');

					});
					tempListHTML[tempListHTML.length-1] += '<p class="addButton"></p></div>';
				}

				tempListHTML = tempListHTML.join('</li>');

				// tempListHTML += '<li class="addPictureCheckbox_item"><div class="add_checkbox_item">+</div></li>';
				$editField.find('.editpiccheckbox_list').empty().append(tempListHTML);

				$selectedCom.unbind('getItemList').bind('getItemList', function (event, list) {
					list.dataInfo = selectItemList;
				});

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                //type_value = (type_value > 0 ) ? type_value : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                //$editField.find('input[value='+type_value+']').attr('checked', 'checked');
                $selectedCom.find('.title_field').data('limit-show-type', type_value);

                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

                _initCommonLimitStatus(isCommonLimit);

				_addLine();
				_editLine();
				_removeLine();

                _updateLimit();
                _updateLimitValue();
			}
		}
		return {
			bind: mkBind,
			getItemList: function(){
				return selectItemList;
			}
		};
	})(),
    //图片单选
	'settingPictureRadioField': (function(){
		var selectItemList = [],
			$editField = $('#form_edit_pic_radioset'),
			$selectedCom, radioName;

        // 每个选项统一限选的个数，全局一个变量控制
        var commonLimitValue = '';

		// check clear
		function _checkClearB(){
			$selectedCom.find('.pictureradio-item').not('.empty').each(function(i){
				if(i%3 === 0){
					$(this).addClass('clearB');
				} else {
					$(this).removeClass('clearB');
				}
			});
		}

		// eventbind
		function _addLine(){
			$editField.find('.addButton').off('click').on('click',function(){
				// add Line ...
				var option = '<li class="pictureradio-item"><div class="picradio_img"></div><div class="picradio_contect"><input type="radio" name="' + radioName + '" value="0" disabled="disabled"><label class="optionValue">选项</label></div></li>',
					listNum = selectItemList.length,
					editTemplate = '<li class="editpictureradio_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="picradio_' + $selectedCom.attr('id') + '"><div class="pictextcontect"><div class="imgcontect"><img src="" alt="" class="choicePicture"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/> <span class="upload_btn">上传图片<br/>(限2MB)</span> </div></div><input type="text" class="imgedittext" value="选项"><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="" placeholder="">个</div><p class="removeButton"></p></div></li>';
				$(option).appendTo($selectedCom.find('.pictureRadioList')).attr('listfield', listNum).find('input:radio').attr({
					'name': radioName,
					'value': listNum,
                    'limit': ''
				});

				var $editLine = $(editTemplate);
				$editField.find('.editpictureradio_item').last().after($editLine);
				// $editLine.find('.edittext').select().focus();
				$editField.find('.addButton').remove();
				$editField.find('.pictextcontect').last().append('<p class="addButton"></p>');
				_checkClearB();
				selectItemList.push({name:'选项',img:'',limit:''});
				MKGlobal.addUnsaveCount();

                var $isLimit = $editField.find('input[name=radio_limit]').prop('checked');

                if($isLimit){
                    // 判断是否统一限选
                    var $editWrap = $editField.find('.J-editWrap');
                    var isCommonLimit = $editWrap.hasClass('limited');
                    if(isCommonLimit) {
                        var $radio = $editField.find('.editpictureradio_item').last().find('.radio_limit');
                        $radio.prop('disabled', true).val(commonLimitValue);
                        _updateOptionLimit($radio);
                    }
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

				// ---
				_removeLine();
				_addLine();
				_editLine();
                _updateLimitValue();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}

		function _removeLine(){
			$editField.find('.removeButton').off('click').on('click',function(){
				// remove 自己
				var $_editField = $(this).closest('.editpictureradio_item'),
					num = parseInt($_editField.attr('lineNum')),
					$corElem = $selectedCom.find('.pictureradio-item[listField="' + $_editField.attr('lineNum') + '"]'),
					$editLine = $editField.find('.editpictureradio_item');
				if ($editLine.length > 1) {
					delete selectItemList[num];
					$corElem.remove();
					$_editField.remove();
					$editField.find('.addButton').remove();
                    $editField.find('.pictextcontect').last().append('<p class="addButton"></p>');
					_checkClearB();
					_addLine();
				} else {
					$_editField.find('.imgedittext').val('选项');
					$_editField.find('.upload_btn').show();
					$_editField.find('.imgcontect img').hide();
					$corElem.find('.optionValue').text('选项');
					$corElem.find('.picc_img').remove();
					$corElem.find('.picradio_img').removeAttr('style');
					selectItemList[num].name = '选项';
					selectItemList[num].img = '';
				}
				MKGlobal.addUnsaveCount();
				$(".formBuilder_edit").getNiceScroll().resize();
			});
		}
        
		function _editLine(){
			// text edit
			$editField.off('keyup.editLine input.editLine').on('keyup.editLine input.editLine', '.imgedittext', function (e){
                MKFORM.__beforeInput(e.target);
                
				var $_editField = $(this).closest('.editpictureradio_item'),
					num = $_editField.attr('lineNum'),
					$corElem = $selectedCom.find('.pictureradio-item[listField="' + num + '"]'),
					value = $.trim($(this).val());
				$corElem.find('.optionValue').text(value);
				selectItemList[num].name = value;
                
				MKGlobal.addUnsaveCount();
				if($_editField.find('.addButton').length > 0){
					// 最后一行， 按回车创建新的一个
					if(e.which == 13){
						$_editField.find('.addButton').trigger('click');
					}
				}
			});
			// status edit
            $editField.off('click.changeStatus').on('click.changeStatus','.editstatus',function (e){
                var $corElem = $selectedCom.find('.pictureradio-item[listField="' + $(this).closest('.editpictureradio_item').attr('lineNum') + '"]');
                if($corElem.find('input:radio').attr('checked') === 'checked'){
                    $selectedCom.find('input:radio').removeAttr('checked');
                    $(this).removeAttr('checked');
                }else{
                    $selectedCom.find('input:radio').removeAttr('checked');
                    $corElem.find('input:radio').attr('checked', 'checked');
                }
                MKGlobal.addUnsaveCount();
            });

			// pic edit
			MKFORM.formUtility.formSelectImgUpload($editField.find('.uploadimg'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/'),
					$this = $(e.target),
					$currentField = $this.closest('.editpictureradio_item');
				$this.siblings('.upload_btn').hide();
				// $this.parent().css('background-color','#FFF');
				$currentField.find('.choicePicture').attr('src', MKFORM.localHost + imgPath).show().error(function () {
					$(this).hide();
					imgPath = '';
					$this.siblings('.upload_btn').show();
					// $this.parent().css('background-color','#E4E3E4');
				});
				// $currentField.find('.upload_shopping_file').attr('imgsrc', ((imgPath) ? (MKFORM.localHost + imgPath) : ''));
				var $imgF = $selectedCom.find('.pictureradio-item[listField="' + $currentField.attr('linenum') + '"]').find('.picradio_img');
				if($imgF.find('.picc_img').length===0){
					$imgF.show().append('<img class="picc_img"/>');
				}
				selectItemList[$currentField.attr('linenum')].img = MKFORM.localHost + imgPath;
				$imgF.find('.picc_img').attr('src', MKFORM.localHost + imgPath);
				MKGlobal.addUnsaveCount();
			});
		}

        function clearCommonLimitValue() {
            commonLimitValue = '';
            $selectedCom.find(".title_field").data('common-limit-value', '');
        }

        function _updateLimit(){
            $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                if($(this).prop('checked')){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }
                $selectedCom.find('.title_field').data('limit', $(this).prop('checked'));
                MKGlobal.addUnsaveCount();
            });
            $editField.find('input[name=formBuilder_edit_radio_limit_tip]').unbind('change').bind('change', function () {
                $selectedCom.find('.title_field').data('limit-show-type', ($(this).prop('checked')?1:0));
                //$selectedCom.find('.title_field').data('limit-show-type', $(this).prop('value'));
                MKGlobal.addUnsaveCount();
            });

            /* 批量填写限选 */
            var $limitTipCommonCheckbox = $editField.find('.J-limitTipCommonCheckbox')
            $limitTipCommonCheckbox.off('change').on('change', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $editWrap.addClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 1);
                    $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                    _disabledCommonLimitValue($editWrap);
                } else {
                    $editWrap.removeClass('limited');
                    $selectedCom.find(".title_field").data('common-limit', 0);
                    $editField.find('.J-limitTipCommonInput').val('');
                    clearCommonLimitValue();
                    _unDisabledCommonLimitValue($editWrap);
                }
                MKGlobal.addUnsaveCount();
            });
            var $limitTipCommonInput = $editField.find('.J-limitTipCommonInput');
            $limitTipCommonInput.off('change input').on('change input', function () {
                var reg = /^[0-9]+$/;
                var $self = $(this);
                commonLimitValue = $.trim($self.val());
                if (commonLimitValue !== '' && !reg.test(commonLimitValue)) {
                    $self.val('').focus();
                    commonLimitValue = '';
                }
                $selectedCom.find(".title_field").data('common-limit-value', commonLimitValue);
                _updateCommonLimitValue($editField);
                MKGlobal.addUnsaveCount();
            });
            $limitTipCommonInput.off('focus').on('focus', function () {
                var $editWrap = $editField.find('.J-editWrap');
                if(!$editWrap.hasClass('limited')) {
                    $limitTipCommonCheckbox.trigger('click');
                }
            });
        }

        // 添加统一的限选值
        function _disabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', true);
        }

        function _unDisabledCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.prop('disabled', false);
        }

        function _updateCommonLimitValue($context) {
            var $radios = $context.find('.radio_limit');
            $radios.each(function (i, radio) {
                var $radio = $(radio);
                if($radio.hasClass('other_limit')) {
                    $selectedCom.find(".title_field").data('other-limit', commonLimitValue);
                } else {
                    _updateOptionLimit($radio);
                }
                $radio.val(commonLimitValue);
            });
        }

        function _updateOptionLimit($radio) {
            var num = $radio.closest('li').attr('lineNum');
            var $corElem = $selectedCom.find('.pictureradio-item[listField="' + num + '"]');
            $corElem.find('.optionValue').data('limit', commonLimitValue);

            selectItemList[num].limit = commonLimitValue;
        }

        function isDisabledByCommonLimit() {
            var isDisabled = '';
            // 判断是否统一限选，来恢复下
            var $editWrap = $editField.find('.J-editWrap');
            if($editWrap.hasClass('limited')) {
                isDisabled = ' disabled ';
            }

            return isDisabled;
        }

        function _updateLimitValue(){

             $editField.find('input.radio_limit').unbind('change').bind('change', function (e) {

                 MKGlobal.addUnsaveCount();
                 var re = /^[0-9]+$/;
                 if ($.trim($(this).val()) != '' && !re.test($(this).val())) {
                     alert("限额只能为大于或等于零的整数");
                     $(this).val('');
                     $(this).focus();
                 }

                 var num = $(this).closest('[lineNum]').attr('lineNum'),
                     $corElem = $selectedCom.find('.pictureradio-item[listField="' + num + '"]')
                 $corElem.find('.optionValue').data('limit', $(this).val());
                 selectItemList[num].limit = $(this).val();

            });

        }

        function _initCommonLimitStatus(isCommonLimit) {
            if(isCommonLimit) {
                $editField.find('.J-editWrap').addClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', true);
                $editField.find('.J-limitTipCommonInput').val(commonLimitValue);

                var $editWrap = $editField.find('.J-editWrap');
                _disabledCommonLimitValue($editWrap);
                _updateCommonLimitValue($editField);
            } else {
                $editField.find('.J-editWrap').removeClass('limited');
                $editField.find('.J-limitTipCommonCheckbox').prop('checked', false);
                $editField.find('.J-limitTipCommonInput').val('');

                var $editWrap = $editField.find('.J-editWrap');
                _unDisabledCommonLimitValue($editWrap);
            }
        }

		function mkBind(){
			var tempListHTML = [];
			selectItemList = [];

			if (MKFORM.currentComponent) {
                $selectedCom = $('#' + MKFORM.currentComponent);

                var $titleField = $selectedCom.find('.title_field');
                var titleData = $titleField.data();

                var $isLimit = titleData.limit;
                // 是否统一限选
                var isCommonLimit = titleData.commonLimit || 0;
                commonLimitValue = titleData.commonLimitValue || '';

                if ($isLimit && $isLimit == 'true' || $isLimit == true){
                    $isLimit = true;
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                } else {
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

				radioName = $selectedCom.find('.picradio_contect input[type="radio"]').attr('name'); 
				// 显示编辑项目
				var $items = $selectedCom.find('.pictureradio-item').not('.empty');
				if($items.length > 0){
					$items.each(function(){
						var listNum = selectItemList.length,
							tmpVal = $(this).attr('listField', listNum).find('.optionValue').text();
                        var tmpLimit = parseInt($(this).find('.optionValue').data('limit'), 10);
                        if(!(tmpLimit>=0)) tmpLimit = "";

						selectItemList.push({
							img: $(this).find('.picc_img').attr('src')||'',
							name: tmpVal,
                            limit: tmpLimit
						});

						var $imgInfo = $(this).find('.picc_img'),
							__img = '<img src="" alt="" class="choicePicture"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/><span class="upload_btn">上传图片<br/>(限2MB)</span>';
						if($imgInfo.length>0){
							__img = '<img src="'+$imgInfo.attr('src')+'" alt="" class="choicePicture" style="display: inline;"><div class="upload_choiceimg"><input type="file" size="1" class="uploadimg" name="_FILE_"/><span class="upload_btn" style="display:none">上传图片<br/>(限2MB)</span>';
						}
						tempListHTML.push('<li class="editpictureradio_item" lineNum="' + listNum + '"><input class="editstatus" type="radio" name="picradio_' + $selectedCom.attr('id') + '" ' + ($(this).find('input:radio').attr('checked')=='checked' ? 'checked="checked"' : '') + '><div class="pictextcontect"><div class="imgcontect">'+__img+'</div></div><input type="text" class="imgedittext" value="' + tmpVal + '"><div class="radio_limit_tip">限选<input type="text" class="radio_limit input" value="'+ tmpLimit +'" placeholder="">个</div><p class="removeButton"></p>');

					});
					tempListHTML[tempListHTML.length-1] += '<p class="addButton"></p></div>';
				}

				tempListHTML = tempListHTML.join('</li>');


				// tempListHTML += '<li class="addPictureRadio_item"><div class="add_radio_item">+</div></li>';
				$editField.find('.editpicradio_list').empty().append(tempListHTML);

				$selectedCom.unbind('getItemList').bind('getItemList', function (event, list) {
					list.dataInfo = selectItemList;
				});

                var $limit_show_type = $selectedCom.find('.title_field').data('limit-show-type'); // Limit show type
                $editField.find('input[name=formBuilder_edit_radio_limit_tip]').removeAttr('checked');
                var type_value = parseInt($limit_show_type);
                type_value = (type_value > 0 ) ? 1 : 0;
                //type_value = (type_value > 0 ) ? type_value : 0;
                if(type_value == 1){
                    $editField.find('input[name=formBuilder_edit_radio_limit_tip]').attr('checked', 'checked');
                }
                //$editField.find('input[value='+type_value+']').attr('checked', 'checked');
                $selectedCom.find('.title_field').data('limit-show-type', type_value);


                if($isLimit){
                    $editField.find(".radio_limit_tip").show();
                }else{
                    $editField.find(".radio_limit_tip").hide();
                }

                _initCommonLimitStatus(isCommonLimit);

				_addLine();
				_editLine();
				_removeLine();

                _updateLimit();
                _updateLimitValue();
			}
		}
		return {
			bind: mkBind,
			getItemList: function(){
				return selectItemList;
			}
		};
	})(),
	'settingPicChooseType': (function () {
		// 这个是选择 选择组件的类型 多选 单选 下拉 互相切换
		// 记得选择完成以后调用重新渲染
		// 记得修改当前的组件的类型
		// 修改后再重新渲染
		var $editField = $('#form_edit_picselecttype'),
			$selectedCom,
			_typeMap = {
				'id_pictureCheckbox': 'piceditsize_checkbox',
				'id_pictureRadio': 'piceditsize_radio'
			},
			_map = {
				'id_pictureCheckbox': 'checkbox',
				'id_pictureRadio': 'radio'
			},
			_comMap = {
				'checkbox': 'id_pictureCheckbox',
				'radio': 'id_pictureRadio'
			};

		function generateHTML(type, id, obj) {
			var _r = '',m = 0;
			if (type === 'checkbox') {
				$.each(obj.dataInfo, function (n, v) {
                    if(typeof(v)==='undefined') return;
					var _img = '';
					if(v.img){
						_img = '<img class="picc_img" src="'+decodeURIComponent(v.img)+'">';
					}
					_r += '<li class="picturecheckbox-item'+((m%3==0)?' clearB':'')+'" listfield="'+n+'"><div class="piccheckbox_img" '+(v.img?'style="display: block;"':'')+'>'+_img+'</div><div class="piccheckbox_contect"><input type="checkbox" name="picturecheckbox'+id+'" value="'+n+'" disabled="disabled"><label class="optionValue" data-limit="'+ v.limit+'">'+v.name+'</label></div></li>';
                    m++;
                });

				_r = '<ul class="pictureCheckboxList">' + _r + '</ul><div class="clearB"></div>';
			} else if (type === 'radio') {
				$.each(obj.dataInfo, function (n, v) {
                    if(typeof(v)==='undefined') return;
					var _img = '';
					if(v.img){
						_img = '<img class="picc_img" src="'+decodeURIComponent(v.img)+'">';
					}
					_r += '<li class="pictureradio-item'+((m%3==0)?' clearB':'')+'" listfield="'+n+'"><div class="picradio_img" '+(v.img?'style="display: block;"':'')+'>'+_img+'</div><div class="picradio_contect"><input type="radio" name="pictureradio'+id+'" value="'+n+'" disabled="disabled"><label class="optionValue" data-limit="'+ v.limit+'">'+v.name+'</label></div></li>';
                    m++;
                });

				_r = '<ul class="pictureRadioList">' + _r + '</ul><div class="clearB"></div>';
			}
			return _r;
		}

		function mkBind() {
			var currentType,
				currentId_Num;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				currentId_Num = $selectedCom.attr('id').replace('com', '');
				currentType = _typeMap[$selectedCom.attr('name')];
				// show current state
				$editField.find('#' + currentType).attr('checked', 'checked');

				$editField.find('input:radio').unbind('change').bind('change', function () {
					// ----
					var selectedType = $(this).val(),
						selectVal = {'dataInfo': [], 'hasOther': false, 'defaultTip':false},
						tmpHTML = '';

					$selectedCom.trigger('getItemList', [selectVal]);

					$selectedCom.find('.picture_' + _map[$selectedCom.attr('name')]).attr('class', 'picture_'+selectedType).html(generateHTML(selectedType, currentId_Num, selectVal));
					$selectedCom.attr('name', _comMap[selectedType]);
					renderFormComponent($selectedCom);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'settingStarNum': (function () {
		var $editField = $('#form_edit_starnum'),
			$selectedCom;

		function mkBind() {
			var starNum;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);

				starNum = $selectedCom.find('.starGroup').find('.star').length;

				$editField.find('option[value="' + starNum + '"]').attr('selected', 'selected');

				$editField.find('select').unbind('change').bind('change', function () {
					var tmpHTML = '';

					for (var i = 0, len = ($(this).val() - 0); i < len; i++) {
						tmpHTML += '<span class="star"></span>';
					}

					$selectedCom.find('.starGroup').empty().append(tmpHTML);
					MKGlobal.addUnsaveCount();
				});
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'settingStarType': (function () {
		// TODO 短期 搞不定啊  -- 需要图片 、 图片有了就什么都有了
	})(),
	'settingFileType': (function(){

		var $editField = $('#form_edit_filetype'),
			$selectedCom;

		function mkBind(){
			var $list = $editField.find('.type_select'),
				typedata = '';
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$list.data('animating',false);
				$editField.find('.type_select_detail_field input').removeAttr('checked');
				typedata = $selectedCom.data('typedata');
				$editField.find('.limit-set-detail').removeAttr('style');
				$('#editlimittype').removeAttr('checked');
				$editField.find('.type_select_expand').removeClass('type_select_expand_to_close').text('展开详细');
				$editField.find('.type_select_detail').removeAttr('style');
				if(typedata){
					$editField.find('.limit-set-detail').show();
					$('#editlimittype').attr('checked','checked');
					$('.detail_name').each(function(i){
						if($.inArray($(this).text(),typedata)>=0){
							$(this).siblings('input').attr('checked','checked');
						}
					});
				}
				selectlistCheck($selectedCom);
				$editField.find('#editlimittype').unbind('click').bind('click',function (e) {
					if($(this).attr('checked')){
						$editField.find('.limit-set-detail').show();
						selectlistCheck($selectedCom);
					} else {
						$editField.find('.limit-set-detail').hide();
						$selectedCom.data('typedata',false);
						$selectedCom.find('.filetype-hint').remove();
						$editField.find('.type_select_detail_field input').removeAttr('checked');
					}
					MKGlobal.addUnsaveCount();
					$('.formBuilder_edit').getNiceScroll().resize();
				});

				$editField.find('.type_select_expand').unbind('click').bind('click',function(e){
					e.stopPropagation();
					if($(this).hasClass('type_select_expand_to_close')){
						$(this).removeClass('type_select_expand_to_close').text('展开详细').parent().siblings('.type_select_detail').hide();
					} else {
						$(this).addClass('type_select_expand_to_close').text('收起').parent().siblings('.type_select_detail').show();
					}
					$('.formBuilder_edit').getNiceScroll().resize();

					return false;
				});

				$editField.find('.type_select_big').unbind('change').bind('change',function (){
					var $typeField = $(this).closest('.type_select_field');
					if($(this).attr('checked')){
						// -- all check
						$typeField.siblings('.type_select_detail').find('.type_select_detail_field input').attr('checked','checked');
					} else {
						$typeField.siblings('.type_select_detail').find('.type_select_detail_field input').removeAttr('checked');
					}
					selectlistCheck($selectedCom);
					MKGlobal.addUnsaveCount();
				});

				$editField.find('.type_select_detail_field input').unbind('change').bind('change',function (){
					// var $typeField = $(this).closest('.type_select_item');
					selectlistCheck($selectedCom);
					MKGlobal.addUnsaveCount();
				});

			}

			function selectlistCheck($ui) {
				var list = [];
				$editField.find('.type_select_item').each(function () {
					var check_detail = [],
						$detailItem = $(this).find('.type_select_detail_item'),
						$desShow = $(this).find('.type_des'),ans = '';

					$detailItem.each(function () {
						var fname = $(this).find('.detail_name').text();
						if ($(this).find('input').attr('checked')) {
							check_detail.push(fname);
							list.push(fname);
						}
					});

					if(check_detail.length === $detailItem.length){
						ans = '全部';
						$(this).find('.type_select_big').attr('checked','checked');
					} else {
						if(check_detail.length>0) {
							ans = '('+check_detail.join(',')+')';
						}
						$(this).find('.type_select_big').removeAttr('checked');
					}

					$desShow.text(ans);

				});


				if(list.length === 0){
					list = false;
					$ui.find('.filetype-hint').remove();
				} else {
					if($ui.find('.filetype-hint').length > 0){
						$ui.find('.filetype-hint').text('支持 '+list.join(', '));
					} else {
						$('<p class="filetype-hint" style="'+MKGlobal.formScheme.instruction+'">支持 '+list.join(', ')+'</p>').insertBefore($ui.find('.upload_file').parent());
					}

				}
				$ui.data('typedata',list);
			}
		}

		return {
			bind: function(){
				mkBind();
			}
		};
	})(),
	'settingPictureLink': (function(){
		// -- return obj
		var $editField = $('#form_edit_picture_link'), // 获取title 对象
			$selectedCom,
			$pictureField;

		// 对当前的组件进行事件的绑定
		function mkBind() {
			var pictureLink;
			if (MKFORM.currentComponent) {
				$selectedCom = $('#' + MKFORM.currentComponent);
				$pictureField = $selectedCom.find('.title_field');
				var link = $pictureField.attr('img-link');
				if(link == 'false'){
					link = '';
				}
				pictureLink = decodeURIComponent(link||'');
				$editField.find('.edit_input').val(pictureLink).unbind('input keyup').bind('input keyup',function () {
                    MKFORM.__beforeInput(this);
                    
					$pictureField.attr('img-link',encodeURIComponent($.trim($(this).val()))); // 回车转义保存
					MKGlobal.addUnsaveCount();
				}).unbind('paste').bind('paste',function(){
						$pictureField.attr('img-link',encodeURIComponent($.trim($(this).val()))); // 回车转义保存
						MKGlobal.addUnsaveCount();
					}).trigger('keyup');
			}
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'settingHoverDelete': (function (){
		var $hoverCom;
		function mkBind(id){
			$hoverCom = $('#' + id);
			if($hoverCom.find('.deleteButton').length < 1){
				$('.deleteButton').each(function(){
					if(!$(this).parent().hasClass('clicked')){
						$(this).remove();
					}
				});
				$hoverCom.prepend('<div class="deleteButton"></div>');

				$hoverCom.find('.deleteButton').unbind('click').bind('click', function () {

					// 2014-10-31 add
					if($.inArray(id,MKFORM.formAnalysisList) >= 0 && !MKFORM.noreminder){
						TINY.box.show({
							html:$(".popwin_toRemoveComponent").html(),
							width: 414,
							height: 178,
							animate:true,
							boxid: 'remove_component',
							close:true,
							openjs: function(){
								var $box = $('#remove_component');
								$box.find(".btn_cancel").click(function(){
									TINY.box.hide();
								});

								if(!MKFORM.removeComponent){
									MKFORM.removeComponent = 1;
								} else {
									MKFORM.removeComponent++;
								}

								if(MKFORM.removeComponent && MKFORM.removeComponent > 2){
									$box.find('.donotcheckbox').attr('id','donotremindme');
								} else {
									$box.find('.donot').remove();
								}

								$('#donotremindme').click(function(){
									var $this = $(this);
									if($this.attr('checked')){
										MKFORM.noreminder = true;
									} else {
										MKFORM.noreminder = false;
									}
								});
								
								$box.find(".btn_confrim").click(function(){
									removeComponent();
									TINY.box.hide();
								});
							}
						});
						return false;
					} else {
						removeComponent();
					}

					function removeComponent(){
						var $componentField = $('.formBuilder_interim_edit').eq(1);
						MKFORM.currentComponent = '';
						$hoverCom.remove();
						// 只有当第3个的时候切回第二栏的组件选择
						if ($('.formBuilder_interim_edit_active').index() === 2) {
							$componentField.trigger('click');
						}

						renderFormComponent();
						var $componentList = $('.form_component').children('.ui-draggable');
						MKFORM.formUtility.formContactCheck($componentList);
						MKFORM.formUtility.formPaymentCheck($componentList);
						MKFORM.formUtility.formLimitedItemCheck($componentList);
						MKFORM.formUtility.formLogicCheck($('.form_component').children('.ui-draggable'));
						MKFORM.formUtility.formStaticFollowCheck($('.form_component').children('.ui-draggable'));
						MKGlobal.addUnsaveCount();
					}

				});
			}
		}


		return {
			bind: function(id){
				mkBind(id);
			}
		};
	})(),
	'settingDeleteSelf': (function () {
		// ---del
		var $selectCom;

		function mkBind() {
			if (MKFORM.currentComponent) {
				$selectCom = $('#' + MKFORM.currentComponent);
				$('.deleteButton').remove();
				$selectCom.prepend('<div class="deleteButton"></div>');
				$selectCom.find('.deleteButton').unbind('click').bind('click', function () {

					// 2014-10-31 add
					if($.inArray(MKFORM.currentComponent,MKFORM.formAnalysisList) >= 0 && !MKFORM.noreminder){
						TINY.box.show({
							html:$(".popwin_toRemoveComponent").html(),
							width: 414,
							height: 178,
							animate:true,
							boxid: 'remove_component',
							close:true,
							openjs: function(){
								var $box = $('#remove_component');
								$box.find(".btn_cancel").click(function(){
									TINY.box.hide();
								});

								if(!MKFORM.removeComponent){
									MKFORM.removeComponent = 1;
								} else {
									MKFORM.removeComponent++;
								}

								if(MKFORM.removeComponent && MKFORM.removeComponent > 2){
									$box.find('.donotcheckbox').attr('id','donotremindme');
								} else {
									$box.find('.donot').remove();
								}

								$('#donotremindme').click(function(){
									var $this = $(this);
									if($this.attr('checked')){
										MKFORM.noreminder = true;
									} else {
										MKFORM.noreminder = false;
									}
								});
								
								$box.find(".btn_confrim").click(function(){
									removeComponent();
									TINY.box.hide();
								});
							}
						});
						return false;
					} else {
						removeComponent();
					}

					function removeComponent(){
						var $componentField = $('.formBuilder_interim_edit').eq(1);
						MKFORM.currentComponent = '';
						$selectCom.remove();
						// 只有当第3个的时候切回第二栏的组件选择
						if ($('.formBuilder_interim_edit_active').index() === 2) {
							$componentField.trigger('click');
						}

						renderFormComponent();
						var $componentList = $('.form_component').children('.ui-draggable');
						MKFORM.formUtility.formContactCheck($componentList);
						MKFORM.formUtility.formPaymentCheck($componentList);
						MKFORM.formUtility.formLimitedItemCheck($componentList);
						MKGlobal.addUnsaveCount();
					}

				});
			}
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),

    'settingPrevPage': (function () {
        var $selectCom,$formTitle,
            $editField = $('#form_edit_prev_page');

        function mkBind() {
            if (MKFORM.currentComponent) {
                $selectCom = $('#' + MKFORM.currentComponent);
                $formTitle = $selectCom.parent().siblings('.form_title');

                var prev_page = $formTitle.attr('prev_page');
                prev_page = typeof(prev_page)==='undefined'? 0: parseInt(prev_page);
                if(prev_page > 0 ){
                    $editField.find('input[name=radio_limit]').attr('checked', 'checked');
                }else{
                    $editField.find('input[name=radio_limit]').removeAttr('checked');
                }

                $editField.find('input[name=radio_limit]').unbind('change').bind('change', function () {
                    var r = $(this).prop('checked')? 1:0;
                    $formTitle.attr('prev_page', r);
                    MKGlobal.formInfo.prevPage = r;
                    MKGlobal.addUnsaveCount();
                });
            }
        }

        return {
            bind: function () {
                mkBind();
            }
        };
    })()

};

MKFORM.formSetting = {
	// 集成了 渲染 、 事件绑定
	'formTitle': (function () {
		var $titleField = $('.formName_input');

		function mkBind() {
			// --
			var $formTitleField = $('.formBuilder_main').find('.title>h2');
			$titleField.val($formTitleField.text().replace(/&nbsp;/g,' ')).unbind('input keyup').bind('input keyup', function () {
                MKFORM.__beforeInput(this);
                
				var oldVal = $.trim($('.form_title').text());
				var currentVal = $(this).val();
                var flag = true;
				//var flag = false;
				//if((oldVal.length === 0 && $.trim(currentVal.length)>0) || (oldVal.length > 0 && $.trim(currentVal).length===0))
				//	flag = true;
				$formTitleField.text(currentVal);
                $formTitleField.html($formTitleField.html().replace(/\s/g,'&nbsp;'));
				
				if(flag){
					MKFORM.formUtility.formSchemeCSSGenerator();
				}
                
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'formSubTitle': (function () {
		var $subtitleField = $('.formInstruct_input');

		function mkBind() {
			var $formSubtitleField = $('.formBuilder_main').find('.title>div');
			$subtitleField.val($formSubtitleField.text().replace(/&nbsp;/g,' ')).unbind('input keyup').bind('input keyup', function () {
                MKFORM.__beforeInput(this);
                
				var oldVal = $.trim($('.form_title').text());
				var currentVal = $(this).val();
				var flag = true;
				//var flag = false;
				//if((oldVal.length === 0 && $.trim(currentVal.length)>0) || (oldVal.length > 0 && $.trim(currentVal).length===0))
				//	flag = true;
				$formSubtitleField.text(currentVal);
                $formSubtitleField.html($formSubtitleField.html().replace(/\s/g,'&nbsp;'));
				
				if(flag){
					MKFORM.formUtility.formSchemeCSSGenerator();
				}

				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'formChangeLogo': (function () {
		function mkBind() {
			var $settingField = $('.sdi_logobackgroundImg'),
				$logofield = $('#face'),
				$trigger = $('#form_changelogo');
			function showImg(){
				if(MKGlobal.formInfo.logoAvailable === true){
					$logofield.attr('src', MKGlobal.formSchemeStruct.logo).show();
					$('.formLogo').show();
					$('.title').addClass('haslogo');
					$logofield.error(function () {
						$('.formLogo').hide();
						$(this).hide();
						$('.title').removeClass('haslogo');
					});
				} else {
					$('.title').removeClass('haslogo');
					$('.formLogo').hide();
					$logofield.hide();
				}
                MKFORM.formUtility.formSchemeCSSGenerator();
			}

			if(MKGlobal.formInfo.formLogo){
				MKGlobal.formInfo.logoAvailable = true;
				MKGlobal.formSchemeStruct.logo = MKGlobal.formInfo.formLogo;
				$settingField.find('.operation').show();
			} else {
				MKGlobal.formInfo.logoAvailable = false;
				$settingField.find('.operation').hide();
			}

			showImg();
			// 回显关键信息
			if(MKGlobal.formInfo.logoAvailable){
				// 如果是可以显示的
				$trigger.attr('checked','checked').parent().addClass('checked');
			}

			$trigger.unbind('change').bind('change',function(){
				var $this = $(this);
				if($this.attr('checked') === 'checked'){
					MKGlobal.formInfo.logoAvailable = true;
					$settingField.find('.operation').show();
				} else {
					MKGlobal.formInfo.logoAvailable = false;
					$settingField.find('.operation').hide();
				}
				showImg();
				MKGlobal.addUnsaveCount();
			});

			// 2.2 上传图片的设置
			MKFORM.formUtility.formImgUpload($settingField.find('.input_file'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/');
				MKGlobal.formSchemeStruct.logo = MKFORM.localHost + imgPath;
				// alert('logo');
				showImg();
				MKGlobal.addUnsaveCount();
			});
		}



		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formChangeTitleBackground': (function () {
		function mkBind() {
			var $settingField = $('.sdi_TitlebackgroundImg'),
				$logofield = $('.form_title'),
				$trigger = $('#form_title_background');
			function showImg(){
				// alert('showimg-title');
				MKFORM.formUtility.formSchemeCSSGenerator();
			}

			if(MKGlobal.formInfo.formTitleBackground !== 'none' && MKGlobal.formInfo.formTitleBackground && (MKGlobal.formInfo.formTitleBackground||"").indexOf('url') >= 0){
				MKGlobal.formInfo.titlebkAvailable = true;
				$settingField.find('.operation').show();
			} else {
				MKGlobal.formInfo.titlebkAvailable = false;
				$settingField.find('.operation').hide();
			}

			// showImg();
			// 回显关键信息
			if(MKGlobal.formInfo.titlebkAvailable){
				// 如果是可以显示的
				$trigger.attr('checked','checked').parent().addClass('checked');
			}

			$trigger.unbind('change').bind('change',function(){
				var $this = $(this);
				if($this.attr('checked') === 'checked'){
					MKGlobal.formInfo.titlebkAvailable = true;
					$settingField.find('.operation').show();
				} else {
					MKGlobal.formInfo.titlebkAvailable = false;
					$settingField.find('.operation').hide();
				}
				showImg();
				MKGlobal.addUnsaveCount();
			});

			// 2.2 上传图片的设置
			MKFORM.formUtility.formImgUpload($settingField.find('.input_file'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/');
				MKGlobal.formSchemeStruct.timg = 'url('+MKFORM.localHost + imgPath+')';
				showImg();
				MKGlobal.addUnsaveCount();
			});
		}



		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formSchemeChange': (function () {
		// 事件的绑定
		var schemeMap = {
			'formBuilder_color_instruction': 'instruction',
			'formBuilder_color_title': 'title',
			'formBuilder_color_wallpaper': 'wallpaper',
			'formBuilder_color_form': 'form',
			'formBuilder_color_highlight': 'highlight'
		};

		function mkBind() {
			$('.formBuilder_color_items').unbind('click').bind('click', function () {
				// ----
				var currentSchemeInfo = $(this).attr('schemeInfo'),
					schemeName = '',
					schemeStyle = '';
				if (currentSchemeInfo !== MKGlobal.preFormSchemeInfo) {
					$('.formBuilder_color_items').removeClass('active_color');
					$(this).addClass('active_color');
					MKGlobal.preFormSchemeInfo = currentSchemeInfo;
				}
				MKFORM.formSetting.formCustomScheme._init($(this));

				MKGlobal.addUnsaveCount();
			});

			$('.removeself_color').unbind('click').bind('click',function(){
				var id = $(this).attr('schemeid');
				$.ajax({
					url: 'handler/handleRemoveFormStyleScheme.php',
					type: 'POST',
					dataType: 'json',
					data: {
						DATA: JSON.stringify({
							"ID" : id
						})
					}
				}).done(function(data){
					if(data.flag){
						getFormScheme();
						$(document).queue('MKFORMEDIT',function(){
							MKFORM.formSetting.formSchemeChange.bind();
						});
						$(document).dequeue('MKFORMEDIT');
					}
				});
				return false;
			});
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'formCustomScheme':(function(){
		var _handle = {
			changeToggle: function(){
				var $this = $(this);
				if(!$this.hasClass('active')){
					$this.addClass('active').siblings('.active').removeClass('active');
				}
			},
			showDesign: function(){
				// 隐藏显示
				var $this = $(this),
					$stylePad = $this.closest('.style_design'),
					$orgPad = $stylePad.siblings('.style_pad'),
					h = 32;

				if(undefined === $this.data('isopen')){
					$this.data('isopen',true);
					(function($ui){
						window.setTimeout(function(){
							$ui.data('isopen',false);
						},12000);
					})($this);
				}

				$this.data('isopen',!$this.data('isopen'));

				var color = 'Blue';
				if(MKGlobal.formType == 2){
					color = 'Orange';
				}
				if($this.data('isopen')){
					h = '62%';
					$('.sdp_save').show();
					$('.sdp_arrow').find('img').attr('src','images/icon/pulldown'+color+'.png');
				} else {
					$('.sdp_save').hide();
					$('.sdp_arrow').find('img').attr('src','images/icon/pullup'+color+'.png');
				}
				// $this.attr('human',true);
				MKGlobal.human = true;

				$stylePad.css({
					height: h
				});
				$orgPad.css({
					bottom: h
				});
				$orgPad.getNiceScroll().resize();
				$stylePad.find('.style_design_item').getNiceScroll().resize();
				window.setTimeout(function(){
					$orgPad.getNiceScroll().resize();
					$stylePad.find('.style_design_item').getNiceScroll().resize();
				},300);
				// $stylePad.stop().animate({
				// 	height: h},
				// 	200, function() {
				// 		$orgPad.getNiceScroll().resize();
				// 		$stylePad.find('.style_design_item').getNiceScroll().resize();
				// });
				// $orgPad.stop().animate({
				// 	bottom: h},
				// 	200, function() {
				// 		$orgPad.getNiceScroll().resize();
				// 		$stylePad.find('.style_design_item').getNiceScroll().resize();
				// });
			},
			font_colorBind: function(hsb, hex, rgb, el, fromSetColor){
				var $el = $(el),
					$colorPad = $el.find('.in_color'),
					type = $el.attr('gt');
				$colorPad.css('color','#'+hex);
				if(type === 'ft'){
					MKGlobal.formSchemeStruct['ht'] = hex;
				}
				MKGlobal.formSchemeStruct[type] = hex;
				MKFORM.formUtility.formSchemeCSSGenerator();
				MKGlobal.addUnsaveCount();
			},
			background_colorBind: function(hsb, hex, rgb, el, fromSetColor){
				var $el = $(el),
					$colorPad = $el.find('.in_color'),
					type = $el.attr('gt'),
					colorObj,brighten,black;
				$colorPad.css('backgroundColor','#'+hex);
				if(type === 'fb'){
					colorObj = mgColorManager.getColorVal(hex);

					brighten = colorObj.S / 100;
					black = colorObj.V / 100;
	
					if(colorObj.GY>180 && colorObj.GY<254.8){
						// darken
						MKGlobal.formSchemeStruct['hb'] = mgColorManager.getHSV2RGB([colorObj.H, ((brighten + 0.07 < 1) ? brighten + 0.07 : 1), (black - 0.16 > 0 ? (black - 0.16) : 0)]);
					} else if(colorObj.GY>254.8){
						// gray
						MKGlobal.formSchemeStruct['hb'] = 'FFF8DC';
					} else if(colorObj.GY<22 && colorObj.GY>0){
						// HSV fix
						MKGlobal.formSchemeStruct['hb'] = mgColorManager.getHSV2RGB([colorObj.H,(brighten - 0.08 > 0 ? brighten - 0.08 : 0), ((black - 0) + 0.24 < 1 ? (black - 0) + 0.24 : 1)]);
					} else {
						// lighter
						MKGlobal.formSchemeStruct['hb'] = mgColorManager.getHSV2RGB([colorObj.H,(brighten - 0.08 > 0 ? brighten - 0.08 : 0), ((black - 0) + 0.14 < 1 ? (black - 0) + 0.14 : 1)]);
					}
				}
				MKGlobal.formSchemeStruct[type] = hex;
				MKGlobal.addUnsaveCount();
				MKFORM.formUtility.formSchemeCSSGenerator();
			},
			changeSize: function(){
				var $this = $(this);

				// if(!$this.hasClass('active')){
					// $this.addClass('active').siblings('.active').removeClass('active');
					MKGlobal.formSchemeStruct.fw = $this.attr('chose-info');
					MKGlobal.addUnsaveCount();
				// }
			},
			changeFontSize: function(){
				var $this = $(this);
				MKGlobal.formSchemeStruct.fs = $this.attr('chose-info');
				MKFORM.formUtility.formSchemeCSSGenerator();
				/* 如果有商品组件，重新初始化排版 */
				_handle.shoppingHeightChange();

				MKGlobal.addUnsaveCount();
			},
			/* 如果有商品组件，重新初始化排版 */
			shoppingHeightChange: function () {
				function _loadImage($list, count, $picItem, cb) {
					var totalCount = $picItem.length;
					$picItem.find('img').on('load', function () {
						if(count++ === totalCount) {
							cb();
						}
					}); 
				}

				function _recalculate($items) {
					// 1. 找到现在总共的商品个数
					if($items && $items.length > 0) {
						var maxHeightArray = _findEveryLineMaxHeight($items);
						
						var total = $items.length;
						var line = Math.ceil(total / 3);
						var startIndex = 0;
						var endIndex = 0;

						for(var i = 0; i <= line; ++i) {
							startIndex = i * 3;
							endIndex = startIndex + 3;
							for(var j = startIndex; j < endIndex; ++j) {
								var $item = $items.eq(j);
								if($item && $item.length === 0) {
									break;
								}
								$item.removeAttr('style');
								$item.height(maxHeightArray[i]);
							}
						}
					}
				}

				function _findEveryLineMaxHeight($items) {
					var heightArray = [];
					var maxHeightArray = [];
					var total = $items.length;
					var line = Math.ceil(total / 3);

					var startIndex = 0;
					var endIndex = 0;
					for(var i = 0; i <= line; ++i) {
						startIndex = i * 3;
						endIndex = startIndex + 3;
						for(var j = startIndex; j < endIndex; ++j) {
							var $item = $items.eq(j);
							if($item && $item.length === 0) {
								break;
							}
							$item.removeAttr('style');
							var h = $item.outerHeight();
							heightArray.push(h);
						}
						maxHeightArray.push(Math.max.apply(null, heightArray));
						heightArray = [];
					}

					return maxHeightArray;
				}

				var $main = $('.formBuilder_main');
				var $shoppings = $main.find('[name="id_shopping"]');
				if($shoppings && $shoppings.length > 0) {
					var $list = $shoppings.find('.shoppingList');
					$list.each(function (i, el) {
						var $el = $(el);
						var $items = $el.find('.shopping-item').not('.empty');
						_recalculate($items);
					});
				}
			},
			changeLineHeight: function(){
				var $this = $(this);
					MKGlobal.formSchemeStruct.flh = $this.attr('chose-info');
					MKFORM.formUtility.formSchemeCSSGenerator();
					MKGlobal.addUnsaveCount();
			},
			saveScheme: function(e){
				if(e||e.stopPropagation){
					e.stopPropagation();
				}
				var $this = $(this),
					$savePad = $this.closest('.sdi_save_btn'),
					$infoPad = $savePad.siblings('.sdi_saveinfo_input'),
					$designField = $savePad.closest('.style_design_item');

				TINY.box.show({
					html:$(".popwin_scheme").html(),
					width: 414,
					height: 238,
					animate:true,
					boxid: 'save_scheme',
					close:true,
					openjs: function(){

						function __selfCssGener(){
							var styleList = ['fw','fs','flh','wb','wt','img','imgp','imgr','imgf','lb','lt','logo','timg','fb','ft','it','hb','ht'],
								defaultsValue = ['750px', '16px', '25px', 'F4F5F0', '333333', '', 'left', '', '', 'FEFEFE', '222222', '', '', 'FFFFFF', '333333','333333', 'FFF8DC', '333333'],
								ans = [],
								needSave = $.extend(true, {}, MKGlobal.formSchemeStruct);
							if(!MKGlobal.formInfo.backgroundAvailable){
								needSave.img = '';
								needSave.imgp = '';
								needSave.imgr = '';
								needSave.imgf = '';
							} else {
								needSave.img = MKGlobal.formInfo.background;
								needSave.imgr = MKGlobal.formInfo.backgroundtype;
							}
							if(!MKGlobal.formInfo.logoAvailable){
								needSave.logo = '';
							}
							if(!MKGlobal.formInfo.titlebkAvailable){
								needSave.timg = '';
							}
							for(var i=0,len = styleList.length; i<len; i++){
								ans[i] = needSave[styleList[i]]||defaultsValue[i];
							}

							return ans.join(',');
						}

						var $box = $('#save_scheme'),
							res = __selfCssGener();

						$box.find(".btn_cancel").click(function(){
							TINY.box.hide();
						});

						$box.find(".btn_confrim").unbind('click').click(function(){
							if( MKGlobal.preFormSchemeInfo !== res){
								$.ajax({
									url: 'handler/handleAddFormStyleScheme.php',
									type: 'POST',
									dataType: 'json',
									data: {
										DATA: JSON.stringify({
											NAME: $box.find('.schemename').val(),
											CSS: res
										})
									}
								}).done(function(data){
									if(data.flag){
										getFormScheme();
										$(document).queue('MKFORMEDIT',function(){
											MKFORM.formSetting.formSchemeChange.bind();
										});
										$(document).dequeue('MKFORMEDIT');
										TINY.box.hide();
									}
								});
							} else {
								TINY.box.hide();
							}
						});
					}
				});
			}
		};

		function mkBind(){
			var $styleDesign = $('.style_design'),
				$styleDesignPad = $styleDesign.find('.style_design_pad'),
				$styleSave = $styleDesign.find('.sdp_save'),
				$wb = $styleDesign.find('.sdi_backgroundcolor'),
				$tb = $styleDesign.find('.sdi_titlebackgroundcolor'),
				$ft = $styleDesign.find('.sdi_mainfontcolor'),
				$fb = $styleDesign.find('.sdi_mainbackgroundcolor'),
				$tt = $styleDesign.find('.sdi_titlefontcolor'),
				$it = $styleDesign.find('.sdi_desfontcolor');

			$styleDesignPad.data('isopen',false);

			if(MKGlobal.fb !== '0' && MKGlobal.fb !== '1'){
                //注释掉是这样的话在创建表单后，并没有MKGlobal.fb这个变量，这样子无论如何设置表单宽度，最后都会变成普通
				//MKGlobal.formSchemeStruct.fw = '640px';
			}

			$styleDesignPad.off('click.showDesign').on('click.showDesign',_handle.showDesign);
			$styleDesign.find('.stateBtn').off('click.changeToggle').on('click.changeToggle',_handle.changeToggle);
			$styleSave.off('click.save').on('click.save',_handle.saveScheme);

			MKFORM.formSetting.formCustomScheme._init($('.formBuilder_color_outer').find('.active_color'),true);

			MKFORM.formUtility.formColorPicker($wb,_handle.background_colorBind);
			MKFORM.formUtility.formColorPicker($tb,_handle.background_colorBind);
			MKFORM.formUtility.formColorPicker($ft,_handle.font_colorBind);
			MKFORM.formUtility.formColorPicker($fb,_handle.background_colorBind);
			MKFORM.formUtility.formColorPicker($tt,_handle.font_colorBind);
			MKFORM.formUtility.formColorPicker($it,_handle.font_colorBind);

			MKFORM.formSetting.formCustomScheme._init($('.formBuilder_color_outer').find('.active_color'),true);

			$styleDesign.find('.sdi_formwidth').find('.stateBtn').unbind('click.changeStyle').bind('click.changeStyle',_handle.changeSize);
			$styleDesign.find('.sdi_formfontsize').find('.stateBtn').unbind('click.changeStyle').bind('click.changeStyle',_handle.changeFontSize);
			$styleDesign.find('.sdi_formlineheight').find('.stateBtn').unbind('click.changeStyle').bind('click.changeStyle',_handle.changeLineHeight);
		}

		function styleInit($ui,silent){
			var $defaultStyle = $('.style_pad'),
			$styleDesign = $('.style_design'),
			$designItem = $styleDesign.find('.style_design_item');

			// 显示
			if(!silent){
				if(!MKGlobal.human){
					
					$defaultStyle.css({
						bottom: '62%'
					});
					$styleDesign.css({
						height: '62%'
					});
					$designItem.show();
					$defaultStyle.getNiceScroll().resize();
					$designItem.getNiceScroll().resize();
					window.setTimeout(function(){
						$defaultStyle.getNiceScroll().resize();
						$designItem.getNiceScroll().resize();
					},300);
					$('.style_design_pad').data('isopen',true);
					$('.sdp_save').show();
					$('.sdp_arrow').find('img').attr('src','images/icon/pulldownBlue.png');
				}
			} else {
				$designItem.show();
				$designItem.getNiceScroll().resize();
			}

			if($ui.length>0){
				var tmpO = parseFormScheme($ui.attr('schemeinfo'));
				if(MKGlobal.formSchemeStruct.img){
					tmpO.img = MKGlobal.formSchemeStruct.img;
				}
				if(MKGlobal.formSchemeStruct.timg){
					tmpO.timg = MKGlobal.formSchemeStruct.timg;
				}
				if(MKGlobal.formSchemeStruct.logo){
					tmpO.logo = MKGlobal.formSchemeStruct.logo;
				}

				MKGlobal.formSchemeStruct = tmpO;
				MKFORM.formUtility.formSchemeCSSGenerator();
			} else {
				if(!MKGlobal.preFormSchemeInfo){
					MKGlobal.formSchemeStruct.wb = 'F4F5F0';
					MKGlobal.formSchemeStruct.wt = '333333';
					MKGlobal.formSchemeStruct.lb = 'FEFEFE';
					MKGlobal.formSchemeStruct.lt = '222222';
					MKGlobal.formSchemeStruct.fb = 'FFFFFF';
					MKGlobal.formSchemeStruct.ft = '333333';
					MKGlobal.formSchemeStruct.it = '333333';
					MKGlobal.formSchemeStruct.hb = 'FFF8DC';
					MKGlobal.formSchemeStruct.ht = '333333';
				}
			}

			// 将 配色方案中的图片信息同步到目前这张表单上去
			if(MKGlobal.formSchemeStruct.img){
				if(MKGlobal.formInfo.background === 'none' || !MKGlobal.formInfo.background){
					MKGlobal.formInfo.background = MKGlobal.formSchemeStruct.img;
				}
			}
			if(MKGlobal.formSchemeStruct.logo){
				if(MKGlobal.formInfo.formLogo === 'none' || !MKGlobal.formInfo.formLogo){
					MKGlobal.formInfo.formLogo = MKGlobal.formSchemeStruct.logo;
				}
			}
			if(MKGlobal.formSchemeStruct.timg){
				if(MKGlobal.formInfo.formTitleBackground === 'none' || !MKGlobal.formInfo.formTitleBackground){
					MKGlobal.formInfo.formTitleBackground = MKGlobal.formSchemeStruct.logo;
				}
			}
			
			// 设置初始值
			$styleDesign.find('.sdi_backgroundcolor').colpickSetColor(MKGlobal.formSchemeStruct.wb).find('.in_color').attr('style','background-color:#'+MKGlobal.formSchemeStruct.wb);
			$styleDesign.find('.sdi_titlebackgroundcolor').colpickSetColor(MKGlobal.formSchemeStruct.lb).find('.in_color').attr('style','background-color:#'+MKGlobal.formSchemeStruct.lb);
			$styleDesign.find('.sdi_mainfontcolor').colpickSetColor(MKGlobal.formSchemeStruct.ft).find('.in_color').attr('style','color:#'+MKGlobal.formSchemeStruct.ft+';');
			$styleDesign.find('.sdi_mainbackgroundcolor').colpickSetColor(MKGlobal.formSchemeStruct.fb).find('.in_color').attr('style','background-color:#'+MKGlobal.formSchemeStruct.fb);
			$styleDesign.find('.sdi_titlefontcolor').colpickSetColor(MKGlobal.formSchemeStruct.lt).find('.in_color').attr('style','color:#'+MKGlobal.formSchemeStruct.lt+';');
			$styleDesign.find('.sdi_desfontcolor').colpickSetColor(MKGlobal.formSchemeStruct.it).find('.in_color').attr('style','color:#'+MKGlobal.formSchemeStruct.it+';');

			// init 图片的对齐部分
			var $bkp = $styleDesign.find('.sdi_backgroundImg'),
				$fw = $styleDesign.find('.sdi_formwidth'),
				$fs = $styleDesign.find('.sdi_formfontsize'),
				$flh = $styleDesign.find('.sdi_formlineheight');

			$bkp.find('.active').removeClass('active');
			$bkp.find('.stateBtn[chose-info="'+MKGlobal.formSchemeStruct.imgp.toLowerCase()+'"]').addClass('active');
			$fw.find('.active').removeClass('active');
			$fw.find('.stateBtn[chose-info="'+MKGlobal.formSchemeStruct.fw.toLowerCase()+'"]').addClass('active');
			$fs.find('.active').removeClass('active');
			$fs.find('.stateBtn[chose-info="'+MKGlobal.formSchemeStruct.fs.toLowerCase()+'"]').addClass('active');
			$flh.find('.active').removeClass('active');
			$flh.find('.stateBtn[chose-info="'+MKGlobal.formSchemeStruct.flh.toLowerCase()+'"]').addClass('active');

		}

		return {
			bind: mkBind,
			_init: styleInit,
			showDesign: _handle.showDesign
		};
	})(),
	'formStartTime': (function () {
		// -- start time;
		function mkBind() {
			var $startButton = $('#startFormSetting'),
				$startField;
			// set Val;
			if (MKGlobal.formInfo.formControl.startDate) {
				$startButton.attr('checked', 'checked');
				$startField = $startButton.parent().addClass('checked').siblings('.formStart_field').show();
				$startField.find('#form_startTime input').val(MKGlobal.formInfo.formControl.startDate.substring(16, 0));
			}

			// date picker bind ...
			$('#form_startTime').datetimepicker({
				language: 'zh-CN',
				pickSeconds: false
			}).on('changeDate', function () {
					var startDateStr = $(this).find("input").val().replace(/-/g, "/") + ':00',
						endDateStr = '',
						selectedDate = new Date(startDateStr),
						currentDate = new Date();

					if ($(".formEndTime_field").css('display') != 'none') {
						endDateStr = $("#form_endTime").find("input").val();
					}

					if (selectedDate < currentDate) {
						$(this).parent().siblings(".formStartError").css("visibility", "visible").text("启用表单的时间不能早于当前时间哦~~").data('currenttype', 'BCT'); // before current time
					} else if (endDateStr != "" && selectedDate > new Date(endDateStr)) {
						$(this).parent().siblings(".formStartError").css("visibility", "visible").text("启用表单的时间需早于停用表单的时间哦~~").data('currenttype', 'NBET'); // need before end time
					} else {
						$(this).parent().siblings(".formStartError").css("visibility", "hidden").data('currenttype', null);
						if ($(this).closest('.formBuilder_timeSetting').find(".formEndError").data('currenttype') == 'NLST') {
							$(this).closest('.formBuilder_timeSetting').find(".formEndError").css("visibility", "hidden").data('currenttype', null);
						}
					}
					MKGlobal.addUnsaveCount();
				});

			$startButton.unbind('change').bind('change', function () {
				if ($(this).attr("checked") != "checked") {
					$(this).parent().siblings(".formStart_field").hide();
				} else {
					$(this).parent().siblings(".formStart_field").show();
				}
				$(".formStart_field #form_startTime").find("input").val("");
				$(".formStart_field").find(".formStartError").css("visibility","hidden");
				if ($(".formEndTime_field").find(".formEndError").text() == "停用表单的时间需晚于启用表单的时间哦~~") {
					$(".formEndTime_field").find(".formEndError").css("visibility","hidden");
				}
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formEndTime': (function () {
		// ---
		function mkBind() {
			var $endButton = $('#endFormSetting'),
				$endField;
			// set Val;
			if (MKGlobal.formInfo.formControl.stopDate) {
				$endButton.attr('checked', 'checked');
				$endField = $endButton.parent().addClass('checked').siblings('.formEndTime_field').show();
				$endField.find('#form_endTime input').val(MKGlobal.formInfo.formControl.stopDate.substring(16, 0));
			}

			// date picker bind ...
			$('#form_endTime').datetimepicker({
				language: 'zh-CN',
				pickSeconds: false
			}).on('changeDate', function () {
					var startDateStr = '',
						endDateStr = $(this).find("input").val().replace(/-/g, "/") + ':00',
						selectedDate = new Date(endDateStr),
						currentDate = new Date();

					if ($(".formStart_field").css('display') != 'none') {
						startDateStr = $("#form_startTime").find("input").val();
					}

					if (selectedDate < currentDate) {
						$(this).parent().siblings(".formEndError").css("visibility", "visible").text("停用表单的时间不能早于当前时间哦~~").data('currenttype', 'BCT');
					} else if (startDateStr != "" && selectedDate <= new Date(startDateStr)) {
						$(this).parent().siblings(".formEndError").css("visibility", "visible").text("停用表单的时间需晚于启用表单的时间哦~~").data('currenttype', 'NLST'); // need late than start time
					} else {
						if ($(this).closest('.formBuilder_timeSetting').find(".formStartError").data('currenttype') == 'NBET') {
							$(this).closest('.formBuilder_timeSetting').find(".formStartError").css("visibility", "hidden").data('currenttype', null);
						}
						$(this).parent().siblings(".formEndError").css("visibility", "hidden").data('currenttype', null);
					}
					MKGlobal.addUnsaveCount();
				});


			$endButton.unbind('change').bind('change', function () {
				if ($(this).attr("checked") != "checked") {
					$(this).parent().siblings(".formEndTime_field").hide();
				} else {
					$(this).parent().siblings(".formEndTime_field").show();
				}
				$(".formEndTime_field #form_endTime").find("input").val("");
				$(".formEndTime_field").find(".formEndError").css("visibility","hidden");
				if ($(".formStart_field").find(".formStartError").text() == "启用表单的时间需早于停用表单的时间哦~~") {
					$(".formStart_field").find(".formStartError").css("visibility","hidden");
				}
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formSetMaxiumFeedback': (function () {
		function mkBind() {
			var $endMaxButton = $('#endFormMax'),
				$endField;
			// set Val;
			if (MKGlobal.formInfo.formControl.maxFeedback) {
				$endMaxButton.attr('checked', 'checked');
				$endField = $endMaxButton.parent().addClass('checked').siblings('.formEndMax_field').show();
				$endField.find('.formEnd_feedbackNum input').val(MKGlobal.formInfo.formControl.maxFeedback);
			}

			$(".formEnd_feedbackNum").find(".feedbackNum").bind("change",function(){
				var feedbackNum = $(this).val();
				var currentNum = $(this).parent().siblings(".current_feedbackNum").find("span").text();
				if ( feedbackNum != "" && parseInt(feedbackNum) < parseInt(currentNum)) {
					$(this).parent().siblings(".formEndMaxError").css("visibility","visible").text("停用表单时的反馈数不能少于当前的反馈数哦~~");
				}else{
					$(this).parent().siblings(".formEndMaxError").css("visibility","hidden");
				}
			});

			$(".formEndMax_field .current_feedbackNum").find("span").text(MKGlobal.formInfo.feedbackNum);
			$endMaxButton.unbind('change').bind('change', function () {
				if ($(this).attr("checked") != "checked") {
					$(this).parent().siblings(".formEndMax_field").hide();
				} else {
					$(this).parent().siblings(".formEndMax_field").show();
				}
				MKGlobal.addUnsaveCount();
				$(".formEndMax_field .formEnd_feedbackNum").find("input").val("");
				$(".formEndMax_field").find(".formEndMaxError").css("visibility","hidden");
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formShowShare': (function(){
		
		function mkBind() {
			var $shareShowBtn = $('#showShareButton');
			// set value
			if (MKGlobal.formInfo.formShare === true) {
				$shareShowBtn.attr('checked', 'checked');
				$shareShowBtn.parent().addClass('checked');
			}

			$shareShowBtn.unbind('change').bind('change', function () {
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formEndSeeRes': (function(){
		// 提交后查看统计
		function mkBind() {
			var $endFormSubmitSawRes = $('#endFormSubmitSawRes');
			// set value
			if (MKGlobal.formInfo.formRes === true) {
				$endFormSubmitSawRes.attr('checked', 'checked');
				$endFormSubmitSawRes.parent().addClass('checked');
			}

			$endFormSubmitSawRes.unbind('change').bind('change', function () {
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),

	'formEndSeeResDetail': (function(){
		// 提交后查看统计
		function mkBind() {
			var $endFormSubmitSawResDetail = $('#endFormSubmitSawResDetail');
            var $feedbackOpenPassword = $("#formFeedbackOpenPasswd");
			// set value

			if (MKGlobal.formInfo.formResDetail === true) {
				$endFormSubmitSawResDetail.attr('checked', 'checked');
				$endFormSubmitSawResDetail.parent().addClass('checked');
                $feedbackOpenPassword.show();
			}

			$endFormSubmitSawResDetail.unbind('change').bind('change', function () {
				MKGlobal.addUnsaveCount();
                    //console.log($endFormSubmitSawResDetail.prop('checked'));
                if ($endFormSubmitSawResDetail.prop('checked') === true) {
                    $feedbackOpenPassword.show();
                }else{
                    $feedbackOpenPassword.hide();
                }

			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
    'formFeedbackDetailPasswd': (function(){
        // 提交后查看统计密码
        function mkBind() {
            var $feedbackOpenPassword = $(".feedback_open_password");

            $feedbackOpenPassword.val(MKGlobal.formInfo.feedbackDetailPassword);

            $feedbackOpenPassword.unbind('change').bind('change', function () {
                MKGlobal.addUnsaveCount();
            });
        }

        return {
            bind: function () {
                return mkBind();
            }
        };
    })(),
	'formEndGeneRan': (function(){
		// 提交后生成随机码
		function mkBind() {
			var $endFormSubmitGeneRan = $('#endFormRandomCode');
			// set value
			if (MKGlobal.formInfo.formRandomCode === true) {
				$endFormSubmitGeneRan.attr('checked', 'checked');
				$endFormSubmitGeneRan.parent().addClass('checked');
			}

			$endFormSubmitGeneRan.unbind('change').bind('change', function () {
				var $afterOpenlink = $('.aftersubmit').find('input:radio[value="openlink"]');
				if ($endFormSubmitGeneRan.prop('checked')) {
					if ($afterOpenlink.prop('checked')) {
						$('.randomCode_tips').show();
					}
					$('.aftersubmit').find('input:radio[value="showtext"]').attr('checked','checked');
					$afterOpenlink.attr('disabled','disabled');
					setTimeout("$('.randomCode_tips').hide();",3000);
				}else{
					$afterOpenlink.removeAttr('disabled');
				}
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formSetUnique': (function () {
		function mkBind() {
			var $uniqueButton = $('#endFormSubmitOnce');
			// set value
			if (MKGlobal.formInfo.formSubmitOnce === 1) {
				$uniqueButton.attr('checked', 'checked');
				$uniqueButton.parent().addClass('checked');
			}

			$uniqueButton.unbind('change').bind('change', function () {
				var $onlyWechat = $('#openFormOnlyByWeixin');
				if ($uniqueButton.prop('checked')) {
					if (!$onlyWechat.prop('checked')) {
						$('.submitOnce_tips').show();
						setTimeout("$('.submitOnce_tips').hide();",3000);
					}
				}
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formOnlyWechat': (function () {
		function mkBind() {
			var $onlyWechatButton = $('#openFormOnlyByWeixin');
			if (MKGlobal.formInfo.onlyWechat === 1) {
				$onlyWechatButton.attr('checked', 'checked');
				$onlyWechatButton.parent().addClass('checked');
			}

			$onlyWechatButton.unbind('change').bind('change', function () {
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formSetPayment': (function () {
		function mkBind() {
			var $alipayBtn = $('#payment_ali'),
                $paymentOnly = $('input[name="formBuilder_edit_noticePaySetting"]'),
                payOnlySet = function(formPaymentOnly){
                    $paymentOnly.removeAttr('checked');
                    switch(formPaymentOnly){
                        case 'ONLY':
                            $paymentOnly.filter('input[value="only"]').attr('checked', 'checked');
                            break;
                        case 'BOTH':
                        case '':
                            $paymentOnly.filter('input[value="both"]').attr('checked', 'checked');
                            break;
                        case 'NO':
                        default:
                            break;
                    }
                },
                editFileShow = function(show){
                    if(show==='normal'){
                        $('.formNoticePaySetting').show();
                        $('.formNoticePaySetting_radio').show();
                    }else
                    if(show==='payneed'){
                        $('.formNoticePaySetting').hide();
                        $('.formNoticePaySetting_radio').hide();
                    }else{
                        $('.formNoticePaySetting').show();
                        $('.formNoticePaySetting_radio').show();
                    }
                };
			if ($.inArray('ALIPAY', MKGlobal.formInfo.formPaymentInfo) < 0) {
				$alipayBtn.removeAttr('checked').parent().removeClass('checked');
                editFileShow('payneed');
                payOnlySet('off');
			} else {
				$alipayBtn.attr('checked','checked').parent().addClass('checked');
                editFileShow('normal');
                payOnlySet(MKGlobal.formInfo.formPaymentOnly);
			}
			$alipayBtn.unbind('change').bind('change', function () {
                if($(this).attr('checked') == 'checked'){
                    editFileShow('normal');
                    payOnlySet(MKGlobal.formInfo.formPaymentOnly);
                }else{
                    editFileShow('payneed');
                    payOnlySet('off');
                }
				MKGlobal.addUnsaveCount();
			});
            $paymentOnly.unbind('change').bind('change', function (e) {
                e.stopPropagation();
                var $this = $(this);

                if($this.attr('checked')=='checked'){
                    editFileShow('normal');
                }
                //$this.data('mkselected', 0);
				MKGlobal.addUnsaveCount();
			});
            //$paymentOnly.unbind('click').bind('click', function () {
             //   var $this = $(this);
             //   var radioCheck= $this.data('mkselected');
             //   if(1==radioCheck){
             //       $this.removeAttr('checked');
             //       $this.data('mkselected', 0);
             //       editFileShow(false);
             //   }else{
             //       $this.data('mkselected', 1);
             //   }
            //
             //   MKGlobal.addUnsaveCount();
			//});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formAfterSubmit': (function () {
		// get current type ...
		var afterSubmitType, afterSubmitValue,
			typeMap = ['showtext', 'openlink'];

		function mkBind() {
			var $block = $('.aftersubmit');
			afterSubmitType = $('.form_title').attr('type');
			afterSubmitValue = $('.form_title').attr('finishform');
			$block.find('input:radio').removeAttr('checked');
			$block.find('input:radio[value="' + typeMap[parseInt(afterSubmitType, 0)] + '"]').attr('checked', 'checked');
			$block.find('.formBuilder_edit_input').val(afterSubmitValue);
			if (MKGlobal.formInfo.formRandomCode == true) {
				$('.aftersubmit').find('input:radio[value="openlink"]').attr('disabled','disabled');
			}

			$block.find('input:radio').unbind('change').bind('change', function () {
				$block.find('input:radio').removeAttr('checked');
				$(this).attr('checked', 'checked');
				$('.form_title').attr('type', $.inArray($(this).val(), typeMap));
				MKGlobal.addUnsaveCount();
			});

			$block.find('.formBuilder_edit_input').unbind('input keyup').bind('input keyup', function () {
                MKFORM.__beforeInput(this);
                
				$('.form_title').attr('finishform', $(this).val());
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				mkBind();
			}
		};
	})(),
	'formFeedbackNotice': (function () {
		function mkBind() {
			// set Value
			// var emailinfo = send_mail_to_Email,
			// 	nameinfo = send_mail_to_Name,
			// 	$emailField = $('.feedback_email'),
			// 	$sendButton = $('#autoSendMail');

			// if (MKGlobal.formInfo.sendMailInfo.email) {
			// 	emailinfo = MKGlobal.formInfo.sendMailInfo.email;
			// }
			// if (MKGlobal.formInfo.sendMailInfo.name) {
			// 	nameinfo = MKGlobal.formInfo.sendMailInfo.name;
			// }

			// $.ajax({
			// 	url: 'handler/handleGetAllAccountByClient.php',
			// 	type: 'POST',
			// 	dataType: 'json'
			// })
			// .done(function (res) {
			// 	var options = '',
			// 		selected = '',
			// 		emailList = emailinfo.split(';');
			// 	if(res.flag){
			// 		for(var i in res.data){
			// 			selected = '';
			// 			if($.inArray(res.data[i], emailList) >= 0){
			// 				selected = 'selected="selected"';
			// 			}
			// 			options += "<option value='"+i+"' "+selected+">" + res.data[i] + "</option>";
			// 		}

			// 		$emailField.data('infoofemaillist',res.data).append(options);
			// 		$emailField.width($('.formName_input').width()).chosen();
			// 	}
			// });

			// $emailField.change(function(){
			// 	MKGlobal.addUnsaveCount();
			// });
			

			// $('.feedback_name').val(nameinfo).unbind('keyup').bind('keyup',function(){
			// 	MKGlobal.addUnsaveCount();
			// });
			var emailinfo = send_mail_to_Email,
				emailArray = emailinfo.split(';'),
				nameinfo = send_mail_to_Name,
				emailState = send_mail_to_state,
				$emailField = $('.feedback_email'),
				$sendButton = $('#autoSendMail'),
                $web_hook_set = $('.formBuilder_web_hook_set'),
				sIndex = -1;

			$emailField.mikeTag({
				'tagClass': 'MGTAG-i',
				'defaultText': '',
				'maxNo': 10,
				'RegEx': /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))$/i,
				'onRemove': function(){
					var email = this.find('span').attr('fullvalue'),index = $.inArray(email,emailArray);
					if ( index != -1) {
						emailArray.splice(index,1);
					}
				}
			});

			if (MKGlobal.formInfo.sendMailInfo.email) {
				emailinfo = MKGlobal.formInfo.sendMailInfo.email;
				emailArray = emailinfo.split(';');
			}
			if (MKGlobal.formInfo.sendMailInfo.name) {
				nameinfo = MKGlobal.formInfo.sendMailInfo.name;
			}
			if (!isEmptyObject(MKGlobal.formInfo.sendMailInfo.state)) {
				emailState = MKGlobal.formInfo.sendMailInfo.state;
			}

			$emailField.mikeTag_Add(emailinfo.split(';'));

			$('.MGTAG-i').each(function(){
				var $this = $(this),$element = $this.find('span'),mailState = emailState[$element.attr('fullvalue')];
				setMailState(mailState.s,mailState.r,$this);
			});
			$('.formFeedbackMail .mikeContainer').unbind('keyup.chosenAjax').bind('keyup.chosenAjax',function (e){
				var keyword = $(this).find('.tagInput>input').val(),sLen=parseInt($(".formBuilder_feedback_email_dropDown li").index(),0),time = 0;
				if (e.which == 13) {
					if ($('.tagInput>input').length > 0) {
						time = 1000;
					}
					setTimeout(function(){
						var $element = $('.MGTAG-i:last');
						chkFeedbackNoticeEmail($element.find('span').attr('fullvalue'),$element);
						$('.formBuilder_feedback_email_dropDown').hide();
					},time);
				}else if(e.which == 32){
					var $element = $(".formBuilder_feedback_email_dropDown li.sHover");
					if ($element.length) {
						$emailField.mikeTag_Add( $element.text() );
						chkFeedbackNoticeEmail($element.text(),$('.MGTAG-i:last'));
					}
					$('.formBuilder_feedback_email_dropDown').hide();
				}else if(e.which == 40){//向下
					if (sIndex == sLen) {
						sIndex = 0;
					}else{
						sIndex++;
					}
					$(".formBuilder_feedback_email_dropDown li:not("+sIndex+")").removeClass("sHover");
					$(".formBuilder_feedback_email_dropDown li:eq("+sIndex+")").addClass("sHover");
				}else if(e.which == 38){//向上
					if (sIndex == 0) {
						sIndex = sLen;
					}else{
						sIndex--;
					}
					$(".formBuilder_feedback_email_dropDown li:not("+sIndex+")").removeClass("sHover");
					$(".formBuilder_feedback_email_dropDown li:eq("+sIndex+")").addClass("sHover");
				}else{
					sIndex=-1;
					if (keyword == '') {
						$('.formBuilder_feedback_email_dropDown').hide();
					}else{
						$.ajax({
							url: 'handler/handleAjaxGetFeedbackNoticeEmail.php',
							type: 'POST',
							dataType: 'json',
							data: {
								DATA: JSON.stringify({
									"TYPING" : keyword
								})
							}
						}).done(function(data){
							if(data.flag){
								$('.formBuilder_feedback_email_dropDown').empty();
								$.each(data.data, function (i,v){
									if ($.inArray(v,emailArray) == -1) {
										$('.formBuilder_feedback_email_dropDown').append('<li class="feedbackEmail_li">'+v+'</li>');
									}
								});
								$('.formBuilder_feedback_email_dropDown').show().css('top',(parseInt($('.mikeContainer').height())+43)+'px').getNiceScroll().resize();
							}else{
								$('.formBuilder_feedback_email_dropDown').hide();
							}
						});
					}
				}
			});
			$(".formFeedbackMail").off('click.accredit').on('click.accredit','.email_unAccredit',function(){
				var $this=$(this),email = $this.find('span').attr('fullvalue');
				TINY.box.show({
					html:$(".popwin_emailAccredit").html(),
					width: 414,
					height: 246,
					animate:true,
					boxid: 'box_emailAccredit',
					close:true,
					openjs: function(){
						var $box = $('#box_emailAccredit');
						$box.find('.ea_email').text(email);
						$box.find(".btn_confrim").click(function(){
							TINY.box.hide();
							addFeedbackNoticeEmail(email,$this);
						});
					}
				});
			});
			$(".formFeedbackMail").off('click.reSendEmail').on('click.reSendEmail','.email_waitAccredit, .email_refuseAccredit',function(){
				var $this=$(this),email = $this.find('span').attr('fullvalue');
				if ($this.find('span').attr('isResend') == '0') {
					$('.formBuilder_feedback_email_errorTips').text('一天内仅能发起一次授权申请，请明天再试').show();
					setTimeout("$('.formBuilder_feedback_email_errorTips').hide();",3000);
				}else{
					addFeedbackNoticeEmail(email,$this);
				}
			});
			$('body').click(function(){
				$('.formBuilder_feedback_email_dropDown').hide();
			});
			$(".formFeedbackMail").off('click.addFeedbackEmail').on('click.addFeedbackEmail','.feedbackEmail_li',function(){
				$emailField.mikeTag_Add( $(this).text() );
				chkFeedbackNoticeEmail($(this).text(),$('.MGTAG-i:last'));
				$('.formBuilder_feedback_email_dropDown').hide();
			});
			$('.feedback_name').val(nameinfo).unbind('keyup').bind('keyup',function(){
                MKFORM.__beforeInput(this);
				MKGlobal.addUnsaveCount();
			});
			$('.mikeContainer').find('input').die('keyup').live('keyup',function(){
				MKGlobal.addUnsaveCount();
			});
			function setMailState(status,isResend,$ui){
				var $element = $ui.find('span');
				$ui.find('.email_stateIcon').remove();
				$ui.removeClass('email_unAccredit').removeClass('email_waitAccredit').removeClass('email_accredited').removeClass('email_refuseAccredit').removeClass('email_refuseForeverAccredit');
				if ( status == -1) {
					$ui.addClass('email_unAccredit').append('<a class="email_stateIcon" title="该邮箱为陌生地址，点击进行授权"></a>');
					$element.attr({'state':status,'isResend':isResend,'title':'该邮箱为陌生地址，点击进行授权'});
				}else if ( status == 0) {
					$ui.addClass('email_waitAccredit').append('<a class="email_stateIcon" title="已发送申请，等待对方授权，点击重发"></a>');
					$element.attr({'state':status,'isResend':isResend,'title':'已发送申请，等待对方授权，点击重发'});
				}else if ( status == 1 || status == 9) {
					$ui.addClass('email_accredited');
					$element.attr({'state':status,'isResend':isResend});
				}else if ( status == 2) {
					$ui.addClass('email_refuseAccredit').append('<a class="email_stateIcon" title="该邮箱拒绝接收反馈提醒，点击重新申请授权"></a>');
					$element.attr({'state':status,'isResend':isResend,'title':'该邮箱拒绝接收反馈提醒，点击重新申请授权'});
				}else if ( status == 3) {
					$ui.addClass('email_refuseForeverAccredit').append('<a class="email_stateIcon" title="该邮箱永久拒绝接收反馈提醒"></a>');
					$element.attr({'state':status,'isResend':isResend,'title':'该邮箱永久拒绝接收反馈提醒'});
				}
			}
			function chkFeedbackNoticeEmail(email,$ui){
				if ($('.tagInput.failed').length == 0) {
					$.ajax({
						url: 'handler/handleChkFeedbackNoticeEmail.php',
						type: 'POST',
						dataType: 'json',
						data: {
							DATA: JSON.stringify({
								"EMAIL" : email
							})
						}
					}).done(function(data){
						if(data.flag){
							if ($.inArray(email,emailArray) == -1) {
								emailArray.push(email);
							}
							setMailState(data.status,data.resend,$ui);
						}else{
							$('.formBuilder_feedback_email_errorTips').text('邮箱格式不符，请重试').show();
							setTimeout("$('.formBuilder_feedback_email_errorTips').hide();",3000);
							$ui.remove();
						}
					});
				}
			}
			function addFeedbackNoticeEmail(email,$ui){
				if ($('.tagInput.failed').length == 0) {
					$.ajax({
						url: 'handler/handleAddFeedbackNoticeEmail.php',
						type: 'POST',
						dataType: 'json',
						data: {
							DATA: JSON.stringify({
								"EMAIL" : email
							})
						}
					}).done(function(data){
						if(data.flag){
							setMailState(data.status,data.resend,$ui);
							$('.formBuilder_feedback_email_errorTips').text('邮件已发送').show();
							setTimeout("$('.formBuilder_feedback_email_errorTips').hide();",3000);
						}else{
							$('.formBuilder_feedback_email_errorTips').text('邮箱格式不符，请重试').show();
							setTimeout("$('.formBuilder_feedback_email_errorTips').hide();",3000);
							$ui.remove();
						}
					});
				}
			}

            var $openNoticeSender = $('#openNoticeSender');
			if (!MKGlobal.formInfo.sendMailInfo.needSend) {
				$sendButton.removeAttr('checked');
				$sendButton.parent().removeClass('checked').siblings('.formFeedbackMail').hide();
			} else {
				$sendButton.attr('checked', 'checked');
				$sendButton.parent().addClass('checked').siblings('.formFeedbackMail').show();

                $openNoticeSender.attr('checked', 'checked');
                $openNoticeSender.parent().addClass('checked');
			}

            if(!MKGlobal.formInfo.webHookUrl) MKGlobal.formInfo.webHookUrl = [];

            var show_enabled_webhook_url = function() {
                $web_hook_set.html('更多');
                $web_hook_set.show();
                bind_hover_filed(false);

            };

            var reload_webhook_list = function(){
                var hook_list = $(".web_hook_list");
                hook_list.html('');

                hook_list.off("click",".del_webook").on("click",".del_webhook", function(){

                    var val = $(this).closest("li").data("url");

                    $.each(MKGlobal.formInfo.webHookUrl, function(id, url){
                        if(url == val){
                            MKGlobal.formInfo.webHookUrl.splice(id, 1);
                            return true;
                        }
                    });
                    $(this).closest("li").remove();

                    if(MKGlobal.formInfo.webHookUrl.length == 0){
                        $(".added_hook_tip").hide();
                    }

                    MKGlobal.addUnsaveCount();

                });
                $.each(MKGlobal.formInfo.webHookUrl, function(id, url){
                   var li = "<li data-url='"+url+"'>"+ url +" <span class='del_webhook'>删除</span></li>" ;
                    hook_list.append(li);
                });

                hook_list.closest(".tinner").css("height", 'auto');

                if(MKGlobal.formInfo.webHookUrl.length > 0){
                    $(".added_hook_tip").show();
                }else{
                    $(".added_hook_tip").hide();
                }
            }

            var bind_hover_filed = function(bind){
                var formBuilder_edit_filed= $('.formBuilder_edit_filed');
                formBuilder_edit_filed.unbind('mouseenter mouseleave');
                if(bind){
                    formBuilder_edit_filed.hover(function(){
                        $web_hook_set.show();
                    },function(){
                        $web_hook_set.hide();
                    });
                }
            };

            if(MKGlobal.formInfo.webHookUrl.length > 0){
                show_enabled_webhook_url();
                $('.setting_web_hook .input_val span').hide();
            }

			$sendButton.unbind('change').bind('change', function () {
				if ($(this).attr("checked") != "checked") {
					$(this).parent().siblings('div.formFeedbackMail').hide();
				} else {
					$(this).parent().siblings('div.formFeedbackMail').show();
                    MKGlobal.formInfo.sendMailInfo.needSend = true;
				}
				MKGlobal.addUnsaveCount();
			});

            $openNoticeSender.unbind('change').bind('change', function (e) {
                var $self = $(this);
                var isChecked = $self.attr('checked');
                if(isChecked !== 'checked') {
                    MKGlobal.formInfo.sendMailInfo.needSend = false;
                    MKGlobal.formInfo.sendSmsInfo.needSend = false;
                } else {
                    var isSendChecked = $sendButton.attr('checked');
                    if(isSendChecked === 'checked') {
                        MKGlobal.formInfo.sendMailInfo.needSend = true;
                    }
                }
                MKGlobal.addUnsaveCount();
            });

            $web_hook_set.unbind('click').bind('click', function () {
                //click popup
                TINY.box.show({
                    'html':$("#popwin_invite_web_hook").html(),
                    'width': 500,
                    'openjs':function(){
                        reload_webhook_list();
                        var span = $('.setting_web_hook .input_val span');
                        if(MKGlobal.formInfo.webHookUrl.length > 0){
                            span.hide();
                        }else{
                            span.show();
                        }
                        $(".web_hook_confirm").css("opacity","0");
                        $('.input_inviteWebHook')
                            .unbind('paste').bind('paste',function(){
                                var $this = $(this),
                                    tmpVal;
                                setTimeout(function () {
                                    tmpVal = $this.val().replace(/(<([^>]+)>)/g, "");
                                    $this.val($.trim(tmpVal));
                                }, 200);
                        }).unbind('change').bind('change',function(){

                            });

                        $(".input_inviteWebHook").unbind("keyup").keyup(function(eve){
                            if(eve.keyCode == 13){
                                $(".web_hook_submit").click();
                            }
                        })

                        $(".web_hook_submit").unbind('click').click(function(){
                            //添加
                            var url = $('.input_inviteWebHook:last').val().trim();
                            var cfm = $('.web_hook_confirm');
                            if(url.trim() == "") return false;

                            if(MKGlobal.formInfo.webHookUrl.length >= 5){
                                cfm.css('opacity',1).html("最多添加5个Webhook");
                                setTimeout(function(){cfm.css('opacity', 0)}, 3000);
                                return true;
                            }

                            if(url.indexOf("'")!= -1 || url.indexOf('"') != -1){
                                cfm.css('opacity',1).html("不能包含引号");
                                setTimeout(function(){cfm.css('opacity', 0)}, 3000);
                                return true;
                            }

                            if((url.toLowerCase().indexOf('http://')>=0 && url.toLowerCase().replace('http://','').length > 0)
                                    || (url.toLowerCase().indexOf('https://')>=0 && url.toLowerCase().replace('https://','').length > 0)){

                                var exist = false;
                                $.each(MKGlobal.formInfo.webHookUrl, function(id, value){
                                    if(value == url) {
                                        exist = true;
                                        return true;
                                    }
                                });

                                if(exist){
                                    cfm.css('opacity',1).html('不能重复添加');
                                    setTimeout(function(){cfm.css('opacity', 0)}, 3000);
                                    return true;
                                }

                                MKGlobal.formInfo.webHookUrl.push(url);
                                MKGlobal.addUnsaveCount();
                                show_enabled_webhook_url();
                                reload_webhook_list();
                                $(".input_inviteWebHook").val("");

                            }else{
                                cfm.css('opacity',1).html('格式不正确，地址需要以http://或者https://开头');
                                setTimeout(function(){cfm.css('opacity', 0)}, 3000);
                            }

                        });
                    },
                    'closejs':function(){
                        $(".input_inviteWebHook").siblings("label").remove()
                            .siblings(".error_img").remove();
                        $(".web_hook_confirm").css("opacity","0");
                    },
                    animate:false,
                    maskid:'blackmask',
                    maskopacity:40
                });
            });
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formFeedbackNoticeSMS': (function () {
		function mkBind() {
			var smsinfo = null,
				smsArray = null,
				$smsField = $('.feedback_sms'),
				$sendButton = $('#autoSendSMS'),
				$sendOnlyOneButton = $('#autoSendSMSOnlyOne'),
				sIndex = -1;

            $smsField.mikeTag({
				'tagClass': 'MGTAG-sms',
				'defaultText': '',
				'maxNo': 3,
				'RegEx': /^1[34578]\d{9}$/i,
				'onRemove': function(){
					var phone = this.find('span').attr('fullvalue'),index = $.inArray(phone,smsArray);
					if ( index != -1) {
                        smsArray.splice(index,1);
					}
				}
			});

			if (MKGlobal.formInfo.sendSmsInfo.sms) {
                smsinfo = MKGlobal.formInfo.sendSmsInfo.sms;
                smsArray = smsinfo.split(';');
                $smsField.mikeTag_Add(smsinfo.split(';'));
			}

            var $openNoticeSender = $('#openNoticeSender');
			if (!MKGlobal.formInfo.sendSmsInfo.needSend) {
				$sendButton.removeAttr('checked');
				$sendButton.parent().removeClass('checked').siblings('div.formFeedbackSms').hide().siblings('.formFeedbackSmsSub').hide();
			
				//sendOnlyOneButton默认选中
				$sendOnlyOneButton.attr('checked', 'checked');
				$sendOnlyOneButton.parent().addClass('checked');
			} else {
				$sendButton.attr('checked', 'checked');
				$sendButton.parent().addClass('checked').siblings('div.formFeedbackSms').show().siblings('.formFeedbackSmsSub').show();


                if (!MKGlobal.formInfo.sendSmsInfo.needSendSmsOnlyOne) {
                    $sendOnlyOneButton.removeAttr('checked');
                    $sendOnlyOneButton.parent().removeClass('checked');
                } else {
                    $sendOnlyOneButton.attr('checked', 'checked');
                    $sendOnlyOneButton.parent().addClass('checked');
                }

                $openNoticeSender.attr('checked', 'checked');
                $openNoticeSender.parent().addClass('checked');
            }


			$sendButton.unbind('change').bind('change', function () {
				if ($(this).attr("checked") != "checked") {
					$(this).parent().siblings('div.formFeedbackSms').hide().siblings('.formFeedbackSmsSub').hide();
				} else {
					$(this).parent().siblings('div.formFeedbackSms').show().siblings('.formFeedbackSmsSub').show();
                    MKGlobal.formInfo.sendSmsInfo.needSend = true;
				}
				MKGlobal.addUnsaveCount();
			});
            $openNoticeSender.bind('change', function (e) {
                var $self = $(this);
                var isChecked = $self.attr('checked');
                if(isChecked !== 'checked') {
                    MKGlobal.formInfo.sendMailInfo.needSend = false;
                    MKGlobal.formInfo.sendSmsInfo.needSend = false;
                } else {
                    var isSendChecked = $sendButton.attr('checked');
                    if(isSendChecked === 'checked') {
                        MKGlobal.formInfo.sendSmsInfo.needSend = true;
                    }
                }
                MKGlobal.addUnsaveCount();
            });
            $sendOnlyOneButton.unbind('change').bind('change', function () {
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formAutoCreateContact': (function () {
		//---
		var $contactAdd =$("#autoAddContact"),
			$contactSetting = $contactAdd.parent().siblings('.formCreateContacts');
		function mkBind() {
			// MKGlobal.formInfo.newContact = true;
			if(!MKGlobal.formInfo.newContact){
				$contactAdd.removeAttr('checked');
				$contactAdd.parent().removeClass('checked');
			}

			if ($contactAdd.attr('checked') == 'checked') {
				$contactSetting.show();
			} else {
				$contactSetting.hide();
			}
			$contactAdd.bind('change', function () {
				if($('.tip_info').is(':visible') != true){
					if ($(this).attr("checked") != "checked") {
						$contactSetting.hide();
					} else {
						$contactSetting.show();
					}
				} else {
					window.setTimeout(function(){
						$contactAdd.removeAttr('checked').parent().removeClass('checked');
					},0);

				}
				MKGlobal.addUnsaveCount();
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formTitleClick': (function () {
		// 点击 title 部分 跳转 到 表单设置
		function mkBind() {
			$('.formBuilder_main .form_title').unbind('click').bind('click', function () {
				// --
				var $editField = $('.formBuilder_interim_edit').eq(0);
				if (!$editField.hasClass('formBuilder_interim_edit_active')) {
					$editField.trigger('click');
				}
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formChangeBackground': (function () {
		var tmpBackground = '';

		function mkBind() {
			var $settingField = $('.sdi_backgroundImg'),
				$setBackground = $('#form_background'),	// 是否显示背景图
				$backgroundController = $settingField.find('.upload_background_image_style'),
				$setBackgroundRepeat = $('#background_repeat'),
				$setBackgroundFix = $('#background_fix'),
				$setBackgroundPosition = $backgroundController.find('.sdi_stateBtn');

			// 初始化
			if(MKGlobal.formInfo.backgroundtype !== 'no-repeat'){
				$setBackgroundRepeat.attr('checked', 'checked').parent().addClass('checked');
			}

			if(MKGlobal.formSchemeStruct.imgf === 'fix'){
				$setBackgroundFix.attr('checked', 'checked').parent().addClass('checked');
			}

			if(MKGlobal.formSchemeStruct.imgp){
				$setBackgroundPosition.find('.active').removeClass('active');
				$setBackgroundPosition.find('.stateBtn[chose-info="'+MKGlobal.formSchemeStruct.imgp+'"]').addClass('active');
			} else {
				$setBackgroundPosition.find('.active').removeClass('active');
				$setBackgroundPosition.find('.stateBtn').eq(0).addClass('active');
				MKGlobal.formSchemeStruct.imgp = $setBackgroundPosition.eq(0).attr('chose-info');
			}

			if (MKGlobal.formInfo.background && MKGlobal.formInfo.background != 'none' && MKGlobal.formInfo.background != false && (MKGlobal.formInfo.background||"").indexOf('url') >= 0){
				$setBackground.attr('checked', 'checked').parent().addClass('checked');
				MKGlobal.formInfo.backgroundAvailable = true;
				$settingField.find('.operation').show();
			} else {
				MKGlobal.formInfo.backgroundAvailable = false;
				$settingField.find('.operation').hide();
			}

			// 背景图片显示的控制
			$setBackground.unbind('change').bind('change', function () {
				var hint = MKFORM.uploadhint;
				if ($(this).attr("checked") != "checked") {
					MKGlobal.formInfo.backgroundAvailable = false;
					$settingField.find('.operation').hide();
				} else {
					MKGlobal.formInfo.backgroundAvailable = true;
					$settingField.find('.operation').show();
				}

				// alert(MKGlobal.formInfo.backgroundAvailable);

				MKFORM.formUtility.formSchemeCSSGenerator();
				if(MKGlobal.formInfo.background && MKGlobal.formInfo.background !== 'none' ){
					hint = '文件已经上传';
				}
				$settingField.find('.input_file').next('p').text(hint);

				MKGlobal.addUnsaveCount();
			});


			// 2.2 上传图片的设置
			MKFORM.formUtility.formImgUpload($settingField.find('.input_file'), function (e, data) {
				var imgPath = data.result.data.url.replace(/[\\]/g, '/');
				// TODO !!!! 上线前要改成 www.mikecrm.com
				MKGlobal.addUnsaveCount();
				MKGlobal.formInfo.background = 'url(' + MKFORM.localHost + imgPath + ')';
				MKFORM.formUtility.formSchemeCSSGenerator();
			});


			$setBackgroundRepeat.unbind('change').bind('change', function () {
				if ($(this).attr('checked') == 'checked') {

					MKGlobal.formInfo.backgroundtype = 'repeat';
				} else {
					MKGlobal.formInfo.backgroundtype = 'no-repeat';
				}
				MKGlobal.formSchemeStruct.imgp = MKGlobal.formInfo.backgroundtype;
				MKFORM.formUtility.formSchemeCSSGenerator();
				MKGlobal.addUnsaveCount();
			});

			$setBackgroundFix.unbind('change').bind('change', function () {
				if ($(this).attr('checked') == 'checked') {

					MKGlobal.formInfo.backgroundfix = 'fix';
				} else {
					MKGlobal.formInfo.backgroundfix = '';
				}
				MKGlobal.formSchemeStruct.imgf = MKGlobal.formInfo.backgroundfix;
				MKFORM.formUtility.formSchemeCSSGenerator();
				MKGlobal.addUnsaveCount();
			});

			$setBackgroundPosition.find('.stateBtn').unbind('click').bind('click',function(){
				var $this = $(this);
				if(!$this.hasClass('active')){
					$this.addClass('active').siblings('.active').removeClass('active');
					MKGlobal.formSchemeStruct.imgp = $this.attr('chose-info');
					MKFORM.formUtility.formSchemeCSSGenerator();
					MKGlobal.addUnsaveCount();
				}
			});
		}

		return {
			bind: function () {
				return mkBind();
			}
		};
	})(),
	'formFinishLoading': function () {
		$('.globalLoading').fadeOut(400);
	},
	formLogicShow: function(){
		// 切换到逻辑编辑模式
		$('.logic_view').click(function(e){
			if(MKFORM.isChangingLogic === false && !$(this).hasClass('.current_tag')){
				MKFORM.isChangingLogic = true;
				var $logic = $('#form_logic_mask'),
					infoList = MKFORM.formUtility.formTitleListGetter(),
					followList = MKFORM.formUtility.formStaticFollowListGetter(),	// 获取静态元素的列表
					followRelationObject = false,
					tmpHTML = '',
					$this = $(this);
				$('#form_logic_bk').fadeIn(1200);
				// tmpHTML 生成

				// 整理 followList
				if(followList){
					followRelationObject = {};
					for(var __infoList_index=0,__infoList_len = followList.length; __infoList_index<__infoList_len; __infoList_index++){
						followRelationObject[followList[__infoList_index].id] = {
							'prev': followList[__infoList_index].prev||false,
							'next': followList[__infoList_index].next||false
						};
					}
				}

				$('.design_view').removeClass('current_tag');
				$('.logic_view').addClass('current_tag');

				$('.formBuilder_step2').addClass('logic_bk');

				for(var i=0,len=infoList.length; i<len; i++){
					tmpHTML += '<div class="logic_form_item" com-info-id="'+infoList[i].id+'">';
					tmpHTML+=logicLineGenerator($this, infoList, followList, followRelationObject, i);
					tmpHTML += '</div>';
				}
				//插入
				$logic.find('.logic_mask_main').empty().append('<div class="form_title">'+$('.form_title').clone().html()+'</div>'+tmpHTML);

				$logic.find('.item_selector').unbind('change.logicSelect').bind('change.logicSelect',function(){
					var $this = $(this),
						num = $this.attr('serialNo'),
						_com = $this.closest('.logic_form_item').attr('com-info-id'),
						_data = $('#'+_com).data('Logic_Setting'),
						_count = 0;

					if(!_data){
						_data = {};
					}
					if($this.val() !== 0 && $this.val() !== "0"){
						_data[num] = $this.val();
					} else {
						delete _data[num];
					}

					for(var obji in _data){
						if(_data.hasOwnProperty(obji)){
							if(_data[obji]){
								_count++;
							}
						}
					}
					if(_count === 0){
						_data = false;
					}
					$('#'+_com).data('Logic_Setting',_data);

					changeStaticView();
					MKGlobal.addUnsaveCount();
				});

				// event binding
				$logic.find('.logic_is_end').unbind('change.orginalLogic').bind('change.orginalLogic',function(){
					var $this = $(this);
					if($this.val() !== 0 && $this.val() !== "0"){
						if($this.val().match("follow")){
							$('#'+$this.attr('cid')).data('Logic_Setting', {
								condition: "showWith",
								showWith: $this.val().replace('follow_')
							});
						} else {
							$('#'+$this.attr('cid')).data('Logic_Setting', {
								condition: "",
								jumpto: $this.val()
							});
						}

					} else {
						$('#'+$this.attr('cid')).data('Logic_Setting', false);
					}
					changeStaticView();
					MKGlobal.addUnsaveCount();
				});


				$logic.off('change.changeState').on('change.changeState','.logic_state',function(){
					var $this = $(this);
					switch($this.val()){
						case 'jumpto':
							$this.addClass('logic_state_min');
							$this.siblings('.jump_select').removeClass('hidden_condition');
							$this.siblings('.showwith_select').addClass('hidden_condition');
							$('#'+$this.attr('cid')).data('Logic_Setting', {
								condition: '',
								jumpto: $this.siblings('.jump_select').val()|| $this.siblings('.jump_select').find('option').first().attr("selected",'selected').attr('value')
							});
							
							break;
						case 'showwith':
							$this.addClass('logic_state_min');
							$this.siblings('.showwith_select').removeClass('hidden_condition');
							$this.siblings('.jump_select').addClass('hidden_condition');
							var $showwith = $this.siblings('.showwith_select');
							// console.log($showwith.val());
							$('#'+$this.attr('cid')).data('Logic_Setting', {
								condition: $showwith.val()||$showwith.find('option').first().attr("selected",'selected').attr('value'),
								showWith: $showwith.find('option[value="'+$showwith.val()+'"]').attr('comid')|| $showwith.find('option').first().attr("selected",'selected').attr('comid')
							});
							break;
						default:
							$this.removeClass('logic_state_min');
							$this.siblings('.jump_select').addClass('hidden_condition');
							$this.siblings('.showwith_select').addClass('hidden_condition');
							$('#'+$this.attr('cid')).data('Logic_Setting', false);
							break;
					}

					MKGlobal.addUnsaveCount();
				});

				$logic.off('change.changeFollowState').on('change.changeFollowState','.showwith_select',function(){
					var $this = $(this),
						val = $this.val(),
						cid = $this.siblings('.logic_state').attr('cid');

					$('#'+cid).data('Logic_Setting', {
						condition: val,
						showWith: $this.find('option[value="'+val+'"]').attr('comid')
					});
				});

				$logic.off('change.changeJumpState').on('change.changeJumpState','.jump_select',function(){
					var $this = $(this),
						val = $this.val(),
						cid = $this.siblings('.logic_state').attr('cid');

					$('#'+cid).data('Logic_Setting', {
						condition: '',
						jumpto: val
					});
				});


				$('.logic_fake').find('.logic_mask_main').empty().append('<div class="form_title">'+$('.form_title').clone().html()+'</div>'+tmpHTML);
				// animate add
				// $('.formBuilder_main_content').on('webkitAnimationEnd oanimationend msAnimationEnd animationend',function(e) {
				// 	$(this).find('.logic_fake').css('z-index','3');
				// }).addClass('change-size-animate');
				if(Modernizr.csstransitions && Modernizr.csstransforms3d){
					if($('.formBuilder_main_container').hasClass('logic_animate')){
						$('.formBuilder_main_container').removeClass('logic_animate');
					} else {
						$('.formBuilder_main_container').addClass('logic_animate');
					}
				} else {
						$logic.fadeIn(200,function(){
							$logic.find('.logic_scrollable').scrollTop(0);
						});
						$logic.find('.logic_scrollable').getNiceScroll().resize().show();
						// $('.design_view').slideDown(200);
						$('#form_logic_bk').show();
						$('.design_view').removeClass('current_tag');
						$('.logic_view').addClass('current_tag');
						MKFORM.isChangingLogic = false;
				}



				// $logic.addClass('logic_back_init').show();
				// window.setTimeout(function(){
				// 	$logic.addClass('change-back-size-animate');
				// },300);
				
				// scrollbar manager
				
				$(".formBuilder_edit").getNiceScroll().hide();
				$(".formBuilder_color .style_pad").getNiceScroll().hide();
				$(".formBuilder_example").getNiceScroll().hide();
			}
		});

		if(Modernizr.csstransitions && Modernizr.csstransforms3d) {
			$('.formBuilder_main_container').on('transitionend oTransitionEnd webkitTransitionEnd animationend webkitAnimationEnd oanimationend MSAnimationEnd',function(e) {
				var $logic = $('#form_logic_mask');
				if($(this).hasClass('logic_animate')){
					$logic.fadeIn(200,function(){
						$logic.find('.logic_scrollable').scrollTop(0);
					});
					$logic.find('.logic_scrollable').getNiceScroll().resize().show();
					// $('.design_view').slideDown(200);
					
					
					
				} else {
					// $('.logic_view').slideDown(200);
					$(this).removeClass('logic_back_animate');
					$(".formBuilder_edit").getNiceScroll().resize();
					$(".formBuilder_edit").getNiceScroll().show();
					// $('.logic_view').addClass('current_tag');
				}
				MKFORM.isChangingLogic = false;
			});
		}

		// 切换回表单编辑
		$('.design_view').click(function(){
			if(!$(this).hasClass('current_tag') && MKFORM.isChangingLogic === false){
				MKFORM.isChangingLogic = true;
				$('.logic_view').removeClass('current_tag');
				$('.design_view').addClass('current_tag');
				$('#form_logic_mask').hide();
				$('.formBuilder_step2').removeClass('logic_bk');
				$('#form_logic_bk').hide();
				// animate-do
				// $('.design_view').slideUp(200);
				
				// scrollbar manager
				$('.logic_scrollable').getNiceScroll().hide();
				$(".formBuilder_edit").getNiceScroll().resize();
				$(".formBuilder_edit").getNiceScroll().show();
				$(".formBuilder_color .style_pad").getNiceScroll().resize();
				$(".formBuilder_color .style_pad").getNiceScroll().show();
				$(".formBuilder_example").getNiceScroll().resize();
				$(".formBuilder_example").getNiceScroll().show();

				if(Modernizr.csstransitions && Modernizr.csstransforms3d){
					$('.formBuilder_main_container').removeClass('logic_animate').addClass('logic_back_animate');
				} else {
					MKFORM.isChangingLogic = false;
					// $('.formBuilder_main_container').removeClass('logic_animate').addClass('logic_back_animate');
					// $('.logic_view').addClass('current_tag');
				}
			}
		});
		
		// console.log(MKFORM.formUtility.formTitleListGetter());
		// console.log(MKFORM.formUtility.formStaticFollowListGetter());

		function logicLineGenerator($this, infoList, followList, followRelationObject, i){
			var tmpHTML = '';
			if(infoList[i].value){
				tmpHTML += '<span class="logic_question">Q'+(i+1)+'</span>:<span class="form_item_title">'+(infoList[i].name||'')+'</span>';
				var list = infoList.slice(i+1, infoList.length);
				var logic_html, selector, _current;
				for (var j=0,jLen=infoList[i].value.length; j<jLen; j++) {
					// 这个是当前选项选了啥 对应的是 comXXX
					if(infoList[i].data){
						_current = infoList[i].data[infoList[i].value[j].serialNo]||0;
					} else {
						_current = 0;
					}
					
					logic_html = list.map(function(v,_i){
						var _i = (i+1+_i);
						return '<option value="'+v.id+'" '+(_current===v.id?'selected="selected"':'')+'>'+'Q'+(_i+1)+': '+v.name+'</option>';
					});

					if(_current == 'end'){
						logic_html.push('<option value="end" selected="selected">直接结束</option>');
					} else {
						logic_html.push('<option value="end">直接结束</option>');
					}

					selector = '<select class="item_selector" serialNo="'+infoList[i].value[j].serialNo+'"><option value="0">下一题</option>'+logic_html.join('')+'</select>';
					tmpHTML += '<div class="item_option"><span class="item_option_content">'+infoList[i].value[j].content+'</span><span class="item_jump_to">跳转到'+selector+'</span></div>';
				}
			} else {
				var comData = $('#'+infoList[i].id).data('Logic_Setting'),
					status = '',
					list = infoList.slice(i+1, infoList.length);
				

				_current = '';

				if($.inArray(infoList[i].type,['id_section','id_picture']) >= 0 && followRelationObject && followRelationObject[infoList[i].id]){
					var stateChosenHTML = '',
						jumpChosenHTML = '',
						showWithChosenHTML = '',
						logic_html,
						conditionNum = 0,
						_current = false;
					// 是静态组件，并且符合条件::
					if(comData){
						if(comData.condition === ''){
							conditionNum = 1;
							_current = comData.jumpto;
						} else if(comData.condition === 'next' || comData.condition === 'prev'){
							conditionNum = 2;
							_current = comData.showWith;
						}
					}

					// 条件的组件生成
					stateChosenHTML = '<select class="logic_state '+(conditionNum!==0?" logic_state_min":"")+'" cid="'+infoList[i].id+'">'+
						'<option value="none" '+(conditionNum===0?"selected='selected'":"")+'>显示下一题</option>'+
						'<option value="jumpto" '+(conditionNum===1?"selected='selected'":"")+'>跳转到</option>'+
						'<option value="showwith" '+(conditionNum===2?"selected='selected'":"")+'>跟随显示</option>'
						+'</select>';

					// 跳转的组件生成
					logic_html = list.map(function(v,_i){
							_i = i+1+_i;
							return '<option value="'+v.id+'" '+((_current===v.id && conditionNum===1)?'selected="selected"':'')+'>'+'Q'+(_i+1)+': '+v.name+'</option>';
						});

						if(_current == 'end' && conditionNum === 1){
							logic_html.push('<option value="end" selected="selected">直接结束</option>');
						} else {
							logic_html.push('<option value="end">直接结束</option>');
						}

					jumpChosenHTML = '<select class="jump_select'+(conditionNum !== 1?' hidden_condition':'')+'">'+logic_html.join('')+'</select>';

					// console.log(jumpChosenHTML);

					// 跟随的组件生成

					logic_html = [];
					var $_t_ro;
					for(var _roi in followRelationObject[infoList[i].id]){
						// console.log(followRelationObject[infoList[i].id]);
						if(followRelationObject[infoList[i].id][_roi]){
							$_t_ro = $('#'+followRelationObject[infoList[i].id][_roi]);
							logic_html.push('<option value="'+_roi+'" comid="'+followRelationObject[infoList[i].id][_roi]+'" '+((_current===followRelationObject[infoList[i].id][_roi] && conditionNum===2)?'selected="selected"':'')+'>'+(_roi==='prev'?"上一题":"下一题")+': Q'+($_t_ro.index()+1)+' '+($_t_ro.find('.title').text()||$_t_ro.find('.subtitle').text())+'</option>');
						}
					}

					showWithChosenHTML = '<select class="showwith_select'+(conditionNum !== 2?' hidden_condition':'')+'">'+logic_html.join('')+'</select>';

					// console.log(showWithChosenHTML);

					// selection change
					// get Logic setting
					// get condition
					// if (condition is "showWith")
					//     to => "next/prev"  showWith => "com13"
					//     set show what/
					// else if (condition is "")
					//     jumpto => "com13"
					// else
					//     condition => none.

					tmpHTML += '<div class="orginal_question"><span>Q'+(i+1)+'</span>:<span class="form_item_title">'+(infoList[i].name||'')+'</span>'+
						'</div><div class="original_question_logic">行为'+stateChosenHTML+jumpChosenHTML+showWithChosenHTML+'</div><div class="clearB"></div>';

				} else {
					var logic_html, selector, _current;
					if(comData){
						if(comData.condition === ''){
							_current = comData.jumpto;
						}
					}
					logic_html = list.map(function(v,_i){
						_i = i+1+_i;
						return '<option value="'+v.id+'" '+(_current===v.id?'selected="selected"':'')+'>'+'Q'+(_i+1)+': '+v.name+'</option>';
					});

					if(_current == 'end'){
						logic_html.push('<option value="end" selected="selected">直接结束</option>');
					} else {
						logic_html.push('<option value="end">直接结束</option>');
					}

					selector = '<select class="logic_is_end" cid="'+infoList[i].id+'"><option value="0">下一题</option>'+logic_html.join('')+'</select>';
					tmpHTML += '<div class="orginal_question"><span>Q'+(i+1)+'</span>:<span class="form_item_title">'+(infoList[i].name||'')+'</span>'+
						'</div><div class="original_question_logic">直接跳到'+selector+'</div><div class="clearB"></div>';
				}
			}
			return tmpHTML;
		}

		function changeStaticView(){
			// 每个操作执行完成之后都去检查所有的静态组件的状态并且刷新之：
			var infoList = MKFORM.formUtility.formTitleListGetter(),
				followList = MKFORM.formUtility.formStaticFollowListGetter(),	// 获取静态元素的列表
				followRelationObject = false;

			// console.log(followList);

			// 整理 followList
			if(followList){
				followRelationObject = {};
				for(var __infoList_index=0,__infoList_len = followList.length; __infoList_index<__infoList_len; __infoList_index++){
					followRelationObject[followList[__infoList_index].id] = {
						'prev': followList[__infoList_index].prev||false,
						'next': followList[__infoList_index].next||false
					};
				}
			}
			$('#form_logic_mask').find('.logic_form_item').each(function (i){
				// console.log(arguments);
				var $this = $(this),
					comid = $(this).attr('com-info-id'),
					type = ($this.find('.logic_state').length > 0)?1:0;
				if(followRelationObject[comid]){
					if(type === 0){
						// repaint line
						// alert(comid);
						$('#'+$this.attr('com-info-id')).data('Logic_Setting', false);
						var _infoList = MKFORM.formUtility.formTitleListGetter();
						$this.html(logicLineGenerator($this, _infoList, followList, followRelationObject, i));
					} else {
						// 控制 跟随的选项 & 清空错误的跟随选项
						var followResult = MKFORM.formUtility.formStaticFollowCheck($('.formBuilder_example').find('.ui-draggable')); // MKFORM.formUtility.formStaticComponentFollowChecker($('#'+$this.attr('com-info-id')).data('Logic_Setting'), $this.attr('com-info-id'));
						var _infoList = MKFORM.formUtility.formTitleListGetter(),
							_followList = followList,
							_followRelationObject = followRelationObject;

						if(followResult){
							_followList = MKFORM.formUtility.formStaticFollowListGetter();
							_followRelationObject = false;
							if(_followList){
								_followRelationObject = {};
								for(var __infoList_index=0,__infoList_len = _followList.length; __infoList_index<__infoList_len; __infoList_index++){
									_followRelationObject[_followList[__infoList_index].id] = {
										'prev': _followList[__infoList_index].prev||false,
										'next': _followList[__infoList_index].next||false
									};
								}
							}
						}
						// console.log(_infoList);
						$this.html(logicLineGenerator($this, _infoList, _followList, _followRelationObject, i));
					}
				} else {
					if(type === 1){
						// repaint line
						// console.trace();
						// alert(comid+'  -1');
						$('#'+$this.attr('com-info-id')).data('Logic_Setting', false);
						var _infoList = MKFORM.formUtility.formTitleListGetter();
						$this.html(logicLineGenerator($this, _infoList, followList, followRelationObject, i));
					}
				}
			});
		}

	}
};

MKFORM.formUtility = {
	formImgUpload: function ($ui, uploadCallback, pCom) {
		$ui.fileupload({
			dataType: "json",
            pasteZone: null,
			url: 'handler/handleUploadFormPicture.php?inpc_b',
			drop: function (e) {
				return false;
			},
			add: function (e, data) {
				var flag = false,
                    that = (typeof(pCom)=='object' ? pCom : $(this).siblings('p'));

				if (data.files[0].size) {
					if (data.files[0].size < 2000000) {
						$(this).attr('hasFile', true);
                        that.text(data.files[0].name).css("color", "#333333");
						flag = true;
					} else {
                        that.text('请上传小于2M的图片…').css('color', '#B94A48');
					}
				} else {
					$(this).attr('hasFile', true);
                    that.text(data.files[0].name).css("color", "#333333");
					flag = true;
				}
				if (flag) {
					data.submit();
				}
			},
			start: function (e, data) {
                (typeof(pCom)=='object' ? pCom : $(this).siblings('p')).text('开始上传……');
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 90, 10),
                    that = (typeof(pCom)=='object' ? pCom : $(this).siblings('p'));
                that.css('color', '#333').text('正在上传……' + progress + '%').siblings('.progress').css('width', progress * 0.9 + '%');
			},
			done: function (e, data) {
				// var uploadFlag = data.result.data.flag;
				var uploadFlag = data.result.flag,
                    that = (typeof(pCom)=='object' ? pCom : $(this).siblings('p'));
				if (uploadFlag) {
                    that.css('color', '#333').text(data.files[0].name).siblings('.progress').css('width', '90%');

					uploadCallback(e, data);
				} else {
                    that.css('color', '#333').text('文件超过大小，上传失败。').siblings('.progress').css('width', '90%');
					$('.validate_submit').removeAttr('style').text('提交');
				}
				$(this).siblings('.progress').fadeOut();
			}
		});
	},
	formButtonImgUpload: function ($ui, uploadCallback) {
		$ui.fileupload({
			dataType: "json",
            pasteZone: null,
			url: 'handler/handleUploadFormPicture.php?inpc_c',
			drop: function (e) {
				return false;
			},
			add: function (e, data) {
				var flag = false;
				if (data.files[0].size) {
					if (data.files[0].size < 2000000) {
						$(this).attr('hasFile', true);
						// $(this).parent().siblings('.errorinfo').text(data.files[0].name).css("color", "#333333");
						flag = true;
					} else {
						// $(this).siblings('p').css('color', '#B94A48');
						$(this).parent().siblings('.uploadinfo').text('上传的文件太大了…').show().css('color', '#B94A48');
					}
				} else {
					$(this).attr('hasFile', true);
					// $(this).siblings('p').text(data.files[0].name).css("color", "#333333");
					flag = true;
				}
				if (flag) {
					data.submit();
				}
			},
			start: function (e, data) {
				$(this).parent().siblings('.uploadinfo').text('开始上传！').show().css('color', '#333');
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 90, 10);
				$(this).parent().siblings('.uploadinfo').text('上传中…' + progress + '%').show().css('color', '#333');
			},
			done: function (e, data) {
				// var uploadFlag = data.result.data.flag;
				var uploadFlag = data.result.flag;
				if (uploadFlag) {
					$(this).parent().siblings('.uploadinfo').text('上传成功!').show().css('color', '#333');
					window.setTimeout((function ($ui) {
						return function () {
							$ui.parent().siblings('.uploadinfo').hide();
						};
					})($(this)), 300);
					uploadCallback(e, data);

				} else {
					$(this).parent().siblings('.uploadinfo').text('上传失败...').show().css('color', '#333');
				}
				$(this).siblings('.progress').fadeOut();
			}
		});
	},
	formSelectImgUpload: function ($ui, uploadCallback) {
		$ui.fileupload({
			dataType: "json",
            pasteZone: null,
			url: 'handler/handleUploadFormPicture.php?inpc_d',
			drop: function (e) {
				return false;
			},
			add: function (e, data) {
				var flag = false;
				if (data.files[0].size) {
					if (data.files[0].size < 2000000) {
						$(this).attr('hasFile', true);
						flag = true;
					} else {
						$(this).siblings('.upload_btn').html('文件太大<br/>(限2MB)').show();
					}
				} else {
					$(this).attr('hasFile', true);
					flag = true;
				}
				if (flag) {
					data.submit();
				}
			},
			start: function (e, data) {
				$(this).siblings('.upload_btn').html('开始上传<br/>(限2MB)').show();
			},
			progressall: function (e, data) {
				var progress = parseInt(data.loaded / data.total * 90, 10);
				$(this).siblings('.upload_btn').text('' + progress + '%...');
			},
			done: function (e, data) {
				var uploadFlag = data.result.flag;
				if (uploadFlag) {
					$(this).siblings('.upload_btn').html('上传成功<br/>(限2MB)').show();

					uploadCallback(e, data);

				} else {
					$(this).siblings('.upload_btn').html('上传失败<br/>(限2MB)').show();
				}
			}
		});
	},
	formSetCurrentTime: function () {
		var currentTime;

		function dateString(val) {
			if (val < 10) {
				return '0' + val;
			}
			return val;
		}

		function dateShow(currentTime) {
			return '当前时间：<span class="year">' + currentTime.getFullYear() + '</span> 年 <span class="month">' + dateString(currentTime.getMonth() + 1) + '</span> 月 <span class="day">' + dateString(currentTime.getDate()) + '</span> 日 <span class="time">' + dateString(currentTime.getHours()) + ':' + dateString(currentTime.getMinutes()) + '</span>';
		}

		currentTime = new Date();
		$('.current_time').html(dateShow(currentTime));

		window.setInterval(function () {
			currentTime = new Date();
			$('.current_time').html(dateShow(currentTime));
		}, 60000);
	},
	getCurrentCursorPosition: function($ui) {
		var el = $ui.get(0);
		var pos = 0;
		if('selectionStart' in el) {
			pos = el.selectionStart;
		} else if('selection' in document) {
			el.focus();
			var Sel = document.selection.createRange();
			var SelLength = document.selection.createRange().text.length;
			Sel.moveStart('character', -el.value.length);
			pos = Sel.text.length - SelLength;
		}
		return pos;
	},
	formContactCheck: function ($ui) {
		var _r = false;
		// false 就是 没有 联系人组件 、、 true 就是 有 联系人组件
		$ui.each(function () {
			if ($(this).attr('name').indexOf('basic') >= 0) {
				_r = true;
				return false;
			}
		});

		$('.tip_need_contactcomponent').unbind('click').bind('click', function () {
			// -- click to
			var $editField = $('.formBuilder_interim_edit').eq(1),
				$component = $('.formBuilder_edit').eq(1),
				$contact_describeField = $('.contactsUtility>.utility');

			$contact_describeField.each(function (i) {
				var $this = $(this);
				(function (t) {
					$this.css({
						'backgroundColor': '#FFE0C7',
						'color': '#E85305',
						'borderColor': '#E85305'
					});
					window.setTimeout(function () {
						$this.animate({
							'backgroundColor': '#fff',
							'color': '#115A83',
							'borderColor': '#92AFBC'
						}, 200, function () {
							$this.removeAttr('style');
						});
					}, (300 + t));
				})(i * 20);
			});
			$editField.trigger('click');
			$component.scrollTop($component.height());

		});

		if (_r) {
			$('.tip_need_contactcomponent').hide();

			if(!$('#autoAddContact').attr('checked') && $('.createcontact').find('.input_checkbox label').hasClass('gray')){
				$('.form_edit_contact').trigger('click');
				$('.formCreateContacts').show();
			}
			$('.createcontact').show().find('.input_checkbox label').removeClass('gray');			
		} else {
			$('.tip_need_contactcomponent').show();
			$('.createcontact').show().find('.input_checkbox label').addClass('gray');
			$('.formCreateContacts').hide();
			$('#autoAddContact').removeAttr('checked').parent().removeClass('checked');

		}

		return _r;
	},
	formPaymentCheck: function ($ui) {
		var _r = false;
		$ui.each(function () {
			if ($(this).attr('name').indexOf('id_shopping') >= 0) {
				_r = true;
				return false;
			}
		});

		if(!_r){
			// -- no id_shopping;
			$('#payment_ali').removeAttr('checked').parent().removeClass('checked');
            $('.formNoticePaySetting').hide();
            $('.formNoticePaySetting_radio').hide();
		}

		$('.tip_need_payment').unbind('click').bind('click', function () {
			// -- click to
			var $editField = $('.formBuilder_interim_edit').eq(1);
			$editField.trigger('click');
		});


		if (_r) {
			$('.tip_need_payment').hide();
			$('.setpaymentinfo').show();
		} else {
			$('.tip_need_payment').show();
			$('.setpaymentinfo').hide();
		}

		return _r;
	},
	formLimitedItemCheck: function($ui){
		var limitList = {
			"basic_name": 1,
			"basic_city": 1,
			"basic_gender": 1,
			"basic_company": 1,
			"basic_adress": 1,
			"basic_job": 1,
			"basic_website": 1,
			'basic_birthday':1,
			'basic_note': 1
		},resList = {
			"basic_name": 0,
			"basic_city": 0,
			"basic_gender": 0,
			"basic_company": 0,
			"basic_adress": 0,
			"basic_job": 0,
			"basic_website": 0,
			'basic_birthday':0,
			'basic_note': 0
		};

		$ui.each(function () {
			// --
			var name = $(this).attr('name'),
				limitCount = limitList[name];
			if(limitCount){
				resList[name]++;
			}
		});

		for(var i in resList){
			if(resList[i] >= limitList[i]){
				$('#'+i).addClass('limit-disable').data('title',"该表单已添加过该组件");
			} else {
				$('#'+i).removeClass('limit-disable').data('title',"点击选择或拖动到左侧");
			}
		}

        // 手机组件的短信验证码限制
        var basic_mobile = $('#basic_mobile');
        if($('.form_component .mobile_vcode_com').length>0){
            basic_mobile.addClass('limit-disable').data('title',"只能短信验证一个手机");
        }else{
            basic_mobile.removeClass('limit-disable').data('title',"点击选择或拖动到左侧");
        }
	},
	formPageInfoCheck: function($ui){
		var _list_page = [];
		$ui.each(function () {
			// --
			var name = $(this).attr('name');
			if(name === 'id_page'){
				$(this).find('.page_pre').html('第 '+(_list_page.length+1)+' 页');
				$(this).find('.page_next').html('第 '+(_list_page.length+2)+' 页');
				_list_page.push(name);
			}
		});
	},
	getSimpleDate: function (date) {
		var monthList = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
		return monthList[date.getMonth()] + '' + date.getDate();
	},
	mkStringEval: function (s) {
		var LINK_REG = /\[(.+?)]\(([^\(\)]*?)\)/g,
			LINK_TEST_REG = MKGlobal.urlRegEx;
		return s.replace(LINK_REG,function($0,$1,$2){

			var linkList = $.trim($2).split(' ');
				uriTest = (!LINK_TEST_REG.test(linkList[0])),
				newURI = '',
				tmpTitle = '';
			if(uriTest){
				return $0;
			} else {
				newURI = linkList[0].split("://");
				newURI = newURI[0]+'://'+encodeURIComponent(newURI[1]);
				if(linkList[1]){
					tmpTitle = 'title='+JSON.stringify(linkList[1]);
				}
			}
			return '<a link-save="'+newURI+'" target="_blank">'+$1+'<img width="12" height="12" src="/images/icon/externalLink.png"></a>';
		});
	},
	mkHtmlString: function (s){
		var TAG_A_REG = /<[aA][^>]*link-save="([^"]*)"[^>]*>([^<>]*)<['img''IMG'][^>]*src="/images\/icon\/externalLink.png"[^>]*><\/[aA]>/g;
		return s.replace(TAG_A_REG,function($,$1,$2){
			return '['+$2+']('+decodeURIComponent($1)+')';
		});
	},
	mkStringEncode: function (s) {
		return (typeof s != "string") ? s :
			s.replace(/"|&|'|<|>|[\x00-\x20]|[\x7F-\xFF]|[\u0100-\u2700]/g,
				function ($0) {
					var c = $0.charCodeAt(0),
						r = ["&#"];
					c = (c == 0x20) ? 0xA0 : c;
					r.push(c);
					r.push(";");
					return r.join("");
				});
	},
	formSchemeCSSGenerator: function(){
		function __addCss(name, content){
			var styleElem = document.getElementsByTagName('style');
			for(var i=0,len=styleElem.length; i<len; i++){
				if(styleElem[i]){
					if(name === styleElem[i].id){
						styleElem[i].parentNode.removeChild(styleElem[i]);
					}
				}
			}
			$('<style id="'+name+'">'+content+'</style>').appendTo('head');
		}
		var cssInfo = '',
			backgroundInfo = '',
			otherInfo = '',
			titlebk = '';
		if(MKGlobal.formInfo.backgroundAvailable){
			$(document).queue('generateCSSQ',function(){
				if(MKGlobal.formInfo.background){
					backgroundInfo += 'background-image:'+(MKGlobal.formInfo.background||'')+';';
				}
				if(MKGlobal.formInfo.backgroundtype){
					backgroundInfo += 'background-repeat:'+MKGlobal.formInfo.backgroundtype+';';
				}
				if(MKGlobal.formSchemeStruct.imgp){
					backgroundInfo += 'background-position:'+MKGlobal.formSchemeStruct.imgp+' top;';
				}
				$(document).dequeue('generateCSSQ');
			});
		}

		if(MKGlobal.formInfo.titlebkAvailable){
			$(document).queue('generateCSSQ',function(){
				if(MKGlobal.formSchemeStruct.timg && MKGlobal.formSchemeStruct.timg.indexOf('url')>=0){
					
					try{
						var newImg = new Image(),
                            imgSrc = MKGlobal.formSchemeStruct.timg.replace(/^url\(/,'').replace(/\)$/,'');
						newImg.onerror = function(e){
							$(document).dequeue('generateCSSQ');
							// $(document).clearQueue('generateCSSQ');
						};
						newImg.onload = function(){
							var formTitle = $('.form_title'),
                                fullWidth = formTitle.outerWidth(true),
                                fullHeight = parseInt(newImg.height*fullWidth/newImg.width-20);
                            //for IE8 background size, use img target
                            if(navigator.userAgent.match(/msie [8]/i)) {
                                formTitle.css({'position':'relative','padding':'0px'});
                                formTitle.find('.form_title_bgimg_under_ie8').remove();
                                formTitle.children('div').css({'position':'absolute','z-index': 2,'margin':'0px 20px 10px 20px'});

                                otherInfo += '.form_component  .deleteButton {position: relative; z-index: 3;}';

                                var bgimg = $('<img class="form_title_bgimg_under_ie8" src="'+imgSrc+'" style="position:absolute; z-index: 1;"/>');
                                bgimg.width(fullWidth);
                                bgimg.height(fullHeight);
                                formTitle.prepend(bgimg);
                            }else{
                                titlebk += 'background-image:'+(MKGlobal.formSchemeStruct.timg||'')+'; background-size: 100%; background-repeat: no-repeat;';
                            }

                            var formLogo = formTitle.children('.formLogo'),
                                formLogoWidth = formLogo.width() + 10;
                            if(formLogo){
                                formLogo.css({'margin-top':'10px'});
                                formTitle.children('.title').css({
                                    'padding-left':(formLogoWidth > 0 ? formLogoWidth:0),
                                    'width': fullWidth - formLogoWidth - 40
                                });
                            }

                            var titleHeight = $('.form_title .title').height(),
                                logoHeight = formLogo.height(),
                                maxContentHeight = titleHeight > logoHeight? titleHeight : logoHeight;
                            titlebk += 'height:'+( maxContentHeight < fullHeight ? fullHeight : maxContentHeight )+'px;';

                            formTitle.attr('titlebackgroundimg', (MKGlobal.formSchemeStruct.timg||''));
                            $(document).dequeue('generateCSSQ');
						};
                        //for IE
                        newImg.src = imgSrc;
                    } catch(e){
						$(document).clearQueue('generateCSSQ');
					}
				} else {
					$(document).dequeue('generateCSSQ');
				}
			});
		}else{
            $('.form_title').attr('titlebackgroundimg', '');
        }

		$(document).queue('generateCSSQ',function(){
			cssInfo += '.formBuilder_example_all .formBuilder_example, #form_logic_mask, .logic_fake{background-color:#'+MKGlobal.formSchemeStruct.wb+'; color:#'+MKGlobal.formSchemeStruct.wt+';'+backgroundInfo+'}.break_color{background-color:#'+MKGlobal.formSchemeStruct.wb+'}';
			cssInfo += '.formBuilder_example_all .form_title,.logic_mask_main .form_title{background-color:#'+MKGlobal.formSchemeStruct.lb+';color:#'+MKGlobal.formSchemeStruct.lt+';'+titlebk+'}';
			cssInfo += '.formBuilder_example_all .formBuilder_main .form_component,'+
                       '.formBuilder_example_all .formBuilder_main .logic_form_item,'+
                       '.formBuilder_example_all .formBuilder_main  .logic_mask_main{background-color:#'+MKGlobal.formSchemeStruct.fb+';color:#'+MKGlobal.formSchemeStruct.ft+';}';
			cssInfo += '.formBuilder_example_all .formBuilder_main .form_component>li{background-color:#'+MKGlobal.formSchemeStruct.fb+';color:#'+MKGlobal.formSchemeStruct.ft+';}';
			cssInfo += '.formBuilder_example_all .form_component .title,'+
                       '.formBuilder_example_all .form_component .mbvc_title  {font-size:'+MKGlobal.formSchemeStruct.fs+';line-height: '+MKGlobal.formSchemeStruct.flh+';}';
			cssInfo += '.formBuilder_example_all .form_component .shopping-item .item_name {font-size:' + (parseInt(MKGlobal.formSchemeStruct.fs, 10) - 2) + 'px;}';
			cssInfo += '.formBuilder_example_all .form_component .optionValue {font-size:' + (parseInt(MKGlobal.formSchemeStruct.fs, 10) - 2) + 'px;}';
			cssInfo += '.formBuilder_example_all .form_component .instruct,'+
                       '.formBuilder_example_all .form_component .mbvc_instruct,'+
                       '.formBuilder_example_all .form_component .subtitle{color:#'+MKGlobal.formSchemeStruct.it+';border-color:#'+MKGlobal.formSchemeStruct.it+'}';
			cssInfo += '.formBuilder_example_all .formBuilder_main .form_component .clicked{background-color:#'+MKGlobal.formSchemeStruct.hb+';color:#'+MKGlobal.formSchemeStruct.ht+'}';

			cssInfo += '.style_design_pad .sdp_color_wb{background-color:#'+MKGlobal.formSchemeStruct.wb+'}';
			cssInfo += '.style_design_pad .sdp_color_lb{background-color:#'+MKGlobal.formSchemeStruct.lb+'}';
			cssInfo += '.style_design_pad .sdp_color_ft{background-color:#'+MKGlobal.formSchemeStruct.ft+'}';
			cssInfo += '.style_design_pad .sdp_color_fb{background-color:#'+MKGlobal.formSchemeStruct.fb+'}';
			cssInfo += '.style_design_pad .sdp_color_it{background-color:#'+MKGlobal.formSchemeStruct.it+'}';
			cssInfo += '.style_design_pad .sdp_color_lt{background-color:#'+MKGlobal.formSchemeStruct.lt+'}';

            cssInfo += otherInfo;

			__addCss('form_style_scheme',cssInfo);
            $('.formBuilder_example').getNiceScroll().resize();
		});

		$(document).dequeue('generateCSSQ');
		// alert('--generateCSSQ--');
	},
	formColorPicker: function($ui,changeCallback){
		$ui.colpick({
			layout: 'hex',
			submit: 0,
			onChange: changeCallback
		});
	},
	// 表单的逻辑部分
	formTitleListGetter: function(){
		// 找到 组件
		// 按 组件 生成 array
		var _r = [],
			$formComponents = $('.form_component').find('.ui-draggable');
		if($formComponents.length>0){
			var tmpComponent;
			$formComponents.each(function(){
				var $this = $(this);
				if(/* $this.attr('name') !== 'id_picture' && $this.attr('name') !== 'id_section' && */$this.attr('name') !== 'id_page'){
					tmpComponent = {
						name: $this.find('.title_field').find('.title').text()||$this.find('.subtitle').text(),
						id: $this.attr('id'),
						type: $this.attr('name')
					};

					if($.inArray($this.attr('name'),['id_radio'/*,'id_checkBox'*/, 'basic_gender', 'id_dropDown', 'id_pictureRadio'/*, 'id_pictureCheckbox'*/])>-1){
						var _values = [];
						switch($this.attr('name')){
							case 'id_radio':
								$this.find('.optionsLine').each(function(){
									var $self = $(this);
									_values.push({
										"serialNo": $self.find('input[type="radio"]').attr('value'),
										"content": $self.text()
									});
								});
								break;
							// case 'id_checkBox':
							// 	$this.find('.optionsLine').each(function(){
							// 		var $self = $(this);
							// 		_values.push({
							// 			"serialNo": $self.find('input[type="checkbox"]').attr('value'),
							// 			"content": $self.text()
							// 		});
							// 	});
							// 	break;
							case 'basic_gender':
								$this.find('.optionsLine').each(function(){
									var $self = $(this);
									_values.push({
										"serialNo": $self.find('input[type="radio"]').attr('value'),
										"content": $self.text()
									});
								});
								break;
							case 'id_dropDown':
								$this.find('option').each(function(){
									var $self = $(this);
									if($self.attr('name') >= 0){
										_values.push({
											"serialNo": $self.attr('name'),
											"content": $self.text()
										});
									}
								});
                                if($this.find('select').attr('other') == 'true'){// logic for dropdown other, 20160329 Russell
                                    _values.push({
                                        "serialNo": 'on',
                                        "content": '其他'
                                    });
                                }
								break;
							case 'id_pictureRadio':
								$this.find('.picradio_contect').each(function(){
									var $self = $(this);
									_values.push({
										"serialNo": $self.find('input[type="radio"]').attr('value'),
										"content": $self.find('.optionValue').text()
									});
								});
								break;
							// case 'id_pictureCheckbox':
							// 	$this.find('.piccheckbox_contect').each(function(){
							// 		var $self = $(this);
							// 		_values.push({
							// 			"serialNo": $self.find('input[type="checkbox"]').attr('value'),
							// 			"content": $self.text()
							// 		});
							// 	});
							// 	break;
						}
						tmpComponent.data = $this.data('Logic_Setting');
						tmpComponent.value = _values;
					}

					_r.push(tmpComponent);
				}
			});
		}
		return _r;
	},
	formGetAllWillHideComponent: function(infoList){
		var tmpElem,
			allHideElem = [],	// 所有被隐藏的组件
			jumptoElem = [],	// 所有被跳转到的组件
			dataInfo = [],	// 组件的隐藏的缓存
			$elem,elemData,
			tmp,tmpO,
			i=0,len = infoList.length;

		// get all need hide
		for(i=0; i<len; i++){
			// =->找出所有会被隐藏的元素
			tmpElem = infoList[i];
			$elem = $('#'+tmpElem.id);
			elemData = $elem.data('Logic_Setting');
			if(elemData){
				// console.info(i);
				// console.log(elemData);
				if(elemData.jumpto){
					// find after..
					for(var _innerLoop=(i+1); _innerLoop<len; _innerLoop++){
						if(elemData.jumpto !== 'end'){
							// console.log(infoList[_innerLoop]);
							if(infoList[_innerLoop].id === elemData.jumpto){
								if($.inArray(infoList[_innerLoop].id, allHideElem) == -1){
									allHideElem.push(infoList[_innerLoop].id);
								}
								if($.inArray(infoList[_innerLoop].id, jumptoElem) == -1){
									jumptoElem.push(infoList[_innerLoop].id);
								}
								break;
							}
						}
						// console.log('--jumpto'+infoList[_innerLoop].id);
						if($.inArray(infoList[_innerLoop].id, allHideElem) == -1){
							allHideElem.push(infoList[_innerLoop].id);
						}
					}
				} else if(elemData.showWith){
					// pass .
				} else {
					// find after..
					var __flag = true;
					// console.log(elemData);
					for(var _dataindex in elemData){

						for(var _innerLoop=(i+1); _innerLoop<len; _innerLoop++){
							// dataInfo.push(elemData[_dataindex]);
							if(elemData[_dataindex] !== 'end'){
								if(infoList[_innerLoop].id === elemData[_dataindex]){
									if($.inArray(infoList[_innerLoop].id, allHideElem)==-1){
										allHideElem.push(infoList[_innerLoop].id);
									}
									if($.inArray(infoList[_innerLoop].id, jumptoElem) == -1){
										jumptoElem.push(infoList[_innerLoop].id);
									}
									// console.log('break');
									// break;
									__flag = false;
								} else {
									if(__flag){
										// console.log('run...');
										if($.inArray(infoList[_innerLoop].id, allHideElem)==-1){
											allHideElem.push(infoList[_innerLoop].id);
										}
										// console.info(allHideElem);
									}
								}
							} else {
								if($.inArray(infoList[_innerLoop].id, allHideElem)==-1){
									allHideElem.push(infoList[_innerLoop].id);
								}
							}
						}
					}
				}
			}
		}

		return {
			all: allHideElem,
			jumpTag: jumptoElem
		};
	},
	// 跟随关系的可选项的列表
	formStaticFollowListGetter: function(){
		// 获取静态元素是否有紧邻的符合条件的元素
		function hasLogicComponentPrev(infoList, i, allHideElem){
			// infoList 是查询的列表， i 是从 i 的位置查找前方有没有符号条件的元素
			if(i > 0){
				var tmpElem = infoList[i-1],
					tmpData = $('#'+tmpElem.id).data('Logic_Setting');

				if($.inArray(tmpElem.type,['id_section','id_picture']) == -1){
					if(tmpData || $.inArray(tmpElem.id,allHideElem)>=0){
						return tmpElem.id;
					}
				} else {
					if(i-1 !== 0){
						return hasLogicComponentPrev(infoList, i-1, allHideElem);
					} else {
						return false;
					}
				}
			}
			return false;
		}

		function hasLogicComponentNext(infoList, i, allHideElem){
			// infoList 是查询的列表， i 是从 i 的位置查找后面有没有符合条件的元素
			if(i<infoList.length-1){
				var tmpElem = infoList[i+1],
					tmpData = $('#'+tmpElem.id).data('Logic_Setting');

				if($.inArray(tmpElem.type,['id_section','id_picture']) == -1){
					if(tmpData || $.inArray(tmpElem.id,allHideElem)>=0){
						return tmpElem.id;
					}
				} else {

					if(i+1 < infoList.length){
						// console.log('-next ::'+(i+1));
						return hasLogicComponentNext(infoList, i+1, allHideElem);
					} else {
						return false;
					}
				}
			}
			return false;
		}

		// 检查静态元素是否紧邻在符合条件的元素，每次切换变化都需要check
		var _R,
			tmpElem,
			infoList = MKFORM.formUtility.formTitleListGetter(),
			allHideElem = MKFORM.formUtility.formGetAllWillHideComponent(infoList),	// 所有被隐藏的组件
			dataInfo = [],	// 组件的隐藏的缓存
			$elem,elemData,
			tmp,tmpO,
			i=0,len = infoList.length;


		// console.log(allHideElem);

		for(i=0; i<len; i++){
			tmpElem = infoList[i];
			if($.inArray(tmpElem.type,['id_section','id_picture']) >= 0 && $.inArray(tmpElem.id,allHideElem.all) >= 0 && $.inArray(tmpElem.id,allHideElem.jumpTag) === -1){
				// dataInfo[] = [];
				tmpO = {};
				tmpO.id = tmpElem.id;
				if(tmp=hasLogicComponentPrev(infoList, i, allHideElem)){
					tmpO.prev = tmp;
				}
				// console.log('====== next ====');
				if(tmp=hasLogicComponentNext(infoList, i, allHideElem)){
					tmpO.next = tmp;
				}
				if(JSON.stringify(tmpO) !== '{"id":"'+tmpElem.id+'"}'){
					dataInfo.push($.extend(true, {}, tmpO));
				}
				// console.log('====== next end ====');
			}
		}
		// console.log(dataInfo);
		if(dataInfo.length === 0){
			_R = false;
		} else {
			_R = dataInfo;
		}
		// find result
		return _R;
	},
	formStaticComponentFollowChecker: function(cominfo, id){
		// 传入一个元素的 component jump data / id 用于确定位置
		var infoList = MKFORM.formUtility.formTitleListGetter(),
			staticList = MKFORM.formUtility.formStaticFollowListGetter(),
			comShow = false,	// 现在组件指向的是哪个
			comState = false,	// 现在组件的方向
			index = false,
			i,len,j,
			tmpList = [];


		for(i=0,len=infoList.length; i<len; i++){
			if(infoList[i].id === id){
				index = i;
				break;
			}
		}

		// 它的外层是对所有的组件进行循环的检查
		// 这里专注于检查每一个组件
		// 前提： 前一个组件已经检查到没有问题
		if(cominfo){
			comState = cominfo.condition;
			if(comState === 'next' || comState === 'prev'){
				comShow = cominfo.showWith;
				// 确定组件是否在应该在的方向上
				var _exsistFlag = false,
					_exsistIndex = false;

				if(index){
					if(comState === 'next'){
						for(j = index+1; j<len; j++){
							if(infoList[j].id === comShow){
								_exsistFlag = true;
								_exsistIndex = infoList[j].id;
								break;
							}
						}
					} else if(comState === 'prev'){
						for(j = 0; j<index; j++){
							if(infoList[j].id === comShow){
								_exsistFlag = true;
								_exsistIndex = infoList[j].id;
								break;
							}
						}
					}
				}

				if(_exsistFlag === false){
					// 不存在在线上则取消
					$('#'+id).data('Logic_Setting',false);
				} else {
					// 如果存在，那么距离有多远？
					tmpList = [];
					var currentIndex = false;
					for(i=0,len=infoList.length; i<len; i++){
						if((infoList[i].type !== 'id_section' && infoList[i].type !== 'id_picture') || i === index){
							tmpList.push(infoList[i].id);
						}
					}
					for(j=0; j<tmpList.length; j++){
						if(tmpList[j] === _exsistIndex){
							_exsistIndex = j;
						}
						if(tmpList[j] === id){
							currentIndex = j;
						}
					}
					if(currentIndex === false){
						$('#'+id).data('Logic_Setting',false);
					}else if(_exsistIndex-currentIndex !== -1 && _exsistIndex-currentIndex !== 1){
						$('#'+id).data('Logic_Setting',false);
						// 距离大于 1 的时候已经不正常了
					}
				}
			}
		}

		if(comShow){
			if(index !== false){
				var prevStatic = getPrevStaticState(infoList, index, staticList);
				if (prevStatic === true){
					$('#'+id).data('Logic_Setting',false);
				} else if(prevStatic) {
					if(prevStatic.state === 'next'){
						$('#'+id).data('Logic_Setting',false);
					}
					// 如果是向上的就不管这个了。
				} else {
					// 上一个没有状态 或者上一个也是没有状态的
					// 这个状态不能为上
					// if(comState === 'prev'){
					// 	$('#'+id).data('Logic_Setting',false);
					// }
					// console.log('---');
					// $('#'+id).data('Logic_Setting',false);
				}
			} else {
				if($('#'+id).data('Logic_Setting')){
					$('#'+id).data('Logic_Setting',false);
				}
			}
			
		}

		// 获取前方一个的元素的方向，如果前方没有，就只能跟后方，如果前方是跟随上一个的，那么这个就略过，如果是跟随后一个的，那么当前这个只能为跟随后一个。

		function getPrevStaticState(infoList, i, staticList){
			if(i > 0){
				var tmpElem = infoList[i-1],
					tmpData = $('#'+tmpElem.id).data('Logic_Setting'),
					currentData = $('#'+infoList[i].id).data('Logic_Setting');
				// FIXED ME!!!
				if($.inArray(tmpElem.type,['id_section','id_picture']) === -1){
					if(currentData){
						if(currentData.showWith){
							if(currentData.showWith = tmpElem.id){
								return false;
							} else {
								// 不相等了，要进行清除
								return true;
							}
						} else {
							// 没有 showWith -- 不处在跟随的状态
							return false;
						}
					} else {
						// 没有 logic_data , 不做处理
						return false;
					}
				} else {
					var state = false;
					if(tmpData){
						if(tmpData.showWith){
							for(var j=0,len=staticList.length; j<len; j++){
								for(var staticName in staticList[j]){
									if(staticList[j][staticName] === tmpData.showWith && staticName !== 'id'){
										state = {
											'id': staticList[j].id,
											'state': staticName
										};
										break;
									}
								}
								if(state){
									break;
								}
							}
							return state;
						} else {
							return false;
						}
					}

				}
			}
			return false;
		}
	},
	// 表单逻辑检查
	formLogicCheck: function($ui){
		var comList = MKFORM.formUtility.formTitleListGetter();
		$ui.each(function() {
			var $this = $(this),
				comIndex = $this.index(),
				currentList = comList.slice(comIndex+1, comList.length),
				_data = $this.data('Logic_Setting');
			currentList = currentList.map(function(v){
				return v.id;
			});
			if(_data){
				if(_data.hasOwnProperty('condition')){
					if($.inArray(_data.jumpto,currentList)<0){
						_data = false;
					}
				} else {
					for(var i in _data){
						if(_data.hasOwnProperty(i)){
							if($.inArray(_data[i],currentList)<0){
								// remove
								_data[i] = false;
							}
						}
					}
				}
			}

			$this.data('Logic_Setting',_data);
		});
	},
	// 表单组件是否进行跟随检查
	formStaticFollowCheck: function($ui){
		$ui.each(function() {
			var $this = $(this);
			// 如果有 showWith 但是不在 follow 表中，取消 follow 选项
			// 如果在的话， 检查它前后的元素 follow 方向
			MKFORM.formUtility.formStaticComponentFollowChecker($(this).data('Logic_Setting'), $(this).attr('id'));
		});
	},
	// 表单自动存储
	formAutoSaveMachine: function(){
		var timerSaveInterval = false,	// 存储了
			noActiveSaveInterval = false,
			saveTimestarp;
		var _checkUnsaveInterval = window.setInterval(function(){
			if(MKGlobal.unsaveinfo !== 0){
				window.clearInterval(_checkUnsaveInterval);
				// alert();
				saveTimestarp = (new Date()).valueOf();
				window.setInterval(function(){
					// 定时存储
				}, 600000);

				window.setInterval(function(){
					// 定时存储
				}, 320000);
			}
		},5000);	// 5s check.

		return function(){
			// change status;
		};
	}
};

// 表单中的每一个组件绑定事件
function renderFormComponent($ui) {
	// 记得最后要 nicescroll resize 一下
	if ($ui) {
		var componentId = $ui.attr('id'),
			componentName = $ui.attr('name');

		if (MKFORM.currentComponent !== componentId) {
			MKFORM.currentComponent = componentId;
			MKFORM.currentChanged = true;
		} else {
			MKFORM.currentChanged = false;
		}
		MKFORM.editManager(componentName);

		$.each(MKFORM.editFunctionMap[componentName], function (key, val) {
			MKFORM.componentSetting[val].bind();
		});
	} else {
		MKFORM.editManager(false);
	}

	$('#form_componentEdit').getNiceScroll().resize();
}

// 有些时候进行了组件类型的修改，需要调用重新渲染一下
function reRenderFormComponent(id) {
	// 记得最后要 nicescroll resize 一下
}
init();
// 绑定拖动的事件 / 初始化
function init() {
	$(document).queue('MKFORMEDIT', function () {
		// 1. 添加组件 的拖动
		var $componentList;
		utilityDrag().bind();
		formItemSortable();
		addOptionDrag();
		serialSet();
		// 2. 表单设置的初始化
		MKFORM.formSetting.formTitle.bind();
		MKFORM.formSetting.formSubTitle.bind();
		MKFORM.formSetting.formSchemeChange.bind();
		MKFORM.formSetting.formChangeLogo.bind();

		MKFORM.formSetting.formTitleClick.bind();
 
		MKFORM.formSetting.formChangeTitleBackground.bind();

		MKFORM.formSetting.formChangeBackground.bind();
		MKFORM.formSetting.formCustomScheme.bind();
		// 收集时间控制
		MKFORM.formSetting.formStartTime.bind();
		MKFORM.formSetting.formSetMaxiumFeedback.bind();
		MKFORM.formSetting.formSetUnique.bind();
		MKFORM.formSetting.formOnlyWechat.bind();
		MKFORM.formSetting.formEndTime.bind();

		// 可以控制的分享按钮
		MKFORM.formSetting.formShowShare.bind();
		// 可以控制是否查看统计
		MKFORM.formSetting.formEndSeeRes.bind();
		MKFORM.formSetting.formEndSeeResDetail.bind();
        MKFORM.formSetting.formFeedbackDetailPasswd.bind();

		// 可以控制是否生成随机码
		MKFORM.formSetting.formEndGeneRan.bind();
		
		MKFORM.formSetting.formSetPayment.bind();

		MKFORM.formSetting.formAutoCreateContact.bind();

		MKFORM.formSetting.formAfterSubmit.bind();
		MKFORM.formSetting.formFeedbackNotice.bind();
		MKFORM.formSetting.formFeedbackNoticeSMS.bind();
		// TODO 完成初始化的工作
		// finish ...
		MKFORM.formUtility.formSetCurrentTime();
		MKFORM.formSetting.formFinishLoading();

		// -- logic
		MKFORM.formSetting.formLogicShow();


		$componentList = $('.form_component').children('.ui-draggable');
		MKFORM.formUtility.formContactCheck($componentList);
		MKFORM.formUtility.formPaymentCheck($componentList);
		MKFORM.formUtility.formLimitedItemCheck($componentList);
		MKFORM.formUtility.formPageInfoCheck($componentList);
		MKFORM.formUtility.formStaticFollowCheck($componentList);
		
		MKFORM.formUtility.formSchemeCSSGenerator();
		// --
		MKGlobal.unsaveinfo = 0;

		// edit first show pad
		if(MKGlobal.fb === '0' || MKGlobal.fb === '1'){
			$('.style_design_pad').trigger('click');
		}
		// $('.btn_example_save').addClass('allsaved').text('');
	});
}


// 给 id 下的 option中的元素加上 拖动事件
function addOptionDrag() {
	var $componentContainer = $(".formBuilder_main .form_component");
	$componentContainer.find(".optionGarden").sortable({
		opacity: 0.8,   //拖动时候的透明度
//		axis: "y",
		stop: function (event, ui) {
			$(this).parents(".ui-draggable").trigger("click");
			MKGlobal.addUnsaveCount();
		}
	});
    $componentContainer.find(".pictureCheckboxList,.pictureRadioList").sortable({
		opacity: 0.8,   //拖动时候的透明度
//		axis: "y",
        start: function(event, ui) {
            $(this).children('li').removeClass('clearB');
        },
		stop: function (event, ui) {
            var ul = $(this);
            ul.children('li').each(function(i){
                if(i%3==0){
                    $(this).addClass('clearB');
                }
            });
            ul.closest(".ui-draggable").trigger("click");
			MKGlobal.addUnsaveCount();
		}
	});
    var shoppingSelect_index = null;
    $componentContainer.find(".shoppingList").sortable({
		opacity: 0.8,   //拖动时候的透明度
//		axis: "y",
        start: function(event, ui) {
            var item = ui.item;
            if(item.is('li:not(.empty)')){
                $(this).children('li:not(.empty)').removeClass('clearB');
                shoppingSelect_index = item.index();
            }
        },
		stop: function (event, ui) {
            var ul = $(this),
                $selectedCom = ul.closest(".ui-draggable"),
                item = ui.item;
            if(item.is('li:not(.empty)')) {
                ul.children('li:not(.empty)').each(function (i) {
                    if (i % 3 == 0) {
                        $(this).addClass('clearB');
                    }
                });
                var shoppingInfo = $selectedCom.data('shoppingInfo');
                if (!shoppingInfo) {
                    $selectedCom.data('shoppingInfo', []);
                } else {
                    if(shoppingSelect_index!==null){
                        var new_index = item.index() - 1,
                            old_index = shoppingSelect_index - 1;
                        if(new_index!==old_index){
                            var info = shoppingInfo.splice(old_index, 1);
                            shoppingInfo.splice(new_index, 0, info[0]);
                            $selectedCom.data('shoppingInfo', shoppingInfo);
                        }
                    }
                }
                $selectedCom.trigger("click");
				/* 更新一下 itemid 的顺序 */
				$selectedCom.find('.shopping-item').not('.empty').each(function (i, el) {
					$(el).attr('itemid', i);
				});

				// _recalculateBySortable
				_recalculateBySortable($selectedCom);

                MKGlobal.addUnsaveCount();
            }
		}
	});
}

function _recalculateBySortable($selectedCom) {
	var $list = $selectedCom.find('.shoppingList');
	var $items = $list.find('.shopping-item').not('.empty');
	// 1. 找到现在总共的商品个数
	if($items && $items.length > 0) {
		var maxHeightArray = _findEveryLineMaxHeight($items);
		var total = $items.length;
		var line = Math.ceil(total / 3);
		var startIndex = 0;
		var endIndex = 0;

		for(var i = 0; i <= line; ++i) {
			startIndex = i * 3;
			endIndex = startIndex + 3;
			for(var j = startIndex; j < endIndex; ++j) {
				var $item = $items.eq(j);
				if($item && $item.length === 0) {
					break;
				}
				$item.height(maxHeightArray[i]);
			}
		}
	}
}

function _findEveryLineMaxHeight($items) {
	var heightArray = [];
	var maxHeightArray = [];
	var total = $items.length;
	var line = Math.ceil(total / 3);

	var startIndex = 0;
	var endIndex = 0;
	for(var i = 0; i <= line; ++i) {
		startIndex = i * 3;
		endIndex = startIndex + 3;
		for(var j = startIndex; j < endIndex; ++j) {
			var $item = $items.eq(j);
			if($item && $item.length === 0) {
				break;
			}
			$item.removeAttr('style');
			var h = $item.outerHeight();
			heightArray.push(h);
		}
		if(heightArray && heightArray.length > 0) {
			maxHeightArray.push(Math.max.apply(null, heightArray));
			heightArray = [];
		} 
	}

	return maxHeightArray;
}

MKFORM.serialCount = (function () {
	var count = 0;
	return {
		_getCount: function () {
			return count;
		},
		_setCount: function (newCount) {
			count = newCount;
		},
		_selfAdd: function () {
			count++;
		}
	};
})();

function serialSet() {
	var serialArray = [];

	// 获取所有会统计元素的 id 列表
	MKFORM.formAnalysisList = [];
	// - 算出最大的一个值
	if(MKGlobal.formInfo.formMN === false){
		$(".ui-draggable").each(function () {
			var $this = $(this);
			if($.inArray($this.attr('name'),['id_checkBox','id_radio','id_star','id_number','id_pictureRadio','id_pictureRadio','id_pictureCheckbox','id_dropDown']) >= 0){
				MKFORM.formAnalysisList.push($this.attr("id"));
			}
			serialArray.push($this.attr("id").replace(/[^\d]/g, ''));
		});
		serialArray.sort(function (a, b) {
			return (a - b);
		});
		// 赋值最大值
		if (serialArray.length > 0) {
			MKFORM.serialCount._setCount(serialArray[serialArray.length - 1]);
		}
	} else {
		$(".ui-draggable").each(function () {
			var $this = $(this);
			if($.inArray($this.attr('name'),['id_checkBox','id_radio','id_star','id_number','id_pictureRadio','id_pictureRadio','id_pictureCheckbox','id_dropDown']) >= 0){
				MKFORM.formAnalysisList.push($this.attr("id"));
			}
		});
		if(MKGlobal.formInfo.formMN > 0){
			MKFORM.serialCount._setCount(MKGlobal.formInfo.formMN);
		}
	}

}

function utilityDrag() {
	var htmlMap = {
		id_checkBox: function (name) {
			var options = '',
				count = 0,
				defaults = ["选项1", "选项2", "选项3"];
			$.each(defaults, function (n) {
				options += '<li class="optionsLine medium"><input type="checkbox" name="checkbox' + MKFORM.serialCount._getCount() + '" value="' + count + '" disabled=true><label class="optionValue">' + defaults[n] + '</label></li>';
				count++;
			});
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div class="checkbox"><ul class="optionGarden">' + options + '</ul><div class="clearB"></div></div>';
		},
		id_dropDown: function (name) {
			var options = '',
				count = 0,
				defaults = ["选项1", "选项2", "选项3"];
			$.each(defaults, function (n) {
				options += '<option name="' + count + '">' + defaults[n] + '</option>';
				count++;
			});
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div class="select"><select class="medium" disabled=true><option name="-1">请选择</option>' + options + '</select></div>';
		},
		id_multiple: function (name) {
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div><textarea class="textarea medium" disabled=true></textarea></div>';
		},
		id_number: function (name) {
			return this.id_singleLine(name);
		},
		id_radio: function (name) {
			var options = '',
				count = 0,
				defaults = ["选项1", "选项2", "选项3"];
			$.each(defaults, function (n) {
				options += '<li class="optionsLine medium"><input type="radio" name="radio' + MKFORM.serialCount._getCount() + '" value="' + count + '" disabled=true><label class="optionValue">' + defaults[n] + '</label></li>';
				count++;
			});
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div class="radio"><ul class="optionGarden">' + options + '</ul><div class="clearB"></div></div>';
		},
		id_singleLine: function (name) {
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div><input type="text" class = "input medium" disabled=true></div>';
		},
		id_section: function (name) {
			var defaultSubtitle = "这里填写你的描述";
			return '<span class="title_field"><label class="title">' + name + '</label></span><hr><div class="subtitle">' + defaultSubtitle + '</div>';
		},
		id_page: function (name) {
			return '<div class="page_pre"></div><div class="page"><div class="same-as-break break_color"></div></div><div class="page_next"></div>';
		},
		id_fileUpload: function (name) {
			return  '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div><div class="upload_file medium"><input type="file" class="input_file" name="_FILE_" data-url="" disabled=true><p>请选择小于20M的文件进行上传</p><img src="/images/icon/importFileAdd.png"></div></div>';
		},
		id_star: function (name) {
			return  '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div><div class="starGroup" starSelected="0"><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span><span class="star"></span></div></div>';
		},
		id_date: function (name) {
			return  '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span><div><input type="text" class = "date input medium" dateType="d" disabled=true></div>';
		},
		id_shopping: function (name) {
			var title = '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span>',
				field = '<div class="shopping"><ul class="shoppingList"><li class="shopping-item empty">暂时没有商品</li></ul><div class="clearB"></div></div>';
			return title + field;
		},
		id_picture: function (name) {
			var defaultSubtitle = "这里是"+name+",写下你对它的描述";
			return '<div class="title_field img_title"><img src="/images/icon/formDefaultPicture.png" style="width: 100%;"><input type="file" class="in_pic_upload" name="_FILE_" /></div><div class="subtitle">' + defaultSubtitle + '</div>';
		},
		id_pictureCheckbox: function (name) {
			var title = '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span>',
				field = '',options = '',
				count = 0,
				defaults = ["选项1", "选项2", "选项3"];
			$.each(defaults, function (n) {
				options += '<li class="picturecheckbox-item'+(count===0?' clearB':'')+'" listfield="0"><div class="piccheckbox_img"></div><div class="piccheckbox_contect"><input type="checkbox" name="picturecheckbox' + MKFORM.serialCount._getCount() + '" value="' + count + '" disabled="disabled"><label class="optionValue">' + defaults[n] + '</label></div></li>';
				count++;
			});;

			field = '<div class="picture_checkbox"><ul class="pictureCheckboxList">'+options+'</ul><div class="clearB"></div></div>';
			return title + field;
		},
		id_pictureRadio: function (name) {
			var title = '<span class="title_field"><label class="title">' + name + '</label><span class="com_required"></span></span>',
				field = '',options = '',
				count = 0,
				defaults = ["选项1", "选项2", "选项3"];
			$.each(defaults, function (n) {
				options += '<li class="pictureradio-item'+(count===0?' clearB':'')+'" listfield="0"><div class="picradio_img"></div><div class="picradio_contect"><input type="radio" name="pictureradio' + MKFORM.serialCount._getCount() + '" value="' + count + '" disabled="disabled"><label class="optionValue">' + defaults[n] + '</label></div></li>';
				count++;
			});;

			field = '<div class="picture_radio"><ul class="pictureRadioList">'+options+'</ul><div class="clearB"></div></div>';
			return title + field;
		},
		basic_name: function (name) {
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required">*</span></span><div><input type="text" class = "input medium" disabled=true></div>';
		},
		basic_city: function (name) {
			return this.basic_name(name);
		},
		basic_job: function (name) {
			return this.basic_name(name);
		},
		basic_company: function (name) {
			return this.basic_name(name);
		},
		basic_weixin: function (name) {
			return this.basic_name(name);
		},
		basic_adress: function (name) {
			return this.basic_name(name);
		},
		basic_phone: function (name) {
			return this.basic_name(name);
		},
		basic_birthday: function (name) {
			return this.basic_name(name);
		},
		basic_fax: function (name) {
			return this.basic_name(name);
		},
		basic_gender: function (name) {
			var options = '',
				count = 0,
				defaults = ["先生", "女士"];
			$.each(defaults, function (n) {
				options += '<li class="optionsLine medium"><input type="radio" name="radio' + MKFORM.serialCount._getCount() + '" genderValue="' + ((count === 1) ? "F" : "M") + '" value="' + count + '" disabled=true><label class="optionValue">' + defaults[n] + '</label></li>';
				count++;
			});
			return '<span class="title_field"><label class="title">' + name + '</label><span class="com_required">*</span></span><div class="radio"><ul class="optionGarden">' + options + '</ul><div class="clearB"></div></div>';
		},
		basic_email: function (name) {
			return this.basic_name(name);
		},
		basic_website: function (name) {
			return this.basic_name(name);
		},
		basic_mobile: function (name) {
			return this.basic_name(name);
		},
		basic_qq: function (name) {
			return this.basic_name(name);
		},
		basic_note: function (name) {
			return this.basic_name(name);
		},
		"undefined": function () {
			return "";
		}
	};

	function MKBind() {
        var formBuilder_edit = $('.formBuilder_edit'), formBuilder_edit_tooltip_timer;
        // 添加组件 tooltip 功能，取 data-title 属性的值
        formBuilder_edit.off('mouseenter').on('mouseenter', '.ui-draggable' , function(e){
            var pageY = e.pageY+10, pageX = e.pageX+10, text = $(this).data('title');
            if(formBuilder_edit_tooltip_timer) {
                clearTimeout(formBuilder_edit_tooltip_timer);
                formBuilder_edit_tooltip_timer = null;
            }
            formBuilder_edit_tooltip_timer = setTimeout(function(){
                $('#formBuilder_edit_tooltip').text(text).css({'display':'inline-block','top':pageY,'left':pageX});
            }, 100);
        });
        formBuilder_edit.off('mouseleave').on('mouseleave', '.ui-draggable' , function(e){
            //if($(e.target).is('li')){
                if(formBuilder_edit_tooltip_timer) {
                    clearTimeout(formBuilder_edit_tooltip_timer);
                    formBuilder_edit_tooltip_timer = null;
                }
                $('#formBuilder_edit_tooltip').hide();
            //}
        });
        formBuilder_edit.find('.utility').unbind('click').bind('click',function () {
			var $componentContainer = $(".formBuilder_main .form_component"),
				utilityId = $(this).attr('id'),
				utilityText = $(this).find('.title').text(),
				componentHTML = htmlMap[utilityId](utilityText),
				componentTitle = "点击进行修改,拖动交换位置,按住Ctrl拖动即可复制.";

			//2014.9.25 Smily添加判断：唯一联系人组件的title不显示按住Ctrl拖动可复制
			var limitList = ["basic_name","basic_city","basic_gender","basic_company","basic_adress","basic_job","basic_website",'basic_birthday','basic_note'];
			if ( $.inArray(utilityId,limitList)!=-1 ) { 
				componentTitle = "点击进行修改,拖动交换位置.";
			}

			// add To last ...
			if(!$(this).hasClass('limit-disable')){
				MKFORM.serialCount._selfAdd();
				$(this).clone().html(componentHTML).appendTo($componentContainer).removeClass('utility').attr({
					"id": "com" + MKFORM.serialCount._getCount(),
					"name": utilityId,
					"title": componentTitle
				}).addClass('unedited');

				formItemSortable();
				addOptionDrag();

				$(".formBuilder_example").stop().animate({
					scrollTop: $componentContainer.height()
				}, 300, function () {
					$(".formBuilder_example").getNiceScroll().resize();
				});
				MKGlobal.addUnsaveCount();
			}
		}).draggable({
				appendTo: "body",
				helper: "clone",
				cancel: ".limit-disable",
				opacity: 0.8,
				revert: false,
				distance: 2,
				connectToSortable: $(".formBuilder_main .form_component"),
				start: function (event, ui) {
					$(".ui-draggable-dragging").css({
						"height": "auto",
						"float": "none",
						"width": "170px"
					}).attr("id", $(event.target).attr("id"));
				},
				drag: function (event, ui) {
				},
				stop: function (event, ui) {
					var utilityId = ui.helper.attr('id'),
						utilityText = ui.helper.text(),
						componentHTML = htmlMap[utilityId](utilityText),
						$newComponent;
					MKFORM.serialCount._selfAdd();
					$newComponent = $('.form_component').find('.utility');
					$newComponent.html(componentHTML).removeClass('utility').attr({
						"id": "com" + MKFORM.serialCount._getCount(),
						"name": utilityId,
						"title": "点击进行修改,拖动交换位置,按住Ctrl拖动即可复制."
					});
					formItemSortable();
					addOptionDrag();
					MKGlobal.addUnsaveCount();
					$newComponent.trigger('click');

				}
			});
	}

	return {
		'addUtility': function (name, html) {
			htmlMap[name] = html;
		},
		getUtilityHTML: function(name, _title){
			return htmlMap[name](_title);
		},
		bind: function () {
			return MKBind();
		}
	};
}

function formItemSortable() {
	// 对所有的表单中的元素增加sortable
	var $componentContainer = $(".formBuilder_main .form_component");
	$componentContainer.find('.locked').attr({
		'class': 'ui-draggable',
		'title': '拖动交换位置,按住Ctrl拖动即可复制.'
	});
	var ctrlCopy = false,
		scrollFlag = true,
		utilTrue = utilityDrag(),
		tmpHTML = '';
	// TODO CHECK contact field / payment field

    /**
     * @author 2016-3-8 lulin
     * ctrl 按下阻止右键菜单
     * windows 和 mac osx 的 ctrl 键表现不一致
     * */
    $componentContainer.on('contextmenu', function (e) {
        if(e.ctrlKey) {
            e.preventDefault();
        }
    });
	$componentContainer.sortable({
		items: ">li:not(.placeholder)",
		opacity: 0.8,   //拖动时候的透明度
		axis: "y",
		cancel: ".locked",
		distance: 6,
		refreshPositions: true,
		start: function (event, ui) {
			var isClicked = false;
			var limitList = ["basic_name","basic_city","basic_gender","basic_company","basic_adress","basic_job","basic_website",'basic_birthday','basic_note'];
			// ui.helper / ui.item / ui.placeholder
			//在拖动开始的时候判断是否按下了Ctrl ————2014.9.25 Smily添加判断：非唯一联系人组件
			if (event.ctrlKey && ( $.inArray(ui.item.attr('name'),limitList)==-1) ) {
				if (ui.helper.find(".deleteButton").length) {
					isClicked = true;
					ui.helper.find(".deleteButton").remove();
				}
				MKFORM.serialCount._selfAdd();
				// -- 2014 - 01 - 23
				// 复制的原理 ： 其实是在拖动开始都时候，复制一份当前的元素插入到原来的位置，把需要拖动的元素移走就可以了
				// 这里其实可以优化 ： 这个时候取消拖动，新插入都应该删除才是。 -- 需要计数器的重新计算 云云。
				// -- @shenmo

                // 以前在拖动复制的时候，新复制出来的组件id是原来那个，而原来那个组件的id却被更新了，这样导致反馈统计数据出错了，这里修复一下
                // -- @michael 2014-06-02
                var currentComId = ui.item.attr('id');
                var newComId = "com" + MKFORM.serialCount._getCount();
                ui.helper.attr("id", newComId);

				var $newItem = $('<li class="' + ui.helper.attr("class") + '" id="' + currentComId + '"></li>')
                    .attr({"name": ui.helper.attr("name"), "title": ui.helper.attr("title")})
                    .html(ui.item.html())
                    .data(_.cloneDeep(ui.item.data()))
                    .insertAfter(ui.helper);

                if($newItem.hasClass('clicked')) {
                    $newItem.removeClass("clicked");
                }

                // 绑定的限选等功能在 title_field 上
                var $titleField = $newItem.find('.title_field');
                if($titleField && $titleField.length > 0) {
                    var titleFieldData = _.cloneDeep(ui.item.find('.title_field').data());
                    $titleField.data(titleFieldData);
                }
                
                // 如果之前点击过，加入删除的 icon
				if (isClicked) {
					ui.helper.prepend("<div class='deleteButton'></div>");
				}
				ctrlCopy = true;
			}

			if(ui.helper.hasClass('utility')){
				tmpHTML = utilTrue.getUtilityHTML(ui.helper.attr('id'), ui.helper.find('.title').text());
				ui.placeholder.empty().append(tmpHTML).css({'opacity': '0.4', 'visibility': 'visible'}).find('.deleteButton').remove();
			} else {
				ui.placeholder.empty().append(ui.helper.html()).css({'opacity': '0.4', 'visibility': 'visible'}).find('.deleteButton').remove();
			}

		},
		sort: function (event, ui) {
			$(this).find(".placeholder").remove();
			// ui.placeholder
			ui.placeholder.css({'width': '90%', "float": 'none'});
			$(".ui-sortable-helper").addClass('buildFormSort').css('width', '500px');
			//$(".ui-draggable-dragging").html(createcomponent(ui.helper));

            // 如果是添加组件, class = utility
			if (ui.helper.hasClass('utility')) {
				ui.helper.css('width', '170px');
				// ui.placeholder.css({'width': '90%', "float": 'none'});
				ui.placeholder.empty().append(tmpHTML).css({
                    'opacity': '0.4',
                    'visibility': 'visible',
                    'height':'auto',
                    'width':'500px'
                });
			} else {
				ui.placeholder.empty().append(ui.helper.html()).css({
                    'opacity': '0.4',
                    'visibility': 'visible',
                    'height':'auto',
                    'width':'100%'
                }).find('.deleteButton').remove();
			}
		},
		out: function (event, ui) {
			if (ui.helper) {
				ui.helper.css('width', '170px');
			}
		},
		over: function (event, ui) {
			ui.helper.css('width', '500px');
			if (ui.helper.hasClass('utility')) {
				ui.helper.css('width', '170px');
			}
		},
		update: function (event, ui) {
			$(this).find(".buildFormSort").removeClass('buildFormSort');
		},
		beforeStop: function (event, ui) {
			$(this).find(".buildFormSort").removeClass('buildFormSort');
		},
		stop: function () {
			MKGlobal.addUnsaveCount();
			if (ctrlCopy) {
				formItemSortable();
				addOptionDrag();
				MKFORM.componentSetting.settingDeleteSelf.bind();
				ctrlCopy = false;
			}
			MKFORM.formUtility.formPageInfoCheck($('.form_component').children('.ui-draggable'));

			// new check!
			MKFORM.formUtility.formLogicCheck($('.form_component').children('.ui-draggable'));
			MKFORM.formUtility.formStaticFollowCheck($('.form_component').children('.ui-draggable'));


			// nicescroller update

			$(".formBuilder_example").getNiceScroll().resize();
		}
	}).find('.ui-draggable').unbind('click').bind('click', function () {
			// 编辑的开始
			var $editField = $('.formBuilder_interim_edit').eq(2);
			renderFormComponent($(this));
			MKFORM.componentSetting.settingDeleteSelf.bind();
			if (!$editField.hasClass('formBuilder_interim_edit_active')) {
				$editField.trigger('click');
			}
			$(this).removeClass('unedited');
		}).unbind('mouseover').bind('mouseover',function(){
			var currentId = $(this).attr('id');
			MKFORM.componentSetting.settingHoverDelete.bind(currentId);
		});

	var $componentList = $('.form_component').children('.ui-draggable');
	MKFORM.formUtility.formContactCheck($componentList);
	MKFORM.formUtility.formPaymentCheck($componentList);
	MKFORM.formUtility.formLimitedItemCheck($componentList);
	MKFORM.formUtility.formPageInfoCheck($componentList);
	MKFORM.formUtility.formStaticFollowCheck($componentList);
}

if (typeof Array.prototype.reduce != "function") {
	Array.prototype.reduce = function(callback, initialValue) {
		var previous = initialValue,
			k = 0,
			length = this.length;
		if (typeof initialValue === "undefined") {
			previous = this[0];
			k = 1;
		}

		if (typeof callback === "function") {
			for (k; k < length; k++) {
				this.hasOwnProperty(k) && (previous = callback(previous, this[k], k, this));
			}
		}
		return previous;
	};
}
// map 
if (typeof Array.prototype.map != "function") {
	Array.prototype.map = function (fn, context) {
		var arr = [];
		if (typeof fn === "function") {
			for (var k = 0, length = this.length; k < length; k++) {
				arr.push(fn.call(context, this[k], k, this));
			}
		}
		return arr;
	};
}