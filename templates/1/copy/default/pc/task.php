<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <script>
    $(document).ready(function(){
		$("#<?php echo $module['module_name'];?> #show_result").html('<span class=\'fa fa-spinner fa-spin\'></span>');
		//
        $.get('<?php echo $module['action_url'];?>',function(data){
			//
			$("#<?php echo $module['module_name'];?> #show_result").html(data);
		});
    });
    
	function dalay_reload(){
		window.location.reload();	
	}    
    
    </script>
	<style>
    #<?php echo $module['module_name'];?>{}
	#<?php echo $module['module_name'];?> .match_line{ line-height:30px; margin-top:20px;}
	#<?php echo $module['module_name'];?> .m_label{ display:inline-block;  width:20%; overflow:hidden; text-align:right; padding-right:10px;}
	#<?php echo $module['module_name'];?> .m_label .s{}
	#<?php echo $module['module_name'];?> .m_label .m{}
	#<?php echo $module['module_name'];?> .m_label .e{}
	#<?php echo $module['module_name'];?> .input_div{ vertical-align:top; display:inline-block; width:75%; overflow: hidden; }
/*表单DIYMODULE设计CSS 载入 2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html">
    	<div id=show_result>
        </div>
    </div>
</div>
