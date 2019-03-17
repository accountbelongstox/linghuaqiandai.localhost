<script type="text/javascript">
/*编辑模式JS代码  --  动点世纪小熊 2017.1.4*/
function set_Table_EidtAllStyles(){
	/*-----------------------------------*/
	$('.sdi_block').each(function(a,b){
		if($(b).hasClass("sdi_backgroundcolor")){//背景色
			var c=$(b).find(".in_color").css("background-color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'background-color':"#"+c2
			}
			set_Table_Colors("sdi_backgroundcolor",cObj);
		}
		if($(b).hasClass("sdi_titlebackgroundcolor")){//表头底色
			var c=$(b).find(".in_color").css("background-color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'background-color':"#"+c2
			}
			set_Table_Colors("sdi_titlebackgroundcolor",cObj);
			
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_mainfontcolor")){//题目文字色
			var c=$(b).find(".in_color").css("color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'color':"#"+c2
			}
			set_Table_Colors("sdi_mainfontcolor",cObj);
		}
		if($(b).hasClass("sdi_mainbackgroundcolor")){//内容底色
			var c=$(b).find(".in_color").css("background-color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'background-color':"#"+c2
			}
			set_Table_Colors("sdi_mainbackgroundcolor",cObj);
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_titlefontcolor")){//表头文字色
			var c=$(b).find(".in_color").css("color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'color':"#"+c2
			}
			set_Table_Colors("sdi_titlefontcolor",cObj);
		}
		if($(b).hasClass("sdi_font") && $(b).hasClass("sdi_desfontcolor")){//描述文字 
			var c=$(b).find(".in_color").css("color");
			var c2=getHexBackgroundColor(c);
			var cObj={
				'color':"#"+c2
			}
			set_Table_Colors("sdi_desfontcolor",cObj);
		}
	})
	/*-----------------------------------*/
}

function set_propertys_reutnr1or2(v,e,bool){
	v=parseInt(v);
	if(!e){
		return false;
	}
	if(v == 1){
		if(!$(e).get(0).checked && !bool){
			/*以执行点击代替设置属性,以激活该选择框的其他值.*/
			$(e).trigger('click');
		}
		$(e).attr({
			"checked":true
		})
	}else{
		if($(e).get(0).checked && !bool){
			/*以执行点击代替设置属性,以激活该选择框的其他值.*/
			$(e).trigger('click');
		}
		$(e).attr({
			"checked":false
		})
	}
}	
function set_Member_Power(userid,type){
			var o={
				id:$("[tabindex='5000']").attr('data-table-id'),
				userid:userid
			}
			$.post("<?php echo $module['action_url'];?>&act=Member_Power"+type,o,function(data){
				if(data.length > 0){
					data=data.split('null').join('""');
					var d=$.parseJSON(data);
					//console.log(d); 
					//return ;
					set_Member_HTML(d,type);
				}
			})
}
function set_Member_Invite(username,type,invite){
	var d={
		icon:'',
		phone:'',
		username:username
	}
	set_Member_HTML(d,type,invite);
}
function set_Member_HTML(d,type,invite){
			if(!d){
				return false;
			}
			var username=d.username;
			if(username == ''){
				return false;
			}
			var icon=d.icon;
			if(icon.length < 1){
				icon='/images/avatar_default-a.png';
			}else{
				icon="/upload/index/user_icon/"+icon;
			}
			var type_=type;
			var attr_name='data-'+type_+'-username';
			var phone=d.phone;
			var power=type;
			var selected_admin='';
			var selected_edit='';
			var selected_read='';
			switch(power){
				case "admin":
				selected_admin='selected';
				break;
				case "edit":
				selected_edit='selected';
				break;
				case "read":
				selected_read='selected';
				break;
				default:
					
				break;
			}
			var inviteHTML='';
			var data_invite=0;
			if(invite){
				inviteHTML='<span style="color:blue">(邀请中...)</span>';
				data_invite=1;
			}
			var select_html='';
			select_html+='<div class="formEnd_member">';
			select_html+='<div class="left-member">';
			select_html+='<img style="width: 20px; height: 20px; border-radius: 15px; float: left; margin: 5px 8px 0 8px;" class="avatar" src="'+icon+'">';
			select_html+='<span class="user_username" data-username="'+username+'" data-phone="'+phone+'">'+username+inviteHTML+'</span>';
			select_html+='</div>';
			select_html+='<div id="authorization" class="input-member date">';
			select_html+='<select class="select-date-picker member-select" data-invite="'+data_invite+'" onchange="change_member_property(this);" value="'+power+'">';
			select_html+='<option value="admin" data-value="admin" '+selected_admin+'>表管理员</option>';
			select_html+='<option value="edit" data-value="edit" '+selected_edit+'>数据维护</option>';
			select_html+='<option value="read" data-value="read" '+selected_read+'>数据查看</option>';
			select_html+='</select>';
			select_html+='</div>';
			select_html+='<a class="delete" data-disable-delete="false" data-delete-self="false" href="javascript:void(0)" onclick="remove_teamlist(this);">';
			select_html+='<i class="fa-remove" ></i>';
			select_html+='</a>';
			select_html+='</div>';
			var eleHTML=$(select_html).get(0);
			change_member_property($(eleHTML).find('select.select-date-picker'));
			$("#formMember_ADDPower_field").append(eleHTML);
			
}		
/*还原图片属性*/
function restore_img_proper(str,val){
			if(str==val){
				return 1;
			}else{
				return 0;
			}
}
if(window.location.search.indexOf('edit=') != -1){/*进入编辑模式*/
	show_globalLoading("<img src='/images/progress-complete.gif'/> <span>请稍候:读取数据中.</span>","show");
    get_edit_table(window.location.search.split('edit=')[1].split('&')[0],function(){
    	/*读取完字段后,设置表属性*/
    	set_thetable_proprety(function(){
    		show_globalLoading("<img src='/images/icon/verify_sucess.png'/> <span>读取成功.</span>","hide");
    		set_Table_EidtAllStyles();//设置表样式
    	});
    });
  }
  function set_thetable_proprety(fn){
    var table_propertys='<?php echo $module["property_json"];?>';
    table_propertys=table_propertys.split('null').join('""');//过滤服务器有可能数据库默认为空的值.
    if(table_propertys.length > 0){
    	table_propertys=$.parseJSON(table_propertys);
    }
    //console.log(table_propertys)
    	$('.formBuilder_example').attr({'data-table-id':table_propertys['id']})
		$('.formBuilder_example').attr({'data-table-name':table_propertys['name']})
		$('#data-table-description').html(table_propertys['description']);//表名
		$('.formBuilder_edit_input.formName_input').val(table_propertys['description']);//表名
		set_propertys_reutnr1or2(table_propertys['write_state'],$('#data-write_state'));//是否开启表
		set_propertys_reutnr1or2(table_propertys['authcode'],$('#data-authcode'));//是否验证码
		//set_propertys_reutnr1or2(table_propertys['email_inform'],$('#data-email_inform'));//是否发送邮件
		$('.formBuilder_edit_input.formInstruct_input').val(table_propertys['remark']);//简介
    	$('.formBuilder_edit_input.formDescribe_input').val(table_propertys['describe'])//副标题
		$('#data-remark').html(table_propertys['describe']);//副标题
		/*-------------快捷短语--------------------------------*/ 
		var shortcuts=table_propertys['shortcut'].split("|");//
		for(var i=0;i<shortcuts.length;i++){
			input_add_firstLi(shortcuts[i]);
		}
		/*-------------发送短信--------------------------------*/
		//console.log(table_propertys['table_sms']['check']);
		
		set_propertys_reutnr1or2(table_propertys['table_sms']['check'],$('#data-table_sms'));//是否短信
		add_sms__HTML(table_propertys['table_sms']['table_sms']);//设置短信
		/*-------------团队协作--------------------------------*/
		set_propertys_reutnr1or2(table_propertys['admin_is_edit'],$('#table_admin_is_edit'));//管理员是否维护表
		Member=['edit','read','admin'];
		for(var i=0;i<Member.length;i++){
			/*准权限用户*/
			var powers=table_propertys['Member_ADDPower_check'][Member[i]+'_power'];
			if(powers.length > 0){
				powers=powers.split('|');
				for(var j=0;j<powers.length;j++){
					if(parseInt(powers[j]) > 4){
						set_Member_Power(powers[j],Member[i]);
					}
				}
			}
			/*受邀请用户*/
			var invites=table_propertys['Member_ADDPower_check']['invite']['phones'][Member[i]]+table_propertys['Member_ADDPower_check']['invite']['emails'][Member[i]];
			invites=invites.split(',');
			for(var j=0;j<invites.length;j++){
				if(invites[j].length > 0){
					set_Member_Invite(invites[j],Member[i],'invite');
				}
			}
		}
		
		/*-------------是否重复提交--------------------------------*/ 
		set_propertys_reutnr1or2(table_propertys['uniqueness']['check'],$('#data-uniqueness'));
		$('#data-uniqueness').attr({
			'data-uniqueness_name':table_propertys['uniqueness']['uniqueness_name'],
			'data-uniqueness':table_propertys['uniqueness']['uniqueness']
		})
		
		if(parseInt(table_propertys['uniqueness']['check']) == 1){
		  $('#val-uniqueness').find('input').each(function(a,b){
		      if($(b).val() == $('#data-uniqueness').attr('data-uniqueness_name')){
		          $(b).trigger('click');
		      }
		  })
		}
		/*-------------用户查询--------------------------------*/ 
		$('#publish_condition').attr({
			'data-publish_condition':table_propertys["read_state"]["publish_condition"]
		})
		$('#publish_condition_select').attr({
			'data-publish_condition':table_propertys["read_state"]["publish_condition"]
		})
		
		set_propertys_reutnr1or2(table_propertys['read_state']['check'],$('#publish_condition'));
		
				/*-------------表背景图属性--------------------------------*/ 
		set_propertys_reutnr1or2(table_propertys['form_background']['check'],$('#form_background'));
		var backgroundimage__=table_propertys['form_background']['backgroundimage'];
		if(backgroundimage__.length > 0){
			$('#backgroundimage').val(backgroundimage__);//背景图
			$('#backgroundimage_file').attr('data-callvalue',backgroundimage__);//背景图
			$('#backgroundimage').parent().find('p').html(backgroundimage__);
			UploadimagesucceedCollBack($('#backgroundimage'));
		}
		var chose_info=table_propertys['form_background']['backgroundposition'].split(' top').join('').split(' ').join('');
		$('.upload_background_image_style').find('a.active').attr('chose-info',chose_info);//图位置
		$(".stateBtn[chose-info='"+chose_info+"']").trigger('click');
		var background_fix__=restore_img_proper('fixed',table_propertys["form_background"]["background_fix"]);
		set_propertys_reutnr1or2(background_fix__,$('#background_fix'));//图固定
		var backgroundrepeat__=restore_img_proper('repeat',table_propertys["form_background"]["backgroundrepeat"]);
		set_propertys_reutnr1or2(backgroundrepeat__,$('#background_repeat'));//图重复
		/*-------------表头背景图---------------------------------*/ 
		set_propertys_reutnr1or2(table_propertys['form_title_background']['check'],$('#form_title_background'));//表头背景图
		var titlebackgroundimage___=table_propertys['form_title_background']['titlebackgroundimage'];
		if(titlebackgroundimage___.length > 0){
			$('#titlebackgroundimage').val(titlebackgroundimage___);
			$('#titlebackgroundimage_file').attr('data-callvalue',titlebackgroundimage___);//表头背景图
			$('#titlebackgroundimage').parent().find('p').html(titlebackgroundimage___);
			UploadimagesucceedCollBack($('#titlebackgroundimage'));
		}
		/*-------------表头LOGO---------------------------------*/ 
		set_propertys_reutnr1or2(table_propertys['form_changelogo']['check'],$('#form_changelogo'));//是否有背景图
		var form_changelogo___=table_propertys['form_changelogo']['titlebackgroundlogo'];
		if(form_changelogo___.length > 0){
			$('#titlebackgroundlogo').val(form_changelogo___);
			$('#titlebackgroundlogo_file').attr('data-callvalue',form_changelogo___);//表头背景图
			$('#titlebackgroundlogo').parent().find('p').html(form_changelogo___);
			UploadimagesucceedCollBack($('#titlebackgroundlogo'));
		}
		/*图片的其他属性*/		
		$('.sdi_backgroundcolor').find('.in_color').css({'background-color':table_propertys['backgroundcolor']})
		$('.sdi_titlebackgroundcolor').find('.in_color').css({'background-color':table_propertys['titlebackgroundcolor']})
		$('.sdi_titlefontcolor').find('.in_color').css({'color':table_propertys['titlefontcolor']})
		$('.sdi_mainfontcolor').find('.in_color').css({'color':table_propertys['mainfontcolor']})
		$('.sdi_mainbackgroundcolor').find('.in_color').css({'background-color':table_propertys['mainbackgroundcolor']})
		$('.sdi_desfontcolor').find('.in_color').css({'color':table_propertys['desfontcolor']});
		/*提交后动作 1=显示二维码*/
		set_propertys_reutnr1or2(table_propertys['callback'],$('#formBuilder_callback'));//提交后动作
		
		/* 自定义CSS.暂定接口
		''=table_propertys['inform_user']
		''=table_propertys['css_width']
		''=table_propertys['css_pc_bg']
		''=table_propertys['css_pc_top']
		''=table_propertys['css_phone_bg']
		''=table_propertys['css_phone_top']
		''=table_propertys['css_diy']
		*/
		if(fn){
			fn();
		}
  }
  function get_edit_table(id,fn){
    var obj={
      'table_id':parseInt(id)
    }
    $.get("<?php echo $module['action_url'];?>&act=getfields",obj,function(data){
        if(data != ""){
        data.split("null").join('""');
          var table_v=jQuery.parseJSON(data);
          $(table_v).each(function(a,e){
          var b=jQuery.parseJSON(e);
            if(b.input_type.indexOf('系统') == -1){
            	if(parseInt(b['page']) > parseInt($("#ui-sortable").children('li').last().attr('data-page'))){
             /*检查分页 如果分页大于上一个,则先添加一个分页标签*/
            		append_To_tableEle('page');
            	}
              var e=append_To_tableEle(b.input_type);
              if(e.length == 1){
                  attrs=get_attr_name(e);
                  for(var i=0;i<attrs.length;i++){/*给表单元素的属性覆盖一次*/
                      var va=attrs[i];
                      if(attrs[i]=='args'){
                       var va='input_args';
                      }
                      if(attrs[i]=='data-required'){
                       var va='required';
                        /*保留字*/
                      }
                      if(attrs[i]=='data-page'){
                       var va='page';
                        /*保留字*/
                      }
                      e.attr(attrs[i],b[va]);
                  }
                  e.attr('data-id',b.id);/*将ID号的值给表格*/
                  args_inputTohtml(e);
                e.find('.title').html(b.description);
              }
            }
          })/*each完成*/
            if(fn){
            	fn();
            }
        }else{
            if(fn){
            	fn();
            }
        }
    });
  }
</script>