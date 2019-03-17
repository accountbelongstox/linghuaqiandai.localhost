<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
<?php require("./include/return_data/js/diymodule_admin.php");?>
<style>
    #<?php echo $module['module_name'];?>_table .type{width:100px;}
    #<?php echo $module['module_name'];?>_table .title{width:280px;}
    #<?php echo $module['module_name'];?>_table .width{width:50px;}
    #<?php echo $module['module_name'];?>_table .height{width:50px;}
    #<?php echo $module['module_name'];?>_table .editor{width:100px;}
    #<?php echo $module['module_name'];?>_table .time{ font-size:12px; width:120px;}
    #<?php echo $module['module_name'];?>_table .sequence{width:40px;}
    /*表单DIYMODULE设计CSS 载入 2*/
    <?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html" class="<?php echo $module['module_name'];?>_html" cloud-table="1" class="<?php echo $module['module_name'];?>_html">
    <div class="portlet-title" style="padding-bottom: 20px;margin-bottom: 20px;">
        <div class="caption"><?php echo $module['cloud_table_name']?></div>
    </div>
    <div class=table_scroll >
        <div class="top"><a style="color:#fff;" data-tablesnumber="0" onclick="create_html(this,$(this).attr('data-n'));" data-type="all" data-n="0" class="btn" href="javascript:;" ><i class="fa fa-check-circle"></i>生成全部HTML<i class="fa fa-angle-down"></i></a></div>
        <div class="center_content" style="padding: 20px 0 0 10px;"></div>
    </div>
    </div>
</div>
