<div id=<?php echo $module['module_name'];?>  cloud-module="<?php echo $module['module_name'];?>" align=left  style="display:inline-block;width:<?php echo $module['width']?>;height:<?php echo $module['height']?>;display:inline-block;vertical-align:top; ">
<script>
$(document).ready(function(){
	if('<?php echo $module['title_visible'];?>'==1){$("#<?php echo $module['module_name'];?> .module_title").css('display','block');}

});
</script>
	<style>
	/*css返由PHP返回*/
	<?php require("./include/return_data/css/list_css.php");?>
    </style>
    <div id="<?php echo $module['module_name'];?>_<?php echo $module['id']?>_html">
    <div class=module_title><?php echo $module['title'];?></div>
     <?php echo $module['content']?>
    </div>

</div>