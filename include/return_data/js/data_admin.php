<script type="text/javascript">
		var GetData_Id=0;/*GetData_Id 是本页面全局的数据ID - GET变量*/
		var GetData_JSON={};/*GetData_JSON 是本页面全局获取数据的JSON提交 - GET变量*/
		var GetData_Arr=false;/*这是一个最大可获取的ID*/
		var get_data_id=0;
		
		
	    var select_option_html=false;/*获取一个初始的查看框上的HTML代码*/
	   	var vive_data_shortcut=false;/*获取一个初始的查看框上的HTML代码*/
	   	var vive_table_name=get_vive_table_name();/*获取一个初始的查看框上的HTML代码*/
	   	function get_vive_table_name(){
	   		if(!vive_table_name){
	   			return $("#form_data_admin_table tbody").children("tr").eq(0).find(".admin_changetable").attr("data-table_name");
	   		}
	   	}
	   	var vive_table_id=get_vive_table_id();/*获取一个初始的查看框上的HTML代码*/
	   	function get_vive_table_id(){
	   		if(!vive_table_id){
	   			return $("#form_data_admin_table tbody").children("tr").eq(0).find(".admin_changetable").attr("data-table_id");
	   		}
	   	}
		function create_vive_select(data_id,json_){/*第二个参数是GET到的数据的JSON*/
			if(select_option_html == false){
				select_option_html = $("#"+data_id+"_examined").find("#examined_"+data_id+"_div").html();
			}
			if(vive_data_shortcut == false){
				vive_data_shortcut = $("#"+data_id+"_examined").attr("data-shortcut");
			}
			var htm='<td data-phone="'+get_true_phone(json_,"start")+'" data-table_name="'+vive_table_name+'" data-table_id="'+vive_table_id+'" data-shortcut="'+vive_data_shortcut+'" data-weixin="'+get_data_weixin(data_id)+'" class="admin_changetable">';
			htm+='<div id="examined_'+data_id+'_vive">';
			htm+='<span class="input_span">';
			htm+=select_option_html;
			htm+='<span class="state" ></span>';
			htm+='</span>';
			htm+='</div>';
			htm+='</td>';
			return htm;
		}
		
		 function get_true_phone(json_,n){
		 	var phone="phone";
		 	/*智能取得手机号码*/
			if(n != "start"){
				phone=phone+n;
			}else{
				n=0;
			}
			if(json_[phone]['value']){
				return json_[phone]['value'];
			}else{
				$n++;
				return get_true_phone(json_,n);
			}
		}
		function get_data_weixin(data_id){
			var weixin=$("#"+data_id+"_examined").attr("data-weixin");
			if(weixin){
				return weixin;
			}else{
				$.get("<?php echo $module['action_url'];?>&act=get_examined",{data_id:data_id,table_name:vive_table_name},function(data){/*注意,此处vive_table_name使用的是全局变量,需要由其他函数先获得值.*/
					return data;
				})
			}
		}

		function get_max_pNum(){
			if(GetData_Arr == false){
				GetData_Arr=[];
				var trs=$("#form_data_admin_table tbody").children("tr");
				/*将现有的数据装入数组，待查*/
				for(var i=0;i<trs.length;i++){
					var n=$(trs[i]).attr("id").replace(/[^0-9]/ig,"");
					n=parseInt(n);
					GetData_Arr.push(n);
				}
				return GetData_Arr;
			}else{
				$.get("<?php echo $module['action_url'];?>&act=getData_maxNum",function(data){
					if(data.length > 1){
						var j=$.parseJSON(data);
						GetData_Arr=[];
						$(j).each(function(a,b){
							var n=parseInt(b);
							if(n=n){
								GetData_Arr.push(n);
							}
						});
					}
				})
			}
			return GetData_Arr;
		}
		
		function get_arr_location(arr,num){
			for(var i=0;i<arr.length;i++){
				if(arr[i] == num){
					return i;
				}
			}
			return 0;
		}
		
		function GetDatas(e,gettype){
			$('.show_input_text').hide();
			var Data_Arr=get_max_pNum();/*得到全部可阅读的数据组*/
			$('#form_submit_authority').show();
			$('#form_submit_authority').css({
				height:($(window).height()/100)*80,
				width:($(window).width()/100)*60
			});
			if(Data_Arr != GetData_Arr){
				/*如果重新GET到新的数组,则重置GetData_Id的位置*/
				GetData_Id=get_arr_location(Data_Arr,GetData_Id);
			}
			if(gettype == "tr"){/*这是从列表里点击*/
				GetData_Id=parseInt($(e).attr("data-id"));
				GetData_Id=get_arr_location(Data_Arr,GetData_Id);
			}
			if(gettype == "nex"){/*对话框点击 下一条*/
				GetData_Id++;
			}
			if(gettype == "pev"){/*对话框点击 上一条*/
				GetData_Id--;
			}
			var n=GetData_Id;
			if(n > Data_Arr.length || n < 0){
				alert('数据已经到头了!');
				return false;
			}
			var data_id=Data_Arr[GetData_Id];
			get_data_id=data_id;
			var obj={
				id:data_id,
				table_name:vive_table_name
			}
			$.get("<?php echo $module['action_url'];?>&act=get_data",obj,function(data){
				data=data.split("null").join('""');
				var j=$.parseJSON(data);
				var examined_n=parseInt(j['examined']['value']);
				var vive_remark_span='';
				if(j['state_txt']['value'] != ''){
					vive_remark_span=j['state_txt']['value'];
				}
				var html='';
				for (var p in j) {
		       		var json_data=j[p];
		       		if(json_data["type"]!="系统自带" && json_data["input_type"]!="系统自带"){
			       		var html_v="";
			       		switch(json_data["input_type"]){
			       			case 'img':
			       			html_v='<img src="/upload/form/img/'+json_data['value']+'" />';
			       			break;
			       			case 'imgs':
			       			html_v='<img src="/upload/form/imgs/'+json_data['value']+'" />';
			       			break;
			       			case 'map':
			       			html_v='<iframe frameborder="0" src="/include/core/get_point.php?point='+json_data['value']+'&location_aotu=yes" scrolling="auto" marginwidth="0" marginheight="0" vspace="0" hspace="0" allowtransparency="true" style="width: 100%; height: 400px;"></iframe>';
			       			break;
			       			default:
			       			html_v=json_data['value'];
			       			break
			       		}
			       		html+='<div class="label label-warning">'+json_data['name']+'</div>';
			       		html+='<div class="content-sub-section">'+html_v+'</div>';
		       		}
				}
					$('.section-content-ajax').html(html);
					var select_html_=create_vive_select(data_id,j);/*创建一个选择下拉*/
					$("#show_button_tr").html(select_html_);
					var ops=$("#show_button_tr").find("select").find("option");
					ops.attr("selected",false);
					ops.eq(examined_n).attr("selected",true);
					if(vive_remark_span != ''){
						vive_remark_span='<span class="span_shortcut">备注:'+vive_remark_span+'</span>';
						$("#vive_remark_div").html(vive_remark_span);
					}else{
						$("#vive_remark_div").html('<span>无备注</span>');
					}
			});
		}

    $(document).ready(function(){
		//index.php?cloud=form.data_show_detail&table_id=39&id=307
		

	
		$("#<?php echo $module['module_name'];?> .export").click(function(){
			if($("#<?php echo $module['module_name'];?> #export_div").css('display')=='none'){
				$("#<?php echo $module['module_name'];?> #export_div").css('display','block');
			}else{
				$("#<?php echo $module['module_name'];?> #export_div").css('display','none');
			}
			return false;	
		});
		$("#<?php echo $module['module_name'];?> #export_submit").click(function(){
			field_str='';
			$("#<?php echo $module['module_name'];?> #export_div input").each(function(index, element) {
                if($(this).prop('checked')){field_str+=$(this).attr('id').replace(/export_/,'')+'|';}
            });
			if(field_str==''){alert('<?php echo self::$language['is_null']?>');return false;}
			$("#<?php echo $module['module_name'];?> #export_form #field").val(field_str);
			
			$("#<?php echo $module['module_name'];?> #export_submit").next().submit();
			return false;	
		});
		
		if(get_param('publish')!=''){$("#publish").val(get_param('publish'))}
		$("#<?php echo $module['module_name'];?> .publish").each(function(index, element) {
            if($(this).val()==1){$(this).prop('checked',true);}
        });
		$(".load_js_span").each(function(index, element) {
            $(this).load($(this).attr('src'));
        });
    });
	
	function close_parent(e){
		$(e).parent().parent().parent().hide()
		
	}
    function cloud_table_filter(id){
		if($("#"+id).prop("value")!=-1){
			key=id.replace("_filter","");
			url=window.location.href;
			url=replace_get(url,key,$("#"+id).prop("value"));
			if(key!="search"){url=replace_get(url,"search","");}else{
				url='./index.php?cloud=form.data_admin&search='+$("#search_filter").val()+'&order='+get_param('order')+'&table_id='+get_param('table_id');
			}
			url=replace_get(url,"current_page","1");
			//cloud_alert(url);
			window.location.href=url;	
		}                                                                                                                                                                                                                                
		return false;
    }

    function update(id){
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
		publish=($("#publish_"+id).prop('checked'))?1:0;
        var obj={
            publish:publish,
            sequence:$("#sequence_"+id).val(),
            id:id,
            examined:$('#tr_'+id).find("#examined").get(0).selectedIndex,
            assessor:$('#assessor_'+id).val()
        }
        return;
        $.get('<?php echo $module['action_url'];?>&act=update',obj, function(data){
			//alert(data);
            try{v=eval("("+data+")");}catch(exception){alert(data);}
            $("#state_"+id).html(v.info);
        });
        return false;
    }

    function del(id){
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id}, function(data){
				alert(data);
                try{v=eval("("+data+")");}catch(exception){
                    alert(data);
                }
                $("#state_"+id).html(v.info);
                if(v.state=='success'){
                $("#tr_"+id+" td").animate({opacity:0},"slow",function(){$("#tr_"+id).css('display','none');});
                }
            });
        }
        return false;
    }

    function subimt_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        ids=ids.split('|');
        var obj=new Object();
        for(id in ids){
            if(ids[id]!=''){
            obj[id]=new Object();
            obj[id]['id']=ids[id];
            obj[id]['publish']=($("#publish_"+ids[id]).prop('checked'))?1:0
            obj[id]['sequence']=$("#sequence_"+ids[id]).prop('value');
            $("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');	
            }	
        }
        
        $.post("<?php echo $module['action_url'];?>&act=submit_select",obj,function(data){
            //alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			

                $("#state_select").html(v.info);
                //cloud_alert(ids);
                success=v.ids.split("|");
                for(id in ids){
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['executed'];?>");	
                    }	
                }
        });	
        
         return false;
        
        	
    }
    function del_select(){
        ids=get_ids();
        if(ids==''){$("#state_select").html("<?php echo self::$language['select_null']?>");return false;}
		$("#state_select").html('');
        if(confirm("<?php echo self::$language['delete_confirm']?>")){
        idss=ids;
        ids=ids.split("|");	
        for(id in ids){
            if(ids[id]!=''){$("#state_"+ids[id]).html('<span class=\'fa fa-spinner fa-spin\'></span>');}	
        }
            $.get('<?php echo $module['action_url'];?>&act=del_select',{ids:idss}, function(data){
            alert(data);
			try{v=eval("("+data+")");}catch(exception){alert(data);}
			
                $("#state_select").html(v.info);
                if(v.state=='success'){
                //cloud_alert(ids);	
                success=v.ids.split("|");
                for(id in ids){
                    //cloud_alert(ids[id]);
                    if(in_array(ids[id],success)){
                        $("#state_"+ids[id]).html("<span class=success><?php echo self::$language['success'];?></span>");	
                        $("#tr_"+ids[id]).css('display','none');
                    }else{
                        $("#state_"+ids[id]).html("<?php echo self::$language['fail'];?>");	
                    }	
                }
                }
            });
        }	
         return false;	
    }
    

    //审核函数
    function changeExamined(e) {
        var id=$(e).attr('data-id');
        if(confirm('是否将该用户修改为：“ '+$("#examined-"+id+" option:selected").text()+"”")){
            var phone=$(e).parent().parent().find('.phone').html();
            if(phone == ''){
                alert('用户手机号不完整');
                return;
            }
            var weixin=$(e).attr('weixin');
            if(weixin == ''){
                alert('审核员资料不完整，无法操作. “请在个人资料中填写微信号”。');
                return;
            }
            if(id = 4){
                
            }
            var obj={
                id:id,
                examined:$(e).val(),
                phone:phone,
                weixin:weixin,
                name:$(e).parent().parent().find('.name').html()
            };
            var examined_state=$(e).val();
            $.post("<?php echo $module['action_url'];?>&act=change_examined",obj,function(data){
                if(data != 'fail'){
                    //更换颜色
                    $(e).removeClass('_data_select_style_'+$(e).attr('selectedata'));
                    $(e).addClass('_data_select_style_'+examined_state);
                    //更换状态码
                    $(e).attr({selectedata:examined_state});
                    if(data == 0){
                        $('#shadow_text b').html('未审核成功');
                        $('#shadow_text span').html('该用户需要重新审核！');
                        $('#shadow_text').show();
                        $('#shadow_text').animate({
                           top: '55%', opacity: 'hide'
                         }, 1500);
                         return;
                    }
                    if(data == 1){
                        $('#shadow_text b').html('初审成功');
                        $('#shadow_text span').html('已经向用户发送复审短信！');
                        $('#shadow_text').show();
                        $('#shadow_text').animate({
                           top: '55%', opacity: 'hide'
                         }, 1500);
                         return;
                    }
                    if(data == 2){
                        $('#shadow_text b').html('该用户被通过');
                        $('#shadow_text span').html('已经向用户发送通过短信！');
                        $('#shadow_text').show();
                        $('#shadow_text').animate({
                           top: '55%', opacity: 'hide'
                         }, 1500);
                         return;
                    }
                    if(data == 3){
                        $('#shadow_text b').html('用户被禁止');
                        $('#shadow_text span').html('此用户不再享受贷款服务');
                        $('#shadow_text').show();
                        $('#shadow_text').animate({
                           top: '55%', opacity: 'hide'
                         }, 1500);
                         return;
                    }
                }else{
                    alert('修改不成功,请刷新再试');
                }
                
            }); 

        }else{
            //还原选中
            $(e).val($(e).attr('selectedata'));
            //alert(<?php echo $module['action_url'];?>);
        }
    }
	

	$('[id_data_admin="select"]').change(function(e){
		
		
	})
	
	
	
	
	function id_data_admin_select(e){
			/*表维护时修改*/
		$('.show_input_content').html($(e).val());
		$('.show_input_text').show();
		var obj={
			table_id:vive_table_id
		}
		get_data_id=parseInt($(e).attr("data-id"));
		$.get("<?php echo $module['action_url'];?>&act=msg_money",obj,function(data){
			$("#sms_money").html(data);
		})
		var l=$(e).offset().left;
		var t=$(e).offset().top+$(e).height();
		var weixin=$(e).parent().parent().parent().attr('data-weixin');
		var sms='0';
		var phone=$(e).parent().parent().parent().attr('data-phone');
		var examined=$(e).get(0).selectedIndex;
		
		/**/
		$('.show_input_sms p').last().html("加载中...");

		obj['examined'] = examined;
		obj['weixin'] = weixin;
		$.get("<?php echo $module['action_url'];?>&act=getsmscontent",obj,function(data){
			//console.log(data);
			if(data != ''){
				$('.show_input_sms p').last().html(data);
			}
		})
		$('.show_input_sms p').last().html("加载中..."+$(e).val()+"，添加审核员微信号："+weixin+" 为您办理,搜索并关注公众号：[百仟贷]");
		$('.show_input_sms p').find('input').val(phone);
		if( parseInt($(e).find("option:selected").attr("data-sms")) == 1){ //有短信
			$('#is_sms').attr("checked", true);
			$('.show_input_text .show_input_sms').show();
			$('.show_input_sms p').eq(1).show();
			$('.show_input_sms p').eq(2).show();
			sms='1';
		}else{
			$('#is_sms').attr("checked", false);
			$('.show_input_sms p').eq(1).hide();
			$('.show_input_sms p').eq(2).hide();
		}
		
		if($(e).offset().top-300 > $('body').scrollTop())
		{
			t=$(e).offset().top-$('.show_input_text').height();
			if(t<0){
				t=0;
			}
		}
		
		$('.show_input_text').css({
			position:'absolute',
			left:l,
			top:t
		})
		$('.show_input_text').show();
		
		$('.show_input_submit a').attr({
			'data-weixin':weixin,
			'data-state':$(e).val(),
			'data-phone':phone,
			'data-sms':sms,
			'data-examined':examined
		})
	}
	
	function submit_join_input(e){
		var e=$(e);
		var state_txt=e.attr('data-state_txt');
		var table_name=vive_table_name;
		var weixin=e.attr('data-weixin');
        var weixincode=e.attr('data-weixincode');
		var state=e.attr('data-state');
		var id=get_data_id;
		var phone=e.attr('data-phone');
		if(e.parent().parent().find('input').prop('checked')){
			var sms='1';
		}else{
			var sms='0';
		}
		
		var examined=e.attr('data-examined');
			
		var obj={
			state_txt:state_txt,
			table_name:table_name,
			weixin:weixin,
			state:state,
			id:id,
			phone:phone,
			sms:sms,
			examined:examined
		}
		if(state_txt ==''){
			alert('请先选择或输入维护理由!');
			return false;
		}
		//if(weixin ==''){
		//	alert('请先在用户中心设置微信号');
		//	return false;
		//}
		if(state ==''){
			alert('请设置状态');
			return false;
		}
		if(parseInt(sms) == 1 && parseInt(sms_money) < 1){
			alert('你的表的短信余额已经不足,请先联系表管理员充值.或者取消短信发送');
			return false;
		}
		$.post('<?php echo $module['action_url'];?>&act=change_examined',obj, function(data){
				$("#tr_"+id).find(".state_txt").html(state_txt);/*更新列表状态*/
				$("#tr_"+id).find("#vive_remark_div").html('<span class="span_shortcut">备注:'+state_txt+'</span>');/*更新VIVE状态*/
				$('.show_input_text').hide();
				$('#success_state').html(data);
				$('#success_state').show();
				$('#success_state').animate({
					'opacity':'hide'
				},3000)
        });
	}
	function close_show_input(e){
		$(e).parent().parent().hide();
	}
	//$('.admin_changetable select').parent().click(function(){
	//	$('.show_input_text').hide();
	//})
	function show_sms_p(e){
		var e=$(e);
		if(e.parent().parent().find('input').prop('checked')){
			$('.show_input_sms p').eq(1).show();
			$('.show_input_sms p').eq(2).show();
		}else{
			$('.show_input_sms p').eq(1).hide();
			$('.show_input_sms p').eq(2).hide();
		}
	}
	function change_assessor(e){
		var e=$(e);
		var id=e.attr('id').split('_')[1];
		var value=e.val();
		var table=e.attr('id').split('_')[0];
		var table_name=e.attr('data-table_name');
		var table_id=e.attr('data-table_id');
		var obj={
			id:id,
			value:value,
			table:table,
			table_name:table_name,
			table_id:table_id
		}
		if(confirm("确认修改审核员?")){
			$.post('<?php echo $module['action_url'];?>&act=change_assessor',obj, function(data){
				
				$('#success_state').html(data);
				$('#success_state').show();
				$('#success_state').animate({
					'opacity':'hide'
				},800)
			});
		}
	}
function show_img(e){
    //$("#shelter").show();
    $('.show_img').find('img').eq(1).attr({
        'src':$(e).attr('src')
    });
    $('.show_img').show();


    $('.show_img').find('img').eq(1).ready(function(){
        $('.show_img').find('img').eq(0).hide();
          $('.show_img').find('img').eq(1).show();
          showImgHW();
    })
}

function showImgHW(){
var t=($(window).height()/2)-($('.show_img').height()/2);
if(parseInt(t)<0){
	t=0;
}
  $('.show_img').css({
        top:t,
        left:($(window).width()/2)-($('.show_img').width()/2)
    })
}
function close_show_img(e){
    $('.show_img').find('img').eq(1).hide();
    $('.show_img').find('img').eq(0).show();
    $(e).parent().hide();
    //$('#shelter').hide();
}
function defined_sublime(e){
	$(e).hide();
	$(".span_shortcut").removeClass("active");
	$("#defined_shortcut").show();
}
function defined_inpu(e){
	$("#show_a_submit").attr({
		"data-state_txt":$(e).val()
	})
}
function set_span_shortcut(e){
	$(".span_shortcut").removeClass("active");
	$(e).addClass("active");
	$("#defined_shortcut").val("");
	$("#defined_shortcut").hide();
	$(".defined_sublime").show();
	$("#show_a_submit").attr({
		"data-state_txt":$(e).html()
	})
}
</script>