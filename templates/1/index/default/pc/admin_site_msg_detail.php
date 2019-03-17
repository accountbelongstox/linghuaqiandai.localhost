<div id=<?php echo $module['module_name'];?>  class="portlet light <?php echo $module['module_name'];?>" cloud-module="<?php echo $module['module_name'];?>" align=left >
    
<style>
    #<?php echo $module['module_name'];?>_html{ padding-top:10px;}
    #<?php echo $module['module_name'];?>_html .m_label3{ display: inline-block;width:80px;}
/*表单DIYMODULE设计CSS 载入 2*/
<?php require("./include/return_data/css/form_data_admin.php");?>
</style>
<div id="<?php echo $module['module_name'];?>_html">
    <div id="show_count" style="display:none;"></div>
      <span class=m_label><?php echo self::$language['sender']?>: </span><?php echo $module['sender']?><br/><br/>
      <span class=m_label><?php echo self::$language['addressee']?>: </span><?php echo $module['addressee']?><br/><br/>
      <span class=m_label><?php echo self::$language['time']?>: </span><?php echo $module['time']?><br/><br/>
      <span class=m_label><?php echo self::$language['title']?>: </span><?php echo $module['title']?>
      <hr/>
      <?php echo $module['content']?>
    </div>
</div>