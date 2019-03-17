<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
	<script>
    $(document).ready(function(){
            
    });
    </script>
    

<style>
    
</style>

<?php 
require("./include/return_data/css/weixin_css.php");
?>
<div id="<?php echo $module['module_name'];?>_html">
    
      <?php echo $module['list']?>
    </div>
</div>