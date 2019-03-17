<?php require("./include/return_data/css/data_show_list.php");?>
<div id=<?php echo $module['module_name'];?>  class="portlet light" cloud-module="<?php echo $module['module_name'];?>" align=left >
    <div id="<?php echo $module['module_name'];?>_html"  cloud-table=1>
    <?php echo $module['search'];?>
    <div class="result"></div>
    </div>
</div>
<?php require("./include/return_data/js/data_show_list.php");?>
