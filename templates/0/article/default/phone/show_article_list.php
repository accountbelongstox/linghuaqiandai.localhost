<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left style="width:100%;" >
<script>
$(document).ready(function(){
	$("#<?php echo $module['module_name'];?>  .list a").each(function(index, element) {
        if($(this).children(".img").html().length==0){
			$(this).children(".img").css('display','none');
			$(this).children(".text").css('width','98%');
		}else{
			$(this).children(".img").css('width',$(this).width()-$(this).children('.text').width()-30);
			$(this).children(".img").children('img').css('height',$(this).height()-10).css('width',$(this).height()-10).css('display','block');	
			$(this).children(".img").css('width',$(this).children(".img").children('img').width());
			$(this).children(".text").css('width',$(this).width()-$(this).children(".img").children('img').width()-10);
		}
    });
});

function reset_a(){
	$("#<?php echo $module['module_name'];?> .list a img").each(function(index, element) {
        $(this).parent().css('width',$(this).width());
    });	
}
</script>

<style>

<?php require("./include/return_data/css/list_css.php");?>

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=list ><?php echo $module['list'];?></div>
    <?php echo $module['page']?>
</div>
</div>