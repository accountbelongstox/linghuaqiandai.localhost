<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left  style="width:100%;" save_name="<?php echo $module['module_save_name'];?>" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>_html div").each(function(index, element) {
        if($(this).html().length==0){$(this).css('display','none');}
    });
	$.get("<?php echo $module['count_url']?>");
        
    });
</script>  
<style>
	/*css返由PHP返回*/
	<?php require("./include/return_data/css/list_css.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
<div id="show_count" style="display:none;"></div>
<div class=title><?php echo $module['title']?></div>
<div class=tag><?php echo $module['tag']?></div>
<div class=img><?php echo $module['img']?></div>
<div class=content><?php echo $module['content']?></div>
</div>
</div>