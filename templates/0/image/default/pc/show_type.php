<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if($("#<?php echo $module['module_name'];?>").parent('div').width()<500){$("#<?php echo $module['module_name'];?>").css('display','block');}
	
	$("#<?php echo $module['module_name'];?> #image_type_"+get_param('type')).attr('class','current_type');
	$("#<?php echo $module['module_name'];?> .type a span").each(function(index, element) {
        if($("#"+$(this).parent().attr('id')+"_div").html().length==0){
			$(this).css('display','none');
		}else{
			if($("#"+$(this).parent().attr('id')+"_div").css('display')=='block'){
				$(this).attr('class','hide_sub');
			}else{
				$(this).attr('class','show_sub');
			}
		}
    });
	
	cloud=get_param('m');
	if(cloud=='image.show_thumb' && get_param('type')!=''){
		$("#<?php echo $module['module_name'];?> #image_type_"+get_param('type')).parent().css('display','block');	
		$("#<?php echo $module['module_name'];?> #image_type_"+get_param('type')).parent().parent().css('display','block');	
	}
	
	$("#<?php echo $module['module_name'];?> .type a span").click(function(){
		if($(this).parent().next('div').css('display')=='none'){
			$(this).parent().next('div').css('display','block');
			$(this).attr('class','hide_sub');	
		}else{
			$(this).parent().next('div').css('display','none');
			$(this).attr('class','show_sub');
		}
		return false;	
	});
});
</script>
    

<style>
/*css加载*/
<?php require('./include/return_data/css/list_css.php');?>
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=type><?php echo $module['list'];?></div>
</div>
</div>