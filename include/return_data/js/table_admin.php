<script type="text/javascript">
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> .write_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .read_state").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .default_publish").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .authcode").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .sms_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
        });
		$("#<?php echo $module['module_name'];?> .email_inform").each(function(index, element) {
           if($(this).val()==1){$(this).prop('checked',true);}
       });
		if(get_param('id')!=''){$("[cloud-table] .filter").css('display','none');}
    });
    function update(id){
		function table_join_detail(){
			var txt="";
			var n=0;
			var a=$("#table_join_admin_"+id).find('.jion_span_a');
			var b=$("#table_join_admin_"+id).find('.jion_span_c');
			var sms=$("#table_join_admin_"+id).find('.is_sms_select input');
			a.each(function(e1,e2){
				txt+="|"+$(e2).html()+":"+b.eq(n).html();
				if(sms.eq(n).is(':checked')){
					txt+='&sms';
				}
				n++;
			});
			return txt;
		};
		var remark=$("#remark_"+id).val();
        var j_name=$("#name_"+id);
        var j_description=$("#description_"+id);
		if(j_description.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_description.focus(); return false;}
		if(j_name.val()==''){$("#state_"+id).html('<span class=fail><?php echo self::$language['please_input'];?></span>');j_name.focus();return false;}			
		if(!is_passwd(j_name.val())){
			$("#state_"+id).html('<span class=fail><?php echo self::$language['table_name'];?><?php echo self::$language['only_letters_numbers_underscores'];?></span>');j_name.focus(); return false;
		}
        var authorization=$("#authorization_"+id).val();
		var write_state=($("#write_state_"+id).prop('checked'))?1:0;
		var read_state=($("#read_state_"+id).prop('checked'))?1:0;
		var default_publish=($("#default_publish_"+id).prop('checked'))?1:0;
		var authcode=($("#authcode_"+id).prop('checked'))?1:0;
		var sms_inform=($("#sms_inform_"+id).prop('checked'))?1:0;
		var email_inform=($("#email_inform_"+id).prop('checked'))?1:0;
        var publish_condition=$("#publish_condition_"+id).val();
		var table_join=$("#table_join_"+id).val();
		var table_join_detail=table_join_detail();
        $("#state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
        $.get('<?php echo $module['action_url'];?>&act=update',{
			description:j_description.val(),
			name: j_name.val(),
			inform_user: $("#inform_user_"+id).val(),
			write_state:write_state,
			read_state:read_state,
			default_publish:default_publish,
			authcode:authcode,
			sms_inform:sms_inform,
            publish_condition:publish_condition,
			email_inform:email_inform,
			id:id,
            authorization:authorization,
			table_join:table_join,
			table_join_detail:table_join_detail,
			remark:remark

			}, function(data){
			//alert(data);
            try{
				v=eval("("+data+")");
			}catch(exception){
				alert(data);
				}
			
            $("#state_"+id).html(v.info);
			if(v.info.indexOf('success') != -1){
				//window.location.reload();
			}
        });
        return false;	
        
    }

	function change_table(id,UPtype){
		if(UPtype != "__folder__"){
			var description=$("#description_"+id).val();
			var creater=$("#creater_"+id).val();
			var remark=$("#remark_"+id).val();
			if(confirm("确定修改该表?")){
				$.get('<?php echo $module['action_url'];?>&act=change_table',{
					id:id,
					description:description,
					creater:creater,
					remark:remark
				},function(data){
					if(parseInt(data) == 1){
						alert("修改成功")
						return ;
					}
					alert(data);
				})
				$("#shelter").hide();
				$(".admin_show_col_div").hide();
			}
		}else{
			/*修改文件夹*/
		}
	}
	function onchange_table_join(a){
		var a=$(a);
		var table_id=a.attr('id').split('join_')[1];
		$.get('<?php echo $module['action_url'];?>&act=getTable_joins',{
			table_id:table_id,
			name:a.val()
			}, function(data){
				var arr=data.split('|select_option:')[1].split('|select_default_value')[0].split('/');
				var join_lab_select=a.parent().next().find('.join_lab_select').html();
				var html="";
				for(var i=0;i<arr.length;i++){
					html+='<div class="table_join_p"><div class="join_lib_le">';
					html+='<span class="jion_span_a">'+arr[i]+'</span> ';
					html+='<span style="color: #222;" class="jion_span_b">绑定表</span></div>';
					html+='<div class="join_lib_ri">';
					html+='<div onclick="join_child_select(this);" class="jion_span_c">是否关联表</div><div class="clear_join" onclick="clear_join(this);"></div>';
					html+='<div class="is_sms_select">短信 <input type="checkbox" value="" class="input_checkbox">';
					html+='</div>';
					html+='<div class="join_lab_select">'+join_lab_select+'<div class="clear"></div></div>';
					html+='<div class="clear"></div></div>';
					html+='<div class="clear"></div></div>';
				}
				$("#table_join_detail_"+table_id).html(html);
				console.log(html); 
			
		})
	}
	
	function clear_join(e){
		$(e).prev().html("------");
	}
    function del(id,e){
        if(confirm("是否确定删除?不可恢复!")){
        	var type=$(e).attr("data-type");
			$("#<?php echo $module['module_name'];?> #state_"+id).html('<span class=\'fa fa-spinner fa-spin\'></span>');
            $.get('<?php echo $module['action_url'];?>&act=del',{id:id,type:type}, function(data){
            	alert(data);
            	if(data == "删除成功"){
            		$("#folder_"+id).remove();
            		$("#shelter").hide();
            	}
            	
            });
        }
        return false;	
        
    } 

 

    function join_child_select(e){
		var e=$(e);
		var table_id=e.attr('data-table-id');
		e.parent().find('.join_lab_select').show();//下一个显示
		
		e.parent().find('.join_lab_select li').removeClass('icon-check');
		e.parent().find('.join_lab_select li').each(function(a,b){
			if($(b).html() == e.html()){
				$(b).addClass('icon-check');
			}
		});
    }
	
	function joinUlTxtSelect(e){
		var e=$(e);
		e.parent().parent().hide();
		e.parent().parent().parent().find('.jion_span_c').html(e.html());
		
	}
	
	
	
	//如果是显示模式
var showtable_id_b=true;
if(window.location.search.indexOf('showtable_id') != -1 && showtable_id_b){
    showtable_id_b=false;
    window.location.search=window.location.search.split('showtable_id').join('');
    $('.table_scroll table').find('tbody').eq(0).find('tr').eq(0).find('.btn_feedback').eq(0).trigger("click");
}

$('.am-icon-edit').click(function(){
    $(this).parent().parent().find('.select_admin_add_table_input').show();
    $(this).parent().hide();
})

//设置查询条件
$('.default_publish').change(function(){
    var e=$(this).parent().find('.table_edit_select');
    if($(this).is(':checked')){
        e.show();
    }else{
        e.hide();
    }
});

$('.copy_table_span').hover(function(){
    $(this).parent().attr({href:'javascript:;'});
},function(){
    $(this).parent().attr({href:$(this).parent().attr('data-href')});
})

$('.copy_table_span').click(function(){
    $('#categories_col').show();
    
})
$('.copy_table_select').change(function(){
    if($(this).val()!='default'){
        $('.categories .copy_table_2').css({
            display:'inline-block'
        });
    }
})
$('.copy_submit').click(function(){
	var v=$("#copy_table_name").val();
	var sv=$('.copy_table_select').val();
	if(v == ''){
		alert("请先输入新的表名!");
		return false;
	}
	if(sv == 'default'){
		alert("请先选择您要复制的表!");
		return false;
	}
	
    $.get($(this).attr('data-activeUrl')+'&act=copy_table',{
        newtablename_description:v,
        table_id:$('.copy_table_select').find("option:selected").attr('data-id')
    }, function(data){
        if(data == 'success'){
            alert('复制成功');
           	//window.location.reload();
        }else{
            alert('复制失败');

        }
    })
})
/*添加文件夹*/
$('.add_table_folder').click(function(){
	var l=$(this).offset().left;
	$(".tooltipster-fade").show();
})

$(".icon-boxes.clearfix.form-color-2 li").click(function(){
	$(".icon-boxes.clearfix.form-color-2 li").removeClass("active");
	$(this).addClass("active");
})
$(".color-boxes.clearfix li").click(function(){
	$(".color-boxes.clearfix li").removeClass("active");
	$(this).addClass("active");
})
$('.css_close').click(function(){
	var n=$(this).attr("data-n");
	n=parseInt(n);
	n=n-1;
	var e=$(this).parent();
	for (var i=0;i<n;i++) {
		e=$(e).parent();
	}
	e.hide();
})
    //自动计数
$(function() {
	$('.transactions').each(function(a,b){
		var c=$(b).attr("data-barColor") ? $(b).attr("data-barColor") : "#ef1e25";
	    $(b).easyPieChart({
	        easing: 'easeOutBounce',
	        size: 50,
	        //lineCap: 'butt',//butt  square
	        barColor:c,
	        onStep: function(from, to, percent) {
	            $(this.el).find('.percent').text(Math.round(percent));
	        }
	    });
	    //console.log($(b).attr("data-barColor"));
	})
});
$(".progress-bar.progress-bar-success").width(function(){
	var full=$(this).attr("data-full");
	var count=$(this).attr("data-count");
	
	return (100/(full/count))+"%";
})
//自动做表
$(".display").find(".number").find("span").each(function(a,b){
    var n=parseInt($(b).attr("data-value"));
    var t=0;
    var t_=parseInt(n/30);
    var set__=setInterval(function(){
        t+=t_;
        if(t>=n){
            t=n;
            clearInterval(set__);
        }
        $(b).html(t);
    },30)
});
/*
$(".dashboard-stat2").mousemove(function(){
	$(this).find(".actions").show();
})
$(".dashboard-stat2").mouseout(function(){
	$(this).find(".actions").hide();
})
*/
$('.admin_show_colDiv').click(function(){
	$("#shelter").show();
	$(this).find(".admin_show_col_div").show();
})


function create_folder(ele){
	var e=$("#setting_details_folder");
	var description=e.find(".form-folder-name").val();
	var backgroundcolor=e.find("ul.color-boxes.clearfix").find("li.active").attr("data-index");
	var backgroundimage=e.find("ul.icon-boxes.clearfix").find("li.active").attr("data-value");
	if(description == ''){
		description="未命名文件夹";
	}
	var obj={
		description:description,
		backgroundcolor:backgroundcolor,
		backgroundimage:backgroundimage
	}
    $.get('<?php echo $module['action_url'];?>&act=create_folder',obj,function(data){
    	window.location.reload();
    });
    $("#setting_details_folder").parent().parent().hide();
}
function select_show(){
	var e=null;
	$(".table_scroll .row").children("div").each(function(a,b){
		if(e == null){
			e=$(b);
		}
		if($(b).find('.pinned-img').hasClass("gd-show")){
			e=$(b);
		}
	});
	return e;
}
function sequence(id,e){
	var obj={
		table_id:id,
	}
	var img_ele=$("#folder_"+id).find('.pinned-img');
    $("#shelter").hide();
	$(".admin_show_col_div").hide();
	if(img_ele.hasClass("gd-show")){
		//取消置顶
		$("#folder_"+id).insertAfter(select_show());
		console.log(select_show());
		obj["val"]="0";
		$(e).find("span").html("置顶");
		img_ele.addClass("gd-hide");
		img_ele.removeClass("gd-show");
	}else{
		//置顶
		$("#folder_"+id).insertBefore($(".table_scroll .row").find("div").eq(0));
		obj["val"]="1";
		$(e).find("span").html("取消置顶");
		img_ele.addClass("gd-show");
		img_ele.removeClass("gd-hide");
	}
    $.get('<?php echo $module['action_url'];?>&act=sequence',obj,function(data){
    	console.log(data);
    }) 
}

function index_show(id,e){
	var obj={
		table_id:id,
	}

	if($(e).html() == '取消推荐'){
		//取消置顶
		$(e).html("首页推荐");
		obj["val"]="2";
	}else{
		//置顶
		$(e).html("取消推荐");
		obj["val"]="1";
	}
    $.get('<?php echo $module['action_url'];?>&act=index_show',obj,function(data){
    	console.log(data);
		$(".admin_show_col_div").hide();
    	$("#shelter").hide();
    }) 
}

function move(id,e){
	var html='<div class="move_new_folder"><a href="javascript:;" style="color:#1E90FF;" onclick="unmove(this);">返回</a>';
	if($('.re_html_head').length > 0){
		html+='<a href="javascript:;" class="btn btn-minor fll" onclick="move_folder(0,'+id+',this)"><i class="fa-folder folder_i"> </i> <span>桌面</span></a>';
		html+="</div>";
		$(e).parent().parent().find(".move_new_folder").html('');
		$(html).insertAfter($(e).parent());
	    $(e).parent().parent().find(".admin_col_panel").hide();
	}else{
	    $.get('<?php echo $module['action_url'];?>&act=get_folder',function(data){
	    	if(data !=""){
	    		data=data.split("null").join('""');
	    		var j=$.parseJSON(data);
	    		$(j).each(function(a,b){
	    			html+='<a href="javascript:;" class="btn btn-minor fll" data-parent="'+b["parent"]+'" onclick="move_folder('+b["id"]+','+id+',this)"><i class="fa-folder folder_i"> </i> <span>'+b["description"]+'</span></a>';
	    		})
	    		html+="</div>";
	    		$(e).parent().parent().find(".move_new_folder").html('');
	    		$(html).insertAfter($(e).parent());
	    		$(e).parent().parent().find(".admin_col_panel").hide();
	    	}
    	})	
	}
}
function move_folder(table_id,folder_id,e){
	/*将表单移入文件夹*/
	var obj={
		"folder_id":folder_id,
		"table_id":table_id
	}
    $.get('<?php echo $module['action_url'];?>&act=move_folder',obj,function(data){
    });
    $("#folder_"+folder_id).remove();
    $("#success_info").show();
    $("#success_info").animate({
    	'opacity':'hide'
    },1200);
    var ele=$("#folder_"+table_id).find(".form-data .count");
    ele.html(parseInt(ele.html())+1);
}
function unmove(e){
	$(e).parent().parent().find(".move_new_folder").hide("");
    $(e).parent().parent().find(".admin_col_panel").show();
}
</script>