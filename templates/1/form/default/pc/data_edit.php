
	<style>
	#<?php echo $module['module_name'];?> .input_span .cloud_input input{ height:13px;}
    #<?php echo $module['module_name'];?> .m_label{ }
	#<?php echo $module['module_name'];?> .m_label .required{ }
    #<?php echo $module['module_name'];?> div{ line-height:50px;}
    #<?php echo $module['module_name'];?> .m_label{ display:inline-block; width:150px; text-align:right; overflow:hidden; padding-right:10px;}
    #<?php echo $module['module_name'];?> .input_span{ display:inline-block; width:850px; overflow:hidden;}
    #<?php echo $module['module_name'];?> legend{ }
    #<?php echo $module['module_name'];?> .img_thumb{ max-height:150px;}

    
    /*表单设计CSS载入*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
    
    <script>
    $(document).ready(function(){
		$("#index_user_position a[href='index.php?cloud=form.data_admin']").attr('href','index.php?cloud=form.data_admin&table_id=<?php echo $_GET['table_id'];?>');
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
		
		$("#<?php echo $module['module_name'];?> .del_imgs").click(function(){
			$(this).prev('a').animate({opacity:0},"slow",function(){$(this).css('display','none');});
			$(this).css('display','none');
			//$(this).next('br').css('display','none');
			v=$("#<?php echo $module['module_name'];?> #"+$(this).attr('input_name')).attr('old_value');
			v=v.replace('|'+$(this).attr('file'),'');
			$("#<?php echo $module['module_name'];?> #"+$(this).attr('input_name')).attr('old_value',v);
			return false;
		});
		
		$("#<?php echo $module['module_name'];?> .del_files").click(function(){
			$(this).prev('a').animate({opacity:0},"slow",function(){$(this).css('display','none');});
			$(this).css('display','none');
			//$(this).next('br').css('display','none');
			v=$("#<?php echo $module['module_name'];?> #"+$(this).attr('input_name')).attr('old_value');
			v=v.replace('|'+$(this).attr('file'),'');
			$("#<?php echo $module['module_name'];?> #"+$(this).attr('input_name')).attr('old_value',v);
			return false;
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
			$("#fade_div").css('display','none');
			$("#set_cloud_iframe_div").css('display','none');
			t=$("#cloud_iframe").attr('src');
			t=t.split('?id=');
			t=t[1].split('&');
			t=t[0];
			temp=getCookie('map_'+t);
			if(temp){
				$("#<?php echo $module['module_name'];?> #"+t).val(getCookie('map_'+t).replace(/%2C/g,','));
			}
			return false;
		});
		$("#<?php echo $module['module_name'];?> input[cloud_type='map']").focus(function(){
			set_iframe_position(800,500);
			//cloud_alert(replace_file);
			$("#cloud_iframe").attr('scrolling','auto');
			$("#fade_div").css('display','block');
			$("#set_cloud_iframe_div").css('display','block');
			$("#cloud_iframe").attr('src','/include/core/get_point.php?id='+$(this).attr('id')+'&point='+$(this).val());
			return false;	
		});
		
		
    });
    
function exe_cloud_form_submit(){
			err=false;
			
			try{if(editor){editor.sync();}}catch(e){}
			$("#<?php echo $module['module_name'];?> span").each(function(index, element) {
                if($(this).html()=='<?php echo self::$language['is_null'];?>' || $(this).html()=='<?php echo self::$language['not_match'];?>' || $(this).html()=='<?php echo self::$language['exist_same'];?>'){
					$(this).html('');
				}
            });
			$("#<?php echo $module['module_name'];?> span[class='state']").each(function(index, element) {
               $(this).html('');
            }); 
			var obj=new Object();
			$(".cloud_input").each(function(index, element){
				if($(this).prop('value')==undefined){$(this).prop('value','');}
				
				if($(this).prop('value')=='' && $(this).attr('cloud_value')=='' && $(this).attr('old_value')=='' && $(this).attr('cloud_required')==='1'){
					$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['is_null'];?>1</span>');
					$(this).focus();err=true;return false;
				}
				
				var check_reg_value = $(this).attr('check_reg');
				if(check_reg_value !='' && $(this).attr('cloud_required') === '1' ){
					temp=$(this).attr('check_reg');
　　				if($(this).prop('value').match(eval(temp))==null){
						$("#"+$(this).attr('id')+'_state').html('<span class=fail><?php echo self::$language['not_match'];?>2</span>');
						$(this).focus();
						err=true;
						return false;
					}
				}else{
					$(this).attr('check_reg','');
				}
				
               obj[$(this).attr('id')]=$(this).attr('value');
			   if(obj[$(this).attr('id')] == undefined){
				   obj[$(this).attr('id')]=$(this).attr('cloud_value');
			   }
			   if($(this).attr('old_value')!=undefined){
					obj[$(this).attr('id')+'_old_value']=$(this).attr('old_value'); 
					obj[$(this).attr('id')]=$(this).attr('old_value'); 
			   }
            });
			if(err){
				return false;
			}
			console.log(obj);
			$("#<?php echo $module['module_name'];?> #submit").next('span').html('<span class=\'fa fa-spinner fa-spin\'></span>');
			$.post("<?php echo $module['action_url'];?>&act=update",obj,function(data){
				$("#<?php echo $module['module_name'];?> #submit").next('span').html('');
				//alert(data);
				try{
					v=eval("("+data+")");
				}catch(exception){
					alert(data);
				}
				
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
				window.location.reload();
	
			});	
			
}        
    </script>
    <script src="/plugin/datePicker/index.php"></script>

<div id="<?php echo $module['module_name'];?>_html">
    <?php echo $module['fields'];?>
	<div><span class=m_label> </span><span class=input_span><a href="#" id=submit class="submit"><?php echo self::$language['submit'];?></a> <span></span></span></div>    
    </div>
</div>
