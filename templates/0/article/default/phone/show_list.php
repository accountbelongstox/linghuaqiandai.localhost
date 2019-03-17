<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if('<?php echo $module['title'];?>'==''){$("#<?php echo $module['module_name'];?> .module_title").css('display','none');}
	$("#<?php echo $module['module_name'];?>  .list a").each(function(index, element) {
        if($(this).children(".img").html().length==0){
			$(this).children(".img").css('display','none');
			$(this).children(".text").css('width','95%');
		}else{
			$(this).children(".img").css('width',$(this).width()-$(this).children('.text').width()-30);
			$(this).children(".img").children('img').css('height',$(this).height()-10).css('width',$(this).height()-10).css('display','block');	
			$(this).children(".img").css('width',$(this).children(".img").children('img').width());
			$(this).children(".text").css('width',$(this).width()-$(this).children(".img").children('img').width()-30);
		}
    });
	
	
	
	if('<?php echo $module['scroll'];?>'!='no'){
	  $("#<?php echo $module['module_name'];?> .list").rollGallery({
		  direction:"top",
		  speed:2000,
		  rollNum:1,
		  childrenSel:'a',
	  });
		if('<?php echo $module['scroll'];?>'=='left'){
			
		}else{
			$("#<?php echo $module['module_name'];?> .module_title").css('display','none');
		}
	}

});
</script>

<style>


<?php require("./include/return_data/css/list_css.php");?>

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin" >
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list id="toplist"><?php echo $module['list'];?></div>
</div>
</div>