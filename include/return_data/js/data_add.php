<script type="text/javascript">
    /*如果页面小于750,则要请求服务器得到图的高度*/
    getRatioSize($(window).width());
    function getRatioSize(max_width){
        var img_src=$('.form_title_div.form_title_background').attr("data-background-image");
        if(!img_src){
            return false;
        }
        var height=$('.form_title_div.form_title_background').css("max-height");
        height=parseInt(height);
        console.log(height)
        var width=750;
        if(max_width < 750 ){
            var ratiow = (width/100);
            var rn= max_width/ratiow;
            var ratioh = (height/100)*rn;
            height = parseInt(ratioh);
        }
        height=height-5;
        $('.form_title_div.form_title_background').height(height);
        return height;
    }
    $(document).ready(function(){
		$(window).resize(function(){
            getRatioSize($(window).width());
        })
		$("#<?php echo $module['module_name'];?> select").each(function(index, element) {
            if($(this).attr('cloud_value')){$(this).val($(this).attr('cloud_value'));}
        });
		$("#<?php echo $module['module_name'];?> cloud_radio").each(function(index, element) {
            if($(this).attr('cloud_value')){
				$("#"+$(this).attr('id')+' input[value="'+$(this).attr('cloud_value')+'"]').prop('checked',true);	
			}
        });
		$("#<?php echo $module['module_name'];?> cloud_checkbox").each(function(index, element) {
            if($(this).attr('cloud_value')){
				temp=$(this).attr('cloud_value').split('/');
				for(v in temp){
					$("#"+$(this).attr('id')+' input[value="'+temp[v]+'"]').prop('checked',true);	
				}
			}
        });
		$("cloud_radio input").click(function(){
			$(this).parent('cloud_radio').val($(this).val());	
			
		});
		$("cloud_checkbox input").click(function(){
			id=$(this).parent('cloud_checkbox').attr('id');
			v='';
			$("#"+id+" input").each(function(index, element) {
                if($(this).prop('checked')){v+=$(this).val()+'/';}
            });
			$("#"+id).val(v);
		});
		$("#<?php echo $module['module_name'];?>_html input").keydown(function(event){
			if(event.keyCode==13 && event.target.tagName!='TEXTAREA'){return exe_cloud_form_submit();}		  	
		});
		$("#<?php echo $module['module_name'];?> #submit").click(function(){
			exe_cloud_form_submit();
			return false;
		});
		
        $("input[type='radio']").css('border','none');
        $("input[type='checkbox']").css('border','none');
		
		
		$("#close_button").click(function(){
			//alert(getCookieValue_Map('Map_AddName'));
			//alert(getCookieValue_Map('Map_localX'));
			//alert(getCookieValue_Map('Map_localY'));
			$("#fade_div").css('display','none');
			$("#set_cloud_iframe_div").css('display','none');
			var t=$("#cloud_iframe").attr('src');
			t=t.split('id=');
			t=t[1].split('&');
			t=t[0];
			var temp=getCookieValue_Map('Map_localY');
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookieValue_Map('Map_localX')+','+getCookieValue_Map('Map_localY'));
				$("#<?php echo $module['module_name'];?> #"+t+'_state').html(getCookieValue_Map('Map_AddName'));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[cloud_type='map']").focus(function(){
			set_iframe_position(($(window).width()/100)*90,($(window).height()/100)*60);
			//cloud_alert(replace_file);
			$("#cloud_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_cloud_iframe_div").css('display','block');
			$("#cloud_iframe").attr('src','./include/core/get_point.php?location_aotu=yes&id='+$(this).attr('id'));
			$('#close_button').html('确认位置');
			return false;	
		});
});
    
//得到cookie
function getCookieValue_Map(cookieName){  
    var cookieValue = document.cookie;  
    var cookieStartAt = cookieValue.indexOf(""+cookieName+"=");  
    if(cookieStartAt==-1)  
    {  
        cookieStartAt = cookieValue.indexOf(cookieName+"=");  
    }  
    if(cookieStartAt==-1)  
    {  
        cookieValue = null;  
    }  
    else  
    {  
        cookieStartAt = cookieValue.indexOf("=",cookieStartAt)+1;  
        cookieEndAt = cookieValue.indexOf(";",cookieStartAt);  
        if(cookieEndAt==-1)  
        {  
            cookieEndAt = cookieValue.length;  
        }  
        cookieValue = unescape(cookieValue.substring(cookieStartAt,cookieEndAt));//解码latin-1  
    }  
    return cookieValue;  
}  


	function exe_cloud_form_submit(){
			err=false;
			try{if(editor){editor.sync();}}catch(e){}
			
			$("#<?php echo $module['module_name'];?> span").each(function(index, element) {
                if($(this).html()=='<?php echo self::$language['is_null'];?>' || $(this).html()=='<?php echo self::$language['not_match'];?>' || $(this).html()=='<?php echo self::$language['exist_same'];?>'){$(this).html('');}
            });
			$("#<?php echo $module['module_name'];?> span[class='state']").each(function(index, element) {
               $(this).html('');
            });
			var obj=new Object();
			$(".cloud_input").each(function(index, element){
				if($(this).prop('value')==undefined){$(this).prop('value','');}
				if($(this).prop('value')=='' && $(this).attr('cloud_required')==='1'){
						$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?></span>');
						var alert_html=$("#"+$(this).attr('id')+'_state').parent().parent().children(":first").html().split('/span>')[1]+'必须填写';
						alert(alert_html);
						$(this).focus();
						err=true;
						return false;
					}
				var check_reg_value = $(this).attr('check_reg');
				if(check_reg_value !='' && $(this).attr('cloud_required') === '1' ){
					temp=$(this).attr('check_reg');
　　				if($(this).prop('value').match(eval(temp))==null){
					$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?></span>');
					var alert_html=$("#"+$(this).attr('id')+'_state').parent().parent().children(":first").html().split('/span>')[1]+'填写错误';
					alert(alert_html);
					$(this).focus();
					err=true;
					return false;}
				}else{
					$(this).attr('check_reg','');
				}
               obj[$(this).attr('id')]=$(this).prop('value');
			   //alert($(this).attr('id'));
            });
			if(err){return false;}
			//return false;
			
			$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');

		    if(getCookieValue_Map('Map_AddName')){
		        obj['address']=getCookieValue_Map('Map_AddName');
		    }
		        obj['examined']=0;
		        obj['overdue']=0;
		        
			$.post("<?php echo $module['action_url'];?>&act=add",obj,function(data){
				$("#<?php echo $module['module_name'];?> #submit").next('span').html('');
				//alert(data);
				try{v=eval("("+data+")");}catch(exception){alert(data);}
				
				if(v.state=='fail'){
					if(v.id){
						$("#"+v.id).focus();
						$("#"+v.id+'_state').html(v.info);	
					}else{
						$("#<?php echo $module['module_name'];?> #submit").next('span').html(v.info);
					}
				}else{
					$("#<?php echo $module['module_name'];?>_html").css('text-align','center');
					$("#<?php echo $module['module_name'];?>_html").html(v.info);
				}
	
			});	
	}
   

	function next_add_submit(e){
		var e=$(e);
		var page=$('#'+e.attr('data-page'));
		var divs=page.find('div');
		if(check_low_input_value('#'+e.attr('data-page'))){
			e.attr({
				'data-page':'add_page_'+(parseInt(e.attr('data-page').split('page_')[1])+1)
			});
			var nex_pag=$('#'+e.attr('data-page'));
			if(nex_pag.length > 0){
				page.hide();
				$("#prev_add_divselect").css({
					"width":"27%"
				});
				$("#prev_add_divselect").show();
				e.parent().css({
					"width":"68%"
				});
				nex_pag.show();
			}
			//判断最后还有没有元素
			var next_pag2=$('#'+'add_page_'+(parseInt(e.attr('data-page').split('page_')[1])+1));
			if(next_pag2.length < 1){
				/*显示提交按钮*/
				e.parent().hide();
				e.hide();
				$("#submit").parent().css({
					"width":"68%"
				});
				$('.add_submit_div').show();
			}
		}else{

		}
	}
	function prev_add_submit(e){
		$('.add_submit_div').hide();
		$('#next_add_submit_sel').show();
		$('#next_add_submit_sel').parent().show();
		var a=$("#next_add_submit_sel").attr("data-page");
		var pag=$('#'+a);
		a=a.split('page_')[1];
		a=parseInt(a);
		a=a-1;
		a='add_page_'+a;
		$("#next_add_submit_sel").attr({
			"data-page":a
		})
		var prev_page=$('#'+a);
		pag.hide();
		if( a == 'add_page_1'){
			$("#next_add_submit_sel").parent().css({
				"width":"100%"
			});
			$(e).parent().hide();
		}
		prev_page.show();
		
	}

	function check_low_input_value(ele_){
			err=false;
			try{if(editor){editor.sync();}}catch(e){}
			if(!ele_){
				var ele_='#<?php echo $module['module_name'];?>';
			}
			$(ele_+" span").each(function(index, element) {
                if($(this).html()=='<?php echo self::$language['is_null'];?>' || $(this).html()=='<?php echo self::$language['not_match'];?>' || $(this).html()=='<?php echo self::$language['exist_same'];?>'){$(this).html('');}
            });
			$(ele_+" span[class='state']").each(function(index, element) {
               $(this).html('');
            });
			var obj=new Object();
			$(ele_+" .cloud_input").each(function(index, element){
				if($(this).prop('value')==undefined){$(this).prop('value','');}
				if($(this).prop('value')=='' && $(this).attr('cloud_required')==='1'){
						$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?></span>');
						var alert_html=$("#"+$(this).attr('id')+'_state').parent().parent().children(":first").html().split('/span>')[1]+'必须填写';
						alert(alert_html);
						$(this).focus();
						err=true;
						return false;
					}
				var check_reg_value = $(this).attr('check_reg');
				if(check_reg_value !='' && $(this).attr('cloud_required') === '1'){
					temp=$(this).attr('check_reg');
　　				if($(this).prop('value').match(eval(temp))==null){
					$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?></span>');
					var alert_html=$("#"+$(this).attr('id')+'_state').parent().parent().children(":first").html().split('/span>')[1]+'填写错误';
					alert(alert_html);
					$(this).focus();
					err=true;
					return false;}
				}else{
					$(this).attr('check_reg','');
				}
               obj[$(this).attr('id')]=$(this).prop('value');
			   //alert($(this).attr('id'));
            });
			if(err){return false;}
			return true;
	}
$('.f_share_main').find(".qrcode").mouseover(function(){
	$(this).parent().animate({
		"width":116
	})
	return false;
})
$('.f_share_main').find(".qrcode").mouseout(function(){
	$(this).parent().animate({
		"width":30
	})
	return false;
})
$('.f_share_main .f_share').click(function(){
	$("#shelter").show();
	$('#code_box').show();
	var h=$("#weixinshare .tcontent").height();
	$("#weixinshare").height(h);
	var wH=$(window).height();
	var wW=$(window).width();
	var codeH=$('#code_box').height();
	var codeW=$('#code_box').width();
	$('#code_box').css({
		top:(wH-codeH)/2,
		left:(wW-codeW)/2
	})
})
$(window).mousedown(function(){
	if($('#code_box').is(':visible')){
		$('#code_box').hide();
		$("#shelter").hide();
	}
})
</script>