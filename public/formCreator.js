// 这个文件可以并且仅可以解决 表单的 JSON －> HTML 或者是 HTML -> JSON 还有进行 皮肤的更换／更新 的工作


(function($) {
	var json = '{"form":{"title":"空白的表单","subtitle":"从头开始创建您的表单"},"component":[]}',
		jsonObject = JSON.parse(json),
		// 插件的设置项
		defaults = {
			jsonObject: jsonObject,
			style: false,
			isPublic: false, // 设置为 true 的话就是表示拥有提交按钮， 并且编辑区域可以进行编辑
			isView: false
		},
		saveDefaults = {
			style: false
		},
		themeColor = (function(){
			var themeColorObject = {
				instruction:"",
				highlight:"",
				title: "",
				form: "",
				wallpaper: ""
			};
			return {
				_setTheme: function(o){
					themeColorObject = o;
				},
				_getTheme: function(){
					return themeColorObject;
				}
			};
		})(),
		finishForm = (function(){
			var finishForm;
			return {
				_setValue: function(value){
					finishForm = value;
				},
				_getValue: function(){
					return finishForm;
				}
			};
		})(),
		_container;

	// 生成每个组件的 HTML 代码
	var createHTML = {

		id_checkBox: function(o){

            if(!o.isLimit) o.isLimit = false;
            if(!(o.isOtherLimit>=0)) o.isOtherLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;
            if(!o.commonLimit) o.commonLimit = 0;
            if(!o.commonLimitValue) o.commonLimitValue = '';

			var options = '',
				count = 0,
				layout = '',
				serial = o.id.replace(/[^\d]/g,''),
				instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                //limit 是否选择限制单选名额
				titleField = '<span class="title_field" data-other-limit="'+ o.isOtherLimit +'" data-limit="'+ o.isLimit+'" data-limit-show-type="'+ o.limitShowType+'" data-common-limit="'+ o.commonLimit +'" data-common-limit-value="'+  o.commonLimitValue +'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '',
				layoutMap = {
					'single': 1,
					'two': 2,
					'three': 3,
					'four': 4
				},
				layoutVal = false;

			if(layoutMap[o.layout] !== 1){
				layoutVal = layoutMap[o.layout];
			}
			$.each(o.value, function(n,v){
				if(!v.hasOwnProperty('input')){
					options += '<li class="optionsLine medium"><input type="checkbox" name="checkbox'+serial+'" value="'+(v.lid||count)+'" '+((v.selected)?'checked="checked"':'')+'><label class="optionValue" data-limit="'+(v.limit>=0? v.limit:"")+'">'+v.name+'</label></li>';
				} else {
					options += '<li class="optionsLine medium other" data-limit="'+ (v.limit>=0? v.limit:"") +'"><input type="checkbox" name="checkbox'+serial+'" value="'+(v.lid||count)+'" '+((v.selected)?'checked="checked"':'')+'><label class="optionValue">其他:<input type="text" class="input medium" ></label></li>';
				}
				if(layoutVal){
					if((n+1)%layoutVal == 0 && n!==0){
						options += '<li class="clearB"></li>';
					}
				}
				count++;
			});
			if(o.layout){
				layout = 'layout-type-'+ o.layout;
			}
			mainField = '<div class="checkbox"><ul class="optionGarden '+layout+'">'+options+'</ul><div class="clearB"></div></div>';
			
			return titleField+instructField+mainField;
		},
        /**
         * isLimit: boolean 是否限制选项数量, default: false
         * isOtherLimit: boolean | number 是否有其它选项，并且记录其它选项的限制数量, default: false
         * islimitShowType: boolean 是否显示剩余数量, default: false
         * commonLimit: number<0, 1> 是否统一限选, default: 0
         * commonLimitValue: number 统一限选的数量, default: 0
        */
		id_dropDown: function (o) {
            if(!o.isLimit) o.isLimit = false;
            if(!(o.isOtherLimit>=0)) o.isOtherLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;
            if(!o.commonLimit) o.commonLimit = 0;
            if(!o.commonLimitValue) o.commonLimitValue = '';

			var options = '',
				count = 0,
				instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                titleField = '<span class="title_field" data-limit="'+ o.isLimit+'" data-other-limit="'+ o.isOtherLimit+'" data-limit-show-type="'+ o.limitShowType+'" data-common-limit="'+ o.commonLimit +'" data-common-limit-value="'+  o.commonLimitValue +'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField,
				otherTag = false,
				defaultTipTag = false;
			$.each(o.value, function(n,v){
				if(!v.hasOwnProperty('input')){
					if (v.hasOwnProperty('defaultTip')) {
						defaultTipTag = true;
						options += '<option name="-1" '+((v.selected)?'selected="selected"':'')+'>'+v.name+'</option>';
					}else{
						options += '<option name="'+(v.lid||count)+'" '+((v.selected)?'selected="selected"':'')+' data-limit="'+(v.limit>=0? v.limit:"")+'">'+v.name+'</option>';
						count++;	
					}					
				} else {
					otherTag = true;
				}
			});
			mainField = '<div class="select" ><select class="medium" other="'+otherTag+'" defaultTip="'+defaultTipTag+'">'+options+'</select></div>';
			return titleField+instructField+mainField;
		},
		id_multiple: function (o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div style="position: relative;"><textarea class="'+((o.size)||"textarea medium")+'">'+((o.value)?o.value:"")+'</textarea></div>';
			return titleField+instructField+mainField;
		},
		id_number: function(o){
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div><input number-type="'+(o.numtype)+'" type="text" class = "'+((o.size)||"input medium")+'" '+((o.value)?'value="'+o.value+'"':"")+' /></div>';
			return titleField+instructField+mainField;
		},
		id_radio: function(o){

            if(!o.isLimit) o.isLimit = false;
            if(!(o.isOtherLimit>=0)) o.isOtherLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;
            if(!o.commonLimit) o.commonLimit = 0;
            if(!o.commonLimitValue) o.commonLimitValue = '';

			var options = '',
				count = 0,
				serial = o.id.replace(/[^\d]/g,''),
				layout = '',
				instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                //limit 是否选择限制单选名额
				titleField = '<span class="title_field" data-other-limit="'+ o.isOtherLimit +'" data-limit="'+ o.isLimit+'" data-limit-show-type="'+ o.limitShowType+'" data-common-limit="'+ o.commonLimit +'" data-common-limit-value="'+  o.commonLimitValue +'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '',
				layoutMap = {
					'single': 1,
					'two': 2,
					'three': 3,
					'four': 4
				},
				layoutVal = false;

			if(layoutMap[o.layout] !== 1){
				layoutVal = layoutMap[o.layout];
			}
			$.each(o.value, function(n,v){
				if(!v.hasOwnProperty('input')){
					options += '<li class="optionsLine medium"><input type="radio" name="radio'+serial+'" value="'+(v.lid||count)+'" '+((v.selected)?'checked="checked"':'')+'><label class="optionValue" data-limit="'+(v.limit>=0? v.limit:"")+'">'+v.name+'</label></li>';
				} else {
					options += '<li class="optionsLine medium other" data-limit="'+ (v.limit>=0? v.limit:"") +'"><input type="radio" name="radio'+serial+'" value="'+(v.lid||count)+'" '+((v.selected)?'checked="checked"':'')+'><label class="optionValue">其他:<input type="text" class="input medium" data-limit="'+(v.limit>=0? v.limit:"")+'" ></label></li>';
				}
				if(layoutVal){
					if((n+1)%layoutVal == 0 && n !== 0){
						options += '<li class="clearB"></li>';
					}
				}
				count++;
			});
			if(o.layout){
				layout = 'layout-type-'+ o.layout;
			}
			mainField = '<div class="radio"><ul class="optionGarden '+layout+'">'+options+'</ul><div class="clearB"></div></div>';
			return titleField+instructField+mainField;
		},
		id_singleLine: function (o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div><input type="text" class = "'+((o.size)||"input medium")+'" '+((o.value)?'value="'+o.value+'"':"")+' /></div>';
			return titleField+instructField+mainField;
		},
		id_section: function(o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field title_field_block" style="'+ (o.titleAlignStyle||'') + '"><label class="title">'+o.title+'</label></span>',
				mainField = '<hr class="sectionLine"/><div class="subtitle" style="'+ (o.alignstyle||'') +'">'+_mkMarkEval(o.subtitle)+'</div>';
			return titleField+instructField+mainField;
		},
		id_page: function(o) {
			return '<div class="page_pre"></div><div class="page"><div class="same-as-break break_color"></div></div><div class="page_next"></div>';
		},
		id_picture: function(o) {
			// 2014 - 01 - 06 new add
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<div class="title_field img_title" img-link="'+ o.imglink+'"><img src="'+decodeURIComponent(o.img)+'" style="'+((o.pictureshow==='normal' || !o.pictureshow)?'width:100%':'max-width:100%')+'" /><input type="file" class="in_pic_upload" name="_FILE_" hasfile="true"></div>',
				mainField = '<div class="subtitle" style="'+ (o.alignstyle||'') +'">'+_mkMarkEval(o.subtitle)+'</div>';
			return titleField+instructField+mainField;
		},
		id_fileUpload: function(o) {
			// 2013 - 05 -28 new add
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div><div class="upload_file medium"><input class="input_file" name="_FILE_" data-url=""><p>请选择一个文件</p><img src="/images/icon/importFileAdd.png"></div></div>',
				fileTypeField = ((o.filetype)?'<p class="filetype-hint">支持 '+o.filetype.join(', ')+'</p>':'');
			return titleField+instructField+fileTypeField+mainField;
		},
		id_date: function(o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div><input type="text" class= "date '+((o.size)||"input medium")+'" datetype="'+o.dateType+'"></div>';
			return titleField+instructField+mainField;
		},
		id_star: function(o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField = '<div><div class="starGroup" starSelected="0">';
			for(var i = 0; i < o.star; i++) {
				mainField += '<span class="star"></span>';
			}
			mainField += '</div></div>';
			return titleField+instructField+mainField;
		},
		id_shopping: function(o) {
			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				shoppingItemTemplate = '<div class="pic_place"><img src="%%PIC%%"/></div><div class="text_place"><a class="item_name" a_link="%%LINK%%">%%NAME%%</a><p class="item_price">%%PRICE%%</p><p class="item_select"><span class="remove">-</span><input class="itemnum" value="0"><span class="add">+</span></p></div>',
				mainField,
				tmpHTML = '';

			if(o.value){
				$.each(o.value, function(n,v){
					var flag = false;
					if (v !== null) {
						if(v.pic){
							flag = true;
						}
						tmpHTML += '<li class="shopping-item'+(flag?'':' nopic')+((n%3==0)?' clearB':'')+'" itemid="'+n+'">'+shoppingItemTemplate.replace(/(%%(.*?)%%)/igm, function () {
							var tmpVal = '';
							if (arguments[2] === 'PRICE') {
								if (v[arguments[2].toLowerCase()]) {
									tmpVal = '￥' + v[arguments[2].toLowerCase()];
								}
								return tmpVal;
							}
							return v[arguments[2].toLowerCase()] || '';
						})+'</li>';
					}
				});
			}
			
			if(tmpHTML === ''){
				tmpHTML += '<li class="shopping-item empty">暂时没有商品</li>';
			} else {
				tmpHTML = '<li class="shopping-item empty" style="display: none;">暂时没有商品</li>'+tmpHTML;
			}
			mainField = '<div class="shopping"><ul class="shoppingList">'+tmpHTML+'</ul><div class="clearB"></div></div>';
			return titleField+instructField+mainField;
		},
		id_pictureCheckbox: function(o){
            if(!o.isLimit) o.isLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;
            if(!o.commonLimit) o.commonLimit = 0;
            if(!o.commonLimitValue) o.commonLimitValue = '';

			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                //limit 是否选择限制单选名额
                titleField = '<span class="title_field" data-limit="'+ o.isLimit+'" data-limit-show-type="'+ o.limitShowType+'" data-common-limit="'+ o.commonLimit +'" data-common-limit-value="'+  o.commonLimitValue +'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField,
				serial = o.id.replace(/[^\d]/g,''),
				tmpHTML = '';
			if(o.value){
				$.each(o.value, function(n, v) {
					var _img = '';
					if(v.img){
						_img = '<img class="picc_img" src="'+decodeURIComponent(v.img)+'">';
					}
					tmpHTML += '<li class="picturecheckbox-item'+((n%3==0)?' clearB':'')+'" listfield="'+n+'"><div class="piccheckbox_img" '+(v.img?'style="display: block;"':'')+'>'+_img+'</div><div class="piccheckbox_contect"><input type="checkbox" name="picturecheckbox'+serial+'" value="'+(v.lid||n)+'" '+((v.selected)?'checked="checked"':'')+' disabled="disabled"><label class="optionValue" data-limit="'+(v.limit>=0? v.limit:"")+'">'+v.name+'</label></div></li>';
				});
			}

			mainField = '<div class="picture_checkbox"><ul class="pictureCheckboxList">'+tmpHTML+'</ul><div class="clearB"></div></div>';
			return titleField+instructField+mainField;
		},
		id_pictureRadio: function(o){
            if(!o.isLimit) o.isLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;
            if(!o.commonLimit) o.commonLimit = 0;
            if(!o.commonLimitValue) o.commonLimitValue = '';

			var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                //limit 是否选择限制单选名额
                titleField = '<span class="title_field" data-limit="'+ o.isLimit+'" data-limit-show-type="'+ o.limitShowType+'" data-common-limit="'+ o.commonLimit +'" data-common-limit-value="'+  o.commonLimitValue +'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				mainField,
				serial = o.id.replace(/[^\d]/g,''),
				tmpHTML = '';
			if(o.value){
				$.each(o.value, function(n, v) {
					var _img = '';
					if(v.img){
						_img = '<img class="picc_img" src="'+decodeURIComponent(v.img)+'">';
					}
					tmpHTML += '<li class="pictureradio-item'+((n%3==0)?' clearB':'')+'" listfield="'+n+'"><div class="picradio_img" '+(v.img?'style="display: block;"':'')+'>'+_img+'</div><div class="picradio_contect"><input type="radio" name="pictureradio'+serial+'" value="'+(v.lid||n)+'" '+((v.selected)?'checked="checked"':'')+' disabled="disabled"><label class="optionValue" data-limit="'+(v.limit>=0? v.limit:"")+'">'+v.name+'</label></div></li>';
				});
			}

			mainField = '<div class="picture_radio"><ul class="pictureRadioList">'+tmpHTML+'</ul><div class="clearB"></div></div>';
			return titleField+instructField+mainField;
		},
		basic_name: function(o){
			return this.id_singleLine(o);
		},
		basic_city: function(o){
			return this.id_singleLine(o);
		},
		basic_birthday: function(o){
			return this.id_singleLine(o);
		},
		basic_job: function(o){
			return this.id_singleLine(o);
		},
		basic_company: function(o){
			return this.id_singleLine(o);
		},
		basic_adress: function(o){
			return this.id_singleLine(o);
		},
		basic_phone:function(o){
			return this.id_singleLine(o);
		},
		basic_fax: function(o){
			return this.id_singleLine(o);
		},
		basic_gender: function(o){
            if(!o.isLimit) o.isLimit = false;
            if(!o.limitShowType) o.limitShowType = 0;

			var options = '',
				count = 0,
				serial = o.id.replace(/[^\d]/g,''),
				titleField = '<span class="title_field"  data-limit="'+ o.isLimit+'" data-limit-show-type="'+ o.limitShowType+'"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
				instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
				mainField,
				layout = '';

			$.each(o.value, function(n,v){
				var nameArray = v.name.split("-"),
                    genderVar = nameArray.pop(),
                    showName = nameArray.join('-');
				options += '<li class="optionsLine medium"><input type="radio" name="radio'+serial+'" genderValue="'+(genderVar||"")+'" value="'+(v.lid||count)+'" '+((v.selected)?'checked="checked"':'')+'><label class="optionValue" data-limit="'+(v.limit>=0? v.limit:"")+'">'+showName+'</label></li>';
				count++;
			});
			if(o.layout){
				layout = 'layout-type-'+ o.layout;
			}
			mainField = '<div class="radio"><ul class="optionGarden '+layout+'">'+options+'</ul><div class="clearB"></div></div>';
			return titleField+instructField+mainField;
		},
		basic_email:function(o){
			return this.id_singleLine(o);
		},
		basic_website: function(o){
			return this.id_singleLine(o);
		},
		basic_weixin: function(o){
			return this.id_singleLine(o);
		},
        basic_mobile: function (o) {
            var instructField = ((o.instruct)?'<p class="instruct">'+_mkMarkEval(o.instruct)+'</p>':''),
                titleField = '<span class="title_field"><label class="title">'+o.title+'</label><span class="com_required">'+((o.required)?'*':'')+'</span></span>',
                mainField = '<div'+(o.mobile_vcode_com? ' class="with_mblc"':'')+'><input type="text" class = "'+((o.size)||"input medium")+'" '+((o.value)?'value="'+o.value+'"':"")+' />'+(o.mobile_vcode_com?'<div class="button mblc_button">获取验证码</div>':'')+'</div>',

                mbvcTitle = (o.mobile_vcode_com) ? ('<span class="mbvc_title_field"><label class="mbvc_title">'+(o.mobile_vcode_com.mbvc_title||'')+'</label><span class="com_mbvc_required">'+((o.mobile_vcode_com.com_mbvc_required)?'*':'')+'</span></span>') : '',
                mbvcInstruct = (o.mobile_vcode_com) ? ((o.mobile_vcode_com.mbvc_instruct)?('<p class="mbvc_instruct">'+_mkMarkEval(o.mobile_vcode_com.mbvc_instruct)+'</p>'):'') : '',
                mbvcField = (o.mobile_vcode_com) ? ('<div class="mobile_vcode_com">'+mbvcTitle+mbvcInstruct+'<div><input type="text" class="'+((o.size)||"input medium")+'" disabled="disabled"></div></div>'):'';

            return titleField+instructField+mainField+mbvcField;
        },
		basic_note: function(o){
			return this.id_singleLine(o);
		},
		basic_qq:function(o){
			return this.id_singleLine(o);
		},
		"undefined": function(){
			return "";
		}
	};

	// 生成一个对象的HTML / 可以获取对象的ID *
	var _createComponent = function (o){
		var componentHTML = '<li class="locked" id="'+o.id+'" name="'+o.name+'">'+createHTML[o.name](o)+'</li>';
		return componentHTML;
	};

	// 通过JSON串来构建表单
	var _createFormViaJSON = function (opt){
		// 传入一个json对象
		var o = opt.jsonObject,
			pub = opt.isPublic,
			style = opt.style,
			com = null;
		var formTitle = _container.find(".form_title");

		if(o){
			if(!o.form.logo || o.form.logo === 'false'){
				o.form.logo = '';
			}
			if(formTitle.length){
				formTitle.find(".title>h2").text(o.form.title);
				formTitle.find(".title>div").text(o.form.subtitle);
				formTitle.find("#face").attr("src",decodeURIComponent(o.form.logo));
				formTitle.attr("contact",o.form.contact);
				formTitle.attr("sendMail",o.form.sendMail);
				formTitle.attr("sendtoemail",(o.form.sendToEmail||''));
				formTitle.attr("sendtoname",(o.form.sendToName||''));
                formTitle.attr("sendsms",o.form.sendSms);
                formTitle.attr("sendsmsonlyone",o.form.sendSmsOnlyOne);
                formTitle.attr("sendtosms",(o.form.sendToSms||''));
				formTitle.attr("paymenttype",(o.form.paymenttype)||'');
				formTitle.attr("paymentonly",(o.form.paymentonly)||'');
				if(o.finishForm){
					formTitle.attr("finishform",o.finishForm.value);
					formTitle.attr("type",o.finishForm.type);
				}
                if(o.form.hasOwnProperty('prev_page')){
                    formTitle.attr("prev_page", o.form.prev_page);
                }
			}
			$.each(o.component, function(n,v){
				com = $(_createComponent(v));
				com.appendTo(_container.find(".form_component"));
				if(v.layout){
					com.data('layoutType', v.layout);
				}

				if(v.name === 'id_checkBox' || v.name === 'id_pictureCheckbox'){
					if(v.hasOwnProperty('snumber')){
						com.data('__MGComponentSelect',{
							enable: true,
							number: v.snumber,
							type: v.stype
						});
					}
				}

				// setting logic data
				// if(v.name === 'id_checkBox' || v.name === 'id_pictureCheckbox' || v.name === 'id_radio' || v.name === 'id_dropDown' || v.name === 'id_pictureRadio' || v.name === 'basic_gender'){
				// 所有的组件都有可能拥有结束标记
				if(v.jump){
					com.data('Logic_Setting',v.jump);
				}
				// }

				if(v.name === 'id_shopping'){
					com.data('shoppingInfo', v.value);
				}

				if(v.name === 'id_picture'){
					com.find('.img_title').find('img').data('style',v.pictureshow||'normal');
				}

				if(v.filetype){
					com.data('typedata', v.filetype);
				}
			});
			if(pub)
				$("<input type='text' value='提交'/>").appendTo(_container.find(".form_component"));
		}

		// 使用颜色的插入 -- 
		// if(style){
		// 	themeColor._setTheme(style);
		// }
		// _setTheme();
	};


	var _setTheme = function(){
		// _container.find(".ui-draggable,.locked").attr("style",themeColor._getTheme().form);
		// _container.find(".form_component").attr("style",themeColor._getTheme().form);
		// _container.find(".instruct").attr("style",themeColor._getTheme().instruction);
		// // 2014-02-13 new add!!!
		// _container.find(".filetype-hint").attr("style",themeColor._getTheme().instruction);
		// _container.find(".form_title").attr("style",themeColor._getTheme().title);
		// _container.parent().attr("style",themeColor._getTheme().wallpaper+";overflow: hidden; outline: none;");
		// _container.find(".clicked").attr("style",themeColor._getTheme().highlight);
		// -- 
		_container.parent().getNiceScroll().resize();
	};

	function _mkMarkEval(s){
		// 字符串转换成 html 的字符串
		var LINK_REG = /\[(.+?)]\(([^\(\)]*?)\)/g,
			LINK_TEST_REG = /^(file|gopher|news|nntp|telnet|http|ftp|https|ftps|sftp):\/\//;
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
	}

	function _mkMarkParse(s){
		// html 字符串 转换为 mark 形式
		var TAG_A_REG = /<a[^>]*link-save="([^"]*)"[^>]*>([^<>]*)<img[^>]*src="/images\/icon\/externalLink.png"[^>]*><\/a>/gi;
		return s.replace(TAG_A_REG,function($,$1,$2){
			return '['+$2+']('+decodeURIComponent($1)+')';
		});
	}

    /**
     * @description 从 HTML 生成 JSON 串的方法 ... 
     * jsonStringArray: string[] 是最后所有组件的 json 数据
     * jsonStr: string 是表单＋组件的所有 json 数据
    */
	var _generateJSON = function (ui, style) {
		var jsonStringArray = [],
			$formTitle = ui.find(".form_title"),
			jsonObject,styleInfo,hasContact=false,
			jsonStr = '';
		ui.find(".formBuilder_main>ul").children().each(function(){
			var $component = $(this),
				componentName = $component.attr("name"),
				jsonString = "{"+
				"\"name\":\""+componentName+"\","+
				"\"id\":\""+$component.attr("id")+"\","+
				"\"title\":"+JSON.stringify(($component.find(".title").html()||'').replace(/[\r\n]/igm,'<br/>'))+","+
				"\"required\":"+ (!($component.find(".com_required").text().length == 0)) +","+
				"\"instruct\":"+JSON.stringify( _mkMarkParse((($component.find(".instruct").length)?$component.find(".instruct").html():'').replace(/[\r\n]/igm,'<br/>')))+",",
				options,flag = true;

            var limitComponent = ['id_radio','id_checkBox','id_dropDown','id_pictureCheckbox','id_pictureRadio', 'basic_gender'];
            var otherLimitComponent = ['id_radio','id_checkBox','id_dropDown'];

            // 拥有批量统一限选功能的组件：commonLimit、commonLimitValue
            var commonLimitComponent = ['id_dropDown', 'id_radio','id_checkBox', 'id_pictureRadio', 'id_pictureCheckbox'];

            if(limitComponent.indexOf(componentName) != -1){
                jsonString += "\"isLimit\":"+ ($component.find(".title_field").data('limit') == true || $component.find(".title_field").data('limit') == "true") +",";
                jsonString += "\"limitShowType\":"+ ($component.find(".title_field").data('limit-show-type')?$component.find(".title_field").data('limit-show-type'):0) +",";
            }

            if(otherLimitComponent.indexOf(componentName) != -1){
                var otherLimit = parseInt($component.find(".title_field").data('other-limit'), 10);
                if(!(otherLimit>=0)){
                    otherLimit = false;
                }
                //if(typeof(otherLimit) == "undefined" || otherLimit == null || otherLimit == ''){
                //    otherLimit = false;
                //}
                
                jsonString += "\"isOtherLimit\":"+ otherLimit +",";
            }

            if(commonLimitComponent.indexOf(componentName) !== -1) {
                var $title_field = $component.find(".title_field");
                var commonLimitValue = parseInt($title_field.data('common-limit-value'), 10) || 0;
                var commonLimit = parseInt($title_field.data('common-limit'), 10) || 0;

                jsonString += "\"commonLimit\":" + commonLimit + "," + "\"commonLimitValue\":\"" + commonLimitValue + "\",";
            }

			switch(componentName){
				case "basic_name":
				case "basic_qq":
				case "basic_mobile":
				case "basic_website":
				case "basic_email":
				case "basic_fax":
				case "basic_phone":
				case "basic_adress":
				case "basic_company":
				case "basic_weixin":
				case "basic_birthday":
				case "basic_note":
				case "basic_job":
				case "basic_city": // 这个东西先没有了
					hasContact = true;
				case "id_singleLine":
				case "id_multiple":
					jsonString += "\"value\":"+JSON.stringify($component.find("input:text,textarea").val()||'')+",";
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
                    if(componentName === 'basic_mobile' && $component.find('.mobile_vcode_com').length>0){
                        var mobile_vcode_com = {
                            'mbvc_title': ($component.find(".mbvc_title").html()||'').replace(/[\r\n]/igm,'<br/>'),
                            'com_mbvc_required': (!($component.find(".com_mbvc_required").text().length == 0)),
                            'mbvc_instruct': _mkMarkParse((($component.find(".mbvc_instruct").length)?$component.find(".mbvc_instruct").html():'').replace(/[\r\n]/igm,'<br/>')),
                            'mbvc_value': ($component.find(".mobile_vcode_com input:text").val()||'')
                        };
                        jsonString += '"mobile_vcode_com":'+JSON.stringify(mobile_vcode_com)+',';
                    }
					jsonString += "\"size\":\""+ (($component.find("input:text").length)?$component.find("input:text").attr("class"):$component.find("textarea").attr("class")) +"\"";
					break;
				case "id_number":
					jsonString += "\"numtype\":"+JSON.stringify($component.find("input:text").attr('number-type')||'')+",";
					jsonString += "\"value\":"+JSON.stringify($component.find("input:text,textarea").val()||'')+",";
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"size\":\""+ (($component.find("input:text").length)?$component.find("input:text").attr("class"):$component.find("textarea").attr("class")) +"\"";
					break;
				case "id_fileUpload":
					jsonString += "\"filetype\":"+JSON.stringify($component.data("typedata")||false)+",";
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"value\":\"\"";
					break;
				case 'id_star':
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"star\":"+$component.find('.starGroup').find('.star').length;
					break;
				case 'id_date':
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"dateType\":\""+$component.find('.date').attr('datetype')+"\"";
					break;
				case "id_section":
					jsonString += "\"alignstyle\":"+JSON.stringify('text-align:'+$component.find('.subtitle').css('text-align'))+",";
                    jsonString += "\"titleAlignStyle\":"+JSON.stringify('text-align:'+$component.find('.title_field').css('text-align'))+",";

					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"subtitle\":" +JSON.stringify( _mkMarkParse($component.find(".subtitle").html().replace(/[\r\n]/igm,'<br/>')))+"";
					break;
				case "id_page":
					jsonString += "\"value\":\"\"";
					break;
				case "id_picture":
					var src = '';
					if($component.find('.title_field img').length >0){
						src = encodeURIComponent($component.find('.title_field img').attr('src'));
					}
					jsonString += "\"img\":"+JSON.stringify(src)+",";
					jsonString += "\"imglink\":"+JSON.stringify($component.find('.title_field').attr('img-link')||false)+",";
					jsonString += "\"alignstyle\":"+JSON.stringify('text-align:'+$component.find('.subtitle').css('text-align')||false)+",";
					jsonString += "\"pictureshow\":"+JSON.stringify($component.find('.img_title').find('img').data('style')||"normal")+",";
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString +=  "\"subtitle\":" +JSON.stringify( _mkMarkParse($component.find(".subtitle").html().replace(/[\r\n]/igm,'<br/>')))+"";
					break;
				case "id_dropDown":
					options = [];
					$component.find("option").each(function(){
						if ($(this).attr("name") == "-1") {
							options.push(JSON.stringify({
								name: $(this).text(),
								selected: ($(this).attr("selected") == "selected"),
								lid: $(this).attr('listfield'),
								defaultTip: true
							}));
							// options.push("{"+"\"name\":"+JSON.stringify($(this).text())+","+"\"selected\":"+($(this).attr("selected") == "selected")+",\"defaultTip\":true}");
						}else{
							// options.push("{"+"\"name\":"+JSON.stringify($(this).text())+","+"\"selected\":"+($(this).attr("selected") == "selected")+"}");
                            var limit_num = parseInt($(this).data('limit'), 10);
							options.push(JSON.stringify({
								name: $(this).text(),
								selected: ($(this).attr("selected") == "selected"),
								lid: $(this).attr('name'),
                                limit: ( limit_num>=0 ? limit_num : "")
							}));
						}						
					});
					if($component.find('select').attr("other") == "true"){
						options.push("{"+"\"name\":\"\","+"\"selected\":false,\"lid\":\"on\",\"input\":true}");
					}
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"value\":["+options.join(",")+"]";
					break;
				case "id_shopping":
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"value\":"+(($component.data('shoppingInfo'))?JSON.stringify($component.data('shoppingInfo')):'[]')+"";
					break;
				case "id_pictureCheckbox":
					options = [];
					if($component.data('__MGComponentSelect')){
						if($component.data('__MGComponentSelect').enable){
							jsonString += '"snumber":'+($component.data('__MGComponentSelect').number||'""')+',"stype":'+$component.data('__MGComponentSelect').type+',';
						}
					}
					$component.find(".picturecheckbox-item").each(function(){
						var $this = $(this),
							$_img = $this.find('.picc_img'),
							imgSrc = '';
						if($_img.length>0){
							imgSrc = encodeURIComponent($_img.attr('src'));
						}
                        var limit_num = parseInt($(this).find("label.optionValue").data('limit'), 10);
						options.push(JSON.stringify({
							name: $this.find('label.optionValue').text(),
							selected: $this.find('input:first').attr('checked')=='checked',
							img: imgSrc,
							lid: $this.find('input:first').attr('value'),
                            limit: ( limit_num>=0 ? limit_num : "")
						}));
					});
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += '"value":['+options.join(',')+']';
					break;
				case "id_pictureRadio":
					options = [];
					$component.find(".pictureradio-item").each(function(){
						var $this = $(this),
							$_img = $this.find('.picc_img'),
							imgSrc = '';
						if($_img.length>0){
							imgSrc = encodeURIComponent($_img.attr('src'));
						}
                        var limit_num = parseInt($(this).find("label.optionValue").data('limit'), 10);
						options.push(JSON.stringify({
							name: $this.find('label.optionValue').text(),
							selected: $this.find('input:first').attr('checked')=='checked',
							img: imgSrc,
							lid: $this.find('input:first').attr('value'),
                            limit: ( limit_num>=0 ? limit_num : "")
						}));
					});
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += '"value":['+options.join(',')+']';
					break;
				case "id_checkBox":
				case "id_radio":
					options = [];
					if($component.data('__MGComponentSelect')){
						if($component.data('__MGComponentSelect').enable){
							jsonString += '"snumber":'+($component.data('__MGComponentSelect').number||'""')+',"stype":'+$component.data('__MGComponentSelect').type+',';
						}
					}
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					if($component.data('layoutType')){
						jsonString += '"layout":'+JSON.stringify($component.data('layoutType'))+',';
					}
					$component.find(".optionGarden>.optionsLine").each(function(){
						if($(this).hasClass('other')){
							// options.push("{"+"\"name\":\"\","+"\"selected\":"+($(this).find("input:first").attr("checked") == "checked")+",\"input\":true}");
                            var other_limit = parseInt($component.find('.title_field').data('other-limit'), 10);
                            if(!(other_limit>=0)) other_limit = '';
							options.push(JSON.stringify({
								name: '',
								selected: ($(this).find("input:first").attr("checked") == "checked"),
								input: true,
								lid: $(this).find("input:first").attr('value'),
                                limit:  other_limit
							}));
						}else {
                            var limit_num = parseInt($(this).find("label").data('limit'), 10);
							options.push(JSON.stringify({
								name: $(this).find("label").text(),
								selected: ($(this).find("input:first").attr("checked") == "checked"),
								lid: $(this).find("input:first").attr('value'),
                                limit: ( limit_num>=0 ? limit_num : "")
							}));
							// options.push("{"+"\"name\":"+JSON.stringify($(this).find("label").text())+","+"\"selected\":"+($(this).find("input:first").attr("checked") == "checked")+"}");
						}
					});
					jsonString += "\"value\":["+options.join(",")+"]";
					break;
				case "basic_gender":
					hasContact = true;
					options = [];
					if($component.data('layoutType')){
						jsonString += '"layout":'+JSON.stringify($component.data('layoutType'))+',';
					}
					$component.find(".optionGarden>.optionsLine").each(function(){
                        var limit_num = parseInt($(this).find("label").data('limit'), 10);
                        options.push(JSON.stringify({
							name: $(this).find("label").text()+"-"+($(this).find("input").attr("genderValue")||""),
							selected: ($(this).find("input:first").attr("checked") == "checked"),
							lid: $(this).find("input:first").attr('value'),
                            limit: ( limit_num>=0 ? limit_num : "")
						}));
						// options.push("{"+"\"name\":"+JSON.stringify($(this).find("label").text()+"-"+($(this).find("input").attr("genderValue")||""))+","+"\"selected\":"+($(this).find("input:first").attr("checked") == "checked")+"}");
					});
					if($component.data('Logic_Setting')){
						jsonString += '"jump":'+JSON.stringify($component.data('Logic_Setting'))+',';
					}
					jsonString += "\"value\":["+options.join(",")+"]";
					break;
				default:
					// 2014-06-13 bug fix
					flag = false;
					break;
			}
			jsonString +="}";
			if(flag){
				jsonStringArray.push(jsonString);
			}
		});
		var contactAttr =  $formTitle.attr("contact");
		if(typeof contactAttr === 'undefined'){
			contactAttr = true;
		}
		jsonStr = "{\"form\":{\"title\":"+JSON.stringify($formTitle.find(".title h2").text())+",\"logo\":"+JSON.stringify(encodeURIComponent($("#face:visible").attr("src")||'')||'')+",\"backgroundimg\":"+JSON.stringify(encodeURIComponent($formTitle.attr('backgroundimg')||''))+",\"backgroundtype\":"+JSON.stringify($formTitle.attr('backgroundtype')||'')+",\"titlebackground\":"+JSON.stringify(encodeURIComponent($formTitle.attr('titlebackgroundimg')||''))+",\"subtitle\":"+JSON.stringify($formTitle.find(".title div").text()||'')+",\"formShare\":"+(($formTitle.attr('formShare')===undefined)?true:$formTitle.attr('formShare'))+",\"FLAGS\":"+($formTitle.attr("flags")||'"[]"')+",\"GROUPS\":\""+($formTitle.attr("groups")||'[]')+"\",\"contact\":"+((hasContact)?contactAttr:hasContact)+",\"paymenttype\":"+JSON.stringify($formTitle.attr('paymenttype'))+",\"paymentonly\":"+JSON.stringify($formTitle.attr('paymentonly'))+",\"mn\":"+($formTitle.attr('mn')||0)+",\"sendMail\":"+($formTitle.attr("sendmail")||'false')+",\"sendToEmail\":\""+$formTitle.attr('sendtoemail')+"\",\"sendToName\":"+JSON.stringify($formTitle.attr('sendtoname'))+",\"sendSms\":"+($formTitle.attr("sendsms")||'false')+",\"sendSmsOnlyOne\":"+($formTitle.attr("sendsmsonlyone")||'false')+",\"sendToSms\":\""+$formTitle.attr('sendtosms')+"\",\"webhookurl\":"+(typeof($formTitle.attr('webhookurl'))==='undefined'? "[]": $formTitle.attr('webhookurl'))+",\"prev_page\":"+(typeof($formTitle.attr('prev_page'))==='undefined'? 0:parseInt($formTitle.attr('prev_page')))+"},\"component\":["+jsonStringArray.join(",")+"],\"finishForm\":{\"type\":\""+$formTitle.attr("type")+"\",\"value\":"+JSON.stringify( $formTitle.attr("finishForm"))+"}}";
		return jsonStr;
	};

	// 插件使用的方法
	var formCreatorMethods = {
		init: function (options) {
			var opt = $.extend({}, defaults, options),
				initHTML = '<div class = "form_title" finishForm="" type=0> <div class="formLogo"><img id="face" border="" alt="" src="" ></div> <div class="title"> <h2></h2><div></div></div><div class="clearB"></div></div> <ul class="form_component"></ul>';
			// 从容器开始往内部构建一系列的结构，可以使其完成表单生成的操作
			_container = this;
			if( this.find(".formBuilder_main").length) {
				this.find(".formBuilder_main").html(initHTML);
				this.find(".form_component").empty();
			} else {
				$('<div class = "formBuilder_main">'+initHTML+'</div>').appendTo(this);
			}
			if (_container.find("img").attr("src") == "") {
				_container.find("img").hide();
			}
			_createFormViaJSON(opt);

			_container.find(".form_component .locked,.form_component .ui-draggable").live("click",function(){
				$(".clicked").removeClass("clicked");
				$(this).addClass("clicked");
				_setTheme();
			});

			if(opt.isView){
				this.find("select,input,textarea").attr("disabled",true);
			}
		},
		generate: function(options) {
			var opt = $.extend({}, saveDefaults, options);
			return _generateJSON(this,opt.style);
		},
		setNewTheme: function(options){
			var opt = $.extend({}, saveDefaults, options);
			// -- 
			themeColor._setTheme(opt.style);
			_setTheme();
		}
	};

	$.fn.formCreator = function () {
		var method = arguments[0];
		// 方法调用逻辑
		if(formCreatorMethods[method]) {
			method = formCreatorMethods[method];
			// 我们的方法是作为参数传入的，把它从参数列表中删除，因为调用方法时并不需要它
			arguments = Array.prototype.slice.call(arguments, 1);
		} else if(typeof(method) == 'object' || !method) {
			method = formCreatorMethods.init;
		} else {
			$.error('Method == ' + method + ' == does not exist on jQuery.formCreator - CREATE BY MIKECRM');
			return this;
		}
		// 用apply方法来调用我们的方法并传入参数
		return method.apply(this, arguments);
	};

})(jQuery);