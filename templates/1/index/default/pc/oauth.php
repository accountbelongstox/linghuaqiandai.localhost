<style type="text/css">
    <?php 
require("./include/return_data/css/form_data_admin.php");
 ?>
</style>
<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<script src="/plugin/datePicker/index.php"></script>
    <script>
    $(document).ready(function(){


    });	
	
	</script>
    
    
    
    
<style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px; }
	#online_div a{  margin:30px; display:inline-block; }
	#online_div img{border:none;display:block;}
</style>
<?php
require("./include/return_data/css/edit_user.php");
?>
    
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html">

        <div class="portlet-title" style="padding-bottom:20px;">
        	<div class="caption" ><?php echo $module['cloud_table_name']?></div>
   	    </div>
        
		<div id=online_div><?php echo $module['online']?></div>
    
    
    </div>
</div>

