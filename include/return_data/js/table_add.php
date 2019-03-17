<script type="text/javascript">
$(document).disableSelection();
$("button.close").click(function(){
	add_member__close();
})
$.ajaxSetup({ 
  'async': true 
});
function add_member__close(e){
    $("#add_role_modal").hide();
    $("#shelter").hide();
}
 $(window).bind('beforeunload',function(){
 	return '请确认您的表单是否已保存，确定离开此页面吗？'; 
 })
//格式化时间戳
function getLocalTime(nS) { 
	return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " "); 
}
//改变团队属性
function change_member_property(e){
	var data_invite=$(e).attr('data-invite');
	var email_reg=/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
	var phone_reg=/^(1)[0-9]{10}$/;
	var invite='';
	var attr1='';
	var type=$(e).val();
	var username=$(e).parent().parent().find('.user_username').attr('data-username');
	var ele=$("#Member_ADDPower_check");
	//data-edit-username
	if(parseInt(data_invite) == 1){
		if(email_reg.test(username)){
			ele.attr('data-invite-'+type+'-email',ele.attr('data-invite-'+type+'-email')+','+username+',')
		}
		if(phone_reg.test(username)){
			ele.attr('data-invite-'+type+'-phone',ele.attr('data-invite-'+type+'-phone')+','+username+',')
		}
	}
	ele.attr('data-'+type+'-username',ele.attr('data-'+type+'-username')+','+username+',')
	//console.log(ele.attr('data-'+type+'-username')+','+username+',');
	/*需要去重复,调用去重复函数*/
	replece_member_checkbox(username,type,'noremoveHTML');
	
}


/*------------------------------------------*/
function deleteButton_close(e){
	if(!confirm("确定要删除?不可恢复!")){
		return false;
	}
	if($(e).parent().attr("data-id")){
		var obj={
			deleteid:$(e).parent().attr("data-id"),
			id:$("[tabindex='5000']").attr("data-table-id")
		}
		$.get("<?php echo $module['action_url'];?>&act=deletebutton",obj,function(data){
			if(data == "ok"){
				$("[tabindex='5000']").attr({
					"data-delete-id":$("[tabindex='5000']").attr("data-delete-id")+$(e).parent().attr("data-id")+"|"
				})
				$(e).parent().remove();
				set_page_pv();
			}else{
				alert("当前字段下有数据,请先删除数据后再删除.");
				return false;
			}
		})
	}else{
		$(e).parent().remove();
		set_page_pv();
		
	}
}

/*定义表提交超时的全局变量*/
function show_globalLoading(str,type){
	$("#shelter").show();
	$(".globalLoading").find(".info").html(str);
	if(type == 'show'){
		$("#shelter").show();
		$(".globalLoading").animate({
    		"opacity":"show"
    	},600)
		return false;
	}
	if(type == 'hide'){
		
		$(".globalLoading").animate({
    		"opacity":"hide"
    	},1000,function(){
    		$("#shelter").hide();
    		$(".globalLoading").find(".info").html($(".globalLoading").attr("data-html"));
    	})
    	return false;
	}
	
    $(".globalLoading").animate({
    	"opacity":"show"
    },500,function(){
    	$(".globalLoading").animate({
    		"opacity":"hide"
    	},500,function(){
    	$(".globalLoading").find(".info").html($(".globalLoading").attr("data-html"));
   	 })
    });
}
//去重复
function un_arr(arr){
	var new_arr=[];
	for(var i=0;i<arr.length;i++) {
	　　var items=arr[i];
	　　//判断元素是否存在于new_arr中，如果不存在则插入到new_arr的最后
	　　if($.inArray(items,new_arr) == -1) {
	　　　　new_arr.push(items);
	　　}
	}
	return new_arr
}

function confirm_add(e){
	if($("#table-container table").find("tr").length< 1 && $("#authority_emails").val().length < 2){
	    $(".globalLoading").show();
    	$(".globalLoading .info").html("已经没有更多了.");
    	$(".globalLoading").animate({
    		 opacity: 'hide'
    	},700,function(){
    		$(".globalLoading .info").html($(".globalLoading").attr("data-html"));
    	})
    	return false;
	}
	var memberN=0;
	if($("#authority_emails").val().length>0){
		var email_phone_arr=invite_statistics();
		//邮箱email_phone_arr[0]
		var emails_arr=email_phone_arr[0];
		//手机email_phone_arr[1]
		var phones_arr=email_phone_arr[1];
		
		if(emails_arr.length>0){
			add_invite_acc(emails_arr,'email');
		}

		if(phones_arr.length>0){
			add_invite_acc(phones_arr,'phone');
		}
		memberN=emails_arr.length+phones_arr.length;
		
		//加上邀请部份的账号
		function add_invite_acc(arr__,addType){
			//console.log(arr__);
			var type=$("#cooperator_role").val();
			var e_=$("#Member_ADDPower_check");
			var str_='data-invite-'+type+'-'+addType;
			e_.attr(str_,e_.attr(str_)+','+arr__.join(',')+',')
			//加到管理列表 上
			var str_='data-'+type+'-username';
			e_.attr(str_,e_.attr(str_)+','+arr__.join(',')+',')
			for(var i=0;i<arr__.length;i++){
				replece_member_checkbox(arr__[i],type);
			}
			//添加HTML
			for(var i=0;i<arr__.length;i++){
				var option_admin='';
				var option_edit='';
				var option_read='';
				switch(type){
					case 'admin':
					option_admin="selected";
					break;
					case 'edit':
					option_edit="selected";
					break;
					case 'read':
					option_read="selected";
					break;
				}
				//邀请部份HTML
				invHTML='<div class="formEnd_member invitation_select">';
				invHTML+='<div class="left-member">';
				invHTML+='<img style="width: 20px; height: 20px; border-radius: 15px; float: left; margin: 5px 8px 0 8px;" class="avatar" src="/images/avatar_default-a.png">';
				invHTML+='<span class="user_username " data-username="'+arr__[i]+'" data-phone="">'+arr__[i]+'<span style="color:blue">(邀请中...)</span></span>';
				invHTML+='</div>';
				invHTML+='<div id="authorization" class="input-member date">';
				invHTML+='<select class="select-date-picker member-select" onchange="change_member_property(this);" data-invite="1" value="'+type+'">';
				invHTML+='<option value="admin" '+option_admin+' data-value="admin">表管理员</option>';
				invHTML+='<option value="edit" '+option_edit+' data-value="edit">数据维护</option>';
				invHTML+='<option value="read" '+option_read+' data-value="read">数据查看</option>';
				invHTML+='</select>';
				invHTML+='</div>';
				invHTML+='<a class="delete" data-disable-delete="false" data-delete-self="false" href="javascript:void(0)" onclick="remove_teamlist(this);"><i class="fa-remove"></i></a>';
				invHTML+='</div>';
				$("#formMember_ADDPower_field").html($("#formMember_ADDPower_field").html()+invHTML);
			}
		}
		//-----------------------------------------------------
	}
	
	$("#table-container table").find("tr").each(function(a,b){
	
		if($(b).find("input[type=checkbox]").length < 1){
				$("#add_role_modal").hide();
				$("#shelter").hide();
			/*
			show_success("添加0个用户.",function(){
				$("#add_role_modal").hide();
				$("#shelter").hide();
			});
			*/
			return false;/* == break*/
		}
		if($(b).find("input[type=checkbox]").get(0).checked){
			var icon=$(b).find(".user_icon").attr("src");
			var username=$(b).find(".use_usename").html();
			var type_=$(b).find(".user_power_select").val();
			var attr_name='data-'+type_+'-username';
			var e__=$("#Member_ADDPower_check");
				e__.attr(attr_name,e__.attr(attr_name)+username+',')
				//叠加.
				replece_member_checkbox(username,type_);
			var phone=$(b).find("input[type=checkbox]").attr("data-phone");
			var power=$(b).find(".user_power_select").val();
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
			
			var select_html='';
			select_html+='<div class="formEnd_member">';
			select_html+='<div class="left-member">';
			select_html+='<img style="width: 20px; height: 20px; border-radius: 15px; float: left; margin: 5px 8px 0 8px;" class="avatar" src="'+icon+'">';
			select_html+='<span class="user_username" data-username="'+username+'" data-phone="'+phone+'">'+username+'</span>';
			select_html+='</div>';
			select_html+='<div id="authorization" class="input-member date">';
			select_html+='<select class="select-date-picker member-select" data-invite="0" onchange="change_member_property(this);" value="'+power+'">';
			select_html+='<option value="admin" data-value="admin" '+selected_admin+'>表管理员</option>';
			select_html+='<option value="edit" data-value="edit" '+selected_edit+'>数据维护</option>';
			select_html+='<option value="read" data-value="read" '+selected_read+'>数据查看</option>';
			select_html+='</select>';
			select_html+='</div>';
			select_html+='<a class="delete" data-disable-delete="false" data-delete-self="false" href="javascript:void(0)" onclick="remove_teamlist(this);">';
			select_html+='<i class="fa-remove" ></i>';
			select_html+='</a>';
			select_html+='</div>';
			$("#formMember_ADDPower_field").html($("#formMember_ADDPower_field").html()+select_html);
			$(b).remove();
			memberN++;
		}
	});
	
	
	if(memberN < 1 && $("#authority_emails").val().length < 2){
    	$(".globalLoading .info").html("请先选择团队成员,或填写邮箱邀请.");
    	$(".globalLoading").animate({
    		 opacity: 'show'
    	},500,function(){
    		$(".globalLoading").animate({
    			"opacity":"hide"
    		},500,function(){
    			$(".globalLoading .info").html($(".globalLoading").attr("data-html"));
    		})
    	})
	}
	$("#add_role_modal").hide();
	$("#shelter").hide();
	
	$("#success_info").html("成功添加:"+memberN+"个用户");
    $("#success_info").animate({
    	"opacity":"show"
    },500,function(){
    	$("#success_info").animate({
    		"opacity":"hide"
    	},500)
    });
}


//移除团队协作账号
function remove_teamlist(e){
	var username=$(e).parent().find('.user_username').attr('data-username');
	replece_member_checkbox(username,'all');
	$(e).parent().remove();
}
//替换原来的邀请的邮箱重叠部份
function replece_member_checkbox(username,type,noremove){
	var e=$("#Member_ADDPower_check");
	var arr=['edit','read','admin'];
	for(var i=0;i<arr.length;i++){
		if(arr[i] != type){
			//移除重复.
		var attr_name='data-invite-'+arr[i]+'-phone';
			e.attr(attr_name,e.attr(attr_name).split(username).join(','))
		var attr_name='data-invite-'+arr[i]+'-email';
			e.attr(attr_name,e.attr(attr_name).split(username).join(','))
			//换掉已经有的账号
		var attr_name='data-'+arr[i]+'-username';
			e.attr(attr_name,e.attr(attr_name).split(username).join(','))
		}else{
			//如果是本次提交,不替换,但需要去重
			//换掉非本次提交的其他数据
		var attr_name='data-invite-'+arr[i]+'-phone';
		var unarr=e.attr(attr_name).replace(',,',',').split(',');
		var val_=un_arr(unarr).join(',')+',';
			e.attr(attr_name,val_);
		var attr_name='data-invite-'+arr[i]+'-email';
		var unarr=e.attr(attr_name).replace(',,',',').split(',');
		var val_=un_arr(unarr).join(',')+',';
			e.attr(attr_name,val_);
		var attr_name='data-'+arr[i]+'-username';
		var unarr=e.attr(attr_name).replace(',,',',').split(',');
		var val_=un_arr(unarr).join(',')+',';
			e.attr(attr_name,val_);
		}
	}
	if(noremove){
		return false;
	}
	var divs=$("#formMember_ADDPower_field").find('.invitation_select');//移除重复的HTML
	divs.each(function(a,b){
		if($(b).find('.user_username').attr('data-username') == username){
			$(b).remove();
		}
	})
}
//附加函数
function is_usernames(str,arr){
	for(var i=0;i<arr.length;i++){
		if(arr[i] == str){
			return false;
		}
	}
	return true;
}

$("#add-enterprise-contact").click(function(){
    $("#add_role_modal").show();
    $("#shelter").show();
    $(".globalLoading").show();
    $(".globalLoading.info").html("提交中...");
    var id=$("[tabindex='5000']").attr("data-table-id");
    if(id == ""){
    	alert("请等待系统加载");
    	return false;
    }
    $.get("<?php echo $module['action_url'];?>&act=getMyMember&id="+id,function(data){
    	if(data!=""){
    		data=data.split('null').join('""');
    		var j=$.parseJSON(data);
    		var tr="";
    		if(j.length > 0){
	    		$(j).each(function(a,b){
	    			var str=create_tr_memberHTML(b);
	    			tr+=str;
	    		})
				$("#table-container-tbody").html(tr);
    		}
    		$(".globalLoading.info").html($(".globalLoading").attr("data-html"));
    		$(".globalLoading").hide();
    	}
    	
    })
})
/*数组去空值*/
function filter_arr(arr){
	var a=[];
	for (var i=0;i<arr.length;i++) {
		if(arr[i] != '' && arr[i] && arr[i].length > 0){
			a.push(arr[i]);
		}
	}
	return a;
}
function create_tr_memberHTML(b){
	var tr='';
	var usernameArr='';
		usernameArr+=$('#Member_ADDPower_check').attr("data-edit-username")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-admin-username")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-read-username")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-edit-phone")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-admin-phone")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-read-phone")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-edit-email")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-admin-email")+',';
		usernameArr+=$('#Member_ADDPower_check').attr("data-invite-read-email")+',';
		usernameArr=usernameArr.split(',,').join(',');
		usernameArr=usernameArr.split(',');
		usernameArr=filter_arr(usernameArr);
	var name=b.username;
	if(is_usernames(name,usernameArr)){
		var email=b.email;
		if(email.length <1){
			email="<font style=font-style:italic;color:red>未填写</font>";
		}
		var icon=b.icon;
		if(icon.length < 1){
			icon="/images/avatar_default-a.png";
		}else{
			icon="/upload/index/user_icon/"+icon;
		}
		var phone=b.phone;
		var id=b.id;
		var nickname=b.nickname;
		var reg_time=getLocalTime(b.reg_time);
		var last_time=getLocalTime(b.last_time);
		var real_name=b.real_name;
		var chip=b.chip;
		var weixincode=b.weixincode;
		if(weixincode.length<1){
			weixincode_html='';
		}else{
			weixincode_html='<a style="position:relative; margin-right: 15px;" href="javascript:;" onmouseover="$(this).find(\'.weixincode_img\').show();" title="查看二维码" onmouseout="$(this).find(\'.weixincode_img\').hide();"><span style="position:absolute;top:0;left:0;" class="weixincode"><i class="fa-qrcode"> </i></span><span style="position:absolute;top:30px;left:-50px;display:none" class="weixincode_img"><img width="100" height="100" src="'+weixincode+'" /></span></a>'
		}
		var userAlert='';
		if(name.length <1||phone.length <1||chip.length <1||email.length <1){
			var alert_txt='';
			if(name.length <1){
				alert_txt+='<br /><i class=fa-exclamation ></i>用户名未填写';
			}
			if(phone.length <1){
				alert_txt+='<br /><i class=fa-exclamation ></i>手机号未填写';
			}
			if(chip.length <1){
				alert_txt+='<br /><i class=fa-exclamation ></i>微信号未填写';
			}
			if(email.length <1){
				alert_txt+='<br /><i class=fa-exclamation ></i>邮箱未填写';
			}
			if(weixincode.length <1){
				alert_txt+='<br /><i class=fa-exclamation ></i>微信二维码未上传';
			}
			userAlert='<a href="javascript:;" alt="用户资料不完善"  onclick="help(this);" data-color="red" data-txt="资料不完善'+alert_txt+'" title="用户资料不完善" style="color:red;"><i class="fa-warning" ></i></a>'
		}
		tr+='<tr>';
		tr+='<td class="c-checkbox"><input data-phone="'+phone+'" data-email="'+email+'" data-chip="'+chip+'" type="checkbox" name="'+name+'" id="authority_'+id+'" value="'+name+'" class="input_checkbox"></td>';
		tr+='<td class="c-nickname"> <img class="avatar user_icon" src="'+icon+'" alt="Avatar default" data-txt="姓名:'+real_name+'<br />手机:'+phone+'<br />微信:'+chip+'<br />注册:'+reg_time+'<br />登陆:'+last_time+'<br />" onclick="help(this);"> <span class="username use_usename">'+name+'</span> '+weixincode_html+' <a title="编辑该用户资料" href="/index.php?cloud=index.admin_edit_user&id='+id+'" target="_blank"><i class="fa-edit"></i></a> '+userAlert+'</td>';
		tr+='<td class="c-email">'+email+'</td>';
		tr+='<td class="c-member">';
        tr+='<select class="select-member-select user_power_select" value="edit">';
        tr+='<option value="admin" data-value="admin">表管理员</option>';
        tr+='<option value="edit" selected="selected" data-value="edit">数据维护</option>';
        tr+='<option value="read" data-value="read">数据查看</option>';
        tr+='</select></td>'; 
		tr+='</tr>';
		return tr;
	}else{
		return tr;
	}
}
//是否显示团队协作
$("#Member_ADDPower_check").click(function(){
	show_or_hide_member_add(this);
})
//自执行
show_or_hide_member_add($("#Member_ADDPower_check"));
//
function show_or_hide_member_add(e){
	if($(e).get(0).checked){
		$("#formMember_ADDPower_field").show();
		$(".formEnd_addContcat").show();
	}else{
		/*
		 * 清除准备邀请的用户邮箱
		*/
		$("#formMember_ADDPower_field").hide();
		$(".formEnd_addContcat").hide();
	}
}

//自动统计需要邀请的邮箱及手机号

$("#cooperator_role").change(function(){
	var txt=$(this).find("option:selected").text();
	$("#invite_info").find(".select_span_role").html(txt);
})

var set_check_member_user_invite=null;//用来定时检测邀请的用户是否注册.

function get_usernames(e){
	show_globalLoading("<img src='/images/progress-complete.gif'/> <span>验证用户名中.</span>","hide");
	var emails=$("#authority_emails").val();
	emails=emails.replace(';',',');
	emails=emails.replace('，',',');
	emails=emails.replace('；',',');
	emails=emails.replace('。',',');
	emails=emails.replace('、',',');
	emails=emails.replace('|',',');
	emails=emails.split(',');
	for(var i=0;i<emails.length;i++){
		var obj={
			username:emails[i]
		}
		$.get("<?php echo $module['action_url'];?>&act=getuser",obj,function(data){
			if(data && data.length > 1 && data.indexOf('failed') == -1){
				data=data.split('null').join('""');
				data=$.parseJSON(data);
				var html=create_tr_memberHTML(data);
				if($("#authority_"+data.id).length < 1){
					$("#table-container-tbody .remove_tr").remove();
					$("#table-container-tbody").html($("#table-container-tbody").html()+html);
					$("#authority_"+data.id).parent().parent().find(".user_power_select").val($('#cooperator_role').val());
					$("#authority_"+data.id).attr({
						checked:true
					});
				}else{
					$("#authority_"+data.id).parent().parent().find(".user_power_select").val($('#cooperator_role').val());
					$("#authority_"+data.id).attr({
						checked:true
					}); 
				}
			}else{
				if(data && data.length > 1 && data.indexOf('failed') != -1){
					data=data.split('null').join('""');
					data=$.parseJSON(data);
					var arr_=$("#authority_emails").attr("data-value").split(',');
					if(check_include_arr(arr_,data.failed)){
						var arr_=[$("#authority_emails").attr("data-value")," "];
						$("#authority_emails").attr({
							"data-value":arr_.join(data.failed+',')
						});
					}
				}
			}
		})
	}
}

function check_include_arr(arr,val){
	/*检查数组是否包含某个值.*/
	for (var i=0;i<arr.length;i++) {
		if(arr[i] == val){
			return false;
		}
	}
	return true;
}


function invite_statistics(){
		var str="";
		var emails=$("#authority_emails").attr("data-value");
		emails=emails.replace(';',',');
		emails=emails.replace('，',',');
		emails=emails.replace('；',',');
		emails=emails.replace('。',',');
		emails=emails.replace('、',',');
		emails=emails.replace('|',',');
		emails=emails.split(',');
		var email_reg=/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		var phone_reg=/^(1)[0-9]{10}$/;
		var email_arr=[];
		var phone_arr=[];
		for(var i=0;i<emails.length;i++){
			if(email_reg.test(emails[i])){//邮箱邀请
				email_arr.push(emails[i]);
			}
			if(phone_reg.test(emails[i])){//邮箱邀请
				phone_arr.push(emails[i]);
			}
		}
		email_arr=un_arr(email_arr);
		phone_arr=un_arr(phone_arr);
		//共邀请10人.[邮箱=5][手机=5]
		if(email_arr.length > 0 || phone_arr.length > 0 ){
			str+="共邀请"+(email_arr.length+phone_arr.length)+"人 加入 <span class='select_span_role' style='color:red'>["+$("#cooperator_role").find("option:selected").text()+"]</span>.<br />";
		}
		if(email_arr.length >0){
			str+=email_arr.length+"邮箱:[";
			var email_str='';
			for(var i=0;i<email_arr.length;i++){
				email_str+=email_arr[i]+',';
			}
			str+=email_str+"]<br />";
		}
		if(phone_arr.length >0){
			str+=phone_arr.length+"手机:[";
			var phone_str='';
			for(var i=0;i<phone_arr.length;i++){
				phone_str+=phone_arr[i]+',';
			}
			str+=phone_str+"]<br />";
		}
		
		$("#invite_info").html(str);
		var arr=[];
		arr[0]=email_arr;
		arr[1]=phone_arr;
		//console.log(arr)
		return arr;
}


//保存表
$('.btn_example_save').click(function(){
	create_table(function(){
		console.log("保存成功");
	});
})
//生成表单按钮
$('.btn_example_generate').click(function(){
	create_table(function(){
		$(window).unbind('beforeunload');
		window.location.href='/index.php?cloud=form.field_add&id='+$('[tabindex="5000"]').attr('data-table-id')
	});
});

$("#data-table_sms").click(function(){
	if($("#data-table_sms").get(0).checked){
		$("#data-table_join").show();
		$("#data-table_join_detail").animate({
			opacity:'show',
			top:40
		})
	}else{
		$("#data-table_join").hide();
		$("#data-table_join_detail").animate({
			opacity:'hide',
			top:0
		})
		
	}
	if(parseInt($(".formBuilder_example").attr("data-table-id")) == 0){
		add_sms__HTML("审核中&|复审中&sms|已通过&sms|未通过&|");//空表时设置短信属性
	}
})


function add_sms__HTML(str){
	var table_smss=str.split("|");//快捷短语
	if(table_smss.length > 0){
		$("#data-table_join_detail").children("li[class='user-defined-sms']").remove();
	}
	for(var i=0;i<table_smss.length;i++){
		var sms=table_smss[i].split("&");
		if(sms[0] != ''){
			var v=0;
			if(sms[1] == 'sms'){
				v=1;
			}
			add_group_firstLi(v,sms[0]);
		}
	}
}

function add_group_firstLi(v,str,power){
	var check='';
	if(parseInt(v) == 1){
		check=' checked ';
	}
	var html='<li onmousemove="show_Lithis_icon(this);" class="user-defined-sms" onmouseout="hide_Lithis_icon(this);"><span onclick="edit_sms_input(this);" class="sms_title group_i_pencil">'+str+'</span><input style="display:none;" onblur="edit_sms_input(this);" type="text" class="sms_input" /> <span>短信通知:</span></span><span class="group_checkbox"><input type="checkbox" '+check+' class="is_sms" /></span><a onclick="remove_LiParent(this);" class="remove_group" href="javascript:void(0);"><i class="fa-remove group_remove_i"></i></a></li>';
	$(".group_firstLi.group_last_Li").before(html);
	if(power){
		$(".group_firstLi.group_last_Li").prev().find(".group_i_pencil").trigger("click");
		$(".group_firstLi.group_last_Li").prev().find(".sms_input").focus();
	}
}
StartLoadTable();
function StartLoadTable(){
	//$(".globalLoading").show()
	//1.载入快捷短语
	var obj={
		id:$(".formBuilder_example").attr("data-table-id")
	}
	$.get("<?php echo $module['action_url'];?>&act=get_shortcut",obj,function(data){
		var a=data.split(',');
		var html='';
		for(var i=0;i<a.length;i++){
			html+='<span class="MGTAG-i email_accredited"><span fullvalue="'+a[i]+'" title="'+a[i]+'">'+a[i]+'</span><a href="javascript:;" onclick="shortcut_remove_tag(this);" title="remove tag" class="email-remove-tag">&nbsp;&nbsp;</a></span>';
		}
		//$("#data-table_shortcut").find(".data-shortcut").append(html);
	})
	//2载入短信通知用户
	
	
	//$(".globalLoading").hide()
}
//短信编辑区
function shortcut_remove_tag(e){
	if(confirm("确定删除这个短语?")){
		$(e).parent().remove();
	}
}
function add_firstLi(e){
	$(e).val('');
	$(e).parent().parent().find(".input_add_firstLi").show();
	
}
function input_add_firstLi(e){
	if(e == ""){
		$("input.input_add_firstLi").hide();
		return false;
	}
	var html='<span class="MGTAG-i email_accredited" ><span fullvalue="'+e+'" title="'+e+'" >'+e+'</span><a href="javascript:;" onclick="shortcut_remove_tag(this);" title="remove tag" class="email-remove-tag">&nbsp;&nbsp;</a></span>';
	$("#data-table_shortcut").find(".data-shortcut").append(html);
	$("input.input_add_firstLi").val('');
	$("input.input_add_firstLi").hide();
}
function show_Lithis_icon(e){
	$(e).find(".remove_group").show();
}
function hide_Lithis_icon(e){
	$(e).find(".remove_group").hide();
}
function show_this_icon(e){
	$(e).parent().find("i").show();
}
function hide_this_icon(e){
	$(e).parent().find("i").hide();
}
function remove_LiParent(e){
	if(confirm("确定删除这个维护状态?")){
		$(e).parent().remove();
		
	}
}
function edit_sms_input(e){
	if($(e).hasClass("sms_title")){
		$(e).hide();
		$(e).parent().find(".sms_input").show();
		$(e).parent().find(".sms_input").val($(e).html());
	}
	if($(e).hasClass("sms_input")){
		$(e).hide();
		$(e).parent().find(".sms_title").show();
		$(e).parent().find(".sms_title").html($(e).val());
	}
	$("[tabindex='5001']").scrollTop($("[tabindex='5001']")[0].scrollHeight);
}

function get_Table_SmsV(){
	var t='';
	$('#data-table_join_detail li').each(function(a,b){
		if(!$(b).hasClass('group_firstLi') && !$(b).hasClass('group_last_Li')){
			var sms='';
			if(parseInt(check_checkbox_reutnr1or2($(b).find('input.is_sms'))) == 1){
				sms='sms';
			}
			t+=$(b).find('.sms_title').html()+'&'+sms+'|';
		}
	})
	return t;
}
function get_shortcut(){
	var t='';
	$('#data-table_shortcut').find('.data-shortcut').find('span[fullvalue]').each(function(a,b){
		if($(b).html() != ""){
			t+=$(b).html()+'|';
		}
	})
	return t;
	
}

// [A] : 创建空表./*需要返回新表的ID ,以便下一个函数调用*/
function create_table(fn){
    	var table_id=$(".formBuilder_example").attr("data-table-id");
    	if(parseInt(table_id) > 0){/*表已有的情况下直接提交属性*/
    		update_property({
    			/*必须传入参数. obj={ 'table_id': n , 'table_name': name } */
    			'table_id':table_id,
    			'table_name':$(".formBuilder_example").attr("data-table-name")
    		},fn);
    		return false;
    	}
      var obj={
        'description':$('.form_title').find('.title h2').html(),/*表名(中文)*/
        'remark':$('.form_title').find('.title div').html()/*表名描述*/
      }
      var language={
      	'description':'表名',
      	'remark':'描述'
      }
      for(var p in obj){
      	if(obj[p].length < 1){
      		show_globalLoading(language[p]+'不能为空.');
      		return false;
      	}
      }
      show_globalLoading("<img src='/images/loading_7913a2f.gif'/> <span>请稍候:正在创建表.</span>","show");
      $.get("<?php echo $module['action_url'];?>&act=add",obj ,function(data){
      	if(data.length > 0 ){
      		data=data.split("'").join('"');
      		var j=$.parseJSON(data);
      		if(j["fail"]){
      			show_globalLoading("<img src='/images/icon/no.png'/> <span>错误:"+j["fail"]+"</span>","hide");
      			return false;
      		}
      		show_globalLoading("<img src='/images/progress-complete.gif'/> <span>请稍候:表建立成功.</span>","show");
      		obj={
      			table_id:j['table_id'],
      			table_name:j['table_name']
      		}
      		$(".formBuilder_example").attr({
      			"data-table-id":obj["table_id"],
      			"data-table-name":obj["table_name"]
      		});
      		update_property(obj,fn);
      	}else{
      		return false;
      	}
  })
 }
 
// [B] : 提交表属性 需要传入 obj['table_id'] 以及 obj['table_name']
function update_property(obj,fn/*必须传入参数. obj={ 'table_id': n , 'table_name': name } */){
	/*必须传入参数.
	 obj={
		'table_id': n ,
		'table_name':  name
	}
	*/
		if(!obj){
			show_globalLoading("<img src='/images/icon/no.png'/> <span>错误:数据没有被传输 -1</span>","hide");
			return false;
		}
		show_globalLoading("<img src='/images/loading_7913a2f.gif'/> <span>请稍候:正在提交属性.</span>","show");
		var upobj={};
		/*---------------------------------------------------------*/
		upobj['id']=obj['table_id'];//表ID(必须)
		upobj['description']=$("#data-table-description").html();//表名 中文
		upobj['write_state']=check_checkbox_reutnr1or2($("#data-write_state"));//是否开启得交
		upobj['default_publish']=upobj['write_state'];//默认显示
		upobj['authcode']=check_checkbox_reutnr1or2($("#data-authcode"));//是否开启验证码
		upobj['add_power']=upobj['write_state'];//是否允许所有用户添加  -------- 该提交受表是否开启约束,不受前端得交影响(制约因素:upobj['read_state'])
		upobj['sms_inform']=0;//有新填写是否短信通知||目前默认否 ----不受前端提交影响
		upobj['email_inform']=check_checkbox_reutnr1or2($("#data-email_inform"));//有新填写是否邮件通知
		upobj['inform_user']='';//$("#data-inform_user").val();//有新填写时通知到那个用户
		upobj['css_width']='';//$("#data-css_width").val();//css宽度
		upobj['css_pc_bg']='';//$("#data-css_pc_bg").val();//背景图
		upobj['css_pc_top']='';//$("#data-css_pc_top").val();//到顶部距离
		upobj['css_phone_bg']='';//upobj['css_pc_bg'];
		upobj['css_phone_top']='';//upobj['css_pc_top'];
		upobj['css_diy']='';//$("#data-css_diy").val();//css个性化
		upobj['remark']=$(".formBuilder_edit_input.formInstruct_input").val();//表简介(描述)
		upobj['describe']=$('.formBuilder_edit_input.formDescribe_input').val();//副标题
		upobj['shortcut']=get_shortcut();//数据维护短语
		upobj['admin_is_edit']=check_checkbox_reutnr1or2($("#table_admin_is_edit"));//表管理是否维护数据
		/*-------------发送短信--------------------------------*/
		upobj['table_sms']={
			'check':check_checkbox_reutnr1or2($("#data-table_sms")),//1.是否开启
			'table_sms':get_Table_SmsV()//2.维护表时是否短信提示
		}
		/*-------------团队协作--------------------------------*/
		upobj['Member_ADDPower_check']={
			//'check':check_checkbox_reutnr1or2($("#Member_ADDPower_check")),//1.是否开启
			'edit_power':$("#Member_ADDPower_check").attr("data-edit-username"),//数据维护
			'read_power':$("#Member_ADDPower_check").attr("data-read-username"),//数据查看
			'admin_power':$("#Member_ADDPower_check").attr("data-admin-username"),//表管理
			'invite':{//受邀请用户
				'phones':{//-------------------手机受邀
					'admin':$("#Member_ADDPower_check").attr("data-invite-admin-phone"),
					'edit':$("#Member_ADDPower_check").attr("data-invite-edit-phone"),
					'read':$("#Member_ADDPower_check").attr("data-invite-read-phone")
				},
				'emails':{//-------------------邮箱受邀
					'admin':$("#Member_ADDPower_check").attr("data-invite-admin-email"),
					'edit':$("#Member_ADDPower_check").attr("data-invite-edit-email"),
					'read':$("#Member_ADDPower_check").attr("data-invite-read-email")
				}
			}
		}
		/*-------------是否重复提交--------------------------------*/
		upobj['uniqueness']={
			'check':check_checkbox_reutnr1or2($("#data-uniqueness")),//1.是否允许重复提交
			'uniqueness':$('#val-uniqueness input[name="formuniqueness"]:checked').val(),//2.判断条件
			'uniqueness_name':$('#val-uniqueness input[name="formuniqueness"]:checked').val()//3.判断条件
		}
		/*-------------用户查询条件--------------------------------*/
		upobj['read_state']={
			'check':check_checkbox_reutnr1or2($("#publish_condition")),//1.是否允许查询
			'publish_condition':$("#publish_condition_select").val()//2.查询条件
		}
		/*-------------表背景图属性--------------------------------*/
		upobj['form_background']={
			'check':check_checkbox_reutnr1or2($("#form_background")),//1.是否有背景图
			'backgroundimage':$('#backgroundimage').val(),//2.表背景图
			'backgroundposition':$('.upload_background_image_style').find('a.active').attr('chose-info')+' top',//3.表背景图重复定义
			'background_fix':$('#background_fix').get(0).checked ? 'fixed' : 'scroll',
			'backgroundrepeat':$('#background_repeat').get(0).checked ? 'repeat' : 'no-repeat'
		}
		/*-------------表头背景图---------------------------------*/
		upobj['form_title_background']={
			'check':check_checkbox_reutnr1or2($("#form_title_background")),//1.是否有背景图
			'titlebackgroundimage':$('#titlebackgroundimage').val()
		}
		/*-------------表头LOGO---------------------------------*/
		upobj['form_changelogo']={
			'check':check_checkbox_reutnr1or2($("#form_changelogo")),//1.是否有背景图
			'titlebackgroundlogo':$('#titlebackgroundlogo').val(),//2.背景图
			'titleclass':' haslogo',//3.需要有的CLASS
			'titlestyle':'padding-left: 115px; width: 385px;'//4.表标题style属性
		}
		upobj['backgroundcolor']=getHexBackgroundColor($('.sdi_backgroundcolor').find('.in_color').css('background-color'));//表背景色
		upobj['titlebackgroundcolor']=getHexBackgroundColor($('.sdi_titlebackgroundcolor').find('.in_color').css('background-color'));//表头底色
		upobj['titlefontcolor']=getHexBackgroundColor($('.sdi_titlefontcolor').find('.in_color').css('color'));//表头文字色
		upobj['mainfontcolor']=getHexBackgroundColor($('.sdi_mainfontcolor').find('.in_color').css('color'));//标题文字色
		upobj['mainbackgroundcolor']=getHexBackgroundColor($('.sdi_mainbackgroundcolor').find('.in_color').css('background-color'));//内容底色
		upobj['desfontcolor']=getHexBackgroundColor($('.sdi_desfontcolor').find('.in_color').css('color'));//描述文字色
		/*------------提交后是否显示 二维码---------*/
		upobj['callback']=check_checkbox_reutnr1or2($("#formBuilder_callback"));
		//--------------------------
		$.ajax({  
          'type' : "post",  
          'url' : "<?php echo $module['action_url'];?>&act=update_property&id="+upobj['id'],  
          'data' : upobj,  
          'async' : false,  
          success : function(data){
		 	if(data.length > 0){
			 	if(parseInt(data) != 1){
			 		show_globalLoading("<img src='/images/no.gif'/> <span>失败,错误代码"+data+".</span>","hide");
			 	}
		 	}
		   update_field(obj,fn);
          }
      })
}
//提交表字段
function update_field(obj,fn/*必须传入参数. obj={ 'table_id': n , 'table_name': name } */){
	/*必须传入参数.
	 obj={
		'table_id': n ,
		'table_name':  name
	}
	*/
	if(!obj){
		show_globalLoading("<img src='/images/icon/no.png'/> <span>错误:数据没有被传输 -1</span>","hide");
		return false;
	}
	show_globalLoading("<img src='/images/loading_7913a2f.gif'/> <span>请稍候:正在提交字段.</span>","show");
	var id=obj["table_id"];
	$("#ui-sortable").children("li").each(function(a,b){
		var obj={}
		obj['id']=id;//表ID
		obj['table_id']=id;//表ID
		obj['name']=$(b).attr("name");//字段名
		obj['description']=$(b).attr("description");//字段名(中文)
		obj['read_able']=1;//允许读取
		obj['sequence']=$(b).attr("data-sequence") ? $(b).attr("data-sequence") : $(b).index();//排序
		obj['write_able']=1;//是否写入
		obj['type']='varchar';//类型$(b).attr("input_type")
		obj['input_type']=$(b).attr("input_type");//输入类型
		obj['placeholder']=$(b).attr("placeholder");//输入框提示文字 
		obj['reg']=$(b).attr("reg");//正则方法
		obj['unique']=$(b).attr("unique");//独一无二禁止重复
		obj['search_able']=$(b).attr("search_able");
		obj['required']=$(b).attr("data-required");
		obj['args']=$(b).attr("args");//字段属性
		obj['fore_list_show']=1;//前台显示
		obj['back_list_show']=1;//后台显示
		obj['page']=$(b).attr("data-page") ? $(b).attr("data-page") : 1;
		obj['data_style']=$(b).attr("data_style") ? $(b).attr("data_style") : 0;
		$.post("<?php echo $module['action_url'];?>&act=save_field&id="+id,obj,function(data){
			/*如果是新提交的字段,会返回带有field_id=???的字符串*/
			if(data != ""){
				if(data.indexOf('field_id=') != -1){
					var data_id=data.split("field_id=")[1];
					$(b).attr({
						"data-id":parseInt(data_id)
					})
				}
			}
		} 
		)
	})
	/*开始删除临时数据*/
	show_globalLoading("<img src='/images/icon/verify_sucess.png'/> <span>正在保存表.</span>","hide");
	/*如果有待删除的表单,则执行删除.*/
	var obj={
		clearids:$("[tabindex='5000']").attr("data-delete-id")
	}
	$.post("<?php echo $module['action_url'];?>&act=clearids&id="+id,obj,function(data){
		$("[tabindex='5000']").attr({
			"data-delete-id":""
		});
		/*开始生成静态*/
		$.get("<?php echo $module['action_url'];?>&act=create_html&id="+id,function(data){
			/*最后执行函数*/
			if(fn){
				fn();
			}
		})
	})
}

function check_checkbox_reutnr1or2(e){
	if(e.length < 1){
		return "0";
	}
	if($(e).get(0).checked){
		return "1";
	}else{
		return "0"
	}
}
  //保存字段提交函数(只对应字段)
  function save_addMysql(submit_php,submit_type,fn){
    //field_add

        var id=create_table();
        $('#shadow_div').show();
        $('.shadow_title').show();
        var submit_php_=submit_php;
        var submit_type_=submit_type;
        
        var lis=$('.form_component').children('li');
        if(lis.length < 1 && submit_php == 'field_add'){
                $('#shadow_div').hide();
                $('.shadow_title').hide();
                if(fn){fn()};
                return;
        }
        if(lis.length < 1 && submit_php == 'field_edit'){
                $('#shadow_div').hide();
                $('.shadow_title').hide();
                if(fn){fn()};
                return;
        }
        var n=0;
        lis.each(function(a,b){
        if(submit_type == 'update'){
          if(!$(b).attr("data-id")){/*如果用户新添加了字段 则再次指向字段添加*/
            submit_php_='field_add';
            submit_type_='field_add';
            id=$('.formBuilder_example').attr('table_id');
            return save_addMysql(submit_php_,submit_type_,fn);
          }else{
            submit_php_='field_edit';
            submit_type_='update';
            id=$(b).attr('data-id');
          }
        }
          var url=$('.btn_example_save').attr('data-action_url')+'&act='+submit_type_+'&id='+id;

          $('.btn_example_save').attr({
            'ajax-url':url
          })
          $('.btn_example_generate').attr({
            'ajax-url':url
          })

          /*--------------------------each--------------------*/
          $.post(url,obj,function(data){
            n++;/*用来检测是不是最后一个提交完成*/
              if(data != '' && submit_type == 'add'){
                $(b).attr({
                    'data-id':data
                  })
              }

              if(n >= lis.length){/*判断是否全部字段提交完毕*/
                //window.location.reload()
                $('#shadow_div').hide();
                $('.shadow_title').hide();
                if(fn){
                  fn();
                }
              }
            })

          /*--------------------------each--------------------*/
         })
  }

/*
 
 * 样式
 *
 * */
$(".input_style_select").change(function(){
	var name=$("[tabindex='5003']").attr("name");
	var radio_ele=$("#ui-sortable").find("[name='"+name+"']");
	var ul=radio_ele.find(".radio");
	var lis=ul.find("li");
	var val=parseInt($(this).val());
	radio_ele.attr({
		"data_style":val
	})
	switch(val){
		case 0:
			lis.find("input").attr({
				"type":"radio"
			});
		break;
		case 1:
			lis.find("input").attr({
				"type":"hidden"
			});
		break;
	}
})

  
</script>