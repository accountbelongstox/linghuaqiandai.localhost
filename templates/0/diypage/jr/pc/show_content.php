<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
     if($('#<?php echo $module['module_name'];?> .title').html()==''){$("#<?php echo $module['module_name'];?> .title").css('display','none');}   
     if($('#<?php echo $module['module_name'];?> .content').html()==''){$("#<?php echo $module['module_name'];?> .content").css('display','none');}   
});
</script>
    

<style>
	/*css返由PHP返回*/
	<?php require("./include/return_data/css/list_css.php");?>
</style>


<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=title><?php echo $module['title'];?></div>
	<div class=content><?php echo $module['content'];?></div>
</div>
</div>