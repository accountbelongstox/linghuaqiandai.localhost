<div id=<?php echo $module['module_name'];?> save_name="<?php echo $module['module_save_name'];?>"  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script>
$(document).ready(function(){
	if('<?php echo $module['title'];?>'==''){$("#<?php echo $module['module_name'];?> .module_title").css('display','none');}
	if('<?php echo $module['scroll'];?>'!='no'){
		$("#<?php echo $module['module_name'];?> .list").imgscroll({
			speed: 20,    //图片滚动速度
			amount: 0,    //图片滚动过渡时间
			width: 3,     //图片滚动步数
			dir: "<?php echo $module['scroll'];?>"   // "left" 或 "up" 向左或向上滚动
		});

		if('<?php echo $module['scroll'];?>'=='left'){
			$('body').attr('onload','reset_a()');
		}else{
			$("#<?php echo $module['module_name'];?> .module_title").css('display','none');
		}
	}
	function reset_a(){
		$("#<?php echo $module['module_name'];?> .list a img").each(function(index, element) {
			$(this).parent().css('width',$(this).width());
			$(this).css('margin',0);
		});	
	}
});

</script>

<style>
<?php require("./include/return_data/css/list_css.php");?>

</style>

	
<div id="<?php echo $module['module_name'];?>_html" class="module_div_bottom_margin">
	<div class=module_title><?php echo $module['title'];?></div>
	<div class=list ><?php echo $module['list'];?></div>
</div>
</div>